<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crons extends CI_Controller {

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
		
		$this->load->model('Invoice_model');
	}
	
	function emails() {
		$emails = $this->Invoice_model->getUnsentEmail(3);
		if (count($emails) > 0) {
			for ($i = 0; $i < count($emails); $i++) {
				$result = $this->sendEmail($emails[$i]->{'subject'},$emails[$i]->{'sender'},$emails[$i]->{'receipient'},
						$emails[$i]->{'sender_name'},$emails[$i]->{'receipient_name'},$emails[$i]->{'msg'},$emails[$i]->{'file'});
				if ($result)
					$this->Invoice_model->updateEmail($emails[$i]->{'e_id'}, array('sent_date'=>date('Y-m-d H:i:s'),'sent_status'=>'success'));
				else
					$this->Invoice_model->updateEmail($emails[$i]->{'e_id'}, array('sent_status'=>'failed'));
			}
		}
	}
	
	function sendEmail($subject, $from, $to, $from_name, $to_name, $msg, $file) {
	
		
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['smtp_host'] = 'mail.asmc.com.sg';
		$config['smtp_user'] = 'mailer@asmc.com.sg';
		$config['smtp_pass'] = 'p@$$w0rd123';
		
		$this->load->library('email', $config); 
		$this->email->from($from, $from_name);
		
		$this->email->reply_to($from, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($msg);
		$this->email->attach($file);
		$result = $this->email->send();
		$this->email->clear(TRUE);
		
		return $result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */