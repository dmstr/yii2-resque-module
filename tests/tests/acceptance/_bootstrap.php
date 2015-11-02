<?php
// Here you can initialize variables that will be available to your tests

/**
 * Application configuration for acceptance tests
 */
$config = yii\helpers\ArrayHelper::merge(
    require('/app/src/config/main.php'),
    #require('/app/config.php'),
    [
        'controllerNamespace' => 'app\controllers',
    ]
);


new yii\web\Application($config);