<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPage */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">



    <section class="widget">
        <header>
            <h4><?= Html::encode($this->title) ?></h4>                
        </header>

        <div class="widget-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout'=>"{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    'title',

                    ['class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '70'],
                                    'template' => '{view}',
                                    'buttons'=>[
                                        // 'view' => function ($url, $model) {     
                                        //      return Html::a('<button class="btn btn-primary btn-xs">Update</button>', '/'.$model->slug);
                                        //  },
                                         'view' => function ($url, $model) {     
                                             return Html::a('<button class="btn btn-default btn-sm">Update</button>', '/page/update/'.$model->id);
                                         }
                                    ], 
                    ],
                ],
            ]); ?>
        </div>

        <a href="/page/create" class="btn btn-success">Add Page</a>
</div>
