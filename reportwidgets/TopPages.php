<?php namespace Winter\GoogleAnalytics\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Winter\GoogleAnalytics\Classes\Analytics;
use ApplicationException;
use Exception;

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
        try {
            $this->loadData();
        }
        catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
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
                'default'           => '7',
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
        $days = $this->property('days');
        if (!$days)
            throw new ApplicationException('Invalid days value: '.$days);

        $obj = Analytics::instance();
        $data = $obj->service->data_ga->get($obj->viewId, $days.'daysAgo', 'today', 'ga:pageviews', ['dimensions' => 'ga:pagePath', 'sort' => '-ga:pageviews']);

        $rows = $data->getRows() ?: [];
        $rows = $this->vars['rows'] = array_slice($rows, 0, $this->property('number'));

        $total = 0;
        foreach ($rows as $row)
            $total += $row[1];

        $this->vars['total'] = $total;
    }
}
