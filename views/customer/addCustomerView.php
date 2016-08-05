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
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>customer/addCustomer">
					<!-- 
<div class="form-group">
					  <label class="col-sm-3 control-label">Project name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('customer_project');?>
						<input type="text" name="customer_project" value="<?php echo set_value('customer_project', $customer_project);?>" class="form-control">
					  </div>
					</div>
 -->
 					<input type="hidden" name="customer_project" value="<?php echo set_value('customer_project', $customer_project);?>" class="form-control">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funder name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('customer_name');?>
						<input type="text" name="customer_name" value="<?php echo set_value('customer_name', $customer_name);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funder user name (login account)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('customer_username');?>
						<input type="text" name="customer_username" value="<?php echo set_value('customer_username', $customer_username);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funder email</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('customer_email');?>
						<input type="text" name="customer_email" value="<?php echo set_value('customer_email', $customer_email);?>" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Funder password</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('customer_pass');?>
						<input type="password" name="customer_pass" value="<?php echo set_value('customer_pass', $customer_pass);?>" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Funder NRIC</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('customer_nric');?>
						<input type="text" name="customer_nric" value="<?php echo set_value('customer_nric', $customer_nric);?>" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Funder mobile</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('customer_mobile');?>
						<input type="text" name="customer_mobile" value="<?php echo set_value('customer_mobile', $customer_mobile);?>" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Funder address</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('customer_addr');?>
						<textarea rows="4" name="customer_addr" autocomplete="off" class="form-control"><?php echo set_value('customer_addr', $customer_addr);?></textarea>
					  </div>
					  </div>
					   <div class="form-group">
					  <label class="col-sm-3 control-label">Funder address 2</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('customer_addr2');?>
						<textarea rows="4" name="customer_addr2"  autocomplete="off" class="form-control"><?php echo set_value('customer_addr2', $customer_addr2);?></textarea>
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Funder D.O.B <br/>(YYYY-mm-dd)</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('customer_dob');?>
						<input type="text" name="customer_dob" value="<?php echo set_value('customer_dob', $customer_dob);?>" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
						<label class="col-sm-3 control-label">Funder Bank Name</label>
					  	<div class="col-sm-9">
					  		 <?php echo form_error('customer_bank_name');?>
						<input type="text" name="customer_bank_name" value="<?php echo set_value('customer_bank_name', $customer_bank_name);?>" autocomplete="off" class="form-control">
					  	</div>
					  </div>
					   <div class="form-group">
						<label class="col-sm-3 control-label">Funder Bank Account No.</label>
					  	<div class="col-sm-9">
					  		 <?php echo form_error('customer_bank_acc');?>
						<input type="text" name="customer_bank_acc" value="<?php echo set_value('customer_bank_acc', $customer_bank_acc);?>" autocomplete="off" class="form-control">
					  	</div>
					  </div>
					   <div class="form-group">
						<label class="col-sm-3 control-label">Funder Bank Account Type</label>
					  	<div class="col-sm-9">
					  		 <?php echo form_error('customer_acc_type');?>
						<input type="text" name="customer_acc_type" value="<?php echo set_value('customer_acc_type', $customer_acc_type);?>" autocomplete="off" class="form-control">
					  	</div>
					  </div>
					  <div class="form-group">
						<label class="col-sm-3 control-label">Funder Bank Swift Code</label>
					  	<div class="col-sm-9">
					  		 <?php echo form_error('customer_bank_swift');?>
						<input type="text" name="customer_bank_swift" value="<?php echo set_value('customer_bank_swift', $customer_bank_swift);?>" autocomplete="off" class="form-control">
					  	</div>
					  </div>
					  
					</div>
					
					<div class="bottom">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
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