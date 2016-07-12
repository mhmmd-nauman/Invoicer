	<div class="modal fade" id="modal_account" tabindex="-1" role="dialog" aria-labelledby="modal_account" aria-hidden="true">
		
		<div class="modal-dialog modal-lg">
								   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-gear"></span> <?php echo $this->lang->line('account_and_company_details');?></h4>
	      	  	</div>
	      	  	
				<div class="modal-body">
					
					<!-- Tabs -->
					<ul class="nav nav-tabs nav-append-content">
					  	<li class="active"><a href="#company"><?php echo $this->lang->line('tab_company_and_personal_details');?></a></li>
						<li><a href="#account"><?php echo $this->lang->line('tab_my_account');?></a></li>
					</ul>

					<!-- Tab content -->
					<div class="tab-content">
						
						<div class="tab-pane active" id="company">
					    	
							<form class="form-horizontal" id="form_details" method="post" action="<?php echo site_url('user/updateDetails/'.$user->id)?>" data-toggle="validator" enctype="multipart/form-data">
								
								<div class="alerts"></div>
								
								<div class="form-group">
							    	<label for="field_firstName" class="col-sm-3 control-label"><?php echo $this->lang->line('first_name_label');?>: <span class="text-danger">*</span></label>
							    	<div class="col-sm-9">
							      	  	<input type="text" class="form-control" id="field_firstName" name="field_firstName" placeholder="<?php echo $this->lang->line('first_name_placeholder');?>" value="<?php echo $user->first_name;?>" required data-error="<?php echo $this->lang->line('first_name_error');?>">
										<div class="help-block with-errors"></div>
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<label for="field_lastName" class="col-sm-3 control-label"><?php echo $this->lang->line('last_name_label');?>: <span class="text-danger">*</span></label>
							    	<div class="col-sm-9">
							      	  	<input type="text" class="form-control" id="field_lastName" name="field_lastName" placeholder="<?php echo $this->lang->line('last_name_placeholder');?>" value="<?php echo $user->last_name;?>" required data-error="<?php echo $this->lang->line('last_name_error');?>">
										<div class="help-block with-errors"></div>
							    	</div>
							  	</div>
								
								<hr class="dashed">
								
								<div class="form-group">
							    	<label for="field_companyName" class="col-sm-3 control-label"><?php echo $this->lang->line('company_name_label');?>: <span class="text-danger">*</span></label>
							    	<div class="col-sm-9">
							      	  	<input type="text" class="form-control" id="field_companyName" name="field_companyName" placeholder="<?php echo $this->lang->line('company_name_placeholder');?>" value="<?php echo $user->company_name;?>" required data-error="<?php echo $this->lang->line('company_name_error');?>">
										<div class="help-block with-errors"></div>
							    	</div>
							  	</div>
								
								<div class="form-group" <?php if( $user->company_logo == '' ):?>style="display:none"<?php endif;?>>
							    	<label for="field_companyName" class="col-sm-3 control-label"><?php echo $this->lang->line('company_logo_label');?>:</label>
							    	<div class="col-sm-9">
							      	  	<img src="<?php echo base_url($user->company_logo);?>" style="width: 200px" id="image_companyLogo"><br>
										<a href="#" class="btn btn-danger btn-xs" id="button_deleteLogo"><?php echo $this->lang->line('company_logo_delete');?></a>
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<label for="field_companyName" class="col-sm-3 control-label"><?php echo $this->lang->line('upload_logo_label');?>:</label>
							    	<div class="col-sm-9">
										<div class="fileinput fileinput-new" data-provides="fileinput">
										    <div class="input-group">
										      	<div class="form-control uneditable-input" data-trigger="fileinput">
										        	<span class="fui-clip fileinput-exists"></span>
										        	<span class="fileinput-filename"></span>
										      	</div>
										      	<span class="input-group-btn btn-file">
										        	<span class="btn btn-default fileinput-new" data-role="select-file"><?php echo $this->lang->line('upload_select_file');?></span>
										        	<span class="btn btn-default fileinput-exists" data-role="change"><span class="fui-gear"></span> <?php echo $this->lang->line('upload_change');?></span>
										        	<input type="file" name="field_companyLogo" id="field_companyLogo">
										        	<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span> <?php echo $this->lang->line('upload_remove');?></a>
										      	</span>
											</div>
										</div>
										<p class="help-block"><?php echo $this->lang->line('upload_message');?></p>
							    	</div>
							  	</div>
							  								
								<hr class="dashed">
								
								<div class="form-group">
							    	<label for="field_companyPhone" class="col-sm-3 control-label"><?php echo $this->lang->line('company_phone_label');?>:</label>
							    	<div class="col-sm-9">
							      	  	<input type="text" class="form-control" id="field_companyPhone" name="field_companyPhone" placeholder="<?php echo $this->lang->line('company_phone_placeholder');?>" value="<?php echo $user->company_phone;?>">
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<label for="field_companyFax" class="col-sm-3 control-label"><?php echo $this->lang->line('company_tax_label');?>:</label>
							    	<div class="col-sm-9">
							      	  	<input type="text" class="form-control" id="field_companyFax" name="field_companyFax" placeholder="<?php echo $this->lang->line('company_tax_placeholder');?>" value="<?php echo $user->company_phone;?>">
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<label for="field_companyAddress" class="col-sm-3 control-label"><?php echo $this->lang->line('company_address_label');?>:</label>
							    	<div class="col-sm-9">
							      	  	<textarea class="form-control" id="field_companyAddress" name="field_companyAddress" placeholder="<?php echo $this->lang->line('company_address_placeholder');?>" rows="5"><?php echo $user->company_address;?></textarea>
							    	</div>
							  	</div>
								
                                                                <div class="form-group">
                                                                        <label for="field_defaultCurrency" class="col-sm-3 control-label"><?php echo $this->lang->line('client_default_currency_label');?>:</label>
                                                                        <div class="col-sm-9">
                                                                                <select id="field_defaultCurrency" name="field_defaultCurrency" class="form-control regular chosen">
                                                                                    <?php foreach( $allCurrencies as $currency ):?>
                                                                                        <option value="<?php echo $currency->currency_shortname;?>" <?php if( $currency->currency_shortname == $user->default_currency ):?>selected<?php endif;?> ><?php echo $currency->currency_shortname;?> <?php echo $currency->currency_sign;?></option>
                                                                                        <?php endforeach;?>
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                                
								<div class="form-group">
							    	<label for="field_companyInfo" class="col-sm-3 control-label"><?php echo $this->lang->line('additional_info_label');?>:</label>
							    	<div class="col-sm-9">
							      	  	<textarea class="form-control" id="field_companyInfo" name="field_companyInfo" placeholder="<?php echo $this->lang->line('additional_info_placeholder');?>" rows="5"><?php echo $user->company_additionalinfo;?></textarea>
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<div class="col-sm-9 col-md-offset-3">
							      		<button type="submit" class="btn btn-primary btn-embossed"><span class="fui-check"></span> <?php echo $this->lang->line('update_details');?></button>
							    	</div>
							  	</div>
							  
							</form>
							
					  	</div><!-- /.tab-pane -->
						
						<div class="tab-pane" id="account">
					    	
							<form class="form-horizontal" id="form_account" method="post" action="<?php echo site_url('user/updateAccount/'.$user->id)?>" data-toggle="validator">
								
								<div class="alerts"></div>								
								
								<div class="form-group">
							    	<label for="field_email" class="col-sm-3 control-label"><?php echo $this->lang->line('username_label');?>: <span class="text-danger">*</span></label>
							    	<div class="col-sm-9">
							      	  	<input type="email" class="form-control" id="field_email" name="field_email" placeholder="<?php echo $this->lang->line('username_placeholder');?>" value="<?php echo $user->email;?>" required data-error="<?php echo $this->lang->line('username_error');?>">
										<div class="help-block with-errors"></div>
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<label for="field_password" class="col-sm-3 control-label"><?php echo $this->lang->line('password_label');?>: <span class="text-danger">*</span></label>
							    	<div class="col-sm-9">
							      	  	<input type="password" class="form-control" id="field_newpassword" name="field_newpassword" placeholder="<?php echo $this->lang->line('password_placeholder');?>" required data-error="<?php echo $this->lang->line('password_error');?>">
										<div class="help-block with-errors"></div>
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<label for="field_password2" class="col-sm-3 control-label"><?php echo $this->lang->line('password_re_label');?>: <span class="text-danger">*</span></label>
							    	<div class="col-sm-9">
							      	 	 <input type="password" class="form-control" id="field_newpassword2" name="field_newpassword2" placeholder="<?php echo $this->lang->line('password_re_placeholder');?>" required data-match="#field_newpassword" data-error="<?php echo $this->lang->line('password_re_error');?>">
										 <div class="help-block with-errors"></div>
							    	</div>
							  	</div>
								
								<div class="form-group">
							    	<div class="col-sm-9 col-md-offset-3">
							      		<button type="submit" class="btn btn-primary btn-embossed"><span class="fui-check"></span> <span class="buttonText"><?php echo $this->lang->line('save_account_details');?></span></button>
							    	</div>
							  	</div>
							  
							</form>
							
					  	</div><!-- /.tab-pane -->
					  
					</div><!-- /.tab-content -->
					
	      	  	</div><!-- /.modal-body -->
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('close_window');?></button>
	      	  	</div>
	    	
			</div><!-- /.modal-content -->
				  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->