<?php
namespace aw2\linkedin;

\aw2_library::add_service('linkedin','linkedin api support',['namespace'=>__NAMESPACE__]);


\aw2_library::add_service('linkedin.login_url','returns the login URL for linkedin',['namespace'=>__NAMESPACE__]);

function login_url($atts,$content=null,$shortcode){
	if(\aw2_library::pre_actions('all',$atts,$content)==false)return;
	extract(\aw2_library::shortcode_atts( array(
	'ticket_id'=>null,
	'scope'=>null,
	'app_id'=>null,
	'app_secret'=>null
	), $atts) );
	
	$redirect_url = SITE_URL.'?social_auth=linkedin';
	
	if(empty($ticket_id)) return '';
	if(empty($app_id) || empty($app_secret)) return '';	
	
	$return_value='';
	
	$provider = new \League\OAuth2\Client\Provider\LinkedIn([
		'clientId'          =>  $app_id,
		'clientSecret'      =>  $app_secret,
		'redirectUri'       =>  $redirect_url,
	]);
	
	$scope = \aw2\session_ticket\get(["main"=>$ticket_id,"field"=>'scope'],null,null);
	//$scopes= explode(',',$scope);
	
	$options = [
        'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
        'scope' => $scope // array or string
    ];
	
	$authorizationUrl = $provider->getAuthorizationUrl($options);
	$return_value = $provider->getAuthorizationUrl($options);
  
    \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'state',"value"=>$provider->getState()],null,null); // save state for future validation
	
    \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'redirect_url',"value"=>$redirect_url],null,null); // save state for future validation
	
	$return_value=\aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;	
}


\aw2_library::add_service('linkedin.auth','Check the auth for linkedin',['namespace'=>__NAMESPACE__]);

function auth($atts,$content=null,$shortcode){
	if(\aw2_library::pre_actions('all',$atts,$content)==false)return;
	extract(\aw2_library::shortcode_atts( array(
	'ticket_id'=>null,
	'scope'=>null,
	'app_id'=>null,
	'app_secret'=>null
	), $atts) );
	
	$redirect_url = SITE_URL.'?social_auth=linkedin';
	
	if(empty($ticket_id)) return '';
	if(empty($app_id) || empty($app_secret)) return '';	
	
	
	if (isset($_GET['error']) || !isset($_GET['code'])) {
	  \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'status',"value"=>'error'],null,null);
	  \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'description',"value"=>$_REQUEST['error_description']],null,null);
	  return;
	}
		
	$provider = new \League\OAuth2\Client\Provider\LinkedIn([
		'clientId'          =>  $app_id,
		'clientSecret'      =>  $app_secret,
		'redirectUri'       =>  $redirect_url,
	]);
	
	 try {
            // you have to set initially used redirect url to be able
            // to retrieve access token
            // retrieve access token using code provided by LinkedIn
            $accessToken = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
			
           \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'access_token',"value"=>$accessToken],null,null);
		   
			$user = $provider->getResourceOwner($accessToken);

			$return_value['firstName'] = $user->getFirstName();
			$return_value['lastName'] = $user->getLastName();
			$return_value['id'] = $user->getId();
			$return_value['emailAddress'] = $user->getEmail();
			$return_value['publicProfileUrl'] = $user->getUrl();
			$return_value['pictureUrl'] = $user->getImageUrl();
            
        } catch (Exception $exception) {
            // in case of failure, provide with details
            \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'status',"value"=>'error'],null,null);
			\aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'description',"value"=>$exception->getMessage()],null,null);
			return;
        }
	  \aw2\session_ticket\set(["main"=>$ticket_id,"field"=>'status',"value"=>'success'],null,null);

	$return_value=\aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;	
}
if(IS_WP){
	\add_action( 'wp', 'aw2\linkedin\auth_check', 11 );
	
	function auth_check(){

		if(!isset($_REQUEST['social_auth'])) return;
		
		if($_REQUEST['social_auth'] !== 'linkedin') return;
		
		$ticket_id = $_COOKIE['linkedin_login'];
		
		$query_string=explode('&',$_SERVER["QUERY_STRING"]);

		array_shift($query_string);
		
		$query_string =  implode('&',$query_string);
		
		$app_path = \aw2\session_ticket\get(["main"=>$ticket_id,"field"=>'app_path'],null,null);
		
		

		wp_redirect($app_path.'/t/'.$ticket_id.'?'.$query_string);

		die();
	}
}