
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | EditUser</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--Favicon-->
    <link href="<?php echo base_url(); ?>assets2/images/Favicon/favicon502.png" rel="icon" />
    <!--Favicon End-->
    <script src="<?php echo base_url(); ?>mpayfiles/jquery.min.js"></script>
    <link href="<?php echo base_url(); ?>mpayfiles/RG-DEv.css" rel="stylesheet" />
    <!--sweet alert-->
    <script src="<?php echo base_url(); ?>js/Sweetalert/sweetalert.min.js"></script>
    <link href="<?php echo base_url(); ?>js/Sweetalert/sweetalert.css" rel="stylesheet" />
    <!--sweet alert End-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!--Font Style-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <!--Font Style End-->
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Font Awesome End-->
    <!-- Page plugins -->
    <link href="<?php echo base_url(); ?>mpayfiles/argon.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>mpayfiles/Main1.css" rel="stylesheet" />
    <!--Color theme style-->
    <link href="<?php echo base_url(); ?>mpayfiles/Theme.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
</head>
<body>
    
    <!--sweet alert start-->

     <?php

        if(isset($MESSAGEBOXTYPE))
        {
        if($MESSAGEBOXTYPE == "success" or $MESSAGEBOXTYPE == "error"  or $MESSAGEBOXTYPE == "info")
        {?>
            <script>swal("", "<?php echo $MESSAGEBOX; ?>", "<?php echo $MESSAGEBOXTYPE; ?>")</script>
        <?php }

        } ?>


    <?php
        if($this->session->flashdata("MESSAGEBOXTYPE") == "success" or $this->session->flashdata("MESSAGEBOXTYPE") == "error")
        {?>
       
            <script>swal("", "<?php echo $this->session->flashdata("MESSAGEBOX"); ?>", "<?php echo $this->session->flashdata("MESSAGEBOXTYPE"); ?>")</script>
       <?php  } ?>  


    <?php include("elements/sdsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include("elements/sdsidebar.php"); ?>
        <!-- Header -->
        

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-3">
                <div class="col-lg-4 col-9">
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Edit User</a></li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12 mg-t-20">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pd-xs-10">

                        <form action="<?php echo base_url(); ?>SuperDealer_new/EditUser" method="post">
                            <input name="__RequestVerificationToken" type="hidden" value="lqhZGW2Q63NueCU43LDw7_MAIVAeWk553vTxvvM8cFZ9RkJkXx3NuWtk6_eoSdkqaDrVSIFCYxgrPCkC59K9vLNAg8jOwgL-4KgcmkoHU_s1" />

                            <input type="hidden" id="hidUserId" name="hidUserId" 
                            value="<?php echo $this->Common_methods->encrypt($regData["UserId"]); ?>">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Select User</label>
                                        <div class="editor-field">
                                            <select class="form-control" id="UserType" name="UserType" required="">
                                                <option value="">Select</option>
                                                    <option value="Agent">Retailer</option>
                                            </select>
                                            <script language="javascript">
                                                document.getElementById("UserType").value = '<?php echo $regData["UserType"]; ?>';
                                            </script>
                                            <span class="field-validation-valid error" data-valmsg-for="UserType" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Scheme Name</label>
                                        <div class="editor-field">
                                            <select class="form-control" data-val="true" data-val-required="Scheme is required." id="Pattern" name="Pattern" required="">
                                                <option value="">Select</option>
                                                <?php
                                                    $check_CREATE_GROUP_rights = $this->db->query("select user_id from access_rights_alloted where user_id = ? and rights_id = (select Id from access_rights where rights_name = 'CREATE_GROUP')",array($this->session->userdata("SdId")));
                                                    if($check_CREATE_GROUP_rights->num_rows() == 1)
                                                    {
                                                        $rsltgroups = $this->db->query("select Id,group_name from tblgroup where user_id = ?",array($this->session->userdata("SdId")));
                                                    }
                                                    else
                                                    {
                                                        $rsltgroups = $this->db->query("select Id,group_name from tblgroup where user_id = 1 and Id = (select downline_scheme from tblusers where user_id = ?)",array($this->session->userdata("SdId")));
                                                    }
                                                    foreach($rsltgroups->result() as $rwgp)
                                                    {?>
                                                        <option value="<?php echo $rwgp->Id; ?>"><?php echo $rwgp->group_name; ?></option>
                                                    <?php }
                                                 ?>
                                            </select>
                                            <script language="javascript">
                                                document.getElementById("Pattern").value = '<?php echo $regData["Pattern"]; ?>';
                                            </script>
                                                <span class="field-validation-valid error" data-valmsg-for="Pattern" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <div class="editor-field">
                                            
                                            <input readonly class="form-control" data-val="true" data-val-maxlength="The field FirstName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Valid characters: Alphabets and min 3." data-val-regex-pattern="[a-zA-Z]{3,30}$" data-val-required="First Name is required." id="FirstName" name="FirstName" placeholder="Enter First Name" required="" type="text" value="<?php echo $regData["FirstName"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="FirstName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <div class="editor-field">
                                            
                                            <input readonly class="form-control" data-val="true" data-val-maxlength="The field MiddleName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" id="MiddleName" name="MiddleName" placeholder="Enter Middle Name"  type="text" value="<?php echo $regData["MiddleName"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="MiddleName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <div class="editor-field">
                                            
                                            <input readonly class="form-control" data-val="true" data-val-maxlength="The field LastName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Valid characters: Alphabets and min 3." data-val-regex-pattern="[a-zA-Z]{3,30}$" data-val-required="Last Name is required." id="LastName" name="LastName" placeholder="Enter Last Name"  type="text" value="<?php echo $regData["LastName"]; ?>" />


                                            <span class="field-validation-valid error" data-valmsg-for="LastName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>PAN Number</label>
                                        <div class="editor-field">
                                            
                                            <input readonly class="form-control" data-val="true" data-val-regex="Invalid pancard format." data-val-regex-pattern="[A-Z]{5}\d{4}[A-Z]{1}" data-val-required="Pancard is required." id="PanCardNo" name="PanCardNo" placeholder="Enter pancard" required="" type="text" value="<?php echo $regData["PanCardNo"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="PanCardNo" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <div class="editor-field">
                                            
                                            <input readonly class="form-control" data-val="true" data-val-maxlength="The field ContactNo must be a string or array type with a maximum length of &#39;10&#39;." data-val-maxlength-max="10" data-val-regex="Contact no should be 10 digits." data-val-regex-pattern="[0-9]{10}" data-val-required="Contact Number is required." id="ContactNo" name="ContactNo" placeholder="Enter mobile no" required="" type="text" value="<?php echo $regData["ContactNo"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="ContactNo" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Email ID</label>
                                        <div readonly class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field EmailID must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Invalid email ID format." data-val-regex-pattern="^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" data-val-required="EmailID is required." id="EmailID" name="EmailID" placeholder="Enter Email ID" required="" type="text" value="<?php echo $regData["EmailID"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="EmailID" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Aadhar No.</label>
                                        <div class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field AadharNo must be a string or array type with a maximum length of &#39;16&#39;." data-val-maxlength-max="16" data-val-regex="Aadhar no should be 12 digits." data-val-regex-pattern="[0-9]{12,14}" data-val-required="Aadhar No is required." id="AadharNo" name="AadharNo" placeholder="Enter Aadhar no" required="" type="text" value="<?php echo $regData["AadharNo"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="AadharNo" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Shop Address</label>
                                        <div class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field ShopAddress must be a string or array type with a maximum length of &#39;250&#39;." data-val-maxlength-max="250" data-val-minlength="Shop Address is required." data-val-minlength-min="3" data-val-required="Shop Address is required." id="ShopAddress" name="ShopAddress" placeholder="Enter Shop Address" required="" type="text" value="<?php echo $regData["ShopAddress"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="ShopAddress" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <div class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field PermanentAddress must be a string or array type with a maximum length of &#39;250&#39;." data-val-maxlength-max="250" data-val-minlength="Permanent Address is required." data-val-minlength-min="3" data-val-required="Permanent Address is required." id="PermanentAddress" name="PermanentAddress" placeholder="Enter Address" required="" type="text" value="<?php echo $regData["PermanentAddress"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="PermanentAddress" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Pin Code</label>
                                        <div class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field PinCode must be a string or array type with a maximum length of &#39;6&#39;." data-val-maxlength-max="6" data-val-regex="Pincode should be 6 digits." data-val-regex-pattern="[0-9]{6}" data-val-required="Pincode is required." id="PinCode" name="PinCode" placeholder="Enter Pincode" required="" type="text" value="<?php echo $regData["PinCode"]; ?>" />
                                            <span class="field-validation-valid error" data-valmsg-for="PinCode" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div class="editor-field">
                                            <select class="form-control select-list" data-val="true" data-val-maxlength="The field StateName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-required="State Name is required." id="StatesName" name="StatesName" required="" onchange="fillcityddl()">
                                                <option value="">Select</option>

                                                <?php
                                                $statelist = $this->db->query("select state_id,state_name from tblstate order by state_name");
                                                foreach ($statelist->result() as $rw) 
                                                {?>
                                                    <option value="<?php echo $rw->state_id; ?>"><?php echo $rw->state_name; ?></option>
                                                <?php }
                                                 ?>
                                            </select>
                                            <script language="javascript">
                                                document.getElementById("StatesName").value = '<?php echo $regData["StateName"]; ?>';
                                                
                                            </script>

                                            <span class="field-validation-valid error" data-valmsg-for="StateName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>District</label>
                                        <div class="editor-field">
                                            <select class="form-control select-list" data-val="true" data-val-maxlength="The field CityName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-required="City Name is required." id="CityName" name="CityName" required="">
                                                <option value="">Select</option>

                                                <?php
                                                $citylist = $this->db->query("select city_id,city_name from tblcity where state_id = ? order by city_name",array($regData["StateName"]));
                                                foreach ($citylist->result() as $rwc) 
                                                {?>
                                                    <option value="<?php echo $rwc->city_id; ?>"><?php echo $rwc->city_name; ?></option>
                                                <?php }
                                                 ?>
                                            </select>
                                            <script language="javascript">
                                                document.getElementById("CityName").value = '<?php echo $regData["CityName"]; ?>';
                                                
                                            </script>
                                            <span class="field-validation-valid error" data-valmsg-for="CityName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5><b>Bank A/C Details</b></h5>
                                    <hr />
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <div class="editor-field">
                                            <select class="form-control select-list" data-val="true" data-val-maxlength="The field BankName must be a string or array type with a maximum length of &#39;50&#39;." data-val-maxlength-max="50" data-val-required="Bank Name is required." id="BankName" name="BankName" required=""><option value="">Select</option>
</select>
                                            <span class="field-validation-valid error" data-valmsg-for="BankName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>Account No.</label>
                                        <div class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field AccountNo must be a string or array type with a maximum length of &#39;20&#39;." data-val-maxlength-max="20" data-val-regex="Bank Account No between 9-20 digit." data-val-regex-pattern="[0-9]{9,20}" data-val-required="Account No is required." id="AccountNo" name="AccountNo" placeholder="Enter Account No" required="" type="text" value="" />
                                            <span class="field-validation-valid error" data-valmsg-for="AccountNo" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <div class="editor-field">
                                            
                                            <input class="form-control" data-val="true" data-val-maxlength="The field IFSCCode must be a string or array type with a maximum length of &#39;11&#39;." data-val-maxlength-max="11" data-val-regex="Invalid IFSC Code format." data-val-regex-pattern="^[A-Za-z]{4}0[A-Z0-9a-z]{6}$" data-val-required="IFSC Code is required." id="IFSCCode" name="IFSCCode" placeholder="Enter IFSC" required="" type="text" value="" />
                                            <span class="field-validation-valid error" data-valmsg-for="IFSCCode" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="">
                                        <input type="submit" class="btn btn-primary" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="<?php echo base_url(); ?>mpayfiles/jquery.memeber.route.min.1.7.2.js"></script>
    <script src="/bundles/jquery?v=wBUqTIMTmGl9Hj0haQMeRbd8CoM3UaGnAwp4uDEKfnM1"></script>

    <script src="/bundles/jqueryval?v=WDt8lf51bnC546FJKW5By7_3bCi9X11Mr6ray08RhNs1"></script>

    <link href="<?php echo base_url(); ?>mpayfiles/select2.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>mpayfiles/select2.min.js"></script>
    <script>
        $(".select-list").select2({
            placeholder: "Select"
        });
        $(".select-list").select2({
            placeholder: "Select"
        });
    </script>

        <div class="container-fluid"><?php include("elements/footer.php"); ?>
        </div>
    </div>
        <!--Start Bottom to top-->
        <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
        <!--End Bottom to top-->

        <div id="ModalSearchTrxn" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Transaction Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table" style="border-bottom:1px solid #ddd;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transaction ID</th>
                                            <th>Trans. AMT</th>
                                            <th>Charged AMT</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="srchTxnDate"></td>
                                            <td id="srchTxnOrderID"></td>
                                            <td id="srchTxnAmount"></td>
                                            <td id="srchTxnCharge"></td>
                                            <td id="srchTxnStatus"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mg-t-10 table-responsive">
                                <table class="table table-transdet" id="srchTxnDetails"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Start Page Plugins-->
        <!--Modal Processing-->
        <div class="modal" id="ProcessingBox">
            <div class="modal-dialog" style="margin-top:15%;">
                <div class="modal-content" style="background: transparent;">
                    <div class="modal-body ConfirmBox text-center" style="padding:20px !important;">
                        <h3 class="text-white">Processing your transaction...</h3>
                        <img src="<?php echo base_url(); ?>mpayfiles/Processing.gif" style="width:70px;" />
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="ConfirmBox" style="margin-top:30%;">
            <div class="modal-dialog">
                <div class="modal-content" style="background: #ddd;">
                    <div class="modal-header ConfirmBoxhead">
                        <h4 class="modal-title">Message</h4>
                        <button type="button" class="close" aria-hidden="true" onclick="closepopup();">×</button>
                    </div>
                    <div class="modal-body ConfirmBox" style="padding:20px !important;">
                        <p id="message"></p>
                    </div>
                    <div class="modal-footer" id="btnsuccessBox" style="display:none;">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsuccessPrint">Print</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal End-->

        <script src="<?php echo base_url(); ?>mpayfiles/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/bootstrap.bundle.min.js"></script>
        <script src="https://demos.creative-tim.com/argon-dashboard-pro/assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/jquery.scrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="<?php echo base_url(); ?>mpayfiles/Chart.min.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="<?php echo base_url(); ?>mpayfiles/argon.min.js"></script>
        <!-- Demo JS - remove this in your project -->
        <script src="<?php echo base_url(); ?>mpayfiles/demo.min.js"></script>
        <script>
            // ===== Scroll to Top ====
            $(window).scroll(function () {
                if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                    $('#return-to-top').fadeIn(200);    // Fade in the arrow
                } else {
                    $('#return-to-top').fadeOut(200);   // Else fade out the arrow
                }
            });
            $('#return-to-top').click(function () {      // When arrow is clicked
                $('body,html').animate({
                    scrollTop: 0                       // Scroll to top of body
                }, 500);
            });

            function closepopup() {
                jQuery('#ConfirmBox').attr("style", "display:none;");
            };
        </script>
        <!--Start Calendar Plugins-->
        <script src="<?php echo base_url(); ?>mpayfiles/jquery-ui.js"></script>

        <script>
            $('.editable-on-click').click(function (e) {
                var input = $(this).find('input');
                if (input.length) {
                    input.trigger('click');
                    return;
                }
                var textarea = $(this).find('textarea');
                if (textarea.length) {
                    textarea.trigger('click');
                    return;
                }
            });
            $('.fileUpload').click(function (e) {
                e.stopPropagation();
            });
            jQuery(function () {
                jQuery('#txtSearchTrxn').keyup(function () {
                    var refNumber = jQuery('#txtSearchTrxn').val();
                    if (refNumber.length === 15) {
                        jQuery.post('/Reports/SubShowTransaction', { transactionRef: refNumber }, function (response) {
                            if (response != null && response != '') {
                                $('#ModalSearchTrxn').modal('show');
                                jQuery('#srchTxnDate').html(response.TxnDatetime);
                                jQuery('#srchTxnOrderID').html(response.OrderID);
                                jQuery('#srchTxnAmount').html(response.TxnAmount);
                                jQuery('#srchTxnCharge').html(response.ServiceCharge);
                                jQuery('#srchTxnStatus').html(response.TxnStatus === 'Success' ? '<span class="success" style="margin-left:0px;">Success</span>' : response.TxnStatus === 'Pending' ? '<span class="pending" style="margin-left:0px;">Pending</span>' : '<span class="failure" style="margin-left:0px;">' + response.TxnStatus + '</span>');
                                if (response.ServiceID === 9) {
                                    var htmlStr = '<tr><td>Remitter Mobile</td><td>' + response.TxnNumber + '</td></tr><tr><td>Beneficiary Name</td><td>' + response.RecipientName + '</td></tr><tr><td>Bank</td><td>' + response.BankName + '</td></tr><tr><td>Account No</td><td>' + response.AccountNo + '</td></tr><tr><td>IFSC</td><td>' + response.IfscCode + '</td></tr><tr><td>MODE</td><td>' + response.PaymentType + '</td></tr><tr><td>RRN</td><td>' + response.RRN + '</td></tr><tr><td>Opening Balance</td><td>' + response.OpeningBal + '</td></tr><tr><td>Charged Amount</td><td>' + response.ServiceCharge + '</td></tr><tr><td>Customer Convenience Fee (CCF)</td><td>' + response.TxnNumber + '</td></tr><tr><td>Response Message</td><td>' + response.Message + '</td></tr>'; if (response.TxnStatus === 'Success') { htmlStr += '<tr><td>Receipt</td><td><a href="/Recharge/ViewReceipt/' + response.OrderID + '" target="_blank" class="download">View Receipt</a></td></tr>'; }
                                    jQuery('#srchTxnDetails').html(htmlStr);
                                } else {
                                    var htmlStr = '<tr><td>RRN</td><td>' + response.RRN + '</td></tr><tr><td>Opening Balance</td><td>' + response.OpeningBal + '</td></tr><tr><td>Charged Amount</td><td>' + response.ServiceCharge + '</td></tr><tr><td>Customer Convenience Fee (CCF)</td><td>' + response.TxnNumber + '</td></tr><tr><td>Response Message</td><td>' + response.Message + '</td></tr>'; if (response.TxnStatus === 'Success') { htmlStr += '<tr><td>Receipt</td><td><a href="/Recharge/ViewReceipt/' + response.OrderID + '" target="_blank" class="download">View Receipt</a></td></tr>'; }
                                    jQuery('#srchTxnDetails').html(htmlStr);
                                }
                            } else {
                                jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                                jQuery('#message').html('Transaction not found.');
                                jQuery('#message').attr("style", "color:red;");
                            }
                        });
                    }
                });
            });
        </script>
        
</body>
</html>
