<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuilderController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', 'all'));

        $query = Builder::query()->latest('id');

        if ($status !== '' && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('owner_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('rera', 'like', "%{$search}%")
                    ->orWhere('gst', 'like', "%{$search}%");
            });
        }

        $builders = $query->paginate(12)->withQueryString();
        $featured = Builder::query()->where('featured', true)->orderByDesc('trust_score')->first()
            ?? Builder::query()->orderByDesc('trust_score')->first();

        $activeCount = Builder::query()->where('status', 'Active')->count();
        $cityCount = Builder::query()->whereNotNull('city')->pluck('city')->unique()->count();

        return view('pages.builders', [
            'builders' => $builders,
            'featured' => $featured,
            'filters' => ['q' => $search, 'status' => $status],
            'pageTitle' => 'Builders',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'builders',
            'summaryLine' => number_format($activeCount).' active builders across '.number_format(max(1, $cityCount)).' cities · Manage relationships end-to-end',
        ]);
    }
}
