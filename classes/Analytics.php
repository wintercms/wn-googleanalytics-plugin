<?php namespace Winter\GoogleAnalytics\Classes;

use App;
use ApplicationException;
use Google\Client;
use Google\Service\AnalyticsData;
use Winter\GoogleAnalytics\Models\Settings;

class Analytics
{
    use \Winter\Storm\Support\Traits\Singleton;

    /**
     * @var \Google\Client Google API client
     */
    public $client;

    /**
     * @var \Google\Service\AnalyticsData Google API analytics service
     */
    public $service;

    /**
     * @var string Google Analytics View ID
     */
    public $viewId;

    protected function init()
    {
        $settings = Settings::instance();
        if (!strlen($settings->profile_id)) {
            throw new ApplicationException(trans('winter.googleanalytics::lang.strings.notconfigured'));
        }

        if (!$settings->gapi_key) {
            throw new ApplicationException(trans('winter.googleanalytics::lang.strings.keynotuploaded'));
        }

        $client = new Client();

        /*
         * Set caching
         */
        $cache = App::make(CacheItemPool::class);
        $client->setCache($cache);

        /*
         * Set assertion credentials
         */
        $auth = json_decode($settings->gapi_key->getContents(), true);
        $client->setAuthConfig($auth);
        $client->addScope(AnalyticsData::ANALYTICS_READONLY);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithAssertion();
        }

        $this->client = $client;
        $this->service = new AnalyticsData($client);
        $this->viewId = 'properties/' . $settings->profile_id;
    }
}
