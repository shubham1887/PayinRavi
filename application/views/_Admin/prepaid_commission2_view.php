<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Group Commission</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
   <script language="javascript">
	  	function getData()
		{
		if(document.getElementById("ddlgroup").value != 0)
		{
				$.ajax({
				url:'<?php echo base_url(); ?>_Admin/groupapi/getresult?groupid='+document.getElementById("ddlgroup").value,
				method:'POST',
				cache:false,
				success:function(msg)
				{
					document.getElementById("ajxdata").style.display = "block";
					document.getElementById("ajaxload").style.display = "none";
					document.getElementById("ajxdata").innerHTML = msg;
				}
			
			
			});
		}
		else
		{
			document.getElementById("ajxdata").innerHTML = "";
		}
		}
		function changeapi(i)
		{
			var apiid= document.getElementById("ddlapi"+i).value;
			var groupid= document.getElementById("uid").value;
			$.ajax({
  				url: '<?php echo base_url(); ?>_Admin/groupapi/changeapi?company_id='+i+'&api_id='+apiid+'&group_id='+groupid,
				  type: 'POST',
				  success:function(html)
				  {
					getData();
				  },
				  complate:function(msg)
				  {
					getData();
				  }
				});
        
		}
		function changeall()
        {
            var ids = document.getElementById("hidcompany_ids").value;
           
            var struserarr = ids.split(",");
            for(i=0;i<struserarr.length;i++)
        	{
        		var id = struserarr[i];
        		changecommission(id);
        	}
        }
		function changecommission(id)
		{
		var com = document.getElementById("txtComm"+id).value;
		var mincom = document.getElementById("txtMinCom"+id).value;
		var maxcom = document.getElementById("txtMaxCom"+id).value;
		var comtype = document.getElementById("ddlcommission_type"+id).value;
		
		document.getElementById("ajaxprocess").style.display = "block";
		
		
			
			
		document.getElementById("modelmp_failure_msg_BDEL").innerHTML ="";
		document.getElementById("modelmp_success_msg_BDEL").innerHTML ="";
		document.getElementById("responsespansuccess_BDEL").style.display = "none";
		document.getElementById("responsespanfailure_BDEL").style.display = "none";	
			
		if(com.length >= 1 || comAmt.length >= 1)
		{
		
		$.ajax({
  url: '<?php echo base_url(); ?>_Admin/groupapi/changecommission?groupid='+document.getElementById("ddlgroup").value+'&com='+com+'&company_id='+id+'&mincom='+mincom+'&maxcom='+maxcom+'&comtype='+comtype,
  type: 'POST',
  success:function(html)
  {
  	document.getElementById("ajaxprocess").style.display = "none";
  	getData();
	  
	  
	  
	if(html == "OK")
	{
		document.getElementById("modelmp_success_msg_BDEL").innerHTML ="Commission Updated Successfully";
		document.getElementById("responsespansuccess_BDEL").style.display = "block";
		$('#myMessgeModal').modal({show:true});
	}
	else
	{
		document.getElementById("modelmp_failure_msg_BDEL").innerHTML =html;
		document.getElementById("responsespanfailure_BDEL").style.display = "block";
		$('#myMessgeModal').modal({show:true});
	}
  },
  complate:function(msg)
  {
  	document.getElementById("ajaxprocess").style.display = "none";
  	getData();
  }
});
        }
		}
	  </script>










<!--------------- vast web files start --------------------------->





 <link href="<?php echo base_url(); ?>vfiles/css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>vfiles/icon" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>vfiles/font-awesome.min.css">
    <!-- Wait Me Css -->
    <link href="<?php echo base_url(); ?>vfiles/waitMe.css" rel="stylesheet">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>vfiles/bootstrap.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    
    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>vfiles/animate.css" rel="stylesheet">
    <!-- Morris Chart Css-->
    <link href="<?php echo base_url(); ?>vfiles/morris.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>vfiles/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/icofont.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-select.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>vfiles/all-themes.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/dataTables.bootstrap.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>vfiles/jquery.timepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/daterangepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>vfiles/Dashcustom.css" rel="stylesheet">
    <!-- fullbodycolor css -->
    <link href="<?php echo base_url(); ?>vfiles/globalallcss.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>vfiles/jquery-1.10.2.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery.validate.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery.validate.unobtrusive.min.js.download"></script>

    <script src="<?php echo base_url(); ?>vfiles/jquery.unobtrusive-ajax.min.js.download"></script>











<!------------------------ vast web files end here --------------------->



  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Settings</a>
          <span class="breadcrumb-item active">Group Commission Settings</span>
        </nav>
      </div><!-- br-pageheader -->
      
      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
             
              <div >
                 
                
<!------------ code start ------------------------------------------------------------------------->






<script src="<?php echo base_url(); ?>vfiles/jquery-1.10.2.min.js.download"></script>
<script src="<?php echo base_url(); ?>vfiles/jquery.validate.min.js.download"></script>
<script src="<?php echo base_url(); ?>vfiles/jquery.validate.unobtrusive.min.js.download"></script>
<style>
    .table.dataTable thead th, table.dataTable thead td {
        padding: 8px 4px 6px 4px;
    }

    .table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px 4px 6px 4px;
    }

    .dropdown-menu {
        margin-top: 81px !important;
    }

    .dataTables_wrapper .dt-buttons a.dt-button {
        padding: 7px 10px 8px 8px;
    }

    .bootstrap-select.btn-group:not(.input-group-btn), .bootstrap-select.btn-group[class*="col-"] {
        height: 20px;
    }

    #div_Loader {
        background: rgba(0, 0, 0, 0.6) none repeat scroll 0 0;
        height: 100%;
        position: absolute;
        top: 0;
        width: 100%;
        z-index: 999999;
    }


    .ldio-gs56nt525f > div {
        transform-origin: 100px 100px;
        animation: ldio-gs56nt525f 0.2s infinite linear;
    }

        .ldio-gs56nt525f > div div {
            position: absolute;
            width: 22px;
            height: 152px;
            background: var(--main-bg-lcolor);
            left: 100px;
            top: 100px;
            transform: translate(-50%,-50%);
        }

            .ldio-gs56nt525f > div div:nth-child(1) {
                width: 120px;
                height: 120px;
                border-radius: 50%;
            }

            .ldio-gs56nt525f > div div:nth-child(6) {
                width: 80px;
                height: 80px;
                background: #fff;
                border-radius: 50%;
            }

            .ldio-gs56nt525f > div div:nth-child(3) {
                transform: translate(-50%,-50%) rotate(45deg)
            }

            .ldio-gs56nt525f > div div:nth-child(4) {
                transform: translate(-50%,-50%) rotate(90deg)
            }

            .ldio-gs56nt525f > div div:nth-child(5) {
                transform: translate(-50%,-50%) rotate(135deg)
            }

    .loadingio-spinner-gear-94vo528ab8 {
        width: 200px;
        height: 200px;
        display: inline-block;
        overflow: hidden;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
    }

    .ldio-gs56nt525f {
        width: 100%;
        height: 100%;
        position: relative;
        transform: translateZ(0) scale(1);
        backface-visibility: hidden;
        transform-origin: 0 0; /* see note above */
    }

        .ldio-gs56nt525f div {
            box-sizing: content-box;
        }
           .select2-container--default .select2-selection--single {
        border: 1px solid #bbb !important;
        border-radius: 0px !important;
        height: 38px !important;background-color: #f5f5f5 !important;
       
    }
           .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:36px !important;}
           .select2-container--default .select2-selection--single .select2-selection__arrow{height:36px !important;}

    @keyframes ldio-gs56nt525f {
        0% {
            transform: rotate(0deg)
        }

        50% {
            transform: rotate(22.5deg)
        }

        100% {
            transform: rotate(45deg)
        }
    }
</style>

<section class="">
    <div class="container-fluid">
        
        <div class="row clearfix">
            <div class="col-md-12">
                





<div id="custnav" class="col-md-2 slab-first-tab">
    <h2>Category's</h2>
    <ul class="nav nav-tabs">
        <li class="active"><a class="active" href="<?php echo base_url(); ?>_Admin/Prepaid_commission">Prepaid/DTH</a></li>
        <li><a href="<?php echo base_url(); ?>_Admin/PostpaidUtility_Slab_setting">Utilities</a></li>
        <li><a href="<?php echo base_url(); ?>_Admin/Money_Transfer_Slab_DMT2" style="margin-bottom:0px;">Financial</a></li>
        <li><a href="<?php echo base_url(); ?>_Admin/Flight_Slab" style="margin-bottom:0px;">Travel &amp; Hotel</a></li>
        <li><a href="<?php echo base_url(); ?>_Admin/Giftcard_Slab_setting">Gift Card</a></li>
        <li><a href="<?php echo base_url(); ?>_Admin/Security_Slab_setting">Security</a></li>
        <li><a href="<?php echo base_url(); ?>vfiles/Prepaid_commission">eCommerce</a></li>
        <li><a href="<?php echo base_url(); ?>vfiles/Prepaid_commission">Service&nbsp;&amp;&nbsp;Repair</a></li>
        <li><a href="<?php echo base_url(); ?>vfiles/Prepaid_commission">Others</a></li>
    </ul>
</div>
<script>
    $(document).ready(function () {
        var current = location.pathname;
            current = current.replace("M_Poss", "Money_Transfer_Slab_DMT2");
            current = current.replace("AepsSlab", "Money_Transfer_Slab_DMT2");
            current = current.replace("Pancard_Slab_Setting", "Money_Transfer_Slab_DMT2");
            current = current.replace("BUS_Slab", "Flight_Slab");
            current = current.replace("Hotel_Slab", "Flight_Slab");
            $('#custnav ul li a').each(function () {
            var $this = $(this);
            if ($this.attr('href').indexOf(current) !== -1) {
                $this.parent().addClass('active');
            }
        })
    });
</script>
                



                <div class="col-md-10 slab-first-tab-content">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">


                                <div class="header " style="padding:0px;border-bottom:0px;">
                                    <div class="row">
                                        <div class="col-md-12 all-slab-header">
                                            <a href="<?php echo base_url(); ?>_Admin/Prepaid_commission" id="Comm" class="btn bg-blue-grey waves-effect fullbodydycolorbg">Common Slab<p>For New Users</p></a><button type="button" id="Mdbtn" class="btn bg-blue-grey waves-effect" onclick="editUserWise(&#39;Master&#39;, &#39;EditFormUserWise&#39;)">MD Slab<p>Exsiting Users</p></button>

                                            <button type="button" id="Dlmbtn" class="btn bg-blue-grey waves-effect" onclick="editUserWise(&#39;Dealer&#39;, &#39;EditFormUserWise&#39;)">Distributor Slab<p>Exsiting Users</p></button>

                                            <button type="button" id="Rembtn" class="btn bg-blue-grey waves-effect" onclick="editUserWise(&#39;Retailer&#39;, &#39;EditFormUserWise&#39;)">Retailer Slab<p>Exsiting Users</p></button>

                                            <button type="button" id="Apibtn" class="btn bg-blue-grey waves-effect" onclick="editUserWise(&#39;API&#39;, &#39;EditFormUserWise&#39;)">API user Slab<p>Exsiting Users</p></button>

                                            <button type="button" id="Whitebtn" class="btn bg-blue-grey waves-effect" onclick="editUserWise(&#39;Whitelabel&#39;, &#39;EditFormUserWise&#39;)">White Label Slab<p>Exsiting Users</p></button>

                                            <button id="btnEdit" type="button" class="btn  waves-effect" style="margin-left:22px;" onclick="funcEdit(this, &#39;EditFormComm&#39;)"> <img src="<?php echo base_url(); ?>vfiles/edit.svg" style="width:13px;">&nbsp;Edit Slab</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <div id="divEditFormComm" class="slab-edit-table table-responsive " style="position:inherit;">
<form action="<?php echo base_url(); ?>_Admin/Prepaid_commission/UpdateGroupCommission" data-ajax="true" data-ajax-method="POST" data-ajax-mode="replace" data-ajax-success="OnSuccess" data-ajax-update="#divEditFormComm" id="form0" method="post" novalidate="novalidate">    

  <input id="btnsubmit" type="submit" value="Save Now" class="btn  waves-effect" style="display:none;">
    <div class="slab-table">
        <table id="updatecolm" class="table table-bordered" style="margin-top: 15px;">
            <thead class="" style="position:initial;">
                <tr>
                    <th>Operator&nbsp;Name</th>
                    <th>Master&nbsp;(M/D)&nbsp;%</th>
                    <th>Distributor&nbsp;%</th>
                    <th>Retailer&nbsp;%</th>
                    
                    <th>API&nbsp;%</th>
                    <th>White Label&nbsp;%</th>
                </tr>
            </thead>
            <tbody id="tbodyshow">

              <?php 
                $rsltgroupapi = $this->db->query("select 
                  a.company_id,a.company_name ,
                  IFNULL(b.RetailerComm,0.00) as  RetailerComm,
                  IFNULL(b.DistComm,0.00) as  DistComm,
                  IFNULL(b.MdComm,0.00) as  MdComm,
                  IFNULL(b.WLComm,0.00) as  WLComm,
                  IFNULL(b.ApiComm,0.00) as  ApiComm
                from tblcompany a 
                left join tblgroupapi b on a.company_id = b.company_id 
                where 
                a.service_id = 1 or a.service_id = 2");
                foreach($rsltgroupapi->result() as $rwoptr)
                {?>


                    <tr>
                        <td><?php echo $rwoptr->company_name; ?></td>
                        <td><?php echo $rwoptr->MdComm; ?></td>
                        <td><?php echo $rwoptr->DistComm; ?></td>
                        <td><?php echo $rwoptr->RetailerComm; ?></td>
                        <td><?php echo $rwoptr->ApiComm; ?></td>
                        <td><?php echo $rwoptr->WLComm; ?></td>
                    </tr>

                <?php }
              ?>

                    
                 
            </tbody>
            <tbody id="tbodyedit" style="display:none;">


                <?php
                  foreach($rsltgroupapi->result() as $rwoptr)
                  {?>



                        <tr>
                          
                          <td>
                              <?php echo $rwoptr->company_name; ?>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field mastercomm must be a number." id="common_<?php echo $rwoptr->company_id; ?>__mastercomm" name="common[mastercomm][<?php echo $rwoptr->company_id; ?>]" style="width:100%" type="text" value="<?php echo $rwoptr->MdComm; ?>">
                              <span class="field-validation-valid" data-valmsg-for="common[mastercomm][<?php echo $rwoptr->company_id; ?>]" data-valmsg-replace="true"></span>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field dlmcomm must be a number." id="common_<?php echo $rwoptr->company_id; ?>__dlmcomm" name="common[distcomm][<?php echo $rwoptr->company_id; ?>] style="width:100%" type="text" value="<?php echo $rwoptr->DistComm; ?>">
                              <span class="field-validation-valid" data-valmsg-for="common[distcomm][<?php echo $rwoptr->company_id; ?>]" data-valmsg-replace="true"></span>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field dlm_rem_comm must be a number." id="common_<?php echo $rwoptr->company_id; ?>__dlm_rem_comm" name="common[retailercomm][<?php echo $rwoptr->company_id; ?>]" style="width:100%" type="text" value="<?php echo $rwoptr->RetailerComm; ?>">
                              <span class="field-validation-valid" data-valmsg-for="common[retailercomm][<?php echo $rwoptr->company_id; ?>]" data-valmsg-replace="true"></span>
                          </td>
                          
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field apicomm must be a number." id="common_<?php echo $rwoptr->company_id; ?>__apicomm" name="common[apicomm][<?php echo $rwoptr->company_id; ?>]" style="width:100%" type="text" value="<?php echo $rwoptr->ApiComm; ?>">
                              <span class="field-validation-valid" data-valmsg-for="common[apicomm][<?php echo $rwoptr->company_id; ?>]" data-valmsg-replace="true"></span>
                          </td>
                          <td>
                              <input class="text-box single-line" data-val="true" data-val-number="The field whitelabelcomm must be a number." id="common_<?php echo $rwoptr->company_id; ?>__whitelabelcomm" name="common[wlcomm][<?php echo $rwoptr->company_id; ?>]" style="width:100%" type="text" value="<?php echo $rwoptr->WLComm; ?>">
                              <span class="field-validation-valid" data-valmsg-for="common[wlcomm][<?php echo $rwoptr->company_id; ?>]" data-valmsg-replace="true"></span>
                          </td>
                      </tr>



                  <?php }
                 ?>
                
               
            </tbody>
        </table>
    </div>
</form>
                                        <script>
    function OnSuccess() {
        $('#btnsubmit').hide();
        $('#btnEdit').show();
    }
</script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="div_Loader" style="display:none;">
    <div class="loadingio-spinner-gear-94vo528ab8">
        <div class="ldio-gs56nt525f">
            <div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
    </div>
</div>


<script>
    var FormId = "";
    var roleshow = "";

    function funcEdit(event, frmId) {
        var val = $('#ddlUserId').val();
         var ddldlm = $('#ddldealer').val();
        var ddlrem = $('#ddlUserIdrem').val();
        $('#btnsubmit').show();
        $('#btnsubmituser').show();
        if (val == "") {
            $('#btnsubmitusercommon').show();
        }
        if (roleshow == "Retailer" && ddldlm != "" && ddlrem=="") {
            $('#btnsubmitusercommondlmrem').show();
        }
        $('#btnEdit').hide();
        //alert();
        $('#tbodyshow').hide();
        $('#tbodyedit').show();
        if (FormId == "")//Use in Default Slab edit
        {
            FormId = frmId;
        }
        var ddlVal = $('#ddlUserId').val();
        if (ddlVal != null && ddlVal == '')//Update ALL
        {
            $('#tbodyeditAll').show();
            $('#tbodyedit').hide();
        }
         if (ddlVal != null && ddlVal != '')//Update ALL
         {
            $('#tbodyeditAll').hide();
            $('#tbodyedit').show();
         }
         var Retailerval = $('#Retailerid').val();
         if (Retailerval != null && Retailerval == '')//Update ALL
         {
             $('#tbodyeditAll').show();
             $('#tbodyedit').hide();
         }
         if (Retailerval != null && Retailerval != '')//Update ALL
         {
             $('#tbodyeditAll').hide();
             $('#tbodyedit').show();
        }

    }
    function funcSave() {
        //$("#"+FormId+"").on("submit", function (event) { });
        alert("her");
        $("#" + FormId + "").submit();
    }

    function editUserWise(userRole, frmId) {
        roleshow = userRole;
        $('#div_Loader').show();
        $('#btnsubmit').hide();
        $('#btnsubmituser').hide();
        $('#btnsubmitusercommon').hide();
        $('#btnEdit').show();
        //alert(userRole);
        var url = '/_Admin/Prepaid_commission/UserPrepaidSlab';
        $.post(url, { role: userRole }, function (data) {
        $('#div_Loader').hide();
            $("#divEditFormComm").html(data);
            FormId = frmId;
            $("#role").val(userRole);
            if (userRole == "Retailer") {
                $('#retailerdrop').show();
                $('#allshow').hide();
        }
        else {
                $('#retailerdrop').hide();
                $('#allshow').show();
        }
        })
            .fail(function (xhr, status, error) {
                  $('#div_Loader').hide();
             //  $('#divLoader').hide();
              alert("error");
              //var err = eval("(" + xhr.responseText + ")");
              //alert(err.Message);
              console.log(xhr.responseText);
          })
          .always(function () {
          });
        if(userRole=="Master")
        {
            $("#Mdbtn").removeClass("btn bg-blue-grey waves-effect").addClass("btn bg-grey waves-effect fullbodydycolorbg");
            $("#Dlmbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Rembtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Apibtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Whitebtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Comm").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            document.getElementById("Retailerdropdow").style.display = "none";
        }
        if (userRole == "Dealer") {
            $("#Dlmbtn").removeClass("btn bg-blue-grey waves-effect").addClass("btn bg-grey waves-effect fullbodydycolorbg");
            $("#Mdbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Rembtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Apibtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Whitebtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Comm").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            document.getElementById("Retailerdropdow").style.display = "none";
        }
        if (userRole == "Retailer") {
            $("#Rembtn").removeClass("btn bg-blue-grey waves-effect").addClass("btn bg-grey waves-effect fullbodydycolorbg");
            $("#Mdbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Dlmbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Apibtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Whitebtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Comm").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Retailerdropdow").show();
           //var  x = $("#ddlUserId");
           // x.options[x.selectedIndex].text = "Select Dealer";
        }
        if (userRole == "API") {
            $("#Apibtn").removeClass("btn bg-blue-grey waves-effect").addClass("btn bg-grey waves-effect fullbodydycolorbg");
            $("#Mdbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Dlmbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Rembtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Whitebtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Comm").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            document.getElementById("Retailerdropdow").style.display = "none";
        }
        if (userRole == "Whitelabel") {
            $("#Whitebtn").removeClass("btn bg-blue-grey waves-effect").addClass("btn bg-grey waves-effect fullbodydycolorbg");
            $("#Mdbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Dlmbtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Rembtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Apibtn").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            $("#Comm").removeClass("btn bg-grey waves-effect fullbodydycolorbg").addClass("btn bg-blue-grey waves-effect");
            document.getElementById("Retailerdropdow").style.display = "none";
        }
    }
    function ddlUserIdChange() {
        var ddlVal = $('#ddlUserId').val();
        var role = $("#role").val();
        $('#btnsubmit').hide();
        $('#btnsubmituser').hide();
         $('#btnsubmitusercommon').hide();
        $('#btnEdit').show();
        var url = '/_Admin/Prepaid_commission/UserPrepaidSlab';
        $.post(url, { role: role, userid: ddlVal}, function (data) {
            $("#divEditFormComm").html(data);
        })
          .fail(function (xhr, status, error) {
              console.log(xhr.responseText);
          })
          .always(function () {
          });
    }
    function ddlUserIdChangerem() {
        var dlmid = $('#ddldealer').val();
        var ddlVal = $('#ddlUserIdrem').val();
        var role = $("#role").val();
        $('#btnsubmit').hide();
        $('#btnsubmituser').hide();
         $('#btnsubmitusercommon').hide();
        $('#btnEdit').show();
        var url = '/_Admin/Prepaid_commission/UserPrepaidSlab';
        $.post(url, { role: role, userid: ddlVal,dlmid: dlmid }, function (data) {
            $("#divEditFormComm").html(data);
            $('#retailerdrop').show();
            $('#allshow').hide();
        })
          .fail(function (xhr, status, error) {
              console.log(xhr.responseText);
          })
          .always(function () {
          });
    }
    //Indivual Retailer Wise
    function ddlRetailerIdChange() {
        $('#btnsubmit').hide();
        $('#btnsubmituser').hide();
        $('#btnsubmitusercommon').hide();
        $('#btnEdit').show();
        var ddlVal = $('#ddlUserId').val();

        var role = $("#role").val();
        //alert(ddlVal);
        var url = '/_Admin/Prepaid_commission/UserPrepaidSlab';
        $.post(url, { role: role, userid: ddlVal }, function (data) {
            $("#divEditFormComm").html(data);
        })
          .fail(function (xhr, status, error) {
              console.log(xhr.responseText);
          })
          .always(function () {
          });
    }
    function ddlretailerid() {
                 var dlmid = $('#ddldealer').val();
        var role = $("#role").val();
        $('#btnsubmit').hide();
        $('#btnsubmituser').hide();
         $('#btnsubmitusercommon').hide();
        $('#btnEdit').show();
        var url = '/_Admin/Prepaid_commission/UserPrepaidSlab';
        $.post(url, { role: role, dlmid: dlmid }, function (data) {
            $("#divEditFormComm").html(data);
            $('#retailerdrop').show();
            $('#allshow').hide();
        })
          .fail(function (xhr, status, error) {
              console.log(xhr.responseText);
          })
          .always(function () {
          });
    }
</script>
<!--Window Load-->
<script>
    window.onload = function () {
        $("#Comm").removeClass("btn bg-blue-grey waves-effect").addClass("btn bg-grey waves-effect");
    }
</script>




    <script>
    function getbalance(apinm) {
        var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i>';
        $('#' + apinm).html(loadingText);
             $.ajax({
             type: 'POST',
             url: '/ADMIN/getapibal',
                 data: { apinm: apinm},
                 success: function (data) {
                     $('#' + apinm).text("₹ "+ data);
                }
            });
        }
    </script>

    <!--   All Tabs -->
    <script type="text/javascript">
        $(document).ready(function () {

            $('ul.tabs li').click(function () {
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            })

        })
    </script>

    <!------------------QR------------------------>

    <script>
        function scannpay() {
            $('#genrateamt').val("")
            $('#genrateupi').show();
            $('#showqr').hide();
            $('.genrateupi-right').show();
            $('#website_show').hide();
            $('#ssl_show').hide();
            $('#Email_show').hide();
            $('#Sms_show').hide();
            $('#Upi_show').hide();
            $('#White_show').hide();
            $('#Mpos_show').hide();
            $('#Microatm_show').hide();
            $('#scan_show').show();
        }
        function genrateQR() {

            var amt = $('#genrateamt').val();
            if (amt != "") {

                  $.ajax({
                type: "GET",
                      url: '/ADMIN/FindQR',
                      data: { amount: amt},
                cache: false,
                success: function (data) {
                    $('#qrcode').attr("src", data);
                    $('#showqr').show();
                    $('.genrateupi-right').hide();
                    $('#genrateamt').attr('disabled', 'disabled')
                }
            });
            }
            else {
                $('#scan-input-required').html('Please Enter Purchse Amount')
                setTimeout(() => ($('#scan-input-required').html('')),5000)
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $(".genrateupi-right").click(function () {
                $("").removeClass("active");
                $(".genrateupi-left").addClass("active");
            });
        });
    </script>
    <!----------------Auto Fund-------------------->
    <script>
        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: '/ADMIN/websitepaymentAuto',
                cache: false,
                success: function (data) {
                }
            });
        });
    </script>
    <!---------------Auto Staus---------------->
    <script>
        function autostscheck() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/changeAuto',
                cache: false,
                success: function (data) {
                    if (data == false) {
                        $("#autowebcheck").addClass("custom-off");
                        $("#autowebcheck").removeClass("costom-on");
                    }
                    else {
                        $("#autowebcheck").addClass("costom-on");
                        $("#autowebcheck").removeClass("custom-off");
                    }
                }
            })
        }
    </script>
    <!-----------  Website---------------->

    <script>
           function showdayleftinfo() {
              $.ajax({
                type: "GET",
                url: '/ADMIN/websitemonthly',
                cache: false,
                  success: function (data) {
                       $('.lblotherpayment').text('')
                       $('.comfirsmclasscss').show();
                      var diff = data.duedate.diff;
                      var afterdate = data.duedate.showin

                      var gst = (data.Firstmonth.amount)*18/100
                      var gst1 = (data.SecondMonth.amount)*18/100
                      var gst2 = (data.ThirdMonth.amount) * 18 / 100

                      $('#duedatetxt').val(data.duedate.duedate);
                      if (data.autostschk.autosts == false) {
                          $("#autowebcheck").addClass("custom-off");
                          $("#autowebcheck").removeClass("costom-on");
                      }
                      else {
                          $("#autowebcheck").addClass("costom-on");
                          $("#autowebcheck").removeClass("custom-off");
                      }

                      if (diff < 5) {
                          $('#webpayment').show();
                          $('#webpaymentnotallow').hide();
                          $('#txtwebmsg').text("");


                          var total = parseFloat((data.Firstmonth.amount)) + parseFloat(gst);
                          var total1 = parseFloat((data.SecondMonth.amount)) + parseFloat(gst1);
                          var total2 = parseFloat((data.ThirdMonth.amount)) + parseFloat(gst2);

                          $('#website1').text(data.Firstmonth.amount);
                          $('#website2').text(data.SecondMonth.amount);
                          $('#website3').text(data.ThirdMonth.amount);

                          $('#qramt1').text(data.Firstmonth.amount);
                          $('#qramt2').text(data.SecondMonth.amount);
                          $('#qramt3').text(data.ThirdMonth.amount);

                          $('#qrgst1').text(gst);
                          $('#qrgst2').text(gst1);
                          $('#qrgst3').text(gst2);

                          $('#qrtotal1').text(total);
                          $('#qrtotal2').text(total1);
                          $('#qrtotal3').text(total2);


                      }
                      else {
                          $('#webpayment').hide();
                          $('#webpaymentnotallow').show();
                          $('#txtwebmsg').text("Payment Option Not Enable Now. Please Try After  " + afterdate);
                      }
                      $('#website_show').show();
                      $('#ssl_show').hide();
                      $('#Email_show').hide();
                      $('#Sms_show').hide();
                      $('#Upi_show').hide();
                      $('#White_show').hide();
                      $('#Mpos_show').hide();
                      $('#Microatm_show').hide();
                      $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclickweb1() {
            var val = $('#websitecheck').is(":checked");

            if (val == false) {
                var value1 = $('#qramt1').text();
                $('#qrgst1').text(0);
                $('#qrtotal1').text(value1);
            }
            else {
                var value1 = $('#qramt1').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#qrgst1').text(gst);
                $('#qrtotal1').text(total);
            }
            $('#website1qr').show();
            $('#website2qr').hide();
            $('#website3qr').hide();
            $('.first-form').hide();
        }
        function onclickweb2() {

            var val = $('#websitecheck').is(":checked");

            if (val == false) {
                var value1 = $('#qramt2').text();
                $('#qrgst2').text(0);
                $('#qrtotal2').text(value1);
            }
            else {
                var value1 = $('#qramt2').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#qrgst2').text(gst);
                $('#qrtotal2').text(total);
            }


            $('#website2qr').show();
            $('#website1qr').hide();
            $('#website3qr').hide();
            $('.first-form').hide();
        }
        function onclickweb3() {

            var val = $('#websitecheck').is(":checked");

            if (val == false) {
                var value1 = $('#qramt3').text();
                $('#qrgst3').text(0);
                $('#qrtotal3').text(value1);
            }
            else {
                var value1 = $('#qramt3').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#qrgst3').text(gst);
                $('#qrtotal3').text(total); 
            }

            $('#website3qr').show();
            $('#website1qr').hide();
            $('#website2qr').hide();
            $('.first-form').hide();
        }
        $(".first-form-close-button").click(function () {
            $('.first-form').show();
            $('#website3qr').hide();
            $('#website1qr').hide();
            $('#website2qr').hide();
        })
        $(".first-form-close").click(function () {
            $('.first-form-on').hide();
            $('.first-form').show();
        })
        $(".second-form-close").click(function () {
            $('.second-form-on').hide();
            $('.second-form').show();
        })
    </script>
    <script>
        function websitepayment(val) {
            var gststs = $('#websitecheck').is(":checked");

            $.ajax({
               
                type: "GET",
                url: '/ADMIN/websitepayment',
                data: { month: val, gststs: gststs },
                cache: false,
                success: function (data) {
                    $('.comfirsmclasscss').hide();
                    //---------hide confirm
                  //  alert(data);
                    if (data.includes("Low") || data.includes("Not Enable")) {
                        //------------show failed
                        $('.payment-faild').show();
                       
                        var msg = data;
                        if (msg == "Low") {
                            msg = "Your Remain Balance is Low";
                        }
                        $('.faild').text(msg);
                        //Failed
                    }
                    else {
                        //-------show success
                        $('.payment-sucess').show();
                        var msg ="Your Next Due Date is "+ data;
                        
                        $('.sucess').text(msg);
                        //success
                    }
                   // location.reload();
                }
            });
        }
    </script>

    <!------------Website-------------------->
    <!---------------SSL--------------------->
    <script>
          function ssldatashow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/sslpricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                  $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;
                    var duedate = data.duedate;

                    var gst = parseFloat(firstprice) * 18 / 100
                    var gst1 = parseFloat(Secondprice) * 18 / 100
                    var gst2 = parseFloat(thirdprice) * 18 / 100

                    var total = parseFloat(firstprice) + parseFloat(gst);
                    var total1 = parseFloat(Secondprice) + parseFloat(gst1);
                    var total2 = parseFloat(thirdprice) + parseFloat(gst2);

                    $('#sslduedatetxt').val(duedate);
                    $('#1stsslprice').text(firstprice);
                    $('#2ndsslprice').text(Secondprice);
                    $('#3rdsslprice').text(thirdprice);

                    $('#sslamt1').text(firstprice);
                    $('#sslamt2').text(Secondprice);
                    $('#sslamt3').text(thirdprice);

                    $('#sslt1').text(data.First.t1);
                    $('#sslt2').text(data.Second.t2);
                    $('#sslt3').text(data.Third.t3);

                    $('#sslgstamt1').text(gst);
                    $('#sslgstamt2').text(gst1);
                    $('#sslgstamt3').text(gst2);

                    $('#ssltotalamt1').text(total);
                    $('#ssltotalamt2').text(total1);
                    $('#ssltotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').show();
                    $('#Email_show').hide();
                    $('#Sms_show').hide();
                    $('#Upi_show').hide();
                    $('#White_show').hide();
                    $('#Mpos_show').hide();
                    $('#Microatm_show').hide();
                    $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclickssl1() {
            var val = $('#sslcheck').is(":checked");

            if (val == false) {
                var value1 = $('#sslamt1').text();
                $('#sslgstamt1').text(0);
                $('#ssltotalamt1').text(value1);
            }
            else {
                var value1 = $('#sslamt1').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#sslgstamt1').text(gst);
                $('#ssltotalamt1').text(total);
            }
            $('#ssl1qr').show();
            $('#ssl2qr').hide();
            $('#ssl3qr').hide();
            $('.second-form').hide();
        }
        function onclickssl2() {
            var val = $('#sslcheck').is(":checked");

            if (val == false) {
                var value1 = $('#sslamt2').text();
                $('#sslgstamt2').text(0);
                $('#ssltotalamt2').text(value1);
            }
            else {
                var value1 = $('#sslamt2').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#sslgstamt2').text(gst);
                $('#ssltotalamt2').text(total);
            }
            $('#ssl1qr').hide();
            $('#ssl2qr').show();
            $('#ssl3qr').hide();
            $('.second-form').hide();
        }
        function onclickssl3() {
            var val = $('#sslcheck').is(":checked");

            if (val == false) {
                var value1 = $('#sslamt3').text();
                $('#sslgstamt3').text(0);
                $('#ssltotalamt3').text(value1);
            }
            else {
                var value1 = $('#sslamt3').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#sslgstamt3').text(gst);
                $('#ssltotalamt3').text(total);
            }
            $('#ssl1qr').hide();
            $('#ssl2qr').hide();
            $('#ssl3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#ssl1qr').hide();
            $('#ssl2qr').hide();
            $('#ssl3qr').hide();
        })
    </script>

    <!----------------SSL--------------------->
    <!----------------EMAIL------------------->
    <script>
        function emailShow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/emailpricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                    $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;
                    var duedate = data.duedate;
                    var gst = parseFloat(firstprice) * 18 / 100
                    var gst1 = parseFloat(Secondprice) * 18 / 100
                    var gst2 = parseFloat(thirdprice) * 18 / 100

                    var total = parseFloat(firstprice) + parseFloat(gst);
                    var total1 = parseFloat(Secondprice) + parseFloat(gst1);
                    var total2 = parseFloat(thirdprice) + parseFloat(gst2);
                    $('#emailduedatetxt').val(duedate);
                    $('#1stemailprice').text(firstprice);
                    $('#2ndemailprice').text(Secondprice);
                    $('#3rdemailprice').text(thirdprice);

                    $('#emailamt1').text(firstprice);
                    $('#emailamt2').text(Secondprice);
                    $('#emailamt3').text(thirdprice);

                    $('#emailt1').text(data.First.t1);
                    $('#emailt2').text(data.Second.t2);
                    $('#emailt3').text(data.Third.t3);

                    $('#emailgstamt1').text(gst);
                    $('#emailgstamt2').text(gst1);
                    $('#emailgstamt3').text(gst2);

                    $('#emailtotalamt1').text(total);
                    $('#emailtotalamt2').text(total1);
                    $('#emailtotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').hide();
                    $('#Email_show').show();
                    $('#Sms_show').hide();
                    $('#Upi_show').hide();
                    $('#White_show').hide();
                    $('#Mpos_show').hide();
                    $('#Microatm_show').hide();
                    $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclickemail1() {
            var val = $('#emailcheck').is(":checked");

            if (val == false) {
                var value1 = $('#emailamt1').text();
                $('#emailgstamt1').text(0);
                $('#emailtotalamt1').text(value1);
            }
            else {
                var value1 = $('#emailamt1').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#emailgstamt1').text(gst);
                $('#emailtotalamt1').text(total);
            }
            $('#email1qr').show();
            $('#email2qr').hide();
            $('#email3qr').hide();
            $('.second-form').hide();
        }
        function onclickemail2() {
            var val = $('#emailcheck').is(":checked");

            if (val == false) {
                var value1 = $('#emailamt2').text();
                $('#emailgstamt2').text(0);
                $('#emailtotalamt2').text(value1);
            }
            else {
                var value1 = $('#emailamt2').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#emailgstamt2').text(gst);
                $('#emailtotalamt2').text(total);
            }
            $('#email1qr').hide();
            $('#email2qr').show();
            $('#email3qr').hide();
            $('.second-form').hide();
        }
        function onclickemail3() {
            var val = $('#emailcheck').is(":checked");

            if (val == false) {
                var value1 = $('#emailamt3').text();
                $('#emailgstamt3').text(0);
                $('#emailtotalamt3').text(value1);
            }
            else {
                var value1 = $('#emailamt3').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#emailgstamt3').text(gst);
                $('#emailtotalamt3').text(total);
            }
            $('#email1qr').hide();
            $('#email2qr').hide();
            $('#email3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#email1qr').hide();
            $('#email2qr').hide();
            $('#email3qr').hide();
        })
    </script>

    <!----------------EMAIL------------------>
    <!----------------SMS-------------------->
    <script>
        function smsShow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/smspricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                     $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;
                    var duedate = data.duedate;
                    $('#smsduedatetxt').val(duedate);
                    var totalsms1 = data.First.t1;
                    var totalsms2 = data.Second.t2;
                    var totalsms3 = data.Third.t3;

                    var totalprice1 = (parseFloat(firstprice) * parseFloat(totalsms1)).toFixed(2);
                    var totalprice2 = parseFloat(Secondprice) * parseFloat(totalsms2).toFixed(2);
                    var totalprice3 = parseFloat(thirdprice) * parseFloat(totalsms3).toFixed(2);


                    var gst = parseFloat(parseFloat(totalprice1) * 18 / 100).toFixed(2);
                    var gst1 = parseFloat(parseFloat(totalprice2) * 18 / 100).toFixed(2);
                    var gst2 = parseFloat(parseFloat(totalprice3) * 18 / 100).toFixed(2);

                    var total = parseFloat(totalprice1) + parseFloat(gst);
                    var total1 = parseFloat(totalprice2) + parseFloat(gst1);
                    var total2 = parseFloat(totalprice3) + parseFloat(gst2);

                    $('#1stsmsprice').text(firstprice);
                    $('#2ndsmsprice').text(Secondprice);
                    $('#3rdsmsprice').text(thirdprice);

                    $('#1stsmspricet1').text(totalprice1);
                    $('#2ndsmspricet2').text(totalprice2);
                    $('#3rdsmspricet3').text(totalprice3);

                    $('#smsamt1').text(totalprice1);
                    $('#smsamt2').text(totalprice2);
                    $('#smsamt3').text(totalprice3);

                    $('#smst1').text(data.First.t1);
                    $('#smst2').text(data.Second.t2);
                    $('#smst3').text(data.Third.t3);

                    $('#smsgstamt1').text(gst);
                    $('#smsgstamt2').text(gst1);
                    $('#smsgstamt3').text(gst2);

                    $('#smstotalamt1').text(total);
                    $('#smstotalamt2').text(total1);
                    $('#smstotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').hide();
                    $('#Email_show').hide();
                    $('#Sms_show').show();
                    $('#Upi_show').hide();
                    $('#White_show').hide();
                    $('#Mpos_show').hide();
                    $('#Microatm_show').hide();
                    $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclicksms1() {
            var val = $('#smscheck').is(":checked");

            if (val == false) {
                var value1 = $('#1stsmspricet1').text();
                $('#smsgstamt1').text(0);
                $('#smstotalamt1').text(value1);
            }
            else {
                var value1 = $('#1stsmspricet1').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#smsgstamt1').text(gst);
                $('#smstotalamt1').text(total);
            }
            $('#sms1qr').show();
            $('#sms2qr').hide();
            $('#sms3qr').hide();
            $('.second-form').hide();
        }
        function onclicksms2() {
            var val = $('#smscheck').is(":checked");

            if (val == false) {
                var value1 = $('#2ndsmspricet2').text();
                $('#smsgstamt2').text(0);
                $('#smstotalamt2').text(value1);
            }
            else {
                var value1 = $('#2ndsmspricet2').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#smsgstamt2').text(gst);
                $('#smstotalamt2').text(total);
            }
            $('#sms1qr').hide();
            $('#sms2qr').show();
            $('#sms3qr').hide();
            $('.second-form').hide();
        }
        function onclicksms3() {
            var val = $('#smscheck').is(":checked");

            if (val == false) {
                var value1 = $('#3rdsmspricet3').text();
                $('#smsgstamt3').text(0);
                $('#smstotalamt3').text(value1);
            }
            else {
                var value1 = $('#3rdsmspricet3').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#smsgstamt3').text(gst);
                $('#smstotalamt3').text(total);
            }
            $('#sms1qr').hide();
            $('#sms2qr').hide();
            $('#sms3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#sms1qr').hide();
            $('#sms2qr').hide();
            $('#sms3qr').hide();
        })
    </script>


    <!----------------SMS------------------>
    <!----------------UPI------------------->
    <script>
        function upiShow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/upipricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                      $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;
                    var duedate = data.duedate;
                    $('#upiduedatetxt').val(duedate);
                    var gst = parseFloat(firstprice) * 18 / 100
                    var gst1 = parseFloat(Secondprice) * 18 / 100
                    var gst2 = parseFloat(thirdprice) * 18 / 100

                    var total = parseFloat(firstprice) + parseFloat(gst);
                    var total1 = parseFloat(Secondprice) + parseFloat(gst1);
                    var total2 = parseFloat(thirdprice) + parseFloat(gst2);

                    $('#1stupiprice').text(firstprice);
                    $('#2ndupiprice').text(Secondprice);
                    $('#3rdupiprice').text(thirdprice);

                    $('#upiamt1').text(firstprice);
                    $('#upiamt2').text(Secondprice);
                    $('#upiamt3').text(thirdprice);

                    $('#upit1').text(data.First.t1);
                    $('#upit2').text(data.Second.t2);
                    $('#upit3').text(data.Third.t3);

                    $('#upigstamt1').text(gst);
                    $('#upigstamt2').text(gst1);
                    $('#upigstamt3').text(gst2);

                    $('#upitotalamt1').text(total);
                    $('#upitotalamt2').text(total1);
                    $('#upitotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').hide();
                    $('#Email_show').hide();
                    $('#Sms_show').hide();
                    $('#Upi_show').show();
                    $('#White_show').hide();
                    $('#Mpos_show').hide();
                    $('#Microatm_show').hide();
                    $('#scan_show').hide();
                  
                }
            });
        }
    </script>
    <script>
        function onclickupi1() {
            var val = $('#upicheck').is(":checked");

            if (val == false) {
                var value1 = $('#upiamt1').text();
                $('#upigstamt1').text(0);
                $('#upitotalamt1').text(value1);
            }
            else {
                var value1 = $('#upiamt1').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#upigstamt1').text(gst);
                $('#upitotalamt1').text(total);
            }
            $('#upi1qr').show();
            $('#upi2qr').hide();
            $('#upi3qr').hide();
            $('.second-form').hide();
        }
        function onclickupi2() {
            var val = $('#upicheck').is(":checked");

            if (val == false) {
                var value1 = $('#upiamt2').text();
                $('#upigstamt2').text(0);
                $('#upitotalamt2').text(value1);
            }
            else {
                var value1 = $('#upiamt2').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#upigstamt2').text(gst);
                $('#upitotalamt2').text(total);
            }
            $('#upi1qr').hide();
            $('#upi2qr').show();
            $('#upi3qr').hide();
            $('.second-form').hide();
        }
        function onclickupi3() {
            var val = $('#upicheck').is(":checked");

            if (val == false) {
                var value1 = $('#upiamt3').text();
                $('#upigstamt3').text(0);
                $('#upitotalamt3').text(value1);
            }
            else {
                var value1 = $('#upiamt3').text();
                var gst = parseFloat(value1) * 18 / 100;
                var total = parseFloat(value1) + parseFloat(gst);
                $('#upigstamt3').text(gst);
                $('#upitotalamt3').text(total);
            }
            $('#upi1qr').hide();
            $('#upi2qr').hide();
            $('#upi3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#upi1qr').hide();
            $('#upi2qr').hide();
            $('#upi3qr').hide();
        })
    </script>

    <!----------------UPI------------------>
    <!----------------Whitelabel-------------------->
    <script>
        function whiteShow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/whitepricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                    $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;

                    var totalsms1 = data.First.t1;
                    var totalsms2 = data.Second.t2;
                    var totalsms3 = data.Third.t3;

                    var totalprice1 = (parseFloat(firstprice) * parseFloat(totalsms1)).toFixed(2);
                    var totalprice2 = parseFloat(Secondprice) * parseFloat(totalsms2).toFixed(2);
                    var totalprice3 = parseFloat(thirdprice) * parseFloat(totalsms3).toFixed(2);


                    var gst = parseFloat(parseFloat(totalprice1) * 18 / 100).toFixed(2);
                    var gst1 = parseFloat(parseFloat(totalprice2) * 18 / 100).toFixed(2);
                    var gst2 = parseFloat(parseFloat(totalprice3) * 18 / 100).toFixed(2);

                    var total = parseFloat(totalprice1) + parseFloat(gst);
                    var total1 = parseFloat(totalprice2) + parseFloat(gst1);
                    var total2 = parseFloat(totalprice3) + parseFloat(gst2);

                    $('#1stwhiteprice').text(firstprice);
                    $('#2ndwhiteprice').text(Secondprice);
                    $('#3rdwhiteprice').text(thirdprice);

                    $('#1stwhitepricet1').text(totalprice1);
                    $('#2ndwhitepricet2').text(totalprice2);
                    $('#3rdwhitepricet3').text(totalprice3);

                    $('#whiteamt1').text(totalprice1);
                    $('#whiteamt2').text(totalprice2);
                    $('#whiteamt3').text(totalprice3);

                    $('#whitet1').text(data.First.t1);
                    $('#whitet2').text(data.Second.t2);
                    $('#whitet3').text(data.Third.t3);

                    $('#whitegstamt1').text(gst);
                    $('#whitegstamt2').text(gst1);
                    $('#whitegstamt3').text(gst2);

                    $('#whitetotalamt1').text(total);
                    $('#whitetotalamt2').text(total1);
                    $('#whitetotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').hide();
                    $('#Email_show').hide();
                    $('#Sms_show').hide();
                    $('#Upi_show').hide();
                    $('#White_show').show();
                    $('#Mpos_show').hide();
                    $('#Microatm_show').hide();
                    $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclickwhite1() {
            var val = $('#whitecheck').is(":checked");

            if (val == false) {
                var value1 = $('#1stwhitepricet1').text();
                $('#whitegstamt1').text(0);
                $('#whitetotalamt1').text(value1);
            }
            else {
                var value1 = $('#1stwhitepricet1').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#whitegstamt1').text(gst);
                $('#whitetotalamt1').text(total);
            }
            $('#white1qr').show();
            $('#white2qr').hide();
            $('#white3qr').hide();
            $('.second-form').hide();
        }
        function onclickwhite2() {
            var val = $('#whitecheck').is(":checked");

            if (val == false) {
                var value1 = $('#2ndwhitepricet2').text();
                $('#whitegstamt2').text(0);
                $('#whitetotalamt2').text(value1);
            }
            else {
                var value1 = $('#2ndwhitepricet2').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#whitegstamt2').text(gst);
                $('#whitetotalamt2').text(total);
            }
            $('#white1qr').hide();
            $('#white2qr').show();
            $('#white3qr').hide();
            $('.second-form').hide();
        }
        function onclickwhite3() {
            var val = $('#whitecheck').is(":checked");

            if (val == false) {
                var value1 = $('#3rdwhitepricet3').text();
                $('#whitegstamt3').text(0);
                $('#whitetotalamt3').text(value1);
            }
            else {
                var value1 = $('#3rdwhitepricet3').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#whitegstamt3').text(gst);
                $('#whitetotalamt3').text(total);
            }
            $('#white1qr').hide();
            $('#white2qr').hide();
            $('#white3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#white1qr').hide();
            $('#white2qr').hide();
            $('#white3qr').hide();
        })
    </script>


    <!----------------Whitelabel------------------>
    <!----------------Mpos-------------------->
    <script>
        function mposShow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/mpospricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                    $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;

                    var totalsms1 = data.First.t1;
                    var totalsms2 = data.Second.t2;
                    var totalsms3 = data.Third.t3;

                    var totalprice1 = (parseFloat(firstprice) * parseFloat(totalsms1)).toFixed(2);
                    var totalprice2 = parseFloat(Secondprice) * parseFloat(totalsms2).toFixed(2);
                    var totalprice3 = parseFloat(thirdprice) * parseFloat(totalsms3).toFixed(2);


                    var gst = parseFloat(parseFloat(totalprice1) * 18 / 100).toFixed(2);
                    var gst1 = parseFloat(parseFloat(totalprice2) * 18 / 100).toFixed(2);
                    var gst2 = parseFloat(parseFloat(totalprice3) * 18 / 100).toFixed(2);

                    var total = parseFloat(totalprice1) + parseFloat(gst);
                    var total1 = parseFloat(totalprice2) + parseFloat(gst1);
                    var total2 = parseFloat(totalprice3) + parseFloat(gst2);

                    $('#1stmposprice').text(firstprice);
                    $('#2ndmposprice').text(Secondprice);
                    $('#3rdmposprice').text(thirdprice);

                    $('#1stmpospricet1').text(totalprice1);
                    $('#2ndmpospricet2').text(totalprice2);
                    $('#3rdmpospricet3').text(totalprice3);

                    $('#mposamt1').text(totalprice1);
                    $('#mposamt2').text(totalprice2);
                    $('#mposamt3').text(totalprice3);

                    $('#mpost1').text(data.First.t1);
                    $('#mpost2').text(data.Second.t2);
                    $('#mpost3').text(data.Third.t3);

                    $('#mposgstamt1').text(gst);
                    $('#mposgstamt2').text(gst1);
                    $('#mposgstamt3').text(gst2);

                    $('#mpostotalamt1').text(total);
                    $('#mpostotalamt2').text(total1);
                    $('#mpostotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').hide();
                    $('#Email_show').hide();
                    $('#Sms_show').hide();
                    $('#Upi_show').hide();
                    $('#White_show').hide();
                    $('#Mpos_show').show();
                    $('#Microatm_show').hide();
                    $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclickmpos1() {
            var val = $('#mposcheck').is(":checked");

            if (val == false) {
                var value1 = $('#1stmpospricet1').text();
                $('#mposgstamt1').text(0);
                $('#mpostotalamt1').text(value1);
            }
            else {
                var value1 = $('#1stmpospricet1').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#mposgstamt1').text(gst);
                $('#mpostotalamt1').text(total);
            }
            $('#mpos1qr').show();
            $('#mpos2qr').hide();
            $('#mpos3qr').hide();
            $('.second-form').hide();
        }
        function onclickmpos2() {
            var val = $('#mposcheck').is(":checked");

            if (val == false) {
                var value1 = $('#2ndmpospricet2').text();
                $('#mposgstamt2').text(0);
                $('#mpostotalamt2').text(value1);
            }
            else {
                var value1 = $('#2ndmpospricet2').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#mposgstamt2').text(gst);
                $('#mpostotalamt2').text(total);
            }
            $('#mpos1qr').hide();
            $('#mpos2qr').show();
            $('#mpos3qr').hide();
            $('.second-form').hide();
        }
        function onclickmpos3() {
            var val = $('#mposcheck').is(":checked");

            if (val == false) {
                var value1 = $('#3rdmpospricet3').text();
                $('#mposgstamt3').text(0);
                $('#mpostotalamt3').text(value1);
            }
            else {
                var value1 = $('#3rdmpospricet3').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#mposgstamt3').text(gst);
                $('#mpostotalamt3').text(total);
            }
            $('#mpos1qr').hide();
            $('#mpos2qr').hide();
            $('#mpos3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#mpos1qr').hide();
            $('#mpos2qr').hide();
            $('#mpos3qr').hide();
        })
    </script>


    <!----------------Mpos------------------>
    <!----------------Micro ATM-------------------->
    <script>
        function microatmShow() {
            $.ajax({
                type: "GET",
                url: '/ADMIN/microatmpricelist',
                cache: false,
                success: function (data) {
                     $('.lblotherpayment').text('')
                    $('.comfirsmclasscss').show();
                    var firstprice = data.First.p1;
                    var Secondprice = data.Second.p2;
                    var thirdprice = data.Third.p3;

                    var totalsms1 = data.First.t1;
                    var totalsms2 = data.Second.t2;
                    var totalsms3 = data.Third.t3;

                    var totalprice1 = (parseFloat(firstprice) * parseFloat(totalsms1)).toFixed(2);
                    var totalprice2 = parseFloat(Secondprice) * parseFloat(totalsms2).toFixed(2);
                    var totalprice3 = parseFloat(thirdprice) * parseFloat(totalsms3).toFixed(2);


                    var gst = parseFloat(parseFloat(totalprice1) * 18 / 100).toFixed(2);
                    var gst1 = parseFloat(parseFloat(totalprice2) * 18 / 100).toFixed(2);
                    var gst2 = parseFloat(parseFloat(totalprice3) * 18 / 100).toFixed(2);

                    var total = parseFloat(totalprice1) + parseFloat(gst);
                    var total1 = parseFloat(totalprice2) + parseFloat(gst1);
                    var total2 = parseFloat(totalprice3) + parseFloat(gst2);

                    $('#1stmicroatmprice').text(firstprice);
                    $('#2ndmicroatmprice').text(Secondprice);
                    $('#3rdmicroatmprice').text(thirdprice);

                    $('#1stmicroatmpricet1').text(totalprice1);
                    $('#2ndmicroatmpricet2').text(totalprice2);
                    $('#3rdmicroatmpricet3').text(totalprice3);

                    $('#microatmamt1').text(totalprice1);
                    $('#microatmamt2').text(totalprice2);
                    $('#microatmamt3').text(totalprice3);

                    $('#microatmt1').text(data.First.t1);
                    $('#microatmt2').text(data.Second.t2);
                    $('#microatmt3').text(data.Third.t3);

                    $('#microatmgstamt1').text(gst);
                    $('#microatmgstamt2').text(gst1);
                    $('#microatmgstamt3').text(gst2);

                    $('#microatmtotalamt1').text(total);
                    $('#microatmtotalamt2').text(total1);
                    $('#microatmtotalamt3').text(total2);


                    $('#website_show').hide();
                    $('#ssl_show').hide();
                    $('#Email_show').hide();
                    $('#Sms_show').hide();
                    $('#Upi_show').hide();
                    $('#White_show').hide();
                    $('#Mpos_show').hide();
                    $('#Microatm_show').show();
                    $('#scan_show').hide();
                }
            });
        }
    </script>
    <script>
        function onclickmicroatm1() {
            var val = $('#microatmcheck').is(":checked");

            if (val == false) {
                var value1 = $('#1stmicroatmpricet1').text();
                $('#microatmgstamt1').text(0);
                $('#microatmtotalamt1').text(value1);
            }
            else {
                var value1 = $('#1stmicroatmpricet1').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#microatmgstamt1').text(gst);
                $('#microatmtotalamt1').text(total);
            }
            $('#microatm1qr').show();
            $('#microatm2qr').hide();
            $('#microatm3qr').hide();
            $('.second-form').hide();
        }
        function onclickmicroatm2() {
            var val = $('#microatmcheck').is(":checked");

            if (val == false) {
                var value1 = $('#2ndmicroatmpricet2').text();
                $('#microatmgstamt2').text(0);
                $('#microatmtotalamt2').text(value1);
            }
            else {
                var value1 = $('#2ndmicroatmpricet2').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#microatmgstamt2').text(gst);
                $('#microatmtotalamt2').text(total);
            }
            $('#microatm1qr').hide();
            $('#microatm2qr').show();
            $('#microatm3qr').hide();
            $('.second-form').hide();
        }
        function onclickmicroatm3() {
            var val = $('#microatmcheck').is(":checked");

            if (val == false) {
                var value1 = $('#3rdmicroatmpricet3').text();
                $('#microatmgstamt3').text(0);
                $('#microatmtotalamt3').text(value1);
            }
            else {
                var value1 = $('#3rdmicroatmpricet3').text();
                var gst = (parseFloat(value1) * 18 / 100).toFixed(2);
                var total = parseFloat(value1) + parseFloat(gst);
                $('#microatmgstamt3').text(gst);
                $('#microatmtotalamt3').text(total);
            }
            $('#microatm1qr').hide();
            $('#microatm2qr').hide();
            $('#microatm3qr').show();
            $('.second-form').hide();
        }
        $(".second-form-close-button").click(function () {
            $('.second-form').show();
            $('#microatm1qr').hide();
            $('#microatm2qr').hide();
            $('#microatm3qr').hide();
        })
    </script>


    <!----------------Mpos------------------>
    <!----------------Other payment------------------->
    <script>
        function otherpayment(servicenm, qu) {
            $('.lblotherpayment').text('')
           
            
            var quantity = ""; var gststs = true;
            if (servicenm == "SSL") {
                gststs = $('#sslcheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#sslt1').text();
                }
                else if (qu == "2") {
                    quantity = $('#sslt2').text();
                }
                else if (qu == "3") {
                    quantity = $('#sslt3').text();
                }
            }
            else if (servicenm == "EMAIL") {
                gststs = $('#emailcheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#emailt1').text();
                }
                else if (qu == "2") {
                    quantity = $('#emailt2').text();
                }
                else if (qu == "3") {
                    quantity = $('#emailt3').text();
                }
            }
            else if (servicenm == "SMS") {
                gststs = $('#smscheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#smst1').text();
                }
                else if (qu == "2") {
                    quantity = $('#smst2').text();
                }
                else if (qu == "3") {
                    quantity = $('#smst3').text();
                }
            }
            else if (servicenm == "UPI") {
                gststs = $('#upicheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#upit1').text();
                }
                else if (qu == "2") {
                    quantity = $('#upit2').text();
                }
                else if (qu == "3") {
                    quantity = $('#upit3').text();
                }
            }
            else if (servicenm == "MPOS") {
                gststs = $('#mposcheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#mpost1').text();
                }
                else if (qu == "2") {
                    quantity = $('#mpost2').text();
                }
                else if (qu == "3") {
                    quantity = $('#mpost3').text();
                }
            }
            else if (servicenm == "MICROATM") {
                gststs = $('#microatmcheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#microatmt1').text();
                }
                else if (qu == "2") {
                    quantity = $('#microatmt2').text();
                }
                else if (qu == "3") {
                    quantity = $('#microatmt3').text();
                }
            }
            else if (servicenm == "WHITELABEL") {
                gststs = $('#whitecheck').is(":checked");
                if (qu == "1") {
                    quantity = $('#whitet1').text();
                }
                else if (qu == "2") {
                    quantity = $('#whitet2').text();
                }
                else if (qu == "3") {
                    quantity = $('#whitet3').text();
                }
            }

            $('.lblotherpayment').text('safsdgdfgdfgd')
            $('.comfirsmclasscss').hide();
            $.ajax({
             type: 'POST',
             url: '/ADMIN/OtherPayments',
                data: { service: servicenm, quant: quantity, gststs: gststs},
                 success: function (data) {
                    // alert(data);
                     // location.reload();
                     $('.lblotherpayment').text(data)
                }
            });

        }
    </script>
    <!----------------Other payment------------------->

    <script type="text/javascript">
        $(document).ready(function () {

            $('ul.tabs2 li').click(function () {
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs2 li').removeClass('current2');
                $('.tab-content2').removeClass('current2');

                $(this).addClass('current2');
                $("#" + tab_id).addClass('current2');
            })

        })
    </script>
    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/datatablejquery.js.download"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>vfiles/bootstrap.js.download"></script>
    <!-- Autosize Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/autosize.js.download"></script>
    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.slimscroll.js.download"></script>
    <!-- Waves Effect Plugin Js -->
    
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.countTo.js.download"></script>
    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/raphael.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/morris.js.download"></script>
    <!-- ChartJs -->
    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.flot.js.download"></script>

    <!-- Sparkline Chart Plugin Js -->
    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>vfiles/admin.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/index.js.download"></script>
    <!-- Demo Js -->
    <script src="<?php echo base_url(); ?>vfiles/demo.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/moment.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/daterangepicker.js.download"></script>
    <!--data table -->
    <script src="<?php echo base_url(); ?>vfiles/jquery.dataTables.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/dataTables.bootstrap.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/dataTables.buttons.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/buttons.flash.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jszip.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/pdfmake.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/vfs_fonts.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/buttons.html5.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/buttons.print.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery-datatable.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/jquery.timepicker.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/bootstrap-material-datetimepicker.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/sweetalert.min.js.download"></script>
    <link href="<?php echo base_url(); ?>vfiles/datatable.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>vfiles/basic-form-elements.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/bootstrap-datepicker.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/bootstrap-datetimepicker.min.js.download"></script>







    <!-- Push Nitification using SignalR-->
    <script src="<?php echo base_url(); ?>vfiles/jquery.signalR-2.4.0.min.js.download"></script>
    <script src="<?php echo base_url(); ?>vfiles/hubs"></script>
    <script type="text/javascript">
        window.onload = function () {
            var hub = $.connection.notificationHub;
            hub.client.broadcaastNotif = function (totalNotif) {
                console.log("Notif Data: " + totalNotif);
                console.log("total items : " + totalNotif.length);
                if (totalNotif.length > 0) {
                    $.each(totalNotif, function (i, obj) {
                        console.log("i : " + i);
                        console.log("Title : " + obj.Title);
                        console.log("Details : " + obj.Details);
                        console.log("DetailsURL : " + obj.DetailsURL);
                        customnotify(obj.Title, obj.Details, obj.DetailsURL, obj.Id);
                    });

                }
            };
            //$.connection.hub.start().done(function () { });
            $.connection.hub.start()
                .done(function () {
                    console.log("Hub Connected!");

                    //Server Call
                    hub.server.getNotification();

                })
                .fail(function () {
                    console.log("Could not Connect!");
                });
        };
    </script>



    <script>
    function SetAsReaded(idn,url)
    {
        var urlSiteName = 'maharshimulti.co.in';
        var setObj = { Id : idn};
        var Url = "https://www." + urlSiteName +"/api/Notification/UpdateReadProperty";
        $.ajax({
            type: "POST",
            url: Url,
            data: JSON.stringify(setObj),
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
            },
            error: function (xhr,err) {
                console.log("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
                console.log("responseText: " + xhr.responseText);
            }
        });
    }
    </script>



    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
    });
    function customnotify(title, desc, url, id) {
        if (Notification.permission !== "granted") {
           // alert("permission=granted");
            Notification.requestPermission();
        }
        else {
            //alert('');
            var notification = new Notification(title, {
                icon: '',
                body: desc,
            });

            /* Remove the notification from Notification Center when clicked.*/
            notification.onclick = function () {
                //alert("Click");
                SetAsReaded(id, url);
                notification.close();
            };
            ///* Callback function when the notification is closed. */
            notification.onclose = function () {
                SetAsReaded(id, url);
                notification.close();
                console.log('Notification closed');
            };
        }
    }
    </script>

    <!-- Push Nitification using SignalR END-->
    <!--Check Live Balance admin-->
    <!--get credit balance-->
    

    <!--Transfer Total Balance Admin All Users-->
    


    <!--Read All PushNotification-->

    <script>
        var currentRelUrl = window.location.pathname;
        var navNode = $("#leftsidebar .hhu li a[href$='" + currentRelUrl + "']").addClass("activee");


    </script>

    <script>
        window.onload = function () {
            $.ajax({
                type: "POST",
                url: '/ADMIN/timealert',
                cache: false,
                dataType: 'json',
                async: true,
                success: function (data) {
                }
            });
        };
    </script>



    <script>
    function ReadAllNoticationdata()
    {
        $.ajax({
            type: "POST",
            url: '/ADMIN/ReadAllNotification',
            cache: false,
            dataType: 'json',
            async: true,
            success: function (data) {
                var sts = data.Status;
                var message = data.Message;
                if(sts=="Success")
                {
                    

                  }
            }
        });
    }
    </script>


    <!--  Loder For 2 second-->
    
    <!--  Loder For 1 Second-->
    

    <!--  Loder For .5 Second -->
    

    <script>
        function apna(dienb) {
            var bt = document.getElementById('start_button');
            if (dienb.value != '') {
                bt.disabled = false;
            }
            else {
                bt.disabled = true;
            }
        }
    </script>
    <script>
        function manages(txts) {
            var bt = document.getElementById('btSubmits');
            if (txts.value != '') {
                bt.disabled = false;
            }
            else {
                bt.disabled = true;
            }
        }
    </script>
    <script>
        $(".global-class").css('background', 'pink');
    </script>



    <script type="text/javascript">
        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
    <!--  Disable Enable By Class Name  -->
    <script>
        $('.searchInput').keyup(function () {
            if ($(this).val() == '') {

                $('.enableOnInput').prop('disabled', true);
            } else {

                $('.enableOnInput').prop('disabled', false);
            }
        });
    </script>
    <script>

        $("#sidebar-open").click(function () {
            $("#leftsidebar").toggle('1000');

        });

    </script>

    <script>
        $(".more-info-one").click(function () {
            $('.first-form').hide();
            $('.first-form-on').show();
        })

        $(".more-info-second").click(function () {
            $('.second-form').hide();
            $('.second-form-on').show();
        })




        $(".third-form-close-button").click(function () {
            $('.third-form').show();
            $('.third-form-button').hide();
        })
        $(".form-bot-inner-third button").click(function () {
            $('.third-form').hide();
            $('.third-form-button').show();
        })

        $(".more-info-third").click(function () {
            $('.third-form').hide();
            $('.third-form-on').show();
        })
        $(".third-form-close").click(function () {
            $('.third-form').show();
            $('.third-form-on').hide();
        })
    </script>


    <script>
        $('.modalbutton-show button').on('click', function () {
            $(this).addClass('active').siblings().removeClass('active');
        });
    </script>





































<!-------------------------- code end here ----------------------------------------------------------------------------->


              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      
      </div><!-- br-pagebody -->
        
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>

    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>
