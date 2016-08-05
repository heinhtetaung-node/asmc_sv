<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
	 
	function __construct(){
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Manager_model');
		$this->load->model('Agent_model');
		$this->load->model('Customer_model');
		$this->load->model('Director_model');
		$this->load->library('form_validation');
	}
	
	public function index()
	{
		//if already logon, go home
		if ($this->session->userdata('user_type') == 'admin')
			redirect('admin');
		else if ($this->session->userdata('user_type') == 'manager')
			redirect('agent');
		else if ($this->session->userdata('user_type') == 'agent')
			redirect('message');
		else if ($this->session->userdata('user_type') == 'customer')
			redirect('profile');
		else if ($this->session->userdata('user_type') == 'director')
			redirect('manager');
			
		$data = array();
		$data['useremail'] = $data['password'] = '';
		
		if (isset($_POST['useremail']) && isset($_POST['password'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			$this->form_validation->set_rules('useremail', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				if ($_POST['group'] == 1) {
				 	$admin = $this->Admin_model->loginAdmin($_POST['useremail'], $_POST['password']);
				 	if ($admin !== false) {
				 		$this->session->set_userdata('admin', $admin);
				 		$this->session->set_userdata('user_type', 'admin');
				 		
				 		redirect('admin');
				 	}
				 	else {
				 		$this->session->set_userdata('error', 'Admin email or password incorrect');
				 	}
				}
				else if ($_POST['group'] == 2) {
					$manager = $this->Manager_model->loginManager($_POST['useremail'], $_POST['password']);
				 	if ($manager !== false) {
				 		$this->session->set_userdata('manager', $manager);
				 		$this->session->set_userdata('user_type', 'manager');
				 		
				 		redirect('agent');
				 	}
				 	else {
				 		$this->session->set_userdata('error', 'Manager email or password incorrect');
				 	}
				}
				else if ($_POST['group'] == 3) {
					$agent = $this->Agent_model->loginAgent($_POST['useremail'], $_POST['password']);
				 	if ($agent !== false) {
				 		$this->session->set_userdata('agent', $agent);
				 		$this->session->set_userdata('user_type', 'agent');
				 		
				 		redirect('message');
				 	}
				 	else {
				 		$this->session->set_userdata('error', 'Agent email or password incorrect');
				 	}
				}
				else if ($_POST['group'] == 4) {
					$customer = $this->Customer_model->loginCustomer($_POST['useremail'], $_POST['password']);
				 	if ($customer !== false) {
				 		$this->session->set_userdata('customer', $customer);
				 		$this->session->set_userdata('user_type', 'customer');
				 		
				 		redirect('profile/?pid='.$customer->{"customer_id"});
				 	}
				 	else {
				 		$this->session->set_userdata('error', 'Customer email or password incorrect');
				 	}
				}
				else if ($_POST['group'] == 5) {
					$director = $this->Director_model->loginDirector($_POST['useremail'], $_POST['password']);
				 	if ($director !== false) {
				 		$this->session->set_userdata('director', $director);
				 		$this->session->set_userdata('user_type', 'director');
				 		
				 		redirect('manager');
				 	}
				 	else {
				 		$this->session->set_userdata('error', 'Customer email or password incorrect');
				 	}
				}
			}
		}
		
		$this->load->view('loginView', $data);
	}
	
	public function logout() {
		//reset session based on login user type
		if ($this->session->userdata('user_type') == 'admin')
			$this->session->unset_userdata('admin');
		else if ($this->session->userdata('user_type') == 'manager')
			$this->session->unset_userdata('manager');
		else if ($this->session->userdata('user_type') == 'agent')
			$this->session->unset_userdata('agent');
		else if ($this->session->userdata('user_type') == 'customer')
			$this->session->unset_userdata('customer');
		else if ($this->session->userdata('user_type') == 'director')
			$this->session->unset_userdata('director');
		
		$this->session->unset_userdata('user_type');
		redirect('login');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */