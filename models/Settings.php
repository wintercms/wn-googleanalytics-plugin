<?php namespace Winter\GoogleAnalytics\Models;

use Config;
use Winter\Storm\Database\Model;

/**
 * Google Analytics settings model
 *
 * @package winter/wn-googleanalytics-plugin
 * @author Alexey Bobkov, Samuel Georges, Winter CMS
 */
class Settings extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'winter_googleanalytics_settings';

    public $settingsFields = 'fields.yaml';

    public $attachOne = [
        'gapi_key' => ['System\Models\File', 'public' => false]
    ];

    /**
     * Validation rules
     */
    public $rules = [
        'gapi_key'   => 'required_with:profile_id',
        'profile_id'   => 'required_with:gapi_key'
    ];

    public function initSettingsData()
    {
        $this->domain_name = Config::get('winter.googleanalytics::domain_name', 'auto');
        $this->anonymize_ip = Config::get('winter.googleanalytics::anonymize_ip', false);
        $this->force_ssl = Config::get('winter.googleanalytics::force_ssl', false);
    }
}