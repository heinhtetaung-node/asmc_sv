<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager_model extends CI_Model {
	
	function loginManager($m_name, $m_pass) {
		$pass = md5($m_pass);
		$sql = "select * from manager where m_email = '$m_name' and m_pass = '$pass' and active = 1";
		
		$date = date('Y-m-d H:i:s');
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->{'m_id'};
				$sql2 = "update manager set m_login_date = '$date' where m_id = $id";
				$this->db->query($sql2);
				return $row;
			}
		}
		else
			return false;
	}
	
	function getAllManager($dr_id = null,$limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$whereArr = array();
		if ($search != null) {
			$whereArr[] = "  (manager.m_name like '%$search%' or manager.m_email like '%$search%' or manager.m_code like '%$search%') ";
		}
		
		if ($dr_id != null && $dr_id != '')
			$whereArr[] = ' m_upline = '.$dr_id;
			
		$where = '';
		if (count($whereArr) > 0) {
			$where = count($whereArr) > 1 ? join(' and ', $whereArr) : 'and '.$whereArr[0];
		}
		
		$sql = "select * from manager where active = 1 $where order by m_name asc ".$filter;
		$query = $this->db->query($sql);
		$m = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$m[] = $row;
			}
		}
		return $m;
	}
	
	function getManagerById($m_id) {
		$sql = "select * from manager where m_id = $m_id and active = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function checkDuplicateEmail($email, $m_id = null) {
		if ($m_id != null) {
			$and = " and m_id != $m_id ";
		}
		else
			$and = '';
		$sql = "select * from manager where lower(m_email) = lower('$email') $and and active = 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? true : false;
	
	}
	
	function updateManager($m_id, $data) {
		$this->db->where('m_id', $m_id);
		$this->db->update('manager', $data);
	}
	
	function addManager($data) {
		$this->db->insert('manager', $data);
	}
	
	function deleteManager($id) {
		$sql = "update manager set active = 0 where m_id = $id";
		$this->db->query($sql);
	}	
	
	function getManagerCommAndPipeline($m_id) {
		$sql = "select m_comm, m_pipeline from manager where m_id = $m_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
}
									