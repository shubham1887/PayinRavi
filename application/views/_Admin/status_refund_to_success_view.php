<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>STATUS REFUND TO SUCCESS REPORT</title>

    
    
	<?php include("elements/linksheader.php"); ?>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 
    
     <script>
  function getdata()
  {
      document.getElementById("imageautoload").style.display = "block";
      $.ajax({
          
          
          url:document.getElementById("hidgetuserdataurl").value+"?text="+document.getElementById("ddluser").value,
          cache:false,
          type:'POST',
          success:function(data)
          {
            
              var data = data.split("^-^");
              var dataarr = data;
             
              $( "#ddluser" ).autocomplete({
                  
     
     source: function(request, response) {
        var results = $.ui.autocomplete.filter(dataarr, request.term);
        
        response(results.slice(0, 20));
    }
    });
          },
          complete:function()
          {
               document.getElementById("imageautoload").style.display = "none";
          }
          
      });
  }
  
  </script>
  
  <script language="javascript">
                function testhidstr(id)
                    {
                        	document.getElementById("tr_reqresp"+id).style.display = 'none';
                    }
					function tetingalert(id)
					{
					
        			document.getElementById("tr_reqresp"+id).style.display = 'none'
        		
		
        			$.ajax({
        				url:document.getElementById("hidgetlogurl").value+"?recharge_id="+id,
        				cache:false,
        				method:'POST',
        				success:function(data)
        				{
        				  
        					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
        					
        					var jsonobj = JSON.parse(data);
        					var msg = jsonobj.message;
        					var sts = jsonobj.status;
        					
        					if(sts == 0)
        					{
        						var request = jsonobj.request;
        						var response = jsonobj.response;
        						
        						document.getElementById("tr_reqresp"+id).style.display = 'table-row'
        			            
        						document.getElementById("tdreq"+id).innerHTML  = request;
        						document.getElementById("tdresp"+id).innerHTML  = response;
        						
        					}
        					
        						
        				},
        				error:function()
        				{
        				alert("error");
        				},
        				complete:function()
        				{
        				
        				}
        				});
					}
				</script>
     <script>
	
$(document).ready(function(){
document.getElementById("ddlstatus").value = '<?php echo $ddlstatus; ?>';
document.getElementById("ddloperator").value = '<?php echo $ddloperator; ?>';
document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
	
});
	
		 
		
function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		var db = document.getElementById("ddldb").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("hiddb").value = db;
		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
}
	
	</script>
<style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
</style>
<script type="text/javascript">
    
	function ActionSubmit(value,name)
	{
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			var isstatus;
			if(document.getElementById('action_'+value).value == "Success")
			{isstatus = 'Success';}
			else if(document.getElementById('action_'+value).value == "Failure")
			{isstatus='Failure';}
			else if(document.getElementById('action_'+value).value == "Pending")
			{isstatus='Pending';}
			
			if(confirm('Are you sure?\n you want to '+isstatus+' rechrge for - ['+name+']')){
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidrechargeid').value= value;	
				document.getElementById('hidid').value= "req to get";
							
				document.getElementById('frmCallAction').submit();
				}
		}
	}
	
</script>
<style>
.myselect {
  margin: 1px  !important; ;
  width: 70px  !important; ;
  padding: 1px 5px 1px 1px  !important; ;
  font-size: 12px  !important; ;
  border: 1px solid #ccc  !important; ;
  height: 24px  !important; ;
}
.retry
{
	background:#FBC6FB;
}
.dont
{
	background:#C0C0C0;
}
.manual
{
background:#C0C6C0;
}
</style>
<script language="javascript">
function viewhidelog()
{
	var flag = document.getElementById("btnviewlog").value;
	if(flag == "VIEW LOG")
	{
		document.getElementById("btnviewlog").value = "HIDE LOG";
		var str = document.getElementById("hisrecids").value;
		var strarr = str.split("#");
		for(i=0;i<strarr.length;i++)
		{
			tetingalert(strarr[i]);
		}
		
	}
	else
	{
			document.getElementById("btnviewlog").value = "VIEW LOG";
			var str = document.getElementById("hisrecids").value;
			var strarr = str.split("#");
			for(i=0;i<strarr.length;i++)
			{
				document.getElementById("tr_reqresp"+strarr[i]).style.display = 'none'
			}
			
	}
	
}
</script>
<style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}


.modal-ku {
  width: 950px;
  margin: auto;
}
</style>

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
          <a class="breadcrumb-item" href="#">REPORT</a>
          <span class="breadcrumb-item active">RECHARGE REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        
        <div class="col-sm-6 col-lg-12">
           
            
            
            <span class="breadcrumb-item active">
          	    <button class="btn btn-success btn-sm" type="button" style="font-size:14px;">Success : <?php echo $totalRecahrge; ?></button>
            </span>
           
              <span class="breadcrumb-item active">
              	<button class="btn btn-primary btn-sm" type="button" style="font-size:14px;">Pending : <?php echo $totalpRecahrge; ?></button>
              </span>
              <span class="breadcrumb-item active">
              	<button class="btn btn-danger btn-sm" type="button" style="font-size:14px;">Failure : <?php echo $totalfRecahrge; ?></button>
              </span>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-14 col-lg-14">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form action="<?php echo base_url()."_Admin/status_refund_to_success_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmsubmit" id="frmsubmit">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5>From Date</h5>
                                           <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <h5>To Date</h5>
                                            <input class="form-control-sm" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5><table><tr><td>USER </td><td><img id="imageautoload" src="<?php echo base_url()."ajax-loader.gif"; ?>" style="width:40px;display:none"></td></tr></table></h5>
                                            <input class="form-control-sm"  type="text" placeholder="type username" id="ddluser" name="ddluser" value="<?php echo $ddluser; ?>">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Status</h5>
                                           <select id="ddlstatus" name="ddlstatus" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            
                                           </select>
                                        </td>
                                         <td style="padding-right:10px;">
                                        	 <h5>API</h5>
                                           <select id="ddlapi" name="ddlapi" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <?php echo $this->Api_model->getApiListForRechargeDropdownList_whereapi_id_not_equelto(1,2,3);  ?>
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Operator</h5>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm" style="width:120px;">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltcompany = $this->db->query("select * from tblcompany order by company_name");
											foreach($rsltcompany->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->company_id; ?>"><?php echo $r->company_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        <td style="padding-right:10px">
                                        	 <h5>Re-root</h5>
                                           <select id="ddlreroot" name="ddlreroot" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                           
                                            <option value="yes">Re-Root</option>
                                           
                                           
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Number / Id</h5>
                                            <input class="form-control-sm" id="txtNumId" name="txtNumId" type="text" value="<?php echo $txtNumId; ?>" style="width:120px;" >
                                        </td>
										<td style="padding-right:10px;">
                                        	 <h5>Data</h5>
                                           <select id="ddldb" name="ddldb" class="form-control-sm" style="width: 120px;">
											   	<option value="LIVE">LIVE</option>
											   <option value="ARCHIVE">ARCHIVE</option>
											</select>
                                        </td>
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-sm" style="font-size:12px;">
                                        </td>
                                        <td valign="bottom">
                                       
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-sm" onClick="startexoprt()" style="font-size:12px;">
                                        </td>
                                      
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                    <form action="<?php echo base_url()."_Admin/status_refund_to_success_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidrechargeid" name="hidrechargeid" />
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
 </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-14 col-lg-14">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">RECHARGE REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <div id="pageing"><?php  echo $pagination; ?> </div>
                
    <table class="table is-narrow is-hoverable is-fullwidth" style="color:#000000;font-weight:normal;font-size:14px;overflow:hidden">
    <tr>  
    
    <th>Rec.Id</th>
  
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     <th >Change. Date</th>
     <th>Time</th>
     <th>Agent Name</th>
     <th>opcode</th>
	 <th>Mobile No</th>    
	 <th>Amt</th>  
	
	 <th>Status</th> 
	 <th>API</th>
	 <th>ApiLast<br>Balance</th>
	 <th></th>
	 
	 
    </tr>
    
    
    <?php $strrecid = "";$totalRecharge = 0;	$i = count($result_recharge->result());foreach($result_recharge->result() as $result) 	
	{
	    
	    
	    $recharge_by = $result->recharge_by;
	    $image = "WEB";
	    if($recharge_by == "GPRS")
	    {
	        $image = "APP";
	    }
	    if($recharge_by == "API")
	    {
	        $image = "API";
	    }
	    $commission_amount = "";
         $DComm = "";
         $MdComm = "";
         $MdComm = "";
         $AdminComm = 0;
	    $Profit = 0;
		if(isset($result->recharge_id)) 
		{
			$strrecid .=$result->recharge_id."#"; 
		}
		$retry =   $result->retry;
	?>
    	<?php
			if($retry == "yes")
			{?>
            	<tr class="retry" style="border-top: 1px solid #000;">
			<?php }
			else if($retry == "manual")
			{?>
            	<tr class="manual" style="border-top: 1px solid #000;">
			<?php }
			else
			{?>
            	<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
			<?php }
		 ?>
			
           
 <td>
     <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->recharge_id; ?>')">
         <?php echo $result->recharge_id; ?><br>
         <b><?php echo $image; ?></b>
         
         
         <input type="hidden" id="hidUsername<?php echo $result->recharge_id; ?>" value="<?php echo $result->businessname; ?>">
         <input type="hidden" id="hidCompany_name<?php echo $result->recharge_id; ?>" value="<?php echo $result->company_name; ?>">
         <input type="hidden" id="hidMobile_no<?php echo $result->recharge_id; ?>" value="<?php echo $result->mobile_no; ?>">
         <input type="hidden" id="hidAmount<?php echo $result->recharge_id; ?>" value="<?php echo $result->amount; ?>">
         <input type="hidden" id="hidOperatorId<?php echo $result->recharge_id; ?>" value="<?php echo str_replace('"',"",$result->operator_id); ?>">
         
         
    </a>
     </td>
 
  
  
  <td><?php echo $result->operator_id; ?></td>
  
  
  
 <td ><?php echo $this->common->change_date_format($result->add_date); ?></td>
 <td ><?php echo $this->common->change_date_format($result->status_change_date); ?></td>
 <td>
     <?php 
        if($result->update_time != "0000-00-00 00:00:00")
        {
            $recdatetime =date_format(date_create($result->add_date),'Y-m-d h:i:s');
            $cdate =date_format(date_create($result->update_time),'Y-m-d h:i:s');
            $now_date = strtotime (date ($cdate)); // the current date 
    		$key_date = strtotime (date ($recdatetime));
    		$diff = $now_date - $key_date;
    		echo $diff;
    		//echo  "<br>";    
        }
        
     //echo $result->update_time; 
     ?>
 </td>
 <!-- <td><?php echo $result->update_time; ?></td>-->
 <td style="width:120px;min-width:120px;font-weight:bold;color:#3366cc;font-size:16px;font-family:sans-serif"><?php echo $result->businessname; ?></td>
 <td><?php echo $result->company_name; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>

 <td id="tdstatus<?php echo $result->recharge_id; ?>">
 <?php 
 if($result->recharge_status == 'Pending'){echo "<span class='label btn-warning'>Pending</span>";}
 if($result->recharge_status == 'Success')
 {
     
     $commission_amount = $result->commission_amount;
     $DComm = $result->DComm;
     $MdComm = $result->MdComm;
     $AdminComm = $result->AdminComm;
     $flatcomm = $result->flat_commission;
     $Profit = ($AdminComm + $result->roffer) - ( $commission_amount +  $DComm + $MdComm + $flatcomm);
     
 	$totalRecharge += $result->amount;echo "<span class='label btn-success'>Success</span>";
 }
 if($result->recharge_status == 'Failure')
 {
	 if($result->edit_date == 3)
	 {
			echo "<span class='label btn-primary'>Reverse</span>"; 
	 }
	 else
	 {
		 echo "<span class='label btn-danger'>Failure</span>";
	 }
 	
 }
 
 
 ?></td>
 <td><?php echo $result->ExecuteBy;?></td>
<td><?php echo $result->lapubalance;?></td>
 
 <td>
     <a style="width:70px;max-width:70px;" href="javascript:void()" onClick="openrecactionmodel('<?php echo $result->recharge_id; ?>')" class="btn btn-primary btn-sm">Action</a>
     <a id="btnResponseLog" style="width:70px;max-width:70px;" href="javascript:void()" onClick="getreqresplog('<?php echo $result->recharge_id; ?>')" class="btn btn-warning btn-sm">Response</a>
     
 </td>
 
 
 </tr>
 <tr id="tr_reqresp<?php echo $result->recharge_id; ?>" style="display:none">
     <td>Request </td><td colspan="6" id="tdreq<?php echo $result->recharge_id; ?>"  style="word-break:break-all"></td>
     <td>Response</td> <td colspan="7" id="tdresp<?php echo $result->recharge_id; ?>" style="word-break:break-all" ></td>
      <td><a href="javascript:void(0)" onClick="testhidstr('<?php echo $result->recharge_id; ?>')" >Hide</a></td>
 </tr>
		<?php 	
		$i--;} ?>
        <tr style="background-color:#CCCCCC;">  
    
    <th></th>  
      <th></th>  
       <th > </th>
      <th > </th>
     <th  > </th>
     <th > </th>
      <th > </th>
     
	 <th >Total </th>    
	 <th ><?php echo $totalRecharge; ?></th>    
			  <th > </th>
   	 <th></th>  
   	 <th></th> 
   	 <th ></th>    
         
    </tr>
		</table> 
              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
        </div>
      </div><!-- br-pagebody -->
      <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getlogs"; ?>">
    <input type="hidden" id="hidgetuserdataurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
    
    <!-- Core Scripts - Include with every page -->
   <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/status_refund_to_success_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
<input type="hidden" id="hisrecids" value="<?php echo $strrecid;?>">                                    



<script language="javascript">
function openrecactionmodel(id)
{
  document.getElementById("spanpopupalertmessage").innerHTML="";
  document.getElementById("popupalertdiv").style.display="none";
    document.getElementById("hidRefId").value = id;
    document.getElementById("txtPopupActionUsername").innerHTML = document.getElementById("hidUsername"+id).value;
    document.getElementById("txtPopupActionOperator").innerHTML = document.getElementById("hidCompany_name"+id).value;
    document.getElementById("txtPopupActionMobileNumber").innerHTML = document.getElementById("hidMobile_no"+id).value;
    document.getElementById("txtPopupActionAmount").innerHTML = document.getElementById("hidAmount"+id).value;
   
    document.getElementById("txtactpopupopid").innerHTML = document.getElementById("hidOperatorId"+id).value;
    $('#myActionModal').modal({show:true});
}
</script>
<form id="frmrecaction" action="" method="post">
    
    <input type="hidden" id="hidRefId">
	<div class="modal fade" id="myActionModal" role="dialog">
    <div class="modal-dialog"  >
      <div class="modal-content" style="width:600px;">
        <div class="modal-header">
            <h4 class="modal-title" id="modalmptitle_BDEL">Action</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
        <div class="modal-body" style="background-color:#F2F2F2">
            <span id="spanloader" style="display:none">
              <img id="imgloading" src="<?php echo base_url()."Loading.gif"; ?>" style="width:80px">
            </span>
           
            <div class="alert alert-solid" role="alert" id="popupalertdiv" style="display:none"><!--  alert-success-->
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                 <div id="spanpopupalertmessage" style="word-break: break-all;"></div>
            </div>
            
          
          <div>
              
          		<table class="">
                <tr>
                	<td align="left"><label style="font-size:14px;color:#000;">Username :</label>
                        <span id="txtPopupActionUsername" name="txtPopupActionUsername" style="font-size:14;color:#2D2B2B;margin-left:5px;"></span>
                    </td>
                </tr>
                <tr>
                	<td align="left"><label style="font-size:14px;color:#000;">Operator :</label>
                	    <span id="txtPopupActionOperator" name="txtPopupActionOperator" style="font-size:14;color:#2D2B2B;margin-left:5px;"></span>
                    </td>
                </tr>
                <tr>
                	<td align="left"><label style="font-size:14px;color:#000;">Mobile Number :</label>
                	    <span id="txtPopupActionMobileNumber" name="txtPopupActionMobileNumber" style="font-size:14;color:#2D2B2B;margin-left:5px;"></span>
                    </td>
                </tr>
                <tr>
                	<td align="left"><label style="font-size:14px;color:#000;">Amount :</label>
                	    <span id="txtPopupActionAmount" name="txtPopupActionAmount" style="font-size:14;color:#2D2B2B;margin-left:5px;"></span>
                    </td>
                </tr>
                <tr>
                   
                    <td align="left"><label style="font-size:14px;color:#000;">Remarks or OperatorId or Transaction Id :</label>
                    <br>
                        <textarea id="txtactpopupopid" style="width:400px"></textarea>
                    </td>
                            
                </tr>
                <tr>
                	<td align="left"><label style="font-size:14px;color:#000;">Recharge Ip:</label>
                	    <span id="txtPopupActionRecIp" name="txtPopupActionRecIp" style="font-size:14;color:#2D2B2B;margin-left:5px;"></span>
                    </td>
                </tr>
                 <tr>
                	<td align="left"><label style="font-size:14px;color:#000;">Send To Another API:</label>
                	    <select id="ddlresendapi" name="ddlresendapi" class="select" style="font-size:14;color:#2D2B2B;margin-left:5px;width:120px;height:30px;" >
                	        <option value="0">select Api</option>
                	        <?php echo $this->Api_model->getApiListForDropdownList();?>
                	    </select>
                	    <input type="button" id="btnresendtootherpopup" value="Send" class="btn btn-primary btn-sm">
                    </td>
                </tr>
                
                
                </table>
                
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="btnRefund" name="btnRefund" class="btn btn-danger btn-sm"  value="Refund">Refund</button>
            <button type="button" id="btnStatus" name="btnStatus" class="btn btn-warning  btn-sm"  value="Status">Status</button>
            <button type="button" id="btnSuccess" name="btnSuccess" class="btn btn-primary  btn-sm"  value="Success">Success</button>
            <button type="button" id="btnResend" name="btnResend" class="btn btn-warning  btn-sm"  value="Resend">Resend</button>
           
        </div>
      
      </div>
    </div>
  </div>   
	  </form>
        <input type="hidden" id="hidrefundmethodurl" value="<?php echo base_url()."_Admin/list_recharge/dorefund"; ?>"> 
        <input type="hidden" id="hidstatusmethodurl" value="<?php echo base_url()."_Admin/list_recharge/checkstatus"; ?>"> 
        <input type="hidden" id="hidsuccessmethodurl" value="<?php echo base_url()."_Admin/list_recharge/dosuccess"; ?>"> 
        <input type="hidden" id="hidresendtoothermethodurl" value="<?php echo base_url()."_Admin/list_recharge/resendtoanotherapi"; ?>"> 
        
	  
	  
	   <script>

        $("#btnRefund").click( function()
           {
              
               $.ajax({
    					type:"POST",
    					url:document.getElementById("hidrefundmethodurl").value,
    					data:{'recharge_id':document.getElementById("hidRefId").value},
    					beforeSend: function() 
    					{
                
                document.getElementById("spanpopupalertmessage").innerHTML="";
    					   document.getElementById("popupalertdiv").style.display="none";
                           document.getElementById("spanloader").style.display="block";
                        },
    					success: function(response)
    					{
    					    //alert(response);
    					    document.getElementById("spanloader").style.display="none";
    					    document.getElementById("popupalertdiv").style.display="block";
    						var jsonobj = JSON.parse(response);
    						var msg = jsonobj.message;
    						var sts = jsonobj.status;
    						if(sts == "0")
    						{
    						    
    						    $("#popupalertdiv").addClass('alert-success');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;   
    						    document.getElementById("tdstatus"+id).innerHTML = "<span class='label btn-primary'>Reverse</span>";
    						}
    						else
    						{
    						     $("#popupalertdiv").addClass('alert-danger');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;
    						}
    						
    						 
    					
    						console.log(response);  
    					},
    					error:function(response)
    					{
    					    $("#popupalertdiv").addClass('alert-danger');
    					  document.getElementById("spanloader").style.display="none";
    					  document.getElementById("popupalertdiv").style.display="block";
    					  document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
    					},
    					complete:function()
    					{
    					    document.getElementById("popupalertdiv").style.display="block";
    					    document.getElementById("spanloader").style.display="none";
    						
    					}
    				});

									 
           }
        );
        
        $("#btnSuccess").click( function()
           {
              
               $.ajax({
    					type:"POST",
    					url:document.getElementById("hidsuccessmethodurl").value,
    					data:{'recharge_id':document.getElementById("hidRefId").value,'operator_id':document.getElementById("txtactpopupopid").value},
    					beforeSend: function() 
    					{
                 document.getElementById("spanpopupalertmessage").innerHTML="";
    					   document.getElementById("popupalertdiv").style.display="none";
                           document.getElementById("spanloader").style.display="block";
                        },
    					success: function(response)
    					{
    					    //alert(response);
    					    document.getElementById("spanloader").style.display="none";
    					    document.getElementById("popupalertdiv").style.display="block";
    						var jsonobj = JSON.parse(response);
    						var msg = jsonobj.message;
    						var sts = jsonobj.status;
    						if(sts == "0")
    						{
    						    
    						    $("#popupalertdiv").addClass('alert-success');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;   
    						    document.getElementById("tdstatus"+id).innerHTML = "<span class='label btn-success'>Success</span>";
    						}
    						else
    						{
    						     $("#popupalertdiv").addClass('alert-danger');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;
    						}
    						
    						 
    					
    						console.log(response);  
    					},
    					error:function(response)
    					{
    					    $("#popupalertdiv").addClass('alert-danger');
    					  document.getElementById("spanloader").style.display="none";
    					  document.getElementById("popupalertdiv").style.display="block";
    					  document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
    					},
    					complete:function()
    					{
    					    document.getElementById("popupalertdiv").style.display="block";
    					    document.getElementById("spanloader").style.display="none";
    						
    					}
    				});

									 
           }
        );
        $("#btnStatus").click( function()
           {
              
               $.ajax({
    					type:"POST",
    					url:document.getElementById("hidstatusmethodurl").value,
    					data:{'recharge_id':document.getElementById("hidRefId").value},
    					beforeSend: function() 
    					{
    					     document.getElementById("spanpopupalertmessage").innerHTML="";
    					   document.getElementById("popupalertdiv").style.display="none";
                           document.getElementById("spanloader").style.display="block";
                        },
    					success: function(response)
    					{
    					   //alert(response);
    					    document.getElementById("spanloader").style.display="none";
    					    document.getElementById("popupalertdiv").style.display="block";
    						var jsonobj = JSON.parse(response);
    						var msg = jsonobj.message;
    						var sts = jsonobj.status;
    						if(sts == "0")
    						{
    						    var statuscode = jsonobj.statuscode;
    						    if(statuscode == "Success")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-success');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    else if(statuscode == "Failure")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-danger');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    else if(statuscode == "Pending")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-primary');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    
    						}
    						else
    						{
    						     $("#popupalertdiv").addClass('alert-danger');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;
    						}
    						
    						 
    					
    						console.log(response);  
    					},
    					error:function(response)
    					{
    					    $("#popupalertdiv").addClass('alert-danger');
    					  document.getElementById("spanloader").style.display="none";
    					  document.getElementById("popupalertdiv").style.display="block";
    					  document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
    					},
    					complete:function()
    					{
    					    document.getElementById("popupalertdiv").style.display="block";
    					    document.getElementById("spanloader").style.display="none";
    						
    					}
    				});

									 
           }
        );
        
        
        $("#btnresendtootherpopup").click( function()
           {
              var api_id = document.getElementById("ddlresendapi").value;
              if(api_id > 0)
              {
                $.ajax({
    					type:"POST",
    					url:document.getElementById("hidresendtoothermethodurl").value,
    					data:{'recharge_id':document.getElementById("hidRefId").value,'api_id':api_id},
    					beforeSend: function() 
    					{
                 document.getElementById("spanpopupalertmessage").innerHTML="";
    					   document.getElementById("popupalertdiv").style.display="none";
                           document.getElementById("spanloader").style.display="block";
                        },
    					success: function(response)
    					{
    					   //alert(response);
    					    document.getElementById("spanloader").style.display="none";
    					    document.getElementById("popupalertdiv").style.display="block";
    						var jsonobj = JSON.parse(response);
    						var msg = jsonobj.message;
    						var sts = jsonobj.status;
    						if(sts == "0")
    						{
    						    var statuscode = jsonobj.statuscode;
    						    if(statuscode == "Success")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-success');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    else if(statuscode == "Failure")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-danger');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    else if(statuscode == "Pending")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-primary');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    
    						}
    						else
    						{
    						     $("#popupalertdiv").addClass('alert-danger');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;
    						}
    						
    						 
    					
    						console.log(response);  
    					},
    					error:function(response)
    					{
    					    $("#popupalertdiv").addClass('alert-danger');
    					  document.getElementById("spanloader").style.display="none";
    					  document.getElementById("popupalertdiv").style.display="block";
    					  document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
    					},
    					complete:function()
    					{
    					    document.getElementById("popupalertdiv").style.display="block";
    					    document.getElementById("spanloader").style.display="none";
    						
    					}
    				});   
              }	
              else
              {
                  alert("Please Select Api To Resend");
              }
           }
        );
        
         $("#btnResend").click( function()
           {
              
                $.ajax({
    					type:"POST",
    					url:document.getElementById("hidresendurl").value,
    					data:{'recharge_id':document.getElementById("hidRefId").value},
    					beforeSend: function() 
    					{
                document.getElementById("spanpopupalertmessage").innerHTML="";
    					   document.getElementById("popupalertdiv").style.display="none";
                           document.getElementById("spanloader").style.display="block";
                        },
    					success: function(response)
    					{
    					   //alert(response);

    					    document.getElementById("spanloader").style.display="none";
    					    document.getElementById("popupalertdiv").style.display="block";
    						var jsonobj = JSON.parse(response);
    						var msg = jsonobj.message;
    						var sts = jsonobj.status;
    						if(sts == "0")
    						{
    						    var statuscode = jsonobj.statuscode;
    						    if(statuscode == "Success")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-success');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    else if(statuscode == "Failure")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-danger');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    else if(statuscode == "Pending")
    						    {
    						        var data = jsonobj.data;
    						        var requrl = data.url;
    						         var reqresp = htmlEntities(data.Response);
    						        $("#popupalertdiv").addClass('alert-primary');
    						        document.getElementById("spanpopupalertmessage").innerHTML = msg+"|||||Request Url :"+requrl+"|||||Response :"+reqresp;   
    						    }
    						    
    						}
    						else
    						{
    						     $("#popupalertdiv").addClass('alert-danger');
    						    document.getElementById("spanpopupalertmessage").innerHTML = msg;
    						}
    						
    						 
    					
    						console.log(response);  
    					},
    					error:function(response)
    					{
    					    $("#popupalertdiv").addClass('alert-danger');
    					  document.getElementById("spanloader").style.display="none";
    					  document.getElementById("popupalertdiv").style.display="block";
    					  document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
    					},
    					complete:function()
    					{
    					    document.getElementById("popupalertdiv").style.display="block";
    					    document.getElementById("spanloader").style.display="none";
    						
    					}
    				});   
              
           }
        );
        
        
        
        
       function getreqresplog(recharge_id)
       {
           
          if(recharge_id > 0)
          {
                $.ajax({
					type:"POST",
					url:document.getElementById("hidgetlogurl").value+"/getlog_table?recharge_id="+recharge_id,
					beforeSend: function() 
					{
					    $('#myResponseModal').modal({show:true});
					   document.getElementById("log_reqresp").style.display="none";
                       document.getElementById("log_spanloader").style.display="block";
                    },
					success: function(response)
					{
					   //alert(response);
					    document.getElementById("log_spanloader").style.display="none";
					    document.getElementById("log_reqresp").style.display="block";
						document.getElementById("log_reqresp").innerHTML = response;
						console.log(response);  
					},
					error:function(response)
					{
					    $("#popupalertdiv").addClass('alert-danger');
					  document.getElementById("log_spanloader").style.display="none";
					  document.getElementById("log_reqresp").style.display="block";
					  document.getElementById("log_reqresp").innerHTML = "Some Error Occured";
					},
					complete:function()
					{
					    document.getElementById("log_reqresp").style.display="block";
					    document.getElementById("log_spanloader").style.display="none";
						
					}
				});   
          }	
          else
          {
              alert("Please Select Api To Resend");
          }
       }
              
          
        
        
        
        function htmlEntities(str) 
        {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }
    </script>




<div class="modal fade" id="myResponseModal" role="dialog">
    <div class="modal-dialog modal-lg"   >
      <div class="modal-content">
        <div class="modal-header btn-success">
            <h4 class="modal-title ">Request/Response Log</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
        <div class="modal-body">
            <span id="log_spanloader" style="display:none">
              <img id="log_imgloading" src="<?php echo base_url()."Loading.gif"; ?>" style="max-width:80px">
            </span>
           
            
          
          <div id="log_reqresp" style="overflow:auto;height:500px;word-break: break-all;">
              
          	
                
          </div>
        </div>
      </div>
    </div>
  </div>   




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
    <style>
        .modal-footer {
    /* display: flex; */
    align-items: left;
    justify-content: flex-end;
    padding: 1rem;
    border-top: 1px solid #e9ecef;
}
    </style>
     
  </body>
</html>
