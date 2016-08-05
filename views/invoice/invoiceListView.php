<?php 
$this->load->view('header');
$this->load->view('navbar');
$this->load->view('sidebar');
?>

<script  type="text/javascript">
function confirmDelete() {
      var confirmed = confirm("Are you sure? This will remove this entry forever.");
      return confirmed;
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
        <div class="col-md-12">
          <div class="block-web">
            
            <div class="header">
              <div class="actions"> </div>
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
              <?php 
              if ($this->session->userdata('user_type') == 'customer') {?>
            
              	 <form method="get" action="<?php echo base_url();?>customerinv">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>
              <?php } else {?>
                <form method="get" action="<?php echo base_url();?>invoice">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>
              <?php } ?>
              	<br/>

             	<table class="table table-bordered">
					<thead>
					<tr>
						<th>Contract No.</th>
						<th>Contract Date</th>
						<th>Funding Amt</th>
						<th>Start Payout</th>
						<th>End Payout</th>
						<th>Customer</th>
						<th>Manager</th>
						<th>Agent</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					
					<?php
					if (isset($invoices) && count($invoices) > 0) {
						$page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						$start = ($page - 1) * $per_page;
							
						for ($i = 0; $i < count($invoices); $i++) {
							echo '<tr>';
							
							echo '<td>'.$invoices[$i]->{'inv_no'}.'</td>';
							echo '<td>'.$invoices[$i]->{'inv_date'}.'</td>';
							echo '<td>$'.number_format($invoices[$i]->{'inv_total'},2,'.',',').'</td>';
							echo '<td>'.date('d-M-Y', strtotime($invoices[$i]->{'payout'}->{'min'})).'</td>';
							echo '<td>'.date('d-M-Y', strtotime($invoices[$i]->{'payout'}->{'max'})).'</td>';
							echo '<td>'.$invoices[$i]->{'customer_name'}.'</td>';
							
							echo '<td>'.$invoices[$i]->{'m_name'}.'</td>';
							echo '<td>'.$invoices[$i]->{'agent_name'}.'</td>';
								
							echo '<td>'.date('Y-m-d', strtotime($invoices[$i]->{'inv_created_date'})).'</td>';
							echo '<td><a href="'.base_url().'invoice/viewInvoice/?inv='.$invoices[$i]->{'inv_id'}.'">View</a>';
							if ($this->session->userdata('user_type') == 'admin') 
							echo ' | 
								<a href="'.base_url().'invoice/editInvoice/?inv='.$invoices[$i]->{'inv_id'}.'">Edit</a> | 
								<a href="'.base_url().'invoice/deleteInvoice/?inv='.$invoices[$i]->{'inv_id'}.'" onClick="return confirmDelete();">Delete</a>';
								
							echo '</td>';
							echo '</tr>';
						}
					}
					?>
					</tbody>
				</table>
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