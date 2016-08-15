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

<div id="main-content" ng-controller="invoiceListViewctrl"> 
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
			  
			  <form method="get" action="<?php echo base_url();?>invoice">
				Search: <input type="text" name="search" ng-model="search" ng-change="filter()" placeholder="Filter" />
				
				<?php 
				if($this->session->userdata('user_type')=="admin" || $this->session->userdata('user_type')=="director"){ ?>
				<select ng-model="manager_search" ng-change="agent_search=''; customer_search=''">
					<option value="">All Managers</option>
					<option ng-repeat="(key, value) in datas | groupBy: 'm_name'">{{key}}</option>
				</select><?php
				} ?>
				
				<?php
				if($this->session->userdata('user_type')=="admin" || $this->session->userdata('user_type')=="director" || $this->session->userdata('user_type')=="manager"){ ?>
				<select ng-model="agent_search" ng-change="customer_search=''">
					<option value="">All Agents</option>
					<!-- using where <option ng-repeat="(key, value) in datas | where:{m_name:manager_search} | groupBy: 'agent_name'">{{key}}</option> -->
					
					<option ng-repeat="obj in datas | where:{m_name:manager_search} | orderBy: 'agent_name' | groupBy: 'agent_name'">{{obj[0].agent_name}}</option>
					
					<option ng-hide="manager_search!=''" ng-repeat="obj in datas | orderBy: 'agent_name' | groupBy: 'agent_name'">{{obj[0].agent_name}}</option>
					
				</select><?php
				} ?>
				
				
				<?php
				if($this->session->userdata('user_type')=="admin" || $this->session->userdata('user_type')=="director"){ ?>
				<select ng-model="customer_search">
					<option value="">All Funders</option>

					<option ng-hide="agent_search!='' && obj[0].agent_name!=agent_search" ng-repeat="obj in datas | where:{m_name:manager_search} | orderBy: 'customer_name' | groupBy: 'customer_name'">{{obj[0].customer_name}}</option>					
					
					<option ng-hide="agent_search!='' || manager_search!=''" ng-repeat="obj in datas | orderBy: 'customer_name' | groupBy: 'customer_name'">{{obj[0].customer_name}}</option>
				</select><?php
				} ?>
				
				<?php
				if($this->session->userdata('user_type')=="manager" || $this->session->userdata('user_type')=="agent"){ ?>
				<select ng-model="customer_search">
					<option value="">All Funders</option>

					<option ng-hide="agent_search!='' && obj[0].agent_name!=agent_search" ng-repeat="obj in datas | where:{agent_name:agent_search} | orderBy: 'customer_name' | groupBy: 'customer_name'">{{obj[0].customer_name}}</option>					
					
					<option ng-hide="agent_search!='' || manager_search!=''" ng-repeat="obj in datas | orderBy: 'customer_name' | groupBy: 'customer_name'">{{obj[0].customer_name}}</option>
				</select><?php
				} ?>
				
				
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
              if ($this->session->userdata('user_type') == 'customer') {?>
				<!--- !important later implement -->
              	 <!--<form method="get" action="<?php //echo base_url();?>customerinv">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>-->
              <?php } else {?>
				<!--- !important later implement -->
                <!--<form method="get" action="<?php //echo base_url();?>invoice">
              		Search: <input type="text" name="search" />
              		<input type="submit" class="btn btn-primary" value="Search" name="submit"/>
              	</form>-->
              <?php } ?>
			  
				<?php 
				$data['igcol']="9"; $data['pdfpage']="A4"; $data['pdfFontSize']="4"; $data['pdfspace']="20";
				$this->load->view('common/exporttable', $data); 
				?>
              	<br/>

             	<table class="table table-bordered" id="ang_table">
					<thead>
					<tr>
						<th ng-click="sortField = 'inv_no'; reverse = !reverse"><a href="">Contract No.</a></th>
						<th ng-click="sortField = 'inv_date'; reverse = !reverse"><a href="">Contract Date</a></th>
						<th ng-click="sortField = 'inv_total'; reverse = !reverse"><a href="">Funding Amt</a></th>
						<th ng-click="sortField = 'payout.min'; reverse = !reverse"><a href="">Start Payout</a></th>
						<th ng-click="sortField = 'payout.max'; reverse = !reverse"><a href="">End Payout</a></th>
						<th ng-click="sortField = 'customer_name'; reverse = !reverse"><a href="">Funder</a></th>
						<?php if($this->session->userdata('user_type')!="manager" && $this->session->userdata('user_type')!="agent"){ ?>
							<th ng-click="sortField = 'm_name'; reverse = !reverse"><a href="">Manager</a></th>
						<?php } ?>
						<?php if($this->session->userdata('user_type')!="agent"){ ?>
							<th ng-click="sortField = 'agent_name'; reverse = !reverse"><a href="">Agent</a></th>
						<?php } ?>
						<th ng-click="sortField = 'inv_created_date'; reverse = !reverse"><a href="">Created Date</a></th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody ng-init="getdatas(<?php echo htmlspecialchars(json_encode($invoices,JSON_NUMERIC_CHECK)); ?>)">
					
					<?php
					// if (isset($invoices) && count($invoices) > 0) {
						// $page = isset($_GET['p']) && $_GET['p'] != '' ? $_GET['p'] : 1;
						// $start = ($page - 1) * $per_page;
							
						// for ($i = 0; $i < count($invoices); $i++) {
							// echo '<tr>';
							
							// echo '<td>'.$invoices[$i]->{'inv_no'}.'</td>';
							// echo '<td>'.$invoices[$i]->{'inv_date'}.'</td>';
							// echo '<td>$'.number_format($invoices[$i]->{'inv_total'},2,'.',',').'</td>';
							// echo '<td>'.date('d-M-Y', strtotime($invoices[$i]->{'payout'}->{'min'})).'</td>';
							// echo '<td>'.date('d-M-Y', strtotime($invoices[$i]->{'payout'}->{'max'})).'</td>';
							// echo '<td>'.$invoices[$i]->{'customer_name'}.'</td>';
							
							// echo '<td>'.$invoices[$i]->{'m_name'}.'</td>';
							// echo '<td>'.$invoices[$i]->{'agent_name'}.'</td>';
								
							// echo '<td>'.date('Y-m-d', strtotime($invoices[$i]->{'inv_created_date'})).'</td>';
							// echo '<td><a href="'.base_url().'invoice/viewInvoice/?inv='.$invoices[$i]->{'inv_id'}.'">View</a>';
							// if ($this->session->userdata('user_type') == 'admin') 
							// echo ' | 
								// <a href="'.base_url().'invoice/editInvoice/?inv='.$invoices[$i]->{'inv_id'}.'">Edit</a> | 
								// <a href="'.base_url().'invoice/deleteInvoice/?inv='.$invoices[$i]->{'inv_id'}.'" onClick="return confirmDelete();">Delete</a>';
								
							// echo '</td>';
							// echo '</tr>';
						// }
					// }
					?>
					
					<tr id="{{datas.dr_id}}" tr-id="{{datas.dr_id}}" ng-repeat="datas in filtered = (datas | filter:{inv_no:search, agent_name:agent_search, m_name:manager_search, customer_name:customer_search} | orderBy : sortField :reverse |  startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit) track by $index"> 
					
						<td>{{ datas.inv_no }}</td>
						<td class="datetd">{{ datas.inv_date | date:'dd-MMM-yyyy' }}</td>
						<td>{{ datas.inv_total | currency }}</td>
						<td class="datetd">{{ convertToDate(datas.payout.min) | date:'dd-MMM-yyyy' }}</td>
						<td class="datetd">{{ convertToDate(datas.payout.max) | date:'dd-MMM-yyyy' }}</td>
						<td style="text-transform:capitalize">{{ datas.customer_name }}</td>
						<?php if($this->session->userdata('user_type')!="manager" && $this->session->userdata('user_type')!="agent"){ ?>
							<td>{{ datas.m_name }}</td>
						<?php } ?>
						<td>{{ datas.agent_name }}</td>
						<td class="datetd">{{ convertToDate(datas.inv_created_date) | date:'dd-MMM-yyyy' }}</td>
						<td>
							<a href="<?php echo base_url(); ?>invoice/viewInvoice/?inv={{datas.inv_id}}">View</a> | 
							<a href="<?php echo base_url(); ?>invoice/editInvoice/?inv={{datas.inv_id}}">Edit</a> | 
							<a href="<?php echo base_url(); ?>invoice/deleteInvoice/?inv={{datas.inv_id}}" onclick="return confirmDelete();">Delete</a>
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