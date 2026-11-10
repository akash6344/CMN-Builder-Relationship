@extends('layouts.app')

@php
  $active = $active ?? 'marketing';
@endphp

@section('content')
@php
    $initialEst = \App\Support\SocialCampaignCatalog::estimates(5000);
@endphp
<div class="promotion-scope promo-wizard" id="promotion-wizard" style="padding-bottom:88px;">
    <div class="promo-wizard-sticky">
        <p class="promo-step-label" data-promo-step-label>Step 1 of 7 · Platforms</p>
        <div class="promo-wizard-progress"><span data-promo-progress style="width:14.28%;"></span></div>
    </div>

    <div style="max-width:760px;margin:0 0 18px;">
        @include('promotion.partials.property-card', ['property' => $property])
    </div>

    <section class="promo-step is-active" data-promo-step="0">
        <h2>Select platforms</h2>
        <p>Your listing is reused automatically on every platform you pick.</p>
        <div class="promo-grid cols-3">
            @foreach ($platforms as $platform)
                <button type="button" class="promo-selectable {{ in_array($platform['id'], ['facebook','instagram','youtube'], true) ? 'is-on' : '' }}" data-platform-id="{{ $platform['id'] }}">
                    <span class="promo-check">✓</span>
                    <span class="promo-platform-tone" style="background:{{ $platform['tone'] }};"></span>
                    <h4>{{ $platform['name'] }}</h4>
                    <p>{{ $platform['blurb'] }}</p>
                </button>
            @endforeach
        </div>
        <p style="margin-top:12px;color:#1f6b4a;font-weight:700;font-size:0.88rem;" data-platform-count>3 platforms selected</p>
    </section>

    <section class="promo-step" data-promo-step="1">
        <h2>What do you want to achieve?</h2>
        <p>Pick your campaign objective.</p>
        <div class="promo-grid cols-2">
            @foreach ($objectives as $objectiveItem)
                <button type="button" class="promo-selectable {{ $objectiveItem['id'] === 'leads' ? 'is-on' : '' }}" data-objective-id="{{ $objectiveItem['id'] }}">
                    <span class="promo-check">✓</span>
                    <h4>{{ $objectiveItem['icon'] }} {{ $objectiveItem['name'] }} @if($objectiveItem['recommended'])<span class="promo-tag">Recommended</span>@endif</h4>
                    <p>{{ $objectiveItem['blurb'] }}</p>
                </button>
            @endforeach
        </div>
    </section>

    <section class="promo-step" data-promo-step="2">
        <h2>Your ad creative</h2>
        <p>Generated from your listing — edit only if you want to.</p>
        <div class="promo-grid cols-4">
            @foreach ($creatives as $creativeItem)
                <button type="button" class="promo-selectable {{ in_array($creativeItem['id'], ['carousel','reel'], true) ? 'is-on' : '' }}" data-creative-id="{{ $creativeItem['id'] }}">
                    <span class="promo-check">✓</span>
                    <h4>{{ $creativeItem['name'] }} @if($creativeItem['recommended'])<span class="promo-tag">Recommended</span>@endif</h4>
                    <p>{{ $creativeItem['blurb'] }}</p>
                </button>
            @endforeach
        </div>
        <div class="promo-split two-col" style="margin-top:20px;">
            <div class="promo-surface">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                    <h3 style="margin:0;">Ad content</h3>
                    <button type="button" class="promo-btn promo-btn-secondary" data-edit-toggle style="padding:6px 10px;font-size:0.82rem;"><i class="fas fa-pen"></i> Edit Ad Content</button>
                </div>
                <p class="promo-field-label">Ad headline</p>
                <p data-headline-view>{{ $copy['headline'] }}</p>
                <input data-headline-input class="form-control" hidden value="{{ $copy['headline'] }}">
                <p class="promo-field-label" style="margin-top:12px;">Primary text</p>
                <p data-primary-view style="color:#64748b;">{{ $copy['primaryText'] }}</p>
                <textarea data-primary-input hidden rows="3" class="form-control">{{ $copy['primaryText'] }}</textarea>
                <p class="promo-field-label" style="margin-top:12px;">Call to action</p>
                <div style="display:flex;flex-wrap:gap:6px;">
                    @foreach ($ctaOptions as $cta)
                        <button type="button" class="promo-btn promo-btn-secondary {{ $cta === $copy['cta'] ? 'is-on' : '' }}" data-cta-option="{{ $cta }}" style="padding:5px 10px;font-size:0.78rem;border-radius:999px;">{{ $cta }}</button>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="promo-preview-tabs" data-preview-tabs></div>
                @include('promotion.partials.ad-previews', ['property' => $property, 'copy' => $copy])
                <p style="margin-top:8px;font-size:0.75rem;color:#64748b;text-align:center;">Live mockup built from your listing photos and details.</p>
            </div>
        </div>
    </section>

    <section class="promo-step" data-promo-step="3">
        <h2>Target audience</h2>
        <p>Let us do it for you, or fine-tune yourself.</p>
        <button type="button" class="promo-selectable is-on" data-smart-audience="true" style="width:100%;">
            <h4>🤖 CMNHousing Smart Targeting</h4>
            <p>We'll automatically select the audience most likely to enquire about your property.</p>
        </button>
        <button type="button" class="promo-selectable" data-smart-audience="false" style="width:100%;margin-top:10px;">
            <h4>Set it myself</h4>
            <p>Choose location, buyer type, property interest, price and age.</p>
        </button>
        <div data-custom-audience hidden class="promo-grid cols-2" style="margin-top:14px;">
            <div class="promo-surface">
                <h4 style="margin:0;">Location</h4>
                <p data-radius-label style="color:#64748b;font-size:0.85rem;">{{ $property['city'] }} · 25 km radius</p>
                <input type="range" min="5" max="100" step="5" value="25" data-radius-input style="width:100%;margin-top:8px;">
            </div>
            <div class="promo-surface">
                <h4 style="margin:0;">Age</h4>
                <p data-age-label style="color:#64748b;font-size:0.85rem;">25 – 55 years</p>
                <input type="range" min="30" max="70" value="55" data-age-input style="width:100%;margin-top:8px;">
            </div>
            <div class="promo-surface">
                <h4>Buyer type</h4>
                @foreach (['Home Buyers', 'Investors', 'Tenants', 'NRI Buyers'] as $buyer)
                    <button type="button" class="promo-selectable {{ in_array($buyer, ['Home Buyers','Investors','NRI Buyers'], true) ? 'is-on' : '' }}" data-buyer-type="{{ $buyer }}" style="width:100%;margin-top:6px;padding:8px 10px;">{{ $buyer }}</button>
                @endforeach
            </div>
            <div class="promo-surface">
                <h4>Property interest</h4>
                @foreach (['Villas', 'Apartments', 'Plots', 'Luxury Properties'] as $interest)
                    <button type="button" class="promo-selectable {{ in_array($interest, ['Villas','Luxury Properties'], true) ? 'is-on' : '' }}" data-interest="{{ $interest }}" style="width:100%;margin-top:6px;padding:8px 10px;">{{ $interest }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="promo-step" data-promo-step="4">
        <h2>Budget & duration</h2>
        <p>Pick a package or set your own budget.</p>
        <div class="promo-grid cols-4">
            @foreach ($durations as $durationItem)
                <button type="button" class="promo-selectable {{ $durationItem['id'] === '15' ? 'is-on' : '' }}" data-duration-id="{{ $durationItem['id'] }}">
                    <h4>{{ $durationItem['label'] }} @if($durationItem['recommended'])<span class="promo-tag">Recommended</span>@endif</h4>
                    <p>{{ \App\Support\SocialCampaignCatalog::inr($durationItem['from']) }}+</p>
                </button>
            @endforeach
        </div>
        <div class="promo-split two-col" style="margin-top:16px;">
            <div class="promo-surface">
                <label for="budget" class="promo-field-label">Advertising budget</label>
                <div style="display:flex;align-items:center;gap:6px;border:1px solid #e2e8f0;border-radius:12px;padding:8px 12px;">
                    <span style="font-size:1.1rem;">₹</span>
                    <input id="budget" type="number" min="1000" step="500" value="5000" data-budget-input style="border:none;width:100%;font-size:1.1rem;font-weight:700;outline:none;">
                </div>
                <div class="promo-stat-grid">
                    <div class="promo-stat"><strong data-est-reach>{{ $initialEst['reach'] }}</strong><span>Est. reach</span></div>
                    <div class="promo-stat"><strong data-est-clicks>{{ $initialEst['clicks'] }}</strong><span>Est. clicks</span></div>
                    <div class="promo-stat"><strong data-est-leads>{{ $initialEst['leads'] }}</strong><span>Est. leads</span></div>
                </div>
                <p style="font-size:0.68rem;color:#64748b;margin-top:8px;text-transform:uppercase;letter-spacing:0.05em;">*Estimates only — not guaranteed results</p>
            </div>
            <div style="display:grid;gap:10px;">
                @foreach ($packages as $package)
                    <button type="button" class="promo-selectable {{ $package['id'] === 'pro' ? 'is-on' : '' }}" data-package-id="{{ $package['id'] }}" data-package-amount="{{ $package['amount'] }}">
                        <h4>{{ $package['name'] }} @if($package['recommended'])<span class="promo-tag">Recommended</span>@endif</h4>
                        <p>{{ $package['price'] }} / {{ $package['period'] }}</p>
                        <ul style="margin:8px 0 0;padding-left:0;list-style:none;font-size:0.8rem;color:#64748b;">
                            @foreach ($package['features'] as $feature)
                                <li>✓ {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="promo-step" data-promo-step="5">
        <h2>Your campaign</h2>
        <p>Check everything before payment.</p>
        <div class="promo-split two-col">
            <div class="promo-surface" data-review-rows>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;"><span style="color:#64748b;">Platforms</span><strong data-review="platforms">Facebook + Instagram + YouTube</strong></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;"><span style="color:#64748b;">Objective</span><strong data-review="objective">Lead Generation</strong></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;"><span style="color:#64748b;">Creative</span><strong data-review="creative">Carousel + Video / Reel</strong></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;"><span style="color:#64748b;">Audience</span><strong data-review="audience">CMNHousing Smart Targeting</strong></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;"><span style="color:#64748b;">Duration</span><strong data-review="duration">15 Days</strong></div>
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e2e8f0;"><span style="color:#64748b;">Budget</span><strong data-review="budget">₹5,000</strong></div>
                <p style="margin:14px 0 0;color:#64748b;font-size:0.85rem;">Estimated campaign reach</p>
                <p style="margin:4px 0;font-size:1.8rem;font-weight:800;color:#1f6b4a;" data-review="reach">{{ $initialEst['reach'] }} people</p>
            </div>
            <div>
                <div class="promo-preview-tabs" data-preview-tabs></div>
                @include('promotion.partials.ad-previews', ['property' => $property, 'copy' => $copy])
            </div>
        </div>
    </section>

    <section class="promo-step" data-promo-step="6">
        <div class="promo-success-screen">
            <p style="font-size:2.6rem;margin:0;">🟢</p>
            <h2>Campaign submitted</h2>
            <p style="color:#64748b;">Payment of <strong data-paid-amount>₹5,000</strong> received. Nothing else is needed from you right now.</p>
            <div class="promo-surface" style="margin-top:18px;text-align:left;">
                <div style="display:flex;justify-content:space-between;padding:6px 0;"><span style="color:#64748b;">Campaign ID</span><strong data-campaign-id>CMN-SM-2026-000123</strong></div>
                <div style="display:flex;justify-content:space-between;padding:6px 0;"><span style="color:#64748b;">Status</span><strong>Under Review</strong></div>
            </div>
            <a href="{{ $campaignsUrl }}" class="promo-btn promo-btn-primary" style="margin-top:16px;">Go to campaign dashboard <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>
</div>

<div class="promo-footer-bar" data-promo-footer>
    <div class="promo-footer-inner">
        <button type="button" class="promo-btn promo-btn-secondary" data-promo-back><i class="fas fa-arrow-left"></i> Back</button>
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:0.85rem;color:#64748b;" data-total-wrap>Total <strong data-total-label>₹5,000</strong></span>
            <button type="button" class="promo-btn promo-btn-primary" data-promo-continue>Continue <i class="fas fa-arrow-right"></i></button>
        </div>
    </div>
</div>

<script type="application/json" id="promotion-config">@json([
    'copy' => $copy,
    'property' => $property,
    'platforms' => $platforms,
    'objectives' => $objectives,
    'creatives' => $creatives,
    'durations' => $durations,
    'backUrl' => $backUrl,
    'campaignId' => 'CMN-SM-2026-000123',
])</script>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/promotion.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/promotion-wizard.js') }}"></script>
@endpush
