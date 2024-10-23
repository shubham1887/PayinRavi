var rgapp = angular.module('rgapp', []);
rgapp.controller('MAINRGBS', ['$scope', '$http', function ($scope, $http) {
    resetmethod();
    Binddata();

    function Binddata() {
        $http({
            url: '/api/OperatorServices/Categories',
            method: 'POST'
        }).then(function successCallback(response) {
            if (response.data.ResponseStatus === '1') {
                $scope.categoriesdata = response.data.Data;
            } else {
                swal('', response.data.Remarks, 'error');
                $scope.categoriesdata = null;
            }
        }, function errorCallback(response) { alert(response.data); location.reload(); });
    }

    $scope.dobindopnamebycate = function (item) {
        $scope.subcategoriesdata = null; $scope.ErrorMessage = null;
        if (item.Categoryid) {
            $http({
                url: '/api/OperatorServices/SubCategories?category=' + item.Categoryid,
                method: 'POST'
            }).then(function successCallback(response) {
                if (response.data.ResponseStatus === '1') {
                    $scope.subcategoriesdata = response.data.Data;
                } else {
                    swal('', response.data.Remarks, 'error');
                    $scope.subcategoriesdata = null;
                }
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        } else
            $scope.ErrorMessage = 'Select Category Name.';
    };

    $scope.dobindvalidateparam = function (item) {
        resetmethod();
        if (item) {
            $http({
                url: '/api/OperatorServices/GetBillerparams?billerid=' + item.Billerid,
                method: 'POST'
            }).then(function successCallback(response) {
                if (response.data.ResponseStatus === '1') {
                    $scope.Billerparamdata = response.data.Data; var cnt = 0;
                    response.data.Data.forEach(function (itemdata) {
                        if (cnt === 0) {
                            $(".bank-details").show();
                            $scope.maintransnumber = itemdata.Name;
                            $scope.maintransnumbermaxlen = itemdata.MaxLength;
                            $scope.maintransnumberminlen = itemdata.MinLenght;
                            itemdata.Ismandatory === true ? (jQuery('#MainNumber').attr('required', 'required')) : (jQuery('#MainNumber').removeAttr('required'));
                            itemdata.FieldType === 'NUMERIC' ? (jQuery('#MainNumber').attr('onkeypress', 'return ValidateNumber(event);')) : (jQuery('#MainNumber').removeAttr('onkeypress'));
                            $scope.maintransnumberregpattern = itemdata.Pattern;
                            //itemdata.FieldType == 'NUMERIC' ? (jQuery('#MainNumber').attr('onkeypress', 'return ValidateNumber(event);')) : (jQuery('#MainNumber').removeAttr('onkeypress'))
                        } else if (cnt === 1) {
                            $(".bank-details").show();
                            $scope.mainaccountlabel = itemdata.Name;
                            itemdata.MaxLength > 1 ? (jQuery('#MainAccount_Number').attr('maxlength', itemdata.MaxLength)) : (jQuery('#MainAccount_Number').removeAttr('maxlength'));
                            itemdata.MinLenght !== 0 ? (jQuery('#MainAccount_Number').attr('minlength', itemdata.MinLenght)) : (jQuery('#MainAccount_Number').removeAttr('minlength'));
                            itemdata.Ismandatory === true ? (jQuery('#MainAccount_Number').attr('required', 'required')) : (jQuery('#MainAccount_Number').removeAttr('required'));
                            itemdata.FieldType === 'NUMERIC' ? (jQuery('#MainAccount_Number').attr('onkeypress', 'return ValidateNumber(event);')) : (jQuery('#MainAccount_Number').removeAttr('onkeypress'));
                            itemdata.Pattern !== ' ' ? (jQuery('#MainAccount_Number').attr('pattern', itemdata.Pattern)) : (jQuery('#MainAccount_Number').removeAttr('pattern')); $scope.accountnumverview = false;
                        } else if (cnt === 2) {
                            $(".bank-details").show();
                            $scope.maincyclelabel = itemdata.Name;
                            itemdata.MaxLength > 1 ? (jQuery('#MainCycle_Number').attr('maxlength', itemdata.MaxLength)) : (jQuery('#MainCycle_Number').removeAttr('maxlength'));
                            itemdata.MinLenght !== 0 ? (jQuery('#MainCycle_Number').attr('minlength', itemdata.MinLenght)) : (jQuery('#MainCycle_Number').removeAttr('minlength'));
                            itemdata.Ismandatory === true ? (jQuery('#MainCycle_Number').attr('required', 'required')) : (jQuery('#MainCycle_Number').removeAttr('required'));
                            itemdata.FieldType === 'NUMERIC' ? (jQuery('#MainCycle_Number').attr('onkeypress', 'return ValidateNumber(event);')) : (jQuery('#MainCycle_Number').removeAttr('onkeypress'));
                            itemdata.Pattern !== ' ' ? (jQuery('#MainCycle_Number').attr('pattern', itemdata.Pattern)) : (jQuery('#MainCycle_Number').removeAttr('pattern')); $scope.cyclenumbernumverview = false;
                        }
                        cnt++;
                    });
                    $scope.Biller_Name = item;
                    if ($scope.Biller_Name.Billercode === 'BSLL') { $scope.pptypenumbernumverview = false; } if ($scope.Biller_Name.Validateallow === true) { $scope.btnpaymentprocess = true; $scope.btnfeachindvalidateinfo = false; $scope.payable_amount = true; } else { $scope.btnpaymentprocess = false; $scope.btnfeachindvalidateinfo = true; $scope.payable_amount = false; }
                } else {
                    swal('', response.data.Remarks, 'error');
                    $scope.Billerparamdata = null;
                    $scope.btnpaymentprocess = true; $scope.btnfeachindvalidateinfo = true;
                }
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        } else
            $scope.ErrorMessage = 'Select Category or Subcategory Name.';
    };

    function resetmethod() {
        $scope.ErrorMessage = null; $scope.maintransnumber = 'Consumer Number'; $scope.payable_amount = true; $scope.maintransnumbermaxlen = '15'; $scope.maintransnumberminlen = '1'; $scope.maintransnumberregpattern = null;
        $scope.accountnumverview = true; $scope.cyclenumbernumverview = true; $scope.pptypenumbernumverview = true;
        $scope.mainaccountlabel = 'Account Number'; $scope.maincyclelabel = 'Cycle';
        $scope.MainAccount_Number = null; $scope.MainCycle_Number = null; $scope.MainNumber = null;
        $scope.btnpaymentprocess = false; $scope.btnfeachindvalidateinfo = true; $scope.Pay_Amount = null;
        $scope.Retailer_MobileNumber = null; $scope.Pay_TPIN = null;
    }

    $scope.doforfeachingbalfor = function () {
        $scope.ErrorMessage = null;
        //$scope.Category_name && 
        if ($scope.Biller_Name && $scope.MainNumber && $scope.Retailer_MobileNumber && $scope.Payment_Mode && $scope.Pay_TPIN) {
            var currentnumber = ''; if ($scope.MainCycle_Number) { currentnumber = $scope.MainCycle_Number; } if ($scope.PostpaidLand_Type) { currentnumber = $scope.PostpaidLand_Type; }
            //swal({ title: "Processing", text: "Please wait..", imageUrl: "../Images/image/Loder/Processing.gif", showConfirmButton: false });
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Utility/Validatebillingdetails',
                method: 'POST',
                data: JSON.stringify({ billercode: $scope.Biller_Name.Billerid, customerNo: $scope.Retailer_MobileNumber, billnumber: $scope.MainNumber, billeraccount: $scope.MainAccount_Number, billercycle: currentnumber })
            }).then(function successCallback(response) {
                if (response.data.StatusCode === 1) {
                    $scope.Pay_Amount = response.data.Data.dueamount;
                    $scope.netpaymentamount = response.data.Data.dueamount;
                    $scope.shomainnumber = $scope.MainNumber;
                    $scope.shopayamount = $scope.Pay_Amount;
                    $scope.shopduedate = response.data.Data.duedate;
                    $scope.shopbilldate = response.data.Data.billdate;
                    $scope.showbillername = $scope.Biller_Name.Billername;
                    $scope.shobillerimage = '/images/Recharge/Operators/' + $scope.Biller_Name.Imageurl;
                    $scope.shopconsumername = response.data.Data.customername;
                    $scope.shopbillnumbers = response.data.Data.billnumber;
                    $scope.refNumbers = response.data.Data.reference_id;
                    jQuery('#Perconfirmmodal').modal('show');
                    //swal.close();
                    jQuery('#ProcessingBox').attr("style", "display:none;");
                } else {
                    //swal('', response.data.Message, 'error');
                    jQuery('#ProcessingBox').attr("style", "display:none;");
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html(response.data.Message);
                    jQuery('#message').attr("style", "color:red;");
                }
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        } else
            $scope.ErrorMessage = "All field's are required.";
    };

    $scope.dooutprocbillpay = function () {
        $scope.ErrorMessage = null;
        //$scope.Category_name && 
        if ($scope.Biller_Name && $scope.MainNumber && $scope.Retailer_MobileNumber && $scope.Payment_Mode && $scope.Pay_Amount > 0 && $scope.Pay_TPIN) {
            var currentnumber = ''; if ($scope.MainCycle_Number) { currentnumber = $scope.MainCycle_Number; } if ($scope.PostpaidLand_Type) { currentnumber = $scope.PostpaidLand_Type; }
            //swal({ title: "Processing", text: "Please wait..", imageUrl: "../Images/image/Loder/Processing.gif", showConfirmButton: false });
            jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            $http({
                url: '/Utility/Dotransactions',
                method: 'POST',
                data: JSON.stringify({ billercode: $scope.Biller_Name.Billerid, billnumber: $scope.MainNumber, Amount: $scope.Pay_Amount, custmobileno: $scope.Retailer_MobileNumber, billeraccount: $scope.MainAccount_Number, billercycle: currentnumber, payment: $scope.Payment_Mode, duedate: $scope.shopduedate, billdate: $scope.shopbilldate, consumername: $scope.shopconsumername, billnumbers: $scope.shopbillnumbers, referenceNo: $scope.refNumbers, tPin: $scope.Pay_TPIN })
            }).then(function successCallback(response) {
                var jsonobj = response.data;
                if (jsonobj.StatusCode === 1) {
                    //swal({
                    //    title: '<small><div class="rg-alert-su">SUCCESS!</div></small>', text: '<div style="margin-left: 20px;text-align:left"> <b>Number :</b>' + $scope.MainNumber + '<br/><b>Amount :</b>' + $scope.Pay_Amount + '<br/><b>Message :</b>' + jsonobj.Data.Message + '<br/></div>', html: true, type: 'success', showCancelButton: true, confirmButtonColor: '#DD6B55', confirmButtonText: 'Print', closeOnConfirm: false
                    //}, function () { doshowprintforbbps(jsonobj.Data.Rechargeid); });
                    
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html('<small><div class="rg-alert-su">SUCCESS!</div></small>\n<div style="margin-left: 20px;text-align:left"> <b>Number :</b>' + $scope.MainNumber + '<br/><b>Amount :</b>' + $scope.Pay_Amount + '<br/><b>Message :</b>' + jsonobj.Data.Message + '<br/></div>');
                    jQuery('#message').attr("style", "color:green;");
                    jQuery('#btnsuccessBox').show();
                    jQuery('#btnsuccessPrint').attr('onclick', 'doshowprintforbbps(' + jsonobj.Data.Rechargeid + ')');
                    resetmethod();
                } else {
                    //swal('', jsonobj.Message, 'error');
                    jQuery('#ProcessingBox').attr("style", "display:none;");
                    jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                    jQuery('#message').html(jsonobj.Message);
                    jQuery('#message').attr("style", "color:red;");
                }
            }, function errorCallback(response) { alert(response.data); location.reload(); });
        } else
            $scope.ErrorMessage = "All field's are required.";
    };

    function doshowprintforbbps(itemvalue) {
        $.post("/Recharge/GetTransactiondetailsPay", { TranId: itemvalue }, function (item) {
            showprtreciept(item);
        }).error(function (result) { alert(result.responseText); location.reload(); });
    }

    function showprtreciept(itemval) {
        jQuery('#prt_operatorname').html(itemval.Operator);
        jQuery('#prt_operator_number').html(itemval.Operatornumber);
        jQuery('#prt_transactionid').html(itemval.Trxnid);
        jQuery('#prt_trxn_head_id').html(itemval.Trxnid);
        jQuery('#prt_InvoiceId').html(itemval.Trxnid);
        jQuery('#prt_operatorref').html(itemval.Operatorref);
        jQuery('#prt_transaction_date').html(parseJsonDate(itemval.Trxndate));
        jQuery('#prt_trxn_amount').html(itemval.Billamount);
        jQuery('#hdamt').val(itemval.Billamount);
        jQuery('#prt_total_amount').html(itemval.Billamount);
        swal.close();
        jQuery('#myReciept').modal('show');
    }

    function validateofflineeingmbill(itemx) {
        var clength = jQuery(itemx).val();
        if (clength > 0) {
            jQuery('#bl_pay_off_view').html(clength);
            jQuery('#btn_request_blr_off').removeAttr('disabled');
        } else {
            jQuery('#btn_request_blr_off').attr('disabled', 'disabled');
        }
    }

    function parseJsonDate(jsonDateString) {
        return new Date(parseInt(jsonDateString.replace('/Date(', '')));
    }

    
}]);