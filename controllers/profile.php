<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		
		//only admin can access
		if ($this->session->userdata('user_type') == null)
			redirect('login');
			
		$this->load->model('Customer_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all Customers
	public function index() {
		$data['title'] = 'Profile';
		$data['subtitle'] = 'User profile';
		
		$data['active'] = 'profile';
		
		if (isset($_GET['pid']) && $_GET['pid'] != '') {
			$data['profile'] = $this->Customer_model->getCustomerById($_GET['pid']);
			$this->load->view('customer/profileView', $data);
		}
		
		else
			redirect('invoice');
	}
	
	function changePass() {
		$data['title'] = 'Profile';
		$data['subtitle'] = 'Change Password';
		
		$data['active'] = 'profile';
		
		if (isset($_POST['pass']) && $_POST['pass'] != '') {
			$pass = md5($_POST['pass']);
			$sql = '';
			if ($this->session->userdata('user_type') == 'admin') {
			
				$id = $this->session->userdata('admin')->{'admin_id'};
				
				$sql = "update admin set admin_pass = '$pass' where admin_id = $id";
				
			}
			else if ($this->session->userdata('user_type') == 'manager') {
				$id = $this->session->userdata('manager')->{'m_id'};
				$sql = "update manager set m_pass = '$pass' where m_id = $id";
			}
			else if ($this->session->userdata('user_type') == 'director') {
				$id = $this->session->userdata('director')->{'dr_id'};
				$sql = "update director set dr_pass = '$pass' where dr_id = $id";
			}
			else if ($this->session->userdata('user_type') == 'agent') {
				$id = $this->session->userdata('agent')->{'agent_id'};
				$sql = "update agent set agent_pass = '$pass' where agent_id = $id";
			}
			else if ($this->session->userdata('user_type') == 'customer') {
				$id = $this->session->userdata('customer')->{'customer_id'};
				$sql = "update customer set customer_pass = '$pass' where customer_id = $id";
			}
			if ($sql != '') {
				$this->db->query($sql);
				$this->session->set_userdata('success', 'Password updated');	
			}
		}
		$this->load->view('changePass', $data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */