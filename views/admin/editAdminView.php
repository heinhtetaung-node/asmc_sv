<?php 
$this->load->view('header');
$this->load->view('navbar');
$this->load->view('sidebar');
?>

<div id="main-content"> 
	<div class="page-content">
   
		<!-- title -->
   		<div class="row">
        	<div class="col-md-12">
          		<h2><?php echo $title;?></h2>
        	</div>
      	</div>
      
      	<div class="row">
        <div class="col-md-9">
          <div class="block-web">
  
            <div class="header">
            <h3 class="content-header">
             	<?php echo $subtitle;?>
              </h3>
              
            </div>
    
            <div class="porlets-content">
            <?php 
              if ($this->session->userdata('error') != null) {
              	echo '<div class="alert alert-danger">'.$this->session->userdata('error').'</div>';
              	$this->session->unset_userdata('error');
              }
              if ($this->session->userdata('success') != null) {
              	echo '<div class="alert alert-success">'.$this->session->userdata('success').'</div>';
              	$this->session->unset_userdata('success');
              }
              ?>
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>admin/editAdmin">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('admin_name');?>
						<input type="text" name="admin_name" value="<?php echo set_value('admin_name', $admin_name);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin email</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('admin_email');?>
						<input type="text" name="admin_email" value="<?php echo set_value('admin_email', $admin_email);?>" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Admin password</label>
					  <div class="col-sm-9">
						<input type="password" name="admin_pass" value="<?php echo set_value('admin_pass', $admin_pass);?>" placeholder="Leave blank if unchanged" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  
					</div>
					
					<div class="bottom">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<input type="hidden" name="admin_id" value="<?php echo $admin->{'admin_id'};?>"/>
				</form>
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<?php
$this->load->view('footer.php');