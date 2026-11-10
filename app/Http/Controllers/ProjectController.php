<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $status = strtolower(trim((string) $request->query('status', 'all'))) ?: 'all';
        $search = trim((string) $request->query('q', ''));

        $counts = [
            'live' => ProjectDetail::query()->where('status', 'published')->count(),
            'pending' => ProjectDetail::query()->where('status', 'under_review')->count(),
            'review' => ProjectDetail::query()->where('status', 'draft')->count(),
            'rejected' => ProjectDetail::query()->where('status', 'rejected')->count(),
            'all' => ProjectDetail::query()->count(),
        ];

        $projectsQuery = ProjectDetail::query()
            ->withCount('unitConfigurations')
            ->latest('updated_at')
            ->latest('id');

        if ($status === 'live') {
            $projectsQuery->where('status', 'published');
        } elseif ($status === 'pending') {
            $projectsQuery->where('status', 'under_review');
        } elseif ($status === 'review') {
            $projectsQuery->where('status', 'draft');
        } elseif ($status === 'rejected') {
            $projectsQuery->where('status', 'rejected');
        }

        if ($search !== '') {
            $projectsQuery->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('builder_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('rera_number', 'like', "%{$search}%");
            });
        }

        return view('pages.projects', [
            'projects' => $projectsQuery->paginate(12)->withQueryString(),
            'counts' => $counts,
            'filters' => [
                'status' => $status,
                'q' => $search,
            ],
            'pageTitle' => 'Projects',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'projects',
        ]);
    }
}
