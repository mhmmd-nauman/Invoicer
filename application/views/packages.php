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
