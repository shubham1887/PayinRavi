<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Complain</title>
  <?php include("script.php"); ?>
    <script>
	function getDiv()
	{
			if(document.getElementById("ddlComplainType").value == "ID")
			{
				document.getElementById("transactiondiv").style.display = "block";
			}
			else if(document.getElementById("ddlComplainType").value == "Other")
			{
				document.getElementById("transactiondiv").style.display = "none";
			}
	}
	function setLoad()
	{
		alert("setLoad");
			document.getElementById("transactiondiv").style.display = "none";
		
	}
	function setcompform()
	{

document.getElementById("recid").style.display ="table-row";
			document.getElementById("ddlcomp_tyoe").value ="Recharge Id";
			document.getElementById("recharge_id").value = '<?php echo $recahrge_id; ?>';
		
	}
	
	</script>
    <script>
	$(document).ready(function(){
	//global vars
	var form = $("#frmcomplain_view");
	var varsubject = $("#ddlcomp_tyoe");
	var varmessage = $("#txtMessage");	


	varsubject.focus();
	form.submit(function(){		
		if(validatesSubject() & validatesMessage())
			{				
			return true;
			}
		else
			return false;
	});	
	
function validatesSubject(){
	var dropdown1 = document.getElementById('ddlcomp_tyoe');
	var a = dropdown1.selectedIndex;
		if(a == 0){
			varsubject.addClass("error");
			return false;
		}
		
		else{
			if(a == 1)
			{
				varsubject.removeClass("error");
				document.getElementById("recid").style.display = "block";
				if(document.getElementById("recharge_id").value == "")
				{
					$('#recharge_id').addClass("error");
					return false;
				}
				else
				{
					$('#recharge_id').removeClass("error");
					return true;
				}
			}
			else
			{
			varsubject.removeClass("error");
			return true;
			}
		}
	}
	
		function validatesMessage(){
		if(varmessage.val() == ""){
			varmessage.addClass("error");
			return false;
		}
		else{
			varmessage.removeClass("error");
			return true;
		}
	}	
	setTimeout(function(){$('div.message').fadeOut(1000);}, 2000);
	
});
function test()
{
	var ddl = document.getElementById("ddlcomp_tyoe");
	if(ddl.selectedIndex == 0)
	{
		document.getElementById("recid").style.display="none";
	}
	if(ddl.selectedIndex == 1)
	{
		document.getElementById("recid").style.display="table-row";
	}
	if(ddl.selectedIndex == 2)
	{
		document.getElementById("recid").style.display="none";
	}
}
	</script>
</head>
<?php if($cmpl_flag == 1) {?>
<body class="twoColFixLtHdr" onLoad="setcompform()">
<?php } else {?>
<body class="twoColFixLtHdr" onLoad="setLoad()">
<?php } ?>
<div id="container">
 
 <?php require_once("RetailerMenu.php"); ?> 
  
  <div class="container">
    <h2 class="border shadow"><span id="myLabel">Add Complain</span></h2>           
    <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	?>
              <?php
	if($this->session->flashdata('message')){
	echo "<div class='message'>".$this->session->flashdata('message')."</div>";}
	?>
<div class="breadcrumb">
    <form method="post" action="<?php echo base_url()."Retailer/complain"; ?>" name="frmcomplain_view" id="frmcomplain_view" autocomplete="off">

<table cellpadding="3" cellspacing="3" border="0">

</table>
<div id="messagediv">
<table cellpadding="3" cellspacing="3" border="0">
<tr>
<td align="right">Subject : </td>
<td align="left">
<select id="ddlcomp_tyoe" name="ddlcomp_tyoe"  style="width:170px;" onChange="test()">
<option>----Select---- </option>
<option>Recharge Id</option>
<option>Other</option>
</select>

</td>

</tr>

<tr id="recid" style="display:none;">
<td align="right">Recharge Id : </td>
<td align="left">
<input type="text" name="recharge_id" id="recharge_id" title="Enter Recharge Id" class="text">

</td>

</tr>

<tr>
<td align="right" style="width:250px;"><label for="txtMessage">Message :</label></td><td align="left"><textarea class="text" title="Enter Message Regarding Your Complain" id="txtMessage" name="txtMessage" rows="5" cols="5">
</textarea>
</td>
</tr>

</table>

</div>
<table cellpadding="3" cellspacing="3" border="0">
<tr>
<td style="width:250px;"></td><td align="left"><input type="submit" class="button" id="btnSubmit" name="btnSubmit" value="Submit"/> 
<input type="reset" class="button" value="Cancel" name="btnCancel" id="btnCancel" />
</td>

</tr>
</table>

</form>
</div>
<h2 class="h2">View Complain</h2>
<table style="width:100%;font-size:14px;" cellpadding="3" cellspacing="0" border="0">
    <tr style="background: #CCCCCC;">
    <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Complain Id</th>
    <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Subject</th>
   <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Message</th>
    <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Recharge ID</th>
    <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Solve Date</th>
    <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Response Message</th>    
   <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >Status</th>    
    </tr>
    <?php	$i = 0;foreach($result_complain->result() as $result) 	{  ?>
	<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
     <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><?php echo $result->complain_id; ?></td>
  <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><?php echo $result->complain_type; ?></td>
  <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><?php echo $result->message; ?></td>
  <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><?php echo $result->recharge_id; ?></td>
  <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><?php echo $result->complainsolve_date; ?></td>  
  <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><?php echo $result->response_message; ?></td>  
  <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">
     <?php if($result->complain_status == "Pending"){echo "<span class='orange'>".$result->complain_status."</span>";} ?>
  <?php if($result->complain_status == "Solved"){echo "<span class='green'>".$result->complain_status."</span>";} ?>
  <?php if($result->complain_status == "Unsolved"){echo "<span class='red'>".$result->complain_status."</span>";} ?>
 </td>      
</tr>
		<?php 	
		$i++;} ?>
		</table>

       <?php  echo $pagination; ?>


	<!-- end #mainContent --></div>
	<!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
    <div id="footer">
     <?php require_once("general_footer.php"); ?>
  <!-- end #footer --></div>
<!-- end #container --></div>
  
</body>
</html>