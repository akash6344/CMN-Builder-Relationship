@php
    $img = $property['images'];
@endphp
<div data-preview-host>
    <div data-preview-id="facebook" class="promo-ad-preview is-on">
        <div class="head">
            <div class="avatar">CMN</div>
            <div>
                <strong style="font-size:0.85rem;">CMNHousing</strong>
                <span style="display:block;font-size:0.7rem;color:#64748b;">Sponsored</span>
            </div>
        </div>
        <p style="padding:0 12px 8px;font-size:0.85rem;margin:0;" data-copy-primary>{{ $copy['primaryText'] }}</p>
        <img class="cover" src="{{ $img[0] }}" alt="">
        <div style="padding:10px 12px;background:#f1f5f9;">
            <p style="margin:0;font-size:0.72rem;color:#64748b;text-transform:uppercase;">cmnhousing.in</p>
            <p style="margin:4px 0;font-weight:700;font-size:0.85rem;" data-copy-headline>{{ $copy['headline'] }}</p>
            <p style="margin:0;font-size:0.78rem;color:#64748b;">{{ $property['price'] }} · {{ $property['locality'] }}</p>
            <span class="promo-btn promo-btn-secondary" style="margin-top:8px;padding:6px 10px;font-size:0.75rem;" data-copy-cta>{{ $copy['cta'] }}</span>
        </div>
    </div>

    <div data-preview-id="instagram" class="promo-ad-preview">
        <div class="head">
            <div class="avatar">CMN</div>
            <div><strong style="font-size:0.85rem;">cmnhousing</strong><span style="display:block;font-size:0.7rem;color:#64748b;">Sponsored</span></div>
        </div>
        <img class="cover" src="{{ $img[1] }}" alt="" style="aspect-ratio:1/1;">
        <div class="cta-bar" data-copy-cta>{{ $copy['cta'] }} ›</div>
        <p style="padding:10px 12px;margin:0;font-size:0.82rem;"><strong>cmnhousing</strong> <span data-copy-headline>{{ $copy['headline'] }}</span></p>
    </div>

    <div data-preview-id="youtube" class="promo-ad-preview">
        <div style="position:relative;">
            <img class="cover" src="{{ $img[2] }}" alt="" style="aspect-ratio:16/9;">
            <span style="position:absolute;left:8px;bottom:8px;background:rgb(0 0 0 / 75%);color:#fff;font-size:0.68rem;padding:2px 6px;border-radius:4px;">Ad · 0:22</span>
        </div>
        <table style="width:100%;padding:10px;"><tr><td><div class="avatar">CMN</div></td><td><p style="margin:0;font-size:0.85rem;font-weight:700;" data-copy-headline>{{ $copy['headline'] }}</p><p style="margin:0;font-size:0.72rem;color:#64748b;">CMNHousing · Sponsored</p></td></tr></table>
        <div class="cta-bar" style="color:#1f6b4a;" data-copy-cta>{{ $copy['cta'] }}</div>
    </div>

    <div data-preview-id="google" class="promo-ad-preview" style="padding:14px;">
        <p style="font-size:0.68rem;font-weight:700;color:#64748b;text-transform:uppercase;margin:0;">Ad · cmnhousing.in</p>
        <p style="margin:8px 0 0;color:#1f6b4a;font-weight:700;" data-copy-headline>{{ $copy['headline'] }} | CMNHousing</p>
        <p style="margin:6px 0;font-size:0.82rem;color:#64748b;" data-copy-primary>{{ $copy['primaryText'] }}</p>
        <p style="margin:0;font-size:0.82rem;font-weight:600;" data-copy-cta>{{ $copy['cta'] }}</p>
    </div>

    <div data-preview-id="linkedin" class="promo-ad-preview">
        <div class="head"><div class="avatar">CMN</div><div><strong style="font-size:0.85rem;">CMNHousing</strong><span style="display:block;font-size:0.7rem;color:#64748b;">Promoted</span></div></div>
        <p style="padding:0 12px 8px;font-size:0.82rem;margin:0;" data-copy-primary>{{ $copy['primaryText'] }}</p>
        <img class="cover" src="{{ $img[0] }}" alt="">
        <div style="display:flex;justify-content:space-between;gap:8px;padding:10px 12px;background:#f1f5f9;align-items:center;">
            <p style="margin:0;font-size:0.82rem;font-weight:700;" data-copy-headline>{{ $copy['headline'] }}</p>
            <span style="border:1px solid #1f6b4a;border-radius:999px;padding:4px 10px;font-size:0.72rem;font-weight:700;color:#1f6b4a;" data-copy-cta>{{ $copy['cta'] }}</span>
        </div>
    </div>

    <div data-preview-id="x" class="promo-ad-preview" style="padding:12px;">
        <p style="margin:0 0 8px;font-size:0.82rem;"><strong>CMNHousing</strong> <span style="color:#64748b;">@cmnhousing · Ad</span></p>
        <p style="margin:0 0 8px;font-size:0.82rem;" data-copy-headline>{{ $copy['headline'] }} — {{ $property['price'] }}</p>
        <img src="{{ $img[1] }}" alt="" style="width:100%;border-radius:10px;aspect-ratio:16/9;object-fit:cover;">
        <p style="margin:8px 0 0;"><span class="promo-btn promo-btn-secondary" style="padding:4px 10px;font-size:0.72rem;" data-copy-cta>{{ $copy['cta'] }}</span></p>
    </div>
</div>
