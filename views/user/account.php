<?php  

use app\models\ProductWeek;
use yii\widgets\ActiveForm;

$membership_type = Yii::$app->user->identity->membership_type;

if($membership_type == 'free') {
	$this->registerJsFile('https://js.stripe.com/v2/');
	$this->registerJs("Stripe.setPublishableKey('".Yii::$app->params['stripePublishableKey']."');",  yii\web\View::POS_END);
	$this->registerJsFile('/js/manual-payment-form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
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
							<center>You have purchased a <?= $pickup->size ?> share pickup for <?= ucfirst($pickup->day) ?></center>
							<div class="spacer30"></div>
						<?php else: ?>
						

						<h3 class="text-center">Select your pickup day</h3>

						<div id="pickup-selection">

							<?php $form = ActiveForm::begin(['action'=>'/user/set-pickup', 'id'=> $membership_type == 'free' ? 'payment-form' : 'pickup-form']); ?>

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
								<a href="" data-size="full" class="btn btn-secondary btn-block size"><i class="fa fa-check"></i> Full $32</a>
								<a href="" data-size="half" class="btn btn-secondary btn-block size"><i class="fa fa-check"></i> Half $18</a>

							<?php endif ?>


							<div class="hidden">
								<input type="radio" name="Pickup[day]" value="thursday" class="thursday" <?php if($pickup && $pickup->day == 'thursday') echo 'checked' ?>>
								<input type="radio" name="Pickup[day]" value="saturday" class="saturday" <?php if($pickup && $pickup->day == 'saturday') echo 'checked' ?>>
								<input type="radio" name="Pickup[day]" value="opt-out" class="opt-out" <?php if($pickup && $pickup->day == 'opt-out') echo 'checked' ?>>
						
								<input type="radio" name="Pickup[size]" value="half" class="half size" <?php if($membership_type == 'half') echo 'checked' ?>>
								<input type="radio" name="Pickup[size]" value="full" class="full size" <?php if($membership_type == 'full') echo 'checked' ?>>
							</div>
							
							<div class="spacer30"></div>
							
							<?php if(ProductWeek::getWeeklyAddons()): ?>	


								<div class="text-center add-ons">
									<label>I'm Interested in the following Add Ons</label>
									<div class="spacer15"></div>
									<input type="hidden" name="Pickup[addons]" value="">
									<?php  foreach (ProductWeek::getWeeklyAddons() as $addon): ?>
										
										<label>
											<input type="checkbox" name="Pickup[addons][]" value="<?= $addon->product->name; ?>" <?php if($addons && in_array($addon->product->name, $addons)){echo 'checked';} ?>>
											<?= $addon->product->name; ?>
										</label>
									
									<?php endforeach; ?>
								<div class="spacer15"></div>
								</div>
							<?php endif;  ?>
							
							<?php if($pickup) : ?>
								<input type="hidden" name="id" value="<?= $pickup->id ?>">								
							<?php endif; ?>




							<?php if ($membership_type != 'free'): ?>

								<input type="submit" name="confirm" value="Confirm" class="btn btn-block btn-primary">
							
							<?php else: ?>

								<a data-toggle="modal" data-target="#modal-pay" class="btn btn-block btn-primary" id="pay-modal">Purchase</a>
								
								<!-- Modal -->
								<div class="modal fade" id="modal-pay" tabindex="-1" role="dialog">
								    <div class="modal-dialog" role="document">
								        <div class="modal-content">
								            <div class="modal-body">
								                <?php echo $this->render('/user/_ccform', [
													'model'=>$charge,
													'form'=>$form]
												); ?>
								            </div>
								            <div class="modal-footer">
								            	$<input type="text" name="Charge[amount]" value="" class="charge-amount">
								            	<button type="submit" class="btn btn-primary">Confirm</button>
								                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>            -->
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
	

		
		
		
		


		<div class="spacer30"></div>
		</div> <!-- content -->
	</div>	

</div>