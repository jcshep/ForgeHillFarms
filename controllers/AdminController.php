<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\SearchUser;
use app\models\LoginForm;
use app\models\Product;
use app\models\Charge;
use app\models\SearchProduct;
use app\models\SearchNewsletter;
use app\models\ProductWeek;
use app\models\SearchProductWeek;
use app\models\SearchEmail;
use app\models\Email;
use app\models\Pickup;
use app\models\AppHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Setting;


class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [   'actions' => ['index','users','user-view','newsletter-list','weekly-overview','delete-product', 'product-add', 'remove-product','emails','email-generator', 'email-preview','scheduled-pickups','export-pickups','remove-cc', 'remove-email','duplicate-email'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                                                if(\Yii::$app->user->identity->access_level == 'admin')
                                                    return true;  
                                                }
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = 'backend';
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
 
        return $this->redirect(['weekly-overview']);
    }

    public function actionScheduledPickups()
    {


        if ($post = Yii::$app->request->post()) {

            $half_boxes_available = Setting::findOne(['setting'=>'half-boxes-available']);
            $half_boxes_available->value = $post['half-boxes-available'];
            $half_boxes_available->save();

            $full_boxes_available = Setting::findOne(['setting'=>'full-boxes-available']);
            $full_boxes_available->value = $post['full-boxes-available'];
            $full_boxes_available->save();

            return $this->redirect(Yii::$app->request->referrer);

        }

        return $this->render('scheduled-pickups', [
            // 'setting' => $setting,
            // 'dataProvider' => $dataProvider,
        ]);
    }


    public function actionNewsletterList()
    {
        $searchModel = new SearchNewsletter();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('newsletter-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUsers()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }





    public function actionUserView($id)
    {
        $model = User::findOne($id);
        $charge = new Charge();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->password_change)
                $model->resetPassword();

            if($model->save()) {
                Yii::$app->session->setFlash('success','User Updated');
                return $this->redirect(['user-view', 'id' => $model->id]);
            }

            return $this->redirect(Yii::$app->request->referrer);
        } 

        $charge->cc_token = Yii::$app->request->post('stripeToken');
        $charge->user_id = $model->id;

        if ($charge->load(Yii::$app->request->post()) && $charge->validate()) {

            // Save customer if new card
            if($charge->save_cc) {
                $charge->createCustomer();
                $model->refresh();
            }
            
            // Charge existing customer if they are saved
            if($model->stripe_id) {
                $charge->scenario = 'saved_cc';
                if($charge->chargeCustomer())
                    Yii::$app->session->setFlash('success','Customer Charged');
            }

            //One time charge on new card
            if(!$model->stripe_id) {
                $charge->scenario = 'new_cc';
                if($charge->singleCharge('Manual Admin Charge'))
                    Yii::$app->session->setFlash('success','Customer Charged');
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        
        
        return $this->render('user-view', [
            'model' => $model,
            'charge' => $charge,
        ]);
        
    }



    public function actionRemoveCc($id)
    {
        $user = User::findOne($id);
        $user->stripe_id = NULL;
        $user->stripe_last_4 = NULL;
        $user->save();

        Yii::$app->session->setFlash('error','Saved Card Removed');

        return $this->redirect(Yii::$app->request->referrer);
    }




    public function actionWeeklyOverview()
    {
        $product = new Product;
        $searchProduct = new SearchProduct();
        $productDataProvider = $searchProduct->search(Yii::$app->request->queryParams, 'product');
        $addonDataProvider = $searchProduct->search(Yii::$app->request->queryParams, 'addon');
        
        $searchProductWeek = new SearchProductWeek;
        $productWeekDataProvider = $searchProductWeek->search(
                                                            Yii::$app->request->queryParams, 
                                                            AppHelper::getCurrentWeekDates()['start'],
                                                            AppHelper::getCurrentWeekDates()['end']
                                                        );

        if ($product->load(Yii::$app->request->post()) && $product->save()) {
            Yii::$app->session->setFlash('success','Product Added');
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('weekly-overview', [
            'product' => $product,
            'searchProduct' => $searchProduct,
            'productDataProvider' => $productDataProvider,
            'addonDataProvider' => $addonDataProvider,
            'searchProductWeek' => $searchProductWeek,
            'productWeekDataProvider' => $productWeekDataProvider,
        ]);
    }


    public function actionDeleteProduct($id)
    {
        Product::findOne($id)->delete();
        Yii::$app->session->setFlash('error','Product Deleted');
        return $this->redirect(Yii::$app->request->referrer);

    }



    public function actionRemoveProduct($id)
    {
        ProductWeek::findOne($id)->delete();
        Yii::$app->session->setFlash('error','Product Removed');
        return $this->redirect(Yii::$app->request->referrer);

    }

    public function actionProductAdd($id,$s,$e)
    {

        $productWeek = new ProductWeek();
        $productWeek->product_id = $id;
        $productWeek->week_start = $s;
        $productWeek->week_end = $e;
        $productWeek->save();

        Yii::$app->session->setFlash('success','Product Added To Week');
        return $this->redirect(Yii::$app->request->referrer);
    }



    public function actionEmailGenerator($id = NULL)
    {
        $model = new Email;

         if($id)
           $model = Email::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if (Yii::$app->request->post('send-now')) {                
                Yii::$app->session->setFlash('success','Email Sent');
                $model->status = 'sent';
                $model->send_date = date("Y-m-d H:i:s");
                $model->send();
                $model->save();                                
                return $this->redirect(Yii::$app->request->referrer);
            }

            if (Yii::$app->request->post('saved')) { 
                Yii::$app->session->setFlash('success','Email Saved');
                $model->status = 'saved';
                $model->save();
                return $this->redirect(['admin/email-generator', 'id'=>$model->id]);
            }

            if (Yii::$app->request->post('scheduled')) { 
                Yii::$app->session->setFlash('success','Email Scheduled');
                $model->status = 'scheduled';
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            }


            if (Yii::$app->request->post('test-email')) { 
                Yii::$app->session->setFlash('success','Test Email Sent');
                $model->status = 'saved';
                $model->send('test');
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            }


            return $this->redirect(['email-generator', 'id' => $model->id]);            
        }

        

        return $this->render('email-generator', [
            'model' => $model,
        ]);

    }



    public function actionEmails()
    {

        $searchModel = new SearchEmail();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('emails', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    public function actionEmailPreview($id)
    {

        $model = Email::findOne($id);

        return $this->renderPartial('/mail/email-template', [
            'model'=>$model
        ]);

    }


    public function actionRemoveEmail($id)
    {
        Email::findOne($id)->delete();
        Yii::$app->session->setFlash('error','Email Deleted');
        return $this->redirect(Yii::$app->request->referrer);

    }


    public function actionDuplicateEmail($id)
    {
        $original = Email::findOne($id);

        $new = new Email;
        $new->type = $original->type;
        $new->status = $original->status;
        $new->content_area_1 = $original->content_area_1;
        $new->content_area_2 = $original->content_area_2;
        $new->content_area_3 = $original->content_area_3;
        $new->created = $original->created;
        $new->send_to = $original->send_to;

        if ($new->save()) {
            Yii::$app->session->setFlash('success','Email Duplicated');
        } else {
            Yii::$app->session->setFlash('error','Email Not Saved');
        }
        
        
        return $this->redirect('/admin/emails');

    }




    public function actionExportPickups() {
        $filename = 'pick-ups.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');


        // CSV headers
        $list = ["Pickup Day|Pickup Size|Customer Name|Customer Phone|Addons"];


        $pickups = Pickup::find()->joinWith('user')->where([
                'week'=>AppHelper::getCurrentWeekDates()['start'],
            ])->orderBy('pickup.day DESC, user.membership_type')->all();
        
        if ($pickups) :
            
            foreach ($pickups as $pickup):

                if($pickup->day != 'opt-out') :

                    $addons = '';
                    if ($pickup->addons):
                        foreach (json_decode($pickup->addons) as $addon):
                            $addons .= $addon.', ';
                        endforeach;
                    endif;

                    $list[] = 
                        $pickup->day.'|'.
                        $pickup->size.'|'.
                        $pickup->user->fname.' '.$pickup->user->lname.'|'.                    
                        $pickup->user->phone.'|'.                    
                        $addons;  
                endif;              

            endforeach;

        endif;

        // Export file 
        $file = fopen('php://output', 'w');
        foreach ($list as $line) {
            fputcsv($file, explode('|',$line));
        }
        fclose($file);

        exit;
        // return $this->redirect(Yii::$app->request->referrer);

    }



    
}








