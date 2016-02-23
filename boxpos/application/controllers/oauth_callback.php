<?php
require_once ("secure_area.php");
class Oauth_Callback extends Secure_area 
{
	function __construct()
	{
		parent::__construct();
		 $this->load->library('google_oauth');
		
	}
	public function authenticate_google_oauth()
	{
		 if (isset($_GET['code'])) 
		  {
			  $mail_protocol_value=$this->Appconfig->get('mail_protocol');
			  $result=$this->AppEmailConfig->get($mail_protocol_value);
			  $this->load->library('google_oauth');
				if(!empty($result))
					{  
					$config['application_name'] = $result->oauth_project_name;
					$config['client_id']= $result->oauth_client_id;
					$config['client_secret']= $result->oauth_client_secret;
					$config['redirect_uri']= 'index.php/oauth_callback/authenticate_google_oauth';
					$config['developer_key']= $result->oauth_developer_key;
							
					$this->google_oauth->initialize($config);
						
					$this->google_oauth->authenticate_oauth_code($_GET['code']);
					}
		}else if(isset($_GET['error'])) 
		{
			header('Location: ' . filter_var(base_url()."/index.php/config", FILTER_SANITIZE_URL));
		}
	}
}
?>