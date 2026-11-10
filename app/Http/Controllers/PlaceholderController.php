<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PlaceholderController extends Controller
{
    /**
     * @var array<string, array{title: string, sub: string}>
     */
    private array $pages = [
        'builder-leads' => ['title' => 'Builder Leads', 'sub' => 'Inbound builder acquisition pipeline'],
        'subscriptions' => ['title' => 'Subscriptions', 'sub' => 'Builder plans and renewals'],
        'site-visits' => ['title' => 'Site Visits', 'sub' => 'Scheduled builder and project site visits'],
        'builder-support' => ['title' => 'Builder Support', 'sub' => 'Tickets and relationship support queues'],
        'payments' => ['title' => 'Payments', 'sub' => 'Subscription and advertising payments'],
        'builder-performance' => ['title' => 'Builder Performance', 'sub' => 'Engagement and conversion insights'],
        'marketing' => ['title' => 'Marketing', 'sub' => 'Campaigns and featured placements'],
        'notifications' => ['title' => 'Notification Center', 'sub' => 'CMNHousing · Builder Relationship Manager'],
    ];

    public function __invoke(string $page): View
    {
        abort_unless(isset($this->pages[$page]), 404);

        return view('pages.placeholder', [
            'pageTitle' => $this->pages[$page]['title'],
            'pageSub' => $this->pages[$page]['sub'],
            'active' => $page,
            'note' => 'This screen is scaffolded from the BRM designs and will be connected to live data in a later pass.',
        ]);
    }
}
