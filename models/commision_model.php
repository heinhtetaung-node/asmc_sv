<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commision_model extends CI_Model {
	
	function getAllInvoice($group, $id, $limit = null, $offset = null, $search = null) {
	
		if ($group == 'manager') {
			$where2 = ' and manager.m_id = '.$id;
		}
		else if ($group == 'customer') {
			$where2 = ' and invoice.customer_id = '.$id;
		}
		else if ($group == 'agent') {
			$where2 = ' and agent.agent_id = '.$id;
		}
		else
			$where2 = '';
			
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		$where = '';
		if ($search != null) {
			$where = " and (invoice.inv_no like '%$search%' or manager.m_name like '%$search%' or customer.customer_name like '%$search%' or agent.agent_name like '%$search%') ";
		}
		
		$sql = "select invoice.*, manager.m_name, agent.agent_name, customer.customer_name from invoice 
			inner join manager on invoice.m_id = manager.m_id join
			agent on agent.agent_id = invoice.agent_id join
			customer on customer.customer_id = invoice.customer_id where invoice.active = 1 $where $where2
			order by invoice.inv_no asc ".$filter;
		$query = $this->db->query($sql);
		$inv = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$inv_id = $row->{'inv_id'};
				if ($group == 'manager') {
					//chekc if this invoice is transerred, if yes, no commision
					if ($this->checkIsInvoiceTransferred($inv_id, $row->{'m_id'}, 1))
						$row->{'m_payouts'} = array();
					else
						$row->{'m_payouts'} = $this->getManagerPayoutReformat($inv_id);
				}
				else if ($group == 'agent') {
					if ($this->checkIsInvoiceTransferred($inv_id, $row->{'agent_id'}, 2))
						$row->{'s_payouts'} = array();
					else
						$row->{'s_payouts'} = $this->getSalesPayoutReformat($inv_id);
				}
				$inv[] = $row;
			}
		}	
		if ($group == 'agent') {
			$additional_agent_inv = $this->getAdditionalAgentInvoice($this->session->userdata('agent')->{'agent_id'});
			if (count($additional_agent_inv) > 0) {
				$inv= array_merge($inv, $additional_agent_inv);
			}
		}
		return $inv;
	}
	
	function getAdditionalAgentInvoice($agent_id) {
		$sql = "select invoice.*, manager.m_name, agent.agent_name, customer.customer_name from invoice 
			inner join manager on invoice.m_id = manager.m_id join
			
			customer on customer.customer_id = invoice.customer_id 
			join additional_agent on additional_agent.inv_id = invoice.inv_id join
			agent on agent.agent_id = additional_agent.agent_id 
			where invoice.active = 1 
			and additional_agent.agent_id = $agent_id
			order by invoice.inv_no asc";
		$query = $this->db->query($sql);
		$inv = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if ($this->checkIsInvoiceTransferred($row->{'inv_id'}, $row->{'agent_id'}, 1))
						$row->{'s_payouts'} = array();
					else
						$row->{'s_payouts'} = $this->getSalesPayoutReformat($row->{'inv_id'});
				$inv[] = $row;
			}
		}
		return $inv;	
	}
	
	function checkIsInvoiceTransferred($inv_id, $user_id, $user_type) {
		$sql = "select * from invoice_transfer where to_user = $user_id and inv_id = $inv_id and user_type= $user_type";
		$query = $this->db->query($sql);
// 		log_message('error', $sql);
		return $query->num_rows() > 0 ? true : false;
	}
	function getManagerPayoutReformat($inv_id) {
		$sql = "select date,amt from manager_payout where inv_id =$inv_id order by number asc";
		$query = $this->db->query($sql);
		$p = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$p[$row->{'date'}] = $row->{'amt'};
			}
		}
		return $p;
	}
	
	function getSalesPayoutReformat($inv_id) {
		$sql = "select date,amt from sales_payout where inv_id =$inv_id order by number asc";
		$query = $this->db->query($sql);
		$p = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$p[$row->{'date'}] = $row->{'amt'};
			}
		}
		return $p;
	}
}
									