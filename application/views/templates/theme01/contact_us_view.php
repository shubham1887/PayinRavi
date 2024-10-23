<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $data["company_name"]; ?></title>
<meta charset="utf-8">
<?php include("template_assets/theme01/links.php"); ?>
	


</head>
<body id="page1">
<div class="bodykk"><div class="hedtop"></div>
</div>
<div class="body1">
  <div class="body2">
		<div class="main">
<!-- header -->
		<?php include("template_assets/theme01/header.php"); ?>
<!-- header end-->
		</div>
  </div>
</div>




<div class="body3">
		<div class="main">
<!-- content -->
<article id="content1">
  <div class="wrapper">
    <h2 class="under">Contact <?php echo $data["company_name"]; ?></h2>
    <div class="wrapper">
      <div style="text-align:justify;" class="contant-box">
        <h6>Our Registered office:</h6>
        
        
       
          	<?php
          		$CustomerCare_rslt = $this->db->query("select value from admininfo where param = 'CustomerCare' and host_id = 1");
        		$EmailId_rslt = $this->db->query("select value from admininfo where param = 'EmailId' and host_id = 1");
        		$OfficeAddress_rslt = $this->db->query("select value from admininfo where param = 'OfficeAddress' and host_id = 1");
        		$CompanyInfo_rslt = $this->db->query("select value from admininfo where param = 'CompanyInfo' and host_id = 1");
        		$Message_rslt = $this->db->query("select value from admininfo where param = 'Message' and host_id = 1");
        		
        	    $show_template_rslt = $this->db->query("select value from admininfo where param = 'show_template' and host_id = 1");
        		$ddltemplate_rslt = $this->db->query("select value from admininfo where param = 'web_template_id' and host_id = 1");
        	    $MplanKeyRslt = $this->db->query("select value from admininfo where param = 'MPLAN_KEY' and host_id = 1");
        	    
			    
        		$CustomerCare = $CustomerCare_rslt->row(0)->value;
        		$EmailId = $EmailId_rslt->row(0)->value;
        		$OfficeAddress = $OfficeAddress_rslt->row(0)->value;
        		$CompanyInfo = $CompanyInfo_rslt->row(0)->value;
        		$Message = $Message_rslt->row(0)->value;
          ?>
          	
         
        
        <div class="feature">
          <ul >
            <li><?php echo $data["company_name"]; ?><br />
             <p><?php echo $OfficeAddress; ?></p></li>
             <li>Contact: +91-<?php echo $CustomerCare; ?></li>
             <li>Email: <a href="mailto:<?php echo $EmailId; ?>"><?php echo $EmailId; ?></a><br />
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</article>
	  </div>
</div>
	


<div class="body3">
		<div class="main">
			<article id="content2">
				<div class="wrapper">
                <h2 class="under">Our Operators</h2>
                <div style="width:980px; background-color:#FFFFFF; height:70px; float:left; margin-top:10px; margin-bottom:10px;">
     <marquee direction="left" scrollamount="2" scrolldelay="2" width="980" height="70" behavior="scroll">
      <img src="../../template_assets/theme01/images/aircel.gif">
      <img src="../../template_assets/theme01/images/airtel.gif">
      <img src="../../template_assets/theme01/images/bsnl.gif">
      <img src="../../template_assets/theme01/images/docomo.gif">
      <img src="../../template_assets/theme01/images/idea.gif">
      <img src="../../template_assets/theme01/images/loop.gif">
      <img src="../../template_assets/theme01/images/mtnl.gif">
      <img src="../../template_assets/theme01/images/mts.gif">
      <img src="../../template_assets/theme01/images/reliance_mobile.gif">
      <img src="../../template_assets/theme01/images/tata_indicom.gif">
      <img src="../../template_assets/theme01/images/videocon.gif">
      <img src="../../template_assets/theme01/images/virgin_mobile.gif">
      <img src="../../template_assets/theme01/images/vodafone.gif">
      <img src="../../template_assets/theme01/images/AirtelDTH.gif">
      <img src="../../template_assets/theme01/images/dishtv.gif">
      <img src="../../template_assets/theme01/images/reliance_digitaltv.gif">
      <img src="../../template_assets/theme01/images/sun_direct.gif">
      <img src="../../template_assets/theme01/images/tata_sky.gif">
      <img src="../../template_assets/theme01/images/videocon_d2h.gif">
      <img src="../../template_assets/theme01/images/mblaze_scroller.gif">
      <img src="../../template_assets/theme01/images/mbrowse_scroller.gif">
      <img src="../../template_assets/theme01/images/reliance_netconnect_scroller.gif">
      <img src="../../template_assets/theme01/images/tataphoton_plus_scroller.gif">
      <img src="../../template_assets/theme01/images/tataphoton_whiz_scroller.gif">
      
      </marquee>
      </div></div>
			</article>
<!-- content end -->
		</div>
	</div>
		<div class="foter">
		  <div class="main">
		    <!-- footer -->
		    <footer>Copyright 2020 <?php echo $data["company_name"]; ?> - All Rights Reserved</footer>
		    <!-- footer end -->
		    </div>
</div>

</body>
</html>