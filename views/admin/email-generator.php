<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use  yii\jui\DatePicker;
use  app\models\User;
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
							['full' => 'Full Members', 'half' => 'Half Members', 'free' => 'Free Members (Buyers Club)', 'newsletter' => 'Newsletter']
				   		);
				   	?>
					<div class="spacer30"></div>
					<?= $form->field($model, 'test_email')->textInput(['maxlength' => true])->label('Send to Preview Email') ?>
					<input type="submit" name="test-email" value="Send Test" class="btn btn-info btn-xs">

				</div> <!--col-->

			</div> <!--row-->
			
			<div class="spacer30"></div>

		   <div class="form-group">				
				<?php if ($model->isNewRecord): ?>
					<input type="submit" name="saved" value="Create & Preview" class="btn btn-success">			
				<?php endif ?>

				<?php if (!$model->isNewRecord && $model->status != 'sent'): ?>
					<input type="submit" name="saved" value="Save & Update Preview" class="btn btn-success">
					<input type="submit" name="send-now" value="Send Now" class="btn btn-info">					
					<input type="submit" name="scheduled" value="Schedule" class="btn btn-info">		
				<?php endif ?>

				<?php if ($model->status == 'sent'): ?>
					<div class="alert alert-info">This email was sent on <?= date('F j', $model->send_date) ?> at <?= date('g:ia', $model->send_date) ?></div>
					<input type="submit" disabled="" name="saved" value="Save & Update Preview" class="btn btn-success">
					<input type="submit" disabled="" name="send-now" value="Send Now" class="btn btn-info">		
					<input type="submit" disabled="" name="scheduled" value="Schedule" class="btn btn-info">				
				<?php endif ?>
			</div>

		<?php ActiveForm::end(); ?>

		<div class="spacer30"></div>
		
		

		<?php if (!$model->isNewRecord): ?>
			
			<h2>Preview</h2>
			<iframe src="/admin/email-preview/<?= $model->id ?>" frameborder="0" class="email-preview"></iframe>

		<?php endif ?>
		















