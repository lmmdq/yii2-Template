<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
//use wh\googleauthenticator\GoogleAuthenticator;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property integer $state
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $google_auth
 * @property integer $google_auth_secret
 * @property string $city
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    public $password = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required', 'on' => ['create', 'update']],
            ['password', 'required', 'on' => 'create'],
            ['email', 'email'],
            ['email', 'unique', 'message' => '邮箱已经存在'],
            ['email', 'trim'],
            [['state', 'google_auth','city_id','type'], 'integer'],
            [['username', 'password'], 'string', 'max' => 32],
            [['password_hash', 'email', 'google_auth_secret', 'region'], 'string', 'max' => 255]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '账号'),
            'password' => Yii::t('app', '密码'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'email' => Yii::t('app', '邮箱'),
            'state' => Yii::t('app', '状态'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'google_auth' => '使用用动态验证码',
            'city_id' => '市',
            'province_id'=>'省',
            'region' => Yii::t('app', '所属区局'),
            'type' => Yii::t('app','类型'),
        ];
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function validateState()
    {
        return $this->state == 0;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

//    public function generateGoogleAuthSecret()
//    {
//        $ga = new GoogleAuthenticator();
//        $this->google_auth_secret = $ga->createSecret();
//    }

    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }
}
