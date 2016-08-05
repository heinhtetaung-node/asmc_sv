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
             		Commissions
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
              		 <div class="tab-container">
             		 	<ul class="nav nav-tabs">
               				  <li class="active"><a href="#sales" data-toggle="tab">Sales Payout</a></li>
               			</ul>
						  <div class="tab-content">
							<div class="tab-pane cont active" id="sales">
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
				 				
				  
							</div>
						  </div>
           			 </div>
              	
              	</div> <!-- end portlets content --!>
              	
            </div><!-- end block web --!>
    
       	 </div><!-- end colum 9 --!>
       	 </div><!-- end row--!>
	
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<?php
$this->load->view('footer.php');