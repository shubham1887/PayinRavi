
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

 <?php include("elements/agentsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <?php include("elements/agentheader.php"); ?>
        <!-- Header -->
        


<link href="<?php echo base_url(); ?>mpayfiles/moneytransfer.css" rel="stylesheet" />

<div data-ng-app="myapp" data-ng-controller="RINCNTRL" id="pagebodyBox" style="display:none;">
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-3">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Money Transfer</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row mg-t-20" data-ng-hide="searchBox">
            <div class="col-md-12 pd-xs-0">
                <div class="card card-min-height">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <div class="inputText">
                                        <input type="text" class="form-control formtext" placeholder="10 DIGIT NUMBER" maxlength="10" autofocus="autofocus" autocomplete="off" required="" data-ng-model="mobileNumber" data-ng-change="doFindDetails()" onkeypress="return ValidateNumber(event);" />
                                        <i class="typcn typcn-device-tablet"></i>
                                    </div>
                                </div>
                              
                            </div>
                              
                            <div class="col-md-12">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" data-ng-click="doFindDetails()" />
                                </div>
                                <label class="errormsg">{{ErrorMessage}}</label>
                            </div>
<h5 class="text-danger">Upload self-attested and both side (Front & Back) of Sender ID clearly {Aadhar Card (masking)/ PAN Card/ Indian Driving License/ Nepalese Citizenship/ Nepalese Passport *Any one}</h5>
<h5 class="text-danger">First Register Remitter Authorized will be (1hr-3hr) </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-------------- if user is not verified ------------------------>
<!-------------- if user is not verified ------------------------>
<!-------------- if user is not verified ------------------------>
<!-------------- if user is not verified ------------------------>
<!-------------- if user is not verified ------------------------>


        <div class="row mg-t-20" data-ng-hide="moneyBoxNovVerified">
            <div class="col-md-12 col-12 pd-xs-lr-0">
                <div class="card card-money">
                    <div class="card-content">
                        <div class="card-body pd-xs-lr-0 pd-md-0  pd-xs-10">
                            <div class="row shadow-md">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b><i class="fa fa-user tx-18 icon-red"></i>HI,{{SenderDetails.Name}}</b></p>
                                   
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Mobile : {{SenderDetails.SenderMobile}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Dob : {{SenderDetails.Dob}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Status : 
                                    <span class="success" data-ng-if="SenderDetails.Status==='Verified'"><span class="barSuccess"></span> {{SenderDetails.Status}}</span>


                                    <span class="pending" data-ng-if="SenderDetails.Status==='Unverified'"><span class="barPending"></span>{{SenderDetails.Status}}  {{SenderDetails.ApproveStatus}}</span>
                                </b></p>
                                </div>

                                <div class="col-md-8 col-lg-8 col-xl-8 col-8 pd-xs-5">
                                    <p class="mypara"><b>Address : {{SenderDetails.Address}} {{SenderDetails.City}} {{SenderDetails.State}} {{SenderDetails.District}}</b></p>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Nationality : {{SenderDetails.Nationality}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>IdType : {{SenderDetails.IdType}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>IdNumber : {{SenderDetails.IdNumber}}</b></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                                    <button type="submit" class="savebtn1" data-toggle="modal" data-target="#modalRemitter" style="line-height: 21px;float: right;">Change remitter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!------------- not verified end ----------------------------------------->
<!------------- not verified end ----------------------------------------->
<!------------- not verified end ----------------------------------------->
<!------------- not verified end ----------------------------------------->













        <div class="row mg-t-20" data-ng-hide="moneyBox">
            <div class="col-md-6 col-12 pd-xs-lr-0">
                <div class="card card-money">
                    <div class="card-content">
                        <div class="card-body pd-xs-lr-0 pd-md-0  pd-xs-10">
                            <div class="row shadow-md">
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b><i class="fa fa-user tx-18 icon-red"></i>HI,{{SenderDetails.Name}}</b></p>
                                   
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Mobile : {{SenderDetails.SenderMobile}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Dob : {{SenderDetails.Dob}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Status : 
                                    <span class="success" data-ng-if="SenderDetails.Status==='Verified'"><span class="barSuccess"></span> {{SenderDetails.Status}}</span>


                                    <span class="pending" data-ng-if="SenderDetails.Status==='Unverified'"><span class="barPending"></span>{{SenderDetails.Status}}</span>
                                    <br><span class="alert info">{{SenderDetails.ApproveStatus}}</span>
                                   

                                </b></p>
                                </div>

                                <div class="col-md-8 col-lg-8 col-xl-8 col-8 pd-xs-5">
                                    <p class="mypara"><b>Address : {{SenderDetails.Address}} {{SenderDetails.City}} {{SenderDetails.State}} {{SenderDetails.District}}</b></p>
                                </div>

                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>Nationality : {{SenderDetails.Nationality}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>IdType : {{SenderDetails.IdType}}</b></p>
                                </div>
                                <div class="col-md-4 col-lg-4 col-xl-4 col-4 pd-xs-5">
                                    <p class="mypara"><b>IdNumber : {{SenderDetails.IdNumber}}</b></p>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12 col-12">
                                    <button type="submit" class="savebtn1" data-toggle="modal" data-target="#modalRemitter" style="line-height: 21px;float: right;">Change remitter</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12 col-xl-12 pd-0">
                                    <form>
                                        <div class="mycontainer">
                                            <div class="col-md-12 col-12 col-xl-12">
                                                <label for="fund">Action {{selector}}</label>
                                                <Select id="selector" class="form-control fontb" name="dropdown" data-ng-model="selector" data-ng-change="doShowBoxView()">
AddBeneficiaryCashPayment
                                                    <option value="AddBeneficiaryCashPayment">ADD BENEFICIARY Cash Payment</option>
                                                    <option value="AddBeneficiaryAccountDeposit">ADD BENEFICIARY Account Deposit</option>
                                                    <option value="FundTransfer">FUND TRANSFER</option>
                                                </Select>
                                            </div>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------  F U N D    T R A N S F E R  ------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>                                            

                                            <div class="FundTransfer box" data-ng-hide="FundTransferBox">
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="form-group" data-ng-hide="ENDIS_transAccountNo">
                                                        <label for="ac">Account Number</label>
                                                        <div class="inputText" >
                                                            <input type="text" placeholder="Enter Account Number" class="form-control fontb"  data-ng-model="transAccountNo" readonly="readonly" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" data-ng-hide="ENDIS_transBankName">
                                                        <label for="bank">Bank name</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Bank name" class="form-control fontb" data-ng-model="transBankName" readonly="readonly" />

                                                            <input type="hidden"  data-ng-model="transBankBranchId" readonly="readonly" />



                                                            <i class="icon fa fa-bank"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-8 col-8 col-xl-8">
                                                            <div class="form-group">
                                                                <label for="bank">Benificiary Name</label>
                                                                <input type="text" placeholder="Enter Benificiary name" class="form-control fontb" data-ng-model="transRecipientName" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4 col-xl-4 wrapper">
                                                            <button type="submit" class="savebtn" data-ng-click="dovalidateaftertransferdata(transRecipientID)">GET NAME</button>
                                                            <input type="hidden" data-ng-model="transRecipientID" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-6 col-xl-6">
                                                            <div class="form-group">
                                                                <label for="bank">Receiver Mobile</label>
                                                                <input type="text" class="form-control fontb" data-ng-model="transRecipientMobile" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-6 col-xl-6">
                                                            <div class="form-group">
                                                                <label for="bank">Relation With Sender</label>
                                                                <input type="text" class="form-control fontb" data-ng-model="transRecipientRelation" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xl-4 col-12">
                                                            <div class="form-group">
                                                                <label for="fund">Mode</label>
                                                                <input type="text"  class="form-control fontb" data-ng-model="transPaymentType" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xl-4 col-12">
                                                            <div class="form-group">
                                                                <label for="fund">Service Charge</label>
                                                                <input type="text"  class="form-control fontb" data-ng-model="transServiceCharge" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-xl-4 col-12">
                                                            <div class="form-group fontb">
                                                                <label for="fund" class="fontb">Payout Amount (Nepal Rupee)</label>
                                                                <input type="text"  class="form-control fontb" data-ng-model="transPayoutAmount" readonly="readonly" />
                                                            </div>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-4 col-xl-4 col-12">
                                                            <div class="form-group">
                                                                <label for="fund" class="fontb">Transfer Amount</label>
                                                                <input type="text" class="form-control fontb" name="amt" placeholder="Amount" maxlength="5" data-ng-model="transAmount" onkeypress="return ValidateNumber(event)" autocomplete="off" data-ng-change="doFindNumberinWords()" />
                                                                <label for="fund" style="font-weight:bold;">{{amountinWord}}</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-xl-4 col-12">
                                                            <div class="form-group">
                                                                <label for="fund" class="fontb">Collection Amount</label>
                                                                <input type="text" class="form-control fontb" name="amt" placeholder="Amount" maxlength="5" data-ng-model="transCollectionAmount" onkeypress="return ValidateNumber(event)" autocomplete="off" data-ng-change="doFindNumberinWordsCollectionAmount()" />
                                                                <label for="fund" style="font-weight:bold;">{{amountinWordCollectionAmount}}</label>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 col-xl-4 col-12">
                                                            <div class="form-group fontb">
                                                                <label for="fund" class="fontb">Transaction PIN</label>
                                                                <input type="password" class="form-control fontb" name="amt1" placeholder="Enter TPIN" maxlength="4" data-ng-model="transtpin" onkeypress="return ValidateNumber(event)" autocomplete="new-password" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 col-xl-12">
                                                     <div class="row">
                                            <div class="col-md-6 col-xl-6 col-6">          
                                    <label class="fontb">Remittance Reason</label>
                                    <div class="inputText fontb">
                                        <select class="form-control fontb" data-ng-model="ftremitancereason">
                                            <option value="">Select</option>
                                            <option value="Family Maintenance">Family Maintenance</option>
                                            <option value="Saving Purpose">Saving Purpose</option>
                                            <option value="Repayment of Loans">Repayment of Loans</option>
                                            <option value="Medical Expenses">Medical Expenses</option>
                                            <option value="EMI Payments">EMI Payments</option>
                                            <option value="Utility Payment">Utility Payment</option>
                                            <option value="Educational Expenses">Educational Expenses</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                                                </div>


                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-9 col-9 col-xl-9">
                                                            <button type="submit" class="btn btn-primary btn-block" data-ng-click="dopretransferMemberfnd()">Fund Transfer</button>
                                                        </div>
                                                        <div class="col-md-12 col-12 col-xl-12">
                                                            <label class="errormsg">{{FundErrorMessage}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!----- add bene cash payment box start ------------>
                                            <!----- add bene cash payment box start ------------>
                                            <!----- add bene cash payment box start ------------>
                                            <!----- add bene cash payment box start ------------>

<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------  Add Receiver CASH PAYMENT ----------------------------------------------->
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>                                            
                                            <div class="AddBeneficiary box" data-ng-hide="AddBeneficiaryCashPaymentBox">
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    
                                                    <div class="form-group">
                                                        <label for="ac">Receiver Name</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Receiver Name" class="form-control fontb" data-ng-model="rcptReceiverName" maxlength="30" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bank">Gender</label>
                                                        <div class="inputText">
                                                            <select class="form-control fontb select-opt" data-ng-model="rcptReceiverGender" >
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="ac">Receiver Mobile Number</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Receiver Mobile Number" class="form-control fontb" data-ng-model="rcptReceiverMobileNo" maxlength="10" onkeypress="return ValidateNumber(event)" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                        <label for="ac" style="font-weight:bold;" data-ng-show="rcptReceiverMobileNo.length">Mobile No.{{rcptReceiverMobileNo.length}} Digits</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="ac">Receivers Address</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Receiver Address" class="form-control fontb" data-ng-model="rcptReceiverAddress" maxlength="500" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bank">Relationship With Sender</label>
                                                        <div class="inputText">
                                                            <select class="form-control fontb select-opt" data-ng-model="rcptReceiverRelationship" >
                                                                <option value="Aunti">Aunti</option>
                                                                <option value="Boy Friend">Boy Friend</option>
                                                                <option value="Brother">Brother</option>
                                                                <option value="Brother in Law">Brother in Law</option>
                                                                <option value="Cousin">Cousin</option>
                                                                <option value="Daughter">Daughter</option>
                                                                <option value="Father">Father</option>
                                                                <option value="Father in Law">Father in Law</option>


                                                                <option value="Friend">Friend</option>
                                                                <option value="Girl Friend">Girl Friend</option>
                                                                <option value="Grand Father">Grand Father</option>
                                                                <option value="Grand Mother">Grand Mother</option>
                                                                <option value="Husband">Husband</option>
                                                                <option value="Mother">Mother</option>
                                                                <option value="Mother in Law">Mother in Law</option>
                                                                <option value="Nephew">Nephew</option>
                                                                <option value="Niece">Niece</option>
                                                                <option value="Other">Other</option>
                                                                <option value="Self">Self</option>
                                                                <option value="Sister">Sister</option>
                                                                <option value="Sister in Law">Sister in Law</option>
                                                                <option value="Son">Son</option>
                                                                <option value="Uncle">Uncle</option>
                                                                <option value="Wife">Wife</option>

                                                                
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-12 col-12 col-xl-12">
                                                            <button type="submit" class="btn btn-primary btn-block" data-ng-click="dormtreceivercashpaymentdatavalue()">ADD</button>
                                                            <label class="errormsg">{{RcptReceiverErrorMessage}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------  Add Beneficiary Receiver Account Deposit ----------------------------------------------->
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
                                            <div class="AddBeneficiary box" data-ng-hide="AddBeneficiaryBox">
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="form-group">
                                                        <label for="ac">Account Number</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Account Number" class="form-control fontb" data-ng-model="rcptAccountNoAD" maxlength="20" onkeypress="return ValidateNumber(event)" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                        <label for="ac" style="font-weight:bold;" data-ng-show="rcptAccountNo.length">Account No.{{rcptAccountNoAD.length}} Digits</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bank">Bank name</label>
                                                        <div class="inputText">
                                                            <select class="form-control fontb select-opt" data-ng-model="rcptBankName" data-ng-options="p.BankName for p in BankNameDetails track by p.BankName" data-ng-change="dofindifsccode()">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="bank">City name</label>
                                                        <div class="inputText">
                                                            <select class="form-control fontb select-opt" data-ng-model="rcptBankCityName" data-ng-options="p.City for p in BankCityDetails track by p.City" data-ng-change="dofindBranchCode()">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="form-group">
                                                        <label for="bank">Branch name</label>
                                                        <div class="inputText">
                                                            <select class="form-control fontb select-opt" data-ng-model="rcptBankBranchName" data-ng-options="p.BranchAddress for p in BankBranchDetails track by p.BranchCode" data-ng-change="">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    
                                                </div>
                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-8 col-8 col-xl-8">
                                                            <label for="bank">Receiver Name</label>
                                                            <div class="inputText">
                                                                <input type="text" placeholder="Enter Receiver name" class="form-control fontb" data-ng-model="rcptRecipientNameAD" onkeypress="return ValidateAlphabetSpace(event)" />
                                                                <i class="icon fa fa-user"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4 col-xl-4 wrapper">
                                                            <button type="submit" class="savebtn" data-ng-click="dovalidatebeforedata()">GET NAME</button>
                                                            <input type="hidden" data-ng-model="rcptisverifiedAD" />
                                                        </div>
                                                    </div>
                                                </div>





                                                <div class="col-md-12 col-12 col-xl-12">


                                                <div class="form-group">
                                                    <label for="bank">Gender</label>
                                                    <div class="inputText">
                                                        <select class="form-control fontb select-opt" data-ng-model="rcptReceiverGenderAD" >
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                    <div class="form-group">
                                                        <label for="ac">Receiver Mobile Number</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Receiver Mobile Number" class="form-control fontb" data-ng-model="rcptReceiverMobileNoAD" maxlength="10" onkeypress="return ValidateNumber(event)" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                        <label for="ac" style="font-weight:bold;" data-ng-show="rcptReceiverMobileNo.length">Mobile No.{{rcptReceiverMobileNo.length}} Digits</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="ac">Receivers Address</label>
                                                        <div class="inputText">
                                                            <input type="text" placeholder="Enter Receiver Address" class="form-control fontb" data-ng-model="rcptReceiverAddressAD" maxlength="500" />
                                                            <i class="icon fa fa-edit"></i>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bank">Relationship With Sender</label>
                                                        <div class="inputText">
                                                            <select class="form-control fontb select-opt" data-ng-model="rcptReceiverRelationshipAD" >
                                                                <option value="Aunti">Aunti</option>
                                                                <option value="Boy Friend">Boy Friend</option>
                                                                <option value="Brother">Brother</option>
                                                                <option value="Brother in Law">Brother in Law</option>
                                                                <option value="Cousin">Cousin</option>
                                                                <option value="Daughter">Daughter</option>
                                                                <option value="Father">Father</option>
                                                                <option value="Father in Law">Father in Law</option>


                                                                <option value="Friend">Friend</option>
                                                                <option value="Girl Friend">Girl Friend</option>
                                                                <option value="Grand Father">Grand Father</option>
                                                                <option value="Grand Mother">Grand Mother</option>
                                                                <option value="Husband">Husband</option>
                                                                <option value="Mother">Mother</option>
                                                                <option value="Mother in Law">Mother in Law</option>
                                                                <option value="Nephew">Nephew</option>
                                                                <option value="Niece">Niece</option>
                                                                <option value="Other">Other</option>
                                                                <option value="Self">Self</option>
                                                                <option value="Sister">Sister</option>
                                                                <option value="Sister in Law">Sister in Law</option>
                                                                <option value="Son">Son</option>
                                                                <option value="Uncle">Uncle</option>
                                                                <option value="Wife">Wife</option>

                                                                
                                                            </select>
                                                        </div>
                                                    </div>




                                                </div>









                                                <div class="col-md-12 col-12 col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-12 col-12 col-xl-12">
                                                            <button type="submit" class="btn btn-primary btn-block" data-ng-click="dormtreceiverAccountDepositmentdatavalue()">ADD</button>
                                                            <label class="errormsg">{{RcptReceiverRegAccountDepositErrorMessage}}</label>
                                                        </div>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!----------------------XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX--------------------------->
<!-----------XXXXXXXXXXXXXXXXXXXX END Add Receiver Account Deposit XXXXXXXXXXXXXXXXXXXX----------------->
<!----------------------XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX--------------------------->
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12 col-xl-6 pd-xs-lr-0">
                <div class="card card-money">
                    <div class="card-content">
                        <div class="card-body  pd-xs-10">
                            <div class="row mycont pd-b-15">
                                <div class="col-md-6 col-6 col-xl-6 text-left">
                                    <h6>BENIFICIARY LIST</h6>
                                </div>
                                <div class="col-md-12 col-12 col-xl-6">
                                    <div class="inputText">
                                        <input type="text" placeholder="Search Here" class="txtsearch form-control" data-ng-model="filtercipient" autocomplete="off" />
                                        <i class="icon fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row mycont bene-box">
                                <table class="table table-bene">
                                    <tbody>
                                        <tr data-ng-repeat="item in BeneficiaryDetails | filter:filtercipient">
                                            <td>
                                                <div class="row">
                                                    
                                                    <div class="col-md-6 col-xl-7 col-6 pd-xs-5">
                                                        <h5 style="float: left;">{{item.PaymentMode}}</h5><br>
                                                    </div>
                                                    <div class="col-md-6 col-xl-7 col-6 pd-xs-5">
                                                        
                                                        <p class="mypara1">Name : <b>{{item.Name}}</b>&nbsp;&nbsp;&nbsp;({{item.Gender}})</p>
                                                        <p class="para3">
                                                            <span>
                                                                Mobile : {{item.Mobile}}<br />
                                                                Address : {{item.Address}}<br />
                                                                Relation : {{item.Relationship}}<br />

                                                            </span>
                                                            <span data-ng-if="item.PaymentMode == 'Account Deposit'">
                                                                <span >Account No : {{item.accountNumber}}</span><br>
                                                                <span >BankName : {{item.BankName}}</span><br>
                                                                <span >BranchName : {{item.BankBranchName}}</span><br>  
                                                            </span>

                                                        </p>
                                                    </div>
                                                    <div class="col-md-6 col-xl-5 col-6 pd-xs-5">
                                                        <button type="button" class="btn2" data-ng-click="dobindtransferdata(item)">TRANSFER</button>
                                                        <span data-ng-click="doremovedata(item)"><i class="trashicon fa fa-trash"></i></span>
                                                        <p class="para4"><span data-ng-if="item.IsValidate"><i class="fa fa-check checkicon"></i><span class="text-green">&nbsp;Success</span></span><span data-ng-if="!item.IsValidate" style="cursor:pointer;" data-ng-click="dovalidateafterdata(item)"><i class="fa fa-check"></i><span class="text-orange">&nbsp;Click to Validate</span></span></p>
                                                    </div>
                                                </div>
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

        <div class="row mg-t-20 mg-t-xs-0" data-ng-hide="transactionBox">
            <div class="col-md-12 col-12 pd-xs-lr-0">
                <div class="card card-min-height">
                    <div class="card-content">
                        <div class="card-body pd-lr-0  pd-xs-10">
                            <div class="row">
                                <div class="col-md-2 col-12 form-group">
                                    <label>Remitter</label>
                                    <div class="inputText">
                                        <input type="text" class="form-control" placeholder="Remitter" data-ng-model="srcMobileNo" maxlength="10" onkeypress="return ValidateNumber(event)" required="" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 form-group">
                                    <label>Order ID</label>
                                    <div class="inputText">
                                        <input type="text" class="form-control" placeholder="Order ID" data-ng-model="srcOrderID" maxlength="20" required="" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 form-group">
                                    <label>Bank Account</label>
                                    <div class="inputText">
                                        <input type="text" class="form-control" placeholder="Bank Account" data-ng-model="srcAccountNo" maxlength="16" onkeypress="return ValidateNumber(event)" required="" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 form-group">
                                    <label>Transfer Amount</label>
                                    <div class="inputText">
                                        <input type="text" class="form-control" placeholder="Transfer Amount" data-ng-model="srctxnAmount" maxlength="10" onkeypress="return ValidateNumber(event)" required="" />
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <label>Status</label>
                                    <div class="inputText">
                                        <select class="form-control" data-ng-model="srctxnStatus">
                                            <option value="">Select</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            <option value="Reversal">Reversal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 form-group">
                                    <br />
                                    <button type="submit" class="btn btn-primary btn-block" data-ng-click="doBindtxndatamemberr()"><i class="fa fa-search"></i></button>
                                </div>
                                <div class="col-md-12 col-12 table-responsive">
                                    <table class="table table-transaction">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Order Details</th>
                                                <th>Sender Details</th>
                                                <th>Account Details</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-ng-repeat="txn in currenttxnDetails">
                                                <td>{{txn.Trxndate}}</td>
                                                <td style="line-height: 21px;">Order ID : {{txn.OrderID}} <br />Bank Ref. : {{txn.OptID}}</td>
                                                <td><p class="number">{{txn.Number}}</p>  {{txn.Accountname}}</td>
                                                <td style="line-height: 21px;">{{txn.Accountno}}  <br /><span class="btnimps">{{txn.Trxntype}}</span> {{txn.IFSC}} </td>
                                                <td><b>₹ {{txn.Amount}}</b></td>
                                                <td><span data-ng-if="txn.Status=='Success'" class="success"><span class="barSuccess"></span>Success</span><span data-ng-if="txn.Status=='Pending'" class="pending"><span class="barPending"></span>Pending</span><span class="failure" data-ng-if="txn.Status=='Failure' || txn.Status=='Reversal'"><span class="barFailure"></span>{{txn.Status}}</span></td>

                                                <td>
                                                    <a href="/Retailer/TransactionReportDetails?Id={{txn.OrderID}}" target="_blank" class="btnview" data-ng-if="txn.Status=='Success'">Reciept</a></td>
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

        <div id="modalRemitter" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Change Remitter</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body pd-lr-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="inputText">
                                    <input type="text" class="form-control" placeholder="Remitter Mobile Number" data-ng-model="searchMobileNumber" onkeypress="return ValidateNumber(event);" required="" data-ng-change="dosearchFindDetails()" />
                                    <i class="icon fa fa-mobile"></i>
                                </div>
                            </div>
                            <label class="errormsg">{{SearchErrorMessage}}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-ng-click="dosearchFindDetails()">Continue</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Start-->
<!---------  Customer Create Popup Dialog Start ------------->
<!---------  Customer Create Popup Dialog Start ------------->
<!---------  Customer Create Popup Dialog Start ------------->
<!---------  Customer Create Popup Dialog Start ------------->
<!---------  Customer Create Popup Dialog Start ------------->
<!---------  Customer Create Popup Dialog Start ------------->        
        <div id="modalRegisterRemitter" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="color: #FFF;font-weight: bold;font-size: 18px;font-family: sans-serif;">Register Remitter</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body pd-lr-0">
                        <div class="row">


                            <form action="<?php echo base_url(); ?>Retailer/IndoNepal" method="post" autocomplete="off">
                            <input name="__RequestVerificationToken" type="hidden" value="lqhZGW2Q63NueCU43LDw7_MAIVAeWk553vTxvvM8cFZ9RkJkXx3NuWtk6_eoSdkqaDrVSIFCYxgrPCkC59K9vLNAg8jOwgL-4KgcmkoHU_s1">
                            <div class="row" >
                                <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Name</label>
                                    <input type="text" class="form-control formtext" placeholder="First Name" required="" data-ng-model="rmtFirstName" maxlength="30" onkeypress="return ValidateOnlyAlphabet(event)" autocomplete="off"  />
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Date Of Borth</label>

                                    <div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control formtext" required="" data-ng-model="rmtDOB" maxlength="10"  autocomplete="off" placeholder="YYYY-MM-DD"  />
                                                    
                                                </div>
                                            </div>



                                    
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Gender</label>
                                    <select type="text" class="form-control formtext" data-ng-model="rmtGender" >
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>

                                    </select>

                                </div>
                            </div>


                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control formtext" placeholder="Mobile Number" required="" data-ng-model="rmtMobileNumber" maxlength="10"  autocomplete="off"  />
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>EmailId</label>
                                    <input type="text" class="form-control formtext" placeholder="EmailId" required="" data-ng-model="rmtEmailId" maxlength="30" autocomplete="off"  />
                                </div>
                            </div>


                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Nationality</label>
                                    <select type="text" class="form-control formtext" data-ng-model="rmtNationality"  >
                                        
                                        <option value="Indian">Indian</option>
                                        <option value="Nepales">Nepalese</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Address</label>
                                <div class="inputText">
                                    <input type="text" class="form-control formtext" placeholder="Address" required="" data-ng-model="rmtAddress" maxlength="120"  autocomplete="off"  />
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>City</label>
                                    <input type="text" class="form-control formtext" placeholder="Enter City Name" required="" data-ng-model="rmtCity" maxlength="120"  autocomplete="off"  />
                                   
                                </div>
                            </div>





                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>State</label>

                                      <select class="form-control fontb select-opt" data-ng-model="rmtState"  data-ng-change="dofindDistrict()">

                                        <option></option>
                                        <?php 

                                            $statedistrict = $this->db->query("select aState,aDistrict,aStateCode from indonepal_statedistrict_india group BY aState order by aState" );

                                            foreach($statedistrict->result() as $rwstatedist)   
                                            {?>
                                                <option value="<?php echo $rwstatedist->aState; ?>"><?php echo $rwstatedist->aState; ?></option>

                                            <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>District</label>
                                    <select class="form-control fontb select-opt" data-ng-model="rmtDistrict"  data-ng-change="">
                                            <option value="">Select</option>
                                            <option ng-repeat="District in DistrictDetails" value="{{District.aDistrict}}">{{District.aDistrict}}</option>
                                    </select>


                                   

                                </div>
                            </div>
                            




                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Id Type</label>
                                    <select type="text" class="form-control formtext" data-ng-model="rmtIdType" >
                                        <option value="">Select</option>
                                        <?php 
                                            $json_obj_idtype = json_decode($this->IndoNepalPrabhu->getIdType());
                                            foreach($json_obj_idtype as $rwidtype)
                                            {?>
                                                <option value="<?php echo $rwidtype; ?>"><?php echo $rwidtype; ?></option>
                                            <?php }

                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Id Number</label>
                                    <input type="text" class="form-control formtext" placeholder="Id Number" required="" data-ng-model="rmtIdNumber" maxlength="30"  autocomplete="off"  />
                                </div>
                            </div>




                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Income Source</label>
                                    <select type="text" class="form-control formtext" data-ng-model="rmtIncomeSource" >
                                        <option value="">Select</option>
                                        <?php 
                                            $json_obj_incomeSource = json_decode($this->IndoNepalPrabhu->getIncomeSource());
                                            foreach($json_obj_incomeSource as $rwincomesource)
                                            {?>
                                                <option value="<?php echo $rwincomesource; ?>"><?php echo $rwincomesource; ?></option>
                                            <?php }

                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="inputText">
                                    <label>Employeer</label>
                                    <input type="text" class="form-control" placeholder="Employeer" required="" data-ng-model="rmtEmployeer" maxlength="30"  autocomplete="off"  />
                                </div>
                            </div>
                            
                            </div>
                        </form>


                            





                            <label class="errormsg">{{rmtErrorMessage}}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-ng-click="dormtmemberdatavalue()">Register</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
<!--------XXXXX Customer Create Popup Dialo Ends Here XXXXX-----------------> 
<!--------XXXXX Customer Create Popup Dialo Ends Here XXXXX-----------------> 
<!--------XXXXX Customer Create Popup Dialo Ends Here XXXXX-----------------> 
<!--------XXXXX Customer Create Popup Dialo Ends Here XXXXX-----------------> 
<!--------XXXXX Customer Create Popup Dialo Ends Here XXXXX-----------------> 


        <div id="modalVerifyRemitter" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Verify Remitter</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body pd-lr-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="inputText">
                                    <input type="text" class="form-control" placeholder="OTP" required="" data-ng-model="rmtOtp" maxlength="6" onkeypress="return ValidateNumber(event);" autocomplete="off"  />
                                    <i class="icon fa fa-mobile"></i>
                                </div>
                            </div>
                            <label class="errormsg">{{rmtVfyErrorMessage}}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-ng-click="dormtmemberverifydatavalue()">Verify</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
<!---------------- end model verify remitter --------------------------->    







<!------------- Receiver Create Popup Dialo Ends Here ------------------------>        
<!------------- Receiver Create Popup Dialo Ends Here ------------------------>        
<!------------- Receiver Create Popup Dialo Ends Here ------------------------>        
<!------------- Receiver Create Popup Dialo Ends Here ------------------------>        
<!------------- Receiver Create Popup Dialo Ends Here ------------------------>        

        <div id="modalVerifyReceiver" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Verify Receiver</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body pd-lr-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="inputText">
                                    <input type="text" class="form-control" placeholder="OTP" required="" data-ng-model="rmtReceiverOtp" maxlength="6" onkeypress="return ValidateNumber(event);" autocomplete="off"  />
                                    <i class="icon fa fa-mobile"></i>
                                </div>
                            </div>
                            <label class="errormsg">{{ReceiverCashPaymentVfyErrorMessage}}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-ng-click="dormtreceivercashpaymentverifydatavalue()">Verify</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
<!---------------- end model verify remitter --------------------------->        

        <div id="modalTransferAmt" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body pd-lr-0">
                        <div class="row">
                            <div class="col-md-6 text-right">
                                <h4>Transfer Amount</h4>
                            </div>
                            <div class="col-md-6">
                                <h4> <i class="fa fa-inr"></i> {{transAmount}}</h4>
                            </div>
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <td style="width:50%;">
                                            <table>
                                                <tr>
                                                    <td style="border-top: 0px;">
                                                        <b class="f-700">Remitter</b>
                                                        <p>{{SenderDetails.Name}}</p>

                                                        <b class="f-700">Benificiary</b>
                                                        <p class="m-0">{{transRecipientID.Name}}</p>
                                                        <p class="m-0">{{transRecipientID.BankName}}</p>
                                                        <p class="m-0">{{transRecipientID.AccountNo}}</p>
                                                        <p class="m-0">{{transRecipientID.IFSC}}</p>
                                                        <br />
                                                        <b class="f-700">Payment Mode</b>
                                                        <p>{{transPaymentType}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="width:50%;border-left:1px solid #ddd;">
                                            <table>
                                                <tr>
                                                    <td style="border-top: 0px;">
                                                        <b class="f-700">Transfer Amount (INR)</b>
                                                        <p><i class="fa fa-inr"></i> {{chargeBreakup.info_TransferAmount}}</p>

                                                        <b class="f-700">Collect From Customer</b>
                                                        <p><i class="fa fa-inr"></i> {{chargeBreakup.info_CollectionAmount}}</p>

                                                        <b class="f-700">Exchange Rate</b>
                                                        <p> {{chargeBreakup.info_ExchangeRate}}</p>

                                                        <b class="f-700">Receiver Payout (Nepal Rupee)</b>
                                                        <p><i class="fa fa-npr"></i> {{chargeBreakup.info_PayoutAmount}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="inputText">
                                    <input type="text" class="form-control" placeholder="OTP" required="" data-ng-model="rmtTransferOtp" maxlength="8" onkeypress="return ValidateNumber(event);" autocomplete="off"  />
                                    <i class="icon fa fa-mobile"></i>
                                    <input type="hidden" data-ng-model="hidTransferOtpProcessId" value="{{TransProcessId}}" />
                                </div>
                                </div>
                                 <div class="col-4">
                                    <button type="submit" class="btn btn-danger" data-ng-click="dofnlmemberdataproctorgtxnroute()">Proceed To Pay</button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>

        <div id="modalOrderStatus" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Order Status</h5>
                    </div>
                    <div class="modal-body pd-lr-0">
                        <div class="row" style="overflow:auto; height:300px;">
                            <div class="col-md-6 text-right">
                                <h4>Amount</h4>
                            </div>
                            <div class="col-md-6">
                                <h4> <i class="fa fa-inr"></i> {{showtransAmount}}</h4>
                            </div>
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <td style="width:50%;vertical-align:top;background: #f9f9f9;">
                                            <table class="table">
                                                <tr>
                                                    <td style="border-top: 0px;">
                                                        <b class="f-700">Remitter</b>
                                                        <p>{{SenderDetails.Name}}</p>

                                                        <b class="f-700">Benificiary</b>
                                                        <p class="m-0">{{transRecipientID.Name}}</p>
                                                        <p class="m-0">{{transRecipientID.BankName}}</p>
                                                        <p class="m-0">{{transRecipientID.AccountNo}}</p>
                                                        <p class="m-0">{{transRecipientID.IFSC}}</p>
                                                        <br />
                                                        <b class="f-700">Payment Mode</b>
                                                        <p>{{transPaymentType}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="width:50%;border-left:1px solid #ddd;vertical-align:top;background: #f9f9f9;">
                                            <table class="table">
                                                <tr>
                                                    <td style="border-top: 0px;">
                                                        <b class="f-700">Transfer Details</b>
                                                        <div class="clearfix"></div>
                                                        <div class="transdet" data-ng-hide="paySlab1">
                                                            <span id="paySlab1Amt">&#8377; {{paySlab1Amount}}</span>
                                                            <span id="paySlab1Status"></span>
                                                            <div class="clearfix"></div>
                                                            <p id="paySlab1Message"></p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="transdet" data-ng-hide="paySlab2">
                                                            <span id="paySlab2Amt">&#8377; {{paySlab2Amount}}</span>
                                                            <span id="paySlab2Status"></span><div class="clearfix"></div>
                                                            <p id="paySlab2Message"></p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="transdet" data-ng-hide="paySlab3">
                                                            <span id="paySlab3Amt">&#8377; {{paySlab3Amount}}</span>
                                                            <span id="paySlab3Status"></span><div class="clearfix"></div>
                                                            <p id="paySlab3Message"></p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="transdet" data-ng-hide="paySlab4">
                                                            <span id="paySlab4Amt">&#8377; {{paySlab4Amount}}</span>
                                                            <span id="paySlab4Status"></span><div class="clearfix"></div>
                                                            <p id="paySlab4Message"></p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="transdet" data-ng-hide="paySlab5">
                                                            <span id="paySlab5Amt">&#8377; {{paySlab5Amount}}</span>
                                                            <span id="paySlab5Status"></span><div class="clearfix"></div>
                                                            <p id="paySlab5Message"></p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                	<td colspan="2">
                                                		<a href="<?php echo base_url(); ?>Retailer/IndoNepal_verify_transacion" class="btn btn-success">Verify Transaction</a>
                                                	</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <label class="errormsg">{{FundfnlErrorMessage}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="IndoNepal/Receipt?Id={{ResponseData.OrderID}}" target="_blank" class="btn btn-primary" data-ng-hide="fundPrintBox">Print</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal" data-ng-click="doFindDetails()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!--end-->

        <div id="modalRcptRemove" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>OTP sent to {{mobileNumber}}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body pd-lr-0">
                        <div class="row">
                            <div class="col-md-12 text-center form-group">
                                <p style="margin-bottom:5px;">Please verify OTP to delete beneficiary</p>
                                <h5>{{rmvRcptID.Name}}  | {{rmvRcptID.AccountNo}}</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="inputText">
                                    <input type="text" class="form-control" placeholder="OTP" data-ng-model="RmvOtp" onkeypress="return ValidateNumber(event);" required="" maxlength="6" autocomplete="off" />
                                    <i class="icon fa fa-mobile"></i>
                                </div>
                                <input type="hidden" data-ng-model="rmvRcptID" />
                            </div>
                            <label class="errormsg">{{RemoveErrorMessage}}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row w-100">
                            <div class="col-md-3 offset-md-1">
                                <button type="submit" class="btn btn-warning" data-ng-click="doremovedata(rmvRcptID)">Resend</button>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-primary" data-ng-click="doverifyremovedata(rmvRcptID)">Verify</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Later</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<!---------------- document upload dialog starts here -------------------->
<!----------------------------------------------- ------------------------->
<!------------------------                          ----------------------->
       <!--Start-->

        <div id="modalUploadRemitter" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm m-t-100">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="color: #FFF;font-weight: bold;font-size: 18px;font-family: sans-serif;">Upload Document</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="<?php echo base_url(); ?>Retailer/IndoNepal/UploadDocument" method="post" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="etCustomerMobile" id="etCustomerMobile">
                        <input type="hidden" name="etIDType" id="etIDType">
                        <input type="hidden" name="etIDNumber" id="etIDNumber">



                        
                    <div class="modal-body pd-lr-0">
                        <div class="row">


                            
                           
                            <div class="row" >
                                <div class="col-md-12 form-group">
                                    <div class="inputText">
                                        <h5>Id Type : <b><span id="idtype_uploadmodel"></span></b></h5>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="inputText">
                                        <h5>Id Number : <b><span id="idnumber_uploadmodel"></span></b></h5>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <div class="inputText">
                                        <label>Upload</label>
                                        <input type="file" name="file_idProof" value="Upload">
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="btnUploadSenderData">Upload</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                    
                </div>
            </div>
        </div>






<!------------- document upload dialog ends here  ---------------------------->
<!-------------                                   ---------------------------->  

<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'top',
            trigger: 'hover'
        });
    });
</script>
<script src="<?php echo base_url(); ?>mpayfiles/in/ag.jquery-validate05.js"></script>

<script src="<?php echo base_url(); ?>mpayfiles/in/angular.min.js"></script>
<script src="<?php echo base_url(); ?>mpayfiles/in/angular.routeartrg.member.min.1.7.7.js"></script>

<link href="<?php echo base_url(); ?>mpayfiles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>mpayfiles/select2.min.js"></script>
<script>
    $(".select-opt").select2({
        placeholder: "Select"
    });
</script>
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









        <script type="text/javascript">
            function fillcityddl()
            {
                
                //rmtState,rmtDistrict
                var state = jQuery('.rmtState').val();
                jQuery.ajax({
                    url: '/Retailer/IndoNepal/BindDistrict?state='+state,
                    type: 'POST',
                    data:{'state':state},
                    cache:false,
                    success: function (response) 
                    {
                        jQuery('.rmtDistrict').html(response);
                    }, 
                    error: function (response) 
                    {
                      //  alert('Something went wrong, try later.'); 
                        //location.reload();
                    }, 
                    async: true
                });
}
        </script>




<!--Calnedar Plugin-->
<link href="<?php echo base_url(); ?>mpayfiles/jquery-ui.css" rel="stylesheet" />
<script>
    jQuery(function () {
        jQuery(".datepicker").datepicker({ changeYear: true, changeMonth : true,yearRange: "-80:+0", dateFormat: 'yy-mm-dd'});
        
    });
</script>
<!--Calnedar Plugin End-->



        <!--Modal Processing-->
        <div class="modal" id="ProcessingBox">
            <div class="modal-dialog" style="margin-top:15%;">
                <div class="modal-content" style="background: transparent;">
                    <div class="modal-body ConfirmBox text-center" style="padding:20px !important;">
                        <h3 class="text-white">Processing your transaction...</h3>
                        <img src="<?php echo base_url(); ?>Processing.gif" style="width:70px;" />
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
