<?php namespace Winter\GoogleAnalytics\Updates;

use Db;
use Backend\Models\UserPreference;
use Winter\Storm\Database\Updates\Migration;

class ConvertData extends Migration
{
    public function up()
    {
        Db::table('system_files')
            ->where('attachment_type', 'RainLab\GoogleAnalytics\Models\Settings')
            ->update(['attachment_type' => 'Winter\GoogleAnalytics\Models\Settings']);

        Db::table('system_settings')
            ->where('item', 'rainlab_googleanalytics_settings')
            ->update(['item' => 'winter_googleanalytics_settings']);

        $records = UserPreference::where('namespace', 'backend')->where('group', 'reportwidgets')->get();

        foreach ($records as $record) {
            $data = $record->value;
            foreach ($data as $widget => &$widgetDetails) {
                if (starts_with($widgetDetails['class'], 'RainLab\\GoogleAnalytics')) {
                    $widgetDetails['class'] = str_replace('RainLab\\', 'Winter\\', $widgetDetails['class']);
                }
            }
            $record->value = $data;
            $record->save();
        }
    }

    public function down()
    {
        Db::table('system_files')
            ->where('attachment_type', 'Winter\GoogleAnalytics\Models\Settings')
            ->update(['attachment_type' => 'RainLab\GoogleAnalytics\Models\Settings']);

        Db::table('system_settings')
            ->where('item', 'winter_googleanalytics_settings')
            ->update(['item' => 'rainlab_googleanalytics_settings']);

        $records = UserPreference::where('namespace', 'backend')->where('group', 'reportwidgets')->get();

        foreach ($records as $record) {
            $data = $record->value;
            foreach ($data as $widget => &$widgetDetails) {
                if (starts_with($widgetDetails['class'], 'Winter\\GoogleAnalytics')) {
                    $widgetDetails['class'] = str_replace('Winter\\', 'RainLab\\', $widgetDetails['class']);
                }
            }
            $record->value = $data;
            $record->save();
        }
    }
}
