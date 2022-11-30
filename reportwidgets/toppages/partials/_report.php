<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <?php if (!isset($error)): ?>
        <div class="table-container">
            <table class="table data" data-control="rowlink">
                <thead>
                    <tr>
                        <th><span><?= e(trans('winter.googleanalytics::lang.strings.page_url')) ?></span></th>
                        <th><span><?= e(trans('winter.googleanalytics::lang.strings.pageviews')) ?></span></th>
                        <th><span><?= e(trans('winter.googleanalytics::lang.strings.users')) ?></span></th>
                        <th><span>% <?= e(trans('winter.googleanalytics::lang.strings.engagement')) ?></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row):
                        $url = $row->getDimensionValues()[0]->getValue();
                        $views = $row->getMetricValues()[0]->getValue();
                        $users = $row->getMetricValues()[1]->getValue();
                        $engagement = round($row->getMetricValues()[2]->getValue() * 100, 2);
                    ?>
                        <tr>
                            <td><a href="<?= $url ?>" target="_blank"><?= e($url) ?></a></td>
                            <td><?= e($views) ?></td>
                            <td><?= e($users) ?></td>
                            <td>
                                <div class="progress">
                                    <div class="bar" style="width: <?= $engagement . '%' ?>"></div>
                                    <?= $engagement . '%' ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if (!count($rows)): ?>
                        <tr>
                            <td colspan="3"><?= e(trans('winter.googleanalytics::lang.widgets.noresult_toppages')) ?></td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="flash-message static warning"><?= e($error) ?></p>
    <?php endif ?>
</div>
