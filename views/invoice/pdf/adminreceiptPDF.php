<?php

tcpdf();

// Extend the TCPDF class to create custom Header and Footer
class ADMINRECEIPTTPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
//         $image_file = '/usr/share/nginx/gold_admin/assets/img/hk_logo.png';
//         $this->Image($image_file, 145, 10, 50, '', 'PNG', '', 'T', false, 330, '', false, false, 0, false, false, false);
        // Set font
        $this->SetTextColor(255, 255, 255); 
        $this->SetFont('helvetica', 'B', 25);
        // Title
       
       //  $this->Rect(105,5,100,20,'F','',$fill_color = array(0, 0, 0));
//     	$this->Cell(105, 18, 'Sales & Purchase', 0, 0, 'R', 0, '', 0, false, 'C', 'B');
    }

}

$obj_pdf = new ADMINRECEIPTTPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "Receipt";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);

$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->setFontSubsetting(false);

$obj_pdf->SetPrintFooter(false);
$obj_pdf->setCellHeightRatio(1.5);

// $obj_pdf->addTTFfont('/usr/share/nginx/gold_admin/application/helpers/tcpdf/fonts/DroidSansFallback.ttf');
// $obj_pdf->SetFont('DroidSansFallback', '', 10);
$obj_pdf->AddPage();
ob_start();


?>
<table style="width:100%">
	<tr>
		<td style="width:20%" rowspan="5"><img src="<?php echo BASE_PATH.'images/logo.png';?>"/></td>
		<td style="width:65%;font-size:12px;font-weight:bold;text-align:center">ASIA STRATEGIC MINING CORPORATION PTE LTD</td>
	</tr>
	<tr>
		<td style="font-size:8px;text-align:center">Co.Reg.No. 200908568W</td>
	</tr>
	<tr>
		<td style="font-size:8px;text-align:center">
			1,North Bridge Road, #06-23, High Street Centre, Singapore 179094
		</td>
	</tr>
	<tr>
		<td style="font-size:8px;text-align:center">Tel: 6338 0029  &nbsp;&nbsp;&nbsp;  Fax: 6338 3236</td>
	</tr>
	<tr>
		<td style="font-size:8px;text-align:center">Email: accounts@asmc.com.sg</td>
	</tr>
	<tr>
		<td coslpan="2" style="width:100%;font-size:14px;text-align:center;font-weight:bold">OFFICIAL RECEIPT</td>
	</tr>
	<tr>
		<td coslpan="2"  style="width:100%;font-size:10px;font-weight:bold;text-align:right">No. <?php echo $receipt_no;?></td>
	</tr>
	<tr>
		<td coslpan="2"  style="width:100%;text-align:right">Date: &nbsp;&nbsp;&nbsp;
		<span style="text-decoration:underline"><?php echo date('d-M-Y', strtotime($receipt_date));?></span></td>
	</tr>
</table>
<br/><br/>
<table style="width:100%" cellpadding="5px">
	<tr>
		<td style="width:30%">Received / Payment from :</td>
		<td style="width:70%;border-bottom:1px solid #000000;"><?php echo $receive_from;?></td>
	</tr>
	<tr>
		<td style="width:30%">I/C / Passport Number :</td>
		<td style="border-bottom:1px solid #000000;"><?php echo $nric;?></td>
	</tr>
	<tr>
		<td style="width:30%">The sum of : </td>
		<td style="border-bottom:1px solid #000000;">$<?php echo number_format($sum, 2, '.',',');?></td>
	</tr>
	<tr>
		<td style="width:30%">Cheque / TT no :</td>
		<td style="border-bottom:1px solid #000000;"><?php echo $cheque;?></td>
	</tr>
	<tr>
		<td style="width:30%">as full / partial payment:</td>
		<td style="border-bottom:1px solid #000000;"><?php echo $desc;?></td>
	</tr>
	<tr>
		<td style="width:30%">Agreement No : </td>
		<td style="border-bottom:1px solid #000000;"><?php echo $inv->{'inv_no'};?></td>
	</tr>
	<tr>
		<td colspan="2" style="height:30px"></td>
	</tr>
	<tr>
		<td colspan="2" style="width:100%; text-align:center;font-size:6px">
		This is electronic repceipt no signature is required<br/>
		Payment is only valid upon clearance of the cheque<br/>
		Admin Fee is non-refundable											
		</td>
	</tr>
</table>
<?php


    // we can have any view part here like HTML, PHP etc
$content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');

// $obj_pdf->Output('output.pdf', 'I');


 $obj_pdf->Output(RECEIPT_PATH.'admin/'.$inv->{'inv_id'}.'.pdf', 'F');
 
 if ($display == 1)
  	$obj_pdf->Output(RECEIPT_PATH.'admin/'.$inv->{'inv_id'}.'.pdf', 'I');

?>