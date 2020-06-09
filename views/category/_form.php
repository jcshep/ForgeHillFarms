<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

use yii\helpers\ArrayHelper;
use app\models\MenuItem;
use app\models\MenuCategoryLocation;
use app\models\AppHelper;
use app\models\Location;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $model app\models\MenuCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-category-form">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

	<div class="row">
		<div class="col-sm-2"><?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?></div> <!--col-->
	</div> <!--row-->
	
	<?php  /* ?>
	<?php echo $form->field($model, 'display_menu')->widget(\kartik\switchinput\SwitchInput::classname(), [
		'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
		])->label('Show this category and its items in the default menu');?>
			

	<?php echo $form->field($model, 'display_order_menu')->widget(\kartik\switchinput\SwitchInput::classname(), [
		'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
		])->label('Show this category and its items in the online ordering menu');?>

	<div class="spacer-sm"></div>
	*/?>

	

	<?php /*if ($model->isNewRecord): ?>
        
        <div class="well text-center location-checkbox">
            <h5>Please create the item before adding pricing and availability</h5>
        </div>

    <?php else: ?>
     <div class="row">
        <div class="col-sm-24 location-checkbox">
            <label>Location Availability</label>            
            <div class="spacer-sm"></div>
            
            <?php foreach (Location::find()->all() as $location): ?>

                <?php 
                    $menu_category_info[$location->id] = $location->getMenuCategoryInfo($model->id); 
                    

                    if(!$menu_category_info[$location->id]) {
                        $menu_category_info[$location->id] = new MenuCategoryLocation;
                        $hours = Setting::find()->select('value')->where(['location'=>$location->id, 'setting'=>'hours'])->one()->value;
                        $menu_category_info[$location->id]->availability_inherit = 1;
                    } else {
                        $hours = $menu_category_info[$location->id]->availability;
                    }


                ?>
                
                <div class="well <?= $menu_category_info[$location->id]->enabled ? 'active' : NULL ?>">
                    <div class="row">                        
                        <div class="col-md-16">                            
                            <h4>
                                <label>
                                <?= Html::checkbox(
                                            'location['.$location->id.'][enabled]', 
                                            $menu_category_info[$location->id]->enabled, 
                                            ['label' => NULL, 'class'=>'hide-show-checkbox', 'data-controls'=>'location-price-enabled-'.$location->id]) 
                                        ?>
                                <?= $location->name ?>
                                </label>
                            </h4>
                        </div> <!--col-->
                        <div class="col-md-4 col-md-offset-4">
                            <a href="" class="btn btn-default btn-sm btn-block location-price-enabled-<?= $location->id ?>">Availability <i class="fa fa-chevron-down"></i></a>
                        </div> <!--col-->
                    </div> <!--row-->

                    <div class="lower location-enabled-<?= $location->id ?>">
                        <div class="spacer-sm"></div>
                        <div class="notice text-danger">The following settings will only be applied to menu items in this category if the menu item is set to "inherit from category"</div>
                        <div class="inherit-options">
                            <label>
                            <?= Html::checkbox(
                                        'location['.$location->id.'][availability_inherit]', 
                                        $menu_category_info[$location->id]->availability_inherit, 
                                        ['label' => NULL, 'class'=>'hide-show-checkbox', 'data-controls'=>'availability-'.$location->id]) 
                                    ?>
	                            Available any time location is open
	                        </label>                            
	                        </div>                 
                        <div class="availability availability-<?= $location->id ?> <?= $menu_category_info[$location->id]->availability_inherit ? NULL : 'active' ?>">
                            <?php echo $this->render('/menu-item/_availability-hours', ['hours'=>$hours,'location'=>$location]); ?>    
                        </div>
                        
                    </div>
                </div>

            
            <?php endforeach ?>
           
        </div> <!--col-->
    </div> <!--row-->
    
    <?php endif //end if is new record */?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
