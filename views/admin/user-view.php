<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->fname.' '.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1>
    	<?= Html::encode($this->title) ?> <br>
    	<small class="text-uppercase"><?= $model->membership_type ?> Membership</small>
    </h1>

    
	<div class="spacer30"></div>
	
	<div class="row">
		<div class="col-sm-4">
			<div class="well">
				<strong>Phone: </strong> <?= $model->phone ?> <br>
				<strong>Email: </strong> <a href="mailto:<?= $model->email ?> "><?= $model->email ?> </a><br>
				<strong>Registered Date:</strong> <?= date('F j, Y', $model->created) ?>
			</div>
		</div> <!--col-->
	</div> <!--row-->


	<h3>Update User</h3>

	<div class="row">
		<div class="col-sm-8">
			<?php $form = ActiveForm::begin(); ?>

			<?php echo $form->errorSummary($model); ?>

			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'membership_type')->hint('<small>Changing the membership type here will not charge the users card</small>')->dropDownList(
					            ['free'=>'Free','half'=>'Half Membership', 'full'=>'Full Membership'],
					            ['description'=>'test']
					        ); ?>					
				</div> <!--col-->
			</div>

			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
				</div> <!--col-->
				<div class="col-sm-6">
					<?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
				</div> <!--col-->
				<div class="col-sm-8">
					<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
				</div> <!--col-->
				<div class="col-sm-4">
					<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
				</div> <!--col-->
				<div class="col-sm-5">
					<?= $form->field($model, 'password_change')->textInput(['maxlength' => true]) ?>
				</div> <!--col-->
			</div> <!--row-->

			

			<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div> <!--col-->
	</div> <!--row-->

    

</div>
