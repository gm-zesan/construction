<?php

namespace Database\Seeders;

use App\Enums\EnquiryStatus;
use App\Models\ClientEnquiry;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ClientEnquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commercialService = Service::where('slug', 'commercial-construction-contracting')->first();
        $steelService = Service::where('slug', 'structural-steel-heavy-framing')->first();
        $designService = Service::where('slug', 'architectural-design-space-planning')->first();

        $vertexProject = Project::where('slug', 'vertex-corporate-tower')->first();
        $highlandProject = Project::where('slug', 'highland-logistics-industrial-distribution-hub')->first();

        $enquiries = [
            [
                'name' => 'Tariq Al-Mansoor',
                'email' => 'tariq.mansoor@horizonproperties.com',
                'phone' => '+8801812345678',
                'company' => 'Horizon Properties Group',
                'subject' => 'Request for Tender (RFT): 15-Story Mixed Commercial Center in Banani',
                'message' => 'We are preparing the tender package for our upcoming mixed-use commercial center in Banani. We reviewed your Vertex Corporate Tower showcase and would like to invite your team for an introductory pre-qualification briefing next Tuesday.',
                'service_id' => $commercialService?->id,
                'project_id' => $vertexProject?->id,
                'status' => EnquiryStatus::NEW,
                'internal_notes' => null,
                'submitted_at' => now()->subHours(2),
            ],
            [
                'name' => 'Farhana Kabir',
                'email' => 'fkabir@apexindustrial.com.bd',
                'phone' => '+8801719876543',
                'company' => 'Apex Industrial Logistics Ltd.',
                'subject' => 'Heavy Steel Fabrication Inquiry for 180,000 sq.ft Warehouse expansion',
                'message' => 'Our Gazipur facility requires a 180,000 sq.ft warehouse expansion with long-span steel trusses and heavy floor load capacities. Please share your typical lead time for structural steel fabrication and erection schedule.',
                'service_id' => $steelService?->id,
                'project_id' => $highlandProject?->id,
                'status' => EnquiryStatus::CONTACTED,
                'internal_notes' => 'Spoke with Lead Engineer Marcus on Sept 6. Shared preliminary steel tonnage calculator and company credentials. Follow-up meeting scheduled.',
                'submitted_at' => now()->subDays(2),
            ],
            [
                'name' => 'Kamran Hossain',
                'email' => 'k.hossain@delta-enterprises.net',
                'phone' => '+8801911223344',
                'company' => 'Delta Global Enterprises',
                'subject' => 'Architectural BIM Consultation & Feasibility Study',
                'message' => 'Seeking an architectural partner capable of BIM coordination and structural feasibility for a 4-acre tech campus masterplan in Ashulia.',
                'service_id' => $designService?->id,
                'project_id' => null,
                'status' => EnquiryStatus::READ,
                'internal_notes' => 'Reviewed by Sarah Jenkins. Forwarded project brief to design and estimating team for initial spatial appraisal.',
                'submitted_at' => now()->subDays(4),
            ],
            [
                'name' => 'Rafiqul Islam',
                'email' => 'rafiq.islam@urbannexus.org',
                'phone' => '+8801622334455',
                'company' => 'Urban Nexus Developments',
                'subject' => 'General Contractor Prequalification for Waterfront Plaza',
                'message' => 'We would like to request your audited company profile, financial capability letters, and recent project references for prequalification in the upcoming Waterfront Plaza bidding.',
                'service_id' => $commercialService?->id,
                'project_id' => null,
                'status' => EnquiryStatus::CLOSED,
                'internal_notes' => 'Prequalification documents sent via courier and email on Sept 2. Successfully qualified for vendor shortlist.',
                'submitted_at' => now()->subDays(6),
            ],
        ];

        foreach ($enquiries as $enquiryData) {
            ClientEnquiry::updateOrCreate(
                ['email' => $enquiryData['email'], 'subject' => $enquiryData['subject']],
                $enquiryData
            );
        }
    }
}
