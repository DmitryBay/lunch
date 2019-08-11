<?php

/* @var $this yii\web\View */

$this->title = 'Главная';
use yii\helpers\Html;
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

?>

<?= $this->render('../layouts/_top_menu') ?>

<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image:url('/img/main-back.jpeg');">
    </div>
    <div class="container">
        <div class="content-center brand">
            <img class="n-logo" src="/img/logo.png" alt="">
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
                     style="background-image: url('/now-ui-kit/assets/img/login.jpg')">
                    <!-- First image on the left side -->
                    <p class="blockquote blockquote-primary">"Over the span of the satellite record, Arctic sea ice has
                        been declining significantly, while sea ice in the Antarctichas increased very slightly"
                        <br>
                        <br>
                        <small>-NOAA</small>
                    </p>
                </div>
                <!-- Second image on the left side of the article -->
                <div class="image-container" style="background-image: url('/now-ui-kit/assets/img/bg3.jpg')"></div>
            </div>
            <div class="col-md-5">
                <!-- First image on the right side, above the article -->
                <div class="image-container image-right"
                     style="background-image: url('/now-ui-kit/assets/img/bg1.jpg')"></div>
                <h3>So what does the new record for the lowest level of winter ice actually mean</h3>
                <p>The Arctic Ocean freezes every winter and much of the sea-ice then thaws every summer, and that
                    process will continue whatever happens with climate change. Even if the Arctic continues to be one
                    of the fastest-warming regions of the world, it will always be plunged into bitterly cold polar dark
                    every winter. And year-by-year, for all kinds of natural reasons, there’s huge variety of the state
                    of the ice.
                </p>
                <p>
                    For a start, it does not automatically follow that a record amount of ice will melt this summer.
                    More important for determining the size of the annual thaw is the state of the weather as the
                    midnight sun approaches and temperatures rise. But over the more than 30 years of satellite records,
                    scientists have observed a clear pattern of decline, decade-by-decade.
                </p>
                <p>The Arctic Ocean freezes every winter and much of the sea-ice then thaws every summer, and that
                    process will continue whatever happens with climate change. Even if the Arctic continues to be one
                    of the fastest-warming regions of the world, it will always be plunged into bitterly cold polar dark
                    every winter. And year-by-year, for all kinds of natural reasons, there’s huge variety of the state
                    of the ice.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-11">
                <div class="content-center">
                    <?=  Html::a('Перейти к поиску ресторана для обеда!',['/places/index',['class'=>'btn btn-xs btn-block btn-success']]) ?>

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
