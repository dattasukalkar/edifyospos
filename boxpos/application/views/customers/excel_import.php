<?php $this->load->view("partial/headerpopup"); ?>
<div class="container-fluid">

<?php
echo form_open_multipart('customers/do_excel_import/',array('id'=>'item_form'));
?>

<div class="page-header h1">Import customers from Excel sheet</div>

<ul class="bg-danger" id="error_message_box"></ul>

<div class="panel panel-default">
	<div class="panel-heading">Template
	</div>
	<div class="panel-body">
	<a href="<?php echo site_url('customers/excel'); ?>">Download Import Excel Template (CSV)</a>
	</div>
</div>


<fieldset id="item_basic_info">

<div class="panel panel-default">
	<div class="panel-heading">Import
	</div>
	<div class="panel-body">
		<div class="field_row clearfix">
			<?php echo form_label('File path:', 'name',array('class'=>'')); ?>
		</div>
		<div class="form-group">
			<?php echo form_upload(array(
			'name'=>'file_path',
			'id'=>'file_path',
			'class'=>'',
			'value'=>'')
			);?>
		</div>

		<div class="form-group">
			<?php
			echo form_submit(array(
			'name'=>'submitf',
			'id'=>'submitf',
			'value'=>$this->lang->line('common_submit'),
			'class'=>'btn btn-default btn-block')
			);
			?>
		</div>
	</div>
</div>
</fieldset>
<?php 
echo form_close();
?>
</div>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{	
	$('#item_form').validate({
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
			file_path:"required"
   		},
		messages: 
		{
   			file_path:"Full path to excel file required"
		}
	});
});
</script>
</div>
<?php $this->load->view("partial/footer"); ?>

