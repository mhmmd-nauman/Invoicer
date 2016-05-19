	<div class="modal fade" id="modal_newClient" tabindex="-1" role="dialog" aria-labelledby="modal_newClient" aria-hidden="true">	
		
		<div class="modal-dialog modal-lg">
								   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-plus"></span> <?php echo $this->lang->line('heading_add_new_client');?></h4>
	      	  	</div>
				
				<form class="form-horizontal" action="<?php echo site_url('clients/create');?>" method="post" data-toggle="validator" id="form_newClient">
	      	  	
					<div class="modal-body">
						
						<div class="alerts"></div>
													
						<div class="form-group">
							<label for="field_clientName" class="col-sm-3 control-label"><?php echo $this->lang->line('client_name_label');?>: <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="field_clientName" name="field_clientName" placeholder="<?php echo $this->lang->line('client_name_placeholder');?>" value="" required data-error="<?php echo $this->lang->line('client_name_error');?>">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="field_clientContact" class="col-sm-3 control-label"><?php echo $this->lang->line('client_contact_label');?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="field_clientContact" name="field_clientContact" placeholder="<?php echo $this->lang->line('client_contact_placeholder');?>" value="">
							</div>
						</div>
															  	
						<div class="form-group">
							<label for="field_clientEmail" class="col-sm-3 control-label"><?php echo $this->lang->line('client_email_label');?>: <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="field_clientEmail" name="field_clientEmail" placeholder="<?php echo $this->lang->line('client_email_placeholder');?>" value="" required data-error="<?php echo $this->lang->line('client_email_error');?>">
								<div class="help-block with-errors"></div>
							</div>
						</div>
								
						<div class="form-group">
							<label for="field_clientPhone" class="col-sm-3 control-label"><?php echo $this->lang->line('client_phone_label');?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="field_clientPhone" name="field_clientPhone" placeholder="<?php echo $this->lang->line('client_placeholder');?>" value="">
							</div>
						</div>
																													
						<div class="form-group">
							<label for="field_clientFax" class="col-sm-3 control-label"><?php echo $this->lang->line('client_fax_label');?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="field_clientFax" name="field_clientFax" placeholder="<?php echo $this->lang->line('client_fax_placehoder');?>" value="">
							</div>
						</div>
						
						<div class="form-group">
							<label for="field_defaultCurrency" class="col-sm-3 control-label"><?php echo $this->lang->line('client_default_currency_label');?>:</label>
							<div class="col-sm-9">
								<select id="field_defaultCurrency" name="field_defaultCurrency" class="form-control regular chosen">
								    <?php foreach( $allCurrencies as $currency ):?>
									<option value="<?php echo $currency->currency_shortname;?>" <?php if( $currency->currency_shortname == 'USD' ):?>selected<?php endif;?>><?php echo $currency->currency_shortname;?> <?php echo $currency->currency_sign;?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
										
						<div class="form-group">
							<label for="field_clientWebsite" class="col-sm-3 control-label"><?php echo $this->lang->line('client_website_label');?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="field_clientWebsite" name="field_clientWebsite" placeholder="<?php echo $this->lang->line('client_website_placeholder');?>" value="">
							</div>
						</div>
										
						<div class="form-group">
							<label for="field_clientAddress" class="col-sm-3 control-label"><?php echo $this->lang->line('client_address_label');?>:</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="field_clientAddress" name="field_clientAddress" placeholder="<?php echo $this->lang->line('client_address_placeholder');?>" rows="6"></textarea>
							</div>
						</div>
						
						<div class="form-group"></div>
										
	      	  		</div>
	      	  	
					<div class="modal-footer">
	        			<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        			<button type="submit" class="btn btn-primary btn-embossed" id="button_confirmUpdatePayment" data-rowindex=""><span class="fui-check"></span> <?php echo $this->lang->line('create_new_client');?></button>
	      	  		</div>
				
				</form>
	    	
			</div><!-- /.modal-content -->
				  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->