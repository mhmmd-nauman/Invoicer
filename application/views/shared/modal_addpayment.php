	<div class="modal fade" id="modal_addPayment" tabindex="-1" role="dialog" aria-labelledby="modal_addPayment" aria-hidden="true">	
		
		<div class="modal-dialog">
								   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-plus"></span> <?php echo $this->lang->line('add_payment');?></h4>
	      	  	</div>
	      	  	
				<form id="form_addPayment" data-toggle="validator">
				
					<div class="modal-body">
											
						<div class="form-group">
							<input type="number" data-type="number" class="form-control" name="field_paymentAmount" id="field_paymentAmount" placeholder="<?php echo $this->lang->line('amount_placeholder');?>" required data-error="<?php echo $this->lang->line('amount_error');?>" step="0.01">
							<div class="help-block with-errors"></div>
						</div>
						
						<div class="form-group">
							<select class="form-control select select-default select-block mbl" name="field_paymentType" id="field_paymentType" required>
								<?php foreach( $paymentTypes as $paymentType ):?>
								<option value="<?php echo $paymentType->payment_type_id;?>"><?php echo $paymentType->payment_type;?></option>
								<?php endforeach;?>
							</select>
							<div class="help-block with-errors"></div>
						</div>
						
						<div class="form-group">
							<div class="input-group">
							    <span class="input-group-btn">
							      <button class="btn" type="button"><span class="fui-calendar"></span></button>
							    </span>
							    <input type="text" class="form-control datePicker" name="field_paymentDate" id="field_paymentDate" value="<?php echo date($this->config->item('date_format_php'));?>" required data-error="<?php echo $this->lang->line('payment_date_error');?>">
							</div>
							<div class="help-block with-errors"></div>
						</div>
					
	      	 	   </div><!-- /.modal-body -->
	      	  	
					<div class="modal-footer">
	        			<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        			<button type="submit" class="btn btn-primary btn-embossed" data-rowindex=""><span class="fui-check"></span> <?php echo $this->lang->line('add_payment');?></button>
	      	  		</div>
				
				</form>
	    	
			</div><!-- /.modal-content -->
				  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->