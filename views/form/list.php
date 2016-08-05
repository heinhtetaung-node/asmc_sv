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
              
              	 <form method="get" action="<?php echo base_url();?>form/viewRecords">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>
             
              	<br/>

             	<table class="table table-bordered">
					<thead>
					<tr>
						<th>Booking Ref No.</th>
						<th>Date</th>
						<th>Name</th>
						<th>NRIC</th>
						<th>Mobile</th>
						<th>Funding Amt.</th>
						<th>Status</th>
<!-- 						<th>Created Date</th> -->
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					
					<?php
					if (isset($forms) && count($forms) > 0) {
						
						for ($i = 0; $i < count($forms); $i++) {
							echo '<tr>';
							
							echo '<td>'.$forms[$i]->{'booking_ref_no'}.'</td>';
							echo '<td>'.date('d-M-Y', strtotime($forms[$i]->{'form_date'})).'</td>';
							echo '<td>'.$forms[$i]->{'name'}.'</td>';
							echo '<td>'.$forms[$i]->{'nric'}.'</td>';
							echo '<td>'.$forms[$i]->{'mobile'}.'</td>';
							echo '<td>'.$forms[$i]->{'funding_amt'}.'</td>';
							
// 							echo '<td>'.date('Y-m-d', strtotime($forms[$i]->{'form_created_date'})).'</td>';
							echo '<td>';
							$inv = $this->Invoice_model->getInvoiceForForm($forms[$i]->{'f_id'});
							
							if (count($inv) == 0) {
								echo '<span class="label label-warning">Pending</span>';
							}
							else {
								echo '<span class="label label-success">Approved</span>';
							}
							echo '</td>';
							echo '<td><a href="'.base_url().'invoice/addFromForm/?id='.$forms[$i]->{'f_id'}.'">Edit</a> | 
								<a href="'.base_url().'form/deleteRecord/?id='.$forms[$i]->{'f_id'}.'" onClick="return confirmDelete();">Delete</a>';
								
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