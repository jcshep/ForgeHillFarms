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

    <h1>Newsletter List</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            'name',
            'email:email',            
            ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '20'],
                                    'template' => '{delete}',
                                    'buttons'=>[
                                         'delete' => function ($url, $model) {     
                                             return Html::a('<i class="fa fa-close"></i>', ['remove-newsletter-email', 'id' => $model->id], [
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

</div>
