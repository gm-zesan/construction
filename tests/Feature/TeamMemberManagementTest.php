<?php

use App\Models\TeamMember;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    // Seed permissions
    $this->seed(\Database\Seeders\PermissionTableSeeder::class);
    $this->seed(\Database\Seeders\CreateAdminUserSeeder::class);

    $this->admin = User::where('email', 'admin@gmail.com')->first();
});

it('allows authorized admin to view team members index page', function () {
    $response = $this->actingAs($this->admin)->get(route('team-members.index'));
    $response->assertStatus(200);
    $response->assertSee('Team Members &amp; Leadership', false);
});

it('allows authorized admin to create a new team member', function () {
    $response = $this->actingAs($this->admin)->post(route('team-members.store'), [
        'name' => 'Michael Chang',
        'designation' => 'Lead Geotechnical Specialist',
        'department' => 'Geotechnical & Foundations',
        'bio' => 'Over 15 years overseeing deep bored piling and diaphragm wall stabilization.',
        'email' => 'michael.chang@agency.com',
        'phone' => '+1 555 789 0123',
        'linkedin_url' => 'https://linkedin.com/in/michaelchang',
        'sort_order' => 10,
        'is_active' => 1,
        'is_featured' => 1,
    ]);

    $response->assertRedirect(route('team-members.index'));
    $this->assertDatabaseHas('team_members', [
        'name' => 'Michael Chang',
        'designation' => 'Lead Geotechnical Specialist',
        'department' => 'Geotechnical & Foundations',
        'is_active' => true,
        'is_featured' => true,
    ]);
});

it('allows authorized admin to edit and update a team member', function () {
    $member = TeamMember::create([
        'name' => 'Emma Watson',
        'designation' => 'Senior Site Architect',
        'department' => 'Architecture',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)->put(route('team-members.update', $member->id), [
        'name' => 'Emma Watson Updated',
        'designation' => 'Principal BIM Architect',
        'department' => 'Digital Architecture',
        'sort_order' => 2,
        'is_active' => 1,
        'is_featured' => 1,
    ]);

    $response->assertRedirect(route('team-members.index'));
    $this->assertDatabaseHas('team_members', [
        'id' => $member->id,
        'name' => 'Emma Watson Updated',
        'designation' => 'Principal BIM Architect',
    ]);
});

it('allows authorized admin to toggle active and featured status via ajax', function () {
    $member = TeamMember::create([
        'name' => 'Robert Thorne',
        'designation' => 'Trade Superintendent',
        'is_active' => true,
        'is_featured' => false,
    ]);

    $response = $this->actingAs($this->admin)->post(route('team-members.toggle-status', $member->id), [
        'type' => 'status',
    ]);

    $response->assertJson(['success' => true, 'is_active' => false]);
    expect($member->fresh()->is_active)->toBeFalse();

    $responseFeatured = $this->actingAs($this->admin)->post(route('team-members.toggle-status', $member->id), [
        'type' => 'featured',
    ]);

    $responseFeatured->assertJson(['success' => true, 'is_featured' => true]);
    expect($member->fresh()->is_featured)->toBeTrue();
});

it('allows authorized admin to delete a team member', function () {
    $member = TeamMember::create([
        'name' => 'Temporary Worker',
        'designation' => 'Site Inspector',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)->delete(route('team-members.destroy', $member->id));
    $response->assertJson(['success' => true]);
    $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
});

it('renders dynamic team members on the about us page', function () {
    $this->seed(\Database\Seeders\TeamMemberSeeder::class);

    $response = $this->get('/about');
    $response->assertStatus(200);

    // Verify seeded team members are visible on the page
    $response->assertSee('Harry Son');
    $response->assertSee('Design Vision');
    $response->assertSee('John Doe');
    $response->assertSee('Concept Development');
    $response->assertSee('Stive Smith');
    $response->assertSee('Project Manager');
});
