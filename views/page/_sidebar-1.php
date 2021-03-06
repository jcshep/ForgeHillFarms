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
		
		
		
		<div class="border"></div>
		<div class="spacer30"></div>
		
		<h3>Sign Up For Updates</h3>
		<form id="newsletter-signup" method="POST">
			<div class="alert alert-success static">Thank You! Your email has been added.</div>
			
			<label>Name</label>
			<input type="text" name="name" class="form-control name">

			<label>Email</label>
			<input type="email" name="email" class="form-control email">
			
			<input type="submit" value="submit" name="submit" class="form-control">
		</form>

	</div>

	<div class="spacer30"></div>
	<div class="border"></div>
	<div class="spacer30"></div>

	<h3>From The Farmers</h3>
	<div class="editable">
		<?= Page::editBlock('sidebar-image-1','image','Edit Image'); ?>
		<img src="/uploads/<?= Page::renderBlock('sidebar-image-1'); ?>" alt="">
		<?= Page::removeImage('sidebar-image-1','image','Edit Image', 'hero'); ?>
	</div>	
	<div class="spacer15"></div>
	<div class="editable">
	<?= Page::editBlock('sidebar-1','wysiwyg', 'Edit Copy', 'bottom'); ?>
	<?= Page::renderBlock('sidebar-1'); ?>
	</div>



</div>