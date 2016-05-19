<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $this->lang->line('html_title');?></title>
	
	<link href="<?php echo base_url('css/invoice_pdf.css')?>" rel="stylesheet">

</head>

<body>
							
	<div class="invoiceWrapper" id="invoiceWrapper">
		
		<table class="invoiceTable">
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
					<div><?php echo nl2br($user->company_additionalinfo);?></div>
				</td>
			</tr>
			<tr>
				<td>
					<h2><?php echo $theInvoice->invoice_title;?></h2>
					<b><?php echo $this->lang->line('pdf_invoice_to');?>:</b><br>
					<b><?php echo $theInvoice->client_name;?></b><br>
					<div><?php echo nl2br( $theInvoice->client_address );?></div>
					<div><?php echo nl2br( $theInvoice->client_additionalInfo );?></div>
				</td>
				<td class="text-right lead" style="padding-top: 40px">
					<?php
						if( $theInvoice->invoice_status == 'due' ) {
							$status = 'due';
						} elseif( $theInvoice->invoice_status == 'past due' ) {
							$status = 'past-due';
						} elseif( $theInvoice->invoice_status == 'paid' ) {
							$status = 'paid';
						}
					?>
					<h2 class="status <?php echo $status;?>"><?php echo $theInvoice->invoice_status;?></h2>
					<?php echo $this->lang->line('pdf_invoice_number');?>: <b>#<?php echo $theInvoice->invoice_number;?></b><br>
					<div <?php if( $theInvoice->invoice_po == '' ):?>style="display:none"<?php endif;?> id="div_invoicePo"><?php echo $this->lang->line('pdf_invoice_po');?>: <b><?php echo $theInvoice->invoice_po;?></b></div>
					<b><?php echo date($this->config->item('date_format_php'), $theInvoice->invoice_date);?></b>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 20px; padding-bottom:30px; text-align: left">
					<div class="invoiceEdit bind"><?php echo $theInvoice->invoice_topnote;?></div>
				</td>
			</tr>
		</table>
		
		<table class="itemsTable">
			<thead>
			<?php echo $theInvoice->invoice_items_head;?>
			</thead>
			<tbody>
			<?php echo $theInvoice->invoice_items_body;?>
			</tbody>
		</table>
		
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
		
		<table class="totalsTable">
			<tbody>
				<tr>
					<td style="padding-left: 50%">
						<?php echo $this->lang->line('pdf_invoice_subtotal');?>:
					</td>
					<td>
						<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                        <?php echo $theInvoice->invoice_subtotal;?>
                        <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
					</td>
				</tr>
				<tr <?php if( $theInvoice->invoice_discount == 0 ):?>style="display: none"<?php endif;?> id="row_invoiceDiscount">
					<td style="padding-left: 50%">
						<?php echo $this->lang->line('pdf_invoice_discount');?> (<?php echo $theInvoice->invoice_discount;?>%):
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
					<td style="padding-left: 50%">
						<?php echo $this->lang->line('pdf_invoice_tax');?> (<?php echo $theInvoice->invoice_taxtype;?>, <?php echo $theInvoice->invoice_taxamount;?>%):
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
					<td style="padding-left: 50%">
						<?php echo $this->lang->line('pdf_invoice_total_amount');?>:
					</td>
					<td>
						<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                        <?php echo $total;?>
                        <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
					</td>
				</tr>
				<tr>
					<td style="padding-left: 50%">
						<?php echo $this->lang->line('pdf_invoice_paid_to_date');?>:
					</td>
					<td>
						<?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                        <?php echo $theInvoice->invoice_paidtodate;?>
                        <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
					</td>
				</tr>
				<tr>
					<td style="padding-left: 50%">
						<b><?php echo $this->lang->line('pdf_invoice_balance');?> (<?php echo $theInvoice->currency_shortname;?>):</b>
					</td>
					<td style="width: 240px">
						<b>
                            <?php if( $settings[0]->currency_placement == 'before' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                            <span><?php echo number_format($theInvoice->invoice_balance, 2);?></span>
                            <?php if( $settings[0]->currency_placement == 'after' ):?><?php echo $theInvoice->currency_sign;?><?php endif;?>
                        </b>
					</td>
				</tr>
				<tr>
					<td style="padding-left: 0px"></td>
					<td style="font-size: 14px; padding-top: 20px"><?php echo $this->lang->line('pdf_invoice_due_before');?>: <b><?php echo date($this->config->item('date_format_php'), $theInvoice->invoice_duedate);?></b></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: left">
						<div class="bottomNotes">
							<?php echo $theInvoice->invoice_bottomnote;?>
						</div>
					</td>
				<tr>
			</body>
		</table>
											
	</div><!-- /.invoiceWrapper -->

</body>
</html>