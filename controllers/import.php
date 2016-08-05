<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

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
		
		
	}
	function index() {
	
	}
	
	function importR() {
		$base_url = '/Applications/MAMP/htdocs/asmc/crm/pdf/import/receipt/';
		if ($handle = opendir($base_url)) {
			echo "Directory handle: $handle<br/>";
			echo "Entries:<br/>";

			/* This is the correct way to loop over the directory. */
			while (false !== ($folder = readdir($handle))) {
				$pdf = '';
				if ($folder != '' && $folder != '.' && $folder != '..' && $folder != '.DS_Store') {
// 					echo "$folder<br/>";
					$sql = "select inv_id from invoice where inv_no = '$folder'";
					$query = $this->db->query($sql);
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {
							$inv_id = $row->{'inv_id'};
						}
						//get all receipts under this folder
						$handle2 = opendir($base_url.$folder.'/');
						while (false !== ($pdf = readdir($handle2))) {
							if ($pdf != '' && $pdf != '.' && $pdf != '..' && $pdf != '.DS_Store') {
								echo "$pdf<br/>";
								$split = explode('.pdf', $pdf);
								echo date('Y-m', strtotime($split[0])).'<br/>';
								$date = date('Y-m', strtotime($split[0]));
								//get payout id
							$sql = "select id from client_payout where inv_id =$inv_id and date like '$date%'";
							 $query = $this->db->query($sql);
							 if ($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$pid = $row->{'id'};
								}
								$filename = $pid.$pdf;
								$sql = "update client_payout set pdf_receipt = '$pdf' where id=$pid";
								$this->db->query($sql);
							
								//rename file
								rename($base_url.$folder.'/'.$pdf, $base_url.$folder.'/'.$filename);
							 }

							}
						}
						
						
						
// 						$filename = $inv_id.$
					}
// 					exit;
				}
				
			}

			closedir($handle);
		}
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */