<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->lang->line('html_title')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo base_url('css/vendor/bootstrap.min.css')?>" rel="stylesheet">

    <!-- Loading Flat UI Pro -->
    <link href="<?php echo base_url('css/flat-ui-pro.css');?>" rel="stylesheet">
	
	<link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/font-awesome.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('css/chosen.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('js/redactor/redactor.css');?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo base_url('img/favicon.png');?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    	<script src="<?php echo base_url('js/vendor/html5shiv.js');?>"></script>
      	<script src="<?php echo base_url('js/vendor/respond.min.js');?>"></script>
    <![endif]-->
</head>
<body class="<?php echo $page;?>">

	<nav class="navbar navbar-inverse navbar-lg navbar-fixed-top mainNav" role="navigation">
		<div class="navbar-header">
	    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
	      	  <span class="sr-only"><?php echo $this->lang->line('toggle_navigation');?></span>
	    	</button>
	    	<a class="navbar-brand" href="<?php echo site_url();?>"><img src="<?php echo base_url('img/logo_.png');?>" style="height: 40px; position: relative; top: -4px"></a>
	  	</div>
	  	<div class="collapse navbar-collapse" id="navbar-collapse-01">
	    	
			<?php if( $clients ):?>
			<div class="btn-group clientDropdown">
				<button class="btn btn-default dropdown-toggle navbar-btn btn-sm" type="button" data-toggle="dropdown" style="margin-right: 10px">
			    	<span class="fui-plus"></span> <?php echo $this->lang->line('create_new_invoice_for');?> <span class="caret"></span>
			  	</button>
			  	<ul class="dropdown-menu dropdown-menu-inverse list_clients" role="menu">
					<?php foreach( $clients as $client ):?>
					<li><a href="<?php echo site_url('invoices/create/'.$client->client_id)?>"><?php echo $client->client_name;?></a></li>
					<?php endforeach;?>
			  	</ul>
			</div>
			<?php endif;?>
			
			<button class="btn btn-default navbar-btn btn-sm addClientButton" type="button" data-target="#modal_newClient" data-toggle="modal"><span class="fui-plus"></span> 
				<?php echo $this->lang->line('add_client');?>
			</button>
                    <?php if( $this->ion_auth->in_group(array(2))){?>
                    <button class="btn btn-default navbar-btn btn-sm addClientButton" type="button" data-target="#modal_newEmployee" data-toggle="modal"><span class="fui-plus"></span> 
                            Add Employee
                    </button>
                    <?php } ?>
                    
            <ul class="nav navbar-nav navbar-right" style="margin-right: 20px">
            	<li class="dropdown">
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome <?php echo $this->ion_auth->user()->row()->first_name." ".$this->ion_auth->user()->row()->last_name;?> <b class="caret"></b></a>
                	<ul class="dropdown-menu">
 					   	<li><a href="#modal_account" data-toggle="modal"><?php echo $this->lang->line('my_account_and_company');?></a></li>
						<li><a href="#modal_apikeys" data-toggle="modal"><?php echo $this->lang->line('api_keys');?></a></li>
						<li><a href="<?php echo site_url('settings');?>"><?php echo $this->lang->line('application_settings');?></a></li>
                  	  	<li><a href="<?php echo site_url('documentation')?>"><?php echo $this->lang->line('help_documentation');?></a></li>
                  	  	<li class="divider"></li>
                  	  	<li><a href="<?php echo site_url('logout')?>"><?php echo $this->lang->line('logout');?></a></li>
                	</ul>
              	</li>
            </ul>
			
	  	</div><!-- /.navbar-collapse -->
	</nav><!-- /navbar -->
	
	<div class="iconbar leftBar">
		<ul>
		<li <?php if( isset($page) && $page == 'dashboard' ):?>class="active"<?php endif;?>><a href="<?php echo site_url('dashboard');?>" class="fa fa-tachometer" title="<?php echo $this->lang->line('dashboard');?>"></a></li>
	    	<li <?php if( isset($page) && $page == 'invoices' ):?>class="active"<?php endif;?>><a href="<?php echo site_url('invoices');?>" class="fui-document" title="<?php echo $this->lang->line('invoices');?>"></a></li>
	    	<li <?php if( isset($page) && $page == 'clients' ):?>class="active"<?php endif;?>><a href="<?php echo site_url('clients');?>" class="fui-user" title="<?php echo $this->lang->line('clients');?>"></a></li>
	    	<li <?php if( isset($page) && $page == 'reports' ):?>class="active"<?php endif;?>><a href="<?php echo site_url('reports');?>" class="fa fa-calculator" title="<?php echo $this->lang->line('reports');?>"></a></li>
		<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group(array(2))){?>
                    <li <?php if( isset($page) && $page == 'users' ):?>class="active"<?php endif;?>><a href="<?php echo site_url('users');?>" class="fui-user" title="Users"></a></li>
                <?php }?>
                <li <?php if( isset($page) && $page == 'documentation' ):?>class="active"<?php endif;?>><a href="<?php echo site_url('documentation');?>" class="fa fa-life-ring" title="<?php echo $this->lang->line('documentation')?>"></a></li>
		<li class="power"><a href="<?php echo site_url('logout');?>" class="fui-power" title="<?php echo $this->lang->line('logout');?>"></a></li>
	  	</ul>
	</div><!-- /.leftBar -->