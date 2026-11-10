@extends('layouts.app')

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Leads</h2>
      <p class="page-head-sub">{{ $summaryLine }}</p>
    </div>
  </div>

  <div class="kpi-grid" style="margin-bottom:1rem;">
    <div class="kpi-card"><strong>{{ number_format($counts['total']) }}</strong><span>Total</span></div>
    <div class="kpi-card"><strong>{{ number_format($counts['new']) }}</strong><span>New</span></div>
    <div class="kpi-card"><strong>{{ number_format($counts['contacted']) }}</strong><span>Contacted</span></div>
    <div class="kpi-card"><strong>{{ number_format($counts['site_visit']) }}</strong><span>Site Visits</span></div>
    <div class="kpi-card"><strong>{{ number_format($counts['negotiating']) }}</strong><span>Negotiating</span></div>
    <div class="kpi-card"><strong>{{ number_format($counts['closed']) }}</strong><span>Closed</span></div>
  </div>

  <div class="toolbar-row">
    <form method="GET" action="{{ route('builder-leads.index') }}" class="toolbar-search">
      {!! \App\Support\Icon::svg('search') !!}
      <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Filter by name, email, project, builder...">
      @if (($filters['status'] ?? 'all') !== 'all')
        <input type="hidden" name="status" value="{{ $filters['status'] }}">
      @endif
    </form>
    <div class="status-tabs">
      @foreach (['all' => 'All', 'new' => 'New', 'contacted' => 'Contacted', 'site_visit' => 'Site Visit', 'closed' => 'Closed'] as $key => $label)
        <a
          class="status-tab {{ ($filters['status'] ?? 'all') === $key ? 'is-active' : '' }}"
          href="{{ route('builder-leads.index', array_filter(['status' => $key === 'all' ? null : $key, 'q' => $filters['q'] ?? null])) }}"
        >{{ $label }}</a>
      @endforeach
    </div>
  </div>

  <div class="card table-card">
    <div class="table-wrap">
      <table class="projects-table">
        <thead>
          <tr>
            <th>Lead</th>
            <th>Interest</th>
            <th>Builder</th>
            <th>Status</th>
            <th>Source</th>
            <th>Platform</th>
            <th>Assigned</th>
            <th>Updated</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if (! $hasLeads)
            <tr><td colspan="9" class="empty-cell">Run housing migrations to create the shared leads table.</td></tr>
          @else
            @forelse ($leads as $lead)
              <tr>
                <td>
                  <div class="person-cell">
                    <span class="avatar-sm">{{ $lead->initials() }}</span>
                    <span>
                      <strong class="project-name">{{ $lead->name }}</strong>
                      <span class="muted-inline">{{ $lead->lead_code }}</span>
                      <span class="muted-inline">{{ $lead->email ?: '—' }} · {{ $lead->phone ?: '—' }}</span>
                    </span>
                  </div>
                </td>
                <td>
                  <strong>{{ $lead->interest_title ?: ($lead->project?->name ?: 'General') }}</strong>
                  <span class="muted-inline">{{ $lead->unit_label ?: ($lead->city ?: '—') }}</span>
                </td>
                <td>{{ $lead->builder_name ?: '—' }}</td>
                <td><span class="badge {{ $lead->statusBadgeClass() }}">{{ $lead->statusLabel() }}</span></td>
                <td>{{ $lead->sourceLabel() }}</td>
                <td>{{ strtoupper($lead->source_platform) }}</td>
                <td>{{ $lead->assigned_to ?: 'Unassigned' }}</td>
                <td>{{ optional($lead->last_activity_at ?? $lead->created_at)->format('M j, Y') }}</td>
                <td>
                  <div class="row-actions">
                    @if ($lead->phone)
                      <a class="icon-action" href="tel:{{ $lead->phone }}" title="Call">{!! \App\Support\Icon::svg('phone') !!}</a>
                    @endif
                    @if ($lead->email)
                      <a class="icon-action" href="mailto:{{ $lead->email }}" title="Email">{!! \App\Support\Icon::svg('mail') !!}</a>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="9" class="empty-cell">No shared leads yet. Favorites / enquiries from the user dashboard will show here.</td></tr>
            @endforelse
          @endif
        </tbody>
      </table>
    </div>
    @if ($hasLeads && method_exists($leads, 'hasPages') && $leads->hasPages())
      <div class="pagination">{{ $leads->links() }}</div>
    @endif
  </div>
@endsection
