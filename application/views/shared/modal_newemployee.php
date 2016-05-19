<div class="modal fade" id="modal_newEmployee" tabindex="-1" role="dialog" aria-labelledby="modal_newEmployee" aria-hidden="true">	
		
		<div class="modal-dialog modal-lg">
								   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-plus"></span> Add New Employee</h4>
	      	  	</div>
				
				<form class="form-horizontal" action="<?php echo site_url('user/createEmployee/'.$theUser->id);?>" method="post" data-toggle="validator" id="form_newEmployee">
	      	  	
					<div class="modal-body">
						
						<div class="alerts"></div>
													
						<div class="form-group">
							<label for="field_clientName" class="col-sm-3 control-label">First Name: <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value=""  data-error="Please enter the First Name">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="field_clientContact" class="col-sm-3 control-label">Last Name:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="">
							</div>
						</div>
                                                
						<div class="form-group">
							<label for="field_clientPhone" class="col-sm-3 control-label">Phone:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="">
							</div>
						</div>
                                                <div class="form-group">
							<label for="field_clientPhone" class="col-sm-3 control-label">Company:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="company" name="company" placeholder="Company" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="field_clientEmail" class="col-sm-3 control-label">Email: <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" value=""  data-error="<?php echo $this->lang->line('client_email_error');?>">
								<div class="help-block with-errors"></div>
							</div>
						</div>
								
						<div class="form-group">
							<label for="field_clientName" class="col-sm-3 control-label">Password: <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" value=""  data-error="Please enter the Password">
								<div class="help-block with-errors"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="field_clientName" class="col-sm-3 control-label">Confirm Password: <span class="text-danger">*</span></label>
							<div class="col-sm-9">
                                                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password" value=""  data-error="Please enter the Confirm Password">
								<div class="help-block with-errors"></div>
							</div>
						</div>																							
						
						
						
						<div class="form-group"></div>
										
	      	  		</div>
	      	  	
					<div class="modal-footer">
	        			<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        			<button type="submit" class="btn btn-primary btn-embossed" id="button_confirmUpdatePayment" data-rowindex=""><span class="fui-check"></span> Create New Employee</button>
	      	  		</div>
				
				</form>
	    	
			</div><!-- /.modal-content -->
				  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->
