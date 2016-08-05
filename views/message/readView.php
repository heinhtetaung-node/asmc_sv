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
            
         
            <div class="read-panel">
            	<form method="post" action="<?php echo base_url();?>message/readMessage/?a=<?php echo $_GET['a'];?>&mid=<?php echo $_GET['mid'];?>">
              <div class="media"> 
              <?php
              $date =  date('Y-m-d', strtotime($message->{'msg_sent_date'})) == date('Y-m-d') ? 'Today '.date('h:i a',strtotime($message->{'msg_sent_date'})) : date('d M y h:i a',strtotime($message->{'msg_sent_date'}));
                  		
                ?>
                <div class="media-body"> <span class="media-meta pull-right"><?php echo $date;?></span>
           
                   <small class="text-muted">From: <?php echo $message->{'sender'};?></small><br/>
                  <small class="text-muted">To: <?php echo $message->{'receiver'};?></small>
              </div>
                <br/>
              <h4 class="email-subject"><strong><?php echo $message->{'msg_subject'};?></strong></h4>
              <p>
              <?php 
              	echo nl2br($message->{'msg_text'});
              
              	?>
              </p>
              
              <br>
              <?php
              //only can replt for inbox, for sent item cannot replty.
              if ($active == 'inbox') {?>
              <div class="media"> 
                <div class="media-body">
                <input type="hidden" name="msg_id" value="<?php echo $message->{'msg_id'};?>"/>
                	<?php echo form_error('msg_text');?>
                  <textarea class="form-control" name="msg_text" placeholder="Reply here..."></textarea><br/>
                  <input type="submit" name="submit" class="btn btn-primary" value="Reply"/>
                </div>
              </div><!-- /media --> 
              <?php }?>
                
          </div><!--/ read-panel -->   
        	  </form> 
         </div>
         
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->


<?php
$this->load->view('footer.php');