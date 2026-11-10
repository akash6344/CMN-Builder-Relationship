<?php

namespace App\Http\Controllers;

use App\Models\ProjectDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $status = strtolower(trim((string) $request->query('status', 'all'))) ?: 'all';
        $search = trim((string) $request->query('q', ''));

        $counts = [
            'pending' => ProjectDocument::query()->where('status', 'pending')->count(),
            'verified' => ProjectDocument::query()->where('status', 'verified')->count(),
            'rejected' => ProjectDocument::query()->where('status', 'rejected')->count(),
            'all' => ProjectDocument::query()->count(),
        ];

        $documentsQuery = ProjectDocument::query()
            ->with('projectDetail')
            ->latest('updated_at')
            ->latest('id');

        if (in_array($status, ['pending', 'verified', 'rejected'], true)) {
            $documentsQuery->where('status', $status);
        }

        if ($search !== '') {
            $documentsQuery->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('document_number', 'like', "%{$search}%")
                    ->orWhereHas('projectDetail', function ($project) use ($search): void {
                        $project->where('name', 'like', "%{$search}%")
                            ->orWhere('builder_name', 'like', "%{$search}%");
                    });
            });
        }

        return view('pages.documents', [
            'documents' => $documentsQuery->paginate(15)->withQueryString(),
            'counts' => $counts,
            'filters' => ['status' => $status, 'q' => $search],
            'pageTitle' => 'Documents',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'documents',
        ]);
    }

    public function verify(ProjectDocument $document): RedirectResponse
    {
        if ($document->status !== 'pending') {
            return back()->withErrors(['document' => 'Only pending documents can be verified.']);
        }

        $document->verify();

        return back()->with('success', "{$document->title} marked as verified.");
    }

    public function reject(ProjectDocument $document): RedirectResponse
    {
        if ($document->status !== 'pending') {
            return back()->withErrors(['document' => 'Only pending documents can be rejected.']);
        }

        $document->reject();

        return back()->with('success', "{$document->title} rejected.");
    }
}
