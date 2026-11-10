@extends('layouts.app')

@php
  $revenue = $analytics['revenueGrowth'];
  $maxRevenue = max($revenue['values']) ?: 1;
  $points = [];
  foreach ($revenue['values'] as $i => $value) {
      $x = 40 + ($i * 70);
      $y = 180 - (($value / $maxRevenue) * 140);
      $points[] = [$x, $y, $value];
  }
  $linePath = collect($points)->map(fn ($p, $i) => ($i === 0 ? 'M' : 'L').$p[0].' '.$p[1])->implode(' ');
  $areaPath = $linePath.' L '.($points[count($points)-1][0]).' 180 L '.$points[0][0].' 180 Z';

  $cities = $analytics['buildersByCity'];
  $maxCity = max(array_column($cities, 'value') ?: [1]);

  $plans = $analytics['planMix'];
  $planTotal = max(1, array_sum(array_column($plans, 'value')));
  $donut = [];
  $offset = 0;
  foreach ($plans as $plan) {
      $pct = ($plan['value'] / $planTotal) * 100;
      $donut[] = array_merge($plan, ['pct' => $pct, 'offset' => $offset]);
      $offset += $pct;
  }

  $pipeline = $analytics['pipeline'];
  $maxPipe = max(array_column($pipeline, 'value') ?: [1]);
@endphp

@section('content')
  <div class="page-head">
    <div>
      <h2 class="page-head-title">Analytics</h2>
      <p class="page-head-sub">Trends, city mix, plan distribution and pipeline conversion across your portfolio</p>
    </div>
  </div>

  <div class="analytics-grid">
    <div class="card card-pad">
      <h3 class="card-title">{!! \App\Support\Icon::svg('lineChart') !!} Revenue Growth</h3>
      <p class="card-sub">Last 6 months · ₹ Lakhs</p>
      <svg class="chart-svg" viewBox="0 0 480 220" role="img" aria-label="Revenue growth chart">
        <line class="chart-grid" x1="40" y1="40" x2="440" y2="40"/>
        <line class="chart-grid" x1="40" y1="90" x2="440" y2="90"/>
        <line class="chart-grid" x1="40" y1="140" x2="440" y2="140"/>
        <line class="chart-grid" x1="40" y1="180" x2="440" y2="180"/>
        <path d="{{ $areaPath }}" class="chart-area"/>
        <path d="{{ $linePath }}" class="chart-line-path"/>
        @foreach ($points as $point)
          <circle cx="{{ $point[0] }}" cy="{{ $point[1] }}" r="5" class="chart-point-outer"/>
          <circle cx="{{ $point[0] }}" cy="{{ $point[1] }}" r="3" class="chart-point"/>
        @endforeach
        @foreach ($revenue['labels'] as $i => $label)
          <text x="{{ 40 + ($i * 70) }}" y="205" text-anchor="middle" class="chart-label">{{ $label }}</text>
        @endforeach
      </svg>
    </div>

    <div class="card card-pad">
      <h3 class="card-title">{!! \App\Support\Icon::svg('barChart') !!} Builders by City</h3>
      <p class="card-sub">Top metros in portfolio</p>
      <div class="vbars analytics-bars">
        @foreach ($cities as $city)
          @php $h = max(8, (int) round(($city['value'] / $maxCity) * 100)); @endphp
          <div class="vbar-col {{ $loop->first ? 'is-primary' : '' }}">
            <strong>{{ $city['value'] }}</strong>
            <div class="vbar-track"><i class="vbar-fill" style="height: {{ $h }}%;"></i></div>
            <span>{{ $city['label'] }}</span>
          </div>
        @endforeach
      </div>
    </div>

    <div class="card card-pad">
      <h3 class="card-title">{!! \App\Support\Icon::svg('shield') !!} Subscription Plan Mix</h3>
      <p class="card-sub">Active plans across portfolio</p>
      <div class="donut-wrap">
        <svg class="donut-svg" viewBox="0 0 42 42" aria-hidden="true">
          @foreach ($donut as $slice)
            <circle
              cx="21" cy="21" r="15.915"
              fill="transparent"
              stroke="{{ $slice['color'] }}"
              stroke-width="6"
              stroke-dasharray="{{ $slice['pct'] }} {{ 100 - $slice['pct'] }}"
              stroke-dashoffset="{{ 25 - $slice['offset'] }}"
            />
          @endforeach
        </svg>
        <ul class="donut-legend">
          @foreach ($donut as $slice)
            <li><i style="background:{{ $slice['color'] }}"></i>{{ $slice['label'] }} <strong>{{ $slice['value'] }}</strong></li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="card card-pad">
      <h3 class="card-title">{!! \App\Support\Icon::svg('trendingUp') !!} Pipeline Conversion</h3>
      <p class="card-sub">Volumes at each stage</p>
      <div class="hbar-list">
        @foreach ($pipeline as $stage)
          @php $w = max(6, (int) round(($stage['value'] / $maxPipe) * 100)); @endphp
          <div class="hbar-row">
            <span>{{ $stage['label'] }}</span>
            <div class="hbar-track"><i style="width: {{ $w }}%;"></i></div>
            <strong>{{ number_format($stage['value']) }}</strong>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
