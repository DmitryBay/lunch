<?php


?>
<nav  class="navbar navbar-expand-lg bg-primary fixed-top <?=  isset($options['transparent']) && $options['transparent']  ? ' navbar-transparent': ''?> " color-on-scroll="400">
    <div class="container">
        <div class="dropdown button-dropdown">
            <a href="/" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                <span class="button-bar"></span>
                <span class="button-bar"></span>
                <span class="button-bar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-header">Меню:</a>
                <?=\yii\helpers\Html::a('Поиск Ресторанов',['/restaurants/map'],['class'=>'dropdown-item'])?>
                <?=\yii\helpers\Html::a('Добавить Место',['/restaurants/add'],['class'=>'dropdown-item'])?>


<!--                <div class="dropdown-divider"></div>-->

            </div>
        </div>
        <div class="navbar-translate">
            <a class="navbar-brand" href="/">Lunchio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#example-navbar-danger" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="example-navbar-danger" data-nav-image="/now-ui-kit/assets/img/blurred-image-1.jpg">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link available-soon" href="#">
                        <i class="fab fa-app-store-ios"></i>
                        <p>App store</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link available-soon" href="#">
                        <i class="fab fa-google-play"></i>
                        <p>Google Play</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->
