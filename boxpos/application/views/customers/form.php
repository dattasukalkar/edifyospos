<?php $this->load->view("partial/headerpopup"); ?>
<div class="container-fluid">

<?php
echo form_open('customers/save/'.$person_info->person_id,array('id'=>'customer_form'));
?>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="customer_basic_info">

<div class="page-header h1"><?php echo $this->lang->line("customers_basic_information"); ?></div>
<?php $this->load->view("people/form_basic_info"); ?>
<div class="form-horizontal">
<div class="form-group">
<?php echo form_label($this->lang->line('customers_account_number').':', 'account_number',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_input(array(
		'name'=>'account_number',
		'id'=>'account_number',
		'class'=>'form-control',
		'value'=>$person_info->account_number)
	);?>
	</div>
</div>

<div class="form-group">
<?php echo form_label($this->lang->line('customers_taxable').':', 'taxable',array('class'=>'col-md-4 col-sm-4 control-label')); ?>
	<div class="col-md-8 col-sm-8">
	<?php echo form_checkbox
('taxable', '1', $person_info->taxable == '' ? TRUE : (boolean)$person_info->taxable);?>
	</div>
</div>

</div>

<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-default btn-block',)
);
?>
</fieldset>
<?php 
echo form_close();
?>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#customer_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				tb_remove();
				post_person_form_submit(response);
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			first_name: "required",
			last_name: "required",
    		email: "email"
   		},
		messages: 
		{
     		first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
     		last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
     		email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>"
		}
	});
});
</script>

</div>
<?php $this->load->view("partial/footer"); ?>
