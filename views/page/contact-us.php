<?php

use app\models\Page;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Forge Hill Farms | Community Supported Farm | CSA by the Brandywine';
?>


<div id="hero">
	<div class="container">
		<?= Page::editBlock('hero-image-'.$model->slug,'image','Edit Image', 'hero'); ?>
		<img src="/uploads/<?= Page::renderBlock('hero-image-'.$model->slug); ?>" alt="">
	</div>
</div>

<div class="spacer30"></div>



<div id="content">
	<div class="container">
		<div class="row">
			
			


			<div class="col-sm-6 col-sm-push-3">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<h1>Contact Us</h1>

				<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

			        <div class="alert alert-success">
			            Thank you for contacting us. We will respond to you as soon as possible.
			        </div>

				    <?php else: ?>

			                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
								
								<?= $form->errorSummary($contactForm); ?>
								
			                    <?= $form->field($contactForm, 'name') ?>

			                    <?= $form->field($contactForm, 'email') ?>

			                    <?= $form->field($contactForm, 'subject') ?>

			                    <?= $form->field($contactForm, 'body')->textArea(['rows' => 6]) ?>


			                    <div class="form-group">
			                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
			                    </div>

			                <?php ActiveForm::end(); ?>

				    <?php endif; ?>


			</div> <!--col-->

			<div class="col-sm-3 col-sm-pull-6">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<?php echo $this->render('/page/_sidebar-3'); ?>
	
			</div> <!--col-->

		
			<!-- Sidebar -->
			<div class="col-sm-3">
				<?php echo $this->render('/page/_sidebar-2'); ?>
			</div> <!--col-->
			<!-- Sidebar -->
		</div> <!--row-->
	</div>
</div>














