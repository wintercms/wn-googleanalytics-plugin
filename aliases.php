<?php

use Winter\Storm\Support\ClassLoader;

/**
 * To allow compatibility with plugins that extend the original RainLab.GoogleAnalytics plugin, this will alias those classes to
 * use the new Winter.GoogleAnalytics classes.
 */
$aliases = [
    // Regular aliases
    Winter\GoogleAnalytics\Plugin::class                        => RainLab\GoogleAnalytics\Plugin::class,
    Winter\GoogleAnalytics\Classes\CacheItem::class             => RainLab\GoogleAnalytics\Classes\CacheItem::class,
    Winter\GoogleAnalytics\Classes\CacheItemPool::class         => RainLab\GoogleAnalytics\Classes\CacheItemPool::class,
    Winter\GoogleAnalytics\Classes\Analytics::class             => RainLab\GoogleAnalytics\Classes\Analytics::class,
    Winter\GoogleAnalytics\Components\Tracker::class            => RainLab\GoogleAnalytics\Components\Tracker::class,
    Winter\GoogleAnalytics\Models\Settings::class               => RainLab\GoogleAnalytics\Models\Settings::class,
    Winter\GoogleAnalytics\ReportWidgets\TrafficGoal::class     => RainLab\GoogleAnalytics\ReportWidgets\TrafficGoal::class,
    Winter\GoogleAnalytics\ReportWidgets\TopPages::class        => RainLab\GoogleAnalytics\ReportWidgets\TopPages::class,
    Winter\GoogleAnalytics\ReportWidgets\TrafficOverview::class => RainLab\GoogleAnalytics\ReportWidgets\TrafficOverview::class,
    Winter\GoogleAnalytics\ReportWidgets\Browsers::class        => RainLab\GoogleAnalytics\ReportWidgets\Browsers::class,
    Winter\GoogleAnalytics\ReportWidgets\TrafficSources::class  => RainLab\GoogleAnalytics\ReportWidgets\TrafficSources::class,
];

app(ClassLoader::class)->addAliases($aliases);
