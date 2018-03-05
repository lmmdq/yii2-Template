<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'runtimePath' => ROOT_DIR . '/runtimes/backend',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'modules' => [
        'setting' => [
            'class' => 'wh\setting\Module',
            //'admins' => ['guest']
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'top-menu',
            'navbar' => [],
            'controllerMap' => [
                'role' => 'backend\maps\admin\RoleController',
                'route' => 'backend\maps\admin\RouteController',
                'menu' => 'backend\maps\admin\MenuController',
                'assignment' => 'backend\maps\admin\AssignmentController',
                'permission' => 'backend\maps\admin\PermissionController'
            ]
        ],
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'imageAllowExtensions' => ['jpg', 'png', 'gif']
        ],
        'backup' => [
            'class' => 'spanjeta\modules\backup\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ]

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/auth',
            //'admin/*', // add or remove allowed actions to this list
            'debug/*',
            //'user/*'
            'gii/*'
        ]
    ],
    'components' => [
        'rbac_cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => ROOT_DIR . '/runtimes/common/cache/rbac'
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@mdm/admin/views' => '@backend/views/admin'
                ]
            ]
        ],
        'authManager' => [
            'class' => 'common\components\DbManager',
            'cache' => 'rbac_cache'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
