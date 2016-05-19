	<div class="modal fade" id="modal_apikeys" tabindex="-1" role="dialog" aria-labelledby="modal_account" aria-hidden="true">
		
		<div class="modal-dialog">
								   	 	
			<div class="modal-content">
				
				<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title"><span class="fui-gear"></span> <?php echo $this->lang->line('headding_api_keys');?></h4>
	      	  	</div>
	      	  	
				<div class="modal-body">
					
					<?php if( !$keys ):?>
					<div class="alert alert-info">
						<button class="close fui-cross" data-dismiss="alert"></button>
					  	<h4><?php echo $this->lang->line('no_keys_heading');?></h4>
					  	<?php echo $this->lang->line('no_keys_message');?>
					</div>
					<?php endif;?>
					
					<div class="form-group" style="display: none">
						<div class="input-group">
							<input type="text" id="search-query-3" placeholder="Search" class="form-control">
							<span class="input-group-btn">
								<button class="btn delAPIKey" data-url="<?php echo site_url('settings/deleteapikey')?>"><span class="fui-cross-circle text-danger"></span></button>
							</span>
						</div>
					</div>
					
					<div id="keys">
						<?php if( $keys ):?>
						<?php foreach( $keys as $key ):?>
						<div class="form-group">
							<div class="input-group">
								<input type="text" id="search-query-3" placeholder="Search" class="form-control" value="<?php echo $key->key;?>">
								<span class="input-group-btn">
									<button class="btn delAPIKey" data-id="<?php echo $key->id;?>" data-url="<?php echo site_url('settings/deleteapikey')?>"><span class="fui-cross-circle text-danger"></span></button>
								</span>
							</div>
						</div>
						<?php endforeach;?>
						<?php endif;?>
					</div>
					
					<button type="button" class="btn btn-block btn-primary" id="button_createApiKey" data-url="<?php echo site_url('settings/newapikey')?>"><span class="fui-check"></span> <?php echo $this->lang->line('create_new_key');?></button>
					
	      	  	</div><!-- /.modal-body -->
	      	  	
				<div class="modal-footer">
	        		<button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><span class="fui-cross"></span> <?php echo $this->lang->line('close_window');?></button>
	      	  	</div>
	    	
			</div><!-- /.modal-content -->
				  	
		</div><!-- /.modal-dialog -->
		
	</div><!-- /.modal -->