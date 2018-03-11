<?php

use app\models\Page;

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
			
			<div class="col-sm-3">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<?php echo $this->render('/page/_sidebar-3'); ?>
	
			</div> <!--col-->


			<div class="col-sm-6">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<h1>Contact Us</h1>

				<form action="">
					<label>Name</label>
					<input type="text" name="name" class="form-control name">

					<label>Email</label>
					<input type="email" name="email" class="form-control email">

					<label>Subject</label>
					<input type="text" name="subject" class="form-control email">

					<label>Message</label>
					<textarea name="message" id=""></textarea>

					<input type="submit" value="submit" name="submit" class="form-control">
				</form>


			</div> <!--col-->

		
			<!-- Sidebar -->
			<div class="col-sm-3">
				<?php echo $this->render('/page/_sidebar-2'); ?>
			</div> <!--col-->
			<!-- Sidebar -->
		</div> <!--row-->
	</div>
</div>














