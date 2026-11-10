<?php

namespace App\Support;

class SocialCampaignCatalog
{
    /**
     * @return array<string, mixed>
     */
    public static function sampleProperty(array $overrides = []): array
    {
        $base = [
            'title' => 'Green Valley Residences — Phase 2',
            'type' => 'Gated Community',
            'locality' => 'Kokapet',
            'city' => 'Hyderabad',
            'price' => 'From ₹1.13 Cr',
            'beds' => 3,
            'baths' => 3,
            'area' => '2,100–3,400 sq.ft.',
            'images' => [
                asset('images/promotion/property-villa.jpg'),
                asset('images/promotion/property-living.jpg'),
                asset('images/promotion/property-bedroom.jpg'),
            ],
            'description' => 'Promote your builder project with platform-ready creatives. CMNHousing reuses project photos, RERA details, unit mix, and location for every channel.',
        ];

        return array_replace($base, $overrides);
    }

    public static function adCopy(array $property): array
    {
        return [
            'headline' => sprintf('%s in %s', $property['title'], $property['locality']),
            'primaryText' => $property['description'],
            'cta' => 'Enquire Now',
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function platforms(): array
    {
        return [
            ['id' => 'facebook', 'name' => 'Facebook', 'blurb' => 'Local + targeted buyers', 'tone' => '#1877F2'],
            ['id' => 'instagram', 'name' => 'Instagram', 'blurb' => 'Property photos & reels', 'tone' => '#E1306C'],
            ['id' => 'youtube', 'name' => 'YouTube', 'blurb' => 'Property video campaigns', 'tone' => '#FF0000'],
            ['id' => 'linkedin', 'name' => 'LinkedIn', 'blurb' => 'Investors, NRI & professionals', 'tone' => '#0A66C2'],
            ['id' => 'google', 'name' => 'Google Ads', 'blurb' => 'High-intent property searches', 'tone' => '#34A853'],
            ['id' => 'x', 'name' => 'X', 'blurb' => 'Additional reach', 'tone' => '#111111'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function objectives(): array
    {
        return [
            ['id' => 'awareness', 'icon' => '🏠', 'name' => 'Property Awareness', 'blurb' => 'Get maximum visibility', 'recommended' => false],
            ['id' => 'leads', 'icon' => '👥', 'name' => 'Lead Generation', 'blurb' => 'Generate buyer/tenant enquiries', 'recommended' => true],
            ['id' => 'video', 'icon' => '🎥', 'name' => 'Video Showcase', 'blurb' => 'Promote property videos/reels', 'recommended' => false],
            ['id' => 'premium', 'icon' => '💎', 'name' => 'Premium Property Promotion', 'blurb' => 'Maximum exposure across CMNHousing + social', 'recommended' => false],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function creatives(): array
    {
        return [
            ['id' => 'single', 'name' => 'Single Image', 'blurb' => 'Property photo + details', 'recommended' => false],
            ['id' => 'carousel', 'name' => 'Carousel', 'blurb' => '5–10 property photos', 'recommended' => true],
            ['id' => 'reel', 'name' => 'Video / Reel', 'blurb' => '15–30 second property promotion', 'recommended' => false],
            ['id' => 'ai', 'name' => 'AI Property Video', 'blurb' => 'CMNHousing creates the promo video for you', 'recommended' => false],
        ];
    }

    /**
     * @return list<string>
     */
    public static function ctaOptions(): array
    {
        return [
            'View Property', 'Enquire Now', 'WhatsApp', 'Call Now', 'Schedule Visit', 'Get Price', 'Book Site Visit',
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function durations(): array
    {
        return [
            ['id' => '7', 'days' => 7, 'label' => '7 Days', 'from' => 1000, 'recommended' => false],
            ['id' => '15', 'days' => 15, 'label' => '15 Days', 'from' => 2500, 'recommended' => true],
            ['id' => '30', 'days' => 30, 'label' => '30 Days', 'from' => 5000, 'recommended' => false],
            ['id' => 'custom', 'days' => 45, 'label' => 'Custom', 'from' => 7500, 'recommended' => false],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function packages(): array
    {
        return [
            [
                'id' => 'boost',
                'name' => 'CMNHousing Social Boost',
                'price' => '₹2,500',
                'period' => '15 Days',
                'amount' => 2500,
                'recommended' => false,
                'features' => ['Facebook', 'Instagram', 'AI ad creative', 'Audience targeting', 'Lead generation', 'WhatsApp enquiries', 'Campaign monitoring', 'Performance dashboard'],
            ],
            [
                'id' => 'pro',
                'name' => 'CMNHousing Social Pro',
                'price' => '₹5,000',
                'period' => '30 Days',
                'amount' => 5000,
                'recommended' => true,
                'features' => ['Everything in Social Boost', 'YouTube', 'Video / Reel', 'Retargeting', 'Advanced audience', 'Campaign optimization'],
            ],
            [
                'id' => 'max',
                'name' => 'CMNHousing Growth Max',
                'price' => 'Custom',
                'period' => 'Tailored',
                'amount' => 12000,
                'recommended' => false,
                'features' => ['Social Media', 'Google Ads', 'CMNHousing Premium', 'Retargeting', 'AI creative', 'Lead management'],
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function promotionOptions(): array
    {
        return [
            ['id' => 'social', 'name' => 'Social Media Ads', 'blurb' => 'Facebook, Instagram, YouTube and more', 'recommended' => true, 'primary' => true],
            ['id' => 'premium', 'name' => 'CMNHousing Premium', 'blurb' => 'Homepage & search visibility', 'recommended' => true, 'primary' => false],
            ['id' => 'google', 'name' => 'Google Ads', 'blurb' => 'Search-driven buyers', 'recommended' => false, 'primary' => false],
            ['id' => 'growth', 'name' => 'Complete Growth Campaign', 'blurb' => 'Social + Google + CMNHousing', 'recommended' => true, 'primary' => false],
        ];
    }

    /**
     * @return array{reach: string, clicks: string, leads: string}
     */
    public static function estimates(int $budget): array
    {
        $reachLow = (int) (round(($budget * 4) / 1000) * 1000);
        $reachHigh = (int) (round(($budget * 10) / 1000) * 1000);

        return [
            'reach' => self::fmtK($reachLow).'–'.self::fmtK($reachHigh),
            'clicks' => self::fmtK((int) round($budget * 0.12)).'–'.self::fmtK((int) round($budget * 0.35)),
            'leads' => (string) max(5, (int) round($budget * 0.005)).'–'.(string) (int) round($budget * 0.018),
        ];
    }

    public static function inr(int $amount): string
    {
        return '₹'.number_format($amount, 0, '.', ',');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function demoCampaigns(array $property): array
    {
        return [
            [
                'id' => 'CMN-SM-2026-000201',
                'title' => $property['title'],
                'place' => $property['locality'].', '.$property['city'],
                'platforms' => ['Facebook', 'Instagram', 'YouTube'],
                'budget' => 5000,
                'days' => 15,
                'progress' => 72,
                'views' => 28450,
                'clicks' => 1240,
                'leads' => 96,
                'image' => $property['images'][0],
                'status' => 'Active',
            ],
            [
                'id' => 'CMN-SM-2026-000195',
                'title' => 'Skyline Towers',
                'place' => 'Gachibowli, Hyderabad',
                'platforms' => ['Facebook', 'Instagram'],
                'budget' => 2500,
                'days' => 15,
                'progress' => 40,
                'views' => 14210,
                'clicks' => 620,
                'leads' => 41,
                'image' => $property['images'][1],
                'status' => 'Active',
            ],
            [
                'id' => 'CMN-SM-2026-000188',
                'title' => 'Lakeview Enclave',
                'place' => 'Jubilee Hills, Hyderabad',
                'platforms' => ['Instagram', 'YouTube', 'LinkedIn'],
                'budget' => 11250,
                'days' => 30,
                'progress' => 88,
                'views' => 82800,
                'clicks' => 3110,
                'leads' => 350,
                'image' => $property['images'][2],
                'status' => 'Active',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function campaignKpis(): array
    {
        return [
            'active' => '3',
            'spend' => self::inr(18750),
            'views' => '125,460',
            'engagements' => '2,340',
            'leads' => '487',
        ];
    }

    private static function fmtK(int $n): string
    {
        if ($n >= 1000) {
            $v = $n / 1000;

            return ($n % 1000 === 0 ? number_format($v, 0) : number_format($v, 1)).'K';
        }

        return (string) $n;
    }
}
