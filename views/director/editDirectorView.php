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
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>director/editDirector">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Director name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('dr_name');?>
						<input type="text" name="dr_name" value="<?php echo set_value('dr_name', $dr_name);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Director email</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('dr_email');?>
						<input type="text" name="dr_email" value="<?php echo set_value('dr_email', $dr_email);?>" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Director password</label>
					  <div class="col-sm-9">
						<input type="password" name="dr_pass" value="<?php echo set_value('dr_pass', $dr_pass);?>" placeholder="Leave blank if unchanged" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Director code</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('dr_code');?>
						<input type="text" name="dr_code" value="<?php echo set_value('dr_code', $dr_code);?>" class="form-control">
					  </div>
					  </div>
					</div>
					
					<div class="bottom">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<input type="hidden" name="dr_id" value="<?php echo $director->{'dr_id'};?>"/>
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