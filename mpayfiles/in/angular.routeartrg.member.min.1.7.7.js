var myapp = angular.module('myapp', []);
myapp.controller('RINCNTRL', ['$scope', '$http', function ($scope, $http) {
    MainLoad(), BindBkData();

    function MainLoad() {
        jQuery('#pagebodyBox').show(), $scope.pageheaderBox = 0, $scope.searchBox = 0, $scope.moneyBox = 1,
        $scope.moneyBoxNovVerified = 1, 
        $scope.transactionBox = 0, 
        $scope.FundTransferBox = 1, 
        $scope.AddBeneficiaryBox = 1;
        $scope.AddBeneficiaryCashPaymentBox = 0;
        ResetFund(); ResetMethod();BindDisctict();
    }

    function ResetMethod() {
        $scope.ErrorMessage = null, $scope.SearchErrorMessage = null, $scope.RcptErrorMessage = null, $scope.FundErrorMessage = null, $scope.rmtErrorMessage = null;
        $scope.transRecipientID = null, $scope.rmvRcptID = null;
        $scope.rmtFirstName = null, $scope.rmtLastName = null, $scope.rmtPinCode = null, $scope.rcptisverified = null;
        $scope.transAccountNo = null, $scope.transBankName = null, $scope.transRecipientName = null, $scope.transRecipientID = null, $scope.transAmount = null, $scope.transtpin = null; $scope.transPaymentType = 'IMPS'; $scope.showtransAmount = null; $scope.amountinWord = null;
        $scope.rmtFirstName = null, $scope.rmtLastName = null, $scope.rmtPinCode = null, $scope.rmtOtp = null;
        $scope.rcptAccountNo = null, $scope.rcptBankName = null, $scope.rcptRecipientName = null, $scope.rcptIfscCode = null;
        $scope.SenderDetails = null;
    }

    function ResetFund() {
        $scope.paySlab1 = 1, $scope.paySlab2 = 1, $scope.paySlab3 = 1, $scope.paySlab4 = 1, $scope.paySlab5 = 1, $scope.fundPrintBox = 1;
        $scope.paySlab1Amount = null, $scope.paySlab2Amount = null, $scope.paySlab3Amount = null, $scope.paySlab4Amount = null, $scope.paySlab5Amount = null, $scope.payMerchantRefID = null;
        jQuery('#paySlab1Status').html(''); jQuery('#paySlab2Status').html(''); jQuery('#paySlab3Status').html(''); jQuery('#paySlab4Status').html(''); jQuery('#paySlab5Status').html('');
        jQuery('#paySlab1Status').removeClass('transSucc2 transPnd2 transfail2'); 
        jQuery('#paySlab2Status').removeClass('transSucc2 transPnd2 transfail2'); 
        jQuery('#paySlab3Status').removeClass('transSucc2 transPnd2 transfail2'); 
        jQuery('#paySlab4Status').removeClass('transSucc2 transPnd2 transfail2'); 
        jQuery('#paySlab5Status').removeClass('transSucc2 transPnd2 transfail2');
        jQuery('#paySlab1Message').html(''); 
        jQuery('#paySlab2Message').html(''); 
        jQuery('#paySlab3Message').html(''); 
        jQuery('#paySlab4Message').html(''); 
        jQuery('#paySlab5Message').html('');
        jQuery('#paySlab1Amt').removeClass('transSucc1 transPnd1 transfail1'); 
        jQuery('#paySlab2Amt').removeClass('transSucc1 transPnd1 transfail1'); 
        jQuery('#paySlab3Amt').removeClass('transSucc1 transPnd1 transfail1'); 
        jQuery('#paySlab4Amt').removeClass('transSucc1 transPnd1 transfail1'); 
        jQuery('#paySlab5Amt').removeClass('transSucc1 transPnd1 transfail1');
    }

    $scope.populatedistrict = function()
    {
        BindDisctict($scope.rmtState);
    }
    function BindDisctict() {
        $scope.DestcictDetails =null;
        $http({
            url: '/Retailer/IndoNepal/getDistrict',
            method: 'POST',
            data: JSON.stringify({ state_name: "" })
        }).then(function successCallback(response) {

           var jObj = JSON.parse(response.data);
            $scope.DestrictDetails = jObj.Data;
            
        }, function errorCallback(response) 
        { 
            alert(response.data); 
            //location.reload(); 
        });
    }





    $scope.doFindDetails = function () {
        $scope.ErrorMessage = null; 
        if ($scope.mobileNumber && $scope.mobileNumber.length === 10) 
            { BindData(); } 
        else { $scope.ErrorMessage = 'Mobile no should be 10 digit.'; }
    };

    $scope.dosearchFindDetails = function () {
        $scope.SearchErrorMessage = null; if ($scope.searchMobileNumber && $scope.searchMobileNumber.length === 10) { jQuery('#modalRemitter').modal('hide'), $scope.mobileNumber = $scope.searchMobileNumber, BindData(); } else { $scope.SearchErrorMessage = 'Mobile no should be 10 digit.'; }
    };

    function BindData() {
        MainLoad();
        jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
        $http({
            url: '/Retailer/IndoNepal/ValidateSender',
            method: 'POST',
            data: JSON.stringify({ number: $scope.mobileNumber })
        }).then(function successCallback(response) 
        {
            
            var jObj = JSON.parse(response.data);
            if (jObj.StatusCode === 1) 
            {
                $scope.searchBox = 1, 
                $scope.pageheaderBox = 1, 
                $scope.moneyBox = 0; 
                $scope.selector = 'AddBeneficiaryCashPayment';
                $scope.SenderDetails = jObj.Data; 
                SubBindData();
            } 
            else if (jObj.StatusCode === 2) 
            {
                //$scope.ErrorMessage = jObj.Message;

                jQuery('#modalRegisterRemitter').modal('show');
            }
            else if (jObj.StatusCode === 3) 
            {
                var status = jObj.Data.Status;
                var ApproveStatus = jObj.Data.ApproveStatus;
                if(status == "Verified")
                {
                    $scope.searchBox = 1, 
                    $scope.pageheaderBox = 1, 
                    $scope.moneyBox = 0; 
                    $scope.selector = 'AddBeneficiaryCashPayment';
                    $scope.SenderDetails = jObj.Data; 
                    SubBindData();
                }
                else if(status == "Unverified" && ApproveStatus == "Under Review")
                {
                    $scope.searchBox = 1, 
                    $scope.pageheaderBox = 1, 
                    $scope.moneyBoxNovVerified = 0; 
                    $scope.SenderDetails = jObj.Data; 
                    //SubBindData();
                }
                else
                {
                    //$scope.ErrorMessage = jObj.Message;
                    document.getElementById("etCustomerMobile").value = jObj.Data.SenderMobile;
                    document.getElementById("etIDNumber").value = jObj.Data.IdNumber;
                    document.getElementById("etIDType").value = jObj.Data.IdType;


                    
                    document.getElementById("idtype_uploadmodel").innerHTML = jObj.Data.IdType;
                    document.getElementById("idnumber_uploadmodel").innerHTML = jObj.Data.IdNumber;
                    jQuery('#modalUploadRemitter').modal('show');
                }
                
            } 
            else 
            {
               
             $scope.ErrorMessage = jObj.Message; 
            }

            jQuery('#ProcessingBox').attr("style", "display:none;");
        }, 
        function errorCallback(response) { alert(response.data); 
           // location.reload(); 


        });
    }

    function SubBindData() {
        $http({
            url: '/Retailer/IndoNepal/SenderBeneficiaryList',
            method: 'POST',
            data: JSON.stringify({ number: $scope.mobileNumber })
        }).then(function successCallback(response) {

           var jObj = JSON.parse(response.data);

            if (jObj.StatusCode === 1) {
                $scope.BeneficiaryDetails = jObj.Data;
            } else {
                $scope.BeneficiaryDetails = null;
            }
        }, function errorCallback(response) 
        { 
            alert(response.data); 
            //location.reload(); 
        });
    }

    $scope.doShowBoxView = function () {
        
        if ($scope.selector === "FundTransfer") {
            $scope.FundTransferBox = 0, 
            $scope.AddBeneficiaryCashPaymentBox = 1, 
            $scope.AddBeneficiaryBox = 1;
        }
        else if ($scope.selector === "AddBeneficiaryCashPayment") {
        
            $scope.AddBeneficiaryCashPaymentBox = 0, 
            $scope.FundTransferBox = 1, 
            $scope.AddBeneficiaryBox = 1;
        }
        else if ($scope.selector === "AddBeneficiaryAccountDeposit") {
        
            $scope.AddBeneficiaryCashPaymentBox = 1, 
            $scope.FundTransferBox = 1, 
            $scope.AddBeneficiaryBox = 0;
        }

        else 
        {
        
            $scope.FundTransferBox = 1, 
            $scope.AddBeneficiaryCashPaymentBox = 0;
            $scope.AddBeneficiaryBox = 1;
        }
    };

    $scope.dobindtransferdata = function (item) 
    {
       // alert(item.BankName);
        $scope.FundTransferBox = 0, 
        $scope.AddBeneficiaryBox = 1; 
        $scope.AddBeneficiaryCashPaymentBox = 1; 
        $scope.selector = 'FundTransfer';
        $scope.transPaymentType = item.PaymentMode;
        $scope.transAmount = null, 
        $scope.transtpin = null, 

        //    alert(item.BankBranchId);

        $scope.transAccountNo = item.AccountNo, 
        $scope.transBankName = item.BankName, 
        $scope.transBankBranchId =item.BankBranchId,
        $scope.transRecipientName = item.Name, 
        $scope.transRecipientMobile = item.Mobile, 
        $scope.transRecipientRelation = item.Relationship, 
        $scope.transRecipientID = item;

        if(item.PaymentMode == "Cash Payment")
        {
            $scope.ENDIS_transAccountNo = 1;
            $scope.ENDIS_transBankName = 1;
            
        }
        else
        {
            $scope.ENDIS_transAccountNo = 0;   
            $scope.ENDIS_transBankName = 0;   
        }
    };

    $scope.doremovedata = function (item) {
        $scope.RemoveErrorMessage = null;
        if (item) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Moneytransfer/RcptRemoveRequest',
                method: 'POST',
                data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, rcptID: item.RPTID })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) {
                    jQuery('#modalRcptRemove').modal('show'); $scope.rmvRcptID = item; $scope.RemoveErrorMessage = jObj.Message;
                }
                else {
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html(jObj.Message);
                    jQuery('#message').attr("style", "color:red;");
                }
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        }
    };

    $scope.doverifyremovedata = function (item) {
        if (item && $scope.RmvOtp && $scope.RmvOtp.length === 6) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Moneytransfer/RcptDeleteRequest',
                method: 'POST',
                data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, rcptID: item.RPTID, otp: $scope.RmvOtp })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) {
                    jQuery('#modalRcptRemove').modal('hide'); $scope.rmvRcptID = null, $scope.RmvOtp = null;
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html(jObj.Message);
                    jQuery('#message').attr("style", "color:green;"); SubBindData();
                }
                else {
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html(jObj.Message);
                    jQuery('#message').attr("style", "color:red;");
                }
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        }
    };

    $scope.dovalidateafterdata = function (item) {
        if (item && !item.IsValidate) {
            if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) > 0) {
                if (confirm('Do you want to verify your ' + item.AccountNo + ' account and ' + item.IFSC + ' IFSC?')) {
                    jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                    $http({
                        url: '/Moneytransfer/AccountInquiry',
                        method: 'POST',
                        data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, name: $scope.SenderDetails.Name, accountNo: item.AccountNo, ifscCode: item.IFSC, rcptName: item.Name, bankName: item.BankName })
                    }).then(function successCallback(response) {
                        if (response.data.StatusCode === 1) {
                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                            jQuery('#message').html(response.data.Message);
                            jQuery('#message').attr("style", "color:green;"); BindData();
                        }
                        else if (response.data.StatusCode === 2) {
                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                            jQuery('#message').html(response.data.Message);
                            jQuery('#message').attr("style", "color:orange;");
                        }
                        else {
                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                            jQuery('#message').html(response.data.Message);
                            jQuery('#message').attr("style", "color:red;");
                        }
                        jQuery('#ProcessingBox').attr("style", "display:none;");
                    }, function errorCallback(response) { alert(response.data); location.reload(); });
                }
            } else
                $scope.RcptErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
        }
    };

    $scope.dovalidatebeforedata = function () {
        $scope.RcptErrorMessage = null;
        if ($scope.rcptAccountNo && $scope.rcptBankName && $scope.rcptIfscCode) {
            if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) > 0) {
                if (confirm('Do you want to verify your ' + $scope.rcptAccountNo + ' account and ' + $scope.rcptIfscCode + ' IFSC?')) {
                    jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                    $http({
                        url: '/Retailer/Dmrmm_home/AccountInquiry',
                        method: 'POST',
                        data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, name: $scope.SenderDetails.Name, accountNo: $scope.rcptAccountNo, ifscCode: $scope.rcptIfscCode, rcptName: $scope.rcptRecipientName, bankName: $scope.rcptBankName.BankName })
                    }).then(function successCallback(response) {
                        if (response.data.StatusCode === 1) {
                           
                            $scope.rcptRecipientName = response.data.Name;
                            $scope.rcptisverified = 'X';
                        }
                        else if (response.data.StatusCode === 2) 
                        {
                           
                            $scope.RcptErrorMessage = response.data.Message;
                        }
                        else
                           
                            $scope.RcptErrorMessage = response.data.Message;
                        jQuery('#ProcessingBox').attr("style", "display:none;");
                    }, function errorCallback(response) { 
                        alert(response.data); 
                     //   location.reload(); 
                    });
                }
            } else
                $scope.RcptErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
        } else
            $scope.RcptErrorMessage = "All field's are required.";
    };

    $scope.dovalidateaftertransferdata = function (item) {
        $scope.FundErrorMessage = null;
        if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) > 0) {
            if (confirm('Do you want to verify your ' + item.AccountNo + ' account and ' + item.IFSC + ' IFSC?')) {
                if (item) {
                    jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                    $http({
                        url: '/Moneytransfer/AccountInquiry',
                        method: 'POST',
                        data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, name: $scope.SenderDetails.Name, accountNo: item.AccountNo, ifscCode: item.IFSC, rcptName: item.Name, bankName: item.BankName })
                    }).then(function successCallback(response) {
                        if (response.data.StatusCode === 1) {
                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                            jQuery('#message').html(response.data.Message);
                            jQuery('#message').attr("style", "color:green;"); BindData();
                        }
                        else if (response.data.StatusCode === 2) {
                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                            jQuery('#message').html(response.data.Message);
                            jQuery('#message').attr("style", "color:orange;");
                        }
                        else {
                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                            jQuery('#message').html(response.data.Message);
                            jQuery('#message').attr("style", "color:red;");
                        }
                        jQuery('#ProcessingBox').attr("style", "display:none;");
                    }, function errorCallback(response) { alert(response.data); location.reload(); });
                } else
                    $scope.FundErrorMessage = 'Select beneficiary.';
            }
        } else
            $scope.FundErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
    };

    function BindBkData() {
        $http({
            url: '/Retailer/IndoNepal/BankNameList',
            method: 'POST'
        }).then(function successCallback(response) {
            if (response.data)
                $scope.BankNameDetails = JSON.parse(response.data);
            else
                $scope.BankNameDetails = null;
        }, function errorCallback(response) { alert(response.data); location.reload(); });
    }
///////////////////////////////////////////////////////////////////////////////
/////// receiver registration
///////////////////////////////////////////////////////////////////////////////
    $scope.dorcptmemberdatavalue = function () {
        $scope.RcptErrorMessage = null;
        if ($scope.mobileNumber && $scope.rcptAccountNo && $scope.rcptBankName && $scope.rcptRecipientName && $scope.rcptIfscCode) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            var verifyrcpt = $scope.rcptisverified ? $scope.rcptisverified : '';
            $http({
                url: '/Retailer/IndoNepal/RcptRegistration',
                method: 'POST',
                data: JSON.stringify({ 
                	number: $scope.mobileNumber, CustomerId: $scope.SenderDetails.CustomerId, 
                	name: $scope.rcptRecipientName, accountNo: $scope.rcptAccountNo, 
                	ifscCode: $scope.rcptIfscCode, 
                	bankID: $scope.rcptBankName.Id, verify: verifyrcpt })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) {
                    $scope.RcptErrorMessage = jObj.Message;
                    $scope.rcptAccountNo = null, 
                    $scope.rcptRecipientName = null, $scope.rcptBankName = null, 
                    $scope.rcptIfscCode = null; 
                    SubBindData();
                }
                else
                    $scope.RcptErrorMessage = jObj.Message;
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data); 
               // location.reload(); 
            });
        } else
            $scope.RcptErrorMessage = "All field's are required.";
    };




////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
//////////////// sender registration methods
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

	//sender register get otp
    $scope.dormtmemberdatavalue = function () {
        $scope.rmtErrorMessage = null;

        //alert($scope.rmtFirstName);
    //alert($scope.rmtDistrict.label);



        if ($scope.rmtFirstName ){}else{alert("firstname required");}
        if ($scope.rmtDOB ){}else{alert("rmtDOB required");}
        if ($scope.rmtGender ){}else{alert("rmtGender required");}
        if ($scope.rmtMobileNumber ){}else{alert("rmtMobileNumber required");}
        if ($scope.rmtEmailId ){}else{alert("rmtEmailId required");}
        if ($scope.rmtNationality ){}else{alert("rmtNationality required");}
        if ($scope.rmtAddress ){}else{alert("rmtAddress required");}
        if ($scope.rmtState ){}else{alert("rmtState required");}
        if ($scope.rmtDistrict ){}else{alert("rmtDistrict required");}
        if ($scope.rmtCity ){}else{alert("rmtCity required");}
        if ($scope.rmtIdType ){}else{alert("rmtIdType required");}
        if ($scope.rmtIdNumber ){}else{alert("rmtIdNumber required");}
        if ($scope.rmtIncomeSource ){}else{alert("rmtIncomeSource required");}

        if ($scope.rmtEmployeer ){}else{alert("rmtEmployeer required");}



         //alert($scope.rmtState);
         //   alert($scope.rmtDistrict);
           //   alert($scope.rmtDistrict.Id);
         //alert($scope.rmtDistrict.Name);
        if ($scope.rmtFirstName && $scope.rmtDOB && $scope.rmtGender && $scope.rmtMobileNumber  && 
            $scope.rmtEmailId  && $scope.rmtNationality  && $scope.rmtAddress && 
            $scope.rmtState  && $scope.rmtDistrict  && $scope.rmtCity && 
            $scope.rmtIdType  && $scope.rmtIdNumber  && $scope.rmtIncomeSource &&
            $scope.rmtEmployeer) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Retailer/IndoNepal/GenerateReference',
                method: 'POST',
                data: JSON.stringify({ number: $scope.mobileNumber })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) {
                    jQuery('#modalRegisterRemitter').modal('hide'); 
                    $scope.rmtOtp = null; 
                    jQuery('#modalVerifyRemitter').modal('show');
                }
                else
                    $scope.rmtErrorMessage = jObj.Message;
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data);
           //  location.reload(); 
         });
        } else
            $scope.rmtErrorMessage = "All field's are required.";
    };

    /// sender registartion with otp
    $scope.dormtmemberverifydatavalue = function () 
    {


         if ($scope.rmtFirstName ){}else{alert("firstname required");}
        if ($scope.rmtDOB ){}else{alert("rmtDOB required");}
        if ($scope.rmtGender ){}else{alert("rmtGender required");}
        if ($scope.rmtMobileNumber ){}else{alert("rmtMobileNumber required");}
        if ($scope.rmtEmailId ){}else{alert("rmtEmailId required");}
        if ($scope.rmtNationality ){}else{alert("rmtNationality required");}
        if ($scope.rmtAddress ){}else{alert("rmtAddress required");}
        if ($scope.rmtState ){}else{alert("rmtState required");}
        if ($scope.rmtDistrict ){}else{alert("rmtDistrict required");}
        if ($scope.rmtCity ){}else{alert("rmtCity required");}
        if ($scope.rmtIdType ){}else{alert("rmtIdType required");}
        if ($scope.rmtIdNumber ){}else{alert("rmtIdNumber required");}
        if ($scope.rmtIncomeSource ){}else{alert("rmtIncomeSource required");}

        if ($scope.rmtEmployeer ){}else{alert("rmtEmployeer required");}



         //alert($scope.rmtState);
           // alert($scope.rmtDistrict);
             



        $scope.rmtVfyErrorMessage = null;
        if ($scope.rmtFirstName && $scope.rmtDOB && $scope.rmtGender && $scope.rmtMobileNumber  && 
            $scope.rmtEmailId  && $scope.rmtNationality  && $scope.rmtAddress && 
            $scope.rmtState  && $scope.rmtDistrict  && $scope.rmtCity && 
            $scope.rmtIdType  && $scope.rmtIdNumber  && $scope.rmtIncomeSource &&
            $scope.rmtEmployeer && $scope.rmtOtp && $scope.rmtOtp.length === 6) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Retailer/IndoNepal/RemiRegistration',
                method: 'POST',
                data: JSON.stringify({ 
                                        fname: $scope.rmtFirstName, 
                                        DOB: $scope.rmtDOB, 
                                        Gender: $scope.rmtGender, 
                                        number: $scope.rmtMobileNumber, 
                                        EmailId: $scope.rmtEmailId, 
                                        Nationality: $scope.rmtNationality, 
                                        Address: $scope.rmtAddress, 
                                        State: $scope.rmtState, 
                                        District: $scope.rmtDistrict, 
                                        City: $scope.rmtCity, 
                                        IdType: $scope.rmtIdType, 
                                        IdNumber: $scope.rmtIdNumber, 
                                        IncomeSource: $scope.rmtIncomeSource, 
                                        Employeer: $scope.rmtEmployeer, 
                                        otp: $scope.rmtOtp 
                                    })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) {
                    jQuery('#modalVerifyRemitter').modal('hide'); 
                    $scope.rmtOtp = null, 
                    $scope.rmtFirstName = null, 
                    $scope.rmtDOB = null, 
                    $scope.rmtGender = null;
                    $scope.rmtMobileNumber = null;
                    $scope.rmtEmailId = null;
                    $scope.rmtNationality = null;
                    $scope.rmtAddress = null;
                    $scope.rmtState = null;
                    $scope.rmtDistrict = null;
                    $scope.rmtCity = null;
                    $scope.rmtIdType = null;
                    $scope.rmtIdNumber = null;
                    $scope.rmtIncomeSource = null;
                    $scope.rmtEmployeer = null;
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html(jObj.Message);
                    jQuery('#message').attr("style", "color:green;"); BindData();
                }
                else
                    $scope.rmtVfyErrorMessage = jObj.Message;
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data);
           //  location.reload(); 
         });
        } else
            $scope.rmtVfyErrorMessage = "All field's are required.";
    };



////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////



////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
//////////////// Receiver registration methods
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////

	//receiver register (cash payment)  get otp
    $scope.dormtreceivercashpaymentdatavalue = function () {

        $scope.RcptReceiverErrorMessage = null;


        if ($scope.rcptReceiverName ){}else{alert("ReceiverName required");}
        if ($scope.rcptReceiverGender ){}else{alert("Gender required");}
        if ($scope.rcptReceiverMobileNo ){}else{alert("Receiver Mobile Number required");}
        if ($scope.rcptReceiverAddress ){}else{alert("Address required");}
        if ($scope.rcptReceiverRelationship ){}else{alert("Relation required");}
        


        if ($scope.rcptReceiverName && $scope.rcptReceiverGender && $scope.rcptReceiverMobileNo  && 
            $scope.rcptReceiverAddress  && $scope.rcptReceiverRelationship) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Retailer/IndoNepal/ReceiverRegistrationCashPayment',
                method: 'POST',
                data: JSON.stringify({ 
                    SenderMobile: $scope.mobileNumber,ReceiverName : $scope.rcptReceiverName,
                    ReceiverGender: $scope.rcptReceiverGender,ReceiverMobileNo : $scope.rcptReceiverMobileNo,
                    ReceiverAddress: $scope.rcptReceiverAddress,ReceiverRelationship : $scope.rcptReceiverRelationship,
                 })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) {
                  	$scope.RcptReceiverErrorMessage = jObj.Message;
                    //$scope.rcptAccountNo = null, 
                    //$scope.rcptRecipientName = null, $scope.rcptBankName = null, 
                    //$scope.rcptIfscCode = null; 
                    SubBindData();
                }
                else
                    $scope.RcptReceiverErrorMessage = jObj.Message;
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data);
           //  location.reload(); 
         });
        } else
       
            $scope.RcptReceiverErrorMessage = "All field's are required.";
    };




    $scope.dormtreceiverAccountDepositmentdatavalue = function () {

        $scope.RcptReceiverRegAccountDepositErrorMessage = null;


        if ($scope.rcptRecipientNameAD ){}else{alert("ReceiverName required");}
        if ($scope.rcptReceiverGenderAD ){}else{alert("Gender required");}
        if ($scope.rcptReceiverMobileNoAD ){}else{alert("Receiver Mobile Number required");}
        if ($scope.rcptReceiverAddressAD ){}else{alert("Address required");}
        if ($scope.rcptReceiverRelationshipAD ){}else{alert("Relation required");}

        if ($scope.rcptAccountNoAD ){}else{alert("Account Number required");}
        if ($scope.rcptBankBranchName ){}else{alert("Bank Branch Name required");}
        


        if ($scope.rcptRecipientNameAD && $scope.rcptReceiverGenderAD && $scope.rcptReceiverMobileNoAD  && 
            $scope.rcptReceiverAddressAD  && $scope.rcptReceiverRelationshipAD &&
            $scope.rcptAccountNoAD  && $scope.rcptBankBranchName
            ) {
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Retailer/IndoNepal/ReceiverRegistrationAccountDeposit',
                method: 'POST',
                data: JSON.stringify({ 
                    SenderMobile: $scope.mobileNumber,ReceiverName : $scope.rcptRecipientNameAD,
                    ReceiverGender: $scope.rcptReceiverGenderAD,ReceiverMobileNo : $scope.rcptReceiverMobileNoAD,
                    ReceiverAddress: $scope.rcptReceiverAddressAD,ReceiverRelationship : $scope.rcptReceiverRelationshipAD,

                    AccountNo : $scope.rcptAccountNoAD,
                    BankBranchName : $scope.rcptBankBranchName.Id,



                 })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                
                if (jObj.StatusCode === 1) 
                {
                  	$scope.RcptReceiverErrorMessage = jObj.Message;
                    $scope.rcptRecipientNameAD = null, 
                    $scope.rcptReceiverGenderAD = null, 
                    $scope.rcptReceiverMobileNoAD = null, 
                    $scope.rcptReceiverRelationshipAD = null; 
                    $scope.rcptReceiverRelationshipAD = null; 
                    $scope.rcptAccountNoAD = null; 
                    $scope.rcptBankBranchName = null; 
                    $scope.rcptBankCityName = null; 
                    $scope.rcptBankName = null; 
                    SubBindData();
                }
                else
                    $scope.RcptReceiverRegAccountDepositErrorMessage = jObj.Message;
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data);
           //  location.reload(); 
         });
        } else
        
            $scope.RcptReceiverRegAccountDepositErrorMessage = "All field's are required.";
    };




////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX////



    $scope.dopretransferMemberfnd = function () {
        $scope.FundErrorMessage = null; ResetFund();
        $scope.TransProcessId = null;

        if($scope.transPaymentType == "Account Deposit")
        {
			if ($scope.transAccountNo && $scope.transBankName && $scope.transRecipientName && $scope.transRecipientID && $scope.transPaymentType && $scope.transAmount && $scope.transtpin && $scope.transtpin.length === 4) 
	        {
	            if ($scope.transAmount >= 100 && $scope.transAmount <= 60000) 
	            {
	                //if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) >= $scope.transAmount) 
	                if(true)
	                {
	                    jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
	                    $http({
	                        url: '/Retailer/IndoNepal/TransferAmountDetails',
	                        method: 'POST',
	                        data: JSON.stringify({ 
	                        	amount: $scope.transAmount, 
	                        	mobileNumber: $scope.mobileNumber, 
	                        	accountNo: $scope.transAccountNo, 
	                        	tPin: $scope.transtpin,
	                        	RecipientId : $scope.transRecipientID.ReceiverId,
	                        	mode : $scope.transPaymentType,

	                        	 })
	                    }).then(function successCallback(response) {
	                        var jObj = response.data;
	                        if (jObj.StatusCode === 1) {
	                            jQuery('#modalTransferAmt').modal('show');
	                            $scope.chargeBreakup = response.data;
                                $scope.txndetailsbindData = response.data;
                                $scope.payConvenienceAmt = jObj.TotalCharge;
                                $scope.payCustomerPayAmt = jObj.CustomerPayAmount;
                                $scope.payMerchantEarnAmt = jObj.TotalMargin;
                                $scope.payMerchantPayAmt = jObj.TotalAmount;
                                $scope.payMerchantRefID = jObj.TxnRefNumber;
                                
                                if(jObj.OTP_RESPONSE.statuscode == "TXN")
                                {
                                    $scope.TransProcessId = jObj.OTP_RESPONSE.ProcessId;
                                
                                }

	                            angular.forEach(jObj.Data, function (item) {
	                                if (item.SLNO === 1) {
	                                    $scope.paySlab1 = 0;
	                                    $scope.paySlab1Amount = item.Amount;
	                                    jQuery('#paySlab1Status').html('Wait...');
	                                    jQuery('#paySlab1Message').html('!...');
	                                } else if (item.SLNO === 2) {
	                                    $scope.paySlab2 = 0;
	                                    $scope.paySlab2Amount = item.Amount;
	                                    jQuery('#paySlab2Status').html('Wait...');
	                                    jQuery('#paySlab2Message').html('!...');
	                                } else if (item.SLNO === 3) {
	                                    $scope.paySlab3 = 0;
	                                    $scope.paySlab3Amount = item.Amount;
	                                    jQuery('#paySlab3Status').html('Wait...');
	                                    jQuery('#paySlab3Message').html('!...');
	                                } else if (item.SLNO === 4) {
	                                    $scope.paySlab4 = 0;
	                                    $scope.paySlab4Amount = item.Amount;
	                                    jQuery('#paySlab4Status').html('Wait...');
	                                    jQuery('#paySlab4Message').html('!...');
	                                } else if (item.SLNO === 5) {
	                                    $scope.paySlab5 = 0;
	                                    $scope.paySlab5Amount = item.Amount;
	                                    jQuery('#paySlab5Status').html('Wait...');
	                                    jQuery('#paySlab5Message').html('!...');
	                                }
	                            });
	                        }
	                        else {
	                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
	                            jQuery('#message').html(response.data.Message);
	                            jQuery('#message').attr("style", "color:red;");
	                        }
	                        jQuery('#ProcessingBox').attr("style", "display:none;");
	                    }, 
                        function errorCallback(response) { 
                            alert(response.data); 
                          //  location.reload(); 
                        });
	                } else
	                    $scope.FundErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
	            } 
	            else
	                $scope.FundErrorMessage = "Amount should be between 1 to 75000.";
	        } 
	        else
	        {
	            $scope.FundErrorMessage = "All field's are required.";
	        }
    	}
    	else if($scope.transPaymentType == "Cash Payment")
        {
			if ($scope.transRecipientName && $scope.transRecipientID && $scope.transPaymentType && $scope.transAmount && $scope.transtpin && $scope.transtpin.length === 4) 
	        {
	            if ($scope.transAmount >= 100 && $scope.transAmount <= 60000) 
	            {
	                //if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) >= $scope.transAmount) 
	                if(true)
	                {
	                    jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
	                    $http({
	                        url: '/Retailer/IndoNepal/TransferAmountDetails',
	                        method: 'POST',
	                        data: JSON.stringify({ 
	                        	amount: $scope.transAmount, 
	                        	mobileNumber: $scope.mobileNumber, 
	                        	tPin: $scope.transtpin,
	                        	RecipientId : $scope.transRecipientID.ReceiverId,
	                        	mode : $scope.transPaymentType,

	                        	 })
	                    }).then(function successCallback(response) {
	                        var jObj = response.data;
	                        if (jObj.StatusCode === 1) {
	                            jQuery('#modalTransferAmt').modal('show');
	                            $scope.chargeBreakup = response.data;
	                            $scope.txndetailsbindData = response.data;
	                            $scope.payConvenienceAmt = jObj.TotalCharge;
	                            $scope.payCustomerPayAmt = jObj.CustomerPayAmount;
	                            $scope.payMerchantEarnAmt = jObj.TotalMargin;
	                            $scope.payMerchantPayAmt = jObj.TotalAmount;
	                            $scope.payMerchantRefID = jObj.TxnRefNumber;
                                
                                if(jObj.OTP_RESPONSE.statuscode == "TXN")
                                {
                                    $scope.TransProcessId = jObj.OTP_RESPONSE.ProcessId;
                                
                                }


	                            angular.forEach(jObj.Data, function (item) {
	                                if (item.SLNO === 1) 
                                    {
                                
	                                    $scope.paySlab1 = 0;
	                                    $scope.paySlab1Amount = item.Amount;
	                                    jQuery('#paySlab1Status').html('Wait...');
	                                    jQuery('#paySlab1Message').html('!...');
	                                } else if (item.SLNO === 2) {
	                                    $scope.paySlab2 = 0;
	                                    $scope.paySlab2Amount = item.Amount;
	                                    jQuery('#paySlab2Status').html('Wait...');
	                                    jQuery('#paySlab2Message').html('!...');
	                                } else if (item.SLNO === 3) {
	                                    $scope.paySlab3 = 0;
	                                    $scope.paySlab3Amount = item.Amount;
	                                    jQuery('#paySlab3Status').html('Wait...');
	                                    jQuery('#paySlab3Message').html('!...');
	                                } else if (item.SLNO === 4) {
	                                    $scope.paySlab4 = 0;
	                                    $scope.paySlab4Amount = item.Amount;
	                                    jQuery('#paySlab4Status').html('Wait...');
	                                    jQuery('#paySlab4Message').html('!...');
	                                } else if (item.SLNO === 5) {
	                                    $scope.paySlab5 = 0;
	                                    $scope.paySlab5Amount = item.Amount;
	                                    jQuery('#paySlab5Status').html('Wait...');
	                                    jQuery('#paySlab5Message').html('!...');
	                                }
	                            });
	                        }
	                        else {
	                            jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
	                            jQuery('#message').html(response.data.Message);
	                            jQuery('#message').attr("style", "color:red;");
	                        }
	                        jQuery('#ProcessingBox').attr("style", "display:none;");
	                    }, function errorCallback(response) 
                        { 
                            alert(response.data); 
                            //location.reload(); 
                        });
	                } else
	                    $scope.FundErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
	            } 
	            else
	                $scope.FundErrorMessage = "Amount should be between 1 to 75000.";
	        } 
	        else
	        {
	            $scope.FundErrorMessage = "All field's are required.";
	        }
    	}

    };


    $scope.dofnlmemberdataproctorgtxnroute = function () 
    {
       
         
       if($scope.rmtTransferOtp.length >= 6)
       {
            $scope.FundfnlErrorMessage = null; 
            $scope.ResponseData = null; 
            jQuery('#modalTransferAmt').modal('hide'); 
            $scope.fundPrintBox = 1; 
            $scope.showtransAmount = $scope.transAmount;

            $scope.rmtTransferOtp = $scope.rmtTransferOtp;
            if($scope.transPaymentType == "Account Deposit")
            {
                if ($scope.rmtTransferOtp && $scope.transAccountNo && $scope.transBankName && $scope.transRecipientName && $scope.transRecipientID && $scope.transPaymentType && $scope.transAmount) 
                {
                    if ($scope.transAmount >= 1 && $scope.transAmount <= 60000) 
                    {
                        //if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) >= $scope.transAmount) 
                        if(true)
                        {
                            jQuery('#modalOrderStatus').modal('show');//item.Amount
                            angular.forEach($scope.txndetailsbindData.Data, function (item) {
                                $http({
                                    url: '/Retailer/IndoNepal/DoFundTransfer',
                                    method: 'POST',
                                    async: false,
                                    data: JSON.stringify({ 
                                        number: $scope.mobileNumber, 
                                        remitterID: $scope.SenderDetails.RemitterID, 
                                        rcptID: $scope.transRecipientID.RPTID, 
                                        amount: item.Amount, 
                                        paymentType: $scope.transPaymentType, 
                                        refernceNumber: $scope.payMerchantRefID,
                                        remitancereason: $scope.ftremitancereason,
                                        TransOtp: $scope.rmtTransferOtp,
                                        ProcessId : $scope.TransProcessId






                                    })
                                }).then(function successCallback(response) {
                                    var jObj = response.data;
                                    if (jObj.StatusCode === 1) {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Success');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transSucc2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transSucc1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html('<b>Order Id : </b>' + jObj.OrderID);
                                        $scope.fundPrintBox = 0;
                                    } else if (jObj.StatusCode === 2) {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Pending');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transPnd2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transPnd1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html(jObj.Message);
                                        $scope.fundPrintBox = 0;
                                    } else {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Failed');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transfail2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transfail1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html(jObj.Message);
                                    }
                                }, function errorCallback(response) { alert(response.data); 
                                    

                                    //location.reload(); 


                                });
                            });
                            $scope.transAmount = null;
                        } else
                            $scope.FundfnlErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
                    } else
                        $scope.FundfnlErrorMessage = "Amount should be between 1 to 75000.";
                } 
                else
                {
                    $scope.FundfnlErrorMessage = "All field's are required.";
                }   
            }
            else if($scope.transPaymentType == "Cash Payment")
            {
                if ($scope.rmtTransferOtp && $scope.transRecipientName && $scope.transRecipientID && $scope.transPaymentType && $scope.transAmount) 
                {
                    if ($scope.transAmount >= 1 && $scope.transAmount <= 60000) 
                    {
                        //if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) >= $scope.transAmount) 
                        if(true)
                        {
                            jQuery('#modalOrderStatus').modal('show');//item.Amount
                            angular.forEach($scope.txndetailsbindData.Data, function (item) {
                                $http({
                                    url: '/Retailer/IndoNepal/DoFundTransfer',
                                    method: 'POST',
                                    async: false,
                                    data: JSON.stringify({ 
                                        number: $scope.mobileNumber, 
                                        remitterID: $scope.SenderDetails.RemitterID, 
                                        rcptID: $scope.transRecipientID.RPTID, 
                                        amount: item.Amount, 
                                        paymentType: $scope.transPaymentType, 
                                        refernceNumber: $scope.payMerchantRefID,
                                        remitancereason: $scope.ftremitancereason,
                                        TransOtp: $scope.rmtTransferOtp,
                                        ProcessId : $scope.TransProcessId
                                    })
                                }).then(function successCallback(response) 
                                {
                                    var jObj = response.data;
                                    $scope.ResponseData = jObj;
                                    if (jObj.StatusCode === 1 || jObj.StatusCode === "1") 
                                    {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Success');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transSucc2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transSucc1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html('<b>Order Id : </b>' + jObj.OrderID);
                                        $scope.fundPrintBox = 0;
                                        $scope.btnVerifyTransaction = 0;
                                    } 
                                    else if (jObj.StatusCode === 2 || jObj.StatusCode === "2") 
                                    {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Pending');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transPnd2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transPnd1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html(jObj.Message);
                                        $scope.fundPrintBox = 0;
                                    }
                                    else if (jObj.StatusCode === 0 || jObj.StatusCode === "0") 
                                    {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Failed');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transfail2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transfail1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html(jObj.Message);
                                    } 
                                    else 
                                    {
                                        jQuery('#paySlab' + item.SLNO + 'Status').html('Pending');
                                        jQuery('#paySlab' + item.SLNO + 'Status').addClass('transPnd2');
                                        jQuery('#paySlab' + item.SLNO + 'Amt').addClass('transPnd1');
                                        jQuery('#paySlab' + item.SLNO + 'Message').html(jObj.Message);
                                        $scope.fundPrintBox = 0;
                                    }
                                }, function errorCallback(response) { alert(response.data); 
                                    

                                    //location.reload(); 


                                });
                            });
                            $scope.transAmount = null;
                        } else
                            $scope.FundfnlErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
                    } else
                        $scope.FundfnlErrorMessage = "Amount should be between 1 to 75000.";
                } 
                else
                {
                    $scope.FundfnlErrorMessage = "All field's are required.";
                }   
            }
       }
       else
       {
        alert("Please Enter Otp");
       }
        
    };



    $scope.VerifyTransaction = function()
    {
        
    };


    function TransactionBindData() {
        if ($scope.srcMobileNo || $scope.srcOrderID || $scope.srcAccountNo || $scope.srctxnAmount || $scope.srctxnStatus) {
            if (!$scope.srcOrderID) { $scope.srcOrderID = 0; } if (!$scope.srctxnAmount) { $scope.srctxnAmount = 0; }
        } else {
            $scope.srcMobileNo = '', $scope.srcOrderID = 0, $scope.srcAccountNo = '', $scope.srctxnAmount = 0, $scope.srctxnStatus = '';
        }
        $http({
            url: '/Retailer/dmrmm_home/SubDmtTransactions',
            method: 'POST',
            data: JSON.stringify({ number: $scope.srcMobileNo, orderID: $scope.srcOrderID, accountNo: $scope.srcAccountNo, amount: $scope.srctxnAmount, status: $scope.srctxnStatus })
        }).then(function successCallback(response) {
            $scope.currenttxnDetails = response.data;
        }, function errorCallback(response) { alert(response.data); location.reload(); });
    }

    $scope.doBindtxndatamemberr = function () {
        TransactionBindData();
    };



    $scope.doFindNumberinWords = function () {
        $scope.amountinWord = '';
        //alert($scope.transPaymentType);
       // alert($scope.transBankBranchId);
        if ($scope.transAmount) {
            $http({
                url: '/Retailer/IndoNepal/Showtransaction',
                method: 'POST',
                data: JSON.stringify({ trxnamount: $scope.transAmount,mode: $scope.transPaymentType,BankBranchId: $scope.transBankBranchId})
            }).then(function successCallback(response) {
                $scope.amountinWord = response.data.AmountInWords;
                $scope.transServiceCharge = response.data.ServiceCharge_data.aServiceCharge;
                $scope.transCollectionAmount = response.data.ServiceCharge_data.aCollectionAmount;
                $scope.transPayoutAmount = response.data.ServiceCharge_data.aPayoutAmount;

                
            }, function errorCallback(response) { alert(response.data); 
                //location.reload();
                 });
        }
    };

    $scope.doFindNumberinWordsCollectionAmount = function () 
    {

        $scope.amountinWordCollectionAmount = '';
        if ($scope.transCollectionAmount) {
            $http({
                url: '/Retailer/IndoNepal/Showtransaction',
                method: 'POST',
                data: JSON.stringify({ trxnamount_collection: $scope.transCollectionAmount })
            }).then(function successCallback(response) {
                $scope.amountinWordCollectionAmount = response.data.AmountInWords;
                $scope.transServiceCharge = response.data.ServiceCharge_data.aServiceCharge;
                $scope.transAmount = response.data.ServiceCharge_data.aTransferAmount;
                $scope.transPayoutAmount = response.data.ServiceCharge_data.aPayoutAmount;

            }, function errorCallback(response) { alert(response.data); 
                //location.reload();
                 });
        }
    };




    $scope.dofindifsccode = function () {
        if ($scope.rcptBankName) {
            
        	$http({
            url: '/Retailer/IndoNepal/BankCityList',
            method: 'POST',
            data: JSON.stringify({ BankName: $scope.rcptBankName.BankName })
        }).then(function successCallback(response) {
            if (response.data)
                $scope.BankCityDetails = JSON.parse(response.data);
            else
                $scope.BankCityDetails = null;
        }, function errorCallback(response) { alert(response.data); });




        } else {
            $scope.rcptIfscCode = null;
        }
    };











        $scope.dofindBranchCode = function () {
        	
        if ($scope.rcptBankCityName) {
            
        	$http({
            url: '/Retailer/IndoNepal/BankBranchList',
            method: 'POST',
            data: JSON.stringify({ City: $scope.rcptBankCityName.City,BankName: $scope.rcptBankName.BankName })
        }).then(function successCallback(response) {
            if (response.data)
                $scope.BankBranchDetails = JSON.parse(response.data);
            else
                $scope.BankBranchDetails = null;
        }, function errorCallback(response) { alert(response.data); });




        } else {
            $scope.BankBranchDetails = null;
        }
    };





            $scope.dofindDistrict = function () {
            
        if ($scope.rmtState) {
            
            $http({
            url: '/Retailer/IndoNepal/DistrictList',
            method: 'POST',
            data: JSON.stringify({ State: $scope.rmtState })
        }).then(function successCallback(response) {
            if (response.data)
                $scope.DistrictDetails = JSON.parse(response.data);
            else
                $scope.DistrictDetails = null;
        }, function errorCallback(response) { alert(response.data); });




        } else {
            $scope.DistrictDetails = null;
        }
    };







}]);