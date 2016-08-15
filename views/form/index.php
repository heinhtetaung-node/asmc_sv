<?php 
$this->load->view('header_signup');
// $this->load->view('navbar');
// $this->load->view('sidebar');
?>
<script>
$(document).ready(function() {

var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    
    canvas = wrapper.querySelector("canvas"),
     
    signaturePad;
    
var wrapper2 = document.getElementById("signature-pad2"),
    clearButton2 = wrapper.querySelector("[data-action=clear2]"),
    
    canvas2 = document.getElementById("canvas2"),
     
    signaturePad2;


// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    
     ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas2.width = canvas2.offsetWidth * ratio;
    canvas2.height = canvas2.offsetHeight * ratio;
    canvas2.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas,{onEnd:function() {	 document.getElementById("signature").value = signaturePad.toDataURL();}});

var signaturePad2 = new SignaturePad(canvas2,{onEnd:function() {	 document.getElementById("director_signature").value = signaturePad2.toDataURL();}});


clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
    event.preventDefault();
});
$(".clear2").on('click', function (event) {
    signaturePad2.clear();
    event.preventDefault();
});
$(".datepicker").datepicker({dateFormat:'dd-mm-yy'});
});
</script>


<style>
form label {
    color: #000000;
}
</style>
<div class="container" ng-controller="MyCtrl">
<div class="row">
	<div class="large-12 columns main-content-top">
	  <!-- Row -->
	  <div class="row">

		<div class="large-3 columns">

		 
		</div>

	  </div>
	  <!-- End Row -->
	</div>
</div>
  
<div class="row main-content">	
	<div class="large-12 columns">
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
              <h3 style="text-align:center">BM Steam Coal Reservation Form</h3>
			<form method="post" action="">
			<table class="form-table" style="width:100%">
				<?php 
				if ($this->session->userdata('user_type') == 'admin'){	// new code edit by Hein Htet Aung Aug 3
				?>
				<tr>
					<td colspan="2" ><label>Booking Ref. Number:</label></td>
					<td colspan="4"><input type="text" name="booking_ref_no" value="ASFD"></td>
				</tr>
				<?php 
				} 
				?>
				<tr>
					<td colspan="2" ><label>NRIC/Passport:</label></td>
					<td class="autoinputtd">
						<input type="text" style="display:none;" name="nric" ng-model="customer_nric">
						<input type="hidden" ng-init="getfunders(<?php echo htmlspecialchars(json_encode($funders,JSON_NUMERIC_CHECK)); ?>)" >
						<autocomplete ng-model="customer_nric" attr-placeholder="type to search funder..." click-activation="true" data="movies" on-type="doSomething" on-select="doSomethingElse"></autocomplete>
						
					</td>
					<td ><label>Date of Birth:</label></td>
					<td colspan="2" ><input type="text" ng-model="customer_dob" id="dob_id" class="datepicker" name="dob"></td>
				</tr>
				
				<tr>
					<td colspan="2" ><label>Name of Funder:</label></td>
					<td colspan="4"><input type="text" ng-model="filtercustomer.customer_name" name="name"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Bank Account No.:</label></td>
					<td><input type="text" ng-model="filtercustomer.customer_bank_acc" name="bank_acc_no"></td>
					<td ><label>Mobile No.:</label></td>
					<td colspan="2" ><input type="text" ng-model="filtercustomer.customer_mobile" name="mobile"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Name In Bank Account:</label></td>
					<td><input type="text" name="bank_acc_name" ng-model="filtercustomer.customer_bank_name" ></td>
					<td ><label>Email Address:</label></td>
					<td colspan="2" ><input type="email" ng-model="filtercustomer.customer_email" name="email"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Correspondence Address:</label></td>
					<td class="autoinputtd"><textarea class="txtarea" ng-model="filtercustomer.customer_addr" name="address"></textarea></td>					
				</tr>
				<tr>
					<td colspan="2" ><label>Nationality:</label></td>
					<td><input type="text" name="nationality"></td>
					<td ><label>Bank Type:</label></td>
					<td colspan="2" ><input type="text" class="form-control" name="bank_type"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Telephone No.(H):</label></td>
					<td><input type="tel" ng-model="filtercustomer.customer_home_no" name="tel"></td>
					<td ><label>Office No.:</label></td>
					<td colspan="2" ><input type="text" name="office_no"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Country:</label></td>
					<td>
						<select name="country">
						<?php
						if (isset($countries) && count($countries) > 0) {
							echo '<option value="Singapore">Singapore</option>';
							echo '<option value="Malaysia">Malaysia</option>';
							foreach ($countries as $coun) {
								echo '<option value="'.$coun->{"country_name"}.'">'.$coun->{"country_name"}.'</option>';
							}
						}
						?>
						
<!-- // 						<input type="text" name="country"> -->
						</select>
					</td>
					<td ><label>Postal Code:</label></td>
					<td colspan="2" ><input type="text" name="postal"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Beneficiary:</label></td>
					<td><input type="text" name="beneficiary_name"></td>
					<td ><label>NRIC No.:</label></td>
					<td colspan="2" ><input type="text" name="beneficiary_nric"></td>
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
					<td><input type="text" name="funding_amt"></td>
					<td ><label>Tonnage:</label></td>
					<td colspan="2" ><input type="text" name="tonnage" placeholder="m/ton"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Returns on Funds per month (SGD$):</label></td>
					<td><input type="text" name="return_per_mth"></td>
					<td ><label>Percentage:</label></td>
					<td colspan="2" ><input type="text" name="percentage" placeholder="%"></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Administration Fee (SGD$):</label></td>
					<td><input type="text" name="admin_fee"></td>
					<td ><label>Due Date:</label></td>
					<td colspan="2" ><input type="text" class="datepicker" name="due_date" placeholder=""></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Venue:</label></td>
					<td><input type="text" name="venue"></td>
					<td ><label>Time:</label></td>
					<td colspan="2" ><input type="time" name="time" placeholder=""></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Commencement Date:</label></td>
					<td><input type="text" class="datepicker" name="commencement_date"></td>
					<td ><label>Completion:</label></td>
					<td colspan="2" ><input type="text" class="datepicker" name="completion_date" placeholder=""></td>
				</tr>
				<tr>
					<td colspan="2" ><label>Agreement Type:</label></td>
					<td colspan="4">
					<select name="agreement_type">
						<option value="1">Standard</option>
						<option value="2">Progressive</option>
						<option value="3">Topup</option>
					</select>
					</td>
				</tr>
				
				<tr>
					<td colspan="6" >Returns on Funds will commence on the 4th month after clearance of Full and Final Payments.</td>
				</tr>
				<tr>
					<td colspan="2" ><label>Remarks:</label></td>
					<td colspan="4"><input type="text" name="remarks"></td>
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
					
					<div id="signature-pad" class="m-signature-pad">
						<div class="m-signature-pad--body">
						  <canvas style="width:100%"></canvas>
						</div>
						<div class="m-signature-pad--footer">
						  <div class="description">Sign above</div>
						  <input type="hidden" name="signature" id="signature"/>
						  <button class="button clear" data-action="clear">Clear</button>
						</div>
					  </div>


					</td>
					<td style="height:80px"><label>Approved By:</label></td>
					<td  colspan="2" style="border:1px solid #000000">
					
					<div id="signature-pad2" class="m-signature-pad">
						<div class="m-signature-pad--body">
						  <canvas id="canvas2" style="width:100%"></canvas>
						</div>
						<div class="m-signature-pad--footer">
						  <div class="description">Sign above</div>
						  <input type="hidden" name="director_signature" id="director_signature"/>
						  <button class="button clear2" data-action="clear2">Clear</button>
						</div>
					  </div>


					</td>
					
				</tr>
				<tr>
					<td ><label>Date:</label></td>
					<td colspan="2" ><input type="text" class="datepicker" name="form_date" placeholder=""></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td style="text-align:center" colspan="6" >For Official Use Only:</td>
				</tr>
				<tr>
					<td colspan="2" ><label>CRM/Agent:</label></td>
					<td>
					<select name="agent_id" onchange="setemail('agent')" id="agent_email_id">
						<option value=""></option>
						<?php
						if (isset($agents) && count($agents) > 0) {
							foreach ($agents as $a) {
								echo '<option data-email="'.$a->{'agent_email'}.'" value="'.$a->{'agent_id'}.'">'.$a->{'agent_name'}.'</option>';
							}
						}
						?>
					</select><input type="hidden" id="agent_email" name="agent_email" />
				
					</td>
					<td ><label>SM:</label></td>
					<td colspan="2" >
					<select name="manager_id" onchange="setemail('manager')" id="manager_email_id">
						<option value=""></option>
						<?php
						if (isset($managers) && count($managers) > 0) {
							foreach ($managers as $m) {
								echo '<option data-email="'.$m->{'m_email'}.'" value="'.$m->{'m_id'}.'">'.$m->{'m_name'}.'</option>';
							}
						}
						?>
					</select><input type="hidden" id="manager_email" name="manager_email" />
					</td>
				</tr>
				<tr>
					<td colspan="2" ><label>Sales Director:</label></td>
					<td>
						<select name="director_id" onchange="setemail('director')" id="director_email_id">
							<option value=""></option>
							<?php
							if (isset($directors) && count($directors) > 0) {
								foreach ($directors as $d) {
									echo '<option data-email="'.$d->{'dr_email'}.'" value="'.$d->{'dr_id'}.'">'.$d->{'dr_name'}.'</option>';
								}
							}
							?>
						</select><input type="hidden" id="director_email" name="director_email" />
					</td>
					<td ><label>Marketing:</label></td>
					<td colspan="2" >
					<input type="text" name="marketing" placeholder="">
					</td>
				</tr>
				<tr>
					<td colspan="2" ><label>Source:</label></td>
					<td><select name="source">
						<option value="EC">EC</option>
						<option value="REF">REF</option>
						<option value="SG">SG</option>
						<option value="TM">TM</option>
						</select>
					</td>
					<td ><label>Referral Name:</label></td>
					<td colspan="2" ><input type="text" name="referral_name" placeholder=""></td>
				</tr>
				<tr>
					<td ><label>Document Required:</label></td>
					<td colspan="2">Funder NRIC/Passport copy</td>
					<td ><label>Bank Book/Bank Statement:</label></td>
					<td colspan="2"><input type="text" name="bank_book" placeholder=""></td>
				</tr>
				
			</table>
			<button id="submit" class="btn btn-primary" name="submit">Submit</button>
			<br/><br/>
			</form>
			
	</div>

</div>


</div>

<script>
	function setemail(idname){
		$('#'+idname+'_email').val($('#'+idname+'_email_id').find('option:selected').attr('data-email'));
	}
</script>
<?php 
// $this->load->view('footer');
?>