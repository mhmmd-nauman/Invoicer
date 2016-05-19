<?php $this->load->view('shared/header');?>

	<div class="leftBar2">

		<div class="buttonWrapper">
			<button type="button" class="btn btn-primary btn-embossed btn-block" data-target="#modal_createReport" data-toggle="modal"><span class="fui-plus"></span> <?php echo $this->lang->line('create_new_report');?></button>
		</div>

		<ul class="paneOneList reportsList" id="reportsList">
			<?php if( $reports ):?>
			<?php foreach( $reports as $report ):?>
			<li <?php if( isset($theReport) && $report->report_id == $theReport['report']->report_id ):?>class="active"<?php endif;?> >
				<a href="<?php echo site_url('reports/'.$report->report_id);?>">
					<b><?php echo $report->report_title;?></b>
					<span>Created on: <b><?php echo date($this->config->item('date_format_php'), $report->report_date);?></b></span>
				</a>
			</li>
			<?php endforeach;?>
			<?php else:?>
			<div class="alert alert-info" style="margin: 20px">
				<button class="close fui-cross" data-dismiss="alert"></button>
				<h4><?php echo $this->lang->line('no_reports_heading');?></h4>
				<p>
					<?php echo $this->lang->line('no_reports_message');?>
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

				<?php if( isset($theReport) ):?>

				<div class="report" id="report">

					<nav class="navbar navbar-default reportButtons" role="navigation">

						<a href="<?php echo site_url('reports/getPDF/'.$theReport['report']->report_id);?>" class="btn btn-default navbar-btn btn-sm btn-embossed invoiceSlidePanel" type="button" style="margin-right: 10px; margin-left: 10px"><span class="fui-export"></span> Download PDF</a>

						<a href="<?php echo site_url('reports/delete/'.$theReport['report']->report_id);?>" class="btn btn-danger navbar-btn btn-sm btn-embossed" type="button" style="margin-right: 10px"><span class="fui-cross-circle"></span> Delete Report</a>

					</nav><!-- /navbar -->

					<div style="margin: 20px" class="table-responsive">

						<table class="table reportTable">

							<tr>
								<td>
									<h2><?php echo $theReport['report']->report_title;?></h2>
									<p>
										<?php echo $this->lang->line('report_created_on');?>: <b><?php echo date($this->config->item('date_format_php'), $theReport['report']->report_date);?></b><br>
										<?php echo $this->lang->line('report_clients');?>: <?php foreach( $theReport['clients'] as $client){echo "<b>".$client->client_name."</b>, ";}?><br>
										<?php echo $this->lang->line('report_from');?>: <b><?php echo date($this->config->item('date_format_php'), $theReport['report']->report_from);?></b> <?php echo $this->lang->line('report_to');?>: <b><?php echo date($this->config->item('date_format_php'), $theReport['report']->report_untill);?></b><br>
										<?php echo $this->lang->line('report_currency');?>: <b><?php echo $theReport['report']->currency_shortname;?> <?php echo $theReport['report']->currency_sign;?></b><br>
										<?php echo $this->lang->line('report_included');?>: <?php if( $theReport['report']->report_included_paid ):?><span class="label label-primary"><?php echo $this->lang->line('paid');?></span><?php endif;?> <?php if( $theReport['report']->report_included_due ):?><span class="label label-info"><?php echo $this->lang->line('due');?></span><?php endif;?> <?php if( $theReport['report']->report_included_pastdue ):?><span class="label label-danger"><?php echo $this->lang->line('past_due');?></span><?php endif;?><br>
									</p>
								</td>
								<td class="text-right">
									<?php if( $user->company_logo != '' ):?>
									<img src="<?php echo base_url($user->company_logo)?>" style="width:150px">
									<?php else:?>
									<h1><?php echo $user->company_name;?></h1>
									<?php endif;?>
								</td>
							</tr>

							<tr>
								<td colspan="2" style="padding-left: 0px; padding-right: 0px">
									<table class="table table-bordered itemTable">
										<thead>
											<tr>
												<th><?php echo $this->lang->line('invoice');?> #</th>
												<th><?php echo $this->lang->line('invoice_date');?></th>
												<th><?php echo $this->lang->line('invoice_status');?></th>
												<th><?php echo $this->lang->line('invoice_paid');?></th>
												<th><?php echo $this->lang->line('invoice_balance');?></th>
											</tr>
										</thead>
										<?php
										$totalPaid = 0;
										$totalBalance = 0;
										?>
										<tbody>
											<?php foreach( $theReport['invoices'] as $invoice ):?>
											<tr>
												<td><a href="<?php echo site_url('invoices/'.$invoice->invoice_id);?>"><?php echo $invoice->invoice_number;?></a></td>
												<td><?php echo date($this->config->item('date_format_php'), $invoice->invoice_date);?></td>
												<td>
													<?php if( $invoice->invoice_status == 'paid' ):?>
													<span class="label label-primary"><?php echo $this->lang->line('paid');?></span>
													<?php elseif( $invoice->invoice_status == 'due' ):?>
													<span class="label label-info"><?php echo $this->lang->line('due');?></span>
													<?php elseif( $invoice->invoice_status == 'past due' ):?>
													<span class="label label-danger"><?php echo $this->lang->line('past_due');?></span>
													<?php endif;?>
												</td>
												<td>
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                    <?php echo $invoice->invoice_paidtodate; $totalPaid += $invoice->invoice_paidtodate;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                </td>
												<td>
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                    <?php echo $invoice->invoice_balance; $totalBalance += $invoice->invoice_balance;?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                </td>
											</tr>
											<?php endforeach;?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="3">Totals</td>
												<td>
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                    <?php echo number_format($totalPaid, 2);?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                </td>
												<td>
                                                    <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                    <?php echo number_format($totalBalance, 2);?>
                                                    <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theReport['report']->currency_sign;?><?php endif;?>
                                                </td>
											</tr>
										</tfoot>
									</table>
								</td>
							</tr>

						</table>

					</div>

				</div><!-- /.report -->

				<?php endif;?>

			</div><!-- /.col -->

		</div><!-- /.row -->

	</div><!-- /.container-fluid -->

	</section>

	<!-- Modal -->

	<div class="modal fade" id="modal_createReport" tabindex="-1" role="dialog" aria-labelledby="modal_createReport" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><i class="fa fa-calculator"></i> <?php echo $this->lang->line('heading_create_report');?></h4>
	      	  	</div>

				<form class="form-horizontal" action="<?php echo site_url('reports/create');?>" data-toggle="validator" method="post">

					<div class="modal-body">

						<div class="form-group">
					    	<label for="field_reportTitle" class="col-sm-3 control-label"><?php echo $this->lang->line('report_title_label');?>:</label>
					    	<div class="col-sm-9">
								<input type="text" class="form-control" name="field_reportTitle" id="field_reportTitle" required data-error="<?php echo $this->lang->line('report_title_error');?>" value="<?php echo $this->lang->line('report_title_default_value');?>">
								<div class="help-block with-errors"></div>
					    	</div>
					  	</div>

						<div class="form-group">
					    	<label for="field_reportClients" class="col-sm-3 control-label"><?php echo $this->lang->line('for_clients_label');?>:</label>
					    	<div class="col-sm-9">
								<select multiple="multiple" class="form-control multiselect multiselect-default" name="field_reportClients[]" id="field_reportClients" required>
									<?php foreach( $clients as $client ):?>
									<option value="<?php echo $client->client_id;?>"><?php echo $client->client_name;?></option>
									<?php endforeach;?>
								</select>
					    	</div>
					  	</div>

						<div class="form-group">
					    	<label for="field_reportStatus" class="col-sm-3 control-label"><?php echo $this->lang->line('status_label');?>:</label>
					    	<div class="col-sm-9">
								<select multiple="multiple" class="form-control multiselect multiselect-default" name="field_reportStatus[]" id="field_reportStatus" required>
								  	<option value="paid"><?php echo $this->lang->line('paid');?></option>
								  	<option value="due"><?php echo $this->lang->line('due');?></option>
								  	<option value="past due"><?php echo $this->lang->line('past_due');?></option>
								</select>
					    	</div>
					  	</div>

						<div class="form-group">
					    	<label for="field_reportCurrency" class="col-sm-3 control-label"><?php echo $this->lang->line('currency');?>:</label>
					    	<div class="col-sm-9">
								<select class="form-control regular chosen" name="field_reportCurrency" id="field_reportCurrency">
									<?php foreach( $currencies as $currency ):?>
									<option value="<?php echo $currency->currency_shortname?>" <?php if( $this->config->item('default_currency') == $currency->currency_shortname ):?>selected<?php endif;?> ><?php echo $currency->currency_shortname;?> - <?php echo $currency->currency_sign;?> (<?php echo $currency->currency_fullname;?>)</option>
									<?php endforeach;?>
								</select>
								<div class="help-block with-errors"></div>
					    	</div>
					  	</div>

						<div class="form-group">
					    	<label for="field_reportFrom" class="col-sm-3 control-label"><?php echo $this->lang->line('date_from_label');?>:</label>
					    	<div class="col-sm-9">
								<div class="input-group">
								    <span class="input-group-btn">
								      	<button class="btn" type="button"><span class="fui-calendar"></span></button>
								    </span>
								    <input type="text" class="form-control datePicker" value="<?php echo date($this->config->item('date_format_php'));?>" id="field_reportFrom" name="field_reportFrom" required data-error="<?php echo $this->lang->line('date_from_error');?>">
								</div>
								<div class="help-block with-errors"></div>
					    	</div>
					  	</div>

						<div class="form-group">
					    	<label for="field_reportTo" class="col-sm-3 control-label"><?php echo $this->lang->line('date_to_label');?>:</label>
					    	<div class="col-sm-9">
								<div class="input-group">
								    <span class="input-group-btn">
								      	<button class="btn" type="button"><span class="fui-calendar"></span></button>
								    </span>
								    <input type="text" class="form-control datePicker" value="<?php echo date($this->config->item('date_format_php'));?>" id="field_reportTo" name="field_reportTo" required data-error="<?php echo $this->lang->line('date_to_error');?>">
								</div>
								<div class="help-block with-errors"></div>
					    	</div>
					  	</div>

	      	  		</div>

					<div class="modal-footer">
	        			<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        			<button type="submit" class="btn btn-primary btn-embossed" ><span class="fui-check"></span> <?php echo $this->lang->line('build_report');?></button>
	      	  		</div>

				</form>

			</div><!-- /.modal-content -->

		</div><!-- /.modal-dialog -->

	</div><!-- /.modal -->

	<?php $this->load->view('shared/modal_account');?>

	<?php $this->load->view('shared/modal_apikey');?>

	<?php $this->load->view('shared/modal_newclient')?>

    <?php $this->load->view('shared/shared_javascript');?>

	<script src="<?php echo base_url('js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('js/dataTables.bootstrap.js')?>"></script>
	<script src="<?php echo base_url('js/dataTables.responsive.min.js')?>"></script>
	<script>

	var ctable = $('#table_clientPayments').dataTable();

	$(function(){

	    // generic datepickers
	    var datepickerSelector = $('.datePicker');
	    datepickerSelector.datepicker({
			showOtherMonths: true,
	      	selectOtherMonths: true,
	      	dateFormat: innvoice.getProp('dateFormat'),
	      	yearRange: '-1:+1'
	    }).prev('.input-group-btn').on('click', function (e) {
	      	e && e.preventDefault();
	      	datepickerSelector.focus();
	    });
	    $.extend($.datepicker, { _checkOffset: function (inst,offset,isFixed) { return offset; } });

	    // Now let's align datepicker with the prepend button
	    datepickerSelector.datepicker('widget').css({ 'margin-left': '-45px' });

        $("select.multiselect").select2({dropdownCssClass: 'dropdown-inverse'});

	});

	</script>
  </body>
</html>