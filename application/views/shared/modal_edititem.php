	<div class="modal fade" id="modal_editItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
								   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="modal_changeItemsStructureLabel"><span class="fui-new"></span> <?php echo $this->lang->line('edit_invoice_item');?></h4>
	      	  	</div>
	      	  	
				<div class="modal-body">
					
					<form class="form-horizontal" id="form_editItem">
						
					</form>
					
	      	  	</div>
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        		<button type="button" class="btn btn-primary btn-embossed" id="button_updateItem" data-rowindex=""><span class="fui-check"></span> <?php echo $this->lang->line('update_item');?></button>
	      	  	</div>
	    	
			</div><!-- /.modal-content -->
				  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->