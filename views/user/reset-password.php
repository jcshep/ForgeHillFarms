<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Password Reset';

?>
<div class="page page-login">

    <div id="content">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 bg-white">

                <div class="spacer30"></div>
                
                <h2><?= Html::encode($this->title) ?></h2>

                <p>Please enter a new password below:</p>

                <?php $form = ActiveForm::begin(); ?>
                
                <div class="form-group">
                    <?= $form->field($model, 'password_change')->passwordinput()->label('New Password') ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'password_change_repeat')->passwordinput()->label('Repeat New Password') ?>
                </div>


                <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <a href="/forgot-password" class="btn btn-default">Go back to login</a>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
