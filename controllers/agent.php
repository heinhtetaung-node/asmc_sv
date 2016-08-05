<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent extends CI_Controller {

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
		//only admin and manager can access
		if ($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'manager'
		&& $this->session->userdata('user_type') != 'director')
			exit;
			
		$this->load->model('Agent_model');
		$this->load->model('Manager_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all Agents
	public function index() {
		$data['title'] = 'Agents';
		$data['subtitle'] = 'Agent Lists';
		
		$data['active'] = 'agent';
		
		$per_page = 250;
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
			
		$data['agents'] = $this->Agent_model->getAllAgent($limit, $offset, $search);
		
		$config['base_url'] = base_url().'agent?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Agent_model->getAllAgent(null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
		$this->load->view('agent/agentListView', $data);
	}
	
	public function addAgent() {
		$data['title'] = 'Agent';
		$data['subtitle'] = 'Add Agent Account';
		$data['active'] = 'agent';
		$data['agent_name'] = $data['agent_pass'] = $data['agent_email'] = $data['agent_code'] = '';
		$data['managers'] = $this->Manager_model->getAllManager();
		
		//add new
		if (isset($_POST['agent_name'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('agent_name', 'Agent name', 'required');
			$this->form_validation->set_rules('agent_email', 'Agent email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('agent_pass', 'Agent password', 'required');
			$this->form_validation->set_rules('agent_code', 'Agent code', 'required');
			$this->form_validation->set_rules('agent_upline', 'Manager', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$Agent_data['agent_name'] = $_POST['agent_name'];
				$Agent_data['agent_email'] = $_POST['agent_email'];
				$Agent_data['agent_pass'] = md5($_POST['agent_pass']);
				$Agent_data['agent_code'] = $_POST['agent_code'];
				$Agent_data['agent_upline'] = $_POST['agent_upline'];
				$Agent_data['agent_created_date'] = date('Y-m-d H:i:s');
				
				$this->Agent_model->addAgent($Agent_data);
				$this->session->set_userdata('success', 'New Agent account added');
				redirect('agent');
			}
		}
		
		$this->load->view('agent/addAgentView', $data);
	}
	
	public function editAgent() {
		if ($this->session->userdata('user_type') != 'admin')
			exit;
		$data['subtitle'] = 'Edit Agent';
		$data['title'] = 'Agent';
		$data['active'] = 'Agent';
		$data['managers'] = $this->Manager_model->getAllManager();
		
		//get admin detail
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$Agent = $this->Agent_model->getAgentById($_GET['id']);
			//if no admin found
			if (count($Agent) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['agent'] = $Agent;
				$data['agent_name'] = $Agent->{'agent_name'};
				$data['agent_email'] = $Agent->{'agent_email'};
				$data['agent_code'] = $Agent->{'agent_code'};
				$data['agent_upline'] = $Agent->{'agent_upline'};
				$data['agent_pass'] = '';
			}
		}
		//submit update
		else if (isset($_POST['agent_id'])) {
			$Agent = $this->Agent_model->getAgentById($_POST['agent_id']);
			if (count($Agent) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['agent'] = $Agent;
				$data['agent_name'] = $Agent->{'agent_name'};
				$data['agent_email'] = $Agent->{'agent_email'};
				$data['agent_code'] = $Agent->{'agent_code'};
				$data['agent_upline'] = $Agent->{'agent_upline'};
				$data['agent_pass'] = '';
			}
			
			//validate
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			$this->form_validation->set_rules('agent_name', 'Agent name', 'required');
			$this->form_validation->set_rules('agent_email', 'Agent email', 'required|valid_email|callback_email_check['.$_POST['agent_id'].']');
			$this->form_validation->set_rules('agent_code', 'Agent code', 'required');
			$this->form_validation->set_rules('agent_upline', 'Manager', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//update
				$Agent_data['agent_name'] = $_POST['agent_name'];
				$Agent_data['agent_email'] = $_POST['agent_email'];
				$Agent_data['agent_code'] = $_POST['agent_code'];
				$Agent_data['agent_upline'] = $_POST['agent_upline'];
				
				if (isset($_POST['agent_pass']) && $_POST['agent_pass'] != '') {
					$Agent_data['agent_pass'] = md5($_POST['agent_pass']);
				}
				$this->Agent_model->updateAgent($_POST['agent_id'], $Agent_data);
				$Agent = $this->Agent_model->getAgentById($_POST['agent_id']);
				$data['agent'] = $Agent;
				$data['agent_name'] = $Agent->{'agent_name'};
				$data['agent_email'] = $Agent->{'agent_email'};
				$data['agent_code'] = $Agent->{'agent_code'};
				$data['agent_upline'] = $Agent->{'agent_upline'};
				$data['agent_pass'] = '';
				$this->session->set_userdata('success', 'Agent updated');
			}
		}
		else {
			$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
		}
		$this->load->view('agent/editAgentView', $data);
	}
	
	function email_check($email, $Agent_id = null) {
	  if ($this->Agent_model->checkDuplicateEmail($email, $Agent_id)) {
			$this->form_validation->set_message('email_check', 'The %s is already registered');
			return FALSE;
	  } 
	  else {
			return TRUE;
	  }
	}
	
	public function deleteAgent() {
		if ($this->session->userdata('user_type') != 'admin')
			exit;
			if (isset($_GET['id']) && $_GET['id'] != '') {
			$this->Agent_model->deleteAgent($_GET['id']);
			$this->session->set_userdata('success', 'Agent deleted');
			redirect('agent');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */