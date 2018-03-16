<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\SearchUser;
use app\models\LoginForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                        'actions' => ['account','sign-up'],
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionAccount()
    {
        return $this->render('account', [
            
        ]);
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
                    return $this->redirect(['/user/account']);
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

        $model = new User();

        $model->membership_type = Yii::$app->request->get('type');
        $model->cc_token = Yii::$app->request->post('stripeToken');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {



            if($model->charge() && $model->save()) {

                //Send activation email
                // Yii::$app->mailer->compose('/mail/default',[
                //     'auth_key' => $model->auth_key
                //     ])
                // ->setFrom('info@globaltravelalliance.com')
                // ->setTo($model->email)
                // ->setSubject('Global Travel Alliance - Account Activation')
                // ->send();

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
            return $this->redirect(['user/login']);
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
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
