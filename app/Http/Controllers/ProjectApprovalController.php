<?php

namespace App\Http\Controllers;

use App\Models\ProjectDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $status = strtolower(trim((string) $request->query('status', 'pending'))) ?: 'pending';
        $search = trim((string) $request->query('q', ''));

        $counts = [
            'pending' => ProjectDetail::query()->where('status', 'under_review')->count(),
            'live' => ProjectDetail::query()->where('status', 'published')->count(),
            'rejected' => ProjectDetail::query()->where('status', 'rejected')->count(),
            'all' => ProjectDetail::query()->whereIn('status', ['under_review', 'published', 'rejected'])->count(),
        ];

        $projectsQuery = ProjectDetail::query()
            ->withCount('unitConfigurations')
            ->latest('updated_at')
            ->latest('id');

        if ($status === 'pending') {
            $projectsQuery->where('status', 'under_review');
        } elseif ($status === 'live') {
            $projectsQuery->where('status', 'published');
        } elseif ($status === 'rejected') {
            $projectsQuery->where('status', 'rejected');
        } else {
            $projectsQuery->whereIn('status', ['under_review', 'published', 'rejected']);
        }

        if ($search !== '') {
            $projectsQuery->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('builder_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('rera_number', 'like', "%{$search}%");
            });
        }

        return view('pages.project-approvals', [
            'projects' => $projectsQuery->paginate(12)->withQueryString(),
            'counts' => $counts,
            'filters' => ['status' => $status, 'q' => $search],
            'pageTitle' => 'Project Approvals',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'project-approvals',
        ]);
    }

    public function approve(ProjectDetail $project): RedirectResponse
    {
        if (! $project->isPendingReview()) {
            return back()->withErrors(['project' => 'Only pending projects can be approved.']);
        }

        $project->approve();

        return back()->with('success', "{$project->name} is now live.");
    }

    public function reject(Request $request, ProjectDetail $project): RedirectResponse
    {
        if (! $project->isPendingReview()) {
            return back()->withErrors(['project' => 'Only pending projects can be rejected.']);
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5', 'max:2000'],
        ], [], ['rejection_reason' => 'rejection comment']);

        $project->reject($validated['rejection_reason']);

        return back()->with('success', "{$project->name} sent back to the builder for edits.");
    }
}
