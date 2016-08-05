<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class License extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();
	
		$dsn      = 'mysql:dbname='.$this->db->database.';host='.$this->db->hostname;
		$username = $this->db->username;
		$password = $this->db->password;

		// Autoloading (composer is preferred, but for this example let's just do this)
		require_once(FCPATH.'/sgAuth/OAuth2/Autoloader.php');
		OAuth2\Autoloader::register();

		// $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=my_oauth2_db;host=localhost"
		$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

		// Pass a storage object or array of storage objects to the OAuth2 server class
		$server = new OAuth2\Server($storage);

		// Add the "Client Credentials" grant type (it is the simplest of the grant types)
		$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

		// Add the "Authorization Code" grant type (this is where the oauth magic happens)
// 		$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

		$grantType = new OAuth2\GrantType\RefreshToken($storage);

		// add the grant type to your OAuth server
		$server->addGrantType($grantType);
		
		// Handle a request to a resource and authenticate the access token
		if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
// 			$server->getResponse()->send();
			header('Content-Type: application/json');
			echo json_encode(array('status' => 0, 'msg' => 'Authentication Failed'));
			exit;
		}
		
		$this->load->model('Terminal_model');
	}
	
	public function index()
	{
		header('Content-Type: application/json');
		echo json_encode(array('status' => 1, 'msg' => 'Test success'));
	}
	
	function checkLicense() {
		header('Content-Type: application/json');
		$msg = '';
		$status = 0;
		
		if(isset($_POST['license']) && $_POST['license'] != '') {
			//check whether the license valid
			$terminal = $this->Terminal_model->validateLicense($_POST['license']);
			if (count($terminal) > 0) {
				$status = 1;
				$msg = 'Valid';
			}
			else {
				$msg = 'Invalid License Key';
			}
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}
	
	
}
