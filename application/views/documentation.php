<?php $this->load->view('shared/header');?>
	
	<section class="app">
	
	<div class="container-fluid" style="overflow: hidden">
		
		<div class="row">
						
			<div class="col-md-12">
				
				<iframe src="http://docs.selfhosted.net/innvoice/index.html" style="border: 0px; background: #FAF6F0; width: 100%" id="docFrame"></iframe>
			
			</div><!-- /.col -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container-fluid -->
	
	</section>
	
	<!-- Modal -->
		
	<?php $this->load->view('shared/modal_account');?>
	
	<?php $this->load->view('shared/modal_apikey');?>
		
	<?php $this->load->view('shared/modal_newclient')?>
	
    <?php $this->load->view('shared/shared_javascript');?>
	
	<script>
	$(function(){
		
		$('#docFrame').height( $('#docFrame').closest('.container-fluid').height()-20 )
	
	})
	</script>
	
  </body>
</html>
