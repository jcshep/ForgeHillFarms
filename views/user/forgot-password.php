<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Forgot Password';

?>
<div class="page page-password-reset">


        <div class="row">
            <div class="col-md-4 col-md-offset-4 bg-white">
                
                <h2><?= Html::encode($this->title) ?></h2>

                <p>Please enter your email to receive the password reset link:</p>

                <?php $form = ActiveForm::begin(); ?>
                
                
                <div class="form-group">
                    <?= $form->field($model, 'email')->textinput()->label('Email') ?>
                </div>


                <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <a href="login" class="btn btn-default">Go back to login</a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
