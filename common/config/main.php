<?php

return [
    'name' => getenv('APP_NAME'),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            //'class' => 'yii\swiftmailer\Mailer',
            'class' => \YarCode\Yii2\Mailgun\Mailer::class,
            'domain' => getenv('MAILGUN_DOMAIN'),
            'apiKey' => getenv('MAILGUN_API_KEY'),
            'useFileTransport' => filter_var(getenv('MAILER_USE_FILE_TRANSPORT'), FILTER_VALIDATE_BOOLEAN),
            'viewPath' => '@app/mail',
            //   'textLayout' => 'my/layout',  // custome layout
            'htmlLayout' => 'layouts/html', // disable layout
            //        'apiKey' => getenv('SENDGRID_API_KEY'),
        ],
    ],
];
