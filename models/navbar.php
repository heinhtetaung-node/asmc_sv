<div class="header navbar navbar-inverse box-shadow navbar-fixed-top">
  <div class="navbar-inner">
    <div class="header-seperation">
      <ul class="nav navbar-nav">
        <li class="sidebar-toggle-box"> <a href="#"><i class="fa fa-bars"></i></a> </li>
        <li> <a href="<?php echo base_url();?>"><strong><?php echo WEB_TITLE;?></strong></a> </li>
         <li><a href="#"> Welcome, 
         	<?php 
         		if ($this->session->userdata('user_type') == 'admin')
         			echo $this->session->userdata('admin')->{'admin_name'};
         		else if ($this->session->userdata('user_type') == 'manager')
         			echo $this->session->userdata('manager')->{'m_name'};
         		else if ($this->session->userdata('user_type') == 'agent')
         			echo $this->session->userdata('agent')->{'agent_name'};
         		else if ($this->session->userdata('user_type') == 'customer')
         			echo $this->session->userdata('customer')->{'customer_name'};
         	?>
         	</a></li>
        <li class="hidden-xs">
          <div class="hov">
      
          <!-- 
  <div class="btn-group">
             <a data-toggle="dropdown" href="" class="con"><span class="fa fa-envelope"></span><span class="label label-success">7</span></a>
             
            </div>
 -->

          </div>
        </li>
<!--         <li class="hidden-xs"> <form method="post" action="index.html" class="searchform"><input type="text" placeholder="Search here..." name="keyword" class="form-control"></form> </li> -->
        <li id="last-one"> <a href="<?php echo base_url();?>login/logout">Log Out <i class="fa fa-angle-double-right"></i></a> </li>
<!--         <li><a id="show-right-info-bar" href="javascript:;" class=""><i class="fa fa-bars"></i></a></li> -->
      </ul><!--/nav navbar-nav--> 
    </div><!--/header-seperation--> 
  </div><!--/navbar-inner--> 
</div><!--/header--> 
