<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use  yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->params['breadcrumbs'][] = ['label' => 'Emails', 'url' => ['admin/emails']];
$this->params['breadcrumbs'][] = 'Update';
?>


<h1>Email Creator</h1>

	<div class="spacer30"></div>

		<?php $form = ActiveForm::begin(); ?>

			<?php echo $form->errorSummary($model); ?>
			
			<div class="row">
				<div class="col-sm-6">
					
					<?= $form->field($model, 'content_area_1')->textarea(['class'=>'wysiwyg']) ?>

					<?= $form->field($model, 'content_area_2')->textarea(['class'=>'wysiwyg']) ?>

					<?= $form->field($model, 'content_area_3')->textarea(['class'=>'wysiwyg']) ?>

				</div> <!--col-->


				<div class="col-sm-4 col-sm-offset-1">
					<?= $form->field($model, 'type')->dropDownList(
					            ['weekly'=>'Weekly Product List & Scheduling Request','newsletter'=>'Newsletter'],
					            ['description'=>'test']
					       )->label('Email Layout'); ?>	

					<div class="spacer30"></div>

					<?= $form->field($model, 'send_date')->widget(DatePicker::className(),
		                [
	                    'language' => 'en',
	                    'clientOptions' =>[
	                    	'dateFormat' => 'F j, Y',
		                    'autoSize'=>true,		                    
		                    ],
		                 'options' => ['class' => 'form-control']
		                ])
		            ?>
		            <small>If you choose to "send now", this date will be ignored</small>
					
					<div class="spacer30"></div>
		            <?php 
						if($model->send_to) $model->send_to = json_decode($model->send_to);
						echo $form->field($model, 'send_to')->checkboxList(
							[0 => 'Full Members', 1 => 'Half Members', 2 => 'Free Members (Buyers Club)', 3 => 'Newsletter']
				   		);
				   	?>
				</div> <!--col-->

			</div> <!--row-->
			
			<div class="spacer30"></div>

		   <div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? 'Create & Preview' : 'Save & Update Preview', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				<div class="btn btn-info">Send Now</div>
			</div>

		<?php ActiveForm::end(); ?>

		<div class="spacer30"></div>


		<?php if (!$model->isNewRecord): ?>
			
			<h2>Preview</h2>
			<iframe src="/admin/email-preview/<?= $model->id ?>" frameborder="0" class="email-preview"></iframe>

		<?php endif ?>
		




















