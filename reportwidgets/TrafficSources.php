<?php namespace Winter\GoogleAnalytics\ReportWidgets;

use Lang;
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
 * Google Analytics traffic sources widget.
 *
 * @package backend
 * @author Alexey Bobkov, Samuel Georges
 */
class TrafficSources extends ReportWidgetBase
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
                'default'           => e(trans('winter.googleanalytics::lang.widgets.title_traffic_sources')),
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error'
            ],
            'reportSize' => [
                'title'             => 'winter.googleanalytics::lang.widgets.traffic_sources_report_size',
                'default'           => '150',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'winter.googleanalytics::lang.widgets.traffic_sources_report_size_validation'
            ],
            'center' => [
                'title'             => 'winter.googleanalytics::lang.widgets.traffic_sources_center',
                'type'              => 'checkbox'
            ],
            'legendAsTable' => [
                'title'             => 'winter.googleanalytics::lang.widgets.legend_as_table',
                'type'              => 'checkbox',
                'default'           => 1
            ],
            'days' => [
                'title'             => 'winter.googleanalytics::lang.widgets.days',
                'default'           => '30',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$'
            ],
            'displayDescription' => [
                'title'             => 'winter.googleanalytics::lang.widgets.display_description',
                'type'              => 'checkbox',
                'default'           => 1
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
            new Dimension(['name' => 'sessionMedium']),
        ]);
        $request->setMetrics([
            new Metric(['name' => 'sessions']),
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
                    'metricName' => 'sessions',
                ])
            ]),
        ]);

        $data = $analytics->service->properties->runReport(
            $analytics->viewId,
            $request,
        );

        $this->vars['rows'] = $data->getRows() ?: [];
        $this->vars['mediumMap'] = [
            'organic' => Lang::get('winter.googleanalytics::lang.mediums.organic'),
            'cpc' => Lang::get('winter.googleanalytics::lang.mediums.cpc'),
            '(none)' => Lang::get('winter.googleanalytics::lang.mediums.direct'),
            'referral' => Lang::get('winter.googleanalytics::lang.mediums.referral'),
            '(not set)' => Lang::get('winter.googleanalytics::lang.mediums.unknown'),
        ];
    }
}
