<?php  

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AppHelper;
use yii\widgets\ActiveForm;

?>

<?php \yii\widgets\Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchProduct,
    'layout'=>"{items}\n{pager}",
    'tableOptions' => ['class' => 'table table-striped table-condensed'],
    'columns' => [
        [
        	'attribute' => 'name',
        	'label' => false,
        ],  	
        ['class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '75'],
                                'template' => '{delete} {view}',
                                'buttons'=>[
                                    'delete' => function ($url, $model) {     
                                         return Html::a('<i class="fa fa-close"></i>', ['delete-product', 'id' => $model->id], [
                                         	'class' => 'text-danger',
                                         	'data' => [
                                         		'confirm' => 'Are you sure you want to delete this product?',
                                         		'method' => 'post',
                                         	]]);
                                     },
                                     'view' => function ($url, $model) {     
                                         return Html::a('<button class="btn btn-info btn-xs"><strong>ADD</strong> <i class="fa fa-chevron-right"></i></button>', 
                                                            ['product-add', 'id' => $model->id, 's'=>AppHelper::getCurrentWeekDates()['start'], 'e'=>AppHelper::getCurrentWeekDates()['end']]
                                                        );
                                     }
                                ], 
                ],
    ],
]); ?>
<?php \yii\widgets\Pjax::end(); ?>


<a data-toggle="modal" data-target="#modal-add-<?= $type ?>" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add product</a>

<!-- Modal -->
<?php $form = ActiveForm::begin(); ?>
<div class="modal fade" id="modal-add-<?= $type ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				

					<?php echo $form->errorSummary($product); ?>

					<?= $form->field($product, 'name')->textInput(['maxlength' => true])->label('Product Name') ?>
					
					<?= $form->field($product, 'type')->hiddenInput(['value' => $type])->label(false) ?>

				
			</div>
			<div class="modal-footer">
				<?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	        
			</div>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>