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
		
		<h1 style="text-align:center">Welcome to Forge Hill Farms</h1> 

		<p style="margin-bottom:40px;">Thank you for joining our CSA.  We want you to love being a part of our farm and look forward to hearing from you about how we can improve your experience.  </p>
		<p style="margin-bottom:40px;">As a member, you will receive a weekly email on Mondays that list our available produce for the week.  The weekly newsletter will have information on upcoming events and other helpful information.  You will also be asked to select if you want any additional add-on items and the day that you plan to pick up your share.  </p>
		<p style="margin-bottom:40px;">Please know that you can contact us at anytime and thank you for your interest in our farm. </p>
		
		<a href="<?= Yii::$app->params['siteUrl'] ?>/user/account" style="width:200px; margin:auto; background: #B93A26; border: 15px solid #B93A26;  font-size: 13px; line-height: 110%; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
			&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fef8ec;">MY ACCOUNT</span>&nbsp;&nbsp;&nbsp;&nbsp;
		</a>

	</td>
</tr>


<?= $this->render('mail-footer'); ?>