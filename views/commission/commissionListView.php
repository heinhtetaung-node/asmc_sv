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
        <div class="col-md-12">
          <div class="block-web">
            
            <div class="header">
              <div class="actions"> </div>
              <h3 class="content-header">
             	<?php echo $subtitle;?>
              </h3>
            </div>
            
            <div class="porlets-content" style="overflow-x:scroll">
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
             <?php
             $total_comm = 0;
             ?>
             	<table class="table table-bordered">
					<thead>
					<tr>
						<th>Invoice No.</th>
						<th>Invoice Date</th>
						
						
						<th>Customer</th>
						<th>Agent</th>
						<th>Funding Amount</th>
						<th>Commissions 
<!-- 						(<?php echo $percent * 100;?>%) -->
						</th>
<!-- 						<th>View</th> -->
						<th>Tonnage</th>
						<?php for ($i =0; $i <count($dates); $i++) {
							echo '<th>'.$dates[$i].'</th>';
						}
						?>
					</tr>
					</thead>
					<tbody>
					
					<?php
					
					if (isset($invoices) && count($invoices) > 0) {
						$page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						$start = ($page - 1) * $per_page;
							
						$total_comm_per_date = array();
						
						for ($i = 0; $i < count($invoices); $i++) {
							echo '<tr>';
							
							echo '<td>'.$invoices[$i]->{'inv_no'}.'</td>';
							echo '<td>'.$invoices[$i]->{'inv_date'}.'</td>';
							echo '<td>'.$invoices[$i]->{'customer_name'}.'</td>';
							echo '<td>'.$invoices[$i]->{'agent_name'}.'</td>';
							echo '<td>$'.number_format($invoices[$i]->{'inv_total'}).'</td>';
							
							if ($group == 'manager') {
								if ($this->Commision_model->checkIsInvoiceTransferred($invoices[$i]->{'inv_id'}, $invoices[$i]->{'m_id'}, 1))
									echo '<td>-</td>';
								else {
									echo '<td>$'.number_format($percent * $invoices[$i]->{'inv_total'}).'</td>';
									$total_comm += $percent * $invoices[$i]->{'inv_total'};	
								}
							
							}
							else if ($group == 'agent') {
								if ($this->Commision_model->checkIsInvoiceTransferred($invoices[$i]->{'inv_id'}, $invoices[$i]->{'agent_id'}, 1))
									echo '<td>-</td>';
								else {
									echo '<td>$'.number_format($percent * $invoices[$i]->{'inv_total'}).'</td>';
									$total_comm += $percent * $invoices[$i]->{'inv_total'};	
								}
							
							}
							
							echo '<td>'.$invoices[$i]->{'inv_amt'}.'</td>';
// 							echo '<td><a href="'.base_url().'commission/viewComm/?inv='.$invoices[$i]->{'inv_id'}.'">View Comm</a></td>';
							
							for ($k =0; $k <count($dates); $k++) {
								if ($group == 'manager') {
									if (isset($invoices[$i]->{'m_payouts'}[$dates[$k]])) {
										echo '<td>'.$invoices[$i]->{'m_payouts'}[$dates[$k]].'</td>';
										if (isset($total_comm_per_date[$dates[$k]]))
											$total_comm_per_date[$dates[$k]] += $invoices[$i]->{'m_payouts'}[$dates[$k]];
										else
											$total_comm_per_date[$dates[$k]] = $invoices[$i]->{'m_payouts'}[$dates[$k]];
									}
									else
										echo '<td>-</td>';
										
									
								}
								else if ($group == 'agent') {
									if (isset($invoices[$i]->{'s_payouts'}[$dates[$k]])) {
										echo '<td>'.$invoices[$i]->{'s_payouts'}[$dates[$k]].'</td>';
										if (isset($total_comm_per_date[$dates[$k]]))
										$total_comm_per_date[$dates[$k]] += $invoices[$i]->{'s_payouts'}[$dates[$k]];	
										else
										$total_comm_per_date[$dates[$k]] = $invoices[$i]->{'s_payouts'}[$dates[$k]];	
									}
									else
										echo '<td>-</td>';
										
									

								}
									
							}
							
						}
					}
					?>
					
					<tr>
						<td colspan="7" style="text-align:right">Monthly Tonnage Total:</td>
						<?php
						for ($k =0; $k <count($dates); $k++) {
							$ttl = isset($total_comm_per_date[$dates[$k]]) ? $total_comm_per_date[$dates[$k]] : 0;
							echo '<td>'.$ttl.'</td>';
						}
						?>
						
					</tr>
					</tbody>
				</table>
				<p><b><?php echo 'Total Commision: $'.number_format($total_comm,2,'.',',');?></b></p>
				<?php echo $this->pagination->create_links(); ?>
		
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<?php
$this->load->view('footer.php');