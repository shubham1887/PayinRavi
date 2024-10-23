BindState(); BindData();

jQuery(function () {
    jQuery('#StateName').change(function () 
        {
      
            var state = jQuery('#StateName').val(); if (state !== '') BindCities(); 
        });

    //jQuery('#StatesName').change(function () { var state = jQuery('#StatesName').val(); if (state !== '') BindCities(); });

    jQuery('#BankName').change(function () { var bkName = jQuery('#BankName').val(); if (bkName !== '') jQuery('#IFSCCode').val(bkName); });

    //jQuery('#BanksName').change(function () { var bkName = jQuery('#BanksName').val(); if (bkName !== '') jQuery('#IFSCCode').val(bkName); });

    jQuery('#UserType').change(function () { var usrtyp = jQuery('#UserType').val(); if (usrtyp !== '') BindingPtrs(); });

    jQuery('#PinCode').change(function () { var usrzip = jQuery('#PinCode').val(); if (usrzip !== '' && usrzip.length === 6) BindZipData(); });
});

function fillcityddl()
{
    var state = jQuery('#StateName').val();
    jQuery.ajax({
        url: '/Master/State/BindCity',
        type: 'POST',
        cache:false,
        data: { 'state':state} ,
        success: function (response) {
            var textHtml = '<option value="">Select</option>';
            if (response !== '') {
                jQuery.each(response, function () { textHtml += '<option value="'+this.city_id+'">' + this.city_name + '</option>'; });
            }
            jQuery('#CityName').html(textHtml);
        }, error: function (response) {
          //  alert('Something went wrong, try later.'); 
            //location.reload();
        }, async: true
    });
}
function BindState() {
    jQuery.ajax({
        url: '/Master/State/BindState',
        type: 'POST',
        success: function (response) {
            var textHtml = '<option value="">Select</option>';
            if (response !== '') {
                jQuery.each(response, function () { textHtml += '<option value="'+this.state_id+'">' + this.state_name + '</option>'; });
            }
            jQuery('#StateName').html(textHtml);
        }, error: function (response) {
          //  alert('Something went wrong, try later.'); 
            //location.reload();
        }, async: true
    });
}

function BindCities() 
{
    var stateNm = jQuery('#StateName').val(); stateNm === '' ? stateNm = jQuery('#StatesName').val() : stateNm;
    jQuery.ajax({
        url: '/Master/State/BindCities',
        type: 'POST',
        cache: false,
        contentType: "application/json;",
        data: "{ 'state': '" + stateNm + "'}",
        success: function (response) {
            var textHtml = '<option value="">Select</option>';
            if (response !== '') {
                jQuery.each(response, function () { textHtml += '<option>' + this + '</option>'; });
                jQuery('#CityName').html(textHtml);
            }
        }, error: function (response) {
            //alert('Something went wrong, try later.'); 
            //location.reload();
        }, async: true
    });
}

function BindData() {
    jQuery.ajax({
        url: '/Master/State/BindBanks',
        type: 'POST',
        success: function (response) {
            var textHtml = '<option value="">Select</option>';
            if (response !== '') {
                jQuery.each(response, function () { textHtml += '<option value="' + this.Ifsc + '">' + this.BankName + '</option>'; });
            }
            jQuery('#BankName').html(textHtml);
        }, error: function (response) {
           // alert('Something went wrong, try later.'); 
            //location.reload();
        }, async: true
    });
}

function BindingPtrs() {
    var usrtyp = jQuery('#UserType').val();
    jQuery.ajax({
        url: '/AddUser/BindingptrData',
        type: 'POST',
        cache: false,
        contentType: "application/json;",
        data: "{ 'type': '" + usrtyp + "'}",
        success: function (response) {
            var textHtml = '<option value="">Select</option>';
            if (response.StatusCode === 1) {
                jQuery.each(response.Data, function () { textHtml += '<option value="' + this.PatternID + '">' + this.Name + '</option>'; });
            } else {
                swal('', response.Message, 'error');
            }
            jQuery('#Pattern').html(textHtml);
        }, error: function (response) {
           // alert('Something went wrong, try later.'); 
            //location.reload();
        }, async: true
    });
}

function BindZipData() {
    var usrzip = jQuery('#PinCode').val();
    jQuery.ajax({
        url: '/AddUser/BindPinCodeData',
        type: 'POST',
        cache: false,
        contentType: "application/json;",
        data: "{ 'pinCode': '" + usrzip + "'}",
        success: function (response) {
            if (response.StatusCode === 1) {
                jQuery('#StateName').val(response.State);
                jQuery('#CityName').html('<option>' + response.City + '</option>');
                jQuery('.select2-selection').html('<span class="select2-selection__rendered" id="select2-StateName-container" role="textbox" aria-readonly="true" title="' + response.State + '">' + response.State+'</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>');
            } else {
                swal('', response.Message, 'error');
            }
        }, error: function (response) {
           // alert('Something went wrong, try later.'); 
            //location.reload();
        }, async: true
    });
}