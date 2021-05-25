<?php 
use app\models\Page;
use app\models\Category;
use yii\helpers\Html; 

$categories = Category::find()->orderBy('order')->all();
?>



<div id="store">

	<div class="container">
		
		<div id="content" class="text-center container">
			<h2>FARM STORE</h2>
			
			
			<?= Page::editBlock('farm-store-content-1','wysiwyg', 'Edit Content', 'corner', 'content'); ?>
			<?= Page::renderBlock('farm-store-content-1'); ?>
			
			<div class="text-center">
				<a href="/farm-store-menu.pdf" target="_blank" class="btn btn-secondary">Download Full Product List</a>
			</div>
			<div class="spacer30"></div>
		</div>
		

		<?php if($flashMessage = Yii::$app->session->getFlash('success')): ?>
			<div class="alert alert-success text-center" id="anchor"><?= $flashMessage ?></div>
		<?php endif; ?>
		


		<?php if(Yii::$app->session->get('cart') && $count = count(Yii::$app->session->get('cart'))) { ?>
		<div class="row">
			<div class="col-sm-3 col-sm-offset-9 text-right">
				<a href="/store/cart" class="btn btn-primary btn-checkout btn-block">				
					<span class="count"><?= $count ?></span>				
					<!-- <i class="fa fa-shopping-cart"></i>  -->
					View Cart / Checkout
				</a>
			</div> <!--col-->
		</div> <!--row-->
		<?php } ?>

		<div class="spacer30"></div>

		
		<!-- Desktop -->
		<div class="row hidden-sm hidden-xs hidden-md">
			<div class="col-md-3">
				<ul id="categories" class="nav nav-tabs">
				<?php $i=0; foreach ($categories as $category): ?>			
					<li <?= ($i==0 ? 'class="active"' : NULL) ?>>
						<a href="#<?= $category->slug ?>" aria-controls="<?= $category->slug ?>" role="tab" data-toggle="tab"><?= $category->title ?></a>
					</li>
				<?php $i++; endforeach ?>
				</ul>
			</div> <!--col-->

			<div class="col-md-9">
				<div class="tab-content">
				<?php $i=0; foreach ($categories as $category): ?>
					<div class="tab-pane fade in <?= ($i==0 ? 'active' : NULL) ?>" id="<?= $category->slug ?>">
						<h2><?= $category->title ?></h2>
						<div class="row">
						<?php foreach ($category->items as $product): ?>
							
							<?= $this->render('farm-store-product',[
											'product'=>$product, 
											]) ?>

						<?php endforeach ?>
						</div>
						
					</div>
				<?php $i++; endforeach ?>	
				</div>
			</div> <!--col-->
		</div> <!--row-->
		




		<!-- Mobile -->
		<div class="visible-sm visible-xs visible-md">
			<div class="panel-group mobile-menu" id="accordion" role="tablist" aria-multiselectable="true">
				<?php $i=0; foreach ($categories as $category): ?>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading-<?= $category->slug ?>">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $category->slug ?>" aria-controls="collapse-<?= $category->slug ?>">
							<?= $category->title ?>
						</a>
					</div>
				</div>

				<div id="collapse-<?= $category->slug ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?= $category->slug ?>">
					<div class="panel-body">
						<div class="row">
						<?php foreach ($category->items as $product): ?>
							
							<?= $this->render('farm-store-product',[
											'product'=>$product, 
											]) ?>

						<?php endforeach ?>
						</div>
					</div>
				</div>
				<?php endforeach ?>
			</div>
		</div>





	</div>

</div> <!-- #store -->