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
		
		<h1 style="text-align:center"> <small>Order Confirmation</small> <br>Order Received</h1> 

		<p style="margin-bottom:40px;">Thank you for your purchase.</p>
		<p style="margin-bottom:40px;">During the CSA season, all farm store purchases are ready for pick up on Thursdays from 4-7 pm and Saturdays from 10-12 pm.  Please come in the driveway, drive to the right of the barn and park behind it.  You may then walk up to the table in the pickup area and we will hand your order to you.  </p>
		
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