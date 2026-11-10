@extends('layouts.app')

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Documents</h2>
      <p class="page-head-sub">{{ number_format($counts['pending']) }} pending verification · Shared project documents from CMN-housing</p>
    </div>
  </div>

  <div class="status-cards">
    <a class="status-card {{ ($filters['status'] ?? 'all') === 'all' ? 'is-active' : '' }}" href="{{ route('documents.index') }}">
      <span>All</span>
      <strong>{{ $counts['all'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? '') === 'pending' ? 'is-active' : '' }}" href="{{ route('documents.index', ['status' => 'pending']) }}">
      <span>Pending</span>
      <strong>{{ $counts['pending'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? '') === 'verified' ? 'is-active' : '' }}" href="{{ route('documents.index', ['status' => 'verified']) }}">
      <span>Verified</span>
      <strong>{{ $counts['verified'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? '') === 'rejected' ? 'is-active' : '' }}" href="{{ route('documents.index', ['status' => 'rejected']) }}">
      <span>Rejected</span>
      <strong>{{ $counts['rejected'] }}</strong>
    </a>
  </div>

  <div class="toolbar-row">
    <form method="GET" action="{{ route('documents.index') }}" class="toolbar-search">
      {!! \App\Support\Icon::svg('search') !!}
      <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search document, project, builder...">
      @if (($filters['status'] ?? 'all') !== 'all')
        <input type="hidden" name="status" value="{{ $filters['status'] }}">
      @endif
    </form>
  </div>

  @if (session('success'))
    <div class="card card-pad flash-success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="card card-pad flash-error">{{ $errors->first() }}</div>
  @endif

  <div class="card table-card">
    <div class="table-wrap">
      <table class="projects-table">
        <thead>
          <tr>
            <th>Document</th>
            <th>Project</th>
            <th>Builder</th>
            <th>Category</th>
            <th>Number</th>
            <th>Status</th>
            <th>Updated</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($documents as $document)
            <tr>
              <td>
                <strong class="project-name">{{ $document->title }}</strong>
                @if ($document->file_name)
                  <span class="muted-inline">{{ $document->file_name }}</span>
                @endif
              </td>
              <td>{{ $document->projectDetail?->name ?: '—' }}</td>
              <td>{{ $document->projectDetail?->builder_name ?: '—' }}</td>
              <td>{{ $document->displayCategory() }}</td>
              <td>{{ $document->document_number ?: '—' }}</td>
              <td><span class="badge {{ $document->statusBadgeClass() }}">{{ $document->displayStatus() }}</span></td>
              <td>{{ optional($document->updated_at)->diffForHumans() }}</td>
              <td>
                <div class="approval-actions">
                  @if ($document->file_url)
                    <a class="btn btn-secondary-sm" href="{{ $document->file_url }}" target="_blank" rel="noopener">View</a>
                  @endif
                  @if ($document->status === 'pending')
                    <form method="POST" action="{{ route('documents.verify', $document) }}">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-success-sm" type="submit">Verify</button>
                    </form>
                    <form method="POST" action="{{ route('documents.reject', $document) }}">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-danger-sm" type="submit">Reject</button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="empty-cell">No documents found in the shared housing database.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($documents->hasPages())
      <div class="pagination">{{ $documents->links() }}</div>
    @endif
  </div>
@endsection
