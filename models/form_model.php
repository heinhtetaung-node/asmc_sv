<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_model extends CI_Model {
	//fetch result, return single object or array of objects
	function fetchResult($sql, $single_object) {
		$query = $this->db->query($sql);
		
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if ($single_object)
					return $row;
				else 
					$data[] = $row;
			}
		}
		return $data;
	}
	
	function addForm($data) {
		$this->db->insert('forms', $data);
	}
	
	function updateForm($id, $data) {
		$this->db->where('f_id', $id);
		$this->db->update('forms', $data);
	}
	
	function getCountry() {
		$sql = "select * from countries";
		return $this->fetchResult($sql, false);
	}
	
	function getForm($id) {
		$sql = "select * from forms where f_id = $id";
		return $this->fetchResult($sql, true);
	}
	function getAllForms($approved = null, $limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$where = '';
		$whereArr = array();
		
		if ($search != null && trim($search) != '') {
			$keys = explode(' ', $search);
			if (count($keys) > 0) {
				$fields = $this->db->list_fields('forms');	
				$or = array();
				foreach ($keys as $key) {
					foreach ($fields as $field)
					{
					   $or[] = $field." like '%$search%' ";
					}
				}
				if (count($or) > 0) {
					$whereArr[] = " (".join(' or ',$or).")";
				}
			}
		}
		
		//filter by agent or manager
		if ($this->session->userdata('user_type') == 'manager') {
			$whereArr[] = " manager_id = ".$this->session->userdata('manager')->{'m_id'};
		}
		if ($this->session->userdata('user_type') == 'agent') {
			$whereArr[] = " agent_id = ".$this->session->userdata('agent')->{'agent_id'};
		}
		if ($this->session->userdata('user_type') == 'director') {
			$whereArr[] = " director_id = ".$this->session->userdata('director')->{'dr_id'};
		}
		
		
		if ($approved == 1) {
			$whereArr[] = "  form_approved_date is not null";
		}
		else if ($approved == 0) {
			$whereArr[] = "  form_approved_date is null";
		}
		if (count($whereArr) > 0) {
			$where = 'where';
			$where .= count($where) == 1 ? $whereArr[0] : join(' and ', $whereArr);
		}
		
		$sql = "select * from forms $where $filter";
		return $this->fetchResult($sql, false);
	}
}
									