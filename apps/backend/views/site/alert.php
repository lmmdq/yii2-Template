<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = '提示';
?>
<div class="site-error">

    <?php
    if (Yii::$app->getSession()->hasFlash('error')) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success', //这里是提示框的class
            ],
            'body' => Yii::$app->getSession()->getFlash('alert'), //消息体
        ]);
    }
    ?>

</div>
