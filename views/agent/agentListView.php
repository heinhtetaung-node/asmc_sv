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
              <form method="get" action="<?php echo base_url();?>agent">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>
              	<br/>
             	<table class="table table-bordered">
					<thead>
					<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Email</th>
						<th>Agent Code</th>
						<th>Manager</th>
						<th>Last Login</th>
						<th>Created Date</th>
						<?php
						if ($this->session->userdata('user_type') == 'admin') {?>
							<th>Action</th>
						<?php }?>
					</tr>
					</thead>
					<tbody>
					
					<?php
					if (isset($agents) && count($agents) > 0) {
						$page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						$start = ($page - 1) * $per_page;
							
						for ($i = 0; $i < count($agents); $i++) {
							echo '<tr>';
							echo '<td>'.($start+$i+1).'</td>';
							echo '<td>'.$agents[$i]->{'agent_name'}.'</td>';
							echo '<td>'.$agents[$i]->{'agent_email'}.'</td>';
							echo '<td>'.$agents[$i]->{'agent_code'}.'</td>';
							echo '<td>'.$agents[$i]->{'m_name'}.' ('.$agents[$i]->{"m_code"}.')</td>';
							echo '<td>';
								if ($agents[$i]->{'agent_login_date'} != null)
									echo date('Y-m-d H:i:s', strtotime($agents[$i]->{'agent_login_date'}));
								else
									echo '-';
							echo '</td>';
							echo '<td>'.date('Y-m-d', strtotime($agents[$i]->{'agent_created_date'})).'</td>';
							if ($this->session->userdata('user_type') == 'admin') {
								echo '<td><a href="'.base_url().'agent/editAgent/?id='.$agents[$i]->{'agent_id'}.'">Edit</a> | 
								<a href="'.base_url().'agent/deleteAgent/?id='.$agents[$i]->{'agent_id'}.'" onClick="return confirmDelete();">Delete</a></td>';
							}
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