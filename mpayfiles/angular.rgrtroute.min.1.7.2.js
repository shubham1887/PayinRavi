/// <reference path="angular.min.js" />

var myapp = angular.module('myapp', []);
myapp.controller('RGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.GetsubcategoryBy = function () {
        if ($scope.mycategory) {
            $http({
                method: 'POST',
                url: '/rapportera_sup_Admin/GetSubCategory',
                data: JSON.stringify({ Category: $scope.mycategory })
            }).then(function successCallback(response) {
                $scope.subservicename = response.data;
            });
        } else {
            $scope.userss = null;
        }
    };

    $scope.GetoperatorsyBy = function () {
        if ($scope.mysubcategory) {
            $http({
                method: 'POST',
                url: '/rapportera_sup_Admin/GetOperatorsby',
                data: JSON.stringify({ Service: $scope.mysubcategory.Id })
            }).then(function successCallback(response) {
                $scope.Operatorsname = response.data;
            });
        } else {
            $scope.Operatorsname = null;
        }
    };

    $scope.Gettransationbydates = function () {
        if ($scope.Fromdate) {
            if ($scope.Todate) {
                $http({
                    method: 'POST',
                    url: '/rapportera_sup_Admin/GetTransactionReport',
                    data: JSON.stringify({ Parent: $scope.reatilerLists.Id, Usertype: 'User' })
                }).then(function successCallback(response) {
                    $scope.userss = response.data;
                });
            }
        }
    };

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Recharge/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderId })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 9) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            var mycategory = 0;
            var mysubcategory = 0;
            var myoperatorss = 0;
            if ($scope.mycategory) { mycategory = $scope.mycategory; } else { mycategory = 0; }
            if ($scope.mysubcategory) { mysubcategory = $scope.mysubcategory.Id; } else { mysubcategory = 0; }
            if ($scope.myoperators) { myoperatorss = $scope.myoperators.Id; } else { myoperatorss = 0; }
            $("#modalProcessing").modal("show");
            //swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Retailer/Statement/SubRptTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), Category: mycategory, Subcategory: mysubcategory, Operator: myoperatorss, Status: $scope.mytransactionstatus })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                } else {
                    $scope.alltransaction = null;
                }
                //swal.close();
                $("#modalProcessing").modal("hide");
            }, function errorCallback(rejection) {
                //swal.close();
                $("#modalProcessing").modal("show");
                if (rejection.status === 404) {
                    $location.path('/error');
                } else {
                    errorCallback(rejection);
                }
            });
            //} else {
            //    swal('', 'Transaction Report - restrict to one day', 'error');
            //}
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactioncomplain = function (itemval) {
        if (itemval) {
            if (confirm('Do you want raise complain?')) {
                $http({
                    method: 'POST',
                    url: '/Recharge/PutDisputetransaction',
                    data: JSON.stringify({ Number: itemval.CustomerNumber, Trxnid: itemval.OrderID })
                }).then(function successCallback(response) {
                    if (response.data === 1)
                        swal('', 'Your complain has been raised successfully.', 'success');
                    else if (response.data === 4)
                        swal('', 'Complain of this transaction has alredy been raised.', 'error');
                    else
                        swal('', 'Please try again.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.puttransactionstatus = function (itemval) {
        if (itemval) {
            if (confirm('Do you want to check status')) {
                swal({ title: "Processing", text: "Please wait..", imageUrl: "../Content/images/Loader/Processing.gif", showConfirmButton: false });
                $http({
                    method: 'POST',
                    url: '/Recharge/GetTransactionStatus',
                    data: JSON.stringify({ trxncode: itemval.Trxnid })
                }).then(function successCallback(response) {
                    if (response.data === 1) {
                        gettransationrpts();
                        swal('', 'Your transaction status is successfully.', 'success');
                    }
                    else if (response.data === 2)
                        swal('', 'Your transaction status is Pending.', 'error');
                    else if (response.data === 0)
                        swal('', 'Your transaction status is Failed.', 'error');
                    else if (response.data === 5)
                        swal('', 'Your transaction is not exist.', 'error');
                    else
                        swal('', 'Error occured.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Retailer/Statement/TransactionExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('ZBPRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Recharge/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderId })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 8) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/ZbpReport/SubRptTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchUsername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode === 0) {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                } else {
                    $scope.alltransaction = response.data; swal.close();
                }
            }, function errorCallback(rejection) {
                alert(rejection.data); location.reload();
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactioncomplain = function (itemval) {
        if (itemval) {
            if (confirm('Do you want raise complain?')) {
                $http({
                    method: 'POST',
                    url: '/Recharge/PutDisputetransaction',
                    data: JSON.stringify({ Number: itemval.CustomerNumber, Trxnid: itemval.OrderId })
                }).then(function successCallback(response) {
                    if (response.data === 1)
                        swal('', 'Your complain has been raised successfully.', 'success');
                    else if (response.data === 4)
                        swal('', 'Complain of this transaction has alredy been raised.', 'error');
                    else
                        swal('', 'Please try again.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.puttransactionstatus = function (itemval) {
        if (itemval) {
            if (confirm('Do you want to check status')) {
                swal({ title: "Processing", text: "Please wait..", imageUrl: "../Content/images/Loader/Processing.gif", showConfirmButton: false });
                $http({
                    method: 'POST',
                    url: '/Recharge/GetTransactionStatus',
                    data: JSON.stringify({ trxncode: itemval.Trxnid })
                }).then(function successCallback(response) {
                    if (response.data === 1) {
                        gettransationrpts();
                        swal('', 'Your transaction status is successfully.', 'success');
                    }
                    else if (response.data === 2)
                        swal('', 'Your transaction status is Pending.', 'error');
                    else if (response.data === 0)
                        swal('', 'Your transaction status is Failed.', 'error');
                    else if (response.data === 5)
                        swal('', 'Your transaction is not exist.', 'error');
                    else
                        swal('', 'Error occured.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/ZbpReport/TransactionExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('MDRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Recharge/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderId })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 8) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/MDReport/SubRptTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchUsername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode === 0) {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                } else {
                    $scope.alltransaction = response.data; swal.close();
                }
            }, function errorCallback(rejection) {
                alert(rejection.data); location.reload();
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactioncomplain = function (itemval) {
        if (itemval) {
            if (confirm('Do you want raise complain?')) {
                $http({
                    method: 'POST',
                    url: '/Recharge/PutDisputetransaction',
                    data: JSON.stringify({ Number: itemval.CustomerNumber, Trxnid: itemval.OrderId })
                }).then(function successCallback(response) {
                    if (response.data === 1)
                        swal('', 'Your complain has been raised successfully.', 'success');
                    else if (response.data === 4)
                        swal('', 'Complain of this transaction has alredy been raised.', 'error');
                    else
                        swal('', 'Please try again.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.puttransactionstatus = function (itemval) {
        if (itemval) {
            if (confirm('Do you want to check status')) {
                swal({ title: "Processing", text: "Please wait..", imageUrl: "../Content/images/Loader/Processing.gif", showConfirmButton: false });
                $http({
                    method: 'POST',
                    url: '/Recharge/GetTransactionStatus',
                    data: JSON.stringify({ trxncode: itemval.Trxnid })
                }).then(function successCallback(response) {
                    if (response.data === 1) {
                        gettransationrpts();
                        swal('', 'Your transaction status is successfully.', 'success');
                    }
                    else if (response.data === 2)
                        swal('', 'Your transaction status is Pending.', 'error');
                    else if (response.data === 0)
                        swal('', 'Your transaction status is Failed.', 'error');
                    else if (response.data === 5)
                        swal('', 'Your transaction is not exist.', 'error');
                    else
                        swal('', 'Error occured.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/MDReport/TransactionExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('ADRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Distributor_new/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderId })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 8) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Distributor_new/Transaction/SubRptTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchUsername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode === 0) {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                } else {
                    $scope.alltransaction = response.data; swal.close();
                }
            }, function errorCallback(rejection) {
                alert(rejection.data); 
                //location.reload();
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactioncomplain = function (itemval) {
        if (itemval) {
            if (confirm('Do you want raise complain?')) {
                $http({
                    method: 'POST',
                    url: '/Recharge/PutDisputetransaction',
                    data: JSON.stringify({ Number: itemval.CustomerNumber, Trxnid: itemval.OrderId })
                }).then(function successCallback(response) {
                    if (response.data === 1)
                        swal('', 'Your complain has been raised successfully.', 'success');
                    else if (response.data === 4)
                        swal('', 'Complain of this transaction has alredy been raised.', 'error');
                    else
                        swal('', 'Please try again.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.puttransactionstatus = function (itemval) {
        if (itemval) {
            if (confirm('Do you want to check status')) {
                swal({ title: "Processing", text: "Please wait..", imageUrl: "../Content/images/Loader/Processing.gif", showConfirmButton: false });
                $http({
                    method: 'POST',
                    url: '/Recharge/GetTransactionStatus',
                    data: JSON.stringify({ trxncode: itemval.Trxnid })
                }).then(function successCallback(response) {
                    if (response.data === 1) {
                        gettransationrpts();
                        swal('', 'Your transaction status is successfully.', 'success');
                    }
                    else if (response.data === 2)
                        swal('', 'Your transaction status is Pending.', 'error');
                    else if (response.data === 0)
                        swal('', 'Your transaction status is Failed.', 'error');
                    else if (response.data === 5)
                        swal('', 'Your transaction is not exist.', 'error');
                    else
                        swal('', 'Error occured.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/Distributor_new/Transaction/TransactionExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('RGASMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Recharge/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderId })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 8) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            var mycategory = 0;
            var mysubcategory = 0;
            var myoperatorss = 0;
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubAEPSTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), Category: mycategory, Subcategory: mysubcategory, Operator: myoperatorss, Status: '' })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                } else {
                    $scope.alltransaction = null;
                }
                swal.close();
            }, function errorCallback(rejection) {
                swal.close(); if (rejection.status === 404) {
                    $location.path('/error');
                } else {
                    errorCallback(rejection);
                }
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactioncomplain = function (itemval) {
        if (itemval) {
            if (confirm('Do you want raise complain?')) {
                $http({
                    method: 'POST',
                    url: '/Recharge/PutDisputetransaction',
                    data: JSON.stringify({ Number: itemval.CustomerNumber, Trxnid: itemval.OrderId })
                }).then(function successCallback(response) {
                    if (response.data === 1)
                        swal('', 'Your complain has been raised successfully.', 'success');
                    else if (response.data === 4)
                        swal('', 'Complain of this transaction has alredy been raised.', 'error');
                    else
                        swal('', 'Please try again.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/AEPSTransactionExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('DISTRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Recharge/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderId })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 8) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/ADReport/SubAEPSTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchUsername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode === 0) {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                } else {
                    $scope.alltransaction = response.data; swal.close();
                }
            }, function errorCallback(rejection) {
                alert(rejection.data); location.reload();
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactioncomplain = function (itemval) {
        if (itemval) {
            if (confirm('Do you want raise complain?')) {
                $http({
                    method: 'POST',
                    url: '/Recharge/PutDisputetransaction',
                    data: JSON.stringify({ Number: itemval.CustomerNumber, Trxnid: itemval.OrderId })
                }).then(function successCallback(response) {
                    if (response.data === 1)
                        swal('', 'Your complain has been raised successfully.', 'success');
                    else if (response.data === 4)
                        swal('', 'Complain of this transaction has alredy been raised.', 'error');
                    else
                        swal('', 'Please try again.', 'error');
                }, function errorCallback(response) {
                    $scope.alltransaction = null;
                    alert(response);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/ADReport/AEPSTransactionExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('RGPNMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    $scope.getprintreciepts = function (itemval) {
        jQuery('#trandetailbynormal').hide(); jQuery('#trandetailbydmt').hide(); jQuery('#trandetailbybps').hide(); jQuery('#trandetailbyheadbps').hide(); jQuery('#trandetailbyheadnormal').hide();
        if (itemval) {
            $http({
                method: 'POST',
                url: '/Recharge/Showtransactiondetail',
                data: JSON.stringify({ trxnnumber: itemval.OrderID })
            }).then(function successCallback(response) {
                if (response.data) {
                    var data = response.data;
                    jQuery('#prt_hdtranid').html(data.Transid);
                    jQuery('#prt_bdtranid').html(data.Transid);
                    if (itemval.ServiceId === 9) {
                        $scope.rptsendername = data.Sendername;
                        $scope.rptaccountno = data.Accountno;
                        $scope.rptifsccode = data.Ifsc;
                        $scope.rptsenderno = data.Transnumber;
                        $scope.rptreceipentname = data.Receipent;
                        $scope.rpttxntype = data.Transtype;
                        $scope.ptrreferencenumbername = 'IMPS/UTR No.';
                        jQuery('#trandetailbydmt').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    } else if (data.Transservicetype === 'BBPS') {
                        jQuery('#prt_trandbillername').html(data.Billername);
                        jQuery('#prt_tranbillermobile').html(data.Custmobileno);
                        jQuery('#prt_tranchannel').html(data.Paymentchannel);
                        jQuery('#prt_trannumber').html(data.Transnumber);
                        jQuery('#prt_tranpaymode').html(data.Paymentmode);
                        jQuery('#prt_bdtranddate').html(data.Transdatetime);
                        $scope.ptrreferencenumbername = 'BBPS Transaction ID';
                        jQuery('#trandetailbybps').show();
                        jQuery('#trandetailbyheadnormal').hide();
                        jQuery('#trandetailbyheadbps').show();
                    } else {
                        $scope.rpttxnnumber = data.Transnumber;
                        $scope.rpttxndatetime = data.Transdatetime;
                        $scope.ptrreferencenumbername = 'Operator Refernce No.';
                        jQuery('#trandetailbynormal').show();
                        jQuery('#trandetailbyheadnormal').show();
                        jQuery('#trandetailbyheadbps').hide();
                    }
                    jQuery('#prt_trandate').html(data.Transdatetime);
                    jQuery('#prt_tranoperator').html(data.Servicename);
                    jQuery('#prt_tranid').html(data.Transid);
                    jQuery('#prt_tranrefernce').html(data.Referenceno);
                    jQuery('#prt_tranamount').html(data.Amount);
                    jQuery('#prt_transtatus').html(data.Status);
                    $scope.prt_trantotal = data.Amount;
                    $scope.prt_trantotalamt = data.Amount;
                    $scope.prt_tranword = data.Words;
                    $scope.prt_tranfee = 0;
                }
            }, function errorCallback(response) {
                alert(response.data);
                location.reload();
            });
            jQuery('#myReciept').modal('show');
        } else {
            swal('', 'Please try after sometime.', 'error');
        }
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubPanTransaction',
                data: JSON.stringify({ fromDate: $('#Fromdate').val(), toDate: $('#Todate').val() })
            }).then(function successCallback(response) {
                $scope.alltransaction = response.data;
                swal.close();
            }, function errorCallback(rejection) {
                swal.close(); if (rejection.status === 404) {
                    $location.path('/error');
                } else {
                    errorCallback(rejection);
                }
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.puttransactionstatus = function (itemval) {
        if (itemval) {
            if (confirm('Do you want to check status')) {
                swal({ title: "Processing", text: "Please wait..", imageUrl: "../Content/images/Loader/Processing.gif", showConfirmButton: false });
                $http({
                    method: 'POST',
                    url: '/PanCard/SubPSAStatusTransaction',
                    data: JSON.stringify({ txnID: itemval.OrderID })
                }).then(function successCallback(response) {
                    if (response.data.StatusCode === 1)
                        swal('', response.data.Message, 'success');
                    else
                        swal('', response.data.Message, 'error');
                }, function errorCallback(response) {
                    swal.close();
                    alert(response.data);
                });
            }
        }
    };

    $scope.doforcalculations = function () {
        if ($scope.prt_tranfee > 0) {
            $scope.prt_trantotal = parseFloat($scope.prt_trantotalamt) + parseFloat($scope.prt_tranfee);
            bindingworddatat($scope.prt_trantotal);
        } else {
            $scope.prt_trantotal = $scope.prt_trantotalamt;
            bindingworddatat($scope.prt_trantotal);
        }
    };

    function bindingworddatat(trantotal) {
        $http({
            method: 'POST',
            url: '/Recharge/Showtransaction',
            data: JSON.stringify({ trxnamount: trantotal })
        }).then(function successCallback(response) {
            if (response.data) {
                $scope.prt_tranword = response.data;
            }
        }, function errorCallback(response) {
            alert(response.data);
            location.reload();
        });
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/PanCardTransactionExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('RGGCMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubGCTransaction',
                data: JSON.stringify({ fromDate: $('#Fromdate').val(), toDate: $('#Todate').val(), filterData: $scope.filterData })
            }).then(function successCallback(response) {
                $scope.alltransaction = response.data;
                swal.close();
            }, function errorCallback(rejection) {
                swal.close(); if (rejection.status === 404) {
                    $location.path('/error');
                } else {
                    errorCallback(rejection);
                }
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/PanCardTransactionExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('RGWLMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //gettransationrpts();
    }

    $scope.getTransactionreports = function () {
        gettransationrpts();
    };

    function gettransationrpts() {
        if (jQuery('#Fromdate').val() && jQuery('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            var txnStatus = $scope.filterStatus ? $scope.filterStatus : '';
            $http({
                method: 'POST',
                url: '/Reports/SubSignupTransaction',
                data: JSON.stringify({ fromDate: $('#Fromdate').val(), toDate: $('#Todate').val(), status: txnStatus, number: '' })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data.Data;
                    swal.close();
                } else {
                    $scope.alltransaction = null; swal.close();
                }
            }, function errorCallback(rejection) {
                swal.close(); if (rejection.status === 404) {
                    $location.path('/error');
                } else {
                    errorCallback(rejection);
                }
            });
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    }

    $scope.doprocessupdatedata = function (item) {
        $scope.txnRefNumber = item;
        $scope.txnStatus = null;
        $scope.txnRemarks = null;
    };

    $scope.doUpdatetransactionproc = function () {
        if ($scope.txnStatus && $scope.txnRemarks) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Supports/SubUpdatesnRequest',
                data: JSON.stringify({ refNumber: $scope.txnRefNumber.RefID, status: $scope.txnStatus, comment: $scope.txnRemarks })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    alert(response.data.Message); gettransationrpts(); $scope.txnRefNumber = null, $scope.txnStatus = null, $scope.txnRemarks = null; jQuery('#myModal').modal('hide');
                } else {
                    swal('', response.data.Message, 'error');
                }
            }, function errorCallback(response) {
                    alert(response.data), location.reload();
            });
        } else
            swal('', "All field's are required.", 'error');
    };

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/SignupTransactionExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);