<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

$cart = unserialize($model->cart);
$products = Product::find()->where(['id'=>$cart])->all();

?>


<?= $this->render('mail-header'); ?>


<!-- 1 Column Text + Button : BEGIN -->
<tr>
	<td bgcolor="#fef8ec" style="padding: 40px 40px 20px; text-align: center;">
		
		<h1 style="text-align:center">Your Order is Ready</h1> 
				
		<p style="margin-bottom:40px;">Your order is ready.  You may pick up your order Monday through Sunday 8 am - 7 pm.  Pick up is at Forge Hill Farms 404 Creek Road Downingtown, PA 19335.  Please drive, past the house, to the left side of barn and pull up to the first open section.  You will see a small fridge for eggs and produce and a freezer for meat.  If you ordered honey or apparel it will be next to the fridge.  Your items will be labeled with your name.  If you have any questions please either email <a href="mailto:jennifer@forgehillfarms.com">jennifer@forgehillfarms.com</a> or call 610-724-2413.</p>
		
		<table style="width: 100%; color:#05426b; text-align:left; font-family: 'Roboto Mono',monospace">
	
			<?php foreach ($products as $product): ?>
				<tr>
					<td style="border-bottom:1px solid #CCC; font-family: 'Roboto Mono',monospace; padding:5px 0;" width="300"><?= $product->name ?></td>
					<td style="border-bottom:1px solid #CCC; font-family: 'Roboto Mono',monospace; padding:5px 0; text-align:right;">$<?= number_format($product->price, 2) ?></td>
				</tr>		
			<?php endforeach ?>
			
			<tr>
				<td colspan="2" style="text-align:right;  font-family: 'Roboto Mono',monospace;">
					<br>
					<small>TOTAL</small> <strong style="font-size:20px;">$<?=  number_format($model->total,2) ?></strong>
				</td>
			</tr>
			
		</table>
		

	</td>
</tr>


<?= $this->render('mail-footer'); ?>