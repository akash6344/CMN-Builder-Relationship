@extends('layouts.app')

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Project Approvals</h2>
      <p class="page-head-sub">{{ number_format($counts['pending']) }} awaiting review · Approve to go live or send back for edits</p>
    </div>
  </div>

  <div class="status-cards">
    <a class="status-card {{ ($filters['status'] ?? 'pending') === 'pending' ? 'is-active' : '' }}" href="{{ route('project-approvals.index', ['status' => 'pending']) }}">
      <span>Pending</span>
      <strong>{{ $counts['pending'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? '') === 'live' ? 'is-active' : '' }}" href="{{ route('project-approvals.index', ['status' => 'live']) }}">
      <span>Live</span>
      <strong>{{ $counts['live'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? '') === 'rejected' ? 'is-active' : '' }}" href="{{ route('project-approvals.index', ['status' => 'rejected']) }}">
      <span>Rejected</span>
      <strong>{{ $counts['rejected'] }}</strong>
    </a>
    <a class="status-card {{ ($filters['status'] ?? '') === 'all' ? 'is-active' : '' }}" href="{{ route('project-approvals.index', ['status' => 'all']) }}">
      <span>All</span>
      <strong>{{ $counts['all'] }}</strong>
    </a>
  </div>

  <div class="toolbar-row">
    <form method="GET" action="{{ route('project-approvals.index') }}" class="toolbar-search">
      {!! \App\Support\Icon::svg('search') !!}
      <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search project, builder, RERA...">
      @if (($filters['status'] ?? 'pending') !== 'pending')
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
            <th>Project</th>
            <th>Builder</th>
            <th>Location</th>
            <th>Status</th>
            <th>Units</th>
            <th>RERA</th>
            <th>Updated</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($projects as $project)
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
              <td>{{ $project->unit_configurations_count ?: ($project->total_units ?: '—') }}</td>
              <td>{{ $project->rera_number ?: '—' }}</td>
              <td>{{ optional($project->updated_at)->diffForHumans() }}</td>
              <td>
                @if ($project->isPendingReview())
                  <div class="approval-actions">
                    <form method="POST" action="{{ route('project-approvals.approve', $project) }}">
                      @csrf
                      @method('PATCH')
                      <button class="btn btn-success-sm" type="submit">Approve</button>
                    </form>
                    <button
                      class="btn btn-danger-sm"
                      type="button"
                      data-reject-id="{{ $project->id }}"
                      data-reject-name="{{ $project->name }}"
                      onclick="openRejectModal(this)"
                    >Send back</button>
                  </div>
                @else
                  <span class="muted-inline">—</span>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="empty-cell">No projects in this approval queue.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if ($projects->hasPages())
      <div class="pagination">{{ $projects->links() }}</div>
    @endif
  </div>

  <div class="modal-backdrop" id="rejectModal" hidden>
    <div class="modal-box">
      <div class="modal-header">
        <h3>Send project back for edits</h3>
        <button type="button" class="modal-close" onclick="closeRejectModal()">×</button>
      </div>
      <form method="POST" id="rejectForm">
        @csrf
        @method('PATCH')
        <p class="card-sub">This returns <strong id="rejectName">the project</strong> to the builder for edits. It does not delete the project.</p>
        <label class="form-label" for="rejection_reason">What should they fix?</label>
        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required minlength="5" maxlength="2000" placeholder="Explain what needs to be corrected..."></textarea>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeRejectModal()">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background:#ef4444;">Send back</button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  const rejectBase = @json(url('/project-approvals'));
  function openRejectModal(btn) {
    document.getElementById('rejectForm').action = `${rejectBase}/${btn.dataset.rejectId}/reject`;
    document.getElementById('rejectName').textContent = btn.dataset.rejectName || 'the project';
    document.getElementById('rejection_reason').value = '';
    document.getElementById('rejectModal').hidden = false;
  }
  function closeRejectModal() {
    document.getElementById('rejectModal').hidden = true;
  }
  document.getElementById('rejectModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'rejectModal') closeRejectModal();
  });
</script>
@endpush
