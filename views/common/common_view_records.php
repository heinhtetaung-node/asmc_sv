<?php
$id="";
if($this->session->userdata('user_type') == 'director'){
	$data=$this->session->userdata('director');
	$id=$data->dr_id;
}
if($this->session->userdata('user_type') == 'manager'){
	$data=$this->session->userdata('manager');
	$id=$data->m_id;
}
if($this->session->userdata('user_type') == 'agent'){
	$data=$this->session->userdata('agent');
	$id=$data->agent_id;
}
if($this->session->userdata('user_type') == 'customer'){
	$data=$this->session->userdata('customer');
	$id=$data->customer_id;
}
?>
<?php
if($id!=""){ ?>
	<li class="sub-menu dcjq-parent-li"><a href="<?php echo base_url();?>form/viewRecentSignup/<?php echo $id; ?>" class="dcjq-parent">View Records</a></li><?php
}	
?>
