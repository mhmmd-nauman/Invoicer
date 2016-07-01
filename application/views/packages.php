<?php $this->load->view('shared/header');?>
	
	<section class="app">
	
	<div class="container">
		
		<div class="row">
						
			<div class="col-md-12">
				
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
				
				<form class="" action="<?php echo site_url('packages/update')?>" method="post">
				
					<div class="settingPanel">
					
                                           <h5>Packages</h5>
					
                                            <?php if(empty($package_confirmation)){?>
                                            <div class="row">
                                                <div class="col-md-11">
                                                <?php //print_r($employees);?>
                                                <ul class="paneOneList invoiceList" id="invoiceList">
                                                    <?php 
                                                    if($packages){
                                                    foreach($packages as $package){?>
                                                    <li class="all due" data-year="any">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <a href="#">
                                                                        <span class="clearfix">
                                                                            <span class=" pull-left"><?php echo "#$package->id - $package->name - $package->price ";?></span> 
                                                                        </span>

                                                                </a>
                                                                    
                                                            </div>
                                                        <div class="col-md-1 ">
                                                            <input type="radio" name="package"  value="<?php echo $package->id;?>" <?php if( $user->package_id == $package->id)echo "checked"; ?> >
                                                        </div>
                                                        </div>
                                                    </li>
                                                    <?php } 
                                                    }else{ ?>
                                                      <li class="all due" data-year="any">
                                                        <a href="#">
                                                                <span class="clearfix">
                                                                    <span class=" pull-left">No Package found</span>
                                                                </span>

                                                        </a>
                                                    </li>  
                                                  <?php }
                                                    ?>
                                                </ul>
                                                </div>
                                            </div>					
						
										
					</div><!-- /.settingPanel -->
                                        <div class="settingPanel">
                                            <h5>Credit Card Information</h5>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="field_firstName" class="col-sm-3 control-label"><?php echo $this->lang->line('first_name_label');?> on Card: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="field_firstName" name="field_firstName" placeholder="<?php echo $this->lang->line('first_name_placeholder');?>" value="<?php echo $user->first_name;?>" required data-error="<?php echo $this->lang->line('first_name_error');?>">
                                                                    <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                           
                                                <div class="form-group">
                                                    <label for="field_lastName" class="col-sm-3 control-label"><?php echo $this->lang->line('last_name_label');?> on Card: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="field_lastName" name="field_lastName" placeholder="<?php echo $this->lang->line('last_name_placeholder');?>" value="<?php echo $user->last_name;?>" required data-error="<?php echo $this->lang->line('last_name_error');?>">
                                                                    <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="field_lastName" class="col-sm-3 control-label">Credit Card: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="field_lastName" name="field_CC" placeholder="Credit Card" value="" required data-error="">
                                                                    <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="field_lastName" class="col-sm-3 control-label">Expiry Year-Month: <span class="text-danger">*</span></label>
                                                    <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="field_lastName" name="field_expYearMonth" placeholder="XXXX-XX" value="" required data-error="">
                                                                    <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <?php } else{?>
                                        
                                        <h5>Package Confirmation</h5>
                                       
                                        Your new package details are: <?php echo $package_data->name ;?> - ($<?php echo $package_data->price ;?>) per month 
                                               <input type="hidden"  name="package_confirmation" value="1">
                                              
                                            <?php }    ?>
					<div class="settingPanel">
						
						<h5><?php echo $this->lang->line('heading_save_changes');?></h5>
						
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-wide"><span class="fui-check"></span> <?php echo $this->lang->line('button_save_changes');?></button>
						</div>
						
					</div><!-- /.settingPanel -->
				
				</form>
			
			</div><!-- /.col -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->
	
	</section>
	
	<!-- Modal -->
		
	<?php $this->load->view('shared/modal_account');?>
	
	<?php $this->load->view('shared/modal_apikey');?>
		
	<?php $this->load->view('shared/modal_newclient')?>
	
    <?php $this->load->view('shared/shared_javascript');?>
	
  </body>
</html>
<!-- ALTER TABLE `users` ADD `package_id` TINYINT(4) NULL DEFAULT '1' ; 
ALTER TABLE `packages` ADD `price` DECIMAL(5,2) NULL AFTER `description`;
-->
