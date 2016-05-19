<?php $this->load->view('shared/header')?>
	
	<div class="leftBar2">
		
		<div class="buttonWrapper">
			<div class="input-group">
				<input type="text" id="field_filterClients" placeholder="Filter clients" class="form-control">
				<span class="input-group-btn">
					<button class="btn" type="submit"><span class="fui-search"></span></button>
				</span>
			</div>
		</div>
		
		<ul class="paneOneList clientList" id="clientList">
			<?php if( $users ):?>
			<?php foreach( $users as $user ):?>
			<li >
				<a href="<?php echo site_url('users/'.$user->id)?>">
					<b><?php echo $user->first_name." ".$user->last_name;?></b>
					<span class="clearfix">
						
					</span>
				</a>
			</li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
		
		<?php if( !$users ):?>
		<div class="alert alert-info" style="margin: 20px">
		  	<button class="close fui-cross" data-dismiss="alert"></button>
		  	<h4>No Users</h4>
		  	<p>
		  		No Users
		  	</p>
		</div>
		<?php endif;?>
		
	</div><!-- /.leftBar2 -->
	
	<section class="app">
	
	<div class="container">
		
		<div class="row">
						
			<div class="col-md-12 paneTwo">
				
				<?php if( $this->session->flashdata('error') ):?>
				<div style="margin-top: 20px">
					<?php echo $this->session->flashdata('error');?>
				</div>
				<?php endif;?>
				
				<?php if( $this->session->flashdata('success') ):?>
				<div style="margin-top: 20px">
					<?php echo $this->session->flashdata('success');?>
				</div>
				<?php endif;?>
				
				<?php if( isset($theUser) ):?>
				
				<div role="tabpanel" class="clientTabs">

					<!-- Nav tabs -->
				  	<ul class="nav nav-tabs nav-append-content" role="tablist">
					<li role="presentation" <?php if($active_tab==""){?>class="active"<?php }?>><a href="#clientOverview" aria-controls="clientOverview" role="tab" data-toggle="tab"><span class="fa fa-tachometer"></span> User Details</a></li>
				    	<li role="presentation" <?php if($active_tab=="groups"){?>class="active"<?php }?>><a href="#clientGroups" aria-controls="clientGroups" role="tab" data-toggle="tab"><span class="fa fa-tachometer"></span> Groups</a></li>
				    	<li role="presentation" <?php if($active_tab=="active_employee"){?>class="active"<?php }?>><a href="#clientEmployee" aria-controls="clientEmployee" role="tab" data-toggle="tab"><span class="fa fa-tachometer"></span> Employees</a></li>
                                        </ul>
					
					<form class="form-horizontal" method="post" action="<?php echo site_url('users/update/'.$theUser->id);?>" data-toggle="validator">

				  	<!-- Tab panes -->
				  	<div class="tab-content">
						
                                                <div role="tabpanel" class="tab-pane <?php if($active_tab==""){?>active<?php }?>" id="clientOverview">
							
							<div class="dashboard">
								
                                                            <div class="form-group">
                                                                <label for="field_clientName" class="col-sm-3 control-label">First Name:<span class="text-danger">*</span></label>
                                                                <div class="col-sm-9">
                                                                        <input type="text" class="form-control" id="field_clientName" name="field_clientName" placeholder="First Name" value="<?php echo $theUser->first_name;?>" required data-error="<?php echo $this->lang->line('client_name_error');?>">
                                                                        <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="field_clientName" class="col-sm-3 control-label">Last Name:<span class="text-danger">*</span></label>
                                                                <div class="col-sm-9">
                                                                        <input type="text" class="form-control" id="field_clientName" name="field_clientName" placeholder="Last Name" value="<?php echo $theUser->last_name;?>" required data-error="<?php echo $this->lang->line('client_name_error');?>">
                                                                        <div class="help-block with-errors"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label for="field_clientContact" class="col-sm-3 control-label">Phone:</label>
                                                                    <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="field_clientContact" name="field_clientContact" placeholder="Phone" value="<?php echo $theUser->phone;?>">
                                                                    </div>
                                                            </div>	
                                                            <div class="form-group">
                                                                    <label for="field_clientContact" class="col-sm-3 control-label">Company:</label>
                                                                    <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="field_clientContact" name="field_clientContact" placeholder="Company" value="<?php echo $theUser->company;?>">
                                                                    </div>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label for="field_clientContact" class="col-sm-3 control-label">Email:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="field_clientContact" name="field_clientContact" placeholder="Email" value="<?php echo $theUser->email;?>">
                                                                    </div>
                                                            </div>
                                                            <div class="form-group">
                                                                    <label for="field_clientContact" class="col-sm-3 control-label">Web Address:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="field_clientContact" name="field_clientContact" placeholder="Web Address" value="<?php echo $theUser->webaddress;?>">
                                                                    </div>
                                                            </div>
                                                            <div class="form-group">
								<div class="col-sm-9 col-sm-offset-3 clientDetailsButtons">
									<button type="submit" class="btn btn-primary btn-embossed btn-wide"><span class="fui-check"></span> <?php echo $this->lang->line('update_details');?></button>
									<span style="padding: 0px 30px" class="hidden-md hidden-sm hidden-xs">or</span>
									<a href="<?php echo site_url('users/delete/'.$theUser->id)?>" class="btn btn-danger btn-embossed btn-wide" id="button_deleteClient"><span class="fui-cross"></span> Delete User</a>
								</div>
                                                            </div>
							</div><!-- /.dashboard -->
							
						</div><!-- /.tab-pane -->
						
                                                <div role="tabpanel" class="tab-pane <?php if($active_tab=="gropus"){?>active<?php }?>" id="clientGroups">
							
							<div class="dashboard">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    Member of Groups 
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-default navbar-btn btn-sm addClientButton" type="button" data-target="#modal_newEmployee" data-toggle="modal"><span class="fui-plus"></span> 
                                                                            Manage Groups
                                                                    </button>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                            <ul class="paneOneList invoiceList" id="invoiceList">
                                                            <?php //print_r($groups);?>
                                                           <?php foreach($groups as $group){?>
                                                            <li class="all due" data-year="any">
                                                                <a href="#">
                                                                        <span class="clearfix">
                                                                            <span class=" pull-left"><?php echo $group->name;?></span>
                                                                        </span>

                                                                </a>
                                                            </li>
                                                                    <!--
                                                                    <div class="col-sm-9">
                                                                        <input type="checkbox"  id="in_group" name="in_group[]"  value="<?php echo $group->id;?>">
                                                                    </div> 
                                                                    -->
                                                            
                                                           <?php }?>
                                                            </ul>
                                                            </div>
                                                            <!--
                                                            <div class="form-group">
								<div class="col-sm-9 col-sm-offset-3 clientDetailsButtons">
									<button type="submit" class="btn btn-primary btn-embossed btn-wide"><span class="fui-check"></span> <?php echo $this->lang->line('update_details');?></button>
									<span style="padding: 0px 30px" class="hidden-md hidden-sm hidden-xs">or</span>
									<a href="<?php echo site_url('users/delete/'.$theUser->id)?>" class="btn btn-danger btn-embossed btn-wide" id="button_deleteClient"><span class="fui-cross"></span> Delete User</a>
								</div>
                                                            </div>
                                                            -->
							</div><!-- /.dashboard -->
							
						</div><!-- /.tab-pane -->
						
                                                <div role="tabpanel" class="tab-pane <?php if($active_tab=="active_employee"){?>active<?php }?>" id="clientEmployee">
							
							<div class="dashboard">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    List of Employees
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-default navbar-btn btn-sm addClientButton" type="button" data-target="#modal_newEmployee" data-toggle="modal"><span class="fui-plus"></span> 
                                                                            Add Employee
                                                                    </button>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <?php //print_r($employees);?>
                                                                <ul class="paneOneList invoiceList" id="invoiceList">
                                                                    <?php 
                                                                    if($employees){
                                                                    foreach($employees as $employee){?>
                                                                    <li class="all due" data-year="any">
									<a href="#">
										<span class="clearfix">
                                                                                    <span class=" pull-left"><?php echo "#$employee->id - $employee->first_name $employee->last_name - $employee->email ";?></span>
										</span>
										
									</a>
                                                                    </li>
                                                                    <?php } 
                                                                    }else{ ?>
                                                                      <li class="all due" data-year="any">
									<a href="#">
										<span class="clearfix">
                                                                                    <span class=" pull-left">No Employees found</span>
										</span>
										
									</a>
                                                                    </li>  
                                                                  <?php }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                            <!--
                                                            <div class="form-group">
								<div class="col-sm-9 col-sm-offset-3 clientDetailsButtons">
									<button type="submit" class="btn btn-primary btn-embossed btn-wide"><span class="fui-check"></span> <?php echo $this->lang->line('update_details');?></button>
									<span style="padding: 0px 30px" class="hidden-md hidden-sm hidden-xs">or</span>
									<a href="<?php echo site_url('users/delete/'.$theUser->id)?>" class="btn btn-danger btn-embossed btn-wide" id="button_deleteClient"><span class="fui-cross"></span> Delete User</a>
								</div>
                                                            </div>
                                                            -->
							</div><!-- /.dashboard -->
							
						</div><!-- /.tab-pane -->
						
				  	</div><!-- /.tab-content -->
					
					</form>

				</div><!-- /.tab-panel -->
				
				<?php else:?>
				
				
				
				<?php endif;?>
			
			</div><!-- /.col -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->
	
	</section>

	<?php $this->load->view('shared/modal_account');?>
	
	<?php $this->load->view('shared/modal_apikey');?>
		
	<?php $this->load->view('shared/modal_newemployee');?>

    <?php $this->load->view('shared/shared_javascript');?>
	
	<script src="<?php echo base_url('js/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('js/dataTables.bootstrap.js');?>"></script>
	<script src="<?php echo base_url('js/dataTables.responsive.min.js');?>"></script>
	<script src="<?php echo base_url('js/jquery.fastLiveFilter.js');?>"></script>
	<script>
	
	<?php if( isset($theClient) && $theClient ):?>
	
	var ctable = $('#table_clientPayments').dataTable({
		"footerCallback": function ( row, data, start, end, display ) {
		
			var api = this.api(), data;
			
			// Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
			
			// Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
                <?php if( $settings[0]->currency_placement == 'before' ):?>
				$( api.column( 3 ).footer() ).html('<?php echo $theClient->currency_sign;?>'+pageTotal.toFixed(2) +' ( <?php echo $theClient->currency_sign;?>'+ total.toFixed(2) +' total)');
                <?php elseif( $settings[0]->currency_placement == 'after' ):?>
                $( api.column( 3 ).footer() ).html(pageTotal.toFixed(2) +'<?php echo $theClient->currency_sign;?> ( '+ total.toFixed(2) +'<?php echo $theClient->currency_sign;?> total)');
                <?php endif;?>
			
		}
	});
	
	<?php endif;?>
	
	$('#field_filterClients').fastLiveFilter('#clientList');
	
	</script>
	<script src="<?php echo base_url('js/Chart.min.js');?>"></script>
	<script>
	
	
	
	</script>
  </body>
</html>
	