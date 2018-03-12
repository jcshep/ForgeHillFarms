<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;




/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = 'Register for the 2018 Season';
// $this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div id="content" class="page user-create">

	<div class="spacer30"></div>
	
	<div class="container">
	<div class="row">

		<div class="col-sm-8 col-sm-offset-2 bg-white">
			
			<h2><?= Html::encode($this->title) ?></h2>
			
			<p>Please create an account using the form below.</p>

			<div class="project-form">

					<?php $form = ActiveForm::begin(); ?>

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

					<?= $form->field($model, 'membership_type') ->radioList(['full' => 'Full', 'half' => 'Half', 'free'=>'Free'], ['class'=>'membership-selection', 
							
                                'item' => function($index, $label, $name, $checked, $value) use ($model) {
                                		
                                		$checked = $value == $model->membership_type ? 'checked' : NULL;

                                		$return = '<label class="modal-radio '.$checked.'" data-membership-type="' . $value . '">';
	                                    $return .= '<div class="inside">';
	                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" '. $checked .' tabindex="3">';

                                		switch ($value) {
                                			case 'full': # code... break;
											$return .= '<h3>' . ucwords($label) . ' SHARE</h3>';
	                                    	$return .= '<p>Suitable for a family of four or more.</p>';
	                                    	$return .= '<h3>$650 SHARE</h3>';
                                		}

                                		switch ($value) {
                                			case 'half': # code... break;
											$return .= '<h3>' . ucwords($label) . ' SHARE</h3>';
	                                    	$return .= '<p>Suitable for an individual or a couple</p>';
	                                    	$return .= '<h3>$375 SHARE</h3>';
                                		}

                                		switch ($value) {
                                			case 'free': # code... break;
											$return .= '<h3>' . ucwords($label) . ' SHARE</h3>';
	                                    	$return .= '<p>Suitable for an individual or a couple</p>';
	                                    	$return .= '<h3><small>FULL SHARE</small> $32 <br> <small>HALF SHARE</small> $18</h3>';
                                		}

	                                    
	                                    $return .= '<div class="price"></div>';
	                                    $return .= '</div>';
	                                    $return .= '</label>';
	                                    return $return;
	                                }
                            
					])->label(false);?>
					
					<div class="spacer30"></div>


					<div class="credit-card-form">
						<?php echo $this->render('_ccform', [
								'model'=>$model,
								'form'=>$form]
							); ?>
						<div class="spacer30"></div>
					</div>


					<div class="form-group submit-group text-center" style="display:<?php if($model->membership_type) {echo 'block';} else {echo 'none';} ?>"">
						<?= Html::submitButton($model->isNewRecord ? 'Create Account' : 'Update', ['class' => 'btn btn-primary btn-lg']) ?>
						<div></div>
						<a href="login" class="btn btn-default">Already a member?</a>
					</div>

					<?php ActiveForm::end(); ?>

			</div>


		</div>
	</div> <!-- row -->

	</div><!-- container -->


</div>
