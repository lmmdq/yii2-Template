<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (Yii::$app->session->hasFlash('changepassword')) :
        $message = Yii::$app->session->getFlash('changepassword');
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong><?php echo Html::encode($message);?></strong>
        </div>
        <?php
    endif;
    ?>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'new_password_repeat')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('更新', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>