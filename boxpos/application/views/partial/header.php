<html>

<head>
    <meta charset="utf-8">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="<?php echo base_url();?>" />
    <link rel="icon" href="<?php echo base_url();?>images/icon.ico">
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>assets/css/navbar-fixed-top.css" rel="stylesheet">
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/ospos.css" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/ospos_print.css"  media="print"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script>BASE_URL = '<?php echo site_url(); ?>';</script>
	<script src="<?php echo base_url();?>js/jquery-1.11.3.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<!-- <script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>  -->
	<script src="<?php echo base_url();?>js/jquery.color.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.metadata.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.form.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.tablesorter.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.ajax_queue.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.bgiframe.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.validate.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.jkey-1.1.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/swfobject.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/date.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/datepicker.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>assets/js/bootstrap.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.validate.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/additional-methods.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<!-- <script>$.noconflict();</script> -->
	<style type="text/css">
		html {
			overflow: auto;
		}
		</style>   
	 <![endif]-->
	<title><?php echo $this->config->item('company').' -- '.$this->lang->line('common_powered_by').' BOX Point Of Sale' ?></title>   

</head>
 
 <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo base_url();?>"><img class="navbar-logo" alt="<?php echo $this->config->item('company'); ?>" src="<?php echo base_url();?>images/logo.png"></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="glyphicon glyphicon-th"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
		<li><a><?php echo $this->config->item('company'); ?></a></li>
		<li class="hidden-xs hidden-sm"><a><?php echo date('F d, Y h:i a') ?></a></li>
		<li class="hidden-xs hidden-sm"><a><?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name!"; ?></a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
       
        <li class="dropdown hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th dropdown"></span></a>
          <ul class="dropdown-menu">
            <li>
            	<?php
					foreach($allowed_modules->result() as $module)
					{
					?>
					<li>
					<a href="<?php echo site_url("$module->module_id");?>">
					<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" class="menulogo" alt="Menubar Image" />
					<span><?php echo $this->lang->line("module_".$module->module_id) ?></span>
					</a>
					</li>
					<?php
					}
					?>
            </li>
          </ul>
        </li>
        
        <li class="dropdown hidden-lg hidden-md hidden-sm">
          <ul>
            <li>
            	<?php
					foreach($allowed_modules->result() as $module)
					{
					?>
					<li>
					<a href="<?php echo site_url("$module->module_id");?>">
					<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" class="menulogo" alt="Menubar Image" />
					<span><?php echo $this->lang->line("module_".$module->module_id) ?></span>
					</a>
					</li>
					<?php
					}
					?>
            </li>
          </ul>
        </li>

       <li><?php echo anchor("home/logout",$this->lang->line("common_logout")); ?></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">


