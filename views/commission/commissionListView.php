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
				<form method="get" action="<?php echo base_url();?>commission">
					
					<?php $search=""; if(isset($_GET['search'])){ $search=$_GET['search']; }  ?>
					
              		Search: <input type="text" name="search" placeholder="Filter" value="<?php echo $search; ?>" />
					<?php 
					$agent_search_display="";
					if($this->session->userdata('user_type')=="agent" || $this->session->userdata('user_type')=="customer"){ 
						$agent_search_display="display:none;";
					}
					?>
					<select name="agent_search" class="agent_search" style="<?php echo $agent_search_display; ?>">
						<option value="">Select Agent</option>
						<?php
						for ($i = 0; $i < count($agents); $i++) {
							$selected="";
							if(isset($_GET['agent_search'])){ if($_GET['agent_search']==$agents[$i]->agent_id){ $selected='selected'; } }
							echo "<option ".$selected." value='".$agents[$i]->agent_id."'>".$agents[$i]->agent_name."</option>";
						}
						?>
					</select>
					
					<?php 
					$funder_search_display="";
					if($this->session->userdata('user_type')!="agent" && $this->session->userdata('user_type')!="customer"){ 
						$funder_search_display="display:none;";
					}
					?>
					<select name="funder_search" class="funder_search" style="<?php echo $funder_search_display; ?>">
						<option value="">Select Funder</option>
						<?php
						for ($i = 0; $i < count($funders); $i++) {
							$selected="";
							if(isset($_GET['funder_search'])){ if($_GET['funder_search']==$funders[$i]->customer_id){ $selected='selected'; } }
							echo "<option ".$selected." value='".$funders[$i]->customer_id."'>".$funders[$i]->customer_name."</option>";
						}
						?>
					</select>
					
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>
             <?php
             $total_comm = 0;
             ?>
				<?php $data['igcol']=""; $data['pdfFontSize']="4"; $data['pdfspace']="20"; $data['pdfpage']="A4"; $this->load->view('common/exporttable', $data); ?>
				<br>
             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
						<th>Contract No.</th>
						<th>Contract Date</th>
						
						
						<th>Funder</th>
						<?php if($this->session->userdata('user_type')!="agent"){ ?>
								<th>Agent</th>
						<?php } ?>
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
							if($this->session->userdata('user_type')!="agent"){
								echo '<td>'.$invoices[$i]->{'agent_name'}.'</td>';
							}
							echo '<td>$'.number_format($invoices[$i]->{'inv_total'},2).'</td>';
							
							if ($group == 'manager') {
								if ($this->Commision_model->checkIsInvoiceTransferred($invoices[$i]->{'inv_id'}, $invoices[$i]->{'m_id'}, 1))
									echo '<td>-</td>';
								else {
									echo '<td>$'.number_format($percent * $invoices[$i]->{'inv_total'},2).'</td>';
									$total_comm += $percent * $invoices[$i]->{'inv_total'};	
								}
							
							}
							else if ($group == 'agent') {
								if ($this->Commision_model->checkIsInvoiceTransferred($invoices[$i]->{'inv_id'}, $invoices[$i]->{'agent_id'}, 1))
									echo '<td>-</td>';
								else {
									echo '<td>$'.number_format($percent * $invoices[$i]->{'inv_total'},2).'</td>';
									$total_comm += $percent * $invoices[$i]->{'inv_total'};	
								}
							
							}
							
							echo '<td>$'.number_format($invoices[$i]->{'inv_amt'},2).'</td>';
// 							echo '<td><a href="'.base_url().'commission/viewComm/?inv='.$invoices[$i]->{'inv_id'}.'">View Comm</a></td>';
							
							for ($k =0; $k <count($dates); $k++) {
								if ($group == 'manager') {
									if (isset($invoices[$i]->{'m_payouts'}[$dates[$k]])) {
										echo '<td>$'.number_format($invoices[$i]->{'m_payouts'}[$dates[$k]],2).'</td>';
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
										echo '<td>$'.number_format($invoices[$i]->{'s_payouts'}[$dates[$k]],2).'</td>';
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
							echo '<td>$'.number_format($ttl,2).'</td>';
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
<script>
	$(document).ready(function(e){
		
	});
</script>

<?php
$this->load->view('footer.php');