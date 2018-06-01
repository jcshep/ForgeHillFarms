<?php  

use app\models\ProductWeek;

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
					<span class="membership-type">Membership Level: <strong><?= Yii::$app->user->identity->membership_type ?></strong></span>
					<div class="inner">
						<div class="upper text-center">SELECT YOUR PICKUP DAY</div>

						<div class="spacer30"></div>
						
						<div id="pickup-selection">

							<form action="/user/set-pickup" method="POST">
							
							<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

							<?php if (date('w') < 4): ?>
								<a href="" data-day="thursday" class="btn btn-secondary btn-block day <?php if($pickup && $pickup->day == 'thursday') echo 'active' ?>"><i class="fa fa-check"></i> Thursday <?php echo date('F j', strtotime('next thursday')) ?></a>			
							<?php else: ?>
								<a href="" class="btn btn-secondary btn-block disabled <?php if($pickup && $pickup->day == 'thursday') echo 'active' ?>"><i class="fa fa-check"></i> Thursday</a>			
							<?php endif ?>
								
							<a href="" data-day="saturday" class="btn btn-secondary btn-block day <?php if($pickup && $pickup->day == 'saturday') echo 'active' ?>"><i class="fa fa-check"></i> Saturday <?php echo date('F j', strtotime('next saturday')) ?></a>
							<a href="" data-day="opt-out" class="btn btn-secondary btn-block day <?php if($pickup && $pickup->day == 'opt-out') echo 'active' ?>"><i class="fa fa-check"></i> Opt Out</a>
							

							<div class="hidden">
								<input type="radio" name="Pickup[day]" value="thursday" class="thursday" <?php if($pickup && $pickup->day == 'thursday') echo 'checked' ?>>
								<input type="radio" name="Pickup[day]" value="saturday" class="saturday" <?php if($pickup && $pickup->day == 'saturday') echo 'checked' ?>>
								<input type="radio" name="Pickup[day]" value="opt-out" class="opt-out" <?php if($pickup && $pickup->day == 'opt-out') echo 'checked' ?>>
							</div>
							
							<div class="spacer15"></div>
							
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

							<input type="submit" name="submit" value="Confirm" class="btn btn-block btn-primary">

							</form>
						</div>
						
						
						
					</div>	
				</div>
			</div> <!--col-->
		</div> <!--row-->
	

		
		
		
		


		<div class="spacer30"></div>
		</div> <!-- content -->
	</div>	

</div>