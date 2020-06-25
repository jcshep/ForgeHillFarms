<?php  

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Checkout';
// $this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('https://js.stripe.com/v2/');
$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
$this->registerJsFile('/js/payment-form-store.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>



<div id="store" class="checkout">

	<div class="container narrow">

		<div id="content" class="text-center">
			<h2>CHECKOUT</h2>
			<p>You may pick up your order either on Thursdays from 4-7 pm or Saturdays 10 am - 12 noon.  Please drive to the back of the barn to park and then come to the table in the pick up area to let us know your name so we can get your order for you.  We are located at 404 Creek Road Downingtown PA. If you are unable to pick up on these days or if you forget to pick up please email <a href="mailto:jennifer@forgehillfarms.com">jennifer@forgehillfarms.com</a>.</p>
		</div>
	

		<?php if($flashMessage = Yii::$app->session->getFlash('success')): ?>
			<div class="alert alert-success text-center"><?= $flashMessage ?></div>
		<?php endif; ?>



		<div class="spacer30"></div>


	
		<div id="content">
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

			<div class="row">
				<div class="col-md-6"><?= $form->field($model, 'email')->textInput() ?></div>
				<div class="col-md-6"><?= $form->field($model, 'phone')->textInput() ?></div>
			</div>
			
			
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<?php echo $this->render('/user/_ccform', [
						'model'=>$model,
						'form'=>$form
					]); ?>
				</div> <!--col-->
			</div> <!--row-->

			
			<div class="spacer30"></div>

			<div class="totals text-right">
				<h3><small>TOTAL</small> $<?= number_format($total, 2) ?></h3>
			</div>

			<div class="row">
				<div class="col-md-6">
					<a href="/store/cart" class="btn btn-secondary"><i class="fa fa-chevron-left"></i> Back To Cart</a>
				</div> <!--col-->
				<div class="col-md-6 text-right">				
					<?= Html::submitButton('Submit Payment', ['class' => 'btn btn-primary']) ?>
				</div> <!--col-->
			</div> <!--row-->
		
		<?php ActiveForm::end(); ?>
		</div>


	</div>

</div> <!-- #store -->