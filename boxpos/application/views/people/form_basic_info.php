<div class="form-horizontal">
<div class="form-group">
<?php echo form_label($this->lang->line('common_first_name').':', 'first_name',array('class'=>'required col-md-4 col-sm-4 control-label')); ?>
<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'first_name',
		'id'=>'first_name',
		'type'=>'text',
		'class'=>'form-control',
		'value'=>$person_info->first_name)
	);?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_last_name').':', 'last_name',array('class'=>'required col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'last_name',
		'id'=>'last_name',
		'class'=>'form-control',
		'type'=>'text',
		'value'=>$person_info->last_name)
	);?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_email').':', 'email',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'class'=>'form-control',
		'type'=>'email',
		'value'=>$person_info->email)
	);?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_phone_number').':', 'phone_number',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'phone_number',
		'id'=>'phone_number',
		'class'=>'form-control',
		'type'=>'tel',
		'value'=>$person_info->phone_number));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_address_1').':', 'address_1',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'address_1',
		'id'=>'address_1',
		'class'=>'form-control',
		'value'=>$person_info->address_1));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_address_2').':', 'address_2',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'address_2',
		'id'=>'address_2',
		'class'=>'form-control',
		'value'=>$person_info->address_2));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_city').':', 'city',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'city',
		'id'=>'city',
		'class'=>'form-control',
		'value'=>$person_info->city));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_state').':', 'state',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'state',
		'id'=>'state',
		'class'=>'form-control',
		'value'=>$person_info->state));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_zip').':', 'zip',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'zip',
		'id'=>'zip',
		'class'=>'form-control',
		'value'=>$person_info->zip));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_country').':', 'country',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'country',
		'id'=>'country',
		'class'=>'form-control',
		'value'=>$person_info->country));?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('common_comments').':', 'comments',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_textarea(array(
		'name'=>'comments',
		'id'=>'comments',
		'value'=>$person_info->comments,
		'rows'=>'5',
		'class'=>'form-control',
		'cols'=>'17')
	);?>
	</div>
</div>
</div>
