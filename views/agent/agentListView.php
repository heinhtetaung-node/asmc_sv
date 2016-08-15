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

<div id="main-content" ng-controller="agentlistctrl"> 
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
              <!--<form method="get" action="<?php //echo base_url();?>agent">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>-->
				<form method="get" action="<?php echo base_url();?>agent">
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
				<?php $data['igcol']="0,7"; $data['pdfpage']="A4"; $this->load->view('common/exporttable', $data); ?>
              	<br/>
             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
						<th>No.</th>
						<th ng-click="sortField = 'agent_name'; reverse = !reverse"><a href="">Name</a></th>
						<th ng-click="sortField = 'agent_email'; reverse = !reverse"><a href="">Email</a></th>
						<?php if ($this->session->userdata('user_type') != 'manager') { ?>
						<th ng-click="sortField = 'agent_code'; reverse = !reverse"><a href="">Agent Code</a></th>
						<th ng-click="sortField = 'm_name'; reverse = !reverse"><a href="">Manager</a></th>
						<?php } ?>
						<th ng-click="sortField = 'agent_login_date'; reverse = !reverse"><a href="">Last Login</a></th>
						<th ng-click="sortField = 'agent_created_date'; reverse = !reverse"><a href="">Created Date</a></th>
						<!--<th>Status</th>-->
						<?php
						//if ($this->session->userdata('user_type') == 'admin') {?>
							<th>Action</th>
						<?php //}?>
					</tr>
					</thead>
					<tbody ng-init="getdatas(<?php echo htmlspecialchars(json_encode($agents,JSON_NUMERIC_CHECK)); ?>)">
					
					<?php
					// if (isset($agents) && count($agents) > 0) {
						// $page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						// $start = ($page - 1) * $per_page;
							
						// for ($i = 0; $i < count($agents); $i++) {
							// echo '<tr>';
							// echo '<td>'.($start+$i+1).'</td>';
							// echo '<td>'.$agents[$i]->{'agent_name'}.'</td>';
							// echo '<td>'.$agents[$i]->{'agent_email'}.'</td>';
							// echo '<td>'.$agents[$i]->{'agent_code'}.'</td>';
							// echo '<td>'.$agents[$i]->{'m_name'}.' ('.$agents[$i]->{"m_code"}.')</td>';
							// echo '<td>';
								// if ($agents[$i]->{'agent_login_date'} != null)
									// echo date('Y-m-d H:i:s', strtotime($agents[$i]->{'agent_login_date'}));
								// else
									// echo '-';
							// echo '</td>';
							// echo '<td>'.date('Y-m-d', strtotime($agents[$i]->{'agent_created_date'})).'</td>';
							// if ($this->session->userdata('user_type') == 'admin') {
								// echo '<td><a href="'.base_url().'agent/editAgent/?id='.$agents[$i]->{'agent_id'}.'">Edit</a> | 
								// <a href="'.base_url().'agent/deleteAgent/?id='.$agents[$i]->{'agent_id'}.'" onClick="return confirmDelete();">Delete</a></td>';
							// }
						// }
					// }
					?>
						<tr id="{{datas.agent_id}}" tr-id="{{datas.agent_id}}" ng-repeat="datas in filtered = (datas | filter:search | orderBy : sortField :reverse |  startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit) track by $index">
							<td>{{ $index+1 }}</td>
							<td>{{ datas.agent_name }}</td>
							<td>{{ datas.agent_email }}</td>
							<?php if ($this->session->userdata('user_type') != 'manager') { ?>
							<td>{{ datas.agent_code }}</td>
							<td>{{ datas.m_name }}</td>
							<?php } ?>
							<td>{{ convertToDate(datas.agent_login_date) | date:'dd-MMM-yyyy h:mma' }}</td>
							<td>{{ convertToDate(datas.agent_created_date) | date:'dd-MMM-yyyy h:mma' }}</td>
							<!--<td>
								<input class="status" type="checkbox" checked='{{ (datas.active==1)? "checked" : "" }}' data-size="mini" data-toggle="toggle" data-on="Active" data-off="Disable">
							</td>-->
							
							<td>
								<a href="<?php echo base_url(); ?>agent/editAgent/?id={{datas.agent_id}}">Edit</a>  
								<?php if ($this->session->userdata('user_type') == 'admin') { ?>
								|
								<a href="<?php echo base_url(); ?>agent/deleteAgent/?id={{datas.agent_id}}" onclick="return confirmDelete();">Delete</a>
								<?php } ?>
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