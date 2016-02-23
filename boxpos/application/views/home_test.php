<?php $this->load->view("partial/header"); ?>

<h5 class="text-center"><?php echo $this->lang->line('common_welcome_message'); ?></h5>

<!-- 
<div id="home_module_list">
	<div class="container-fluid">
		<?php
		foreach($allowed_modules->result() as $module)
		{
			if (sizeof(explode('_', $module->module_id)) == 1)
			{
		?>
		<div class="btn-home col-md-4 col-sm-4 col-xs-4">
			<div class="btn btn-default btn-lg btn-block module_item">
				<a href="<?php echo site_url("$module->module_id");?>">
				<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" border="0" alt="Menubar Image" />
				<div>
				<h5><?php echo $this->lang->line("module_".$module->module_id) ?></h5>
				</div>
				<p>
				<h5><div class="small hidden-sm hidden-xs"><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></h5>
				</div>
				</a>
			</div>
		</div>
		<?php
			}
		}
		?>
	</div>
</div>
 -->



<div class="row">
	<?php
	foreach($allowed_modules->result() as $module)
	{
		if (sizeof(explode('_', $module->module_id)) == 1)
		{
	?>
	<div class="col-sm-4 col-md-4 col-xs-4 col-menu">
		<a href="<?php echo site_url("$module->module_id");?>">
		<div class="thumbnail btn">
		  <img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>">
		  <div class="caption">
			<h5><?php echo $this->lang->line("module_".$module->module_id) ?></h5>
			<div class="hidden-xs"><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></div>
			</a>
		  </div>
		</div>
	</div>
	<?php
			}
		}
		?>
</div>









<?php $this->load->view("partial/footer"); ?>
