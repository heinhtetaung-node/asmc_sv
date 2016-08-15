<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Condition_model extends CI_Model {
	
	function checksignup_within3day($creator_id) {
		$sql = sprintf("
				SELECT *, (SELECT COUNT(formid) FROM invoice where invoice.formid=forms.f_id ) as inv_status, DATEDIFF(CURDATE(), form_created_date) AS DiffDate 
				FROM `forms` 
				WHERE 
				(creator_id=%d AND DATEDIFF(CURDATE(), form_created_date)<4 AND edit_permission=0)
				OR 
				(creator_id=%d AND DATEDIFF(CURDATE(), form_created_date)>=4 AND edit_permission=1)
				ORDER BY f_id DESC",$creator_id, $creator_id
				);
		
		$Q = $this->db->query($sql);
		return $Q->result_array();		
	}	
	
	function checkenable_after3day($formid){
		$sql = sprintf("
				SELECT edit_permission, DATEDIFF(CURDATE(), form_created_date) AS DiffDate 
				FROM `forms` 
				WHERE 
				f_id=%d AND DATEDIFF(CURDATE(), form_created_date)>=4
				",$formid
				);
		
		$Q = $this->db->query($sql);
		return $Q->result_array();		
	}
	
	function update_editpermission($f_id, $edit_permission){
		$sql = sprintf("
				UPDATE `forms` SET `edit_permission` = '%d' WHERE `f_id` = %d;
				",$edit_permission, $f_id
				);
		
		$Q = $this->db->query($sql);
		return $this->db->affected_rows();			
	}
	
}
									