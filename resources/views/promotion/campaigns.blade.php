@extends('layouts.app')

@php
  $active = $active ?? 'marketing';
@endphp

@section('content')
<div class="promotion-scope">
    <div style="display:flex;flex-wrap:wrap;justify-content:space-between;gap:12px;align-items:center;margin-bottom:8px;">
        <div>
            <h1 class="promo-title" style="margin-top:0;">Social media campaigns</h1>
            <p class="promo-sub" style="margin:0;">Track spend, views, engagements and leads for every property campaign.</p>
        </div>
        <a href="{{ $wizardUrl }}" class="promo-btn promo-btn-primary">New campaign <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="promo-kpi-grid">
        <div class="promo-kpi"><strong>{{ $kpis['active'] }}</strong><span>Active campaigns</span></div>
        <div class="promo-kpi"><strong>{{ $kpis['spend'] }}</strong><span>Total spend</span></div>
        <div class="promo-kpi"><strong>{{ $kpis['views'] }}</strong><span>Views</span></div>
        <div class="promo-kpi"><strong>{{ $kpis['engagements'] }}</strong><span>Engagements</span></div>
        <div class="promo-kpi"><strong>{{ $kpis['leads'] }}</strong><span>Leads</span></div>
    </div>

    <div style="display:grid;gap:16px;">
        @foreach ($campaigns as $campaign)
            <article class="promo-campaign-card">
                <img src="{{ $campaign['image'] }}" alt="{{ $campaign['title'] }}">
                <div class="promo-campaign-body">
                    <div style="display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;">
                        <div>
                            <h2 style="margin:0;font-size:1.05rem;">{{ $campaign['title'] }}</h2>
                            <p style="margin:4px 0 0;color:#64748b;font-size:0.85rem;">{{ $campaign['place'] }}</p>
                        </div>
                        <span class="promo-chip">{{ $campaign['status'] }}</span>
                    </div>
                    <p style="margin:10px 0 0;">
                        @foreach ($campaign['platforms'] as $platform)
                            <span class="promo-platform-pill">{{ $platform }}</span>
                        @endforeach
                    </p>
                    <p style="margin:10px 0 0;font-size:0.85rem;color:#64748b;">
                        {{ \App\Support\SocialCampaignCatalog::inr($campaign['budget']) }} · {{ $campaign['days'] }} Days
                    </p>
                    <div class="promo-progress"><span style="width:{{ $campaign['progress'] }}%"></span></div>
                    <p style="margin:6px 0 0;font-size:0.75rem;color:#64748b;">{{ $campaign['progress'] }}% delivered</p>
                    <div class="promo-metrics">
                        <div class="promo-stat"><strong>{{ number_format($campaign['views']) }}</strong><span>Views</span></div>
                        <div class="promo-stat"><strong>{{ number_format($campaign['clicks']) }}</strong><span>Clicks</span></div>
                        <div class="promo-stat"><strong>{{ $campaign['leads'] }}</strong><span>Leads</span></div>
                    </div>
                    <div class="promo-actions" style="margin-top:12px;">
                        <button type="button" class="promo-btn promo-btn-secondary" data-toast-trigger>View campaign</button>
                        <button type="button" class="promo-btn promo-btn-primary" data-toast-trigger>Optimize</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/promotion.css') }}">
@endpush

@push('scripts')
<script>
document.querySelectorAll('[data-toast-trigger]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.textContent = 'Campaign tools will connect to live ad accounts in a future sprint.';
    toast.hidden = false;
    setTimeout(() => { toast.hidden = true; }, 3200);
  });
});
</script>
@endpush
