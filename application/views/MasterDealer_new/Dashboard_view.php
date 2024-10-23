<!DOCTYPE html>
<html>


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | Index</title>
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
    <!-- Sidenav -->
     <?php include("elements/mdsidebar.php"); ?>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include("elements/mdheader.php"); ?>
        <div class="header bg-primary pb-6">
     <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-3">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET1 Opening</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_opening"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-gantt"></i>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET1 Payment</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_purchase"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET1 Commission</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="COMMISSION"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-areaspline"></i>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET1 CLOSSING</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_clossing"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>



                    </div>
                                        <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET2 Opening</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="WL2OPENING"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-gantt"></i>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET2 Payment</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="WL2PURCHASE"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET2 Commission</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="COMMISSION2"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-areaspline"></i>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">WALLET2 CLOSSING</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="WL2CLOSSING"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
             <div class="container-fluid mt--6">
            <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-12 col-xl-6 col-lg-6 col-md-4 col-sm-4">
                            <div class="card">
                                <div class="card-status bg-primary"></div>
                                <div class="card-body text-center">
                                    <h2 class="card-category"> Bank Down</h2>
                                    
                                                          <table class="table table-bordered table-striped fixed_header  ">
              <thead class="thead-colored thead-primary "  >
                <tr>
                  <th>Sr.</th>
                  <th>Bank Name</th>
                  <th>Is Down?</th>
                  <th>NEFT</th>
                  <th>IMPS</th>
                  <th>AEPS</th>             
                </tr>
              </thead>
              <tbody>
              <?php 
            $i = 1;
            foreach($data_result as $result)
            {
       // print_r($result);exit;
                if($result->is_down == "1")
                {   
                  
                    ?>
                <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $result->bank_name; ?></td>
                <td><?php   
                if($result->is_down == "1") {
                    echo '<span class="btn btn-danger btn-sm">OFF</span>';
                }
                if($result->is_down == "0") {
                    echo '<span class="btn btn-success btn-sm">LIVE</span>';
                }   
                $imps_class = '';
                $aeps_class = '';
                if($result->neft_enabled == "1")
                {
                    $neft_class = 'btn btn-success btn-sm';
                 }
                if($result->neft_enabled == "0")
                {
                    $neft_class = 'btn btn-danger btn-sm';
                }
                if($result->rtgs_enabled == "1")
                {
                    $rtgs_class = 'btn btn-success btn-sm';
                }
                if($result->rtgs_enabled == "0")
                {
                    $rtgs_class = 'btn btn-danger btn-sm';
                }
                if($result->imps_enabled == "1")
                {
                    $imps_class = 'btn btn-success btn-sm';
                }
                if($result->imps_enabled == "0")
                {
                    $imps_class = 'btn btn-danger btn-sm';
                }
                if($result->aeps_enabled == "1")
                {
                    $aeps_class = 'btn btn-success btn-sm';
                }
                if($result->aeps_enabled == "0")
                {
                    $aeps_class = 'btn btn-danger btn-sm';
                }?></td> 
                <td><span class="<?php echo $neft_class; ?>"><?php echo $result->neft_enabled; ?></span></td>
                <td><span class="<?php echo $imps_class; ?>"><?php echo $result->imps_enabled; ?></span></td>
                <td><span class="<?php echo $aeps_class; ?>"><?php echo $result->aeps_enabled; ?></span></td>
 
            </tr>
        <?php   
        $i++;} } ?>
        </tbody>
     </table>
           
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-status bg-primary"></div>
                                <div class="card-body text-center">
                                    <h2 class="card-category">Bank List</h2>

                                    <table class="table table-bordered">
  <thead>
    <tr>
                  <th>Sr.</th>

                                                <th>BANK NAME</th>
                                                <th>ACCOUNT NUMBER</th>
                                                <th>IFSC</th>
                                                <th>NAME</th>
                                                <th>BRANCH</th>
                                            </tr>
  </thead>
  <tbody>
    <?php
    $i = 1;
                                            $rsltbanks = $this->db->query("select 

                                                '' as ImageUrl,
                                                CONCAT(b.bank_name,'-',a.account_number,'-',a.ifsc,'-',a.account_name) as BankDetails,
                                                '' as ReferenceNo,
                                                a.Id as ReferenceCode,
                                                b.bank_name as BankName,
                                                a.account_name as HolderName,
                                                a.account_number as AccountNo,
                                                a.ifsc as IFSCCode,
                                                a.branch as BranchName,
                                                '' as BankImage,
                                                a.Id,a.bank_id,a.account_name,a.account_number,a.ifsc,a.branch,a.add_date,b.bank_name from creditmaster_banks a left join tblbank b on a.bank_id = b.bank_id order by a.Id");
                                            foreach($rsltbanks->result() as $rwadminbank)
                                            {

                                             ?>
                                            <tr data-ng-repeat="bank in bankDetails.CompanyBanks">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $rwadminbank->BankName; ?></td>
                                                <td><?php echo $rwadminbank->AccountNo; ?></td>
                                                <td><?php echo $rwadminbank->IFSCCode; ?></td>
                                                <td><?php echo $rwadminbank->HolderName; ?></td>
                                                <td><?php echo $rwadminbank->BranchName; ?></td>
                                            </tr>
                                        <?php $i++;} ?>
  </tbody>
</table>
                                    
                                    
                                </div>
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
            url: '<?php echo base_url(); ?>MasterDealer_new/Dashboard/getsummary',
            type: 'POST',
            cache: false,
            success: function (data) 
            {
              //  alert(data);
                var  x = JSON.parse(data);
                document.getElementById("day_opening").innerHTML = x.OPENING;
                document.getElementById("WL2OPENING").innerHTML = x.WL2OPENING;
                document.getElementById("day_purchase").innerHTML = x.PURCHASE;
                document.getElementById("day_clossing").innerHTML = x.CLOSSING;
                document.getElementById("WL2CLOSSING").innerHTML = x.WL2CLOSSING;
                document.getElementById("WL2PURCHASE").innerHTML = x.WL2PURCHASE;
                document.getElementById("COMMISSION").innerHTML = x.COMMISSION;
                document.getElementById("COMMISSION2").innerHTML = x.COMMISSION2;

                
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