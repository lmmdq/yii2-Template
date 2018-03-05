<?php
/**
 * @link http://www.wayhood.com/
 */

namespace backend\models;

use Yii;
use backend\models\Admin;

/**
 * Class ChangePasswordForm
 * @package backend\models
 * @author Song Yeung <netyum@163.com>
 * @date 15-6-22
 */
class ChangePasswordForm extends \yii\base\Model
{
    public $old_password;
    public $new_password;

    public $new_password_repeat;


    public function rules()
    {
        return [
            [['old_password', 'new_password', 'new_password_repeat'], 'required'],
            ['new_password', 'compare', 'compareAttribute'=>'new_password_repeat'],
            [['old_password', 'new_password'], 'string', 'max'=>16, 'min'=>6],
            [['old_password', 'new_password'], 'match', 'pattern'=> '/^[\@A-Za-z0-9\!\@\#\$\%\^\&\*\(\)\.\~]{6,22}$/', 'message'=>'密码请使用字母、数字、下划线、中划线。'],
            ['old_password', 'validatePassword']
        ];
    }

    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $id = Yii::$app->user->identity->id;
            $user = Admin::findOne($id);
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError('old_password', '原始密码不正确');
            }
        }
    }

    public function changePassword()
    {
        $id = Yii::$app->user->identity->id;
        $user = Admin::findOne($id);
        if (is_null($user)) {
            return false;
        }
        $user->setPassword($this->new_password);
        return $user->save(false);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password' => '原密码',
            'new_password' => '新密码',
            'new_password_repeat' => '新密码确认'
        ];
    }
}