<!DOCTYPE html>
<html>


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | Index</title>
    <!-- Favicon -->
    <link rel="icon" href="<?php echo base_url(); ?>assets2/img/dashboard/favicon.png" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/vendor/%40fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/argon.min5438.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/custom.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/Min1.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/Theme.css" rel="stylesheet" /> 

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
      <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
</head>

<body>
    <!-- Sidenav -->
     <?php include("elements/sdsidebar.php"); ?>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include("elements/sdheader.php"); ?>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-3">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Opening Bal</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_opening"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-gantt"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ 0</span>
                                        <span class="text-nowrap">Sales Weekly</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Payment</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_purchase"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ 0</span>
                                        <span class="text-nowrap">Sales Monthly</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        



                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->

                
               
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Recharge</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_recharge"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-areaspline"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_recharge_commission"></span></span>
                                        <span class="text-nowrap">Commission</span>
                                    </p>
                                </div>
                            </div>
                        </div>




                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->

                
               
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">BILLs</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_bills"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-areaspline"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_bills_commission"></span></span>
                                        <span class="text-nowrap">Commission</span>
                                    </p>
                                </div>
                            </div>
                        </div>

               
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">DMT</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_dmt"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_dmt_charge"></span></span>
                                        <span class="text-nowrap">DMT CHARGE</span>
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">INDO NEPAL</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_dmt_infonepal"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_dmt_infonepal_charge"></span></span>
                                        <span class="text-nowrap">INDO NEPAL CHARGE</span>
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">AEPS</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_aeps"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_aeps_commission"></span></span>
                                        <span class="text-nowrap">AEPS COMMISSION</span>
                                    </p>
                                </div>
                            </div>
                        </div>






                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">CLOSSING</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_clossing"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_dmt_charge"></span></span>
                                        <span class="text-nowrap">DMT CHARGE</span>
                                    </p>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-status bg-primary"></div>
                        <div class="card-body text-center">
                            <div class="card-category">User Details</div>
                            <div class="display-5 my-3">
                                <img width="100">
                            </div>
                            <ul class="list-unstyled leading-loose">
                                <li>
                                    <h5 class="user_name">Welcome, <span><?php echo $this->session->userdata("AgentBusinessName"); ?> !</span></h5>
                                    <h5 class="line-height-5 text-uppercase">NA</h5>
                                </li>
                                <li><i class="mdi mdi-email-outline text-danger f-18 mr-1"></i> <?php echo $this->session->userdata("Agentemailid"); ?>
                                </li>
                                <li><i class="mdi mdi-phone-message-outline text-primary f-18 mr-1"></i> +91 <?php echo $this->session->userdata("AgentMobile"); ?>
                                </li>
                                <li>CIN: NA</li>
                                <li>GST: NA</li>
                                <li><i class="mdi mdi-home-city-outline text-success f-18 mr-1"></i> <a href="#"
                                        data-target="#bankDetailsModal" data-toggle="modal">See Bank Details</a></li>
                                <li><i class="mdi mdi-account-settings-outline text-muted f-18 mr-1"></i> <a
                                        href="#">Manage Account</a>
                                </li>

                            </ul>
                            <div class="text-center mt-4 mb-2"> <a href="#" class="btn btn-primary btn-block"><i
                                        class="fa fa-inr"></i> LOAD MONEY</a> </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-9 col-lg-9 col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-12 col-xl-6 col-lg-6 col-md-4 col-sm-4">
                            <div class="card" id="news">
                                <div class="card-block slider-block">
                                    <div class="">
                                        <div id="demo" class="carousel slide" data-ride="carousel">
                                            <!-- Indicators -->
                                            <ul class="carousel-indicators">
                                                <li data-target="#demo" data-slide-to="0" class=""></li>
                                                <li data-target="#demo" data-slide-to="1" class=""></li>
                                                <li data-target="#demo" data-slide-to="2" class="active"></li>
                                            </ul>
                                            <!-- The slideshow -->
                                            <div class="carousel-inner">
                                                <div class="carousel-item">
                                                    <img src="<?php echo base_url(); ?>assets2/img/dashboard/dashbanner03.png"
                                                        class="img-fluid">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="<?php echo base_url(); ?>assets2/img/dashboard/dashbanner02.png"
                                                        class="img-fluid">
                                                </div>
                                                <div class="carousel-item active">
                                                    <img src="<?php echo base_url(); ?>assets2/img/dashboard/dashbanner01.png"
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                            <!-- Left and right controls -->
                                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </a>
                                            <a class="carousel-control-next" href="#demo" data-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-status bg-primary"></div>
                                <div class="card-body text-center">
                                    <div class="card-category">News</div>
                                    <marquee class="marq" direction="up" scrollamount="3" onmouseover="this.stop();"
                                        onmouseout="this.start();" style="min-height: 325px;">
                                        <p>
                                            <span
                                                style="color:#ffffff;background-color: #0000ff;padding: 2px 6px;border-radius: 4px;">
                                                <strong>Good News!!Dear Partners,ab apni mATM seva shuru ho gayi
                                                    hai,adhik jankari ke liye
                                                    company ke manager se sammpark kare. PayIN</strong>
                                            </span>
                                        </p>
                                    </marquee>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="bankDetailsModal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>BANK DETAILS</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="overflow:auto; height:400px;">
                            <div class="row">
                                <div class="col-md-12 text-center display-4">
                                    <h5>PARENT BANK DETAILS</h5>
                                </div>
                                <div class="col-md-12 col-sm-6 sptop">
                                    <table class="table table-bordered dataTable table-hover">
                                        <thead>
                                            <tr>
                                                <th>BANK NAME</th>
                                                <th>ACCOUNT NUMBER</th>
                                                <th>IFSC</th>
                                                <th>NAME</th>
                                                <th>BRANCH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat="bank in bankDetails.ParentBanks">
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center display-4">
                                    <h5>COMPANY BANK DETAILS</h5>
                                </div>
                                <div class="col-md-12 col-sm-6 sptop">
                                    <table class="table table-bordered dataTable table-hover tblbank">
                                        <thead>
                                            <tr>
                                                <th>BANK NAME</th>
                                                <th>ACCOUNT NUMBER</th>
                                                <th>IFSC</th>
                                                <th>NAME</th>
                                                <th>BRANCH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat="bank in bankDetails.CompanyBanks">
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                                <td>xxxxxxxxx</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding:5px;">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <?php include("elements/agentfooter.php"); ?>
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
                    <img src="<?php echo base_url(); ?>assets2/img/Processing.gif" style="width:70px;" />
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
                    <button type="submit" class="btn btn-primary" data-dismiss="modal"
                        id="btnsuccessPrint">Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
<script>
    $(document).ready(function()
  {
    //alert("her");
      today();
   
               });
    function today()
    {
       
        $("#day_opening").html("");

        
        //call ajax
        $.ajax({
            url: '<?php echo base_url(); ?>SuperDealer_new/Dashboard/getsummary',
            type: 'POST',
            cache: false,
            success: function (data) 
            {
              //  alert(data);
                var  x = JSON.parse(data);
                document.getElementById("day_opening").innerHTML = x.OPENING;
                document.getElementById("day_purchase").innerHTML = x.PURCHASE;
               // document.getElementById("day_revert").innerHTML = x.REVERT;
                document.getElementById("day_recharge").innerHTML = x.RECHARGE;
                document.getElementById("day_recharge_commission").innerHTML = x.RECHARGE_COMMISSION;
                document.getElementById("day_dmt").innerHTML = x.DMT;
                document.getElementById("day_dmt_charge").innerHTML = x.DMT_CHARGE;
                document.getElementById("day_clossing").innerHTML = x.CLOSSING;
                
             },
            error: function (data) {

            }
        });
        return true;

     }
</script>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="<?php echo base_url(); ?>assets2/js/argon.min5438.js?v=1.2.0"></script>
</body>

</html>