<?php

namespace app\models;

use InvalidArgumentException;
use Yii;
// use yii\base\InvalidArgumentException;
use yii\base\Security;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $auth_key;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['full_name', 'username', 'email', 'password', 'auth_key'], 'required'],
            [['role', 'status'], 'string'],
            [['deleted_at', 'created_at', 'updated_at'], 'safe'],
            [['username', 'email', 'password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['access_token'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['access_token'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'status' => 'Status',
            'deleted_at' => 'Deleted At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function generateRandomKey($length = 32)
    {
        if (!is_int($length)) {
            throw new InvalidArgumentException('First parameter ($length) must be an integer');
        }

        if ($length < 1) {
            throw new InvalidArgumentException('First parameter ($length) must be greater than 0');
        }

        return random_bytes($length);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordHash($password)
    {
        $this->password = Yii::$app->security()->generatePasswordHash($password);
    }

    public function getRole()
    {
        return $this->role;
    }
}
