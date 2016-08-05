<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model {
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
	function loginCustomer($customer_name, $customer_pass) {
		$pass = md5($customer_pass);
		$sql = "select * from customer where customer_username = '$customer_name' and customer_pass = '$pass' and active = 1";
// 		print_r($sql);exit;
		$date = date('Y-m-d H:i:s');
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->{'customer_id'};
				$sql2 = "update customer set customer_login_date = '$date' where customer_id = $id";
				$this->db->query($sql2);
				return $row;
			}
		}
		else
			return false;
	}
	
	function getAllCustomer($limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$where = '';
		if ($search != null) {
			$where = " and (customer.customer_name like '%$search%' or customer.customer_email like '%$search%' 
					or customer.customer_mobile like '%$search%' or customer.customer_nric like '%$search%'
					or customer.customer_addr like '%$search%') ";
		}
		
		$sql = "select * from customer where active = 1 $where order by customer_id desc ".$filter;
		$query = $this->db->query($sql);
		$m = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$m[] = $row;
			}
		}
		return $m;
	}
	
	function getCustomerById($customer_id) {
		$sql = "select * from customer where customer_id = $customer_id and active = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function checkDuplicateEmail($email, $customer_id = null) {
		if ($customer_id != null) {
			$and = " and customer_id != $customer_id ";
		}
		else
			$and = '';
		$sql = "select * from customer where lower(customer_email) = lower('$email') $and and active = 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? true : false;
	}
	
	function updateCustomer($customer_id, $data) {
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customer', $data);
	}
	
	function addCustomer($data) {
		$this->db->insert('customer', $data);
		return $this->db->insert_id();
	}
	
	function getCustomerWithIC($nric) {
		$sql = "select * from customer where lower(customer_nric) = lower('$nric')";
		return $this->fetchResult($sql, true);
	}
	
	function deleteCustomer($id) {
		$sql = "update customer set active = 0 where customer_id = $id";
		$this->db->query($sql);
	}	
}
									