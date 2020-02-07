<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

$cart = unserialize($model->cart);
$products = Product::find()->where(['id'=>$cart])->all();

?>


<h1>New Farm Store Order</h1>
<h2>Pending Pickup</h2>


<p>
	<strong>Customer Information</strong> <br>
	<?= $model->fname ?> <?= $model->lname ?><br>
	<?= $model->phone ?> <br>
	<?= $model->email ?>
</p>

<table style="border:1px solid #CCC">
	
	<?php foreach ($products as $product): ?>
		<tr>
			<td style="border-bottom:1px solid #CCC" width="300"><?= $product->name ?></td>
			<td style="border-bottom:1px solid #CCC">$<?= number_format($product->price, 2) ?></td>
		</tr>		
	<?php endforeach ?>
	
	<tr>
		<td colspan="2" style="text-align:right">
			<br>
			<small>TOTAL</small> $<?=  number_format($model->total,2) ?>
		</td>
	</tr>
	
</table>

<p>&nbsp;</p>

<p>
	Please login to the admin dashboard and press the "ready" button. 
	<br>This will initiate an email notification to the customer that their item is ready for pickup.
</p>
