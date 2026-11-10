<?php

namespace App\Http\Controllers;

use App\Support\DemoAnalyticsData;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.analytics', [
            'analytics' => DemoAnalyticsData::overview(),
            'pageTitle' => 'Analytics',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'analytics',
        ]);
    }
}
