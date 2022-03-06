<?php

namespace app\models;
use yii\db\Expression;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public static function tableName() 
    {
       return 'user';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$user[$id]) ? new static(self::$user[$id]) : null;
    }

    public static function findUser($username,$password)
    {
        return static::findOne(['username' => $username, 'password' => $password]);
    }

    


     /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security::generatePasswordHash($password);
    }
  
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
