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
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>manager/addManager">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Manager name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('m_name');?>
						<input type="text" name="m_name" value="<?php echo set_value('m_name', $m_name);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Manager email</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('m_email');?>
						<input type="text" name="m_email" value="<?php echo set_value('m_email', $m_email);?>" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Manager password</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('m_pass');?>
						<input type="password" name="m_pass" value="<?php echo set_value('m_pass', $m_pass);?>" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  
					  <?php if ($this->session->userdata('user_type') == 'admin') {?>
					   <div class="form-group">
					  <label class="col-sm-3 control-label">Director</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('m_upline');?>
						<select name="m_upline">
							<option value="">Select Director</option>
							<?php if (isset($directors) && count($directors) > 0) {
								foreach ($directors as $d) {
									echo '<option value="'.$d->{'dr_id'}.'">'.$d->{'dr_name'}.' ('.$d->{'dr_code'}.')</option>';
								}
							}
							?>
						</select>
					  </div>
					  </div>
					  <?php } else if ($this->session->userdata('user_type') == 'director') {?>
					  	<input type="hidden" name="m_upline" value="<?php echo $this->session->userdata('director')->{'dr_id'};?>"/>
					  <?php }?>
					  
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Manager code</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('m_code');?>
						<input type="text" name="m_code" value="<?php echo set_value('m_code', $m_code);?>" autocomplete="off" class="form-control">
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