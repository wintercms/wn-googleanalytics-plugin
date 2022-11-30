<div class="report-widget">
    <h3><?= e($this->property('title')) ?></h3>

    <img
        src="<?= Url::asset('plugins/winter/googleanalytics/assets/images/table-placeholder.svg') ?>"
        class="placeholder"
        style="width: 100%; height: 260px"
        onload="$.request('<?= $this->alias ?>::onLoad');"
    />
</div>
