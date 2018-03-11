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


<div id="top">
	<div class="container">
		
		<div class="row">
			<div class="col-sm-6">
				<?php if (!\Yii::$app->user->isGuest) { ?>
					<a href="/user/login">LOGOUT</a>						
				<?php } else { ?>											
					<a href="/user/login">LOGIN</a>	
				<?php } ?>		
				
			</div> <!--col-->
			<div class="col-sm-6 text-right">
				<?php if (!\Yii::$app->user->isGuest) { ?>
					<a href="/user/sign-up">MY ACCOUNT</a>
				<?php } else { ?>						
					<a href="/user/sign-up">SIGNUP</a>
				<?php } ?>				
			</div> <!--col-->
		</div> <!--row-->
		<div class="border"></div>
	</div>
</div>

<div class="spacer30"></div>

<div id="header">
	<div class="container text-center">
		<div class="row">
			<div class="col-sm-4">
				<div class="valign">
					<div class="valign-top"></div>
					<img src="/images/tag.svg" alt="GREAT FOOD GREATER PURPOSE">
					<div class="valign-bottom"></div>
				</div>				
			</div> <!--col-->
			<div class="col-sm-4 border-sides">
				<div class="valign">
					<div class="valign-top"></div>
					<a href="/"><img id="logo" src="/images/logo.svg" alt="Forge Hill Farms"></a>
					<div class="valign-bottom"></div>
				</div>					
			</div> <!--col-->
			<div class="col-sm-4">
				<div class="valign">
					<div class="valign-top"></div>
						<img src="/images/address.svg" alt="GREAT FOOD GREATER PURPOSE">
					<div class="valign-bottom"></div>
				</div>					
			</div> <!--col-->
		</div> <!--row-->
		<div class="spacer30"></div>
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
					<div class="col-sm-3">
						<ul>
							<?= Page::nav(); ?>
						</ul>
					</div> <!--col-->
					<div class="col-sm-3">
						<ul>
							<li><a href="" target="_blank">Facebook</a></li>
							<li><a href="" target="_blank">Instagram</a></li>
							<li><a href="" target="_blank">Twitter</a></li>
						</ul>
					</div> <!--col-->
					<div class="col-sm-3">
						<?= Page::editBlock('footer-address','text','Edit Address', 'top', 'footer'); ?>
						<?= Page::renderBlock('footer-address'); ?>						
						<a href="mailto:info@forgehillfarms.com">INFO@FORGEHILLFARMS.COM</a>
					</div> <!--col-->
					<div class="col-sm-3 text-right">
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
