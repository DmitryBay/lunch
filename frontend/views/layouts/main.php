<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);

?>
<? unset($this->assetBundles['yii\bootstrap\BootstrapAsset']);?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<nav  class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="#pablo">Lunchio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#example-navbar-danger" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="example-navbar-danger" data-nav-image="./assets/img/blurred-image-1.jpg">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#pablo">
                        <i class="fab fa-app-store-ios"></i>
                        <p>App store</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pablo">
                        <i class="fab fa-google-play"></i>
                        <p>Google Play</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->

<div class="wrap">
    <div class="page-header clear-filter" filter-color="orange">
        <div class="page-header-image" data-parallax="true" style="background-image:url('/img/main-back.jpeg');">
        </div>
        <div class="container">

            <div class="content-center brand">
                <img class="n-logo" src="./assets/img/now-logo.png" alt="">
                <h1 class="h1-seo">Now UI Kit.</h1>
                <h3>A beautiful Bootstrap 4 UI kit. Yours free.</h3>
            </div>
        </div>
    </div>

    <div class="container">

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>

        <div class="content-center brand">
            <img class="n-logo" src="/now-ui-kit/assets/img/now-logo.png" alt="">
            <h1 class="h1-seo">Now UI Kit.</h1>
            <h3>A beautiful Bootstrap 4 UI kit. Yours free.</h3>
        </div>
        <h6 class="category category-absolute">Designed by
            <a href="http://invisionapp.com/" target="_blank">
                <img src="/now-ui-kit/assets/img/invision-white-slim.png" class="invision-logo" />
            </a>. Coded by
            <a href="https://www.creative-tim.com" target="_blank">
                <img src="/now-ui-kit/assets/img/creative-tim-white-slim2.png" class="creative-tim-logo" />
            </a>.</h6>

        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
