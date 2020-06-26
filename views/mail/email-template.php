<?php  
    use app\models\ProductWeek;
?>

    <?= $this->render('mail-header'); ?>

            <!-- 1 Column Text + Button : BEGIN -->
            <tr>
                <td bgcolor="#fef8ec" style="padding: 40px 40px 20px; text-align: center;">
                    <?= $model->content_area_1 ?>
                </td>
            </tr>
            
            <?php if ($model->type == 'weekly'): ?>
            <tr>
                <td bgcolor="#fef8ec" style="padding: 0 40px 40px;  font-size: 15px; line-height: 140%; color: #05426b;">
                    <!-- Button : BEGIN -->
		              <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">
                        <tr>
                            <td style="border-radius: 3px; background: #B93A26; text-align: center;" class="button-td">
                                <a href="https://forgehillfarms.com/user/account" style="background: #B93A26; border: 15px solid #B93A26;  font-size: 13px; line-height: 110%; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fef8ec;">SCHEDULE YOUR PICKUP</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                </a>
                            </td>
                        </tr>
                    </table>
                    <!-- Button : END -->
                </td>
            </tr>
            <!-- 1 Column Text + Button : END -->
            
            <!-- Clear Spacer : BEGIN -->
            <tr>
                <td aria-hidden="true" height="40" style="font-size: 0; line-height: 0;">
                    &nbsp;
                </td>
            </tr>
            <!-- Clear Spacer : END -->
            <?php endif; ?>
            

	        <!-- 2 Even Columns : BEGIN -->
	        <tr>
	            <td align="center" valign="top" style="padding: 10px;">
	                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
	                    <tr>
	                        <!-- Column : BEGIN -->
	                        <td class="stack-column-center left">
	                            
                                <?= $model->content_area_2 ?>
                                


                                <?= $model->content_area_3 ?>

                                <?php if ($model->getAttachment()): ?>
                                    <a target="_blank" href="<?php echo Yii::$app->params['siteUrl'] ?>/<?php echo $model->getAttachment(); ?>" style="background: #B93A26; border: 15px solid #B93A26;  font-size: 13px; line-height: 110%; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#fef8ec;">DOWNLOAD ATTACHMENT</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    </a>
                                <?php endif ?>

	                        </td>
	                        <!-- Column : END -->
                            
                            <?php if ($model->type == 'weekly'): ?>
                                                            
	                        <!-- Column : BEGIN -->
	                        <td class="stack-column-center right" valign="top">
	                            <div style="background-color:#174375; text-align:center; padding:5px 20px 20px; margin-left:30px;">
                                    <h3 style="color:#FFF">This Week's haul</h3>   
                                    <div style="background:#FFF; color:#B93A26; display:inline-block; padding:2px 8px;"><?= date('m.d.Y') ?></div>
                                    <?php echo ProductWeek::generateWeeklyList(); ?>
                                </div>
	                        </td>
	                        <!-- Column : END -->

                            <?php endif ?>
	                    </tr>
	                </table>
	            </td>
	        </tr>
	        <!-- 2 Even Columns : END -->

	        
            

	        <?= $this->render('mail-footer'); ?>