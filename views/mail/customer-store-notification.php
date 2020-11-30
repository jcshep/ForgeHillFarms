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
		<p style="margin-bottom:40px;">You may pick up your order Monday through Sunday 8 am - 7 pm.  Please drive to the back of the barn to park and then come to the table in the pick up area to let us know your name so we can get your order for you.  We are located at 404 Creek Road Downingtown PA. If you are unable to pick up on these days or if you forget to pick up please email <a href="mailto:jennifer@forgehillfarms.com">jennifer@forgehillfarms.com</a>.</p>
		
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