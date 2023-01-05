<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <img
        src="<?= Url::asset('plugins/winter/googleanalytics/assets/images/bar-graph-placeholder.svg') ?>"
        class="placeholder"
        style="width: 100%; height: 340px"
        onload="$.request('<?= $this->alias ?>::onLoad');"
    />
</div>
