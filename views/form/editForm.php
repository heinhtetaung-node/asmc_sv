<?php 
$this->load->view('header');
$this->load->view('navbar');
$this->load->view('sidebar');
?>
<script>
$(document).ready(function() {
// 
// var wrapper = document.getElementById("signature-pad"),
//     clearButton = wrapper.querySelector("[data-action=clear]"),
//     canvas = wrapper.querySelector("canvas"),
//     signaturePad;
// 
// // Adjust canvas coordinate space taking into account pixel ratio,
// // to make it look crisp on mobile devices.
// // This also causes canvas to be cleared.
// function resizeCanvas() {
//     // When zoomed out to less than 100%, for some very strange reason,
//     // some browsers report devicePixelRatio as less than 1
//     // and only part of the canvas is cleared then.
//     var ratio =  Math.max(window.devicePixelRatio || 1, 1);
//     canvas.width = canvas.offsetWidth * ratio;
//     canvas.height = canvas.offsetHeight * ratio;
//     canvas.getContext("2d").scale(ratio, ratio);
// }
// 
// window.onresize = resizeCanvas;
// resizeCanvas();
// 
// var signaturePad = new SignaturePad(canvas,{onEnd:function() {	 document.getElementById("signature").value = signaturePad.toDataURL();}});
// 
// 
// clearButton.addEventListener("click", function (event) {
//     signaturePad.clear();
//     event.preventDefault();
// });
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
        <div class="col-md-12">
          <div class="block-web">
  
            <div class="header">
            <h3 class="content-header">
             BM Steam Coal Reservation Form </h3>
              
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
              <h3 style="text-align:center"></h3>
			<form method="post" action="">
			<table class="form-table" style="width:100%">
				<?php 
				if ($this->session->userdata('user_type') == 'admin'){	// new code edit by Hein Htet Aung Aug 3
				?>
				<tr>
					<td colspan="2" ><label>Booking Ref. Number:</label></td>
					<td colspan="4"><input type="text" name="booking_ref_no" value="<?php echo isset($booking_ref_no) ? set_value('booking_ref_no', $booking_ref_no) : set_value('booking_ref_no', '');?>"></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="2" ><label>Name of Funder:</label></td>
					<td colspan="4"><input type="text" name="name" value="<?php echo isset($name) ? set_value('name', $name) : set_value('name', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>NRIC/Passport:</label></td>
					<td><input type="text" name="nric" value="<?php echo isset($nric) ? set_value('nric', $nric) : set_value('nric', '');?>"></td>
					<td ><label>Date of Birth:</label></td>
					<td colspan="2" ><input type="date" name="dob" value="<?php echo isset($dob) ? set_value('dob', date('Y-m-d',strtotime($dob))) : set_value('dob', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Nationality:</label></td>
					<td><input type="text" name="nationality" value="<?php echo isset($nationality) ? set_value('nationality', $nationality) : set_value('nationality', '');?>"></td>
					<td ><label>Mobile No.:</label></td>
					<td colspan="2" ><input type="text" name="mobile" value="<?php echo isset($mobile) ? set_value('mobile', $mobile) : set_value('mobile', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Telephone No.(H):</label></td>
					<td><input type="tel" name="tel" value="<?php echo isset($tel) ? set_value('tel', $tel) : set_value('tel', '');?>"></td>
					<td ><label>Office No.:</label></td>
					<td colspan="2" ><input type="text" name="office_no" value="<?php echo isset($office_no) ? set_value('office_no', $office_no) : set_value('office_no', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Bank Account No.:</label></td>
					<td><input type="text" name="bank_acc_no" value="<?php echo isset($bank_acc_no) ? set_value('bank_acc_no', $bank_acc_no) : set_value('bank_acc_no', '');?>"></td>
					<td ><label>Bank Type:</label></td>
					<td colspan="2" ><input type="text" class="form-control" name="bank_type" value="<?php echo isset($bank_type) ? set_value('bank_type', $bank_type) : set_value('bank_type', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Name In Bank Account:</label></td>
					<td><input type="text" name="bank_acc_name" value="<?php echo isset($bank_acc_name) ? set_value('bank_acc_name', $bank_acc_name) : set_value('bank_acc_name', '');?>"></td>
					<td ><label>Email Address:</label></td>
					<td colspan="2" ><input type="email" name="email" value="<?php echo isset($email) ? set_value('email', $email) : set_value('email', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Correspondence Address:</label></td>
					<td colspan="4"><input type="text" name="address" value="<?php echo isset($address) ? set_value('address', $address) : set_value('address', '');?>"></td>
					
				</tr>
				<tr>
					<td colspan="2" ><label>Country:</label></td>
					<td><input type="text" name="country" value="<?php echo isset($country) ? set_value('country', $country) : set_value('country', '');?>"></td>
					<td ><label>Postal Code:</label></td>
					<td colspan="2" ><input type="text" name="postal" value="<?php echo isset($postal) ? set_value('postal', $postal) : set_value('postal', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Beneficiary:</label></td>
					<td><input type="text" name="beneficiary_name" value="<?php echo isset($beneficiary_name) ? set_value('beneficiary_name', $beneficiary_name) : set_value('beneficiary_name', '');?>"></td>
					<td ><label>NRIC No.:</label></td>
					<td colspan="2" ><input type="text" name="beneficiary_nric" value="<?php echo isset($beneficiary_nric) ? set_value('beneficiary_nric', $beneficiary_nric) : set_value('beneficiary_nric', '');?>"></td>
				</tr>
				<tr>
					<td colspan="6" >This Reservation is subject to you entering into a Funding Agreement within 7 days from the date stated here within.</td>
				</tr>
				
				<tr>
					<td colspan="2" ><label>Project Site Address:</label></td>
					<td colspan="4" ><b>CV ARUNA<br/>Anggana Sungai Siring Samarinda, East Kalimantan,<br/>Borneo Indonesia.</td>
				</tr>
				<tr>
					<td colspan="2" ><label>Funding Amount (SGD$):</label></td>
					<td><input type="text" name="funding_amt" value="<?php echo isset($funding_amt) ? set_value('funding_amt', $funding_amt) : set_value('funding_amt', '');?>"></td>
					<td ><label>Tonnage:</label></td>
					<td colspan="2" ><input type="text" name="tonnage" placeholder="m/ton" value="<?php echo isset($tonnage) ? set_value('tonnage', $tonnage) : set_value('tonnage', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Returns on Funds per month (SGD$):</label></td>
					<td><input type="text" name="return_per_mth" value="<?php echo isset($return_per_mth) ? set_value('return_per_mth', $return_per_mth) : set_value('return_per_mth', '');?>"></td>
					<td ><label>Percentage:</label></td>
					<td colspan="2" ><input type="text" name="percentage" placeholder="%" value="<?php echo isset($percentage) ? set_value('percentage', $percentage) : set_value('percentage', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Administration Fee (SGD$):</label></td>
					<td><input type="text" name="admin_fee" value="<?php echo isset($admin_fee) ? set_value('admin_fee', $admin_fee) : set_value('admin_fee', '');?>"></td>
					<td ><label>Due Date:</label></td>
					<td colspan="2" ><input type="date" name="due_date" placeholder="" value="<?php echo isset($due_date) ? set_value('due_date', $due_date) : set_value('due_date', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Venue:</label></td>
					<td><input type="text" name="venue" value="<?php echo isset($venue) ? set_value('venue', $venue) : set_value('venue', '');?>"></td>
					<td ><label>Time:</label></td>
					<td colspan="2" ><input type="time" name="time" placeholder="" value="<?php echo isset($time) ? set_value('time', $time) : set_value('time', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Commencement Date:</label></td>
					<td><input type="date" name="commencement_date" value="<?php echo isset($commencement_date) ? set_value('commencement_date', $commencement_date) : set_value('commencement_date', '');?>"></td>
					<td ><label>Completion:</label></td>
					<td colspan="2" ><input type="date" name="completion_date" placeholder="" value="<?php echo isset($completion_date) ? set_value('completion_date', $completion_date) : set_value('completion_date', '');?>"></td>
				</tr>
				<tr>
					<td colspan="6" >Returns on Funds will commence on the 4th month after clearance of Full and Final Payments.</td>
				</tr>
				<tr>
					<td colspan="2" ><label>Remarks:</label></td>
					<td colspan="4"><input type="text" name="remarks" value="<?php echo isset($remarks) ? set_value('remarks', $remarks) : set_value('remarks', '');?>"></td>
				</tr>
				<tr>
					<td rowspan="3"><label>Payment Details:</label></td>
					<td><label>Cheque Payable:</label></td>
					<td colspan="3"><b>Asia Strategic Mining Corporation Pte Ltd</b></td>
				</tr>
				<tr>
					
					<td rowspan="2"><label>Bank Transfer:</label></td>
					<td colspan="3"><b>UOB Bank Current Account 372-303-108-5</b></td>
				</tr>
				<tr>
					
					
					<td colspan="3"><b>Bank Swift Code: UOVBSGSG </b></td>
				</tr>
				<tr>
					<td style="height:80px"><label>Signature:</label></td>
					<td  colspan="2" style="border:1px solid #000000">
					
					<img src="<?php echo $signature; ?>"  />

					</td>
					<td ><label>Date:</label></td>
					<td colspan="2" ><input type="date" name="form_date" placeholder="" value="<?php echo isset($form_date) ? set_value('form_date', $form_date) : set_value('form_date', '');?>"></td>
				</tr>
				<tr>
					<td style="text-align:center" colspan="6" >For Official Use Only:</td>
				</tr>
				<tr>
					<td colspan="2" ><label>CRM:</label></td>
					<td><input type="text" name="crm" value="<?php echo isset($crm) ? set_value('crm', $crm) : set_value('crm', '');?>"></td>
					<td ><label>SM:</label></td>
					<td colspan="2" ><input type="text" name="sm" placeholder="" value="<?php echo isset($sm) ? set_value('sm', $sm) : set_value('sm', '');?>"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Source:</label></td>
					<td><select name="source">
						
						<option value="EC" <?php echo isset($source) && $source == 'EC' ? 'selected="selected"' : '';?>>EC</option>
						<option value="REF" <?php echo isset($source) && $source == 'REF' ? 'selected="selected"' : '';?>>REF</option>
						<option value="SG" <?php echo isset($source) && $source == 'SG' ? 'selected="selected"' : '';?>>SG</option>
						<option value="TM" <?php echo isset($source) && $source == 'TM' ? 'selected="selected"' : '';?>>TM</option>
						</select>
					</td>
					<td ><label>Referral Name:</label></td>
					<td colspan="2" ><input type="text" name="referral_name" placeholder="" value="<?php echo isset($referral_name) ? set_value('referral_name', $referral_name) : set_value('referral_name', '');?>"></td>
				</tr>
				<tr>
					<td ><label>Document Required:</label></td>
					<td colspan="2">Funder NRIC/Passport copy</td>
					<td ><label>Bank Book/Bank Statement:</label></td>
					<td colspan="2"><input type="text" name="bank_book" placeholder="" value="<?php echo isset($bank_book) ? set_value('bank_book', $booking_ref_no) : set_value('bank_book', '');?>"></td>
				</tr>
				
			</table>
			<button id="submit" class="btn btn-primary" name="submit">Approve & Create Funding Agreement</button>
			<br/><br/>
			</form>
		</div><!--/porlets-content-->
          </div><!--/block-web--> 
        </div><!--/col-md-12--> 
      </div>
      
		
   
	</div>  <!--/page-content end--> 
</div><!--/main-content end-->
</div><!--/page-container end-->


<?php 
$this->load->view('footer');
?>