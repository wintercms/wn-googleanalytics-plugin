<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <?php if (!isset($error)): ?>
        <div
            data-control="chart-line"
            data-time-mode="weeks"
            data-chart-options="xaxis: {mode: 'time'}, legend: {show: false}, tooltipOpts: {defaultTheme: false, content: '%x: <strong>%y %s</strong>'}"
            class="height-200"
        >
            <?php foreach ($points as $index => $rows): ?>
            <span
                data-chart="dataset"
                data-set-color="#008dc9"
                data-set-data="<?= str_replace('"', '', substr(substr(json_encode($rows), 1), 0, -1)) ?>"
                data-set-label="<?= strtolower(e(trans('winter.googleanalytics::lang.widgets.metric_' . $metrics[$index]))) ?>"></span>
            <?php endforeach ?>

        </div>
    <?php else: ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>

</div>
