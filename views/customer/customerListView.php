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
              <form method="get" action="<?php echo base_url();?>customer">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>
              	<br/>
             	<table class="table table-bordered">
					<thead>
					<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Username</th>
						<th>Email</th>
						<th>NRIC</th>
						<th>Mobile</th>
						<th>Address</th>
						<th>D.O.B</th>
						<th>Last Login</th>
						<th>Created Date</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					
					<?php
					if (isset($customers) && count($customers) > 0) {
						$page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						$start = ($page - 1) * $per_page;
							
						for ($i = 0; $i < count($customers); $i++) {
							echo '<tr>';
							echo '<td>'.($start+$i+1).'</td>';
							echo '<td>'.$customers[$i]->{'customer_name'}.'</td>';
							echo '<td>'.$customers[$i]->{'customer_username'}.'</td>';
							echo '<td>'.$customers[$i]->{'customer_email'}.'</td>';
							echo '<td>'.$customers[$i]->{'customer_nric'}.'</td>';
							echo '<td>'.$customers[$i]->{'customer_mobile'}.'</td>';
							echo '<td>'.$customers[$i]->{'customer_addr'}.'</td>';
							echo '<td>';
							if ($customers[$i]->{'customer_dob'} != null && $customers[$i]->{'customer_dob'} != '' && $customers[$i]->{'customer_dob'} != '0000-00-00')
								echo $customers[$i]->{'customer_dob'};
							else
								echo '-';
							echo '</td>';
							echo '<td>';
								if ($customers[$i]->{'customer_login_date'} != null)
									echo date('Y-m-d H:i:s', strtotime($customers[$i]->{'customer_login_date'}));
								else
									echo '-';
							echo '</td>';
							echo '<td>'.date('Y-m-d', strtotime($customers[$i]->{'customer_created_date'})).'</td>';
							echo '<td><a href="'.base_url().'customer/editCustomer/?id='.$customers[$i]->{'customer_id'}.'">Edit</a> | 
								<a href="'.base_url().'customer/deleteCustomer/?id='.$customers[$i]->{'customer_id'}.'" onClick="return confirmDelete();">Delete</a></td>';
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