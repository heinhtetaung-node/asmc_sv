<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commission extends CI_Controller {

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
		if ($this->session->userdata('user_type') == 'customer')
			exit;
			
		$this->load->model('Admin_model');
		$this->load->model('Agent_model');
		$this->load->model('Customer_model');
		$this->load->model('Manager_model');
		$this->load->model('Invoice_model');
		$this->load->model('Commision_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	//list all invoice
	public function index() {
		$data['title'] = 'Commissions';
		$data['subtitle'] = 'Commissions Lists';
		
		$data['active'] = 'commission';
		
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
			
		$data['percent'] = 0;
	
		if ($this->session->userdata('user_type') == 'admin') {
			$group = 'admin';
			$id = $this->session->userdata('admin')->{'admin_id'};
		}
		else if ($this->session->userdata('user_type') == 'manager') {
			$group = 'manager';
			$id = $this->session->userdata('manager')->{'m_id'};
			$data['percent'] = 0.02;
		}
		else if ($this->session->userdata('user_type') == 'agent') {
			$group = 'agent';
			$id = $this->session->userdata('agent')->{'agent_id'};
			$data['percent'] = 0.06;
		}
		
			$data['group'] = $group;
			
// 		print_r($data['percent']);exit;
		$data['invoices'] = $this->Commision_model->getAllInvoice($group, $id, $limit, $offset, $search);
		// echo '<pre>';
// 		print_r($data['invoices']);exit;
// 		
		$config['base_url'] = base_url().'commission?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Commision_model->getAllInvoice($group, $id, null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
		
		$date = $this->Invoice_model->getStartEndPayoutDate($group,$id);

		$data['dates'] = $this->get_months($date->{'mins'}, $date->{'maxs'});
		
		//first 3 months dun hv comm
// 		$data['dates'] = array_slice($data['dates'], 3,count($data['dates']) - 1);
		
// 		$data['invoices'] = $this->Invoice_model->getAllInvoice();
		$this->load->view('commission/commissionListView', $data);
		
	}
	
	function get_months($date1, $date2) {

		$time1 = strtotime($date1);
		$time2 = strtotime($date2);

		$my = date('mY', $time2);
		$months = array(date('Y-m-t', $time1));
		$f = '';

		while($time1 < $time2) {
			$time1 = strtotime((date('Y-m-d', $time1).' +15days'));

			if(date('F', $time1) != $f) {
				$f = date('F', $time1);

				if(date('mY', $time1) != $my && ($time1 < $time2))
					$months[] = date('Y-m-t', $time1);
			}

		}

		$months[] = date('Y-m-d', $time2);
		return $months;
	}
	
	function viewComm() {
		$data['title'] = 'Commision';
		$data['subtitle'] = 'Commission View';
		
		$data['active'] = 'commission';
		$data['inv'] = $this->Invoice_model->getInvoiceById($_GET['inv']);
		
		
		$agent_comm_pipeline = $this->Agent_model->getAgentCommAndPipeline($data['inv']->{'agent_id'});
		$m_comm_pipeline = $this->Manager_model->getManagerCommAndPipeline($data['inv']->{'m_id'});
		$data['comm'] = $agent_comm_pipeline->{'agent_comm'}.'%';
		$data['pipeline'] = '$'.number_format($agent_comm_pipeline->{'agent_pipeline'}, 2,'.',',');
		$data['m_comm'] = $m_comm_pipeline->{'m_comm'}.'%';
		$data['m_pipeline'] = '$'.number_format($m_comm_pipeline->{'m_pipeline'}, 2,'.',',');
		
		if ($this->session->userdata('user_type') == 'manager') {
			$data['manager_payout'] = $this->Invoice_model->getManagerPayout($_GET['inv']);
			$this->load->view('commission/managerCommView', $data);
		}
		else if ($this->session->userdata('user_type') == 'agent') {
			$data['sales_payout'] = $this->Invoice_model->getSalesPayout($_GET['inv']);
			$this->load->view('commission/salesCommView', $data);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */