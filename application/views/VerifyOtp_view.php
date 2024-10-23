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

    <title>Verify Otp</title>

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
          <a href="<?php echo site_url('landingpage');?>">
            
              
               <!-- <img src="<?php echo base_url(); ?>MPM2.png" style="width:400px;">-->
               <h3>PAYIN.LIVE</h3>
                
                
                
                
             
            <p style="color:#DC2A25;font-size:18px;font-weight:bold">Money Transfer Solution</p>
          </a>
        </div>
        <div class="loginBox" style="background-color:#0B3E80">
          <div class="heading">
            <h3 style="color:#FFFFFF">Verify Otp</h3>
            <p style="color:#FFFFFF">Otp Sent To Your Registered Mobile Number</p>
          </div>
          <?php echo form_open('',array('id'=>"frmVerifyOtp",'method'=>'post'))?>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="OTP" id="txtOtp" name="txtOtp">
          </div><!-- form-group -->
          
          <div class="actionRow">
            <input type="hidden" name="hidUid" value="<?php echo $UserId; ?>">
            <input type="hidden" name="hidCrypt" value="<?php echo $insert_id; ?>">
            <button type="submit" class="btn-info buttonSignIn">Verify</button>
            <a href="<?php echo base_url()."login"; ?>" class="forgotLink">Back Login?</a>
          </div>
          <?php echo form_close();?>
          <div class="signUpLink" style="color:#FFFFFF">For Business Inquiry, Contact  <a href="" class="tx-info" style="color:#FFFFFF"></a></div>
        </div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
