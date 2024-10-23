<!DOCTYPE html>
<html>


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
<style type="text/css">
    .fixed_header {
  display:block;
  overflow:auto;
  height:290px;
 
}
  
    

</style>
</head>
  <script type="text/javascript">
        function getLastTransactions()
          {
             
              $.ajax
              ({
                      type: "GET",
                      url: '<?php echo base_url(); ?>Retailer/Dashboard/getLastTransactions',
                      cache: false,
                      success: function(html)
                      {
                          document.getElementById("userbalancediv").innerHTML = html;
                      }
                  
              });
              
          } 
          function getLastTransactionsdmt()
          {
             
              $.ajax
              ({
                      type: "GET",
                      url: '<?php echo base_url(); ?>Retailer/Dashboard/getLastTransactionsdmt',
                      cache: false,
                      success: function(html)
                      {
                          document.getElementById("userbalancediv2").innerHTML = html;
                      }
                  
              });
              
          } 
        
  </script>
<body>
    <!-- Sidenav -->
     <?php include("elements/agentsidebar.php"); ?>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include("elements/agentheader.php"); ?>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Opening</h5>
                                           <span class="h2 font-weight-bold mb-0 ng-binding"> E ₹ <span id="day_opening"></span></span><br>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">D ₹ <span id="day_openingdmt"></span></span>
                                            <span class="h1 font-weight-bold mb-0 ng-binding"><span id=""></span></span>
                                            
                                        </div>

                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                <i class="mdi mdi-arrow-up"></i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Credit</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding"> ₹ <span id="day_purchase"></span></span><br>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                                                <i class="mdi ">+</i>
                                            </div>
                                        </div>
                                    </div>
                                     <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span class="text-dark" id="day_cradit1"></span></span>
                                        <span class="text-nowrap"></span> 
                                        <span class="text-success mr-2 ng-binding">₹ <span class="text-dark" id="day_cradit2"></span></span>
                                        <span class="text-nowrap"></span>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Debit</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding"> ₹ <span id="day_revert"></span></span>
                                           
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="mdi ">-</i>
                                            </div>

                                        </div>

                                    </div>
                                   <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span class="text-dark" id="day_debit1"></span></span>
                                        <span class="text-nowrap"></span>
                                        <span class="text-success mr-2 ng-binding">₹ <span class="text-dark" id="day_debit2"></span></span>
                                        <span class="text-nowrap"></span>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Clossing</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">E ₹ <span id="day_clossing"></span></span><br>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">D ₹ <span id="day_clossingdmt"></span></span>
                                            <span class="h1 font-weight-bold mb-0 ng-binding"><span id=""></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="mdi mdi-arrow-down"></i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">SUCCESS</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="totalsuccess"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                <i class="mdi  mdi-check-all"></i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">FAILED</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="totalfailed"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                                                <i class="mdi  mdi-close"></i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">PENDING</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="totalPending"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                                <i class="mdi ">!</i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">REVERSAL</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="totalreversal"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                                                <i class="mdi mdi-sync"></i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Recharges</h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_recharge"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-cellphone"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="day_recharge_commission"></span></span>
                                        <span class="text-nowrap text-uppercase">Recharges Commission</span>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Money Transfer </h5>
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="day_dmt"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-bank"></i>
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
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="totalnepal"></span></span>
                                        </div>
                                        <div class="col-auto">
                                            <div
                                                class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="mdi mdi-plus-network"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2 ng-binding">₹ <span id="totalnepalchre"></span></span>
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
                                            <span class="h2 font-weight-bold mb-0 ng-binding">₹ <span id="totalaeps"></span></span>
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
                                        <span class="text-nowrap">AEPS COMMISSION</span>
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
                                    <h2 class="card-category"> Bank Down</h2>
                                   
                                                                                   <table class="table table-bordered table-striped fixed_header  ">
              <thead class="thead-colored thead-primary "  >
                <tr>
                  <th>Sr.</th>
                  <th>Bank Name</th>
                  <th>Is Down?</th> 
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
               
 
            </tr>
        <?php   
        $i++;} } ?>
        </tbody>
     </table>
                        </div>
                    </div>
                </div>
               
                <div class="col-12 col-xl-9 col-lg-9 col-md-6 col-sm-6">
                    <div class="row">
                        <div class="col-12 col-xl-6 col-lg-6 col-md-4 col-sm-4">
                            <div class="card">
                                <div class="card-status bg-primary"></div>
                                <div class="card-body text-center">
                                    <h2 class="card-category"> Recharge Last Transaction</h2>
                                   
 <div id="userbalancediv">
                                    
                                </div>
           
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-status bg-primary"></div>
                                <div class="card-body text-center">

                                    <h2 class="card-category">DMT Last Transaction</h2>

                                    
                                   <div id="userbalancediv2">
                                    
                                </div>
                                </div>
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
            url: '<?php echo base_url(); ?>Retailer/Dashboard/getsummary',
            type: 'POST',
            cache: false,
            success: function (data) 
            {
              //  alert(data);
                var  x = JSON.parse(data);
                document.getElementById("day_opening").innerHTML = x.OPENING;
                document.getElementById("day_openingdmt").innerHTML = x.OPENINGdmt;
                document.getElementById("day_purchase").innerHTML = x.PURCHASE;
                document.getElementById("day_revert").innerHTML = x.REVERT;
                document.getElementById("day_cradit1").innerHTML = x.PURCHASEWL1;
                document.getElementById("day_cradit2").innerHTML = x.PURCHASEWL2;
                document.getElementById("day_debit1").innerHTML = x.DEBITWL1;
                document.getElementById("day_debit2").innerHTML = x.DEBITWL2;
                document.getElementById("day_recharge").innerHTML = x.RECHARGE;
                document.getElementById("day_recharge_commission").innerHTML = x.RECHARGE_COMMISSION;
                document.getElementById("day_dmt").innerHTML = x.DMT;
                document.getElementById("day_dmt_charge").innerHTML = x.DMT_CHARGE;
                document.getElementById("day_clossing").innerHTML = x.CLOSSING;
                document.getElementById("day_clossingdmt").innerHTML = x.CLOSSINGdmt;
                document.getElementById("totalsuccess").innerHTML = x.totalsuccess;
                document.getElementById("totalfailed").innerHTML = x.totalfailed;
                document.getElementById("totalPending").innerHTML = x.totalPending;
                document.getElementById("totalreversal").innerHTML = x.totalreversal;
                document.getElementById("totalnepal").innerHTML = x.totalnepal;
                document.getElementById("totalaeps").innerHTML = x.totalaeps;
                document.getElementById("totalnepalchre").innerHTML = x.totalnepalchre;
                
             },
            error: function (data) {

            }
        });
        return true;

     }
     $(document).ready(function()
    {
     // setTimeout(function(){window.location.reload(1);}, 50000);
        getLastTransactions();
        getLastTransactionsdmt();
       
    window.setInterval(getLastTransactions, 60000 * 10);
    window.setInterval(getLastTransactionsdmt, 60000 * 10);
      
        setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
                           });
                           
        
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