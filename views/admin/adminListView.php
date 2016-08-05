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

<div id="main-content" ng-controller="adminlistctrl"> 
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
              	<form method="get" action="<?php echo base_url();?>admin">
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
				<?php $data['igcol']="0,5"; $data['pdfpage']="A4"; $this->load->view('common/exporttable', $data); ?>
              	<br/>
             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
						<th>No.</th>
						<th ng-click="sortField = 'admin_name'; reverse = !reverse"><a href="">Name</a></th>
						<th ng-click="sortField = 'admin_email'; reverse = !reverse"><a href="">Email</a></th>
						<th ng-click="sortField = 'admin_login_date'; reverse = !reverse"><a href="">Last Login</a></th>
						<th ng-click="sortField = 'admin_created_date'; reverse = !reverse"><a href="">Created Date</a></th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody ng-init="getdatas(<?php echo htmlspecialchars(json_encode($admins,JSON_NUMERIC_CHECK)); ?>)">
					
					<?php
					// if (isset($admins) && count($admins) > 0) {
						// $page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						// $start = ($page - 1) * $per_page;
							
						// for ($i = 0; $i < count($admins); $i++) {
							
							// echo '<tr>';
							// echo '<td>'.($start+$i+1).'</td>';
							// echo '<td>'.$admins[$i]->{'admin_name'}.'</td>';
							// echo '<td>'.$admins[$i]->{'admin_email'}.'</td>';
							// echo '<td>';
								// if ($admins[$i]->{'admin_login_date'} != null)
									// echo date('Y-m-d H:i:s', strtotime($admins[$i]->{'admin_login_date'}));
								// else
									// echo '-';
							// echo '</td>';
							// echo '<td>'.date('Y-m-d', strtotime($admins[$i]->{'admin_created_date'})).'</td>';
							// echo '<td><a href="'.base_url().'admin/editAdmin/?id='.$admins[$i]->{'admin_id'}.'">Edit</a> | 
								// <a href="'.base_url().'admin/deleteAdmin/?id='.$admins[$i]->{'admin_id'}.'" onClick="return confirmDelete();">Delete</a></td>';
						// }
					// }
					?>
					
						<tr id="{{datas.admin_id}}" tr-id="{{datas.admin_id}}" ng-repeat="datas in filtered = (datas | filter:search | orderBy : sortField :reverse |  startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit) track by $index">
							<td>{{ $index+1 }}</td>
							<td>{{ datas.admin_name }}</td>
							<td>{{ datas.admin_email }}</td>
							<td>{{ convertToDate(datas.admin_login_date) | date:'dd-MMM-yyyy h:mma' }}</td>
							<td>{{ convertToDate(datas.admin_created_date) | date:'dd-MMM-yyyy h:mma' }}</td>
							<td>
								<a href="<?php echo base_url(); ?>admin/editAdmin/?id={{datas.admin_id}}">Edit</a> | 
								<a href="<?php echo base_url(); ?>admin/deleteAdmin/?id={{datas.admin_id}}" onclick="return confirmDelete();">Delete</a>
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