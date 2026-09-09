<?php

namespace Tests\Feature;

use App\Enums\EnquiryStatus;
use App\Models\ActivityLog;
use App\Models\ClientEnquiry;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContactPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Cache::flush();
        $this->seed(\Database\Seeders\WebsiteContentSeeder::class);
    }

    public function test_contact_page_renders_successfully(): void
    {
        $service = Service::create([
            'title' => 'Civil Infrastructure',
            'slug' => 'civil-infrastructure',
            'short_description' => 'Civil infrastructure and heavy civil construction.',
            'description' => 'Comprehensive civil engineering services.',
            'is_published' => true,
        ]);

        $project = Project::factory()->create([
            'title' => 'Commercial Sky Tower',
            'is_published' => true,
        ]);

        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertSee("Let&#039;s Build Something Great Together", false);
        $response->assertSee('Send Us a Message', false);
        $response->assertSee('Civil Infrastructure');
        $response->assertSee('Commercial Sky Tower');
        $response->assertSee('Common Questions About Working With Us', false);
    }

    public function test_contact_form_requires_mandatory_fields(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertEquals(0, ClientEnquiry::count());
    }

    public function test_contact_form_validates_email_format(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'message' => 'This is a test message for project scoping and estimating.',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals(0, ClientEnquiry::count());
    }

    public function test_contact_form_submits_successfully_and_logs_activity(): void
    {
        $service = Service::create([
            'title' => 'Structural Concrete',
            'slug' => 'structural-concrete',
            'short_description' => 'Structural concrete and framing.',
            'description' => 'Expert concrete engineering.',
            'is_published' => true,
        ]);
        $project = Project::factory()->create(['is_published' => true]);

        $payload = [
            'name' => 'Alexander Vance',
            'email' => 'a.vance@constructcorp.com',
            'phone' => '+1 (555) 987-6543',
            'company' => 'ConstructCorp Global',
            'subject' => 'Phase 2 Foundation RFP',
            'service_id' => $service->id,
            'project_id' => $project->id,
            'message' => 'We are seeking general contracting and structural engineering bids for our upcoming 12-story commercial facility.',
        ];

        $response = $this->post(route('contact.store'), $payload);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('enquiry_submitted', true);

        $this->assertDatabaseHas('client_enquiries', [
            'name' => 'Alexander Vance',
            'email' => 'a.vance@constructcorp.com',
            'phone' => '+1 (555) 987-6543',
            'company' => 'ConstructCorp Global',
            'subject' => 'Phase 2 Foundation RFP',
            'service_id' => $service->id,
            'project_id' => $project->id,
            'status' => EnquiryStatus::NEW->value,
        ]);

        $enquiry = ClientEnquiry::first();
        $this->assertNotNull($enquiry->submitted_at);

        // Verify activity log was recorded
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'create',
            'module' => 'enquiry',
            'subject_id' => $enquiry->id,
        ]);
    }

    public function test_contact_form_supports_ajax_json_submission(): void
    {
        $payload = [
            'name' => 'Marcus Aurelius',
            'email' => 'marcus@romanarchitects.com',
            'message' => 'Inquiry regarding architectural restoration and deep piling works.',
        ];

        $response = $this->postJson(route('contact.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('client_enquiries', [
            'name' => 'Marcus Aurelius',
            'email' => 'marcus@romanarchitects.com',
        ]);
    }
}
