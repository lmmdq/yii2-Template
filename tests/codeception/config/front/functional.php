<?php
$_SERVER['SCRIPT_FILENAME'] = YII_TEST_FRONT_ENTRY_FILE;
$_SERVER['SCRIPT_NAME'] = YII_FRONT_TEST_ENTRY_URL;

/**
 * Application configuration for front functional tests
 */
return yii\helpers\ArrayHelper::merge(
    require(APPS_DIR . '/common/config/main.php'),
    require(APPS_DIR . '/common/config/main-local.php'),
    require(APPS_DIR . '/front/config/main.php'),
    require(APPS_DIR . '/front/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/functional.php'),
    require(__DIR__ . '/config.php'),
    [
    ]
);
