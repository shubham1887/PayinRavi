<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor::Customize Commission</title>
      <?php include("files/links.php"); ?>
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
<script language="javascript">
	function getData()
	{
	if(document.getElementById("ddlcompany").value != 0)
	{
			document.getElementById("ajaxload").style.display = "block";
			$.ajax({
			url:'<?php echo base_url(); ?>Distributor/set_commission/getCommission?company_id='+document.getElementById("ddlcompany").value,
			method:'POST',
			cache:false,
			success:function(msg)
			{
				document.getElementById("divcomm").style.display = "block";
				document.getElementById("ajaxload").style.display = "none";
				document.getElementById("divcomm").innerHTML = msg;
			}

		});
	}
	else
	{
		document.getElementById("divcomm").innerHTML = "";
	}
	}
	function changecommission(user_id,fos_id)
	{
	var com = document.getElementById("txtAgentComm"+user_id).value;
	var foscom = document.getElementById("txtFosComm"+ser_id).value;
	
	document.getElementById("ajaxload").style.display = "block";


	document.getElementById("modelmp_failure_msg_BDEL").innerHTML ="";
	document.getElementById("modelmp_success_msg_BDEL").innerHTML ="";
	document.getElementById("responsespansuccess_BDEL").style.display = "none";
	document.getElementById("responsespanfailure_BDEL").style.display = "none";	
	if(com.length >= 1 || foscom.length >= 1)
	{
	$.ajax({
url: '<?php echo base_url(); ?>Distributor/set_commission/changecommission?company_id='+document.getElementById("ddlcompany").value+'&com='+com+'&foscom='+foscom,
type: 'POST',
success:function(html)
{
document.getElementById("ajaxload").style.display = "none";
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
document.getElementById("ajaxload").style.display = "none";
getData();
}
});
	}
	}
	</script>
</head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->
        <!-- navbar side -->
       <?php include("files/distributorheader.php"); ?> 
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/distributorsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header" >Downline Commission</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Select Operator
                            
                        </div>
                        <div class="panel-body">
                           
                                    
                                    <input type="hidden" id="txtuserid" name="txtuserid">
<form id="frmsubmit" name="frmsubmit" action="" method="post">
<input type="hidden" id="hidflag" name="hidflag">
<input type="hidden" id="hidid" name="hidid">
<input type="hidden" id="hidcom" name="hidcom">
</form>
<form method="post"  name="frmscheme_view" id="frmscheme_view" autocomplete="off">
<div class="breadcrumb" style="padding:20px;">
<table>
<tr>
<td>
<table cellpadding="3" cellspacing="3" border="0">
	<tr>
<td align="right"><label for="txtGroupName" style="font-size:20px;"><span style="color:#F06">*</span>Select Group Name :</label></td><td align="left">
<select id="ddlcompany" name="ddlcompany" onChange="getData()" style="font-size:20px;width:200px;height:40px;">
 <option value="0">Select</option>
<?php
	$operator_rslt = $this->db->query("select * from tblcompany order by company_name");
	foreach($operator_rslt->result() as $row)
	{
 ?>
 <option value="<?php echo $row->company_id; ?>"><?php echo $row->company_name; ?></option>
 <?php } ?>
</select>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
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
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>COMMISSION LIST
                            
                        </div>
                        <div class="panel-body">
                           <div class="table-responsive">
                           <div id="ajaxload" style="display:none">
<img src="<?php echo base_url()."ajax-loader.gif" ?>">
</div>
                                <div id="divcomm">
								</div>
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
	<div class="modal fade" id="myMessgeModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL">Response Message</h4>
          
        </div>
        <div class="modal-body">
        
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
          
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>
   
   <?php include("files/adminfooter.php"); ?> 
</body>
</html>
