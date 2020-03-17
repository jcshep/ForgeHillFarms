<?php  

use app\models\ProductWeek;
use app\models\Setting;
use yii\widgets\ActiveForm;
use app\models\Page;

$membership_type = Yii::$app->user->identity->membership_type;

if($membership_type == 'free') {
	$this->registerJsFile('https://js.stripe.com/v2/');
	$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
	$this->registerJsFile('/js/manual-payment-form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
} else {
	$this->registerJsFile('https://js.stripe.com/v2/');
	$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
	$this->registerJsFile('/js/member-addon-payment.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
}

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

			<div class="spacer60"></div>

			<h3>Please check back when season begins in June to select your pickup day.</h3>

			<div class="spacer60"></div>
			<div class="spacer60"></div>

		<?php /* 
		<div class="row">
			<div class="col-sm-6">
				<h3>This Week's Haul</h3>		
				
				<div class="date"><?php echo date('m.d.Y') ?></div>
				<?php echo ProductWeek::generateWeeklyList(); ?>

			</div> <!--col-->
			<div class="col-sm-6">

				<div class="box">
					<span class="membership-type">Membership Level: <strong><?= $membership_type ?></strong></span>
					<div class="inner">

						
						

						
						<?php if ($pickup && $membership_type == 'free'): ?>
							<div class="spacer30"></div>
							<h3 class="text-center">Confirmed</h3>
							<center>Your purchase has been confirmed. Thank you!</center>
							<div class="spacer30"></div>
						<?php else: ?>
						

						<h3 class="text-center">Select your pickup day</h3>

						<div id="pickup-selection">
							
							<?php if ($membership_type == 'free' && !$user->stripe_id): ?>
								<?php $form = ActiveForm::begin(['action'=>'/user/set-pickup', 'id'=> 'payment-form']); ?>	
							<?php else: ?>
								<?php $form = ActiveForm::begin(['action'=>'/user/set-pickup', 'id'=> 'pickup-form']); ?>	
							<?php endif ?>
							
							

							



							<!-- <form action="/user/set-pickup" method="POST" <?php if ($membership_type == 'free'): ?>id="payment-form"<?php endif; ?>> -->
							
							<?php if (date('w') < 4): ?>
								<a href="" data-day="thursday" class="btn btn-secondary btn-block day <?php if($pickup && $pickup->day == 'thursday') echo 'active' ?>"><i class="fa fa-check"></i> Thursday <?php echo date('F j', strtotime('next thursday')) ?></a>			
							<?php else: ?>
								<a href="" class="btn btn-secondary btn-block disabled <?php if($pickup && $pickup->day == 'thursday') echo 'active' ?>"><i class="fa fa-check"></i> Thursday</a>			
							<?php endif ?>
								
								<a href="" data-day="saturday" class="btn btn-secondary btn-block day <?php if($pickup && $pickup->day == 'saturday') echo 'active' ?>"><i class="fa fa-check"></i> Saturday <?php echo date('F j', strtotime('next saturday')) ?></a>
							
							<?php if ($membership_type != 'free'): ?>
								<a href="" data-day="opt-out" class="btn btn-secondary btn-block day <?php if($pickup && $pickup->day == 'opt-out') echo 'active' ?>"><i class="fa fa-check"></i> Opt Out</a>
							<?php endif ?>
							
							
							<?php if ($membership_type == 'free'): ?>
								<div class="spacer15"></div>
								<h3 class="text-center">Select share size</h3>

								<?php if (Setting::findOne(['setting'=>'full-boxes-available'])->value == 0): ?>
									<a href="" data-size="full" class="btn btn-secondary btn-block size disabled"><i class="fa fa-check"></i> Full $<?= Page::renderBlock('full-share-week-price'); ?> - Sold Out</a>
								<?php else: ?>
									<a href="" data-size="full" class="btn btn-secondary btn-block size"><i class="fa fa-check"></i> Full $<span id="full-value"><?= Page::renderBlock('full-share-week-price'); ?></span></a>
								<?php endif ?>


								<?php if (Setting::findOne(['setting'=>'half-boxes-available'])->value == 0): ?>
									<a href="" data-size="half" class="btn btn-secondary btn-block size disabled"><i class="fa fa-check"></i> Half $<?= Page::renderBlock('half-share-week-price'); ?> - Sold Out</a>
								<?php else: ?>
									<a href="" data-size="half" class="btn btn-secondary btn-block size"><i class="fa fa-check"></i> Half $<span id="half-value"><?= Page::renderBlock('half-share-week-price'); ?></span></a>
								<?php endif ?>
									

								
							<?php endif ?>


							<div class="hidden">
								<input type="radio" name="Pickup[day]" value="thursday" class="thursday" <?php if($pickup && $pickup->day == 'thursday') echo 'checked' ?>>
								<input type="radio" name="Pickup[day]" value="saturday" class="saturday" <?php if($pickup && $pickup->day == 'saturday') echo 'checked' ?>>
								<input type="radio" name="Pickup[day]" value="opt-out" class="opt-out" <?php if($pickup && $pickup->day == 'opt-out') echo 'checked' ?>>
						
								<input type="radio" name="Pickup[size]" value="half" class="half size" <?php if($membership_type == 'half') echo 'checked' ?>>
								<input type="radio" name="Pickup[size]" value="full" class="full size" <?php if($membership_type == 'full') echo 'checked' ?>>
							</div>
							
							<div class="spacer30"></div>
							
							<input type="hidden" name="Pickup[addons]" value="">

							<?php if(ProductWeek::getWeeklyAddonsNonpayment()): ?>	


								<div class="text-center add-ons">
									<h3>Reserve Addons</h3>
									
									<?php foreach (ProductWeek::getWeeklyAddonsNonpayment() as $addon): ?>
										
										<label>
											<input type="checkbox" name="Pickup[addons][]" value="<?= $addon->product->name; ?>" <?php if($addons && in_array($addon->product->name, $addons)){echo 'checked';} ?>>
											<?= $addon->product->name; ?>
											<?php if ($addon->product->price): ?>
												<span class="pull-right">$<?= $addon->product->getPrice(); ?></span>	
											<?php endif ?>
											
										</label>
									
									<?php endforeach; ?>
									
									<div class="spacer15"></div>
									<div class="description">
										Reserved addons are not guaranteed but will help us in estimating the demand so we can be prepared.
									</div>
									<div class="spacer30"></div>
								</div>


							<?php endif;  ?>





							<?php if(ProductWeek::getWeeklyAddonsPaid()): ?>	


								<div class="text-center add-ons purchase">
									<h3>Purchase AddOns</h3>

									<?php foreach (ProductWeek::getWeeklyAddonsPaid() as $addon): ?>
										
										<label>
											<input class="purchaseble-add-on" data-price="<?= $addon->product->price; ?>" type="checkbox" name="Pickup[addons][]" value="<?= $addon->product->name; ?>" <?php if($addons && in_array($addon->product->name, $addons)){echo 'checked';} ?>>
											<?= $addon->product->name; ?>
											<span class="pull-right">$<?= $addon->product->getPrice(); ?></span>
										</label>
									
									<?php endforeach; ?>
									<div class="spacer30"></div>
								</div>

								
							<?php endif;  ?>



							
							<?php if($pickup) : ?>
								<input type="hidden" name="id" value="<?= $pickup->id ?>">								
							<?php endif; ?>




							<?php if ($membership_type != 'free'): ?>
								
								<input type="submit" name="confirm" value="Confirm" class="btn btn-block btn-primary btn-submit">

								<a data-toggle="modal" data-target="#modal-pay" class="btn btn-block btn-secondary hidden" id="addon-modal">Purchase AddOns & Confirm</a>
								
								<?php  
									echo $this->render('/user/_addon-payment', [
										'user'=>$user,
										'charge'=>$charge,
										'user'=>$user,
										'form'=>$form]
									); 
								?>
				


							<?php else: ?>
								
								<input type="hidden" name="membership-type" value="<?= $membership_type ?>">

								<a data-toggle="modal" data-target="#modal-pay" class="btn btn-block btn-primary" id="pay-modal">Purchase</a>
								
								<!-- Modal -->
								<div class="modal fade" id="modal-pay" tabindex="-1" role="dialog">
								    <div class="modal-dialog" role="document">
								        <div class="modal-content">
								            <div class="modal-body">
								            	<?php if ($user->stripe_id) { ?>
								            		
								            		<h3>Using Saved Credit Card</h3>
													<div class="saved-cc"><span>xxxx xxxx xxxx </span> <?= $user->stripe_last_4 ?> </div>
								            	<?php } ?>

								                <?php 
								                if (!$user->stripe_id) {
									                echo $this->render('/user/_ccform', [
														'model'=>$charge,
														'form'=>$form]
													); 
												}
												?>
								            </div>
								            <div class="modal-footer">
								            	<div class="row">
								            		<div class="col-sm-6 save-cc">
								            			<?php 
								            			if (!$user->stripe_id) 
								            				echo $form->field($charge, 'save_cc')->checkbox();
								            			?>	

								            			<?php if ($user->stripe_id) { ?>
								            				<a href="/user/remove-cc" class="remove-card"><i class="fa fa-close"></i> Remove Saved Credit Card</a>
								            			<?php } ?>	

								            		</div> <!--col-->
								            		<div class="col-sm-6">
								            			$<input type="text" name="Charge[amount]" value="" class="charge-amount">
								            			<button type="submit" class="btn btn-primary">Confirm</button>
								            		</div> <!--col-->
								            	</div> <!--row-->
								            	
								            </div>
								        </div>
								    </div>
								</div>

							<?php endif; ?>

							<?php ActiveForm::end(); ?>

						</div>

						
						<?php endif //End if user is free / already purchased ?>	
						
					</div> <!-- inner -->		
				</div>
			</div> <!--col-->
		</div> <!--row-->
		*/ ?>

		
		
		
		


		<div class="spacer30"></div>
		</div> <!-- content -->
	</div>	

</div>