<?php

/* @var $this yii\web\View */

$this->title = 'Главная';
use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>

<?= $this->render('../layouts/_top_menu',[
    'options'=>[
        'transparent'=>true
    ]
]) ?>

<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image:url('/img/main-back.jpeg');">
    </div>
    <div class="container">
        <div class="content-center brand">
<!--            <img class="n-logo" src="/img/logo.png" alt="">-->
            <h1 class="h1-seo">Lunchio (Ланчио)</h1>
            <h3>Отличный способ сэкономить на обедах. </h3>
            <p><a href="#"><?= Yii::t('app', 'Как это работает?') ?></a></p>
        </div>
    </div>
</div>
<div class="separator separator-primary"></div>
<div class="container">



    <div class="section-story-overview">
        <div class="row">
            <div class="col-md-6">
                <div class="image-container image-left"
                     style="background-image: url('/img/landing_1.jpg')">
                    <!-- First image on the left side -->
                    <p class="blockquote blockquote-primary">"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."
                        <br>
                        <br>
                        <small>-NOAA</small>
                    </p>
                </div>
                <!-- Second image on the left side of the article -->
                <div class="image-container" style="background-image:url('/img/landing_2.jpeg')"></div>
            </div>
            <div class="col-md-5">
                <!-- First image on the right side, above the article -->
                <div class="image-container image-right"
                     style="background-image: url('/img/landing_3.jpeg')"></div>
                <h3>Давайте поговорим немного о питании?</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </p>

            </div>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="content-center">
                    <?=  Html::a('Перейти к поиску ресторана для обеда!',['/places/index'],['class'=>'btn btn-xs btn-block btn-success']) ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
</div>
