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


        <div class="row">
            <div class="col-md-4 col-md-offset-4 bg-white">
                
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
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <a href="sign-up" class="btn btn-success">Create Account</a>
                        <a href="forgot-password" class="btn btn-default">Forgot Password?</a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
