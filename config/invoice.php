<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

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
			
		$this->load->model('Admin_model');
		$this->load->model('Agent_model');
		$this->load->model('Customer_model');
		$this->load->model('Manager_model');
		$this->load->model('Invoice_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	
	function emailFunder() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$this->sendEmailToFunder($_GET['id']);
			echo 'Email Sent';
		}
	}
	
	function sendPayoutEmailToFunder($inv_id, $pid) {
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		//funding amt
		$email['sender'] = EMAIL_SENDER;
		$email['sender_name'] = 'ASMC';
		$email['receipient'] = $invoice->{'customer_email'};
		$email['receipient_name'] = $invoice->{'customer_name'};
		
		$email['subject'] = 'ASMC Monthly Payout Receipts';
		$email['msg'] = 'Dear '.$invoice->{'customer_name'}.',<br/><br/>Attached is your monthly payout receipt for your reference.'.
					'<br/><br/><br/>
					ASIA STRATEGIC MINING CORPORATION PTE LTD<br/><br/><i>This email is auto generated. Please do no reply.</i>';
		$email['file'] = RECEIPT_PATH.'customer/'.$invoice->{'inv_id'}.'.pdf';
		
		$this->Invoice_model->addEmail($email);
		
		
	}
	
	function sendEmailToFunder($inv_id) {
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		//funding amt
		$email['sender'] = EMAIL_SENDER;
		$email['sender_name'] = 'ASMC';
		$email['receipient'] = $invoice->{'customer_email'};
		$email['receipient_name'] = $invoice->{'customer_name'};
		
		$email['subject'] = 'ASMC Funding Receipts';
		$email['msg'] = 'Dear '.$invoice->{'customer_name'}.',<br/><br/>Attached is your funding receipt for your reference.'.
					'<br/><br/><br/>
					ASIA STRATEGIC MINING CORPORATION PTE LTD<br/><br/><i>This email is auto generated. Please do no reply.</i>';
		$email['file'] = RECEIPT_PATH.$invoice->{'inv_id'}.'.pdf';
		
		$this->Invoice_model->addEmail($email);
		
		//Admin fee
		// $email['subject'] = 'ASMC Admin Fee Receipts';
// 			$email['msg'] = 'Dear '.$invoice->{'customer_name'}.',<br/><br/>Attached is your admin fee receipt for your reference.'.
// 					'<br/><br/><br/>
// 					ASIA STRATEGIC MINING CORPORATION PTE LTD<br/><br/><i>This email is auto generated. Please do no reply.</i>';
// 		$email['file'] = RECEIPT_PATH.'admin/'.$invoice->{'inv_id'}.'.pdf';
// 		
// 		$this->Invoice_model->addEmail($email);
		
	}
	
	function generateContract($invid = null, $display = null) {
		$inv_id = $invid != null ? $invid : $_GET['id'];
		
		$this->load->helper('pdf_helper');
		
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		$data['inv'] = $invoice;
		$data['display'] = $display != null ? $display : 1;
		$this->load->view('invoice/pdf/agreementPDF', $data);
	}
	
	function generateRisk($invid = null, $display = null) {
		$inv_id = $invid != null ? $invid : $_GET['id'];
		$this->load->helper('pdf_helper');
		
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		$data['inv'] = $invoice;
		$data['display'] = $display != null ? $display : 1;
		$this->load->view('invoice/pdf/riskPDF', $data);
	}
	
	function generatePayout($invid = null, $display = null) {
		$inv_id = $invid != null ? $invid : $_GET['id'];
		
		$this->load->helper('pdf_helper');
		
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		$data['inv'] = $invoice;
		$data['payout'] = $this->Invoice_model->getClientPayout($invoice->{'inv_id'});
	
		$data['display'] = $display != null ? $display : 1;
		$this->load->view('invoice/pdf/payoutPDF', $data);
	}
	
	function generateFundingReceipt($invid = null, $display = null) {
		$inv_id = $invid != null ? $invid : $_GET['id'];
		
		$this->load->helper('pdf_helper');
		
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		
		$data['inv'] = $invoice;
		$data['display'] = $display != null ? $display : 1;
		
		$funding_receipt = $this->Invoice_model->getFundingReceipt($inv_id, $data['inv']->{'inv_date'});
		
		$data['receipt_no'] = $funding_receipt->{'r_no'};
		$data['receipt_date'] = $funding_receipt->{'r_created_date'};
		
		$data['receive_from'] = $data['inv']->{'customer_name'};
		$data['nric'] = $data['inv']->{'customer_nric'};
		$data['sum'] = $data['inv']->{'funding_amt'};
		if ($data['inv']->{'cheque_no'} != '')
			$data['cheque'] = $data['inv']->{'cheque_no'};
		else if ($data['inv']->{'cheque_no2'} != '')
			$data['cheque'] = $data['inv']->{'cheque_no2'};
		else if ($data['inv']->{'tt_no'} != '')
			$data['cheque'] = $data['inv']->{'tt_no'};
		else
			$data['cheque'] = '-';
		$data['desc'] = 'For Funding in Steam Coal Project';
	
		
		$this->load->view('invoice/pdf/receiptPDF', $data);
	}
	
	function generateAdminReceipt($invid = null, $display = null) {
		$inv_id = $invid != null ? $invid : $_GET['id'];
		
		$this->load->helper('pdf_helper');
		
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		
		
		$data['inv'] = $invoice;
		$data['display'] = $display != null ? $display : 1;
		
		$admin_receipt = $this->Invoice_model->getAdminReceipt($inv_id, $data['inv']->{'inv_date'});
		
		$data['receipt_no'] = $admin_receipt->{'r_no'};
		$data['receipt_date'] = $admin_receipt->{'r_created_date'};
		
		$data['receive_from'] = $data['inv']->{'customer_name'};
		$data['nric'] = $data['inv']->{'customer_nric'};
		$data['sum'] = $data['inv']->{'admin_fee'};
		if ($data['inv']->{'admin_cheque_no'} != '')
			$data['cheque'] = $data['inv']->{'admin_cheque_no'};
		else if ($data['inv']->{'admin_tt_no'} != '')
			$data['cheque'] = $data['inv']->{'admin_tt_no'};
		else
			$data['cheque'] = '-';
		$data['desc'] = 'For Admin Fee in Funding Steam Coal Project';
	
		
		$this->load->view('invoice/pdf/adminreceiptPDF', $data);
	}
	
	function generateClientPayoutReceipt($pid = null, $invid = null, $display = null) {
		$inv_id = $invid != null ? $invid : $_GET['id'];
		$p_id = $pid != null ? $pid : $_GET['pid'];
		
		
		$this->load->helper('pdf_helper');
		
		$invoice = $this->Invoice_model->getInvoiceById($inv_id);
		$payout = $this->Invoice_model->getClientPayoutById($p_id);
		
		$data['inv'] = $invoice;
		$data['display'] = $display != null ? $display : 1;
		
		$payout_receipt = $this->Invoice_model->getClientPayoutReceipt($inv_id, $payout->{'id'}, $payout->{'pay_date'});
		
		$data['receipt_no'] = $payout_receipt->{'r_no'};
		$data['receipt_date'] = $payout_receipt->{'r_created_date'};
		
		$data['receive_from'] = $data['inv']->{'customer_name'};
		$data['nric'] = $data['inv']->{'customer_nric'};
		$data['sum'] = $payout->{'amt'};
		
		$data['cheque'] = 'ASMC Bank Transfer';
		$data['desc'] = 'For Monthly Payout in Funding Steam Coal Project';
	
		
		$this->load->view('invoice/pdf/payoutreceiptPDF', $data);
	}
	
	function test() {
		$current_date = '2014-12-25';
		
		$start_month = date('m', strtotime($current_date));
		$start_year = date('Y', strtotime($current_date));
		

		$payout = array();
		for ($i = 0; $i < 36; $i++) {
			
			$date = $start_year.'-'.str_pad($start_month,2,'0', STR_PAD_LEFT).'-01';
		
			if ($start_month == 12) {
				$start_month = 1;
				$start_year++;
			}
			else
				$start_month++;
				
			$last_day = date('t', strtotime("+1 month", strtotime($date)));
			
			echo date("Y-m-".str_pad($last_day, 2, '0', STR_PAD_LEFT), strtotime("+1 month", strtotime($date)));
			echo '<br/>';
			
// 			$payout[] = array('inv_id'=>$inv_id, 'date'=>$pdate, 'amt'=>$amt);
		}
	}
	
	//list all invoice
	public function index() {
		//only admin can access
		// if ($this->session->userdata('user_type') != 'admin')
// 			redirect('login');
			
		$data['title'] = 'Contracts';
		$data['subtitle'] = 'Contracts Lists';
		
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
		$data['title'] = 'Contracts';
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
	
	function editInvoice() {
		//only admin can access
		if ($this->session->userdata('user_type') != 'admin')
			redirect('login');
		
		$data['title'] = 'Contracts';
		$data['subtitle'] = 'Edit Contracts';
	
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
			
			if (isset($_POST['submit'])) {
		
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
				//validate
				$this->form_validation->set_rules('inv_date', 'Invoice Date', 'required');
				$this->form_validation->set_rules('inv_no', 'Invoice number', 'required');
				$this->form_validation->set_rules('inv_amt', 'Amount', 'required|numeric');
				$this->form_validation->set_rules('inv_unitprice', 'Price/Unit', 'required|numeric');
				$this->form_validation->set_rules('inv_period', 'Investing Period', 'required|numeric');
				$this->form_validation->set_rules('m_id', 'Manager', 'required|callback_valid_manager');
				$this->form_validation->set_rules('agent_id', 'Agent', 'required|callback_valid_agent');
				$this->form_validation->set_rules('customer_id', 'Customer', 'required|callback_valid_customer');
			
				if ($this->form_validation->run() == FALSE)
				{
				
				}
				else {
					$inv['inv_date'] = $_POST['inv_date'];
					$inv['inv_no'] = $_POST['inv_no'];
					$inv['inv_amt'] = $_POST['inv_amt'];
					$inv['inv_unitprice'] = $_POST['inv_unitprice'];
					$inv['inv_total'] = $_POST['inv_total'];
					$inv['inv_period'] = $_POST['inv_period'];
					$inv['remarks'] = $_POST['remarks'];
					$inv['country'] = $_POST['country'];
					$inv['funding_amt'] = $_POST['funding_amt'];
					$inv['customer_id'] = $_POST['customer_id'];
					$inv['m_id'] = $_POST['m_id'];
					$inv['agent_id'] = $_POST['agent_id'];
					$inv['admin_id'] = $this->session->userdata('admin')->{'admin_id'};
					$inv['cheque_no'] = $_POST['cheque_no'];
					$inv['cheque_no2'] = $_POST['cheque_no2'];
					$inv['admin_cheque_no'] = $_POST['admin_cheque_no'];
					$inv['tt_no'] = $_POST['tt_no'];
					$inv['admin_tt_no'] = $_POST['admin_tt_no'];
					$inv['admin_fee'] = $_POST['admin_fee'];
					
					$inv_id = $_POST['inv_id'];
					$this->Invoice_model->updateInvoice($inv_id, $inv);
				
					//
					$this->Invoice_model->adjustClientPayoutPeriod($inv_id, $inv['inv_period'], $inv['inv_date'], $inv['inv_unitprice']*$inv['inv_amt']);
					
					$agent_comm_pipeline = $this->Agent_model->getAgentCommAndPipeline($inv['agent_id']);
					
					$amt = $agent_comm_pipeline->{'agent_pipeline'} * $inv['inv_amt'];
				
					$this->Invoice_model->adjustSalesPayoutPeriod($inv_id, $inv['agent_id'], $inv['inv_period'], $inv['inv_date'], $amt, $inv['funding_amt']);
					
					$m_comm_pipeline = $this->Manager_model->getManagerCommAndPipeline($inv['m_id']);
					
					$amt = $m_comm_pipeline->{'m_pipeline'} * $inv['inv_amt'];
				
					$this->Invoice_model->adjustManagerPayoutPeriod($inv_id, $inv['m_id'], $inv['inv_period'], $inv['inv_date'], $amt, $inv['funding_amt']);
					
					$updates = array();
					//upload contract
					if (isset($_FILES['contract']) && $_FILES['contract']['name'] != '') {
						if ($_FILES["contract"]["error"] > 0) {
							 $this->session->set_userdata('error', $_FILES["contract"]["error"]);
						}
						else if ($_FILES["contract"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'contract_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["contract"]["tmp_name"], CONTRACT_PATH.$filename);
							$updates['contract'] = $filename;
						}
					}
			
					//uplaoad risk
					if (isset($_FILES['risk']) && $_FILES['risk']['name'] != '') {
						if ($_FILES["risk"]["error"] > 0) {
							 $this->session->set_userdata('error', $_FILES["risk"]["error"]);
						}
						else if ($_FILES["risk"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'risk_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["risk"]["tmp_name"], RISK_PATH.$filename);
							$updates['risk'] = $filename;
						}
					}
			
					//upload iras
					if (isset($_FILES['iras']) && $_FILES['iras']['name'] != '') {
						if ($_FILES["iras"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["iras"]["error"]);
						}
						else if ($_FILES["iras"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'iras_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["iras"]["tmp_name"], IRAS_PATH.$filename);
							$updates['iras'] = $filename;
						}
					}
					
					//upload bank redcord
					if (isset($_FILES['bank']) && $_FILES['bank']['name'] != '') {
						if ($_FILES["bank"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["bank"]["error"]);
						}
						else if ($_FILES["bank"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'bank_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["bank"]["tmp_name"],BANK_PATH.$filename);
							$updates['bank_record'] = $filename;
						}
					}
					
					//workseet
					if (isset($_FILES['worksheet']) && $_FILES['worksheet']['name'] != '') {
						if ($_FILES["worksheet"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["worksheet"]["error"]);
						}
						else if ($_FILES["worksheet"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'worksheet_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["worksheet"]["tmp_name"], WORKSHEET_PATH.$filename);
							$updates['worksheet'] = $filename;
						}
					}
					
					//nric
					if (isset($_FILES['nric']) && $_FILES['nric']['name'] != '') {
						if ($_FILES["nric"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["nric"]["error"]);
						}
						else if ($_FILES["nric"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'nric_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["nric"]["tmp_name"], NRIC_PATH.$filename);
							$updates['nric'] = $filename;
						}
					}
					
					if (isset($_FILES['comfort_letter']) && $_FILES['comfort_letter']['name'] != '') {
						if ($_FILES["comfort_letter"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["comfort_letter"]["error"]);
						}
						else if ($_FILES["comfort_letter"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'comfort_letter_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["comfort_letter"]["tmp_name"], COMFORT_PATH.$filename);
							$updates['comfort_letter'] = $filename;
						}
					}
					
					if (count($updates) > 0) {
						$this->Invoice_model->updateInvoice($inv_id, $updates);
					}
					$this->session->set_userdata('success', 'Invoice updated');
			
					// $this->generateContract($inv_id);
// 					$this->generateRisk($inv_id);
// 					$this->generatePayout($inv_id);
					$this->generateFundingReceipt($inv_id, 0);
					// $this->generateAdminReceipt($inv_id, 0);
					
					
					
	// 				exit;
					redirect('invoice/viewInvoice/?inv='.$inv_id);
				
				}
			}
		
			$this->load->view('invoice/editInvoiceView', $data);
		}
	}
	
	function markPaid() {
		if (isset($_GET['inv']) && isset($_GET['id'])) {
			$inv_id = $_GET['inv'];
			$payout_id = $_GET['id'];
			
			$this->Invoice_model->markClientPaid($payout_id);
			$this->generateClientPayoutReceipt($payout_id, $inv_id, 0);
			$this->sendPayoutEmailToFunder($inv_id, $payout_id);
			
			redirect('invoice/viewInvoice/?inv='.$inv_id);
		}
	}
	
	function markUnpaid() {
		if (isset($_GET['inv']) && isset($_GET['id'])) {
			$inv_id = $_GET['inv'];
			$payout_id = $_GET['id'];
			
			$this->Invoice_model->markClientUnpaid($payout_id);
			redirect('invoice/viewInvoice/?inv='.$inv_id);
		}
	}
	
	function addInvoice() {
		//only admin can access
		if ($this->session->userdata('user_type') != 'admin')
			redirect('login');
		$data['title'] = 'Contracts';
		$data['subtitle'] = 'Add Contracts';
		
		$data['active'] = 'addinvoice';
		$data['managers'] = $this->Manager_model->getAllManager();
		$data['agents'] = $this->Agent_model->getAllAgent();
		$data['customers'] = $this->Customer_model->getAllCustomer();
		
		if (isset($_POST['submit'])) {
		
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('inv_date', 'Invoice Date', 'required');
			$this->form_validation->set_rules('inv_no', 'Invoice number', 'required');
			$this->form_validation->set_rules('inv_amt', 'Amount', 'required|numeric');
			$this->form_validation->set_rules('inv_unitprice', 'Price/Unit', 'required|numeric');
			$this->form_validation->set_rules('inv_period', 'Investing Period', 'required|numeric');
			$this->form_validation->set_rules('m_id', 'Manager', 'required|callback_valid_manager');
			$this->form_validation->set_rules('agent_id', 'Agent', 'required|callback_valid_agent');
			$this->form_validation->set_rules('customer_id', 'Customer', 'required|callback_valid_customer');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$inv['inv_date'] = $_POST['inv_date'];
				$inv['inv_no'] = $_POST['inv_no'];
				$inv['inv_amt'] = $_POST['inv_amt'];
				$inv['inv_unitprice'] = $_POST['inv_unitprice'];
				$inv['inv_total'] = $_POST['inv_total'];
				$inv['inv_period'] = $_POST['inv_period'];
				$inv['funding_amt'] = $_POST['funding_amt'];
				$inv['customer_id'] = $_POST['customer_id'];
				$inv['m_id'] = $_POST['m_id'];
				$inv['agent_id'] = $_POST['agent_id'];
				$inv['admin_id'] = $this->session->userdata('admin')->{'admin_id'};
				$inv['inv_created_date'] = date('Y-m-d H:i:s');
				$inv['remarks'] = $_POST['remarks'];
				$inv['country'] = $_POST['country'];
				$inv['cheque_no'] = $_POST['cheque_no'];
				$inv['cheque_no2'] = $_POST['cheque_no2'];
				$inv['admin_cheque_no'] = $_POST['admin_cheque_no'];
				$inv['tt_no'] = $_POST['tt_no'];
				$inv['admin_tt_no'] = $_POST['admin_tt_no'];
				$inv['admin_fee'] = $_POST['admin_fee'];
					
					
				$inv_id = $this->Invoice_model->addInvoice($inv);
				
				//add client payout
				$this->Invoice_model->addClientPayout($inv_id, $inv['inv_period'], $inv['inv_date'], $inv['inv_unitprice'] * $inv['inv_amt']);
				
				$agent_comm_pipeline = $this->Agent_model->getAgentCommAndPipeline($inv['agent_id']);
					
				$amt = $agent_comm_pipeline->{'agent_pipeline'} * $inv['inv_amt'];
				//add sales payout
				$this->Invoice_model->addSalesPayout($inv_id, $inv['agent_id'], $inv['inv_period'], $inv['inv_date'], $amt, $inv['funding_amt']);
				
				//add maanger payout
				$m_comm_pipeline = $this->Manager_model->getManagerCommAndPipeline($inv['m_id']);
					
				$amt = $m_comm_pipeline->{'m_pipeline'} * $inv['inv_amt'];
				//add sales payout
				$this->Invoice_model->addManagerPayout($inv_id, $inv['m_id'], $inv['inv_period'], $inv['inv_date'], $amt, $inv['funding_amt']);
				
				$updates = array();
				//upload contract
				if (isset($_FILES['contract']) && $_FILES['contract']['name'] != '') {
					if ($_FILES["contract"]["error"] > 0) {
						 $this->session->set_userdata('error', $_FILES["contract"]["error"]);
					}
					else if ($_FILES["contract"]["type"] != 'application/pdf') {
						$this->session->set_userdata('error', 'Please upload PDF only');
					}
					else {
						$filename = str_replace(' ', '_', 'contract_'.$inv_id.'.pdf');
						move_uploaded_file($_FILES["contract"]["tmp_name"], CONTRACT_PATH.$filename);
						$updates['contract'] = $filename;
					}
				}
			
				//uplaoad risk
				if (isset($_FILES['risk']) && $_FILES['risk']['name'] != '') {
					if ($_FILES["risk"]["error"] > 0) {
						 $this->session->set_userdata('error', $_FILES["risk"]["error"]);
					}
					else if ($_FILES["risk"]["type"] != 'application/pdf') {
						$this->session->set_userdata('error', 'Please upload PDF only');
					}
					else {
						$filename = str_replace(' ', '_', 'risk_'.$inv_id.'.pdf');
						move_uploaded_file($_FILES["risk"]["tmp_name"], RISK_PATH.$filename);
						$updates['risk'] = $filename;
					}
				}
			
				//upload iras
				if (isset($_FILES['iras']) && $_FILES['iras']['name'] != '') {
					if ($_FILES["iras"]["error"] > 0) {
						$this->session->set_userdata('error', $_FILES["iras"]["error"]);
					}
					else if ($_FILES["iras"]["type"] != 'application/pdf') {
						$this->session->set_userdata('error', 'Please upload PDF only');
					}
					else {
						$filename = str_replace(' ', '_', 'iras_'.$inv_id.'.pdf');
						move_uploaded_file($_FILES["iras"]["tmp_name"], IRAS_PATH.$filename);
						$updates['iras'] = $filename;
					}
				}
				
				//upload bank redcord
					if (isset($_FILES['bank']) && $_FILES['bank']['name'] != '') {
						if ($_FILES["bank"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["bank"]["error"]);
						}
						else if ($_FILES["bank"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'bank_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["bank"]["tmp_name"],BANK_PATH.$filename);
							$updates['bank_record'] = $filename;
						}
					}
					
					//workseet
					if (isset($_FILES['worksheet']) && $_FILES['worksheet']['name'] != '') {
						if ($_FILES["worksheet"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["worksheet"]["error"]);
						}
						else if ($_FILES["worksheet"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'worksheet_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["worksheet"]["tmp_name"], WORKSHEET_PATH.$filename);
							$updates['worksheet'] = $filename;
						}
					}
					
					//nric
					if (isset($_FILES['nric']) && $_FILES['nric']['name'] != '') {
						if ($_FILES["nric"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["nric"]["error"]);
						}
						else if ($_FILES["nric"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'nric_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["nric"]["tmp_name"], NRIC_PATH.$filename);
							$updates['nric'] = $filename;
						}
					}
					
					if (isset($_FILES['comfort_letter']) && $_FILES['comfort_letter']['name'] != '') {
						if ($_FILES["comfort_letter"]["error"] > 0) {
							$this->session->set_userdata('error', $_FILES["comfort_letter"]["error"]);
						}
						else if ($_FILES["comfort_letter"]["type"] != 'application/pdf') {
							$this->session->set_userdata('error', 'Please upload PDF only');
						}
						else {
							$filename = str_replace(' ', '_', 'comfort_letter_'.$inv_id.'.pdf');
							move_uploaded_file($_FILES["comfort_letter"]["tmp_name"],COMFORT_PATH.$filename);
							$updates['comfort_letter'] = $filename;
						}
					}
				if (count($updates) > 0) {
					$this->Invoice_model->updateInvoice($inv_id, $updates);
				}
				$this->session->set_userdata('success', 'Invoice added');
			
// 				exit;
				
				// $this->generateContract($inv_id);
// 				$this->generateRisk($inv_id);
// 				$this->generatePayout($inv_id);

				$this->generateFundingReceipt($inv_id, 0);
// 				$this->generateAdminReceipt($inv_id, 0);
					
				$this->sendEmailToFunder($inv_id);
				
				redirect('invoice/viewInvoice/?inv='.$inv_id);
				
			}
		}
		
		$this->load->view('invoice/addInvoiceView', $data);
	}
	
	function markSalesPaid() {
		if (isset($_GET['inv']) && isset($_GET['id'])) {
			$inv_id = $_GET['inv'];
			$payout_id = $_GET['id'];
			
			$this->Invoice_model->markSalesPaid($payout_id);
			redirect('invoice/viewInvoice/?inv='.$inv_id);
		}
	}
	
	function markSalesUnpaid() {
		if (isset($_GET['inv']) && isset($_GET['id'])) {
			$inv_id = $_GET['inv'];
			$payout_id = $_GET['id'];
			
			$this->Invoice_model->markSalesUnpaid($payout_id);
			redirect('invoice/viewInvoice/?inv='.$inv_id);
		}
	}
	
	function markMPaid() {
		if (isset($_GET['inv']) && isset($_GET['id'])) {
			$inv_id = $_GET['inv'];
			$payout_id = $_GET['id'];
			
			$this->Invoice_model->markManagerPaid($payout_id);
			redirect('invoice/viewInvoice/?inv='.$inv_id);
		}
	}
	
	function markMUnpaid() {
		if (isset($_GET['inv']) && isset($_GET['id'])) {
			$inv_id = $_GET['inv'];
			$payout_id = $_GET['id'];
			
			$this->Invoice_model->markManagerUnpaid($payout_id);
			redirect('invoice/viewInvoice/?inv='.$inv_id);
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
	
	function deleteInvoice() {
		if (isset($_GET['inv'])) {
			$this->Invoice_model->deleteInvoice($_GET['inv']);
			$this->session->set_userdata('success', 'Invoice deleted');
			redirect('invoice');
		}
	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */