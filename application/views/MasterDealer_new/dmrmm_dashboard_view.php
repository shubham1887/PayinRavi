<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

   <title>RETAILER::DMR DASHBOARD</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
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
b
{
    color:@000000;
}
</style>
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
</style>
    <style>
	.error
	{
  		background-color: #ffdddd;
	}
	</style>
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
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}

#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
</style>
  </head> 
 <?php 
//$totallimit = 0.00;
//foreach($data->limit as $rlimit)
//{
//	$totallimit += floatval($rlimit->remaining);
//}
?>
  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/mdsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/mdheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Retailer/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">DMR DASHBOARD</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>DMR DASHBOARD</h4>
          
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
          <?php include("elements/messagebox.php"); ?>
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">SENDER INFORMATION</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <table class="table table-bordered">
								 <tr>
									<td><b>Name : <?php echo $data->name; ?></b></td>
									<td><b>Mobile Number : <?php echo $data->mobile; ?></b></td>
									<td><b>Customer Type : <?php echo ""; ?></b></td>


								 </tr>
								 <tr>

									 <td><b>currency : <?php echo "INR"; ?></b></td>
									 <td><b>AvailLimit : <?php echo $data->remaininglimit ; ?></b></td>
									 <td></td>

								 </tr>

							</table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">BENEFICIARY LIST</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered" style="color:#000000">
								   <tr>
								    <th>Sr.</th>
								    <th></th>
									<th>Name</th>
									<th>Bank Name</th>
									<th>IFSC Code</th>
									<th>Account Number</th>
									<th>NEFT</th>
									<th>IMPS(IFSC)</th>
									<th></th>

								   </tr>

									 <?php 
									    $i=1;
									    $accno_array = array();
									    foreach($benelist as $rbene) 
										{
												// print_r($rbene);exit;
                                            
												 $user_id = $this->session->userdata("MdId");
												 $add_date = $this->common->getDate();
												 $ipaddress = $this->common->getRealIpAddr();
												 $mt_mobile = $this->session->userdata("MobileNumber");
												 $is_verified =  $rbene->is_verified;
												 $verified_name =  $rbene->verified_name;
												 $bank =  $rbene->bank;
												 $recipient_name =  $rbene->name;
												 $ifsc =  $rbene->ifsc;
												 $account =  $rbene->account;
												 $recipient_id =  $rbene->id;
												 $is_verified = 1;
												 $accno_array[$account] = "yes";
												 ?>
													<tr>
								
													   <td><?php echo $i; ?></td>
													   <td>
													       <?php
                            								if($rbene->is_verified == 1)
                            								{?>
                            								    <span style="font-size: 6px; color: green;">
                            								    <i class="fas fa-check-double tx-30 tx-green green success"></i>
                            								    </span>
                            								<?php }
                            								else
                            								{?>
                            								<a href="javascript:void(0)" onClick="validatename('<?php echo $rbene->id; ?>')">
                            								<span style="font-size: 6px;color: red;">
                            								<i class="fas fa-question tx-20">
                            								    
                            								</i>
                            								</span>
                            								</a>
                            								<!--	Verify-->
                                                                
                            								<?php }
                            							 ?>
													   </td>
														<td>
															<?php echo $recipient_name; ?>
															<br>
															<label><?php echo $verified_name; ?></label>
															<input type="hidden" name="hidbenedata" id="hidbenedata<?php echo $recipient_id; ?>" value="<?php echo base64_encode(json_encode($rbene)); ?>">
														</td>
														
														<td><?php echo $bank; ?></td>
														<td><?php echo $ifsc; ?></td>
														<td><?php echo $account; ?></td>

														<td>
														
														
															<a href="javascript:void(0)" onClick="dotransaction('<?php echo $this->Common_methods->encrypt($recipient_id); ?>','<?php echo  $this->Common_methods->encrypt('NEFT')?>')">NEFT</a>
														

														</td>
														<td>
														 <a href="javascript:void(0)" onClick="dotransaction('<?php echo $this->Common_methods->encrypt($recipient_id); ?>','<?php echo  $this->Common_methods->encrypt('IMPS')?>')">IMPS</a>
															
														
														</td>
														<td>
														    
														    <a href="javascript:void(0)" onClick="benedelete('<?php echo $rbene->id; ?>','<?php echo $rbene->name; ?>','<?php echo $rbene->account; ?>','<?php echo $rbene->ifsc; ?>','<?php echo $rbene->mobile; ?>')">
                            								<span style="font-size: 6px;color: red;">
                            								<i class="icon ion-close tx-30">
                            								    
                            								</i>
                            								</span>
														    
														  </td>  
														    
														  
													</tr>

												 <?php $i++;
											}
										   
										

									 ?>

									  </table>
                <div class="divsmcontainer" style="text-align:center">
                    	<a href="<?php echo base_url()."Retailer/dmrmm_bene_registration?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="btn btn-success">Add New Receiver</a>
                    </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div><!-- row end-->
        
        
        
        
        
        
      </div><!-- br-pagebody -->
      <input type="hidden" id="hidurllivedata" value="<?php echo base_url()."Retailer/recharge_home/getLiveTransactions"; ?>">
		<input type="hidden" id="hidurlcheckotp" value="<?php echo base_url()."Retailer/dmrmm_dashboard/checksender_mastermoney"; ?>">
		<input type="hidden" id="hidurlregsendermm" value="<?php echo base_url()."Retailer/dmrmm_dashboard/sendererg_mastermoney"; ?>">
      
     
      <input type="hidden" id="hidacvalurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard/getAccountvalidate"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard"; ?>">
      
      
      
          <div class="modal fade" id="myMPModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle"></h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader" style="display:none">
          <img id="imgloading" src="<?php echo base_url()."images/ajax-loader.gif"; ?>"></span>
          <div id="responsespansuccess" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_success_msg"></strong>
                </div>
          </div>
          <div id="responsespanfailure" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_failure_msg"></strong>
                </div>
          </div>
          <div id="responsespanotpinput" style="display:none">
          		<table class="table">
                <tr>
                	<td><label>Enter OTP</label></td>
                	<td>
                    <input type="text" id="hidotp" name="hidotp" class="form-control" maxlength="8" onKeyPress="return IsNumeric(event);">
                    </td>
                    <td>
                    <input type="button" id="btnSubmitOtp" name="btnSubmitOtp" class="btn btn-success" value="Submit" onClick="validatebenereg()">
                    </td>
                    <td>
                    <input type="button" id="btnResendOtp" name="btnResendOtp" class="btn btn-primary" value="Resend OTP" onClick="resendotp()">
                    </td>
                </tr>
                </table>
          </div>
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>
  
  		<div class="modal fade" id="myBenedeleteModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL"></h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader" style="display:none">
          <img id="imgloading" src="<?php echo base_url()."images/ajax-loader.gif"; ?>"></span>
          <div id="responsespansuccess_BDEL" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_success_msg_BDEL"></strong>
                </div>
          </div>
          <div id="responsespanfailure_BDEL" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_failure_msg_BDEL"></strong>
                </div>
          </div>
          <div id="responsespanotpinput_BDEL" style="display:none">
          		<table class="table">
                <tr>
                	<td><label>Enter OTP</label></td>
                	<td>
                    <input type="text" id="hidotpbenedelete" name="hidotp" class="form-control" maxlength="8" onKeyPress="return IsNumeric(event);">
                    </td>
                    <td>
                    <input type="button" id="btnSubmitOtpbenedelete" name="btnSubmitOtp" class="btn btn-success" value="Submit" onClick="validatedeletebene()">
                    </td>
                    
                </tr>
                </table>
          </div>
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>
	<form action="<?php echo base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmdmr" id="frmdmr">
            <input type="hidden" id="hidformaction" name="hidformaction">
            <input type="hidden" id="hidbvbeneid" name="hidbeneid">
            <input type="hidden" id="txtotp" name="txtotp">
            <input type="hidden" id="hidremiterid" name="hidremiterid" value="<?php echo $data->mobile; ?>">
            <input type="hidden" id="hidencrdata" name="hidencrdata" value="<?php echo $this->Common_methods->encrypt($this->session->userdata("session_id")); ?>">
            <input type="hidden" name="txtbeneName" id="txtbeneName">
            <input type="hidden" name="txtAccountNo" id="txtAccountNo" >
            <input type="hidden" name="txtIfsc" id="txtIfsc">
            <input type="hidden" name="txtMobile" id="txtMobile" >
               
			</form>
   
    
    
    
    
    
    
    
    <script language="javascript">
	  	function validatename(id)
		{
			 $('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("responsespanfailure").style.display = 'none'
			document.getElementById("responsespansuccess").style.display = 'none'
			document.getElementById("modelmp_success_msg").innerHTML  = "";
			document.getElementById("modelmp_failure_msg").innerHTML  = "";
			document.getElementById("modalmptitle").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidacvalurl").value,
				cache:false,
				data:{"bid":id},
				method:'POST',
				success:function(data)
				{
				  
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						var benename = jsonobj.recipient_name;
					
						document.getElementById("modalmptitle").innerHTML  = msg;
						document.getElementById("responsespansuccess").style.display = 'block';
						document.getElementById("modelmp_success_msg").innerHTML = benename+"";
						document.getElementById("divaccvalname"+id).innerHTML  = benename;
					}
					else
					{
						document.getElementById("modalmptitle").innerHTML  = "Account Validation Failed";
						document.getElementById("responsespanfailure").style.display = 'block';
						document.getElementById("modelmp_failure_msg").innerHTML = msg;
					}
				},
				error:function()
				{
				      alert();
					document.getElementById("modalmptitle").innerHTML  = "Account Validation Failed";
					document.getElementById("responsespanfailure").style.display = 'block';
					document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					 $('#myOverlay').hide();
    				$('#loadingGIF').hide();
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
				}
				});
		}
		
		
	function addnewbene(benename,accno,ifsc,bankid)
    {
        //alert(benename+"   "+accno+"   "+ifsc+"   "+bankid);
      //return;
      $('#myBenedeleteModal').modal('hide');
      $('#myOverlay').show();
        $('#loadingGIF').show();
      
      
      
      document.getElementById("responsespanfailure_BDEL").style.display = 'none'
      document.getElementById("responsespansuccess_BDEL").style.display = 'none'
      document.getElementById("responsespanotpinput_BDEL").style.display = 'none'
      
      document.getElementById("modelmp_success_msg_BDEL").innerHTML  = "";
      document.getElementById("modelmp_failure_msg_BDEL").innerHTML  = "";
      document.getElementById("modalmptitle_BDEL").innerHTML  = "";
      
      $.ajax({
        url:document.getElementById("hidbregvalurl").value,
        cache:false,
        data:{'hidformaction':'BENEREGISTRATION','txtbeneName':benename,'txtAccountNo':accno,'txtIfsc':ifsc,'ddlbank':bankid},
        method:'POST',
        success:function(data)
        {
           
          //{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
          
          var jsonobj = JSON.parse(data);
          var msg = jsonobj.message;
          var sts = jsonobj.status;
          
          if(sts == 0)
          {
            document.getElementById("modalmptitle_BDEL").innerHTML  = msg;
            document.getElementById("responsespansuccess_BDEL").style.display = 'block'
            document.getElementById("modelmp_success_msg_BDEL").innerHTML = msg;
          }
          else
          {
            document.getElementById("modalmptitle_BDEL").innerHTML  = "Bene Registration Failed";
            document.getElementById("responsespanfailure_BDEL").style.display = 'block'
            document.getElementById("modelmp_failure_msg_BDEL").innerHTML = msg;
          }
        },
        error:function()
        {
          document.getElementById("modalmptitle_BDEL").innerHTML  = "Bene Registration Failed";
          document.getElementById("responsespanfailure_BDEL").style.display = 'block'
          document.getElementById("modelmp_failure_msg_BDEL").innerHTML = "Internal Server Error. Please try Later..";
        },
        complete:function()
        {
          $('#myOverlay').hide();
            $('#loadingGIF').hide();
          $('#myBenedeleteModal').modal({show:true});
          
          
          window.setTimeout(function() 
          {
            window.location.href = document.getElementById("hiddashboardurl").value;
          }, 2000);
          
        }
        });
    }
		
		
		function benedelete(id,name,account,ifsc,mobile)
		{
			document.getElementById("hidbvbeneid").value = id;
			document.getElementById("txtbeneName").value = name;
			document.getElementById("txtAccountNo").value = account;
			document.getElementById("txtIfsc").value = ifsc;
			document.getElementById("txtMobile").value = mobile;
			$('#myMPModal').modal('hide');
			 $('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("txtotp").value = "";
			document.getElementById("hidformaction").value = "BENEDELETE";
			document.getElementById("responsespanfailure_BDEL").style.display = 'none'
			document.getElementById("responsespansuccess_BDEL").style.display = 'none'
			document.getElementById("responsespanotpinput_BDEL").style.display = 'none'
			
			document.getElementById("modelmp_success_msg_BDEL").innerHTML  = "";
			document.getElementById("modelmp_failure_msg_BDEL").innerHTML  = "";
			document.getElementById("modalmptitle_BDEL").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmdmr').serialize(),
				method:'POST',
				success:function(data)
				{
				   // alert(data);
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
					
						document.getElementById("modalmptitle_BDEL").innerHTML  = msg;
						document.getElementById("responsespansuccess_BDEL").style.display = 'block'
						document.getElementById("modelmp_success_msg_BDEL").innerHTML = msg;
						//document.getElementById("responsespanotpinput_BDEL").style.display = 'block';
					}
					else
					{
						document.getElementById("modalmptitle_BDEL").innerHTML  = "Registration Request Failed";
						document.getElementById("responsespanfailure_BDEL").style.display = 'block'
						document.getElementById("modelmp_failure_msg_BDEL").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle_BDEL").innerHTML  = "Registration Request Failed";
					document.getElementById("responsespanfailure_BDEL").style.display = 'block'
					document.getElementById("modelmp_failure_msg_BDEL").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
				     $('#myOverlay').hide();
    		        $('#loadingGIF').hide();
				
					$('#myBenedeleteModal').modal({show:true});
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
				}
				});
		}
	  </script>
      <input type="hidden" id="hidacvalurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard/getAccountvalidate"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard"; ?>">
    
    
    
    
    
    
    
    
    
    <script language="javascript">
	function dotransaction(id,type)
	{
	   
		document.getElementById("hidcriptd1").value = id;
		document.getElementById("hidcriptd3").value = type;
		document.getElementById("frmtxn").submit();
	}
	</script>
    <form id="frmtxn" method="post" action="<?php echo base_url()."Retailer/dmrmm_transaction?cr=".$this->Common_methods->encrypt("MyData"); ?>">
    	<input type="hidden" id="hidcriptd1" name="crypt_d1">
        <input type="hidden" id="hidcriptd2" name="crypt_d2" value="<?php echo $this->Common_methods->encrypt($data->mobile); ?>">
        <input type="hidden" id="hidcriptd3" name="crypt_d3">
        <input type="hidden" id="tedtdeleteafter" value="<?php echo $data->mobile; ?>">
        
    </form>
     <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."Retailer/dmrmm_bene_registration"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard"; ?>">
    
      
     <!-------------------------------  remiter exist otp input dialog for mastermoney --------------------->
      <div class="modal fade" id="myMMOtpModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmmotptitle"></h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloadermmotp" style="display:none">
          <img id="imgloading" src="<?php echo base_url()."images/ajax-loader.gif"; ?>"></span>
          <div id="responsespansuccess_mmotp" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="model_mmotp_success_msg"></strong>
                </div>
          </div>
          <div id="responsespanfailure_mmotp" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="model_mmotp_failure_msg"></strong>
                </div>
          </div>
          <div id="responsespanotpinput_mmotp" style="display:none">
          		<table class="table">
                <tr>
                	<td><label>Enter OTP</label></td>
                	<td>
                    <input type="text" id="hidotp_mmotp" name="hidotp_mmotp" class="form-control" maxlength="8" onKeyPress="return IsNumeric(event);">
                    </td>
                    <td>
                    <input type="button" id="btnSubmitOtp_mmotp" name="btnSubmitOtp_mmotp" class="btn btn-success" value="Submit" onClick="validatesenderotp_mm()">
                    </td>
                    <td style="display:none">
                    <input type="button" id="btnResendOtp_mmotp" name="btnResendOtp_mmotp" class="btn btn-primary" value="Resend OTP" onClick="resendotp_mm()">
                    </td>
                </tr>
                </table>
          </div>
        </div>
        <div class="modal-footer" >
         <span id="spanbtnclode"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
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
  </body>
</html>