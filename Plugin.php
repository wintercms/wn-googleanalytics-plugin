<?php namespace Winter\GoogleAnalytics;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Google Analytics',
            'description' => 'winter.googleanalytics::lang.strings.plugin_desc',
            'author'      => 'Winter CMS',
            'icon'        => 'icon-bar-chart-o',
            'homepage'    => 'https://github.com/wintercms/wn-googleanalytics-plugin',
            'replaces'    => ['RainLab.GoogleAnalytics' => '<= 1.3.1'],
        ];
    }

    public function registerComponents()
    {
        return [
            '\Winter\GoogleAnalytics\Components\Tracker' => 'googleTracker'
        ];
    }

    public function registerPermissions()
    {
        return [
            'winter.googleanalytics.access_settings' => [
                'tab'   => 'winter.googleanalytics::lang.permissions.tab',
                'label' => 'winter.googleanalytics::lang.permissions.settings'
            ],
            'winter.googleanalytics.view_widgets' => [
                'tab'   => 'winter.googleanalytics::lang.permissions.tab',
                'label' => 'winter.googleanalytics::lang.permissions.widgets'
            ]
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'Winter\GoogleAnalytics\ReportWidgets\TrafficOverview' => [
                'label'       => 'Google Analytics traffic overview',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            'Winter\GoogleAnalytics\ReportWidgets\TrafficSources' => [
                'label'       => 'Google Analytics traffic sources',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            'Winter\GoogleAnalytics\ReportWidgets\Browsers' => [
                'label'       => 'Google Analytics browsers',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            'Winter\GoogleAnalytics\ReportWidgets\TrafficGoal' => [
                'label'       => 'Google Analytics traffic goal',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            'Winter\GoogleAnalytics\ReportWidgets\TopPages' => [
                'label'       => 'Google Analytics top pages',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'Google Analytics',
                'icon'        => 'icon-bar-chart-o',
                'description' => 'winter.googleanalytics::lang.strings.settings_desc',
                'class'       => 'Winter\GoogleAnalytics\Models\Settings',
                'permissions' => ['winter.googleanalytics.access_settings'],
                'order'       => 600
            ]
        ];
    }

    public function boot()
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/vendor/google/apiclient/src');
    }
}
