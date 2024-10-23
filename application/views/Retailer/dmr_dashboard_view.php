<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RETAILER::DMR DASHBOARD</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      <style>
	  
	  
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #428bca;
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
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->
        <!-- navbar side -->
       <?php include("files/agentheader.php"); ?> 
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/agentsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
					<br><br>
					<h3>DMR DASHBOARD</h3>
                    <a href="<?php echo base_url()."Retailer/dmr_report" ?>" class="btn btn-outline btn-primary">DMR REPORT</a>
				  <a href="<?php echo base_url()."Retailer/accountreport2" ?>" class="btn btn-outline btn-primary">LEDGER REPORT</a>
				  <a href="<?php echo base_url()."Retailer/dmr_logout" ?>" class="btn btn-outline btn-primary">LOGOUT</a>
                </div>
                <!--end page header -->
            </div>
			  <div class="row">
				  
			  </div>
            <div class="row">
                <div class="col-lg-12">
					<?php include("files/messagebox.php"); ?>
                    <!-- Form Elements -->
					
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SENDER INFORMATION
                            
                        </div>
                        <div class="panel-body">
                          <table class="table table-bordered">
             	<tr>
                	<td>Name :<b> <?php echo $remitter_info->name; ?></b></td>
                    <td>Mobile :<b> <?php echo $remitter_info->mobile; ?></b></td>
                    <td>Consumed Limit :<b> <?php echo $remitter_info->consumedlimit; ?></b></td>
                    <td>Remaining Limit :<b> <?php echo $remitter_info->remaininglimit; ?></b></td>
                </tr>
                <tr>
                	<td>Address :<b> <?php echo $remitter_info->address; ?></b></td>
                    <td>city :<b> <?php echo $remitter_info->city; ?></b></td>
                    <td>state :<b> <?php echo $remitter_info->state; ?></b></td>
                    <td>kycstatus :<b> <?php echo $remitter_info->kycstatus; ?></b></td>
                </tr>
             </table>
                        </div>
                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            <div class="row">
                
                <div class="col-lg-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Receiver Accounts
                            
                        </div>
                        <div class="panel-body">
                           <div class="table-responsive">
                         <?php 
				
				if(count($beneficiary_info) > 0)
                {
					$acc_val_info = $this->db->query("SELECT * FROM `mt3_account_validate` where remitter_id = ? and verification_status = 'VERIFIED'",array($remitter_info->id));
					$db_accval_arr = array();
					if($acc_val_info->num_rows() > 0)
					{
						foreach($acc_val_info->result() as $r)
						{
							$avl_id = $r->Id;
							$avl_user_id = $r->user_id;
							$avl_remitter_id = $r->remitter_id;
							$avl_remitter_mobile = $r->remitter_mobile;
							$avl_bene_id = $r->bene_id;
							$avl_RESP_benename = $r->RESP_benename;
							$db_accval_arr[$avl_remitter_id][$avl_bene_id] = $avl_RESP_benename;
						}
					}
					
					
					?>
					<table class="table table-bordered">
                    	<tr>
                        	<td>Sr.</td>
                            <td>Varification</td>
                            <td>BeneName</td>
                            <td>Account Number</td>
                            <td>Bank</td>
                            <td>IFSC</td>
                            <td>Mobile Number</td>
                            <td>Status</td>
                            <td></td>
                            <td></td>
                            <td>Action</td>
                        </tr>
                   
              <?php 
			  		$i =1;
			  		foreach($beneficiary_info as $bnfr)
					{
						
						?>
						
                       <tr>
                        	<td>
								<?php echo $i; ?>
                                <input type="hidden" id="hidbeneid" value="hidbeneid" value="<?php echo $this->Common_methods->encrypt($bnfr->id); ?>">
                            </td>
                            <td align="center">
                            <?php
								if(isset($db_accval_arr[$remitter_info->id][$bnfr->id]))
								{?>
								<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i>
                            </button>
								<?php }
								else
								{?>
									<button type="button" class="btn btn-primary btn-circle" onClick="onClick="validatename('<?php echo $bnfr->id; ?>')"><i class="fa fa-warning"></i>
                            </button>
                                    
								<?php }
							 ?>
                            </td>
                            <td>
								<?php echo $bnfr->name; ?>
                                <div style="font-weight:bold" id="divaccvalname<?php echo $bnfr->id; ?>"></div>
                            </td>
                            <td><?php echo $bnfr->account; ?></td>
                            <td><?php echo $bnfr->bank; ?></td>
                            <td><?php echo $bnfr->ifsc; ?></td>
                            <td><?php echo $bnfr->mobile; ?></td>
                            
                            <td>
							<?php if($bnfr->status == 1)
							{ 
								echo "<span class='label label-success'>Active</span>";
							}
							else 
							{?>
								<a href="javascript:void(0)" onClick="resendotp('<?php echo $bnfr->id; ?>','<?php echo $bnfr->name; ?>','<?php echo $bnfr->account; ?>','<?php echo $bnfr->ifsc; ?>','<?php echo $bnfr->mobile; ?>')">Pending</a>
							<?php } ?></td>
                            <td><a href="javascript:void(0)" onClick="dotransaction('<?php echo $this->Common_methods->encrypt($bnfr->id); ?>','<?php echo  $this->Common_methods->encrypt('NEFT')?>')">NEFT</a></td>
                            <td><a href="javascript:void(0)" onClick="dotransaction('<?php echo $this->Common_methods->encrypt($bnfr->id); ?>','<?php echo  $this->Common_methods->encrypt('IMPS')?>')">IMPS</a></td>
                            <td>
								<button type="button" class="btn btn-danger btn-circle" onClick="benedelete('<?php echo $bnfr->id; ?>','<?php echo $bnfr->name; ?>','<?php echo $bnfr->account; ?>','<?php echo $bnfr->ifsc; ?>','<?php echo $bnfr->mobile; ?>')" ><i class="fa fa-times"></i></button>
								
                        </tr> 
                        
						<?php $i++;
					}?>
					 </table>
                     <div class="divsmcontainer" style="text-align:center">
                    	<a href="<?php echo base_url()."Retailer/dmr_bene_registration?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="btn btn-default">Add New Receiver</a>
                    </div>	
                <?php }
				else
				{?>
					<div class="divsmcontainer">
                    	<a href="<?php echo base_url()."Retailer/dmr_bene_registration?crypt=".$this->Common_methods->encrypt("MyData"); ?>" class="btn btn-default">Add New Receiver</a>
                    </div>
				<?php }?>
                            </div>
                        </div>
                    </div>
                        
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
        </div>
		<input type="hidden" id="hidurllivedata" value="<?php echo base_url()."Retailer/recharge_home/getLiveTransactions"; ?>">
      
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
						var respdarta = jsonobj.data;
						var benename = respdarta.benename;
						var charged_amt = respdarta.charged_amt;
						document.getElementById("modalmptitle").innerHTML  = msg;
						document.getElementById("responsespansuccess").style.display = 'block';
						document.getElementById("modelmp_success_msg").innerHTML = benename+"<br>Validation Charge : "+charged_amt;
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
	  </script>
      <input type="hidden" id="hidacvalurl" value="<?php echo base_url()."Retailer/dmr_dashboard/getAccountvalidate"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmr_dashboard"; ?>">
        <!-- end page-wrapper -->
    </div>
    <!-- end wrapper -->
    <!-- Core Scripts - Include with every page -->
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
                    <input type="text" id="hidotp" name="hidotp" class="form-control" maxlength="8" onkeypress="return IsNumeric(event);">
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
                    <input type="text" id="hidotpbenedelete" name="hidotp" class="form-control" maxlength="8" onkeypress="return IsNumeric(event);">
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
	<form action="<?php echo base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmdmr" id="frmdmr">
            <input type="hidden" id="hidformaction" name="hidformaction">
            <input type="hidden" id="hidbvbeneid" name="hidbeneid">
            <input type="hidden" id="txtotp" name="txtotp">
            <input type="hidden" id="hidremiterid" name="hidremiterid" value="<?php echo $remitter_info->id; ?>">
            <input type="hidden" id="hidencrdata" name="hidencrdata" value="<?php echo $this->Common_methods->encrypt($this->session->userdata("session_id")); ?>">
            <input type="hidden" name="txtbeneName" id="txtbeneName">
            <input type="hidden" name="txtAccountNo" id="txtAccountNo" >
            <input type="hidden" name="txtIfsc" id="txtIfsc">
            <input type="hidden" name="txtMobile" id="txtMobile" >
               
			</form>
    <script language="javascript">
	
		function validatebenereg()
		{
			$('#myMPModal').modal('hide');
			$('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("txtotp").value = document.getElementById("hidotp").value;
			document.getElementById("hidformaction").value = "OTPBENEREGISTRATION";
			document.getElementById("responsespanfailure").style.display = 'none'
			document.getElementById("responsespansuccess").style.display = 'none'
			document.getElementById("responsespanotpinput").style.display = 'none'
			
			document.getElementById("modelmp_success_msg").innerHTML  = "";
			document.getElementById("modelmp_failure_msg").innerHTML  = "";
			document.getElementById("modalmptitle").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmdmr').serialize(),
				method:'POST',
				success:function(data)
				{
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						document.getElementById("modalmptitle").innerHTML  = msg;
						document.getElementById("responsespansuccess").style.display = 'block'
						document.getElementById("modelmp_success_msg").innerHTML = msg;
					}
					else
					{
						document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
						document.getElementById("responsespanfailure").style.display = 'block'
						document.getElementById("modelmp_failure_msg").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
					document.getElementById("responsespanfailure").style.display = 'block'
					document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					$('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myMPModal').modal({show:true});
					
					
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
					
				}
				});
		}
		function resendotp(id,name,account,ifsc,mobile)
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
			document.getElementById("hidformaction").value = "RESENDOTPBENEREGISTRATION";
			document.getElementById("responsespanfailure").style.display = 'none'
			document.getElementById("responsespansuccess").style.display = 'none'
			document.getElementById("responsespanotpinput").style.display = 'none'
			
			document.getElementById("modelmp_success_msg").innerHTML  = "";
			document.getElementById("modelmp_failure_msg").innerHTML  = "";
			document.getElementById("modalmptitle").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmdmr').serialize(),
				method:'POST',
				success:function(data)
				{
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						var remiter_id = jsonobj.remiter_id;
						var beneid = jsonobj.beneid;
						document.getElementById("hidremiterid").value = remiter_id;
						document.getElementById("hidbeneid").value = beneid;
						document.getElementById("modalmptitle").innerHTML  = msg;
						document.getElementById("responsespanotpinput").style.display = 'block';
					}
					else
					{
						document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
						document.getElementById("responsespanfailure").style.display = 'block'
						document.getElementById("modelmp_failure_msg").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle").innerHTML  = "Registration Request Failed";
					document.getElementById("responsespanfailure").style.display = 'block'
					document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					$('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myMPModal').modal({show:true});
					
				}
				});
		}
	</script>
    
    
    
    <script language="javascript">
	
		function validatedeletebene()
		{
			$('#myBenedeleteModal').modal('hide');
			$('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("txtotp").value = document.getElementById("hidotpbenedelete").value;
			document.getElementById("hidformaction").value = "OTPBENEDELETE";
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
						document.getElementById("modalmptitle_BDEL").innerHTML  = "Deletion Failed";
						document.getElementById("responsespanfailure_BDEL").style.display = 'block'
						document.getElementById("modelmp_failure_msg_BDEL").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle_BDEL").innerHTML  = "Deletion Failed";
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
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						var remiter_id = jsonobj.remiter_id;
						var beneid = jsonobj.beneid;
						document.getElementById("hidremiterid").value = remiter_id;
						document.getElementById("hidbeneid").value = beneid;
						document.getElementById("modalmptitle_BDEL").innerHTML  = msg;
						document.getElementById("responsespanotpinput_BDEL").style.display = 'block';
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
					
				}
				});
		}
	</script>
    
    <script language="javascript">
	function dotransaction(id,type)
	{
		document.getElementById("hidcriptd1").value = id;
		document.getElementById("hidcriptd3").value = type;
		document.getElementById("frmtxn").submit();
	}
	</script>
    <form id="frmtxn" method="post" action="<?php echo base_url()."Retailer/dmr_transaction?cr=".$this->Common_methods->encrypt("MyData"); ?>">
    	<input type="hidden" id="hidcriptd1" name="crypt_d1">
        <input type="hidden" id="hidcriptd2" name="crypt_d2" value="<?php echo $this->Common_methods->encrypt($remitter_info->id); ?>">
        <input type="hidden" id="hidcriptd3" name="crypt_d3">
    </form>
     <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."Retailer/dmr_bene_registration"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmr_dashboard"; ?>">
    
      
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>
</html>
