<?php
require_once "./google-api-php-client/src/Google/autoload.php";
set_include_path(get_include_path() . PATH_SEPARATOR . './google-api-php-client/src');
require "./google-api-php-client/src/Google/Client.php";
require "./google-api-php-client/src/Google/Service/Oauth2.php";
require "./google-api-php-client/src/Google/Service/Gmail.php";

/**
 * google_oauth
 *
 * @package 
 * @author hasmer salubre
 * @access public
 */
class google_oauth {
	var $CI;

	var	$application_name = "";		// Application name
	var	$client_id		  = "";
	var	$client_secret	  = "";	
	var	$redirect_uri	  = '';	
	var	$developer_key	  = "";		
	var	$scope		      = array('https://www.googleapis.com/auth/gmail.compose','https://www.googleapis.com/auth/userinfo.email');
	var $to					="";
	var $company			="";
	var $from				="";	
	var $message			="";
	var $subject			="";
    var $service			="";
	var $client				="";

	var $google_oauth_protocol='google_oauth';
  	function __construct()
	{
		
		$this->CI =& get_instance();
		$this->CI->load->model('appemailconfig','',TRUE);
	}
	
	 function set_application_name($application_name)
		{
			$this->application_name=$application_name;
		}
		
	 function set_client_id($client_id)
		{
			$this->client_id=$client_id;
		}
		
	 function set_client_secret($client_secret)
		{
			$this->client_secret=$client_secret;
		}
		
	 function set_redirect_uri($redirect_uri)
		{
			$this->redirect_uri=$redirect_uri;
		}
		
	 function set_developer_key($developer_key)
		{
			$this->developer_key=$developer_key;
		}
		
	 function to($to)
		{
			$this->to=$to;
		}
		
     function from($from,$company)
		{
			$this->from=$from;
			$this->company=$company;
		}
		
	 function subject($subject)
		{
			$this->subject=$subject;
		}

	 function message($message)
		{
			$this->message = rtrim(str_replace("\r", "", $message));

			if ( ! is_php('5.4') && get_magic_quotes_gpc())
			{
				$this->message = stripslashes($this->message);
			}
			return $this;
		}
		
	public function encodeRecipients($recipient){
		
		$recipientsCharset = 'utf-8';
		if (preg_match("/(.*)<(.*)>/", $recipient, $regs)) {
			$recipient = '=?' . $recipientsCharset . '?B?'.base64_encode($regs[1]).'?= <'.$regs[2].'>';
		}
		return $recipient;
	}
	
	//initialize the attributes value
	public function initialize($config)
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$method = 'set_'.$key;

				if (method_exists($this, $method))
				{
					$this->$method($val);
				}
				else
				{
					$this->$key = $val;
				}
			}
		}
		
		return $this;
	}
	
	public function getClient()
		{
			// Create Client Request to access Google API
				$client = new Google_Client();
				$client->setApplicationName($this->application_name);
				$client->setClientId($this->client_id);
				$client->setClientSecret($this->client_secret);
				$client->setRedirectUri(base_url().$this->redirect_uri);
				$client->setDeveloperKey($this->developer_key);
				$client->addScope($this->scope);
				$client->setApprovalPrompt('force');
				$client->setAccessType('offline');
				return $client;
		}
	//function to get the authentication of oauth	
	public function authenticate_oauth() 
		{
			$client = $this->getClient();
			$result=$this->CI->AppEmailConfig->get($this->google_oauth_protocol);
			if($result!=null)
			{
			  if ($result->user_token!=null)
				{
				$client->setAccessToken($result->user_token);
				if($client->isAccessTokenExpired()) 
				 { 
						//if token is expired then refreshing the token
						$NewAccessToken = json_decode($client->getAccessToken());
						$client->refreshToken($NewAccessToken->refresh_token);
						$client->setAccessToken($client->getAccessToken());
				 }
				} else {
				$client = $this->getClient();
				$authUrl = $client->createAuthUrl();
				$data['authUrl'] = $authUrl;
				header("Location: " . $authUrl);
				}
	       }
		}
		
	public function redirect_to_authentication() 
		{
			$client = $this->getClient();
		    $result=$this->CI->AppEmailConfig->get($this->google_oauth_protocol);
			if($result!=null)
			{
			  if ($result->user_token!=null)
				{
					$client->setAccessToken($result->user_token);
					if($client->isAccessTokenExpired()) 
					{ 
						//if token is expired then refreshing the token
						$NewAccessToken = json_decode($client->getAccessToken());
						$client->refreshToken($NewAccessToken->refresh_token);
						$client->setAccessToken($client->getAccessToken());
					}
					$client = $this->getClient();
					$authUrl = $client->createAuthUrl();
					header("Location: " . $authUrl);			
				} else {
				$client = $this->getClient();
				$authUrl = $client->createAuthUrl();
				$data['authUrl'] = $authUrl;
				header("Location: " . $authUrl);		
				}
		  }
		}
		
	public function check_oauth_authentication() 
		{
			$client = $this->getClient();
			$result=$this->CI->AppEmailConfig->get($this->google_oauth_protocol);
			if($result!=null)
			{
				  if ($result->user_token!=null)
					{
						return true;
						} else {
						return false;
				    }
			}else{
				return false;
				echo "App email configuration is getting null";
			}
		}
  public function get_logged_user_email_id() 
		{
			$client = $this->getClient();
			$result=$this->CI->AppEmailConfig->get($this->google_oauth_protocol);
			if($result!=null)
			{
				
				$client->setAccessToken($result->user_token);
				if($client->isAccessTokenExpired()) 
				 { 
						//if token is expired then refreshing the token
						$NewAccessToken = json_decode($client->getAccessToken());
						$client->refreshToken($NewAccessToken->refresh_token);
						$client->setAccessToken($client->getAccessToken());
				 }
				$objOAuthService = new Google_Service_Oauth2($client);
				$userData = $objOAuthService->userinfo->get();
				return $userData->email;
			}else{
				echo "App email configuration is getting null";
			}
		}
	//function to get the authenrication based on the code	
	public function authenticate_oauth_code($code) 
		{
			$client = $this->getClient();
			$client->authenticate($code);
			if($client->getAccessToken()!=null)
			{
				$client->setAccessToken($client->getAccessToken());
				$objOAuthService = new Google_Service_Oauth2($client);
				$userData = $objOAuthService->userinfo->get();
				$data=array(
						'protocol'=>'google_oauth',
						'user_email'=>$userData->email,
						'user_token'=>$client->getAccessToken());
				$this->CI->AppEmailConfig->save($data);
			}
			header('Location: ' . filter_var(base_url()."/index.php/config", FILTER_SANITIZE_URL));
		  
		}
	//function to provide the email generation and send functionality	
	public function send_email()
		{
				$client = $this->getClient();
				$result=$this->CI->AppEmailConfig->get($this->google_oauth_protocol);
				if($result!=null)
				{
				if ($result->user_token!=null) 
				{
					$client->setAccessToken($result->user_token);
				} else {
					$client = $this->getClient();
					$authUrl = $client->createAuthUrl();
					header("Location: " . $authUrl);
				}
		  if ($client->getAccessToken()) {
			  			  
				 if($client->isAccessTokenExpired()) 
				 { 
						//if token is expired then refreshing the token
						$NewAccessToken = json_decode($client->getAccessToken());
						$client->refreshToken($NewAccessToken->refresh_token);
						$client->setAccessToken($client->getAccessToken());
				 }
				   $data=array(
						'protocol'=>'google_oauth',
						'user_token'=>$client->getAccessToken());
				$this->CI->AppEmailConfig->save($data);
			// Prepare the message in email to send
			try {
					$strRawMessage = "";
					$boundary = uniqid(rand(), true);
					$subjectCharset = $charset = 'utf-8';
					$strToMailName = '';
					$strToMail = $this->to;
					$strSesFromName = $this->company;
					$strSesFromEmail = $this->from;
					$strSubject = $this->subject;
					$strRawMessage .= 'To: ' . $this->encodeRecipients($strToMailName . " <" . $strToMail . ">") . "\r\n";
					$strRawMessage .= 'From: '. $this->encodeRecipients($strSesFromName . " <" . $strSesFromEmail . ">") . "\r\n";
						
					$strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
						
					$strRawMessage .= 'Message: =?' . $subjectCharset . '?B?' . base64_encode($strSubject) . "?=\r\n";
						
					$strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
					$strRawMessage .= 'Content-type: text/html; boundary="' . $boundary . '"' . "\r\n";
						
					$strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
					$strRawMessage .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
					$strRawMessage .= $this->message . "\r\n";
													
					// The message needs to be encoded in Base64URL
					$mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
					$msg = new Google_Service_Gmail_Message();
					$msg->setRaw($mime);
					$service = new Google_Service_Gmail($client);
					return $service->users_messages->send("me", $msg);
								
			} catch (Exception $e) {
				print($e->getMessage());
			   }
			
		}
	}
		}
		public function remove_user() 
		{
			$client = $this->getClient();
			$result=$this->CI->AppEmailConfig->get($this->google_oauth_protocol);
			if($result!=null)
			{
			  if ($result->user_token!=null)
				{
					$client->setAccessToken($result->user_token);
					if($client->isAccessTokenExpired()) 
					{ 
						//if token is expired then refreshing the token
						$NewAccessToken = json_decode($client->getAccessToken());
						$client->refreshToken($NewAccessToken->refresh_token);
						$client->setAccessToken($client->getAccessToken());
					}
					return $client->revoketoken();
				}
			}
			
					  
		}

} 