<!DOCTYPE html>
<!-- saved from url=(0048)http://maharshimulti.co.in/RETAILER/Home/Profile -->
<html class="chrome"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $this->white->getName(); ?></title>
    <!-- Favicon-->

    <link rel="icon" href="http://maharshimulti.co.in/Outside_favicon/63969ec4-c079-4d05-8558-b0f34337ac9b_MF.png" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="<?php echo base_url(); ?>vfiles/css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>vfiles/icon" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>vfiles/font-awesome.min.css">
    <!-- Wait Me Css -->
    <link href="<?php echo base_url(); ?>vfiles/waitMe.css" rel="stylesheet">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>vfiles/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-select.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>vfiles/waves.css" rel="stylesheet">
    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>vfiles/animate.css" rel="stylesheet">
    <!-- Morris Chart Css-->
    <link href="<?php echo base_url(); ?>vfiles/morris.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>vfiles/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/icofont.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>vfiles/globalallcss.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>vfiles/all-themes.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/daterangepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/StyleSheet.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>vfiles/jquery-1.10.2.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery.validate.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery.validate.unobtrusive.min.js.download"></script>
    <style>
        .navbar .navbar-toggle:before {
            content: '\E8D5';
            font-family: 'Material Icons';
            font-size: 26px;
        }

        .navbar .navbar-toggle:before {
            content: '\E8D5';
            font-family: 'Material Icons';
            font-size: 26px;
        }
           .for-blink1{color:#fff;
		animation: blink 2s linear infinite;display: initial;
        }
        @keyframes blink{
        0%{color: #fff;}
        50%{color: Yellow;}
        100%{color: red;}
        }
    </style>
</head>

<body class="theme layoutt-retailer" style="overflow-x: hidden;">

    <section class="layoutt">

        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <center><img src="<?php echo base_url(); ?>vfiles/serachimg.gif" class="img-responsive" style="height:200px;width:200px;"></center>

            </div>
        </div>


        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        <div class="search-bar">
            <div class="search-icon">
                <i class="material-icons">search</i>
            </div>
            <input type="text" placeholder="START TYPING...">
            <div class="close-search">
                <i class="material-icons">close</i>
            </div>
        </div>
        <!-- #END# Search Bar -->
        <!-- Top Bar -->



        <!-- -->
 <?php include("elements/v_aside.php"); ?>
        <!-- -->


         <?php include("elements/v_header.php"); ?>









    </section>
    



<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #dddddd !important;
        border-radius: 0px !important;
        height: 32px !important;
    }

    .editmodalprofile .select2.select2-container.select2-container--default {
        width: 100% !important;
    }

    .editmodalprofile .form-group select {
        background-size: 3.5%;
    }

    .ribbon {
        position: absolute;
        right: -2px;
        top: -2px;
        z-index: 1;
        overflow: hidden;
        width: 75px;
        height: 75px;
    }

        .ribbon span {
            font-size: 11px;
            color: #fff;
            text-align: center;
            font-weight: bold;
            line-height: 20px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            width: 100px;
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px;
            right: -21px;
            background: linear-gradient(#c5c5c5 0%, #868686 100%);
        }

    .list-group-item {
        border: none;
    }

    .field-validation-error {
        color: red;
    }

    .required:after {
        color: red;
        content: " *";
    }

    .toast-top-right1 {
        top: 78px;
        left: 81%;
    }

    .profile-kyc {
        background: yellow;
        border: 1px solid var(--border-color);
        padding: 0px 15px;
        margin-bottom: 10px;
    }

        .profile-kyc p {
            font-size: 36px;
            margin: 0px;
            letter-spacing: 3px;
            text-transform: capitalize;
            font-weight: 600;
        }
        #EditAadhaardocModal .btn:not(.btn-link):not(.btn-circle) i{color:#000;}
</style>
<link href="<?php echo base_url(); ?>vfiles/toastr.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>vfiles/toastr.js.download"></script>

<section class="content" style="margin:90px 0px 0px 0px; overflow-x:hidden;">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="profilebackground fullbodydycolorbg">
                    <div class="card " style="height:318px;">
                        <div class="ribbon"><span>RETAILER</span></div>

                        <div class="body">
                            <center>
                                    <div class="image" style="margin-top:3px;">
                                        <img src="<?php echo base_url(); ?>vfiles/saved_resource" class="img-circle" id="uploadprofileimg" alt="User" width="100" height="100" title="Click Me Upload Profile Image" style="cursor:pointer;" onclick="uploadimage(&#39;c3e92f06-c833-44e6-b3a1-6ede18ec6607&#39;)">

                                    </div>

                                <div class="msg" style="padding-top:12px; font-size:19px; font-weight:600; color:#7a7676;">RAVIKANT</div>
                                <p style="margin-top:5px;font-size:14px;text-transform:uppercase;">Retailer Partner</p>

                            </center>
                            <div class="" style="margin-top:-1px;">
                                <div class="body body-profileclass" style="margin-bottom:11px;background-color:whitesmoke;min-height:113px;border-radius:5px;">
                                    <div class="profileupload fullbodydycolorbg">
                                        <h1 style="color:#fff;font-size:14px;font-weight:bold;margin-top:-7px;text-transform:uppercase;text-align:center;">
                                            <i class="fa fa-lock"></i>&nbsp;One Time Password Security (Login OTP)
                                        </h1>
                                        <div class="row" style="margin-bottom:-20px;">
                                            <div class="col-md-12">
<form action="http://maharshimulti.co.in/Manage/EnableTwoFactorAuthentication" enctype="multipart/form-data" method="post" style="padding-left:38px;padding-top:2px;"><input name="__RequestVerificationToken" type="hidden" value="h0RwhTob6auM9pUB3uGTbhUP5uLgiFKgtVpyH6fdS4cODTX90VIa84V1NSPi1ttQ6xWLj-tT1Hae8rC-RbYwyJzKEptrHKp5K829C9N17xa4kge5A5Xs6cANVIB5bEAj0e1ZyXn7JZKtMngcpTiLlg2">                                                        <center>
                                                            <button type="submit" class="btn  btn-circle-lg waves-effect waves-circle waves-float" style="margin-top:-4px;height:70px;width:70px;background-color:whitesmoke;margin-left:-33px;">
                                                                <span style="font-size:20px;font-weight:700;color:red;">OTP - OFF</span>
                                                            </button>
                                                        </center>
</form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Profile-Upload-->
                                    <div class="newupdateprofile" id="EditProfileimageModal" style="display:none;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:whitesmoke;display:none;">
                                                    <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload Profile Image</h4>
                                                    <button type="button" class="btn bg-grey waves-effect closeprofile profilecloses" style="margin-top: 4px; margin-left: -3px; height:34px;" data-dismiss="modal">
                                                        <span style="top:-2px;color:black;">x</span>
                                                    </button>
                                                </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadProfileimage" enctype="multipart/form-data" method="post">                                                    <div class="modal-body" style="margin-top:0px;">
                                                        <div class="body">
                                                            
                                                                <div class="row clearfix">
                                                                    <input type="text" id="txtprofileid" name="txtprofileid" style="display:none;">
                                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label labeldfdffd">
                                                                        <label for="email_address_2">Upload&nbsp;Image</label>
                                                                    </div>

                                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 newclassfg" style="padding-right:9px;">
                                                                        <div class="form-group">
                                                                            <div class="" style="border:1px solid #ddd;">
                                                                                <input type="file" class="form-control addclasimgup" id="file" name="file">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn bg-grey waves-effect uploadimgwork" disabled="" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                                        <span style="top:-2px;color:black;">Save Image</span>
                                                                    </button>
                                                                    <button type="button" class="btn bg-grey waves-effect profilecloses" style="margin-top: 4px; margin-left: -3px; height:34px;" data-dismiss="modal">
                                                                        <span style="top:-2px;color:black;">Close</span>
                                                                    </button>
                                                                </div>
                                                            
                                                        </div>
                                                    </div></form>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 registered-profile">
                <div class="card profilecard">
                    <div class="body profilebodyback profilelastdetail" style="margin-bottom:11px;background-color:whitesmoke;height:3px;">
                            <h1 style="color:#49586e;font-size:20px;font-weight:bold;margin-top:-13px;text-transform:uppercase;">
                                <img src="<?php echo base_url(); ?>vfiles/store.svg">
                                RAVIKANT
                                <a style="float:right;cursor:pointer;" id="Editaddresshide"><i class="fa fa-pencil-square-o" id="EditaddressModalssee" style="font-size:22px;margin-top:0px;" onclick="editeaddress('<?php echo $this->Common_methods->encrypt($this->session->userdata("DistId")); ?>')">Edit</i></a>
                            </h1>

                    </div>
                    <div class="body bodyprofileshow" style="margin-top:-19px;">
                        <ul class="list-group" id="list-groupwert" style="margin-bottom:;">
                            <li class="list-group-item">
                                <i class="fa fa-map-marker"></i> <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Registered Business Address</span>
                                <span>
                                        <p style="text-align:justify;margin-top:-12px;">HIMATNAGAR TA HIMATNAGAR DSABARKANMTHAGDFGDFGDFG</p>
                                </span>
                            </li>



                            <li class="list-group-item" style="margin-top:-19px;">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">&nbsp;Town&nbsp;/&nbsp;City</span>
                                    <p style="margin-top:4px;float:right;">CITY NOT FOUND !</p>
                            </li>
                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">&nbsp;District</span>
                                <p style="float:right;text-transform:uppercase;">Ahmedabad</p>
                            </li>
                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">&nbsp;State</span>
                                <p style="float:right;text-transform:uppercase;">Gujarat</p>
                            </li>
                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">&nbsp;Zip Code</span>
                                    <p style="float:right;margin-top:0px;">0</p>
                            </li>


                        </ul>


                        <div class="editmodalprofile" id="EditaddressModal" style="display:none">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:whitesmoke;">
                                        <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Update Address</h4>
                                    </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UpdateRetailerProfile" method="post">                                        <div class="modal-body" style="margin-top:0px;">
                                            <div class="body">
                                                
                                                    <div class="row clearfix">
                                                        <input type="text" id="txtid1" name="txtid1" style="display:none;">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Frim Name</label>
                                                        </div>

                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtfrimname" name="txtfrimname" placeholder="Enter Your Address" required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Address</label>
                                                        </div>

                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtaddress" name="txtaddress" placeholder="Enter Your Address" required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Town / City</label>
                                                        </div>

                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtcity" name="txtcity" placeholder="Enter Your Town/city " required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">State</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <select class="form-control" id="State" name="State" onchange="FillDistict()" required="required"><option value="">-- Select State--</option>
<option value="1">Andaman and Nicobar Islands</option>
<option value="2">Andhra Pradesh</option>
<option value="3">Arunachal Pradesh</option>
<option value="4">Assam</option>
<option value="5">Bihar</option>
<option value="6">Chandigarh</option>
<option value="7">Chhattisgarh</option>
<option value="8">Dadar Nagar Haveli</option>
<option value="9">Daman and Diu</option>
<option value="10">Delhi</option>
<option value="11">Goa</option>
<option value="12">Gujarat</option>
<option value="13">Haryana</option>
<option value="14">Himachal Pradesh</option>
<option value="15">Jammu and Kashmir</option>
<option value="16">Jharkhand</option>
<option value="17">Karnataka</option>
<option value="18">Kerala</option>
<option value="19">Lakshadweep</option>
<option value="20">Madhya Pradesh</option>
<option value="21">Maharashtra</option>
<option value="22">Manipur</option>
<option value="23">Meghalaya</option>
<option value="24">Mizoram</option>
<option value="25">Nagaland</option>
<option value="26">Orissa</option>
<option value="27">Pondicherry</option>
<option value="28">Punjab</option>
<option value="29">Rajasthan</option>
<option value="30">Sikkim</option>
<option value="31">Tamil Nadu</option>
<option value="32">Tripura</option>
<option value="33">Uttar Pradesh</option>
<option value="34">Uttarakhand</option>
<option value="35">West Bengal</option>
</select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">District</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <select class="form-control" id="District" name="District" required=""><option value="">-- Select District--</option>
<option value="1">Ahmedabad</option>
<option value="2">Amreli</option>
<option value="3">Anand</option>
<option value="4">Banas Kantha</option>
<option value="5">Bharuch</option>
<option value="6">Bhavnagar</option>
<option value="7">Dahod</option>
<option value="8">Gandhinagar</option>
<option value="9">Jamnagar</option>
<option value="10">Junagadh</option>
<option value="11">Kachchh</option>
<option value="12">Kheda</option>
<option value="13">Mahesana</option>
<option value="14">Narmada</option>
<option value="15">Navsari</option>
<option value="16">Panch Mahals</option>
<option value="17">Patan</option>
<option value="18">Porbandar</option>
<option value="19">Rajkot</option>
<option value="20">Sabar Kantha</option>
<option value="21">Surat</option>
<option value="22">Surendranagar</option>
<option value="23">The Dangs</option>
<option value="24">Vadodara</option>
<option value="25">Valsad</option>
</select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Zip Code</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtzipcode" name="txtzipcode" onkeypress="return isNumber(event)" placeholder="Enter Zip Code" required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer bank-modalpopu">
                                                        <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                            <span style="top:-2px;color:black;">Save Change</span>
                                                        </button>
                                                        <button type="button" class="btn bg-grey waves-effect" id="modalnonelist" style="margin-top: 4px; margin-left: -3px; height:34px;">
                                                            <span style="top:-2px;color:black;">Close</span>
                                                        </button>
                                                    </div>
                                                
                                            </div>
                                        </div></form>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-md-4" style="margin-top:-3px;">
                <div class="profilebackground fullbodydycolorbg">
                    <div class="card " style="height:533px;margin-top:-5px;">
                        <div class="body" style="margin-bottom:11px;background-color:#ddd;height:42px;margin-top:5px;">
                            <h1 style="color:#49586e;font-size:14px;font-weight:bold;margin-top:-16px;text-transform:uppercase;">
                                Joining Date
                                <a style="float:right;cursor:pointer;" onclick="editemobileandpancard(&#39;c3e92f06-c833-44e6-b3a1-6ede18ec6607&#39;)" title="Edit Information"><i class="fa fa-pencil-square-o" style="font-size:22px;margin-top:0px;">Edit</i></a>
                            </h1>
                            <p style="text-transform:uppercase;margin-top:-9px;color:#555;">10/16/2020 5:27:09 PM</p>

                        </div>
                        <div class="body" style="margin-top:-22px;">
                            <div class="profile-borders" id="profileshowtable">
                                <table border="1">
                                    <tbody><tr>
                                        <th>
                                            <p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Name</p>

                                        </th>
                                        <td><p style="text-transform:uppercase;margin-top:-7px;">RAVIKANT</p></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Email-ID</p>
                                        </th>
                                        <td><p style="text-transform:uppercase;margin-top:-7px;">newrcname@gmail.com</p></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Mobile</p>
                                        </th>
                                        <td><p style="text-transform:uppercase;margin-top:-7px;">8238232303</p></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Date of Birth</p>
                                        </th>
                                        <td>
                                                <p style="text-transform:uppercase;margin-top:-7px;">Data Not Found !</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><p>Firm&nbsp;Register&nbsp;No</p></th>
                                        <td><p>Firm&nbsp;Register&nbsp;No</p></td>
                                    </tr>
                                    <tr>
                                        <th><p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Aadharcard&nbsp;No</p></th>
                                        <td>
                                                <p style="text-transform:uppercase;margin-top:-7px;">428420344700</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Pancard&nbsp;No</p></th>
                                        <td>
                                                <p style="text-transform:uppercase;margin-top:-7px;">AOEPP4512N</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">GST No</p></th>
                                        <td>
                                                <p style="text-transform:uppercase;margin-top:-7px;">Data Not Found !</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Position</p></th>
                                        <td>
                                                <p style="text-transform:uppercase;margin-top:-7px;">Data Not Found !</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><p style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Business Type</p></th>
                                        <td>
                                                <p style="text-transform:uppercase;margin-top:-7px;">Data Not Found !</p>
                                        </td>
                                    </tr>
                                </tbody></table>

                            </div>
                            <!--Edit Pancard nad Name and Gst Number Modal Popup-->
                            <div class="editmodalprofile" id="EditnameandpancardModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Update Profile</h4>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UpdatePanccardandmobile" method="post">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix">
                                                            <input type="text" id="txtid2" name="txtid2" style="display:none;">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2" class="required">Name</label>
                                                            </div>

                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input class="form-control" id="txtname" name="txtname" placeholder="Enter Your Name" required="required" type="text" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2" class="required">Aadhaar No</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input class="form-control" id="txtaadhaarcard" maxlength="12" name="txtaadhaarcard" onkeypress="return isNumber(event)" placeholder="Enter Aadhaar Number" required="required" type="text" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2" class="required">Pancard No</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input class="form-control" id="txtpancard" maxlength="10" name="txtpancard" placeholder="Enter Pancard Number" required="required" style="text-transform:uppercase" type="text" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">GST IN</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input class="form-control" id="txtgst" maxlength="15" name="txtgst" placeholder="Enter GST Number" style="text-transform:uppercase" type="text" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">GST Type</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="selecttypegst" style="border:1px solid #ddd;">

                                                                        <select>
                                                                            <option>Select</option>
                                                                            <option>Composition Scheme</option>
                                                                            <option>Reguler Scheme</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2" class="required">Date Of Birth</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input class="form-control" id="dateofbirth" name="dateofbirth" placeholder="Ex:MM/DD/YYYY" required="required" type="date" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2" class="required">Position</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <select class="form-control" id="ddlPosition" name="ddlPosition" required="required"><option value="">Select Type</option>
<option value="Director">Director</option>
<option value="Authorized Signatory">Authorized Signatory</option>
</select>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2" class="required">Business Type</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                                <div class="form-group">
                                                                    <div class="">
                                                                        <select class="form-control for-select2 select2-hidden-accessible" id="ddlBusinessType" name="ddlBusinessType" required="required" tabindex="-1" aria-hidden="true"><option value="">Select Type</option>
<option value="Agriculture Machinery">Agriculture Machinery</option>
<option value="Agriculture Fertilizer">Agriculture Fertilizer</option>
<option value="Automobiles and Vehicles">Automobiles and Vehicles</option>
<option value="Automobile Tyre Supply and Service">Automobile Tyre Supply and Service</option>
<option value="Beauty and Wellness">Beauty and Wellness</option>
<option value="Advertising Agenices">Advertising Agenices</option>
<option value="accounting &amp; Tax Consultants">accounting &amp; Tax Consultants</option>
<option value="Employment Consultants">Employment Consultants</option>
<option value="Software Development and Sales">Software Development and Sales</option>
<option value="Photo and Video Studio">Photo and Video Studio</option>
<option value="Computer Repair &amp; Services">Computer Repair &amp; Services</option>
<option value="Tent And Awning Shops">Tent And Awning Shops</option>
<option value="Packers and Movers">Packers and Movers</option>
<option value="RealEstate Consultants">RealEstate Consultants</option>
<option value="Laundy and Dry Cleaner">Laundy and Dry Cleaner</option>
<option value="Matrimony Services">Matrimony Services</option>
<option value="Lawyers">Lawyers</option>
<option value="Charitable Organisation">Charitable Organisation</option>
<option value="Driving Classes">Driving Classes</option>
<option value="Elementary and Secondary Schools">Elementary and Secondary Schools</option>
<option value="Correspondance Courses">Correspondance Courses</option>
<option value="Other Events &amp; Entertainment">Other Events &amp; Entertainment</option>
<option value="Security Brokers and Dealers">Security Brokers and Dealers</option>
<option value="Collection Agency">Collection Agency</option>
<option value="fuel Service Stations">fuel Service Stations</option>
<option value="Government">Government</option>
<option value="Home Services">Home Services</option>
<option value="Hospitals and Healthcare">Hospitals and Healthcare</option>
<option value="Hotels, Restaurants and Food">Hotels, Restaurants and Food</option>
<option value="Insurance Sale">Insurance Sale</option>
<option value="Computers and Acessories">Computers and Acessories</option>
<option value="Silver Jewellery">Silver Jewellery</option>
<option value="Hardware Shop (Paint &amp; Building Materials)">Hardware Shop (Paint &amp; Building Materials)</option>
<option value="Mobile shop">Mobile shop</option>
<option value="Home Decor">Home Decor</option>
<option value="Bicycle Shop, Repair and Service">Bicycle Shop, Repair and Service</option>
<option value="Tours and Travel Agency">Tours and Travel Agency</option>
<option value="Trucks and Others">Trucks and Others</option>
<option value="Taxi and Car Rentals">Taxi and Car Rentals</option>
<option value="Cruises Service">Cruises Service</option>
<option value="Tuition and Classes">Tuition and Classes</option>
<option value="Cable Service Providers">Cable Service Providers</option>
<option value="Recharges and Bill Payments">Recharges and Bill Payments</option>
</select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-ddlBusinessType-container"><span class="select2-selection__rendered" id="select2-ddlBusinessType-container" title="Select Type">Select Type</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;" onclick="return fun()">
                                                                <span style="top:-2px;color:black;">Save Change</span>
                                                            </button>
                                                            <button type="button" id="profiletablenone" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-left: -3px; height:34px;" data-dismiss="modal">
                                                                <span style="top:-2px;color:black;">Close</span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-8 registered-profile" style="margin-top: -4px;">
                <div class="card profilecard" style="">
                    <div class="body profilebodyback" style="margin-bottom:11px;background-color:whitesmoke;height:42px;">
                        <h1 class="bankprofileac" style="color:#49586e;font-size:17px;font-weight:bold;margin-top:-16px;text-transform:capitalize;">

                            <img src="<?php echo base_url(); ?>vfiles/save.svg" class="bankimgchange">  Bank Account Information

                            <a style="float:right;cursor:pointer;" onclick="editebankinformation(&#39;c3e92f06-c833-44e6-b3a1-6ede18ec6607&#39;)" title="Edit Bank Information"><i class="fa fa-pencil-square-o" style="font-size:22px;margin-top:0px;">Edit</i></a>
                            <span style="float:right;">
                            </span>
                        </h1>
                    </div>
                    <div class="body bodyprofileshow" style="margin-top:-12px;">

                        <ul class="list-group bodyprofileshow-font" id="list-groupwertee" style="margin-bottom:27px;">
                            <li class="list-group-item" style="margin-top:-19px;">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Acc Holder Name</span>
                                    <p style="float:right;margin-top:0px;">DATA NOT FOUND !</p>
                            </li>
                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Bank Account No</span>
                                    <p style="margin-top:4px;float:right;">DATA NOT FOUND !</p>
                            </li>
                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">IFSC Code</span>
                                    <p style="float:right;margin-top:0px;">DATA NOT FOUND !</p>
                            </li>
                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Bank Name</span>
                                    <p style="margin-top:4px;float:right;">DATA NOT FOUND !</p>
                            </li>

                            <li class="list-group-item">
                                <span style="color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;font-weight:600;">Branch Address</span>
                                    <p style="float:right;margin-top:0px;">DATA NOT FOUND !</p>
                            </li>

                        </ul>


                        <!--Edit Bankinfromation Modal Poppup popup-->
                        <div class="editmodalprofile" id="EditBankinfoModal" style="display:none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color:whitesmoke;">
                                        <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Update Bank Infromation</h4>
                                    </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UpdateBankinfromation" method="post">                                        <div class="modal-body" style="margin-top:0px;">
                                            <div class="body">
                                                
                                                    <div class="row clearfix">
                                                        <input type="text" id="txtid3" name="txtid3" style="display:none;">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Account Holder</label>
                                                        </div>

                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtaccholder" name="txtaccholder" placeholder="Enter Your Account Holder Name" required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Bank&nbsp;Account</label>
                                                        </div>

                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtbankaccountno" name="txtbankaccountno" placeholder="Enter Your Bank Account Number" required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">IFS Code</label>
                                                        </div>

                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtifsc" name="txtifsc" placeholder="Enter Your IFSC " required="required" style="text-transform: uppercase;" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Bank Name</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtbankname" name="txtbankname" placeholder="Enter Bank Name " required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="email_address_2" class="required">Branch Address</label>
                                                        </div>
                                                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="" style="border:1px solid #ddd;">
                                                                    <input class="form-control" id="txtbranchaddress" name="txtbranchaddress" placeholder="Enter Branch Address " required="required" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="modal-footer bank-modalpopu">
                                                        <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                            <span style="top:-2px;color:black;">Update Account</span>
                                                        </button>
                                                        <button type="button" class="btn bg-grey waves-effect" id="modalnonelistbank" style="margin-top: 4px; margin-left: -3px; height:34px;" data-dismiss="modal">
                                                            <span style="top:-2px;color:black;">Close</span>
                                                        </button>
                                                    </div>
                                                
                                            </div>
                                        </div></form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-8 registered-profile registered-profilelast">
                <div class="card profilecard" style="">
                    <div class="body profilebodyback" style="margin-bottom:11px;background-color:whitesmoke;height:42px;">
                        <h1 style="float:left;color:#49586e;font-size:20px;font-weight:bold;margin-top:-13px;text-transform:capitalize;padding-bottom:1px;">
                            <i class="fa fa-file" style="font-size:24px;"></i>&nbsp;Upload Document
                        </h1>

                        <!--upload pancard-->
                        <div class="allpopuclass">
                            <!--Edit Address and Pincode Modal Poppup popup-->
                            <div class="addharcardup" id="EditAadhaardocModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload Aadhaar Card Document</h4>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadAadharcarddoc" enctype="multipart/form-data" method="post" novalidate="novalidate">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix">
                                                            <input type="text" id="txtaadharid" name="txtaadharid" style="display:none;">


                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-bottom:0px;">
                                                                <div class="form-group" style="margin:0px;">
                                                                    <div class="" style="border:1px solid #adadad;background: #fff;padding: 0px 6px;">
                                                                        <p style="margin: 0px;border-bottom: 1px solid #bbb;font-size: 10px;">  Front Image</p>  <input type="file" class="form-control" id="file0" name="file" style="color:red;height: 28px;padding: 2px 0px;" data-val="true" data-val-required="File is required">




                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="margin-bottom:0px;">
                                                                <div class="form-group" style="margin:0px;">
                                                                    <div class="" style="border:1px solid #adadad;background: #fff;padding: 0px 6px;">


                                                                        <p style="margin: 0px;border-bottom: 1px solid #bbb;font-size: 10px;">  Back Image </p> <input type="file" class="form-control" id="file1" name="file1" style="color:red;height: 28px;padding: 2px 0px;" data-val="true" data-val-required="File is required">


                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="padding:0px;margin-bottom:0px;">
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn bg-grey waves-effect btnssl2233" data-loading-text="&lt;i class=&#39;fa fa-spinner fa-spin &#39;&gt;&lt;/i&gt;" style=" margin-right:12px; height:45px !important;">
                                                                        <span style="top:-2px;color:black;">Save</span>
                                                                    </button>
                                                                    <button type="button" class="btn bg-grey waves-effect closeaadar" style="  height:45px !important;" data-dismiss="modal">
                                                                        <span style="top:-2px;color:black;">Close</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>




                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>
                            <!--Upload Pancard card Doc Moadl Popup-->
                            <div class="addharcardup addharcardup-second" id="EditPancarddocModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload Pancard Card Document</h4>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadPancardcarddoc" enctype="multipart/form-data" method="post">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix clearfix-widthq">
                                                            <input type="text" id="txtpancardid" name="txtpancardid" style="display:none;">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">Upload Image</label>
                                                            </div>

                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 rrdfggddwq">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input type="file" class="form-control" id="file" name="file">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                                <span style="top:-2px;color:black;">Save Change</span>
                                                            </button>
                                                            <button type="button" class="btn bg-grey waves-effect closeaadar" style="margin-top: 4px;  height:34px;" data-dismiss="modal">
                                                                <span style="top:-2px;color:black;">Close</span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>

                            <!--Upload ShopwithSalfie Doc Moadl Popup-->
                            <div class="addharcardup addharcardup-second" id="EditShopwithSalfiedocModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload Shop with Salfie Document</h4>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadShopwithSalfieddoc" enctype="multipart/form-data" method="post">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix clearfix-widthq">
                                                            <input type="text" id="txtpancardid" name="txtpancardid" style="display:none;">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">Upload Image</label>
                                                            </div>

                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 rrdfggddwq">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input type="file" class="form-control" id="fileSalfie" name="fileSalfie">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                                <span style="top:-2px;color:black;">Save Change</span>
                                                            </button>
                                                            <button type="button" class="btn bg-grey waves-effect closeaadar" style="margin-top: 4px;  height:34px;" data-dismiss="modal">
                                                                <span style="top:-2px;color:black;">Close</span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>
                            <!--Upload Registracion Certification  Doc Moadl Popup-->
                            <div class="addharcardup addharcardup-second" id="EditRegistractiondocModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload  Registraction Certificate Document</h4>
                                            <button type="button" class="btn bg-grey waves-effect closeprofile" style="margin-top: 4px; margin-left: -3px; height:34px;" data-dismiss="modal">
                                                <span style="top:-2px;color:black;">x</span>
                                            </button>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadRegistractionCertificatedoc" enctype="multipart/form-data" method="post">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix clearfix-widthq">
                                                            <input type="text" id="txtRegistractionid" name="txtRegistractionid" style="display:none;">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">Upload Image</label>
                                                            </div>

                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 rrdfggddwq">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input type="file" class="form-control" id="file" name="file">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                                <span style="top:-2px;color:black;">Save Change</span>
                                                            </button>
                                                            <button type="button" class="btn bg-grey waves-effect closeaadar" style="margin-top: 4px;  height:34px;" data-dismiss="modal">
                                                                <span style="top:-2px;color:black;">Close</span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>
                            <!--Upload Serviceaggremt card Doc Moadl Popup-->
                            <div class="addharcardup addharcardup-second" id="EditServicedocModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload Service Agreement Document</h4>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadServiceAggrementdoc" enctype="multipart/form-data" method="post">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix clearfix-widthq">
                                                            <input type="text" id="txtserviceid" name="txtserviceid" style="display:none;">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">Upload Image</label>
                                                            </div>

                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 rrdfggddwq">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input type="file" class="form-control" id="file" name="file">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                                <span style="top:-2px;color:black;">Save Change</span>
                                                            </button>
                                                            <button type="button" class="btn bg-grey waves-effect closeaadar" style="margin-top: 4px;  height:34px;" data-dismiss="modal">
                                                                <span style="top:-2px;color:black;">Close</span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>
                            <!--Upload Address Proof  Doc Moadl Popup-->
                            <div class="addharcardup addharcardup-second" id="EditAddressProofdocModal" style="display:none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color:whitesmoke;">
                                            <h4 class="modal-title" id="defaultModalLabel" style="color:black;">Upload Address Proof Document</h4>
                                            <button type="button" class="btn bg-grey waves-effect closeprofile" style="margin-top: 4px; margin-left: -3px; height:34px;" data-dismiss="modal">
                                                <span style="top:-2px;color:black;">x</span>
                                            </button>
                                        </div>
<form action="http://maharshimulti.co.in/RETAILER/Home/UploadAddressProofdoc" enctype="multipart/form-data" method="post">                                            <div class="modal-body" style="margin-top:0px;">
                                                <div class="body">
                                                    
                                                        <div class="row clearfix clearfix-widthq">
                                                            <input type="text" id="txtAddressproofid" name="txtAddressproofid" style="display:none;">
                                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                                                <label for="email_address_2">Upload Image</label>
                                                            </div>

                                                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7 rrdfggddwq">
                                                                <div class="form-group">
                                                                    <div class="" style="border:1px solid #ddd;">
                                                                        <input type="file" class="form-control" id="file" name="file">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn bg-grey waves-effect" style="margin-top: 4px; margin-right:12px; height:34px;">
                                                                <span style="top:-2px;color:black;">Save Change</span>
                                                            </button>
                                                            <button type="button" class="btn bg-grey waves-effect closeaadar" style="margin-top: 4px;  height:34px;" data-dismiss="modal">
                                                                <span style="top:-2px;color:black;">Close</span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                            </div></form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--upload pancard-->


                    </div>
                    <div class="body bodyprofileshow" style="margin-top:-25px;">
                        <ul class="list-group" style="">
                            <li class="list-group-item" style="margin-top:0px;">
                                <p style="font-weight:bold;color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;" class="required">Aadhaar Card</p>
                                <p style="color:brown;opacity:0.5;margin-top:-10px;border-bottom:1px dashed #999;">MANDATORY</p>
                                <p class="badge" style="margin-top:-38px;margin-right:0px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;"><a href="http://maharshimulti.co.in/Retailer_image/72fdb1c0-04f8-4094-8700-a92ef7fae928_download.jpg" style="cursor:pointer;text-decoration:none;color:#4a2400;" target="_blank">View</a></p>
                                        <p class="badge" style="margin-top:-38px;margin-right:48px;background-color:white;color:green;border:1px solid #dddddd;font-weight:400;cursor:pointer;width: 72px;">Approved</p>

                            </li>
                            <li class="list-group-item" style="margin-top:-15px;">
                                <p style="font-weight:bold;color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;" class="required">Pancard</p>
                                <p style="color:brown;opacity:0.5;margin-top:-10px;border-bottom:1px dashed #999;">MANDATORY</p>
                                <p class="badge" style="margin-top:-38px;margin-right:0px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;"><a href="http://maharshimulti.co.in/Retailer_image/d2caa6e7-4c14-43b3-a94e-89f5f261c8e2_download.jpg" style="cursor:pointer;text-decoration:none;color:#4a2400;" target="_blank">View</a></p>
                                        <p class="badge" style="margin-top:-38px;margin-right:48px;background-color:white;color:green;border:1px solid #dddddd;font-weight:400;cursor:pointer; width: 72px;">Approved</p>

                            </li>
                            <li class="list-group-item" style="margin-top:-15px;">
                                <p style="font-weight:bold;color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;" class="required">Shop with Salfie</p>
                                <p style="color:brown;opacity:0.5;margin-top:-10px;border-bottom:1px dashed #999;">MANDATORY</p>
                                <p class="badge" style="margin-top:-38px;margin-right:0px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;"><a href="http://maharshimulti.co.in/Retailer_image/200fbeb6-4599-4e48-80e7-9d6f1d05f9fd_download.jpg" style="cursor:pointer;text-decoration:none;color:#4a2400;" target="_blank">View</a></p>
                                        <p class="badge" style="margin-top:-38px;margin-right:48px;background-color:white;color:green;border:1px solid #dddddd;font-weight:400;cursor:pointer; width: 72px;">Approved</p>

                            </li>
                            <li class="list-group-item" style="margin-top:-15px;">
                                <p style="font-weight:bold;color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;">GST Certificate</p>
                                <p style="color:deepskyblue;opacity:0.5;margin-top:-10px;border-bottom:1px dashed #999;">OPTIONAL</p>
                                <p class="badge" style="margin-top:-38px;margin-right:0px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;"><a href="<?php echo base_url(); ?>vfiles/saved_resource" style="cursor:pointer;text-decoration:none;color:#4a2400;" target="_blank">View</a></p>
                                    <p class="badge" style="margin-top:-38px;margin-right:48px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;cursor:pointer;width: 72px;" onclick="uploadRegistractionCertificateDoc(&#39;c3e92f06-c833-44e6-b3a1-6ede18ec6607&#39;)">Upload</p>
                            </li>
                            <li class="list-group-item" style="margin-top:-15px;">
                                <p style="font-weight:bold;color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;">Service Agreement</p>
                                <p style="color:deepskyblue;opacity:0.5;margin-top:-10px;border-bottom:1px dashed #999;">OPTIONAL</p>
                                <p class="badge" style="margin-top:-38px;margin-right:0px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;"><a href="<?php echo base_url(); ?>vfiles/saved_resource" style="cursor:pointer;text-decoration:none;color:#4a2400;" target="_blank">View</a></p>
                                    <p class="badge" style="margin-top:-38px;margin-right:48px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;cursor:pointer;width: 72px;" onclick="uploadserviceDoc(&#39;c3e92f06-c833-44e6-b3a1-6ede18ec6607&#39;)">Upload</p>
                            </li>
                            <li class="list-group-item" style="margin-top:-17px;">
                                <p style="font-weight:bold;color:#7a7676;font-family:&#39;Open Sans&#39;,sans-serif;">Address Proof</p>
                                <p style="color:deepskyblue;opacity:0.5;margin-top:-10px;border-bottom:1px dashed #999;">OPTIONAL</p>
                                <p class="badge" style="margin-top:-38px;margin-right:0px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;"><a href="<?php echo base_url(); ?>vfiles/saved_resource" style="cursor:pointer;text-decoration:none;color:#4a2400;" target="_blank">View</a></p>
                                    <p class="badge" style="margin-top:-38px;margin-right:48px;background-color:white;color:black;border:1px solid #dddddd;font-weight:400;cursor:pointer;width: 72px;" onclick="uploadAddressProofDoc(&#39;c3e92f06-c833-44e6-b3a1-6ede18ec6607&#39;)">Upload</p>
                            </li>
                        </ul>
                    </div>

                </div>


            </div>
        </div>

    </div>
</section>

<!--Edit Address and Pincode Modal Poppup popup-->
<!--Upload Aadhaar card Doc Moadl Popup-->


<!--Upload Pancard card Doc Moadl Popup-->


<!--Upload Serviceaggremt card Doc Moadl Popup-->


<!--Upload Registracion Certification  Doc Moadl Popup-->


<!--Upload Address Proof  Doc Moadl Popup-->


<!--Upload Profile Image   Moadl Popup-->

<script src="<?php echo base_url(); ?>vfiles/jquery.min.js.download"></script>
<!-- Custom Js -->
<script src="<?php echo base_url(); ?>vfiles/basic-form-elements.js.download"></script>
<!-- Demo Js -->
<script src="<?php echo base_url(); ?>vfiles/bootstrap-select.js.download"></script>
<script src="<?php echo base_url(); ?>vfiles/demo.js.download"></script>
<script src="<?php echo base_url(); ?>vfiles/jquery.slimscroll.js.download"></script>
<script src="<?php echo base_url(); ?>vfiles/sweetalert-dev.js.download"></script>
<link href="<?php echo base_url(); ?>vfiles/sweetalert(1).css" rel="stylesheet">
<link href="<?php echo base_url(); ?>vfiles/select2.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>vfiles/select2.full.min.js.download"></script>


<script>
    $('.for-select2').select2();


</script>

<script>
    function ToastrMessage() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "positionClass": "toast-top-right1",
            "newestOnTop": false,
            "progressBar": true,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "200",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "show",
            "hideMethod": "hide"
        };
        //toastr.info('MY MESSAGE!');
    }
</script>

<script>
    $(document).ready(function()
    {
        var msg = '';
        var Successs = ""
        var Successs1 = ""
        if (Successs != "") {
             ToastrMessage();
            toastr.success(Successs);
        }
        if (Successs1 != "") {
            ToastrMessage();
            toastr.success(Successs1);
        }

         var Warning = ""
        if (Warning != "") {
            ToastrMessage();
            toastr.Warning(Warning);
        }

        var panMSG = '';
        if(msg !="")
        {
            //swal("File Uploaded!", msg, "success");

            ToastrMessage();
            toastr.success(msg);
        }

        //alert(panMSG);
        if (panMSG != null && panMSG != '') {
            //swal("Oops!", panMSG, "warning");

            ToastrMessage();
            toastr.success(panMSG);
        }
    })
</script>
<script type="text/javascript">
    function isNumber(evt) {
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
            return false;
        return true;
    }
</script>

<script>
    function FillDistict() {
        var State_id = $('#State').val();
    $.ajax({
        url: '/RETAILER/Home/FillDistict',
        type: "GET",
        dataType: "JSON",

        data: { State: State_id },
        success: function (cities) {
            $("#District").html("");
            $.each(cities, function (i, District) {
                $("#District").append(
                    $('<option></option>').val(District.Dist_id).html(District.Dist_Desc));
            });
        }
    });
  }
</script>

<!--edit address and prifile image -->
<script>
    function editeaddress(retailerid) {
        var url = '/Retailer/Dashboard/ShowRetailerprofile1'
        $.ajax({
            url: url,
            data: { retailerid: retailerid },
            cache: false,
            type: "POST",
            dataType: 'html',
            success: function (data) {
                var x = JSON.parse(data);
                 $("#txtid1").val(x.RetailerId);
                $("#txtfrimname").val(x.Frm_Name)
                $("#txtcity").val(x.city);
                $("#txtaddress").val(x.Address);
                $("#txtzipcode").val(x.Pincode);
                $("#State").val(x.State);
                $("#District").val(x.District);
                $('#EditaddressModal').show();
                $('#list-groupwert').hide();

           },
            error: function (request, status, error) {

                console.log(request.responseText);
            }
        });

    }

</script>

<!--edit Name and Pancrad and Gst Number  image -->
<script>

    $(document).ready(function () {


    var url = '/Retailer/Dashboard/AddressFieldcheck'
        $.ajax({
            url: url,
          success: function (data) {



                if (data.pancardPath != null && data.PSAStatus == "Y" && data.aadharcardPath != null && data.AadhaarStatus == "Y" && data.ShopwithSalfieStatus == "Y") {

                    $('#Editaddresshide').hide();
              }





            },
            error: function (reponse) {
                alert("error : " + reponse);
            }
        });
});


    function editemobileandpancard(retailerid) {

        var url = '/RETAILER/Home/Showmobileandpancardprofile'
        $.ajax({
            url: url,
            data: { retailerid: retailerid },
            cache: false,
            type: "POST",
            dataType: 'html',
            success: function (data) {

                var x = JSON.parse(data);

                 $("#txtid2").val(x.RetailerId);
                $("#txtname").val(x.RetailerName);
                $("#txtaadhaarcard").val(x.AadharCard);

                $("#txtpancard").val(x.PanCard);
                $("#txtgst").val(x.gst);
                $("#ddlPosition").val(x.Position);
                var date = x.dateofbirth;
                var dateTime = moment(date).format("YYYY-MM-DD");
                document.getElementById("dateofbirth").value = dateTime;
                $("#ddlBusinessType").val(x.BusinessType);
                if (x.pancardPath != null && x.PSAStatus=="Y")
                {
                 document.getElementById("txtpancard").readOnly = true;

                }
                if (x.aadharcardPath != null && x.AadhaarStatus == "Y" && x.ShopwithSalfieStatus=='Y') {
                  document.getElementById("txtaadhaarcard").readOnly = true;
                }
                if (x.pancardPath != null && x.PSAStatus == "Y" && x.aadharcardPath != null && x.AadhaarStatus == "Y" && x.ShopwithSalfieStatus=='Y'&& x.ShopwithSalfie!=null) {
                    document.getElementById("txtpancard").readOnly = true;
                      document.getElementById("txtaadhaarcard").readOnly = true;
                      document.getElementById("txtname").readOnly = true;
                    document.getElementById("txtgst").readOnly = true;
                    document.getElementById("dateofbirth").readOnly = true;

                }


                $('#EditnameandpancardModal').show();
                $('#profileshowtable').hide();
            },
            error: function (reponse) {
                alert("error : " + reponse);
            }
        });

    }

</script>


<!--edit Bank Information-->
<script>
    function editebankinformation(retailerid) {
        var url = '/RETAILER/Home/ShowBankinfo'
        $.ajax({
            url: url,
            data: { retailerid: retailerid },
            cache: false,
            type: "POST",
            dataType: 'html',
            success: function (data) {
                var x = JSON.parse(data);
                $("#txtid3").val(x.RetailerId);
                $("#txtaccholder").val(x.accountholder)
                $("#txtbankaccountno").val(x.Bankaccountno);
                $("#txtifsc").val(x.Ifsccode);
                $("#txtbankname").val(x.bankname);
                $("#txtbranchaddress").val(x.bankAddress);
                $('#EditBankinfoModal').show();
                $('#list-groupwertee').hide();
            },
            error: function (reponse) {
                alert("error : " + reponse);
            }
        });

    }

</script>
<!--Upload Aadhaar Card Doc Script-->
<script>
    function uploadaadhaarDoc(retailerid) {
        $("#txtaadharid").val(retailerid);
        $('#EditAadhaardocModal').show('');
    }
</script>


<!--Upload Pancard  Card Doc Script-->
<script>
    function uploadpancardDoc(retailerid) {
        $("#txtpancardid").val(retailerid);
        $('#EditPancarddocModal').show('');
    }
</script>
<script>
    function uploadShopwithSalfieDoc(retailerid) {
        $("#txtpancardid").val(retailerid);
        $('#EditShopwithSalfiedocModal').show('');
    }
</script>

<!--Upload Upload
Registraction Certificate  Doc Script-->
<script>
    function uploadRegistractionCertificateDoc(retailerid) {
        $("#txtRegistractionid").val(retailerid);
        $('#EditRegistractiondocModal').show('');
    }
</script>
<!--Upload Service Aggrement  Doc Script-->
<script>
    function uploadserviceDoc(retailerid) {
        $("#txtserviceid").val(retailerid);
        $('#EditServicedocModal').show('');
    }
</script>

<!--Upload Address Proof  Doc Script-->
<script>
    function uploadAddressProofDoc(retailerid) {
        $("#txtAddressproofid").val(retailerid);
        $('#EditAddressProofdocModal').show('');
    }
</script>

<!--Upload Profile Image Script-->
<script>
    function uploadimage(retailerid) {
        $("#txtprofileid").val(retailerid);
        $('#EditProfileimageModal')('show');
    }
</script>

<!--Delete Doc -->

<script type="text/javascript">

    function deleteDoc(retailerid, docname) {

    $.ajax({
        type: "POST", url: '/RETAILER/Home/DelereprofileDoc', data: { 'SSID': retailerid, 'Docname': docname }, dataType: 'json', cache: false, success: function (result) {
            if (result == "Success") {

                var url = '/RETAILER/Home/Profile';
                window.location.href = url;
            }
            else {

                var url = '/RETAILER/Home/Profile';
                window.location.href = url;
            }
        }
    });



    }

</script>


<script>
    function fun() {
        var calval = $("#dateofbirth").val();
        var now = new Date();
        var dateString = moment(now).format('YYYY-MM-DD');
        var a = moment(calval, 'YYYY-MM-DD');
        var b = moment(dateString, 'YYYY-MM-DD');
        var diffDays = b.diff(a, 'days');
        if (diffDays > 6575) {
            return true;
        }
        else {
            alert("Age should be minimum 18 year");
            return false;

        }


    }

</script>

<script>
    $(document).ready(function () {
        $("#modalnonelist").click(function () {
            $("#EditaddressModal").css("display", "none");
            $("#list-groupwert").css("display", "block");
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#modalnonelistbank").click(function () {
            $("#EditBankinfoModal").css("display", "none");
            $("#list-groupwertee").css("display", "block");
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#profiletablenone").click(function () {
            $("#EditnameandpancardModal").css("display", "none");
            $("#profileshowtable").css("display", "block");
        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#uploadprofileimg").click(function () {
            $("#EditProfileimageModal").css("display", "block");
            $(".profileupload").css("display", "none");
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".profilecloses").click(function () {
            $("#EditProfileimageModal").css("display", "none");
            $(".profileupload").css("display", "block");
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".closeaadar").click(function () {
            $("#EditAadhaardocModal ,#EditPancarddocModal,#EditShopwithSalfiedocModal ,#EditRegistractiondocModal ,#EditServicedocModal ,#EditAddressProofdocModal").css("display", "none");

        });
    });
</script>

<script>
    var $submit = $('.uploadimgwork');
    $submit.prop('disabled', true);
    $('.addclasimgup').on('input change', function () { //'input change keyup paste'
        $submit.prop('disabled', !$(this).val().length);
    });
</script>
<script>
    $('.btnssl2233').on('click', function () {
        var $this = $(this);
        $this.button('loading');
        setTimeout(function () {
            $this.button('reset');
        }, 500000);
    });
</script>



    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/datatablejquery.js.download"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>vfiles/bootstrap.js.download"></script>
    <!-- Autosize Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/autosize.js.download"></script>
    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.slimscroll.js.download"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/waves.js.download"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.countTo.js.download"></script>
    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/raphael.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/morris.js.download"></script>
    <!-- ChartJs -->
    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.flot.js.download"></script>
    <script>
        $(function () {
            var current = location.pathname;
            var chk = 0;
            $('#leftulbar li a').each(function () {
                var $this = $(this);
                // if the current path is like this link, make it active
                if ($this.attr('href').indexOf(current) !== -1) {
                    //alert("djdjdj")
                    $(this).closest("li").addClass("active");
                    if (chk == 5) {
                        return false;
                    }
                    chk++;
                }
            })
        })
    </script>


    <!-- Sparkline Chart Plugin Js -->
    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>vfiles/admin.js.download"></script>
    
    <!-- Demo Js -->
    <script src="<?php echo base_url(); ?>vfiles/demo.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/moment.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/daterangepicker.js.download"></script>
    <!--data table -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.dataTables.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/dataTables.bootstrap.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/dataTables.buttons.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/buttons.flash.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jszip.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>vfiles/vfs_fonts.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/buttons.html5.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/buttons.print.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery-datatable.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/bootstrap-material-datetimepicker.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/sweetalert.min.js.download"></script>
    <link href="<?php echo base_url(); ?>vfiles/datatable.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>vfiles/basic-form-elements.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/bootstrap-datepicker.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/bootstrap-datetimepicker.min.js.download"></script>









<!--Redirect to Index view with javascript-->


<script>
    function gocomplaint()
    {
        var url = '/RETAILER/Home/Complaint';
        window.location.href = url;
    }
</script>
<!-- Push Nitification using SignalR-->
<script src="<?php echo base_url(); ?>vfiles/jquery.signalR-2.4.0.min.js.download"></script>
<script src="<?php echo base_url(); ?>vfiles/hubs"></script>
<script type="text/javascript">

    window.onload = function () {
        //alert("chal gaya kya???");

        var hub = $.connection.notificationHub;
        //alert("notificationHub");
        //Client Call
        hub.client.broadcaastNotif = function (totalNotif) {
            //alert("broadcaastNotif");
            console.log("Notif Data: " + totalNotif);
            console.log("total items : " + totalNotif.length)
            if (totalNotif.length > 0) {
                $.each(totalNotif, function (i, obj) {
                    console.log("i : " + i);
                    console.log("Title : " + obj.Title);
                    console.log("Details : " + obj.Details);
                    console.log("DetailsURL : " + obj.DetailsURL);
                    //setNotification(obj.Title, obj.Details, obj.DetailsURL);
                    customnotify(obj.Title, obj.Details, obj.DetailsURL, obj.Id);
                });

            }
        };
        //$.connection.hub.start().done(function () { });
        $.connection.hub.start()
            .done(function () {
                console.log("Hub Connected!");

                //Server Call
                hub.server.getNotification();

            })
            .fail(function () {
                console.log("Could not Connect!");
            });
    };
</script>


<script> 
    function SetAsReaded(idn,url)
    {
        //alert("sjbskjdfbaaaaaaaaaaaaasjkdfb");
       // alert('maharshimulti.co.in');
        var urlSiteName = 'maharshimulti.co.in';
        var setObj = { Id : idn};
        var Url = "https://www." + urlSiteName +"/api/Notification/UpdateReadProperty";
        //alert(Url);
        $.ajax({
            type: "POST",
            //url: "/api/Values/SendNotification",
            url: Url,
            data: JSON.stringify(setObj),
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                //reset field
                //$("#myMessage").val("");
            },
            error: function (xhr,err) {
                console.log("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
                console.log("responseText: " + xhr.responseText);
            }
        });
        //window.open(url,"_blank");
    }
</script>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
    });
    function customnotify(title, desc, url, id) {
        if (Notification.permission !== "granted") {
           // alert("permission=granted");
            Notification.requestPermission();
        }
        else {
            //alert('');
            var notification = new Notification(title, {
                icon: '',
                body: desc,
            });

            /* Remove the notification from Notification Center when clicked.*/
            notification.onclick = function () {
                //alert("Click");
                SetAsReaded(id, url);
                notification.close();
            };


            ///* Callback function when the notification is closed. */
            notification.onclose = function () {
                SetAsReaded(id, url);
                notification.close();
                console.log('Notification closed');
            };
        }


    }
</script>

<!-- Push Nitification using SignalR END-->
<!--  Get Total  My Credit Balance-->
<script>
        function showoutstandingbal()
        {
            $("#showoutstandingbalance").empty();
            $.ajax({
                type: 'Post',
                url: "/RETAILER/Home/Chkbalance",
                dataType: 'html',
            cache: false,
            async: false,
            success: function (data) {
                var x = JSON.parse(data);
                var newRow =

 "<tr>" +
"<td><a href='/RETAILER/Home/Show_Credit_report_by_admin',style='text-decoration:none;cursor:pointer;'><p>My Credit From Admin</p></a></td>" +
"<td><p style='text-align:center;'>" + x.admincreditbal + "</p></td>" + "</tr>" +
"<tr>"+
 "<tr>" +
"<td><a href='/RETAILER/Home/Show_Credit_report_by_dealer',style='text-decoration:none;cursor:pointer;'><p>My Credit From Distributor</p></a></td>" +
"<td><p style='text-align:center;'>" + x.dealercreditbal + "</p></td>" + "</tr>" +
"<tr>";
  $('#showoutstandingbalance').append(newRow);
            }
        });
        }
</script>

<!--Transfer Total Balance Retailer To Retailer and Recived Balannce from Dealer and admin-->
<script>
        function showtransferbal()
        {
            $("#showtransferbalancetableid").empty();
            $.ajax({
                type: 'POST',
                url:'/RETAILER/Home/Totalbaltransfer',
                dataType:'html',
                cache:false,
                async:false,
                success: function(data)
                {
                       var x = JSON.parse(data);
                       var newRow =

    "<tr>" +
   "<td><a href='/RETAILER/Home/Retailer_to_retailer',style='text-decoration:none;cursor:pointer;'><p>Total&nbsp;Transfer&nbsp;Retailer&nbsp;to&nbsp;Retailer</p></a></td>" +
   "<td><p style='text-align:center;'>" + x.retailertoretailer + "</p></td>" + "</tr>" +
    "<tr>" +
    "<tr>" +
   "<td><a href='/RETAILER/Home/ReceiveFund_by_admin',style='text-decoration:none;cursor:pointer;'><p>Received&nbsp;From&nbsp;Admin</p></a></td>" +
   "<td><p style='text-align:center;'>" + x.admintoretailer + "</p></td>" + "</tr>" +
    "<tr>" +
    "<tr>" +
   "<td><a href='/RETAILER/Home/ReceiveFund_by_dealer',style='text-decoration:none;cursor:pointer;'><p>Received&nbsp;From&nbsp;Distributor</p></a></td>" +
   "<td><p style='text-align:center;'>" + x.dealertoretailer + "</p></td>" + "</tr>" +
    "<tr>";

   $('#showtransferbalancetableid').append(newRow);
            }
            });
        }
</script>










</body></html>