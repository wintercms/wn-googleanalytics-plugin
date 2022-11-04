<?php namespace Winter\GoogleAnalytics\Components;

use Cms\Classes\ComponentBase;
use Winter\GoogleAnalytics\Models\Settings;

class Measurement extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'winter.googleanalytics::lang.strings.measurement',
            'description' => 'winter.googleanalytics::lang.strings.measurement_desc'
        ];
    }

    public function onRender()
    {
        $this->page['clientId'] = null;
    }
}
