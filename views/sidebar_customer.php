
<div class="page-container">
<div class="nav-collapse top-margin fixed box-shadow2 hidden-xs" id="sidebar">
  <div class="leftside-navigation">
   <!-- 
 <div class="sidebar-section sidebar-user clearfix">
      <div class="sidebar-user-avatar"> <a href="#"> <img alt="avatar" src="images/avatar1.jpg"> </div>
      <div class="sidebar-user-name">John Doe</div>
      <div class="sidebar-user-links"> <a title="" data-placement="bottom" data-toggle="" href="profile.html" data-original-title="User"><i class="fa fa-user"></i></a> <a title="" data-placement="bottom" data-toggle="" href="inbox.html" data-original-title="Messages"><i class="fa fa-envelope-o"></i></a> <a title="" data-placement="bottom" data-toggle="" href="lockscreen.html" data-original-title="Logout"><i class="fa fa-sign-out"></i></a> </div>
    </div>
 -->
    <ul id="nav-accordion" class="sidebar-menu">
     
      <li>
        <h3>Profile</h3>
      </li>
     
      <li class="<?php if ($active =='profile') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>profile/?pid=<?php echo $this->session->userdata('customer')->{'customer_id'};?>" class="<?php if ($active =='profile') echo 'active';?> dcjq-parent">My Profile</a>
       
      </li>
     <li>
        <h3>Messages</h3>
      </li>
      <?php
      $this->load->model('Message_model');
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
      <li class="<?php if ($active =='invoice') echo 'active';?> sub-menu dcjq-parent-li"> <a href="<?php echo base_url();?>customerinv" class="<?php if ($active =='invoice') echo 'active';?> dcjq-parent">Agreement List</a>
       
      </li>
    </ul><!--/nav-accordion sidebar-menu--> 
  </div><!--/leftside-navigation--> 
</div><!--/sidebar--> 