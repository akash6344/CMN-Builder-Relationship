@extends('layouts.app')

@section('content')
  {{-- 1. Hero + KPI strip --}}
  <section class="hero-banner">
    <div class="hero-copy">
      <span class="hero-badge">{{ $hero['badge'] }}</span>
      <h2>{{ $hero['title'] }}</h2>
      <p>{{ $hero['subtitle'] }}</p>
    </div>
    <button class="hero-ai" type="button" title="AI assistant">
      {!! \App\Support\Icon::svg('sparkles') !!}
      <span>AI</span>
    </button>
  </section>

  <section class="kpi-grid">
    @foreach ($kpiCards as $card)
      <article class="kpi-card {{ !empty($card['danger']) ? 'is-danger' : '' }}">
        <div class="kpi-label">
          <span class="kpi-dot tone-{{ $card['tone'] }}"></span>
          {{ $card['label'] }}
        </div>
        <div class="kpi-value-row">
          <strong>{{ $card['value'] }}</strong>
          <em class="{{ !empty($card['plain']) ? 'is-plain' : (str_starts_with($card['delta'], '-') ? 'is-down' : 'is-up') }}">
            {{ $card['delta'] }}
          </em>
        </div>
      </article>
    @endforeach
  </section>

  {{-- 2. Monthly Revenue Trend + Builder Summary --}}
  <div class="grid-2 mt-16">
    <section class="card card-pad card-tall">
      <h2 class="card-title">{!! \App\Support\Icon::svg('lineChart') !!} Monthly Revenue Trend</h2>
      <p class="card-sub">Subscription + featured + advertising · in ₹ Lakhs</p>
      <div class="line-chart">
        @php
          $values = $revenueTrend['values'];
          $labels = $revenueTrend['labels'];
          $max = max($values ?: [1]);
          $w = 560; $h = 220; $padX = 28; $padY = 24;
          $count = max(count($values) - 1, 1);
          $coords = [];
          foreach ($values as $i => $value) {
            $x = $padX + (($w - ($padX * 2)) * ($i / $count));
            $y = ($h - $padY) - ((($value / $max) * ($h - ($padY * 2))));
            $coords[] = ['x' => round($x, 2), 'y' => round($y, 2)];
          }
          $polyline = collect($coords)->map(fn ($p) => $p['x'].','.$p['y'])->implode(' ');
          $area = $polyline.' '.($coords[count($coords)-1]['x']).','.($h - $padY).' '.$coords[0]['x'].','.($h - $padY);
        @endphp
        <svg viewBox="0 0 {{ $w }} {{ $h }}" class="line-chart-svg" role="img" aria-label="Monthly revenue trend">
          @for ($g = 0; $g < 5; $g++)
            @php $gy = $padY + ((($h - ($padY * 2)) / 4) * $g); @endphp
            <line x1="{{ $padX }}" y1="{{ $gy }}" x2="{{ $w - $padX }}" y2="{{ $gy }}" class="chart-grid" />
          @endfor
          <polygon points="{{ $area }}" class="chart-area"></polygon>
          <polyline points="{{ $polyline }}" class="chart-line-path"></polyline>
          @foreach ($coords as $point)
            <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4.5" class="chart-point-outer"></circle>
            <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="3" class="chart-point"></circle>
          @endforeach
        </svg>
        <div class="line-chart-labels">
          @foreach ($labels as $label)
            <span>{{ $label }}</span>
          @endforeach
        </div>
      </div>
    </section>

    <section class="card card-pad card-tall">
      <h2 class="card-title">{!! \App\Support\Icon::svg('users') !!} Builder Summary</h2>
      <p class="card-sub">Portfolio at a glance</p>
      <div class="stat-list">
        @foreach ($builderSummary as $row)
          <div class="stat-row">
            <span>{{ $row['label'] }}</span>
            <strong>{{ number_format($row['value']) }}</strong>
          </div>
        @endforeach
      </div>
    </section>
  </div>

  {{-- 3. Builder Pipeline --}}
  <section class="card card-pad mt-16">
    <div class="section-head">
      <div>
        <h2 class="card-title">Builder Pipeline</h2>
        <p class="card-sub">Lead → Live on CMNHousing</p>
      </div>
    </div>
    <div class="pipeline">
      @foreach ($pipeline as $step)
        <div class="pipeline-item">
          <span>{{ $step['label'] }}</span>
          <strong>{{ number_format($step['value']) }}</strong>
          <div class="bar"><i style="width: {{ $step['pct'] }}%"></i></div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- 4. Revenue by Stream + Notifications --}}
  <div class="grid-2 mt-16">
    <section class="card card-pad card-tall">
      <h2 class="card-title">{!! \App\Support\Icon::svg('barChart') !!} Revenue by Stream</h2>
      <p class="card-sub">All active monetization channels</p>
      @php $streamMax = max(collect($revenueByStream)->pluck('value')->all() ?: [1]); @endphp
      <div class="vbars">
        @foreach ($revenueByStream as $index => $stream)
          <div class="vbar-col {{ $index === 0 ? 'is-primary' : 'is-muted' }}">
            <strong>{{ $stream['value'] }}</strong>
            <div class="vbar-track">
              <div class="vbar-fill" style="height: {{ max(10, (int) round(($stream['value'] / $streamMax) * 100)) }}%"></div>
            </div>
            <span>{{ $stream['label'] }}</span>
          </div>
        @endforeach
      </div>
    </section>

    <section class="card card-pad card-tall">
      <h2 class="card-title">{!! \App\Support\Icon::svg('bell') !!} Notifications</h2>
      <p class="card-sub">Latest activity</p>
      <div class="feed">
        @foreach ($notifications as $item)
          <div class="feed-item">
            <span class="dot {{ $item['tone'] }}"></span>
            <div>
              <strong>{{ $item['title'] }}</strong>
              <p>{{ $item['body'] }}</p>
            </div>
            <time>{{ $item['when'] }}</time>
          </div>
        @endforeach
      </div>
    </section>
  </div>

  {{-- 5. AI Insights + Trust Score + Timeline --}}
  <div class="grid-3 mt-16">
    <section class="card card-pad">
      <h2 class="card-title">{!! \App\Support\Icon::svg('sparkles') !!} AI Builder Insights</h2>
      <p class="card-sub">{{ $aiInsights['subtitle'] }}</p>
      <div class="insight-rows">
        @foreach ($aiInsights['rows'] as $row)
          <div class="insight-row">
            <span>{{ $row['label'] }}</span>
            <strong class="tone-{{ $row['tone'] }}">{{ $row['value'] }}</strong>
          </div>
        @endforeach
      </div>
    </section>

    <section class="card card-pad">
      <h2 class="card-title">{!! \App\Support\Icon::svg('shield') !!} AI Trust Score</h2>
      <p class="card-sub">{{ $trustScore['builder'] }} · {{ $trustScore['badge'] }}</p>
      <div class="trust-score-block">
        <div class="trust-score-head">
          <div class="trust-score-num">
            <strong>{{ $trustScore['score'] }}</strong>
            <span>/ 100</span>
          </div>
          <div class="trust-stars" aria-label="{{ $trustScore['stars'] }} star rating">
            @for ($i = 0; $i < $trustScore['stars']; $i++)
              <span>★</span>
            @endfor
          </div>
        </div>
        <div class="trust-progress"><i style="width: {{ $trustScore['score'] }}%"></i></div>
        <ul class="check-list">
          @foreach ($trustScore['checks'] as $check)
            <li>{{ $check }}</li>
          @endforeach
        </ul>
        <div class="trust-reco">
          AI Recommendation: {{ $trustScore['recommendation'] }}
        </div>
      </div>
    </section>

    <section class="card card-pad">
      <h2 class="card-title">{!! \App\Support\Icon::svg('clock') !!} Relationship Timeline</h2>
      <p class="card-sub">{{ $trustScore['builder'] }}</p>
      <div class="timeline">
        @foreach ($timeline as $event)
          <div class="timeline-item">
            <span>{{ $event['date'] }}</span>
            <strong>{{ $event['title'] }}</strong>
          </div>
        @endforeach
      </div>
    </section>
  </div>

  {{-- 6. Builder Revenue Funnel --}}
  <section class="card card-pad mt-16">
    <h2 class="card-title">{!! \App\Support\Icon::svg('trendingUp') !!} Builder Revenue Funnel</h2>
    <p class="card-sub">Full lifecycle conversion overview</p>
    <div class="funnel-grid">
      @foreach ($revenueFunnel as $item)
        <div class="funnel-item">
          <span>{{ $item['label'] }}</span>
          <strong>{{ $item['value'] }}</strong>
        </div>
      @endforeach
    </div>
  </section>
@endsection
