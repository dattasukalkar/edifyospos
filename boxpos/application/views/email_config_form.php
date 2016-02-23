<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_messages"></ul>
<?php
echo form_open('email_config/save/',array('id'=>'email_config_form'));
?>
<fieldset id="email_config_info">
<legend><?php echo $this->lang->line("email_config"); ?></legend>

<div class="form-horizontal">

<div class="form-group">
<?php echo form_label($this->lang->line('email_config_smtp_protocol').':', 'name',array('class'=>'required col-md-4 control-label')); ?>

	<div class="col-md-8">
	<?php echo form_dropdown('email_config_smtp_protocol', array(
		'sendmail' => 'SendMail',
		'smtp' => 'SMTP',
		'google_oauth' => 'Google OAuth'), $email_config_smtp_protocol, 'id="protocol_dropdown"');?>
</div>
</div>
<div class="form-group" id="div_email_config_ssl">
	<?php echo form_label($this->lang->line('email_config_smtp_ssl_label').':', 'ssl',array('class'=>'col-md-4 control-label'));?>
<div class="col-md-8">
	<?php echo form_dropdown('email_smtp_certificate', array(
		'null' => 'None',
		'ssl' => 'SSL',
		'tls' => 'TLS',), $email_smtp_certificate, 'id="ssl_dropdown"');?>
</div>
</div>
<div class="form-group" id="div_email_config_smtp_port">
<?php echo form_label($this->lang->line('email_config_smtp_port').':', 'name',array('class'=>'required col-md-4 control-label')); ?>
	<div class="col-md-8">
	<?php echo form_input(array(
		'name'=>'email_config_smtp_port',
		'id'=>'email_config_smtp_port',
		'class'=>'form-control',
		'value'=>$email_config_smtp_port)
	);?>
	</div>
</div>	
<div class="form-group" id="div_email_config_email_address">
<?php echo form_label($this->lang->line('email_config_email_address').':', 'name',array('class'=>'required col-md-4 control-label')); ?>
	<div class="col-md-8">
	<?php echo form_input(array(
		'name'=>'email_config_email_address',
		'id'=>'email_config_email_address',
		'class'=>'form-control',
		'value'=>$email_config_email_address)
	);?>
	</div>
</div>
	
<!-- END GARRISON ADDED -->

<div class="form-group" id="div_email_config_smtp_host">
<?php echo form_label($this->lang->line('email_config_smtp_host').':', 'name',array('class'=>'required col-md-4 control-label')); ?>
	<div class="col-md-8">
	<?php echo form_input(array(
		'name'=>'email_config_smtp_host',
		'id'=>'email_config_smtp_host',
		'class'=>'form-control',
		'value'=>$email_config_smtp_host)
	);?>
	</div>
</div>

<div class="form-group" id="div_email_config_smtp_user">
<?php echo form_label($this->lang->line('email_config_smtp_user').':', 'name',array('class'=>'required col-md-4 control-label')); ?>
	<div class="col-md-8">
	<?php echo form_input(array(
		'name'=>'email_config_smtp_user',
		'id'=>'email_config_smtp_user',
		'class'=>'form-control',
		'value'=>$email_config_smtp_user)
	);?>
	</div>
</div>
<div class="form-group" id="div_email_config_smtp_pass">
<?php echo form_label($this->lang->line('email_config_smtp_pass').':', 'name',array('class'=>'required col-md-4 control-label')); ?>
	<div class="col-md-8">
	<?php echo form_input(array(
		'name'=>'email_config_smtp_pass',
		'id'=>'email_config_smtp_pass',
		'class'=>'form-control',
		'type'=>'password',
		'value'=>$email_config_smtp_pass)
	);?>
	</div>
</div>


<div class="form-group" id="div_email_config_submit">
<?php
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'btn btn-default')
);
?>
</div>
	</div>
</fieldset>

<?php
echo form_close();
?>
<div class="form-group" id="div_email_config_connect_google_oauth">
<?php echo form_label('', 'name',array('class'=>'col-md-4 control-label')); ?>
<div class="col-md-8" id="div_email_config_connect_google_oauth">
	
				<div id="connect_google_oauth">
					<?php echo form_open("",array('id'=>'connect_google_oauth_form')); 
					  echo "<div class='btn btn-default btn-block' style='float: left; margin_right:50px;' id='connect_google_oauth_button'><span>".$this->lang->line('connect_with_oauth_button')."</span></div>";
					 ?>
				</div>

		
</div>
</div>
<div id='div_user_details' class="col-md-8 col-sm-12 col-xs-12" style="float:right">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bookmark"></i>&nbsp;<?php echo $this->lang->line('logged_in_user_details'); ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6"><?php echo $this->lang->line('logged_user_address'); ?>:</div>
								<div class="form-group" id="div_connected_user">
								
								<?php 
								//if($user_email!=null)
								//	{
								 ?><div class="col-md-4">
									<?php echo form_input(array(
															'name'=>'email_config_user_email',
															'id'=>'email_config_user_email',
															'readonly'=>'true',
															'value'=>$user_email)
														   ); 
														   ?>
									
									</div>
											<div id="user_remove_button">
												<?php  
												echo anchor("email_config/remove_user",'&nbsp;<div id="remove_user_button" class="btn btn-default"><i class="fa fa-user-times"></i></div>');?>
										     </div>
											<?php
								//   }
								//  else { 
								   ?>	
									   <?php  //echo "No Connected User"  ?>
								  <?php 
								//  }
								 ?>									 
								</div>
							</div>				
						</div>
					</div>
						
</div>
<div id="feedback_bar"></div>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	if(!$('#email_config_user_email').val())
	{
		 $('#email_config_user_email').val('No Connected User');
		$("#remove_user_button").hide();
	}
	 $("#connect_google_oauth_button").click(function()
	    {
						
		$('#connect_google_oauth_form').attr('action', '<?php echo site_url("email_config/connect_google_oauth"); ?>');
		$('#connect_google_oauth_form').submit();
			
	    });
	$("#protocol_dropdown").change(check_protocol_type).ready(check_protocol_type)
	$("#ssl_dropdown").change(set_smtp_port).ready(set_smtp_port)
	
	$('#email_config_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				if(response.success)
				{
					tb_remove();
					set_feedback(response.message,'success_message',false);		
				}
				else
				{
					set_feedback(response.message,'error_message',true);		
				}
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_messages",
 		wrapper: "li",
		rules: 
		{
			email_config_email_address:
			{
				required:true,
				email:true
			}, 
			email_config_smtp_host: "required",
			email_config_smtp_user: "required",
			email_config_smtp_pass: "required",
			email_config_smtp_port: "required",
 		
    	 		
   		},
		messages: 
		{
     		email_config_email_address: 
			{
				required: "<?php echo $this->lang->line('email_config_email_required'); ?>",
				email:"<?php echo $this->lang->line('email_config_valid_email'); ?>"
			},
     		email_config_smtp_host: "<?php echo $this->lang->line('email_config_host_required'); ?>",
			email_config_smtp_user: "<?php echo $this->lang->line('email_config_user_required'); ?>",
			email_config_smtp_pass: "<?php echo $this->lang->line('email_config_pass_required'); ?>",
			email_config_smtp_port: "<?php echo $this->lang->line('email_config_port_required'); ?>",
     		
	
		}
	});
	
	
	$('#protocol_dropdown').change(function () {
					//get the drop down selected value
                    var selProtocol = $(this).attr('value');
                   
                    $.ajax({   
                        url: "index.php/email_config/get", 
                        type: "POST", 
                        data: {'protocol':selProtocol}, 
                        dataType: "json", 
                         
                        //This is the function which will be called if ajax call is successful.
                        success: function(data) {
                          //set the values to input field
							set_email_config_value(data);
                        }
                    })
	 });
	 
	 
	
});

//set the value selecting on protocol
function set_email_config_value(data)
	{
		$('#email_config_email_address').val(data['email']);
		$('#email_config_smtp_host').val(data['smtp_host']);
		$('#email_config_smtp_user').val(data['smtp_user']);
		$('#email_config_smtp_pass').val(data['smtp_password']);
		$('#email_config_smtp_port').val(data['smtp_port']);
		
	    $('#email_config_oauth_project_name').val(data['oauth_project_name']);
	    $('#email_config_oauth_client_id').val(data['oauth_client_id']);
		$('#email_config_oauth_client_secret').val(data['oauth_client_secret']);
		$('#email_config_oauth_developer_key').val(data['oauth_developer_key']);
		$('#email_config_user_email').val(data['user_email']);
		if(!data['user_email'])
			{
			  $('#email_config_user_email').val('No Connected User');
			  $("#remove_user_button").hide();
			  
			}else{
				$("#remove_user_button").show();
			}
	
	}
	//based on protocol type display the required fields
function check_protocol_type()
	{
	if ($("#protocol_dropdown").val() == "google_oauth")
	{
		$("#div_email_config_connect_google_oauth").show();
		$("#div_user_details").show();
		
		$("#div_email_config_submit").hide();
		$("#div_email_config_ssl").hide();
			
		$("#div_email_config_email_address").hide();
		$("#div_email_config_smtp_host").hide();
		$("#div_email_config_smtp_user").hide();
		$("#div_email_config_smtp_pass").hide();
		$("#div_email_config_smtp_port").hide();
		
	}else if($("#protocol_dropdown").val() == "smtp"){
		$("#div_email_config_smtp_host").show();
		$("#div_email_config_smtp_user").show();
		$("#div_email_config_smtp_pass").show();
		$("#div_email_config_smtp_port").show();
		$("#div_email_config_ssl").show();
		
		$("#div_email_config_connect_google_oauth").hide();
		$("#div_user_details").hide();
		$("#div_email_config_submit").show();
						
	}else if($("#protocol_dropdown").val() == "sendmail"){
		$("#div_email_config_smtp_host").show();
		$("#div_email_config_smtp_user").show();
		$("#div_email_config_smtp_pass").show();
		$("#div_email_config_smtp_port").show();
		$("#div_email_config_ssl").hide();
		$("#div_user_details").hide();
		$("#div_email_config_connect_google_oauth").hide();
		$("#div_email_config_submit").show();
						
	}
}
function set_smtp_port()
{
if ($("#ssl_dropdown").val() == "ssl")
	{
		$('#email_config_smtp_port').val('465');
	}else if($("#ssl_dropdown").val() == "tls"){
		$('#email_config_smtp_port').val('25');					
	}else if($("#ssl_dropdown").val() == "null")
	{
	   $('#email_config_smtp_port').val('25');
	}		
}
</script>
