<?php namespace Winter\GoogleAnalytics\Classes;

use Luketowers\GA4EventTracking\Facades\GA4;

class MeasurementProtocolService
{
    /**
     * Send an event to Google Analytics 4 using the Measurement Protocol API
     *
     * @param string $name The name of the event
     * @param array $params Additional parameters for the event
     * @param string|null $clientId The client ID to use, if null it will be read from session or generated
     * @return array Returns an array with status information from the GA4 service
     */
    public function sendEvent(string $name, array $params = [], ?string $clientId = null): array
    {
        if ($clientId === null) {
            $clientId = session('ga4_client_id', uniqid());
        }

        $eventData = [
            'name' => $name,
            'client_id' => $clientId,
        ] + $params;

        return GA4::sendEvent($eventData);
    }
}
