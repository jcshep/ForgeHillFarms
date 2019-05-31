<?php  
	use app\models\Page;
	use app\models\ProductWeek;
?>


<div id="sidebar">


	<div id="product-list">		
		<div class="text-center">
			<h3>This Weeks Haul</h3>
			<div class="date"><?php echo date('m.d.Y') ?></div>
			<?php echo ProductWeek::generateWeeklyList(); ?>
		</div>
	</div>
	
	<div class="spacer30"></div>
	<div class="border"></div>
	<div class="spacer30"></div>

	<h3>Newsletter</h3>

	<form id="newsletter-signup" method="POST">
		<h3>Sign Up For Updates</h3>

		<div class="alert alert-success static">Thank You! Your email has been added.</div>
		
		<label>Name</label>
		<input type="text" name="name" class="form-control name">

		<label>Email</label>
		<input type="email" name="email" class="form-control email">
		
		<input type="submit" value="submit" name="submit" class="form-control">
	</form>





</div>