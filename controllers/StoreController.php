<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Product;
use app\models\Newsletter;
use app\models\Cart;

class StoreController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['send-form'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }



    public function actionIndex()
    {
        $products = Product::find()->where(['in_store'=>1])->all();

        return $this->render('index', [
            'products' => $products
        ]);
    }


    public function actionCart()
    {
        $cart = Yii::$app->session->get('cart');

        $products = Product::find()->where(['id'=>$cart])->all();


        return $this->render('cart', [
            'products' => $products,
            'total'=>$this->getTotal()
        ]);
    }


    public function actionEmailTest()
    {
        $model = Cart::findOne(12);

        return $this->renderPartial('/mail/customer-store-notification-ready', [
            'model' => $model,
        ]);
    }

    public function actionCheckout()
    {
        $cart = Yii::$app->session->get('cart');

        if(empty($cart))
            return $this->redirect(['/store']);

        $products = Product::find()->where(['id'=>$cart])->all();

        $model = new Cart;
        $model->cc_token = Yii::$app->request->post('stripeToken');
        $model->cart = $cart;
        $model->total = $this->getTotal();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->charge() && $model->save() && $model->sendAdminNotification() && $model->sendCustomerNotification()) {

                    Yii::$app->session->open();
                    Yii::$app->session->set('cart', NULL);
                    Yii::$app->session->close();

                    return $this->redirect(['confirmation']);
            }                             
        }

        return $this->render('checkout', [
            'products' => $products,
            'model' => $model,
            'total'=>$this->getTotal()
        ]);
    }



    public function actionConfirmation()
    {
        return $this->render('confirmation', [
            // 'products' => $products,
            // 'model' => $model,
            // 'total'=>$this->getTotal()
        ]);
    }



    public function actionAddToCart ($id)
    {
        
        Yii::$app->session->open();
        $cart = Yii::$app->session->get('cart');
        $cart[] = (int)$id;
        Yii::$app->session->set('cart', $cart);
        Yii::$app->session->close();

        Yii::$app->session->setFlash('success','Product Added to Cart');

        return $this->redirect(['/store', '#'=>'anchor']);
        
    }

    public function actionRemoveFromCart($id)
    {
        Yii::$app->session->open();
        $cart = Yii::$app->session->get('cart');

        if (($key = array_search($id, $cart)) !== false) 
            unset($cart[$key]);
        
        Yii::$app->session->set('cart', $cart);
        Yii::$app->session->close();

        Yii::$app->session->setFlash('success','Product Removed from Cart');

        return $this->redirect(Yii::$app->request->referrer);
    }



    
    private function getTotal() 
    {
        Yii::$app->session->open();
        $cart = Yii::$app->session->get('cart');
        Yii::$app->session->close();

        $products = Product::find()->where(['id'=>$cart])->all();
        $total = 0;
        foreach ($products as $product) {
            $total = $total + $product->price;
        }

        return $total;
    }

    




}
