
<!-- Modal -->
<div class="modal fade" id="modal-pay" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            	<?php if ($user->stripe_id) { ?>
            		
            		<h3>Using Saved Credit Card</h3>
					<div class="saved-cc"><span>xxxx xxxx xxxx </span> <?= $user->stripe_last_4 ?> </div>
                    <input type="text" name="using-saved-cc" class="hidden using-saved-cc" value="1"> 

            	<?php } ?>

                <?php 
                if (!$user->stripe_id) {
	                echo $this->render('/user/_ccform', [
						'model'=>$charge,
						'form'=>$form]
					); 
				}
				?>
            </div>
            <div class="modal-footer">
            	<div class="row">
            		<div class="col-sm-6 save-cc">
            			<?php 
            			if (!$user->stripe_id) 
            				echo $form->field($charge, 'save_cc')->checkbox();
            			?>	

                            

            			<?php if ($user->stripe_id) { ?>
            				<a href="/user/remove-cc" class="remove-card"><i class="fa fa-close"></i> Remove Saved Credit Card</a>
            			<?php } ?>	
                        
            		</div> <!--col-->
            		<div class="col-sm-6">
            			$<input type="text" name="Charge[amount]" value="" class="charge-amount">
            			<button type="submit" class="btn btn-primary">Confirm</button>
            		</div> <!--col-->
            	</div> <!--row-->
            	
            </div>
        </div>
    </div>
</div>




