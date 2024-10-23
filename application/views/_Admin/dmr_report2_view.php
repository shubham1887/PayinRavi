
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | MoneyHistory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--Favicon-->
    <link href="/assets/images/Favicon/favicon502.png" rel="icon" />
    <!--Favicon End-->
    <script src="../js/Old/jquery.min.js"></script>
    <link href="/css/RG-DEv.css" rel="stylesheet" />
    <!--sweet alert-->
    <script src="/js/Sweetalert/sweetalert.min.js"></script>
    <link href="/js/Sweetalert/sweetalert.css" rel="stylesheet" />
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
    <link href="/Content/Css/Main/argon.min.css" rel="stylesheet" />
    <link href="/Content/Css/Main1.css" rel="stylesheet" />
    <!--Color theme style-->
    <link href="/Content/Css/Theme.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
</head>
<body>
    
    <!--sweet alert start-->


    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header d-flex align-items-center">
                <a class="navbar-brand" href="/Default">
                    <img src="https://mpayonline.co.in/assets/images/Logo/logo502.png" class="navbar-brand-img" alt="...">
                </a>
                <div class="ml-auto">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            

        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/Default">
                            <i class="mdi mdi-monitor-multiple"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Recharge/index">
                                <i class="mdi mdi-cellphone-android text-orange"></i>
                                <span class="nav-link-text">Recharge</span>
                            </a>
                        </li>
                                            <li class="nav-item">
                            <a class="nav-link" href="/Moneytransfer/DMT">
                                <i class="mdi mdi-bank-outline text-info"></i>
                                <span class="nav-link-text">Money Transfer</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/MoneytransferRP/DMT">
                                <i class="mdi mdi-check-box-multiple-outline text-green"></i>
                                <span class="nav-link-text">Money Transfer 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/PMTTransfer/Money">
                                <i class="mdi mdi-message-text-outline text-info"></i>
                                <span class="nav-link-text">Nepal Money Transfer</span>
                            </a>
                        </li>
                                    <li class="nav-item">
                    <a class="nav-link" href="#navbar-BBPS" data-toggle="collapse" role="button" aria-controls="navbar-dashboards">
                        <i class="mdi mdi-gas-station-outline text-pink"></i>
                        <span class="nav-link-text">BBPS</span>
                    </a>
                    <div class="collapse" id="navbar-BBPS">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/Utility/BBPS" class="nav-link">BBPS</a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse" id="navbar-BBPS">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/Services/BBPS" class="nav-link" target="_blank">BBPS New</a>
                            </li>
                        </ul>
                    </div>
                </li>
                                                             <li class="nav-item">
                            <a class="nav-link" href="/Services/Pancard" target="_blank">
                                <i class="mdi mdi-account-card-details-outline text-primary"></i>
                                <span class="nav-link-text"> Pan Card </span>
                            </a>
                        </li>
                                            <li class="nav-item">
                            <a class="nav-link" href="#navbar-AEPS" data-toggle="collapse" role="button" aria-controls="navbar-dashboards">
                                <i class="mdi mdi-content-duplicate text-green"></i>
                                <span class="nav-link-text">AEPS</span>
                            </a>
                            <div class="collapse" id="navbar-AEPS">
                                <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <form method="POST" action="https://aeps.payin.co.in/" target="_blank" style="float: left;padding-left: 45px;">
                                                <input type="hidden" name="params" value="%7B%22ALLOWED_SERVICES%22%3A%22WAP%2CBAP%22%2C%22APP_ID%22%3A%22120%22%2C%22BLOCKED_SERVICES%22%3A%22%22%2C%22PAN%22%3A%22AGOPC5528P%22%2C%22CHECKSUMHASH%22%3A%22MTIzNDU2NzgxMjM0NTY3OPWLpBo4uH7HvK1J%2BF71jFe9YW%2FFkYFXYh2kKMJYEEyvciMW9uve2Ta1F2ZFdq7twNy93R4AMph4k1yj6E8TqijW0vq1Ef%2F0xlTxaXCKcNzxCu3qb7yG5OI2qiFsvJHsQ2AH%2BcR13mI%2Bm5Qqjg0CwgWT3jvIZyF3HNSCV3pyKgvx%22%7D">
                                                <button type="submit" style="width: 100%;background: transparent;border: 0px;cursor:pointer;padding-left: 9px;" class="side-menu__item"><i class="side-menu__icon icon-compass" style="width: 53px;"></i> <span class="">AEPS</span></button>
                                            </form>
                                        </li>
 				        <li class="nav-item">
                                            <a class="nav-link" href="/Services/AEPS" target="_blank">
                                                <span class="menu-title">AEPS New</span>
                                            </a>
                                        </li>
                                </ul>
                            </div>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-Reports" data-toggle="collapse" role="button" aria-controls="navbar-dashboards">
                            <i class="mdi mdi-finance text-info"></i>
                            <span class="nav-link-text">Reports</span>
                        </a>
                        <div class="collapse" id="navbar-Reports">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item"><a href="/Reports/Transaction" class="nav-link">Transaction Report</a></li>
                                <li class="nav-item"><a href="/Reports/Statement" class="nav-link">Statement Report</a></li>
                                <li class="nav-item"><a href="/Reports/LoadReport" class="nav-link">Payment Load Report</a></li>
                                <li class="nav-item"><a href="/Reports/DeductReport" class="nav-link">Payment Debit Report</a></li>
                                    <li class="nav-item"><a href="/DMTNEWM/MoneyHistory" class="nav-link">Money Transfer 1 Report</a></li>
                                                                    <li class="nav-item"><a href="/Reports/AepsTransaction" class="nav-link">AEPS Report</a></li>
                                    <li class="nav-item"><a href="/myaccounts/AEPSBillingdetails" class="nav-link">AEPS Statement Report</a></li>
                                    <li class="nav-item"><a href="/Reports/BankWithdrawalReport" class="nav-link">Bank Withdrawal Report</a></li>
                                    <li class="nav-item"><a href="/Reports/BankWithdrawalHistory" class="nav-link">Bank Withdrawal History</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-Account" data-toggle="collapse" role="button" aria-controls="navbar-dashboards">
                            <i class="mdi mdi-account-multiple-outline  text-pink"></i>
                            <span class="nav-link-text">Account</span>
                        </a>
                        <div class="collapse" id="navbar-Account">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item"><a href="/myaccounts/UserProfile" class="nav-link">Profile</a></li>
                                <li class="nav-item"><a href="/myaccounts/Setting" class="nav-link">Change Password</a></li>
                                <li class="nav-item"><a href="/myaccounts/SettingChangeTPIN" class="nav-link">Change TPIN</a></li>
                                <li class="nav-item"><a href="/myaccounts/loginhistory" class="nav-link">Login Detail</a></li>
                                <li class="nav-item"><a href="/myaccounts/Certificate" class="nav-link">Certificate</a></li>
                                <li class="nav-item"><a href="/Business/MyCommission" class="nav-link">Commision</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-Support" data-toggle="collapse" role="button" aria-controls="navbar-dashboards">
                            <i class="mdi mdi-help-circle-outline text-green"></i>
                            <span class="nav-link-text">Support</span>
                        </a>
                        <div class="collapse" id="navbar-Support">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item"><a href="/Default/Services" class="nav-link">Purchase Services</a></li>
                                <li class="nav-item"><a href="/supports/TopUpRequest" class="nav-link">TopUp Request</a></li>
                                <li class="nav-item"><a href="/Reports/PaymentRequestReport" class="nav-link">Topup History</a></li>
                                <li class="nav-item"><a href="/supports/Index" class="nav-link">View All Tickets</a></li>
                                <li class="nav-item"><a href="/supports/Raisecomplain" class="nav-link">Raise Complain</a></li>
                                    <li class="nav-item"><a href="/supports/FundTransfer" class="nav-link">AEPS Settlement</a></li>
			
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
                <!-- Heading -->
                <h6 class="navbar-heading p-0 text-muted">Documentation</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="/home/FAQ" target="_blank">
                            <i class="mdi mdi-account-question-outline"></i>
                            <span class="nav-link-text">FAQ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/home/PrivacyPolicy" target="_blank">
                            <i class="mdi mdi-alert-outline"></i>
                            <span class="nav-link-text">Privacy Policy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/home/TermsAndConditions" target="_blank">
                            <i class="mdi mdi-clipboard-alert-outline"></i>
                            <span class="nav-link-text">Terms & Conditions</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        </div>
    </nav>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->
                    <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" style="width:100%;">
                        <marquee style="color: #fff !important;"><p>
	<span style="color:#ffffff;"><strong><span style="background-color:#0000ff;">Good News!!Dear Partners,ab apni mATM seva shuru ho gayi hai,adhik jankari ke liye company ke manager se sammpark kare. PayIN</span></strong></span></p>
</marquee>
                    </form>
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center ml-md-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">
                                Main : ₹ <span id="currentMBal">256.020</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">
                                AEPS : ₹ 0
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image">
                                    </span>
                                    <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold">sai store</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="/Myaccounts/UserProfile" class="dropdown-item">
                                    <i class="mdi mdi-account-outline"></i>
                                    <span>My profile</span>
                                </a>
                                <a href="/Myaccounts/setting" class="dropdown-item">
                                    <i class="mdi mdi-cog-clockwise"></i>
                                    <span>Settings</span>
                                </a>

                                <div class="dropdown-divider"></div>
                                <a href="/home/index" class="dropdown-item" onclick="return confirm('Do you want to logout?')">
                                    <i class="mdi mdi-logout-variant"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
            

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-3">
                    <div class="col-lg-4 col-9">
                        <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="/Default"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Money Transfer 1 History</a></li>
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
                                            <a class="dropdown-item totAmount"><b>Total Amount : 0</b></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--For Small Devices End-->
                            <div class="ml-auto">
                                <a class="totAmount"><b>Total Amount : 0</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row match-height">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body pd-xs-10">

                            <div class="row">
                                <div class="col-md-12 nopadding">
<form action="/DMTNEWM/MoneyHistory" method="post">                                        <div class="row">
                                            <div class="col-md-5 col-10 col-lg-4 col-sm-5">
                                                <form class="form-group mg-t-0">
                                                    <div id="dateragne-picker21">
                                                        <div class="input-daterange input-group">
                                                            <input Value="" autocomplete="off" class="form-control" id="FromDate" name="FromDate" placeholder="From Date" required="required" type="text" value="" />
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                            <input Value="" autocomplete="off" class="form-control" id="ToDate" name="ToDate" placeholder="To Date" required="required" type="text" value="" />
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-2 col-2 col-lg-3 col-sm-2 pull-xs-r">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> </button>
                                                </div>
                                            </div>
                                        </div>
</form>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 tblover">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-transaction" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
                                            <thead>
                                                <tr>
                                                    <th><b>SL</b></th>
                                                    <th><b>Sender No</b></th>
                                                    <th><b>Beneficiary Name</b></th>
                                                    <th><b>AccountNo</b></th>
                                                    <th><b>Ifsc</b></th>
                                                    <th><b>Type</b></th>
                                                    <th><b>Amount</b></th>
                                                    <th><b>Bank ref.No</b></th>
                                                    <th><b>Status</b></th>
                                                    <th><b>Date</b></th>
                                                    <th><b>OrderId</b></th>
                                                    
                                                    <th><b>Action</b></th>
                                                </tr>
                                            </thead>
                                            <tbody>


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

    <div id="myReciept" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 900px;">

            <!-- Modal content-->
            <div class="modal-content" style="border: 5px solid rgb(252, 193, 1);">
                <div class="modal-body">
                    <div class="col-md-12">
                        <button type="button" class="btn" data-dismiss="modal" style="padding: 6px ! important; top: -5px;color:#333; right: -47px; background-color: rgb(255, 255, 255) ! important; position: absolute; border: 2px solid rgb(252, 193, 1);">&times;</button>
                    </div>
                    <div class="containers" style="height: 500px; overflow: auto; width: 100%">
                        <div class="panel panel-danger">
                            <div class="panel-heading" style="margin-bottom: 3px; padding: 0px;">Print / Download Receipt of Transaction ID : <span id="tranidHead"></span></div>
                            <div class="panel-body" style="padding: 0% 4%">
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success btn-block" style="color: #FFF !important; text-shadow: none;" id="printbtn" onclick="printreciept()"><i class="fa fa-print"></i>PRINT</button>
                                    </div>


                                </div>

                                <div class="clearfix"></div>
                                <div class="row" id="emailblock" style="display: none">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">EMAIL</div>
                                    <div class="col-md-4">
                                        <input type="email" name="uemail" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success btn-block"><i class="fa fa-share-square-o"></i>SEND EMAIL</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-danger btn-block"><i class="fa fa-close"></i>CLOSE</button>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div id="reciept" style="margin-top:5px">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <style>
                                                td {
                                                    padding: 5px;
                                                }
                                            </style>
                                            <table style="width: 100%; border: 1px solid #000;">
                                                <tr>
                                                    <th colspan="3" style="background: #ddd; font: 18px; text-align: center; padding: 2px"><b>RECIEPT</b></th>
                                                </tr>
                                                <tr>
                                                    <td><b>RECEIPT # :</b> R - <span id="trantopid"></span></td>
                                                    <td></td>
                                                    <td style="text-align: right">Date : 3/18/2021</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;"><b>TRANSACTION DETAILS</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Sender Number</b></td>
                                                    <td><span id="RemitterCode"></span></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Beneficiary Name</b></td>
                                                    <td><span id="Param1"></span></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td><b>Bank name</b></td>
                                                    <td><span id="Param5"></span></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Account Number</b></td>
                                                    <td><span id="Param2"></span></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Reference Number </b></td>
                                                    <td><span id="AckNo"></span></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Time </b></td>
                                                    <td><span id="AddDate"></span></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Amount </b></td>
                                                    <td>
                                                        Rs.<span id="Amount"></span>
                                                        <input type="hidden" id="hdamt" value="0" />
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid #ccc;">
                                                    <td><b>Service Charge / Sur-charge </b></td>
                                                    <td>
                                                        Rs.
                                                        <input type="number" id="sercharge" value="0" onkeyup="calamt()" />
                                                        <label id="lsercharge" style="display: none">0</label>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr style="font-size: 20px">
                                                    <td><b>Total Amount </b></td>
                                                    <td>Rs.<label id="totamt"></label></td>
                                                    <td></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="3" style="text-align: center; background: #ddd">
                                                        <p>
                                                            www.payin.co.in
                                                        </p>

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

    <link href="/Content/themes/base/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript">
        $(function () {
            $("#FromDate").datepicker({ minDate: -90, maxDate: 0 });
            $("#ToDate").datepicker({ minDate: -90, maxDate: 0 });
            $('.datepicker').datepicker({
                startDate: '-3d'
            });
        });

        function showreciept(data) {

            var line = data.split('|');
            $('#trantopid').html(line[0]);
            $('#RemitterCode').html(line[1]);
            $('#Param1').html(line[2]);
            $('#Param5').html(line[3]);
            $('#TranRefNo').html(line[4]);
            $('#Param2').html(line[5]);
            $('#Amount').html(line[6]);
            $('#AckNo').html(line[7]);
            $('#Status').val(line[8]);
            $('#AddDate').html(line[9]);
            $('#totamt').html(line[6]);
            $('#hdamt').val(line[6]);
            $('#myReciept').modal('show');
            if (line[1].contains('Money Slab')) {
                if (line[0] != "") {
                    if (line[2] != "") {
                        $.getJSON("/Recharge/GetTransDetails", { TranId: line[0], Number: line[2] }, function (data) {
                            if (data.split('~')[0] != "0") {
                                $('#Sender_No').html('Sender Number');
                                $('#Tran_Ref_No').html('Reference Number');
                                $('#Receiver_Div').show();
                                $('#BankAccount_No_Div').show();

                                if (data.split('~')[0] == "1") {
                                    //$('#Receiver_Head').html();
                                    $('#Receiver_Name').html(data.split('~')[1]);
                                    //$('#BankAccount_No_Head').html();
                                    $('#BankAccount_No_Name').html(data.split('~')[2]);
                                    $('#opids').html(data.split('~')[3]);
                                } else if (data.split('~')[0] == "2") {
                                    //$('#Receiver_Head').html();
                                    $('#Receiver_Name').html(data.split('~')[2]);
                                    //$('#BankAccount_No_Head').html();
                                    $('#BankAccount_No_Name').html(data.split('~')[3]);
                                    $('#opids').html(data.split('~')[4]);
                                }
                            }
                        });
                    }
                }
            } else {
                $('#Sender_No').html('Service Number');
                $('#Tran_Ref_No').html('Operator Reference Number');
                $('#Receiver_Div').hide();
                $('#BankAccount_No_Div').hide();
            }
        }


        function CheckTrxn(ackno, reference) {
            if (ackno != '' && reference != '') {
                swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
                $.post("/DMTNEWM/GetTransactQuery", { Ackno: ackno, Reference: reference }, function (datas) {
                    if (datas["ResponseStatus"] == "1") {
                        alert(datas["Remarks"]);
                        location.reload();
                    } else {
                        swal("Oops...", datas["Remarks"], "error");
                    }
                });
            } else {
                swal("Oops...", "Ackno & Reference No Required.", "error");
            }
        }
    </script>

    <script>
        $(function () {

            $("#emailbtn").click(function () {
                alert();
                $("#emailblock").toggle();
                hidesercharge();
            });
            $("#printbtn").click(function () {
                $("#emailblock").hide();
                hidesercharge();
            });
            $("#downbtn").click(function () {
                $("#emailblock").hide();
                hidesercharge();
            });

        });

        function hidesercharge() {
            $("#sercharge").hide();
            $("#lsercharge").show();
        }
        function printreciept() {
            hidesercharge();
            var divContents = $("#reciept").html();
            var printWindow = window.open("", "", "height='400',width=800");
            printWindow.document.write("<html>");
            printWindow.document.write("<body>");
            printWindow.document.write(divContents);
            printWindow.document.write("</body></html>");
            printWindow.document.close();
            printWindow.print();
        }

        function calamt() {
            var ser = $("#sercharge").val();
            var hdamt = $("#hdamt").val();
            if (ser != "") {
                var tot = parseInt(ser) + parseInt(hdamt);
                $("#totamt").html(tot);
                $("#lsercharge").html(ser);
            }
            else {
                $("#totamt").html(hdamt);
                $("#sercharge").val(0);
                $("#lsercharge").html(0);
            }
        }
    </script>
    <script src="/js/EXExcel/tableExport.js"></script>
    <script src="/js/EXExcel/jquery.base64.js"></script>
    <script>
        $(document).ready(function () {
            var varpdfFontSize = '7';
            $('#btnExport').bind('click', function (e) {
                $('#tblreports').tableExport({ type: 'excel', escape: 'false', pdfFontSize: varpdfFontSize });
            });
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
                        <img src="/Content/Images/Loader/Processing.gif" style="width:70px;" />
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

        <script src="/Content/Js/main/jquery.min.js"></script>
        <script src="/Content/Js/main/bootstrap.bundle.min.js"></script>
        <script src="https://demos.creative-tim.com/argon-dashboard-pro/assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="/Content/Js/main/jquery.scrollbar.min.js"></script>
        <script src="/Content/Js/main/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="/Content/Js/main/Chart.min.js"></script>
        <script src="/Content/Js/main/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="/Content/Js/main/argon.min.js"></script>
        <!-- Demo JS - remove this in your project -->
        <script src="/Content/Js/main/demo.min.js"></script>
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
        <script src="/Content/Js/main/jquery-ui.js"></script>

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
