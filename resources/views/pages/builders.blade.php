@extends('layouts.app')

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Builders</h2>
      <p class="page-head-sub">{{ $summaryLine }}</p>
    </div>
  </div>

  <div class="toolbar-row">
    <form method="GET" action="{{ route('builders.index') }}" class="toolbar-search">
      {!! \App\Support\Icon::svg('search') !!}
      <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Filter by name, city, RERA...">
      @if (($filters['status'] ?? 'all') !== 'all')
        <input type="hidden" name="status" value="{{ $filters['status'] }}">
      @endif
    </form>
    <button class="btn btn-primary" type="button">
      {!! \App\Support\Icon::svg('plus') !!}
      Add Builder
    </button>
  </div>

  <div class="card table-card">
    <div class="table-wrap">
      <table class="projects-table">
        <thead>
          <tr>
            <th>Builder</th>
            <th>Company</th>
            <th>Projects</th>
            <th>City</th>
            <th>Subscription</th>
            <th>Status</th>
            <th>Manager</th>
            <th>Revenue</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($builders as $builder)
            <tr>
              <td>
                <div class="person-cell">
                  <span class="avatar-sm">{{ $builder->initials() }}</span>
                  <span>
                    <strong class="project-name">{{ $builder->owner_name }}</strong>
                    <span class="muted-inline">{{ $builder->code }}</span>
                  </span>
                </div>
              </td>
              <td>{{ $builder->company_name }}</td>
              <td>{{ number_format($builder->projects_count) }}</td>
              <td>{{ $builder->city ?: '—' }}</td>
              <td><span class="badge {{ $builder->subscriptionBadgeClass() }}">{{ $builder->subscription }}</span></td>
              <td><span class="badge {{ $builder->statusBadgeClass() }}">{{ $builder->status }}</span></td>
              <td>{{ $builder->manager }}</td>
              <td>{{ $builder->formattedRevenue() }}</td>
              <td>
                <div class="row-actions">
                  <button type="button" class="icon-action" title="View">{!! \App\Support\Icon::svg('eye') !!}</button>
                  <button type="button" class="icon-action" title="Edit">{!! \App\Support\Icon::svg('pencil') !!}</button>
                  <a class="icon-action" href="tel:{{ $builder->phone }}" title="Call">{!! \App\Support\Icon::svg('phone') !!}</a>
                  <button type="button" class="icon-action" title="Message">{!! \App\Support\Icon::svg('message') !!}</button>
                  <a class="icon-action" href="mailto:{{ $builder->email }}" title="Email">{!! \App\Support\Icon::svg('mail') !!}</a>
                  <button type="button" class="icon-action" title="Assign manager">{!! \App\Support\Icon::svg('userCog') !!}</button>
                  <button type="button" class="icon-action is-danger" title="Block">{!! \App\Support\Icon::svg('ban') !!}</button>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="empty-cell">No builders found. Run the builder seeder to load portfolio data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($builders->hasPages())
      <div class="pagination">{{ $builders->links() }}</div>
    @endif
  </div>

  @if ($featured)
    <div class="card card-pad featured-card">
      <div class="featured-head">
        <div>
          <h3 class="card-title">Featured Builder Profile</h3>
          <p class="card-sub">{{ $featured->company_name }} · {{ $featured->owner_name }}</p>
        </div>
        <span class="badge badge-review">Trust Score {{ $featured->trust_score }}/100</span>
      </div>
      <div class="featured-grid">
        <div><span>Company</span><strong>{{ $featured->company_name }}</strong></div>
        <div><span>Owner</span><strong>{{ $featured->owner_name }}</strong></div>
        <div><span>GST</span><strong>{{ $featured->gst ?: '—' }}</strong></div>
        <div><span>RERA</span><strong>{{ $featured->rera ?: '—' }}</strong></div>
        <div><span>PAN</span><strong>{{ $featured->pan ?: '—' }}</strong></div>
        <div><span>KYC</span><strong class="{{ $featured->kyc_status === 'Verified' ? 'tone-green' : '' }}">{{ $featured->kyc_status }}</strong></div>
        <div><span>Rating</span><strong>★★★★★ {{ number_format($featured->rating, 1) }}</strong></div>
        <div><span>Subscription</span><strong>{{ $featured->subscription }}</strong></div>
        <div><span>Projects</span><strong>{{ number_format($featured->projects_count) }}</strong></div>
        <div><span>Revenue Generated</span><strong>{{ $featured->formattedRevenue() }}</strong></div>
        <div><span>Support Tickets</span><strong>{{ $featured->support_tickets }} (Resolved)</strong></div>
        <div><span>Assigned Manager</span><strong>{{ $featured->manager }}</strong></div>
      </div>
    </div>
  @endif
@endsection
