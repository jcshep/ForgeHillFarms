<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AppHelper;
use app\models\User;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Weekly Overview';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="scheduled-pickups">
	
	<div class="row">
		<div class="col-sm-8">
			<h1>
				Scheduled Pickups <br>
				<small><?= AppHelper::getCurrentWeekDates()['start-formatted']; ?> to <?= AppHelper::getCurrentWeekDates()['end-formatted']; ?></small>
			</h1>
		</div> <!--col-->
		<div class="col-sm-4 text-right">
			<div class="spacer30"></div>
			<a href="" class="btn btn-success"><i class="fa fa-download"></i> Export</a>
		</div> <!--col-->
	</div> <!--row-->
	
	
	<div class="spacer30"></div>


	<div class="row">
		
		

		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Thursday</h4></div>
				<div class="panel-body">
					<p><em>No Scheudled Pickups</em></p>
				</div>
			</div>
		</div>
		
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Saturday</h4></div>
				<div class="panel-body">
					<p><em>No Scheudled Pickups</em></p>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Not yet selected a pickup time</h4></div>
				<div class="panel-body">
					<table class="table table-condensed small">
						<tr>
							<th width="70%">Name</th>
							<th width="20%"></th>
						</tr>
						<?php foreach (User::find()->all() as $user): ?>
							<tr>
								<td><?= $user->fname ?> <?= $user->lname ?></td>
								<td>
									<?php  
									if($user->membership_type == 'free') 
										echo '<div class="text-center"><div class="btn btn-xs btn-success">FREE</div></div>';                                    

									if($user->membership_type == 'half') 
										echo '<div class="text-center"><div class="btn btn-xs btn-primary">HALF</div></div>';       

									if($user->membership_type == 'full') 
										echo '<div class="text-center"><div class="btn btn-xs btn-info">FULL</div></div>';  
									?>
								</td>
							</tr>
						<?php endforeach ?>
					</table>
				</div>
			</div>
		</div>

	</div> <!--row-->
	
	



	


</div>