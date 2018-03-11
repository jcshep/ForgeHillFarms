<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = 'Register for the 2018 Season';
// $this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="page user-create">

	<div class="row">

		<div class="col-sm-6 col-sm-offset-3 bg-white">
			
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
							
                                'item' => function($index, $label, $name, $checked, $value) {

                                		// switch ($value) {
                                		// 	case 'value': # code... break;
                                		// }

	                                    $return = '<label class="modal-radio" data-membership-type="' . $value . '">';
	                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
	                                    $return .= '<i></i>';
	                                    $return .= '<h3>' . ucwords($label) . '</h3>';
	                                    $return .= '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed facilisis pretium enim at rhoncus. </p>';
	                                    $return .= '<div class="price"></div>';
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


					<div class="form-group submit-group text-center">
						<?= Html::submitButton($model->isNewRecord ? 'Create Account' : 'Update', ['class' => 'btn btn-primary btn-lg']) ?>
						<div></div>
						<a href="login" class="btn btn-default">Already a member?</a>
					</div>

					<?php ActiveForm::end(); ?>

			</div>


		</div>
	</div> <!-- row -->


</div>
