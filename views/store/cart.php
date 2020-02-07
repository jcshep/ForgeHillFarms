



<div id="store" class="cart">

	<div class="container">

		<div id="content" class="text-center">
			<h2>Checkout</h2>
		</div>
	

		<?php if($flashMessage = Yii::$app->session->getFlash('success')): ?>
			<div class="alert alert-success text-center"><?= $flashMessage ?></div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-6">
				<a href="/store" class="btn btn-secondary"><i class="fa fa-chevron-left"></i> Back To Store</a>
			</div> <!--col-->
		</div> <!--row-->


		<div class="spacer30"></div>

		
		<div class="cart-items">
			<?php if (!$products): ?>
			<div class="spacer60"></div>
			<div class="text-center"><h4>No Products in Cart</h4></div>	
			<?php endif ?>

			<?php foreach ($products as $product): ?>
				<div class="row cart-item">
					<div class="col-sm-1">
						<div class="product-thumb" style="background-image:url(/<?php echo $product->getImage(); ?>)"></div>
					</div> <!--col-->
					<div class="col-sm-8">
						<strong><?= $product->name ?></strong>
					</div> <!--col-->
					<div class="col-sm-2">
						<strong>$<?= number_format($product->price, 2) ?></strong>
					</div> <!--col-->
					<div class="col-sm-1">
						<a href="/store/remove-from-cart/<?= $product->id ?>" class="btn btn-secondary btn-xs btn-block"><i class="fa fa-close"></i></a>
					</div> <!--col-->					
				</div> <!--row-->
			<?php endforeach ?>
		</div>

		<div class="totals text-right">
			<h3><small>TOTAL</small> $<?= number_format($total, 2) ?></h3>
		</div>

		<div class="spacer30"></div>

		<div class="row">
			<div class="col-md-6 col-sm-offset-6 text-right">				
				<a href="/store/checkout" class="btn btn-primary">Checkout</a>
			</div> <!--col-->
		</div> <!--row-->
		
		



	</div>

</div> <!-- #store -->