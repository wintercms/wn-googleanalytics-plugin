<?php namespace Winter\GoogleAnalytics\ReportWidgets;

use Lang;
use Exception;
use Backend\Classes\ReportWidgetBase;
use Google\Service\AnalyticsData\DateRange;
use Google\Service\AnalyticsData\Metric;
use Google\Service\AnalyticsData\RunReportRequest;
use Winter\GoogleAnalytics\Classes\Analytics;
use Winter\Storm\Argon\Argon;

/**
 * Google Analytics traffic goal widget.
 *
 * @package backend
 * @author Alexey Bobkov, Samuel Georges
 */
class TrafficGoal extends ReportWidgetBase
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
                'default'           => e(trans('winter.googleanalytics::lang.widgets.title_traffic_goal')),
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error'
            ],
            'days' => [
                'title'             => 'winter.googleanalytics::lang.widgets.traffic_goal_days',
                'default'           => '30',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$'
            ],
            'goal' => [
                'title'             => 'winter.googleanalytics::lang.widgets.traffic_goal_goal',
                'description'       => 'winter.googleanalytics::lang.widgets.traffic_goal_goal_description',
                'default'           => '100',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'winter.googleanalytics::lang.widgets.traffic_goal_goal_validation'
            ],
            'goalMetric' => [
                'title'             => 'winter.googleanalytics::lang.widgets.traffic_goal_metric',
                'description'       => 'winter.googleanalytics::lang.widgets.traffic_goal_metric_description',
                'title'             => 'winter.googleanalytics::lang.widgets.metrics',
                'default'           => 'sessions',
                'type'              => 'dropdown',
                'options'           => [
                    'sessions' => Lang::get('winter.googleanalytics::lang.widgets.metric_sessions'),
                    'activeUsers' => Lang::get('winter.googleanalytics::lang.widgets.metric_activeUsers'),
                    'screenPageViews' => Lang::get('winter.googleanalytics::lang.widgets.metric_screenPageViews'),
                ],
            ],
        ];
    }

    protected function loadData()
    {
        $analytics = Analytics::instance();

        $days = $this->property('days', 30);
        $goal = $this->property('goal', 100);

        // Formulate data request
        $request = new RunReportRequest();
        $now = Argon::now()->toImmutable();
        $request->setMetrics([
            new Metric(['name' => $this->property('goalMetric', 'sessions')]),
        ]);
        $request->setDateRanges([
            new DateRange([
                'startDate' => $now->subDays($days)->format('Y-m-d'),
                'endDate' => $now->format('Y-m-d')
            ])
        ]);
        $request->setMetricAggregations(['TOTAL']);

        $data = $analytics->service->properties->runReport(
            $analytics->viewId,
            $request,
        );

        $this->vars['total'] = $total = $data->getTotals()[0]->getMetricValues()[0]->getValue();
        $this->vars['percentage'] = min(round(($total / $goal) * 100), 100);
    }
}
