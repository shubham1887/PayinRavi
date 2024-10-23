<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>BILL PAYMENT REPORT</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
         document.getElementById("ddlstatus").value = '<?php echo $status; ?>';
         document.getElementById("ddlmode").value = '<?php echo $mode; ?>';
         
         
});
	
		 
		
function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
    var ddlstatus = document.getElementById("ddlstatus").value;
    var ddlmode = document.getElementById("ddlmode").value;


		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;

    document.getElementById("hidexpstatus").value = ddlstatus;
    document.getElementById("hidmode").value = ddlmode;

		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
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
                url:document.getElementById("hidgetlogurl").value+"?recharge_id=BBPS"+id,
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
</style>
<script type="text/javascript">
    
	function ActionSubmit(value)
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
			
			if(confirm('Are you sure?\n you want to '+isstatus+' ....!!!')){
				var txnpwd = prompt("Please Enter Transaction Password");
				

        //alert(document.getElementById('action_'+value).value);

				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidOprId').value= document.getElementById('txtOpeId'+value).value;
				
				
				document.getElementById('hidid').value= value;
				document.getElementById('hidTxnPwd').value= txnpwd;
							
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
</style>
  </head> 

  <body>
    <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getlogs"; ?>">
    <input type="hidden" id="hidgetuserdataurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
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
          <span class="breadcrumb-item active">BILL PAYMENT REPORT</span>
          <a class="breadcrumb-item text-danger text-bold"  href="<?php echo base_url()."_Admin/bill_upload"; ?>"><b>Upload Excel</b>&nbsp;<span class="badge badge-primary">New</span></a>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
       <div class="col-sm-6 col-lg-3">
          <h4>BILL PAYMENT REPORT</h4>
        </div>
        <div class="col-sm-6 col-lg-9">
            
            
            
            <span class="breadcrumb-item">
          	<button class="btn btn-outline btn-sm" type="button" style="font-size:14px;">Commission : <?php echo $summary_array["commission"]; ?></button>
            </span>
            
            <span class="breadcrumb-item active">
          	<button class="btn btn-success btn-sm" type="button" style="font-size:14px;">Success : <?php echo $summary_array["Success"]; ?></button>
            </span>
          <span class="breadcrumb-item active">
          	<button class="btn btn-primary btn-sm" type="button" style="font-size:14px;">Pending : <?php echo $summary_array["Pending"]; ?></button>
          </span>
          <span class="breadcrumb-item active">
          	<button class="btn btn-danger btn-sm" type="button" style="font-size:14px;">Failure : <?php echo $summary_array["Failure"]; ?></button>
          </span>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">









      	<div class="row row-sm mg-t-20">


          <script language="javascript">
                  function setholddmr()
                  {
                    if(document.getElementById("chkhold").checked == true)      
                    {      
                      $.ajax({
                      url:'<?php echo base_url()."_Admin/bill_report/setvalues?"; ?>field=HOLD&val=1',
                      cache:false,
                      method:'POST',
                      success:function(html)
                      {
                        alert(html);
                      }
                      }); 
                    } 
                    else
                    {

                      $.ajax({
                      url:'<?php echo base_url()."_Admin/bill_report/setvalues?"; ?>field=HOLD&val=0',
                      cache:false,
                      method:'POST',
                      success:function(html)
                      {
                        alert(html);
                      }
                      }); 

                    }  
                  }
                </script>
                
                
                
                
                
                
                
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <table  style="margin-left: 50px;">
                  <tr>
                    <td><?php 
                  $rsltcomon = $this->db->query("select * from common where param = 'BILLHOLD'");
                  if($rsltcomon->num_rows() == 1)
                  {
                    $hold_val = $rsltcomon->row(0)->value;
                    if($hold_val == 1)
                    {?>
                      <input checked style="width: 12px" type="checkbox" class="filled-in chk-col-purple" id="chkhold" name="chkhold" value="hold" onClick="setholddmr()">
                        <label for="chkhold">Hold</label>
                    <?php }
                    else
                    {?>
                      <input style="width: 12px" type="checkbox" class="filled-in chk-col-purple" id="chkhold" name="chkhold" value="hold" onClick="setholddmr()">
                    <label for="chkhold">Hold</label>
                    <?php }
                  }
                ?></td>
                    
                  </tr>
                  
                </table>
















          
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form action="<?php echo base_url()."_Admin/bill_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
            <table cellspacing="10" cellpadding="3">
            <tr>
            	<td>
                	<h5>From Date :</h5>
                    <input readonly type="text" name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control-sm" title="Select From Date." maxlength="10" style="cursor: pointer"  />
                </td>
                <td>
                	<h5>To Date :</h5>
                    <input readonly type="text" name="txtTo" id="txtTo" class="form-control-sm" value="<?php echo $to; ?>" title="Select From To." maxlength="10" style="cursor: pointer"  />
                </td>
                <td>
                	<h5>Search Number :</h5>
                    <input  type="text" name="txtNumber" id="txtNumber" class="form-control-sm" value="<?php echo $txtNumber; ?>"  maxlength="20" style="cursor: pointer"  />
                </td>
                <td>
                	<h5>Status:</h5>
                    <select id="ddlstatus" name="ddlstatus" class="form-control-sm" style="">
                        <option value="ALL">ALL</option>
                        <option value="Success">SUCCESS</option>
                        <option value="Pending">PENDING</option>
                        <option value="Failure">FAILURE</option>
                    </select>
                </td>
                <td>
                  <h5>Mode:</h5>
                    <select id="ddlmode" name="ddlmode" class="form-control-sm" style="">
                        <option value="ALL">ALL</option>
                        <option value="Normal">Normal</option>
                        <option value="Express">Express</option>
                    </select>
                </td>
                <td style="padding-top:30px;">
                	<h5></h5>
                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success btn-sm" title="Click to search." />
                </td>
				<td style="padding-top:30px;">
					<h5></h5>
					<input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-sm" onClick="startexoprt()">
				</td>
            </tr>
            </table>
           


</form>
       <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/bill_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hidexpstatus" name="status">
                                    <input type="hidden" id="hidmode" name="mode">
                                    
                                    
                                    </form>   
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">BILL PAYMENT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if(isset($result_all))
	{
		if($result_all->num_rows() > 0)
		{
	?>
    
    <div id="all_transaction">
<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
    <tr>
    <th>Sr No</th>
   <th>Mode</th>
   <th>Id</th>
   <th>DateTime</th>
    <th>Agent</th> 
 
   <th>Operator</th>
    <th>ServiceNo</th>
	<th style="min-width:120px;">Bill Amount</th>
    <th>Cust.Name</th>        
    <th>Status</th>        
    <th>OprId</th> 
	  <th>Action</th> 
		<th></th>
    
	        
    </tr>
    </thead>
    <?php	$total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result) 	{  ?>
			<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo ($i + 1); ?></td>
 <td><?php echo $result->mode; ?></td> 
  <td>
    <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->Id; ?>')">
         <?php echo $result->Id; ?>
    </a>
  </td> 
  <td><?php echo $result->add_date; ?></td>
 <td><?php echo $result->businessname; ?></td>
  
 <td><?php echo $result->company_name; ?></td> 
 <td style="min-width:130px;">
        <?php echo $result->service_no; ?><br>
        Cust.Mob:<?php echo $result->customer_mobile; ?>
         Option 1:<?php echo $result->option1; ?>
 </td> 
<td style="width:120px;">
        
        
            <?php echo $result->bill_amount; ?><br>
            Dr: <?php echo $result->debit_amount; ?><br>
           Cr: <?php echo $result->credit_amount; ?>
           
</td> 
 <td><?php echo $result->customer_name;  ?></td>

 <td>
 <?php if($result->status == "Pending"){echo "<span class='btn btn-primary btn-sm'>".$result->status."</span>";} ?>
  <?php if($result->status == "Success"){echo "<span class='btn btn-success  btn-sm'>".$result->status."</span>";} ?>
  <?php if($result->status == "Failure"){echo "<span  class='btn btn-danger  btn-sm'>".$result->status."</span>";} ?>
  </td>
<td>
    <?php
    if($result->status == "Pending")
    {?>
        <input type="text" id="txtOpeId<?php echo $result->Id; ?>" id="txtOpeId<?php echo $result->Id; ?>" class="form-control-sm" style="width:120px;">
       
    <?php }
    else
    {
        
       echo "<span id='db_amount".$i."'>".$result->opr_id."</span>"; 
       ?>
       <input type="text" id="txtOpeId<?php echo $result->Id; ?>" id="txtOpeId<?php echo $result->Id; ?>" class="form-control" style="width:120px;display:none">
     <?php }
    ?>
    
</td>
 <td>
			 <select style="width:80px;" class="form-control-sm" id="action_<?php echo $result->Id; ?>">
				 <option value="Select">Select</option>
				 <option value="Pending">Pending</option>
				 <option value="Success">Success</option>
				 <option value="Failure">Failure</option>
         <option value="Rollback">Rollback</option>
         <optgroup label="Resend">
          <?php
            $rsltapirs = $this->db->query("select Id,api_name from api_configuration where is_active = 'yes' and Id > 3");
            foreach($rsltapirs->result() as $rwapirs)
            {?>
                <option value="<?php echo $rwapirs->Id; ?>"><?php echo $rwapirs->api_name; ?></option>
            <?php }

           ?>
         </optgroup>
	 		</select>
</td>
<td>
	<input type="button" id="btnact" name="btnact" class="btn btn-primary btn-sm" value="Submit" onClick="ActionSubmit('<?php echo $result->Id; ?>')">
</td>
 </tr>


<tr id="tr_reqresp<?php echo $result->Id; ?>" style="display:none">
     <td>Request </td><td colspan="4" id="tdreq<?php echo $result->Id; ?>"  style="word-break:break-all"></td>
     <td>Response</td> <td colspan="5" id="tdresp<?php echo $result->Id; ?>" style="word-break:break-all" ></td>
      <td><a href="javascript:void(0)" onClick="testhidstr('<?php echo $result->Id; ?>')" >Hide</a></td>
 </tr>





		<?php
		if($result->status == "Success"){
		$total_amount= $total_amount + $result->bill_amount;}
		$i++;} ?>
		
         <tr class="ColHeader">
    <th></th>
    <th></th>
	<th></th>
    
     
 
   
       <th></th>
    <th></th>
    <th>Successfull Transaction :</th>        
   <th><?php echo $total_amount; ?></th>        
    <th></th>
    <th></th>     <th></th>  
			 <th></th>
	<th></th>          
	<th></th>
    <th></th>
	<th></th>
     
	            
    </tr>        
		</table>
        </div>
       <?php
		}
	   else{?>
		   <div class='message'>Record Not Found.</div>
		   <?php }
	   
	   }?> 
              </div><!-- card-body -->
            </div>
             
        </div>
        </div>
      </div><!-- br-pagebody -->
       <form action="<?php echo base_url()."_Admin/bill_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidOprId" name="hidOprId" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
<input type="hidden" id="hidTxnPwd" name="hidTxnPwd">
<input type="hidden" id="hidCustName" name="hidCustName">
 </form>
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
