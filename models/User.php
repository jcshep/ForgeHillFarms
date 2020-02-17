<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use kartik\password\StrengthValidator;
use app\models\Page;

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
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

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [

            [['email'], 'email'],
            [['email'], 'unique'],
            [['email', 'fname', 'lname','phone'], 'required'],
            [['password'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'email'],
            [['access_level','membership_type','phone'], 'string', 'max' => 11],   
            [['password_change','password_change_repeat'], 'string'],
            [['created'],'integer'],

            // Insert
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match", 'on' => 'insert'],
            [['password', 'password_repeat'], 'required', 'on' => 'insert'],

            // Payment Revison
            [['cc', 'cvc', 'cc_zip', 'cc_token'], 'required', 'on' => 'revision'],

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



    // public function createStripeCustomer() {

    //     try {
    //         $response = \Stripe\Customer::create(array(
    //             "description" => "Customer for abigail.white@example.com",
    //             "source" => "tok_mastercard" // obtained with Stripe.js
    //         ));
    //     catch (\Exception $e) {

    //     }
    // }



    public function charge() {

        if($this->membership_type == 'free')
            return true;

        \Stripe\Stripe::setApiKey(Yii::$app->params['stripeSecretKey']);

        if ($this->membership_type == 'full') {
            $price = 725 * 100;
        } else {
            $price = 420 * 100;
        }

        try {
            $response = \Stripe\Charge::create(array(
              "amount" => $price,
              "currency" => "usd",
              "source" => $this->cc_token, // obtained with Stripe.js
              "description" => "Charge for ".$this->fname." ".$this->lname
            ));

            // $this->stripe_id = $customer->id;

            // echo '<pre>';
            // var_dump($response);
            // echo '</pre>';
            // die();
            
            if($response->status == 'succeeded')
                return true;
        } 

        catch (\Stripe\Error\InvalidRequest $a) {
            $error = $a->getMessage();
            $this->addError('cc',$error );
        }

        catch(\Stripe\Error\Card $c) {
            $error = $c->getMessage();
            $this->addError('cc',$error );
        }

        catch (\Exception $e) {
            $error = $e->getMessage();
            $this->addError('cc',$error );
        }

        $this->addError('cc', 'There was an error processing your card.');
        return false;

    }




    public function revisePayment() {

        \Stripe\Stripe::setApiKey(Yii::$app->params['stripeSecretKey']);

        try {
            $response = \Stripe\Charge::create(array(
              "amount" => $this->membership_type == 'full' ? 58500 : 33750,
              "currency" => "usd",
              "source" => $this->cc_token, // obtained with Stripe.js
              "description" => "Remaining Balance Charge for ".$this->fname." ".$this->lname
            ));

            
            if($response->status == 'succeeded')
                return true;
        } 

        catch (\Stripe\Error\InvalidRequest $a) {
            $error = $a->getMessage();
            $this->addError('cc',$error );
        }

        catch(\Stripe\Error\Card $c) {
            $error = $c->getMessage();
            $this->addError('cc',$error );
        }

        catch (\Exception $e) {
            $error = $e->getMessage();
            $this->addError('cc',$error );
        }

        $this->addError('cc', 'There was an error processing your card.');
        return false;

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
                $this->created = time();
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


    public function resetPassword() 
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password_change);
        $this->auth_key = \Yii::$app->security->generateRandomString();
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
