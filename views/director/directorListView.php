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

<div id="main-content" ng-controller="directorlistctrl"> 
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
              <!--<form method="get" action="<?php //echo base_url();?>director">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>-->
				<form method="get" action="<?php echo base_url();?>director">
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
				<?php $data['igcol']="0,6"; $data['pdfpage']="A4"; $this->load->view('common/exporttable', $data); ?>
              	<br/>
             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
						<th>No.</th>
						<th ng-click="sortField = 'dr_name'; reverse = !reverse"><a href="">Name</a></th>
						<th ng-click="sortField = 'dr_email'; reverse = !reverse"><a href="">Email</a></th>
						<th ng-click="sortField = 'dr_code'; reverse = !reverse"><a href="">Director Code</a></th>
						<th ng-click="sortField = 'dr_login_date'; reverse = !reverse"><a href="">Last Login</a></th>
						<th ng-click="sortField = 'dr_created_date'; reverse = !reverse"><a href="">Created Date</a></th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody ng-init="getdatas(<?php echo htmlspecialchars(json_encode($directors,JSON_NUMERIC_CHECK)); ?>)">
					 
					<?php
					// if (isset($directors) && count($directors) > 0) {
						// $page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						// $start = ($page - 1) * $per_page;
							
						// for ($i = 0; $i < count($directors); $i++) {
							// echo '<tr>';
							// echo '<td>'.($start+$i+1).'</td>';
							// echo '<td>'.$directors[$i]->{'dr_name'}.'</td>';
							// echo '<td>'.$directors[$i]->{'dr_email'}.'</td>';
							// echo '<td>'.$directors[$i]->{'dr_code'}.'</td>';
							// echo '<td>';
								// if ($directors[$i]->{'dr_login_date'} != null)
									// echo date('Y-m-d H:i:s', strtotime($directors[$i]->{'dr_login_date'}));
								// else
									// echo '-';
							// echo '</td>';
							// echo '<td>'.date('Y-m-d', strtotime($directors[$i]->{'dr_created_date'})).'</td>';
							// echo '<td><a href="'.base_url().'director/editDirector/?id='.$directors[$i]->{'dr_id'}.'">Edit</a> | 
								// <a href="'.base_url().'director/deleteDirector/?id='.$directors[$i]->{'dr_id'}.'" onClick="return confirmDelete();">Delete</a></td>';
						// }
					// }
					?>
						<tr id="{{datas.dr_id}}" tr-id="{{datas.dr_id}}" ng-repeat="datas in filtered = (datas | filter:search | orderBy : sortField :reverse |  startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit) track by $index">
							<td>{{ $index+1 }}</td>
							<td>{{ datas.dr_name }}</td>
							<td>{{ datas.dr_email }}</td>
							<td>{{ datas.dr_code }}</td>
							<td>{{ convertToDate(datas.dr_login_date) | date:'dd-MMM-yyyy h:mma' }}</td>
							<td>{{ convertToDate(datas.dr_created_date) | date:'dd-MMM-yyyy h:mma' }}</td>
							<td>
								<a href="<?php echo base_url(); ?>director/editDirector/?id={{datas.dr_id}}">Edit</a> | 
								<a href="<?php echo base_url(); ?>director/deleteDirector/?id={{datas.dr_id}}" onclick="return confirmDelete();">Delete</a>
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