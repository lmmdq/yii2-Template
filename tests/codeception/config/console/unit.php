<?php
/**
 * Application configuration for console unit tests
 */
return yii\helpers\ArrayHelper::merge(
    require(APPS_DIR . '/common/config/main.php'),
    require(APPS_DIR . '/common/config/main-local.php'),
    require(APPS_DIR . '/console/config/main.php'),
    require(APPS_DIR . '/console/config/main-local.php'),
    require(dirname(__DIR__) . '/config.php'),
    require(dirname(__DIR__) . '/unit.php'),
    [
    ]
);
