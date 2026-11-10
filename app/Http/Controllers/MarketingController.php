<?php

namespace App\Http\Controllers;

use App\Support\SocialCampaignCatalog;
use Illuminate\View\View;

class MarketingController extends Controller
{
    public function campaigns(): View
    {
        $property = SocialCampaignCatalog::sampleProperty();

        return view('promotion.campaigns', [
            'active' => 'marketing',
            'pageTitle' => 'Marketing',
            'pageSub' => 'Social media campaigns for builder projects',
            'property' => $property,
            'kpis' => SocialCampaignCatalog::campaignKpis(),
            'campaigns' => SocialCampaignCatalog::demoCampaigns($property),
            'wizardUrl' => route('marketing.wizard'),
            'promoteUrl' => route('marketing.promote'),
        ]);
    }

    public function landing(): View
    {
        $property = SocialCampaignCatalog::sampleProperty();

        return view('promotion.landing', [
            'active' => 'marketing',
            'pageTitle' => 'Promote Project',
            'pageSub' => 'Launch social campaigns for builder inventory',
            'property' => $property,
            'promotionOptions' => SocialCampaignCatalog::promotionOptions(),
            'wizardUrl' => route('marketing.wizard'),
            'campaignsUrl' => route('marketing.index'),
        ]);
    }

    public function wizard(): View
    {
        $property = SocialCampaignCatalog::sampleProperty();
        $copy = SocialCampaignCatalog::adCopy($property);

        return view('promotion.wizard', [
            'active' => 'marketing',
            'pageTitle' => 'Campaign Wizard',
            'pageSub' => 'Multi-platform ad builder',
            'property' => $property,
            'copy' => $copy,
            'platforms' => SocialCampaignCatalog::platforms(),
            'objectives' => SocialCampaignCatalog::objectives(),
            'creatives' => SocialCampaignCatalog::creatives(),
            'ctaOptions' => SocialCampaignCatalog::ctaOptions(),
            'durations' => SocialCampaignCatalog::durations(),
            'packages' => SocialCampaignCatalog::packages(),
            'campaignsUrl' => route('marketing.index'),
            'backUrl' => route('marketing.promote'),
        ]);
    }
}
