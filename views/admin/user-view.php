<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->fname.' '.$model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['admin/users']];
$this->params['breadcrumbs'][] = 'Update';



$this->registerJsFile('https://js.stripe.com/v2/');
$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
$this->registerJsFile('/js/manual-payment-form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


?>
<div class="user-update">

	<div class="row">
		<div class="col-sm-6">
			<h1>
				<?= Html::encode($this->title) ?> <br>
				<small class="text-uppercase"><?= $model->membership_type ?> Membership</small>
			</h1>
		</div> <!--col-->
		<div class="col-sm-6">
			<div class="spacer30"></div>
			
			<div class="text-right">
				<a data-toggle="modal" href="#modal-charge" class="btn btn-success"> <i class="fa fa-credit-card"></i> Create Charge </a>			
			</div>
			
			<!-- Modal -->
			<div class="modal fade" id="modal-charge" tabindex="-1" role="dialog">
			    <div class="modal-dialog" role="document">
			        <div class="modal-content">
			           	<?php 
			           		$form = ActiveForm::begin(['id'=> $model->stripe_id ? 'saved-payment-form' : 'payment-form']); 
			           	?>
			            <div class="modal-body">
			                <div class="credit-card-form">			
								
								<?= $form->errorSummary($charge); ?>

								<div class="row">
									<div class="col-sm-4">
										<?= $form->field($charge, 'amount')->label('Charge Amount') ?>
									</div> <!--col-->
								</div> <!--row-->								
								
								<?php if($model->stripe_id) { ?>
									
									<p>Using Saved Credit Card</p>
									<div class="saved-cc">•••• •••• •••• <?= $model->stripe_last_4 ?></div>
								<?php } else { ?>
									
									<?php echo $this->render('/user/_ccform', [
										'model'=>$charge,
										'form'=>$form]
									); ?>

									<?= $form->field($charge, 'save_cc')->checkbox() ?>	

								<?php } ?>
								
								
															
							</div>
			            </div>
			            <div class="modal-footer">
			            	<?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
			                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>           
			            </div>
			            <?php ActiveForm::end(); ?>
			        </div>
			    </div>
			</div>
		</div> <!--col-->
	</div> <!--row-->
    

    
	<div class="spacer30"></div>
	
	<div class="row">
		<div class="col-sm-4">
			<div class="well">
				<strong>Phone: </strong> <?= $model->phone ?> <br>
				<strong>Email: </strong> <a href="mailto:<?= $model->email ?> "><?= $model->email ?> </a><br>
				<strong>Registered Date:</strong> <?= date('F j, Y', $model->created) ?>
			</div>
		</div> <!--col-->
		<div class="col-sm-4 col-sm-offset-1">
			<div class="well">
				<strong>Credit Card</strong>
				
				<?php if($model->stripe_id) { ?>
													
					<div class="saved-cc">•••• •••• •••• <?= $model->stripe_last_4 ?></div>
					<a href="/admin/remove-cc/<?= $model->id ?>" class="delete text-danger small"><i class="fa fa-close"></i> Remove Card</a>
				<?php } else { ?>
					
					<p>No card on file</p>

				<?php } ?>

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
