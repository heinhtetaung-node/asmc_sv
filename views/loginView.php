<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo WEB_TITLE;?></title>

<!-- Bootstrap -->
<link href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url();?>css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/style-responsive.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url();?>js/jquery-2.0.2.min.js"></script> 
</head>

<script>
	$(document).ready(function() {
		$("#submit").click(function() {
			if ($("#group").val() == 0) {
				alert('Please select your role');
				return false;
			}
		});
	});
</script>
<body>
<div class="login-container">
  <div class="middle-login">
    <div class="block-web">
      <div class="head">
        <h3 class="text-center">ASMC</h3>
      </div>
      <div style="background:#fff;">
        <form action="<?php echo base_url();?>login" method="post" class="form-horizontal" style="margin-bottom: 0px !important;">
          <div class="content">
            <h4 class="title">Login Access</h4>
            
            <?php if ($this->session->userdata('error') != null) {
            	echo '<div class="alert alert-danger">'.$this->session->userdata('error').'</div>';
            	$this->session->unset_userdata('error');
            }
            ?>
            <div class="form-group">
              <div class="col-sm-12">
              <?php echo form_error('useremail'); ?>
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control" id="username" name="useremail" value="<?php echo set_value('useremail', $useremail);?>" placeholder="Username">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
              <?php echo form_error('password'); ?>
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" class="form-control" id="password" name="password" value="<?php echo set_value('password', $password);?>" placeholder="Password">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-group"></i></span>
                  <select id="group" name="group" class="form-control" >
                  	<option value="0">Please Select Role</option>
                  
                  	<option value="1">Admin</option>
                  		<option value="5">Director</option>
                  	<option value="2">Manager</option>
                  	<option value="3">Agent</option>
                  	
                  	<option value="4">Funder</option>
                  	
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="foot">
            <button id="submit" data-dismiss="modal" class="btn btn-primary">Log in</button>
          </div>
        </form>
      </div>
    </div>
    <div class="text-center out-links"><a href="#">&copy;  Copyright <?php echo WEB_TITLE;?> <?php echo date('Y');?>. </a></div>
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>js/accordion.js"></script> 
<script src="<?php echo base_url();?>js/common-script.js"></script> 
<script src="<?php echo base_url();?>js/jquery.nicescroll.js"></script>
</body>
</html>
