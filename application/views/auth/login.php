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
		
			<div class="col-md-4 col-md-offset-4">
				
				<div class="text-center" style="margin: 30px 0px 50px">
					<a href=""><img src="<?php echo base_url('img/logo_bigger.png')?>"></a>
				</div>
				
				<div class="loginTabs">
					
					<ul class="nav nav-tabs nav-append-content">
						<li class="active"><a href="#login"><i class="fa fa-lock"></i> <?php echo $this->lang->line('tab_login');?></a></li>
				  		<li><a href="#preset"><i class="fa fa-key"></i> <?php echo $this->lang->line('tab_forgot_password');?></a></li>
					</ul>

					<!-- Tab content -->
					<div class="tab-content">
						
						<div class="tab-pane active" id="login">
				    		
							<h1><?php echo $this->lang->line('log_into_innvoice');?></h1>
							
			    			<?php if( isset($message) && $message != '' ):?>
			    			<div class="alert alert-info">
			    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
			    				<?php echo $message;?>
			    			</div>
			    			<?php endif;?>
							
							<form method="post" action="<?php echo site_url('login')?>">
								<div class="form-group">
							    	<input type="email" class="form-control" id="identity" name="identity" placeholder="<?php echo $this->lang->line('email_placeholder');?>">
							  	</div>
							  	<div class="form-group">
							    	<input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $this->lang->line('password_placeholder');?>">
							  	</div>
							  	<div class="form-group">
							    	<label class="checkbox">
										<input type="checkbox" data-toggle="checkbox" name="remember" value="1"> <?php echo $this->lang->line('remind_me_label');?>
							    	</label>
							  	</div>
							  	<button type="submit" class="btn btn-primary btn-embossed btn-block"><?php echo $this->lang->line('button_login');?></button>
							</form>
							
				  		</div>
					
				 	   <div class="tab-pane" id="preset">
				    		
							<h1><?php echo $this->lang->line('forgot_your_password');?>?</h1>
							
			    			<?php if( isset($message) && $message != '' ):?>
			    			<div class="alert alert-info">
			    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
			    				<?php echo $message;?>
			    			</div>
			    			<?php endif;?>
							
							<form method="post" action="<?php echo site_url('forgot_password')?>">
								<div class="form-group">
							    	<input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $this->lang->line('email_placeholder');?>">
							  	</div>
							  	<button type="submit" class="btn btn-primary btn-embossed btn-block"><?php echo $this->lang->line('retrieve_password');?></button>
							</form>
							
					   </div>
				  
					</div><!-- /.tab-content -->
				
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