<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use App\Support\DemoDashboardData;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $demo = DemoDashboardData::overview();

        $projectCounts = [
            'live' => ProjectDetail::query()->where('status', 'published')->count(),
            'pending' => ProjectDetail::query()->where('status', 'under_review')->count(),
            'rejected' => ProjectDetail::query()->where('status', 'rejected')->count(),
            'draft' => ProjectDetail::query()->where('status', 'draft')->count(),
            'all' => ProjectDetail::query()->count(),
        ];

        return view('pages.dashboard', [
            ...$demo,
            'projectCounts' => $projectCounts,
            'quickActions' => $demo['quickActions'],
            'pageTitle' => 'Dashboard Overview',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'dashboard',
        ]);
    }
}
