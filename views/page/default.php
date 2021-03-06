<?php

use app\models\Page;

$this->title = 'Forge Hill Farms | Community Supported Farm | CSA by the Brandywine';
?>


<div id="hero">
	<div class="container">
		<?= Page::editBlock('hero-image-'.$model->slug,'image','Edit Image', 'hero'); ?>
		<img src="/uploads/<?= Page::renderBlock('hero-image-'.$model->slug); ?>" alt="">
		<?= Page::removeImage('hero-image-'.$model->slug,'image','Edit Image', 'hero'); ?>
	</div>
</div>

<div class="spacer30"></div>



<div id="content">
	<div class="container">
		<div class="row">
			
			


			<div class="col-md-6 col-md-push-3 col-sm-8">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<?= Page::editBlock('title-h1-'.$model->slug, 'text', 'Edit Title', 'corner', 'content'); ?>
				<h1 class="editable"><?= Page::renderBlock('title-h1-'.$model->slug); ?></h1>
				
				<div class="editable">
				<?= Page::editBlock('content-image-'.$model->slug,'image','Edit Image', 'content'); ?>
				<?= Page::removeImage('content-image-'.$model->slug,'image','Edit Image', 'hero'); ?>
				<?php if ($image = Page::renderBlock('content-image-'.$model->slug)): ?>
					<img src="/uploads/<?= Page::renderBlock('content-image-'.$model->slug); ?>" alt="">	
					<div class="spacer30"></div>
				<?php endif ?>

				</div>
				
				<div class="editable">
				<?= Page::editBlock('main-content-'.$model->slug,'wysiwyg', 'Edit Main Content', 'corner', 'content'); ?>
				<?= Page::renderBlock('main-content-'.$model->slug); ?>
				</div>


			</div> <!--col-->


			<div class="col-md-3 col-md-pull-6 hidden-sm hidden-xs">
				
				<div class="border"></div>
				<div class="spacer30"></div>
				
				<?php echo $this->render('/page/_sidebar-3'); ?>
	
			</div> <!--col-->

		
			<!-- Sidebar -->
			<div class="col-md-3 col-sm-4">
				<?php echo $this->render('/page/_sidebar-2'); ?>
			</div> <!--col-->
			<!-- Sidebar -->
		</div> <!--row-->
	</div>
</div>














