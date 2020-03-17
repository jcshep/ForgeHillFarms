<?php use yii\helpers\Html; ?>



<div id="store">

	<div class="container">
		
		<div id="content" class="text-center container narrow">
			<h2>FARM STORE</h2>
			<p>Purchase products online and we will place frozen items located in the freezer and eggs in the small fridge in the CSA pick up area.  Your items will be labeled with your name.  Any dry items like honey will be next to the egg fridge.</p>			
			<p><strong>Please email <a href="info@forgehillfarms.com" target="_blank">info@forgehillfarms.com</a> if you have any questions or need to directions to the CSA pick up area.</strong></p>
		</div>
		

		<?php if($flashMessage = Yii::$app->session->getFlash('success')): ?>
			<div class="alert alert-success text-center" id="anchor"><?= $flashMessage ?></div>
		<?php endif; ?>
		
		<?php if($count = count(Yii::$app->session->get('cart'))) { ?>
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

		<div class="row">
			<?php foreach ($products as $product): ?>
				<div class="col-sm-3 product">
					<div class="product-thumb" style="background-image:url(/<?php echo $product->getImage(); ?>)"></div>
					<div class="spacer15"></div>
					<div class="row title">
						<div class="col-xs-9">
							<strong><?= $product->name ?></strong>
						</div> <!--col-->
						<div class="col-xs-3 text-right">
							<strong>$<?= number_format($product->price, 2) ?></strong>
						</div> <!--col-->
					</div> <!--row-->
					<?= Html::beginForm(['/store/add-to-cart/'.$product->id], 'post', ['enctype' => 'multipart/form-data']) ?>
						<div class="row">
							<div class="col-xs-3">
								<label for="quantity">QTY</label>
								<input type="text" name="quantity" class="form-control quantity" value="1">
							</div> <!--col-->
							<div class="col-xs-9">
								<label>&nbsp;</label>
								<input type="submit" class="btn btn-secondary btn-xs btn-block" name="submit" value="Add To Cart">
							</div> <!--col-->
						</div> <!--row-->
						
						
					<?= Html::endForm() ?>
				</div> <!--col-->
			<?php endforeach ?>
		</div> <!--row-->




	</div>

</div> <!-- #store -->