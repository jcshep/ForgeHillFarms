

<div class="spacer90"></div>

<div id="account">
	
	<div class="container">
	
		<div class="text-right">
				<h4>Welcome, <?= Yii::$app->user->identity->fname ?> <?= Yii::$app->user->identity->lname ?> <span><?= Yii::$app->user->identity->membership_type ?> Membership</span></h4>				
				
				<a href="/user/logout" class="btn btn-xs btn-success">Upgrade Membership</a>
				<a href="/user/logout" class="btn btn-xs btn-default">Logout</a>
				<a href="" class="btn btn-xs btn-default">Account Information</a>
		</div> 
	
	
		<h1>Forge Hill Farms</h1>
		
		<div class="spacer30"></div>

		<h3>Next Week's Goods</h3>



		<div class="spacer30"></div>
		<a href="" class="btn btn-sm btn-primary">Schedule Pickup</a>




		
	</div>

</div>