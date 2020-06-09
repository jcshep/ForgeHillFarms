<?php

use yii\helpers\Html;
use yii\grid\GridView;
use richardfan\sortable\SortableGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchMenuCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-category-index">

    <div class="row">
        <div class="col-md-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div> <!--col-->
        <div class="col-md-6 text-right">
            <div class="spacer-xs"></div>
            <?= Html::a('Create Menu Category', ['category-create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="spacer-md"></div>


    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'sortUrl' => Url::to(['sortCategory']),
        'sortingPromptText' => 'Loading...',
        'layout'=>"{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [

            

            [
                'headerOptions' => ['width' => '20'],
                // 'label'=>'Sort',
                'format'=>'raw',
                'value'=> function($model) {
                    return '<i class="fa fa-sort" aria-hidden="true"></i>';
                }
            ],

            'title',

            // [
            //     // 'headerOptions' => ['width' => '150'],
            //     'label'=>'Display Settings',
            //     'format'=>'raw',
            //     'value'=> function($model) {
            //         $html = '<small class="text-success">';
            //         if($model->display_menu)
            //             $html .= 'Default Menu';

            //         if($model->display_order_menu && $model->display_menu)
            //             $html .= ' / ';

            //         if($model->display_order_menu)
            //             $html .= 'Online Ordering Menu';
            //         $html .= '</div>';
            //         return $html;
            //     }
            // ],

            ['class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '120'],
                            'template' => '{update} {delete}',
                            'buttons'=>[
                                'update' => function ($url, $model) {     
                                     return Html::a('<button class="btn btn-primary btn-xs">Update</button>', 'category-update/'.$model->id, ['title' => Yii::t('yii', 'Update')]);
                                 },
                                 'delete' => function ($url, $model) {
                                    return '<a class="btn btn-danger btn-xs" href="category-delete/'.$model->id.'">Delete</a>';
                                }
                            ], 
            ],
        ],
    ]); ?>

    

</div>
