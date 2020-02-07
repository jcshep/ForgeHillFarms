<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Store Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-index">

    <div class="row">
        <div class="col-sm-8"><h1><?= Html::encode($this->title) ?></h1></div> <!--col-->
        <div class="col-md-4 text-right">
            <div class="spacer30"></div>
            <a href="/admin/add-product" class="btn btn-primary">Add Product</a>
        </div> <!--col-->
    </div> <!--row-->
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped'],
        'rowOptions'=>function($data){
            if(!$data->in_store){
                return ['class' => 'inactive'];
            }},
        'columns' => [
            'name',
            // 'price:currency',
            
            [
                'filter'=> ['product'=>"Product" , 'addon' => "Addon"],
                'label'=>'Type',
                // 'headerOptions' => ['width' => '100'],
                'attribute'=>'type',
                'format'=>'raw',
                'value'=>function ($data){
                    if($data->type == 'addon') 
                        return '<div class="text-center"><div class="btn btn-xs btn-success">ADDON</div></div>';                                    
                    
                    if($data->type == 'product') 
                        return '<div class="text-center"><div class="btn btn-xs btn-primary">PRODUCT</div></div>';                       

                    return false;                                
                },
            ],

            [
                'attribute'=>'price',
                'value' => function ($data){ 
                    if ($data->price) 
                        return '$'.number_format($data->price,2);                     
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '100'],
                                    'template' => '{view} {delete}',
                                    'buttons'=>[
                                        // 'view' => function ($url, $model) {     
                                        //      return Html::a('<button class="btn btn-primary btn-xs">Update</button>', '/'.$model->slug);
                                        //  },
                                        'delete' => function ($url, $model) {     
                                                         return Html::a('<i class="fa fa-close text-danger"></i>', ['delete-product', 'id' => $model->id], [
                                                            'class' => 'text-danger btn btn-default btn-sm',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to remove this item?',
                                                                'method' => 'post',
                                                            ]]);
                                                     }, 
                                         'view' => function ($url, $model) {     
                                             return Html::a('<button class="btn btn-default btn-sm">Edit</button>', '/admin/edit-product/'.$model->id);
                                         }
                                    ], 
                    ],
        ],
    ]); ?>

</div>
