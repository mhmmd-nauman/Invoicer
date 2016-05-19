<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->lang->line('invoice');?> <?php echo $theInvoice->invoice_number;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo base_url('css/vendor/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Loading Flat UI Pro -->
    <link href="<?php echo base_url('css/flat-ui-pro.css');?>" rel="stylesheet">
	
	<link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/font-awesome.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/chosen.css');?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo base_url('img/favicon.png');?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="<?php echo base_url('js/vendor/html5shiv.js');?>"></script>
      	<script src="<?php echo base_url('js/vendor/respond.min.js');?>"></script>
    <![endif]-->
</head>

<body>
	
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
								
				<?php if( isset($theInvoice) ):?>
				<div id="theInvoice" class="invoice">
					
					<div class="ribbon-wrapper">
						<?php if( $theInvoice->invoice_status == 'due' ):?>
						<div class="ribbon due" id="statusRibbon"><?php echo $this->lang->line('due');?></div>
						<?php elseif( $theInvoice->invoice_status == 'paid' ):?>
						<div class="ribbon paid" id="statusRibbon"><?php echo $this->lang->line('paid');?></div>
						<?php elseif( $theInvoice->invoice_status == 'past due' ):?>
						<div class="ribbon past-due" id="statusRibbon"><?php echo $this->lang->line('past_due');?>
						</div>
						<?php endif;?>
					</div>
					
					<nav class="navbar navbar-default" role="navigation">
						
						<?php if( $theInvoice->invoice_status != 'paid' && ( $theInvoice->invoice_paymentbank == 1 || $theInvoice->invoice_paymentstripe == 1 || $theInvoice->invoice_paymentpaypal == 1 ) ):?>
						<button type="button" data-target="#modal_payment" data-toggle="modal" class="btn btn-primary navbar-btn btn-embossed" type="button"><span class="fui-credit-card"></span> <?php echo $this->lang->line('button_pay_invoice');?></button>
						<?php endif;?>
								
						<a href="<?php echo site_url('invoices/getPDF/'.$theInvoice->invoice_code);?>" class="btn btn-default navbar-btn btn-embossed" type="button"><span class="fui-export"></span> <?php echo $this->lang->line('button_download_pdf');?></a>
													
					</nav><!-- /navbar -->
										
					<div class="invoiceWrapper" id="invoiceWrapper">
											
						<table class="table invoiceTable">
							<tr>
								<td>
									<?php if( $theInvoice->company_logo != '' ):?>
									<img src="<?php echo base_url($theInvoice->company_logo)?>" style="width:150px">
									<?php else:?>
									<h1><?php echo $theInvoice->company_name;?></h1>
									<?php endif;?>
								</td>
								<td class="text-right">
									<b><?php echo $theInvoice->company_name;?></b><br>
									<?php echo nl2br($theInvoice->company_address);?>
									<div><?php echo nl2br($theInvoice->company_additionalinfo);?></div>
								</td>
							</tr>
							<tr>
								<td>
									<h2><?php echo $theInvoice->invoice_title;?></h2>
									<b><?php echo $this->lang->line('public_invoice_to');?>:</b><br>
									<b><?php echo $theInvoice->client_name;?></b><br>
									<div><?php echo nl2br($theInvoice->client_address);?></div>
									<div><?php echo nl2br( $theInvoice->client_additionalInfo );?></div>
								</td>
								<td class="text-right lead" style="padding-top: 40px">
									<?php echo $this->lang->line('public_invoice_number');?>: <b>#<?php echo $theInvoice->invoice_number;?></b><br>
									<div <?php if( $theInvoice->invoice_po == '' ):?>style="display:none"<?php endif;?>>PO: <b><?php echo $theInvoice->invoice_po;?></b></div>
									<b><?php echo date($this->config->item('date_format_php'), $theInvoice->invoice_date)?></b>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding-top: 20px; padding-bottom:20px">
									<div><?php echo $theInvoice->invoice_topnote;?></div>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding-left:0px; padding-right:0px">
									<table class="table table-striped itemsTable" id="itemsTable" style="margin-top: 30px">
										<thead>
										<?php echo $theInvoice->invoice_items_head;?>
										</thead>
										<tbody>
										<?php echo $theInvoice->invoice_items_body;?>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td></td>
								<?php

									$subtotal = $theInvoice->invoice_subtotal;
			
									$discountAmount = ($theInvoice->invoice_subtotal/100)*$theInvoice->invoice_discount;
									$discountAmount_ = $discountAmount;
									$discountAmount = number_format($discountAmount, 2);
			
									$taxAmount = (($subtotal - $discountAmount_)/100)*$theInvoice->invoice_taxamount;
									$taxAmount_ = $taxAmount;
									$taxAmount = number_format($taxAmount, 2);
									
									$total = $subtotal - $discountAmount_ + $taxAmount_;
									$total = number_format($total, 2);

								?>
								<td style="width: 50%; padding-right:0px">
									<table class="table table-striped totalsTable">
										<tbody>
											<tr>
												<td>
													<?php echo $this->lang->line('public_invoice_subtotal');?>:
												</td>
												<td>
													<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    <?php echo $subtotal;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
												</td>
											</tr>
											<tr <?php if( $theInvoice->invoice_discount == 0 ):?>style="display: none"<?php endif;?> id="row_invoiceDiscount">
												<td>
													<?php echo $this->lang->line('public_invoice_discount');?> (<?php echo $theInvoice->invoice_discount;?>%):
												</td>
												<td>
													-(
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    <?php echo $discountAmount;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    )
												</td>
											</tr>
											<tr <?php if( $theInvoice->invoice_taxamount == 0 ):?>style="display:none"<?php endif;?> id="row_invoiceTax">
												<td>
													<?php echo $this->lang->line('public_invoice_tax');?> (<?php echo $theInvoice->invoice_taxtype;?>, <?php echo $theInvoice->invoice_taxamount;?>%):
												</td>
												<td>
													+(
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    <?php echo $taxAmount;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    )
												</td>
											</tr>
											<tr>
												<td>
													<?php echo $this->lang->line('public_invoice_total_amount');?>:
												</td>
												<td>
													<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    <?php echo $total;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
												</td>
											</tr>
											<tr>
												<td>
													<?php echo $this->lang->line('public_invoice_paid_to_date');?>:
												</td>
												<td>
													<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    <?php echo $theInvoice->invoice_paidtodate;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td>
													<b><?php echo $this->lang->line('public_invoice_balance');?> (<?php echo $theInvoice->currency_shortname;?>):</b>
												</td>
												<td style="width: 140px">
													<b>
                                                        <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                        <?php echo number_format($theInvoice->invoice_balance, 2);?>
                                                        <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                                                    </b>
												</td>
											</tr>
										</tfoot>
									</table>
								</td>
							</tr>
							<tr>
								<td></td>
								<td style="width: 50%; padding-top: 25px; padding-right: 0px; text-align: right"><?php echo $this->lang->line('public_invoice_due_before');?>: <b class="edit" data-bind="invoice_duedate"><?php echo date($this->config->item('date_format_php'), $theInvoice->invoice_duedate);?></b></td>
							</tr>
							<tr>
								<td colspan="2">
									<div><?php echo $theInvoice->invoice_bottomnote;?></div>
								</td>
							</tr>
						</table>
					
					</div>
					
				</div><!-- /.invoiceWrapper -->
				<?php endif;?>
			
			</div><!-- /.col -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->
	
	<div class="modal fade" id="modal_payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
	   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-credit-card"></span> <?php echo $this->lang->line('pay_invoice');?></h4>
	      	  	</div>
					      	  	
				<div class="modal-body">
					
					<table class="table table-striped totalsTable">
						<tbody>
							<tr>
								<td>
									<?php echo $this->lang->line('public_invoice_subtotal');?>:
								</td>
								<td>
									<?php echo $theInvoice->currency_sign;?><?php echo $subtotal;?>
								</td>
							</tr>
							<tr <?php if( $theInvoice->invoice_discount == 0 ):?>style="display: none"<?php endif;?> id="row_invoiceDiscount">
								<td>
									<?php echo $this->lang->line('public_invoice_discount');?> (<?php echo $theInvoice->invoice_discount;?>%):
								</td>
								<td>
									-(<?php echo $theInvoice->currency_sign;?><?php echo $discountAmount;?>)
								</td>
							</tr>
							<tr <?php if( $theInvoice->invoice_taxamount == 0 ):?>style="display:none"<?php endif;?> id="row_invoiceTax">
								<td>
									<?php echo $this->lang->line('public_invoice_tax');?> (<?php echo $theInvoice->invoice_taxtype;?>, <?php echo $theInvoice->invoice_taxamount;?>%):
								</td>
								<td>
									+(<?php echo $theInvoice->currency_sign;?><?php echo $taxAmount;?>)
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('public_invoice_total_amount');?>:
								</td>
								<td>
									<?php echo $theInvoice->currency_sign;?><?php echo $total;?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo $this->lang->line('public_invoice_paid_to_date');?>:
								</td>
								<td>
									<?php echo $theInvoice->currency_sign;?><?php echo $theInvoice->invoice_paidtodate;?>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td>
									<b><?php echo $this->lang->line('public_invoice_balance');?> (<?php echo $theInvoice->currency_shortname;?>):</b>
								</td>
								<td style="width: 140px">
									<b><?php echo $theInvoice->currency_sign;?><?php echo number_format($theInvoice->invoice_balance, 2);?></b>
								</td>
							</tr>
						</tfoot>
					</table>
					
					<div id="paymentTabs">
					
						<ul class="nav nav-tabs nav-append-content">
							<?php if( $theInvoice->invoice_paymentbank == 1 ):?><li><a href="#bankTransfer"><i class="fa fa-university"></i> <?php echo $this->lang->line('tab_bank_transfer');?></a></li><?php endif;?>
					  		<?php if( $theInvoice->invoice_paymentstripe == 1 ):?><li><a href="#creditCard"><i class="fa fa-credit-card"></i> <?php echo $this->lang->line('tab_credit_card');?></a></li><?php endif;?>
					  		<?php if( $theInvoice->invoice_paymentpaypal == 1 ):?><li><a href="#paypal"><i class="fa fa-paypal"></i> <?php echo $this->lang->line('tab_paypal');?></a></li><?php endif;?>
							</ul>

						<!-- Tab content -->
						<div class="tab-content">
						
							<?php if( $theInvoice->invoice_paymentbank == 1 ):?>
							<div class="tab-pane" id="bankTransfer">
					    	
							<form data-toggle="validator" method="post" action="<?php echo site_url('invoice/addPayment');?>" enctype="multipart/form-data">
								<input type="hidden" name="invoiced_hash" value="<?php echo $hash;?>">
								<input type="hidden" name="invoiceID" value="<?php echo $theInvoice->invoice_id;?>">
								<input type="hidden" name="invoiceCode" value="<?php echo $theInvoice->invoice_code;?>">
								<div class="form-group">
									<label class="control-label" for="field_paymentAmount"><?php echo $this->lang->line('payment_amount_label');?></label>
								    <input type="number" data-type="number" class="form-control" id="field_paymentAmount" name="field_paymentAmount" placeholder="Payment amount" required step="any" data-error="<?php echo $this->lang->line('payment_amount_error');?>" value="<?php echo $theInvoice->invoice_balance;?>">
									<div class="help-block with-errors"></div>
								</div>
								<div class="alert alert-warning">
									<button class="close fui-cross" data-dismiss="alert"></button>
								  	<p><?php echo $this->lang->line('upload_slip_message');?></p>
								</div>
								<div class="form-group">
									<div class="fileinput fileinput-new" data-provides="fileinput">
								    	<div class="input-group">
								      	  	<div class="form-control uneditable-input" data-trigger="fileinput">
								        		<span class="fui-clip fileinput-exists"></span>
								        		<span class="fileinput-filename"></span>
								      	  	</div>
								      	  	<span class="input-group-btn btn-file">
								        		<span class="btn btn-default fileinput-new" data-role="select-file"><?php echo $this->lang->line('upload_select_file');?></span>
								        		<span class="btn btn-default fileinput-exists" data-role="change"><span class="fui-gear"></span> <?php echo $this->lang->line('upload_change');?></span>
								        		<input type="file" name="field_file" required data-error="Please upload a proof of transfer">
								        		<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span> <?php echo $this->lang->line('upload_remove');?></a>
								      	  	</span>
								    	</div>
								  	</div>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-embossed btn-block"><span class="fui-check"></span> <?php echo $this->lang->line('button_submit_payment');?></button>
								</div>
							</form>
							
					  	</div><!-- /.tab-pane -->
							<?php endif;?>
					  	
							<?php if( $theInvoice->invoice_paymentstripe == 1 ):?>
							<div class="tab-pane" id="creditCard">
							
							<div class="alerts"></div>
														
						  	<h4><?php echo $this->lang->line('credit_card_heading');?></h4>
						  	<?php echo $this->lang->line('credit_card_message');?>
							
							<div class="form-group">
								<a href="" class="btn btn-primary btn-embossed btn-block" id="btn_stripe"><i class="fa fa-credit-card"></i> <span class="buttonText"><?php echo $this->lang->line('button_pay_with_cc');?></span></a>
							</div>
														
					  	</div><!-- /.tab-pane -->
							<?php endif;?>
					  	
							<?php if( $theInvoice->invoice_paymentpaypal == 1 ):?>
							<div class="tab-pane" id="paypal">
							
							<h4><?php echo $this->lang->line('paypal_heading');?></h4>
							<?php echo $this->lang->line('paypal_message');?>
							
							<div class="form-group">
								<a href="<?php if( $theInvoice->paypal_email != '' ) {echo site_url('invoices/pay/'.$theInvoice->invoice_code);}else{echo '#';}?>" class="btn btn-primary btn-embossed btn-block <?php if( $theInvoice->paypal_email == '' ):?>disabled<?php endif;?>"><i class="fa fa-paypal"></i> Pay with Paypal</a>
							</div>
							
					  	</div><!-- /.tab-pane -->
							<?php endif;?>
						
						</div><!-- /.tab-content -->
					
					</div><!-- /#paymentTabs -->
					
	      	  	</div><!-- /.modal-body -->
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	      	  	</div>
					    	
			</div><!-- /.modal-content -->
	  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->
	
	<?php $this->load->view('shared/shared_javascript');?>
	
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script>
	
		$(function(){
			
			$('#paymentTabs .nav-tabs li:first').addClass('active');
			$('#paymentTabs .tab-content .tab-pane:first').addClass('active');
			
		})
		
		var handler = StripeCheckout.configure({
	    	key: '<?php echo $theInvoice->stripe_public;?>',
			image: '<?php if( $theInvoice->company_logo != '' ){ echo base_url($theInvoice->company_logo);} else {echo base_url("/img/favicon.png");}?>',
	    	token: function(token) {
				
				$data = token;
				
				$.ajax({
					url: '<?php echo site_url("invoices/stripeProcess/".$theInvoice->invoice_code)?>',
					method: 'post',
					data: $data,
					dataType: 'json'
				}).done(function(ret){
					
					$('#creditCard .alerts').append( $(ret.content) )
					
					if( ret.status != 'paid' ) {
						
						$('#btn_stripe').removeClass('disabled').find('.buttonText').text('<?php echo $this->lang->line('button_pay_with_cc');?>');
						
					} else {
						
						$('#btn_stripe').find('.buttonText').text('<?php echo $this->lang->line('button_pay_with_cc');?>');
						
					}
					
				});
				
	    	}
	  });

	  $('#btn_stripe').on('click', function(e) {
		  
		  $('#btn_stripe').addClass('disabled').find('.buttonText').text('<?php echo $this->lang->line('verifying_payment');?>');
	  	
		  // Open Checkout with further options
		  handler.open({
			  name: '<?php echo $theInvoice->company_name;?>',
			  description: 'Payment for invoice <?php echo $theInvoice->invoice_number;?>',
			  currency: "<?php echo $theInvoice->currency_shortname;?>",
			  amount: <?php echo $theInvoice->invoice_balance*100;?>	
		  });
		
		  e.preventDefault();
		
	  });

	  // Close Checkout on page navigation
	  $(window).on('popstate', function() {
		  handler.close();
	  });
	  
	</script>
	
</body>