<?php

use App\Enums\EnquiryStatus;
use App\Models\ActivityLog;
use App\Models\ClientEnquiry;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    $this->artisan('db:seed');
    $this->superadmin = User::role('superadmin')->first();

    // Create regular staff user with and without contact permissions
    $this->unauthorizedUser = User::factory()->create();
});

test('authorized user can render enquiry index and show views', function () {
    // 1. Index view
    $indexResponse = $this->actingAs($this->superadmin)->get('/dashboard/enquiries');
    $indexResponse->assertStatus(200);
    $indexResponse->assertSee('Client Enquiries');

    // 2. Show view
    $enquiry = ClientEnquiry::first();
    $showResponse = $this->actingAs($this->superadmin)->get("/dashboard/enquiries/{$enquiry->id}");
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Enquiry Information');
    $showResponse->assertSee($enquiry->name);
    $showResponse->assertSee($enquiry->email);
});

test('unauthorized user without contact-list permission cannot access enquiries', function () {
    $this->actingAs($this->unauthorizedUser)
        ->get('/dashboard/enquiries')
        ->assertStatus(403);

    $enquiry = ClientEnquiry::first();
    $this->actingAs($this->unauthorizedUser)
        ->get("/dashboard/enquiries/{$enquiry->id}")
        ->assertStatus(403);
});

test('enquiries index datatables ajax endpoint returns formatted columns', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/enquiries?draw=1&start=0&length=10');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'subject',
                    'status_badge',
                    'action-btn',
                ]
            ]
        ]);
});

test('enquiries index can be filtered by status', function () {
    $response = $this->actingAs($this->superadmin)
        ->getJson('/dashboard/enquiries?draw=1&status=contacted&start=0&length=10');

    $response->assertStatus(200);
    $data = $response->json('data');

    foreach ($data as $row) {
        expect($row['status'])->toBe(EnquiryStatus::CONTACTED->value);
    }
});

test('viewing a new enquiry automatically marks it as read and logs activity', function () {
    $newEnquiry = ClientEnquiry::create([
        'name' => 'Alice Morgan',
        'email' => 'alice.morgan@techcorp.com',
        'phone' => '+8801700112233',
        'company' => 'TechCorp Global',
        'subject' => 'Data Center Construction Query',
        'message' => 'We are looking for EPC contractors for a Tier 3 data center.',
        'status' => EnquiryStatus::NEW,
        'submitted_at' => now(),
    ]);

    $this->actingAs($this->superadmin)
        ->get("/dashboard/enquiries/{$newEnquiry->id}")
        ->assertStatus(200);

    expect($newEnquiry->fresh()->status)->toBe(EnquiryStatus::READ);

    // Verify activity log
    $log = ActivityLog::where('module', 'enquiry')
        ->where('action', 'status_change')
        ->where('subject_id', $newEnquiry->id)
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('marked as read');
});

test('authorized user can update enquiry status and internal notes via form', function () {
    $enquiry = ClientEnquiry::first();

    $response = $this->actingAs($this->superadmin)
        ->put("/dashboard/enquiries/{$enquiry->id}", [
            'status' => 'contacted',
            'internal_notes' => 'Discussed initial project brief with the client via phone call.',
        ]);

    $response->assertRedirect(route('enquiries.show', $enquiry->id));
    $response->assertSessionHas('success');

    $enquiry->refresh();
    expect($enquiry->status)->toBe(EnquiryStatus::CONTACTED);
    expect($enquiry->internal_notes)->toBe('Discussed initial project brief with the client via phone call.');

    // Verify activity log
    $log = ActivityLog::where('module', 'enquiry')
        ->where('action', 'update')
        ->where('subject_id', $enquiry->id)
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Updated enquiry status/notes');
});

test('authorized user can update enquiry status via fast ajax endpoint', function () {
    $enquiry = ClientEnquiry::first();

    $response = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/enquiries/{$enquiry->id}/status", [
            'status' => 'closed',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'status' => 'closed',
        ]);

    expect($enquiry->fresh()->status)->toBe(EnquiryStatus::CLOSED);

    // Verify activity log
    $log = ActivityLog::where('module', 'enquiry')
        ->where('action', 'status_change')
        ->where('subject_id', $enquiry->id)
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Changed enquiry status');
});

test('status update rejects invalid status values', function () {
    $enquiry = ClientEnquiry::first();

    $response = $this->actingAs($this->superadmin)
        ->postJson("/dashboard/enquiries/{$enquiry->id}/status", [
            'status' => 'invalid_status_value',
        ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['status']);
});

test('unauthorized user cannot update status or notes', function () {
    $enquiry = ClientEnquiry::first();

    $this->actingAs($this->unauthorizedUser)
        ->put("/dashboard/enquiries/{$enquiry->id}", [
            'status' => 'closed',
            'internal_notes' => 'Attempted unauthorized note edit.',
        ])
        ->assertStatus(403);

    $this->actingAs($this->unauthorizedUser)
        ->postJson("/dashboard/enquiries/{$enquiry->id}/status", [
            'status' => 'closed',
        ])
        ->assertStatus(403);
});

test('authorized user with contact-delete can delete an enquiry and log activity', function () {
    $enquiry = ClientEnquiry::create([
        'name' => 'Spam Bot',
        'email' => 'spambot@randomdomain.test',
        'phone' => '+1234567890',
        'subject' => 'Spam solicitation message',
        'message' => 'Buy our services today.',
        'status' => EnquiryStatus::NEW,
    ]);

    $response = $this->actingAs($this->superadmin)
        ->delete("/dashboard/enquiries/{$enquiry->id}");

    $response->assertRedirect(route('enquiries.index'));
    $response->assertSessionHas('success');

    expect(ClientEnquiry::find($enquiry->id))->toBeNull();

    // Verify activity log
    $log = ActivityLog::where('module', 'enquiry')
        ->where('action', 'delete')
        ->latest('id')
        ->first();

    expect($log)->not->toBeNull();
    expect($log->description)->toContain('Deleted enquiry from "Spam Bot"');
});

test('unauthorized user cannot delete enquiry', function () {
    $enquiry = ClientEnquiry::first();

    $this->actingAs($this->unauthorizedUser)
        ->delete("/dashboard/enquiries/{$enquiry->id}")
        ->assertStatus(403);

    expect(ClientEnquiry::find($enquiry->id))->not->toBeNull();
});
