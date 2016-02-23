<?php
require_once ("secure_area.php");
class Config extends Secure_area 
{
	function __construct()
	{
		parent::__construct();
		
	}
	
	function index()
	{
		$location_names = array();
		$locations = $this->Stock_locations->get_location_names();
		foreach($locations->result_array() as $array) 
		{
			array_push($location_names, $array['location_name']);
		}
		$data['location_names'] = implode(',', $location_names);
		$this->load->view("config", $data);
	}
		
	function save()
	{
		$batch_save_data=array(
		'company'=>$this->input->post('company'),
		'address'=>$this->input->post('address'),
		'phone'=>$this->input->post('phone'),
		/** EdifyNowComment Line Commented : Start **/
		/**'email'=>$this->input->post('email'),**/
		/** EdifyNowComment Line Commented : Stop **/
		'fax'=>$this->input->post('fax'),
		'website'=>$this->input->post('website'),
		'default_tax_1_rate'=>$this->input->post('default_tax_1_rate'),		
		'default_tax_1_name'=>$this->input->post('default_tax_1_name'),		
		'default_tax_2_rate'=>$this->input->post('default_tax_2_rate'),	
		'default_tax_2_name'=>$this->input->post('default_tax_2_name'),		
		'currency_symbol'=>$this->input->post('currency_symbol'),
		'currency_side'=>$this->input->post('currency_side'),/**GARRISON ADDED 4/20/2013**/
		'return_policy'=>$this->input->post('return_policy'),
		'language'=>$this->input->post('language'),
		'timezone'=>$this->input->post('timezone'),
		'print_after_sale'=>$this->input->post('print_after_sale'),
        'tax_included'=>$this->input->post('tax_included'),
		'recv_invoice_format'=>$this->input->post('recv_invoice_format'),
		'sales_invoice_format'=>$this->input->post('sales_invoice_format'),
		'custom1_name'=>$this->input->post('custom1_name'),/**GARRISON ADDED 4/20/2013**/
		'custom2_name'=>$this->input->post('custom2_name'),/**GARRISON ADDED 4/20/2013**/
		'custom3_name'=>$this->input->post('custom3_name'),/**GARRISON ADDED 4/20/2013**/
		'custom4_name'=>$this->input->post('custom4_name'),/**GARRISON ADDED 4/20/2013**/
		'custom5_name'=>$this->input->post('custom5_name'),/**GARRISON ADDED 4/20/2013**/
		'custom6_name'=>$this->input->post('custom6_name'),/**GARRISON ADDED 4/20/2013**/
		'custom7_name'=>$this->input->post('custom7_name'),/**GARRISON ADDED 4/20/2013**/
		'custom8_name'=>$this->input->post('custom8_name'),/**GARRISON ADDED 4/20/2013**/
		'custom9_name'=>$this->input->post('custom9_name'),/**GARRISON ADDED 4/20/2013**/
		'custom10_name'=>$this->input->post('custom10_name')/**GARRISON ADDED 4/20/2013**/
		);
		
		$stock_locations = explode( ',', $this->input->post('stock_location'));
        $stock_locations_trimmed=array();
        foreach($stock_locations as $location)
        {
            array_push($stock_locations_trimmed, trim($location, ' '));
        }        
        $current_locations = $this->Stock_locations->concat_location_names()->location_names;
        if ($this->input->post('stock_locations') != $current_locations) 
        {
        	$this->load->library('sale_lib');
			$this->sale_lib->clear_sale_location();
			$this->sale_lib->clear_all();
			$this->load->library('receiving_lib');
			$this->receiving_lib->clear_stock_source();
			$this->receiving_lib->clear_stock_destination();
			$this->receiving_lib->clear_all();
        }
        
		if( $this->Appconfig->batch_save( $batch_save_data ) && $this->Stock_locations->array_save($stock_locations_trimmed))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('config_saved_successfully')));
		}
	}
	
	function test_email()
	{
		$mail_protocol_value=$this->Appconfig->get('mail_protocol');
		try{
		if($mail_protocol_value!="0")
		{
		$result=$this->AppEmailConfig->get($mail_protocol_value);
		$this->load->library('email');
		$this->load->library('google_oauth');
		if(!empty($result))
		{
			if($mail_protocol_value!='google_oauth')
					{
					if(!empty($result))
					{
				       
					$config['protocol'] = $result->protocol;
					$config['smtp_host']= $result->smtp_host;
					$config['smtp_user']= $result->smtp_user;
					$config['smtp_pass']= $result->smtp_password;
					$config['smtp_port']= $result->smtp_port;
					$config['smtp_crypto']= $result->smtp_certificate;
					}
					$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$this->email->from($result->email, $this->config->item('company'));
					$this->email->to($result->email);

					$this->email->subject($this->lang->line('test_email_subject')."(".$result->protocol."-".$result->smtp_certificate.")");
					$this->email->message($this->lang->line('test_email_message'));
					$send_result=$this->email->send();
						if($send_result!=null && $send_result==true)
							{
								echo json_encode(array('success'=>true,'message'=>$this->lang->line('email_config_test_email_success')));
							}else{
								echo json_encode(array('success'=>false,'message'=>$this->lang->line('email_config_test_email_failure')));
							}
					}else{
						//code to send email via google oauth
			     		if(!empty($result))
						{
							$config['application_name'] = $result->oauth_project_name;
							$config['client_id']= $result->oauth_client_id;
							$config['client_secret']= $result->oauth_client_secret;
							$config['redirect_uri']= 'index.php/oauth_callback/authenticate_google_oauth';
							$config['developer_key']= $result->oauth_developer_key;
							
							$this->google_oauth->initialize($config);
							
						if($this->google_oauth->check_oauth_authentication())
						 {							 
							//$this->google_oauth->authenticate_oauth();
							
							$this->google_oauth->to($this->google_oauth->get_logged_user_email_id());
							$this->google_oauth->from($result->email,$this->config->item('company'));
							$this->google_oauth->subject($this->lang->line('test_email_subject')."(".$result->protocol."-".$result->smtp_certificate.")");
							$this->google_oauth->message($this->lang->line('test_email_message'));
							
							$send_auth_result=$this->google_oauth->send_email();
							if($send_auth_result!=null && $send_auth_result==true)
							{
								echo json_encode(array('success'=>true,'message'=>$this->lang->line('email_config_test_email_success')));
							}else{
									echo json_encode(array('success'=>false,'message'=>$this->lang->line('email_config_test_email_failure')));
							}
						}else{
								echo json_encode(array('success'=>false,'message'=>$this->lang->line('google_oauth_not_connected')));
							}
						}
		    	     }
		
		     }
		}else{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('email_config_select_protocol_config')));
		} 
		  }catch (Exception $e) {
				print($e->getMessage());
				echo json_encode(array('success'=>false,'message'=>$e->getMessage()));
		  }
			
	}

}
?>