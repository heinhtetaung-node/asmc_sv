<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	
	function loginAdmin($admin_name, $admin_pass) {
		$pass = md5($admin_pass);
		$sql = "select * from admin where admin_email = '$admin_name' and admin_pass = '$pass' and active = 1";
		
		$date = date('Y-m-d H:i:s');
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->{'admin_id'};
				$sql2 = "update admin set admin_login_date = '$date' where admin_id = $id";
				$this->db->query($sql2);
				return $row;
			}
		}
		else
			return false;
	}
	
	function getAllAdmin($limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$where = '';
		if ($search != null) {
			$where = " and (admin.admin_name like '%$search%' or admin.admin_email like '%$search%') ";
		}
		
		$sql = "select * from admin where active = 1 $where order by admin_name asc $filter";
		$query = $this->db->query($sql);
		$admins = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$admins[] = $row;
			}
		}
		return $admins;
	}
	
	function getAdminById($admin_id) {
		$sql = "select * from admin where admin_id = $admin_id and active = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function checkDuplicateEmail($email, $admin_id = null) {
		if ($admin_id != null) {
			$and = " and admin_id != $admin_id ";
		}
		else
			$and = '';
		$sql = "select * from admin where lower(admin_email) = lower('$email') $and and active = 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? true : false;
	
	}
	
	function updateAdmin($admin_id, $data) {
		$this->db->where('admin_id', $admin_id);
		$this->db->update('admin', $data);
	}
	
	function addAdmin($data) {
		$this->db->insert('admin', $data);
	}
	
	function deleteAdmin($id) {
		$sql = "update admin set active = 0 where admin_id = $id";
		$this->db->query($sql);
	}	
	
}
									