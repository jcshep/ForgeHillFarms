<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Cart extends \yii\db\ActiveRecord
{

	public static function tableName()
    {
        return 'store_order';
    }


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
    		[['email', 'fname', 'lname','phone','total'], 'required'],
    		[['user','order_date'],'integer'],
    		[['cart'],'safe'],
    	];
   }


   public function attributeLabels()
    {
        return [
        	'fname' => 'First Name',
        	'lname' => 'Last Name',
            'cc' => 'Credit Card',
        ];
    }



    public function sendAdminNotification()
    {

    	Yii::$app->mailer->compose('/mail/admin-store-notification', [
                    'model'=>$this
                ])
                ->setTo(Yii::$app->params['adminEmail'])
                // ->setFrom([Yii::$app->params['adminEmail'] => $this->name])
                ->setSubject('New Farm Store Purchase | Waiting for Pickup')
                ->send();
		
		return true;           
    }


    public function sendCustomerNotification()
    {

    	$mail = Yii::$app->mailer->compose('/mail/customer-store-notification', [
                    'model'=>$this
                ])
                ->setTo($this->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject('Forge Hill Farms | Preparing Your Order')
                ->send();
        
        return true;
    }


    public function sendCustomerNotificationReady()
    {

        $mail = Yii::$app->mailer->compose('/mail/customer-store-notification-ready', [
                    'model'=>$this
                ])
                ->setTo($this->email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject('Forge Hill Farms | Order Ready For Pickup')
                ->send();
        
        return true;
    }



   public function charge() {

        \Stripe\Stripe::setApiKey(Yii::$app->params['stripeSecretKey']);

        try {
            $response = \Stripe\Charge::create(array(
              "amount" => $this->total * 100,
              "currency" => "usd",
              "source" => $this->cc_token, // obtained with Stripe.js
              "description" => "Farm Store charge for ".$this->fname." ".$this->lname." | ".$this->email
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

    public function getFullname() {
        return $this->fname.' '.$this->lname;
    }

    public function beforeSave($insert) 
    {
    	if (parent::beforeSave($insert)) {
    		if($this->isNewRecord) {
	        	$this->cart = serialize($this->cart);
	        	$this->order_date = time();
    		}
	        
	        return true;
	    } else {
	    	return false;
	    }
    }


}
