



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
				<p>The 2018 Season has not yet begun. Once the season has started, check back here for the list of goods that are available for the week. You will also receive a weekly email with the list of available goods that are available for the week.</p>		
			</div> <!--col-->
			<div class="col-sm-6 text-right">
				<span class="membership-type"><?= Yii::$app->user->identity->membership_type ?> Membership</span>
			</div> <!--col-->
		</div> <!--row-->
	

		
		<div class="spacer30"></div>
		<a href="" class="btn btn-sm btn-primary" disabled>Schedule Pickup</a>
		


		<div class="spacer90"></div>
		</div> <!-- content -->
	</div>	

</div>