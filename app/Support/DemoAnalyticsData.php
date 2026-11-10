<?php

namespace App\Support;

use App\Models\Builder;
use App\Models\ProjectDetail;
use Illuminate\Support\Facades\Schema;

class DemoAnalyticsData
{
    /**
     * @return array<string, mixed>
     */
    public static function overview(): array
    {
        $cities = [
            ['label' => 'Bengaluru', 'value' => 86],
            ['label' => 'Mumbai', 'value' => 72],
            ['label' => 'Hyderabad', 'value' => 58],
            ['label' => 'Delhi', 'value' => 49],
            ['label' => 'Pune', 'value' => 41],
            ['label' => 'Chennai', 'value' => 33],
            ['label' => 'Kochi', 'value' => 24],
        ];

        if (Schema::hasTable('builders')) {
            $liveCities = Builder::query()
                ->selectRaw('city, COUNT(*) as total')
                ->whereNotNull('city')
                ->groupBy('city')
                ->orderByDesc('total')
                ->limit(7)
                ->get();

            if ($liveCities->isNotEmpty()) {
                $cities = $liveCities->map(fn ($row) => [
                    'label' => (string) $row->city,
                    'value' => (int) $row->total,
                ])->all();
            }
        }

        $planMix = [
            ['label' => 'Starter', 'value' => 28, 'color' => '#93c5fd'],
            ['label' => 'Professional', 'value' => 42, 'color' => '#3b82f6'],
            ['label' => 'Developer Premium', 'value' => 22, 'color' => '#818cf8'],
            ['label' => 'Enterprise', 'value' => 8, 'color' => '#10b981'],
        ];

        if (Schema::hasTable('builders')) {
            $plans = Builder::query()
                ->selectRaw('subscription, COUNT(*) as total')
                ->groupBy('subscription')
                ->pluck('total', 'subscription');

            if ($plans->isNotEmpty()) {
                $planMix = collect([
                    'Starter' => '#93c5fd',
                    'Professional' => '#3b82f6',
                    'Developer Premium' => '#818cf8',
                    'Enterprise' => '#10b981',
                ])->map(fn ($color, $label) => [
                    'label' => $label,
                    'value' => (int) ($plans[$label] ?? 0),
                    'color' => $color,
                ])->values()->all();
            }
        }

        $pipeline = [
            ['label' => 'Lead Received', 'value' => 480],
            ['label' => 'Contacted', 'value' => 362],
            ['label' => 'Meeting Scheduled', 'value' => 248],
            ['label' => 'KYC Submitted', 'value' => 186],
            ['label' => 'Project Added', 'value' => 142],
            ['label' => 'Subscription Purchased', 'value' => 98],
            ['label' => 'Live on CMNHousing', 'value' => 84],
        ];

        if (Schema::connection('housing')->hasTable('project_details')) {
            $liveProjects = ProjectDetail::query()->where('status', 'published')->count();
            $pending = ProjectDetail::query()->where('status', 'under_review')->count();
            $pipeline[4]['value'] = max($pipeline[4]['value'], ProjectDetail::query()->count());
            $pipeline[6]['value'] = max($liveProjects, 1);
            $pipeline[3]['value'] = max($pending * 4, $pipeline[3]['value']);
        }

        return [
            'revenueGrowth' => [
                'labels' => ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                'values' => [128, 142, 151, 163, 174, 186],
            ],
            'buildersByCity' => $cities,
            'planMix' => $planMix,
            'pipeline' => $pipeline,
        ];
    }
}
