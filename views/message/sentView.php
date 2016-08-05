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
            
           
            <div class="table-responsive">
              <table class="table table-email">
                <tbody>
                  <?php
                  if (isset($messages) && count($messages) > 0) {
                  	for ($i = 0; $i < count($messages); $i++) {
//                   		$class = $messages[$i]->{"msg_read"} == 0 ? 'class="unread"' : '';
						$class = '';
                  		$date =  date('Y-m-d', strtotime($messages[$i]->{'msg_sent_date'})) == date('Y-m-d') ? 'Today '.date('h:i a',strtotime($messages[$i]->{'msg_sent_date'})) : date('d M y h:i a',strtotime($messages[$i]->{'msg_sent_date'}));
                  		?>
                  		 
                 	  <tr <?php echo $class;?>>
                  		<td>
                  		
                  			<div class="media">
                  			<a href="<?php echo base_url();?>message/readMessage/?a=sent&mid=<?php echo $messages[$i]->{"msg_id"};?>">
                        	<div class="media-body"> <span class="media-meta pull-right"><?php echo $date;?></span>
                          		<h4 class="text-primary"><?php echo $messages[$i]->{"receiver"};?></h4>
                          		<small class="text-muted"></small>
                         
                         		<?php
                         		$content = $messages[$i]->{"msg_text"};
                         		if (strlen($content) > 100) {
                         			$content = substr($content, 0, 100).'...';
                         		}
                         		?>
                         		 <p class="email-summary"><strong><?php echo $messages[$i]->{"msg_subject"};?></strong> 
                          		<?php echo $content;?> </p>
                        	</div>
                        		</a>
                      		</div>
                      		
                      	</td>
                 	 </tr>
                  <?php
                  	}
                  }
                  ?>
                  

                </tbody>
              </table>
            </div><!-- /table-responsive --> 
          </div>

        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->


<?php
$this->load->view('footer.php');