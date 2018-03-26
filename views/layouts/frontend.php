<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\FrontendAsset;
use app\assets\BxSliderAsset;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use app\models\Page;
use app\models\User;
use yii\redactor\widgets\RedactorAsset;

FrontendAsset::register($this);
RedactorAsset::register($this);


?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


</head>

<body>
<?php $this->beginBody() ?>

<div id="slide-out" class="visible-xs"><?= Page::nav(); ?></div>

<div id="top">
	<div class="container">
		
		<div class="row">
			<div class="col-xs-6">
				<?php if (!\Yii::$app->user->isGuest) { ?>
					<a href="/user/logout">LOGOUT</a>						
				<?php } else { ?>											
					<a href="/user/login">LOGIN</a>	
				<?php } ?>		
				
			</div> <!--col-->
			<div class="col-xs-6 text-right">
				<?php if (!\Yii::$app->user->isGuest) { ?>
					<span class="hidden-xs">Welcome, <?= Yii::$app->user->identity->fname ?> <?= Yii::$app->user->identity->lname ?></span>
					<div class="hspacer"></div>
					<a href="/user/account">MY ACCOUNT</a>

				<?php } else { ?>						
					<a href="/user/sign-up">SIGNUP</a>
				<?php } ?>				
			</div> <!--col-->
		</div> <!--row-->
		<div class="border"></div>
	</div>
</div>

<div class="spacer30 hidden-xs"></div>

<div id="header">
	<div class="container text-center">

		<div class="visible-xs" id="hamburger">
			<div class="top"></div>
			<div class="middle"></div>
			<div class="bottom"></div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="valign">
					<div class="valign-top"></div>
					<img src="/images/tag.png" alt="GREAT FOOD GREATER PURPOSE" class="header-img-1">
					<div class="valign-bottom"></div>
				</div>				
			</div> <!--col-->
			<div class="col-sm-4 border-sides">
				<div class="valign">
					<div class="valign-top"></div>
					<a href="/"><img id="logo" src="/images/logo.png" alt="Forge Hill Farms"></a>
					<div class="valign-bottom"></div>
				</div>					
			</div> <!--col-->
			<div class="col-sm-4">
				<div class="valign">
					<div class="valign-top"></div>
						<img src="/images/address.png" alt="GREAT FOOD GREATER PURPOSE" class="header-img-2">
					<div class="valign-bottom"></div>
				</div>					
			</div> <!--col-->
		</div> <!--row-->
		<div class="spacer30 hidden-xs"></div>
		<div class="border"></div>
	</div>
</div>



<div id="nav">
	<div class="container">	
		<?php if (User::isAdmin()): ?>
			<a href="/page/admin" class="edit-link corner" target="blank">Edit Pages</a>
		<?php endif ?>	
		<?= Page::nav(); ?>
		<div class="border"></div>
	</div>
</div>

<div class="spacer15"></div>



<?= $content ?>


<div class="spacer60"></div>

<div id="footer">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<a href="/"><img src="/images/footer-logo.svg" alt="Forge Hill Farms"></a>
			</div> <!--col-->
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-3 hidden-xs">
						<ul>
							<?= Page::nav(); ?>
						</ul>
					</div> <!--col-->
					<div class="col-sm-3">
						<ul>
							<li><a href="https://www.facebook.com/forgehillfarm/" target="_blank">Facebook</a></li>
							<li><a href="https://www.instagram.com/forgehill/" target="_blank">Instagram</a></li>
						</ul>
						<div class="spacer30 visible-xs"></div>
					</div> <!--col-->
					<div class="col-sm-3">
						<?= Page::editBlock('footer-address','text','Edit Address', 'top', 'footer'); ?>
						<?= Page::renderBlock('footer-address'); ?><br>				
						<a href="mailto:info@forgehillfarms.com">INFO@FORGEHILLFARMS.COM</a>
					</div> <!--col-->
					<div class="col-sm-3 text-right">
						<div class="spacer30 visible-xs"></div>
						<img src="/images/footer-stamp.svg" alt="">
					</div> <!--col-->
				</div> <!--row-->
			</div> <!--col-->
		</div> <!--row-->

	</div>
</div>



<!-- Edit Modal -->
<?php Modal::begin(['header' => 'Edit Section', 'id'=>'edit-modal', 'toggleButton' => false, 'size'=>'modal-lg']); ?>
    <div id="edit-content-box"></div>
<?php Modal::end(); ?>
<!-- End Edit Modal -->



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
