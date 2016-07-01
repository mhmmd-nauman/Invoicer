<?php $this->load->view('shared/header');?>
	
	<div class="leftBar2">
		
		<div class="filterPanel" id="filterPanel">
			<?php if(isset($invoices)):?>
			
				<?php
			
				$years = array();
			
				foreach( $invoices as $invoice ) {
				
					$year = date('Y', $invoice->invoice_date);
				
					array_push($years, $year);
				
				}
			
				$years = array_unique($years);
				sort($years, SORT_STRING);
				$years = array_values($years);
									
				?>
		
				<?php if( count($years) > 1 || $years[0] != date('Y') ):?>
		
				<div class="filters yearFilter">
				<!-- Inverted skin  -->
				<div class="btn-group" style="width: 100%">
			 		<button class="btn btn-default dropdown-toggle btn-block btn-sm" type="button" data-toggle="dropdown" id="dropdown_years">
			    		<span class="dropdownText"><?php echo $this->lang->line('invoices_for');?> <b><?php echo date('Y');?></b></span> <span class="caret"></span>
			  		</button>
			  		<ul class="dropdown-menu dropdown-menu-inverse" role="menu">
						<?php foreach($years as $year):?>
							<li><a href="#" data-filter="<?php echo $year?>"><?php echo $year?></a></li>
						<?php endforeach?>
			  		</ul>
				</div>
			</div>
		
			<?php endif;?>
		
			<?php endif;?>
		
			<div class="filters clientFilter">
				<!-- Inverted skin  -->
				<div class="btn-group" style="width: 100%">
			 		<button class="btn btn-default dropdown-toggle btn-block btn-sm" type="button" data-toggle="dropdown" id="dropdown_clients">
			    		<span class="dropdownText"><?php echo $this->lang->line('all_clients');?></span> <span class="caret"></span>
			  		</button>
			  		<ul class="dropdown-menu dropdown-menu-inverse" role="menu">
						<li><a href="#" data-filter="all"><?php echo $this->lang->line('all_clients');?></a></li>
						<?php foreach( $clients as $client ):?>
							<li><a href="#" data-filter="<?php echo $client->client_id;?>"><?php echo $client->client_name;?></a></li>
						<?php endforeach;?>
			  		</ul>
				</div>
			</div>
			
			<div class="filters" id="filters">
				<!--<span class="small"><?php echo $this->lang->line('filter_by_type');?>: &nbsp;</span><br>-->
				<button type="button" class="btn btn-primary btn-xs" data-filter="paid" id="filter_paid"><?php echo $this->lang->line('paid');?></button>
				<button type="button" class="btn btn-info btn-xs active" data-filter="due" id="filter_due"><?php echo $this->lang->line('due');?></button>
				<button type="button" class="btn btn-danger btn-xs active" data-filter="past-due" id="filter_pastDue"><?php echo $this->lang->line('past_due');?></button>
				<button type="button" class="btn btn-inverse btn-xs" id="filter_all"><?php echo $this->lang->line('all');?></button>
			</div>
		
		</div>
		
		<div class="filters">
			<a href="#" class="btn btn-inverse btn-block btn-sm" id="button_toggleFilterPanel" data-textmain="<?php echo $this->lang->line('show_filter_panel');?>" data-textalt="<?php echo $this->lang->line('hide_filter_panel');?>"><?php echo $this->lang->line('show_filter_panel');?></a>
		</div>	
						
		<ul class="paneOneList invoiceList" id="invoiceList">
			
			<?php
				
			if( !isset($theInvoice) ) {
				$theInvoiceID = 0;
			} else {
				$theInvoiceID = $theInvoice->invoice_id;
			}
				
			?>
			
			<?php if( $invoices ):?>
			<?php foreach( $invoices as $invoice ):?>
			<li class="<?php echo str_replace(" ", "-", $invoice->invoice_status);?> <?php echo $invoice->client_id;?> all <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>active<?php endif;?>" id="invoiceLi_<?php echo $invoice->invoice_number;?>" <?php if( $invoice->invoice_status == 'paid' && $invoice->invoice_id != $theInvoiceID ):?>style="display: none"<?php endif;?> data-year="<?php echo date('Y', $invoice->invoice_date);?>">
				<a href="<?php echo site_url('invoices/'.$invoice->invoice_id)?>">
					<span class="clearfix">
						<span class="invoiceAmount pull-right">
                            <?php if( $settings[0]->currency_placement == 'before' ):?>
                            <span <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_currenySymbol"<?php endif;?>>
                                <?php echo $invoice->currency_sign;?>
                            </span>
                            <span <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_total"<?php endif;?>>
                                <?php echo number_format($invoice->invoice_balance+$invoice->invoice_paidtodate, 2);?>
                            </span>
                            <?php elseif( $settings[0]->currency_placement == 'after' ):?>
                            <span <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_total"<?php endif;?>>
                                <?php echo number_format($invoice->invoice_balance+$invoice->invoice_paidtodate, 2);?>
                            </span>
                            <span <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_currenySymbol"<?php endif;?>>
                                <?php echo $invoice->currency_sign;?>
                            </span>
                            <?php endif;?>
                        </span>
						<span class="invoiceNumber pull-left">#<span <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_id"<?php endif;?>><?php echo $invoice->invoice_number;?></span><?php if( $invoice->invoice_autogenerated == 1 ):?>*<?php endif;?> </span> 
						<?php if( $invoice->invoice_status == 'due' ):?>
						<span class="label label-info"><?php echo $this->lang->line('due');?></span>
						<?php elseif( $invoice->invoice_status == 'paid' ):?>
						<span class="label label-primary"><?php echo $this->lang->line('paid');?></span>
						<?php elseif( $invoice->invoice_status == 'past due' ):?>
						<span class="label label-danger"><?php echo $this->lang->line('past_due');?></span>
						<?php endif;?>
					</span>
					<span class="clearfix">
						<span class="invoiceName pull-left" <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_clientName"<?php endif;?>><?php echo $invoice->client_name;?></span>
						<span class="invoiceDate pull-right text-right" <?php if( isset($theInvoice) && $theInvoice->invoice_id == $invoice->invoice_id ):?>data-bind="invoice_issueDate"<?php endif;?>><?php echo date($this->config->item('date_format_php'), $invoice->invoice_date);?></span>
					</span>
				</a>
			</li>
			<?php endforeach;?>
			<?php else:?>
			<div class="alert alert-info" style="margin: 20px">
				<button class="close fui-cross" data-dismiss="alert"></button>
				<h4><?php echo $this->lang->line('no_invoices_heading');?></h4>
				<p>
					<?php echo $this->lang->line('no_invoices_message');?>
				</p>
			</div>
			<?php endif;?>
		</ul>
		
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
								
				<?php if( isset($theInvoice) ):?>
				<div id="theInvoice" class="invoice">
					
					<div class="ribbon-wrapper">
						<?php if( $theInvoice->invoice_status == 'due' ):?>
						<div class="ribbon due" id="statusRibbon"><?php echo $this->lang->line('due');?></div>
						<?php elseif( $theInvoice->invoice_status == 'paid' ):?>
						<div class="ribbon paid" id="statusRibbon"><?php echo $this->lang->line('paid');?></div>
						<?php elseif( $theInvoice->invoice_status == 'past due' ):?>
						<div class="ribbon past-due" id="statusRibbon"><?php echo $this->lang->line('past_due');?></div>
						<?php endif;?>
					</div>
					
					<nav class="navbar navbar-default" role="navigation">
												
						<button data-target="collapse_editInvoice" class="btn btn-default navbar-btn btn-sm btn-embossed invoiceSlidePanel" type="button"><span class="fui-new"></span> <?php echo $this->lang->line('edit_invoice');?></button>
						
						<button data-target="collapse_payments" class="btn btn-default navbar-btn btn-sm  btn-embossed invoiceSlidePanel" type="button"><span class="fui-credit-card"></span> <?php echo $this->lang->line('payments');?></button>
					  	
						<a href="#modal_sendByEmail" data-toggle="modal" class="btn btn-default navbar-btn btn-sm  btn-embossed invoiceSlidePanel" type="button"><span class="fui-mail"></span> <?php echo $this->lang->line('send_to_client');?></a>
						
						<a href="<?php echo site_url('invoices/getPDF/'.$theInvoice->invoice_id)."/true";?>" class="btn btn-default navbar-btn btn-sm btn-embossed invoiceSlidePanel" type="button"><span class="fui-export"></span> <?php echo $this->lang->line('download_pdf');?></a>
						
						<button data-target="#modal_deleteInvoice" data-toggle="modal" class="btn btn-danger navbar-btn btn-sm btn-embossed" type="button" data-invoice-id="<?php echo $theInvoice->invoice_id;?>" id="button_deleteInvoice"><span class="fui-trash"></span> <?php echo $this->lang->line('delete_invoice');?></button>
						
						<button class="btn btn-primary navbar-btn btn-sm btn-embossed disabled" type="button" id="button_saveInvoice" data-invoiceid="<?php echo $theInvoice->invoice_id;?>" data-textsave="<?php echo $this->lang->line('save_invoice');?>" data-textnochanges="<?php echo $this->lang->line('no_changes_to_save');?>" data-textsaving="<?php echo $this->lang->line('saving_invoice');?>"><span class="fui-check"></span> <span class="buttonText"><?php echo $this->lang->line('no_changes_to_save');?></span></button>
	
					</nav><!-- /navbar -->
					
					<div class="invoiceEditWrapper" id="invoiceEditWrapper">
						
						<div class="invoicePanel" id="collapse_editInvoice">
							
							<div role="tabpanel">

								<!-- Nav tabs -->
							  	<ul class="nav nav-tabs nav-append-content" role="tablist">
							    	<li role="presentation" class="active"><a href="#edit_invoiceDetails" aria-controls="edit_invoiceDetails" role="tab" data-toggle="tab"><?php echo $this->lang->line('invoice_details');?></a></li>
							    	<li role="presentation"><a href="#edit_payment" aria-controls="edit_payment" role="tab" data-toggle="tab"><?php echo $this->lang->line('financial');?></a></li>
									<li role="presentation"><a href="#edit_tax" aria-controls="edit_tax" role="tab" data-toggle="tab"><?php echo $this->lang->line('tax');?></a></li>
									<li role="presentation"><a href="#edit_notes" aria-controls="edit_notes" role="tab" data-toggle="tab"><?php echo $this->lang->line('notes');?></a></li>
							  	</ul>

							  	<!-- Tab panes -->
							  	<div class="tab-content">
									
							    	<div role="tabpanel" class="tab-pane active" id="edit_invoiceDetails">
							    		
										<form class="form-horizontal" data-toggle="validator">
											
											<div class="form-group">
											    <label for="field_invoiceTitle" class="col-sm-3 control-label"><?php echo $this->lang->line('invoice_title');?>:</label>
											    <div class="col-sm-9">
											    	<input type="text" class="form-control" id="field_invoiceTitle" name="field_invoiceTitle" placeholder="<?php echo $this->lang->line('invoice_title');?>" value="" data-bind="invoice_title">
											    </div>
											</div>
											
											<div class="form-group">
										    	<label for="field_client" class="col-sm-3 control-label"><?php echo $this->lang->line('client');?>: <span class="text-danger">*</span></label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_client" id="field_client" data-bind="invoice_client">
														<?php foreach( $clients as $client ):?>
														<option value="<?php echo $client->client_id;?>" <?php if( $theInvoice->client_id == $client->client_id ):?>selected<?php endif;?>><?php echo $client->client_name;?></option>
														<?php endforeach;?>
													</select>
													<div class="help-block with-errors"></div>
										    	</div>
										  	</div>
										  	
											<div class="form-group">
											    <label for="field_invoiceNumber" class="col-sm-3 control-label"><?php echo $this->lang->line('invoice_number');?>: <span class="text-danger">*</span></label>
											    <div class="col-sm-9">
											    	<input type="number" class="form-control" id="field_invoiceNumber" name="field_invoiceNumber" placeholder="<?php echo $this->lang->line('invoice_number');?>" value="" data-bind="invoice_id" required step="1" data-error="<?php echo $this->lang->line('invoice_number_error');?>">
													<div class="help-block with-errors"></div>
											    </div>
											</div>
											
											<div class="form-group">
											    <label for="field_ponumber" class="col-sm-3 control-label"><?php echo $this->lang->line('po_number');?>:</label>
											    <div class="col-sm-9">
											    	<input type="text" class="form-control" id="field_ponumber" name="field_ponumber" placeholder="<?php echo $this->lang->line('po_number');?>" value="" data-bind="invoice_po">
											    </div>
											</div>
																																
											<div class="form-group">
											    <label for="field_issueDate" class="col-sm-3 control-label"><?php echo $this->lang->line('issue_date');?>: <span class="text-danger">*</span></label>
											    <div class="col-sm-9">
													<div class="input-group">
													    <span class="input-group-btn">
													      <button class="btn" type="button"><span class="fui-calendar"></span></button>
													    </span>
													    <input type="text" class="form-control datePicker" name="field_issueDate" id="field_issueDate" value="" data-bind="invoice_issueDate" data-function="checkDue" required data-error="<?php echo $this->lang->line('issue_date_error');?>">
													</div>
													<div class="help-block with-errors"></div>
											    </div>
											</div>
											
											<div class="form-group">
										    	<label for="field_visible" class="col-sm-3 control-label"><?php echo $this->lang->line('visible_to_client');?>:</label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_visible" id="field_visible" data-bind="invoice_public">
														<option value="1"><?php echo $this->lang->line('yes');?></option>
													    <option value="0"><?php echo $this->lang->line('no');?></option>
													</select>
										    	</div>
										  	</div>
											
											<div class="form-group" <?php if( $theInvoice->invoice_public == 0 ):?>style="display:none"<?php endif;?> >
										    	<label class="col-sm-3 control-label"><?php echo $this->lang->line('public_url');?>:</label>
										    	<div class="col-sm-9">
													<input type="text" class="form-control" value="<?php echo site_url('invoice/'.$theInvoice->invoice_code);?>">
												</div>
										  	</div>
											
											<div class="form-group">
										    	<label for="field_recurring" class="col-sm-3 control-label"><?php echo $this->lang->line('recurring_invoice');?>?:</label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_recurring" id="field_recurring" data-bind="invoice_recurring">
														<option value="0"><?php echo $this->lang->line('no');?></option>
													    <option value="1"><?php echo $this->lang->line('recurring_1_month');?></option>
														<option value="3"><?php echo $this->lang->line('recurring_3_months');?></option>
														<option value="6"><?php echo $this->lang->line('recurring_6_months');?></option>
														<option value="12"><?php echo $this->lang->line('recurring_1_year');?></option>
													</select>
										    	</div>
										  	</div>
										  	
										</form>
										
							    	</div><!-- /.tab-pane -->
																		
							    	<div role="tabpanel" class="tab-pane" id="edit_payment">
							    		
										<form class="form-horizontal">
											
											<div class="form-group">
											    <label for="field_dueDate" class="col-sm-3 control-label"><?php echo $this->lang->line('due_date');?>: <span class="text-danger">*</span></label>
											    <div class="col-sm-9">
													<div class="input-group">
													    <span class="input-group-btn">
													      <button class="btn" type="button"><span class="fui-calendar"></span></button>
													    </span>
													    <input type="text" class="form-control datePicker" name="field_dueDate" id="field_dueDate" value="" data-bind="invoice_duedate">
													</div>
													<div class="help-block with-errors"></div>
											    </div>
											</div>
											
											<div class="form-group">
										    	<label for="field_paid" class="col-sm-3 control-label"><?php echo $this->lang->line('paid?');?>:</label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_paid" id="field_paid" data-bind="invoice_paid" data-function="checkDue">
														<option value="No"><?php echo $this->lang->line('no');?></option>
													    <option value="Yes"><?php echo $this->lang->line('yes');?></option>
													</select>
										    	</div>
										  	</div>
											
											<div class="form-group">
										    	<label for="field_currency" class="col-sm-3 control-label"><?php echo $this->lang->line('currency');?>: <span class="text-danger">*</span></label>
										    	<div class="col-sm-9">
													<select class="form-control regular chosen" name="field_currency" id="field_currency" data-bind="invoice_currenyName">
														<?php foreach( $currencies as $currency ):?>
														<option value="<?php echo $currency->currency_shortname?>" <?php if( $currency->currency_shortname == $theInvoice->currency_shortname ):?>selected<?php endif;?>><?php echo $currency->currency_shortname?> - <?php echo $currency->currency_sign;?> (<?php echo $currency->currency_fullname;?>)</option>
														<?php endforeach;?>
													</select>
													<div class="help-block with-errors"></div>
										    	</div>
										  	</div>
											
											<div class="form-group">
											    <label for="field_discount" class="col-sm-3 control-label"><?php echo $this->lang->line('discount_in_perc');?>:</label>
											    <div class="col-sm-9">
											    	<input type="number" class="form-control" id="field_discount" name="field_discount" placeholder="<?php echo $this->lang->line('discount_in_perc');?>" data-bind="invoice_discountPercentage" data-function="updateInvoiceAmounts" data-type="number">
											    </div>
											</div>
											
											<div class="form-group">
										    	<label for="field_payment" class="col-sm-3 control-label"><?php echo $this->lang->line('allow_bank_payment');?>:</label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_bank" id="field_bank" data-bind="invoice_paymentbank">
														<option value="0"><?php echo $this->lang->line('no');?></option>
														<option value="1"><?php echo $this->lang->line('yes');?></option>
													</select>
										    	</div>
										  	</div>
											
											<?php if( $settings[0]->stripe_public != '' && $settings[0]->stripe_secret != '' ):?>
											<div class="form-group">
										    	<label for="field_payment" class="col-sm-3 control-label"><?php echo $this->lang->line('allow_credit_card');?>:</label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_stripe" id="field_stripe" data-bind="invoice_paymentstripe">
														<option value="0"><?php echo $this->lang->line('no');?></option>
														<option value="1"><?php echo $this->lang->line('yes');?></option>
													</select>
										    	</div>
										  	</div>
											<?php endif;?>
											
											<?php if( $settings[0]->paypal_email != '' ):?>
											<div class="form-group">
										    	<label for="field_payment" class="col-sm-3 control-label"><?php echo $this->lang->line('allow_paypal');?>:</label>
										    	<div class="col-sm-9">
													<select class="form-control select select-default select-block mbl custom" name="field_paypal" id="field_paypal" data-bind="invoice_paymentpaypal">
														<option value="0"><?php echo $this->lang->line('no');?></option>
														<option value="1"><?php echo $this->lang->line('yes');?></option>
													</select>
										    	</div>
										  	</div>
											<?php endif;?>
										  
										</form>
										
							    	</div>
									
							    	<div role="tabpanel" class="tab-pane" id="edit_tax">
							    		
										<form class="form-horizontal">
																					  	
											<div class="form-group">
										    	<label for="field_taxtype" class="col-sm-3 control-label"><?php echo $this->lang->line('tax_type');?>:</label>
										    	<div class="col-sm-9">
													<input type="text" class="form-control" name="field_taxtype" id="field_taxtype" placeholder="VAT, GST, etc" data-bind="invoice_taxType">
										    	</div>
										  	</div>
											
											<div class="form-group">
										    	<label for="field_percentage" class="col-sm-3 control-label"><?php echo $this->lang->line('tax_perc');?>:</label>
										    	<div class="col-sm-9">
													<input type="number" class="form-control" name="field_percentage" id="field_taxpercentage" placeholder="Percentage" data-bind="invoice_taxPercentage" data-function="updateInvoiceAmounts" data-type="number">
										    	</div>
										  	</div>
										
										</form>
										
							    	</div>
									
							    	<div role="tabpanel" class="tab-pane" id="edit_notes">
							    		
										<form class="form-horizontal">
																					  	
											<div class="form-group">
										    	<label for="field_topnote" class="col-sm-3 control-label"><?php echo $this->lang->line('top_note');?>:</label>
										    	<div class="col-sm-9">
													<textarea class="form-control" id="field_topnote" name="field_topnote" placeholder="<?php echo $this->lang->line('top_note_placeholder');?>" data-bind="invoice_topNote"></textarea>
										    	</div>
										  	</div>
											
											<div class="form-group">
										    	<label for="field_bottomnote" class="col-sm-3 control-label"><?php echo $this->lang->line('bottom_note');?>:</label>
										    	<div class="col-sm-9">
													<textarea class="form-control" id="field_bottomnote" name="field_bottomnote" placeholder="<?php echo $this->lang->line('bottom_note_placeholder');?>" data-bind="invoice_bottomNote"></textarea>
										    	</div>
										  	</div>
											
											<div class="form-group">
										    	<label for="field_bottomnote" class="col-sm-3 control-label"><?php echo $this->lang->line('internal_notes');?>:</label>
										    	<div class="col-sm-9">
													<textarea class="form-control" id="field_notes" name="field_notes" placeholder="<?php echo $this->lang->line('internal_notes_placeholder');?>" rows="5" data-bind="invoice_notes"></textarea>
										    	</div>
										  	</div>
										  
										</form>
										
							    	</div>

							  	</div><!-- /.tab-content -->

							</div><!-- /.tab-panel -->
							
						</div><!-- /.collapse -->
												
						<div class="invoicePanel" id="collapse_payments">
							
							<div class="tab-content">
							
								<?php if( !$payments ):?>
									<div class="alert alert-info">
							  			<button class="close fui-cross" data-dismiss="alert"></button>
							  			<h4><?php echo $this->lang->line('please_note');?></h4>
							  			<?php echo $this->lang->line('message_no_payments');?>
									</div>
								<?php endif;?>
							
								<table class="table table-bordered paymentsTable" id="table_payments">
									<thead>
										<tr>
											<th style="width: 20%"><?php echo $this->lang->line('date');?></th>
											<th style="width: 65%"><?php echo $this->lang->line('type');?></th>
											<th><?php echo $this->lang->line('amount');?> (<span data-bind="invoice_currenyName"><?php echo $theInvoice->currency_shortname;?></span>)</th>
										</tr>
									</thead>
									<tbody>
										<?php if( $payments ):?>
											<?php foreach( $payments as $payment ):?>
												<tr>
													<td data-property="date"><?php echo date($this->config->item('date_format_php'), $payment->payment_date);?></td>
													<td data-property="type" data-type-id="<?php echo $payment->payment_type_id;?>"><?php echo $payment->payment_type;?> <?php if( $payment->payment_requires_proof == 1 && $payment->payment_proof != '' ):?>(<a href="<?php echo base_url('uploads/'.$payment->payment_proof);?>" target="_blank"><?php echo $this->lang->line('payment_proof');?></a>)<?php endif;?></td>
													<td data-property="amount"><?php echo $payment->payment_amount;?></td>
												</tr>
											<?php endforeach;?>
										<?php endif;?>
									</tbody>
									<tfoot>
										<tr>
											<th class="text-right" colspan="2"><?php echo $this->lang->line('invoice_total_paid');?></th>
											<th><b id="paymentsTotal" data-bind="invoice_paidToDate"></b></th>
										</tr>
									</tfoot>
								</table>
							
								<div class="clearfix">
									<button type="button" class="btn btn-primary btn-sm btn-embossed btn-wide pull-right" id="button_addPayment"><span class="fui-plus"></span> <?php echo $this->lang->line('add_payment');?></button>
								</div>
							
							</div><!-- ./tab-content -->
							
						</div><!-- /.collapse -->
						
					</div><!-- /.invoiceEditWrapper -->
					
					<div class="invoiceWrapper table-responsive" id="invoiceWrapper">
											
						<table class="table invoiceTable" id="invoiceTable">
							<tr>
								<td>
									<?php if( $user->company_logo != '' ):?>
									<img src="<?php echo base_url($user->company_logo)?>" style="width:150px">
									<?php else:?>
									<h1><?php echo $user->company_name;?></h1>
									<?php endif;?>
								</td>
								<td class="text-right">
									<b><?php echo $user->company_name;?></b><br>
									<?php echo nl2br($user->company_address);?>
									<div><?php echo nl2br($user->company_additionalinfo);?></div>
								</td>
							</tr>
							<tr>
								<td>
									<h2><span data-bind="invoice_title"></span></h2>
									<b><?php echo $this->lang->line('invoice_to');?>:</b><br>
									<b data-bind="invoice_clientName"></b><br>
									<div data-bind="invoice_clientAddress"></div>
									<div><?php echo nl2br($theInvoice->client_additionalInfo);?></div>
								</td>
								<td class="text-right lead" style="padding-top: 40px">
									<?php echo $this->lang->line('invoice_number');?>: <b>#<span data-bind="invoice_id"></span></b><br>
									<div <?php if( $theInvoice->invoice_po == '' ):?>style="display:none"<?php endif;?> id="div_invoicePo"><?php echo $this->lang->line('invoice_po');?>: <b data-bind="invoice_po"></b></div>
									<b class="bind" data-bind="invoice_issueDate"></b>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding-top: 20px; padding-bottom:20px">
									<div data-bind="invoice_topNote"></div>
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
									
									<button type="button" id="button_editItemStructure" class="btn btn-xs btn-default btn-embossed pull-right"><i class="fa fa-table"></i> <?php echo $this->lang->line('edit_structure');?></button>
									<button type="button" data-target="#modal_importData" data-toggle="modal" class="btn btn-xs btn-primary btn-embossed pull-right" style="margin-right: 10px"><i class="fa fa-file-excel-o"></i> <?php echo $this->lang->line('import_data_csv');?></button>
									<button type="button" class="btn btn-xs btn-primary btn-embossed pull-right" style="margin-right: 10px" id="button_addInvoiceItem"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_single_item');?></button>
									
								</td>
							</tr>
							<tr>
								<td></td>
								<td style="width: 50%; padding-right:0px">
									<table class="table table-striped totalsTable">
										<tbody>
											<tr>
												<td>
													<?php echo $this->lang->line('invoice_subtotal');?>:
												</td>
												<td>

                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    <span data-bind="invoice_subTotal"></span>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
												</td>
											</tr>
											<tr <?php if( $theInvoice->invoice_discount == 0 ):?>style="display: none"<?php endif;?> id="row_invoiceDiscount">
												<td>
													<?php echo $this->lang->line('invoice_discount');?> (<span data-bind="invoice_discountPercentage"></span>%):
												</td>
												<td>
													-(
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    <span data-bind="invoice_discountAmount"></span>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    )
												</td>
											</tr>
											<tr <?php if( $theInvoice->invoice_taxamount == 0 ):?>style="display:none"<?php endif;?> id="row_invoiceTax">
												<td>
													<?php echo $this->lang->line('invoice_tax');?> (<span data-bind="invoice_taxType"></span>, <span data-bind="invoice_taxPercentage"></span>%):
												</td>
												<td>
													+(
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    <span data-bind="invoice_taxAmount"></span>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    )
												</td>
											</tr>
											<tr>
												<td>
													<?php echo $this->lang->line('invoice_total_amount');?>:
												</td>
												<td>
													<?php if( $settings[0]->currency_placement == 'before' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    <span data-bind="invoice_total"></span>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
												</td>
											</tr>
											<tr>
												<td>
													<?php echo $this->lang->line('invoice_paid_to_date');?>:
												</td>
												<td>
													<?php if( $settings[0]->currency_placement == 'before' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    <span data-bind="invoice_paidToDate">0</span>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td>
													<b><?php echo $this->lang->line('invoice_balance');?> (<span data-bind="invoice_currenyName"></span>):</b>
												</td>
												<td style="width: 140px">
													<b>
                                                        <?php if( $settings[0]->currency_placement == 'before' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                        <span data-bind="invoice_balanceDue"></span>
                                                        <?php if( $settings[0]->currency_placement == 'after' ):?><span data-bind="invoice_currenySymbol"></span><?php endif;?>
                                                    </b>
												</td>
											</tr>
										</tfoot>
									</table>
									<button type="button" class="btn btn-xs btn-default btn-embossed pull-right" id="button_refreshTotals"><i class="fa fa-refresh"></i> <?php echo $this->lang->line('refresh_totals');?></button>
								</td>
							</tr>
							<tr>
								<td></td>
								<td style="width: 50%; padding-top: 25px; padding-right: 0px; text-align: right"><?php echo $this->lang->line('invoice_payment_due_before');?>: <b class="edit" data-bind="invoice_duedate"><?php echo $this->lang->line('invoice_pyament_due_on_receipt');?></b></td>
							</tr>
							<tr>
								<td colspan="2">
									<div data-bind="invoice_bottomNote"></div>
								</td>
							</tr>
                                                        <?php if($package['whitelabel'] == 0){?>
                                                        <tr>
								<td colspan="2">
									<img src="<?php echo base_url('img/logo_.png');?>" style="height: 40px; position: relative; top: -4px">
								</td>
							</tr>
                                                        <?php }?>
						</table>
					
					</div>
					
				</div><!-- /.invoiceWrapper -->
				<?php endif;?>
			
			</div><!-- /.col -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->
	
	</section>
	
	<div style="display: none">
		
		<div id="itemRowButtons" class="itemRowButtons">
			<a href="#" class="text-primary item_editRow"><span class="fui-new"></span></a>
			<a href="#" class="text-danger item_delRow"><span class="fui-cross-circle"></span></a>
		</div>
		
		<div id="paymentRowButtons" class="paymentRowButtons">
			<a href="#" class="text-primary payment_editRow"><span class="fui-new"></span></a>
			<a href="#" class="text-danger payment_delRow"><span class="fui-cross-circle"></span></a>
		</div>
		
		<div id="itemColButtons" class="itemColButtons">
			<a href="#" class="text-primary items_editStructure"><span class="fui-new"></span></a>
		</div>
		
		<div class="form-group" id="itemColumnInput">
		    <label for="field_itemCols[]" class="col-sm-3 control-label">Column 1</label>
		    <div class="col-sm-9">
				<div class="input-group">
					<input type="text" id="" name="field_itemCols[]" placeholder="Column name" class="form-control">
					<span class="input-group-btn">
						<button class="btn button_delItemsColumn" type="submit"><span class="fui-cross-circle text-danger"></span></button>
					</span>
				</div>
		    </div>
		</div>
		
		<div class="form-group" id="addItemInput">
		    <label for="field_itemCol" class="col-sm-3 control-label"></label>
		    <div class="col-sm-9">
				<textarea name="field_itemCol" placeholder="" class="form-control"></textarea>
		    </div>
		</div>
		
	</div>
	
	<!-- Modals -->
	
	<?php $this->load->view('shared/modal_changeitemstructure');?>
	
	<?php $this->load->view('shared/modal_additem');?>
	
	<?php $this->load->view('shared/modal_edititem');?>
	
	<?php $this->load->view('shared/modal_addpayment');?>
	
	<?php $this->load->view('shared/modal_editpayment');?>
	
	<?php $this->load->view('shared/modal_account');?>
	
	<?php $this->load->view('shared/modal_apikey');?>
		
	<?php $this->load->view('shared/modal_newclient');?>

    <div class="modal fade" id="modal_importData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
	   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-upload"></span> <?php echo $this->lang->line('modal_import_data');?></h4>
	      	  	</div>
				
				<form method="post" enctype="multipart/form-data" id="form_dataImport" data-toggle="validator" action="<?php echo site_url('invoices/uploadData');?>">
	      	  	
				<div class="modal-body">
					
					<div class="alerts">
						<div class="alert alert-info">
						  	<button class="close fui-cross" data-dismiss="alert"></button>
						  	<h4><?php echo $this->lang->line('please_note');?></h4>
						  	<?php echo $this->lang->line('modal_import_data_message');?>
						</div>
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
					        		<input type="file" name="field_file" required data-error="Please choose a CSV file to upload">
					        		<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span> <?php echo $this->lang->line('upload_remove');?></a>
					      	  	</span>
					    	</div>
					  	</div>
					</div>
					
					<div class="form-group"></div>
					
	      	  	</div><!-- /.modal-body -->
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
                    <button type="submit" class="btn btn-primary btn-embossed" id="button_addItemToInvoice"><span class="fui-check"></span> <span class="buttonText"><?php echo $this->lang->line('import_data_csv');?></span></button>
	      	  	</div>
				
				</form>
	    	
			</div><!-- /.modal-content -->
	  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->
	
	<div class="modal fade" id="modal_deleteInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
	   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-trash"></span> <?php echo $this->lang->line('modal_delete_invoice');?>?</h4>
	      	  	</div>
					      	  	
				<div class="modal-body">
					
					<div class="alert alert-warning">
					  	<?php echo $this->lang->line('modal_delete_invoice_message');?>
					</div>
					
	      	  	</div><!-- /.modal-body -->
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        		<a href="" data-url="<?php echo site_url('invoices/delete/');?>" class="btn btn-primary btn-embossed" id="link_deleteInvoice"><span class="fui-check"></span> <?php echo $this->lang->line('modal_delete_invoice_confirm');?></a>
	      	  	</div>
					    	
			</div><!-- /.modal-content -->
	  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->

    <div class="modal fade" id="modal_sendByEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
	   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-mail"></span> <?php echo $this->lang->line('modal_send_invoice_by_email');?></h4>
	      	  	</div>
				
				<form method="post" data-toggle="validator" action="<?php echo site_url('invoices/send');?>" id="form_sendByEmail">
					
				<input type="hidden" name="invoiceID" value="<?php echo $theInvoice->invoice_id;?>">
				<input type="hidden" name="clientID" value="<?php echo $theInvoice->client_id;?>">
					      	  	
				<div class="modal-body">
					
					<div class="form-group">
						<label class="control-label" for="field_emailAddress"><?php echo $this->lang->line('modal_email_address');?></label>
					    <input type="email" class="form-control" id="field_emailAddress" name="field_emailAddress" placeholder="<?php echo $this->lang->line('modal_email_address');?>" required data-error="<?php echo $this->lang->line('modal_email_address_error');?>" value="<?php echo $theInvoice->client_email;?>">
						<div class="help-block with-errors"></div>
					</div>
					
					<div class="form-group">
						<?php
							//prep subject line
							$find = array('%invoice_number%', '%company_name%');
							$replace = array($theInvoice->invoice_number, $user->company_name);
							
							$subject = str_replace($find, $replace, $this->config->item('email_default_subject'));
						?>
						<label class="control-label" for="field_emailSubject"><?php echo $this->lang->line('modal_email_subject');?></label>
					    <input type="text" class="form-control" id="field_emailSubject" name="field_emailSubject" placeholder="<?php echo $this->lang->line('modal_email_subject');?>" required data-error="<?php echo $this->lang->line('modal_email_subject_error');?>" value="<?php echo $subject;?>">
						<div class="help-block with-errors"></div>
					</div>
					
					<div class="form-group">
						<?php
							//prep subject line
							
							$invoiceUrl = '<a href="'.site_url('invoice/'.$theInvoice->invoice_code).'">'.site_url('invoice/'.$theInvoice->invoice_code).'</a>';
							
							$find = array('%client%', '%invoice_number%', '%invoice_link%', '%company_name%');
							$replace = array( ($theInvoice->client_contact != '')? $theInvoice->client_contact : $theInvoice->client_name, $theInvoice->invoice_number, $invoiceUrl, $user->company_name);
							
							$content = str_replace($find, $replace, $this->config->item('email_default_content'));
						?>
						<label class="control-label" for="field_emailSubject"><?php echo $this->lang->line('modal_email_content');?></label>
						<textarea class="form-control" name="field_emailContent" id="content" placeholder="<?php echo $this->lang->line('modal_email_content');?>" required data-error="<?php echo $this->lang->line('modal_email_content_error');?>" rows="13" id="textarea_emailContent"><?php echo $content;?></textarea>
						<div class="help-block with-errors"></div>
					</div>
					
					<div class="form-group">
						<label class="checkbox">
							<input type="checkbox" checked data-toggle="checkbox" name="checkbox_sendcc" id="checkbox_sendcc" value="1"> <?php echo $this->lang->line('modal_sent_cc_to');?> <b><?php echo $user->email;?></b>
						</label>
					</div>
					
					<div class="alert alert-info">
					  	<button class="close fui-cross" data-dismiss="alert"></button>
					  	<h4><?php echo $this->lang->line('please_note');?></h4>
					  	<p><?php echo $this->lang->line('modal_attachment_message');?></p>
					</div>
										
	      	  	</div><!-- /.modal-body -->
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        		<button type="submit" class="btn btn-primary btn-embossed"><span class="fui-check"></span> <?php echo $this->lang->line('modal_send_to');?> <?php echo $theInvoice->client_name;?></a>
	      	  	</div>
				
				</form>
	    	
			</div><!-- /.modal-content -->
	  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->

    <?php $this->load->view('shared/shared_javascript');?>
	
	<?php if( isset($theInvoice) ):?>
	
	<?php endif;?>
	
	<script src="<?php echo base_url('js/redactor/redactor.min.js');?>"></script>
	<script>
        
    $(function(){
		
		$('#content').redactor({
			buttons: ['html', 'formatting', 'bold', 'italic', 'link', 'alignment', 'horizontalrule']
		});
		
	    // generic datepickers
	    var datepickerSelector = $('.datePicker');
	    datepickerSelector.datepicker({
			showOtherMonths: true,
	      	selectOtherMonths: true,
			changeMonth: true,
    		changeYear: true,
	      	dateFormat: innvoice.getProp('dateFormat'),
	      	yearRange: '-4:+4',
            onSelect: function() {
                
                var dataBind = $(this).attr('data-bind');
                invoice[dataBind].change( $(this).val() );
                innvoice.checkDue();
                
            }
	    }).prev('.input-group-btn').on('click', function (e) {
	      	e && e.preventDefault();
	      	datepickerSelector.focus();
	    });
	    $.extend($.datepicker, { _checkOffset: function (inst,offset,isFixed) { return offset; } });

	    // Now let's align datepicker with the prepend button
	    datepickerSelector.datepicker('widget').css({ 'margin-left': '-45px' });
		
		//toggle filter panel
		$('#button_toggleFilterPanel').on('click', function(){
			
			if( $('#filterPanel').is(':visible') ) {
				
				$('#filterPanel').slideUp(function(){
					$('#button_toggleFilterPanel').text( $('#button_toggleFilterPanel').attr('data-textmain') );
				});
								
			} else {
				
				$('#filterPanel').slideDown(function(){
					$('#button_toggleFilterPanel').text( $('#button_toggleFilterPanel').attr('data-textalt') );
				});				
				
			}
			
		})
		
	})
	
	<?php if( isset($theInvoice) ):?>
        
    <?php
		
		$subtotal = $theInvoice->invoice_subtotal;
		$discountAmount = ($theInvoice->invoice_subtotal/100)*$theInvoice->invoice_discount;
		$taxAmount = (($theInvoice->invoice_subtotal - $discountAmount)/100)*$theInvoice->invoice_taxamount;
		
		$total = $subtotal - $discountAmount + $taxAmount;
		
	?>
        
    var invoice = {
        invoice_id: new MyCtor(document.querySelectorAll('[data-bind="invoice_id"]'), <?php echo $theInvoice->invoice_number;?>),
        invoice_po: new MyCtor(document.querySelectorAll('[data-bind="invoice_po"]'), '<?php echo $theInvoice->invoice_po;?>'),
        invoice_client: new MyCtor(document.querySelectorAll('[data-bind="invoice_client"]'), <?php echo $theInvoice->client_id;?>),
        invoice_clientName: new MyCtor(document.querySelectorAll('[data-bind="invoice_clientName"]'), "<?php echo $theInvoice->client_name;?>"),
        invoice_clientAddress: new MyCtor(document.querySelectorAll('[data-bind="invoice_clientAddress"]'), "<?php echo preg_replace("/\r\n|\r|\n/",'<br/>',$theInvoice->client_address);?>"),
        invoice_title: new MyCtor(document.querySelectorAll('[data-bind="invoice_title"]'), "<?php echo $theInvoice->invoice_title;?>"),
        invoice_status: new MyCtor(document.querySelectorAll('[data-bind="invoice_status"]'), "<?php echo $theInvoice->invoice_status;?>"),
        invoice_issueDate: new MyCtor(document.querySelectorAll('[data-bind="invoice_issueDate"]'), "<?php echo date($this->config->item('date_format_php'), $theInvoice->invoice_date);?>"),
        invoice_duedate: new MyCtor(document.querySelectorAll('[data-bind="invoice_duedate"]'), "<?php echo date($this->config->item('date_format_php'), $theInvoice->invoice_duedate);?>"),
        invoice_paid: new MyCtor(document.querySelectorAll('[data-bind="invoice_paid"]'), "<?php if( $theInvoice->invoice_status == 'paid' ){echo "Yes";} else {echo "No";}?>"),
        invoice_currenyName: new MyCtor(document.querySelectorAll('[data-bind="invoice_currenyName"]'), '<?php echo $theInvoice->currency_shortname;?>'),
        invoice_currenySymbol: new MyCtor(document.querySelectorAll('[data-bind="invoice_currenySymbol"]'), '<?php echo $theInvoice->currency_sign;?>'),
        invoice_topNote: new MyCtor(document.querySelectorAll('[data-bind="invoice_topNote"]'), "<?php echo $theInvoice->invoice_topnote;?>"),
        invoice_bottomNote: new MyCtor(document.querySelectorAll('[data-bind="invoice_bottomNote"]'), "<?php echo $theInvoice->invoice_bottomnote;?>"),
        //invoice_bottomNote_whitelabel:new MyCtor(document.querySelectorAll('[data-bind="invoice_bottomNote"]'), "while_label_logo"),
        invoice_notes: new MyCtor(document.querySelectorAll('[data-bind="invoice_notes"]'), "<?php echo $theInvoice->invoice_notes;?>"),
        invoice_taxType: new MyCtor(document.querySelectorAll('[data-bind="invoice_taxType"]'), "<?php echo $theInvoice->invoice_taxtype;?>"),
        invoice_public: new MyCtor(document.querySelectorAll('[data-bind="invoice_public"]'), "<?php echo $theInvoice->invoice_public;?>"),
        invoice_recurring: new MyCtor(document.querySelectorAll('[data-bind="invoice_recurring"]'), "<?php echo $theInvoice->invoice_recurring;?>"),
        invoice_paymentbank: new MyCtor(document.querySelectorAll('[data-bind="invoice_paymentbank"]'), "<?php echo $theInvoice->invoice_paymentbank;?>"),
        invoice_paymentstripe: new MyCtor(document.querySelectorAll('[data-bind="invoice_paymentstripe"]'), "<?php echo $theInvoice->invoice_paymentstripe;?>"),
        invoice_paymentpaypal: new MyCtor(document.querySelectorAll('[data-bind="invoice_paymentpaypal"]'), "<?php echo $theInvoice->invoice_paymentpaypal;?>"),
        invoice_taxPercentage: new MyCtor(document.querySelectorAll('[data-bind="invoice_taxPercentage"]'), <?php echo $theInvoice->invoice_taxamount;?>),
        invoice_taxAmount: new MyCtor(document.querySelectorAll('[data-bind="invoice_taxAmount"]'), <?php echo $taxAmount;?>),
        invoice_discountPercentage: new MyCtor(document.querySelectorAll('[data-bind="invoice_discountPercentage"]'), <?php echo $theInvoice->invoice_discount;?>),
        invoice_discountAmount: new MyCtor(document.querySelectorAll('[data-bind="invoice_discountAmount"]'), <?php echo  $discountAmount;?>),
        invoice_subTotal: new MyCtor(document.querySelectorAll('[data-bind="invoice_subTotal"]'), <?php echo $theInvoice->invoice_subtotal;?>),
        invoice_total: new MyCtor(document.querySelectorAll('[data-bind="invoice_total"]'), <?php echo $total;?>),
        invoice_paidToDate: new MyCtor(document.querySelectorAll('[data-bind="invoice_paidToDate"]'), <?php echo $theInvoice->invoice_paidtodate;?>),
        invoice_balanceDue: new MyCtor(document.querySelectorAll('[data-bind="invoice_balanceDue"]'), <?php echo $theInvoice->invoice_balance;?>),
        invoice_items_head: new MyCtor(document.querySelectorAll('[data-bind="invoice_items_head"]'), ''),
        invoice_items_body: new MyCtor(document.querySelectorAll('[data-bind="invoice_items_body"]'), ''),
        
        getAll: function(){//returns everything for this invoice in a nice array
            
            var $return = {};
        
            for(var key in this) {
                if (Object.prototype.hasOwnProperty.call(this, key) && key != 'getAll' && key != 'isPastDue') {
                    $return[key] = this[key].data;
                }
            }
            
            return $return;
        },
        
        isPastDue: function(){
            
            console.log('isPastDue');
                                    
            dueDate = new Date(Date.parse(this.invoice_duedate.data));
            							
			//dueDate.setHours(23);
			dueDateStamp = dueDate.getTime()/1000;
															
			//if todays stamp is bigger then the due stamp, the invoice is past due
			
			todayDate = new Date();
			todayDateStamp = todayDate.getTime()/1000;
			
			//alert( todayDate+" > "+dueDate )
			
			
			if( todayDateStamp > dueDateStamp ) {
				
				return true;
				
			} else {
				
				return false;
				
			}
            
        }
    };
		
	<?php if( $payments ):?>
		
	   <?php foreach( $payments as $payment ):?>
	
	   var newPayment = {date: "<?php echo date($this->config->item('date_format_php'), $payment->payment_date)?>", type: <?php echo $payment->payment_type_id;?>, amount: <?php echo $payment->payment_amount;?>};
    innvoice.addPaymenttoPayments(newPayment);
        
	   <?php endforeach;?>
	
    <?php endif;?>	
	
	
	<?php endif;?>
	
    innvoice.setProp('allClients', <?php echo json_encode($clients)?>);	
	
	
	
    innvoice.setProp('alert_lastfieldnumer', "<?php echo $this->lang->line('alert_lastfieldnumer');?>");
	innvoice.setProp('confirm_deleterow', "<?php echo $this->lang->line('confirm_deleterow');?>");
	innvoice.setProp('confirm_deletepayment', "<?php echo $this->lang->line('confirm_deletepayment');?>");
	
	</script>
  </body>
</html>
