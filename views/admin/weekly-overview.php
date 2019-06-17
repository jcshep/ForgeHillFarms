<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AppHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Weekly Overview';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="weekly-overview">
	
	<div class="row">
		<div class="col-sm-8">
			<h1>
				Weekly Overview <br>
				<small><?= AppHelper::getCurrentWeekDates()['start-formatted']; ?> to <?= AppHelper::getCurrentWeekDates()['end-formatted']; ?></small>
			</h1>
		</div> <!--col-->
		<div class="col-sm-4 text-right">
			<div class="spacer30"></div>
			<a href="/admin/email-generator" class="btn btn-success"><i class="fa fa-envelope"></i> Generate Email</a>
		</div> <!--col-->
	</div> <!--row-->
	
	
	<div class="spacer30"></div>

	<div class="row">
		<div class="col-sm-6">
			<h3>Products</h3>
			
			<?= $this->render('_product-add.php',[
					'dataProvider'=>$productDataProvider,
					'searchProduct'=>$searchProduct,
					'product'=>$product,
					'type' => 'product'
				]) ?>	

			
			<div class="spacer60"></div>


			<h3>Addon Items</h3>
			<?= $this->render('_product-add.php',[
					'dataProvider'=>$addonDataProvider,
					'searchProduct'=>$searchProduct,
					'product'=>$product,
					'type' => 'addon'
				]) ?>	


		</div> <!--col-->

		<div class="col-sm-5 col-sm-offset-1">
			<div class="well">
				<h3>Products Available This Week</h3>

				<?= GridView::widget([
				    'dataProvider' => $productWeekDataProvider,
				    // 'filterModel' => $searchProductWeek,
				    'layout'=>"{items}\n{pager}",
				    'tableOptions' => ['class' => 'table table-condensed'],
				    'columns' => [
				        [
				        	'attribute' => 'product.name',
				        	'label' => false,
				        ],  	
				        ['class' => 'yii\grid\ActionColumn',
				                                'headerOptions' => ['width' => '25'],
				                                'template' => '{delete}',
				                                'buttons'=>[
				                                    'delete' => function ($url, $model) {     
				                                         return Html::a('<i class="fa fa-close"></i>', ['remove-product', 'id' => $model->id], [
				                                         	'class' => 'text-danger',
				                                         	'data' => [
				                                         		'confirm' => 'Are you sure you want to remove this product from the weekly listing?',
				                                         		'method' => 'post',
				                                         	]]);
				                                     },				                                     
				                                ], 
				                ],
				    ],
				]); ?>
			</div>

			<div class="well">
				<h3>Addons Available This Week</h3>

				<?= GridView::widget([
				    'dataProvider' => $addonWeekDataProvider,
				    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
				    'layout'=>"{items}\n{pager}",
				    'tableOptions' => ['class' => 'table table-condensed'],
				    'columns' => [
				        [
				        	'attribute' => 'product.name',
				        	'label' => false,
				        ],  	
				        [
				            'headerOptions' => ['width' => '80'],                
				            'label' => false,
				            'attribute' => 'allow_prepayment',
				            'format' => 'html',    
				            'value' => function ($data) {
				                if($data->product->allow_prepayment == 1 && $data->product->price) {
				                    return '<div class="text-success purchasable"><i class="fa fa-credit-card"></i> $'. $data->product->getPrice() .'</div>';
				                } elseif ($data->product->price){
				                    return '<div class="purchasable">$'.$data->product->getPrice().'</div>';
				                }                
				            },
				        ],
				        ['class' => 'yii\grid\ActionColumn',
				                                'headerOptions' => ['width' => '25'],
				                                'template' => '{delete}',
				                                'buttons'=>[
				                                    'delete' => function ($url, $model) {     
				                                         return Html::a('<i class="fa fa-close"></i>', ['remove-product', 'id' => $model->id], [
				                                         	'class' => 'text-danger',
				                                         	'data' => [
				                                         		'confirm' => 'Are you sure you want to remove this product from the weekly listing?',
				                                         		'method' => 'post',
				                                         	]]);
				                                     },				                                     
				                                ], 
				                ],
				    ],
				]); ?>
			</div>
		</div> <!--col-->

	</div> <!--row-->

</div>