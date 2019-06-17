<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\SearchUser;
use app\models\LoginForm;
use app\models\Pickup;
use app\models\AppHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Charge;
use app\models\Setting;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [   'actions' => ['index','create','update','view'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                                                if(\Yii::$app->user->identity->access_level == 'admin')
                                                    return true;  
                                                }
                    ],
                    [
                        'actions' => ['account','sign-up', 'payment-revision','set-pickup','remove-cc','select-plan'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['login','sign-up','forgot-password','reset-password'],
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                    ],

                ],
            ],
        ];
    }




    public function actionAccount()
    {


        $user = User::findOne(Yii::$app->user->identity->id);

        // Check if user doesn't have a membership level set
        if(!$user->membership_type) 
            return $this->redirect(['/user/select-plan']);

        $charge = new Charge();

        // Get pickup if exists
        $pickup = Pickup::find()->where([
            'week'=>AppHelper::getCurrentWeekDates()['start'],
            'user_id'=>Yii::$app->user->identity->id
        ])->one();


        $addons = NULL;
        if ($pickup && $pickup->addons) {
            $addons = json_decode($pickup->addons);
        }

        return $this->render('account', [
            'pickup'=>$pickup,
            'addons'=>$addons,
            'charge'=>$charge,
            'user' => $user
        ]);
    }



    



    public function actionRemoveCc()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->stripe_id = NULL;
        $user->stripe_last_4 = NULL;
        $user->save();

        Yii::$app->session->setFlash('error','Saved Card Removed');

        return $this->redirect(Yii::$app->request->referrer);
    }



    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (\Yii::$app->user->identity->access_level == 'admin') {
                    return $this->redirect(['/']);
                } else {
                    return $this->goBack();
                    // return $this->redirect(['/user/account']);
                }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/']);
    }



    public function actionSignUp()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/user/account']);
        }

        $model = new User(['scenario' => 'insert']);

        $model->membership_type = Yii::$app->request->get('type');
        $model->cc_token = Yii::$app->request->post('stripeToken');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {



            if($model->charge() && $model->save()) {

                //Send activation email
                Yii::$app->mailer->compose('/mail/welcome')
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($model->email)
                    ->setSubject('Welcome')
                    ->send();

                // Yii::$app->session->setFlash('accountCreated');

                // Log user in directly
                Yii::$app->user->login($model, 3600*24*30);

                if (\Yii::$app->user->identity->access_level == 'admin') {
                    return $this->redirect(['/']);
                } else {
                    return $this->redirect(['/user/account']);
                }
                
            }
        }

        return $this->render('sign-up', [
            'model' => $model,
        ]);
    }




    public function actionSelectPlan()
    {

        $model = User::findOne(Yii::$app->user->identity->id);

        $model->membership_type = Yii::$app->request->get('type');
        $model->cc_token = Yii::$app->request->post('stripeToken');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            if($model->charge() && $model->save()) {
                return $this->redirect(['/user/account']);
            }
            
        }

        return $this->render('select-plan', [
            'model' => $model
        ]);

    }





    public function actionForgotPassword()
    {
        $model = new \app\models\ForgotPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = User::findOne(['email' => $model->email]);

            if($user) {
                //Send activation email
                Yii::$app->mailer->compose('/mail/passwordReset',[
                    'auth_key' => $user->auth_key
                    ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($user->email)
                ->setSubject('Password Reset')
                ->send();

                Yii::$app->session->setFlash('passwordResetEmailSent');

                return $this->redirect(['user/login']);
            }
        }

        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }


    public function actionResetPassword()
    {
        // Redirect if not match
        if(!isset($_GET['auth_key'])) 
            return $this->redirect(Yii::$app->params['siteUrl']);

        $auth_key = $_GET['auth_key'];

        $model = User::findOne(['auth_key' => $auth_key]);

        // Redirect if not match
        if(!$model) 
            return $this->redirect(Yii::$app->params['siteUrl']);
        
        // Set scenario
        $model->scenario = 'passwordReset';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('passwordResetComplete');
            return $this->redirect(['/user/login']);
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);

    }





    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'insert']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }




    public function actionPaymentRevision()
    {

        $model = User::findOne(Yii::$app->user->identity->id);
        $model->scenario = 'revision';

        $model->cc_token = Yii::$app->request->post('stripeToken');

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->revisePayment()) {
            

            Yii::$app->session->setFlash('success','Thank you for finalizing your payment.');
            return $this->redirect('/user/account');

        } else {
            return $this->render('payment-revision', [
                'model' => $model,
            ]);
        }


    }



    public function actionSetPickup()
    {
        Yii::$app->controller->enableCsrfValidation = false;

        $user = User::findOne(Yii::$app->user->identity->id);

        if(Yii::$app->request->post('id')) {
            $model = Pickup::findOne(Yii::$app->request->post('id'));
            $new_model = false;
            $previous_day = $model->day;
        } else {
            $model = new Pickup();
            $model->user_id = Yii::$app->user->identity->id;
            $model->week = AppHelper::getCurrentWeekDates()['start'];
            $new_model = true;
        }



        // If user is free member
        if(Yii::$app->request->post('membership-type') == 'free') {

            $charge = new Charge();
            $charge->cc_token = Yii::$app->request->post('stripeToken');
            $charge->user_id = $user->id;

            if ($charge->load(Yii::$app->request->post()) && $charge->validate()) {

                // Save customer if new card
                if($charge->save_cc) {
                    $charge->createCustomer();
                    $user->refresh();
                }

                // Charge existing customer if they are saved
                if($user->stripe_id) {
                    $charge->scenario = 'saved_cc';
                    if(!$charge->chargeCustomer()) {
                        Yii::$app->session->setFlash('error','There was an issue charging your card. Please try again.');
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }

                //One time charge on new card
                if(!$user->stripe_id) {
                    $charge->scenario = 'new_cc';
                    if(!$charge->singleCharge('Buyers Club Purchase')) {
                        Yii::$app->session->setFlash('error','There was an issue charging your card. Please try again.');
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }

            }
        }


        // Save pickup time
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (!$model->day) {
                Yii::$app->session->setFlash('error','Please verify you selected a pickup day.');
                return $this->redirect(['/user/account']);
            }
            
            

            // Charge (if necessary)
            $charge = new Charge();
            if ($charge->load(Yii::$app->request->post()) && $charge->amount && $charge->validate()) {
                
                $charge->cc_token = Yii::$app->request->post('stripeToken');
                $charge->user_id = $user->id;

                // Save customer if new card
                if($charge->save_cc) {
                    $charge->createCustomer();
                    $user->refresh();
                }

                // Charge existing customer if they are saved
                if($user->stripe_id) {
                    $charge->scenario = 'saved_cc';
                    if(!$charge->chargeCustomer()) {
                        Yii::$app->session->setFlash('error','There was an issue charging your account. Please try again.');
                        return $this->redirect(['/user/account']);
                    }
                }

                //One time charge on new card
                if(!$user->stripe_id) {
                    $charge->scenario = 'new_cc';


                    if(!$charge->singleCharge('Add On Purchase')) {
                        Yii::$app->session->setFlash('error','There was an issue charging your card. Please try again.');
                        return $this->redirect(['/user/account']);
                    }
                }

                Yii::$app->session->setFlash('success','Your addons have been purchased.');
            }
            
            if ($model->save()) 
                Yii::$app->session->setFlash('success','Your pickup day has been saved.');



            
            // Only do incrementation on new pickup
            if($new_model && $model->day != 'opt-out') {
                // If successful, deduct an available corresponding box
                $boxes_available = Setting::findOne(['setting'=>$model->size.'-boxes-available']);
                $boxes_available->value = ($boxes_available->value - 1);
                $boxes_available->save();
            }

            // Check if CHANGING TOO opting out and increase by 1
            if(!$new_model && $previous_day != 'opt-out' && $model->day == 'opt-out') {
                $boxes_available = Setting::findOne(['setting'=>$model->size.'-boxes-available']);
                $boxes_available->value = ($boxes_available->value + 1);
                $boxes_available->save();
            }


            // Check if previously selected opt-out, then changed to day
            if(!$new_model && $previous_day == 'opt-out' && $model->day != 'opt-out') {
                $boxes_available = Setting::findOne(['setting'=>$model->size.'-boxes-available']);
                $boxes_available->value = ($boxes_available->value - 1);
                $boxes_available->save();
            }


        } 

        return $this->redirect(Yii::$app->request->referrer);
        
    }

    



    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    
}
