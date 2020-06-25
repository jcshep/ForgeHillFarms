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

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(Yii::$app->params['adminEmail']);
        $email->addTo(Yii::$app->params['adminEmail']);
        $email->setSubject('New Farm Store Purchase | Waiting for Pickup');
        $email->addContent("text/html", Yii::$app->controller->renderPartial('/mail/admin-store-notification', ['model'=>$this]));
        $sendgrid = new \SendGrid(Yii::$app->params['sendgridApiKey']);
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {            
                    // Yii::$app->session->setFlash('error', $e->getMessage());  
        }
		
		return true;           
    }


    public function sendCustomerNotification()
    {


        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(Yii::$app->params['adminEmail']);
        $email->addTo($this->email);
        $email->setSubject('Forge Hill Farms | Order Received');
        $email->addContent("text/html", Yii::$app->controller->renderPartial('/mail/customer-store-notification', ['model'=>$this]));
        $sendgrid = new \SendGrid(Yii::$app->params['sendgridApiKey']);
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {            
                    // Yii::$app->session->setFlash('error', $e->getMessage());  
        }
        
        return true;
    }


    public function sendCustomerNotificationReady()
    {

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(Yii::$app->params['adminEmail']);
        $email->addTo($this->email);
        $email->setSubject('Forge Hill Farms | Order Ready For Pickup');
        $email->addContent("text/html", Yii::$app->controller->renderPartial('/mail/customer-store-notification-ready', ['model'=>$this]));
        $sendgrid = new \SendGrid(Yii::$app->params['sendgridApiKey']);
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {            
                    // Yii::$app->session->setFlash('error', $e->getMessage());  
        }
        
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
