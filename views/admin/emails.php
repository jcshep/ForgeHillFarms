<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Emails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            'type',
            [
                'attribute'=>'created',
                'format'=>'date',
                'filter'=>false,
            ],
            [
                'attribute'=>'status',                
                'filter'=>false,
            ],
            [
                'attribute'=>'send_date',
                'format'=>'date',
                'filter'=>false,
            ],
            ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '190'],
                                    'template' => '{duplicate} {view} {delete}',
                                    'buttons'=>[
                                        'duplicate' => function ($url, $model) {     
                                             return Html::a('<button class="btn btn-default btn-sm">Duplicate</button>', '/admin/duplicate-email/'.$model->id);
                                         },
                                         'view' => function ($url, $model) {     
                                             return Html::a('<button class="btn btn-default btn-sm">View Email</button>', '/admin/email-generator/'.$model->id);
                                         },
                                         'delete' => function ($url, $model) {     
                                             return Html::a('<i class="fa fa-close"></i>', ['remove-email', 'id' => $model->id], [
                                                'class' => 'text-danger',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this email?',
                                                    'method' => 'post',
                                                ]]);
                                         },
                                    ], 
                    ],
        ],
    ]); ?>

    <a href="/admin/email-generator" class="btn btn-success">Create New</a>

</div>
