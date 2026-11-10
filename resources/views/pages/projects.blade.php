@extends('layouts.app')

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Projects</h2>
      <p class="page-head-sub">{{ number_format($counts['live']) }} active {{ $counts['live'] === 1 ? 'project' : 'projects' }} · {{ number_format($counts['pending']) }} awaiting approval</p>
    </div>
    <button class="btn btn-primary" type="button">
      {!! \App\Support\Icon::svg('plus') !!}
      Add Project
    </button>
  </div>

  <div class="status-cards">
    <a class="status-card {{ ($filters['status'] ?? 'all') === 'live' ? 'is-active' : '' }}" href="{{ route('projects.index', ['status' => 'live']) }}">
      <span>Live</span>
      <strong>{{ $counts['live'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? 'all') === 'pending' ? 'is-active' : '' }}" href="{{ route('projects.index', ['status' => 'pending']) }}">
      <span>Pending Approval</span>
      <strong>{{ $counts['pending'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? 'all') === 'review' ? 'is-active' : '' }}" href="{{ route('projects.index', ['status' => 'review']) }}">
      <span>Under Review</span>
      <strong>{{ $counts['review'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? 'all') === 'rejected' ? 'is-active' : '' }}" href="{{ route('projects.index', ['status' => 'rejected']) }}">
      <span>Rejected</span>
      <strong>{{ $counts['rejected'] }}</strong>
    </a>
  </div>

  <div class="card table-card">
    <div class="table-wrap">
      <table class="projects-table">
        <thead>
          <tr>
            <th>Project</th>
            <th>Builder</th>
            <th>Location</th>
            <th>Status</th>
            <th>Properties</th>
            <th>Leads</th>
            <th>Views</th>
            <th>Offers</th>
            <th>Revenue</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($projects as $project)
            @php
              $metrics = $project->dashboardMetrics();
            @endphp
            <tr>
              <td>
                <strong class="project-name">{{ $project->name }}</strong>
                @if ($project->rejection_reason)
                  <div class="reject-note">{{ $project->rejection_reason }}</div>
                @endif
              </td>
              <td>{{ $project->builder_name }}</td>
              <td>{{ $project->location }}</td>
              <td><span class="badge {{ $project->statusBadgeClass() }}">{{ $project->displayStatus() }}</span></td>
              <td>{{ number_format($metrics['properties']) }}</td>
              <td>{{ number_format($metrics['leads']) }}</td>
              <td>{{ number_format($metrics['views']) }}</td>
              <td>{{ number_format($metrics['offers']) }}</td>
              <td>{{ $metrics['revenue'] }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="empty-cell">
                No shared housing projects found yet. Submit one from the builder portal.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($projects->hasPages())
      <div class="pagination">{{ $projects->links() }}</div>
    @endif
  </div>
@endsection
