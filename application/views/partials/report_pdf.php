<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $this->lang->line('html_title');?></title>

	<link href="<?php echo base_url('css/report_pdf.css')?>" rel="stylesheet">

</head>

<body>

	<div class="reportWrapper">

		<table class="reportTable">

			<tr>
				<td>
					<h2><?php echo $theReport['report']->report_title;?></h2>
					<p>
						<?php echo $this->lang->line('pdf_report_created_on');?>: <b><?php echo date($this->config->item('date_format_php'), $theReport['report']->report_date);?></b><br>
						<?php echo $this->lang->line('pdf_report_clients');?>: <?php foreach( $theReport['clients'] as $client){echo "<b>".$client->client_name."</b>, ";}?><br>
						<?php echo $this->lang->line('pdf_report_from');?>: <b><?php echo date($this->config->item('date_format_php'), $theReport['report']->report_from);?></b> <?php echo $this->lang->line('pdf_report_to');?>: <b><?php echo date($this->config->item('date_format_php'), $theReport['report']->report_untill);?></b><br>
						<?php echo $this->lang->line('pdf_report_currency');?>: <b><?php echo $theReport['report']->currency_shortname;?> <?php echo $theReport['report']->currency_sign;?></b><br>
						<?php echo $this->lang->line('pdf_report_included');?>: <?php if( $theReport['report']->report_included_paid ):?><span class="label label-primary"><?php echo $this->lang->line('paid');?></span><?php endif;?> <?php if( $theReport['report']->report_included_due ):?><span class="label label-info"><?php echo $this->lang->line('due');?></span><?php endif;?> <?php if( $theReport['report']->report_included_pastdue ):?><span class="label label-danger"><?php echo $this->lang->line('past_due');?></span><?php endif;?><br>
					</p>
				</td>
				<td class="text-right">
					<img src="<?php echo base_url($user->company_logo)?>" style="width: 150px">
				</td>
			</tr>
		</table>

		<table class="reportTable">

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
					<td><?php echo $invoice->invoice_number;?></td>
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
					<td><?php echo $theReport['report']->currency_sign;?><?php echo $invoice->invoice_paidtodate; $totalPaid += $invoice->invoice_paidtodate;?></td>
					<td><?php echo $theReport['report']->currency_sign;?><?php echo $invoice->invoice_balance; $totalBalance += $invoice->invoice_balance;?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3" style="text-align:right"><?php echo $this->lang->line('totals');?></td>
					<td><b><?php echo $theReport['report']->currency_sign;?><?php echo number_format($totalPaid, 2);?></b></td>
					<td><b><?php echo $theReport['report']->currency_sign;?><?php echo number_format($totalBalance, 2);?></b></td>
				</tr>
			</tfoot>

		</table>

	</div><!-- /.invoiceWrapper -->

</body>
</html>