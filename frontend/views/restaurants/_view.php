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


    <a href="#" id="rest-uploader" data-url="<?= \yii\helpers\Url::to(['/site/upload-image']) ?>" class="float-right"><i class="fas fa-image"></i> Добавить фотографию места</a>
    <h5>Photos </h5>

    <?if (0): // images block?>
    <div class="rest-info__images row">
        <? $i = 1; ?>
        <? foreach ($rF as $image) { ?>

            <?

            switch ($i) {
                case(1) :
                    $cl = 'pr-md-0';
                    break;
                case(2) :
                    $cl = 'pr-md-2';
                    break;
                case(3) :
                    $cl = 'pl-md-2';
                    break;
                case(4) :
                    $cl = 'pl-md-0';
                    break;

            }

            ?>
            <div class="  col-md-4 mt-md <?= $cl ?>  ">

                <? if ($image['status'] != 10) : ?>

                    <? if ($model->mprofile_id == $profile_id) { ?>

                        <? if ($model->status == 0) { ?>
                            <a href="/img/errors/undermoderation.jpg" data-fancybox="imagesSS">
                                <div class="place-card__image"
                                     style="background-image: url('/img/errors/undermoderation.jpg') ">

                                </div>
                            </a>
                        <? } else { ?>

                        <? } ?>
                    <? } ?>

                <? else: ?>

                    <a href="<?= $image['filename'] ?>" data-fancybox="imagesSS">
                        <div class="place-card__image"
                             style="background-image: url('<?= $image['thumb'] ?>') ">

                        </div>
                    </a>
                <? endif; ?>


                <!--                                --><? //= var_dump($image['status']) ?>
                <!--                                --><? //=$image['thumb']?>

            </div>
            <? $i++;
            $i = $i == 4 ? 1 : $i; ?>
        <? } ?>
    </div>
    <?endif;?>
</div>
