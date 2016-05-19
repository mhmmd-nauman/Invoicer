function MyCtor(elements, data) {
        
    this.data = data;
    this.elements = elements;
                
    for( var i = 0; i < elements.length; i++ ) {
                        
        if(elements[i].tagName == 'INPUT' || elements[i].tagName == 'SELECT' || elements[i].tagName == 'TEXTAREA' ) {
            elements[i].value = data;
        } else if( elements[i].tagName == 'DIV' || elements[i].tagName == 'SPAN' || elements[i].tagName == 'B' ) {
            elements[i].innerHTML = data;
        }
        
        elements[i].addEventListener("change", this, false);
    }
        
}

MyCtor.prototype.handleEvent = function(event) {
    switch (event.type) {
        case "change": this.change(event.target.value);
    }
};

MyCtor.prototype.change = function(value, updateAmounts) {
    
    updateAmounts = typeof updateAmounts !== 'undefined' ? updateAmounts : true;
                        
    this.data = value;
        
    for( var i = 0; i < this.elements.length; i++ ) {
                
        if(this.elements[i].tagName == 'INPUT' || this.elements[i].tagName == 'SELECT' || this.elements[i].tagName == 'TEXTAREA' ) {
            this.elements[i].value = value;
        } else if( this.elements[i].tagName == 'DIV' || this.elements[i].tagName == 'SPAN' || this.elements[i].tagName == 'B' ) {
            this.elements[i].innerHTML = value;
        }        
        
    }
    
    innvoice.changesToSave(true);
    
    if( updateAmounts === true ) {
        innvoice.updateInvoiceAmounts();
    }
    
};

//var obj = new MyCtor(document.querySelectorAll('[data-bind="invoice_po"]'), 1234);

/*
function DataBinder( object_id ) {
	
  	// Use a jQuery object as simple PubSub
  	var pubSub = jQuery({});

  	// We expect a `data` element specifying the binding
  	// in the form: data-bind-<object_id>="<property_name>"
  	var data_attr = "bind-" + object_id, message = object_id + ":change";

  	// Listen to change events on elements with the data-binding attribute and proxy
  	// them to the PubSub, so that the change is "broadcasted" to all connected objects
  	jQuery( document ).on( "change", "[data-" + data_attr + "]", function( evt ) {
		    	
		var $input = jQuery( this );
		
    	pubSub.trigger( message, [ $input.data( data_attr ), $input.val() ] );
		
		if( $input.data('function') != undefined ) {
		
			window[$input.data('function')]();
			
		}
		
		innvoice.changesToSave(true);
  
  	});
	
  	jQuery( document ).on( "blur", ".bind[data-" + data_attr + "]", function( evt ) {
		    	
		var $input = jQuery( this );
		
    	pubSub.trigger( message, [ $input.data( data_attr ), $input.text() ] );
		
		innvoice.changesToSave(true);
  
  	});

  	// PubSub propagates changes to all bound elements, setting value of
  	// input tags or HTML content of other tags
  	pubSub.on( message, function( evt, prop_name, new_val ) {
		
		if( typeof new_val ==  'number' && ( prop_name == 'invoice_taxAmount' || prop_name == 'invoice_discountAmount' || prop_name == 'invoice_subTotal' || prop_name == 'invoice_total' || prop_name == 'invoice_paidToDate' || prop_name == 'invoice_balanceDue' ) ) {
			
			new_val = new_val.toFixed(2);
			
		}
    	
		jQuery( "[data-" + data_attr + "=" + prop_name + "]" ).each( function() {
			
			var $bound = jQuery( this );

      	  	if ( $bound.is("input, textarea, select") ) {
        		$bound.val( new_val );
      	  	} else {
        		$bound.html( new_val );
      	  	}
    	});
  	});

  	return pubSub;
}*/