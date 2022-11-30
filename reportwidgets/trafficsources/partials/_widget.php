<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <img
        src="<?= Url::asset('plugins/winter/googleanalytics/assets/images/pie-graph-placeholder.svg') ?>"
        class="placeholder"
        style="width: auto; height: 150px"
        onload="$.request('<?= $this->alias ?>::onLoad');"
    />
</div>
