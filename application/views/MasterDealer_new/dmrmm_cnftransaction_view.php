<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>RETAILER::DMR Confirm Transaction</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
  </head> 

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
          <span class="breadcrumb-item active">ACCOUNT REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>ACCOUNT REPORT</h4>
        </div>
        
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
           <?php include("elements/messagebox.php"); ?>
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Do <?php echo $this->Common_methods->decrypt($this->Common_methods->decrypt($transtype)); ?> Transaction</h6>
                <span class="tx-12 tx-uppercase">
                    <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" class="btn btn-outline-success">Go To DMT Dashboard</a>
                </span>
                <script>
function goBack() {
  window.history.back();
}
</script>
                
              </div><!-- card-header -->
              <div class="card-body">
                  <form action="<?php echo base_url()."Retailer/dmrmm_cnftransaction?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmdmr" id="frmdmr">
            
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
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	
      </div><!-- br-pagebody -->
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
      
      <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."Retailer/dmrmm_bene_registration"; ?>">
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
             <span id="spanbtnclode" > <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
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