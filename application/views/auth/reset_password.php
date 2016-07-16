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
                                        <li class="active"><a href="#login"> Change Password</a></li>
                                        
                                </ul>
                                    <div class="tab-content">
						
						<div class="tab-pane active" id="login">
                                    <h1><?php echo lang('reset_password_heading');?></h1>
                                    
                                    <div id="infoMessage"><?php echo $message;?></div>

                                    <?php echo form_open('auth/reset_password/' . $code);?>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="new" value="" id="new" pattern="^.{8}.*$" placeholder="<?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="new_confirm" value="" id="new_confirm" pattern="^.{8}.*$" placeholder="Confirm Password">
                                    </div>

                                    

                                    <?php echo form_input($user_id);?>
                                    <?php echo form_hidden($csrf); ?>

                                    <p><?php echo form_submit('submit', lang('reset_password_submit_btn'));?></p>

                                    <?php echo form_close();?>
                                                </div>
                                    </div>
                                </div>
                        </div><!-- /.col -->
		
		</div><!-- /.row -->
		
	</div><!-- /.container -->	
	
	
    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="<?php echo base_url('js/vendor/jquery.min.js')?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('js/flat-ui-pro.js')?>"></script>
	<script src="<?php echo base_url('js/application.js')?>"></script>
	
</body>