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

		<p style="margin-bottom:40px;"><strong>The CSA season starts the first full week of June and is 23 weeks long usually ending the first week of November.</strong> There is an additional pick up the week before Thanksgiving. As a member, you will receive a weekly email on Mondays that lists our available produce for the week. The weekly newsletter will have information on upcoming events and recipe ideas. The email will ask you what day you want to pick up that week and if you want any additional add-on items.</p>
		<p style="margin-bottom:40px;">While you wait for the season to start, please check out our year-round online farm store.  We sell beef, pork, lamb, chicken, eggs, honey, and some produce all year long.  If you sign up for the newsletter you will receive information about new items in the farm store.  Here is the link:  <a href="https://forgehillfarms.com/store">https://forgehillfarms.com/store</a>.</p>
		<p style="margin-bottom:40px;">Please know that you can contact us at anytime (info@forgehillfarms.com) and please spread the word.  We increase the amount of members every year so we are always looking for new folks.</p>
		<p>Thank you for your interest in our farm.</p>

		<a href="<?= Yii::$app->params['siteUrl'] ?>/user/account" style="width:200px; margin:auto; background: #B93A26; border: 15px solid #B93A26;  font-size: 13px; line-height: 110%; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
			&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fef8ec;">MY ACCOUNT</span>&nbsp;&nbsp;&nbsp;&nbsp;
		</a>

	</td>
</tr>


<?= $this->render('mail-footer'); ?>