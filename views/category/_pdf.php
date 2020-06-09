<?php  

use app\models\MenuCategory;
use app\models\MenuItem;

?>


<div class="logo">
	<img src="images/logo-pdf.jpg" alt="">
</div>

<div id="menu">
<?php $i=1; foreach (MenuCategory::find()->where(['display_menu'=>1])->orderBy('order ASC')->all() as $category): ?>
	
	<div>
		<h3><?= $category->title ?></h3>
		<div class="description"><?= $category->description ?></div>
		<?php foreach ($category->getItemsByLocation($location) as $item): ?>	
			<div class="item">
				<h5> 
					<?= $item->title ?> 
					<?php if ($item->getPriceByLocation($location)): ?>
						&nbsp;&nbsp;<span class="price"><?= $item->getPriceByLocation($location) ?></span>	
					<?php endif ?>	
				</h5>

				<?php //echo $item->info ?>	

				<p><?= $item->subtitle ?> </p>
										

				
				<div class="details">
					<?php echo $item->description ?>
				</div>
			</div>
		<?php endforeach ?>
	</div>
<?php $i++; endforeach ?>


</div>