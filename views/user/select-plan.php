<?php  

use app\models\ProductWeek;
use app\models\Setting;
use yii\widgets\ActiveForm;
use app\models\Page;
use yii\helpers\Html;

$membership_type = Yii::$app->user->identity->membership_type;


$this->registerJsFile('https://js.stripe.com/v2/');
$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
$this->registerJsFile('/js/payment-form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


?>



<div class="spacer30"></div>

<div id="account">
	
	<div class="container">

		<?php if($flashMessage = Yii::$app->session->getFlash('error')): ?>
			<div class="alert alert-danger"><?= $flashMessage ?></div>
		<?php endif; ?>

		<?php if($flashMessage = Yii::$app->session->getFlash('success')): ?>
			<div class="alert alert-success"><?= $flashMessage ?></div>
		<?php endif; ?>
		
		<div id="content">
		
	
			<div class="user-create">

					<h2>Please select your plan for the 2020 season</h2>

					<p>Your previous account information will stay the same.</p>

					<?php $form = ActiveForm::begin(['id'=>'payment-form']); ?>

					<?php if($model->errors) { ?>
					<div class="alert bg-danger">
						<?= $form->errorSummary($model); ?>
					</div>
					<?php } ?>

					
					
					<div class="spacer30"></div>
					<?php  
						$options = [
							'full'=>Page::renderBlock('option-1'),
							'half'=>Page::renderBlock('option-2'),
							'free'=>Page::renderBlock('option-3'),
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
	                                    	$return .= '<h3>$'.Page::renderBlock('option-1-price').'</h3>';
                                		}

                                		switch ($value) {
                                			case 'half': # code... break;
											$return .= '<h3>' . ucwords($label) . '</h3>';
	                                    	$return .= '<p>Suitable for an individual or a couple</p>';
	                                    	$return .= '<h3>$'.Page::renderBlock('option-2-price').'</h3>';
                                		}

                                		switch ($value) {
                                			case 'free': # code... break;
											$return .= '<h3>' . ucwords($label) . '</h3>';
	                                    	$return .= '<p>Purchase share boxes individually</p>';
	                                    	$return .= '<h3><small>FULL SHARE</small> $'.Page::renderBlock('full-share-week-price').' <br> <small>HALF SHARE</small> $'.Page::renderBlock('half-share-week-price').'</h3>';
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
						<?= Html::submitButton($model->isNewRecord ? 'Create Account' : 'Select', ['class' => 'btn btn-primary btn-lg']) ?>
						<div></div>
					</div>

					<?php ActiveForm::end(); ?>

			</div>
		
		
		
		


		<div class="spacer30"></div>
		</div> <!-- content -->
	</div>	

</div>