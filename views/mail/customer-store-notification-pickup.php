<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

// $cart = unserialize($model->addons);
// $products = Product::find()->where(['id'=>$cart])->all();

?>


<?= $this->render('mail-header'); ?>


<!-- 1 Column Text + Button : BEGIN -->
<tr>
	<td bgcolor="#fef8ec" style="padding: 40px 40px 20px; text-align: center;">
		
		<h1 style="text-align:center">Order Confirmation</h1> 

		<p style="margin-bottom:40px;">Thank you for your order.</p>
		<p style="margin-bottom:40px;">We will have your order ready for you to pick up when you come to pick up your farm share.  Please keep this receipt so that you will know what you will be receiving.</p>
		
		<table style="width: 100%; color:#05426b; text-align:left; font-family: 'Roboto Mono',monospace">
			
			<?php if ($model->addons): ?>
				<?php foreach (json_decode($model->addons) as $addon): ?>
					 
					<tr>
						<td style="border-bottom:1px solid #CCC; font-family: 'Roboto Mono',monospace; padding:5px 0;" width="300"><?= $addon ?></td>
					</tr>								
				<?php endforeach ?>
			<?php endif ?>


			
		</table>
		

	</td>
</tr>


<?= $this->render('mail-footer'); ?>