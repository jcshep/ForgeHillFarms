<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page page-login">

    <div id="content">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 bg-white">

                <div class="spacer30"></div>
                
                <h2><?= Html::encode($this->title) ?></h2>

                <?php if (Yii::$app->session->hasFlash('accountCreated')): ?>
                    <div class="alert bg-success"> Your Account has been created </div>
                <?php endif; ?>

                <?php if (Yii::$app->session->hasFlash('accountActivated')): ?>
                    <div class="alert bg-success"> Account Activated. You may now login.</div>
                <?php endif; ?>

                <?php if (Yii::$app->session->hasFlash('passwordResetEmailSent')): ?>
                    <div class="alert bg-success"> Please check your email for the password reset link.</div>
                <?php endif; ?>

                <?php if (Yii::$app->session->hasFlash('passwordResetComplete')): ?>
                    <div class="alert bg-success"> Your password was changed. You may now login.</div>
                <?php endif; ?>
                


                <p>Please fill out the following fields to login:</p>

                <?php $form = ActiveForm::begin(); ?>
                
                <div class="form-group">
                <?= $form->field($model, 'username')->textinput()->label('Email') ?>
                </div>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6"><?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?></div> <!--col-->
                        <div class="col-sm-6"><a href="sign-up" class="btn btn-secondary btn-block">Create Account</a></div> <!--col-->        
                    </div> <!--row-->
                    <div class="spacer15"></div>
                    <a href="forgot-password" class="btn btn-default btn-block">Forgot Password?</a>
         
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
