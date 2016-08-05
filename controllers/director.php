<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Director extends CI_Controller {

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
			
		$this->load->model('Director_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all directors
	public function index() {
		$data['title'] = 'Directors';
		$data['subtitle'] = 'Directors Lists';
		
		$data['active'] = 'director';
		
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
			
		$data['directors'] = $this->Director_model->getAllDirector($limit, $offset, $search);
		
		$config['base_url'] = base_url().'director?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Director_model->getAllDirector(null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
		$this->load->view('director/directorListView', $data);
	}
	
	public function addDirector() {
		$data['title'] = 'Director';
		$data['subtitle'] = 'Add Director Account';
		$data['active'] = 'director';
		$data['dr_name'] = $data['dr_pass'] = $data['dr_email'] = $data['dr_code'] = '';
		
		//add new
		if (isset($_POST['dr_name'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('dr_name', 'Director name', 'required');
			$this->form_validation->set_rules('dr_email', 'Director email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('dr_pass', 'Director password', 'required');
			$this->form_validation->set_rules('dr_code', 'Director code', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$director_data['dr_name'] = $_POST['dr_name'];
				$director_data['dr_email'] = $_POST['dr_email'];
				$director_data['dr_pass'] = md5($_POST['dr_pass']);
				$director_data['dr_code'] = $_POST['dr_code'];
				$director_data['dr_created_date'] = date('Y-m-d H:i:s');
				
				$this->Director_model->addDirector($director_data);
				$this->session->set_userdata('success', 'New director account added');
				redirect('director');
			}
		}
		
		$this->load->view('director/addDirectorView', $data);
	}
	
	public function editDirector() {
		$data['subtitle'] = 'Edit Director';
		$data['title'] = 'Director';
		$data['active'] = 'director';
		
		//get admin detail
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$director = $this->Director_model->getDirectorById($_GET['id']);
			//if no admin found
			if (count($director) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['director'] = $director;
				$data['dr_name'] = $director->{'dr_name'};
				$data['dr_email'] = $director->{'dr_email'};
				$data['dr_code'] = $director->{'dr_code'};
				$data['dr_pass'] = '';
			}
		}
		//submit update
		else if (isset($_POST['dr_id'])) {
			$director = $this->Director_model->getDirectorById($_POST['dr_id']);
			if (count($director) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['director'] = $director;
				$data['dr_name'] = $director->{'dr_name'};
				$data['dr_email'] = $director->{'dr_email'};
				$data['dr_code'] = $director->{'dr_code'};
				$data['dr_pass'] = '';
			}
			
			//validate
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			$this->form_validation->set_rules('dr_name', 'Director name', 'required');
			$this->form_validation->set_rules('dr_email', 'Director email', 'required|valid_email|callback_email_check['.$_POST['dr_id'].']');
			$this->form_validation->set_rules('dr_code', 'Director code', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//update
				$director_data['dr_name'] = $_POST['dr_name'];
				$director_data['dr_email'] = $_POST['dr_email'];
				$director_data['dr_code'] = $_POST['dr_code'];
				
				if (isset($_POST['dr_pass']) && $_POST['dr_pass'] != '') {
					$director_data['dr_pass'] = md5($_POST['dr_pass']);
				}
				$this->Director_model->updateDirector($_POST['dr_id'], $director_data);
				
				$director = $this->Director_model->getDirectorById($_POST['dr_id']);
				$data['director'] = $director;
				$data['dr_name'] = $director->{'dr_name'};
				$data['dr_email'] = $director->{'dr_email'};
				$data['dr_code'] = $director->{'dr_code'};
				$data['dr_pass'] = '';
				
				$this->session->set_userdata('success', 'Director updated');
			}
		}
		else {
			$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
		}
		$this->load->view('director/editDirectorView', $data);
	}
	
	function email_check($email, $director_id = null) {
	  if ($this->Director_model->checkDuplicateEmail($email, $director_id)) {
			$this->form_validation->set_message('email_check', 'The %s is already registered');
			return FALSE;
	  } 
	  else {
			return TRUE;
	  }
	}
	
	public function deleteDirector() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$this->Director_model->deleteDirector($_GET['id']);
			$this->session->set_userdata('success', 'Director deleted');
			redirect('director');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */