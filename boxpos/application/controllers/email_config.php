<?php
require_once ("secure_area.php");
class Email_Config extends Secure_area 
{
	public function __construct()
	{
		parent::__construct('config');
		$this->load->library('google_oauth');
	}
	function get()
	{
		$protocol=$this->input->post('protocol');
		
		echo json_encode($this->AppEmailConfig->get($protocol));
	}
	function get_selected_protocol()
	{
		echo json_encode(array('success'=>true,'mail_protocol'=>$this->Appconfig->get('mail_protocol')));
	}
	
	function index()
	{
		$protocol_names = array();
		$protocols = $this->AppEmailConfig->get_protocol_names();
		foreach($protocols->result_array() as $array) 
		{
			array_push($protocol_names, $array['protocol_name']);
		}
		$data['protocol_name'] = implode(',', $protocol_name);
		$this->load->view("email_config_form", $data);
	}
		
	function save()
	{
		$data=array(
		'protocol'=>$this->input->post('email_config_smtp_protocol'),
	    'email'=>$this->input->post('email_config_email_address'),
		'smtp_host'=>$this->input->post('email_config_smtp_host'),
		'smtp_user'=>$this->input->post('email_config_smtp_user'),
		'smtp_password'=>$this->input->post('email_config_smtp_pass'),
		'smtp_port'=>$this->input->post('email_config_smtp_port'),
		'smtp_certificate'=>$this->input->post('email_smtp_certificate'));
		if( $this->AppEmailConfig->save( $data ))
		{
			/**pass the key and value to save as reference**/
			if($this->Appconfig->save('mail_protocol',$data['protocol']))
			{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('email_config_saved_successfully')));
			}
		}else{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('email_config_error')));
		}
	}
	function view()
	{
		
		$mail_protocol_value=$this->Appconfig->get('mail_protocol');
		
		$result=$this->AppEmailConfig->get($mail_protocol_value);
		if(!empty($result))
		{
	
	    $data['email_config_email_address']= $result->email;
		$data['email_config_smtp_protocol'] = $result->protocol;
		$data['email_config_smtp_host']= $result->smtp_host;
		$data['email_config_smtp_user']= $result->smtp_user;
		$data['email_config_smtp_pass']= $result->smtp_password;
		$data['email_config_smtp_port']= $result->smtp_port;
		
		$data['email_config_oauth_project_name']= $result->oauth_project_name;
		$data['email_config_oauth_client_id']= $result->oauth_client_id;
		$data['email_config_oauth_client_secret']= $result->oauth_client_secret;
		$data['email_config_oauth_developer_key']= $result->oauth_developer_key;
		$data['email_smtp_certificate']= $result->smtp_certificate;
		$data['user_email']= $result->user_email;
		
		}else
		{
	    $data['email_config_email_address']= "";
		$data['email_config_smtp_protocol'] = "";
		$data['email_config_smtp_host']= "";
		$data['email_config_smtp_user']= "";
		$data['email_config_smtp_pass']= "";
		$data['email_config_smtp_port']= "";
		
		$data['email_config_oauth_project_name']= "";
		$data['email_config_oauth_client_id']= "";
		$data['email_config_oauth_client_secret']= "";
		$data['email_config_oauth_developer_key']= "";
		$data['email_smtp_certificate']= "";
		$data['user_email']= "";
		}
	
		$this->load->view("email_config_form",$data);
	}
	function connect_google_oauth()
	{
		$data=array('protocol'=>"google_oauth");
		
		$this->Appconfig->save('mail_protocol',$data['protocol']);
		
		$this->load->library('google_oauth');
		$mail_protocol_value=$this->Appconfig->get('mail_protocol');
		
		$result=$this->AppEmailConfig->get($mail_protocol_value);
		
		if(!empty($result))
		{
							$config['application_name'] = $result->oauth_project_name;
							$config['client_id']= $result->oauth_client_id;
							$config['client_secret']= $result->oauth_client_secret;
							$config['developer_key']= $result->oauth_developer_key;
							$config['redirect_uri']= 'index.php/oauth_callback/authenticate_google_oauth';
							
							
							$this->google_oauth->initialize($config);
											
							$this->google_oauth->redirect_to_authentication();
							
							$location_names = array();
							$locations = $this->Stock_locations->get_location_names();
							foreach($locations->result_array() as $array) 
							{
								array_push($location_names, $array['location_name']);
							}
							$data['location_names'] = implode(',', $location_names);
							$this->load->view("config", $data, false);
		}		
						
		}
	function check_oauth_authentication()
	{
		$data=array('protocol'=>"google_oauth");
		
		$this->Appconfig->save('mail_protocol',$data['protocol']);
		
		$this->load->library('google_oauth');
		$authentication_flag= $this->google_oauth->check_oauth_authentication();
		if($authentication_flag!=null && $authentication_flag=='true')
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('google_oauth_connected')));
		}else{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('google_oauth_not_connected')));
		}
		
	}
	function remove_user()
	{
		$result=$this->google_oauth->remove_user();
		if($result!=null && $result)
		{
			$data=array(
						'protocol'=>'google_oauth',
						'user_email'=>null,
						'user_token'=>null);
			$this->AppEmailConfig->save($data);
			$this->_reload_config_view();
		}else{
			$this->_reload_config_view();
		}
	}
	function _reload_config_view()
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
}
?>