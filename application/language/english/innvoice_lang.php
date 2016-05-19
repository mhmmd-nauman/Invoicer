<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*/


/* shared */
$lang['invoice'] = "Invoice";

$lang['paid'] = "paid";
$lang['due'] = "due";
$lang['past_due'] = "past due";
$lang['all'] = "all";
$lang['toggle_all'] = "toggle all";
$lang['yes'] = "Yes";
$lang['no'] = "No";
$lang['currency'] = "Currency";
$lang['please_note'] = "Please note";
$lang['date'] = "Date";
$lang['type'] = "Type";
$lang['amount'] = "Amount";

$lang['cancel_close'] = "Cancel & Close";

$lang['upload_select_file'] = "Select file";
$lang['upload_change'] = "Change";
$lang['upload_remove'] = "Remove";

$lang['close_window'] = "Close Window";
$lang['update_details'] = "Update Details";

$lang['notes'] = "Notes";

$lang['error'] = "Error";
$lang['success'] = "Success";


/* /views/shared/header.php */
$lang['html_title'] = "Innvoice";
$lang['toggle_navigation'] = "Toggle navigation";
$lang['create_new_invoice_for'] = "Create New Invoice For... ";
$lang['add_client'] = "Add Client";
$lang['account_functions'] = "Account Functions";
$lang['my_account_and_company'] = "My Account & Company";
$lang['api_keys'] = "API Keys";
$lang['application_settings'] = "Application Settings";
$lang['help_documentation'] = "Help / Documentation";
$lang['logout'] = "Logout";

$lang['dashboard'] = "Dashboard";
$lang['invoices'] = "Invoices";
$lang['clients'] = "Clients";
$lang['reports'] = "Reports";
$lang['documentation'] = "Documentation";
$lang['logout'] = "Logout";


/* /views/dashboard.php */
$lang['show_amounts_in'] = "Show amounts in";
$lang['total_paid'] = "Total Paid";
$lang['total_due'] = "Total Due";
$lang['total_past_due'] = "Total Past Due";
$lang['yearly_overview'] = "Yearly Overview";
$lang['client_overview'] = "Client Overview";

$lang['welcome_heading'] = "Well, hello there!";
$lang['welcome_message'] = '<p>
					It appears you have only just started using Innvoice; wonderful! The first thing I would do, is <a href="#modal_newClient" data-toggle="modal">adding one or more clients</a>. Once you have one or more clients, you can then start creating and sending out invoices.
				</p>
				<p>
					If you need some guidance at any point, just click the Documentation icon in the left menu.
				</p>';


/* /views/invoices.php */
$lang['invoices_for'] = "invoices for";
				
$lang['all_clients'] = "All Clients";
$lang['filter_by_client'] = "Filter by client";
$lang['filter_by_type'] = "Filter by type";

$lang['show_filter_panel'] = "Show Filter Panel";
$lang['hide_filter_panel'] = "Hide Filter Panel";

$lang['no_invoices_heading'] = "No invoices :(";
$lang['no_invoices_message'] = 'There are currently no invoices to list here. To create a new invoice, firts make sure you have one or more clients added. Next, click the green button labeled "Create invoice for..." from the top navigation bar.';

$lang['edit_invoice'] = "Edit Invoice";
$lang['payments'] = "Payments";
$lang['send_to_client'] = "Send to Client";
$lang['download_pdf'] = "Download PDF";
$lang['delete_invoice'] = "Delete Invoice";
$lang['save_invoice'] = "Save Invoice (!)";
$lang['no_changes_to_save'] = "No Changes To Save";
$lang['saving_invoice'] = "Saving Invoice...";

$lang['invoice_details'] = "Invoice Details";
$lang['financial'] = "Financial";
$lang['tax'] = "Tax";

$lang['invoice_title'] = "Invoice Title";
$lang['client'] = "Client";
$lang['invoice_number'] = "Invoice Number";
$lang['invoice_number_error'] = "Please provide an invoice number";
$lang['po_number'] = "PO Number";
$lang['issue_date'] = "Issue Date";
$lang['issue_date_error'] = "Please select an issue date";
$lang['visible_to_client'] = "Visible to client?";
$lang['public_url'] = "Public URL";
$lang['recurring_invoice'] = "Recurring Invoice";
$lang['recurring_1_month'] = "Yes, repeat every month";
$lang['recurring_3_months'] = "Yes, repeat every 3 months";
$lang['recurring_6_months'] = "Yes, repeat every 6 months";
$lang['recurring_1_year'] = "Yes, repeat every 12 months";

$lang['due_date'] = "Due date";
$lang['paid?'] = "Paid";
$lang['discount_in_perc'] = "Discount (in %)";
$lang['allow_bank_payment'] = "Allow bank payment?";
$lang['allow_credit_card'] = "Allow Credit Card (Stripe) payment?";
$lang['allow_paypal'] = "Allow Paypal payment?";

$lang['tax_type'] = "Tax Type";
$lang['tax_perc'] = "Tax %";

$lang['top_note'] = "Top Note";
$lang['top_note_placeholder'] = "This note will appear above your invoice item table";
$lang['bottom_note'] = "Bottom Note";
$lang['bottom_note_placeholder'] = "This note will appear below your invoice item table";
$lang['internal_notes'] = "Internal Notes";
$lang['internal_notes_placeholder'] = "Notes for internal use only";

$lang['message_no_payments'] = "<p>This invoice does not have any payments.</p>";
$lang['payment_proof'] = "Payment proof";
$lang['invoice_total_paid'] = "total paid";
$lang['add_payment'] = "Add Payment";

$lang['invoice_to'] = "TO";
$lang['invoice_number'] = "Invoice Number";
$lang['invoice_po'] = "PO";
$lang['edit_structure'] = "Edit Structure";
$lang['import_data_csv'] = "Import Data (.csv)";
$lang['add_single_item'] = "Add Single Item";
$lang['invoice_subtotal'] = "Sub Total";
$lang['invoice_discount'] = "Discount";
$lang['invoice_tax'] = "Tax";
$lang['invoice_total_amount'] = "Total Amount";
$lang['invoice_paid_to_date'] = "Paid to Date";
$lang['invoice_balance'] = "Balance";
$lang['refresh_totals'] = "Refresh Totals";
$lang['invoice_payment_due_before'] = "Payment due before";
$lang['invoice_pyament_due_on_receipt'] = "Due on receipt";

$lang['alert_lastfieldnumer'] = "Please make sure the last field contains a number!";
$lang['confirm_deleterow'] = "Are you sure you want delete this row?";
$lang['confirm_deletepayment'] = "Are you sure you want delete this payment?";


/* import data modal */
$lang['modal_import_data'] = "Import Data";
$lang['modal_import_data_message'] = '<p>Your CSV file should contain at least <b>three rows of text</b>. If your files contains less then three rows, the data import could possibly fail.</p>
							<p>The first row of your CSV file is expected to contain the column names!</p>
							<p>Importing data will <b>override all item data</b> currently on this invoice</p>';

/* delete invoice modal */
$lang['modal_delete_invoice'] = "Delete Invoice";
$lang['modal_delete_invoice_message'] = '<p>Are you sure you want to delete this invoice? Deleting this invoice will result in:</p>
						<ul>
							<li>All payments made for this invoice being deleted as well</li>
							<li>Clients no longer being able to access this invoice online</li>
						</ul>';
$lang['modal_delete_invoice_confirm'] = "Go ahead, delete invoice";

/* send by email modal */
$lang['modal_send_invoice_by_email'] = "Send invoice by emai";
$lang['modal_email_address'] = "Email address";
$lang['modal_email_address_error'] = "Please provide a valid email address";
$lang['modal_email_subject'] = "Email subject";
$lang['modal_email_subject_error'] = "Please provide a subject for your email";
$lang['modal_email_content'] = "Email content";
$lang['modal_email_content_error'] = "Please provide content for your email";
$lang['modal_sent_cc_to'] = "Send a CC to";
$lang['modal_attachment_message'] = "The invoice will be send as a PDF attachment.";
$lang['modal_send_to'] = "Send to";


/* /views/shared/modal_changeitemstructure.php */
$lang['alter_items_table_structure'] = "Alter Items Table Structure";
$lang['change_item_structure_message'] = "<p>Changing the item structure will result in current items being deleted.</p>";
$lang['add_new_column'] = "Add New Column";
$lang['update_items_table'] = "Update Items Table";


/* /views/shared/modal_additem.php */
$lang['add_item_to_invoice'] = "Add Item To Invoice";


/* /views/shared/modal_edititem.php */
$lang['edit_invoice_item'] = "Edit Invoice Item";
$lang['update_item'] = "Update Item";


/* /modal_addpayment.php */
$lang['add_payment'] = "Add Payment";
$lang['amount_placeholder'] = "Amount (without currency symbol)";
$lang['amount_error'] = "Please enter the amount without currency symbol";
$lang['payment_date_error'] = "Please enter a payment date";


/* /views/shared/modal_editpayment.php */
$lang['heading_edit_payemnt'] = "Edit Payment";
$lang['update_payment'] = "Update Payment";


/* /views/shared/modal_account.php */
$lang['account_and_company_details'] = "My Account & Company Details";
$lang['tab_company_and_personal_details'] = "My Company & Personal Details";
$lang['tab_my_account'] = "My Account";
$lang['first_name_label'] = "First name";
$lang['first_name_placeholder'] = "First name";
$lang['first_name_error'] = "Please enter your first name";
$lang['last_name_label'] = "Last name";
$lang['last_name_placeholder'] = "Last name";
$lang['last_name_error'] = "Please enter your last name";
$lang['company_name_label'] = "Company name";
$lang['company_name_placeholder'] = "Company name";
$lang['company_name_error'] = "Please enter your company name";
$lang['company_logo_label'] = "Company logo";
$lang['company_logo_delete'] = "Delete logo";
$lang['upload_logo_label'] = "Upload logo";
$lang['upload_message'] = "Uploaded logos will automatically be scaled to a width of <b>200px</b>. Uploading a new logo will automatically overwrite the current one (if any).";
$lang['company_phone_label'] = "Company phone";
$lang['company_phone_placeholder'] = "Company phone";
$lang['company_tax_label'] = "Company fax";
$lang['company_tax_placeholder'] = "Company fax";
$lang['company_address_label'] = "Company address";
$lang['company_address_placeholder'] = "Company address";
$lang['additional_info_label'] = "Additional Info (will appear beneath the address on an invoice)";
$lang['additional_info_placeholder'] = "Additional company info";

$lang['username_label'] = "User name / email";
$lang['username_placeholder'] = "Email address";
$lang['username_error'] = "This field must contain a valid email address";
$lang['password_label'] = "Password";
$lang['password_placeholder'] = "Your new passport";
$lang['password_error'] = "Please enter a new password";
$lang['password_re_label'] = "Re-type password";
$lang['password_re_placeholder'] = "Re-type new password";
$lang['password_re_error'] = "password_re_placeholder";

$lang['save_account_details'] = "Save Account Details";


/* /views/shared/modal_apikey.php */
$lang['headding_api_keys'] = "API Keys";
$lang['no_keys_heading'] = "No API Keys";
$lang['no_keys_message'] = "<p>There are currently no generated API keys. Please click the button below to create your first key.</p>";
$lang['create_new_key'] = "Create New Key";


/* /views/shared/modal_newclient.php */
$lang['heading_add_new_client'] = "Add New Client";
$lang['client_name_label'] = "Client Name";
$lang['client_name_placeholder'] = "Client name goes here";
$lang['client_name_error'] = "lease enter a name for the new client";
$lang['client_contact_label'] = "Client contact";
$lang['client_contact_placeholder'] = "Client contact goes here (name of contact person)";
$lang['client_email_label'] = "Client Email";
$lang['client_email_placeholder'] = "Client email address goes here";
$lang['client_email_error'] = "Please provide a valid email address for your new client";
$lang['client_phone_label'] = "Client Phone";
$lang['client_placeholder'] = "Client phone number goes here";
$lang['client_fax_label'] = "Client Fax";
$lang['client_fax_placehoder'] = "Client fax number goes here";
$lang['client_default_currency_label'] = "Default Currency";
$lang['client_website_label'] = "Client Website";
$lang['client_website_placeholder'] = "Client website address goes here";
$lang['client_address_label'] = "Client Address";
$lang['client_address_placeholder'] = "Client address goes here";
$lang['client_additionalinfo_label'] = "Additional info";
$lang['client_additionalinfo_placeholder'] = "Additional info (appears below the address)";
$lang['create_new_client'] = "Create New Client";


/* /views/clients.php */
$lang['tooltip_totalpaid'] = "Total paid to date";
$lang['tooltip_totaldue'] = "Total due to date";
$lang['tooltip_totalpastdue'] = "Total past due to date";

$lang['tab_overview'] = "Overview";
$lang['tab_details'] = "Details";
$lang['tab_invoices'] = "Invoices";
$lang['tab_payments'] = "Payments";
$lang['tab_notes'] = "Notes";
$lang['delete_client'] = "Delete Client";
$lang['default_currency_message'] = "Only payments in the default currency for this client are shown in the table below. If you wish to list payments in a different currency, please change the default currency for this client. The default currency is set to";
$lang['confirm_delete_client'] = "Are you sure you want to do this? Removing this client will result in ALL connecting invoices and payments being deleted from the system. Continue?";

$lang['no_clients_heading'] = "No clients :(";
$lang['no_clients_message'] = 'There are currently no clients to list here. You can add clients by clicking the green button labeled "Add Client" in the top navigation bar.';


/* /views/reports.php */
$lang['create_new_report'] = "Create New Report";
$lang['report_created_on'] = "Created on";
$lang['report_clients'] = "Clients";
$lang['report_from'] = "From";
$lang['report_currency'] = "Currency";
$lang['report_to'] = "To";
$lang['report_included'] = "Included";

$lang['no_reports_heading'] = "No reports :(";
$lang['no_reports_message'] = 'There are currently no reports to list here. To generate a report, click the button labeled "Create New Report".';

$lang['invoice_date'] = "Invoice Date";
$lang['invoice_status'] = "Invoice Status";
$lang['invoice_paid'] = "Paid";


/* /views/settings.php */
$lang['heading_invoice_counter'] = "Internal invoice counter";
$lang['text_invoice_counter'] = "This counter keeps track of the issued invoice numbers. You can use the counter below to manually change the internal counter. Please keep in mind that the next invoice number will be tha vavlue of this counter <b>PLUS ONE</b>. So if the counter currently reads 25, the invoice number for the next invoice will be 26.";
$lang['heading_currency_placement'] = "Currency placement";
$lang['text_currency_placement'] = "With this setting, you can control wether the currency sybmol appears before or after the amount.";
$lang['label_before_amount'] = "Before amount (for example: $10.00)";
$lang['label_after_amount'] = "After amount (for example: 10.00$)";
$lang['heading_payment_stripe'] = "Payment integration: Stripe";
$lang['text_payment_stripe'] = "Integrating Stripe payment requires both a public key and a secret key (log into your Stripe account, click 'Account Settings' and retrieve your keys under 'API Keuys').";
$lang['stripe_public_key'] = "Sercret key:";
$lang['stripe_private_key'] = "Public key:";
$lang['heading_payment_paypal'] = "Payment integration: Paypal";
$lang['text_payment_paypal'] = "Integrating Paypal requires you to provide the main email address used to setup your Paypal account.";
$lang['paypal_email'] = "Paypal email:";
$lang['heading_api'] = "API";
$lang['text_api'] = "You choose to either activate or de-activate the API.";
$lang['heading_save_changes'] = "Save changes";
$lang['button_save_changes'] = "Save Settings";


/* modal create report */
$lang['heading_create_report'] = "Create Report";
$lang['report_title_label'] = "Report Title";
$lang['report_title_default_value'] = "My Report";
$lang['report_title_error'] = "Please provide a report tile";
$lang['for_clients_label'] = "For Client(s)";
$lang['status_label'] = "Status";
$lang['date_from_label'] = "Date From";
$lang['date_from_error'] = "Please select a date";
$lang['date_to_label'] = "Date To";
$lang['date_to_error'] = "Please select a date";
$lang['build_report'] = "Build Report";


/* /views/auth/login.php */
$lang['login_html_title'] = "Innvoice login";
$lang['tab_login'] = "Login";
$lang['tab_forgot_password'] = "Forgot Password";
$lang['log_into_innvoice'] = "Log into Innvoicer";
$lang['email_placeholder'] = "Your email address";
$lang['password_placeholder'] = "Your password";
$lang['remind_me_label'] = "Remind me";
$lang['button_login'] = "Login";
$lang['forgot_your_password'] = "Forgot your password?";
$lang['retrieve_password'] = "Retrieve Password";


/* /views/partials/invoice_pdf.php */
$lang['pdf_invoice_to'] = "TO";
$lang['pdf_invoice_number'] = "Invoice Number";
$lang['pdf_invoice_po'] = "PO";
$lang['pdf_invoice_subtotal'] = "Sub Total";
$lang['pdf_invoice_discount'] = "Discount";
$lang['pdf_invoice_tax'] = "Tax";
$lang['pdf_invoice_total_amount'] = "Total Amount";
$lang['pdf_invoice_paid_to_date'] = "Paid to Date";
$lang['pdf_invoice_balance'] = "Balance";
$lang['pdf_invoice_due_before'] = "Payment due before";


/* /views/partials/invoice_public.pdf */
$lang['button_pay_invoice'] = "Pay Invoice";
$lang['button_download_pdf'] = "Download PDF";
$lang['public_invoice_to'] = "TO";
$lang['public_invoice_number'] = "Invoice Number";
$lang['public_invoice_subtotal'] = "Sub Total";
$lang['public_invoice_discount'] = "Discount";
$lang['public_invoice_tax'] = "Tax";
$lang['public_invoice_total_amount'] = "Total Amount";
$lang['public_invoice_paid_to_date'] = "Paid to Date";
$lang['public_invoice_balance'] = "Balance";
$lang['public_invoice_due_before'] = "Payment due before";
$lang['pay_invoice'] = "Pay Invoice";
$lang['tab_bank_transfer'] = "Bank Transfer";
$lang['tab_credit_card'] = "Credit Card";
$lang['tab_paypal'] = "Paypal";
$lang['payment_amount_label'] = "Payment amount";
$lang['payment_amount_error'] = "Please enter a valid amount";
$lang['upload_slip_message'] = "Use the field below to upload a transfer slip or receipt to proof the transfer has been made.";
$lang['button_submit_payment'] = "Submit payment";
$lang['credit_card_heading'] = "Pay with Credit Card";
$lang['credit_card_message'] = "<p>Click the button below to pay this invoice with your credit card</p>";
$lang['button_pay_with_cc'] = "Pay with Credit Card";
$lang['paypal_heading'] = "Pay with Paypal";
$lang['paypal_message'] = "Please note that in order to pay this invoice with Paypal. we will need to direct to you the Paypal web site to complete the transaction.";
$lang['button_pay_with_paypal'] = "Pay with Paypal";
$lang['verifying_payment'] = "Verifying payment, please wait...";


/* /views/partials/report_pdf.php */
$lang['pdf_report_created_on'] = "Created on";
$lang['pdf_report_clients'] = "Clients";
$lang['pdf_report_from'] = "From";
$lang['pdf_report_to'] = "To";
$lang['pdf_report_currency'] = "Currency";
$lang['pdf_report_included'] = "Included";
$lang['totals'] = "Totals";


/* /controllers/clients.php */
$lang['clients_get_error1'] = "Client does not exist. Please try again.";
$lang['clients_update_error1'] = "The client data could not be saved. Please reload the page and try again.";
$lang['clients_update_error2'] = "Something went wrong when submitting your data, please see the errors below:<br>";
$lang['clients_update_success1'] = "The client data was updated successfully.";
$lang['clients_create_error1'] = "<p>The new client could not be created, please see the errors below.<br></p>";
$lang['clients_create_success1'] = "<p>The new client was created successfully!<br></p>";
$lang['clients_delete_error1'] = "<p>It appears the client you're trying to delete does not exist.</p>";
$lang['clients_delete_success1'] = "<p>The client including all connected invoices and payments were deleted.</p>";


/* /controllers/invoices.php */
$lang['invoices_get_error1'] = "Invoice does not exist. Please try again.";
$lang['invoices_getPDF_error1'] = "Invoice does not exist. Please try again.";
$lang['invoices_create_error1'] = "Your invoice could not be created. Please reload the page and try creating the invoice again.";
$lang['invoices_create_success'] = "Your invoice was successfully created; you can start editing the invoice below";
$lang['invoices_update_error1'] = "<p>Wrong or missing invoice ID. Please reload the page and try again.</p>";
$lang['invoices_update_erorr2'] = "<p>Something went wrong with the submitted data, we could not save the invoice. Please see the errors below and try submitting the data again.</p><br>";
$lang['invoices_update_success1'] = "<p>Your invoice was updated successfully; all is well!</p>";
$lang['invoices_uploadData_error1'] = "<p>Your data could not be successfully processed. Please double check your data and make sure the last column contains only numeric values.</p>";
$lang['invoices_uploadData_success1'] = "<p>Your data was imported successfully.</p>";
$lang['invoices_uploadData_error2'] = "<p>Something went wrong when trying to upload your file, please see the errors below.<br></p>";
$lang['invoices_delete_error1'] = "<p>Wrong or missing invoice ID. Please reload the page and try again.</p>";
$lang['invoices_delete_success1'] = "<p>The invoice and connected payments were successfully removed from the application.</p>";
$lang['invoices_delete_error2'] = "<p>The invoice could not be deleted at this point. Please reload the page and try again.</p>";
$lang['invoice_id'] = "Invoice ID";
$lang['invoice_code'] = "Invoice Code";
$lang['client_id'] = "Client ID";
$lang['email_address'] = "Email address";
$lang['email_subject'] = "Email subject";
$lang['email_content'] = "Email content";
$lang['invoices_send_error1'] = "Something went wrong with the submitted data, please see the errors below.<br>";
$lang['invoices_send_error2'] = "You're not allowed to do this; bad boy!";
$lang['invoices_send_success1'] = "The invoice was successfully send by email to ";
$lang['invoices_send_error3'] = "Unfortunately, we could not send the invoice by email. This is most likely due to faulty settings in your email configuration file: /application/config/email.php";
$lang['invoices_addPayment_error1'] = "Something went wrong :( Please reload the page and try again.)";
$lang['invoices_addPayment_error2'] = "<p>Something went wrong with the submitted data, please see the issues below:<br></p>";
$lang['invoices_addPayment_success1'] = "<p>The payment was added succesfully.</p>";
$lang['invoices_addPayment_error3'] = "<p>Something went wrong with the submitted data, please see the issues below:<br></p>";
$lang['invoices_stripeProcess_success1'] = "<p>Your payment was processed successully. Please reload this page to see the updated details.</p>";
$lang['invoices_stripeProcess_error1'] = "<p>Unfortunately, your payment could not be processed right now. Please verify your payment details and try again.</p>";
$lang['invoices_stripeProcess_error2'] = "<p>Unfortunately, it appears the invoice you're tryig to pay does not exist :(</p>";


/* /controllers/reports.php */
$lang['reports_get_error1'] = "Report does not exist. Please try again.";
$lang['reports_get_error2'] = "<p>The report could not be created, please see the form errors below:<br></p>";
$lang['reports_get_success1'] = "<p>Your new report was successfully built.</p>";
$lang['reports_delete_error1'] = "<p>Wrong or missing report ID. Please reload the page and try again.</p>";
$lang['reports_delete_success1'] = "<p>The report was removed succesfully.</p>";
$lang['reports_getPDF_error1'] = "Report does not exist. Please try again.";


/* /controllers/settings.php */
$lang['paypal_email_address'] = "Paypal email address";
$lang['settings_update_error1'] = "Something went wrong when submitting your data, please see the errors below:<br>";
$lang['settings_update_success1'] = "The settings were updated successfully.";
$lang['settings_updateintegrations_error1'] = "<p>Something went wrong with the submitted data. Please see the errors below and try submitting the data again.</p><br>";
$lang['settings_updateintegrations_success1'] = "<p>Your settings was updated successfully; all is well!</p>";


/* /controllers/user.php */
$lang['user_updateaccount_error1'] = "<p>Wrong or faulty user ID. Please reload the page and try again.</p>";
$lang['new_password_label'] = "New password";
$lang['new_password_confirmation_label'] = "New password confirmation";
$lang['user_updateaccount_error2'] = "<p>Something went wrong when validating your data, please see the errors below:</p>";
$lang['user_updatedetails_error1'] = "<p>Wrong or faulty user ID. Please reload the page and try again.</p>";
$lang['user_updatedetails_error2'] = "<p>Something went wrong when validating your data, please see the errors below:</p>";
$lang['user_updatedetails_success1'] = "<p>Your info was updated successfully!</p>";


/* /views/shared/shared_javascript.php */
$lang['confirm_removeapikey'] = "Please note that once this key is removed, all API calls made with this key will no longer be valid";