<?php

namespace App\Support;

class DemoDashboardData
{
    /**
     * @return array<string, mixed>
     */
    public static function overview(): array
    {
        return [
            'hero' => [
                'badge' => 'Enterprise BRM Console',
                'title' => 'Welcome back, Anita',
                'subtitle' => 'You have 22 renewals due this week, 38 project approvals waiting, and 7 open complaints across your portfolio.',
            ],
            'quickActions' => [
                'Add Builder',
                'Add Project',
                'Schedule Meeting',
                'Upload Documents',
                'Approve Project',
                'Upgrade Subscription',
                'Generate Invoice',
                'Export Report',
            ],
            'kpiCards' => [
                ['label' => 'Active Builders', 'value' => '324', 'delta' => '+12', 'tone' => 'blue'],
                ['label' => 'Active Projects', 'value' => '1,286', 'delta' => '+48', 'tone' => 'cyan'],
                ['label' => 'Monthly Revenue', 'value' => '₹1.82 Cr', 'delta' => '+18%', 'tone' => 'green'],
                ['label' => 'Pending Approvals', 'value' => '38', 'delta' => '-6', 'tone' => 'amber'],
                ['label' => 'New Leads', 'value' => '48', 'delta' => '+9', 'tone' => 'blue'],
                ['label' => 'Premium Builders', 'value' => '96', 'delta' => '+4', 'tone' => 'purple'],
                ['label' => 'Site Visits', 'value' => '154', 'delta' => '+22', 'tone' => 'teal'],
                ['label' => 'Renewal Due', 'value' => '22', 'delta' => 'This week', 'tone' => 'amber', 'plain' => true],
                ['label' => 'Builder Satisfaction', 'value' => '94%', 'delta' => '+2%', 'tone' => 'green'],
                ['label' => 'Complaints', 'value' => '7', 'delta' => '-3', 'tone' => 'red', 'danger' => true],
                ['label' => 'AI Score', 'value' => '9.4/10', 'delta' => 'Excellent', 'tone' => 'blue', 'plain' => true],
                ['label' => 'Conversion Rate', 'value' => '68%', 'delta' => '+5%', 'tone' => 'green'],
            ],
            'revenueTrend' => [
                'labels' => ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                'values' => [128, 142, 151, 163, 174, 186],
            ],
            'builderSummary' => [
                ['label' => 'Total Registered', 'value' => 1200],
                ['label' => 'Active', 'value' => 892],
                ['label' => 'Inactive', 'value' => 208],
                ['label' => 'Verified', 'value' => 764],
                ['label' => 'Premium', 'value' => 96],
                ['label' => 'Blacklisted', 'value' => 12],
            ],
            'pipeline' => [
                ['label' => 'Lead Received', 'value' => 480, 'pct' => 100],
                ['label' => 'Contacted', 'value' => 362, 'pct' => 75],
                ['label' => 'Meeting Scheduled', 'value' => 248, 'pct' => 52],
                ['label' => 'KYC Submitted', 'value' => 186, 'pct' => 39],
                ['label' => 'Project Added', 'value' => 142, 'pct' => 30],
                ['label' => 'Subscription Purchased', 'value' => 98, 'pct' => 20],
                ['label' => 'Live on CMNHousing', 'value' => 84, 'pct' => 18],
            ],
            'revenueByStream' => [
                ['label' => 'Subscription Income', 'value' => 86],
                ['label' => 'Advertisement Income', 'value' => 54],
                ['label' => 'Featured Project Income', 'value' => 41],
                ['label' => 'AI Services Income', 'value' => 28],
                ['label' => 'Loan Referral Income', 'value' => 16],
            ],
            'notifications' => [
                ['tone' => 'info', 'title' => 'Builder Registered', 'body' => 'Nova Realty completed onboarding', 'when' => '2m ago'],
                ['tone' => 'warn', 'title' => 'Subscription Expiring', 'body' => 'Deshmukh Estates plan expires in 3 days', 'when' => '1h ago'],
                ['tone' => 'success', 'title' => 'Payment Received', 'body' => '₹4.2 L from Skyline Developers', 'when' => '3h ago'],
                ['tone' => 'success', 'title' => 'Project Approved', 'body' => 'Skyline Heights Phase 3 is now live', 'when' => '5h ago'],
                ['tone' => 'warn', 'title' => 'KYC Pending', 'body' => 'Palm Grove Developers KYC awaiting review', 'when' => 'Yesterday'],
            ],
            'aiInsights' => [
                'subtitle' => 'Powered by CMNHousing Intelligence',
                'rows' => [
                    ['label' => 'Builder Growth', 'value' => '+18%', 'tone' => 'green'],
                    ['label' => 'Lead Quality', 'value' => 'Excellent', 'tone' => 'green'],
                    ['label' => 'Renewal Chance', 'value' => '92%', 'tone' => 'blue'],
                    ['label' => 'Suggested Upgrade', 'value' => 'Developer Premium', 'tone' => 'dark'],
                    ['label' => 'Expected Revenue', 'value' => '₹24 Lakhs', 'tone' => 'blue'],
                ],
            ],
            'trustScore' => [
                'builder' => 'Skyline Developers',
                'badge' => 'Featured',
                'score' => 97,
                'stars' => 5,
                'checks' => ['KYC Complete', 'GST Verified', 'RERA Verified', 'Documents Verified'],
                'recommendation' => 'Eligible for Premium Builder Badge',
            ],
            'timeline' => [
                ['date' => '05 Jul', 'title' => 'Builder Registered'],
                ['date' => '06 Jul', 'title' => 'Meeting Completed'],
                ['date' => '08 Jul', 'title' => 'KYC Verified'],
                ['date' => '09 Jul', 'title' => 'Project Uploaded'],
                ['date' => '11 Jul', 'title' => 'Project Approved'],
                ['date' => '13 Jul', 'title' => 'Premium Plan Purchased'],
                ['date' => '15 Jul', 'title' => 'Featured Project Activated'],
            ],
            'revenueFunnel' => [
                ['label' => 'Builders Registered', 'value' => '1,200'],
                ['label' => 'Premium Plans', 'value' => '320'],
                ['label' => 'Projects Live', 'value' => '1,850'],
                ['label' => 'Leads Generated', 'value' => '28,000'],
                ['label' => 'Properties Sold', 'value' => '2,650'],
                ['label' => 'Revenue Generated', 'value' => '₹18.4 Cr'],
            ],
        ];
    }
}
