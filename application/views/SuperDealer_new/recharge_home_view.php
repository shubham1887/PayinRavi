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


     <!--sweet alert-->
    <script src="<?php echo base_url(); ?>js/Sweetalert/sweetalert.min.js"></script>
    <link href="<?php echo base_url(); ?>js/Sweetalert/sweetalert.css" rel="stylesheet" />
    <!--sweet alert End-->


    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/argon.min5438.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/custom.css" type="text/css">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/min1.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/Theme.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/RechargePlan.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/css/select2.min.css" rel="stylesheet" />

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
        <?php include("elements/sdsidebar.php"); ?>
        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-3">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Recharge</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row row-sm mg-t-20">
                <div class="col-md-6 col-lg-6 col-xl-7 col-sm-6 col-12 pd-xs-0">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body pd-t-15 pd-xs-10">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 l-border">
                                        <div class="vertical-tab" role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-tabs1">
                                                <li class="nav-item">
                                                    <a class="nav-link active" aria-expanded="true" href="#tab_1"
                                                        data-toggle="tab">
                                                        <i class="mdi mdi-cellphone-settings-variant"></i>
                                                        <span>MOBILE</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" aria-expanded="false" href="#tab_2"
                                                        data-toggle="tab">
                                                        <i class="mdi mdi-lightbulb-on-outline"></i>
                                                        <span>DTH</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" aria-expanded="false" href="#tab_3"
                                                        data-toggle="tab">
                                                        <i class="mdi mdi-cellphone-android"></i>
                                                        <span>POSTPAID</span>
                                                    </a>
                                                </li>
                                               
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1">
                                                    <div class="heading-inner">
                                                        <h1>Mobile Recharge</h1>
                                                    </div>
                                                    <form action="<?php echo base_url(); ?>SuperDealer_new/recharge_home" method="post">
                                                        <div action="javascript:void(0)" onsubmit="Recharge('mob');"
                                                            class="row" id="mob_rch" name="mob_rch">
                                                            <input name="__RequestVerificationToken" type="hidden"
                                                                value="RIJt7T4J_NvFJo4B_e3HLTRP2A_fw7-zyq1rxejuM7Zp-YHIBqvJsu8XfFKIjMCL9DRD5fhjToF5Msq1HRS9vM9S1DfTRP1sgJR0-cf9aUs1" />
                                                            <div
                                                                class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0">
                                                                <div class="form-group mg-t-0">
                                                                    <label>Mobile Number (+91)</label>
                                                                    <div class="inputText">
                                                                        <input type="text" name="mobileNumber"
                                                                            id="mobileNumber"
                                                                            class="form-control formtext"
                                                                            placeholder="10 DIGIT NUMBER" maxlength="10"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            required="" title="Enter Mobile Number"
                                                                            autofocus="" autocomplete="off" />
                                                                        <i class="typcn typcn-device-tablet"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-12 col-xl-6 col-6 pd-lg-l-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Amount</label>
                                                                    <div class="inputText">
                                                                        <input type="text" name="rechargeAmount"
                                                                            class="form-control" id="rechargeAmount"
                                                                            placeholder="Enter Amount" maxlength="5"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            onkeyup="amoutfill();" required=""
                                                                            title="Enter Amount" autofocus=""
                                                                            autocomplete="off" />
                                                                        <i class="icon fa fa-inr"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-12 col-xl-6 col-6 pd-lg-r-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Operator</label>
                                                                    <input readonly="readonly" id="mob_op_val"
                                                                        style="display: none;" type="text">
                                                                    <div class="inputText" id="mob_op_div">
                                                                        <select id="rechargeOperator"
                                                                            name="rechargeOperator"
                                                                            class="form-control select-opt"
                                                                            data-select2-id="rechargeOperator"
                                                                            tabindex="-1" aria-hidden="true">
                                                                            <option value="">Select</option>
                                                                            <?php
                                                                            $rsltmobileOptr = $this->db->query("select company_id,company_name from tblcompany where service_id = 1");
                                                                            foreach( $rsltmobileOptr->result() as $rwopm)
                                                                            {?>
                                                                                <option value="<?php echo $rwopm->company_id; ?>"><?php echo $rwopm->company_name; ?></option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            
                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-6 col-xl-12 col-6 pd-lg-r-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>TPIN</label>
                                                                    <div class="inputText">
                                                                        <input type="password" name="mobileTPIN"
                                                                            class="form-control" id="mobileTPIN"
                                                                            placeholder="Enter TPIN" maxlength="4"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            required="" title="Enter TPIN" autofocus=""
                                                                            autocomplete="new-password" />
                                                                        <i class="icon fa fa-edit"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="col-md-12 col-md-12 col-sm-12 col-lg-12 col-xl-12 col-12 pd-lg-0">
                                                                <div class="" id="mob_button">
                                                                    <input type="busson" class="btn btn-primary pull-left"
                                                                        id="btnmrecharge"
                                                                        onclick="mobilevalidation();" value="Recharge">
                                                                    <ul class="dashlist1 pull-right">
                                                                        <li><a href="#"
                                                                                onclick="return FetchPlans();">View
                                                                                Plan</a></li>
                                                                        <li><a href="#">|</a></li>
                                                                        <li><a href="#" onclick="return special();">View
                                                                                R-Offer</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

<!-------------- mobile jquery --------------------------------------->

<script>
function mobilerechargeconfirm() 
{
        var optname = "";
        var optvalue = "";
        
       
        var mobileno = $("#mobileNumber").val();
        var OptCode = $("#rechargeOperator").val();
        var amout = $("#rechargeAmount").val();
        var tpin = $("#mobileTPIN").val();
        // $("#mobileNumber").val("");
        // $("#rechargeAmount").val("");
        // $("#mobileTPIN").val("");
        if (mobileno != "" && amout != "") {
            $.ajax({
                type: "POST",
                url: "/Retailer/Recharge_home",
                data: { OperatorName: optname, OptCode: OptCode, mobileno: mobileno, Amount: amout, optional1: "", optional2: "", optional3: "", optional4: "", comm: "", BillRefId: "" },
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    $('.loader').show();
                },
                success: function (result) {
                  
                    var status = result.Response;
                    var message = result.Message;
                     jQuery('#ProcessingBox').attr("style", "display:none;");




                     swal({ title: "<small><div class='rg-alert-er'>"+status+"</div></small>", text: "<div style='margin-left: 20px;text-align:left'><b>Message :</b>"+message+"<br /></div>",html: true });;
                },
                complete: function () {

                    

                    $("#currentMBal").load(location.href + "/getBalance");
                    $('.loader').hide();
                          $.ajax({
            url: '/Retailer/Recharge_home/showrecentrecharge',
            type: 'GET',
            dataType: "html",
            data: { type: "Prepaid" },
                   success: function (data) {        
                    $('#reportchk').html(data);
                               
            },
            error: function (data) {
               
            }
        });
                },
                error: function () {
                    $("#currentMBal").load(location.href + "/getBalance");
                    $('.loader').hide();
                }
            })
        }

    }
</script>





<!------------------------ mobile query end ------------------------------->
                                                </div>

                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_2">
                                                    <form action="/Recharge/DTH" method="post">
                                                        <div class="heading-inner">
                                                            <h1>DTH Recharge</h1>
                                                        </div>
                                                        <div action="javascript:void(0)" onsubmit="Recharge('dth');"
                                                            class="row" id="dth_rch" name="dth_rch">
                                                            <!-- ====================== -->
                                                            <div
                                                                class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0">
                                                                <div class="form-group mg-t-0">
                                                                    <label>Subscriber ID</label>
                                                                    <div class="inputText">
                                                                        <input autocomplete="off"
                                                                            class="formtext form-control" id="DTHNumber"
                                                                            maxlength="20" name="DTHNumber"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            placeholder="SUBSCRIBER-ID"
                                                                            required="required" type="text" value="" />
                                                                        <i class="typcn typcn-device-tablet"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-6 col-xl-12 col-6 pd-lg-l-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Amount</label>
                                                                    <div class="inputText">
                                                                        <input autocomplete="off" class="form-control"
                                                                            id="DTHAmount" maxlength="4"
                                                                            name="DTHAmount"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            placeholder="Enter Amount"
                                                                            required="required" type="text" value="" />
                                                                        <i class="icon fa fa-inr"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-6 col-xl-12 col-6 pd-lg-r-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Operator</label>
                                                                    <select class="form-control select-opt"
                                                                        id="ddldthOP" name="ddldthOP"
                                                                        required="required">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                            $rsltmobileOptr = $this->db->query("select company_id,company_name from tblcompany where service_id = 2");
                                                                            foreach( $rsltmobileOptr->result() as $rwopm)
                                                                            {?>
                                                                                <option value="<?php echo $rwopm->company_id; ?>"><?php echo $rwopm->company_name; ?></option>
                                                                            <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>TPIN</label>
                                                                    <div class="inputText">
                                                                        <input type="password" class="form-control"
                                                                            name="dthTPIN" id="dthTPIN"
                                                                            placeholder="Enter TPIN" maxlength="4"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            required="" title="Enter TPIN" autofocus=""
                                                                            autocomplete="new-password" />
                                                                        <i class="icon fa fa-edit"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0">
                                                                <div class="">
                                                                    <input type="button" class="btn btn-primary pull-left"
                                                                        onclick="dthvalidation();" value="Recharge">
                                                                    
                                                                    <ul class="dashlist1 pull-right">
                                                                        <li><a href="#" onclick="return getInfo();"
                                                                                >Get Info</a></li>
                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <!-- ====================== -->
                                                        </div>
                                                    </form>
<!-------------- dth jquery --------------------------------------->

<script>
function dthrechargeconfirm() 
{

   // DTHNumber,DTHAmount,ddldthOP,dthTPIN
        var optname = "";
        var optvalue = "";
        
        
        var circle = "";
        var mobileno = $("#DTHNumber").val();
        var OptCode = $("#ddldthOP").val();
        var amout = $("#DTHAmount").val();
        var tpin = $("#dthTPIN").val();
        // $("#mobileNumber").val("");
        // $("#rechargeAmount").val("");
        // $("#mobileTPIN").val("");
        if (mobileno != "" && amout != "") {
            $.ajax({
                type: "POST",
                url: "/Retailer/Recharge_home",
                data: { OperatorName: optname, OptCode: OptCode, mobileno: mobileno, Amount: amout, optional1: "", optional2: "", optional3: "", optional4: "", comm: "", BillRefId: "" },
                cache: false,
                dataType: 'json',
                beforeSend: function () {
                    $('.loader').show();
                },
                success: function (result) {
                  
                    var status = result.Response;
                    var message = result.Message;
                     jQuery('#ProcessingBox').attr("style", "display:none;");




                     swal({ title: "<small><div class='rg-alert-er'>"+status+"</div></small>", text: "<div style='margin-left: 20px;text-align:left'><b>Message :</b>"+message+"<br /></div>",html: true });;
                },
                complete: function () {

                    

                    $("#currentMBal").load(location.href + "/getBalance");
                    $('.loader').hide();
                          $.ajax({
            url: '/Retailer/Recharge_home/showrecentrecharge',
            type: 'GET',
            dataType: "html",
            data: { type: "Prepaid" },
                   success: function (data) {        
                    $('#reportchk').html(data);
                               
            },
            error: function (data) {
               
            }
        });
                },
                error: function () {
                    $("#currentMBal").load(location.href + "/getBalance");
                    $('.loader').hide();
                }
            })
        }

    }
</script>





<!------------------------ DTH query end ------------------------------->                                                    
                                                </div>
                                                <!-- /.tab-pane -->
                                                <!-- /.tab-pane -->
                                                <div class="tab-pane" id="tab_3">
                                                    <form action="/Recharge/PostP" method="post">
                                                        <div class="heading-inner">
                                                            <h1>PostPaid Recharge</h1>
                                                        </div>
                                                        <div action="javascript:void(0)" onsubmit="Recharge('bil');"
                                                            class="row" id="bil_rch" name="bil_rch">
                                                            <!-- ======================= -->
                                                            <div
                                                                class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0">
                                                                <div class="form-group mg-t-0">
                                                                    <label>PostPaid Number</label>
                                                                    <div class="inputText">
                                                                        <input autocomplete="off" class="form-control"
                                                                            id="PPNumber" maxlength="20" name="PPNumber"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            placeholder="POST-PAID NUMBER"
                                                                            required="required" type="text" value="" />
                                                                        <i class="typcn typcn-device-tablet"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-6 col-xl-12 col-6 pd-lg-l-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Amount</label>
                                                                    <div class="inputText">
                                                                        <input autocomplete="off" class="form-control"
                                                                            id="PPAmount" maxlength="4" name="PPAmount"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            placeholder="Enter Amount"
                                                                            required="required" type="text" value="" />
                                                                        <i class="icon fa fa-inr"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-6 col-sm-6 col-lg-6 col-xl-12 col-6 pd-lg-r-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Operator</label>
                                                                    <select class="form-control select-opt" id="ddlppOP"
                                                                        name="ddlppOP" required="required">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                            $rsltmobileOptr = $this->db->query("select company_id,company_name from tblcompany where service_id = 3");
                                                                            foreach( $rsltmobileOptr->result() as $rwopm)
                                                                            {?>
                                                                                <option value="<?php echo $rwopm->company_id; ?>"><?php echo $rwopm->company_name; ?></option>
                                                                            <?php }?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0"
                                                                id="ppacno" style="display: none">
                                                                <div class="form-group mg-t-15">
                                                                    <label>Account Number</label>
                                                                    <div class="inputText">
                                                                        <input autocomplete="off" class="form-control"
                                                                            id="PPAccountno" maxlength="4"
                                                                            name="PPAccountno"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            placeholder="Account Number(Refer Your Bill)"
                                                                            type="text" value="" />
                                                                        <i class="icon fa fa-inr"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0">
                                                                <div class="form-group mg-t-15">
                                                                    <label>TPIN</label>
                                                                    <div class="inputText">
                                                                        <input type="password" class="form-control"
                                                                            name="postpaidTPIN" id="postpaidTPIN"
                                                                            placeholder="Enter TPIN" maxlength="4"
                                                                            onkeypress="return ValidateNumber(event);"
                                                                            required="" title="Enter TPIN" autofocus=""
                                                                            autocomplete="new-password" />
                                                                        <i class="icon fa fa-edit"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-sm-12 col-lg-12 col-12 col-xl-12 pd-lg-0"
                                                                id="bil_button">
                                                                <div class="">
                                                                    <button class="btn btn-primary"
                                                                        onclick="return ppvalidation();">Recharge
                                                                    </button>
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
                        </div>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12 pd-xs-0">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <img src="<?php echo base_url();?>assets2/img/recharge/Recharge-Banner.png" class="img-fluid banner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
        </div>
        <div class="modal right fade animated slideInRight" id="myModalPlan">
            <div class="modal-dialog sidebarRecharge " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-0" id="myModalLabel2"><b>Browse Plans</b></h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="tab-menu-heading siderbar-tabs border-0">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="als-wrapper" style="width: 100% !important;">
                                    <li class="als-item active" role="presentation"><a
                                            href="#">All Plans </a>
                                    </li>
                                    <li class="als-item" role="presentation"><a
                                            href="#">Top Up </a></li>
                                    <li class="als-item" role="presentation" ><a
                                            href="#">Full Talktime </a>
                                    </li>
                                    <li class="als-item" role="presentation"><a href="#">Data
                                            2G </a></li>
                                    <li class="als-item" role="presentation"><a
                                            href="#">Data 3G/4G </a>
                                    </li>
                                    <li class="als-item" role="presentation" ><a href="#">SMS
                                        </a></li>
                                    <li class="als-item" role="presentation"><a
                                            href="#">Combo </a></li>
                                    <li class="als-item" role="presentation"><a
                                            href="#">Rate Cutter
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active " id="tab">
                                <div class="card-body p-0">
                                    <div class="select" style="width: 100%;" id="allplans"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div>


        <!--Modal Customer Details-->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="text-align:center;">Customer Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table custtable table-striped table-hover"
                            style="font-size:13px;margin-bottom:0px;">
                            <tr>
                                <td style="width:30%;"><b>Customer Name</b></td>
                                <td><span id="custname"></span></td>
                            </tr>
                            <tr>
                                <td><b>Balance</b></td>
                                <td><span id="bal"></span></td>
                            </tr>
                            <tr>
                                <td><b>Next Recharge Date</b></td>
                                <td><span id="nextrechdate"></span></td>
                            </tr>
                            <tr>
                                <td><b>Last Recharge Date</b></td>
                                <td><span id="lastrechargedate"></span></td>
                            </tr>
                            <tr>
                                <td><b>Last Recharge Amount</b></td>
                                <td><span id="lastrechargeamount"></span></td>
                            </tr>
                            <tr>
                                <td><b>Plan Name</b></td>
                                <td><span id="planname"></span></td>
                            </tr>
                            <tr>
                                <td><b>Status</b></td>
                                <td><span id="status"></span></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <!--Modal Customer Details End-->
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
                    <img src="<?php echo base_url();?>assets2/img/Processing.gif" style="width:70px;" />
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

    <script src="<?php echo base_url(); ?>js/Old/RG-Dev.js"></script>


    <!--Modal End-->
    <script src="<?php echo base_url(); ?>assets2/js/Jquery_MPlan.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="<?php echo base_url(); ?>assets2/js/argon.min5438.js"></script>
    <script src="<?php echo base_url(); ?>assets2/js/select2.js"></script>
    <script>
        $(".select-opt").select2({
            placeholder: "Select"
        });
    </script>
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
</body>

</html>