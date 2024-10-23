<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Pending Recharges</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	$(document).ready(function()
	  {
	  getconcurrentlogs();
	  window.setInterval(getconcurrentlogs, 10000);
	  document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
	  document.getElementById("ddloperator").value = '<?php echo $ddloperator; ?>';
	  
//	requeryallrecharge();	
	//window.setInterval(gettransactions, 10000  );
	setTimeout(function(){window.location.reload(1);}, (15000)  );
	setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
		   });
	function ActionSubmit(value,name)
	{
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			var isstatus;
			if(document.getElementById('action_'+value).value == "Success")
			{isstatus = 'Success';}else{isstatus='Failure';}
			
			if(confirm('Are you sure?\n you want to '+isstatus+' rechrge for - ['+name+']'))
			{
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidrechargeid').value= value;		
				document.getElementById('hidid').value=document.getElementById('txtOpId'+value).value;	
				
				document.getElementById('frmCallAction').submit();
			}
		}
	}
	function statuschecking(value)
	{
		$.ajax({
			url:'<?php echo base_url()."ztaohgysbg?id=";?>'+value,
			type:'post',
			cache:false,
			success:function(html)
			{
				if(html == "gtid is wrong.")
				{
					document.getElementById("sts"+value).innerHTML = "Failure";
				}
				else
				{
					document.getElementById("sts"+value).innerHTML = html;
				}
			}
			});
		
	}
	</script>
    <script language="javascript">
	function requeryallrecharge()
	{
		var str = document.getElementById("hisrecids").value;
		var strarr = str.split("#");
		for(i=0;i<strarr.length;i++)
		{
			statuschecking(strarr[i]);
		}
		
		
	}
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
	    .error
	    {
	        background-color:#f1ded0 !important;
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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 2px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
    border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
	border-bottom:: 1px solid #ddd;
	overflow:hidden;
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">Pending Recharges</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Pending Recharges</h4>
        </div>
      </div><!-- d-flex -->
<?php
					$apirslt = $this->db->query("select api_id,api_name from tblapi where api_id IN (select api_id from tblpendingrechares group by api_id)");
					
					$companyrslt = $this->db->query("select company_id,company_name from tblcompany where company_id IN (select company_id from tblpendingrechares group by company_id)");
				 ?>
      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-8">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form action="<?php echo base_url()."_Admin/list_recharge_pending2" ?>" method="post" name="frmsrch" id="frmsrch">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table>
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <h5>API</h5>
                                            <select id="ddlapi" name="ddlapi" class="form-control-sm" onChange="getTransactions()" style="width:80px">
                                            	<option value="ALL">ALL</option>
                                                <?php 
													foreach($apirslt->result() as $rwapi)
													{?>
														<option value="<?php echo $rwapi->api_id; ?>"><?php echo $rwapi->api_name; ?></option>
													<?php }
												 ?>
                                            </select>
                                        </td>
                                        <td >
                                        	 <h5>Operator</h5>
                                            <select id="ddloperator" name="ddloperator" class="form-control-sm" onChange="getTransactions()" style="width:80px">
                                            	<option value="ALL">ALL</option>
                                                <?php 
													foreach($companyrslt->result() as $rwcomp)
													{?>
														<option value="<?php echo $rwcomp->company_id; ?>"><?php echo $rwcomp->company_name; ?></option>
													<?php }
												 ?>
                                            </select>
                                        </td>
                                         <td >
                                        	 <h5>Number</h5>
                                        	 <input type="text" name="txtNumber" id="txtNumber" class="form-control-sm" style="width:120px;" value="<?php echo $txtNumber; ?>">
                                        </td>
                                        <td valign="bottom">
                                            
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-xs">
                                        
                                        </td>
                                        <td valign="bottom" style="padding-left:40px;">
                                        <input type="button" id="btncheclallstatus" name="btncheclallstatus" value="Single Click" class="btn btn-primary btn-xs" onClick="requeryallrecharge()">    
                                        </td>
                                        <td valign="bottom">
                                        <input type="button" id="btnviewlog" name="btnviewlog" value="VIEW LOG" class="btn btn-success btn-xs" onClick="viewhidelog()">
                                        </td>
                                        <td valign="bottom">
                                        <span class="btn btn-info btn-sm">Pending <?php echo $totalcount; ?></span>
                                        </td>
                                        <td valign="bottom">
                                        <span class="btn btn-info btn-sm">Amount <?php echo $total; ?></span>
                                        </td>
                                    </tr>
                                    
                                    </table>
                                    </form>
                                     <form action="<?php echo base_url()."_Admin/list_recharge_pending2" ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidrechargeid" name="hidrechargeid" />
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
											<input type="hidden" id="hidTxnPwd" name="hidTxnPwd">
 </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
          <div class="col-sm-12 col-lg-4">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                             <table class="table">
									
									<tr>
										<td>
                                        
                                        <input type="checkbox" id="chkall" class="filled-in chk-col-purple" />
                                                        <label for="chkall"></label>
                                        
										
										<script language="javascript">
									$('#chkall').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $('.checkBoxrecharge').each(function() {
            this.checked = true;   
			//alert(this.value);
        });
    }
	else
	{
	$('.checkBoxrecharge').each(function() {
            this.checked = false;                        
        });
	}
});
									</script>
										</td>
										<td>
											<select style="width:120px;" class="form-control-sm" id="ddlactall" >
												 <option value="Select">Select</option>
												 <option value="Pending">Pending</option>
												 <option value="Success">Success</option>
												 <option value="Failure">Failure</option> 
												 <?php 
													$apirsl = $this->db->query("select api_name,api_id from tblapi where status = 1 order by api_name");
													foreach($apirsl->result() as $rapi)
													{?>
														<option value="<?php echo $rapi->api_name; ?>"><?php echo $rapi->api_name; ?></option> 
													<?php }
												  ?>
											 </select>
										</td>
										<td >
											<input type="button" id="btnactall" value="Submit" class="btn btn-primary btn-sm">
										</td>
									</tr>
							   </table>
                               
                               
<script language="javascript">
$('#btnactall').click(function(event) {   
    var status = $('#ddlactall').val();
	if(status != "Select")
	{
	document.getElementById("hidactionallstatus").value = status;
	document.getElementById("hidactionall").value = "settoall";
	document.getElementById("frmactall").submit();
	}
	else
	{
		alert("Please Select Action");
	}
});
</script>
              </div><!-- card-body -->
            </div><!-- card -->
          </div>
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">PENDING RECHARGE LIST</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <form id="frmactall" name="frmactall" method="post"> 
    <input type="hidden" name="hidactionall" id="hidactionall">
     <input type="hidden" name="hidactionallstatus" id="hidactionallstatus" value="settoall">							   
	<div id="transactions" class="table-responsive">			   
<table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:12px;overflow:hidden">
    <tr>  
	<th></th> 
     <th>SR.</th> 
     <th>RecId</th>
    <th>DateTime</th>
    <th>Name</th>
   <th>opcode</th>
	<th>Mobile No</th>    
	<th>Amount</th>    
   	<th>API</th>    
    
    <th>Response</th> 
   	<th>Status</th>    
	<th>Action</th>  
    <th></th>                 
    </tr>
    <?php
	    $strrecid = '';
	    $k = 1;
		$i = $result_recharge->num_rows();
		foreach($result_recharge->result() as $result) 	
	    {
	        
	        if($k >50)
	        {
	            break;
	        }
	        $recdt = $result->add_date;
    		$recdatetime =date_format(date_create($recdt),'Y-m-d h:i:s');
    		$cdate =date_format(date_create($this->common->getDate()),'Y-m-d h:i:s');
    	    $this->load->model("Update_methods");
    	    $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
	    
	    
	    
	if(isset($result->recharge_id)) 
	{
		$strrecid .=$result->recharge_id."#"; 
	}
    
	 ?>
	 
	 
	 
	 <?php 
	    if($diff > 5) 
	    {?>
	        <tr id="tr_<?php echo $result->recharge_id; ?>" class="error" style="border-top: 1px solid #000;">
	    <?php }
	    else
	    {?>
	    <tr id="tr_<?php echo $result->recharge_id; ?>" style="border-top: 1px solid #000;" >
	    <?php }
	 ?>
	 
	 
			
			<td valign="middle">
            
                    <input type="checkbox" name="chkp[]" id="md_checkbox_<?php echo $result->recharge_id; ?>"  value="<?php echo $result->recharge_id; ?>" class="filled-in chk-col-purple checkBoxrecharge" />
                   
                    <label for="md_checkbox_<?php echo $result->recharge_id; ?>"></label>
          
          </td>
            <td ><?php echo $i+1; ?></td>
            <td>
             <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->recharge_id; ?>')">
         <?php echo $result->recharge_id; ?>
    		</a>
            </td>
 <td><?php echo $result->add_date; ?></td>
 <td style="word-break:break-all"><?php echo $result->username; ?></td>
  <td><?php echo $result->mcode; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 <td><span id="apinamespan<?php echo $result->recharge_id; ?>"><?php echo $result->ExecuteBy; ?></span></td>
 <td style="width:420px;word-break:break-all;font-size:12px;"><span id="responsespan<?php echo $result->recharge_id; ?>"><?php echo $result->response; ?></span></td>
 
  <td style="display:none"> <input type="text"  id="txtOpId<?php echo $result->recharge_id; ?>" name="txtOpId<?php echo $result->recharge_id; ?>" class="form-control-sm" style="width:80px;"></td>
<td> <?php echo "<span class='orange'><a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Pending</a></span>";?></td>
 <td>
  <?php if($this->session->userdata("ausertype") == "Admin"){ ?>
 <select style="width:80px;" class="" id="action_<?php echo $result->recharge_id; ?>" >
     <option value="Select">Select</option>
     <option value="Pending">Pending</option>
     <option value="Success">Success</option>
     <option value="Failure">Failure</option> 
     <?php 
	 	$apirsl = $this->db->query("select * from tblapi order by api_name");
	 	foreach($apirsl->result() as $rapi)
		{?>
			<option value="<?php echo $rapi->api_name; ?>"><?php echo $rapi->api_name; ?></option> 
		<?php }
	  ?>
 </select>
 <?php } ?>
 </td>
 <td>
 <input type="button" id="btnSubmit<?php echo $result->recharge_id; ?>" name="btnSubmit" value="Submit" class="btn btn-warning btn-sm" onClick="ActionSubmit('<?php echo $result->recharge_id; ?>','<?php echo $result->mobile_no; ?>')">
 </td>
 </tr>
 <tr id="tr_reqresp<?php echo $result->recharge_id; ?>" style="display:none">
     <td>Request </td><td colspan="4" id="tdreq<?php echo $result->recharge_id; ?>"  style="word-break:break-all"></td>
     <td>Response</td> <td colspan="5" id="tdresp<?php echo $result->recharge_id; ?>" style="word-break:break-all" ></td>
      <td><a href="javascript:void(0)" onClick="testhidstr('<?php echo $result->recharge_id; ?>')" >Hide</a></td>
 </tr>
		<?php 
		$k++;
		$i--;} ?>
		</table>
		</div>
</form>	
			
           
            
            
            			        <input type="hidden" id="hisrecids" value="<?php echo $strrecid;?>">
              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
        </div>
      </div><!-- br-pagebody -->
      <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getlogs"; ?>">
<input type="hidden" id="hidgettxnsurl" value="<?php echo base_url()."_Admin/list_recharge_pending/gettransactions"; ?>">
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
    <script language="javascript">
	function getconcurrentlogs()
	{
		var str = document.getElementById("hisrecids").value;
		//alert(str);
		var strarr = str.split("#");
		for(i=0;i<strarr.length;i++)
		{
		
			getandsetlog(strarr[i]);
		}
	}
	function getandsetlog(value)
	{
		if(+value > 10 )
		{
		//alert("getting response for "+value);
			$.ajax({
				url:'<?php echo base_url()."ztaohgysbg/getlastresponselog?id=";?>'+value,
				type:'post',
				cache:false,
				success:function(html)
				{
					var arrresp = html.split("^-^");
					//alert(arrresp[1])
					document.getElementById("responsespan"+arrresp[0]).innerHTML = arrresp[1];
					document.getElementById("apinamespan"+arrresp[0]).innerHTML = arrresp[3];
					var status = arrresp[2];
					
					if(status == "Success")
					{
						document.getElementById("tr_"+arrresp[0]).style.backgroundColor="green";
						$('#tr_'+arrresp[0]).fadeOut(5000);
					}
					if(status == "Failure")
					{
						document.getElementById("tr_"+arrresp[0]).style.backgroundColor="red";
						$('#tr_'+arrresp[0]).fadeOut(5000);
					}
					
					
				}
				});
		}
		
	}
</script>
    <link href="<?php echo base_url(); ?>css/colors/blue.css" id="theme" rel="stylesheet">
        <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getlogs"; ?>">
  </body>
</html>
