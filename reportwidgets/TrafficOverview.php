<?php namespace Winter\GoogleAnalytics\ReportWidgets;

use Lang;
use Exception;
use ApplicationException;
use Backend\Classes\ReportWidgetBase;
use Winter\GoogleAnalytics\Classes\Analytics;
use Winter\Storm\Argon\Argon;
use Google\Service\AnalyticsData\DateRange;
use Google\Service\AnalyticsData\Dimension;
use Google\Service\AnalyticsData\Metric;
use Google\Service\AnalyticsData\RunReportRequest;

/**
 * Google Analytics traffic overview widget.
 *
 * @package backend
 * @author Alexey Bobkov, Samuel Georges
 */
class TrafficOverview extends ReportWidgetBase
{
    /**
     * Renders the widget.
     */
    public function render()
    {
        try {
            $this->loadData();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => e(trans('winter.googleanalytics::lang.widgets.title_traffic_overview')),
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
            'metrics' => [
                'title'             => 'winter.googleanalytics::lang.widgets.metrics',
                'default'           => ['sessions'],
                'type'              => 'set',
                'items'           => [
                    'sessions' => Lang::get('winter.googleanalytics::lang.widgets.metric_sessions'),
                    'activeUsers' => Lang::get('winter.googleanalytics::lang.widgets.metric_activeUsers'),
                    'screenPageViews' => Lang::get('winter.googleanalytics::lang.widgets.metric_screenPageViews'),
                ]
            ],
        ];
    }

    protected function loadData()
    {
        $obj = Analytics::instance();

        $days = $this->property('days', 30);
        $metrics = $this->property('metrics', ['sessions']);

        // Formulate data request
        $request = new RunReportRequest();
        $now = Argon::now()->toImmutable();
        $request->setDimensions([
            new Dimension(['name' => 'date']),
        ]);
        $request->setMetrics(
            array_map(function ($metric) {
                return new Metric(['name' => $metric]);
            }, $metrics)
        );
        $request->setDateRanges([
            new DateRange([
                'startDate' => $now->subDays($days)->format('Y-m-d'),
                'endDate' => $now->format('Y-m-d')
            ])
        ]);

        $data = $obj->service->properties->runReport(
            $obj->viewId,
            $request,
        );

        $rows = $data->getRows();
        if (!$rows) {
            throw new ApplicationException('No traffic found yet.');
        }

        // Set up array of points
        $points = array_map(function ($metric) {
            return [];
        }, $metrics);

        foreach ($rows as $rowIndex => $row) {
            foreach (array_keys($metrics) as $index) {
                if (!isset($row->getMetricValues()[$index])) {
                    continue;
                }

                $points[$index][$rowIndex] = [
                    strtotime($row->getDimensionValues()[0]->getValue()) * 1000,
                    $row->getMetricValues()[$index]->getValue(),
                ];
            }
        }

        // Sort results by date, since Google seems to return them in a random order
        foreach (array_keys($metrics) as $index) {
            array_multisort(array_column($points[$index], 0), SORT_ASC, $points[$index]);
        }

        $this->vars['metrics'] = $this->property('metrics', ['sessions']);
        $this->vars['points'] = $points;
    }
}
