var innvoice = (function(){
    
    var appUI = {
        
        /*
            variables
        */
        activeClient: 'all',
        paidActive: false,
        dueActive: true,
        pastdueActive: true,
        activeYear: '',
        originalButtonText: '',
        payments: [],
        allClients: '',
        alert_lastfieldnumer: '',
        confirm_deleterow: '',
        confirm_deletepayment: '',
        dateFormat: '',
        loadingState_save: '',
        site_url: '',
        currencies: {},
        confirm_removeapikey: '',
        
    
        setup: function(){
            
            /*
                event binding
            */
            
            //document wide events
            $( document ).on( "keydown", "[data-type]", appUI.inputNumbersOnly);
            
            //secondary navigation events
            $('.paneOneList li').on('click', 'a', appUI.menuTwoListToggle);
            
            //invoice items events
            $('#itemsTable')
                .on('mouseover', 'tr', appUI.itemsTableRowMouseIn)
                .on('mouseleave', 'tr', appUI.itemsTableRowMouseOut);
            $('#itemsTable').on('click', '.item_editRow', appUI.editItemsTableRow);
            $('#itemsTable').on('click', '.item_delRow', appUI.deleteItemsTableRow);
            $('#itemsTable')
                .on('mouseover', 'thead', appUI.itemsTableHeaderMouseIn)
                .on('mouseleave', 'thead', appUI.itemsTableHeaderMouseOut);
            $('#invoiceTable').on('click', '.items_editStructure, #button_editItemStructure', appUI.editItemsTableHeader);
            $('#button_addItemColumn').on('click', appUI.addItemsTableColumn);
            $('form#form_editColumns').on('click', '.button_delItemsColumn', appUI.deleteItemsTableColumn);
            $('#button_updateItemColumns').on('click', appUI.updateItemsTableStructure);
            $('#button_addInvoiceItem').on('click', appUI.addInvoiceItemModal);
            $('#button_addItemToInvoice').on('click', appUI.addInvoiceItem);
            $('#button_updateItem').on('click', appUI.updateInvoiceItem);
            
            //edit invoice events
            $('#field_currency').on('change', appUI.invoiceSetCurrency);
            $('#field_visible').on('change', appUI.invoiceVisibleToggle);
            $('#field_discount').on('change', appUI.invoiceDiscountToggle);
            $('#field_taxpercentage').on('change', appUI.invoiceTaxToggle);
            $('#field_ponumber').on('change', appUI.invoicePoToggle);
            $('#field_client').on('change', appUI.invoiceChangeClient);
            $('#button_refreshTotals').on('click', appUI.invoiceUpdateAmounts);
            $('.invoiceSlidePanel').on('click', appUI.invoiceSlidePanel);
            $('#button_saveInvoice').on('click', appUI.saveInvoice);
            $('#button_deleteInvoice').on('click', appUI.deleteInvoicePrep);
            $('form#form_dataImport').validator().on('submit', appUI.invoiceDataImport);
            //$('#field_recurring').on('change', appUI.toggleVisibleUrl);
            $('select#field_paid').on('change', appUI.togglePaid);
            
            //payment events
            $('#button_addPayment').on('click', appUI.paymentModal);
            $('form#form_addPayment').validator().on('submit', appUI.addPayemntFormSubmit);
            $('#table_payments')
                .on('mouseover', 'tr', appUI.paymentTableRowMouseIn)
                .on('mouseleave', 'tr', appUI.paymentTableRowMouseOut);
            $('#table_payments').on('click', '.payment_editRow', appUI.editPayment);
            $('form#form_editPayment').validator().on('submit', appUI.editPaymentFormSubmit);
            $('#table_payments').on('click', '.payment_delRow', appUI.removePayment);
            
            //invoice filter events
            $('#filters button:not(#filter_all)').on('click', appUI.invoiceFilterButtons);
            $('.clientFilter a').on('click', appUI.invoiceFilterClientAnchor);
            $('.yearFilter a').on('click', appUI.invoiceFilterYearAnchor);
            $('#filter_all').on('click', appUI.invoiceFilterAll);
            
            //account / details events
            $('form#form_account').validator().on('submit', appUI.accountFormSubmit);
            $('form#form_details').validator().on('submit', appUI.detailsFormSubmit);
            $('#button_deleteLogo').on('click', appUI.accountDeleteLogo);
            
            //API key events
            $('#button_createApiKey').on('click', appUI.addApiKey);
            $('#keys').on('click', '.delAPIKey', appUI.removeApiKey);
                        
            var d = new Date();            
            appUI.activeYear = d.getFullYear();
            
            //pretty dropdowns
            //$("select:not(.regular)").select2({dropdownCssClass: 'dropdown-inverse'});
            
            //chosen dropdowns
            if( $('select.chosen').size() > 0 ) {
                
                var opts = {};
                opts["width"] = '100%';
                opts["placeholder_text_single"] = "Choose a currency";
                
                $(".chosen").chosen(opts);
            
            }
                        
        },
        
        /*
            makes sure only numbers can be input into this field
        */
        inputNumbersOnly: function(e){
                        
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: Ctrl+C
                (e.keyCode == 67 && e.ctrlKey === true) ||
                // Allow: Ctrl+X
                (e.keyCode == 88 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
            
        },
        
        /*
            "active" class toggle on second menu LI's
        */
        menuTwoListToggle: function(){
            
            $('#invoiceList li').removeClass('active');
            $(this).closest('li').addClass('active');
            
        },
        
        /*
            append some action buttons/icons when hovering over an items table row
        */
        itemsTableRowMouseIn: function(){
            
            var toAppend = $('#itemRowButtons').clone().attr('id', '');
                
            if( $(this).find('td:last .itemRowButtons').size() == 0 ) {
		          
                $(this).find('td:last').append( toAppend );
			     
            }
            
        },
        
        /*
            remove some action buttons/icons when hovering over an items table row
        */
        itemsTableRowMouseOut: function(){
        
            $(this).find('td:last .itemRowButtons').remove();
            
        },
        
        /*
            prepares and launches the edit items table row data modal
        */
        editItemsTableRow: function(e){
        
            e.preventDefault();
            
            $('form#form_editItem > *').remove();
            
            var theRow = $(this).closest('tr');
            
            $('#button_updateItem').attr('data-rowindex', theRow.index())
		      
            var counter = 0;
            
            $('table#itemsTable thead th').each(function(){
                
                newFormGroup = $('#addItemInput').clone().attr('id', '');  
                newFormGroup.find('label').text( $(this).text() );
                
                theRow.find('td:eq('+counter+')').find('div:first').remove();
                
                newFormGroup.find('textarea').val( theRow.find('td:eq('+counter+')').text() );
                
                $('form#form_editItem').append( newFormGroup );
                
                counter++;
			
            });
            
            $('#modal_editItem').modal('show');
            
        },
        
        /*
            deletes an items table row and its data
        */
        deleteItemsTableRow: function(e){
            
            e.preventDefault();
            
            var theTR = $(this).closest('tr');
            
            if( confirm( appUI.confirm_deleterow ) ) {
                
                theTR.remove();
                appUI.updateInvoiceAmounts();
                appUI.changesToSave(true);
            
            }
            
        },
        
        /*
            appends some action buttons/icons when hovering over the items table header
        */
        itemsTableHeaderMouseIn: function(){
        
            var toAppend = $('#itemColButtons').clone().attr('id', '');
		  
            if( $(this).find('th:last .itemColButtons').size() == 0 ) {
		
                $(this).find('th:last').append( toAppend );
			
            }
            
        },
        
        /*
            removes action buttons/icons when hovering away from the items table header
        */
        itemsTableHeaderMouseOut: function(){
            
            $(this).find('th:last .itemColButtons').remove();
        
        },
        
        /*
            prepares and launches the edit items table header modal
        */
        editItemsTableHeader: function(e){
            
            e.preventDefault();
            
            //prepare stuff
            
            $('#modal_changeItemsStructure #form_editColumns > *').each(function(){
                
                $(this).remove();
			
            });

            var counter = 1;
		  
            $('table#invoiceTable').find('th').each(function(){
			
                $(this).find('div').remove();
			
                newFormGroup = $('#itemColumnInput').clone().attr('id', '');
                newFormGroup.find('label').text('Column '+counter);
                newFormGroup.find('input').val( $(this).text() )
			
                $('#modal_changeItemsStructure #form_editColumns').append( newFormGroup );
                
                counter++;
			
            });
            
            //remove the "delete" icon off the 
            
            $('#modal_changeItemsStructure').modal('show');
            
        },
        
        /*
            adds a new additional column into the items table structure
        */
        addItemsTableColumn: function(){
        
            var newFormGroup = $('#itemColumnInput').clone().attr('id', '');
            newFormGroup.find('label').text('Column '+($('#form_editColumns > *').size()+1));
            
            $('#modal_changeItemsStructure #form_editColumns').append( newFormGroup );
            
        },
        
        /*
            deletes a column from the items table structure
        */
        deleteItemsTableColumn: function(){
        
            if( confirm('Are you sure you want to delete this column?') ) {
			
                $(this).closest('.form-group').remove();
                
                appUI.updateItemColInputs();
                
                appUI.changesToSave(true);
            
            };
            
        },
        
        /*
            updates the items table structure, using data from the items table structure modal
        */
        updateItemsTableStructure: function(){
        
            if( $('form#form_editColumns > *').size() > 0 ) {
                
                //rebuild items table
                
                $('table#itemsTable tbody > *').remove();
                
                $('table#itemsTable thead th').remove();
                
                $('form#form_editColumns > *').each(function(){
                    
                    newTH = $('<th>'+$(this).find('input').val()+'</th>');
                    
                    $('table#itemsTable thead tr:first').append( newTH );
                
                });
                
                $('table#itemsTable thead tr:first th:last').css('width', '100px');
                
                $('#modal_changeItemsStructure').modal('hide');
			 
                appUI.changesToSave(true);
            
            };
                
        },
        
        /*
            updates the column field numbers when a column is added or deleted
        */
        updateItemColInputs: function(){
            
            var counter = 1;
            
            $('#modal_changeItemsStructure #form_editColumns > *').each(function(){
                
                $(this).find('label').text('Column '+counter);
                
                counter++;
            
            });
            
        },
        
        /*
            dynamically generates the form and loads the modal
        */
        addInvoiceItemModal: function(){
            
            //dynamically generate the new item form, delete old items first
            
            $('form#form_addItem > *').remove();
		
            $('table#itemsTable thead th').each(function(){
			
                var newFormGroup = $('#addItemInput').clone().attr('id', '');
                newFormGroup.find('label').text( $(this).text() );
			
                $('form#form_addItem').append( newFormGroup );
			
            })
		
            $('#modal_addItem').modal('show');
                
        },
        
        /*
            takes the new item form data and adds it into a new table row and inserts it into the items table
        */
        addInvoiceItem: function(){
            
            //add row to the table; make sure there's a value in the last field though
                        
            if( $('form#form_addItem > *:last').find('textarea').val() != '' && !isNaN( $('form#form_addItem > *:last').find('textarea').val() ) ) {
                
                var newRow = $('<tr></tr>');
                var nrOfTds = $('table#itemsTable thead th').size();
                
                for(x=1; x<=nrOfTds; x++) {
                    
                    var newTd = $('<td></td>');
                    
                    newRow.append( newTd );
                
                }
				
                newRow.find('td').each(function(){
			
                    $(this).text( $('form#form_addItem > *:eq('+$(this).index()+')').find('textarea').val() );
				
                });
		
                $('#itemsTable tbody').append( newRow );
                
                $('#modal_addItem').modal('hide');
		
                appUI.updateInvoiceAmounts();
		
                appUI.changesToSave(true);
		
            } else {
			
                alert( appUI.alert_lastfieldnumer );
			 
            }
            
        },
        
        /*
            updates an invoice item
        */
        updateInvoiceItem: function(){
            
            var rowIndex = $(this).attr('data-rowindex');

            $('form#form_editItem > *').each(function(){
			
                $('#itemsTable tbody tr:eq('+rowIndex+') td:eq('+$(this).index()+')').text( $(this).find('textarea').val() )
			
            });
		
            $('#modal_editItem').modal('hide');
		
            //update amounts
            appUI.updateInvoiceAmounts();
		
            appUI.changesToSave(true);
            
        },
        
        /*
            alters the invoice's currency setting
        */
        invoiceSetCurrency: function(){
                                    
            invoice.invoice_currenySymbol.change(appUI.currencies[$(this).val()]);
            invoice.invoice_currenyName.change( $(this).val() );
            
        },
        
        /*
            toggles the URL display field when the visible option changes
        */
        invoiceVisibleToggle: function(){
            
            if( $(this).val() == 1 ) {
			
                $(this).closest('.form-group').next().show();
			
            } else if( $(this).val() == 0 ) {
			
                $(this).closest('.form-group').next().hide();
			
            }
            
        },
        
        /*
            toggles the discount row, depending on wether or not a discount is set
        */
        invoiceDiscountToggle: function(){
        
            if( $(this).val() > 0 ) {
			
                $('#row_invoiceDiscount').show();
			
            } else {
			
                $('#row_invoiceDiscount').hide();
			
            }
                
        },
        
        /*
            toggles the TAX line on the invoice dpending on wether a TAX has been defined
        */
        invoiceTaxToggle: function(){
        
            if( $(this).val() > 0 ) {
			
                $('#row_invoiceTax').show();
			
            } else {
			
                $('#row_invoiceTax').hide();
			
            }        
        
        },
        
        /*
            toggle the PO line on the invoice depending on wether or not a PO has been defined
        */
        invoicePoToggle: function(){
        
            if( $(this).val() == '' ) {
			
                $('#div_invoicePo').hide();
			
            } else {
			
                $('#div_invoicePo').show();
			
            }
            
        },
        
        /*
            changes the invoice's client
        */
        invoiceChangeClient: function(){
                    
            var clientID = $(this).val();
		
            for( x=0; x<appUI.allClients.length; x++ ) {
						
                if( appUI.allClients[x]['client_id'] == clientID ) {
                    
                    invoice.invoice_clientName.change(appUI.allClients[x]['client_name']);
                    invoice.invoice_clientAddress.change(appUI.allClients[x]['client_address'].replace(/(?:\r\n|\r|\n)/g, '<br />'));
				
                    break;
                }
			}
                
        },
        
        /*
            updates the totals in the bottom of the invoice
        */
        invoiceUpdateAmounts: function(){
            
            appUI.updateInvoiceAmounts();
		  
            appUI.changesToSave(true);
        
        },
        
        /*
            toggles the edit invoice panels
        */
        invoiceSlidePanel: function(){
        
            if( $(this).hasClass('active') ) {
			
                $(this).removeClass('active');
                $('#'+$(this).attr('data-target')).slideUp(500);
			
            } else {
                
                //hide all
                $(this).closest('nav').next().find('.invoicePanel').hide();
                $('.invoiceSlidePanel').removeClass('active');
			
                $(this).addClass('active');
                $('#'+$(this).attr('data-target')).slideDown(500);
			
            }
                
        },
        
        /*
            strips trailing "/" from URL
        */
        stripTrailingSlash: function (str) {
            
            if(str.substr(-1) === '/') {
                return str.substr(0, str.length - 1);
            }
            return str
        },
        
        /*
            sves an invoice to the server
        */
        saveInvoice: function(){
            
            $('#button_saveInvoice').addClass('disabled').find('.buttonText').text( $('#button_saveInvoice').attr('data-textsaving') );
		
            //remove old alerts
            $('.paneTwo .alert').fadeOut(100, function(){
			
                $(this).remove();
			
            })
		
            //get the items table head
            invoice.invoice_items_head.change($('table#itemsTable thead').html());
		
            //get the items table body
            invoice.invoice_items_body.change($('table#itemsTable tbody').html());
		
            var theData = invoice.getAll();
            
            console.log(theData);
                        
            //prep payment data
		
            if( appUI.payments.length > 0 ) {
						
                theData['payments'] = JSON.stringify(appUI.payments);
						
            }
            		                
            $.ajax({
                url: appUI.stripTrailingSlash(appUI.site_url)+"/invoices/update/"+$(this).attr('data-invoiceid'),
                method: "post",
                dataType: 'json',
                data: theData
            }).done(function(ret){
			
                $('#button_saveInvoice').removeClass('disabled').find('.buttonText').text( $('#button_saveInvoice').attr('data-textsave') );
			
                $('#button_saveInvoice').closest('.paneTwo').prepend( $(ret.content) )
			
                if( ret.code == 1 ) {
								
                    setTimeout(function(){$('.paneTwo > .alert').fadeOut(1000, function(){$(this).remove()})}, 5000);
				
                    appUI.changesToSave(false);	
				
                }
			
            })
            
        },
        
        /*
            launches the add payment modal
        */
        paymentModal: function(){
            
            $('#modal_addPayment').modal('show');
            
            $('#modal_addPayment select').select2();
            
        },
        
        /*
            event handler for the submission of the add payment form
        */
        addPayemntFormSubmit: function(e){
        
            if( !e.isDefaultPrevented()) {
                
                var newPaymentRow = $('<tr></tr>');

                newPaymentRow.append( $('<td data-property="date">'+$('form#form_addPayment #field_paymentDate').val()+'</td>') )
		
                newPaymentRow.append( $('<td data-property="type" data-type-id="'+$('form#form_addPayment #field_paymentType').val()+'">'+$('form#form_addPayment #field_paymentType option:selected').text()+'</td>') )
		
                newPaymentRow.append( $('<td data-property="amount">'+$('form#form_addPayment #field_paymentAmount').val()+'</td>') )
		
                $('table#table_payments tbody').append( newPaymentRow );
		
                $('#modal_addPayment').modal( 'hide' );
		
                appUI.updatePayments();
                
                appUI.checkDue();
		
                appUI.changesToSave(true);
			
                //hide alert
                $('.invoicePanel .alert').fadeOut(500, function(){$(this).remove()});
			
                //grab payment data for saving later
			
                var newPayment = {date: $('form#form_addPayment #field_paymentDate').val(), type: $('form#form_addPayment #field_paymentType').val(), amount: $('form#form_addPayment #field_paymentAmount').val()};
			
                appUI.payments.push(newPayment);
						
            }
		
            return false;
                
        },
        
        /*
            appends action icons/buttons when hovering over a row in the payments table
        */
        paymentTableRowMouseIn: function(){
            
            var toAppend = $('#paymentRowButtons').clone().attr('id', '');
		
            if( $(this).find('td:last .paymentRowButtons').size() == 0 ) {
		
                $(this).find('td:last').append( toAppend )
			
            }
            
        },
        
        /*
            removes the action icons/buttons when 
        */
        paymentTableRowMouseOut: function(){
        
            $(this).find('td:last .paymentRowButtons').remove();
                
        },
        
        /*
            populates the edit payment form and launches the edit payment modal
        */
        editPayment: function(e){
            
            e.preventDefault();
		
            var theRow = $(this).closest('tr');
				
            //populate the form
				
            $('#form_editPayment #field_updatePaymentDate').val( theRow.find('td[data-property="date"]').text() ).datepicker( "refresh" )
		
            $('#form_editPayment #field_updatePaymentType').val( theRow.find('td[data-property="type"]').attr('data-type-id') ).trigger("change");
		
            theRow.find('td:last').find('div').remove();
		
            $('#form_editPayment #field_updatePaymentAmount').val( theRow.find('td[data-property="amount"]').text() );
		
            $('#form_editPayment').attr('data-rowindex', theRow.index() )
		
            $('#modal_editPayment').modal('show');
            
        },
        
        /*
            edit payment form submission handler
        */
        editPaymentFormSubmit: function(e){
            
            if( !e.isDefaultPrevented()) {
			
                $('#table_payments tbody tr:eq('+$(this).attr('data-rowindex')+') td[data-property="date"]').text( $('#field_updatePaymentDate').val() );
		
                $('#table_payments tbody tr:eq('+$(this).attr('data-rowindex')+') td[data-property="type"]').text( $('#field_updatePaymentType option:selected').text() );
                
                $('#table_payments tbody tr:eq('+$(this).attr('data-rowindex')+') td[data-property="type"]').attr('data-type-id', $('#field_updatePaymentType').val() )
                
                $('#table_payments tbody tr:eq('+$(this).attr('data-rowindex')+') td[data-property="amount"]').text( $('#field_updatePaymentAmount').val() );
		
                $('#modal_editPayment').modal('hide');
		
                appUI.updatePayments();
		
                appUI.changesToSave(true);
			

                //update payments array

                appUI.payments[$(this).attr('data-rowindex')].amount = $('#field_updatePaymentAmount').val();
                appUI.payments[$(this).attr('data-rowindex')].date = $('#field_updatePaymentDate').val();
                appUI.payments[$(this).attr('data-rowindex')].type = $('#field_updatePaymentType').val();
			
            } 

            return false;
                
        },
        
        /*
            deletes a payment from the payment table
        */
        removePayment: function(e){
            
            e.preventDefault();
				
            var theTR = $(this).closest('tr');
            var theIndex = theTR.index();
		
            if( confirm( appUI.confirm_deletepayment ) ) {
			
                theTR.remove();
			
                appUI.updatePayments();
			
                appUI.changesToSave(true);
						
                //remove from arary
                appUI.payments.splice(theIndex, 1);
			
                //make sure the invoice_paid is set to "No"
                $('#field_paid').val("No").trigger('change');
			
            }
            
        },
        
        /*
            event handler for the invoice filter buttons Due, Paid and Past Due
        */
        invoiceFilterButtons: function(){
        
            $(this).toggleClass('active');
		
            var tag = $(this).attr('data-filter');
				
            if( $(this).hasClass('active') ) {			
			
                if( tag == 'paid' ) {
				
                    appUI.paidActive = true;
				
                } else if( tag == 'due' ) {
				
                    appUI.dueActive = true;
				
                } else if( tag == 'past-due' ) {
				
                    appUI.pastdueActive = true;
				
                }
			
            } else {
						
                if( tag == 'paid' ) {
				
                    appUI.paidActive = false;
				
                } else if( tag == 'due' ) {
				
                    appUI.dueActive = false;
				
                } else if( tag == 'past-due' ) {
				
                    appUI.pastdueActive = false;
				
                }
			
            }
		
            appUI.doInvoiceFilter();
            
        },
        
        /*
            client filter anchor event handler
        */
        invoiceFilterClientAnchor: function(e){
        
            e.preventDefault();
		
            $(this).toggleClass('active');
		
            var tag = $(this).attr('data-filter');
		
            appUI.activeClient = tag;
		
            //make sure some type filters are active 
		
            if( !appUI.paidActive && !appUI.dueActive && !appUI.pastdueActive ) {
			
                appUI.paidActive = true;
                appUI.dueActive = true;
                appUI.pastdueActive = true;
			
            }
		
            appUI.doInvoiceFilter();
		
            $('#dropdown_clients .dropdownText').text( $(this).text() );
            
        },
        
        /*
            year filter anchor event handler
        */
        invoiceFilterYearAnchor: function(e){
        
            e.preventDefault();
		
            $(this).toggleClass('active');
		
            var tag = $(this).attr('data-filter');
		
            appUI.activeYear = tag;
		
            //make sure some type filters are active 
		
            if( !appUI.paidActive && !appUI.dueActive && !appUI.pastdueActive ) {
			
                appUI.paidActive = true;
                appUI.dueActive = true;
                appUI.pastdueActive = true;
			
            }
		
            appUI.doInvoiceFilter();
		
            $('#dropdown_years .dropdownText b').text( $(this).text() );
            
        },
        
        /*
            event handler for the invoice filter ALL button
        */
        invoiceFilterAll: function(e){
    
            e.preventDefault();
		
            $(this).toggleClass('active');
		
            if( $(this).hasClass('active') ) {
			
                appUI.paidActive = true;
                $('#filter_paid').addClass('active');
						
                appUI.dueActive = true;
                $('#filter_due').addClass('active')
						
                appUI.pastdueActive = true;
                $('#filter_pastDue').addClass('active');
		
            } else {
			
                appUI.paidActive = false;
                $('#filter_paid').removeClass('active');
						
                appUI.dueActive = false;
                $('#filter_due').removeClass('active')
						
                appUI.pastdueActive = false;
                $('#filter_pastDue').removeClass('active');
			
            }
		
            appUI.doInvoiceFilter();
            
        },
        
        /*
            prepate the delete invoice modal, adds the invoice ID to the delete button
        */
        deleteInvoicePrep: function(){
            
            var button = $(this);
				
            $('#link_deleteInvoice').attr('href', $('#link_deleteInvoice').attr('data-url')+"/"+button.attr('data-invoice-id'));
            
        },
        
        /*
            handles the import of the invoice item data
        */
        invoiceDataImport: function(e){
                    
            //get rid of old alerts
            $('form#form_dataImport').find('.alert').fadeOut(function(){$(this).remove()})
		
            var theForm = $(this);
            var formdata = false;

            appUI.working(theForm);
		
            if (window.FormData){
                formdata = new FormData(theForm[0]);
            }
		
            if( !e.isDefaultPrevented()) {

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'post',
                    dataType: 'json',
                    contentType : false,
                    processData : false,
                    data : formdata ? formdata : theForm.serialize()
                }).done(function(ret){

                    theForm.find('.alerts').append( $(ret.content) );
				
                    if( ret.code == 1 ) {
					
                        setTimeout(function(){ $('form#form_dataImport').find('.alert-success').fadeOut(function(){$(this).remove()}) }, 5000);
					
                        //apply header
					
                        var newTR = $('<tr></tr>');
										
                        for( x=0; x<ret.data[1].length; x++ ) {
						
                            var newTH = $('<th></th>');
                            newTH.text(ret.data[1][x]);
						
                            newTR.append( newTH );
						
                            //alert( ret.data[1][x] )
                        
                        }
					
                        $('table#itemsTable thead > *').each(function(){
                            $(this).remove();
                        })
					
                        $('table#itemsTable thead').append( newTR );
					
					
                        //apply body
                        $('table#itemsTable tbody > *').each(function(){
                            $(this).remove();
                        })
				
                        for( x=2; x<=Object.keys(ret.data).length; x++ ) {
						
                            var newTR = $('<tr></tr>');
												
                            for( y=0; y<ret.data[x].length; y++ ) {
														
                                var newTD = $('<td></td>');
                                newTD.text( ret.data[x][y] );
							
                                newTR.append( newTD );
							
                            }
						
                            $('table#itemsTable tbody').append( newTR );
						
                        }
					
                        appUI.updateInvoiceAmounts();
				
                    }

                    appUI.finishedWorking(theForm);

                });
		   
            } 
		
            return false;
            
        },
        
        
        /*
            toggles the PAID status on an invoice
        */
        togglePaid: function() {
            'use strict';
            
            invoice.invoice_paid.change( $(this).val() );
            
            appUI.checkDue();
            
        },
        
        
        /*
            activates the invoice filter
        */
        doInvoiceFilter: function() {
	
            if( $('body').hasClass('clients') ) {
                appUI.activeYear = 'any';
            }
		
            $('#invoiceList li').hide();
	
            if(appUI.paidActive) {
	
                $('#invoiceList li.'+appUI.activeClient+".paid[data-year='"+appUI.activeYear+"']").fadeIn();
		
            }
	
            if(appUI.dueActive) {
	
                $('#invoiceList li.'+appUI.activeClient+".due[data-year='"+appUI.activeYear+"']").fadeIn();
		
            }
	
            if(appUI.pastdueActive) {
	
                $('#invoiceList li.'+appUI.activeClient+".past-due[data-year='"+appUI.activeYear+"']").fadeIn();
		
            }

        },
        
        /*
            updates the invoice totals towards the bottom of the invoice
        */
        updateInvoiceAmounts: function() {
		
            //get subtotal
	
            var subTotal = 0;
            
            $('#itemsTable tbody tr').each(function(){
		
                $(this).find('td:last').find('div:first').remove();
				
                subTotal += Number( $(this).find('td:last').text() );
		
            })
	
            subTotal = Math.round(subTotal * 100) / 100;
	   
            invoice.invoice_subTotal.change(subTotal, false);
		
            //discounts
	       
            var discountAmount = (invoice.invoice_subTotal.data/100*invoice.invoice_discountPercentage.data)
	
            discountAmount = Math.round(discountAmount * 100) / 100;
            
            invoice.invoice_discountAmount.change(discountAmount, false);
            
            invoice.invoice_total.change( invoice.invoice_subTotal.data - invoice.invoice_discountAmount.data, false );
	
            //taxes
            
            var taxAmount = ( invoice.invoice_total.data/100 * invoice.invoice_taxPercentage.data )
	
            taxAmount = Math.round(taxAmount * 100) / 100;
            
            invoice.invoice_taxAmount.change( taxAmount, false );
				
	
            //invoice total
            invoice.invoice_total.change( invoice.invoice_total.data + invoice.invoice_taxAmount.data, false );
	
            //balance due
            var balanceDue = invoice.invoice_total.data - invoice.invoice_paidToDate.data;
            invoice.invoice_balanceDue.change( balanceDue.toFixed(2), false );
		
	
            appUI.changesToSave(true);

        },
        
        /*
            updates the invoice payments totals
        */
        updatePayments: function() {
	
            var invoicePaidToDate = 0;
	
            $('table#table_payments tbody tr').each(function(){
		
                invoicePaidToDate += Number( $(this).find('td:last').text() );
		
            })
            
            invoice.invoice_paidToDate.change( invoicePaidToDate );
	
            appUI.updateInvoiceAmounts();
	
            appUI.changesToSave(true);
        
        },
        
        /*
            notitfies the user of unsaved changes
        */
        changesToSave: function(val) {
	
            if( val ) {
		
                $('#button_saveInvoice').removeClass('disabled').find('.buttonText').text( $('#button_saveInvoice').attr('data-textsave') )
		
            } else {
		
                $('#button_saveInvoice').addClass('disabled').find('.buttonText').text( $('#button_saveInvoice').attr('data-textnochanges') )
		
            }

        },
        
        /*
            checks wether the invoice is due, paid or past due
        */
        checkDue: function() {
                        
            if( invoice.invoice_balanceDue.data == 0 || invoice.invoice_balanceDue.data < 0 ) {//payment made, balance is 0 or less
                
                $('#statusRibbon').text('PAID').addClass('paid').removeClass('due').removeClass('past-due');
		
                invoice.invoice_status.change('paid');
		
                $('#invoiceLi_'+invoice.invoice_id.data+" .label").removeClass('label-danger').removeClass('label-info').addClass('label-primary').text('paid');
                
                invoice.invoice_paid.change('Yes');
                
            } else {
                
                console.log(invoice.invoice_paid.data);
            			
                if( invoice.invoice_paid.data == 'No' ) {
			
                    if( invoice.isPastDue() ) {
		
                        $('#statusRibbon').text('PAST DUE').addClass('past-due').removeClass('due').removeClass('paid');
			         
                        invoice.invoice_status.change('past due');
				    
                        $('#invoiceLi_'+invoice.invoice_id.data+" .label").removeClass('label-info').removeClass('label-primary').addClass('label-danger').text('past due');
			
                    } else {
		
                        $('#statusRibbon').text('DUE').addClass('due').removeClass('past-due').removeClass('paid');
			 
                        invoice.invoice_status.change( 'due' );
			
                        $('#invoiceLi_'+invoice.invoice_id.data+" .label").removeClass('label-danger').removeClass('label-primary').addClass('label-info').text('due');
                
                    }
	
                } else {
		
                    $('#statusRibbon').text('PAID').addClass('paid').removeClass('due').removeClass('past-due');
		
                    invoice.invoice_status.change('paid');
		
                    $('#invoiceLi_'+invoice.invoice_id.data+" .label").removeClass('label-danger').removeClass('label-info').addClass('label-primary').text('paid');
		
                }
                
            }
    
        },
        
        /*
            submits the account form
        */
        accountFormSubmit: function(e){
            
            var theForm = $(this);

            appUI.working(theForm);
		
            if( !e.isDefaultPrevented()) {

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'post',
                    dataType: 'json',
                    data: $(this).serialize()
                }).done(function(ret){
				
                    theForm.find('.alerts').append( $(ret.content) );
				
                    if( ret.code == 1 ) {
					
                        setTimeout(function(){ $('form#form_account').find('.alert-success').fadeOut(function(){$(this).remove()}) }, 5000)
					
                    }
				
                    appUI.finishedWorking(theForm);
				
                })
		   
            } 
		
            return false;
            
        },
        
        /*
            submits the company details form
        */
        detailsFormSubmit: function(e){
        
            var theForm = $(this);
		
            if( !e.isDefaultPrevented()) {
			
                appUI.working(theForm);
			
                var form = $(this);
                var formdata = false;

                if (window.FormData){
                    formdata = new FormData(form[0]);
                }
				
                $.ajax({
                    url: form.attr('action'),
                    method: 'post',
                    dataType: 'json',
                    cache : false,
                    contentType : false,
                    processData : false,
                    data: formdata ? formdata : form.serialize()
                }).done(function(ret){
				
                    theForm.find('.alerts').append( $(ret.content) );
				
                    if( ret.code == 1 ) {
					
                        setTimeout(function(){ $('form#form_details').find('.alert-success').fadeOut(function(){$(this).remove()}) }, 5000);
					

                        //reload company logo
                        if( typeof ret.logo != 'undefined' ) {
                            d = new Date();
                            $('img#image_companyLogo').show().closest('.form-group').show();
                            $('img#image_companyLogo').attr('src', ret.logo+"?"+d.getTime());
                            $('#button_deleteLogo').show()
                        }
                    }
				
                    appUI.finishedWorking(theForm);
				
                })
		   
            } 
		
            return false;
                
        },
        
        /*
            deletes the company logo
        */
        accountDeleteLogo: function(e){
        
            e.preventDefault();
		
            $('#image_companyLogo').attr('src', '').hide();
            
            $(this).hide();
                
        },
        
        /*
            activates the "working" state on a form
        */
        working: function(form){
            
            form.find('.alert').remove();
	
            appUI.originalButtonText = form.find('button[type="submit"] .buttonText').text();
            form.find('button[type="submit"]').addClass('disabled').find('.buttonText').text( appUI.loadingState_save );
            form.find('.form-group:not(:last)').css('opacity', 0.5);
            
        },
        
        /*
            disables the working state on a form
        */
        finishedWorking: function(form) {
	
            form.find('button[type="submit"]').removeClass('disabled');
            form.find('button[type="submit"] .buttonText').text( appUI.originalButtonText );
            form.find('.form-group:not(:last)').css('opacity', 1);
        
        },
        
        /*
            generates a new API key
        */
        addApiKey: function(){
        
            var theButton = $(this);
            theButton.addClass('disabled');
				
            $.ajax({
                url: $(this).attr('data-url'),
                method: 'post',
                dataType: 'json'
            }).done(function(ret){
			
                var newGroup = $('#modal_apikeys .modal-body .form-group:hidden').clone();
                newGroup.find('input').val( ret.key );

                $('#modal_apikeys #keys').append( newGroup );
			
                newGroup.show();
			
                theButton.removeClass('disabled');
			
            })
            
        },
        
        /*
            deletes an existing API key
        */
        removeApiKey: function(){
            
            var theButton = $(this);		
						
            if( confirm( appUI.confirm_removeapikey ) ) {
			
                $.ajax({
                    url: $(this).attr('data-url'),
                    method: 'post',
                    dataType: 'json',
                    data: "id="+$(this).attr('data-id')
                }).done(function(ret){
				
                    theButton.closest('.form-group').fadeOut(function(){
                        $(this).remove();
                    });
								
                })
			
            }
            
        },
        
        /*
            adds a payment to the payments array
        */
        addPaymenttoPayments: function(payment){
            
            appUI.payments.push(payment);
            
        },
        
        /*
            adds an currency to the currencies array
        */
        addCurrencyToCurrencies: function(currencyCode, currencySymbol){
        
            appUI.currencies[currencyCode] = currencySymbol;
                
        },
        
        setProp: function(prop, value){
            
            appUI[prop] = value;
            
        },
        
        getProp: function(prop) {
            console.log(appUI[prop]);
            return appUI[prop];
        }
        
    };
    
    /*
        get the interface going
    */
    appUI.setup();
    
    /*
        public API
    */
    return {
        changesToSave: appUI.changesToSave,
        addPaymenttoPayments: appUI.addPaymenttoPayments,
        addCurrencyToCurrencies: appUI.addCurrencyToCurrencies,
        showPayments: appUI.showPayments,
        updateInvoiceAmounts: appUI.updateInvoiceAmounts,
        checkDue: appUI.checkDue,
        setProp: appUI.setProp,
        getProp: appUI.getProp
    };
    
}());