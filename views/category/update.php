<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MenuCategory */

$this->title = 'Update Category: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['admin/categories']];
$this->params['breadcrumbs'][] = ['label' => $model->title];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
