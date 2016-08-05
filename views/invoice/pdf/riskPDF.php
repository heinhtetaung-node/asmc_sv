<?php

tcpdf();

// Extend the TCPDF class to create custom Header and Footer
class RISKTPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = LOGO_PATH;
        $this->Image($image_file, 85, 10, 23, '', 'PNG', '', 'T', false, 330, '', false, false, 0, false, false, false);
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
        $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'R');
    
    }

}

$obj_pdf = new RISKTPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$title = "RISK DISCLOSURE";
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);

$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 8.5);
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

<p></p>
<p>
Funding Agreement No: <strong><?php echo $inv->{'inv_no'};?></strong>
</p>
<p style="text-align:center;font-size:15px;"><strong>Funding Risk Disclosure</strong>
</p>
<p>This brief statement does not disclose all of the risks and other significant aspects of funding. In light of the risks, you should undertake such transactions only if you fully understand the nature of the agreements (and contractual relationships) into which you are entering and the extent of your exposure to risk. Funding is not suitable for many members of the public. 
You should carefully consider whether funding is appropriate for you in light of your experience, objectives, financial resources and other relevant circumstances.
</p>
<p>
<strong>1 Sovereign Risk </strong>
<br/><br/>
Legislation in developing countries such as Indonesia can be difficult to interpret and contrary interpretations by government bureaucrats and civil servants may have adverse consequences for business structures or exploration arrangements. ASMC’s ability to carry on business in Indonesia is subject to political risk. ASMC’s operations are subject to extensive government legislation, the amendment of which could cause it to incur costs that materially and adversely affect its business and results of operations. 
</p>
<p>
<strong>2 Operational and Technical Difficulties / Infrastructure </strong>
<br/><br/>
Possible operational and technical difficulties might unexpectedly be encountered in achieving the Company’s objectives. These difficulties may be caused by failure to achieve the economic grade or coal quality postulated by geological interpretations to be used by the Company at any of the Company’s projects and may result in downgrading, termination or writing off of the respective exploration project. 
The coal tenement depend on the coal jetty and any disruption to, or decrease in the availability of capacity on, the port could materially and adversely affect ASMC’s business and results of operations. 
</p>

<p>
<strong>3 Indonesia Legal Risks </strong>
<br/><br/>
There are a number of legal, regulatory and compliance risks associated with undertaking a mining exploration/exploitation business in Indonesia including, without limitation:
<strong>
<ul>
<li>Changes in government regulatory policy (including in relation to foreign company investment in Indonesia). 
</li>
<li>Changes to minerals law in Indonesia including, relevant to ASMC’s Indonesia operations: 
</li><li>The amounts payable to the Indonesian government in connection with minerals exploration licenses and mining licenses; 
</li><li>The mining rights and privileges granted by operation of the minerals law in Indonesia; 
</li><li>Property access rights afforded to a minerals exploration license; and 
</li><li>Compliance costs associated with Indonesia environmental law. 
</li><li>Uncertainty associated with the exercise of the discretion left to the Mineral Resources Authority of Indonesia in connection with the application for a mining license. 
</li><li>New or increased Indonesia government taxes or duties or changes in Indonesia taxation laws. </li>
</ul>
</strong>
</p>
<p>
<strong>4 Expenditure risks </strong>
<br/><br/>
The outcome of exploration programs outlined in this Proposal will affect the future performance of the Company. There will be no revenue from the Company’s projects until a mine is approved and developed through to production. Mine development requires detailed budgeting based on a feasibility study to enable estimates of mine development expenditure. These estimates may vary and cause delays in development and changes in development plans. Overruns in expenditure estimates may impact ASMC’s ability to obtain sufficient funds to finance its expansion needs and future capital expenditure requirements. 
</p>

<br pagebreak="true"/>
<p></p><p></p>
<p>
ASMC’s capital expenditure projects may not be completed within the expected timeframe and within budget, or at all, and may not achieve the intended economic results. There are long lead times required in the purchase of mining equipment which leads to market risk between ordering and purchase. In the event 
that any project does not offer returns sufficient to increase the value of the Company, a business decision might be made that the project is not worthy of further development and that it should be written off. 
</p>

<p>
Commercial production may be curtailed or shut down for considerable periods of time, causing the Company to incur losses, due to any of the following factors: 
<strong>
<ul>
<li>Disruptions to the transport chain (road and jetty); 
</li><li>Lack of market demand; 
</li><li>Changes in government regulation; 
</li><li>Production allocations; or 
</li><li>Force majeure. </li>
</ul>
</strong>
</p>

<p>
<strong>
Failure by ASMC to pay license fees for each of its exploration/ exploitation licenses within specified timeframes may lead to grounds for revocation of those licenses. 
</strong></p>

<p><strong>5 Coal Markets and Prices </strong>
<br/><br/>
If the Company’s exploration/exploitation is successful and results in coal production, the marketability of the coal depends on the requirements and demands of the international marketplace. 
The Company may not be able to negotiate profitable sale or off take agreements. Customers may default in their contractual obligations. Potential defaults could include non-payment or failure to take delivery of contracted volumes. Should such a default occur, the Company may be unable to find other customers. Depressed coal prices would affect the Company’s business. Future revenues, operating results, profitability, future rates of growth and the carrying value of any properties held depend heavily on prevailing market prices for coal. Any substantial or extended decline in the price of coal would have a material adverse effect on the financial condition and results of operations. Various factors beyond the control of the Company will affect coal prices, including: 
<strong>
<ul>
<li>Exchange rates; 
</li><li>Domestic supplies of coal; 
</li><li>Economic conditions; 
</li><li>Marketability and quality of production; 
</li><li>Consumer demand; 
</li><li>Price trend for coal product types; 
</li><li>Price, availability and acceptability of alternate fuel sources; 
</li><li>Weather conditions; and 
</li><li>Government regulation. 
</li>
</ul>
</strong>
</p>
<p><strong>6 General Economic Risks </strong>
<br/><br/>
Changes in the general economic climate in which ASMC operates may adversely affect the financial performance of ASMC and its assets. Factors which contribute to that general economic climate include: 
<strong>
<ul>
<li>Contractions in the world economy or increases in the rate of inflation resulting from domestic or international conditions (including movements in domestic interest rates and reduced economic activity). 
</li><li>International currency fluctuations. 
</li><li>Changes in interest rates. 
</li><li>New or increased government taxes or duties or changes in taxation laws. 
</li><li>Changes in government regulatory policy.
</li>
</ul>
</strong>
</p>


<p>
<strong>7 Environmental Issues </strong>
<br/><br/>
Environmental Policies in relation to Global Warming and other greenhouse effects may reduce the demand for the coal and coal related products and may cause a drastic loss in demand.
<br/><br/>
The Funder understands and acknowledges the Funding Risk Disclosure. This clause integrated with the Funding Agreement clause 5. IV. B and C.  and shall not supersede it.                                  
</p>

<p></p>
<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>
<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>
<p></p><p></p><p></p>
Funder Name:  <?php echo $inv->{'customer_name'};?>
<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img height="70px" src="<?php echo $signature;?>"/>
	<br/>
	<?php
	if ($signature =='') {
		echo '<br/><br/><br/><br/>';
	}
	?>
Signature: ___________________________________ Date: <?php echo date('d M Y', strtotime($inv->{'inv_date'}));?>
<br/><br/><br/><br/><br/>
ASMC Representative:   Ishak Bin Mohamed Basheere
<br/>
	<br/>
	<br/><br/><br/><br/>
Signature: ___________________________________ Date: <?php echo date('d M Y', strtotime($inv->{'inv_date'}));?>

<br pagebreak="true"/>
<p></p><p></p><p></p><p>
<p>
<strong style="font-size:10px;text-align:center;">ADDITIONAL FUNDING RISK DISCLOSURE</strong>
<br/>

<p>Dear Funder:</p>
<p>As a result of the following information on your account application, The Asia Strategic Mining Corporation Pte Ltd (“ASMC”) is providing you with its additional funding risk disclosure before you open a funding account: </p>
<p>

<ul style="list-style-type:none">
<li><img src="images/checkbox.png"> Your annual income is less than $25,000 </li>

<li><img src="images/checkbox.png"> Your net worth is less than $25,000 </li>

<li><img src="images/checkbox.png"> You are retired  </li>

<li><img src="images/checkbox.png"> You are over 60 years of age</li>
</ul>
*Please tick the appropriate box relevant to your status.</p>
<p>While ASMC is prepared to open your account, it is required to advise you to consider the risks involved with funding. The risk of loss in funding can be substantial and may be inappropriate for you for the reason checked above; therefore, you must consider whether such funding is proper in light of your financial condition. Only Risk Capital (money that you are able to lose without adversely affecting your standard of living) should be utilized. ASMC recommends that you review the <b>Funding Risk Disclosure</b> in the Funding Agreement and/or discuss any concerns with your broker, lawyer or other financial advisor before finalizing your decision. 
</p>
<p><b>ACKNOWLEDGEMENT </b><br/>
I understand that the risks associated with funding may not be appropriate for me. However, I have read the <b>Funding Risk Disclosure</b> and I have considered the financial risks involved in funding with regard to my financial condition, and I wish to proceed with opening a funding account. 
</p>
<p></p><p></p><p></p><p></p>


Funder Name:  <?php echo $inv->{'customer_name'};?>
<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<img height="70px" src="<?php echo $signature;?>"/>
	<br/>
	<?php
	if ($signature =='') {
		echo '<br/><br/><br/><br/>';
	}
	?>
Signature: ___________________________________ Date: <?php echo date('d M Y', strtotime($inv->{'inv_date'}));?>
<br/><br/>
ASMC Representative:   Ishak Bin Mohamed Basheere
<br/>
<img height="70px" src="<?php echo $director_signature;?>"/>
	<br/>
	<?php
	if ($director_signature =='') {
		echo '<br/><br/><br/><br/>';
	}
	?>
	
Signature: ___________________________________ Date: <?php echo date('d M Y', strtotime($inv->{'inv_date'}));?>
<?php


    // we can have any view part here like HTML, PHP etc
$content = ob_get_contents();
ob_end_clean();
$obj_pdf->writeHTML($content, true, false, true, false, '');

// $obj_pdf->Output('output.pdf', 'I');


 $obj_pdf->Output(RISK_PATH.$inv->{'inv_id'}.'.pdf', 'F');
 
 if ($display == 1)
  	$obj_pdf->Output(RISK_PATH.$inv->{'inv_id'}.'.pdf', 'I');

?>