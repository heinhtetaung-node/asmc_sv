<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

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
		else if ($this->session->userdata('user_type') == 'customer') {
			echo 'access denied';
			exit;
		}
			
		$this->load->library('pagination');
		$this->load->model('Form_model');
		$this->load->model('Invoice_model');
		$this->load->library('form_validation');
		
		$this->load->model('Customer_model');
		$this->load->model('Manager_model');
		$this->load->model('Director_model');
		$this->load->model('Agent_model');
	}
	
	public function getallcustomers(){
		echo json_encode($this->Customer_model->getAllCustomer());
	}
	
	public function index()
	{	
		$condition="";
		$data['title'] = WEB_TITLE;
		$data['active'] = 4;
		
		$data['managers'] = $this->Manager_model->getAllManager();
		$data['directors'] = $this->Director_model->getAllDirector();
		$data['agents'] = $this->Agent_model->getAllAgent();
		$data['funders'] = $this->Customer_model->getAllCustomer();
		
		$data['countries'] = $this->Form_model->getCountry();
		
		if (isset($_POST['submit'])) {
			unset($_POST['submit']);
			
			$existing_cus = $this->Customer_model->getCustomerWithIC($_POST['nric']);
			if (count($existing_cus) > 0) {
				$cu_id = $existing_cus->{'customer_id'};
			}
			else {
				$condition="condition1";
				// echo "<pre>";
				// var_dump($_POST);
				// echo "</pre>";
				
			
				//add customer
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
				$password = substr( str_shuffle( $chars ), 0, 8 );
				
				$c['customer_name'] = $_POST['name'];
				$c['customer_username'] = strtolower(trim($_POST['name']));
				$c['customer_email'] = $_POST['email'];
				$c['customer_pass'] = md5($password);
				$c['customer_nric'] = $_POST['nric'];
				$c['customer_dob'] = date('Y-m-d', strtotime($_POST['dob']));
				$c['customer_addr'] = $_POST['address'];
				$c['customer_mobile'] = $_POST['mobile'];
				$c['customer_home_no'] = $_POST['tel'];
				$c['customer_bank_name'] = $_POST['bank_acc_name'];
				$c['customer_bank_acc'] = $_POST['bank_acc_no'];
// 				$c['customer_bank_type'] = $_POST['bank_type'];
				$c['customer_created_date'] = date('Y-m-d H:i:s');
				
				// if($condition=="condition1"){
					// $res=$this->sendNewCustomerEmail($c, $_POST);
					// if($res!="Message has been sent."){
						// echo $res;
					// }
				// }
				// exit;
				
				//echo $password; echo "<br>"; echo $c['customer_pass']; //exit;
				$cu_id = $this->Customer_model->addCustomer($c);
				
				if($cu_id){
					if($c['customer_email']!=""){
						$res=$this->Customer_model->sendFunderAutoGeneratePwEmail($c, $password);
						if($res!="Message has been sent."){
							echo $res;
						}
					}
					
					$res=$this->sendNewCustomerEmail($c, $_POST);
					if($res!="Message has been sent."){
						echo $res;
					}
				}
			}
			
			$_POST['cu_id'] = $cu_id;
			$_POST['form_created_date'] = date('Y-m-d H:i:s');
			
			$_POST['creator_type'] = $this->session->userdata('user_type');
			
			if ($this->session->userdata('user_type') == 'admin')
				$_POST['creator_id'] = $this->session->userdata('admin')->{'admin_id'};
			else if ($this->session->userdata('user_type') == 'manager')
				$_POST['creator_id'] = $this->session->userdata('manager')->{'m_id'};
			else if ($this->session->userdata('user_type') == 'agent')
				$_POST['creator_id'] = $this->session->userdata('agent')->{'agent_id'};
			
			else if ($this->session->userdata('user_type') == 'director')
				$_POST['creator_id'] = $this->session->userdata('director')->{'dr_id'};
			
			
			// Date change to valid Edit by Hein Htet Aung August 3 
			if($_POST['dob']!=""){
				$_POST['dob'] = substr($_POST['dob'],6,4)."-".substr($_POST['dob'],3,2)."-".substr($_POST['dob'],0,2);
			}
			if($_POST['due_date']!=""){
				$_POST['due_date'] = substr($_POST['due_date'],6,4)."-".substr($_POST['due_date'],3,2)."-".substr($_POST['due_date'],0,2);
			}
			if($_POST['commencement_date']!=""){
				$_POST['commencement_date'] = substr($_POST['commencement_date'],6,4)."-".substr($_POST['commencement_date'],3,2)."-".substr($_POST['commencement_date'],0,2);
			}
			if($_POST['completion_date']!=""){
				$_POST['completion_date'] = substr($_POST['completion_date'],6,4)."-".substr($_POST['completion_date'],3,2)."-".substr($_POST['completion_date'],0,2);
			}
			if($_POST['form_date']!=""){
				$_POST['form_date'] = substr($_POST['form_date'],6,4)."-".substr($_POST['form_date'],3,2)."-".substr($_POST['form_date'],0,2);
			}
			$condition="condition2";
			// echo "condition2";
			// echo "<pre>";
			// var_dump($_POST);
			// echo "</pre>";
			
			//exit;
			
			unset($_POST['director_email']);
			unset($_POST['manager_email']);
			unset($_POST['agent_email']);
			
			// echo "condition2";
			// echo "<pre>";
			// var_dump($_POST);
			// echo "</pre>";
			
			// exit;
			
			$this->Form_model->addForm($_POST);
			
			$this->session->set_userdata('success', 'Form submitted');
			
			$emailData = $_POST;
			if (isset($_POST['agent_id']) && $_POST['agent_id'] != '') {
				$agent = $this->Agent_model->getAgentById($_POST['agent_id']);
				if (count($agent) > 0) {
					$emailData['crm'] = $agent->{'agent_name'};
				}
			}
			
			if (isset($_POST['manager_id']) && $_POST['manager_id'] != '') {
				$m = $this->Manager_model->getManagerById($_POST['manager_id']);
				if (count($m) > 0) {
					$emailData['sm'] = $m->{'m_name'};
				}
			}
			
			
			
			$email = $this->load->view('form/email', $emailData, true);
			$this->email($email);
			
		}
		$this->load->view('form/index', $data);
	}
	
	
	function email($message) {
		$subject = 'BM Steam Coal Reservation Form';
		$to = 'martin@blackmineral.com.sg,surina@asmc.com.sg,meilinda@blackmineral.com.sg,support@sgdatahub.com';
		$to = 'cayden.liew@sgdatahub.com';
		$name = 'Black Mineral';
		$from = 'support@sgdatahub.com';
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
// 		$config['smtp_host'] = 'mail.sgdatahub.com';
		$config['smtp_host'] = '192.168.0.12';
		$config['smtp_user'] = 'mailer@sgdatahub.com';
		$config['smtp_pass'] = 'a159Rv45262B$%579985059046';
		
		$this->load->library('email', $config); 
		$this->email->from($from, $name);
		
		$this->email->reply_to($from, $name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
// 		$this->email->send();
	}
	
	function sendNewCustomerEmail($c, $post){	//added by Hein Htet Aung Aug 11,2016
	
		//echo "dddd";
		$subject = 'Sign Up Form submit by New Customer';
		$to = "";
		if($post['director_email']!=""){
			$to=$to.$post['director_email'];
		}
		if($post['manager_email']!=""){
			$to=$to.",".$post['manager_email'];
		}
		if($post['agent_email']!=""){
			$to=$to.",".$post['agent_email'];
		}
		//echo $to;
		$message="<h1>New Customer ".$c['customer_name']." created new sign up Record.</h1>";
		
		$name = $c['customer_name'];
		$from = 'testmail@sgdatacrm.com';
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = SMTP_HOST;
		$config['smtp_port'] = SMTP_PORT; 
		$config['smtp_crypto'] = SMTP_CRYPTO;
		$config['smtp_user'] = SMTP_USER;
		$config['smtp_pass'] = SMTP_PASS;
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['newline'] = "\r\n";
		
		$this->load->library('email'); 
		$this->email->from($from, 'ASMC CRM System');
		$this->email->to($to, $name);
		$this->email->subject($subject);
		$this->email->message($message); 
		$this->email->set_mailtype("html");
		try{
			$this->email->send();
			$res='Message has been sent.';
			return $res;
		}catch(Exception $e){
			$res=$e->getMessage();
		}
		
		//echo $res; exit;
		
	}
	
	function viewRecords() {
		$data['title'] = 'Online Signup Record';
		$data['subtitle'] = 'Signup Records';
		
		$data['active'] = 'online';
		
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
			
		$data['forms'] = $this->Form_model->getAllForms(null,$limit, $offset, $search);
		
		$config['base_url'] = base_url().'forms/editRecord?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Form_model->getAllForms(null,null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
// 		$data['invoices'] = $this->Invoice_model->getAllInvoice();
		$this->load->view('form/list', $data);
	}
	
	function editRecord() {
		$data['title'] = WEB_TITLE;
		$data['active'] = 4;
		
		$data['is_edit'] = 1;
		$data['managers'] = $this->Manager_model->getAllManager();
		$data['directors'] = $this->Director_model->getAllDirector();
		$data['agents'] = $this->Agent_model->getAllAgent();
		$data['countries'] = $this->Form_model->getCountry();
		
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$form = $this->Form_model->getForm($_GET['id']);
			$this->load->vars((array)$form);
			
			if (isset($_POST['submit'])) {
				unset($_POST['submit']);
			
			
				$this->Form_model->updateForm($_GET['id'],$_POST);
			
				$this->session->set_userdata('success', 'Form updated');
			
			}
			$this->load->model("Condition_model");
			if($this->session->userdata('user_type')=="admin"){		// New code added by Hein Htet Aung August 06, 2016 to check admin edit permission by cretor.
				$data['permissionrecord']=$this->Condition_model->checkenable_after3day($_GET['id']);
			}
			$this->load->view('form/editForm', $data);
		}
	}
	
	function deleteRecord() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$sql = "delete from forms where f_id = ".$_GET['id'];
			$this->db->query($sql);
			$this->session->set_userdata('success', 'Form deleted');
			redirect('form/viewRecords');
		}
	}
	
	
	
	
	
	public function viewRecentSignup($creator_id)			// new function added by Hein Htet Aung August 3, 2016
	{	
		$data['title'] = 'Online Signup Record';
		$data['subtitle'] = 'Signup Records';
		
		$data['active'] = 'online';
		
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
		
		$this->load->model('Condition_model');
		$data['forms'] = $this->Condition_model->checksignup_within3day($creator_id);
		
		$config['base_url'] = base_url().'forms/editRecord?'.http_build_query($qStr);
		$config['total_rows'] = count($this->Form_model->getAllForms(null,null, null, $search));
		$config['per_page'] = $per_page; 
		$config['use_page_numbers'] = TRUE;
		$config['query_string_segment'] = 'p';
		
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config); 
		
// 		$data['invoices'] = $this->Invoice_model->getAllInvoice();
		$this->load->view('form/list', $data);
	}
	
	public function update_editpermission(){ // New code added by Hein Htet Aung August 06, 2016 to check admin edit permission by cretor.
		$data = json_decode(file_get_contents("php://input"));     
		
		$this->load->model('Condition_model');
		$res=$this->Condition_model->update_editpermission($data->f_id, $data->edit_permission);
		
		echo json_encode($res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */