<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use App\Models\ProjectDetail;
use App\Models\ProjectDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * @var array<string, array{title: string, description: string}>
     */
    private array $reports = [
        'daily' => [
            'title' => 'Daily Report',
            'description' => "Yesterday's activity, revenue, tickets and approvals",
        ],
        'weekly' => [
            'title' => 'Weekly Report',
            'description' => 'Pipeline movement, conversion and renewals',
        ],
        'monthly' => [
            'title' => 'Monthly Report',
            'description' => 'Portfolio performance, revenue and satisfaction',
        ],
        'yearly' => [
            'title' => 'Yearly Report',
            'description' => 'Full-year financial and operational summary',
        ],
    ];

    public function index(): View
    {
        return view('pages.reports', [
            'reports' => $this->reports,
            'pageTitle' => 'Reports',
            'pageSub' => 'CMNHousing · Builder Relationship Manager',
            'active' => 'reports',
        ]);
    }

    public function export(Request $request, string $type, string $format): StreamedResponse|Response
    {
        abort_unless(isset($this->reports[$type]), 404);
        abort_unless(in_array($format, ['csv', 'excel', 'pdf'], true), 404);

        $rows = $this->rowsFor($type);
        $filename = "cmn-brm-{$type}-report.".($format === 'excel' ? 'xls' : ($format === 'pdf' ? 'txt' : 'csv'));

        if ($format === 'pdf') {
            $body = $this->reports[$type]['title']."\n".$this->reports[$type]['description']."\n\n";
            foreach ($rows as $row) {
                $body .= implode(' | ', $row)."\n";
            }

            return response($body, 200, [
                'Content-Type' => 'text/plain; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        return response()->streamDownload(function () use ($rows): void {
            $out = fopen('php://output', 'w');
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => $format === 'excel'
                ? 'application/vnd.ms-excel'
                : 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @return list<list<string|int|float|null>>
     */
    private function rowsFor(string $type): array
    {
        $headers = ['Metric', 'Value'];
        $rows = [$headers];

        $builderCount = Schema::hasTable('builders') ? Builder::query()->count() : 0;
        $activeBuilders = Schema::hasTable('builders') ? Builder::query()->where('status', 'Active')->count() : 0;
        $projectCount = Schema::connection('housing')->hasTable('project_details') ? ProjectDetail::query()->count() : 0;
        $pendingApprovals = Schema::connection('housing')->hasTable('project_details')
            ? ProjectDetail::query()->where('status', 'under_review')->count()
            : 0;
        $liveProjects = Schema::connection('housing')->hasTable('project_details')
            ? ProjectDetail::query()->where('status', 'published')->count()
            : 0;
        $pendingDocs = Schema::connection('housing')->hasTable('project_documents')
            ? ProjectDocument::query()->where('status', 'pending')->count()
            : 0;

        $rows[] = ['Generated At', now()->toDateTimeString()];
        $rows[] = ['Report Type', strtoupper($type)];
        $rows[] = ['Total Builders', $builderCount];
        $rows[] = ['Active Builders', $activeBuilders];
        $rows[] = ['Total Projects', $projectCount];
        $rows[] = ['Live Projects', $liveProjects];
        $rows[] = ['Pending Approvals', $pendingApprovals];
        $rows[] = ['Pending Documents', $pendingDocs];

        if (Schema::hasTable('builders')) {
            $rows[] = ['—', '—'];
            $rows[] = ['Builder', 'Company', 'City', 'Status', 'Subscription', 'Revenue (L)'];
            foreach (Builder::query()->orderBy('company_name')->limit(50)->get() as $builder) {
                $rows[] = [
                    $builder->owner_name,
                    $builder->company_name,
                    $builder->city,
                    $builder->status,
                    $builder->subscription,
                    $builder->revenue_lakhs,
                ];
            }
        }

        return $rows;
    }
}
