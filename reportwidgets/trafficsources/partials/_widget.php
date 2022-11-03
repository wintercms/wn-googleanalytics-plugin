<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <?php if (!isset($error)): ?>
        <div
            class="control-chart
                <?= $this->property('center') ? 'centered' : null ?>
                 <?= $this->property('legendAsTable') ? null : 'wrap-legend' ?>
                "
            data-control="chart-pie"
            data-size="<?= $this->property('reportSize') ?>"
        >
            <ul>
                <?php foreach ($rows as $row): ?>
                    <li>
                        <?= e($mediumMap[$row->getDimensionValues()[0]->getValue()] ?? $row->getDimensionValues()[0]->getValue()) ?>
                        <span><?= $row->getMetricValues()[0]->getValue() ?></span>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php else: ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>

    <?php if ($this->property('displayDescription')): ?>
        <p class="report-description"><?= e(trans('winter.googleanalytics::lang.widgets.description_traffic_sources')) ?></p>
    <?php endif ?>
</div>
