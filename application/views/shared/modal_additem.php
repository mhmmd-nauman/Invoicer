	<div class="modal fade" id="modal_addItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
	   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="modal_changeItemsStructureLabel"><span class="fui-plus-circle"></span> <?php echo $this->lang->line('add_item_to_invoice');?></h4>
	      	  	</div>
	      	  	
				<div class="modal-body">
					
					<form class="form-horizontal" id="form_addItem">
						
					</form>
					
	      	  	</div>
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        		<button type="button" class="btn btn-primary btn-embossed" id="button_addItemToInvoice"><span class="fui-check"></span> <?php echo $this->lang->line('add_item_to_invoice');?></button>
	      	  	</div>
	    	
			</div><!-- /.modal-content -->
	  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->