<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

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
		if ($this->session->userdata('user_type') == null)
			redirect('login');
			
		$this->load->model('Message_model');
		$this->load->model('Admin_model');
		$this->load->model('Manager_model');
		$this->load->model('Director_model');
		$this->load->model('Agent_model');
		$this->load->model('Customer_model');
		$this->load->library('form_validation');
	}
	
	//list all admin
	public function index() {
		$data['title'] = 'Message';
		$data['subtitle'] = 'Inbox';
		
		$data['active'] = 'inbox';
		if ($this->session->userdata('user_type') == 'admin')
			$id = $this->session->userdata('admin')->{'admin_id'};
		else if ($this->session->userdata('user_type') == 'manager')
			$id = $this->session->userdata('manager')->{'m_id'};
		else if ($this->session->userdata('user_type') == 'agent')
			$id = $this->session->userdata('agent')->{'agent_id'};
		else if ($this->session->userdata('user_type') == 'customer')
			$id = $this->session->userdata('customer')->{'customer_id'};
		else if ($this->session->userdata('user_type') == 'director')
			$id = $this->session->userdata('director')->{'dr_id'};
			
		$data['messages'] = $this->Message_model->getInbox($this->session->userdata('user_type'), $id);
		
		$this->load->view('message/inboxView', $data);
	}
	
	function sent() {
		$data['title'] = 'Message';
		$data['subtitle'] = 'Sent Items';
		
		$data['active'] = 'sent';
		
		if ($this->session->userdata('user_type') == 'admin')
			$id = $this->session->userdata('admin')->{'admin_id'};
		else if ($this->session->userdata('user_type') == 'manager')
			$id = $this->session->userdata('manager')->{'m_id'};
		else if ($this->session->userdata('user_type') == 'agent')
			$id = $this->session->userdata('agent')->{'agent_id'};
		else if ($this->session->userdata('user_type') == 'customer')
			$id = $this->session->userdata('customer')->{'customer_id'};
		else if ($this->session->userdata('user_type') == 'director')
			$id = $this->session->userdata('director')->{'dr_id'};
		$data['messages'] = $this->Message_model->getSentMessage($this->session->userdata('user_type'), $id);
// 		echo '<pre>';
		// print_r($data);exit;
		$this->load->view('message/sentView', $data);
	}
	
	//for non admin
	public function composing() {
		$data['title'] = 'Message';
		$data['subtitle'] = 'Compose message';
		
		$data['active'] = 'compose';
		if (isset($_POST['subject'])) {
			// echo '<pre>';
// 			print_r($_POST);exit;
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//check this login user group
				$msg['msg_from_group'] = $this->session->userdata('user_type');
				
				//sender
				
			   if ($this->session->userdata('user_type') == 'manager')
					$msg['msg_from'] = $this->session->userdata('manager')->{'m_id'};
				else if ($this->session->userdata('user_type') == 'agent')
					$msg['msg_from'] = $this->session->userdata('agent')->{'agent_id'};
				else if ($this->session->userdata('user_type') == 'customer')
					$msg['msg_from'] = $this->session->userdata('customer')->{'customer_id'};
				else if ($this->session->userdata('user_type') == 'director')
					$msg['msg_from']  = $this->session->userdata('director')->{'dr_id'};
				$msg['msg_subject'] = $_POST['subject'];
				$msg['msg_text'] = $_POST['message'];
				$msg['msg_sent_date'] = date('Y-m-d H:i:s');
				
				//send tot admin only
				$msg['msg_to_group'] = 'admin';
				$msg['msg_to'] = '1';
				
				$messages[] = $msg;
				$this->Message_model->addMultipleMsg($messages);
				$this->session->set_userdata('success', 'Message sent successfully.');
				redirect('message/composing');
				
			}
		
		}
		$this->load->view('message/compose2View', $data);
	}
	
	//only for admin
	public function compose() {
		$data['title'] = 'Message';
		$data['subtitle'] = 'Compose message';
		
		$data['active'] = 'compose';
		if (isset($_POST['subject'])) {
			// echo '<pre>';
// 			print_r($_POST);exit;
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				//check this login user group
				$msg['msg_from_group'] = $this->session->userdata('user_type');
				
				//sender
				if ($this->session->userdata('user_type') == 'admin')
					$msg['msg_from'] = $this->session->userdata('admin')->{'admin_id'};
				else if ($this->session->userdata('user_type') == 'manager')
					$msg['msg_from'] = $this->session->userdata('manager')->{'m_id'};
				else if ($this->session->userdata('user_type') == 'agent')
					$msg['msg_from'] = $this->session->userdata('agent')->{'agent_id'};
				else if ($this->session->userdata('user_type') == 'customer')
					$msg['msg_from'] = $this->session->userdata('customer')->{'customer_id'};
			else if ($this->session->userdata('user_type') == 'director')
					$msg['msg_from']  = $this->session->userdata('director')->{'dr_id'};
					
				//receiver group type
				if ($_POST['group'] == 1)
					$msg['msg_to_group'] = 'manager';
				else if ($_POST['group'] == 2)
					$msg['msg_to_group'] = 'agent';
				else if ($_POST['group'] == 3)
					$msg['msg_to_group'] = 'customer';
				else if ($_POST['group'] == 5)
					$msg['msg_to_group'] = 'director';
				
				$msg['msg_subject'] = $_POST['subject'];
				$msg['msg_text'] = $_POST['message'];
				$msg['msg_sent_date'] = date('Y-m-d H:i:s');
				
				//create msg object for all receiver
				$receiver_ids = array();
				
				//send to all manager
				if ($_POST['group'] == 1 && $_POST['to'] == 1) {
					$users = $this->Manager_model->getAllManager();
					for ($i = 0; $i < count($users); $i++) {
						$receiver_ids[] = $users[$i]->{'m_id'};
					}
				}
				//send to selecte manager
				else if ($_POST['group'] == 1 && $_POST['to'] == 2) {
					foreach ($_POST as $key => $val) {
						if (strpos($key, 'user-') !== false) {
							$receiver_ids[] = $val;
						}
					}
				}
				else if ($_POST['group'] == 5 && $_POST['to'] == 1) {
					$users = $this->Director_model->getAllDirector();
					for ($i = 0; $i < count($users); $i++) {
						$receiver_ids[] = $users[$i]->{'dr_id'};
					}
				}
				//send to selecte manager
				else if ($_POST['group'] == 5 && $_POST['to'] == 2) {
					foreach ($_POST as $key => $val) {
						if (strpos($key, 'user-') !== false) {
							$receiver_ids[] = $val;
						}
					}
				}
				//send to all agent
				else if ($_POST['group'] == 2 && $_POST['to'] == 1) {
					$users = $this->Agent_model->getAllAgent();
					for ($i = 0; $i < count($users); $i++) {
						$receiver_ids[] = $users[$i]->{'agent_id'};
					}
				}
				//send to selecte agent
				else if ($_POST['group'] == 2 && $_POST['to'] == 2) {
					foreach ($_POST as $key => $val) {
						if (strpos($key, 'user-') !== false) {
							$receiver_ids[] = $val;
						}
					}
				}
				//send to all customer
				else if ($_POST['group'] == 3 && $_POST['to'] == 1) {
					$users = $this->Customer_model->getAllCustomer();
					for ($i = 0; $i < count($users); $i++) {
						$receiver_ids[] = $users[$i]->{'customer_id'};
					}
				}
				//send to selecte customer
				else if ($_POST['group'] == 3 && $_POST['to'] == 2) {
					foreach ($_POST as $key => $val) {
						if (strpos($key, 'user-') !== false) {
							$receiver_ids[] = $val;
						}
					}
				}
				
				if (count($receiver_ids) > 0) {
					
					$messages = array();
					for ($i = 0; $i < count($receiver_ids); $i++) {
						$m = $msg;
						$m['msg_to'] = $receiver_ids[$i];
						$messages[] = $m;
					}
					
					$this->Message_model->addMultipleMsg($messages);
					$this->session->set_userdata('success', 'Message sent successfully.');
					redirect('message/compose');
				}
				else {
					$this->session->set_userdata('error', 'You have not selected any receiver yet.');
				}
			}
		
		}
		$this->load->view('message/messageComposeView', $data);
	}
	
	public function getReceivers() {
		$users = array();
		//manager
		if (isset($_POST['type']) && $_POST['type'] == 1) {
			$users = $this->Manager_model->getAllManager();
			if (count($users) > 0) {
				foreach ($users as $user) {
					echo '<div style="width:25%;float:left"><input type="checkbox" name="user-'.$user->{'m_id'}.'" value="'.$user->{'m_id'}.'"/>
					  		<span class="custom-checkbox"></span>'.$user->{"m_name"}.'</div>';
				}
			}
		}
		else //manager
		if (isset($_POST['type']) && $_POST['type'] == 5) {
			$users = $this->Director_model->getAllDirector();
			if (count($users) > 0) {
				foreach ($users as $user) {
					echo '<div style="width:25%;float:left"><input type="checkbox" name="user-'.$user->{'dr_id'}.'" value="'.$user->{'dr_id'}.'"/>
					  		<span class="custom-checkbox"></span>'.$user->{"dr_name"}.'</div>';
				}
			}
		}
		//agent
		else if (isset($_POST['type']) && $_POST['type'] == 2) {
			$users = $this->Agent_model->getAllAgent();
			if (count($users) > 0) {
				foreach ($users as $user) {
					echo '<div style="width:25%;float:left"><input type="checkbox" name="user-'.$user->{'agent_id'}.'" value="'.$user->{'agent_id'}.'"/>
					  		<span class="custom-checkbox"></span>'.$user->{"agent_name"}.'</div>';
				}
			}
		}
		//customer
		else if (isset($_POST['type']) && $_POST['type'] == 3) {
			$users = $this->Customer_model->getAllCustomer();
			if (count($users) > 0) {
				foreach ($users as $user) {
					echo '<div style="width:25%;float:left"><input type="checkbox" name="user-'.$user->{'customer_id'}.'" value="'.$user->{'customer_id'}.'"/>
					  		<span class="custom-checkbox"></span>'.$user->{"customer_name"}.'</div>';
				}
			}
		}	
	}
	
	function readMessage() {
		$data['title'] = 'Message';
		$data['subtitle'] = 'Read message';
		
		$data['active'] = $_GET['a'];
		
		if (isset($_GET['mid']) && $_GET['mid'] != '') {
			
			$data['message'] = $this->Message_model->getMessageById($_GET['mid']);
			
			
// 			echo '<pre>';print_r($data['message']);exit;
			//if im receiver and im reading, mark the msg as read
			
			if ($data['message']->{'msg_to_group'} == $this->session->userdata('user_type')) {
				if ($this->session->userdata('user_type') == 'admin')
					$id = $this->session->userdata('admin')->{'admin_id'};
				else if ($this->session->userdata('user_type') == 'manager')
					$id = $this->session->userdata('manager')->{'m_id'};
				else if ($this->session->userdata('user_type') == 'agent')
					$id = $this->session->userdata('agent')->{'agent_id'};
				else if ($this->session->userdata('user_type') == 'customer')
					$id = $this->session->userdata('customer')->{'customer_id'};
				else if ($this->session->userdata('user_type') == 'director')
					$id = $this->session->userdata('director')->{'dr_id'};
				if ($data['message']->{'msg_to'} == $id) {
					$this->Message_model->markMsgRead($_GET['mid']);
				}
			}
			
			
		}
	    if (isset($_POST['submit'])) {
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		
			//validate
			$this->form_validation->set_rules('msg_text', 'Message', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{
				
			}
			else {
				$mid = $_POST['msg_id'];
				$message = $this->Message_model->getMessageById($_GET['mid']);
				
				$msg['msg_from_group'] = $this->session->userdata('user_type');
				
				//sender
				if ($this->session->userdata('user_type') == 'admin')
					$msg['msg_from'] = $this->session->userdata('admin')->{'admin_id'};
				else if ($this->session->userdata('user_type') == 'manager')
					$msg['msg_from'] = $this->session->userdata('manager')->{'m_id'};
				else if ($this->session->userdata('user_type') == 'agent')
					$msg['msg_from'] = $this->session->userdata('agent')->{'agent_id'};
				else if ($this->session->userdata('user_type') == 'customer')
					$msg['msg_from'] = $this->session->userdata('customer')->{'customer_id'};
				else if ($this->session->userdata('user_type') == 'director')
					$msg['msg_from'] = $this->session->userdata('director')->{'dr_id'};
					
				//receiver group type should be the sender of the original message
				$msg['msg_to_group'] = $message->{'msg_from_group'};
				
				$msg['msg_subject'] = $message->{'msg_subject'};
				$msg['msg_text'] = $_POST['msg_text'];
				$msg['msg_sent_date'] = date('Y-m-d H:i:s');
				
				$msg['msg_to'] = $message->{'msg_from'};
				$messages[] = $msg;
				$this->Message_model->addMultipleMsg($messages);
				$this->session->set_userdata('success', 'Message sent');
				redirect('message');
			}
			
		}
		$this->load->view('message/readView', $data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */