<?php

namespace app\modules\user\common\models;

use app\modules\core\common\behaviors\SoftDeleteBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use app\modules\core\common\components\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'softDelete' => [
                'class' => SoftDeleteBehavior::className()
            ],
        ];
    }

    public function init()
    {
        $this->on(SoftDeleteBehavior::EVENT_BEFORE_REMOVE, function($event) {
            if(static::find()->active()->count() == 1) {
                Yii::$app->session->setFlash('error', 'Невозможно удалить пользователя: в системе должен быть хотя бы один пользователь.');
                $event->isValid = false;
            } elseif($this->id == Yii::$app->user->id) {
                Yii::$app->session->setFlash('error', 'Невозможно удалить пользователя: вы залогинены под этим пользователем.');
                $event->isValid = false;
            }
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => 1],
            [['username', 'email'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 30, 'min' => 5],
            [['email', 'password_hash'], 'string', 'max' => 100],
            [['password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password'], 'string', 'min' => 6],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            [['password'], 'required', 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'created_at'           => 'Дата создания',
            'updated_at'           => 'Дата изменения',
            'status'               => 'Статус',
            'username'             => 'Имя пользователя',
            'email'                => 'Email',
            'password_hash'        => 'Хеш пароля',
            'password_reset_token' => 'Токен сброса пароля',
            'auth_key'             => 'Ключ авторизации',
            'password'             => 'Пароль',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password) {
                $this->setPassword($this->password);
            }
            if ($insert) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        $model = static::findOne($id);
        return $model;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public static function getDropdown($exclude = [])
    {
        return ArrayHelper::map(
            static::find()
                ->andWhere(['NOT IN', 'id', $exclude])
                ->active()
                ->select(['id', 'username'])->all(), 'id', 'username');
    }

}
