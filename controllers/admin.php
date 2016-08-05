<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		
		if ($this->session->userdata('user_type') == null)
			redirect('login');
		if ($this->session->userdata('user_type') != 'admin')
			exit;
// 			redirect('login');
			
		$this->load->model('Admin_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all admin
	public function index() {
		$data['title'] = 'Administrator';
		$data['subtitle'] = 'Admin Lists';
		
		$data['active'] = 'admin';
		
		$per_page = 20;
		$data['per_page'] = $per_page;
		
		$limit = $per_page;
		$offset = 0;
		
		$search = null;
		if (isset($_GET['search']) && $_GET['search'] != '') {
			$search = $_GET['search'];
		}

		if (isset($_GET['p']) && $_GET['p'] != '') {
			$offset = ($_GET['p'] -1) * $per_page;
		}
		else if (isset($_GET['p']) && $_GET['p'] == '')
			$offset = 0;
			
		$qStr = $_GET;
		if (isset($qStr['p']))
			unset($qStr['p']);
			
		$data['admins'] = $this->Admin_model->getAllAdmin($limit, $offset, $search);
		
		$config['base_url'] = base_url().'admin?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Admin_model->getAllAdmin(null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
		$this->load->view('admin/adminListView', $data);
	}
	
	public function addAdmin() {
		$data['title'] = 'Administrator';
		$data['subtitle'] = 'Add Admin Account';
		$data['active'] = 'admin';
		$data['admin_name'] = $data['admin_pass'] = $data['admin_email'] = '';
		
		//add new
		if (isset($_POST['admin_name'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('admin_name', 'Admin name', 'required');
			$this->form_validation->set_rules('admin_email', 'Admin email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('admin_pass', 'Admin password', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$admin_data['admin_name'] = $_POST['admin_name'];
				$admin_data['admin_email'] = $_POST['admin_email'];
				$admin_data['admin_pass'] = md5($_POST['admin_pass']);
				$admin_data['admin_created_date'] = date('Y-m-d H:i:s');
				
				$this->Admin_model->addAdmin($admin_data);
				$this->session->set_userdata('success', 'New admin account added');
				redirect('admin');
			}
		}
		
		$this->load->view('admin/addAdminView', $data);
	}
	
	public function editAdmin() {
		$data['subtitle'] = 'Edit Admin';
		$data['title'] = 'Administrator';
		$data['active'] = 'admin';
		
		//get admin detail
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$admin = $this->Admin_model->getAdminById($_GET['id']);
			//if no admin found
			if (count($admin) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['admin'] = $admin;
				$data['admin_name'] = $admin->{'admin_name'};
				$data['admin_email'] = $admin->{'admin_email'};
				$data['admin_pass'] = '';
			}
		}
		//submit update
		else if (isset($_POST['admin_id'])) {
			$admin = $this->Admin_model->getAdminById($_POST['admin_id']);
			if (count($admin) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['admin'] = $admin;
				$data['admin_name'] = $admin->{'admin_name'};
				$data['admin_email'] = $admin->{'admin_email'};
				$data['admin_pass'] = '';
			}
			
			//validate
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			$this->form_validation->set_rules('admin_name', 'Admin name', 'required');
			$this->form_validation->set_rules('admin_email', 'Admin email', 'required|valid_email|callback_email_check['.$_POST['admin_id'].']');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//update
				$admin_data['admin_name'] = $_POST['admin_name'];
				$admin_data['admin_email'] = $_POST['admin_email'];
				if ($_POST['admin_pass'] != '') {
					$admin_data['admin_pass'] = md5($_POST['admin_pass']);
				}
				$this->Admin_model->updateAdmin($_POST['admin_id'], $admin_data);
				
				$admin = $this->Admin_model->getAdminById($_POST['admin_id']);
				$data['admin'] = $admin;
				$data['admin_name'] = $admin->{'admin_name'};
				$data['admin_email'] = $admin->{'admin_email'};
				$data['admin_pass'] = '';
				
				$this->session->set_userdata('success', 'Admin updated');
			}
		}
		else {
			$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
		}
		$this->load->view('admin/editAdminView', $data);
	}
	
	function email_check($email, $admin_id = null) {
	  if ($this->Admin_model->checkDuplicateEmail($email, $admin_id)) {
			$this->form_validation->set_message('email_check', 'The %s is already registered');
			return FALSE;
	  } 
	  else {
			return TRUE;
	  }
	}
	
	public function deleteAdmin() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$this->Admin_model->deleteAdmin($_GET['id']);
			$this->session->set_userdata('success', 'Admin deleted');
			redirect('admin');
		}
	}
	
	function transferInvoice() {
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */