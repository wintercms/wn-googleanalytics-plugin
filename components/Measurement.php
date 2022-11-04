<?php

namespace Winter\GoogleAnalytics\Components;

use Session;
use Cms\Classes\ComponentBase;
use Winter\GoogleAnalytics\Models\Settings;

/**
 * Add measurement capabilities to a page.
 *
 * @author Ben Thomson <git@alfreido.com>
 */
class Measurement extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'winter.googleanalytics::lang.strings.measurement',
            'description' => 'winter.googleanalytics::lang.strings.measurement_desc'
        ];
    }

    public function onRender(): void
    {
        $this->addJs('components/measurement/assets/js/Measurement.js');
        $this->page['clientId'] = $this->clientId();
    }

    /**
     * Returns the currently stored client ID for Google Analytics tracking.
     */
    public function clientId(): ?string
    {
        $clientId = null;

        if (Session::has('winter.googleanalytics.clientId')) {
            $clientId = Session::get('winter.googleanalytics.clientId');
        }

        return $clientId;
    }

    /**
     * Returns the measurement ID.
     */
    public function measurementId()
    {
        return Settings::get('measurement_id');
    }

    /**
     * Stores a client ID, retrieved from the client side.
     */
    public function onStoreClientId(): void
    {
        $clientId = post('clientId');

        if ($clientId) {
            Session::put('winter.googleanalytics.clientId', $clientId);
        }
    }
}
