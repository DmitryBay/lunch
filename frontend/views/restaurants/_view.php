<?php
/**
 * @var $model \common\models\Restaurant
 */
use yii\helpers\Html;
?>

<div class="p-3">
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<i class="fas fa-times"></i>', '#', [  'class' => 'float-right close-rest']) ?>
        </div>
    </div>
    <h3><?= Html::encode($model->title) ?></h3>
    <div class="row">
        <div class="col-12"><?= Yii::$app->formatter->asNtext($model->desc) ?></div>
    </div>

    <div class="rest-photos">

    </div>


    <a href="#" id="rest-uploader" data-url="<?= \yii\helpers\Url::to(['/site/upload-image','type'=>'restaurant','id'=>$model->id]) ?>" class="float-right"><i class="fas fa-image"></i> Добавить фотографию места</a>
    <h5>Photos </h5>

    <?if ($restFiles): // images block?>
    <div class="rest-info__images row">
        <? $i = 1; ?>
        <? foreach ($restFiles as $image) { ?>

            <?

            switch ($i) {
                case(1) :
                    $cl = 'pr-md-0';
                    break;
                case(2) :
                    $cl = 'px-md-1';
                    break;
                case(3) :
                    $cl = '  pl-md-0';
                    break;
                case(4) :
                    $cl = 'pl-md-0';
                    break;

            }

            ?>
            <div class="  col-md-4 mt-md <?= $cl ?>  ">
                    <a href="<?= $image->filename ?>" data-fancybox="imagesSS">
                        <div class="rest-card__image"
                             style="background-image: url('<?= $image->preview ?>') ">
                        </div>
                    </a>


            </div>
            <? $i++;
            $i = $i == 4 ? 1 : $i; ?>
        <? } ?>
    </div>
    <?endif;?>
    <div class="m-3"></div>
</div>

