<?php

use Winter\Storm\Support\ClassLoader;

/**
 * To allow compatibility with plugins that extend the original RainLab.GoogleAnalytics plugin, this will alias those classes to
 * use the new Winter.GoogleAnalytics classes.
 */
$aliases = [
    // Regular aliases
    Winter\GoogleAnalytics\Plugin::class                        => 'RainLab\GoogleAnalytics\Plugin',
    Winter\GoogleAnalytics\Classes\CacheItem::class             => 'RainLab\GoogleAnalytics\Classes\CacheItem',
    Winter\GoogleAnalytics\Classes\CacheItemPool::class         => 'RainLab\GoogleAnalytics\Classes\CacheItemPool',
    Winter\GoogleAnalytics\Classes\Analytics::class             => 'RainLab\GoogleAnalytics\Classes\Analytics',
    Winter\GoogleAnalytics\Components\Tracker::class            => 'RainLab\GoogleAnalytics\Components\Tracker',
    Winter\GoogleAnalytics\Models\Settings::class               => 'RainLab\GoogleAnalytics\Models\Settings',
    Winter\GoogleAnalytics\ReportWidgets\TrafficGoal::class     => 'RainLab\GoogleAnalytics\ReportWidgets\TrafficGoal',
    Winter\GoogleAnalytics\ReportWidgets\TopPages::class        => 'RainLab\GoogleAnalytics\ReportWidgets\TopPages',
    Winter\GoogleAnalytics\ReportWidgets\TrafficOverview::class => 'RainLab\GoogleAnalytics\ReportWidgets\TrafficOverview',
    Winter\GoogleAnalytics\ReportWidgets\Browsers::class        => 'RainLab\GoogleAnalytics\ReportWidgets\Browsers',
    Winter\GoogleAnalytics\ReportWidgets\TrafficSources::class  => 'RainLab\GoogleAnalytics\ReportWidgets\TrafficSources',
];

app(ClassLoader::class)->addAliases($aliases);
