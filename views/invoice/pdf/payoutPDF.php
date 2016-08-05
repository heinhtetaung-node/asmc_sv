<?php

tcpdf();

// Extend the TCPDF class to create custom Header and Footer
class PAYOUTPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = LOGO_PATH;
        $this->Image($image_file, 15, 10, 23, '', 'PNG', '', 'T', false, 330, '', false, false, 0, false, false, false);
        // Set font
        $this->SetTextColor(255, 255, 255); 
        $this->SetFont('helvetica', 'B', 25);
        // Title
       
       //  $this->Rect(105,5,100,20,'F','',$fill_color = array(0, 0, 0));
//     	$this->Cell(105, 18, 'Sales & Purchase', 0, 0, 'R', 0, '', 0, false, 'C', 'B');
    }

}

$obj_pdf = new PAYOUTPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "PAYOUT";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);

$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 8.5);
$obj_pdf->setFontSubsetting(false);

$obj_pdf->SetPrintFooter(false);
$obj_pdf->setCellHeightRatio(1.5);

// $obj_pdf->addTTFfont('/usr/share/nginx/gold_admin/application/helpers/tcpdf/fonts/DroidSansFallback.ttf');
// $obj_pdf->SetFont('DroidSansFallback', '', 10);
$obj_pdf->AddPage();
ob_start();


?>
<style>
.table td {
	height:30px;
}
li {
	margin-bottom:10px;
}
</style>
<p style="text-align:center">Annex A<br/>
<span style="text-align:center;font-weight:bold;font-size:13px;">ASMC Coal Funding Payout Schedule</span></p>
<table style="width:100%">
	<tr>
		<td style="width:10%;">Date:</td>
		<td style="width:20%;"><?php echo date('d-M-Y', strtotime($inv->{"inv_date"}));?></td>
		<td style="width:15%;"></td>
		<td style="width:5%;"></td>
		<td style="width:10%;"></td>
		<td style="width:20%;">Contract No:</td>
		<td style="width:15%;"><?php echo $inv->{"inv_no"};?></td>
	</tr>
	<tr>
		<td style="width:10%;">Name:</td>
		<td style="width:20%;"><?php echo $inv->{"customer_name"};?></td>
		<td style="width:15%;"></td>
		<td style="width:5%;"></td>
		<td style="width:10%;"></td>
		<td style="width:20%;">Funding Amount:</td>
		<td style="width:15%;">$<?php echo number_format($inv->{"inv_total"},2,'.',',');?></td>
	</tr>
	<tr>
		<td style="width:10%;">Tonnage:</td>
		<td style="width:20%;"><?php echo $inv->{"inv_amt"};?> Metric Ton per month</td>
		<td style="width:15%;"></td>
		<td style="width:5%;"></td>
		<td style="width:10%; "></td>
		<td style="width:20%;">Rate Per Metric Ton:</td>
		<td style="width:15%;">$<?php echo number_format($inv->{"inv_unitprice"},2,'.',',');?></td>
	</tr>
	
	<?php
	$total_year = $inv->{'inv_period'} / 12;
	
	$total_rows = round($total_year / 2);
	
	//if even year
	if ($total_year % 2 == 0)
		$total_rows += 1;
		
	$year_counter = 1;
	$exit = false;
	$total_payout = 0;
	for ($i = 1; $i <= $total_rows; $i++) {
		
		?>
		<tr>
			<td style="width:50%;">
			<?php 
				if ($year_counter > $total_year) {
					if ($year_counter == $total_year + 1) {
						echo 'summary';
					}
					$year_counter++;
					$exit = true;
				}
				else {

					?>
					<table style="width:100%">
						<tr>
						<td colspan="3"></td>
						</tr>
						<tr>
							<td colspan="3" style="background-color:#000000;color:#ffffff;border:1px solid #000000;">Year <?php echo $year_counter;?></td>
						</tr>
					<?php
					$total = 0;
					for ($m = 1; $m <= 12; $m++) {
						$index = ($m + ($year_counter - 1) * 12) - 1;
						$pay = $payout[$index];
						$total += $pay->{'amt'};
						$total_payout += $pay->{'amt'};
						?>
						<tr>
							<?php
							if ($index==0) {
							?>
								<td style="text-align:center;width:20%;border:1px solid #000000;"><?php echo $m + ($year_counter - 1) * 12;?></td>
								<td style="text-align:center;width:50%;border:1px solid #000000;"><?php echo date('d-M-Y', strtotime($pay->{'date'}));?></td>
								<td rowspan="3" style="text-align:center;width:30%;border:1px solid #000000;"><br/><br/>Production Period</td>
							<?php
							}
							else if ($index > 0 && $index <= 2) {
							?>
								<td style="text-align:center;width:20%;border:1px solid #000000;"><?php echo $m + ($year_counter - 1) * 12;?></td>
								<td style="text-align:center;width:50%;border:1px solid #000000;"><?php echo date('d-M-Y', strtotime($pay->{'date'}));?></td>
								
							<?php
							}
							//last month
							else if ($index == count($payout) - 1) {
							?>
								<td style="text-align:center;width:20%;border:1px solid #000000;"><br/><br/><?php echo $m + ($year_counter - 1) * 12;?></td>
								<td style="text-align:center;width:50%;border:1px solid #000000;"><br/><br/><?php echo date('d-M-Y', strtotime($pay->{'date'}));?></td>
								<td style="text-align:center;width:30%;border:1px solid #000000;">
								$<?php echo number_format($pay->{'amt'}, 2,'.',',');?>
								<br/><br/>
								$<?php echo number_format($inv->{'inv_total'}, 2,'.',',');?>
								<?php
								$total += $inv->{'inv_total'};
								?>
								</td>
							<?php
							}
							else {
							?>
								<td style="text-align:center;width:20%;border:1px solid #000000;"><?php echo $m + ($year_counter - 1) * 12;?></td>
								<td style="text-align:center;width:50%;border:1px solid #000000;"><?php echo date('d-M-Y', strtotime($pay->{'date'}));?></td>
								<td style="text-align:center;width:30%;border:1px solid #000000;">$<?php echo number_format($pay->{'amt'}, 2,'.',',');?></td>
							<?php }?>
						</tr>
						<?php
					}
					?>	
					<tr>
						<td style="text-align:center;width:20%;"></td>
						<td style="background-color:#000000;color:#ffffff;text-align:center;width:50%;border:1px solid #000000;">Total Receivable</td>
						<td style="text-align:center;background-color:#000000;color:#ffffff;width:30%;border:1px solid #000000;">
						$ <?php echo number_format($total, 2,'.',',');?> </td>
					</tr>
					<tr>
						<td colspan="3"></td>
					</tr>
					</table>
					<?php
					$year_counter++;
				}
			?>
			</td>
			<td style="width:50%;">
			<?php 
				if ($year_counter > $total_year) {
					//summary
					if ($year_counter == $total_year + 1) {
						?>
						<table>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td style="text-align:center;width:20%;"></td>
								<td style="background-color:#000000;color:#ffffff;text-align:center;width:50%;border:1px solid #000000">Total Payout</td>
								<td style="background-color:#000000;color:#ffffff;text-align:center;width:30%;border:1px solid #000000">
								$<?php 
								//last month add funding amt
								$total_payout += $inv->{'inv_total'};
								echo number_format($total_payout,2,'.',',');?>
								</td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="3" style="background-color:#000000;color:#ffffff; border:1px solid #000000"> Monthly Payout</td>
							</tr>	
							<tr>
								<td colspan="2" style="border:1px solid #000000"> Name of Account Holder</td>
								<td style="border:1px solid #000000"> <?php echo $inv->{"customer_name"};?></td>
							</tr>
							<tr>
								<td colspan="3" style=" border:1px solid #000000"></td>
							</tr>
							<tr>
								<td colspan="2" style=" border:1px solid #000000"> Name of Bank</td>
								<td style="border:1px solid #000000"> <?php echo $inv->{"customer_bank_name"};?></td>
							</tr>
							<tr>
								<td colspan="2" style=" border:1px solid #000000"> Account Number</td>
								<td style="border:1px solid #000000"> <?php echo $inv->{"customer_bank_acc"};?></td>
							</tr>
							<tr>
								<td colspan="2" style=" border:1px solid #000000"> Account Type</td>
								<td style="border:1px solid #000000"> <?php echo $inv->{"customer_acc_type"};?></td>
							</tr>
							<tr>
								<td colspan="2" style="background-color:#000000;color:#ffffff; border:1px solid #000000"> Completion Date</td>
								<td style="background-color:#000000;color:#ffffff; border:1px solid #000000"> <?php echo date('t-M-Y', strtotime("+".$inv->{'inv_period'}." month", strtotime($inv->{"inv_date"})));?> </td>
							</tr>	
							<tr>
								<td colspan="3" style=" border:1px solid #000000"> Return of Principle Amount will be payable by cheque upon<br/>&nbsp;completion.		
		</td>
							</tr>
						</table>
						<?php
					}
					$year_counter++;
					$exit = true;
				}
				else {
					?>
					<table style="width:100%">
						<tr>
						<td colspan="3"></td>
						</tr>
						<tr>
							<td colspan="3" style="background-color:#000000;color:#ffffff;border:1px solid #000000;">Year <?php echo $year_counter;?></td>
						</tr>
					<?php
					$total = 0;
					for ($m = 1; $m <= 12; $m++) {
						$pay = $payout[($m + ($year_counter - 1) * 12) - 1];
						$total += $pay->{'amt'};
						$total_payout += $pay->{'amt'};
						?>
						<tr>
							<td style="text-align:center;width:20%;border:1px solid #000000;"><?php echo $m + ($year_counter - 1) * 12;?></td>
							<td style="text-align:center;width:50%;border:1px solid #000000;"><?php echo date('d-M-Y', strtotime($pay->{'date'}));?></td>
							<td style="text-align:center;width:30%;border:1px solid #000000;">$<?php echo number_format($pay->{'amt'}, 2,'.',',');?></td>
						</tr>
						<?php
					}
					?>
					<tr>
					<?php
					if ($index == count($payout) - 1) {
						?>
							<td style="text-align:center;width:20%;border:1px solid #000000;"><?php echo $m + ($year_counter - 1) * 12;?></td>
							<td style="text-align:center;width:50%;border:1px solid #000000;"><?php echo date('d-M-Y', strtotime($pay->{'date'}));?></td>
							<td style="text-align:center;width:30%;border:1px solid #000000;">
							$<?php echo number_format($pay->{'amt'}, 2,'.',',');?>
							<br/>
							<?php
								$total += $inv->{'inv_total'};
								?>
							$<?php echo number_format($inv->{'inv_total'}, 2,'.',',');?>
							</td>
						<?php
					}
					else {
						?>
					
							<td style="text-align:center;width:20%;"></td>
							<td style="background-color:#000000;color:#ffffff;text-align:center;width:50%;border:1px solid #000000;">Total Receivable</td>
							<td style="text-align:center;background-color:#000000;color:#ffffff;width:30%;border:1px solid #000000;">
							$ <?php echo number_format($total, 2,'.',',');?></td>
						<?php }
						?>
						
					</tr>
					<tr>
						<td colspan="3"></td>
					</tr>
					</table>
					<?php
					$year_counter++;
				}
			?>
			</td>
		</tr>
		<?php
		if ($exit)
			break;
	}
	?>
	
</table>
	
<?php


    // we can have any view part here like HTML, PHP etc
$content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');

// $obj_pdf->Output('output.pdf', 'I');


 $obj_pdf->Output(PAYOUT_PATH.$inv->{'inv_id'}.'.pdf', 'F');
 
 if ($display == 1)
  	$obj_pdf->Output(PAYOUT_PATH.$inv->{'inv_id'}.'.pdf', 'I');

?>