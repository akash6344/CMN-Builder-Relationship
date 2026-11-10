@extends('layouts.app')

@php
  $active = $active ?? 'marketing';
@endphp

@section('content')
<div class="promotion-scope">
    <span class="promo-hero-badge"><i class="fas fa-check"></i> Listing verified · Promote Property</span>
    <h1 class="promo-title">Your project is ready to promote</h1>
    <p class="promo-sub">Reach more buyers and investors with CMNHousing campaigns. We reuse project photos, pricing, RERA details, and unit mix across every channel.</p>

    <div style="max-width:640px;margin:18px 0;">
        @include('promotion.partials.property-card', ['property' => $property])
    </div>

    <div class="promo-actions">
        <a href="{{ $wizardUrl }}" class="promo-btn promo-btn-primary">Promote project <i class="fas fa-arrow-right"></i></a>
        <a href="{{ $campaignsUrl }}" class="promo-btn promo-btn-secondary">My campaigns</a>
    </div>

    <h2 style="margin:32px 0 12px;font-size:1.25rem;">Choose how you want to promote</h2>
    <div class="promotion-options">
        @foreach ($promotionOptions as $option)
            <button type="button" class="promotion-option {{ !empty($option['primary']) ? 'primary' : '' }}" onclick="window.location.href='{{ $wizardUrl }}'">
                <h3>
                    {{ $option['name'] }}
                    @if (!empty($option['recommended']))
                        <span class="promo-tag">Recommended</span>
                    @endif
                </h3>
                <p>{{ $option['blurb'] }}</p>
            </button>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/promotion.css') }}">
@endpush
