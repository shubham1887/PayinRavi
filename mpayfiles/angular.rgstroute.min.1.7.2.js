/// <reference path="angular.min.js" />

var myapp = angular.module('myapp', []);
myapp.controller('RGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString());
        $('#Todate').val(date.toLocaleDateString());
        //gettransactionreport();
    }

    $scope.doforfindingdata = function () {
        gettransactionreport();
    };

    function gettransactionreport() {
        if ($('#Fromdate').val() && $('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Retailer/Statement/SubStateTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchusername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else if (response.data.StatusCode === 2) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                }
            }, function errorCallback(response) {
                swal('', response.data, 'error');
            });
        } else {
            swal('', 'From date and to date is required.', 'error');
        }
    }

$scope.doforfindingdata2 = function () {
        gettransactionreport2();
    };


    function gettransactionreport2() {
        if ($('#Fromdate').val() && $('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Retailer/Statement2/SubStateTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchusername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else if (response.data.StatusCode === 2) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                }
            }, function errorCallback(response) {
                swal('', response.data, 'error');
            });
        } else {
            swal('', 'From date and to date is required.', 'error');
        }
    }



    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Retailer/Statement2/StatementExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };



    $scope.DotransactionEw1Export = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            window.location = "/Retailer/Statement/StatementExport?fromDate=" + fromDate + "&toDate=" + toDate;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };




}]);

myapp.controller('ZBPRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString());
        $('#Todate').val(date.toLocaleDateString());
        //gettransactionreport();
    }

    $scope.doforfindingdata = function () {
        gettransactionreport();
    };

    function gettransactionreport() {
        if ($('#Fromdate').val() && $('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/ZbpReport/SubStateTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchusername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else if (response.data.StatusCode === 2) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                }
            }, function errorCallback(response) {
                swal('', response.data, 'error');
            });
        } else {
            swal('', 'From date and to date is required.', 'error');
        }
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/ZbpReport/StatementExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('MDRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString());
        $('#Todate').val(date.toLocaleDateString());
        //gettransactionreport();
    }

    $scope.doforfindingdata = function () {
        gettransactionreport();
    };

    function gettransactionreport() {
        if ($('#Fromdate').val() && $('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/MasterDealer_new/Statement/SubStateTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchusername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else if (response.data.StatusCode === 2) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                }
            }, function errorCallback(response) {
                swal('', response.data, 'error');
            });
        } else {
            swal('', 'From date and to date is required.', 'error');
        }
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/MDReport/StatementExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);

myapp.controller('ADRGMainctrl', ['$scope', '$http', function ($scope, $http) {
    if ($('#Fromdate').val() === '') {
        var date = new Date();
        $('#Fromdate').val(date.toLocaleDateString());
        $('#Todate').val(date.toLocaleDateString());
        //gettransactionreport();
    }

    $scope.doforfindingdata = function () {
        gettransactionreport();
    };


    function gettransactionreport() {
        if ($('#Fromdate').val() && $('#Todate').val()) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../content/images/Loader/Processing.gif", showConfirmButton: false });
            $http({
                method: 'POST',
                url: '/Distributor_new/Statement/SubStateTransaction',
                data: JSON.stringify({ Fromdate: $('#Fromdate').val(), Todate: $('#Todate').val(), userName: $scope.searchusername })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else if (response.data.StatusCode === 2) {
                    $scope.alltransaction = response.data;
                    swal.close();
                } else {
                    $scope.alltransaction = response.data;
                    swal('', response.data.Message, 'error');
                }
            }, function errorCallback(response) {
                swal('', response.data, 'error');
            });
        } else {
            swal('', 'From date and to date is required.', 'error');
        }
    }

    $scope.DotransactionExport = function () {
        var fromDate = jQuery('#Fromdate').val(); var toDate = jQuery('#Todate').val();
        if (fromDate && toDate) {
            var userName = ''; if ($scope.searchUsername) { userName = $scope.searchUsername; }
            window.location = "/Distributor_new/Statement/StatementExport?fromDate=" + fromDate + "&toDate=" + toDate + "&userName=" + userName;
        } else {
            swal('', 'From Date and To Date is required.', 'error');
        }
    };

}]);