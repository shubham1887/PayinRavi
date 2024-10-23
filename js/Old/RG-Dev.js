
function ValidateNumber(e) {
    //if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //    //display error message
    //    //$("#errmsg").html("Digits Only").show().fadeOut("slow");
    //    return false;
    //}
    var evt = (e) ? e : window.event;
    var charCode = (evt.keyCode) ? evt.keyCode : evt.which;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function mobilevalidation()
{
    var num = $('#mobileNumber').val();
    var amt = $('#rechargeAmount').val();
    var mtpin = $('#mobileTPIN').val();
    if (num === '') {
        $('#mobileNumber').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#mobileNumber').css({
            "border": "",
            "background": ""
        });
    }
    if (mtpin === '' && mtpin.length === 4) {
        $('#mobileTPIN').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#mobileTPIN').css({
            "border": "",
            "background": ""
        });
    }
    if (amt === '') {
        $('#rechargeAmount').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } 
    else 
    {
        $('#rechargeAmount').css({
            "border": "",
            "background": ""
        });
        var _opratorName = jQuery("#rechargeOperator option:selected").text();
        if (confirm('Do you want recharge of ' + _opratorName + ' Amount:' + amt)) 
        {
            swal({ title: "Processing", text: "Please wait..", imageUrl: "../Processing.gif", showConfirmButton: false });
            //jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
            mobilerechargeconfirm();
        } 
        else
            return false;
    }
}

function dthvalidation() {
    var num = $('#DTHNumber').val();
    var amt = $('#DTHAmount').val();
    var dtpin = $('#dthTPIN').val();
    if (num === '') {
        $('#DTHNumber').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#DTHNumber').css({
            "border": "",
            "background": ""
        });
    }
    if (dtpin === '' && dtpin.length === 4) {
        $('#dthTPIN').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#dthTPIN').css({
            "border": "",
            "background": ""
        });
    }
    if (amt === '') {
        $('#DTHAmount').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#DTHAmount').css({
            "border": "",
            "background": ""
        });
        swal({ title: "Processing", text: "Please wait..", imageUrl: "../Processing.gif", showConfirmButton: false });
       //jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
       dthrechargeconfirm();
    }
}

function dcvalidation() {
    var num = $('#DCNumber').val();
    var amt = $('#DCAmount').val();
    var dctpin = $('#datacardTPIN').val();
    if (num === '') {
        $('#DCNumber').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#DCNumber').css({
            "border": "",
            "background": ""
        });
    }
    if (dctpin === '' && dctpin.length === 4) {
        $('#datacardTPIN').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#datacardTPIN').css({
            "border": "",
            "background": ""
        });
    }
    if (amt === '') {
        $('#DCAmount').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#DCAmount').css({
            "border": "",
            "background": ""
        });
        swal({ title: "Processing", text: "Please wait..", imageUrl: "../Processing.gif", showConfirmButton: false });
        jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
    }
}

function ppvalidation() {
    var num = $('#PPNumber').val();
    var amt = $('#PPAmount').val();
    var pptpin = $('#postpaidTPIN').val();
    if (num === '') {
        $('#PPNumber').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#PPNumber').css({
            "border": "",
            "background": ""
        });
    }
    if (pptpin === '' && pptpin.length===4) {
        $('#postpaidTPIN').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#postpaidTPIN').css({
            "border": "",
            "background": ""
        });
    }
    if (amt === '') {
        $('#PPAmount').css({
            "border": "1px solid red",
            "background": "#FFCECE"
        });
        return false;
    } else {
        $('#PPAmount').css({
            "border": "",
            "background": ""
        });
        swal({ title: "Processing", text: "Please wait..", imageUrl: "../Processing.gif", showConfirmButton: false });
        //jQuery('#ProcessingBox').attr("style", "display:block;margin-top: 25%;");
    }
}

//pp
function chkbilloperator()
{
    var opval = $("#ddlppOP option:selected").val();
    if (opval === "41" || opval === "54" || opval === "56") {
        $("#ppacno").show();
    } else {
        $("#ppacno").hide();
    }
}