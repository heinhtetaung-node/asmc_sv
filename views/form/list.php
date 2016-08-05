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

<div id="main-content" ng-controller="formlistctrl">  
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
              
              	 <!--<form method="get" action="<?php //echo base_url();?>form/viewRecords">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>-->
				<form method="get" action="<?php echo base_url();?>form/viewRecords">
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
				$data['igcol']="7"; $data['pdfpage']="A4"; 
				$this->load->view('common/exporttable', $data); ?>
              	<br/>

             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
					<?php if($this->session->userdata('user_type')=="admin"){ ?>
						<th ng-click="sortField = 'booking_ref_no'; reverse = !reverse"><a href="">Booking Ref No.</th>
					<?php } ?>
						<th ng-click="sortField = 'form_date'; reverse = !reverse"><a href="">Date</th>
						<th ng-click="sortField = 'name'; reverse = !reverse"><a href="">Name</th>
						<th ng-click="sortField = 'nric'; reverse = !reverse"><a href="">NRIC</th>
						<th ng-click="sortField = 'mobile'; reverse = !reverse"><a href="">Mobile</th>
						<th ng-click="sortField = 'funding_amt'; reverse = !reverse"><a href="">Funding Amt.</th>
						<th ng-click="sortField = 'inv_status'; reverse = !reverse"><a href="">Status</th>
<!-- 						<th>Created Date</th> -->
						<th>Action</th>
					</tr>
					</thead>
					<tbody ng-init="getdatas(<?php echo htmlspecialchars(json_encode($forms,JSON_NUMERIC_CHECK)); ?>)">
					
					<?php
					// if (isset($forms) && count($forms) > 0) {
						
						// for ($i = 0; $i < count($forms); $i++) {
							// echo '<tr>';
							
							// echo '<td>'.$forms[$i]->{'booking_ref_no'}.'</td>';
							// echo '<td>'.date('d-M-Y', strtotime($forms[$i]->{'form_date'})).'</td>';
							// echo '<td>'.$forms[$i]->{'name'}.'</td>';
							// echo '<td>'.$forms[$i]->{'nric'}.'</td>';
							// echo '<td>'.$forms[$i]->{'mobile'}.'</td>';
							// echo '<td>'.$forms[$i]->{'funding_amt'}.'</td>';
							
// // 							echo '<td>'.date('Y-m-d', strtotime($forms[$i]->{'form_created_date'})).'</td>';
							// echo '<td>';
							// $inv = $this->Invoice_model->getInvoiceForForm($forms[$i]->{'f_id'});
							
							// if (count($inv) == 0) {
								// echo '<span class="label label-warning">Pending</span>';
							// }
							// else {
								// echo '<span class="label label-success">Approved</span>';
							// }
							// echo '</td>';
							// echo '<td><a href="'.base_url().'invoice/addFromForm/?id='.$forms[$i]->{'f_id'}.'">Edit</a> | 
								// <a href="'.base_url().'form/deleteRecord/?id='.$forms[$i]->{'f_id'}.'" onClick="return confirmDelete();">Delete</a>';
								
							// echo '</td>';
							// echo '</tr>';
						// }
					// }
					?>
						<tr id="{{datas.dr_id}}" tr-id="{{datas.dr_id}}" ng-repeat="datas in filtered = (datas | filter:search | orderBy : sortField :reverse |  startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit) track by $index">
						<?php if($this->session->userdata('user_type')=="admin"){ ?>
							<td>{{ datas.booking_ref_no }}</td>
						<?php } ?>
							<td class="datetd">{{ convertToDate(datas.form_date) | date:'dd-MMM-yyyy' }}</td>
							<td>{{ datas.name }}</td>
							<td>{{ datas.nric }}</td>
							<td>{{ datas.mobile }}</td>
							<td>{{ datas.funding_amt | currency }}</td>
							<td><span class="label {{(datas.inv_status == 0)? 'label-warning' : 'label-success'}}">{{ (datas.inv_status == 0) ? 'Pending' : 'Approved' }}</span></td>
							<td>
								<!-- new code by Hein Htet Aung August 3 -->
								<span ng-show="datas.inv_status == 0"><a href="<?php echo base_url(); ?>form/editRecord/?id={{datas.f_id}}"><button class="button btn-default btn-xs">Edit</button></a></span>
								<!--<a href="<?php //echo base_url(); ?>invoice/addFromForm/?id={{datas.f_id}}">Edit</a> | -->
								
								<?php if ($this->session->userdata('user_type') == 'admin'): ?>
								<a href="<?php echo base_url(); ?>invoice/addFromForm/?id={{datas.f_id}}"><button class="button btn-primary btn-xs">Add Fund</button></a> <!-- change Edit to Add Fund -->
								<a href="<?php echo base_url(); ?>form/deleteRecord/?id={{datas.f_id}}" onclick="return confirmDelete();"><button class="button btn-danger btn-xs">Delete</button></a>
								<?php endif; ?>
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