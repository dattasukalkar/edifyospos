<?php $this->load->view("partial/header"); ?>
<div id="page_title" style="margin-bottom:8px;"><?php echo $this->lang->line('recvs_register'); ?></div>
<?php
	if(isset($error))
	{
		echo "<div class='error_message'>".$error."</div>";
	}
	?>
<div class="container-fluid">
	<div id="register_wrapper" class="col-md-6 col-sm-12 col-xs-12">
		<?php echo form_open("receivings/change_mode",array('id'=>'mode_form')); ?>
		
		
		<div class="form-horizontal">
			<div class="form-group">		
				<!-- <div class="input-group"> -->
					<div class="col-md-4">			
						<label><?php echo $this->lang->line('recvs_mode') ?></label>
					</div>
					<div class="col-md-8">
						<?php echo form_dropdown('mode',$modes,$mode,'onchange="$(\'#mode_form\').submit();"'); ?>
					</div>
				<!-- </div> -->
			</div>
		</div>	
		
		<?php 
			if ($show_stock_locations) 
			{
			?>
		<span><?php echo $this->lang->line('recvs_stock_source') ?></span>
		<?php echo form_dropdown('stock_source',$stock_locations,$stock_source,'onchange="$(\'#mode_form\').submit();"'); ?>
		<?php 
			if($mode=='requisition')
			{
			?>
		<span><?php echo $this->lang->line('recvs_stock_destination') ?></span>
		<?php echo form_dropdown('stock_destination',$stock_locations,$stock_destination,'onchange="$(\'#mode_form\').submit();"');        
			}
			}
			?>    
		</form>
		<?php echo form_open("receivings/add",array('id'=>'add_item_form')); ?>
		<div class="form-horizontal">
			<div class="form-group">	
				<div class="col-md-4">	
					<label id="item_label" for="item">
					<?php
						if($mode=='receive' or $mode=='requisition')
						{
							echo $this->lang->line('recvs_find_or_scan_item');
						}
						else
						{
							echo $this->lang->line('recvs_find_or_scan_item_or_receipt');
						}
						?>
					</label>
				</div>
				<div class="col-md-8">
					<div class="input-group">
						<div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
						<?php echo form_input(array('name'=>'item','id'=>'item','class'=>'form-control'));?>
					</div>
				
				<div id="new_item_button_register" >
						<?php echo anchor("items/view/-1/width:360",
							"<div class='btn btn-default btn-block'><span>".$this->lang->line('sales_new_item')."</span></div>",
							array('class'=>'thickbox none','title'=>$this->lang->line('sales_new_item')));
							?>
					</div>
				</div>
			</div>	
		</form>
		</div>
		<!-- Receiving Items List -->
		<table id="register" class="table table-responsive">
			<thead>
				<tr>
					<th style="width:11%;"><?php echo $this->lang->line('common_delete'); ?></th>
					<th style="width:30%;"><?php echo $this->lang->line('recvs_item_name'); ?></th>
					<th style="width:11%;"><?php echo $this->lang->line('recvs_cost'); ?></th>
					<th style="width:5%;"><?php echo $this->lang->line('recvs_quantity'); ?></th>
					<th style="width:6%;"></th>
					<th style="width:11%;"><?php echo $this->lang->line('recvs_discount'); ?></th>
					<th style="width:15%;"><?php echo $this->lang->line('recvs_total'); ?></th>
					<th style="width:11%;"><?php echo $this->lang->line('recvs_edit'); ?></th>
				</tr>
			</thead>
			<tbody id="cart_contents">
				<?php
					if(count($cart)==0)
					{
					?>
				<tr>
					<td colspan='8'>
						<div class='text-danger'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
				</tr>
				</tr>
				<?php
					}
					else
					{
						foreach(array_reverse($cart, true) as $line=>$item)
						{
							echo form_open("receivings/edit_item/$line");
						
					?>
				<tr>
					<td><?php echo anchor("receivings/delete_item/$line",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'.$this->lang->line('common_delete').'');?></td>
					<td style="align:center;"><?php echo $item['name']; ?><br><span class="badge"><?php echo $item['in_stock']; ?></span>in <?php echo $item['stock_name']; ?>
						<?php echo form_hidden('location', $item['item_location']); ?>
					</td>
					<?php if ($items_module_allowed && !$mode=='requisition')
						{
						?>
					<td><?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
					<?php
						}
						else
						{
						?>
					<td><?php echo $item['price']; ?></td>
					<?php echo form_hidden('price',$item['price']); ?>
					<?php
						}
						?>
					<td>
						<?php
							echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'class'=>'form-control'));
							if ($item['receiving_quantity'] > 1) 
							{
							?>
					</td>
					<td>x <?php echo $item['receiving_quantity']; ?></td>
					<?php 
						}
						else
						{
						?>
					<td></td>
					<?php 
						}
						?>
					<?php       
						if ($items_module_allowed && $mode!='requisition')
						   {
						?>
					<td><?php echo form_input(array('name'=>'discount','value'=>$item['discount'],'class'=>'form-control'));?></td>
					<?php
						}
						else
						{
						?>
					<td><?php echo $item['discount']; ?></td>
					<?php echo form_hidden('discount',$item['discount']); ?>
					<?php
						}
						?>
					<td><?php echo to_currency($item['price']*$item['quantity']-$item['price']*$item['quantity']*$item['discount']/100); ?></td>
					<td><?php echo form_submit("edit_item", $this->lang->line('sales_edit_item'));?></td>
				</tr>
				<tr>
					<?php 
						if($item['allow_alt_description']==1)
						{
						?>
					<td style="color: #2F4F4F;"><?php echo $this->lang->line('sales_description_abbrv').':';?></td>
					<?php 
						} 
						?>
					<td colspan="2" style="text-align: left;">
						<?php
							if($item['allow_alt_description']==1)
							{
								echo form_input(array('name'=>'description','value'=>$item['description'],'size'=>'20'));
							}
							else
							{
							if ($item['description']!='')
							{
							echo $item['description'];
									echo form_hidden('description',$item['description']);
								}
								else
								{
									echo $this->lang->line('sales_no_description');
										echo form_hidden('description','');
								}
							}
							?>
					</td>
					<td colspan="5"></td>
				</tr>
				</form>
				<?php
					}
					}
					?>
			</tbody>
		</table>
	</div>
	<!-- Overall Receiving -->

	<div id="overall_sale" col-md-6 col-sm-12 col-xs-12>
	<?php
		if(isset($supplier))
		{
			echo $this->lang->line("recvs_supplier").': <b>'.$supplier. '</b><br />';
			echo anchor("receivings/delete_supplier",'['.$this->lang->line('common_delete').' '.$this->lang->line('suppliers_supplier').']');
		}
		else
		{
			echo form_open("receivings/select_supplier",array('id'=>'select_supplier_form')); ?>
	<div class="form-inline">
		<div class="form-group">
			<div class="col-md-4">
				<label id="supplier_label" for="supplier"><?php echo $this->lang->line('recvs_select_supplier'); ?></label>
			</div>
			<div class="input-group col-md-8">
					<div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
			<?php echo form_input(array('name'=>'supplier','id'=>'supplier','class'=>'form-control','value'=>$this->lang->line('recvs_start_typing_supplier_name')));?>
			</div>
			</div>
			</form>
	<div>
		<div class="col-md-4">
			<?php echo $this->lang->line('common_or'); ?>
		</div>
		<div class="col-md-8">		
		<?php echo anchor("suppliers/view/-1/width:350",
			"<div class='btn btn-default btn-block' style='margin:0 auto;'><span>".$this->lang->line('recvs_new_supplier')."</span></div>",
			array('class'=>'thickbox none','title'=>$this->lang->line('recvs_new_supplier')));
			?>
		</div>
	</div>
	
	<div class="clearfix">&nbsp;</div>
	<?php
		}
		?>
	<?php
		if($mode != 'requisition')
		{
		?>
	<table class="table table-responsive">
		<div id='sale_details'>
			<tr>
				<td><div><?php echo $this->lang->line('sales_total'); ?>:</div></td>
				<td><div><?php echo to_currency($total); ?></div></td>
			</tr>
		</div>
	</table>	
	<?php 
		}
		?>
	<?php
		if(count($cart) > 0)
		{
			if($mode == 'requisition')
			{
			?>
	
		<div id="finish_sale">
			<?php echo form_open("receivings/requisition_complete",array('id'=>'finish_receiving_form')); ?>
			<br />
			
			<table class="table table-responsive">
				<tr>			
					<td><?php echo $this->lang->line('common_comments'); ?></td>
				</tr>
				<tr>
					<td><?php echo form_textarea(array('name'=>'comment','id'=>'comment','value'=>$comment,'class'=>'form-control','rows'=>'2'));?></td>
				</tr>

			</table>
			
			<div class='small_button' id='finish_receiving_button' style='float:right;margin-top:5px;'>
				<span><?php echo $this->lang->line('recvs_complete_receiving') ?></span>
			</div>
			</form>    
			<?php echo form_open("receivings/cancel_receiving",array('id'=>'cancel_receiving_form')); ?>
			<div class='small_button' id='cancel_receiving_button' style='float:left;margin-top:5px;'>
				<span><?php echo $this->lang->line('recvs_cancel_receiving')?></span>
			</div>
			</form>
		</div>
		<?php
			}
			else
			{
			?>
		<div id="finish_sale">
			<?php echo form_open("receivings/complete",array('id'=>'finish_receiving_form')); ?>
			
			<table class="table table-responsive">
				<tr>			
					<td><?php echo $this->lang->line('common_comments'); ?></td>
				</tr>
				<tr>
					<td><?php echo form_textarea(array('name'=>'comment','id'=>'comment','value'=>$comment,'class'=>'form-control','rows'=>'2'));?></td>
				</tr>
			</table>
			
			<table class="table table-responsive">
				<?php if ($mode == "receive") 
					{
					?>
				<tr>
					<td>
						<?php echo $this->lang->line('recvs_invoice_enable'); ?>
					</td>
					<td>
						<?php if ($invoice_number_enabled)
							{
								echo form_checkbox(array('name'=>'recv_invoice_enable','id'=>'recv_invoice_enable','size'=>10,'checked'=>'checked'));
							}
							else
							{
								echo form_checkbox(array('name'=>'recv_invoice_enable','id'=>'recv_invoice_enable','size'=>10));
							}
							?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $this->lang->line('recvs_invoice_number').':   ';?>
					</td>
					<td>
						<?php echo form_input(array('name'=>'recv_invoice_number','id'=>'recv_invoice_number','value'=>$invoice_number,'class'=>'form-control'));?>
					</td>
				</tr>
				<?php 
					}
					?>
				<tr>
					<td>
						<?php
							echo $this->lang->line('sales_payment').':   ';?>
					</td>
					<td>
						<?php
							echo form_dropdown('payment_type',$payment_options);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							echo $this->lang->line('sales_amount_tendered').':   ';?>
					</td>
					<td>
						<?php
							echo form_input(array('name'=>'amount_tendered','value'=>'','class'=>'form-control'));
							?>
					</td>
				</tr>
			</table>
			<div>
				<div class="col-md-6">
						<div class='btn btn-default btn-block' id='finish_receiving_button' style='float:right;margin-top:5px;'>
							<span><?php echo $this->lang->line('recvs_complete_receiving') ?></span>
						</div>
						</form>
				</div>
				<div class="col-md-6">
						<?php echo form_open("receivings/cancel_receiving",array('id'=>'cancel_receiving_form')); ?>
						<div class='btn btn-default btn-block' id='cancel_receiving_button' style='float:left;margin-top:5px;'>
							<span><?php echo $this->lang->line('recvs_cancel_receiving')?></span>
				</div>
			</div>
			</div>
			</form>
		</div>
		<?php
			}
			}
			?>
	</div>
</div>



<script type="text/javascript" language="javascript">
	$(document).ready(function()
	{
	    $("#item").autocomplete('<?php echo site_url("receivings/item_search"); ?>',
	    {
	    	minChars:0,
	    	max:100,
	       	delay:10,
	       	selectFirst: false,
	    	formatItem: function(row) {
				return row[1];
			}
	    });
	
	    $("#item").result(function(event, data, formatted)
	    {
			$("#add_item_form").submit();
	    });
	
		$('#item').blur(function()
	    {
	    	$(this).attr('value',"<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
	    });
	
		$('#comment').keyup(function() 
		{
			$.post('<?php echo site_url("receivings/set_comment");?>', {comment: $('#comment').val()});
		});
	
		$('#recv_invoice_number').keyup(function() 
		{
			$.post('<?php echo site_url("receivings/set_invoice_number");?>', {recv_invoice_number: $('#recv_invoice_number').val()});
		});
	
		var enable_invoice_number = function() 
		{
			var enabled = $("#recv_invoice_enable").is(":checked");
			if (enabled)
			{
				$("#recv_invoice_number").removeAttr("disabled").parents('tr').show();
			}
			else
			{
				$("#recv_invoice_number").attr("disabled", "disabled").parents('tr').hide();
			}
			return enabled;
		}
	
		enable_invoice_number();
	
		$("#recv_invoice_enable").change(function() {
			var enabled = enable_invoice_number();
			$.post('<?php echo site_url("receivings/set_invoice_number_enabled");?>', {recv_invoice_number_enabled: enabled});
			
		});
	
		$('#item,#supplier').click(function()
	    {
	    	$(this).attr('value','');
	    });
	
	    $("#supplier").autocomplete('<?php echo site_url("receivings/supplier_search"); ?>',
	    {
	    	minChars:0,
	    	delay:10,
	    	max:100,
	    	formatItem: function(row) {
				return row[1];
			}
	    });
	
	    $("#supplier").result(function(event, data, formatted)
	    {
			$("#select_supplier_form").submit();
	    });
	
	    $('#supplier').blur(function()
	    {
	    	$(this).attr('value',"<?php echo $this->lang->line('recvs_start_typing_supplier_name'); ?>");
	    });
	
	    $("#finish_receiving_button").click(function()
	    {
	    	if (confirm('<?php echo $this->lang->line("recvs_confirm_finish_receiving"); ?>'))
	    	{
	    		$('#finish_receiving_form').submit();
	    	}
	    });
	
	    $("#cancel_receiving_button").click(function()
	    {
	    	if (confirm('<?php echo $this->lang->line("recvs_confirm_cancel_receiving"); ?>'))
	    	{
	    		$('#cancel_receiving_form').submit();
	    	}
	    });
	
	
	});
	
	function post_item_form_submit(response)
	{
		if(response.success)
		{
			$("#item").attr("value",response.item_id);
			$("#add_item_form").submit();
		}
	}
	
	function post_person_form_submit(response)
	{
		if(response.success)
		{
			$("#supplier").attr("value",response.person_id);
			$("#select_supplier_form").submit();
		}
	}
	
</script>
<?php $this->load->view("partial/footer"); ?>
