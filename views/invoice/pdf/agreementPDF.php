<?php

tcpdf();

// Extend the TCPDF class to create custom Header and Footer
class AGREEMENTTPDF extends TCPDF {

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
	public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', '', 7);
        // Page number
        $this->Cell(0, 2, $this->getAliasNumPage(). ' | Private and confidential    v4.1 18.11.14', 'T', false, 'L', 0, '', 0, false, 'T', 'L');
    
    }

}

$obj_pdf = new AGREEMENTTPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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

$obj_pdf->SetPrintFooter(true);
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
<p style="text-decoration:underline">FUNDING AGREEMENT FOR PURCHASE OF STEAM COAL FROM INDONESIA</p>
<p></p><p></p><p></p>
<p>
<strong>THIS AGREEMENT</strong> is made this <?php echo date('d', strtotime($inv->{'inv_date'}));?> day of <?php echo date('M Y', strtotime($inv->{'inv_date'}));?> : 
</p>

<p>
Funding Agreement No: <strong><?php echo $inv->{'inv_no'};?></strong>
</p>
<p></p><p></p>
<p><strong>ASIA STRATEGIC MINING CORPORATION PTE.LTD. </strong><br/><br/>
(ACRA Registration No.  200908568W) of 1 North Bridge Road, #06-23, High Street Centre, Singapore 179094 <br/>
(hereinafter known as "the Contract Holder")
</p>
<p></p><p></p>
<p>And</p>
<p></p>
<p>
<table class="table" style="width:60%;border:none">
	<tr>
		<td>Name</td>
		<td><?php echo $inv->{'customer_name'};?></td>
	</tr>
	<tr>
		<td>NRIC No.</td>
		<td><?php echo $inv->{'customer_nric'};?></td>
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td><?php echo date('d M Y', strtotime($inv->{'customer_dob'}));?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><?php echo $inv->{'customer_addr'};?></td>
	</tr>
	<tr>
		<td style="height:40px">Correspondence Address<br/>(If Different)</td>
		<td><?php echo $inv->{'customer_addr2'};?></td>
	</tr>
	<tr>
		<td>Home No.</td>
		<td><?php echo $inv->{'customer_home_no'};?></td>
	</tr>
	<tr>
		<td>Mobile No.</td>
		<td><?php echo $inv->{'customer_mobile'};?></td>
	</tr>
	<tr>
		<td>Email Address</td>
		<td><?php echo $inv->{'customer_email'};?></td>
	</tr>
</table>
<p></p>
<p>(hereinafter known as "the Funder").</p>
<p></p>
<p></p><p></p>
<p>Both the Contract Holder and the Funder shall be referred to as "The Parties" collectively hereinafter.</p>

<br pagebreak="true"/>

<p><strong>WHEREAS:</strong></p>
<p>
<ol style="list-style-type:upper-alpha; ">
	<li>
	The Contract Holder has a legal and binding contract to supply Indonesian Steam Coal to various buyers from the date 18 August 2014.
	</li><br/><br/>
<li>The Contract Holder has a legal and binding contract with the concession holders and mine operators of the steam coal mine, C V Arjuna, East Kalimantan, Republic of Indonesia to purchase steam coal for a period of <?php echo $inv->{'inv_period'} / 12;?> years (renewable) from 11 July 2014.
</li><br/><br/>
<li>The Contract Holder is keen to secure Funders to fund part or the whole of the purchase and supply of Indonesian Steam Coal of the contract to supply Indonesian Steam Coal.
</li><br/><br/>
<li>The Funder is keen to fund the contract holder for part of the purchase and supply of Indonesian Steam Coal for a period of <?php echo $inv->{'inv_period'} / 12;?> years.
</li><br/><br/>
<li>The Parties have agreed to co-operate for their mutual benefit subject to the terms and conditions stipulated in this agreement below.
</li>
</ol>
</p>
<p><strong>IT IS HEREBY AGREED BY THE PARTIES AS FOLLOWS:</strong><br/>
<strong>1.	DEFINITIONS</strong>
<ol style="list-style-type:lower-alpha;">
<li>"Agreement" shall mean this Funding Agreement;
</li><br/><br/>
<li>"Arbitration"  shall mean that parties shall refer any disputes to arbitration and not pursue litigation in Courts;
</li><br/><br/>
<li>"Arbitration Centre" shall mean the International Arbitration Centre in Singapore;
</li><br/><br/>
<li>"Dispute Resolution" shall mean the procedures carried out by both parties to settle any disputes claims, and consequential issues through arbitration or conciliation;
</li><br/><br/>
<li>"Dollars" shall mean the Singapore Dollars and all shall refer to the currency for payments under this Agreement unless stated otherwise;
</li><br/><br/>
<li>"Early Redemption Fee" means the amount of fee that shall be deducted by the Contract Holder for redeeming the funds during the subsistence of the Funding Period
</li>


<br pagebreak="true"/>

<li>"Effective Date" means the date the agreement is executed and the date when the said fund is paid to the Contract Holder whichever is later
</li><br/><br/>
<li>"Funder" means the person who is providing the funding sum
</li><br/><br/>
<li>"Funding Sum" means the sum of money which the Funder has paid to the Contract Holder under this agreement
</li><br/><br/>
<li>"Funding Period" means the period of <?php echo $inv->{'inv_period'} / 12;?> years from the date that the funding sum is paid to the Contract Holder.
</li><br/><br/>
<li>"Coal" means Indonesian steam coal
</li><br/><br/>
<li>"Quality of coal" means Gross Calorific Value
</li><br/><br/>
<li>"Reserves" means the coal deposits in the concession
 </li><br/><br/>
<li>"Returns on Funds" means SGD$<?php echo number_format($inv->{"inv_unitprice"},2,'.',',');?> per metric ton purchased using the funds. 
</li><br/><br/>

</ol>
<strong>
2.	THE PURPOSE OF THE FUND</strong>
<ol style="list-style-type:lower-alpha;">
<li>The parties are fully aware and agree to use the funds raised pursuant to this agreement solely for the purchase of coal from Indonesia and supplying to various buyers.
</li><br/><br/>
<li>The parties agree that if the funds raised pursuant to this agreement may be used for other purposes provided there is written agreement by the Funder.
</li><br/><br/>
<li>The parties agree that the funds raised shall not be used for any illegal activities or activities which contravene any laws, rules, regulations in Singapore or Indonesia or anywhere else.
</li>
</ol>

<br pagebreak="true"/>

<p>
<strong>3. THE FUNDER’S OBLIGATIONS</strong>
<br/>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I. <span style="text-decoration:underline;">PAYMENT</span></strong>

<ol style="list-style-type:lower-alpha;">
<li>The Funder here agrees to pay to the Contract Holder the sum of SGD$<?php echo number_format($inv->{'inv_total'},2,'.',',');?> to fund the Contract Holder to purchase and supply the coal under its contractual obligation (hereinafter known as the “Funding Sum”).
</li><br/><br/>
<li>All payments shall be made in Singapore Dollars by cheques, cashier’s orders or telegraphic transfers. Bank charges, if any, to be borne by the Funder.
</li><br/><br/>
<li>The funding sum shall exclude any fees, taxes and goods and service tax if applicable.
</li><br/><br/>
<li>The Contract Holder shall give due and valid receipt of payments. 
</li>
</ol>
</p>
<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;II. <span style="text-decoration:underline;">FUNDING PERIOD</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Funder is aware that the sum paid to the Contract Holder is for a fixed period of <?php echo $inv->{'inv_period'} / 12;?> years from the effective date and Funder shall not redeem the funds until the expiry of funding period.  The funding period for this agreement shall expire on <?php echo date("t M Y", strtotime($inv->{'expired_date'}));?>. Once the Funding period commences on the effective date, this agreement shall run continuously for a period of <?php echo $inv->{'inv_period'} / 12;?> years.
  </li><br/><br/>
<li>There shall be no early termination of this agreement for any reason. Early redemption of the funds is subject to terms and conditions stipulated in this agreement.
</li>
</ol>
</p>
<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;III. <span style="text-decoration:underline;">EARLY REDEMPTION OF FUNDING SUM</span></strong>
<br/><br/>
<div style="display:block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The Funder is aware that in the event of early redemption, the following terms and conditions shall <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;apply:</div>
<ol style="list-style-type:lower-roman;">
<li>The Funder shall give written notice to the Contract Holder of his intention to redeem his funding sum.
</li><br/><br/>


<br pagebreak="true"/>


<li>The written notice shall be delivered to the registered office of the Contract Holder and shall be endorsed with the date and time of delivery of the written notice.
</li><br/><br/>
<li>The Contract Holder shall within 14 days approve the redemption by the Funder and within 30 days reimburse the Funder in accordance to the following:
	<ol style="list-style-type:lower-alpha;">
	<li>A minimum holding period of 1 year is required and no redemption can be done within the first year of the funding period. 
	</li><br/><br/>
	<li>If the redemption is done within the second year of the funding period, the Funder shall be imposed a 9% early redemption fee of the funding sum and shall receive the sum of SGD$<?php echo number_format($inv->{'inv_total'} -  ($inv->{'inv_total'} * 0.09),2,'.',',');?> plus the monthly returns accrued at the time of the redemption.
	</li><br/><br/>
	<li>If the redemption is done within the third year of the funding period, the Funder shall be imposed a 6% early redemption fee of the funding sum and shall receive the sum of SGD$<?php echo number_format($inv->{'inv_total'} - ($inv->{'inv_total'}* 0.06),2,'.',',');?> plus the monthly returns accrued at the time of the redemption.
	</li><br/><br/>
	<li>If the redemption is done within the fourth year of the funding period, the Funder shall be imposed a 3% early redemption fee of the funding sum and shall receive the sum of SGD$<?php echo number_format($inv->{'inv_total'} -($inv->{'inv_total'}* 0.03),2,'.',',');?> plus the monthly returns accrued at the time of the redemption.
	</li><br/><br/>
	<li>If the redemption is done within the fifth year of the funding period, the Funder shall not be imposed early redemption fee and shall receive the full funding sum of SGD$<?php echo number_format($inv->{'inv_total'},2,'.',',');?> plus the monthly returns accrued at the time of the redemption.
	</li>
	</ol>

</li>

</ol>

</p>
<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IV. <span style="text-decoration:underline;">WARRANTIES BY THE FUNDERS</span></strong>
<br/><br/>
<ol style="list-style-type:lower-alpha;">
<li>The Funder warranties that the Funds they are paying to the Contract Holder are from clear and clean source and is not in breach of Anti Money Laundering Act of Singapore or any other jurisdiction.
</li><br/><br/>

<br pagebreak="true"/>
<li>The Funder warranties that they are fully aware of the risks of funding the purchase and supply of coal and that the risks have been fully explained and understood by them.
</li><br/><br/>
<li>The Funder warranties that they will not in any way disclose or reveal the contracts and the sources of the Contract Holder to any one without the consent of the contract holder. Any such disclosure shall constitute a fundamental breach of this agreement.
</li><br/><br/>
<li>The Funder warranties that they will not in any way interfere in the management and operations of the Contract Holder. 
</li>
</ol>
</p>
<p>
<strong>4. THE CONTRACT HOLDER’S OBLIGATIONS</strong>
<br/>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I. <span style="text-decoration:underline;">FULL AND FRANK DISCLOSURE OF CONTRACTS</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Contract Holder shall make full and frank disclosure to the Funder all contracts that it is requiring the funds for and shall make disclosure of the agreements with the mine owner and or mine operator.
</li><br/><br/>
<li>The Contract Holder shall make full and frank disclosure to the Funder, all potential risks of the contracts and shall explain to the Funder the risks of funding the contracts.
</li><br/><br/>
<li>The Contract Holder shall secure from the funder a Risk Disclosure form indicating that the risks have been fully explained and that the Funder appreciates the risks and wishes to continue the fund.
</li>
</ol>
<br/>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;II. <span style="text-decoration:underline;">UTILIZATION OF THE FUNDS</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Contract Holder shall utilize the entire funds paid by the Funder for the purchase of steam coal from Indonesia.
</li>
</ol>
<br/>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;III. <span style="text-decoration:underline;">CALCULATION AND PAYMENT OF RETURNS</span></strong>
<ol style="list-style-type:lower-alpha;">

<?php

if ($inv->{'agreement_type'} == 3) {
if ($inv->{'inv_total'} == 10000)
	$percent = 0.01;
else if ($inv->{'inv_total'} >= 20000 && $inv->{'inv_total'} <= 30000)
	$percent = 0.02;
else if ($inv->{'inv_total'} >= 30000)
	$percent = 0.03;
}
else
	$percent = 0.03;
?>
<li>The Contract Holder shall pay to the Funder the sum of SGD$<?php echo number_format($inv->{'inv_total'} * $percent,2,'.',',');?> per month in accordance to Annex A.</li>


<br pagebreak="true"/>
<li>The Contract Holder shall pay the Funder the returns on the last day of each month commencing from the fourth month of the effective period and shall continue to do so throughout the funding period. If the payment of returns falls on a weekend or a Public Holiday then the returns will be credited the following working day.
</li><br/><br/>
<li>The Contract Holder shall not default on the payment of the returns during the subsistence of the funding period and any default shall constitute a breach of this funding agreement.
</li>
</ol>
</p>
<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IV. <span style="text-decoration:underline;">MANAGEMENT OF THE CONTRACTS AND FUNDS</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Contract Holder shall at all times exercise full care and diligence when executing and performing the contracts and shall ensure that all contractual obligations are satisfied in accordance to all contracts and agreements in relation to the purchase and supply of steam coal.
</li><br/><br/>
<li>Subject to the clause on Force Majuere below, any losses occasioned by the negligence, recklessness or illegal acts by the contract holder, its agents or servants shall be the losses of the Contract Holder and shall be solely borne by the Contract Holder.
</li><br/><br/>
<li>The Contract Holder shall provide monthly statements on the 5th of every month to the Funder on the utilisation of the funds as soon as practicable and in any event from the fourth month of the effective date.
</li>
</ol>
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V. <span style="text-decoration:underline;">WARRANTIES BY THE CONTRACT HOLDER</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Contract Holder warrants that they have done legal due diligence on the mines and are satisfied that the mines are operating legally and in accordance with all rules and regulations of Indonesia.
</li><br/><br/>
<li>The Contract Holder warrants that they have done technical due diligence on the mines and are satisfied as to the quality and quantity of the reserves in the mine and that the mine owners and or operators are in a position to supply the quantities of coal required to meet the contractual obligations of the Contract Holder.
</li>

<br pagebreak="true"/>

<li>The Contract Holder warranties that they will be liable for all taxes, insurance and other expenses in relation to the purchase and supply of the coal, save for personal income tax of the Funders.
</li></ol>
</p>

<p>
<strong>5. OTHER TERMS</strong><br/>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I. <span style="text-decoration:underline;">ASSIGNMENT OF THIS AGREEMENT</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Parties may assign this agreement, the rights and obligations under this obligation to third parties provided that notice is given to both parties in writing at least 30 days before the assignment.
</li><br/><br/>
<li>The assignment of this agreement by the Funder to his heirs or successors shall be permitted and the assignee shall be bound by the terms of this agreement.
</li><br/><br/>
<li>The assignment of this agreement by the Contract Holder to third parties shall be permitted and the assignee shall be bound by the terms of this agreement and its obligations under this agreement.
</li><br/><br/>
<li>The Contract Holder has the right to an early termination on the funding agreement at any time. The Contract Holder shall refund the full funding amount and any returns due and payable on that same month back to the Funder. 
</li></ol>
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;II. <span style="text-decoration:underline;">COMPLIANCE WITH THE LAW </span></strong>
<br/>
The Parties shall comply with all applicable provisions, local laws and regulations in force in Indonesia, Malaysia and Singapore including all such regional and central laws and regulations, meet all requirements to submit applications for licenses or permits when necessary and to act in full and strict compliance with the laws.
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;III. <span style="text-decoration:underline;">INDEMNITY </span></strong>
<ol style="list-style-type:lower-alpha;">
<li>The Contract Holder covenants and agrees to indemnify the Funder from any and all liabilities and or claims, damages, including legal fees, for any cause, action for injury or death of persons and damages, loss or destruction to property or environmental liabilities resulting from the Contract Holder’s use or occupancy of the mines, property or other tenements or its operations hereunder.
</li><br/><br/>
<li>The Funder covenants and agrees to indemnify the Contract Holder from any liabilities and or claims, damages, including legal fees, for any cause or action relating to the funds provided by the Funder.
</li></ol>
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IV. <span style="text-decoration:underline;">FORCE MAJEURE </span></strong>
<ol style="list-style-type:lower-alpha;">
<li>In the event of any unforeseen events which is not within the contemplation of The Parties to this agreement including but not limited to the following:
	<ol style="list-style-type:lower-roman;">
	<li>Natural disasters such as floods, storms, hurricanes, earthquakes, volcanic eruptions, tsunami, landslides, lightning, natural fire, drought, heat wave and other unusual severe weather;
	</li><br/><br/>
	<li>Unstable political and social conditions such as war, riots, labour dispute, demonstrations, revolutions and military operations;
	</li><br/><br/>
	<li>All other events which are not due to the negligence or recklessness of parties or not within the contemplation of parties or within the foresight of the parties and not within their control;
	</li>
	</ol>
	<br/><br/>this agreement and its obligations under this agreement shall be suspended.
</li><br/><br/>
<li>The Contract Holder shall endeavour to recommence operations as soon as practicable and in any event within 12 calendar months of the conclusion of the event.
</li>


<br pagebreak="true"/>
<li>In the event that the conditions mentioned above subsist for more than 18 months this agreement shall be voided and all obligations under this agreement shall cease to operate.
</li><br/><br/>
<li>The Contract Holder shall have the duty to mitigate the losses under the circumstances and shall endeavour to refund the Funder the full funding amount as soon as practicable.
</li>
</ol>
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V. <span style="text-decoration:underline;">TERMINATION OF THE AGREEMENT</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>This Agreement shall be terminated under the following  conditions:-<br/><br/>
	<ol style="list-style-type:lower-roman;">
	<li>Upon the expiry of the Funding Period
	</li><br/><br/>
	<li>By mutual agreement by parties on such terms and conditions which maybe agreed
	</li><br/><br/>
	<li>Upon early redemption of  the funding sum subject to the terms and conditions which apply to early redemption
	</li><br/><br/>
	<li>By any other or another agreement between parties which supercedes this agreement
	</li><br/><br/>
	<li>Upon unforeseen events occurring and subsisting for a period exceeding 18 months
	</li><br/><br/>
	<li>Upon any parties breaching this agreement and its terms therein contained and agreed.
	</li><br/><br/>
	<li>Upon liquidation of the Contract Holder or the Bankruptcy of the Funder.
	</li>
	</ol>
</li><br/><br/>
<li>This Agreement shall not be terminated in the following circumstances:
	<br/><br/><ol style="list-style-type:lower-roman;">
	<li>Upon acquisition or takeover or merger of the Contract Holder by the third party, in which the obligations of the Contract Holder will be assigned to the new entity and the obligations shall continue to the Funder.
	</li>
	
<br pagebreak="true"/>

	<li>In the event of death or physical or mental disability of the Funder, the next of kin shall be assigned the rights under this contract and the obligations of Parties will continue.
	</li><br/><br/>
	<li>In the event that there is fluctuation of prices or increase in costs which renders operations unprofitable, the Contract Holder shall bear the losses and shall continue to pay the Funder the returns during the funding period.
	</li><br/><br/>
	<li>In the event that there is an exchange rate fluctuation which renders the operations unprofitable, the Contract Holder shall bear the losses and shall continue to pay the Funder the returns during the funding period.
	</li>
	</ol>
</li>
</ol>
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VI. <span style="text-decoration:underline;">CONSEQUENCES OF TERMINATION</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>In the event that the agreement is terminated after the expiry of the funding period, the Contract Holder shall refund to the Funder all Funding Sums in full including all returns which are due and payable, if any.
</li><br/><br/>
<li>In the event that the agreement is terminated by mutual agreement, The Parties shall comply with the terms of the mutual agreement.
</li><br/><br/>
<li>In the event, that the agreement is terminated by early redemption, The Parties shall comply with the terms and conditions of the early redemption.
</li><br/><br/>
<li>In the event of this agreement being superseded by other agreements the terms in the new agreement shall apply.
</li><br/><br/>
<li>In the event that the Contract Holder is insolvent or is in receivership or liquidation, the Contract Holder shall without reservation recognise and acknowledge the Funder as a creditor of the Contract Holder and inform the liquidator or receiver of the same.
</li>
<br pagebreak="true"/>

<li>In the event that there is breach of the terms and conditions by the Contract Holder, the Contract Holder shall refund in full the funding sum including the returns which the Funder would have received during the funding period.
</li><br/><br/>
<li>In the event that the Funder breaches the terms of this agreement, the Contract Holder shall forfeit the Funding sum and any returns which has accrued or is due to the Funder.
</li>
</ol>
</p>

<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VII. <span style="text-decoration:underline;">DISPUTE RESOLUTION</span></strong>
<ol style="list-style-type:lower-alpha;">
<li>In the event that there is a dispute between Parties, Parties agree that they shall attempt to resolve the dispute by mediation and conciliation at the first instance.
</li><br/><br/>
<li>In the event that the dispute cannot be resolved through mediation or conciliation, The Parties shall refer the matter to a single arbitrator to arbitrate the dispute.
</li><br/><br/>
<li>The place of arbitration will be in Singapore.
</li>
</ol>
</p>


<p>
<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VIII. <span style="text-decoration:underline;">NOTICES</span></strong>

<ul style="list-style-type: none;">

<li>
All notices, letters and forms of communications made by The Parties shall be at the address and contact details as given at the beginning of this Agreement.  Service at the addresses shall be deemed good, effectual and valid notice, unless there has been a change in address notified in writing.
</li>
</ul>
</p>

<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>IX. <span style="text-decoration:underline;">JURISDICTION</span></strong>

<ul style="list-style-type: none;">

<li>
This Agreement is subject to the Laws of Singapore
</li>
</ul>
</p>
<br pagebreak="true"/>
<p>
<strong style="font-size:13px">IN WITNESS WHEREOF THE PARTIES STATED ABOVE SET THEIR HANDS HEREUNDER</strong>
<br/>
<table style="width:100%">
<tr>
	<td style="width:45%">
	
	<br/><br/><br/><br/><br/><br/>
	<hr/>
	ON BEHALF OF<br/>	                                                        
	ASIA STRATEGIC MINING CORPORATION<br/>
	Company Stamp<br/>
	Name: Ishak Bin Mohamed Basheere<br/>
	Designation:  Director

	</td>
	<td style="width:10%">
	</td>
	<td>
	<br/><br/><br/><br/><br/><br/>
	<hr/>
	 Company Stamp
	</td>
</tr>
<tr>
	<td colspan="3">
	<br/><br/><br/><br/><br/><br/>
	<hr style="width:45%"/>
	SIGNATURE OF WITNESS 1<br/>
	Name: Surina Awang<br/>
	Designation: General Manager

	</td>
</tr>

<tr>
	<td colspan="3">
	<img height="70px" src="<?php echo $signature;?>"/>
	<br/>
	<hr style="width:45%"/>
	SIGNATURE OF FUNDER<br/>
	Name: <?php echo $inv->{'customer_name'};?><br/>
	NRIC: <?php echo $inv->{'customer_nric'};?>

	</td>
</tr>
<tr>
	<td colspan="3">
	<br/><br/><br/><br/><br/><br/>
	<hr style="width:45%"/>
	SIGNATURE OF WITNESS 2<br/>
	Name: <?php echo $inv->{'agent_name'};?><br/>
	Designation: Agent<?php
	// if ($inv->{"creator_type"} == 'agent') {
// 		$sql = "select agent_name from agent where agent_id = ".$inv->{'creator_id'};
// 		$agent = $this->Invoice_model->fetchResult($sql, true);
// 		if (count($agent) > 0) {
// 			echo $agent->{'agent_name'};
// 		}
// 	}
// 	else if ($inv->{"creator_type"} == 'director') {
// 		$sql = "select dr_name from director where dr_id = ".$inv->{'creator_id'};
// 		$agent = $this->Invoice_model->fetchResult($sql, true);
// 		if (count($agent) > 0) {
// 			echo $agent->{'dr_name'};
// 		}
// 	}
// 	else if ($inv->{"creator_type"} == 'manager') {
// 		$sql = "select m_name from manager where m_id = ".$inv->{'creator_id'};
// 		$agent = $this->Invoice_model->fetchResult($sql, true);
// 		if (count($agent) > 0) {
// 			echo $agent->{'m_name'};
// 		}
// 	}
// 	else if ($inv->{"creator_type"} == 'admin') {
// 		$sql = "select admin_name from admin where admin_id = ".$inv->{'creator_id'};
// 		$agent = $this->Invoice_model->fetchResult($sql, true);
// 		if (count($agent) > 0) {
// 			echo $agent->{'admin_name'};
// 		}
// 	}
// 	
	?>
	</td>
</tr>

<tr>
	<td colspan="3">
	<br/><br/><br/><br/>
	Beneficiary (Optional)<br/>
	Name: <?php echo isset($beneficiary_name) ? $beneficiary_name : '';?><br/>
	NRIC:  <?php echo isset($beneficiary_nric) ? $beneficiary_nric : '';?>
	</td>
</tr>
</table>
<?php


    // we can have any view part here like HTML, PHP etc
$content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');

// $obj_pdf->Output('output.pdf', 'I');


 $obj_pdf->Output(AGREEMENT_PATH.$inv->{'inv_id'}.'.pdf', 'F');
 
 if ($display == 1)
  	$obj_pdf->Output(AGREEMENT_PATH.$inv->{'inv_id'}.'.pdf', 'I');

?>