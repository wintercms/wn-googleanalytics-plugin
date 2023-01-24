<?php return [

    /*
    |--------------------------------------------------------------------------
    | Tracking ID
    |--------------------------------------------------------------------------
    |
    | You can find the Tracking ID on the Admin / Property Settings page
    |
    */

    'tracking_id' => env('GA_TRACKING_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Domain Name
    |--------------------------------------------------------------------------
    |
    | Specify the domain name you are going to track
    |
    */

    'domain_name' => env('GA_DOMAIN_NAME', 'auto'),

    /*
    |--------------------------------------------------------------------------
    | Anonymize IP
    |--------------------------------------------------------------------------
    |
    | Activate the IP anonymization for visitors
    |
    */

    'anonymize_ip' => env('GA_ANONYMIZE_IP', false),

    /*
    |--------------------------------------------------------------------------
    | Force SSL
    |--------------------------------------------------------------------------
    |
    | Always use SSL to send data to Google
    |
    */

    'force_ssl' => env('GA_FORCE_SSL', false),

    /*
    |--------------------------------------------------------------------------
    | Track Backend Users
    |--------------------------------------------------------------------------
    |
    | If enabled this will include the tracking logic even when Backend Users
    | are the ones making the request. It is recommended to leave it disabled
    | to avoid polluting your analytics data with internal traffic
    |
    */

    'track_backend_users' => false,

    /*
    |--------------------------------------------------------------------------
    | Track in Maintenance Mode
    |--------------------------------------------------------------------------
    |
    | If enabled this will include the tracking logic even when maintenance
    | mode (either hard with `artisan down` or soft through the backend) is
    | enabled.
    |
    */

    'track_maintenance_mode' => false,

];
