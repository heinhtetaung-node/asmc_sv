
<div class="page-container">
<div class="nav-collapse top-margin fixed box-shadow2 hidden-xs" id="sidebar">
  <div class="leftside-navigation" style="overflow:scroll">
   <!-- 
 <div class="sidebar-section sidebar-user clearfix">
      <div class="sidebar-user-avatar"> <a href="#"> <img alt="avatar" src="images/avatar1.jpg"> </div>
      <div class="sidebar-user-name">John Doe</div>
      <div class="sidebar-user-links"> <a title="" data-placement="bottom" data-toggle="" href="profile.html" data-original-title="User"><i class="fa fa-user"></i></a> <a title="" data-placement="bottom" data-toggle="" href="inbox.html" data-original-title="Messages"><i class="fa fa-envelope-o"></i></a> <a title="" data-placement="bottom" data-toggle="" href="lockscreen.html" data-original-title="Logout"><i class="fa fa-sign-out"></i></a> </div>
    </div>
 -->
    <ul id="nav-accordion" class="sidebar-menu" style="overflow:scroll">
     
    
      <li>
        <h3>Users Account</h3>
      </li>
     <?php
      if ($this->session->userdata('user_type') == 'admin') {?>
      <li class="<?php if ($active =='admin') echo 'active';?> sub-menu dcjq-parent-li"> <a href="javascript:;" class="<?php if ($active =='admin') echo 'active';?> dcjq-parent">Administrator</a>
        <ul class="sub">
          <li><a href="<?php echo base_url();?>admin"><i class="fa fa-angle-right"></i>Admin Lists</a></li>
          <li><a href="<?php echo base_url();?>admin/addAdmin"><i class="fa fa-angle-right"></i>Add Admin</a></li>
          
        </ul>
      </li>
      <?php }?>
      <?php
      if ($this->session->userdata('user_type') == 'admin') {?>
      <li class="<?php if ($active =='director') echo 'active';?> sub-menu dcjq-parent-li"> <a href="javascript:;" class="<?php if ($active =='director') echo 'active';?> dcjq-parent">Director</a>
        <ul class="sub">
          <li><a href="<?php echo base_url();?>director"><i class="fa fa-angle-right"></i>Director Lists</a></li>
          <li><a href="<?php echo base_url();?>director/addDirector"><i class="fa fa-angle-right"></i>Add Director</a></li>
          
        </ul>
      </li>
      <li class="<?php if ($active =='manager') echo 'active';?> sub-menu dcjq-parent-li"> <a href="javascript:;" class="<?php if ($active =='manager') echo 'active';?> dcjq-parent">Manager</a>
        <ul class="sub">
          <li><a href="<?php echo base_url();?>manager"><i class="fa fa-angle-right"></i>Manager Lists</a></li>
          <li><a href="<?php echo base_url();?>manager/addManager"><i class="fa fa-angle-right"></i>Add Manager</a></li>
          
        </ul>
      </li>
      <?php } ?>
      <li class="<?php if ($active =='agent') echo 'active';?> sub-menu dcjq-parent-li"> <a href="javascript:;" class="<?php if ($active =='agent') echo 'active';?> dcjq-parent">Agent</a>
        <ul class="sub">
          <li><a href="<?php echo base_url();?>agent"><i class="fa fa-angle-right"></i>Agent Lists</a></li>
          <li><a href="<?php echo base_url();?>agent/addAgent"><i class="fa fa-angle-right"></i>Add Agent</a></li>
          
        </ul>
      </li>
      <?php
      if ($this->session->userdata('user_type') == 'admin') {?>
      <li class="<?php if ($active =='customer') echo 'active';?> sub-menu dcjq-parent-li"> <a href="javascript:;" class="<?php if ($active =='customer') echo 'active';?> dcjq-parent">Customer</a>
        <ul class="sub">
          <li><a href="<?php echo base_url();?>customer"><i class="fa fa-angle-right"></i>Customer Lists</a></li>
          <li><a href="<?php echo base_url();?>customer/addCustomer"><i class="fa fa-angle-right"></i>Add Customer</a></li>
          
        </ul>
      </li>
      <?php }?>
   
      <li>
        <h3>Messages</h3>
      </li>
      <?php
    
      if ($this->session->userdata('user_type') == 'admin')
			$id = $this->session->userdata('admin')->{'admin_id'};
		else if ($this->session->userdata('user_type') == 'manager')
			$id = $this->session->userdata('manager')->{'m_id'};
		else if ($this->session->userdata('user_type') == 'agent')
			$id = $this->session->userdata('agent')->{'agent_id'};
		else if ($this->session->userdata('user_type') == 'customer')
			$id = $this->session->userdata('customer')->{'customer_id'};
      	$unread = $this->Message_model->getUnreadMsg($this->session->userdata('user_type'), $id);
      ?>
       <li class="<?php if ($active =='inbox') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>message" class="<?php if ($active =='inbox') echo 'active';?> dcjq-parent">Inbox <?php if ($unread > 0) { ?><b class="badge bg-success pull-right"><?php echo $unread;?></b><?php } ?></a>
       
      </li>
      <?php
      if ($this->session->userdata('user_type') == 'admin') {?>
     	 <li class="<?php if ($active =='compose') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>message/compose" class="<?php if ($active =='compose') echo 'active';?> dcjq-parent">Compose</a> </li>
  	  <?php }else {?>
  	   <li class="<?php if ($active =='compose') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>message/composing" class="<?php if ($active =='compose') echo 'active';?> dcjq-parent">Compose</a> </li>
  	   <?php } ?>
     
      <li class="<?php if ($active =='sent') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>message/sent" class="<?php if ($active =='sent') echo 'active';?> dcjq-parent">Sent Items</a>
       
      </li>
      
      <li>
        <h3>Funding Record</h3>
      </li>
      <li class="<?php if ($active =='invoice') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>invoice" class="<?php if ($active =='invoice') echo 'active';?> dcjq-parent">Agreement List</a>
       
      </li>
      <?php
      if ($this->session->userdata('user_type') == 'admin') {?>
      <li class="<?php if ($active =='addinvoice') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>invoice/addInvoice" class="<?php if ($active =='addinvoice') echo 'active';?> dcjq-parent">Add Contracts</a>
       
      </li>
      <?php } ?>
      <?php
      if ($this->session->userdata('user_type') == 'manager') {?>
      <li>
        <h3>Commissions</h3>
      </li>
       <li class="<?php if ($active =='commission') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>commission" class="<?php if ($active =='commission') echo 'active';?> dcjq-parent">Commissions</a>
       
      </li>
      <?php }?>
       <li>
        <h3>Online Form</h3>
      </li>
       <?php
      if ( $this->session->userdata('user_type') != 'funder' ) {?>
<!--       <li class="<?php if ($active =='form') echo 'active';?> sub-menu dcjq-parent-li"> <a href="javascript:;" class="<?php if ($active =='form') echo 'active';?> dcjq-parent">Online Forms</a> -->
<!--         <ul class="sub"> -->
          <li  class="<?php if ($active =='commission') echo 'active';?> sub-menu dcjq-parent-li"><a href="<?php echo base_url();?>form" class="<?php if ($active =='commission') echo 'active';?> dcjq-parent">Signup Form</a></li>
          <li  class="<?php if ($active =='commission') echo 'active';?> sub-menu dcjq-parent-li"><a href="<?php echo base_url();?>form/viewRecords" class="<?php if ($active =='commission') echo 'active';?> dcjq-parent">View Records</a></li>
           <li><a href="#"><br/><br/></a></li>
<!--         </ul> -->
<!--       </li> -->
      <?php }?>
      
    </ul><!--/nav-accordion sidebar-menu--> 
  </div><!--/leftside-navigation--> 
</div><!--/sidebar--> 