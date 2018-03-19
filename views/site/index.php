<?php

use app\models\Page;

$this->title = 'Forge Hill Farms | Community Supported Farm | CSA by the Brandywine';
?>


<div id="hero">
	<div class="container editable">
		<?= Page::editBlock('home-hero-image','image','Edit Image', 'hero'); ?>
		<img src="/uploads/<?= Page::renderBlock('home-hero-image'); ?>" alt="">	
		<?= Page::removeImage('home-hero-image','image','Edit Image', 'hero'); ?>
	</div>
</div>


<div class="spacer30"></div>


<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				
				<div class="border"></div>
				<div class="spacer30"></div>

				<h1 class="stamped editable" id="hero-h1">
					<?= Page::editBlock('hero-h1','text','Edit Header', 'bottom', 'hero-h1'); ?>
					<?= Page::renderBlock('hero-h1'); ?>
				</h1>

				<div class="editable">
					<?= Page::editBlock('home-intro','wysiwyg','Edit Copy', 'bottom'); ?>
					<?= Page::renderBlock('home-intro'); ?>
				</div>

				<a href="about-us">LEARN MORE ABOUT US</a>

				<div class="spacer30"></div>
				<div class="border"></div>
				<div class="spacer30"></div>

				<h2>Join Our Community</h2>

				<div id="share-box-selection">
					<div class="row">
						<div class="col-md-6">

							<!-- Full share -->
							<div class="box">
								<span class="inner">
									<div class="row upper">
										<div class="col-sm-8 editable text-uppercase">
											<?= Page::editBlock('option-1','text','Edit Plan Name', 'top', 'share-box-selection'); ?>
											<?= Page::renderBlock('option-1'); ?>
										</div> <!--col-->
										<div class="col-sm-4 text-right">$650</div> <!--col-->
									</div> <!--row-->

									<span class="spacer"></span>
									
									<p class="editable">
										<?= Page::editBlock('full-share-copy','text', 'Edit Full Share', 'top', 'share-box-selection'); ?>
										<?= Page::renderBlock('full-share-copy'); ?>
									</p>	

									<a href="/user/sign-up?type=full" class="btn btn-primary">SIGN UP FOR <?= Page::renderBlock('option-1'); ?></a>
								</span>
							</div>

							<div class="spacer30 visible-sm visible-xs"></div>
						</div> <!--col-->


						<div class="col-md-6">
							<!-- Half share -->
							<div class="box">
								<span class="inner">
									<div class="row upper">
										<div class="col-sm-8 editable text-uppercase">
											<?= Page::editBlock('option-2','text','Edit Plan Name', 'bottom', 'share-box-selection'); ?>
											<?= Page::renderBlock('option-2'); ?>
										</div> <!--col-->
										<div class="col-sm-4 text-right">$375</div> <!--col-->
									</div> <!--row-->

									<span class="spacer"></span>
									
									<p class="editable">
										<?= Page::editBlock('half-share-copy','text', 'Edit Half Share', 'top', 'share-box-selection'); ?>
										<?= Page::renderBlock('half-share-copy'); ?>
									</p>	

									<a href="/user/sign-up?type=half" class="btn btn-primary">SIGN UP FOR <?= Page::renderBlock('option-2'); ?></a>
								</span>
							</div>
						</div> <!--col-->
					</div> <!--row-->


					<div class="spacer30"></div>

						
					<!-- A la carte -->
					<div class="box">
						<span class="inner">
							<div class="row upper">
								<div class="col-sm-6 editable text-uppercase">
									<?= Page::editBlock('option-3','text','Edit Plan Name', 'bottom', 'share-box-selection'); ?>
									<?= Page::renderBlock('option-3'); ?>
								</div> <!--col-->
								<div class="col-sm-6 text-right">
									<small>FULL SHARE</small> $32<br>
									<small>HALF SHARE</small> $18
								</div> <!--col-->
							</div> <!--row-->

							<div class="spacer30"></div>
							
							<p class="editable">
								<?= Page::editBlock('alacarte-copy','text', 'Edit A La Carte', 'top', 'share-box-selection'); ?>
								<?= Page::renderBlock('alacarte-copy'); ?>
							</p>	

							<a href="/user/sign-up?type=free" class="btn btn-secondary">SIGN UP FOR <?= Page::renderBlock('option-3'); ?></a>
						</span>
					</div>

				</div> <!-- share-box-selection -->

				
				<div class="spacer30"></div>
				
				<h3>Pickup Times</h3>

				<div class="row" id="pickup-times">
					<div class="col-sm-7">
						<?= Page::editBlock('pickup-times-copy','wysiwyg', 'Edit Copy', 'top', 'pickup-times'); ?>
						<?= Page::renderBlock('pickup-times-copy'); ?>
						<a href="/our-products">LEARN MORE ABOUT OUR PRODUCTS</a>
					</div> <!--col-->
					<div class="col-sm-5 times">
						<div class="border red"></div>
						<div class="spacer30"></div>
						<div class="row" id="pickup-time-options">
							<div class="col-sm-6">
								<?= Page::editBlock('pickup-times-1-copy','wysiwyg', 'Edit', 'top', 'pickup-times'); ?>
								<?= Page::renderBlock('pickup-times-1-copy'); ?>
							</div> <!--col-->
							<div class="col-sm-6">
								<?= Page::editBlock('pickup-times-2-copy','wysiwyg', 'Edit', 'top', 'pickup-times'); ?>
								<?= Page::renderBlock('pickup-times-2-copy'); ?>
							</div> <!--col-->
						</div> <!--row-->
						<div class="spacer30"></div>
						<div class="border red"></div>
					</div> <!--col-->
				</div> <!--row-->

			</div> <!--col-->


			<!-- Sidebar -->
			<div class="col-sm-4">
				<?php echo $this->render('/page/_sidebar-1'); ?>
			</div> <!--col-->
			<!-- Sidebar -->
		</div> <!--row-->
	</div>
</div>














