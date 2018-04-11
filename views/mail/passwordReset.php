<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>


<?= $this->render('mail-header'); ?>


<!-- 1 Column Text + Button : BEGIN -->
<tr>
	<td bgcolor="#fef8ec" style="padding: 40px 40px 20px; text-align: center;">
		
		<h1 style="text-align:center">RESET PASSWORD</h1> 

		<p style="margin-bottom:40px;">Please click the link below to reset your password and login.</p>
		
		<a href="<?= Yii::$app->params['siteUrl'] ?>/user/reset-password?auth_key=<?= $auth_key ?>" style="width:200px; margin:auto; background: #B93A26; border: 15px solid #B93A26;  font-size: 13px; line-height: 110%; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
			&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fef8ec;">RESET PASSWORD</span>&nbsp;&nbsp;&nbsp;&nbsp;
		</a>

	</td>
</tr>


<?= $this->render('mail-footer'); ?>