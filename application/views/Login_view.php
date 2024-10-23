<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/bracketplus">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Login</title>

    <!-- vendor css -->
    <link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="css/login.css">
  </head>

  <body>

    <div class="loginPage">

      <div class="login-wrapper">
        <div class="LogoBox">
         
              <table>
                  <tr>
                      <td align="center"> <img src="<?php echo base_url(); ?>payin_logo.png" style="width:280px;"></td>
                      
                  </tr>
                  <tr>
                      
                          <td align="center"><p style="color:#DC2A25;font-size:18px;font-weight:bold;width:400px;">Online Recharge Services</p></td>
                      
                  </tr>
              </table>
               
                <br>
                
                
                
                
             
            
          </a>
        </div>
        <div class="loginBox" style="background-color:#0B3E80">
          <div class="heading">
            <h3 style="color:#FFFFFF">Login</h3>
            <p style="color:#FFFFFF">Enter your Username and Password to access your account</p>
          </div>
          <?php echo form_open('',array('id'=>"frmLogin",'method'=>'post'))?>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" id="txtUsername" name="txtUsername">
          </div><!-- form-group -->
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" id="txtPassword" name="txtPassword">            
          </div><!-- form-group -->
          <div class="actionRow">
            <button type="submit" class="btn-info buttonSignIn">Sign In</button>
            <a href="<?php echo base_url()."Forgot_password" ?>" class="forgotLink">Forgot password?</a>
          </div>
          <?php echo form_close();?>
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
          <div class="signUpLink" style="color:#FFFFFF">For Business Inquiry, Contact  <a href="" class="tx-info" style="color:#FFFFFF"><?php echo $CustomerCare; ?></a></div>
          <br>
          <a href="<?php echo base_url(); ?>PayIN.apk" class="tx-info" style="color:#FFFFFF">Download Android Application</a>
        </div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
