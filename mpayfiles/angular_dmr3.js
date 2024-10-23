    var myapp = angular.module('myapp', []);
    myapp.controller('RGCNTRL', ['$scope', '$http', function ($scope, $http) {
        MainLoad(), BindBkData();

        function MainLoad() {
            jQuery('#pagebodyBox').show(), $scope.pageheaderBox = 0, $scope.searchBox = 0, $scope.moneyBox = 1, $scope.transactionBox = 0, $scope.FundTransferBox = 1, $scope.AddBeneficiaryBox = 0;
            ResetFund(); ResetMethod();
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
            jQuery('#paySlab1Status').removeClass('transSucc2 transPnd2 transfail2'); jQuery('#paySlab2Status').removeClass('transSucc2 transPnd2 transfail2'); jQuery('#paySlab3Status').removeClass('transSucc2 transPnd2 transfail2'); jQuery('#paySlab4Status').removeClass('transSucc2 transPnd2 transfail2'); jQuery('#paySlab5Status').removeClass('transSucc2 transPnd2 transfail2');
            jQuery('#paySlab1Message').html(''); jQuery('#paySlab2Message').html(''); jQuery('#paySlab3Message').html(''); jQuery('#paySlab4Message').html(''); jQuery('#paySlab5Message').html('');
            jQuery('#paySlab1Amt').removeClass('transSucc1 transPnd1 transfail1'); jQuery('#paySlab2Amt').removeClass('transSucc1 transPnd1 transfail1'); jQuery('#paySlab3Amt').removeClass('transSucc1 transPnd1 transfail1'); jQuery('#paySlab4Amt').removeClass('transSucc1 transPnd1 transfail1'); jQuery('#paySlab5Amt').removeClass('transSucc1 transPnd1 transfail1');
        }

        $scope.doFindDetails = function () {
            $scope.ErrorMessage = null; if ($scope.mobileNumber && $scope.mobileNumber.length === 10) { BindData(); } else { $scope.ErrorMessage = 'Mobile no should be 10 digit.'; }
        };

        $scope.dosearchFindDetails = function () {
            $scope.SearchErrorMessage = null; if ($scope.searchMobileNumber && $scope.searchMobileNumber.length === 10) { jQuery('#modalRemitter').modal('hide'), $scope.mobileNumber = $scope.searchMobileNumber, BindData(); } else { $scope.SearchErrorMessage = 'Mobile no should be 10 digit.'; }
        };

        function BindData() {
            MainLoad();
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Retailer/dmr3_home/ValidateSender',
                method: 'POST',
                data: JSON.stringify({ number: $scope.mobileNumber })
            }).then(function successCallback(response) {
                var jObj = JSON.parse(response.data);
                if (jObj.StatusCode === 1) 
                {
                    $scope.searchBox = 1, 
                    $scope.pageheaderBox = 1, 
                    $scope.moneyBox = 0; $scope.selector = 'AddBeneficiary';
                    $scope.SenderDetails = jObj.Data; 
                    SubBindData();
                } else if (jObj.StatusCode === 2) {
                    //$scope.ErrorMessage = jObj.Message;
                    jQuery('#modalRegisterRemitter').modal('show');
                } else { $scope.ErrorMessage = jObj.Message; }
                jQuery('#ProcessingBox').attr("style", "display:none;");
            }, function errorCallback(response) { alert(response.data); 
               // location.reload(); 


            });
        }

        function SubBindData() {
            $http({
                url: '/Retailer/dmr3_home/SenderBeneficiaryList',
                method: 'POST',
                data: JSON.stringify({ number: $scope.mobileNumber })
            }).then(function successCallback(response) {

               var jObj = JSON.parse(response.data);

                if (jObj.StatusCode === 1) {
                    $scope.BeneficiaryDetails = jObj.Data;
                } else {
                    $scope.BeneficiaryDetails = null;
                }
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        }

        $scope.doShowBoxView = function () {
            if ($scope.selector === "FundTransfer") {
                $scope.FundTransferBox = 0, $scope.AddBeneficiaryBox = 1;
            } else {
                $scope.FundTransferBox = 1, $scope.AddBeneficiaryBox = 0;
            }
        };

        $scope.dobindtransferdata = function (item) 
        {
           // alert(item.BankName);
            $scope.FundTransferBox = 0, $scope.AddBeneficiaryBox = 1; $scope.selector = 'FundTransfer';
            $scope.transAmount = null, $scope.transtpin = null, $scope.transAccountNo = item.AccountNo, $scope.transBankName = item.BankName, $scope.transRecipientName = item.Name, $scope.transRecipientID = item;
        };

        $scope.doremovedata = function (item) {
            $scope.RemoveErrorMessage = null;
            if (item) {
                jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                $http({
                    url: '../Retailer/dmr3_home/Delete_ben',
                    method: 'POST',
                    data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, rcptID: item.RPTID })
                }).then(function successCallback(response) {
                    var jObj = JSON.parse(response.data);
                    if (jObj.status === 0) {
                        //delete beneficiary otp option
                        //jQuery('#modalRcptRemove').modal('show'); 
                        //$scope.rmvRcptID = item; 
                        //$scope.RemoveErrorMessage = jObj.message;

                        jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                        jQuery('#message').html(jObj.message);
                        jQuery('#message').attr("style", "color:red;");
                        SubBindData();

                         SubBindData();
                    }
                    else {
                        jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                        jQuery('#message').html(jObj.message);
                        jQuery('#message').attr("style", "color:red;");
                        SubBindData();
                    }
                    jQuery('#ProcessingBox').attr("style", "display:none;");
                }, function errorCallback(response) { 
                    alert(response.data); 
                    //location.reload(); 
                });
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
                            url: '/Retailer/Dmr3_home/AccountInquiry',
                            method: 'POST',
                            data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, name: $scope.SenderDetails.Name, accountNo: $scope.rcptAccountNo, ifscCode: $scope.rcptIfscCode, rcptName: $scope.rcptRecipientName, bankName: $scope.rcptBankName.BankName })
                        }).then(function successCallback(response) {
                            if (response.data.StatusCode === 1) {
                                alert("here success");
                                $scope.rcptRecipientName = response.data.Name;
                                $scope.rcptisverified = 'X';
                            }
                            else if (response.data.StatusCode === 2) 
                            {
                                alert("here failure");
                                $scope.RcptErrorMessage = response.data.Message;
                            }
                            else
                                alert("else part");
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
                url: '/Retailer/dmr3_home/BankNameList',
                method: 'POST'
            }).then(function successCallback(response) {
                if (response.data)
                    $scope.BankNameDetails = JSON.parse(response.data);
                else
                    $scope.BankNameDetails = null;
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        }

        $scope.dorcptmemberdatavalue = function () {
            $scope.RcptErrorMessage = null;
            if ($scope.mobileNumber && $scope.rcptAccountNo && $scope.rcptBankName && $scope.rcptRecipientName && $scope.rcptIfscCode) {
                jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                var verifyrcpt = $scope.rcptisverified ? $scope.rcptisverified : '';
                $http({
                    url: '/Retailer/dmr3_home/RcptRegistration',
                    method: 'POST',
                    data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, name: $scope.rcptRecipientName, accountNo: $scope.rcptAccountNo, ifscCode: $scope.rcptIfscCode, bankID: $scope.rcptBankName.Id, verify: verifyrcpt })
                }).then(function successCallback(response) {
                    var jObj = JSON.parse(response.data);
                    if (jObj.StatusCode === 1) {
                        $scope.RcptErrorMessage = jObj.Message;
                        $scope.rcptAccountNo = null, 
                        $scope.rcptRecipientName = null,
                         $scope.rcptBankName = null, $scope.rcptIfscCode = null; 
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

        $scope.dormtmemberdatavalue = function () {
            $scope.rmtErrorMessage = null;
            if ($scope.mobileNumber && $scope.rmtFirstName && $scope.rmtLastName && $scope.rmtPinCode) {
                jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                $http({
                    url: '/Retailer/dmr3_home/GenerateReference',
                    method: 'POST',
                    data: JSON.stringify({ number: $scope.mobileNumber })
                }).then(function successCallback(response) {
                    var jObj = JSON.parse(response.data);
                    if (jObj.StatusCode === 1 ) {
                        jQuery('#modalRegisterRemitter').modal('hide'); $scope.rmtOtp = null; jQuery('#modalVerifyRemitter').modal('show');
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

        $scope.dormtmemberverifydatavalue = function () {
            $scope.rmtVfyErrorMessage = null;
            if ($scope.mobileNumber && $scope.rmtFirstName && $scope.rmtLastName && $scope.rmtPinCode && $scope.rmtOtp && $scope.rmtOtp.length === 6) {
                jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                $http({
                    url: '/Retailer/dmr3_home/RemiRegistration',
                    method: 'POST',
                    data: JSON.stringify({ number: $scope.mobileNumber, fname: $scope.rmtFirstName, lName: $scope.rmtLastName, pinCode: $scope.rmtPinCode, otp: $scope.rmtOtp })
                }).then(function successCallback(response) {
                    var jObj = JSON.parse(response.data);
                    if (jObj.StatusCode === 1) 
                    {
                        alert("step 1");
                        jQuery('#modalVerifyRemitter').modal('hide'); $scope.rmtOtp = null, $scope.rmtFirstName = null, $scope.rmtLastName = null, $scope.rmtPinCode = null;
                        jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                        jQuery('#message').html(jObj.Message);
                        alert("step 2");
                        jQuery('#message').attr("style", "color:green;"); 
                        alert("step 3");
                        BindData();
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

        $scope.dopretransferMemberfnd = function () {
            $scope.FundErrorMessage = null; ResetFund();
            if ($scope.transAccountNo && $scope.transBankName && $scope.transRecipientName && $scope.transRecipientID && $scope.transPaymentType && $scope.transAmount && $scope.transtpin && $scope.transtpin.length === 4) {
                if ($scope.transAmount >= 1 && $scope.transAmount <= 75000) {
                    //if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) >= $scope.transAmount) 
                    if(true)
                    {
                        jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
                        $http({
                            url: '/Retailer/dmr3_home/TransferAmountDetails',
                            method: 'POST',
                            data: JSON.stringify({ 
                                amount: $scope.transAmount, 
                                mobileNumber: $scope.mobileNumber, 
                                accountNo: $scope.transAccountNo, 
                                IFSC : $scope.transRecipientID.IFSC,
                                tPin: $scope.transtpin })
                        }).then(function successCallback(response) {
                            var jObj = response.data;
                            if (jObj.StatusCode === 1) {
                                jQuery('#modalTransferAmt').modal('show');
                                $scope.txndetailsbindData = response.data;
                                $scope.payConvenienceAmt = jObj.TotalCharge;
                                $scope.BankStatus = jObj.BankStatus;
                                $scope.payCustomerPayAmt = jObj.CustomerPayAmount;
                                $scope.payMerchantEarnAmt = jObj.TotalMargin;
                                $scope.payMerchantPayAmt = jObj.TotalAmount;
                                $scope.payMerchantRefID = jObj.TxnRefNumber;
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
                        }, function errorCallback(response) { alert(response.data); 
                           // location.reload(); 
                        });
                    } else
                        $scope.FundErrorMessage = "Amount can not be greater than availabe limit. current limit:" + ($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3);
                } else
                    $scope.FundErrorMessage = "Amount should be between 1 to 75000.";
            } else
                $scope.FundErrorMessage = "All field's are required.";
        };

        $scope.dofnlmemberdataproctorgtxnroute = function () {
            $scope.FundfnlErrorMessage = null; 
            jQuery('#modalTransferAmt').modal('hide'); 
            $scope.fundPrintBox = 1; 
            $scope.showtransAmount = $scope.transAmount;

            $scope.DmtResponse = null; 

            if ($scope.transAccountNo && $scope.transBankName && $scope.transRecipientName && $scope.transRecipientID && $scope.transPaymentType && $scope.transAmount) {
                if ($scope.transAmount >= 1 && $scope.transAmount <= 75000) {
                    //if (($scope.SenderDetails.AvailableLimit + $scope.SenderDetails.AvailableLimit2 + $scope.SenderDetails.AvailableLimit3) >= $scope.transAmount) 
                    if(true)
                    {
                        jQuery('#modalOrderStatus').modal('show');//item.Amount
                        angular.forEach($scope.txndetailsbindData.Data, function (item) {
                            $http({
                                url: '/Retailer/dmr3_home/DoFundTransfer',
                                method: 'POST',
                                async: false,
                                data: JSON.stringify({ number: $scope.mobileNumber, remitterID: $scope.SenderDetails.RemitterID, name: $scope.SenderDetails.Name, rcptID: $scope.transRecipientID.RPTID, accountNo: $scope.transRecipientID.AccountNo, ifscCode: $scope.transRecipientID.IFSC, rcptName: $scope.transRecipientID.Name, bankName: $scope.transRecipientID.BankName, amount: item.Amount, paymentType: $scope.transPaymentType, refernceNumber: $scope.payMerchantRefID })
                            }).then(function successCallback(response) {
                                var jObj = response.data;

                                $scope.DmtResponse = response.data;
                                
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
            } else
                $scope.FundfnlErrorMessage = "All field's are required.";
        };

        function TransactionBindData() {
            if ($scope.srcMobileNo || $scope.srcOrderID || $scope.srcAccountNo || $scope.srctxnAmount || $scope.srctxnStatus) {
                if (!$scope.srcOrderID) { $scope.srcOrderID = 0; } if (!$scope.srctxnAmount) { $scope.srctxnAmount = 0; }
            } else {
                $scope.srcMobileNo = '', $scope.srcOrderID = 0, $scope.srcAccountNo = '', $scope.srctxnAmount = 0, $scope.srctxnStatus = '';
            }
            $http({
                url: '/Retailer/dmr3_home/SubDmtTransactions',
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
            if ($scope.transAmount) {
                $http({
                    url: '/Retailer/dmr3_home/Showtransaction',
                    method: 'POST',
                    data: JSON.stringify({ trxnamount: $scope.transAmount })
                }).then(function successCallback(response) {
                    $scope.amountinWord = response.data;
                }, function errorCallback(response) { alert(response.data); 
                    //location.reload();
                     });
            }
        };

        $scope.dofindifsccode = function () {
            if ($scope.rcptBankName) {
                $scope.rcptIfscCode = $scope.rcptBankName.IfscCode;
            } else {
                $scope.rcptIfscCode = null;
            }
        };

    }]);