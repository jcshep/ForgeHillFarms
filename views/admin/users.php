<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            'fname',
            'lname',
            'email:email',
            [
                'filter'=> ['free'=>"Free" , 'half' => "Half Membership", 'full' => "Full Membership"],
                'label'=>'Membership',
                'headerOptions' => ['width' => '100'],
                'attribute'=>'membership_type',
                'format'=>'raw',
                'value'=>function ($data){
                    if($data->membership_type == 'free') 
                        return '<div class="text-center"><div class="btn btn-xs btn-success">FREE</div></div>';                                    
                    
                    if($data->membership_type == 'half') 
                        return '<div class="text-center"><div class="btn btn-xs btn-primary">HALF</div></div>';       

                    if($data->membership_type == 'full') 
                        return '<div class="text-center"><div class="btn btn-xs btn-info">FULL</div></div>';                          

                    return false;                                
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '70'],
                                    'template' => '{view}',
                                    'buttons'=>[
                                        // 'view' => function ($url, $model) {     
                                        //      return Html::a('<button class="btn btn-primary btn-xs">Update</button>', '/'.$model->slug);
                                        //  },
                                         'view' => function ($url, $model) {     
                                             return Html::a('<button class="btn btn-default btn-sm">View User</button>', '/admin/user-view/'.$model->id);
                                         }
                                    ], 
                    ],
        ],
    ]); ?>

</div>
