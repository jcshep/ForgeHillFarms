<?php  
	use app\models\Page;
?>


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

	<h3>Become A Member</h3>
	
	<div class="editable">
		<?= Page::editBlock('member-cta-image','image','Edit Image', 'content'); ?>
		<img src="/uploads/<?= Page::renderBlock('member-cta-image'); ?>" alt="">	
		<?= Page::removeImage('member-cta-image','image','Edit Image', 'hero'); ?>	
	</div>
	
	<div class="spacer15"></div>
	
	<div class="editable">
		<?= Page::editBlock('member-cta', 'text', 'Edit Copy', 'corner', 'content'); ?>
		<?= Page::renderBlock('member-cta'); ?>
		<div class="spacer15"></div>
		<a href="/user/sign-up" class="btn btn-secondary btn-sm">Sign Up Today</a>
	</div>


	<div class="spacer30 visible-xs"></div>




</div>