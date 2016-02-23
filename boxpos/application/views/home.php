<?php $this->load->view("partial/header"); ?>

<div class="page-header h1"><?php echo $this->lang->line('common_welcome_message'); ?></div>
	<?php
	foreach($allowed_modules->result() as $module)
	{
		if (sizeof(explode('_', $module->module_id)) == 1)
		{
	?>
	
	<div class="col-md-3 col-sm-4 hidden-xs">
	<div class="hovereffect">
		<img src="<?php echo base_url().'images/home/'.$module->module_id.'.png';?>" class="img-responsive center-block img-thumbnail">
		<div class="overlay">
		<a href="<?php echo site_url("$module->module_id");?>">
		<h2>
			<?php echo $this->lang->line("module_".$module->module_id) ?>
		</h2>
		
		<p><?php echo $this->lang->line('module_'.$module->module_id.'_desc');?></p>
		</a></div>
	</div>
	</div>
	
	<div class="hidden-lg hidden-md hidden-sm col-xs-4">
        <a href="<?php echo site_url("$module->module_id");?>">
        <img src="<?php echo base_url().'images/home/'.$module->module_id.'.png';?>" class="img-responsive center-block img-thumbnail">
	<div class="text-center"><?php echo $this->lang->line("module_".$module->module_id) ?></div>
        </a>
        </div>




	<?php
			}
		}
		?>


	</div>
</div>







<?php $this->load->view("partial/footer"); ?>
