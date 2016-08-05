<?php 
$this->load->view('header');
$this->load->view('navbar');
$this->load->view('sidebar');
?>
<script>

$(document).ready(function() {
$(".datepicker").datepicker({dateFormat:'dd-mm-yy'});
});
</script>
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
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>invoice/addFromForm?id=<?php echo $_GET['id'];?>" enctype="multipart/form-data">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Project name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('project_name');?>
						<input type="text" name="project_name" value="<?php echo set_value('project_name');?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Starter Pack</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_starter_pack');?>
					  	<?php
					  	$checked = isset($inv_starter_pack) && $inv_starter_pack == 1 ? 'checked="checked"' : '';?>
						 <div class="checkbox">
							<label>
							  <input type="checkbox" name="inv_starter_pack" style="opacity:1;margin-left:-23px;"> Yes
							</label>
						  </div>
					
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract Date:<br/>(YYYY-MM-DD)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_date');?>
						<input type="text" name="inv_date" value="<?php echo isset($inv_date) ? set_value('inv_date', $inv_date) : set_value('inv_date');?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract Number:</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_no');?>
						<input type="text" name="inv_no" value="<?php echo set_value('inv_no');?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Amount (metric ton):</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_amt');?>
						
						<input type="text" id="inv_amt" name="inv_amt" placeholder="number only"  value="<?php echo isset($inv_amt) ? set_value('inv_amt', $inv_amt) : set_value('inv_amt');?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Rate Per Metric Ton ($):</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_unitprice');?>
					  	<select id="inv_unitprice" name="inv_unitprice" class="form-control">
							<option value="62.50">$62.50</option>
							<option value="40.00">$40.00</option>
						</select>
<!-- 						<input type="text" id="inv_unitprice" name="inv_unitprice" placeholder="number only" value="<?php echo set_value('inv_unitprice');?>" class="form-control"> -->
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Total:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="inv_total" readonly  value="" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Period:<br/>(in months)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_period');?>
						<input type="text" name="inv_period" placeholder="number only" value="<?php echo set_value('inv_period', 60);?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Monthly Payout:<br/>(numbers only)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('funding_amt');?>
						<input type="text" name="funding_amt" placeholder="number only" value="<?php echo isset($funding_amt) ? set_value('funding_amt', $funding_amt) : set_value('funding_amt');?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee: <br/>(numbers only)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('admin_fee');?>
						<input type="text" name="admin_fee" placeholder="number only" value="<?php echo isset($admin_fee) ? set_value('admin_fee', $admin_fee) : set_value('admin_fee');?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Country:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="country" name="country"  class="form-control" value="<?php echo set_value('country');?>"/>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Customer:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('customer_id');?>
					  	<select name="customer_id">
					 		<?php
					 		if (isset($customers) && count($customers) > 0) {
					 			echo '<option value="0"></option>';
					 			foreach ($customers as $c) {
					 				$select = '';
					 				if (isset($customer_id) && $customer_id == $c->{'customer_id'})
					 					$select = 'selected="selected"';
					 					
					 				echo '<option value="'.$c->{'customer_id'}.'" '.$select.'>'.$c->{'customer_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Director:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('dr_id');?>
					 	<select name="dr_id">
					 		<?php
					 		if (isset($directors) && count($directors) > 0) {
					 			echo '<option value="0"></option>';
					 			foreach ($directors as $d) {
					 				$select = '';
					 				if (isset($dr_id) && $dr_id == $d->{'dr_id'})
					 					$select = 'selected="selected"';
					 					
					 					
					 				echo '<option value="'.$d->{'dr_id'}.'" '.$select.'>'.$d->{'dr_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 	
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Manager:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('m_id');?>
					 	<select name="m_id">
					 		<?php
					 		if (isset($managers) && count($managers) > 0) {
					 			echo '<option value="0"></option>';
					 			foreach ($managers as $m) {
					 				$select = '';
					 				if (isset($m_id) && $m_id == $m->{'m_id'})
					 					$select = 'selected="selected"';
					 					
					 				echo '<option value="'.$m->{'m_id'}.'" '.$select.'>'.$m->{'m_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 	
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Agent:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('agent_id');?>
					  	<select name="agent_id">
					 		<?php
					 		if (isset($agents) && count($agents) > 0) {
					 			echo '<option value="0"></option>';
					 			foreach ($agents as $a) {
					 				$select = '';
					 				if (isset($agent_id) && $agent_id == $a->{'agent_id'})
					 					$select = 'selected="selected"';
					 				echo '<option value="'.$a->{'agent_id'}.'" '.$select.'>'.$a->{'agent_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Additional Agent:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('aagent_id');?>
					  	<select name="aagent_id">
					 		<?php
					 		if (isset($agents) && count($agents) > 0) {
					 			echo '<option value="0"></option>';
					 			foreach ($agents as $a) {
					 				echo '<option value="'.$a->{'agent_id'}.'">'.$a->{'agent_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Remarks:</label>
					  <div class="col-sm-9">
					  
						<textarea id="remarks" name="remarks"  class="form-control"><?php echo isset($remarks) ? set_value('remarks', $remarks) : set_value('remarks');?></textarea>
					  </div>
					</div>
					
					<br/>
					 <div class="header">
						<h3 class="content-header">
							Payment Mode
						  </h3>
				
						</div>
						
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 1:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="cheque_no" name="cheque_no"  class="form-control" value="<?php echo set_value('cheque_no');?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 2:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="cheque_no2" name="cheque_no2"  class="form-control" value="<?php echo set_value('cheque_no2');?>"/>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 3:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="cheque_no3" name="cheque_no3"  class="form-control" value="<?php echo set_value('cheque_no3');?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee Cheque No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="admin_cheque_no" name="admin_cheque_no"  class="form-control" value="<?php echo set_value('admin_cheque_no');?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding TT No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="tt_no" name="tt_no"  class="form-control" value="<?php echo set_value('tt_no');?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee TT No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="admin_tt_no" name="admin_tt_no"  class="form-control" value="<?php echo set_value('admin_tt_no');?>"/>
					  </div>
					</div>
					
					<br/>
					 <div class="header">
						<h3 class="content-header">
							Documents
						  </h3>
				
						</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="contract" size="20" />
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Risk Assessment:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="risk" size="20" />
					   </div>
					</div>

					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Receipt:</label>
					  <div class="col-sm-9">
					 	
					 	 <input type="file" name="funding_receipt" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Payout Schedule:</label>
					  <div class="col-sm-9">
					 	
					 	 <input type="file" name="payout_schedule" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">IRAS Certificate:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="iras" size="20" />
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Bank Record:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="bank" size="20" />
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">NRIC:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="nric" size="20" />
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Worksheet:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="worksheet" size="20" />
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Comfort Letter:</label>
					  <div class="col-sm-9">
					 	 <input type="file" name="comfort_letter" size="20" />
					   </div>
					</div>
					
					
					
					<div class="bottom">
					  <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
					</div>
				</form>
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<script>
	$(document).ready(function() {
			$("#inv_total").val($("#inv_amt").val() * $("#inv_unitprice").val());
			$("#inv_amt").on('change',function() {
				$("#inv_total").val($("#inv_amt").val() * $("#inv_unitprice").val());
		
			});
			$("#inv_unitprice").on('change',function() {
				$("#inv_total").val($("#inv_amt").val() * $("#inv_unitprice").val());
		
		});
	
	});
</script>
<?php
$this->load->view('footer.php');