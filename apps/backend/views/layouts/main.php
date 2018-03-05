<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use mdm\admin\components\MenuHelper;
//use common\models\AuthAssignment;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerCssFile('/css/base.css?v1');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'innerContainerOptions' => [
            'class' => 'container-fluid'
        ],
        'brandLabel' => '<span>cms</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    /*$menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];

    $menuItems = Yii::$app->setting->get('menu.items');
    $menuItems = @json_decode($menuItems, true);

    if (is_array($menuItems)) {
        $controllerId = Yii::$app->controller->id;
        //Web::setMenuActiveByControllerId($controllerId, $menuItems);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => $menuItems,
        ]);
    }*/
    $mainMenuItems = [];
    //右边导航
    $rightMenuItems = [];
    if (!Yii::$app->user->isGuest) {
        $mainMenuItems = MenuHelper::getAssignedMenu(Yii::$app->user->id);

        $rightMenuItems[] = [
            'label' => Yii::$app->user->identity->username . (empty($roleName) ? '' : " ( $roleName )"),
            'items' => [
                [
                    'label' => '修改密码',
                    'url' => ['/site/change-password']
                ],
                [
                    'label' => '退出',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $mainMenuItems
    ]);


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $rightMenuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <p class="pull-left">&copy; 大庆市未成年人犯判后缓刑考察帮教平台<?= date('Y') ?></p>

            <p class="pull-right">www.***.cn</p>
        </div>
    </footer>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
