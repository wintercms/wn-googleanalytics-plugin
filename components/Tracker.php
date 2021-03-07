<?php namespace Winter\GoogleAnalytics\Components;

use Cms\Classes\ComponentBase;
use Winter\GoogleAnalytics\Models\Settings;

class Tracker extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'winter.googleanalytics::lang.strings.tracker',
            'description' => 'winter.googleanalytics::lang.strings.tracker_desc'
        ];
    }

    public function trackingId()
    {
        return Settings::get('tracking_id');
    }

    public function domainName()
    {
        return Settings::get('domain_name');
    }

    public function anonymizeIp()
    {
        return Settings::get('anonymize_ip');
    }

    public function forceSSL()
    {
        return Settings::get('force_ssl');
    }
}
