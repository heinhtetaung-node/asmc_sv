<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model {
	
	function addMultipleMsg($data) {
		$this->db->insert_batch('message', $data);
	}
	
	function getUnreadMsg($to_group, $to_id) {
		if ($to_group == 'admin') {
			$sql = "select count(*) as total from message where msg_to_group = 'admin' and msg_read = 0 order by msg_sent_date desc ";
		}
		else {
			$sql = "select count(*) as total from message where msg_to_group = '$to_group' and msg_to = $to_id  and msg_read = 0  order by msg_sent_date desc ";
		}
		$total = 0;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$total = $row->{'total'};
			}
		}
		return $total;
	}
	
	function getInbox($to_group, $to_id, $limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		
		//if from_group = admin, not need check id, all admin can see the same thing
		if ($to_group == 'admin') {
			$sql = "select * from message where msg_to_group = 'admin' order by msg_sent_date desc ".$filter;
		}
		else {
			$sql = "select * from message where msg_to_group = '$to_group' and msg_to = $to_id order by msg_sent_date desc ".$filter;
		}
		$msg = array();
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				//get sender name
				$from = $row->{'msg_from'};
				if ($row->{'msg_from_group'} == 'admin') {
					$sql2 = "select admin_name from admin where admin_id = $from";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"sender"} = $row2->{'admin_name'};
						}
					}
					else
						$row->{'sender'} = '';
				}
				else if ($row->{'msg_from_group'} == 'manager') {
					$sql2 = "select m_name from manager where m_id = $from";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"sender"} = $row2->{'m_name'};
						}
					}
					else
						$row->{'sender'} = '';
				}
				else if ($row->{'msg_from_group'} == 'agent') {
					$sql2 = "select agent_name from agent where agent_id = $from";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"sender"} = $row2->{'agent_name'};
						}
					}
					else
						$row->{'sender'} = '';
				}
				else if ($row->{'msg_from_group'} == 'customer') {
					$sql2 = "select customer_name from customer where customer_id = $from";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"sender"} = $row2->{'customer_name'};
						}
					}
					else
						$row->{'sender'} = '';
				}
				else if ($row->{'msg_from_group'} == 'director') {
					$sql2 = "select dr_name from director where dr_id = $from";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"sender"} = $row2->{'dr_name'};
						}
					}
					else
						$row->{'sender'} = '';
				}
				
				$msg[] = $row;
				
			}
		}	
		return $msg;
	}
	
	function getMessageById($mid) {
		$sql = "select * from message where msg_id = $mid";
		$query = $this->db->query($sql);
		$msg = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$to = $row->{'msg_to'};
				if ($row->{'msg_to_group'} == 'admin') {
					$receiver = $this->Admin_model->getAdminById($to)->{'admin_name'};
				}
				else if ($row->{'msg_to_group'} == 'manager') {
					$receiver = $this->Manager_model->getManagerById($to)->{'m_name'};
				}
				else if ($row->{'msg_to_group'} == 'agent') {
					$receiver = $this->Agent_model->getAgentById($to)->{'agent_name'};
				}
				else if ($row->{'msg_to_group'} == 'customer') {
					$receiver = $this->Customer_model->getCustomerById($to)->{'customer_name'};
				}
				else if ($row->{'msg_to_group'} == 'director') {
					$receiver = $this->Director_model->getDirectorById($to)->{'dr_id'};
				}
				$from = $row->{'msg_from'};
				if ($row->{'msg_from_group'} == 'admin') {
					$sender = $this->Admin_model->getAdminById($from)->{'admin_name'};
				}
				else if ($row->{'msg_from_group'} == 'manager') {
					$sender = $this->Manager_model->getManagerById($from)->{'m_name'};
				}
				else if ($row->{'msg_from_group'} == 'agent') {
					$sender = $this->Agent_model->getAgentById($from)->{'agent_name'};
				}
				else if ($row->{'msg_from_group'} == 'customer') {
					$sender = $this->Customer_model->getCustomerById($from)->{'customer_name'};
				}
				else if ($row->{'msg_from_group'} == 'director') {
					$sender = $this->Director_model->getDirectorById($from)->{'dr_id'};
				}
				$row->{'sender'} = $sender;
				$row->{'receiver'} = $receiver;
				$msg = $row;
			}
		}
		return $msg;
	}
	
	function markMsgRead($mid) {
		$sql = "update message set msg_read  = 1 where msg_id = $mid";
		$this->db->query($sql);
	}
	
	//dont implement search fucntion first
	function getSentMessage($from_group, $from_id, $limit = null, $offset = null, $search = null) {
		$filter = '';
		
		if ($limit != null ) {
			$filter = ' limit '.$limit.' offset '.$offset.' ';
		}
		
		//if from_group = admin, not need check id, all admin can see the same thing
		if ($from_group == 'admin') {
			$sql = "select * from message where msg_from_group = 'admin' order by msg_sent_date desc ".$filter;
		}
		else {
			$sql = "select * from message where msg_from_group = '$from_group' and msg_from = $from_id order by msg_sent_date desc ".$filter;
		}
		$msg = array();
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				//get receiver name
				$to = $row->{'msg_to'};
				if ($row->{'msg_to_group'} == 'admin') {
					$sql2 = "select admin_name from admin where admin_id = $to";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"receiver"} = $row2->{'admin_name'};
						}
					}
					else
						$row->{'receiver'} = '';
				}
				else if ($row->{'msg_to_group'} == 'manager') {
					$sql2 = "select m_name from manager where m_id = $to";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"receiver"} = $row2->{'m_name'};
						}
					}
					else
						$row->{'receiver'} = '';
				}
				else if ($row->{'msg_to_group'} == 'agent') {
					$sql2 = "select agent_name from agent where agent_id = $to";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"receiver"} = $row2->{'agent_name'};
						}
					}
					else
						$row->{'receiver'} = '';
				}
				else if ($row->{'msg_to_group'} == 'customer') {
					$sql2 = "select customer_name from customer where customer_id = $to";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"receiver"} = $row2->{'customer_name'};
						}
					}
					else
						$row->{'receiver'} = '';
				}
				
				else if ($row->{'msg_to_group'} == 'director') {
					$sql2 = "select dr_name from director where dr_id = $to";
					$query2 = $this->db->query($sql2);
					if ($query2->num_rows() > 0) {
						foreach ($query2->result() as $row2) {
							$row->{"receiver"} = $row2->{'dr_name'};
						}
					}
					else
						$row->{'receiver'} = '';
				}
				
				$msg[] = $row;
				
			}
		}	
		return $msg;
	}
}
									