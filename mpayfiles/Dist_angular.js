/// <reference path="angular.min.js" />
var myapp = angular.module("myapp", []);
myapp.controller("RGPAYCNTRL", ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //BindData();
    }
    $scope.SearchBindData = function () {
        BindData();
    };


    function BindData() {
        var _fromDate = jQuery('#Fromdate').val();
        var _toDate = jQuery('#Todate').val();
        if (_fromDate && _toDate) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../mpayfiles/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Distributor_new/LoadReport/SubPaymentLoad',
                data: JSON.stringify({ userId:0, fromDate: _fromDate, toDate: _toDate})
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode !== 0) {
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





































    

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/PaymentLoadExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller("RGPAYDCNTRL", ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //BindData();
    }

    $scope.SearchBindData = function () {
        BindData();
    };

    function BindData() {
        var _fromDate = jQuery('#Fromdate').val();
        var _toDate = jQuery('#Todate').val();
        if (_fromDate && _toDate) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubPaymentDeduct',
                data: JSON.stringify({ userId: 0, fromDate: _fromDate, toDate: _toDate })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode !== 0) {
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

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/PaymentDeductExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller("RGPAYFNCNTRL", ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //BindData();
    }

    $scope.SearchBindData = function () {
        BindData();
    };

    function BindData() {
        var _fromDate = jQuery('#Fromdate').val();
        var _toDate = jQuery('#Todate').val();
        if (_fromDate && _toDate) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubRefundTransaction',
                data: JSON.stringify({ userId: 0, fromDate: _fromDate, toDate: _toDate })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode !== 0) {
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

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/TransactionRefundExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller("RGPAYCRCNTRL", ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //BindData();
    }

    $scope.SearchBindData = function () {
        BindData();
    };

    function BindData() {
        var _fromDate = jQuery('#Fromdate').val();
        var _toDate = jQuery('#Todate').val();
        if (_fromDate && _toDate) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubServiceTransaction',
                data: JSON.stringify({ userId: 0, fromDate: _fromDate, toDate: _toDate })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode !== 0) {
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

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/ServiceChargesExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller("RGPAYCMCNTRL", ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString('en-US'));
        $('#Todate').val(date.toLocaleDateString('en-US'));
        //BindData();
    }

    $scope.SearchBindData = function () {
        BindData();
    };

    function BindData() {
        var _fromDate = jQuery('#Fromdate').val();
        var _toDate = jQuery('#Todate').val();
        if (_fromDate && _toDate) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Reports/SubCommissionTransaction',
                data: JSON.stringify({ userId: 0, fromDate: _fromDate, toDate: _toDate })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data; swal.close();
                } else if (response.data.StatusCode !== 0) {
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

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Reports/CommissionTransactionExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);