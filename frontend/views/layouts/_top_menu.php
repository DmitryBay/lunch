<?php
use yii\helpers\Html;
?>
<nav class="navbar navbar-expand-lg bg-primary fixed-top <?= isset($options['transparent']) && $options['transparent'] ? ' navbar-transparent' : '' ?> "
    <?= isset($options['color_on_scroll']) && $options['color_on_scroll'] ? 'color-on-scroll="400"' : '' ?> >
    <div class="container">
        <div class="dropdown button-dropdown">
            <a href="/" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                <span class="button-bar"></span>
                <span class="button-bar"></span>
                <span class="button-bar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-header">Меню:</a>
                <?= Html::a('Поиск Ресторанов', ['/restaurants'], ['class' => 'dropdown-item']) ?>
                <?= Html::a('Добавить Место', ['/restaurants/add'], ['class' => 'dropdown-item']) ?>


                <!--                <div class="dropdown-divider"></div>-->

            </div>
        </div>
        <div class="navbar-translate">
            <a class="navbar-brand" href="/">Lunchio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#example-navbar-danger"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="example-navbar-danger"
             data-nav-image="/now-ui-kit/assets/img/blurred-image-1.jpg">
            <ul class="navbar-nav ml-auto">
                <? if (Yii::$app->user->isGuest): ?>
                    <li class="nav-item">

                        <?= Html::a('<i class="far fa-user"></i>  <p>Login</p>',['/site/login'],['class'=>'nav-link']) ?>

                    </li>
                <? else:
                   echo  '<li  class="nav-item">'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</li>';

                 endif; ?>


            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->
