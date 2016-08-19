<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['default_currency'] = 'USD';//must match with currency_shortname column from currencies table

/*
	
	please note that the PHP and JS date formats use different syntax. To be save, use one of the patters sets listed here

	php: 'j M Y', js: 'd M yy' => 21 Feb 2015
	php: 'Y/m/d', js: 'yy/mm/dd' => 2015/02/21
	php: 'Y/n/j', js: 'yy/m/d' => 2015/2/21
	php: 'm/d/Y', js: 'mm/dd/yy' => 02/21/2015
	php: 'n/j/Y', js: 'm/d/yy' => 02/21/2015

	PLEASE NOTE: using anything other then the above combinations might lead to issues and it's not supported. If you require to support a different date format,
	please contact support 
	
*/

$config['date_format_php'] = "j M Y";
$config['date_format_js'] = "d M yy";

$config['dashboard_donut_colors'] = array(
	array('#0EAC93', '#13C5A9'),
	array('#2FB972', '#37D484'),
	array('#358CC0', '#42A3DE'),
	array('#9B4BB4', '#A762BD'),
	array('#36495C', '#3F556A'),
	array('#F4A72F', '#F2CD38'),
	array('#D95F06', '#E98A34'),
	array('#C84135', '#EA5548'),
	array('#C5CBCE', '#EFF2F3'),
	array('#8C9899', '#A1B0B0'),
	array('#67B3C9', '#92d1e3'),
	array('#72939B', '#98b2b8'),
	array('#7B6A58', '#978675'),
	array('#776813', '#8a7a1f'),
	array('#6E4324', '#815434'),
	array('#DAE0D0', '#e9ece3'),
	array('#E0DE92', '#ebe9b0'),
	array('#F9B884', '#f9c9a2'),
	array('#D476A1', '#da8cb0'),
	array('#62848C', '#79959b'),
	array('#505760', '#656c75'),
	array('#8EA4AD', '#a6b8bf'),
	array('#BEB9AD', '#d1cdc5'),
	array('#E5BDA0', '#eaccb7'),
	array('#F8DCC0', '#f9e8d8'),
	array('#522B51', '#5f395e'),
	array('#B96B7A', '#c98592'),
	array('#EE7764', '#f09688'),
	array('#FEC968', '#fad187'),
	array('#54BDA9', '#6fc6b5'),
	array('#0EAC93', '#13C5A9'),
	array('#2FB972', '#37D484'),
	array('#358CC0', '#42A3DE'),
	array('#9B4BB4', '#A762BD'),
	array('#36495C', '#3F556A'),
	array('#F4A72F', '#F2CD38'),
	array('#D95F06', '#E98A34'),
	array('#C84135', '#EA5548'),
	array('#C5CBCE', '#EFF2F3'),
	array('#8C9899', '#A1B0B0'),
	array('#67B3C9', '#92d1e3'),
	array('#72939B', '#98b2b8'),
	array('#7B6A58', '#978675'),
	array('#776813', '#8a7a1f'),
	array('#6E4324', '#815434'),
	array('#DAE0D0', '#e9ece3'),
	array('#E0DE92', '#ebe9b0'),
	array('#F9B884', '#f9c9a2'),
	array('#D476A1', '#da8cb0'),
	array('#62848C', '#79959b'),
	array('#505760', '#656c75'),
	array('#8EA4AD', '#a6b8bf'),
	array('#BEB9AD', '#d1cdc5'),
	array('#E5BDA0', '#eaccb7'),
	array('#F8DCC0', '#f9e8d8'),
	array('#522B51', '#5f395e'),
	array('#B96B7A', '#c98592'),
	array('#EE7764', '#f09688'),
	array('#FEC968', '#fad187'),
	array('#54BDA9', '#6fc6b5'),
);

$config['invoice_itemtable_default_head'] = '<tr>
												<th>Item</th>
												<th>Description</th>
												<th>Item Price</th>
												<th>Quantity</th>
												<th style="width: 140px">Total</th>
											</tr>';
											
$config['export_filename_prepend'] = "invoice_";
$config['export_report_prepend'] = "report_";

/*

	From address is used for all emails send by the script
	
*/
$config['email_from_address'] = "getinvoicer@gmail.com";

/*

	From name is used for all emails send by the script
	
*/
$config['email_from_name'] = "Invoicer";

/*
	
	Default subject and content for invoice email to client

*/
$config['email_default_subject'] = "Invoice #%invoice_number% from %company_name% is ready!";
$config['email_default_content'] = "Dear %client%,

A new invoice (number %invoice_number%) has been created and can be viewed online on the following URL:<br>

%invoice_link%<br>

You will find the same invoice attached to this email as a PDF.<br>

Kind regards,

%company_name%";

/*
	
	Email subject for email send to self when payment received

*/
$config['email_payment_company_subject'] = "Innvoice: you have received a payment!";

/*
	
	Email subject for email send to client when payment received

*/
$config['email_payment_client_subject'] = "Innvoice: you have made a payment";

/*
	
	Email subject for email send to client when a new recurring invoice is generated

*/
$config['email_new_recurring_subject'] = "Innvoice: a new recurring invoice has been generated";