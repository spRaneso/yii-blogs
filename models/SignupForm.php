<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $full_name;
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'username', 'email', 'password'], 'trim'],
            [['full_name', 'username', 'email', 'password'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['full_name', 'string', 'min' => 3, 'max' => 255],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        // $user = new User();
        // $user->full_name = $this->full_name;
        // $user->username = $this->username;
        // $user->email = $this->email;
        // $user->generatePasswordHash($this->password);
        // $user->generateAuthKey();

        // return $user->save();

        $authKey = Yii::$app->security->generateRandomString();
        $passwordHash = Yii::$app->security->generatePasswordHash($this->password);

        $rawQuery = "INSERT INTO `users` (`full_name`, `username`, `email`, `password`, `auth_key`) 
                    VALUES (:full_name, :username, :email, :password, :auth_key)";

        try {
                $result = Yii::$app->db->createCommand($rawQuery)
                    ->bindParam(':full_name', $this->full_name)
                    ->bindParam(':username', $this->username)
                    ->bindParam(':email', $this->email)
                    ->bindParam(':password', $passwordHash)
                    ->bindParam(':auth_key', $authKey)
                    ->execute();
            
                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } catch (\yii\db\Exception $e) {
                Yii::error("Error during signup: " . $e->getMessage());
                return false;
            }
    }
}