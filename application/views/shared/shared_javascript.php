    <script src="<?php echo base_url('js/vendor/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('js/flat-ui-pro.js');?>"></script>
	<script src="<?php echo base_url('js/application.js');?>"></script>
	<script src="<?php echo base_url('js/validator.js');?>"></script>
    <script src="<?php echo base_url('js/chosen.jquery.min.js');?>"></script>
    <script src="<?php echo base_url('js/innvoice.ui.js');?>"></script>
	<script src="<?php echo base_url('js/innvoice.databinder.js');?>"></script>
	
	<script>
        
        innvoice.setProp('dateFormat', "<?php echo $this->config->item('date_format_js');?>");
        innvoice.setProp('loadingState_save', "Saving data...");
        innvoice.setProp('site_url', "<?php echo site_url();?>");
        		
		<?php if( isset($currencies) && $currencies ):?>
        <?php foreach( $currencies as $currency ):?>
        innvoice.addCurrencyToCurrencies("<?php echo $currency->currency_shortname?>", "<?php echo $currency->currency_sign;?>");
        <?php endforeach;?>
		<?php endif;?>
		
		$(function(){
			
			var options = {
			    placement: function (context, source) {
			        var position = $(source).position();
					
					if( $(window).width() > 768) {
						return "right"
					} else {
						return "bottom"
					}
			        
			    }
			    , trigger: "hover"
			};

			$('.iconbar a').tooltip(options);
			
		})
		
        innvoice.setProp('confirm_removeapikey', '<?php echo $this->lang->line('confirm_removeapikey');?>');
		
	</script>