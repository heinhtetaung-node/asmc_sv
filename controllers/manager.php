<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends CI_Controller {

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
		if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'director')
			exit;
			
		$this->load->model('Manager_model');
		$this->load->model('Director_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all managers
	public function index() {
		$data['title'] = 'Managers';
		$data['subtitle'] = 'Manager Lists';
		
		$data['active'] = 'manager';
		
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
			
		$dr_id = null;
		if ($this->session->userdata('user_type') == 'director')
			$dr_id = $this->session->userdata('director')->{'dr_id'};
			
		$data['managers'] = $this->Manager_model->getAllManager($dr_id,$limit, $offset, $search);
		
		$config['base_url'] = base_url().'manager?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Manager_model->getAllManager($dr_id,null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
		$this->load->view('manager/managerListView', $data);
	}
	
	public function addManager() {
		$data['title'] = 'Manager';
		$data['subtitle'] = 'Add Manager Account';
		$data['active'] = 'manager';
		$data['m_name'] = $data['m_pass'] = $data['m_email'] = $data['m_code'] = '';
		$data['directors'] = $this->Director_model->getAllDirector();
		
		//add new
		if (isset($_POST['m_name'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('m_name', 'Manager name', 'required');
			$this->form_validation->set_rules('m_email', 'Manager email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('m_pass', 'Manager password', 'required');
			$this->form_validation->set_rules('m_code', 'Manager code', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$manager_data['m_name'] = $_POST['m_name'];
				$manager_data['m_email'] = $_POST['m_email'];
				$manager_data['m_pass'] = md5($_POST['m_pass']);
				$manager_data['m_code'] = $_POST['m_code'];
				$manager_data['m_created_date'] = date('Y-m-d H:i:s');
				if ($_POST['m_upline'] != '')
					$manager_data['m_upline'] = $_POST['m_upline'];
					
				$this->Manager_model->addManager($manager_data);
				$this->session->set_userdata('success', 'New manager account added');
				redirect('manager');
			}
		}
		
		$this->load->view('manager/addManagerView', $data);
	}
	
	public function editManager() {
		$data['subtitle'] = 'Edit Manager';
		$data['title'] = 'Manager';
		$data['active'] = 'manager';
		$data['directors'] = $this->Director_model->getAllDirector();
		
		//get admin detail
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$manager = $this->Manager_model->getManagerById($_GET['id']);
			//if no admin found
			if (count($manager) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['manager'] = $manager;
				$data['m_name'] = $manager->{'m_name'};
				$data['m_email'] = $manager->{'m_email'};
				$data['m_code'] = $manager->{'m_code'};
				$data['m_pass'] = '';
				if ($manager->{"m_upline"} != '' && $manager->{'m_upline'} != null)
					$data['m_upline'] = $manager->{'m_upline'};
			}
		}
		//submit update
		else if (isset($_POST['m_id'])) {
			$manager = $this->Manager_model->getManagerById($_POST['m_id']);
			if (count($manager) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['manager'] = $manager;
				$data['m_name'] = $manager->{'m_name'};
				$data['m_email'] = $manager->{'m_email'};
				$data['m_code'] = $manager->{'m_code'};
				$data['m_pass'] = '';
				if ($manager->{"m_upline"} != '' && $manager->{'m_upline'} != null)
					$data['m_upline'] = $manager->{'m_upline'};
			}
			
			//validate
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			$this->form_validation->set_rules('m_name', 'Manager name', 'required');
			$this->form_validation->set_rules('m_email', 'Manager email', 'required|valid_email|callback_email_check['.$_POST['m_id'].']');
			$this->form_validation->set_rules('m_code', 'Manager code', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//update
				$manager_data['m_name'] = $_POST['m_name'];
				$manager_data['m_email'] = $_POST['m_email'];
				$manager_data['m_code'] = $_POST['m_code'];
				if ($_POST['m_upline'] != '')
					$manager_data['m_upline'] = $_POST['m_upline'];
					
				if (isset($_POST['m_pass']) && $_POST['m_pass'] != '') {
					$manager_data['m_pass'] = md5($_POST['m_pass']);
				}
				$this->Manager_model->updateManager($_POST['m_id'], $manager_data);
				
				$manager = $this->Manager_model->getManagerById($_POST['m_id']);
				$data['manager'] = $manager;
				$data['m_name'] = $manager->{'m_name'};
				$data['m_email'] = $manager->{'m_email'};
				$data['m_code'] = $manager->{'m_code'};
				if ($manager->{"m_upline"} != '' && $manager->{'m_upline'} != null)
					$data['m_upline'] = $manager->{'m_upline'};
				
				$data['m_pass'] = '';
				
				$this->session->set_userdata('success', 'Manager updated');
			}
		}
		else {
			$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
		}
		$this->load->view('manager/editManagerView', $data);
	}
	
	function email_check($email, $manager_id = null) {
	  if ($this->Manager_model->checkDuplicateEmail($email, $manager_id)) {
			$this->form_validation->set_message('email_check', 'The %s is already registered');
			return FALSE;
	  } 
	  else {
			return TRUE;
	  }
	}
	
	public function deleteManager() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$this->Manager_model->deleteManager($_GET['id']);
			$this->session->set_userdata('success', 'Manager deleted');
			redirect('manager');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */