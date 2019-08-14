<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dist/bootstrap-4.3.1/dist/css/bootstrap.css',
        'dist/bootstrap-4.3.1/dist/css/bootstrap-reboot.css',
        'dist/bootstrap-4.3.1/dist/css/bootstrap-grid.css',
        'css/site.css',
        'now-ui-kit/assets/css/bootstrap.min.css',
        'now-ui-kit/assets/css/now-ui-kit.css',
        'https://fonts.googleapis.com/css?family=Montserrat:400,700,200',
        'https://use.fontawesome.com/releases/v5.4.1/css/all.css',
        '/dist/growl/jquery.growl.css',
        '/now-ui-kit/assets/demo/demo.css',

    ];
    public $js = [
        'dist/bootstrap-4.3.1/dist/js/bootstrap.js',
//        'dist/bootstrap-4.3.1/dist/js/bootstrap.bundle.js',

        'now-ui-kit/assets/js/core/popper.min.js',
        'now-ui-kit/assets/js/plugins/bootstrap-switch.js',
        'now-ui-kit/assets/js/plugins/bootstrap-datepicker.js',
        'now-ui-kit/assets/js/plugins/nouislider.min.js',
        'now-ui-kit/assets/js/now-ui-kit.min.js',
//        'https://kit.fontawesome.com/16b15ce522.js',
        '/dist/growl/jquery.growl.js',
        '/js/main.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
