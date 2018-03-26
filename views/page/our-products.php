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
			
			


			<div class="col-md-9 col-md-push-3">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<?= Page::editBlock('title-h1-'.$model->slug, 'text', 'Edit Title', 'corner', 'content'); ?>
				<h1 class="editable"><?= Page::renderBlock('title-h1-'.$model->slug); ?></h1>
				
				<div class="editable">
				<?= Page::editBlock('content-image-'.$model->slug,'image','Edit Image', 'content'); ?>
				<?php if ($image = Page::renderBlock('content-image-'.$model->slug)): ?>
					<img src="/uploads/<?= Page::renderBlock('content-image-'.$model->slug); ?>" alt="">	
					<div class="spacer30"></div>
				<?php endif ?>
				</div>
				
				<div class="editable">
				<?= Page::editBlock('main-content-'.$model->slug,'wysiwyg', 'Edit Main Content', 'corner', 'content'); ?>
				<?= Page::renderBlock('main-content-'.$model->slug); ?>
				</div>



				<div id="all-product-list">
					<div class="row">
						<div class="col-sm-4 editable">
							<h3>Spring</h3>
							<?= Page::editBlock('full-product-list-1', 'text', 'Edit Products', 'corner', 'content'); ?>
							<?= Page::renderBlock('full-product-list-1'); ?>
						</div> <!--col-->

						<div class="col-sm-4 editable">
							<h3>Summer</h3>
							<?= Page::editBlock('full-product-list-2', 'text', 'Edit Products', 'corner', 'content'); ?>
							<?= Page::renderBlock('full-product-list-2'); ?>
						</div> <!--col-->

						<div class="col-sm-4 editable">
							<h3>Fall</h3>
							<?= Page::editBlock('full-product-list-3', 'text', 'Edit Products', 'corner', 'content'); ?>
							<?= Page::renderBlock('full-product-list-3'); ?>

							<div class="spacer30"></div>
							<div class="border"></div>
							<div class="spacer30"></div>
							
							<h3>ADD ON ITEMS</h3>
							<div class="editable">
								<?= Page::editBlock('full-product-list-4', 'text', 'Edit Products', 'corner', 'content'); ?>
								<?= Page::renderBlock('full-product-list-4'); ?>
							</div>
						</div> <!--col-->


					</div> <!--row-->
				</div>


			</div> <!--col-->


			
			<div class="col-md-3 col-md-pull-9 hidden-sm hidden-xs">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<div id="sidebar">

					<h3>Farm Info</h3>
					<div class="editable">
						<?= Page::editBlock('farm-info', 'text', 'Edit Copy', 'corner', 'content'); ?>
						<?= Page::renderBlock('farm-info'); ?>
						<a href="mailto:info@forgehillfarms.com">INFO@FORGEHILLFARMS.COM</a>
					</div>

					
					<div class="spacer30"></div>
					<div class="border"></div>
					<div class="spacer30"></div>

			
					<form id="newsletter-signup" method="POST">
						<h3>Sign Up For Updates</h3>
						<div class="alert alert-success static">Thank You! Your email has been added.</div>

						<label>Name</label>
						<input type="text" name="name" class="form-control name">

						<label>Email</label>
						<input type="email" name="email" class="form-control email">

						<input type="submit" value="submit" name="submit" class="form-control">
					</form>


					<div class="spacer30"></div>
					<div class="border"></div>
					<div class="spacer30"></div>

					<h3>Become A Member</h3>
					<div class="editable">
						<?= Page::editBlock('member-cta', 'text', 'Edit Copy', 'corner', 'content'); ?>
						<?= Page::renderBlock('member-cta'); ?>
						<div class="spacer15"></div>
						<a href="/user/sign-up" class="btn btn-secondary btn-sm">Sign Up Today</a>
					</div>

				</div> <!-- sidebar -->
	
			</div> <!--col-->



		
			<!-- Sidebar -->
		</div> <!--row-->
	</div>
</div>














