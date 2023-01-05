<?php namespace Winter\GoogleAnalytics\ReportWidgets;

use Exception;
use Backend\Classes\ReportWidgetBase;
use Google\Service\AnalyticsData\DateRange;
use Google\Service\AnalyticsData\Dimension;
use Google\Service\AnalyticsData\Metric;
use Google\Service\AnalyticsData\MetricOrderBy;
use Google\Service\AnalyticsData\OrderBy;
use Google\Service\AnalyticsData\RunReportRequest;
use Winter\GoogleAnalytics\Classes\Analytics;
use Winter\Storm\Argon\Argon;

/**
 * Google Analytics top pages widget.
 *
 * @package backend
 * @author Alexey Bobkov, Samuel Georges
 */
class TopPages extends ReportWidgetBase
{
    /**
     * Renders the widget.
     */
    public function render()
    {
        $this->addCss('/plugins/winter/googleanalytics/assets/css/placeholder.css', 'Winter.GoogleAnalytics');

        return $this->makePartial('widget');
    }

    public function onLoad()
    {
        try {
            $this->loadData();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return [
            '#' . $this->alias => $this->makePartial('report')
        ];
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => e(trans('winter.googleanalytics::lang.widgets.title_toppages')),
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error'
            ],
            'days' => [
                'title'             => 'winter.googleanalytics::lang.widgets.days',
                'default'           => '30',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$'
            ],
            'number' => [
                'title'             => 'winter.googleanalytics::lang.widgets.toppages_number',
                'default'           => '5',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$'
            ]
        ];
    }

    protected function loadData()
    {
        $analytics = Analytics::instance();

        $days = $this->property('days', 30);

        // Formulate data request
        $request = new RunReportRequest();
        $now = Argon::now()->toImmutable();
        $request->setDimensions([
            new Dimension(['name' => 'pagePath']),
        ]);
        $request->setMetrics([
            new Metric(['name' => 'screenPageViews']),
            new Metric(['name' => 'activeUsers']),
            new Metric(['name' => 'engagementRate']),
        ]);
        $request->setDateRanges([
            new DateRange([
                'startDate' => $now->subDays($days)->format('Y-m-d'),
                'endDate' => $now->format('Y-m-d')
            ])
        ]);
        $request->setOrderBys([
            new OrderBy([
                'desc' => true,
                'metric' => new MetricOrderBy([
                    'metricName' => 'screenPageViews',
                ])
            ]),
            new OrderBy([
                'desc' => true,
                'metric' => new MetricOrderBy([
                    'metricName' => 'activeUsers',
                ])
            ]),
        ]);
        $request->setLimit($this->property('number', 5));

        $data = $analytics->service->properties->runReport(
            $analytics->viewId,
            $request,
        );

        $this->vars['rows'] = $data->getRows() ?: [];
    }
}
