<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Charge extends \yii\db\ActiveRecord
{

    public $cc;
    public $cc_exp_month;
    public $cc_exp_year;
    public $cc_zip;
    public $cvc;
    public $save_cc;
    public $cc_token;
    public $amount;


    public static function tableName()
    {
        return 'charge';
    }


    public function rules()
    {
        return [
            
            [['cc', 'cc_exp_month', 'cc_exp_year', 'cvc', 'cc_zip', 'cc_token','amount'], 'required', 'on' => 'new_cc'],
            [['amount'], 'required', 'on' => 'saved_cc'],
            [['save_cc', 'user_id', 'cc_exp_month', 'cc_exp_year', 'cvc', 'cc_zip'], 'integer'],
            [['amount'], 'number'],
            
            
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function attributeLabels()
    {
        return [
            'cc' => 'Credit Card',
            'cc_zip' => 'Billing Zip',
            'save_cc' => 'Save Credit Card?',
        ];
    }    



    public function createCustomer() {
        
        \Stripe\Stripe::setApiKey(Yii::$app->params['stripeSecretKey']);

        $customer = \Stripe\Customer::create(array(
            'source'   => $this->cc_token,
            'email'    => $this->user->email,
        ));

        if(isset($customer->id)) {
            $this->user->stripe_id = $customer->id;
            $this->user->stripe_last_4 =$customer->sources->data[0]->last4;
            $this->user->save();

            return true;
        }

        return false;
    }



    public function chargeCustomer() {
        
        \Stripe\Stripe::setApiKey(Yii::$app->params['stripeSecretKey']);

        try {
            // Charge the order:
            $charge = \Stripe\Charge::create(array(
                'customer' => $this->user->stripe_id,
                "amount" => $this->amount * 100,
                "currency" => "usd",
                "description" => "Manual Admin Charge",
                )
            );



            return true;
        }

        catch (\Exception $e) {
            $error = $e->getMessage();
            $this->addError('cc',$error );
        }



        $this->addError('cc', 'There was an error charging the card on your account.');
        return false;
    }



    public function singleCharge($description = NULL) {

        \Stripe\Stripe::setApiKey(Yii::$app->params['stripeSecretKey']);

    
        try {
            $response = \Stripe\Charge::create(array(
              "amount" => $this->amount * 100,
              "currency" => "usd",
              "source" => $this->cc_token, // obtained with Stripe.js
              "description" => $description." - ".$this->user->email
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



    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }




}
