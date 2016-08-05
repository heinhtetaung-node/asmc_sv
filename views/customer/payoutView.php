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
             	<form class="form-horizontal"  onsubmit="return false;">
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract Date:<br/>(YYYY-MM-DD)</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly name="inv_date" value="<?php echo $inv->{'inv_date'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Contract Number:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly name="inv_no" value="<?php echo $inv->{'inv_no'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Amount (metric ton):</label>
					  <div class="col-sm-9">
					  	
						<input type="text" readonly id="inv_amt" name="inv_amt" placeholder="number only"  value="<?php echo $inv->{'inv_amt'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Rate Per Metric Ton ($):</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="inv_unitprice" name="inv_unitprice" placeholder="number only" value="<?php echo $inv->{'inv_unitprice'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Total:</label>
					  <div class="col-sm-9">
					  
						<input type="text"  id="inv_total" readonly name="inv_total" value="<?php echo $inv->{'inv_total'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Period:<br/>(in months)</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly name="inv_period" placeholder="number only" value="<?php echo $inv->{'inv_period'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Amount:<br/>(numbers only)</label>
					  <div class="col-sm-9">
					  	
						<input type="text" readonly name="funding_amt" placeholder="number only" value="<?php echo $inv->{'funding_amt'};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee: <br/>(numbers only)</label>
					  <div class="col-sm-9">
					  	
						<input type="text" name="admin_fee" readonly  placeholder="number only" value="<?php echo $inv->{"admin_fee"};?>" class="form-control">
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Country:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="country" name="country"  class="form-control" value="<?php echo $inv->{'country'};?>"/>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Customer:</label>
					  <div class="col-sm-9">
					 <?php echo $inv->{'customer_name'};?>
					  	
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Manager:</label>
					  <div class="col-sm-9">
					
					 	
					 		<?php echo $inv->{'m_name'};?>
					  	
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Agent:</label>
					  <div class="col-sm-9">
							<?php echo $inv->{'agent_name'};?>
					  	
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Remarks:</label>
					  <div class="col-sm-9">
					  
						<textarea id="remarks" readonly name="remarks"  class="form-control"><?php echo $inv->{'remarks'};?></textarea>
					  </div>
					</div>
					<br/>
					
					<?php if ($this->session->userdata('user_type') != 'manager' && $this->session->userdata('user_type') != 'agent') {?>
					 <div class="header">
						<h3 class="content-header">
							Payment Mode
						  </h3>
				
						</div>
						
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 1:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="cheque_no" name="cheque_no"  class="form-control" value="<?php echo set_value('cheque_no', $inv->{'cheque_no'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Cheque No 2:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="cheque_no2" name="cheque_no2"  class="form-control" value="<?php echo set_value('cheque_no2', $inv->{'cheque_no2'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee Cheque No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="admin_cheque_no" name="admin_cheque_no"  class="form-control" value="<?php echo set_value('admin_cheque_no', $inv->{'admin_cheque_no'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding TT No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="tt_no" name="tt_no"  class="form-control" value="<?php echo set_value('tt_no', $inv->{'tt_no'});?>"/>
					  </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee TT No:</label>
					  <div class="col-sm-9">
					  
						<input type="text" readonly id="admin_tt_no" name="admin_tt_no"  class="form-control" value="<?php echo set_value('admin_tt_no', $inv->{'admin_tt_no'});?>"/>
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
					  	// 
// 						if (file_exists(AGREEMENT_PATH.$inv->{"inv_id"}.'.pdf')) 
// 							echo '<a href="'.AGREEMENT_URL.$inv->{"inv_id"}.'.pdf" target="_blank">Contract</a>';
// 						else
// 							echo '-';
						echo '<a href="'.base_url().'invoice/generateContract/?id='.$inv->{'inv_id'}.'" target="_blank">Contract</a>';
					 	?>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Customer Payout Schedule:</label>
					  <div class="col-sm-9">
					  	<?php
					  
// 						if (file_exists(PAYOUT_PATH.$inv->{"inv_id"}.'.pdf')) 
							echo '<a href="'.base_url().'invoice/generatePayout/?id='.$inv->{'inv_id'}.'" target="_blank">Customer Payout Schedule</a>';
// 						else
// 							echo '-';
					 	?>
					   </div>
					</div>
					<?php } ?>
					<?php
					if($this->session->userdata('user_type') == 'admin') {
					?>
					<div class="form-group">
					
					  <div class="col-sm-12">
					 	 <?php
					  
							echo '<a href="'.base_url().'invoice/emailFunder/?id='.$inv->{'inv_id'}.'" target="_blank">Click here to RE-SEND email receipts to funder.</a> (Note * Receipts are automatically sent when a new contract is added)';
// 						else
// 							echo '-';
					 		
					 	?>
					   </div>
					</div>
					<?php } ?>
					<?php if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'customer') {?>
					
					
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Funding Receipt:</label>
					  <div class="col-sm-9">
					 	 <?php
					  
// 						if (file_exists(RISK_PATH.$inv->{"inv_id"}.'.pdf')) 
							echo '<a href="'.base_url().'invoice/generateFundingReceipt/?id='.$inv->{'inv_id'}.'" target="_blank">Funding Receipt</a>';
// 						else
// 							echo '-';
					 		
					 	?>
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Admin Fee Receipt:</label>
					  <div class="col-sm-9">
					 	 <?php
					  
// 						if (file_exists(RISK_PATH.$inv->{"inv_id"}.'.pdf')) 
							echo '<a href="'.base_url().'invoice/generateAdminReceipt/?id='.$inv->{'inv_id'}.'" target="_blank">Admin Fee Receipt</a>';
// 						else
// 							echo '-';
					 		
					 	?>
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">Risk Assessment:</label>
					  <div class="col-sm-9">
					 	 <?php
					  
// 						if (file_exists(RISK_PATH.$inv->{"inv_id"}.'.pdf')) 
							echo '<a href="'.base_url().'invoice/generateRisk/?id='.$inv->{'inv_id'}.'" target="_blank">Risk Assesment</a>';
// 						else
// 							echo '-';
					 		
					 	?>
					   </div>
					</div>
					
					<div class="form-group">
					  <label class="col-sm-3 control-label">IRAS Certificate:</label>
					  <div class="col-sm-9">
					 	<?php
					  	if ($inv->{'iras'} != '' && $inv->{'iras'} != null) {
					 		echo '<a href="'.IRAS_URL.$inv->{"iras"}.'" target="_blank">IRAS Certificate</a>';
					 	}
					 	else
					 		echo '-';
					 	?>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Bank Record:</label>
					  <div class="col-sm-9">
					 	<?php
					  	if ($inv->{'bank_record'} != '' && $inv->{'bank_record'} != null) {
					 		echo '<a href="'.BANK_URL.$inv->{"bank_record"}.'" target="_blank">Bank Record</a>';
					 	}
					 	else
					 		echo '-';
					 	?>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">NRIC:</label>
					  <div class="col-sm-9">
					 	<?php
					  	if ($inv->{'nric'} != '' && $inv->{'nric'} != null) {
					 		echo '<a href="'.NRIC_URL.$inv->{"nric"}.'" target="_blank">NRIC</a>';
					 	}
					 	else
					 		echo '-';
					 	?>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Worksheet:</label>
					  <div class="col-sm-9">
					 	<?php
					  	if ($inv->{'worksheet'} != '' && $inv->{'worksheet'} != null) {
					 		echo '<a href="'.WORKSHEET_URL.$inv->{"worksheet"}.'" target="_blank">Worksheet</a>';
					 	}
					 	else
					 		echo '-';
					 	?>
					   </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Comfort Letter:</label>
					  <div class="col-sm-9">
					 	<?php
					  	if ($inv->{'comfort_letter'} != '' && $inv->{'comfort_letter'} != null) {
					 		echo '<a href="'.COMFORT_URL.$inv->{"comfort_letter"}.'" target="_blank">Comfort Letter</a>';
					 	}
					 	else
					 		echo '-';
					 	?>
					   </div>
					</div>
					<?php }?>
					
					
					<?php if ($this->session->userdata('user_type') == 'admin') {?>
					
					<div class="bottom">
					 <a href="<?php echo base_url();?>invoice/editInvoice/?inv=<?php echo $inv->{'inv_id'};?>" class="btn btn-primary">Edit</a>
					</div>
					<?php }?>
				</form>
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
        
        
      </div>
      <?php if ($this->session->userdata('user_type') == 'admin') {?>
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
               				
               				 <?php if ($this->session->userdata('user_type') == 'admin') {?>
               				 <li class=""><a href="#profile" data-toggle="tab">Sales Payout</a></li>
               				  <?php }?>
               				 <?php if ($this->session->userdata('user_type') == 'admin') {?>
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
									  			  <th>Receipt</th>
												</tr>
											  </thead>
											  <tbody>
								 	 		<?php
								 	 		}
										echo '<tr>';
										echo '<td>'.$month.'</td>';
										
										
										echo '<td>'.date('Y-m-d', strtotime($client_payout[$i-1]->{'date'})).'</td>';
										
										//first 3 months
										if ($year == 1 && ($month <= 3)) {
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
										if ($year == 1 && ($month <= 3)) {
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
										if ($client_payout[$i-1]->{'pay_date'} != null) {
											echo '<td><a href="'.base_url().'invoice/generateClientPayoutReceipt/?id='.$_GET['inv'].'&pid='.$client_payout[$i-1]->{'id'}.'" target="_blank">Receipt</a></td>';
										}
										else
											echo '<td>-</td>';
										
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
							<?php if ($this->session->userdata('user_type') == 'admin') {?>
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
              	
              	</div> <!-- end portlets content --!>
              	
            </div><!-- end block web --!>
    
       	 </div><!-- end colum 9 --!>
       	 </div><!-- end row--!>
		
   	<?php }?>
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<?php
$this->load->view('footer.php');