@extends('layouts.app')

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Reports</h2>
      <p class="page-head-sub">Scheduled and on-demand exports</p>
    </div>
  </div>

  <div class="reports-grid">
    @foreach ($reports as $key => $report)
      <div class="card card-pad report-card">
        <h3 class="card-title">{{ $report['title'] }}</h3>
        <p class="card-sub">{{ $report['description'] }}</p>
        <div class="report-actions">
          <a class="btn btn-secondary report-export" href="{{ route('reports.export', ['type' => $key, 'format' => 'pdf']) }}">
            {!! \App\Support\Icon::svg('fileText') !!}
            PDF
          </a>
          <a class="btn btn-secondary report-export" href="{{ route('reports.export', ['type' => $key, 'format' => 'excel']) }}">
            {!! \App\Support\Icon::svg('file') !!}
            Excel
          </a>
          <a class="btn btn-secondary report-export" href="{{ route('reports.export', ['type' => $key, 'format' => 'csv']) }}">
            {!! \App\Support\Icon::svg('download') !!}
            CSV
          </a>
        </div>
      </div>
    @endforeach
  </div>
@endsection
