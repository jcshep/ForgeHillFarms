<?php 
use app\models\Pickup;
use app\models\AppHelper;
?>



	<div class="panel panel-default">
		<div class="panel-heading"><h4><?= ucfirst($day) ?></h4></div>
		<div class="panel-body">
			<?php $pickups = Pickup::find()->joinWith('user')->where([
	            'week'=>AppHelper::getCurrentWeekDates()['start'],
	            'day'=>$day,
	        ])->orderBy('user.membership_type')->all(); ?>

	        <?php if ($pickups): ?>
	        	<table class="table table-condensed small">
				<tr>
					<th width="40%">Name</th>
					<th width="50%">Addons</th>
					<th width="10%"></th>
				</tr>
	        	<?php foreach ($pickups as $pickup): ?>
	        		<tr>
						<td><?= $pickup->user->fname ?> <?= $pickup->user->lname ?></td>
						<td><small>
							<?php if ($pickup->addons): ?>
								<?php foreach (json_decode($pickup->addons) as $addon): ?>
									<?= $addon ?>,
								<?php endforeach ?>
							<?php endif ?>
							</small>
						</td>
						<td>
							<?php  
							if($pickup->user->membership_type == 'free') 
								echo '<div class="text-center"><div class="btn btn-xs btn-success">FREE</div></div>';                                    

							if($pickup->user->membership_type == 'half') 
								echo '<div class="text-center"><div class="btn btn-xs btn-primary">HALF</div></div>';       

							if($pickup->user->membership_type == 'full') 
								echo '<div class="text-center"><div class="btn btn-xs btn-info">FULL</div></div>';  
							?>
						</td>
					</tr>
	        	<?php endforeach ?>
	        	</table>
	        <?php else: ?>
	        	<?php if ($day=='opt-out'): ?>
	        		<p><em>No Opt Outs</em></p>	
	        	<?php else: ?>
	        		<p><em>No Scheduled Pickups</em></p>		
	        	<?php endif ?>
	        	
	        <?php endif ?>
			
		</div>
	</div>
