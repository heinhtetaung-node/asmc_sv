<?php 
$this->load->view('header');
$this->load->view('navbar');
$this->load->view('sidebar');
?>

<div id="main-content" ng-controller="editagentctrl"> 
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
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>agent/editAgent">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Agent name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('agent_name');?>
						<input type="text" name="agent_name" value="<?php echo set_value('agent_name', $agent_name);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Agent email</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('agent_email');?>
						<input type="text" name="agent_email" value="<?php echo set_value('agent_email', $agent_email);?>" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Agent password</label>
					  <div class="col-sm-9">
						<input type="password" name="agent_pass" value="<?php echo set_value('agent_pass', $agent_pass);?>" placeholder="Leave blank if unchanged" autocomplete="off" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Manager</label>
					  <div class="col-sm-9">
					  	 <?php echo form_error('agent_upline');?>
						<select name="agent_upline">
							<?php if (isset($managers) && count($managers) > 0) {
								foreach ($managers as $m) {
									if ($agent_upline == $m->{"m_id"})
										$select = "selected='selected'";
									else
										$select ='';
									echo '<option value="'.$m->{'m_id'}.'" '.$select.'>'.$m->{'m_name'}.' ('.$m->{'m_code'}.')</option>';
								}
							}
							?>
						</select>
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Agent code</label>
					  <div class="col-sm-9">
					 	 <?php echo form_error('agent_code');?>
						<input type="text" name="agent_code" value="<?php echo set_value('agent_code', $agent_code);?>" class="form-control">
					  </div>
					  </div>
					  <div class="form-group">
					  <label class="col-sm-3 control-label">Status</label>
					  <div class="col-sm-9">
					 	 <input class="status" type="checkbox" checked data-size="small" data-toggle="toggle" data-on="Active" data-off="Disable">
					  </div>
					  </div>
					</div>
					<?php if ($this->session->userdata('user_type') == 'admin') { ?>
					<div class="bottom">
					  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
					<?php } ?>
					<input type="hidden" name="agent_id" id="agent_id" value="<?php echo $agent->{'agent_id'};?>"/>
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