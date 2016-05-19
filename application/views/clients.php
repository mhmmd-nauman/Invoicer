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
			<?php if( $clients ):?>
			<?php foreach( $clients as $client ):?>
			<li <?php if( isset($theClient) && $theClient->client_id == $client->client_id ):?>class="active"<?php endif;?>>
				<a href="<?php echo site_url('clients/'.$client->client_id)?>">
					<b><?php echo $client->client_name;?></b>
					<span class="clearfix">
						<?php if( $client->total_paid != 0 ):?>
						<span class="label label-primary pull-left" title="<?php echo $this->lang->line('tooltip_totalpaid');?>: <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $client->currency_sign;?><?php echo $client->total_paid;?><?php else:?><?php echo $client->total_paid;?><?php echo $client->currency_sign;?><?php endif;?>" data-toggle="tooltip" data-placement="bottom">
                            <b>
                                <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $client->currency_sign;?><?php endif;?>
                                <?php echo $client->total_paid;?>
                                <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $client->currency_sign;?><?php endif;?>
                            </b>
                        </span>
						<?php endif;?>
						<?php if( $client->total_due != 0 ):?>
						<span class="label label-info pull-left" title="<?php echo $this->lang->line('tooltip_totaldue');?>: <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $client->currency_sign;?><?php echo $client->total_due;?><?php else:?><?php echo $client->total_due;?><?php echo $client->currency_sign;?><?php endif;?>" data-toggle="tooltip" data-placement="bottom">
                            <b>
                                <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $client->currency_sign;?><?php endif;?>
                                <?php echo $client->total_due;?>
                                <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $client->currency_sign;?><?php endif;?>
                            </b>
                        </span>
						<?php endif;?>
						<?php if( $client->total_pastdue != 0 ):?>
						<span class="label label-danger pull-left" title="<?php echo $this->lang->line('tooltip_totalpastdue');?>: <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $client->currency_sign;?><?php echo $client->total_pastdue;?><?php else:?><?php echo $client->total_pastdue;?><?php echo $client->currency_sign;?><?php endif;?>" data-toggle="tooltip" data-placement="bottom">
                            <b>
                                <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $client->currency_sign;?><?php endif;?>
                                <?php echo $client->total_pastdue;?>
                                <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $client->currency_sign;?><?php endif;?>
                            </b>
                        </span>
						<?php endif;?>
					</span>
				</a>
			</li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
		
		<?php if( !$clients ):?>
		<div class="alert alert-info" style="margin: 20px">
		  	<button class="close fui-cross" data-dismiss="alert"></button>
		  	<h4><?php echo $this->lang->line('no_clients_heading');?></h4>
		  	<p>
		  		<?php echo $this->lang->line('no_clients_message');?>
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
				
				<?php if( isset($theClient) ):?>
				
				<div role="tabpanel" class="clientTabs">

					<!-- Nav tabs -->
				  	<ul class="nav nav-tabs nav-append-content" role="tablist">
						<li role="presentation" class="active"><a href="#clientOverview" aria-controls="clientOverview" role="tab" data-toggle="tab"><span class="fa fa-tachometer"></span> <?php echo $this->lang->line('tab_overview');?></a></li>
				    	<li role="presentation"><a href="#clientDetails" aria-controls="clientDetails" role="tab" data-toggle="tab"><span class="fui-info-circle"></span> <?php echo $this->lang->line('tab_details');?></a></li>
				    	<?php if( $invoices ):?><li role="presentation"><a href="#clientInvoices" aria-controls="clientInvoices" role="tab" data-toggle="tab"><span class="fui-document"></span> <?php echo $this->lang->line('tab_invoices');?></a></li><?php endif;?>
						<?php if( $payments ):?><li role="presentation"><a href="#clientPayments" aria-controls="clientPayments" role="tab" data-toggle="tab"><span class="fui-credit-card"></span> <?php echo $this->lang->line('tab_payments');?></a></li><?php endif;?>
						<li role="presentation"><a href="#clientNotes" aria-controls="clientNotes" role="tab" data-toggle="tab"><span class="fui-tag"></span> <?php echo $this->lang->line('tab_notes');?></a></li>
				  	</ul>
					
					<form class="form-horizontal" method="post" action="<?php echo site_url('clients/update/'.$theClient->client_id);?>" data-toggle="validator">

				  	<!-- Tab panes -->
				  	<div class="tab-content">
						
						<div role="tabpanel" class="tab-pane active" id="clientOverview">
							
							<div class="dashboard">
								
								<div class="row">
			
									<div class="col-md-12 clearfix" style="margin-bottom: 20px">
										
										<?php if( $currencies && count($currencies) > 1 ):?>
										<div class="pull-right">
											<?php echo $this->lang->line('show_amounts_in');?>: 
											<div class="btn-group">
												<button class="btn btn-inverse btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
							    					<span class="buttonText"><?php echo $default_currency->currency_shortname;?> <?php echo $default_currency->currency_sign;?></span> <span class="caret"></span>
							  					</button>
							  					<ul class="dropdown-menu dropdown-menu-inverse currencySelect" role="menu">
													<?php foreach( $currencies as $currency ):?>
													<li><a href="" data-currencyid="<?php echo $currency->currency_shortname;?>" data-currencysign="<?php echo $currency->currency_sign;?>"><?php echo $currency->currency_shortname;?> <?php echo $currency->currency_sign;?></a></li>
													<?php endforeach;?>
							  					</ul>
											</div>
										</div>
										<?php endif;?>
				
									</div><!-- /.col -->
			
								</div><!-- /.row -->
								
								<div class="row" style="margin-bottom: 40px">
			
									<div class="col-md-4">
				
										<h2><?php echo $this->lang->line('total_paid');?> (<?php echo date('Y');?>)</h2>
				
										<div class="dashboardTotal paid text-center">
					
											<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
                                            <?php echo $total_paid;?>
                                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
					
										</div>
								
									</div><!-- /.col -->
			
									<div class="col-md-4">
				
										<h2><?php echo $this->lang->line('total_due');?> (<?php echo date('Y');?>)</h2>
				
										<div class="dashboardTotal due text-center">
					
											<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
                                            <?php echo $total_due;?>
                                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
					
										</div>
				
									</div><!-- /.col -->
			
									<div class="col-md-4">
				
										<h2><?php echo $this->lang->line('total_past_due');?> (<?php echo date('Y');?>)</h2>
				
										<div class="dashboardTotal past-due text-center">
					
											<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
                                            <?php echo $total_pastdue;?>
                                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $default_currency->currency_sign;?><?php endif;?>
					
										</div>
				
									</div><!-- /.col -->
			
								</div><!-- /.row -->
		
								<div class="row">
			
									<div class="col-md-8" id="div_yearlyChart">
				
										<h2><?php echo $this->lang->line('yearly_overview');?></h2>
				
										<canvas id="yearly"></canvas>
								
									</div><!-- /.col -->
									
									<div class="col-md-4">
										
										
										
									</div><!-- /.col -->									
					
								</div><!-- /.row -->
								
							</div><!-- /.dashboard -->
							
						</div><!-- /.tab-pane -->
						
				    	<div role="tabpanel" class="tab-pane" id="clientDetails">
				    																									
							<div class="form-group">
								<label for="field_clientName" class="col-sm-3 control-label"><?php echo $this->lang->line('client_name_label');?>:<span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="field_clientName" name="field_clientName" placeholder="<?php echo $this->lang->line('client_name_placeholder');?>" value="<?php echo $theClient->client_name;?>" required data-error="<?php echo $this->lang->line('client_name_error');?>">
									<div class="help-block with-errors"></div>
								</div>
							</div>
							
							<div class="form-group">
								<label for="field_clientContact" class="col-sm-3 control-label"><?php echo $this->lang->line('client_contact_label');?>:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="field_clientContact" name="field_clientContact" placeholder="<?php echo $this->lang->line('client_contact_placeholder');?>" value="<?php echo $theClient->client_contact;?>">
								</div>
							</div>
															  	
							<div class="form-group">
								<label for="field_clientEmail" class="col-sm-3 control-label"><?php echo $this->lang->line('client_email_label');?>:<span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="field_clientEmail" name="field_clientEmail" placeholder="<?php echo $this->lang->line('client_email_placeholder');?>" value="<?php echo $theClient->client_email;?>" required data-error="<?php echo $this->lang->line('client_email_error');?>">
									<div class="help-block with-errors"></div>
								</div>
							</div>
								
							<div class="form-group">
								<label for="field_clientPhone" class="col-sm-3 control-label"><?php echo $this->lang->line('client_phone_label');?>:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="field_clientPhone" name="field_clientPhone" placeholder="<?php echo $this->lang->line('client_placeholder');?>" value="<?php echo $theClient->client_phone;?>">
								</div>
							</div>
																													
							<div class="form-group">
								<label for="field_clientFax" class="col-sm-3 control-label"><?php echo $this->lang->line('client_fax_label');?>:</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="field_clientFax" name="field_clientFax" placeholder="<?php echo $this->lang->line('client_fax_placehoder');?>" value="<?php echo $theClient->client_fax;?>">
								</div>
							</div>
										
							<div class="form-group">
								<label for="field_clientWebsite" class="col-sm-3 control-label"><?php echo $this->lang->line('client_website_label');?>:</label>
								<div class="col-sm-9">
									<input type="url" class="form-control" id="field_clientWebsite" name="field_clientWebsite" placeholder="<?php echo $this->lang->line('client_website_placeholder');?>" value="<?php echo $theClient->client_website;?>">
								</div>
							</div>
										
							<div class="form-group">
								<label for="field_clientAddress" class="col-sm-3 control-label"><?php echo $this->lang->line('client_address_label');?>:</label>
								<div class="col-sm-9">
									<textarea class="form-control" id="field_clientAddress" name="field_clientAddress" placeholder="<?php echo $this->lang->line('client_address_placeholder');?>" rows="6"><?php echo $theClient->client_address;?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label for="field_clientAdditionalinfo" class="col-sm-3 control-label"><?php echo $this->lang->line('client_additionalinfo_label');?>:</label>
								<div class="col-sm-9">
									<textarea class="form-control" id="field_clientAdditionalinfo" name="field_clientAdditionalinfo" placeholder="<?php echo $this->lang->line('client_additionalinfo_placeholder');?>" rows="6"><?php echo $theClient->client_additionalInfo;?></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label for="field_defaultCurrency" class="col-sm-3 control-label"><?php echo $this->lang->line('client_default_currency_label');?>:</label>
								<div class="col-sm-9">
									<select id="field_defaultCurrency" name="field_defaultCurrency" class="form-control regular chosen">
									    <?php foreach( $allCurrencies as $currency ):?>
										<option value="<?php echo $currency->currency_shortname;?>" <?php if( $currency->currency_shortname == $theClient->client_default_currency ):?>selected<?php endif;?> ><?php echo $currency->currency_shortname;?> <?php echo $currency->currency_sign;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
										
							<div class="form-group">
								<div class="col-sm-9 col-sm-offset-3 clientDetailsButtons">
									<button type="submit" class="btn btn-primary btn-embossed btn-wide"><span class="fui-check"></span> <?php echo $this->lang->line('update_details');?></button>
									<span style="padding: 0px 30px" class="hidden-md hidden-sm hidden-xs">or</span>
									<a href="<?php echo site_url('clients/delete/'.$theClient->client_id)?>" class="btn btn-danger btn-embossed btn-wide" id="button_deleteClient"><span class="fui-cross"></span> <?php echo $this->lang->line('delete_client');?></a>
								</div>
							</div>
																					
				    	</div><!-- /.tab-pane -->
						
						<?php if( $invoices ):?>						
				    	<div role="tabpanel" class="tab-pane" id="clientInvoices">
				    		
							<div class="filters clearfix" id="filters">
								<div class="pull-right">
									<span class="small">Filter by type: &nbsp;</span>
									<button type="button" class="btn btn-primary btn-xs" data-filter="paid" id="filter_paid"><?php echo $this->lang->line('paid');?></button>
									<button type="button" class="btn btn-info btn-xs" data-filter="due" id="filter_due"><?php echo $this->lang->line('due');?></button>
									<button type="button" class="btn btn-danger btn-xs" data-filter="past-due" id="filter_pastDue"><?php echo $this->lang->line('past_due');?></button>
									<button type="button" class="btn btn-inverse btn-xs" id="filter_all"><?php echo $this->lang->line('toggle_all');?></button>
								</div>
							</div>
							
							<ul class="paneOneList invoiceList" id="invoiceList">
								<?php foreach( $invoices as $invoice ):?>
								<li class="all <?php echo str_replace(" ", "-", $invoice->invoice_status);?>" data-year="any">
									<a href="<?php echo site_url('invoices/'.$invoice->invoice_id);?>">
										<span class="clearfix">
											<span class="invoiceAmount pull-right">
                                                <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $invoice->currency_sign;?><?php endif;?>
                                                <?php echo number_format($invoice->invoice_balance+$invoice->invoice_paidtodate, 2);?>
                                                <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $invoice->currency_sign;?><?php endif;?>
                                            </span>
											<span class="invoiceNumber pull-left">#<?php echo $invoice->invoice_number;?> </span>
											<?php if( $invoice->invoice_status == 'due' ):?>
											<span class="label label-info">due</span>
											<?php elseif( $invoice->invoice_status == 'paid' ):?>
											<span class="label label-primary">paid</span>
											<?php elseif( $invoice->invoice_status == 'past due' ):?>
											<span class="label label-danger">past due</span>
											<?php endif;?>
										</span>
										<span class="clearfix">
											<span class="invoiceName pull-left"><?php echo $invoice->invoice_title;?></span>
											<span class="invoiceDate pull-right text-right"><?php echo date($this->config->item('date_format_php'), $invoice->invoice_date);?></span>
										</span>
									</a>
								</li>
								<?php endforeach;?>
							</ul>
							
				    	</div>
						<?php endif;?>
						
						<?php if( $payments ):?>
				    	<div role="tabpanel" class="tab-pane" id="clientPayments">
							
							<div class="alert alert-warning">
								<button class="close fui-cross" data-dismiss="alert"></button>
							  	<h4><?php echo $this->lang->line('please note');?></h4>
							  	<p><?php echo $this->lang->line('default_currency_message');?> <b><?php echo $theClient->currency_shortname;?> <?php echo $theClient->currency_sign;?></b></p>
							</div>
				    		
							<table class="table table-bordered paymentsTable" id="table_clientPayments">
								<thead>
									<tr>
										<th style="width: 15%"><?php echo $this->lang->line('date');?></th>
										<th style="width: 20%"><?php echo $this->lang->line('invoice');?> #</th>
										<th>Type</th>
										<th style="width: 20%"><?php echo $this->lang->line('amount');?> (<?php echo $theClient->currency_shortname;?> <?php echo $theClient->currency_sign;?>)</th>
									</tr>
								</thead>
								<?php
								$paymentsTotal = 0;
								?>
								<tbody>
									<?php foreach( $payments as $payment ):?>
									<tr>
										<td><?php echo date($this->config->item('date_format_php'), $payment->payment_date);?></td>
										<td><a href="<?php echo site_url('invoices'.$payment->invoice_id);?>"><?php echo $payment->invoice_number;?></a></td>
										<td><?php echo $payment->payment_type;?></td>
										<td><?php echo $payment->payment_amount; $paymentsTotal += $payment->payment_amount;?></td>
									</tr>
									<?php endforeach;?>
								</tbody>
								<tfoot>
									<tr>
										<th class="text-right" colspan="3"><?php echo $this->lang->line('total_paid');?></th>
										<th><b id="paymentsTotal" data-bind="invoice_paidToDate"><?php echo $paymentsTotal;?></b></th>
									</tr>
								</tfoot>
							</table>
							
				    	</div>
						<?php endif;?>
						
				    	<div role="tabpanel" class="tab-pane" id="clientNotes">
				    		
							<form class="form-horizontal">
																		  	
								<div class="form-group">
							    	<label for="field_clientNotes" class="col-sm-3 control-label"><?php echo $this->lang->line('notes');?>:</label>
							    	<div class="col-sm-9">
										<textarea class="form-control" name="field_clientNotes" id="field_clientNotes" placeholder="Client notes (for internal usage only)" rows="10"><?php echo $theClient->client_notes;?></textarea>
							    	</div>
							  	</div>
								
								<div class="form-group">
									<div class="col-sm-9 col-sm-offset-3">
										<button type="submit" class="btn btn-primary btn-embossed btn-wide"><?php echo $this->lang->line('update_details');?></button>
									</div>
								</div>
							
							</form>
							
				    	</div>

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
		
	<?php $this->load->view('shared/modal_newclient');?>

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
	
	<?php if( isset($theClient) && $theClient ):?>
	
	var lineChartData = {
		labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
		datasets : [
			{
				label: "<?php echo date('Y');?>",
				fillColor : "rgba(14,172,147,0.1)",
				strokeColor : "rgba(14,172,147,1)",
				pointColor : "rgba(14,172,147,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "rgba(54,73,92,0.8)",
				pointHighlightStroke : "rgba(54,73,92,1)",
				data : [<?php echo $totalsCurrentYear->Jan;?>,<?php echo $totalsCurrentYear->Feb;?>,<?php echo $totalsCurrentYear->Mar;?>,<?php echo $totalsCurrentYear->Apr;?>,<?php echo $totalsCurrentYear->May;?>,<?php echo $totalsCurrentYear->Jun;?>,<?php echo $totalsCurrentYear->Jul;?>, <?php echo $totalsCurrentYear->Aug;?>,<?php echo $totalsCurrentYear->Sep;?>,<?php echo $totalsCurrentYear->Oct;?>,<?php echo $totalsCurrentYear->Nov;?>, <?php echo $totalsCurrentYear->Dec;?>],
			},
			{
				label: "<?php echo date('Y')-1;?>",
				fillColor : "rgba(244,167,47,0)",
				strokeColor : "rgba(244,167,47,1)",
				pointColor : "rgba(217,95,6,1)",
				pointStrokeColor : "#fff",
				pointHighlightFill : "rgba(54,73,92,0.8)",
				pointHighlightStroke : "rgba(54,73,92,1)",
				data : [<?php echo $totalsLastYear->Jan;?>,<?php echo $totalsLastYear->Feb;?>,<?php echo $totalsLastYear->Mar;?>,<?php echo $totalsLastYear->Apr;?>,<?php echo $totalsLastYear->May;?>,<?php echo $totalsLastYear->Jun;?>,<?php echo $totalsLastYear->Jul;?>, <?php echo $totalsLastYear->Aug;?>,<?php echo $totalsLastYear->Sep;?>,<?php echo $totalsLastYear->Oct;?>,<?php echo $totalsLastYear->Nov;?>, <?php echo $totalsLastYear->Dec;?>],
			}
			
		]

	}
	
	$(function(){
		
		Chart.defaults.global.scaleFontSize = 15;
		
		var ctx = document.getElementById("yearly").getContext("2d");
		yearlyChart = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
		
		$('#div_yearlyChart').append( yearlyChart.generateLegend() );
		
		$('#button_deleteClient').on('click', function(e){
		
			if( confirm('<?php echo $this->lang->line('confirm_delete_client');?>') ) {
			
				return true;
			
			} else {
			
				return false;
			
			}
		
		})
		
	})
	
	<?php endif;?>
	
	</script>
  </body>
</html>
