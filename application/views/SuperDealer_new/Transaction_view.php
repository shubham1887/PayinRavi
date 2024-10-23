
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | DMT</title>
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


    <?php include("elements/sdsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
         <?php include("elements/sdsidebar.php"); ?>
        <!-- Header -->
        

<div data-ng-app="myapp">
    <div data-ng-controller="ADRGMainctrl">
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-3">
                        <div class="col-lg-4 col-9">
                            <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Transaction Report</a></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-8 col-3 text-right">
                            <div class="page-header">
                                <!--For Small Devices-->
                                <div class="headerbtn">
                                    <div class="card-action pull-right">
                                        <div class="dropdown">
                                            <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                                <i class="mdi mdi-flickr"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item totAmount"><b>Total Amount : {{alltransaction.Total}}</b></a>
                                                <a class="dropdown-item success"><b> <span style="color:green;">Success</span> : {{alltransaction.Success}}</b></a>
                                                <a class="dropdown-item pending"><b> <span style="color:orange;">Pending</span> : {{alltransaction.Pending}}</b></a>
                                                <a class="dropdown-item failure"><b> <span style="color:red;">Failure</span> : {{alltransaction.Failure}}</b></a>
                                                <a class="dropdown-item reversal"><b> <span style="color:#075186;">Reversal</span> : {{alltransaction.Reversal}}</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--For Small Devices End-->
                                <div class="ml-auto">
                                    <a class="totAmount"><b>Total Amount : {{alltransaction.Total}}</b></a>
                                    <a class="success"><b> Success : {{alltransaction.Success}}</b></a>
                                    <a class="pending"><b> Pending : {{alltransaction.Pending}}</b></a>
                                    <a class="failure"><b> Failure : {{alltransaction.Failure}}</b></a>
                                    <a class="reversal"><b> Reversal : {{alltransaction.Reversal}}</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <div class="row match-height mg-t-20">
                <div class="col-xl-12 col-lg-12 pd-xs-0">
                    <div class="card">
                        <div class="card-body pd-xs-10">
                            <div class="row">
                                <div class="col-md-4 col-12 col-lg-4 col-xl-4 col-sm-5">
                                    <form class="form-group mg-t-0">
                                        <div id="dateragne-picker21">
                                            <div class="input-daterange input-group">
                                                <input type="text" class="form-control" id="Fromdate" name="Fromdate" placeholder="Select From Date" />
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="Todate" name="Todate" placeholder="Select To Date" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 col-10 col-lg-3 col-sm-5 col-xl-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter UserName" autocomplete="off" data-ng-model="searchUsername" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-2 col-lg-2 col-sm-2 col-xl-2 pd-xs-l-0">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" data-ng-click="getTransactionreports()"><i class="fa fa-search"></i> </button>
                                    </div>
                                </div>
                                <div class="col-md-2 col-2 col-lg-3 col-sm-2 pull-xs-r pd-xs-r-0">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary pull-right" title="Select date and export all transaction" data-ng-click="DotransactionExport()"><span class="fa fa-file-excel-o"></span></button>
                                    </div>
                                </div>
                                <div class="col-md-2 col-10 col-lg-2 col-sm-3 col-xl-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search" autocomplete="off" data-ng-model="myfilters" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-transaction" id="TableSearch">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Number</th>
                                                    <th>Txn. Amt</th>
                                                    <th>Dr/Cr Amt</th>
                                                    <th>Balance</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr data-ng-repeat="item in alltransaction.Data | filter:myfilters">
                                                    <td style="min-width: 165px !important;">
                                                        {{item.ServiceType}} | {{item.Provider}}
                                                        <p class="number">
                                                            <span data-ng-if="item.TxnStatus==='Success'">
                                                                <a href="#" data-tooltip="Click to raise complaint" data-ng-click="puttransactioncomplain(item);">
                                                                    {{item.OrderID}}
                                                                </a>
                                                            </span>
                                                            <span data-ng-if="item.TxnStatus==='Pending'">
                                                                {{item.OrderID}}
                                                            </span>
                                                            <span data-ng-if="item.TxnStatus==='Failure'">
                                                                {{item.OrderID}}
                                                            </span>
                                                            <span data-ng-if="item.TxnStatus==='Reversal'">
                                                                {{item.OrderID}}
                                                            </span>
                                                        </p>
                                                        <p class="datetime">
                                                            {{item.TxnDate}} {{item.TxnTime}}
                                                            <div class="tooltip">
                                                                <i class="fa fa-calendar"></i>
                                                                <span class="tooltiptext">Updated On :<br /> {{item.UpdateOn}} {{item.UpdateOnTime}}</span>
                                                            </div>
                                                        </p>
                                                    </td>
                                                    <td>{{item.CustomerNumber}}</td>
                                                    <td>{{item.TxnAmount}}</td>
                                                    <td>{{item.TotalAmount}}</td>
                                                    <td>{{item.ClosingBalance}}</td>
                                                    <td>
                                                        <span class="success" data-ng-if="item.TxnStatus==='Success'">{{item.TxnStatus}}</span><span class="pending" data-ng-if="item.TxnStatus==='Pending'">{{item.TxnStatus}}</span><span class="failure" data-ng-if="item.TxnStatus==='Failure'">{{item.TxnStatus}}</span><span class="reversal" data-ng-if="item.TxnStatus==='Reversal'">{{item.TxnStatus}}</span>
                                                    </td>
                                                    <td>
                                                        <a href="/ADReport/TransactionReportDetails/{{item.OrderID}}" target="_blank" class="btnview"><i class="fa fa-eye"></i> More</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!-- /.box-body -->

            <div id="myReciept" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 800px;max-width:800px; margin: 30px auto;">
                    <style>
                        .modal-body {
                            line-height: 21px;
                        }

                        .panel {
                            color: #222 !important;
                        }

                        .modal-body p {
                            line-height: 20px;
                            margin-bottom: 0px;
                        }

                        .modalfoot {
                            padding-top: 50px;
                        }
                    </style>

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body" style="padding: 10px; border-radius: 0px;">
                            <div class="col-md-12">
                                <button type="button" class="btn" data-dismiss="modal" style="padding: 6px ! important; top: -8px; right: -35px; background-color: rgb(255, 255, 255) ! important; position: absolute;">&times;</button>
                            </div>
                            <div class="containers" style="height: 500px; overflow: auto; width: 100%">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" style="margin-bottom: 3px; padding: 7px;">Print / Download Receipt of Transaction ID : <span id="prt_hdtranid"></span></div>
                                    <div class="panel-body" style="padding: 0% 4%">
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-md-9"></div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary fullbtn" style="color: #FFF !important; float: right; padding: 5px 8px; text-shadow: none;" id="btnPrint"><i class="fa fa-print" style="margin-right: 5px;"></i>PRINT</button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="reciept" style="margin-top: 5px; margin-bottom: 7px;">

                                            <div class="row">
                                                <div class="col-md-12" id="dvContents">
                                                    <style>
                                                        td {
                                                            padding: 5px;
                                                        }
                                                    </style>
                                                    <table style="width: 100%; border: 1px solid #888;">
                                                        <tr>
                                                            <th colspan="3">
                                                                <div class="col-md-2 col-sm-2 col-xs-2" style="padding:10px;">
                                                                    <img src="https://mpayonline.co.in/assets/images/Logo/logo502.png" style="width:70px;" />
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-6 text-left" style="padding:10px;">
                                                                    <div style="margin-top: 0px; float: left;">
                                                                        <b>Retailer Name: peher Badiyani</b>
                                                                    </div>
                                                                    <br />
                                                                    <div style="margin-top: 0px; float: left;">
                                                                        <b>Contact Number: 7666075076</b>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4 text-right" style="padding:10px;" id="trandetailbyheadbps">
                                                                    <img src="/Images/Logo/bbp-logo.png" style="width:170px;">
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-4 text-right" style="padding:10px;" id="trandetailbyheadnormal">
                                                                    <b>Receipt # :</b> R - <b id="prt_bdtranid"></b>
                                                                    <br />
                                                                    <b>Date : 3/31/2021</b>
                                                                </div>
                                                            </th>


                                                        </tr>
                                                        <tr style="border-top:1px solid #ddd;" id="trandetailbybps">
                                                            <td>
                                                                <b>Customer Name : </b><span id="prt_trandbillername"></span><br />
                                                                <b>Customer Mobile No : </b><span id="prt_tranbillermobile"></span><br />
                                                                <b>Payment channel : </b><span id="prt_tranchannel"></span><br />
                                                            </td>
                                                            <td>
                                                                <b>Consumer ID/Number : </b><span id="prt_trannumber"></span><br />
                                                                <b>Payment Mode : </b><span id="prt_tranpaymode"></span><br />
                                                                <b>Date & Time : </b><span id="prt_bdtranddate"></span>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr style="border-top:1px solid #ddd;" id="trandetailbydmt">
                                                            <td>
                                                                <b>Sender Name : <span>{{rptsendername}}</span></b><br />
                                                                <b>Account Number : <span>{{rptaccountno}}</span></b><br />
                                                                <b>IFSC Code : <span>{{rptifsccode}}</span></b>
                                                            </td>
                                                            <td>
                                                                <b>Sender Number : <span>{{rptsenderno}}</span></b><br />
                                                                <b>Beneficiary Name : <span>{{rptreceipentname}}</span></b><br />
                                                                <b>Transaction Type : <span>{{rpttxntype}}</span></b><br />
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr style="border-top:1px solid #ddd;" id="trandetailbynormal">
                                                            <td>
                                                                <b>Number : <span>{{rpttxnnumber}}</span></b><br />
                                                            </td>
                                                            <td>
                                                                <b>Date & Time : <span>{{rpttxndatetime}}</span></b><br />
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="3" style="border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;"><b>Transaction Details</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="nospace1">
                                                                <table class="table table-bordered">
                                                                    <tr style="background:#ddd;">
                                                                        <td class="phead"><b>Date</b></td>
                                                                        <td class="phead"><b>Service Provider</b></td>
                                                                        <td class="phead"><b>Transaction ID </b></td>
                                                                        <td class="phead"><b>{{ptrreferencenumbername}}</b></td>
                                                                        <td class="phead"><b>Amount </b></td>
                                                                        <td class="phead"><b>Status </b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><span id="prt_trandate"></span></td>
                                                                        <td><span id="prt_tranoperator"></span></td>
                                                                        <td><span id="prt_tranid"></span></td>
                                                                        <td><span id="prt_tranrefernce"></span></td>
                                                                        <td><span id="prt_tranamount"></span></td>
                                                                        <td><span id="prt_transtatus"></span></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <b class="fee">Customer Convenience Fee :</b>
                                                                    <input type="number" placeholder="{{prt_tranfee}}" class="cFee" id="prt_tranfee" data-ng-model="prt_tranfee" data-ng-change="doforcalculations()" />
                                                                    <input type="hidden" id="prt_trantotalamt" data-ng-model="prt_trantotalamt" />
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <b>Total Amount Rs. : </b>
                                                                    <label id="prt_trantotal">{{prt_trantotal}}</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                    <b>Amount in Words :</b>
                                                                    <label id="prt_tranword">{{prt_tranword}}</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="modalfoot" style="text-align: center;">
                                                                <p>Copyright &#169;2020 - Mpayonline.co.in</p>
                                                                <p style="font-size: 12px">This is a system generated Receipt. Hence no seal or signature required.</p>
                                                            </td>
                                                        </tr>
                                                    </table>

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
        </div>
        <!-- /.box -->
   


<script src="<?php echo base_url(); ?>mpayfiles/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>mpayfiles/jquery-ui.css" rel="stylesheet" />
<script>
    $(function () {
        $("#Fromdate").datepicker();
        $("#Todate").datepicker();
    });
</script>

<script>
    $(function () {
        //$("#Fromdate").datepicker();
        //$("#Todate").datepicker();
        $("#btnPrint").click(function () {
            var contents = $("#reciept").html();
            var frame1 = $('<iframe />');
            frame1[0].name = "frame1";
            frame1.css({ "position": "absolute", "top": "-1000000px" });
            $("body").append(frame1);
            var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
            frameDoc.document.open();
            //Create a new HTML document.
            frameDoc.document.write('<html><head><title>DIV Contents</title>');
            frameDoc.document.write('</head><body>');
            //Append the external CSS file.
            frameDoc.document.write('<link rel="stylesheet" href="../../Content/Css/bootstrap.min.css" type="text/css" media="print" />');
            frameDoc.document.write('<link rel="stylesheet" href="../../Content/css/printReceipt.css" type="text/css" media="print" />');
            frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
            //Append the DIV contents.
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function () {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                frame1.remove();
            }, 500);
        });
    });
</script>
<script src="<?php echo base_url(); ?>mpayfiles/angular.min.js"></script>
<script src="<?php echo base_url(); ?>mpayfiles/angular.rgrtroute.min.1.7.2.js"></script>

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





         <!--Search Table Plugin-->
        <script src="<?php echo base_url(); ?>mpayfiles/Search.js"></script>
        <!--Search Table Plugin End-->

        <!--Modal End-->

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
