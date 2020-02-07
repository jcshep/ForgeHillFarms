<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['admin/store-items']];
$this->params['breadcrumbs'][] = 'Update';


?>
<div class="user-update">

	<h1>
		<?= Html::encode($this->title) ?>
	</h1>
	
	<hr>
	
	<h3><?= $model->isNewRecord ? 'Create' : 'Update' ?> Product</h3>

	<div class="spacer30"></div>

	<div class="row">
		<div class="col-sm-12">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

			<?php echo $form->errorSummary($model); ?>


			<div class="row">
				<div class="col-sm-3">
					<?php  
					echo $form->field($model, 'in_store')->widget(SwitchInput::classname(), [
						'type' => SwitchInput::CHECKBOX
					])->label('Available for purchase?');
					?>
				</div> <!--col-->											
			</div> <!--row-->

			<div class="row">
				<div class="col-sm-2">
					<?= $form->field($model, 'price')->textInput(['maxlength' => true]);?>
				</div> <!--col-->	
			</div> <!--row-->

			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				</div> <!--col-->	
			</div> <!--row-->

			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'imageFile')->fileInput() ?>
					
					<img src="/<?php echo $model->getImage(); ?>?cache=<?= time(); ?>" alt="" class="product-thumb">
				</div> <!--col-->
			</div> <!--row-->
			
			<hr>

			<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div> <!--col-->
	</div> <!--row-->

    

</div>
