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
		<p style="margin-bottom:40px;">Thank you for your order.  We will work to get your order ready within 48 hours.  If we are unable to complete your order within that time we will send you an email.  Once your order is ready you will receive an email letting you know that your order is ready for pick up with instructions of where to find your order.</p>
		
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