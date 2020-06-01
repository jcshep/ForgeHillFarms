<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Store Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-lising">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped'],
        // 'rowOptions'=>function($data){
        //     if(!$data->in_store){
        //         return ['class' => 'inactive'];
        //     }},
        'columns' => [
            [
                'filter'=> ['all' => "All", 'pending'=>'Pending', 'fulfilled' => "Fulfilled",],
                'label'=>'Status',
                'headerOptions' => ['width' => '100'],
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>function ($data){
                    if($data->ready) 
                        return '<div class="text-center"><div class="btn btn-xs btn-success">FULFILLED</div></div>';                                    
                    
                    return '<div class="text-center"><div class="btn btn-xs btn-danger">PENDING</div></div>';
                },
            ],
            [
                'headerOptions' => ['width' => '100'],
                'filter'=>false,
                'attribute'=>'order_date',
                'format'=>'date'
            ],
            [
                'headerOptions' => ['width' => '130'],
                'filter'=>false,
                'attribute'=>'fullname',
                'label'=>'Full Name',
            ],
            [
                'headerOptions' => ['width' => '120'],
                'attribute'=>'email',
                'format'=>'email'
            ],
            [
                'headerOptions' => ['width' => '40'],
                'attribute'=>'phone',
            ],
            [
                'filter'=> false,
                'label'=>'Ordered Items',
                'attribute'=>'cart',
                'format'=>'raw',
                'value'=>function ($data){
                    $html = '<small>';
                    $cart = unserialize($data->cart);
                    $cart = unserialize($data->cart);
                    $products = [];
                    foreach ($cart as $cart_item) {
                        $products[] = Product::find()->where(['id'=>$cart_item])->one();
                    }

                    foreach ($products as $product) {
                        if($product) {
                            $html .= '<div>'.$product->name .'</div>';
                        } else {
                            $html .= '<div><em>(This product was deleted)</em></div>';
                        }
                    }
                    $html .= '</small>';
                    return $html;
                },
            ],
            [
                'headerOptions' => ['width' => '30'],
                'attribute'=>'total',
                'value' => function ($data){ 
                    if ($data->total) 
                        return '$'.number_format($data->total,2);                     
                }
            ],

            ['class' => 'yii\grid\ActionColumn',                            
                            'headerOptions' => ['width' => '50'],
                            'template' => '{fulfill}',
                            'buttons'=>[

                                'fulfill' => function ($url, $model) {  
                                                if (!$model->ready) {
                                                     return Html::a('<i class="fa fa-check text-success"></i>', ['fulfill-order', 'id' => $model->id], [
                                                        'class' => 'text-success btn btn-default btn-sm',
                                                        'data' => [
                                                            'confirm' => 'Are you sure you are ready to fulfill this order? Pressing OK will immediately generate an email to the customer letting them know their order is available for pickup.',
                                                            'method' => 'post',
                                                        ]]);
                                                }
                                             }, 

                            ], 
                    ],
        ],
    ]); ?>

</div>
