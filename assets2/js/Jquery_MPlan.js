$("#mobileNumber").autocomplete({
    source: function (request, response) {
        var char = request.term;
        var cnt = char.toString().length;
        if (cnt === 10) {
            jQuery('#rechargeAmount').focus();
            //char = char.substring(0, 5);
            $.ajax({
                url: '/Retailer/Recharge_home/getoperatorname?mobile_no='+char,
                data: "{'number':'" + char + "','type':'WEB'}",
                dataType: "json",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                success: function (data) {


                    document.getElementById("rechargeOperator").value = data;
                     $('#rechargeOperator').select2().trigger('change');
                   // if (data.records.status === 1) {
                       // $("#rechargeOperator option:contains('" + data + "')").attr('selected', true);
                        //$("#rechargeCircle option:contains('" + data.records.circle + "')").attr('selected', true);
                        //jQuery('#select2-rechargeOperator-container').html('<span class="select2-selection__clear">×</span>' + data);
                        //jQuery('#select2-rechargeCircle-container').html('<span class="select2-selection__clear">×</span>' + data.records.circle);
                        special();
                   // }
                   // else {
                       // $("#rechargeOperator option:contains('Select')").attr('selected', true);
                      //  $("#rechargeCircle option:contains('Select')").attr('selected', true);
                     //   $("#recharge_block").show();
                     //   $("#banner").hide();
                   // }
                },
                error: function (response) {
                    $("#rechargeOperator option:contains('Select')").attr('selected', true);
                    $("#rechargeCircle option:contains('Select')").attr('selected', true);
                },
                failure: function (response) {
                    alert("F" + response.responseText);
                }
            });
        }

    },
    select: function (e, i) {

    },
    minLength: 4
});


$("#DTHNumber").autocomplete({
    source: function (request, response) {
        var char = request.term;
        var cnt = char.toString().length;
        if (cnt >= 8) {
            //char = char.substring(0, 5);
            $.ajax({
                url: '/Recharge/GetDTHOperator',
                data: "{'number':'" + char + "','type':'WEB'}",
                dataType: "json",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    if (data.records.status === 1) {
                        $("#ddldthOP option:contains('" + data.records.Operator.toUpperCase() + "')").attr('selected', true);
                        jQuery('#select2-ddldthOP-container').html('<span class="select2-selection__clear">×</span>' + data.records.Operator.toUpperCase());
                    }
                    else {
                        $("#ddldthOP option:contains('Select')").attr('selected', true);
                        $("#dth_block").show();
                        $("#banner1").hide();
                    }
                },
                error: function (response) {
                    $("#ddldthOP option:contains('Select')").attr('selected', true);
                },
                failure: function (response) {
                    alert("F" + response.responseText);
                }
            });
        }

    },
    select: function (e, i) {

    },
    minLength: 4
});


var planlist = "";
function FetchPlans() {
    //jQuery('#ProcessingBox').attr("style", "display:block;");
    jQuery('#ProcessingBox').modal('show');
    $(".als-wrapper").show();
    if ($("#rechargeOperator option:selected").text() !== null && $("#rechargeOperator option:selected").text() !== '' && $("#rechargeCircle option:selected").text() !== '' && $("#rechargeCircle option:selected").text() !== null) {
        $('#planlist').show();
        $.ajax({
            url: '/Retailer/Recharge_home/FetchPlans',
            data: "{'operatorid':'" + $("#rechargeOperator").val() + "','circleid':'" + $("#rechargeCircle option:selected").text() + "'}",
            dataType: "json",
            type: "POST",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                if (data !== null && data !== "") {
                    if (data.status === 1) {
                        planlist = '';
                        try {
                            PlanBindv2(data, "All");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records.FULLTT, "FULLTT");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records.TOPUP, "TOPUP");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records["3G/4G"], "3G-4G");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records["RATE CUTTER"], "RATE-CUTTER");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records["2G"], "2G");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records.SMS, "SMS");
                        } catch{
                            //
                        }
                        try {
                            PlanBind(data.records.COMBO, "COMBO");
                        } catch{
                            //
                        }
                    }
                    else {
                        planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                        $("#allplans").html(planlist);
                        $("#myModalPlan").modal('show');

                    }
                    planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist">' + planlist + '</ul>';
                    $("#allplans").html(planlist);
                    $("#myModalPlan").modal('show');
                } else {
                    planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                    $("#allplans").html(planlist);
                    $("#myModalPlan").modal('show');
                }
                jQuery('#ProcessingBox').modal('hide');
            },
            error: function (response) { alert("Error" + response.responseText); }
        });

    } else {
        alert('Please Select Operator And Circle.');
    }
}

function PlanBind(obj, type) {
    if (obj != null) {
        planlist += '<table class="table tableplan plans" id="tbl' + type + '" style="display: none;"><thead><tr><td>Category</td><td>Validity</td><td>Description</td><td>Price</td></tr></thead>'
        $.each(obj, function (key, value) {
            planlist += '<tr class="plan" onclick="fillamt(' + obj[key].rs + ');" category="' + type + '" id="li' + obj[key].rs + '">' +
                '<td>' + type + '</td><td>' + obj[key].validity + '</td><td>' + obj[key].desc + '</td><td><a class="btnprice">&#8377; ' + obj[key].rs + '</a></td></tr>';
        });
        '</table>';
    } else {
        if (planlist === '' && type === "COMBO")
            planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found.</h3></ul>';
    }
}

function PlanBindv2(obj, type) {
    if (obj != null) {
        var count = 0;
        planlist += '<table class="table tableplan plans" id="tbl' + type + '"><thead><tr><td>Category</td><td>Validity</td><td>Description</td><td>Price</td></tr></thead>'
        try {
            $.each(obj.records.FULLTT, function () {
                planlist += '<tr class="plan" onclick="fillamt(' + this.rs + ');" category="' + type + '" id="li' + this.rs + '">' +
                    '<td>FULLTT</td><td>' + this.validity + '</td><td>' + this.desc + '</td><td><a class="btnprice">&#8377; ' + this.rs + '</a></td></tr>'; count = 1;
            });
        } catch{
            alert(); //
        }
        try {
            $.each(obj.records.TOPUP, function () {
                planlist += '<tr class="plan" onclick="fillamt(' + this.rs + ');" category="' + type + '" id="li' + this.rs + '">' +
                    '<td>TOPUP</td><td>' + this.validity + '</td><td>' + this.desc + '</td><td><a class="btnprice">&#8377; ' + this.rs + '</a></td></tr>'; count = 1;
            });
        } catch{
            //
        }
        try {
            $.each(obj.records["3G/4G"], function () {
                planlist += '<tr class="plan" onclick="fillamt(' + this.rs + ');" category="' + type + '" id="li' + this.rs + '">' +
                    '<td>3G-4G</td><td>' + this.validity + '</td><td>' + this.desc + '</td><td><a class="btnprice">&#8377; ' + this.rs + '</a></td></tr>'; count = 1;
            });
        } catch{
            //
        }
        try {
            $.each(obj.records["RATE CUTTER"], function () {
                planlist += '<tr class="plan" onclick="fillamt(' + this.rs + ');" category="' + type + '" id="li' + this.rs + '">' +
                    '<td>RATE-CUTTER</td><td>' + this.validity + '</td><td>' + this.desc + '</td><td><a class="btnprice">&#8377; ' + this.rs + '</a></td></tr>'; count = 1;
            });
        } catch{
            //
        }
        try {
            $.each(obj.records["2G"], function () {
                planlist += '<tr class="plan" onclick="fillamt(' + this.rs + ');" category="' + type + '" id="li' + this.rs + '">' +
                    '<td>2G</td><td>' + this.validity + '</td><td>' + this.desc + '</td><td><a class="btnprice">&#8377; ' + this.rs + '</a></td></tr>'; count = 1;
            });
        } catch{
            //
        }
        try {
            $.each(obj.records.COMBO, function () {
                planlist += '<tr class="plan" onclick="fillamt(' + this.rs + ');" category="' + type + '" id="li' + this.rs + '">' +
                    '<td>COMBO</td><td>' + this.validity + '</td><td>' + this.desc + '</td><td><a class="btnprice">&#8377; ' + this.rs + '</a></td></tr>'; count = 1;
            });
        } catch{
            //
        }
        planlist += '</table>';
        if (count === 0) {
            planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found.</h3></ul>';
        }
    } else {
        if (planlist === '')
            planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found.</h3></ul>';
    }
}

$(function () {
    $('ul.mylist .selected li').click(function () {
        alert();
    });

});

function fillamt(amt11) {
    var PrvsId = $("#rechargeAmount").val();
    $("#rechargeAmount").val(amt11);
    $('#li' + amt11).addClass("selectplan");
    $('#li' + PrvsId).removeClass('selectplan');
    $("#myModalPlan").modal('hide');
    //$(".modal-backdrop").hide();
}

function sortplans(p0) {
    $("tr.plan").hide();
    $("table.plans").hide();
    //if (p0 === 'All') {
    //    $("tr.plan").show();
    //    $("table.plans").show();
    //}
    //else {
    $('tr[category="' + p0 + '"]').show();
    $('#tbl' + p0).show();
    //}
}

function amoutfill() {
    var amt = $("#rechargeAmount").val();

    $("tr.plan").show();
    $("#overflow_div").scrollTo("#li" + amt, 1000);//call of Scroll li

    //decorate selected plan
    $("tr.plan").addClass("selectplan").siblings().removeClass("selectplan");
    $("#li" + amt).addClass("selectplan");

}
//plugin for  scroll li
jQuery.fn.scrollTo = function (elem) {
    $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top);
    return this;
};

jQuery.fn.scrollTo = function (elem, speed) {
    $(this).animate({
        scrollTop: $(this).scrollTop() - $(this).offset().top + $(elem).offset().top
    }, speed === undefined ? 1000 : speed);
    return this;
};
/************/
function special() {

    $(".als-wrapper").hide();
    $('#planlist').hide();
    $("#allplans").html('');

    if ($("#mobileNumber").val() !== null && $("#mobileNumber").val() !== "") {
        var cnt = $("#mobileNumber").val().length;
        if (cnt >= 10) {
            //$(".loader").show();
            jQuery('#ProcessingBoxPlan').attr("style", "display:block;");
            $.ajax({
                url: '/Retailer/Recharge_home/FetchMobilePlansRoffer',
                data: "{'operatorid':'" + $("#rechargeOperator").val() + "','number':'" + $("#mobileNumber").val() + "'}",
                dataType: "json",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                success: function (result) {
                    var str = "";
                    try {
                        if (result.status === 1) {
                            var i;
                            for (i = 0; i < result.records.length; i++) {
                                //str += '<li class="plan" onclick="fillamt(' + result.records[i].rs + ');" category="Specials" id="li' + result.records[i].rs + '">' +
                                //    '<table class="table">' +
                                //    '<tr>' +
                                //    '<td style="text-align: center;font-weight:bold;">Rs</td>' +
                                //    '<td style="text-align: left">Category<span class="cat"></span>Validity<span class="day"></span></td>' +
                                //    ' </tr>' +
                                //    '<tr>' +
                                //    '<td><span class="amt">' + result.records[i].rs + '</span></td>' +
                                //    '<td style="text-align: left;font-weight:normal;white-space: normal;">' + result.records[i].desc + '</td>' +
                                //    '</tr>' +
                                //    '</table>' +
                                //    '</li>';

                                str += '<tr class="plan" onclick="fillamt(' + result.records[i].rs + ');" category="Specials" id="li' + result.records[i].rs + '">' +
                                    '<td style="text-align: left;font-weight:normal;white-space: normal;">' + result.records[i].desc + '</td>' +
                                    '<td style="text-align:center;"><a href="#" class="btnprice"><span class="">&#8377; ' + result.records[i].rs + '</span></a></td>' +
                                    '</tr>';


                            }
                            //str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist">' + str + '</ul>';
                            str = '<table class="table"><tr><td style="text-align: left;font-weight: bold;">Category <span class="cat"></span>Validity<span class="day"></span></td><td style="text-align:center; font-weight: bold;">Price</td></tr>' + str + '</table>';
                            $("#allplans").html(str);
                        } else if (result.status === 2) {
                            str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                            $("#allplans").html(str);
                            alert(result.msg);
                        }
                        else {
                            str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                            $("#allplans").html(str);
                        }
                    } catch (ee) {
                        str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                        $("#allplans").html(str);
                    }
                    $("#myModalPlan").modal('show');
                    //$(".loader").hide();
                    jQuery('#ProcessingBoxPlan').attr("style", "display:none;");
                }

            });
        } else {
            alert('Valid Mobile No Is Required.');
        }
    } else {
        alert('Mobile No Is Required.');
    }
}

function getdthoplist() {
    var opnm = $("#ddldthOP option:selected").text();//ddldthOP
    var opval = $("#ddldthOP option:selected").val();
    displaydthplans(opnm);
    var reply = setoperatordimg22(opval);
    $('#opplan').attr('class', 'RG-opplan');
    $('#opplan').css('background-position', reply);

}

function DTHspecial() {
    $(".als-wrapper").hide();
    $('#planlist').hide();
    $('#allplans').html('');
    if ($("#DTHNumber").val() !== null && $("#DTHNumber").val() !== "") {
        jQuery('#ProcessingBoxPlan').attr("style", "display:block;");
        $.ajax({
            url: '/Recharge/FetchDTHPlansRoffer',
            data: "{'operatorid':'" + $("#ddldthOP option:selected").text() + "','number':'" + $("#DTHNumber").val() + "'}",
            dataType: "json",
            type: "POST",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                var str = "";
                if (data.status === 1) {
                    var i;
                    try {
                        for (i = 0; i < data.records.length; i++) {
                            str += '<tr class="plan" onclick="fillamtDTH(' + data.records[i].rs + ');" category="DTHSpecials" id="li' + data.records[i].rs + '">' +
                                '<td style="text-align: left;font-weight:normal">' + data.records[i].desc + '</td>' +
                                '<td><a href="#" class="btnprice"><span class="">&#8377; ' + data.records[i].rs + '</span></a></td>' +
                                '</tr>';

                        }
                        str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><li><table class="table"><tr><td style="text-align: left;font-weight:bold;">Category <span class="cat"></span>Validity<span class="day"></span></td><td style="text-align: left;font-weight:bold;">Price</td></tr>' + str + '</table></li></ul>';
                        $('#allplans').html(str);
                        $("#myModalPlan").modal('show');
                    }
                    catch (err) {
                        str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                        $("#allplans").html(str);

                    }
                } else if (data.records.status === 2) {
                    str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                    $("#allplans").html(str);

                    alert(data.msg);
                } else {
                    str = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                    $("#allplans").html(str);

                }
                $("#myModalPlan").modal('show');
                jQuery('#ProcessingBoxPlan').attr("style", "display:none;");
            }

        });
    }
}

function displaydthplans(id) {
    $(".als-wrapper").hide();
    $('#planlist').hide();
    $('#allplans').html('');
    var planlist = "";
    if (id !== null && id !== '') {
        jQuery('#ProcessingBoxPlan').attr("style", "display:block;");
        $.ajax({
            url: "/Recharge/getdthplans",
            data: "{'opname':'" + id + "'}",
            dataType: "json",
            type: "POST",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                if (data.status === 1) {
                    try {
                        var i;
                        for (i = 0; i < data.records.Plan.length; i++) {

                            //planlist += '<table class="table">' +
                            //'<tr>' +
                            //'<td>1 MONTHS</td>' +
                            //'<td>3 MONTHS</td>' +
                            //'<td>6 MONTHS</td>' +
                            //'<td>1 Year</td>' +
                            //' </tr>' +

                            planlist += '<tr>' +
                                '<td>' + data.records.Plan[i].plan_name + '</td>' +
                                '<td>' + data.records.Plan[i].desc + '</td>' +
                                '<td><a class="btnprice" onclick="fillamtDTH(' + data.records.Plan[i].rs["1 MONTHS"] + ');">&#8377; ' + data.records.Plan[i].rs["1 MONTHS"] + '</a></td>' +
                                '<td><a class="btnprice" onclick=fillamtDTH(' + data.records.Plan[i].rs["3 MONTHS"] + ')>&#8377; ' + data.records.Plan[i].rs["3 MONTHS"] + '</a></td>' +
                                '<td><a class="btnprice" onclick=fillamtDTH(' + data.records.Plan[i].rs["6 MONTHS"] + ')>&#8377; ' + data.records.Plan[i].rs["6 MONTHS"] + '</a></td>' +
                                '<td><a class="btnprice" onclick=fillamtDTH(' + data.records.Plan[i].rs["1 YEAR"] + ')>&#8377; ' + data.records.Plan[i].rs["1 YEAR"] + '</a></td>' +
                                '</tr>';

                            //'<tr>' +
                            //'<td colspan="4" >' +
                            //'<table>' +
                            //'<tr><td style="width:20%;"><b style="line-height: 30px;">Plan Name : </b></td><td colspan="2" style="text-align: left;font-weight:normal">' + data.records.Plan[i].plan_name + '</td></tr>' +
                            //'<tr><td><b>Description : </b></td><td colspan="2" style="text-align: left;font-weight:normal">' + data.records.Plan[i].desc + '</td></tr>' +
                            //'</table>' +
                            //'</td>' +
                            //' </tr></table>';

                        }
                        planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><li class="plan"><table class="table tableDth"><tr><td><b>Plan Name</b></td><td><b>Desc</b></td><td><b>1 MON</b></td><td><b>3 MON</b></td><td><b>6 MON</b></td><td><b>1 Year</b></td></tr>' + planlist + '</table></li></ul>';
                        $('#allplans').html(planlist);
                        $("#myModalPlan").modal('show');
                    }
                    catch (err) {
                        planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                        $("#allplans").html(planlist);
                        $("#myModalPlan").modal('show');
                    }
                } else if (data.status === "2") {
                    planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                    $("#allplans").html(planlist);
                    alert(data.msg);
                    $("#myModalPlan").modal('show');
                }
                else {
                    planlist = '<ul style="list-style: none; padding: 0; margin: 2px" class="mylist"><h3 style="background-color: rgb(255, 206, 206); margin: 0px; padding: 15px; font-weight: bold;">Plans Not Found</h3></ul>';
                    $("#allplans").html(planlist);
                    $("#myModalPlan").modal('show');
                }
                jQuery('#ProcessingBoxPlan').attr("style", "display:none;");
            },
            error: function (response) {
                //alert(response.responseText);
                // $("#dthplan-body").html("<div style='text-align: center; padding: 20px; background-color: rgb(255, 248, 233);'> No Suitable Plans Found.</div>");
                $('#allplans').html('');
            }
        });
        swal.close();
    } else {
        alert('Operator Is Required.');
    }
}


function fillamtDTH(amt11) {
    $("#DTHAmount").val(amt11);
    $('#myModalPlan').modal('hide');
}

function getInfo() {
    var opnm = $("#ddldthOP option:selected").val();
    if ($("#DTHNumber").val() !== null && $("#DTHNumber").val() !== "") {
        if (opnm !== null && opnm !== "") {
            $.ajax({
                url: "/Retailer/Recharge_home/GetDTHCustInfo",
                data: "{'operatorid':'" + opnm + "','number':'" + $("#DTHNumber").val() + "'}",
                dataType: "json",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                success: function (data) {
                    if (data.status === 1) {
                        try {
                            //alert("Customer Name :" + data.records[0].customerName + ", Balance:" + data.records[0].Balance + ", Next Recharge Date:" + data.records[0].NextRechargeDate + ",Status:" + data.records[0].status);

                            $("#nextrechdate").html(data.records[0].NextRechargeDate);
                            $("#custname").html(data.records[0].customerName);
                            $("#bal").html(data.records[0].Balance);
                            $("#status").html(data.records[0].status);
                            $("#planname").html(data.records[0].planname);
                            $("#lastrechargedate").html(data.records[0].lastrechargedate);
                            $("#lastrechargeamount").html(data.records[0].lastrechargeamount);

                            $('#myModal').modal('show');
                        } catch (ee) {
                            alert(data.records.desc);
                        }
                    } else if (data.status === 2) {
                        alert(data.msg);
                    } else {
                        alert("Customer Details Not Found.");
                    }
                },
                error: function (response) {
                    //alert("Error Occured");
                    //$("#dcplanbody").html("<div style='text-align: center; padding: 20px; background-color: rgb(255, 248, 233);'> No Suitable Plans Found.</div>");
                    $('#dcplanbody').html(response.responseText);
                }
            });

        } else {
            alert("Operator is Required.");
        }
    } else { alert("DTH Number is Required."); }
}
