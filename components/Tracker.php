<?php namespace Winter\GoogleAnalytics\Components;

use BackendAuth;
use Config;
use Cms\Classes\ComponentBase;
use Cms\Models\MaintenanceSetting;
use Winter\GoogleAnalytics\Models\Settings;

class Tracker extends ComponentBase
{
    /**
     * @var bool Flag for the current state of the tracker component
     */
    public $enabled = true;

    public function componentDetails()
    {
        return [
            'name'        => 'winter.googleanalytics::lang.strings.tracker',
            'description' => 'winter.googleanalytics::lang.strings.tracker_desc'
        ];
    }

    public function onRun(): void
    {
        // Disable the tracker when no tracking ID is set
        if (empty($this->trackingId())) {
            $this->enabled = false;
        }

        // Disable the tracker when authenticated backend users are detected
        if (
            !Config::get('winter.googleanalytics::track_backend_users', false)
            && BackendAuth::getUser()
        ) {
            $this->enabled = false;
        }

        // Disable the tracker when in maintenance mode
        if (
            !Config::get('winter.googleanalytics::track_maintenance_mode', false)
            && $this->isMaintenanceModeEnabled()
            // && (
            //     app()->maintenanceMode()->active()
            //     || $this->isMaintenanceModeEnabled()
            // )
        ) {
            $this->enabled = false;
        }
    }

    /**
     * isMaintenanceModeEnabled will check if maintenance mode is currently enabled.
     * Static page logic should be disabled when this occurs.
     */
    protected function isMaintenanceModeEnabled(): bool
    {
        return MaintenanceSetting::isConfigured() &&
            MaintenanceSetting::get('is_enabled', false) &&
            !BackendAuth::getUser();
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
