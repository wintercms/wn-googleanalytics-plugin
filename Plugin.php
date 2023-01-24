<?php namespace Winter\GoogleAnalytics;

use Backend\Models\UserRole;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
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

    public function registerComponents(): array
    {
        return [
            \Winter\GoogleAnalytics\Components\Tracker::class => 'googleTracker'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'winter.googleanalytics.access_settings' => [
                'tab'   => 'winter.googleanalytics::lang.permissions.tab',
                'label' => 'winter.googleanalytics::lang.permissions.settings',
                'roles' => [UserRole::CODE_DEVELOPER],
            ],
            'winter.googleanalytics.view_widgets' => [
                'tab'   => 'winter.googleanalytics::lang.permissions.tab',
                'label' => 'winter.googleanalytics::lang.permissions.widgets',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ]
        ];
    }

    public function registerReportWidgets(): array
    {
        return [
            \Winter\GoogleAnalytics\ReportWidgets\TrafficOverview::class => [
                'label'       => 'Google Analytics traffic overview',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            \Winter\GoogleAnalytics\ReportWidgets\TrafficSources::class => [
                'label'       => 'Google Analytics traffic sources',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            \Winter\GoogleAnalytics\ReportWidgets\Browsers::class => [
                'label'       => 'Google Analytics browsers',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            \Winter\GoogleAnalytics\ReportWidgets\TrafficGoal::class => [
                'label'       => 'Google Analytics traffic goal',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ],
            \Winter\GoogleAnalytics\ReportWidgets\TopPages::class => [
                'label'       => 'Google Analytics top pages',
                'context'     => 'dashboard',
                'permissions' => ['winter.googleanalytics.view_widgets']
            ]
        ];
    }

    public function registerSettings(): array
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
}
