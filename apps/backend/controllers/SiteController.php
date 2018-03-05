<?php
namespace backend\controllers;

use backend\models\Admin;
use common\models\AdminNotice;
use common\models\Chapter;
use common\models\LookTime;
use common\models\Student;
use common\models\Book;
use Yii;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\ChangePasswordForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {


        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->validateState()) {
//            if ($model->usedGoogleAuth()) {
//                $model->setFlashLoginUserData();
//                $this->redirect(['auth']);
//            } else {
            $model->loginFinal();
            return $this->goBack();
//            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangePassword()
    {
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('changepassword', "密码修改成功，下次登录请使用新密码");
                return $this->redirect(['site/change-password']);
            } else {
                $model->addError('old_password', "密码修改失败");
            }
        }
        return $this->render('change-password', [
            'model' => $model
        ]);
    }

    public function actionNotice()
    {
        return $this->render('notice');
    }

    public function actionAlert()
    {
        return $this->render('alert');
    }
}
