<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\SearchUser;
use app\models\LoginForm;
use app\models\Product;
use app\models\SearchProduct;
use app\models\ProductWeek;
use app\models\SearchProductWeek;
use app\models\SearchEmail;
use app\models\Email;
use app\models\AppHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [   'actions' => ['index','users','user-view','weekly-overview','delete-product', 'product-add', 'remove-product','emails','email-generator', 'email-preview','scheduled-pickups'],
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
 
        return $this->render('scheduled-pickups', [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->password_change)
                $model->resetPassword();

            if($model->save()) {
                Yii::$app->session->setFlash('success','User Updated');
                return $this->redirect(['user-view', 'id' => $model->id]);
            }
            
        } else {
            return $this->render('user-view', [
                'model' => $model,
            ]);
        }
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
                return $this->redirect(Yii::$app->request->referrer);
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



    
}








