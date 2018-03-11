<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>

<?php //echo $this->render('_header', ['title'=>NULL]); ?>


<h2><?= Yii::$app->params['siteName'] ?></h2>

<p>Please click the link below to reset your password and login.</p>

<a class="btn btn-warning" href="<?= Yii::$app->params['siteUrl'] ?>/user/reset-password?auth_key=<?= $auth_key ?>">Reset Password</a>
