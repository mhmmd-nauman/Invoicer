<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->lang->line('login_html_title');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo base_url('css/vendor/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Loading Flat UI Pro -->
    <link href="<?php echo base_url('css/flat-ui-pro.css');?>" rel="stylesheet">
	
	<link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/login.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/font-awesome.min.css');?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo base_url('img/favicon.png');?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="<?php echo base_url('js/vendor/html5shiv.js');?>"></script>
      	<script src="<?php echo base_url('js/vendor/respond.min.js');?>"></script>
    <![endif]-->
</head>
<body>
	
	<div class="container">
		
		<div class="row">
		
			<div class="col-md-8 col-md-offset-3">
				
				<div class="text-center" style="margin: 3px 0px 5px">
					<a href=""><img src="<?php echo base_url('img/logo_bigger.png')?>"></a>
				</div>
				
				<div class="loginTabs">
					
					
						
						<div class="tab-pane" style=" padding: 10px;">
				    		<h1>Account created successfully.</h1>
                                                <br>	
			    			<?php if( isset($message) && $message != '' ):?>
                                                <div class="alert alert-info" >
			    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
			    				<?php echo $message;?>
			    			</div>
			    			<?php endif;?>
							
				  		</div>
                                    <br>
                                    <br>	   
					
				
				</div><!-- /.loginTabs -->
			
			</div><!-- /.col -->
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->	
	
	
    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="<?php echo base_url('js/vendor/jquery.min.js')?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('js/flat-ui-pro.js')?>"></script>
	<script src="<?php echo base_url('js/application.js')?>"></script>
	
</body>
<script type="text/javascript">
function getWebaddress(){
    var company = $("#company").val();
    company = company.replace(/\s/g, '');
    company = company.toLowerCase();
    $("#webaddress").val(company+".getinvoicer.com");
}
</script>