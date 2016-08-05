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
             <form class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Name</label>
					  <div class="col-sm-9 profile-field">
					  	
						<?php echo $profile->{'customer_name'};?>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Username</label>
					  <div class="col-sm-9 profile-field">
					  	
						<?php echo $profile->{'customer_username'};?>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Email</label>
					  <div class="col-sm-9 profile-field">
					 	 
						<?php echo $profile->{'customer_email'};?>
						 </div>
					  </div>
					  
					  <div class="form-group">
					  <label class="col-sm-3 control-label">NRIC</label>
					  <div class="col-sm-9 profile-field">
					  <?php echo $profile->{'customer_nric'};?>
					   </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Mobile</label>
					  <div class="col-sm-9 profile-field">
					  
						<?php echo $profile->{'customer_mobile'};?>
						 </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Address</label>
					  <div class="col-sm-9 profile-field">
					  	<?php echo $profile->{'customer_addr'};?>
					  	 </div>
					  </div>
					   <div class="form-group">
					  <label class="col-sm-3 control-label">Address 2</label>
					  <div class="col-sm-9 profile-field">
					  	<?php echo $profile->{'customer_addr2'};?>
					  	 </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">D.O.B <br/>(YYYY-mm-dd)</label>
					  <div class="col-sm-9 profile-field">
					  	<?php echo $profile->{'customer_dob'};?> </div>
					  </div>
					  </form> 
					</div>
					
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<?php
$this->load->view('footer.php');