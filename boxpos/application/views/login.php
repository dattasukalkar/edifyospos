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
    <link href="<?php echo base_url();?>assets/css/saas.css" rel="stylesheet">
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
      <a class="navbar-brand" href="<?php echo base_url();?>"><img alt="<?php echo $this->config->item('company'); ?>" src="<?php echo base_url();?>images/logo.png" class="navbar-logo"></a>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
		<li><a href="http://boxpointofsale.com"><i class="fa fa-question-circle"></i>&nbsp;More Information</a></li>
		<li><a href="#"><i class="fa fa-pencil-square-o"></i>&nbsp;Sign Up</a></li>
		<li><a href="http://support.boxpointofsale.com"><i class="fa fa-support"></i>&nbsp;Support</a></li>
        	<li class="active"><a href="<?php echo site_url(); ?>"><i class="fa fa-hand-o-right"></i>&nbsp;Demo</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">
	<div class="jumbotron">
		<div class="page-header h1">
		<?php echo $this->lang->line('common_welcome'); ?>
		</div>
		<div class="body">
		<?php echo $this->lang->line('login_welcome_message'); ?>
		</div>
	</div>
</div>
<div class="container-fluid"> 
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
				Login for Administrators
		</div>
		<div class="panel-body">
			<?php echo form_open('login') ?>
			<?php echo validation_errors(); ?>
			<div class="form-inline">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<?php echo $this->lang->line('login_username'); ?>
						</div>
						<div style="width:100%">
							<?php echo form_input(array(
							'name'=>'username',
							'class'=>'form-control',
							'placeholder'=>'username',
							'value'=>'admin',
							'type'=>'text')); ?>
						</div>
					</div>
				</div>
			</div>
			<p>
			<div class="form-inline">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<?php echo $this->lang->line('login_password'); ?> 
						</div>
						<div>
							<?php echo form_password(array(
							'name'=>'password',
							'class'=>'form-control',
							'placeholder'=>'password',
							'value'=>'boxpointofsale',
							'type'=>'password')); ?>
						</div>
					</div>
				</div>
			<p>
			<div>
				<?php echo form_submit(array(
				'class'=>'btn btn-primary btn-block',
				'value'=>'GO',
				)); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div> 
</div>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
				Login for Cashiers
		</div>
		<div class="panel-body">
			<?php echo form_open('login') ?>
			<?php echo validation_errors(); ?>
			<div class="form-inline">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<?php echo $this->lang->line('login_username'); ?>
						</div>
						<div>
							<?php echo form_input(array(
							'name'=>'username',
							'class'=>'form-control',
							'placeholder'=>'username',
							'value'=>'cashier',
							'type'=>'text')); ?>
						</div>
					</div>
				</div>
			</div>
			<p>
			<div class="form-inline">
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<?php echo $this->lang->line('login_password'); ?> 
						</div>
						<div>
							<?php echo form_password(array(
							'name'=>'password',
							'class'=>'form-control',
							'placeholder'=>'password',
							'value'=>'boxpointofsale',
							'type'=>'password')); ?>
						</div>
					</div>			  
				</div>
			<p>
			<div>
				<?php echo form_submit(array(
				'class'=>'btn btn-primary btn-block',
				'value'=>'GO',
				)); ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div> 
</div>
</div>

<div id="footer" class="navbar-inverse text-center">
<div class="container">
<p class="text-muted">
<?php echo $this->lang->line('common_you_are_using_ospos'); ?> <?php echo $this->config->item('application_version'); ?>.
<?php echo $this->lang->line('common_please_visit_my'); ?>
<a href="http://boxpointofsale.com" target="_blank"><?php echo $this->lang->line('common_website'); ?></a>
<?php echo $this->lang->line('common_learn_about_project'); ?>.</p></div></div>

	<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script> 


</html>





