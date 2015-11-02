<?php
// This is global bootstrap for autoloading

$base = '/app';

require($base . '/vendor/autoload.php');
require($base . '/src/config/env.php');

if (getenv('YII_ENV') !== 'test') {
    echo "Error: YII_ENV must be set to 'test'\n";
    exit;
}

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

defined('YII_TEST_ENTRY_URL') or define('YII_TEST_ENTRY_URL', parse_url(\Codeception\Configuration::config()['config']['test_entry_url'], PHP_URL_PATH));
defined('YII_TEST_ENTRY_FILE') or define('YII_TEST_ENTRY_FILE', dirname(dirname($base)) . '/web/index.php');

require_once($base . '/vendor/yiisoft/yii2/Yii.php');

$_SERVER['SCRIPT_FILENAME'] = YII_TEST_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_TEST_ENTRY_URL;
$_SERVER['SERVER_NAME'] = 'http://web';
$_SERVER['SERVER_PORT'] =  80;


Yii::setAlias('@tests', __DIR__);
