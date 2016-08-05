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
<script>
function confirmDelete() {
	var x = confirm('Confirm delete? This cannot be undone!');
	return x;
}
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
             	<form class="form-horizontal" method="post" action="<?php echo base_url();?>invoice/editInvoice/?inv=<?php echo $inv->{'inv_id'};?>" enctype="multipart/form-data">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Project name</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('project_name');?>
						<input type="text" name="project_name" value="<?php echo set_value('project_name', $inv->{'project_name'});?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Early Redemption</label>
					  <div class="col-sm-9">
					  <?php $checked = isset($inv->{'early_redemption'}) && $inv->{'early_redemption'} == 1 ? 'selected="selected"' : '';?>
					  <select class="form-control" name="early_redemption" <?php echo $checked;?>>
					  	<option value="0">No</option>
					  	<option value="1">Yes</option>
					  </select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Starter Pack</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_starter_pack');?>
					  		<select name="agreement_type">
							<option value="1" <?php echo isset($agreement_type) && $agreement_type == 1 ? 'selected="selected"' : '';?>>Standard</option>
							<option value="2" <?php echo isset($agreement_type) && $agreement_type == 2 ? 'selected="selected"' : '';?>>Progressive</option>
							<option value="3" <?php echo isset($agreement_type) && $agreement_type == 3 ? 'selected="selected"' : '';?>>Topup</option>
						</select>
					  	<!-- 
<?php
					  	$checked = isset($inv_starter_pack) && $inv_starter_pack == 1 ? 'checked="checked"' : '';?>
						 <div class="checkbox">
							<label>
							  <input type="checkbox" name="inv_starter_pack" style="opacity:1;margin-left:-23px;"> Yes
							</label>
						  </div>
 -->
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract Date:<br/>(DD-MM-YYYY)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_date');?>
						<input type="text" name="inv_date" value="<?php echo set_value('inv_date', $inv->{'inv_date'});?>" class="form-control datepicker">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract Number:</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_no');?>
						<input type="text" name="inv_no" value="<?php echo set_value('inv_no', $inv->{'inv_no'});?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Amount (metric ton):</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_amt');?>
						<input type="text" id="inv_amt" name="inv_amt" placeholder="number only"  value="<?php echo set_value('inv_amt', $inv->{'inv_amt'});?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Rate Per Metric Ton ($):</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_unitprice');?>
					  	<select id="inv_unitprice" name="inv_unitprice" class="form-control">
							<option value="0.40" <?php echo isset($inv_unitprice) && $inv_unitprice == 0.4 ? 'selected="selected"' : '';?>>$0.40</option>
							<option value="0.80" <?php echo isset($inv_unitprice) && $inv_unitprice == 0.8 ? 'selected="selected"' : '';?>>$0.80</option>
							<option value="1.20" <?php echo isset($inv_unitprice) && $inv_unitprice == 1.2 ? 'selected="selected"' : '';?>>$1.20</option>
						</select>
<!-- 						<input type="text" id="inv_unitprice" name="inv_unitprice" placeholder="number only" value="<?php echo set_value('inv_unitprice', $inv->{'inv_unitprice'});?>" class="form-control"> -->
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Total:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="inv_total" readonly name="" value="" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Amount:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="" name="inv_total" class="form-control" value="<?php echo set_value('inv_total', $inv->{'inv_total'});?>">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Period:<br/>(in months)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('inv_period');?>
						<input type="text" name="inv_period" placeholder="number only" value="<?php echo set_value('inv_period', $inv->{'inv_period'});?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Monthly Payout:<br/>(numbers only)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('funding_amt');?>
						<input type="text" name="funding_amt" placeholder="number only" value="<?php echo set_value('funding_amt', $inv->{'funding_amt'});?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee: <br/>(numbers only)</label>
					  <div class="col-sm-9">
					  	<?php echo form_error('admin_fee');?>
						<input type="text" name="admin_fee" placeholder="number only" value="<?php echo set_value('admin_fee', $inv->{'admin_fee'});?>" class="form-control">
					  </div>
					</div>
					 <div class="form-group">
					  <label class="col-sm-3 control-label">Country:</label>
					  <div class="col-sm-9">
					  	<input type="text" id="country" name="country"  class="form-control" value="<?php echo set_value('country', $inv->{'country'});?>"/>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Customer:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('customer_id');?>
					  	<select name="customer_id">
					 		<?php
					 		if (isset($customers) && count($customers) > 0) {
					 			foreach ($customers as $c) {
					 				if ($c->{'customer_id'} == $inv->{'customer_id'})
					 					$select = 'selected = "selected"';
					 				else
					 					$select = '';
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
					 	<option value="0">Select Director</option>
					 		<?php
					 		if (isset($directors) && count($directors) > 0) {
					 			
					 			foreach ($directors as $d) {
					 				if ($d->{'dr_id'} == $inv->{'dr_id'})
					 					$select = 'selected = "selected"';
					 				else
					 					$select = '';
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
					 			
					 			foreach ($managers as $m) {
					 				if ($m->{'m_id'} == $inv->{'m_id'})
					 					$select = 'selected = "selected"';
					 				else
					 					$select = '';
					 				echo '<option value="'.$m->{'m_id'}.'" '.$select.'>'.$m->{'m_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 	
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Transfer to Manager:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('tm_id');?>
					 	<select name="tm_id">
					 		<?php
					 		if (isset($managers) && count($managers) > 0) {
					 			
					 			echo '<option value=""></option>';
					 			foreach ($managers as $m) {
					 				
					 					$select = '';
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
					 			foreach ($agents as $a) {
					 				if ($a->{'agent_id'} == $inv->{'agent_id'})
					 					$select = 'selected = "selected"';
					 				else
					 					$select = '';
					 				echo '<option value="'.$a->{'agent_id'}.'" '.$select.'>'.$a->{'agent_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Reassigned Agent:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('aagent_id');?>
					  	<select name="aagent_id">
					 		<?php
					 		if (isset($agents) && count($agents) > 0) {
					 			echo '<option value=""></option>';
					 			foreach ($agents as $a) {
					 				if (isset($inv->{'aagent'}->{'agent_id'}) && $a->{'agent_id'} == $inv->{'aagent'}->{'agent_id'})
					 					$select = 'selected = "selected"';
					 				else
					 					$select = '';
					 				echo '<option value="'.$a->{'agent_id'}.'" '.$select.'>'.$a->{'agent_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Transfer to Agent:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('tagent_id');?>
					 	<select name="tagent_id">
					 		<?php
					 		if (isset($agents) && count($agents) > 0) {
					 			echo '<option value=""></option>';
					 			foreach ($agents as $a) {
					 				
					 					$select = '';
					 				echo '<option value="'.$a->{'agent_id'}.'" '.$select.'>'.$a->{'agent_name'}.'</option>';
					 			}
					 		}
					 		?>
					 	</select> 	
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Marketing Name:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('marketing');?>
					  	<input type="text" name="marketing" class="form-control" value="<?php echo isset($marketing) ? set_value('marketing', $marketing) : set_value('marketing');?>"/>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Referral Name:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('referral');?>
					  	<input type="text" name="referral" class="form-control" value="<?php echo isset($referral) ? set_value('referral', $referral) : set_value('referral');?>"/>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Source:</label>
					  <div class="col-sm-9">
					  <?php echo form_error('source');?>
					  <select name="source">
					 		
					 	<option value="EC" <?php echo isset($source) && $source == 'EC' ? 'selected="selected"' : '';?>>EC</option>
					 	<option value="REF" <?php echo isset($source) && $source == 'REF' ? 'selected="selected"' : '';?>>REF</option>
					 	<option value="SG" <?php echo isset($source) && $source == 'SG' ? 'selected="selected"' : '';?>>SG</option>
					 	<option value="TM" <?php echo isset($source) && $source == 'TM' ? 'selected="selected"' : '';?>>TM</option>
					 			
					 	</select>  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Remarks:</label>
					  <div class="col-sm-9">
					  
						<textarea id="remarks" name="remarks"  class="form-control"><?php echo set_value('remarks', $inv->{'remarks'});?></textarea>
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
					  
						<input type="text" id="cheque_no" name="cheque_no"  class="form-control" value="<?php echo set_value('cheque_no', $inv->{'cheque_no'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 2:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="cheque_no2" name="cheque_no2"  class="form-control" value="<?php echo set_value('cheque_no2', $inv->{'cheque_no2'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 3:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="cheque_no3" name="cheque_no3"  class="form-control" value="<?php echo set_value('cheque_no3', $inv->{'cheque_no3'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee Cheque No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="admin_cheque_no" name="admin_cheque_no"  class="form-control" value="<?php echo set_value('admin_cheque_no', $inv->{'admin_cheque_no'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding TT No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="tt_no" name="tt_no"  class="form-control" value="<?php echo set_value('tt_no', $inv->{'tt_no'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee TT No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" id="admin_tt_no" name="admin_tt_no"  class="form-control" value="<?php echo set_value('admin_tt_no', $inv->{'admin_tt_no'});?>"/>
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
					 	<?php
					  	if ($inv->{'contract'} != '' && $inv->{'contract'} != null) {
					 		echo '<a href="'.AGREEMENT_URL.$inv->{"contract"}.'" target="_blank">Contract</a>';
					 	}
					 	
					 	?>
					 	 <input type="file" name="contract" size="20" />
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Risk Assessment:</label>
					  <div class="col-sm-9">
					 	 <?php
					  	if ($inv->{'risk'} != '' && $inv->{'risk'} != null) {
					 		echo '<a href="'.RISK_URL.$inv->{"risk"}.'" target="_blank">Risk Assesment</a>';
					 	}
					 	
					 	?>
					 	 <input type="file" name="risk" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Receipt:</label>
					  <div class="col-sm-9">
					 	 <?php
					  	if ($inv->{'funding_receipt'} != '' && $inv->{'funding_receipt'} != null) {
					 		echo '<a href="'.RECEIPT_URL.$inv->{"funding_receipt"}.'" target="_blank">Funding Receipt</a>';
					 	}
					 	
					 	?>
					 	 <input type="file" name="funding_receipt" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Payout Schedule:</label>
					  <div class="col-sm-9">
					 	 <?php
					  	if ($inv->{'payout_schedule'} != '' && $inv->{'payout_schedule'} != null) {
					 		echo '<a href="'.PAYOUT_URL.$inv->{"payout_schedule"}.'" target="_blank">Payout Schedule</a>';
					 	}
					 	
					 	?>
					 	 <input type="file" name="payout_schedule" size="20" />
					   </div>
					</div>


					<div class="form-group">
					  <label class="col-sm-3 control-label">IRAS Certificate:</label>
					  <div class="col-sm-9">
					  	<?php
					  	if ($inv->{'iras'} != '' && $inv->{'iras'} != null) {
					 		echo '<a href="'.IRAS_URL.$inv->{"iras"}.'" target="_blank">IRAS Certificate</a>';
					 	}
					 	?>
					 	 <input type="file" name="iras" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Bank Record:</label>
					  <div class="col-sm-9">
					  	<?php
					  	if ($inv->{'bank_record'} != '' && $inv->{'bank_record'} != null) {
					 		echo '<a href="'.BANK_URL.$inv->{"bank_record"}.'" target="_blank">Bank Record</a>';
					 	}
					 	?>
					 	 <input type="file" name="bank" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">NRIC:</label>
					  <div class="col-sm-9">
					  	<?php
					  	if ($inv->{'nric'} != '' && $inv->{'nric'} != null) {
					 		echo '<a href="'.NRIC_URL.$inv->{"nric"}.'" target="_blank">NRIC</a>';
					 	}
					 	?>
					 	 <input type="file" name="nric" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Worksheet:</label>
					  <div class="col-sm-9">
					  	<?php
					  	if ($inv->{'worksheet'} != '' && $inv->{'worksheet'} != null) {
					 		echo '<a href="'.WORKSHEET_URL.$inv->{"worksheet"}.'" target="_blank">Worksheet</a>';
					 	}
					 	?>
					 	 <input type="file" name="worksheet" size="20" />
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Comfort Letter:</label>
					  <div class="col-sm-9">
					 	<?php
					  	if ($inv->{'comfort_letter'} != '' && $inv->{'comfort_letter'} != null) {
					 		echo '<a href="'.COMFORT_URL.$inv->{"comfort_letter"}.'" target="_blank">Comfort Letter</a>';
					 	}
					 	?>
					 	 <input type="file" name="comfort_letter" size="20" />
					   </div>
					</div>
					
					
					<input type="hidden" name="inv_id" value="<?php echo $inv->{'inv_id'};?>"/>
					<div class="bottom">
					  <input type="submit" class="btn btn-primary" name="submit" value="Update"/>
					</div>
				</form>
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
        
        
      	</div>
      	
      <div class="row">
       	 <div class="col-md-9">
       	 	<div class="block-web">
       	 		 <div class="header">
           		 	<h3 class="content-header">
             		Payout
             	 </h3>
              	</div>
              	<div class="porlets-content">
              		 <div class="tab-container">
             		 	<ul class="nav nav-tabs">
               				 <li class="active"><a href="#home" data-toggle="tab">Client Payout</a></li>
               				
               				 <?php if ($this->session->userdata('user_type') == 'agent' || $this->session->userdata('user_type') == 'manager' || $this->session->userdata('user_type') == 'admin') {?>
               				 <li class=""><a href="#profile" data-toggle="tab">Sales Payout</a></li>
               				  <?php }?>
               				 <?php if ($this->session->userdata('user_type') == 'manager' || $this->session->userdata('user_type') == 'admin') {?>
               				  <li class=""><a href="#manager" data-toggle="tab">Manager Payout</a></li>
               				 <?php }?>
<!--                				   <li class=""><a href="#compliance" data-toggle="tab">Compliance Payout</a></li> -->
						</ul>
						  <div class="tab-content">
							<div class="tab-pane cont active" id="home">
							  	<div class="table-responsive">
								
								<?php
								if (isset($client_payout) && count($client_payout) > 0) {
									$month = 1;
									$year = 1;
									$total_per_year = 0;
									$total = 0;
									
									for ($i =1; $i<= count($client_payout); $i++) {
										if ($month == 1) {
											?>
											<div class="alert alert-info"><b>YEAR <?php echo $year;?></b></div>
											<table class="table table-bordered">
											  <thead>
												<tr>
												  <th>No.</th>
												  <th>Date</th>
												  <th>Amount ($)</th>
												  <th>Status/Action</th>
									  				<th> Receipt</th>
									  				<?php if($this->session->userdata('user_type') == 'admin') {?>
									  				<th>Upload Receipt</th>
									  				<?php } ?>
												</tr>
											  </thead>
											  <tbody>
								 	 		<?php
								 	 		}
										echo '<tr>';
										echo '<td>'.$month.'</td>';
										
										
										echo '<td>'.date('Y-m-d', strtotime($client_payout[$i-1]->{'date'})).'</td>';
										
										//first 3 months
										if ($year == 1 && ($month <= 3) && $inv->{'inv_starter_pack'} == 0 && $inv->{'agreement_type'} != 2) {
											echo '<td><b>Production Period</b></td>';
										}
										else if ($inv->{'inv_starter_pack'} == 1 && $year == 1 && ($month <= 1) && $inv->{'agreement_type'} != 2) {
											echo '<td><b>Production Period</b></td>';
										}
										else {
											//last year last row
											if ($i == count($client_payout)) {
												echo '<td>$'.number_format($client_payout[$i-1]->{'amt'},2,'.',',').'<br/>'.
													'$'.number_format($inv->{'funding_amt'},2,'.',',').'</td>';
												$total_per_year += $inv->{'funding_amt'};
											}
											else
												echo '<td>$'.number_format($client_payout[$i-1]->{'amt'},2,'.',',').'</td>';
											$total_per_year += $client_payout[$i-1]->{'amt'};
										}		
										
										//first 3 months
										if ($year == 1 && ($month <= 3) && $inv->{'inv_starter_pack'} == 0 && $inv->{'agreement_type'} != 2) {
											echo '<td>-</td>';
										}
										else if ($inv->{'inv_starter_pack'} == 1 && $year == 1 && ($month <= 1) && $inv->{'agreement_type'} != 2) {
											echo '<td>-</td>';
										}
										else {
											if ($this->session->userdata('user_type') != 'admin') {
											
												if ($client_payout[$i-1]->{'pay_date'} == null) {
													echo '<td><a href="#">UNPAID</a></td>';
												}
												else {
													echo '<td><a class="paid-link" href="#">PAID</a></td>';
												}
											}
												else {
			
												//havent pay
												if ($client_payout[$i-1]->{'pay_date'} == null) {
													echo '<td><a href="'.base_url().'invoice/markPaid/?inv='.$_GET['inv'].'&id='.$client_payout[$i-1]->{'id'}.'">Pay</a></td>';
												}
												else {
													echo '<td><a class="paid-link" href="'.base_url().'invoice/markUnpaid/?inv='.$_GET['inv'].'&id='.$client_payout[$i-1]->{'id'}.'">Paid</a></td>';
												}
											}
										}
										
										 if ($client_payout[$i-1]->{'pdf_receipt'} != null && $client_payout[$i-1]->{'pdf_receipt'} != '' && file_exists(RECEIPT_PATH.'manual/'.$client_payout[$i-1]->{'id'}.$client_payout[$i-1]->{'pdf_receipt'})) {
												echo '<td><a href="'.RECEIPT_URL.'manual/'.$client_payout[$i-1]->{'id'}.$client_payout[$i-1]->{'pdf_receipt'}.'">Receipt</a></td>';
												}
										else {
											if ($client_payout[$i-1]->{'pay_date'} != null) {
												echo '<td><a href="'.base_url().'invoice/generateClientPayoutReceipt/?id='.$_GET['inv'].'&pid='.$client_payout[$i-1]->{'id'}.'" target="_blank">Receipt</a></td>';
											}
											else
												echo '<td>-</td>';
										}
										//upload receipt
										?>
											<?php if($this->session->userdata('user_type') == 'admin') {?>
											<td>
											
											<?php if ($client_payout[$i-1]->{'pdf_receipt'} != null && $client_payout[$i-1]->{'pdf_receipt'} != '' && file_exists(RECEIPT_PATH.'manual/'.$client_payout[$i-1]->{'id'}.$client_payout[$i-1]->{'pdf_receipt'})) {
												echo '<a href="'.RECEIPT_URL.'manual/'.$client_payout[$i-1]->{'id'}.$client_payout[$i-1]->{'pdf_receipt'}.'">View Receipt</a>';
												echo '<br/><a href="'.base_url().'invoice/removeReceipt/?pid='.$client_payout[$i-1]->{'id'}.'&inv='.$_GET['inv'].'" onclick="return confirmDelete();">Delete Receipt</a>';
											}
											?>
											<form method="post" action="<?php echo base_url();?>invoice/uploadReceipt" enctype="multipart/form-data">
											<input type="file" name="receipt_upload"/>
											<input type="hidden" name="pid" value="<?php echo $client_payout[$i-1]->{'id'};?>"/>
											<input type="hidden" name="inv_id" value="<?php echo $_GET['inv'];?>"/>
											
											<input type="submit" class="btn btn-primary" name="submit" value="Upload"/>
											</form>
											</td>
										<?php
										}
										
										//last row
										if ($month == 12 || $i == count($client_payout)) {
										?>	
											<tr>
												<td colspan="2" style="text-align:right"><b>Total Receivable:</b></td>
												<td colspan="3"><b>$<?php echo number_format($total_per_year, 2,'.',',');?></b></td>
											</tr>
											<?php 
											//add to total
											$total += $total_per_year;
											//reset total per year
											$total_per_year = 0;
											?>
										 	</tbody>
											</table>	
									  	<?php
									  	}
									  	
									  	$month ++;
									  	if ($month == 13) {
									  		$month = 1;
									  		$year++;
									  	}
									  }
									  echo '<div class="alert alert-success"><b>Total Payout: $'.number_format($total, 2, '.',',').'</b></div>';
								   }
								
								?>
						
								  </div>
				 
				 
							</div>
							<?php if ($this->session->userdata('user_type') == 'agent' || $this->session->userdata('user_type') == 'manager' || $this->session->userdata('user_type') == 'admin') {?>
							<div class="tab-pane cont" id="profile">
							 	<div class="table-responsive">
								<div class="alert alert-info"><b>Staff Comm: <?php echo $comm;?><br/>Staff Pipeline: <?php echo $pipeline;?></b></div>
								<?php
								if (isset($sales_payout) && count($sales_payout) > 0) {
									$month = 1;
									$year = 1;
									$total_per_year = 0;
									$total = 0;
									
									for ($i =1; $i<= count($sales_payout); $i++) {
										if ($month == 1) {
											?>
											<div class="alert alert-info"><b>YEAR <?php echo $year;?></b></div>
											<table class="table table-bordered">
											  <thead>
												<tr>
												  <th>No.</th>
												  <th>Date</th>
												  <th>Amount ($)</th>
												  <th>Status/Action</th>
									  
												</tr>
											  </thead>
											  <tbody>
								 	 		<?php
								 	 		}
										echo '<tr>';
										echo '<td>'.$month.'</td>';
										
										
										echo '<td>'.date('Y-m-d', strtotime($sales_payout[$i-1]->{'date'})).'</td>';
										
										//first 3 months
										if ($year == 1 && ($month == 1 || $month == 2 || $month == 4 || $month == 5)) {
											echo '<td><b>-</b></td>';
										}
										else {
											//last year last row
											// if ($i == count($sales_payout)) {
// 												echo '<td>$'.number_format($sales_payout[$i-1]->{'amt'},2,'.',',').'</td>';
// 												$total_per_year += $inv->{'funding_amt'};
// 											}
// 											else
												echo '<td>$'.number_format($sales_payout[$i-1]->{'amt'},2,'.',',').'</td>';
											$total_per_year += $sales_payout[$i-1]->{'amt'};
										}		
										
										//first 3 months
										if ($year == 1 && ($month == 1 || $month == 2 || $month == 4 || $month == 5)) {
											echo '<td>-</td>';
										}
										else {
											if ($this->session->userdata('user_type') != 'admin') {
											
												if ($sales_payout[$i-1]->{'pay_date'} == null) {
													echo '<td><a href="#">UNPAID</a></td>';
												}
												else {
													echo '<td><a class="paid-link" href="#">PAID</a></td>';
												}
											}
											else {
													//havent pay
												if ($sales_payout[$i-1]->{'pay_date'} == null) {
													echo '<td><a href="'.base_url().'invoice/markSalesPaid/?inv='.$_GET['inv'].'&id='.$sales_payout[$i-1]->{'id'}.'">Pay</a></td>';
												}
												else {
													echo '<td><a class="paid-link" href="'.base_url().'invoice/markSalesUnpaid/?inv='.$_GET['inv'].'&id='.$sales_payout[$i-1]->{'id'}.'">Paid</a></td>';
												}
											}

										}
										
										//last row
										if ($month == 12 || $i == count($sales_payout)) {
										?>	
											<tr>
												<td colspan="2" style="text-align:right"><b>Total Receivable:</b></td>
												<td colspan="2"><b>$<?php echo number_format($total_per_year, 2,'.',',');?></b></td>
											</tr>
											<?php 
											//add to total
											$total += $total_per_year;
											//reset total per year
											$total_per_year = 0;
											?>
										 	</tbody>
											</table>	
									  	<?php
									  	}
									  	
									  	$month ++;
									  	if ($month == 13) {
									  		$month = 1;
									  		$year++;
									  	}
									  }
									  echo '<div class="alert alert-success"><b>Total Payout: $'.number_format($total, 2, '.',',').'</b></div>';
								   }
								
								?>
						
								  </div>
				 				<?php }?>
				  
				  
							</div>
							<?php if ($this->session->userdata('user_type') == 'manager' || $this->session->userdata('user_type') == 'admin') {?>
							<div class="tab-pane cont" id="manager">
							 
				  			<div class="table-responsive">
									<div class="alert alert-info"><b>Manager Comm: <?php echo $m_comm;?><br/>Manager Pipeline: <?php echo $m_pipeline;?></b></div>
								<?php
								if (isset($manager_payout) && count($manager_payout) > 0) {
									$month = 1;
									$year = 1;
									$total_per_year = 0;
									$total = 0;
									
									for ($i =1; $i<= count($manager_payout); $i++) {
										if ($month == 1) {
											?>
											<div class="alert alert-info"><b>YEAR <?php echo $year;?></b></div>
											<table class="table table-bordered">
											  <thead>
												<tr>
												  <th>No.</th>
												  <th>Date</th>
												  <th>Amount ($)</th>
												  <th>Status/Action</th>
									  
												</tr>
											  </thead>
											  <tbody>
								 	 		<?php
								 	 		}
										echo '<tr>';
										echo '<td>'.$month.'</td>';
										
										
										echo '<td>'.date('Y-m-d', strtotime($manager_payout[$i-1]->{'date'})).'</td>';
										
										//first 3 months
										if ($year == 1 && ($month == 1 || $month == 2 || $month == 4 || $month == 5)) {
											echo '<td><b>-</b></td>';
										}
										else {
											//last year last row
											// if ($i == count($sales_payout)) {
// 												echo '<td>$'.number_format($sales_payout[$i-1]->{'amt'},2,'.',',').'</td>';
// 												$total_per_year += $inv->{'funding_amt'};
// 											}
// 											else
												echo '<td>$'.number_format($manager_payout[$i-1]->{'amt'},2,'.',',').'</td>';
											$total_per_year += $manager_payout[$i-1]->{'amt'};
										}		
										
										//first 3 months
										if ($year == 1 && ($month == 1 || $month == 2 || $month == 4 || $month == 5)) {
											echo '<td>-</td>';
										}
										else {
											if ($this->session->userdata('user_type') != 'admin') {
											
												if ($manager_payout[$i-1]->{'pay_date'} == null) {
													echo '<td><a href="#">UNPAID</a></td>';
												}
												else {
													echo '<td><a class="paid-link" href="#">PAID</a></td>';
												}
											}
											else {
												//havent pay
												if ($manager_payout[$i-1]->{'pay_date'} == null) {
													echo '<td><a href="'.base_url().'invoice/markMPaid/?inv='.$_GET['inv'].'&id='.$manager_payout[$i-1]->{'id'}.'">Pay</a></td>';
												}
												else {
													echo '<td><a class="paid-link" href="'.base_url().'invoice/markMUnpaid/?inv='.$_GET['inv'].'&id='.$manager_payout[$i-1]->{'id'}.'">Paid</a></td>';
												}
											}
										}
										
										//last row
										if ($month == 12 || $i == count($manager_payout)) {
										?>	
											<tr>
												<td colspan="2" style="text-align:right"><b>Total Receivable:</b></td>
												<td colspan="2"><b>$<?php echo number_format($total_per_year, 2,'.',',');?></b></td>
											</tr>
											<?php 
											//add to total
											$total += $total_per_year;
											//reset total per year
											$total_per_year = 0;
											?>
										 	</tbody>
											</table>	
									  	<?php
									  	}
									  	
									  	$month ++;
									  	if ($month == 13) {
									  		$month = 1;
									  		$year++;
									  	}
									  }
									  echo '<div class="alert alert-success"><b>Total Payout: $'.number_format($total, 2, '.',',').'</b></div>';
								   }
								
								?>
						
								  </div>
				 			 <?php }?>
				  
				  
							</div>
							<div class="tab-pane cont" id="compliance">
							 
				  
				  
							</div>
						  </div>
           			 </div>
              	</div>
              	
            </div>
    
       	 	</div>
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
		$("#submit").click(function(e) {
				
				if ($("#inv_no").val() == '') {
					$("#inv_no").focus();
					e.preventDefault();
					alert('Please enter contract no');
				}
			});
	});
</script>
<?php
$this->load->view('footer.php');