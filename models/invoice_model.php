<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model {
	
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
	
	function getStartEndPayout($inv_id) {
		$sql = "select min(date) as min, max(date) as max from client_payout where inv_id = $inv_id and amt != 0";
		$query  = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	
	function addEmail($data) {
		$this->db->insert('emails', $data);
	}
	
	function getUnsentEmail($limit) {
		$sql = "select * from emails where sent_date is null and sent_status is null order by e_id asc limit $limit";
		$query = $this->db->query($sql);
		$emails = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$emails[] = $row;
			}
		}
		return $emails;
	}
	
	function updateEmail($e_id, $data) {
		$this->db->where('e_id', $e_id);
		$this->db->update('emails', $data);
	}
	
	function getClientPayoutById($payout_id) {
		$sql = "select * from client_payout where id= $payout_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function getClientPayoutReceipt($inv_id, $payout_id, $payout_date) {
		$sql = "select receipts.* from client_payout inner join receipts on receipts.r_id = client_payout.r_id where client_payout.id=$payout_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)
				return $row;
		}	
		else {
			//if not create new
			$r_id = $this->addNewReceipt($inv_id, 3, $payout_date, $this->getNewReceiptNumber());
			$this->db->query("update client_payout set r_id = $r_id where id = $payout_id");
			return $this->getReceiptById($r_id);
		}
		return array();
	}
	
	function getFundingReceipt($inv_id, $inv_date) {
		//check if receipt exist,
		$sql = "select * from receipts where inv_id = $inv_id and r_type = 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)
				return $row;
		}	
		else {
			//if not create new
			$r_id = $this->addNewReceipt($inv_id, 1, $inv_date, $this->getNewReceiptNumber());
			return $this->getReceiptById($r_id);
		}
		return array();
	}
	
	function getAdminReceipt($inv_id, $inv_date) {
		//check if receipt exist,
		$sql = "select * from receipts where inv_id = $inv_id and r_type = 2";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row)
				return $row;
		}	
		else {
			//if not create new
			$r_id = $this->addNewReceipt($inv_id, 2, $inv_date, $this->getNewReceiptNumber());
			return $this->getReceiptById($r_id);
		}
		return array();
	}
	
	function addNewReceipt($inv_id, $type, $date, $number) {
		$data['r_number'] = $number;
		$data['r_no'] = RECEIPT_PREFIX.str_pad($number, 4, '0', STR_PAD_LEFT);
		$data['inv_id'] = $inv_id;
		$data['r_type'] = $type;
		$data['r_created_date'] = $date;
		
		$this->db->insert('receipts', $data);
		return $this->db->insert_id();
	}
	
	function getReceiptById($r_id) {
		$sql = "select * from receipts where r_id = $r_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row;
			}
		}
		return array();
	}
	
	function getNewReceiptNumber() {
		$sql = "select r_number from receipts order by r_number desc limit 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				return $row->{'r_number'} + 1;
			}
		}
		else
			return 1;
	}
	
	function addInvoice($data) {
		$this->db->insert('invoice', $data);
		return $this->db->insert_id();
	}
	
	function updateInvoice($inv_id, $data) {
		$this->db->where('inv_id', $inv_id);
		$this->db->update('invoice', $data);
	}
	
	function getDirectorName($dr_id) {
		$sql = "select dr_name from director where dr_id = $dr_id";
		$data = $this->fetchResult($sql, true);
		if (count($data) > 0) {
			return $data->{'dr_name'};
		}
		else
			return '';
	}
	
	function getInvoiceById($inv_id) {
		$sql = "select invoice.*, manager.m_name, agent.agent_name, customer.* from invoice 
			inner join manager on invoice.m_id = manager.m_id join
			agent on agent.agent_id = invoice.agent_id join
			customer on customer.customer_id = invoice.customer_id where invoice.inv_id =$inv_id";
		$query = $this->db->query($sql);
		$inv = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if ($row->{'dr_id'} != '') {
					$row->{'dr_name'} = $this->getDirectorName($row->{'dr_id'});
				}
				
				//get addtional agent
				$aagent = $this->getAdditionalAgent($row->{'inv_id'});
				if (count($aagent) > 0)
				$row->{'aagent'} = $aagent;
				$row->{'expired_date'} = $this->getExpiredDate($row->{'inv_id'});
				$inv = $row;
				
			}
		}	
		return $inv;
	}
	
	function getExpiredDate($inv_id) {
		$sql = "select date from client_payout where inv_id = $inv_id order by date desc limit 1";
		$data = $this->fetchResult($sql, true);
		if (count($data) > 0) {
			return $data->{'date'};
		}
	}
	
	function getAllInvoice($limit = null, $offset = null, $search = null) {
	
		if ($this->session->userdata('user_type') == 'customer') {
			$where2 = ' and invoice.customer_id = '.$this->session->userdata('customer')->{'customer_id'};
		}
		else if ($this->session->userdata('user_type') == 'manager') {
			$where2 = ' and invoice.m_id = '.$this->session->userdata('manager')->{'m_id'};
		}
		else if ($this->session->userdata('user_type') == 'agent') {
			$where2 = ' and invoice.agent_id = '.$this->session->userdata('agent')->{'agent_id'};
		}
		else if ($this->session->userdata('user_type') == 'director') {
			$where2 = ' and invoice.dr_id = '.$this->session->userdata('director')->{'dr_id'};
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
			order by invoice.inv_id desc ".$filter;
		$query = $this->db->query($sql);
		$inv = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$row->{'payout'} = $this->getStartEndPayout($row->{'inv_id'});
				
				
				$inv[] = $row;
			}
		}	
		
		if ($this->session->userdata('user_type') == 'agent') {
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
				$row->{'payout'} = $this->getStartEndPayout($row->{'inv_id'});
				$inv[] = $row;
			}
		}
		return $inv;	
	}
	
	function deleteInvoice($id) {
		$sql = "update invoice set active = 0 where inv_id = $id";
		$this->db->query($sql);
	}
	
	function addClientPayout($agreement_type, $is_starter_pack, $inv_id, $period, $current_date, $amt, $existing_data = null) {
		//start from next month
		
		//check if the date fall before or after 15th, if after 15th, the payout musst be statgin the month after next
		
		if (date('d', strtotime($current_date)) > 15) {
			$start_month = date('m', strtotime($current_date)) + 1;
			$start_year = date('Y', strtotime($current_date));
			
			if ($start_month > 12) {
				$start_month = 1;
				$start_year += 1;
			}
		}
		else {
		$start_month = date('m', strtotime($current_date));
		$start_year = date('Y', strtotime($current_date));
		
		}
		$payout = array();
		for ($i = 1; $i <= $period; $i++) {
			
			$date = $start_year.'-'.str_pad($start_month,2,'0', STR_PAD_LEFT).'-01';
		
			if ($start_month == 12) {
				$start_month = 1;
				$start_year++;
			}
			else
				$start_month++;
				
			$last_day = date('t', strtotime("+1 month", strtotime($date)));
			
			$pdate = date("Y-m-".str_pad($last_day, 2, '0', STR_PAD_LEFT), strtotime("+1 month", strtotime($date)));
			
			//starter pack/progressive payment starrt form next month
			if ($is_starter_pack || $agreement_type == 2) {
				//1%
				$amount = $amt * 0.01;
			}
			//normal, payment start rfom forth motnh
			else {
				//3%
				//first 3 months is $0
				if ($i <= 3)
					$amount = 0;
				else
					$amount = $amt * 0.03;	
			}
			
			$p = array('inv_id'=>$inv_id, 'number' => $i, 'date'=>$pdate, 'amt'=>$amount, 'pay_date' => null);
			
			//if thre'es exsitgn data, put back the data
			if ($existing_data != null && isset($existing_data[$pdate])) {
				$p['pay_date'] = date('Y-m-d H:i:s', strtotime($existing_data[$pdate]));
// 					print_r($existing_data[$pdate]);print_r($p);exit;
			}
				
		    $payout[] = $p;
		}
		if (count($payout) > 0) {
			$this->db->insert_batch('client_payout', $payout);
		}
	// 	echo '<pre>';
// 		print_r($payout);
		
	}
	
	function adjustClientPayoutPeriod($agreement_type,$is_starter_pack, $inv_id, $period, $current_date, $amt) {
		//get existing data if there's already payout
		$sql = "select * from client_payout where inv_id = $inv_id and pay_date is not null";
		$query = $this->db->query($sql);
		$existing = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$existing[$row->{'date'}] = $row->{'pay_date'};
			}
		}
		
		//wipe out and recreate
		$sql ="delete from client_payout where inv_id = $inv_id";
		$this->db->query($sql);
		
		 $this->addClientPayout($agreement_type,$is_starter_pack, $inv_id, $period, $current_date, $amt, $existing);
		//do not use exisgin data, delete all as the amt might changed
// 		$this->addClientPayout($inv_id, $period, $current_date, $amt, null);
	}
	
	
	
	function getClientPayout($inv_id) {
		$sql = "select * from client_payout where inv_id =$inv_id order by number asc";
		$query = $this->db->query($sql);
		$p = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$p[] = $row;
			}
		}
		return $p;
	}
	
	
	
	function markClientPaid($id) {
		$date = date('Y-m-d H:i:s');
		
		$sql = "update client_payout set pay_date ='$date' where id=$id";
		$this->db->query($sql); 
	}	
	
	function markClientUnpaid($id) {
	
		$sql = "update client_payout set pay_date =null where id=$id";
		$this->db->query($sql); 
	}	
	
	function addSalesPayout($agreement_type, $is_starter_pack, $inv_id, $agent_id, $period, $current_date, $amt, $funding_amt, $existing_data = null) {
		//start from next month
		
		if (date('d', strtotime($current_date)) > 15) {
			$start_month = date('m', strtotime($current_date)) + 1;
			$start_year = date('Y', strtotime($current_date));
			
			if ($start_month > 12) {
				$start_month = 1;
				$start_year += 1;
			}
		}
		else {
		$start_month = date('m', strtotime($current_date));
		$start_year = date('Y', strtotime($current_date));
		
		}
		$payout = array();
		for ($i = 1; $i <= $period; $i++) {
			
			$date = $start_year.'-'.str_pad($start_month,2,'0', STR_PAD_LEFT).'-01';
		
			if ($start_month == 12) {
				$start_month = 1;
				$start_year++;
			}
			else
				$start_month++;
			
// 		$start_month = date('m', strtotime($current_date));
// 		$start_year = date('Y', strtotime($current_date));
// 		
// 		//pay out start frm fourth month
// 		if ($start_month > 9)
// 			$start_year += 1;
// 			
// 		$start_month += 3;
// 		if ($start_month > 12) 
// 			$start_month =  $start_month - 12;
// 		
// 		$payout = array();
// 		
// 		//capped at 33 months
// // 		if ($period > 33)
// 			$period = 33;
// 			
// 		for ($i = 1; $i <= $period; $i++) {
// 			
// 			$date = $start_year.'-'.str_pad($start_month,2,'0', STR_PAD_LEFT).'-01';
// 		
// 			if ($start_month == 12) {
// 				$start_month = 1;
// 				$start_year++;
// 			}
// 			else
// 				$start_month++;
				
			$last_day = date('t', strtotime("+1 month", strtotime($date)));
			
			$pdate = date("Y-m-".str_pad($last_day, 2, '0', STR_PAD_LEFT), strtotime("+1 month", strtotime($date)));
			
			//this 4 month amount $0
		// 	if ($i == 1 && $i == 2 && $i == 4 && $i == 4)
// 				$amount = 0;
// 			//comm
// 			else {
// 			else if ($i == 3) {
				// $agent_comm_pipeline = $this->Agent_model->getAgentCommAndPipeline($agent_id);
// 				$amount = $agent_comm_pipeline->{'agent_comm'}/100 * $funding_amt;
// 				
// 				print_r($agent_comm_pipeline->{'agent_comm'}.' '.$funding_amt);exit;
// 			}
// 			else
				$amount = $amt;	
				
			$p = array('inv_id'=>$inv_id, 'agent_id' => $agent_id, 'number' => $i, 'date'=>$pdate, 'amt'=>$amount, 'pay_date' => null);
// 			echo '<pre>';
			
// 			print_r($p);exit;
			
			
			//if thre'es exsitgn data, put back the data
			if ($existing_data != null && isset($existing_data[$pdate])) {
				$p['pay_date'] = date('Y-m-d H:i:s', strtotime($existing_data[$pdate]));
			}
		    $payout[] = $p;
		}
		if (count($payout) > 0) {
			$this->db->insert_batch('sales_payout', $payout);
		}
	}
	
	function adjustSalesPayoutPeriod($agreement_type,$is_starter_pack,$inv_id, $agent_id, $period, $current_date, $amt, $funding_amt) {
		//get existing data if there's already payout
		$sql = "select * from sales_payout where inv_id = $inv_id and pay_date is not null";
		$query = $this->db->query($sql);
		$existing = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$existing[$row->{'date'}] = $row->{'pay_date'};
			}
		}
		
		//wipe out and recreate
		$sql ="delete from sales_payout where inv_id = $inv_id and agent_id = $agent_id";
		$this->db->query($sql);
		
		//do not use exisin
		$existing = null;
		$this->addSalesPayout($agreement_type,$is_starter_pack,$inv_id, $agent_id, $period, $current_date, $amt, $funding_amt, $existing);
	}
	
	function getSalesPayout($inv_id) {
		//aget default agent
		
		$sql ="select agent_id from invoice where inv_id =$inv_id";
		$data = $this->fetchResult($sql, true);
		$agent_id = $data->{'agent_id'};
		
		$sql = "select * from sales_payout where inv_id =$inv_id and agent_id = $agent_id order by number asc";
		$query = $this->db->query($sql);
		$p = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$p[] = $row;
			}
		}
		return $p;
	}
	
	function getAdditionalSalesPayout($inv_id) {
	
		$sql = "select * from additional_agent where inv_id = $inv_id";
		$data = $this->fetchResult($sql, false);
		
		$p = array();
		if (count($data) > 0) {
			foreach($data as $d) {
				$agent_id = $d->{'agent_id'};
				$sql = "select * from sales_payout where inv_id =$inv_id and agent_id = $agent_id order by number asc";
				$query = $this->db->query($sql);
				
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$p[] = $row;
					}
				}
			}
		}
		return $p;
	}
	
	function markSalesPaid($id) {
		$date = date('Y-m-d H:i:s');
		
		$sql = "update sales_payout set pay_date ='$date' where id=$id";
		$this->db->query($sql); 
	}	
	
	function markSalesUnpaid($id) {
	
		$sql = "update sales_payout set pay_date =null where id=$id";
		$this->db->query($sql); 
	}	
	
	function addManagerPayout($agreement_type,$is_starter_pack,$inv_id, $m_id, $period, $current_date, $amt, $funding_amt, $existing_data = null) {
		//start from next month
		// $start_month = date('m', strtotime($current_date));
// 		$start_year = date('Y', strtotime($current_date));
// 		
// 		//pay out start frm fourth month
// 		if ($start_month > 9)
// 			$start_year += 1;
// 			
// 		$start_month += 3;
// 		if ($start_month > 12) 
// 			$start_month = $start_month - 12;
// 		
// // 		log_message('error', 'Y'.$start_year.' M'.$start_month.' inv-'.$inv_id);
// 		$payout = array();
// // 		if ($period > 33)
// 			$period = 33;
// 		for ($i = 1; $i <= $period; $i++) {
// 			
// 			$date = $start_year.'-'.str_pad($start_month,2,'0', STR_PAD_LEFT).'-01';
// 		
// 				
// 			if ($start_month == 12) {
// 				$start_month = 1;
// 				$start_year++;
// 			}
// 			else
// 				$start_month++;
// 				
// 			$last_day = date('t', strtotime("+1 month", strtotime($date)));
// 			
			if (date('d', strtotime($current_date)) > 15) {
			$start_month = date('m', strtotime($current_date)) + 1;
			$start_year = date('Y', strtotime($current_date));
			
			if ($start_month > 12) {
				$start_month = 1;
				$start_year += 1;
			}
		}
		else {
		$start_month = date('m', strtotime($current_date));
		$start_year = date('Y', strtotime($current_date));
		
		}
		$payout = array();
		for ($i = 1; $i <= $period; $i++) {
			
			$date = $start_year.'-'.str_pad($start_month,2,'0', STR_PAD_LEFT).'-01';
		
			if ($start_month == 12) {
				$start_month = 1;
				$start_year++;
			}
			else
				$start_month++;
			$last_day = date('t', strtotime("+1 month", strtotime($date)));
			$pdate = date("Y-m-".str_pad($last_day, 2, '0', STR_PAD_LEFT), strtotime("+1 month", strtotime($date)));
		
			$amount = $amt;	
				
			$p = array('inv_id'=>$inv_id, 'm_id' => $m_id, 'number' => $i, 'date'=>$pdate, 'amt'=>$amount, 'pay_date' => null);
			
			//if thre'es exsitgn data, put back the data
			if ($existing_data != null && isset($existing_data[$pdate])) {
				$p['pay_date'] = date('Y-m-d H:i:s', strtotime($existing_data[$pdate]));
			}
		    $payout[] = $p;
		}
		
		if (count($payout) > 0) {
			$this->db->insert_batch('manager_payout', $payout);
		}
	}
	
	function adjustManagerPayoutPeriod($agreement_type,$is_starter_pack,$inv_id, $m_id, $period, $current_date, $amt, $funding_amt) {
		//get existing data if there's already payout
		$sql = "select * from manager_payout where inv_id = $inv_id and pay_date is not null";
		$query = $this->db->query($sql);
		$existing = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$existing[$row->{'date'}] = $row->{'pay_date'};
			}
		}
		
		//wipe out and recreate
		$sql ="delete from manager_payout where inv_id = $inv_id";
		$this->db->query($sql);
		
		//do no use existing 
		$existing = null;
		$this->addManagerPayout($agreement_type,$is_starter_pack,$inv_id, $m_id, $period, $current_date, $amt, $funding_amt, $existing);
	}
	
	function getStartEndPayoutDate($group,$id) {
		if ($group == 'manager') {
			$db = 'manager_payout';
			$id_field = 'm_id';
		}
		else if ($group == 'agent') {
			$db = 'sales_payout';
			$id_field = 'agent_id';
			}
		$sql = "select min(date) as mins, max(date) as maxs from ".$db." where ".$id_field." =$id";
	
		return $this->fetchResult($sql, true);
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
	
	function getManagerPayout($inv_id) {
		$sql = "select * from manager_payout where inv_id =$inv_id order by number asc";
		$query = $this->db->query($sql);
		$p = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$p[] = $row;
			}
		}
		return $p;
	}
	
	function markManagerPaid($id) {
		$date = date('Y-m-d H:i:s');
		
		$sql = "update manager_payout set pay_date ='$date' where id=$id";
		$this->db->query($sql); 
	}	
	
	function markManagerUnpaid($id) {
	
		$sql = "update manager_payout set pay_date =null where id=$id";
		$this->db->query($sql); 
	}	
	
	function addInvoiceTransfer($t) {
	
		//check invoice transfer before, if yes, update,else add
		$trans = $this->getInvoiceTransfer($t);
		if (count($trans) == 0)
			$this->db->insert('invoice_transfer', $t);
		else {
			$t['date'] = date('Y-m-d H:i:s');
			$this->db->where('inv_id', $t['inv_id']);
			$this->db->where('user_type', $t['user_type']);
			$this->db->update('invoice_transfer', $t);
		}
	}
	
	function getInvoiceTransfer($t) {
		$inv_id = $t['inv_id'];
		$user_type = $t['user_type'];
		
		$sql ="select * from invoice_transfer where inv_id = $inv_id and user_type = $user_type";
		return $this->fetchResult($sql, true);
	}
	
	function addSecondAgent($agent) {
		if (!$this->checkSecondAgentExist($agent['agent_id'], $agent['inv_id']))
		
		$this->db->insert('additional_agent', $agent);
	}
	
	function checkSecondAgentExist($agent_id, $inv_id) {
		$sql = "select * from additional_agent where agent_id = $agent_id and inv_id = $inv_id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? true : false;
	}
	
	function getAdditionalAgent($inv_id) {
		$sql = "select agent.* from additional_agent inner join agent on agent.agent_id = additional_agent.agent_id where additional_agent.inv_id = $inv_id";
		return $this->fetchResult($sql, true);
	}
	
	function removeAdditionalAgent($inv_id, $agent_id) {
		$sql = "delete from additional_agent where inv_id = $inv_id";
		$this->db->query($sql);
		
		$sql = "delete from sales_payout where inv_id = $inv_id and agent_id != $agent_id";
		$this->db->query($sql);
	}

	function getInvoiceForForm($formid) {
		$sql = "select * from invoice where formid=$formid";
		return $this->fetchResult($sql, true);
	}	
	
}
									