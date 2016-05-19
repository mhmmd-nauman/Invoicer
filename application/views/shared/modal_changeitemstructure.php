	<div class="modal fade" id="modal_changeItemsStructure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">	
		
		<div class="modal-dialog">
	   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="modal_changeItemsStructureLabel"><span class="fui-list-small-thumbnails"></span> <?php echo $this->lang->line('alter_items_table_structure');?></h4>
	      	  	</div>
	      	  	
				<div class="modal-body">
					
					<div class="alert alert-warning">
						<button class="close fui-cross" data-dismiss="alert"></button>
					  	<h4><?php echo $this->lang->line('please_note');?></h4>
					  	<?php echo $this->lang->line('change_item_structure_message');?>
					</div>
					
					<form class="form-horizontal" id="form_editColumns">
						
					</form>
					
					<hr class="dashed">
					
					<p class="">
						<button type="button" class="btn button_addItemColumn" id="button_addItemColumn"><span class="fui-plus-circle"></span> <?php echo $this->lang->line('add_new_column');?></button>
					</p>
					
	      	  	</div>
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('cancel_close');?></button>
	        		<button type="button" class="btn btn-primary btn-embossed" id="button_updateItemColumns"><span class="fui-check"></span> <?php echo $this->lang->line('update_items_table');?></button>
	      	  	</div>
	    	
			</div><!-- /.modal-content -->
	  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->