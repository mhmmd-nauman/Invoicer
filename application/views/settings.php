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
				
				<form class="" action="<?php echo site_url('settings/update')?>" method="post">
				
					<div class="settingPanel">
					
						<h5><?php echo $this->lang->line('heading_invoice_counter');?></h5>
					
						<p>
							<?php echo $this->lang->line('text_invoice_counter');?>
						</p>
										
						<div class="form-group">
							<input type="text" id="spinner-01" name="setting_invoicecounter" value="<?php echo $settings[0]->invoice_nr_counter;?>" class="form-control spinner" style="width: 150px;">
						</div>
										
					</div><!-- /.settingPanel -->
                    
                    <div class="settingPanel">
					
						<h5><?php echo $this->lang->line('heading_currency_placement');?></h5>
					
						<p>
							<?php echo $this->lang->line('text_currency_placement');?>
						</p>
										
						<div class="form-group">
							<label class="radio">
                                <input type="radio" name="setting_currencyPlacement" value="before" data-toggle="radio" <?php if( $settings[0]->currency_placement == 'before' ):?>checked<?php endif;?>><?php echo $this->lang->line('label_before_amount');?>
                            </label>

                            <label class="radio">
                                <input type="radio" name="setting_currencyPlacement" value="after" data-toggle="radio" <?php if( $settings[0]->currency_placement == 'after' ):?>checked<?php endif;?>><?php echo $this->lang->line('label_after_amount');?>
                            </label>
						</div>
										
					</div><!-- /.settingPanel -->
					
					<div class="settingPanel">
					
						<h5><?php echo $this->lang->line('heading_payment_stripe');?></h5>
					
						<p>
							<?php echo $this->lang->line('text_payment_stripe');?>
						</p>
										
						<div class="form-group">
							<label><?php echo $this->lang->line('stripe_public_key');?></label>
							<input type="text" id="field_stripesecret" name="field_stripesecret" value="<?php echo $settings[0]->stripe_secret;?>" class="form-control spinner" />
						</div>
						
						<div class="form-group">
							<label><?php echo $this->lang->line('stripe_private_key');?></label>
							<input type="text" id="field_stripepublic" name="field_stripepublic" value="<?php echo $settings[0]->stripe_public;?>" class="form-control spinner" />
						</div>
										
					</div><!-- /.settingPanel -->
					
					<div class="settingPanel">
					
						<h5><?php echo $this->lang->line('heading_payment_paypal');?></h5>
					
						<p>
							<?php echo $this->lang->line('text_payment_paypal');?>
						</p>
										
						<div class="form-group">
							<label><?php echo $this->lang->line('paypal_email');?></label>
							<input type="text" id="field_paypalemail" name="field_paypalemail" value="<?php echo $settings[0]->paypal_email;?>" class="form-control spinner" />
						</div>
										
					</div><!-- /.settingPanel -->
					
					<div class="settingPanel">
					
						<h5><?php echo $this->lang->line('heading_api');?></h5>
					
						<p>
							<?php echo $this->lang->line('text_api');?>
						</p>
										
						<div class="form-group">
							<div class="bootstrap-switch-square">
							  <input type="checkbox" <?php if( $settings[0]->api == 1 ):?>checked<?php endif;?> data-toggle="switch" name="field_api" value="On" id="field_api" />
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
