<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Condition_model extends CI_Model {
	
	function checksignup_within3day($creator_id) {
		$sql = sprintf("
				SELECT *, (SELECT COUNT(formid) FROM invoice where invoice.formid=forms.f_id ) as inv_status, DATEDIFF(CURDATE(), form_created_date) AS DiffDate 
				FROM `forms` 
				WHERE creator_id=%d 
				AND DATEDIFF(CURDATE(), form_created_date)<4 
				ORDER BY f_id DESC",$creator_id
				);
		
		$Q = $this->db->query($sql);
		return $Q->result_array();		
	}	
	
}
									