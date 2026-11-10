<?php

namespace Database\Seeders;

use App\Models\Builder;
use App\Models\ProjectDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BuilderSeeder extends Seeder
{
    public function run(): void
    {
        $demo = [
            [
                'code' => 'B-1001',
                'owner_name' => 'Ravi Kumar',
                'company_name' => 'Skyline Developers',
                'city' => 'Bengaluru',
                'email' => 'ravi@skylinedev.test',
                'phone' => '+91 98765 10001',
                'gst' => '29ABCDE1234F1Z5',
                'rera' => 'PRM/KA/RERA/1251/446',
                'pan' => 'ABCDE1234F',
                'subscription' => 'Developer Premium',
                'status' => 'Active',
                'manager' => 'Anita Rao',
                'projects_count' => 12,
                'revenue_lakhs' => 42.5,
                'trust_score' => 97,
                'rating' => 4.8,
                'kyc_status' => 'Verified',
                'support_tickets' => 2,
                'featured' => true,
            ],
            [
                'code' => 'B-1002',
                'owner_name' => 'Meera Nair',
                'company_name' => 'Coastal Homes',
                'city' => 'Kochi',
                'email' => 'meera@coastal.test',
                'phone' => '+91 98765 10002',
                'subscription' => 'Professional',
                'status' => 'Active',
                'manager' => 'Karan Shah',
                'projects_count' => 6,
                'revenue_lakhs' => 18.2,
                'trust_score' => 88,
                'rating' => 4.5,
                'kyc_status' => 'Verified',
                'support_tickets' => 1,
            ],
            [
                'code' => 'B-1003',
                'owner_name' => 'Arjun Mehta',
                'company_name' => 'Metro Estate Group',
                'city' => 'Mumbai',
                'email' => 'arjun@metroestate.test',
                'phone' => '+91 98765 10003',
                'subscription' => 'Enterprise',
                'status' => 'Active',
                'manager' => 'Anita Rao',
                'projects_count' => 21,
                'revenue_lakhs' => 124.0,
                'trust_score' => 93,
                'rating' => 4.7,
                'kyc_status' => 'Verified',
                'support_tickets' => 0,
            ],
            [
                'code' => 'B-1004',
                'owner_name' => 'Sneha Iyer',
                'company_name' => 'Green Nest Builders',
                'city' => 'Mumbai',
                'email' => 'sneha@greennest.test',
                'phone' => '+91 98765 10004',
                'subscription' => 'Enterprise',
                'status' => 'Active',
                'manager' => 'Rohit Verma',
                'projects_count' => 4,
                'revenue_lakhs' => 3.6,
                'trust_score' => 84,
                'rating' => 4.3,
                'kyc_status' => 'Verified',
            ],
            [
                'code' => 'B-1005',
                'owner_name' => 'Vikram Patel',
                'company_name' => 'Palm Grove Developers',
                'city' => 'Ahmedabad',
                'email' => 'vikram@palmgrove.test',
                'phone' => '+91 98765 10005',
                'subscription' => 'Starter',
                'status' => 'Pending',
                'manager' => 'Anita Rao',
                'projects_count' => 2,
                'revenue_lakhs' => 1.1,
                'trust_score' => 71,
                'rating' => 4.0,
                'kyc_status' => 'Pending',
            ],
            [
                'code' => 'B-1006',
                'owner_name' => 'Neha Kapoor',
                'company_name' => 'Deshmukh Estates',
                'city' => 'Pune',
                'email' => 'neha@deshmukh.test',
                'phone' => '+91 98765 10006',
                'subscription' => 'Professional',
                'status' => 'Inactive',
                'manager' => 'Karan Shah',
                'projects_count' => 8,
                'revenue_lakhs' => 22.4,
                'trust_score' => 79,
                'rating' => 4.2,
                'kyc_status' => 'Verified',
            ],
            [
                'code' => 'B-1007',
                'owner_name' => 'Imran Sheikh',
                'company_name' => 'Sheikh Homes',
                'city' => 'Hyderabad',
                'email' => 'imran@sheikhhomes.test',
                'phone' => '+91 98765 10007',
                'subscription' => 'Starter',
                'status' => 'Suspended',
                'manager' => 'Rohit Verma',
                'projects_count' => 3,
                'revenue_lakhs' => 5.8,
                'trust_score' => 52,
                'rating' => 3.4,
                'kyc_status' => 'Rejected',
            ],
            [
                'code' => 'B-1008',
                'owner_name' => 'Priya Menon',
                'company_name' => 'Prestige Homes',
                'city' => 'Chennai',
                'email' => 'priya@prestige.test',
                'phone' => '+91 98765 10008',
                'subscription' => 'Developer Premium',
                'status' => 'Active',
                'manager' => 'Anita Rao',
                'projects_count' => 15,
                'revenue_lakhs' => 58.9,
                'trust_score' => 91,
                'rating' => 4.6,
                'kyc_status' => 'Verified',
            ],
        ];

        foreach ($demo as $row) {
            Builder::query()->updateOrCreate(['code' => $row['code']], $row);
        }

        if (! Schema::connection('housing')->hasTable('project_details')) {
            return;
        }

        $grouped = ProjectDetail::query()
            ->selectRaw('builder_name, location, COUNT(*) as projects_count')
            ->groupBy('builder_name', 'location')
            ->get();

        $index = 2000;
        foreach ($grouped as $row) {
            $company = (string) $row->builder_name;
            $existing = Builder::query()->where('company_name', $company)->first();
            if ($existing) {
                $existing->update([
                    'city' => $existing->city ?: $row->location,
                    'projects_count' => max((int) $existing->projects_count, (int) $row->projects_count),
                ]);

                continue;
            }

            Builder::query()->updateOrCreate(
                ['code' => 'B-'.$index],
                [
                    'owner_name' => $company,
                    'company_name' => $company,
                    'city' => $row->location,
                    'subscription' => 'Starter',
                    'status' => 'Active',
                    'manager' => 'Anita Rao',
                    'projects_count' => (int) $row->projects_count,
                    'revenue_lakhs' => max(1, (int) $row->projects_count * 3.5),
                    'trust_score' => 75,
                    'rating' => 4.1,
                    'kyc_status' => 'Pending',
                ],
            );
            $index++;
        }
    }
}
