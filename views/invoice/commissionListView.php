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
             
             	<table class="table table-bordered">
					<thead>
					<tr>
						<th>Invoice No.</th>
						<th>Invoice Date</th>
						
						
						<th>Customer</th>
						<th>Agent</th>
						<th>Invoice Amount</th>
						<th>Commision (<?php echo $percent * 100;?>%)</th>
						
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
							echo '<td>'.$invoices[$i]->{'customer_name'}.'</td>';
							echo '<td>'.$invoices[$i]->{'agent_name'}.'</td>';
							echo '<td>$'.number_format($invoices[$i]->{'inv_total'}).'</td>';
							echo '<td>$'.number_format($percent * $invoices[$i]->{'inv_total'}).'</td>';
							
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