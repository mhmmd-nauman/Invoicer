<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>404 page not found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo base_url('css/vendor/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Loading Flat UI Pro -->
    <link href="<?php echo base_url('css/flat-ui-pro.css');?>" rel="stylesheet">
	
	<link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/font-awesome.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/chosen.css');?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo base_url('img/favicon.png');?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="<?php echo base_url('js/vendor/html5shiv.js');?>"></script>
      	<script src="<?php echo base_url('js/vendor/respond.min.js');?>"></script>
    <![endif]-->
</head>
<body>
	
	<nav class="navbar navbar-inverse navbar-lg navbar-fixed-top mainNav" role="navigation">
		<div class="navbar-header">
	    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
	      	  <span class="sr-only">Toggle navigation</span>
	    	</button>
	    	<a class="navbar-brand" href="<?php echo site_url();?>"><img src="<?php echo base_url('img/logo_.png');?>" style="height: 40px; position: relative; top: -4px"></a>
	  	</div>
	</nav><!-- /navbar -->
	
	<div class="container-fluid" style="margin-top: 100px">
		
		<div class="row">
			
			<div class="col-md-12">
				
				<div class="alert alert-info">
				 	<button class="close fui-cross" data-dismiss="alert"></button>
				  	<h4><?php echo $heading;?></h4>
				  	<p><?php echo $message;?></p>
				</div>
				
			</div><!-- /.col -->
			
		</div><!-- /.row -->
		
	</div><!-- /.container -->
	
</body>