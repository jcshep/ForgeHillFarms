<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\SearchUser;
use app\models\LoginForm;
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
                    [   'actions' => ['index'],
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


    public function actionIndex()
    {

        $this->layout = 'backend';
        
        return $this->render('index', [
           
        ]);
    }




    
}
