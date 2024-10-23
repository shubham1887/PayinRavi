<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>DMR Margin Slab</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	

});
	

	</script>
	<script>
function SetEdit(value)
	{
		document.getElementById('txtAPIName').value=document.getElementById("name_"+value).innerHTML;
		document.getElementById('txtUserName').value=document.getElementById("uname_"+value).innerHTML;		
		document.getElementById('txtPassword').value==document.getElementById("pwd_"+value).innerHTML;
		document.getElementById('txtIp').value==document.getElementById("ipaddr_"+value).innerHTML;
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		//document.getElementById('myLabel').innerHTML = "Edit API";
	}
</script>
 <script language="javascript">
          function editslabform(id)
          {
               document.getElementById("hidSlabId").value  = id;
              document.getElementById("txtAmountFrom").value = document.getElementById("hidrange_from"+id).value;
              document.getElementById("txtAmountTo").value = document.getElementById("hidrange_to"+id).value;
              document.getElementById("ddldudtype").value = document.getElementById("hidcharge_type"+id).value;
              document.getElementById("txnCharge").value = document.getElementById("hidcharge_amount"+id).value;
              document.getElementById("txtccf").value = document.getElementById("hidccf"+id).value;
              document.getElementById("ddlccftype").value = document.getElementById("hidccf_type"+id).value;
              document.getElementById("txttds").value = document.getElementById("hidtds"+id).value;
              document.getElementById("ddltdstype").value = document.getElementById("hidtds_type"+id).value;
              document.getElementById("txtcashback").value = document.getElementById("hidcashback"+id).value;
              document.getElementById("ddlcashbacktype").value = document.getElementById("hidcashback_type"+id).value;
              document.getElementById("btnSubmit").value="Update";
          }
      </script>
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
          <a class="breadcrumb-item" href="#"></a>
          <span class="breadcrumb-item active">DMT SLAB</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>DMT SLAB</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <form method="post" action="<?php echo base_url()."_Admin/mt_commission_slab"; ?>" name="frmapi_view" id="frmapi_view" autocomplete="off">
							  <input type="hidden" id="hidgroupid" name="hidgroupid" value="<?php echo $this->input->get("crypt2"); ?>">
							  <input type="hidden" id="hidgroupname" name="hidgroupname" value="<?php echo $this->input->get("crypt1"); ?>">
							  <input type="hidden" id="hidSlabId" name="hidSlabId" >
							  
<fieldset>
<table  class="table">
<tr>
<td align="right"><label for="txtAPIName"><span style="color:#F06">*</span> Amount From :</label></td><td align="left"><input type="text" class="form-control" id="txtAmountFrom"  name="txtAmountFrom" maxlength="10"/>
<span id="APINameInfo"></span>
</td>

<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Amount To :</label></td><td align="left"><input type="text" id="txtAmountTo" class="form-control"  name="txtAmountTo">
<span id="usernameInfo"></span>
</td>
</tr>

<tr>
<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Deductin Type :</label></td><td align="left">
<select  id="ddldudtype" class="form-control"   name="ddldudtype" >
<option value="PER">Percentage</option>
<option value="AMOUNT">Amount</option>
	
</select>
<span id="usernameInfo"></span>
</td>

<td align="right"><label for="txtPassword"><span style="color:#F06">*</span> Transaction Charge :</label></td><td align="left"><input type="text" class="form-control" id="txnCharge" name="txnCharge" maxlength="50"/>
<span id="passwordInfo"></span>
</td>
</tr>

<tr>
    <td align="right">
        <label for="txtAPIName"><span style="color:#F06">*</span> CCF :</label>
    </td>
    <td align="left">
        <input type="text" class="form-control" id="txtccf"  name="txtccf" maxlength="10"/>
        <span id="APINameInfo"></span>
    </td>
    
    
    
    <td align="right">
        <label for="txtAPIName"><span style="color:#F06">*</span> CCF TYPE :</label>
    </td>
    <td align="left">
        <select id="ddlccftype" name="ddlccftype" class="form-control">
            <option value="AMOUNT">AMOUNT</option>
            <option value="PER">PER (%)</option>
        </select>
        <span id="APINameInfo"></span>
    </td>
    

    
</tr>

<tr>
    <td align="right">
        <label for="txtUserName"><span style="color:#F06">*</span> TDS :</label>
    </td>
    <td align="left">
        <input type="text" id="txttds" class="form-control"  name="txttds">
        <span id="usernameInfo"></span>
    </td>
    
    
    
    <td align="right">
        <label for="txtAPIName"><span style="color:#F06">*</span> TDS TYPE :</label>
    </td>
    <td align="left">
        <select id="ddltdstype" name="ddltdstype" class="form-control">
            <option value="AMOUNT">AMOUNT</option>
            <option value="PER">PER (%)</option>
        </select>
        <span id="APINameInfo"></span>
    </td>
    
    

    
    
</tr>


<tr>
    <td align="right">
        <label for="txtAPIName"><span style="color:#F06">*</span> Cashback :</label>
    </td>
    <td align="left">
        <input type="text" class="form-control" id="txtcashback"  name="txtcashback" maxlength="10"/>
        <span id="APINameInfo"></span>
    </td>
    
    
    
    <td align="right">
        <label for="txtAPIName"><span style="color:#F06">*</span> Cashback TYPE :</label>
    </td>
    <td align="left">
        <select id="ddlcashbacktype" name="ddlcashbacktype" class="form-control">
            <option value="AMOUNT">AMOUNT</option>
            <option value="PER">PER (%)</option>
        </select>
        <span id="APINameInfo"></span>
    </td>
    

</tr>

<tr>
<td></td><td align="left"><input type="submit" class="button" id="btnSubmit" name="btnSubmit" value="Submit"/> <input type="reset" class="button" onClick="SetReset()" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
</tr>
</table>
</fieldset>
<input type="hidden" id="hidID" name="hidID" />
</form>     

<form action="<?php echo base_url()."_Admin/mt_commission_slab"; ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="Delete" />
	 <input type="hidden" id="hiddelete_groupid" name="hidgroupid" value="<?php echo $this->input->get("crypt2"); ?>" />
	 <input type="hidden" id="hiddelete_groupname" name="hidgroupname" value="<?php echo $this->input->get("crypt1"); ?>" />
</form>
					
<script language="javascript">
function Confirmation(value)
	{
		var varName = document.getElementById("name_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" ") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
</script>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT SLABS</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                   <table  class="table table-bordered">
     <thead> 
        <tr class="ColHeader"> 
            <th height="30" >Amount Range</th> 
            <th height="30" >Deduction Type</th> 
            <th  height="30" >Transaction Charge</th>
            <th  height="30" >CCF</th> 
            <th  height="30" >CashBacke</th> 
            <th  height="30" >TDS</th> 
            
            <th  height="30" >Add Date</th>
            
            <th  height="30" >Actions</th> 
        </tr> </thead>
    <?php	$i = 0;foreach($result_slabs->result() as $result) 	
    {  
    
    $ccftype = "";
        $tdstype = "";
        $cashbacktype = "";
        if($result->ccf_type == "PER")
        {
            $ccftype = "%";
        }
        if($result->tds_type == "PER")
        {
            $tdstype = "%";
        }
        if($result->cashback_type == "PER")
        {
            $cashbacktype = "%";
        }
    ?>
    <tbody> 
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                  
                   <input type="hidden" id="hidrange_from<?php echo $result->Id; ?>" value="<?php echo $result->range_from; ?>">
                  <input type="hidden" id="hidrange_to<?php echo $result->Id; ?>" value="<?php echo $result->range_to; ?>">
                  <input type="hidden" id="hidcharge_type<?php echo $result->Id; ?>" value="<?php echo $result->charge_type; ?>">
                  <input type="hidden" id="hidcharge_amount<?php echo $result->Id; ?>" value="<?php echo $result->charge_amount; ?>">
                  <input type="hidden" id="hidccf<?php echo $result->Id; ?>" value="<?php echo $result->ccf; ?>">
                  <input type="hidden" id="hidccf_type<?php echo $result->Id; ?>" value="<?php echo $result->ccf_type; ?>">
                  <input type="hidden" id="hidtds<?php echo $result->Id; ?>" value="<?php echo $result->tds; ?>">
                  <input type="hidden" id="hidtds_type<?php echo $result->Id; ?>" value="<?php echo $result->tds_type; ?>">
                  <input type="hidden" id="hidcashback<?php echo $result->Id; ?>" value="<?php echo $result->cashback; ?>">
                  <input type="hidden" id="hidcashback_type<?php echo $result->Id; ?>" value="<?php echo $result->cashback_type; ?>">
                  
                  
                  
                  
                  <span id="name_<?php echo $result->Id; ?>"><?php echo $result->range_from."  -  ".$result->range_to; ?></span>
            </td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                  <span id="uname_<?php echo $result->Id; ?>"><?php echo $result->charge_type; ?></span></td>
             <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                 <span id="uname_<?php echo $result->Id; ?>"><?php echo $result->charge_amount; ?></span></td>
             <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                 <span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->ccf." ".$ccftype; ?></span></td>              
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                  <span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->cashback." ".$cashbacktype; ?></span></td>              
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                  <span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->tds." ".$tdstype; ?></span></td>   
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                  <span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->add_date; ?></span></td>              
              
                         
            
            
            <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                
                <a href="javascript:void(0)" class="btn btn-sm btn-info" onClick="editslabform(<?php echo $result->Id; ?>)" >
													<i class="ace-icon fa fa-pencil bigger-120"></i>Edit	
				</a>
				
				
				<a href="javascript:void(0)" class="btn btn-sm btn-danger" onClick="Confirmation(<?php echo $result->Id; ?>)" >
													<i class="ace-icon fa fa-trash-o bigger-120"></i>Delete	
				</a>
                
                
              </td>  
             </tr></tbody>
		<?php 	
		$i++;} ?>
		</table>
              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
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
