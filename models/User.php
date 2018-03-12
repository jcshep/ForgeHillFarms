<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use kartik\password\StrengthValidator;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $id;
    public $username;
    public $authKey;
    public $accessToken;
    public $password_repeat;
    public $password_change;
    public $password_change_repeat;

    public $cc;
    public $cc_exp_month;
    public $cc_exp_year;
    public $cc_zip;
    public $cvc;
    public $save_cc;
    public $cc_token;


    public function rules()
    {
        return [

            [['email'], 'email'],
            [['email'], 'unique'],
            [['email', 'password', 'password_repeat', 'fname', 'lname'], 'required'],
            [['password'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'email'],
            [['access_level','membership_type','phone'], 'string', 'max' => 11],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],


            // Password Reset
            [['password_change','password_change_repeat'], 'required', 'on' => 'passwordReset'],
            [['password_change'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'email', 'on' => 'passwordReset'], 

        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['passwordReset'] = ['password_change', 'password_change_repeat'];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return [
            'cc' => 'Credit Card',
            'cc_zip' => 'Billing Zip',
            'email' => 'Email',
            'password' => 'Password',
            'fname' => 'First Name',
            'lname' => 'Last Name',
        ];
    }    


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }


    public static function findByUsername($email)
    {
        return static::findOne(['email' => $email]);
    }


    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }



    public function getAuthKey()
    {
        return $this->auth_key;
    }


    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    public function validatePassword($password)
    {
        // return $this->password === sha1($password);
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password)) {
            return true;
        } else {
            return false;
        }
    }


    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }


    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }



    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }



    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            // Encrypt Password
            if($insert) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }


            // Password Reset Scenario
            if($this->scenario == 'passwordReset') {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password_change);
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }


            return true;
        } 
        return false;        
    }


    public static function isAdmin()
    {
        if(isset(Yii::$app->user->identity->access_level) && Yii::$app->user->identity->access_level == 'admin')
            return true;

        return false;
    }


    public static function membershipLabel($level) {

        // switch ($level) {
        //     case 'free': return 'Fbreak;
        //     case 'full': break;
        //     case 'half': break;
        // }

    }


}
