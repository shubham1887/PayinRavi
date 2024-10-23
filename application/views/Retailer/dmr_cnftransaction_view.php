<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RETAILER::DMR Confirm Transaction</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     <script language="javascript">
	  
	  $(document).ready(function(){});
	  
	  var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) 
		{
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
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
	<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
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
                    <h1 class="page-header">DMR</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
					<?php include("files/messagebox.php"); ?>
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i><h3>Do <?php echo $this->Common_methods->decrypt($this->Common_methods->decrypt($transtype)); ?> Transaction</h3>
                            
                        </div>
                        <div class="panel-body">
                           <form action="<?php echo base_url()."Retailer/dmr_cnftransaction?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmdmr" id="frmdmr">
            
            <input type="hidden" id="hidformaction" name="formaction">
          	<input type="hidden"  name="crypt_d7" value="<?php echo $this->Common_methods->encrypt($bene_id); ?>">
            <input type="hidden"  name="crypt_d8" value="<?php echo $this->Common_methods->encrypt($remitter_id); ?>"> 
            <input type="hidden"  name="crypt_d9" value="<?php echo $this->Common_methods->encrypt($transtype); ?>">
            <input type="hidden"  name="crypt_d10" value="<?php echo $this->Common_methods->encrypt($Amount); ?>">
            <input type="hidden"  name="crypt_d11" value="<?php echo $this->Common_methods->encrypt($Remark); ?>">
                <table class="table table-bordered" style="width:500px;">
                <tr>
                	<td><label>Beneficiary Name:</label></td>
                    <td>
                        <input type="hidden" id="hidencrdata" name="hidencrdata" value="<?php echo $this->Common_methods->encrypt($this->session->userdata("session_id")); ?>">
                         <?php echo $benedata->row(0)->benificiary_name; ?>
                    </td>
                </tr>
                <tr>
                	<td><label>Account Number:</label></td>
                    <td>
                       <?php echo $benedata->row(0)->benificiary_account_no; ?>
                    </td>
                </tr>
                <tr>
                	<td><label>IFSC Code:</label></td>
                    <td>
                       <?php echo $benedata->row(0)->benificiary_ifsc; ?>
                    </td>
                </tr>
                <tr>
                	<td><label>Mobile Number:</label></td>
                    <td>
                       <?php echo $benedata->row(0)->benificiary_mobile; ?>
                    </td>
                </tr>
                 <tr>
                	<td><label>Amount:</label></td>
                    <td>
                       <?php echo $this->Common_methods->decrypt($Amount); ?>
                    </td>
                </tr>
                <tr>
                	<td><label>Remark:</label></td>
                    <td>
                       <?php echo $this->Common_methods->decrypt($Remark); ?>
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td style="padding-top:30px;">
                      <input type="button" name="btnConfirm" id="btnConfirm" value="Confirm" class="btn btn-success" onClick="validataandsubmit()" />
                    </td>
                </tr>
                </table>
			</form>
                        </div>
                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
					<script language="javascript">
	function validataandsubmit()
	{
		
			 $('#myOverlay').show();
    		$('#loadingGIF').show();
			
			document.getElementById("hidformaction").value = "CNFTXN";
			document.getElementById("frmdmr").submit();
			
	}
	function validataamount()
	{
		var amt = document.getElementById("txtAmount").value;
		if(amt >= 10 & amt <= 25000)
		{
				$("#txtAmount").removeClass("error");
				return true;
		}
		else
		{
			$("#txtAmount").addClass("error");
			return false;
		}
	}
	function validateremark()
	{
		var remark = document.getElementById("txtRemark").value;
		if(remark.length >= 4)
		{
				$("#txtRemark").removeClass("error");
				return true;
		}
		else
		{
			$("#txtRemark").addClass("error");
			return false;
		}
	}
	
</script>
					<input type="hidden" id="hidurllivedata" value="<?php echo base_url()."Retailer/recharge_home/getLiveTransactions"; ?>">
      
      <script language="javascript">
	  	function benereg(id)
		{
			 $('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("hidformaction").value = "BENEREGISTRATION";
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
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
				}
				});
		}
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
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
					
					
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
					
				}
				});
		}
		function resendotp()
		{
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
					$('#myMPModal').modal({show:true,backdrop: 'static',keyboard: false});
					
				}
				});
		}
	  </script>
      
      <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."Retailer/dmr_bene_registration"; ?>">
      <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmr_dashboard"; ?>">
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
         <span id="spanbtnclode" > <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>
                </div>
            </div>
            
        </div>
        <!-- end page-wrapper -->
    </div>
    <!-- end wrapper -->
    <!-- Core Scripts - Include with every page -->
   
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>
</html>
