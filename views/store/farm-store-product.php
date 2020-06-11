<?php  
	use yii\helpers\Html; 
?>

<div class="col-sm-6 col-md-4 product">
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