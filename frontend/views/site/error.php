<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>


<?= $this->render('../layouts/_top_menu') ?>

<div class="page-header clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image:url('/img/main-back.jpeg');">
    </div>
    <div class="container">
        <div class="content-center brand">
<!--            <img class="n-logo" src="/img/logo.png" alt="">-->
            <h1 class="h1-seo"><?= Html::encode($this->title) ?></h1>
            <p><?= nl2br(Html::encode($message)) ?> </p>

                <p>
                    Пожалуйста, свяжитесь с нами, если считаете что это ошибка сервера. Спасибо!
                </p>
        </div>
    </div>
</div>