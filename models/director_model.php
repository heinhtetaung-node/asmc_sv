<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Director_model extends CI_Model {
	
	function loginDirector($dr_name, $dr_pass) {
		$pass = md5($dr_pass);
		$sql = "select * from director where dr_email = '$dr_name' and dr_pass = '$pass' and active = 1";
		
		$date = date('Y-m-d H:i:s');
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->{'dr_id'};
				$sql2 = "update director set dr_login_date = '$date' where dr_id = $id";
				$this->db->query($sql2);
				return $row;
			}
		}
		else
			return false;
	}
	
	function getAllDirector($limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$where = '';
		if ($search != null) {
			$where = " and (director.dr_name like '%$search%' or director.dr_email like '%$search%' or director.dr_code like '%$search%') ";
		}
		
		$sql = "select * from director where active = 1 $where order by dr_name asc ".$filter;
		$query = $this->db->query($sql);
		$m = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$m[] = $row;
			}
		}
		return $m;
	}
	
	function getDirectorById($dr_id) {
		$sql = "select * from director where dr_id = $dr_id and active = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function checkDuplicateEmail($email, $dr_id = null) {
		if ($dr_id != null) {
			$and = " and dr_id != $dr_id ";
		}
		else
			$and = '';
		$sql = "select * from director where lower(dr_email) = lower('$email') $and and active = 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? true : false;
	
	}
	
	function updateDirector($dr_id, $data) {
		$this->db->where('dr_id', $dr_id);
		$this->db->update('director', $data);
	}
	
	function addDirector($data) {
		$this->db->insert('director', $data);
	}
	
	function deleteDirector($id) {
		$sql = "update director set active = 0 where dr_id = $id";
		$this->db->query($sql);
	}	
	
	function getDirectorCommAndPipeline($dr_id) {
		$sql = "select dr_comm, dr_pipeline from director where dr_id = $dr_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
}
									