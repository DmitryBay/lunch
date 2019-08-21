<?php
$this->title = $model->title;
?>


<div class="regular-page clear-filter page-header-small">
    <div class="container">

        <?= \yii\helpers\Html::encode($model->title) ?>
        <div class="row">

            <?var_dump($model->getAttributes())?>
            <?var_dump($model->location)?>
        </div>
    </div>
</div>
