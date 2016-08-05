<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_model extends CI_Model {
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
	function loginAgent($agent_name, $agent_pass) {
		$pass = md5($agent_pass);
		$sql = "select * from agent where agent_email = '$agent_name' and agent_pass = '$pass' and active = 1";
		
		$date = date('Y-m-d H:i:s');
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$id = $row->{'agent_id'};
				$sql2 = "update agent set agent_login_date = '$date' where agent_id = $id";
				$this->db->query($sql2);
				return $row;
			}
		}
		else
			return false;
	}
	
	function getManagersIdForDirector($dr_id) {
		$sql = "select m_id from manager where m_upline = $dr_id";
		$data = $this->fetchResult($sql, false);
		$m_ids = array();
		if (count($data) > 0) {
			foreach ($data as $mids) {
				$m_ids[] = $mids->{'m_id'};
			}
		}
		
		return count($m_ids) > 0 ? join(',',$m_ids) : '';
	}
	
	function getAllAgent($limit = null, $offset = null, $search = null) {
		
		
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$where = '';
		if ($search != null) {
			$where = " and (agent.agent_name like '%$search%' or agent.agent_email like '%$search%' or agent.agent_code like '%$search%') ";
		}
		
		$where2 = '';
		//if this is asmdin, get all, else get agetn for the manager only
		if ($this->session->userdata('user_type') == 'manager') {
			$mid = $this->session->userdata('manager')->{'m_id'};
			$where2 = " and agent_upline = $mid";
		}
		else if ($this->session->userdata('user_type') == 'director') {
			$dr_id = $this->session->userdata('director')->{'dr_id'};
			$managers = $this->getManagersIdForDirector($dr_id);
			
			$where2 = " and agent_upline in ($managers)";
		}
		
		$sql = "select agent.*, manager.m_name, manager.m_code from agent inner join manager on agent.agent_upline
			= manager.m_id where agent.active = 1 $where $where2 order by agent.agent_name asc ".$filter;
		$query = $this->db->query($sql);
		$m = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$m[] = $row;
			}
		}
		return $m;
	}
	
	function getAgentById($agent_id) {
		$sql = "select * from agent where agent_id = $agent_id and active = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function checkDuplicateEmail($email, $agent_id = null) {
		if ($agent_id != null) {
			$and = " and agent_id != $agent_id ";
		}
		else
			$and = '';
		$sql = "select * from agent where lower(agent_email) = lower('$email') $and and active = 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? true : false;
	
	}
	
	function updateAgent($agent_id, $data) {
		$this->db->where('agent_id', $agent_id);
		$this->db->update('agent', $data);
	}
	
	function addAgent($data) {
		$this->db->insert('agent', $data);
	}
	
	function deleteAgent($id) {
		$sql = "update agent set active = 0 where agent_id = $id";
		$this->db->query($sql);
	}	
	
	function getAgentCommAndPipeline($agent_id) {
		$sql = "select agent_comm, agent_pipeline from agent where agent_id = $agent_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
}
									