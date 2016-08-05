<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
		//only admin can access
		if ($this->session->userdata('user_type') != 'admin')
			exit;
			
		$this->load->model('Customer_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all Customers
	public function index() {
		$data['title'] = 'Customers';
		$data['subtitle'] = 'Customer Lists';
		
		$data['active'] = 'customer';
		
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
			
		$data['customers'] = $this->Customer_model->getAllCustomer($limit, $offset, $search);
		
		$config['base_url'] = base_url().'customer?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Customer_model->getAllCustomer(null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
		$this->load->view('customer/customerListView', $data);
	}
	
	public function addCustomer() {
		$data['title'] = 'Customer';
		$data['subtitle'] = 'Add Customer Account';
		$data['active'] = 'customer';
		$data['customer_name'] = $data['customer_project'] = $data['customer_pass'] = $data['customer_email'] = $data['customer_mobile'] = '';
		$data['customer_addr'] = $data['customer_addr2'] = $data['customer_nric'] = $data['customer_dob'] ='';
		$data['customer_bank_name'] = $data['customer_bank_acc'] = $data['customer_acc_type'] = $data['customer_bank_swift'] = '';
		$data['customer_username'] = '';
		
		//add new
		if (isset($_POST['customer_name'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('customer_name', 'Customer name', 'required');
			$this->form_validation->set_rules('customer_username', 'Customer user name', 'required');
// 			$this->form_validation->set_rules('customer_email', 'Customer email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('customer_pass', 'Customer password', 'required');
			$this->form_validation->set_rules('customer_nric', 'Customer NRIC', 'required');
			$this->form_validation->set_rules('customer_mobile', 'Customer mobile', 'required|min_length[8]');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$Customer_data['customer_name'] = $_POST['customer_name'];
				$Customer_data['customer_username'] = $_POST['customer_username'];
				$Customer_data['customer_project'] = $_POST['customer_project'];
				$Customer_data['customer_email'] = $_POST['customer_email'];
				$Customer_data['customer_pass'] = md5($_POST['customer_pass']);
				$Customer_data['customer_mobile'] = $_POST['customer_mobile'];
				$Customer_data['customer_nric'] = $_POST['customer_nric'];
				$Customer_data['customer_addr'] = $_POST['customer_addr'];
				$Customer_data['customer_addr2'] = $_POST['customer_addr2'];
				$Customer_data['customer_dob'] = $_POST['customer_dob'];
				$Customer_data['customer_bank_name'] = $_POST['customer_bank_name'];
				$Customer_data['customer_bank_acc'] = $_POST['customer_bank_acc'];
				$Customer_data['customer_acc_type'] = $_POST['customer_acc_type'];
				$Customer_data['customer_bank_swift'] = $_POST['customer_bank_swift'];
				$Customer_data['customer_created_date'] = date('Y-m-d H:i:s');
				
				$this->Customer_model->addCustomer($Customer_data);
				$this->session->set_userdata('success', 'New Customer account added');
				redirect('customer');
			}
		}
		
		$this->load->view('customer/addCustomerView', $data);
	}
	
	public function editCustomer() {
		$data['subtitle'] = 'Edit Customer';
		$data['title'] = 'Customer';
		$data['active'] = 'customer';
		
		//get admin detail
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$Customer = $this->Customer_model->getCustomerById($_GET['id']);
			//if no admin found
			if (count($Customer) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['customer'] = $Customer;
				$data['customer_name'] = $Customer->{'customer_name'};
				$data['customer_username'] = $Customer->{'customer_username'};
				
				$data['customer_project'] = $Customer->{'customer_project'};
				$data['customer_email'] = $Customer->{'customer_email'};
				$data['customer_nric'] = $Customer->{'customer_nric'};
				$data['customer_mobile'] = $Customer->{'customer_mobile'};
				$data['customer_addr'] = $Customer->{'customer_addr'};
				$data['customer_addr2'] = $Customer->{'customer_addr2'};
				$data['customer_dob'] = $Customer->{'customer_dob'};
				$data['customer_pass'] = '';
				$data['customer_bank_name'] = $Customer->{'customer_bank_name'};
				$data['customer_bank_acc'] = $Customer->{'customer_bank_acc'};
				$data['customer_acc_type'] = $Customer->{'customer_acc_type'};
				$data['customer_bank_swift'] = $Customer->{'customer_bank_swift'};
			}
		}
		//submit update
		else if (isset($_POST['customer_id'])) {
			$Customer = $this->Customer_model->getCustomerById($_POST['customer_id']);
			if (count($Customer) == 0) {
				$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
			}
			else {
				$data['customer'] = $Customer;
				$data['customer_name'] = $Customer->{'customer_name'};
				$data['customer_username'] = $Customer->{'customer_username'};
				$data['customer_project'] = $Customer->{'customer_project'};
				$data['customer_email'] = $Customer->{'customer_email'};
				$data['customer_nric'] = $Customer->{'customer_nric'};
				$data['customer_mobile'] = $Customer->{'customer_mobile'};
				$data['customer_addr'] = $Customer->{'customer_addr'};
				$data['customer_addr2'] = $Customer->{'customer_addr2'};
				$data['customer_dob'] = $Customer->{'customer_dob'};
				$data['customer_bank_name'] = $Customer->{'customer_bank_name'};
				$data['customer_bank_acc'] = $Customer->{'customer_bank_acc'};
				$data['customer_acc_type'] = $Customer->{'customer_acc_type'};
				$data['customer_bank_swift'] = $Customer->{'customer_bank_swift'};
				
				$data['customer_pass'] = '';
			}
			
			//validate
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			$this->form_validation->set_rules('customer_name', 'Customer name', 'required');
			$this->form_validation->set_rules('customer_username', 'Customer user name', 'required');
// 			$this->form_validation->set_rules('customer_email', 'Customer email', 'required|valid_email|callback_email_check['.$_POST['customer_id'].']');
			$this->form_validation->set_rules('customer_nric', 'Customer NRIC', 'required');
			$this->form_validation->set_rules('customer_mobile', 'Customer mobile', 'required|min_length[8]');
			
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//update
				$Customer_data['customer_name'] = $_POST['customer_name'];
				$Customer_data['customer_username'] = $_POST['customer_username'];
				$Customer_data['customer_project'] = $_POST['customer_project'];
				$Customer_data['customer_email'] = $_POST['customer_email'];
				$Customer_data['customer_nric'] = $_POST['customer_nric'];
				$Customer_data['customer_mobile'] = $_POST['customer_mobile'];
				$Customer_data['customer_dob'] = $_POST['customer_dob'];
				$Customer_data['customer_addr'] = $_POST['customer_addr'];
				$Customer_data['customer_addr2'] = $_POST['customer_addr2'];
				$Customer_data['customer_bank_name'] = $_POST['customer_bank_name'];
				$Customer_data['customer_bank_acc'] = $_POST['customer_bank_acc'];
				$Customer_data['customer_acc_type'] = $_POST['customer_acc_type'];
				$Customer_data['customer_bank_swift'] = $_POST['customer_bank_swift'];
				
				if (isset($_POST['customer_pass']) && $_POST['customer_pass'] != '') {
					$Customer_data['customer_pass'] = md5($_POST['customer_pass']);
				}
				$this->Customer_model->updateCustomer($_POST['customer_id'], $Customer_data);
				$Customer = $this->Customer_model->getCustomerById($_POST['customer_id']);
				$data['customer'] = $Customer;
				$data['customer_name'] = $Customer->{'customer_name'};
				$data['customer_username'] = $Customer->{'customer_username'};
				$data['customer_project'] = $Customer->{'customer_project'};
				$data['customer_email'] = $Customer->{'customer_email'};
				$data['customer_nric'] = $Customer->{'customer_nric'};
				$data['customer_mobile'] = $Customer->{'customer_mobile'};
				$data['customer_addr'] = $Customer->{'customer_addr'};
				
				$data['customer_addr2'] = $Customer->{'customer_addr2'};
				$data['customer_dob'] = $Customer->{'customer_dob'};
				$data['customer_pass'] = '';
				$data['customer_bank_name'] = $Customer->{'customer_bank_name'};
				$data['customer_bank_acc'] = $Customer->{'customer_bank_acc'};
				$data['customer_acc_type'] = $Customer->{'customer_acc_type'};
				$data['customer_bank_swift'] = $Customer->{'customer_bank_swift'};
				$this->session->set_userdata('success', 'Customer updated');
			}
		}
		else {
			$this->session->set_userdata('error', 'Ops... Something went wrong, please try again.');
		}
		$this->load->view('customer/editCustomerView', $data);
	}
	
	function email_check($email, $Customer_id = null) {
		//allow duplicate email
		return TRUE;
	  // if ($this->Customer_model->checkDuplicateEmail($email, $Customer_id)) {
// 			$this->form_validation->set_message('email_check', 'The %s is already registered');
// 			return FALSE;
// 	  } 
// 	  else {
// 			return TRUE;
// 	  }
	}
	
	public function deleteCustomer() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$this->Customer_model->deleteCustomer($_GET['id']);
			$this->session->set_userdata('success', 'Customer deleted');
			redirect('customer');
		}
	}
	
	public function payoutSchedule() {
		$data['title'] = 'Payout Schedule';
		$data['subtitle'] = 'View Contracts';
		
		$data['active'] = 'invoice';
		$data['managers'] = $this->Manager_model->getAllManager();
		$data['agents'] = $this->Agent_model->getAllAgent();
		$data['customers'] = $this->Customer_model->getAllCustomer();
		
		
		if (isset($_GET['inv'])) {
			$data['inv'] = $this->Invoice_model->getInvoiceById($_GET['inv']);
			$data['client_payout'] = $this->Invoice_model->getClientPayout($_GET['inv']);
			$data['sales_payout'] = $this->Invoice_model->getSalesPayout($_GET['inv']);
			$data['manager_payout'] = $this->Invoice_model->getManagerPayout($_GET['inv']);
			
			$agent_comm_pipeline = $this->Agent_model->getAgentCommAndPipeline($data['inv']->{'agent_id'});
			$m_comm_pipeline = $this->Manager_model->getManagerCommAndPipeline($data['inv']->{'m_id'});
			$data['comm'] = $agent_comm_pipeline->{'agent_comm'}.'%';
			$data['pipeline'] = '$'.number_format($agent_comm_pipeline->{'agent_pipeline'}, 2,'.',',');
			$data['m_comm'] = $m_comm_pipeline->{'m_comm'}.'%';
			$data['m_pipeline'] = '$'.number_format($m_comm_pipeline->{'m_pipeline'}, 2,'.',',');
			
			$this->load->view('invoice/invoiceView', $data);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */