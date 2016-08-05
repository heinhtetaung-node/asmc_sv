<?php

if ($this->session->userdata('user_type') == 'admin') {
	$this->load->view('sidebar_admin');
}
else if ($this->session->userdata('user_type') == 'manager') {
	$this->load->view('sidebar_manager');
}
else if ($this->session->userdata('user_type') == 'director') {
	$this->load->view('sidebar_director');
}
else if ($this->session->userdata('user_type') == 'agent') {
	$this->load->view('sidebar_agent');
}
else if ($this->session->userdata('user_type') == 'customer') {
	$this->load->view('sidebar_customer');
}
