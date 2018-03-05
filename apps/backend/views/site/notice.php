<?php
/**
 * Created by PhpStorm.
 * User: limingming
 * Date: 17/8/1
 * Time: 上午7:16
 */
use yii\helpers\Html;
use yii\bootstrap\Alert;

$this->title = '提示';
?>
<div class="site-error">

    <?php
    if (Yii::$app->getSession()->hasFlash('alert')) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success', //这里是提示框的class
            ],
            'body' => Yii::$app->getSession()->getFlash('alert'), //消息体
        ]);
    }
    ?>

</div>