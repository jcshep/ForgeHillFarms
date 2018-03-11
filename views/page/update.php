<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Page */

$this->title = 'Update Page: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-update">

    

    <section class="widget">
        <header>
            <h4><?= Html::encode($this->title) ?></h4>          
        </header>
		
		<div class="widget-body">
	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	    
	    </div>
	</div>

</div>
