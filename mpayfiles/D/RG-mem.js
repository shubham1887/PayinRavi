

$(function () {

    bindServices();
    $('#PaymentMode').change(function () {
        var paymode = $('#PaymentMode option:selected').val();
        if (paymode === "Cheque/DD") {
            $('#TranNo').attr("disabled", false);
            $('#TranDate').attr("disabled", false);
        } else {
            $('#TranDate').attr("disabled", true);
            $('#TranNo').attr("disabled", true);
        }
    });

    $('#ddlusertype').change(function () {
        $.post('/IEBAL/FindUserDetails', { requestType: $('#ddlusertype').val() }, function (data) {
            var items = "<option value=''>Select</option>";
            $.each(data, function (i, list) {
                items += "<option value='" + list.Username + "'>" + list.UserDetails + "</option>";
            });
            $('#ddlusers').html(items);
        });
    });

    $('#ddlusers').change(function () {
        if (jQuery('#ddlusers').val() !== '' && jQuery('#ddlusers').val() !== null) {
            $.post('/IEBAL/FindUserBalance', { requestUser: $('#ddlusers').val() }, function (data) {
                var items = "<b>Current Balance : </b>" + data.Data;
                $('#currentbal').html(items);
            });
        }
    });

    $('#Select_UserName').change(function () {
        if (jQuery('#Select_UserName').val() !== '' && jQuery('#Select_UserName').val() !== null) {
            $.post('/IEBAL/FindUserBalance', { requestUser: $('#Select_UserName').val() }, function (data) {
                var items = "<b>Current Balance : </b>" + data.Data;
                $('#currentbal').html(items);
            });
        }
    });

    $('#ddlUserTypess').change(function () {
        $.post('/Distributor_new/CommissionUserWise/GetUserTypeWiseScheme', { id: $('#ddlUserTypess').val() }, function (data) {
            var items = "<option value=''>Select</option>";
            $.each(data, function (i, list) {
                items += "<option value='" + list.Value + "'>" + list.Text + "</option>";
            });
            $('#ddlSchemeType').html(items);
        });
    });

    $('#btnSubmit').click(function () {
        var userType = jQuery('#ddlusertype').val();
        var userReq = jQuery('#ddlusers').val();
        var reqAmt = jQuery('#cramount').val();
        var remarks = jQuery('#crcomment').val();
        if (userType !== '' && userReq !== '' && reqAmt > 0 && remarks !== '') {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
            $.post('/IEBAL/PaymentReducesRequest', { userName: userReq, amount: reqAmt }, function (data) {
                if (data.StatusCode === 1) {
                    jQuery('#btnSubmit').hide(); jQuery('#btnConfrim').show(); jQuery('#ConfirmView').show(); jQuery('#RequestOtp').val('');
                    swal('', data.Message, 'success');
                } else {
                    swal('', data.Message, 'error');
                }
            });
        } else {
            swal('', 'All fields are required.', 'error');
        }
    });

    $('#btnConfrim').click(function () {
        var userType = jQuery('#ddlusertype').val();
        var userReq = jQuery('#ddlusers').val();
        var reqAmt = jQuery('#cramount').val();
        var remarks = jQuery('#crcomment').val();
        var reqOtp = jQuery('#RequestOtp').val();
        if (userType !== '' && userReq !== '' && reqAmt > 0 && remarks !== '' && reqOtp !== '' && reqOtp.length === 6) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
            $.post('/IEBAL/PaymentReducesConfirm', { userName: userReq, amount: reqAmt, comment: remarks, otp: reqOtp }, function (data) {
                if (data.StatusCode === 1) {
                    jQuery('#btnSubmit').show(); jQuery('#btnConfrim').hide(); jQuery('#ConfirmView').hide(); jQuery('#RequestOtp').val(''); jQuery('#cramount').val(''); jQuery('#crcomment').val('')
                    jQuery('#currentbal').html(''); jQuery('#ddlusers').html('<option value="">Select User</option>');
                    swal('', data.Message, 'success');
                } else {
                    swal('', data.Message, 'error');
                }
            });
        } else {
            swal('', 'OTP is required.', 'error');
        }
    });

});
function bindServices() {
    $.post('/Distributor_new/CommissionUserWise/GetAllServices',{},function (data) {
        var items = "<option value=''>Select</option>";
        $.each(data, function (i, list) {
            items += "<option value='" + list.Value + "'>" + list.Text + "</option>";
        });
        $('#ddlServices').html(items);
    });
}
function chkcrvakidation() {

    if ($('#ddlusers option:selected').text() === '') {
        $('#ddlusers').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#ddlusers').css({
            "border": "",
            "background": ""
        });
    }
    if ($('#cramount').val() === '') {
        $('#cramount').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#cramount').css({
            "border": "",
            "background": ""
        });
    }

}

function chkwhitevalidation() {

    if ($('#Name').val() === '') {
        $('#Name').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#Name').css({
            "border": "",
            "background": ""
        });
    }
    if ($('#LastName').val() === '') {
        $('#LastName').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#LastName').css({
            "border": "",
            "background": ""
        });
    }
    if ($('#PortlURL').val() === '') {
        $('#PortlURL').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#PortlURL').css({
            "border": "",
            "background": ""
        });
    }
    if ($('#PanCard').val() === '') {
        $('#PanCard').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#PanCard').css({
            "border": "",
            "background": ""
        });
    }

}

function SetcommissionopWise(Id, srvCode) {
    if (confirm('Are you want update Commission')) {
        if (Id !== null) {
            var commper = $('#txtUserCommPer' + Id).val();
            var parentcommper = $('#txtParentCommPer' + Id).val();

            var commVal = $('#txtUserCommVal' + Id).val();
            var parentcommVal = $('#txtParentCommVal' + Id).val();

            var surchargeper = $('#txtUserSurPer' + Id).val();
            var parentsurchargeper = $('#txtParentSurPer' + Id).val();

            var surchargeVal = $('#txtUserSurVal' + Id).val();
            var parentsurchargeVal = $('#txtParentSurVal' + Id).val();
            if (commper !== "" && surchargeper !== "") {
                if (parseFloat(parentcommper) >= parseFloat(commper) || srvCode === 9) {
                    if (parseFloat(parentcommVal) >= parseFloat(commVal) || srvCode === 9) {
                        if (parseFloat(parentsurchargeper) <= parseFloat(surchargeper) || srvCode === 9) {
                            if (parseFloat(parentsurchargeVal) <= parseFloat(surchargeVal) || srvCode === 9) {
                                swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
                                
                                $.post("/Distributor_new/CommissionUserWise/CommissionSetting", 
                                    {pattern:srvCode, commID: Id, commPer: commper, commVal: commVal, chargePer: surchargeper, chargeVal: surchargeVal }, 
                                    function (data) 
                                    {

                                    if (data.StatusCode === 1) {
                                        alert(data.Message); GetcommissiondetailsALL();
                                    } else {
                                        swal('', data.Message, 'error');
                                    }
                                });
                            } else {
                                swal('', 'user Surcharge val is Less than parent Surcharge val', 'error');
                            }
                        } else {
                            swal('', 'user Surcharge per is Less than parent Surcharge per.', 'error');
                        }
                    } else {
                        swal('', 'user Commission val is greater than parent commission val.', 'error');
                    }
                } else {
                    swal('', 'user Commission per is greater than parent commission per.', 'error');
                }
            } else {
                swal('', 'Invalid Parametors.', 'error');
            }

        } else {
            return false;
        }
    } else {
        return false;
    }
}

function UnSetcommissionopWise(Id, optID, srvCode) {
    if (confirm('Are you want update Commission')) {
        if (Id !== null) {
            var commper = $('#txtUserCommPer' + Id).val();
            var parentcommper = $('#txtParentCommPer' + Id).val();

            var commVal = $('#txtUserCommVal' + Id).val();
            var parentcommVal = $('#txtParentCommVal' + Id).val();

            var surchargeper = $('#txtUserSurPer' + Id).val();
            var parentsurchargeper = $('#txtParentSurPer' + Id).val();

            var surchargeVal = $('#txtUserSurVal' + Id).val();
            var parentsurchargeVal = $('#txtParentSurVal' + Id).val();
            var schemeid = $('#ddlSchemeType').val();
            if (commper !== "" && surchargeper !== "") {
                if (parseFloat(parentcommper) >= parseFloat(commper) || srvCode === 9) {
                    if (parseFloat(parentcommVal) >= parseFloat(commVal) || srvCode === 9) {
                        if (parseFloat(parentsurchargeper) <= parseFloat(surchargeper) || srvCode === 9) {
                            if (parseFloat(parentsurchargeVal) <= parseFloat(surchargeVal) || srvCode === 9) {
                                swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });

                                $.post("/ADU/SetCommissionSetting", { pattern: schemeid, commPer: commper, commVal: commVal, chargePer: surchargeper, chargeVal: surchargeVal, operatorID: optID }, function (data) {
                                    if (data.StatusCode === 1) {
                                        alert(data.Message); GetcommissiondetailsALL();
                                    } else {
                                        swal('', data.Message, 'error');
                                    }
                                });
                            } else {
                                swal('', 'user Surcharge val is Less than parent Surcharge val', 'error');
                            }
                        } else {
                            swal('', 'user Surcharge per is Less than parent Surcharge per.', 'error');
                        }
                    } else {
                        swal('', 'user Commission val is greater than parent commission val.', 'error');
                    }
                } else {
                    swal('', 'user Commission per is greater than parent commission per.', 'error');
                }
            } else {
                swal('', 'Invalid Parametors.', 'error');
            }

        } else {
            return false;
        }
    } else {
        return false;
    }
}

function DoRequestCommPer() {
    var commPer = $('#RequestCommPer').val();
    var patterns = $('#ddlSchemeType').val();
    if (commPer >= 0 && commPer <= 100 && patterns !== "" && patterns !== null) {
        if (confirm('Are you want to set commission to all.')) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
            $.post("/Distributor_new/CommissionUserWise/SetFullCommissions", { pattern: patterns, value: commPer }, function (data) {
                if (data.StatusCode === 1) {
                    alert(data.Message); GetcommissiondetailsALL();
                } else {
                    swal('', data.Message, 'error');
                }
            });
        }
    } else {
        alert('Please Select Scheme Type & Commission In Per');
    }
}

function DoRequestCommVal() {
    var commPer = $('#RequestCommValue').val();
    var patterns = $('#ddlSchemeType').val();
    if (commPer >= 0 && commPer <= 100 && patterns !== "" && patterns !== null) {
        if (confirm('Are you want to set commission to all.')) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
            $.post("/ADU/SetFullCommissionValue", { pattern: patterns, value: commPer }, function (data) {
                if (data.StatusCode === 1) {
                    alert(data.Message); GetcommissiondetailsALL();
                } else {
                    swal('', data.Message, 'error');
                }
            });
        }
    } else {
        alert('Please Select Scheme Type & Commission In Val');
    }
}

function DoRequestChargePer() {
    var commPer = $('#RequestChargePer').val();
    var patterns = $('#ddlSchemeType').val();
    if (commPer >= 0 && commPer <= 100 && patterns !== "" && patterns !== null) {
        if (confirm('Are you want to set commission to all.')) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
            $.post("/ADU/SetFullServicesCommission", { pattern: patterns, value: commPer }, function (data) {
                if (data.StatusCode === 1) {
                    alert(data.Message); GetcommissiondetailsALL();
                } else {
                    swal('', data.Message, 'error');
                }
            });
        }
    } else {
        alert('Please Select Scheme Type & Charge In Per');
    }
}

function DoRequestChargeValue() {
    var commPer = $('#RequestChargeValue').val();
    var patterns = $('#ddlSchemeType').val();
    if (commPer >= 0 && commPer <= 100 && patterns !== "" && patterns !== null) {
        if (confirm('Are you want to set commission to all.')) {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });
            $.post("/ADU/SetFullServicesCommissionValue", { pattern: patterns, value: commPer }, function (data) {
                if (data.StatusCode === 1) {
                    alert(data.Message); GetcommissiondetailsALL();
                } else {
                    swal('', data.Message, 'error');
                }
            });
        }
    } else {
        alert('Please Select Scheme Type & Charge In Per');
    }
}


function GetcommissiondetailsALL() {
    var schemeid = $('#ddlSchemeType').val();
    var service = $('#ddlServices').val();
    if (schemeid !== "" && schemeid !== null) {
        if (service == "" || service == null) { service = 0; }
        swal({ title: "Processing", text: "Please wait..", imageUrl: "/Images/image/Loder/Processing.gif", showConfirmButton: false });

        $.post("/Distributor_new/CommissionUserWise/GetcommissiondetailsthroughPartial", { schemetype: schemeid, serviceId: service}, function (data) {
            $('#commDetailsDiv').html(data);
            swal.close();
        });
    }
}