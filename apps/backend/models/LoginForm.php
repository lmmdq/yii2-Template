<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Admin;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_admin = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '帐号',
            'password' => '密码',
            'rememberMe' => '记住我'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, '无效的帐号或密码');
            }
        }
    }

    public function validateState()
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validateState()) {
                $this->addError('username', '帐号被禁用');
                return false;
            }
        }
        return true;
    }

    public function setFlashLoginUserData()
    {

        $backUrl = Yii::$app->getUser()->getReturnUrl();
        $data = $this->attributes;
        $data['backUrl'] = $backUrl;
        Yii::$app->session->setFlash('google.auth.user.data', $data);
    }

    public function usedGoogleAuth()
    {
        $admin = $this->getAdmin();
        return $admin->google_auth == 1;
    }

    public function loginFinal()
    {
        return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    public function getAdmin()
    {
        if ($this->_admin === false) {
            $this->_admin = Admin::find()
                ->where(['username'=>$this->username])
                ->one();
            /* if(!Yii::$app->user->can('manager', ['user'=>$this->_user])){
                 $this->_user = null;
             }*/
        }

        return $this->_admin;
    }
}
