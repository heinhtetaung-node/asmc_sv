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

<div id="main-content" ng-controller="customerlistctrl"> 
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
              <!--<form method="get" action="<?php //echo base_url();?>customer">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>-->
				<form method="get" action="<?php echo base_url();?>customer">
              		Search: <input type="text" name="search" ng-model="search" ng-change="filter()" placeholder="Filter" />
					<select ng-model="entryLimit" class="sel_entryLimit">
						<option ng-selected="true">20</option>
						<option>30</option>
						<option>50</option>
						<option>100</option>
						<option>200</option>
						<option>300</option>
						<option>500</option>
					</select>
              		<!--<input type="submit" class="btn btn-primary" value="Search" name="submit"/>-->
              	</form>
				<?php 
				$data['igcol']="0,10"; $data['pdfpage']="A4"; $data['pdfFontSize']="4"; $data['pdfspace']="20";
				$this->load->view('common/exporttable', $data); ?>
              	<br/>
             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
						<th>No.</th>
						<th ng-click="sortField = 'customer_name'; reverse = !reverse"><a href="">Name</a></th>
						<th ng-click="sortField = 'customer_username'; reverse = !reverse"><a href="">Username</a></th>
						<th ng-click="sortField = 'customer_email'; reverse = !reverse"><a href="">Email</a></th>
						<th ng-click="sortField = 'customer_nric'; reverse = !reverse"><a href="">NRIC</a></th>
						<th ng-click="sortField = 'customer_mobile'; reverse = !reverse"><a href="">Mobile</a></th>
						<th ng-click="sortField = 'customer_addr'; reverse = !reverse"><a href="">Address</a></th>
						<th ng-click="sortField = 'customer_dob'; reverse = !reverse"><a href="">D.O.B</a></th>
						<th ng-click="sortField = 'customer_login_date'; reverse = !reverse"><a href="">Last Login</a></th>
						<th ng-click="sortField = 'customer_created_date'; reverse = !reverse"><a href="">Created Date</a></th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody ng-init="getdatas(<?php echo htmlspecialchars(json_encode($customers,JSON_NUMERIC_CHECK)); ?>)">
					
					<?php
					// if (isset($customers) && count($customers) > 0) {
						// $page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						// $start = ($page - 1) * $per_page;
							
						// for ($i = 0; $i < count($customers); $i++) {
							// echo '<tr>';
							// echo '<td>'.($start+$i+1).'</td>';
							// echo '<td>'.$customers[$i]->{'customer_name'}.'</td>';
							// echo '<td>'.$customers[$i]->{'customer_username'}.'</td>';
							// echo '<td>'.$customers[$i]->{'customer_email'}.'</td>';
							// echo '<td>'.$customers[$i]->{'customer_nric'}.'</td>';
							// echo '<td>'.$customers[$i]->{'customer_mobile'}.'</td>';
							// echo '<td>'.$customers[$i]->{'customer_addr'}.'</td>';
							// echo '<td>';
							// if ($customers[$i]->{'customer_dob'} != null && $customers[$i]->{'customer_dob'} != '' && $customers[$i]->{'customer_dob'} != '0000-00-00')
								// echo $customers[$i]->{'customer_dob'};
							// else
								// echo '-';
							// echo '</td>';
							// echo '<td>';
								// if ($customers[$i]->{'customer_login_date'} != null)
									// echo date('Y-m-d H:i:s', strtotime($customers[$i]->{'customer_login_date'}));
								// else
									// echo '-';
							// echo '</td>';
							// echo '<td>'.date('Y-m-d', strtotime($customers[$i]->{'customer_created_date'})).'</td>';
							// echo '<td><a href="'.base_url().'customer/editCustomer/?id='.$customers[$i]->{'customer_id'}.'">Edit</a> | 
								// <a href="'.base_url().'customer/deleteCustomer/?id='.$customers[$i]->{'customer_id'}.'" onClick="return confirmDelete();">Delete</a></td>';
						// }
					// }
					?>
						<tr id="{{datas.dr_id}}" tr-id="{{datas.dr_id}}" ng-repeat="datas in filtered = (datas | filter:search | orderBy : sortField :reverse |  startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit) track by $index">
							<td>{{ $index+1 }}</td>
							<td>{{ datas.customer_name }}</td>
							<td>{{ datas.customer_username }}</td>
							<td>{{ datas.customer_email }}</td>
							<td>{{ datas.customer_nric }}</td>
							<td>{{ datas.customer_mobile }}</td>
							<td>{{ datas.customer_addr }}</td>
							<td class="datetd">{{ convertToDate(datas.customer_dob) | date:'dd-MMM-yyyy' }}</td>
							<td class="datetd">{{ convertToDate(datas.customer_login_date) | date:'dd-MMM-yyyy' }}</td>
							<td class="datetd">{{ convertToDate(datas.customer_created_date) | date:'dd-MMM-yyyy' }}</td>
							<td>
								<a href="<?php echo base_url(); ?>customer/editCustomer/?id={{datas.customer_id}}">Edit</a> | 
								<a href="<?php echo base_url(); ?>customer/deleteCustomer/?id={{datas.customer_id}}" onclick="return confirmDelete();">Delete</a>
							</td>
						</tr>
					</tbody>
				</table>
				<a href=""><div pagination="" page="currentPage" max-size="4" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;"	 next-text="&raquo;"></div></a><br>
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