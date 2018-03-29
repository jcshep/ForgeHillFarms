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
                'attribute'=>'send_date',
                'format'=>'date',
                'filter'=>false,
            ],
            ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '70'],
                                    'template' => '{view}',
                                    'buttons'=>[
                                        // 'view' => function ($url, $model) {     
                                        //      return Html::a('<button class="btn btn-primary btn-xs">Update</button>', '/'.$model->slug);
                                        //  },
                                         'view' => function ($url, $model) {     
                                             return Html::a('<button class="btn btn-default btn-sm">View Email</button>', '/admin/email-generator/'.$model->id);
                                         }
                                    ], 
                    ],
        ],
    ]); ?>

    <a href="/admin/email-generator" class="btn btn-success">Create New</a>

</div>
