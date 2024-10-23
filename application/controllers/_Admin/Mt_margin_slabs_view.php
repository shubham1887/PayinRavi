<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Margin Slab</title>
      <?php include("files/links.php"); ?>
      <?php include("files/apijaxscripts.php"); ?>
       <link href="<?php echo base_url()."jquery.dataTables.css"; ?>" rel="stylesheet" type="text/css" />    
   	<link rel="stylesheet" href="<?php echo base_url()."js/themes/base/jquery.ui.all.css"; ?>">
    <link rel="stylesheet" href="<?php echo base_url()."js/jquery.alerts.css"; ?>">
    <script src="<?php echo base_url()."js/jquery-1.4.4.js"; ?>"></script>
	<script src="<?php echo base_url()."js/qTip.js"; ?>"></script>               
    <script src="<?php echo base_url()."js/jquery.dataTables.min.js"; ?>"></script> 
    <script src="<?php echo base_url()."js/jquery.alerts.js"; ?>"></script>    


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
</head>

<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
        <?php include("files/adminheader.php"); ?> 
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/adminsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Area Chart Example
                            
                        </div>

                        <div class="panel-body">
                          <form method="post" action="<?php echo base_url()."_Admin/mt_commission_slab"; ?>" name="frmapi_view" id="frmapi_view" autocomplete="off">
<fieldset>
<table  class="table">
<tr>
<td align="right"><label for="txtAPIName"><span style="color:#F06">*</span> Amount From :</label></td><td align="left"><input type="text" class="text" id="txtAmountFrom"  name="txtAmountFrom" maxlength="10"/>
<span id="APINameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Amount To :</label></td><td align="left"><input type="text" id="txtAmountTo" class="text"  name="txtAmountTo">
<span id="usernameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Deductin Type :</label></td><td align="left">
<select  id="ddldudtype" class="form-control" style="width:120px;"  name="ddldudtype" >
<option value="PER">Percentage</option>
<option value="AMOUNT">Amount</option>
</select>
<span id="usernameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtPassword"><span style="color:#F06">*</span> Transaction Charge :</label></td><td align="left"><input type="text" class="text" id="txnCharge" name="txnCharge" maxlength="50"/>
<span id="passwordInfo"></span>
</td>
</tr>

<tr>
<td></td><td align="left"><input type="submit" class="button" id="btnSubmit" name="btnSubmit" value="Submit"/> <input type="reset" class="button" onClick="SetReset()" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
</tr>
</table>
</fieldset>
<input type="hidden" id="hidID" name="hidID" />
</form>
                        </div>

                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            <div class="row">
                
                <div class="col-lg-12">
<form action="<?php echo base_url()."_Admin/mt_commission_slab"; ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="Delete" />
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
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>API LIST
                            
                        </div>

                        <div class="panel-body">
                           <div class="table-responsive">
                                 
              <div class="space10"></div>
                <!--END METRO STATES-->
            </div>
            <div class="row-fluid">
                <table  class="table table-bordered">
     <thead> 
        <tr class="ColHeader"> 
            <th height="30" >Amount Range</th> 
            <th height="30" >Deduction Type</th> 
            <th  height="30" >Transaction Charge</th> 
            <th  height="30" >Add Date</th>
              <th  height="30" >Edite Date</th>
            <th  height="30" >Actions</th> 
        </tr> </thead>
    <?php	$i = 0;foreach($result_slabs->result() as $result) 	{  ?>
    <tbody> 
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="name_<?php echo $result->Id; ?>"><?php echo $result->range_from."  -  ".$result->range_to; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->charge_type; ?></span></td>
             <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->charge_amount; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->add_date; ?></span></td>              
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->ipaddress; ?></span></td>              
            <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
              <img src="<?php echo base_url()."images/delete.PNG"; ?>" height="20" width="20" onClick="Confirmation('<?php echo $result->Id; ?>')" title="Delete Row" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>  
             </tr></tbody>
		<?php 	
		$i++;} ?>
		</table>
                            </div>
                        </div>

                    </div>
                        
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
   
   <?php include("files/adminfooter.php"); ?> 
</body>

</html>
