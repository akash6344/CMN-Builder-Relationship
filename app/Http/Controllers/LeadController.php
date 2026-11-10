<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\ProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $hasLeads = Schema::connection('housing')->hasTable('leads');

        $status = strtolower((string) $request->query('status', 'all'));
        $q = trim((string) $request->query('q', ''));

        $leads = collect();
        $counts = [
            'total' => 0,
            'new' => 0,
            'contacted' => 0,
            'site_visit' => 0,
            'negotiating' => 0,
            'closed' => 0,
        ];

        if ($hasLeads) {
            $base = Lead::query();
            $counts = [
                'total' => (clone $base)->count(),
                'new' => (clone $base)->where('status', 'new')->count(),
                'contacted' => (clone $base)->where('status', 'contacted')->count(),
                'site_visit' => (clone $base)->where('status', 'site_visit')->count(),
                'negotiating' => (clone $base)->where('status', 'negotiating')->count(),
                'closed' => (clone $base)->where('status', 'closed')->count(),
            ];

            $query = Lead::query()->with('project')->orderByDesc('last_activity_at')->orderByDesc('id');

            if ($status !== 'all') {
                $query->where('status', str_replace(' ', '_', $status));
            }

            if ($q !== '') {
                $query->where(function ($builder) use ($q) {
                    $builder->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhere('lead_code', 'like', "%{$q}%")
                        ->orWhere('interest_title', 'like', "%{$q}%")
                        ->orWhere('builder_name', 'like', "%{$q}%");
                });
            }

            $leads = $query->paginate(20)->withQueryString();
        }

        $projectCount = Schema::connection('housing')->hasTable('project_details')
            ? ProjectDetail::query()->count()
            : 0;

        return view('pages.leads', [
            'active' => 'builder-leads',
            'leads' => $leads,
            'counts' => $counts,
            'filters' => [
                'status' => $status,
                'q' => $q,
            ],
            'summaryLine' => $hasLeads
                ? number_format($counts['total']).' shared leads across builder + user portals · '.$projectCount.' projects'
                : 'Universal leads table not migrated yet in CMN-housing',
            'hasLeads' => $hasLeads,
        ]);
    }
}
