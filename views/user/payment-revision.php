<?php

use app\models\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = 'Register for the 2019 Season';
// $this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('https://js.stripe.com/v2/');
$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
$this->registerJsFile('/js/payment-form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>


<div id="content" class="page user-create revision">


	<div class="container">
	
		<h1>Payment Revision</h1>
	
		
	
		<p>Please use the form below to finalize your payment.</p>

		<p>
			If you selected the Full Share, you will be billed <strong>$585</strong>. <br>
			If you selected the Half Share, you will be billed <strong>$337.50</strong>
		</p>

		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<?php $form = ActiveForm::begin(['id'=>'payment-form']); ?>

				<?php if($model->errors) { ?>
				<div class="alert bg-danger">
					<?= $form->errorSummary($model); ?>
				</div>
				<?php } ?>

				<div class="row">
					<div class="col-md-6"><?= $form->field($model, 'fname')->textInput() ?></div>
					<div class="col-md-6"><?= $form->field($model, 'lname')->textInput() ?></div>
				</div>


				<div class="form-group">
					<?= $form->field($model, 'email')->textInput() ?>
				</div>

				<div class="form-group">
					<?= $form->field($model, 'phone')->textInput() ?>
				</div>

				<?php  
						$options = [
							'full'=>Page::renderBlock('option-1'),
							'half'=>Page::renderBlock('option-2'),
						];
					?>
					<?= $form->field($model, 'membership_type') ->radioList($options, ['class'=>'membership-selection', 
							
                                'item' => function($index, $label, $name, $checked, $value) use ($model) {
                                		
                                		$checked = $value == $model->membership_type ? 'checked' : NULL;

                                		$return = '<label class="modal-radio '.$checked.'" data-membership-type="' . $value . '">';
	                                    $return .= '<div class="inside">';
	                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '. $checked .' tabindex="3">';

                                		switch ($value) {
                                			case 'full': # code... break;
											$return .= '<h3>' . ucwords($label) . '</h3>';
	                                    	$return .= '<p>Suitable for a family of four or more.</p>';
	                                    	$return .= '<h3>$650 SHARE</h3>';
                                		}

                                		switch ($value) {
                                			case 'half': # code... break;
											$return .= '<h3>' . ucwords($label) . '</h3>';
	                                    	$return .= '<p>Suitable for an individual or a couple</p>';
	                                    	$return .= '<h3>$375 SHARE</h3>';
                                		}


	                                    
	                                    $return .= '<div class="price"></div>';
	                                    $return .= '</div>';
	                                    $return .= '</label>';
	                                    return $return;
	                                }
                            
					])->label(false);?>

				<div class="spacer30"></div>

				<div class="credit-card-form" <?php if($model->membership_type == 'half' || $model->membership_type == 'full') echo 'style="display:block"'; ?>>
					<?php echo $this->render('_ccform', [
							'model'=>$model,
							'form'=>$form]
						); ?>
					<div class="spacer30"></div>
				</div>


				<div class="form-group submit-group text-center" style="display:<?php if($model->membership_type) {echo 'block';} else {echo 'none';} ?>"">
					<?= Html::submitButton($model->isNewRecord ? 'Create Account' : 'Complete Payment', ['class' => 'btn btn-primary btn-lg']) ?>
				</div>

				<?php ActiveForm::end(); ?>
			</div> <!--col-->
		</div> <!--row-->
		
	</div>
</div>