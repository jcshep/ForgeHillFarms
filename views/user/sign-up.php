<?php

use app\models\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = 'Register for the 2021 Season';
// $this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('https://js.stripe.com/v2/');
$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
$this->registerJsFile('/js/payment-form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<div id="content" class="page user-create">

	<div class="spacer30"></div>
	
	<div class="container">
	<div class="row">

		<div class="col-sm-8 col-sm-offset-2 bg-white">
			
			<h2><?= Html::encode($this->title) ?></h2>
			
			<p>Please create an account using the form below.</p>

			<div class="project-form">



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

					<div class="row">
						<div class="col-md-6"><?= $form->field($model, 'password')->passwordInput() ?></div>
						<div class="col-md-6"><?= $form->field($model, 'password_repeat')->passwordInput() ?></div>
					</div>
					
					<div class="spacer30"></div>
					<?php  
						$options = [
							'full'=>Page::renderBlock('option-1'),
							'half'=>Page::renderBlock('option-2'),
							'free'=>Page::renderBlock('option-3'),
						];
					?>

					<?= $form->field($model, 'membership_type')->radioList($options, ['class'=>'membership-selection', 
							
                                'item' => function($index, $label, $name, $checked, $value) use ($model) {
                                		
                                		$checked = $value == $model->membership_type ? 'checked' : NULL;

                                		// Temporary: Disable memberships
	                                    if ($value == 'full' || $value == 'half' || $value == 'free') {
	                                    	$return = '<label class="modal-radio disabled '.$checked.'" data-membership-type="' . $value . '">';
	                                    } else {
	                                    	$return = '<label class="modal-radio '.$checked.'" data-membership-type="' . $value . '">';
	                                    }

                                		
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
						<?= 
	                        \szaboolcs\recaptcha\InvisibleRecaptcha::widget([
	                            'name'         => 'Create Account',
	                            'formSelector' => '#registration-form'
	                        ]);
	                    ?>
						<?php //echo Html::submitButton($model->isNewRecord ? 'Create Account' : 'Update', ['class' => 'btn btn-primary btn-lg']) ?>
						<div></div>
						<a href="login" class="btn btn-default">Already a member?</a>
					</div>

					<?php ActiveForm::end(); ?>

			</div>


		</div>
	</div> <!-- row -->

	</div><!-- container -->


</div>
