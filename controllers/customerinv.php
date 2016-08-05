<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customerinv extends CI_Controller {

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
		if ($this->session->userdata('user_type') != 'customer')
			exit;
			
		$this->load->model('Admin_model');
		$this->load->model('Agent_model');
		$this->load->model('Customer_model');
		$this->load->model('Manager_model');
		$this->load->model('Invoice_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all invoice
	public function index() {
		$data['title'] = 'Funding Record';
		$data['subtitle'] = 'Agreement Lists';
		
		$data['active'] = 'invoice';
		
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
			
		$data['invoices'] = $this->Invoice_model->getAllInvoice($limit, $offset, $search);
		
		$config['base_url'] = base_url().'invoice?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Invoice_model->getAllInvoice(null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
// 		$data['invoices'] = $this->Invoice_model->getAllInvoice();
		$this->load->view('invoice/invoiceListView', $data);
		
	}
	
	public  function viewInvoice() {
		$data['title'] = 'Funding Record';
		$data['subtitle'] = 'View Funding Record';
		
		$data['active'] = 'invoice';
		$data['managers'] = $this->Manager_model->getAllManager();
		$data['agents'] = $this->Agent_model->getAllAgent();
		$data['customers'] = $this->Customer_model->getAllCustomer();
		
		if (isset($_GET['inv'])) {
			$data['inv'] = $this->Invoice_model->getInvoiceById($_GET['inv']);
			$this->load->view('invoice/invoiceView', $data);
		}
	}
	
	function editInvoice() {
		$data['title'] = 'Funding Record';
		$data['subtitle'] = 'Edit Funding Record';
		
		$data['active'] = 'invoice';
		$data['managers'] = $this->Manager_model->getAllManager();
		$data['agents'] = $this->Agent_model->getAllAgent();
		$data['customers'] = $this->Customer_model->getAllCustomer();
		
		if (isset($_GET['inv'])) {
			$data['inv'] = $this->Invoice_model->getInvoiceById($_GET['inv']);
			$this->load->view('invoice/editInvoiceView', $data);
		}
	}
	
	
	function valid_manager($m_id) {
		if ($m_id == 0) {
			$this->form_validation->set_message('valid_manager', 'Please select Manager');
			return FALSE;
		}
		else
			return true;
	}
	function valid_agent($m_id) {
		if ($m_id == 0) {
			$this->form_validation->set_message('valid_agent', 'Please select Agent');
			return FALSE;
		}
		else
			return true;
	}
	function valid_customer($m_id) {
		if ($m_id == 0) {
			$this->form_validation->set_message('valid_customer', 'Please select Customer');
			return FALSE;
		}
		else
			return true;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */