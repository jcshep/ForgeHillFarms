<?php  
	
	use yii\helpers\Html;

?>



<?php if($model->errors) { ?>
<div class="alert bg-danger">
	<?= $form->errorSummary($model); ?>
</div>
<?php } ?>

<div class="row">
	<div class="col-sm-12">
		<?php echo $form->field($model, 'cc')->textInput() ?>
		<?php 
									// $form->field($order, 'cc')
									// 	 ->textInput(['data-stripe' => 'number'])
									// 	 ->widget(\yii\widgets\MaskedInput::className(), [
									// 		'mask' => '9999-9999-9999-9999',
									// 	]) 
		?>
	</div> <!--col-->
</div>


<div class="row">
	<div class="col-md-3 col-xs-3">
	<label>Exp. Month</label>
	<?php 
	$months = cal_info(0);
		echo Html::activeDropDownList($model, 'cc_exp_month',$months['months'],['class'=>'form-control tall','data-stripe'=> 'exp-month']
	);
	?>
	<div class="spacer15 visible-sm visible-xs"></div>
	</div>

	<div class="col-md-3 col-xs-3">
		<label>Exp. Year</label>
		<?php 
			$year = date('Y');
			$i=0;
			while ($i <= 10) {
				$years[$year+$i] = $year+$i;
				$i++;
			}
			echo Html::activeDropDownList($model, 'cc_exp_year',$years,['class'=>'form-control tall','data-stripe'=> 'exp-year']
    	);?>
    	<div class="spacer15 visible-sm visible-xs"></div>
	</div>

	<div class="col-md-3 col-xs-3">
		<?= $form->field($model, 'cvc')->textInput(['data-stripe'=> 'cvc']) ?>
	</div>

	<div class="col-md-3 col-xs-3">
			<?= $form->field($model, 'cc_zip')->textInput() ?>
		</div>
</div> <!--row-->