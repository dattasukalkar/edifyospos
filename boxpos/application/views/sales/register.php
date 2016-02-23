<?php $this->load->view("partial/header"); ?>
<div id="title" class="page-header h1"><?php echo $this->lang->line('sales_register'); ?></div>

<?php
	if(isset($error))
	{
		echo "<div class='alert alert-warning'>".$error."</div>";
	}
	
	if (isset($warning))
	{
		echo "<div class='alert alert-danger'>".$warning."</div>";
	}
	
	if (isset($success))
	{
		echo "<div class='alert alert-success'>".$success."</div>";
	}
	?>

<div>

	<div class="col-md-8 col-sm-12 col-xs-12">
		
			
							
		
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-tag"></i>&nbsp;<?php echo $this->lang->line('common_module') ?></h3>
			</div>
<!-- 			Register Form -->
			<div class="panel-body">				
				<div class="form-horizontal form-register">
					<div class="form-group form-register">
						<?php echo form_open("sales/change_mode",array('id'=>'mode_form')); ?>
							<label class="col-md-4 control-label">
								<span><?php echo $this->lang->line('sales_mode') ?></span>
							</label>
						<div class="col-md-4">
							<?php echo form_dropdown('mode',$modes,$mode,'onchange="$(\'#mode_form\').submit();"'); ?>
							<?php if (count($stock_locations) > 1): ?>
							<span><?php echo $this->lang->line('sales_stock_location') ?></span>
							<?php echo form_dropdown('stock_location',$stock_locations,$stock_location,'onchange="$(\'#mode_form\').submit();"'); ?>
							<?php endif; ?>
						</div>
						<div id="show_suspended_sales_button" class="col-md-4">
							<?php echo anchor("sales/suspended/width:425",
								"<div class='btn btn-block btn-primary'><span class='glyphicon glyphicon-pause'></span>&nbsp;<span>".$this->lang->line('sales_suspended_sales')."</span></div>",
								array('class'=>'thickbox none','title'=>$this->lang->line('sales_suspended_sales')));
								?>
						</div>
						</form>
					</div>
				</div>

				<div class="form-horizontal form-register"">
					<div class="form-group form-register"">
						<?php echo form_open("sales/add",array('id'=>'add_item_form')); ?>
						<label class="col-md-4 control-label" id="item_label" for="item">
						<?php echo $this->lang->line('sales_find_or_scan_item_or_receipt');?>
						</label>
						<div class="col-md-4">
							<?php echo form_input(array('name'=>'item','id'=>'item','class'=>'form-control'));?>
						</div>
						<div id="new_item_button_register" class="col-md-4">
							<?php echo anchor("items/view/-1/width:360",
								"<div class='btn btn-primary btn-block'><span class='glyphicon glyphicon-plus'></span>&nbsp;<span>".$this->lang->line('sales_new_item')."</span></div>",
								array('class'=>'','title'=>$this->lang->line('sales_new_item')));
								?>
						</div>
						</form>
					</div>
				</div>
			</div>
		
		
			<div class="table-responsive">
				<table id="register" class="table">
					<thead>
						<tr>
							<th style="width: 10%;"><?php echo $this->lang->line('common_delete'); ?></th>
						<!--	<th style="width: 10%;"><?php echo $this->lang->line('sales_item_number'); ?></th> -->
							<th style="width: 25%;"><?php echo $this->lang->line('sales_item_name'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_price'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_quantity'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_discount'); ?></th>
							<th style="width: 10%;"><?php echo $this->lang->line('sales_total'); ?></th>
							<th style="width: 15%;"><?php echo $this->lang->line('sales_edit'); ?></th>
						</tr>
					</thead>
					<tbody id="cart_contents">
						<?php
							if(count($cart)==0)
							{
							?>
						<tr>
							<td colspan='8'>
								<div class='bg-danger' style='padding: 7px;'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
							</td>
						</tr>
						<?php
							}
							else
							{
								foreach(array_reverse($cart, true) as $line=>$item)
								{
									echo form_open("sales/edit_item/$line");
								?>
						<tr>
							<td><?php echo anchor("sales/delete_item/$line",'<i class="fa fa-trash"></i>');?></td>
							<!-- <td><?php echo $item['item_number']; ?></td> -->
							<td><?php echo $item['name']; ?>
								<span class="badge"><?php echo $item['in_stock'] ?></span>
								<?php echo form_hidden('location', $item['item_location']); ?>
							</td>
							<?php if ($items_module_allowed)
								{
								?>
							<td><?php echo form_input(array('name'=>'price','value'=>$item['price'],'class'=>'form-control'));?></td>
							<?php
								}
								else
								{
								?>
							<td><?php echo to_currency($item['price']); ?></td>
							<?php echo form_hidden('price',$item['price']); ?>
							<?php
								}
								?>
							<td>
								<?php
									if($item['is_serialized']==1)
									{
										echo $item['quantity'];
										echo form_hidden('quantity',$item['quantity']);
									}
									else
									{
										echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'class'=>'form-control'));
									}
									?>
							</td>
							<td><?php echo form_input(array('name'=>'discount','value'=>$item['discount'],'class'=>'form-control'));?></td>
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
							<td colspan=2 style="text-align: left;">
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
							<td>&nbsp;</td>
							<td style="color: #2F4F4F;">
								<?php
									if($item['is_serialized']==1)
									{
									echo $this->lang->line('sales_serial').':';
									}
									?>
							</td>
							<td colspan="4" style="text-align: left;">
								<?php
									if($item['is_serialized']==1)
									{
										echo form_input(array('name'=>'serialnumber','value'=>$item['serialnumber'],'size'=>'20'));
									}
									else
									{
									echo form_hidden('serialnumber', '');
									}
									?>
							</td>
						</tr>
						<tr style="height: 3px">
							<td colspan=8 style="background-color: white"></td>
						</tr>
						</form>
						<?php
							}
							}
							?>
					</tbody>
				</table>
			</div>
		</div>
	
		
	<!-- Sales Total Section -->
			<div id='sale_details' class="col-md-6">
					
					<?php
							if(count($cart) > 0)
							{
							?>
					
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-bookmark"></i>&nbsp;<?php echo $this->lang->line('sales_basic_information'); ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6"><?php echo $this->lang->line('sales_sub_total'); ?>:</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right"><?php echo to_currency($subtotal); ?></div>
							</div>

							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<?php foreach($taxes as $name=>$value) { ?>
									<?php echo $name; ?>:
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right">
									<?php echo to_currency($value); ?>
								</div>
							</div>			
						
							<div class="row">
								<?php }; ?>
							</div>

							<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6">
										<?php echo $this->lang->line('sales_total'); ?>:
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6 text-right">
										<?php echo to_currency($total); ?>
									</div>
							</div>
						</div>
					</div>
					
					
					<?php
				}
				?>
					
					
			</div><!-- Close Section -->
		
	<!-- Payments Ledger -->
			<div class="col-md-6">
				
				<?php
				// Only show this part if there is at least one payment entered.
				if(count($payments) > 0)
				{
				?>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-calculator"></i>&nbsp;<?php echo $this->lang->line('sales_payment') ?></h3>
					</div>
					<div class="panel-body">
					
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4"><?php echo $this->lang->line('common_delete'); ?></div>
									<div class="col-md-4 col-sm-4 col-xs-4"><?php echo $this->lang->line('sales_payment_type'); ?></div>
									<div class="col-md-4 col-sm-4 col-xs-4"><?php echo $this->lang->line('sales_payment_amount'); ?></div>
								</div>
							<div>
								<?php
									foreach($payments as $payment_id=>$payment)
									{
									echo form_open("sales/edit_payment/$payment_id",array('id'=>'edit_payment_form'.$payment_id));
									?>
								<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-4"><?php echo anchor( "sales/delete_payment/$payment_id", '<span class="fa fa-trash"></span>' ); ?></div>
									<div class="col-md-4 col-sm-4 col-xs-4"><?php echo $payment['payment_type']; ?></div>
									<div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo to_currency( $payment['payment_amount'] ); ?></div>
								</div>
								</form>
								<?php
									}
									?>
							</div>
					
					</div>
				</div>
				
				<?php
				}
				?>
				
							
			</div><!-- Close Section -->



			
	<!-- 	Sales Payment Totals Section -->
			<div class="col-md-12">
				
				<?php
				// Only show this part if there is at least one payment entered.
				if(count($cart) > 0)
				{
				?>
				
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $this->lang->line('sales_payments_total') ;?></h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<?php echo $this->lang->line('sales_payments_total').':';?>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 text-right">
								<?php echo to_currency($payments_total); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">
								<?php echo $this->lang->line('sales_amount_due').':';?>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6 text-right">
								<?php echo to_currency($amount_due); ?>
							</div>
						</div>
					</div>
				</div>
				
				<?php
				}
				?>
				
			</div> <!-- Close Section -->
		
		
	
	
	
	
	</div>
	
	</div> <!-- Close Column div -->
	
	
	
<!-- 	Customers Section -->

	<div class="col-md-4 col-sm-12 col-xs-12">
		<div class="panel panel-default"> <!-- Customers Div -->
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-street-view"></i>&nbsp;<?php echo $this->lang->line('module_customers') ;?></h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<?php
						if(isset($customer))
						{
							echo $this->lang->line("sales_customer").': <b>'.$customer. '</b>';
							echo anchor("sales/remove_customer",'&nbsp;<div class="btn btn-default"><i class="fa fa-user-times"></i></div></div></div></div>');
						}
						else
						{
							echo form_open("sales/select_customer",array('id'=>'select_customer_form')); ?>
					<label id="customer_label" class="control-label" for="customer"><?php echo $this->lang->line('sales_select_customer'); ?></label>
					<?php echo form_input(array('name'=>'customer','id'=>'customer','class'=>'form-control','value'=>$this->lang->line('sales_start_typing_customer_name')));?>
					</form>
				</div>
				<div class="form-group">
					<div>
						<label><?php echo $this->lang->line('common_or'); ?></label>
						<?php echo anchor("customers/view/-1/width:350",
							"<div class='btn btn-primary'><span><i class='fa fa-user-plus'>&nbsp;</i>".$this->lang->line('sales_new_customer')."</span></div>",
							array('class'=>'thickbox none','title'=>$this->lang->line('sales_new_customer')));
							?>
					</div>
				</div>
			</div>
		</div>


		<?php
			}
			?>

	
				<?php
					// Only show this part if there are Items already in the sale.
					if(count($cart) > 0)
					{
					?>

				<?php
					// Only show this part if there is at least one payment entered.
					if(count($payments) > 0)
					{
					?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-paperclip"></i>&nbsp;<?php echo $this->lang->line('common_comments'); ?></h3>
			</div>
			<div class="panel-body">				
				<div id="finish_sale">
					<?php echo form_open("sales/complete",array('id'=>'finish_sale_form')); ?>
					<?php echo form_textarea(array('name'=>'comment', 'id' => 'comment', 'value'=>$comment,'rows'=>'2','class'=>'form-control'));?>

					<?php
						if(!empty($customer_email))
						{
							echo $this->lang->line('sales_email_receipt'). ': '. form_checkbox(array(
								'name'        => 'email_receipt',
								'id'          => 'email_receipt',
								'value'       => '1',
								'checked'     => (boolean)$email_receipt,
								)).'<br />('.$customer_email.')<br />';
						}

// 						if ($payments_cover_total)
// 						{
// 							echo "<div class='btn btn-success btn-block' id='finish_sale_button'><span class='fa fa-check-square-o'></span>&nbsp;<span>".$this->lang->line('sales_complete_sale')."</span></div>";
// 						}
// 						echo "<div class='btn btn-warning btn-block' id='suspend_sale_button'><span class='fa fa-pause'></span>&nbsp;<span>".$this->lang->line('sales_suspend_sale')."</span></div>";
						?>
				</div>
				</form>

				
			</div>
		</div>
		
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-check-square-o"></i>&nbsp;<?php echo $this->lang->line('sales_complete_sale'); ?></h3>
			</div>
			<div class="panel-body">
				<?php
					if ($payments_cover_total)
						{
							echo "<div class='btn btn-success btn-block' id='finish_sale_button'><span class='fa fa-check-square-o'></span>&nbsp;<span>".$this->lang->line('sales_complete_sale')."</span></div>";
						}
						echo "<div class='btn btn-warning btn-block' id='suspend_sale_button'><span class='fa fa-pause'></span>&nbsp;<span>".$this->lang->line('sales_suspend_sale')."</span></div>";
						?>
			</div>
		</div>
		
		
			<?php
					}
					?>

		<div id="payment_details">
			<div>
				<div class="panel panel-default">
				<?php echo form_open("sales/add_payment",array('id'=>'add_payment_form')); ?>

					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;<?php echo $this->lang->line('sales_invoice_enable') ;?></h3>
					</div>
					<div class="panel-body">
						<?php if ($mode == "sale") 
							{
						?>
						<div class="col-md-6">
							<?php echo $this->lang->line('sales_invoice_enable') ;?>
							<?php if ($invoice_number_enabled)
								{
									echo form_checkbox(array('name'=>'sales_invoice_enable','id'=>'sales_invoice_enable','size'=>10,'checked'=>'checked'));
								}
								else
								{
									echo form_checkbox(array('name'=>'sales_invoice_enable','id'=>'sales_invoice_enable','size'=>10));
								}
								?>
						</div>
						<div class="">
							<div class="col-md-6">
								<?php echo $this->lang->line('sales_invoice_number').':   ';?>
							</div>
							<div class="col-md-6">
								<?php echo form_input(array('name'=>'sales_invoice_number','id'=>'sales_invoice_number','value'=>$invoice_number,'class'=>'form-control'));?>
							</div>
						</div>
					<?php 
						}
						?>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-credit-card"></i>&nbsp;<?php echo $this->lang->line('sales_payment').' ';?></h3>
					</div>
					<div class="panel-body">

						<table class="table table-responsive">
							<tr>
								<td width="50%"><span id="amount_tendered_label" name="amount_tendered_label"><?php echo $this->lang->line( 'sales_amount_tendered' ).': '; ?></span>
								</td>
								<td width"50%">
									<?php echo form_input( array( 'name'=>'amount_tendered', 'id'=>'amount_tendered', 'value'=>to_currency_no_money($amount_due), 'class'=>'form-control' ) );	?>
								</td>
								<td width"50%">
									<!-- 11/18 Invisible textbox is added with the help of which we can change payment type -->
									<input type="text" name="payment_type_temp" id="payment_type_temp" class="form-control" style="display: none" >
								</td>
							</tr>

							</form>
						</table>
					</div>
					<div class="panel-body">
						<div class="row">
								<!-- 11/18 replace form dropdown with buttons for tender types
								<?php echo form_dropdown( 'payment_type', $payment_options, array(), 'id="payment_types"' ); ?> -->
							<div class="col-md-6">
								<button type="button" class="btn btn-default btn-block" id = "cash_button" value="Cash" name = "cash_button"><i class="fa fa-money"></i>&nbsp;<?php echo $this->lang->line('sales_cash');?></button>
		                			</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-default btn-block" id = "check_button" value="Check" name = "check_button"><i class="fa fa-list-alt"></i>&nbsp;<?php echo $this->lang->line('sales_check');?></button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<button type="button" class="btn btn-default btn-block col-md-6" id = "debitCard_button" value="Debit Card" name = "debitCard_button"><i class="fa fa-square-o"></i>&nbsp;<?php echo $this->lang->line('sales_debit');?></button>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-default btn-block col-md-6" id = "creditCard_button" value="Credit Card" name="creditCard_button"><i class="fa fa-credit-card"></i>&nbsp;<?php echo $this->lang->line('sales_credit');?></button>
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-gift"></i>&nbsp;<?php echo $this->lang->line('giftcards_retrive_giftcard_info');?></h3>
					</div>
					<div class="panel-body">
						<div class="col-md-6">
							<button type="button" class="btn btn-default btn-block col-md-6" id = "giftCard_button" value="Gift Card" name = "giftCard_button"><i class="fa fa-search"></i>&nbsp;<?php echo $this->lang->line('common_search');?></button>
						</div>
						<div class="col-md-6">
							<!-- 11/18 Invisible Go button is added which is visible only when giftcard button clicked -->
							<button type="button" class="btn btn-default btn-block col-md-6" id = "go_button" value="Go" name="go_button"><i class="fa fa-check-square-o"></i>&nbsp;</button>
						</div>

						<!-- 11/18 Invisible text is added which is visible only when giftcard button clicked -->
						<span name="payment_type_temp" id="giftcardText" name = "giftcardText">Click On Go Button For Adding Gift Card Payment</span>
					</div>
				</div>




<!--				<div class="row">
						<div class="col-md-6">
							<span id="amount_tendered_label" name="amount_tendered_label"><?php echo $this->lang->line( 'sales_amount_tendered' ).': '; ?></span>
						</div>
						<div class="col-md-6">
							<?php echo form_input( array( 'name'=>'amount_tendered', 'id'=>'amount_tendered', 'value'=>to_currency_no_money($amount_due), 'class'=>'form-control' ) );	?>
						</div>
				</div>
				<div class="row">
-->							<!-- 11/18 Invisible textbox is added with the help of which we can change payment type -->
<!--							<input type="text" name="payment_type_temp" id="payment_type_temp" class="form-control" style="display: none" >
				
				</form>
-->			</div>
		</div>
			
	</div>
		<?php
			}
			?>
	</div>
</div>




<div class="clearfix" style="margin-bottom: 30px;">&nbsp;</div>

<div id="Cancel_sale">
	<?php echo form_open("sales/cancel_sale",array('id'=>'cancel_sale_form')); ?>
	<div class='btn btn-danger btn-block' id='cancel_sale_button'>
		<span class="fa fa-close"></span>
		<span><?php echo $this->lang->line('sales_cancel_sale'); ?></span>
	</div>
	</form>
</div>
							
<div class="clearfix" style="margin-bottom: 30px;">&nbsp;</div>
				
<script type="text/javascript" language="javascript">
	$(document).ready(function()
	{
	    $("#item").autocomplete('<?php echo site_url("sales/item_search"); ?>',
	    {
	    	minChars:0,
	    	max:100,
	    	selectFirst: false,
	       	delay:10,
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
	        $(this).val("<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
	    });
	
	    $('#item, #customer').focus(function()
	    {
	        if ($(this).val().match("<?php echo $this->lang->line('sales_start_typing_item_name') . '|' . 
		$this->lang->line('sales_start_typing_customer_name'); ?>"))
	        {
	            $(this).val('');
	        }
	    });
	
	    $("#customer").autocomplete('<?php echo site_url("sales/customer_search"); ?>',
	    {
	    	minChars:0,
	    	delay:10,
	    	max:100,
	    	formatItem: function(row) {
				return row[1];
			}
	    });
	
	    $("#customer").result(function(event, data, formatted)
	    {
			$("#select_customer_form").submit();
	    });
	
	    $('#customer').blur(function()
	    {
	    	$(this).val("<?php echo $this->lang->line('sales_start_typing_customer_name'); ?>");
	    });
		
		$('#comment').keyup(function() 
		{
			$.post('<?php echo site_url("sales/set_comment");?>', {comment: $('#comment').val()});
		});
	
		$('#sales_invoice_number').keyup(function() 
		{
			$.post('<?php echo site_url("sales/set_invoice_number");?>', {sales_invoice_number: $('#sales_invoice_number').val()});
		});
	
		var enable_invoice_number = function() 
		{
			var enabled = $("#sales_invoice_enable").is(":checked");
			if (enabled)
			{
				$("#sales_invoice_number").removeAttr("disabled").parents('tr').show();
			}
			else
			{
				$("#sales_invoice_number").attr("disabled", "disabled").parents('tr').hide();
			}
			return enabled;
		}
	
		enable_invoice_number();
		
		$("#sales_invoice_enable").change(function() {
			var enabled = enable_invoice_number();
			$.post('<?php echo site_url("sales/set_invoice_number_enabled");?>', {sales_invoice_number_enabled: enabled});
		});
		
		$('#email_receipt').change(function() 
		{
			$.post('<?php echo site_url("sales/set_email_receipt");?>', {email_receipt: $('#email_receipt').is(':checked') ? '1' : '0'});
		});
		
		
	    $("#finish_sale_button").click(function()
	    {
	    	if (confirm('<?php echo $this->lang->line("sales_confirm_finish_sale"); ?>'))
	    	{
	    		$('#finish_sale_form').submit();
	    	}
	    });
	
		$("#suspend_sale_button").click(function()
		{ 	
			if (confirm('<?php echo $this->lang->line("sales_confirm_suspend_sale"); ?>'))
	    	{
				$('#finish_sale_form').attr('action', '<?php echo site_url("sales/suspend"); ?>');
	    		$('#finish_sale_form').submit();
	    	}
		});
	
	    $("#cancel_sale_button").click(function()
	    {
	    	if (confirm('<?php echo $this->lang->line("sales_confirm_cancel_sale"); ?>'))
	    	{
	    		$('#cancel_sale_form').submit();
	    	}
	    });
	
		//call when cash_button click
		$("#cash_button").click(function()
		{
		    var inp = $("#amount_tendered").val();
            if((jQuery.trim(inp).length < 1)||(jQuery.trim(inp)<1))
            {
				//make go button and text invisible
		              $("#go_button").css("display","none");
			          $('#giftcardText').css("display","none");
			          $type_of_payment =($(this).attr("value"));
			    //set value of payment type
		              $('#payment_type_temp').val($type_of_payment);
		       // check type of payment
		              check_payment_type_gifcard();
			   //check validation Amount		  
                      alert("Please Enter Valid Amount");
					  $("#amount_tendered").focus();
            }
            else
            {			
			  //make go button and text invisible
		             $("#go_button").css("display","none");
			         $('#giftcardText').css("display","none");
			         $type_of_payment =($(this).attr("value"));
			  //set value of payment type
		             $('#payment_type_temp').val($type_of_payment);
		     // check type of payment
		             check_payment_type_gifcard();
    	    
		             $('#add_payment_form').submit();
			}
	    });
		
		//call when giftCard_button click
		
		$("#giftCard_button").click(function()
		{
		       $type_of_payment =($(this).attr("value"));
		   //set value of payment type
		       $('#payment_type_temp').val($type_of_payment);
		   // check type of payment
		       check_payment_type_gifcard();
		   //make go button and text visible
		      $("#go_button").css("display","inline");
		      $('#giftcardText').css("display","block");
		  
	    });
		
		//call when check_button click
		$("#check_button").click(function()
		{
			  var inp = $("#amount_tendered").val();
            if((jQuery.trim(inp).length < 1)||(jQuery.trim(inp)<1))
            {
				 $("#go_button").css("display","none")
		         $('#giftcardText').css("display","none");
		         $type_of_payment =($(this).attr("value"));
			 //set value of payment type
		         $('#payment_type_temp').val($type_of_payment);
			// check type of payment
		         check_payment_type_gifcard();
			//check validation Amount	 
                 alert("Please Enter Valid Amount");
			     $("#amount_tendered").focus();
            }
			else
			{
			//make go button and text invisible
		        $("#go_button").css("display","none")
		        $('#giftcardText').css("display","none");
		        $type_of_payment =($(this).attr("value"));
			 //set value of payment type
		        $('#payment_type_temp').val($type_of_payment);
			// check type of payment
		        check_payment_type_gifcard();	
		        $('#add_payment_form').submit();
			}
		   
	    });
		
		//call when creditcard button click
		$("#creditCard_button").click(function()
		{
			 var inp = $("#amount_tendered").val();
            if((jQuery.trim(inp).length < 1)||(jQuery.trim(inp)<1))
            {
               
			//make go button and text invisible	
		      $("#go_button").css("display","none");
		      $('#giftcardText').css("display","none");
		      $type_of_payment =($(this).attr("value"));
		   //set value of payment type
		      $('#payment_type_temp').val($type_of_payment);
		  // check type of payment
		      check_payment_type_gifcard(); 
		  //check validation Amount
			  alert("Please Enter Valid Amount");
			  $("#amount_tendered").focus();
            }
			else
		    {	
		  //make go button and text invisible	
		      $("#go_button").css("display","none");
		      $('#giftcardText').css("display","none");
		      $type_of_payment =($(this).attr("value"));
		   //set value of payment type
		      $('#payment_type_temp').val($type_of_payment);
		  // check type of payment
		      check_payment_type_gifcard(); 
		      $('#add_payment_form').submit();
			}

	    });
		
		//call when debitcard button click
		$("#debitCard_button").click(function()
		{
		    var inp = $("#amount_tendered").val();
            if((jQuery.trim(inp).length < 1)||(jQuery.trim(inp)<1))
            {
			//make go button and text invisible	
				$("#go_button").css("display","none");
				$('#giftcardText').css("display","none");
				$type_of_payment =($(this).attr("value"));
		   //set value of payment type
				$('#payment_type_temp').val($type_of_payment);
		   // check type of payment
				check_payment_type_gifcard();
           //check validation Amount				
               alert("Please Enter Valid Amount");
			   $("#amount_tendered").focus();
            }
			else
			{
				
			 //make go button and text invisible	
				$("#go_button").css("display","none");
				$('#giftcardText').css("display","none");
				$type_of_payment =($(this).attr("value"));
		   //set value of payment type
				$('#payment_type_temp').val($type_of_payment);
		   // check type of payment
				check_payment_type_gifcard(); 
				$('#add_payment_form').submit();
			}
		   
	    });
		
		//call when go button click
		$("#go_button").click(function()
		{
		    var inp = $("#amount_tendered").val();
			//check validation Gift Card Number
            if((jQuery.trim(inp).length < 1)||(jQuery.trim(inp)=="")||(jQuery.trim(inp)<1))
            {
               alert("Please Enter Valid Gift Card Number");
            }
			else
		    {		
				$('#payment_type_temp').val("Gift Card");
				$('#add_payment_form').submit();
			//make go button and text invisible	
				$("#go_button").css("display","none");
				$('#giftcardText').css("display","none");
			}
	    });
	
		
	});
	
	function post_item_form_submit(response)
	{
		if(response.success)
		{
	        var $stock_location = $("select[name='stock_location']").val();
	        $("#item_location").val($stock_location);
			$("#item").val(response.item_id);
			$("#add_item_form").submit();
		}
	}
	
	function post_person_form_submit(response)
	{
		if(response.success)
		{
			$("#customer").val(response.person_id);
			$("#select_customer_form").submit();
		}
	}
	
	function check_payment_type_gifcard()
	{
		if ($("#payment_type_temp").val() == "Gift Card")
		{
			$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_giftcard_number'); ?>");
			$("#amount_tendered").val('');
			$("#amount_tendered").focus();
		}
		else
		{
			$("#amount_tendered_label").html("<?php echo $this->lang->line('sales_amount_tendered'); ?>");		
		}
	}
	
</script>
<?php $this->load->view("partial/footer"); ?>
