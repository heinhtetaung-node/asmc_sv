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
            <h3 class="content-header">
             	<?php echo $subtitle;?>
              </h3>
              
            </div>
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
				<div class="compose-mail">
				  <form name="emailform" role="form-horizontal" method="post" action="<?php echo base_url();?>message/compose">
					<div class="form-group" style="margin-bottom:10px;border:none;">
					  <label class="">User Group:</label>
					  <select name="group" id="group">
					  	<option value="1">Manager</option>
					  	<option value="2">Agent</option>
					  	<option value="3">Customer</option>
					  	<option value="5">Director</option>
					  </select>
					 
					</div>
					
					<div class="form-group" style="margin-bottom:10px;border:none;">
					  <label class="">To:</label>
					  <select name="to" id="to">
					  	<option value="1">All</option>
					  	<option value="2">Manual select</option>
					  </select>
					</div>
					<div class="form-group" style="margin-bottom:10px;border:none;">
						<div class="alert alert-info" id="receiver-info" style="display:none">Select your receiver below.</div>
					  <div id="receivers" style="width:90%;display:none;margin:2%">
					  	
					  </div>
					</div>
					<div class="form-group">
					 <?php echo form_error('subject');?>
					  <label for="subject" class="">Subject:</label>
					 
					  <input type="text" tabindex="1" name="subject" value="<?php echo set_value('subject');?>" id="subject" class="form-control">
					</div>
					<div style="margin-top:10px;" class="compose-editor">
					<?php echo form_error('message');?>
					 <textarea rows="15" name="message" class="col-xs-12" id="text-editor"  placeholder="Enter text ..."><?php echo set_value('message');?></textarea>
					 </div>
		
				  </form>
				</div>
				<div class="bottom">
				  <input type="submit" class="btn btn-primary" onclick="document.emailform.submit()" value="Send"/>
				</div>
			  </div>

        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<script>
	$(document).ready(function() {
		//default select all
		$("#to").val(1);
		$("#to").change(function() {
			if ($(this).val() == 2) {
				//get receiver list
				$.ajax({
				  type: "POST",
				  url: "getReceivers",
				  data:{'type':$("#group").val()}
				})
				  .done(function( msg ) {
					$("#receivers").html(msg);
				});
				
				$("#receivers").show();
				$("#receiver-info").show();
			}
			else {
				$("#receivers").hide();
				$("#receiver-info").hide();
				$("#receivers").html('');
			}
		});
	
		//if group chnage
		$("#group").change(function() {
			//if the receiver is manual select, refetch the list
			if ($("#to").val() == 2) {
				//get receiver list
				$.ajax({
				  type: "POST",
				  url: "getReceivers",
				  data:{'type':$("#group").val()}
				})
				  .done(function( msg ) {
					$("#receivers").html(msg);
				});
			}
		});
	});
</script>

<?php
$this->load->view('footer.php');