<?php $this->load->view("partial/header"); ?>
<div class="container-fluid">
<div class="page-header h1" id="page_title"><?php echo $this->lang->line('reports_reports'); ?></div>

<div id="welcome_message" class="body"><h5><?php echo $this->lang->line('reports_welcome_message'); ?></h5>

<ui id="report_list">

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $this->lang->line('reports_summary_reports'); ?></h3>
		</div>
		<div class="panel-body">
			<?php 
			foreach($grants as $grant) 
			{
				if (!preg_match('/reports_(inventory|receivings)/', $grant['permission_id']))
				{
					show_report('summary',$grant['permission_id']);
				}
			}
			?>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading"> 
			<h3 class="panel-title"><?php echo $this->lang->line('reports_graphical_reports'); ?></h3>
		</div>
		<div class="panel-body">
                        <?php
                        foreach($grants as $grant)
                        {
                                if (!preg_match('/reports_(inventory|receivings)/', $grant['permission_id']))
                                {
                                        show_report('graphical_summary',$grant['permission_id']);
                                }
                        }
                        ?>
		</div>
	</div>
</div>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $this->lang->line('reports_detailed_reports'); ?></h3>
		</div>
		<div class="panel-body">
		<?php
			$person_id = $this->session->userdata('person_id');
			show_report_if_allowed('detailed', 'sales', $person_id);
			show_report_if_allowed('detailed', 'receivings', $person_id);
			show_report_if_allowed('specific', 'customer', $person_id, 'reports_customers');
			show_report_if_allowed('specific', 'discount', $person_id, 'reports_discounts');
			show_report_if_allowed('specific', 'employee', $person_id, 'reports_employees');
		?>
		</div>
	</div>

	<?php
	if ($this->Employee->has_grant('reports_inventory', $this->session->userdata('person_id')))
	{
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $this->lang->line('reports_inventory_reports'); ?></h3>
		</div>
		<div class="panel-body">
		<?php 
			show_report('', 'reports_inventory_low');	
			show_report('', 'reports_inventory_summary');
		?>
		</div>
	</div>


		</ul>

	<?php 
	}
	?>
</div>
</div>
<?php
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<?php $this->load->view("partial/footer"); ?>
