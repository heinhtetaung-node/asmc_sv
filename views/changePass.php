<?php 
$this->load->view('header');
$this->load->view('navbar');
$this->load->view('sidebar');
?>
<script>
$(document).ready(function() {
	$("#submit").click(function(event) {
		
		
		if ($("#pass").val() != '' && $("#pass").val() == $("#cpass").val()){
			$("#form").submit();
		}
		else {
			event.preventDefault();
			alert('Password does not match');
		}
	});
});
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
        <div class="col-md-9">
          <div class="block-web">
  
            <div class="header">
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
             <form id="form"  action="" method="post" class="form-horizontal">
					<div class="form-group">
					  <label class="col-sm-3 control-label">New password</label>
					  <div class="col-sm-9 profile-field">
					  	
						<input type="password" class="form-control" name="pass" id="pass"/>
						
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Confirm new password</label>
					  <div class="col-sm-9 profile-field">
					  	<input type="password" class="form-control"  name="cpass" id="cpass"/>
					  </div>
					</div>
					<div class="form-group">
					  
					  <div class="col-sm-9 profile-field">
					  	
						<button class="btn btn-primary" id="submit" name="submit">Update</button>
						
					</div>
					  </form> 
					</div>
					
            </div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->

<?php
$this->load->view('footer.php');