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
					
					<ul class="nav nav-tabs nav-append-content">
						<li class="active"><a href="#login"><i class="fa fa-lock"></i> Create New Account</a></li>
				  		
					</ul>

					<!-- Tab content -->
					<div class="tab-content">
						
						<div class="tab-pane active" >
				    		<h1>Account Information</h1>
                                                <br>	
			    			<?php if( isset($message) && $message != '' ):?>
			    			<div class="alert alert-info">
			    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
			    				<?php echo $message;?>
			    			</div>
			    			<?php endif;?>
							
                                                        <form class="form-horizontal" method="post" action="<?php echo site_url('register')?>">
                                                            <div class="form-group">
                                                                
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                               <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="company" name="company" placeholder="Company" onchange="getWebaddress();">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $this->lang->line('email_placeholder');?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $this->lang->line('password_placeholder');?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="webaddress" name="webaddress" placeholder="Your Login URL">
                                                                </div>
                                                            </div>
                                                             <div class="form-group">
                                                                 <div class="col-md-3">
                                                                     &nbsp;
                                                                 </div>
                                                                 <div class="col-md-6">
                                                                    <button type="submit" class="btn btn-primary btn-embossed btn-block">Create My Account</button>
                                                                 </div>
                                                                 <div class="col-md-3">
                                                                     &nbsp;
                                                                 </div>
                                                             </div>
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
<script type="text/javascript">
function getWebaddress(){
    var company = $("#company").val();
    company = company.replace(/\s/g, '');
    company = company.toLowerCase();
    $("#webaddress").val(company+".getinvoicer.com");
}
</script>