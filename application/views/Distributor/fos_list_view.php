<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>Fos List</title>



    

     

    

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

});

	

	function startexoprt()

{

		$('.DialogMask').show();

		

		var from = document.getElementById("txtFrom").value;

		var to = document.getElementById("txtTo").value;

		document.getElementById("hidfrm").value = from;

		document.getElementById("hidto").value = to;

		document.getElementById("frmexport").submit();

	$('.DialogMask').hide();

}

	</script>

  </head> 



  <body>

<div class="DialogMask" style="display:none"></div>

   <div id="myOverlay"></div>

<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>

    <!-- ########## START: LEFT PANEL ########## -->

    

    <?php include("elements/distsidebar.php"); ?><!-- br-sideleft -->

    <!-- ########## END: LEFT PANEL ########## -->



    <!-- ########## START: HEAD PANEL ########## -->

    <?php include("elements/distheader.php"); ?><!-- br-header -->

    <!-- ########## END: HEAD PANEL ########## -->



    <!-- ########## START: RIGHT PANEL ########## -->

    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## END: RIGHT PANEL ########## --->



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">

      <div class="br-pageheader">

        <nav class="breadcrumb pd-0 mg-0 tx-12">

          <a class="breadcrumb-item" href="<?php echo base_url()."Distributor/dashboard"; ?>">Dashboard</a>

          <a class="breadcrumb-item" href="#">FOS</a>

          <span class="breadcrumb-item active">FOS List</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>FOS List</h4>

        </div>

      </div><!-- d-flex -->



      <div class="br-pagebody">

      	<div class="row row-sm mg-t-20">

        <?php include("elements/messagebox.php"); ?>

          <div class="col-sm-6 col-lg-12">

            <div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                  <form action="<?php echo base_url()."Distributor/fos_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">                            

                                    <input type="hidden" id="hidID" name="hidID">                                     

                                    <input type="hidden" id="hidID" name="hidID">                                     
                                    <table cellspacing="10" cellpadding="3">                                     
                                    <tr>                                     	
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>FOS NAME</h5>                                             
                                    <input class="form-control-sm" id="txtAGENTName" value="<?php echo $txtAGENTName; ?>" name="txtAGENTName" type="text" style="width:120px;" >                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>FOS ID</h5>                                             
                                    <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text" style="width:120px;" >                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>MOBILE NO</h5>                                              
                                    <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text" style="width:120px;" >                                         
                                    </td>                                         
                                    <td valign="bottom">                                         
                                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-sm">                                    </td>
                                    </tr>
                                    </table>                                                                                                                                                                  </form>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-12 col-lg-12">

         	<div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">FOS LIST</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                <table class="table table-striped .table-bordered" style="font-size:14px;color:#000000">
    <tr>
  		<th>Sr No</th>
	   <th>Agent Id</th>
	   <th>Agent Name</th>
	   <th>Mobile</th>
	   <th>State</th>   
	   <th>City</th> 
	   <th>Group Name</th> 
	   <th>DMR.GROUP</th>
	   <th style="width: 80px;">Balance</th> 
	   <th style="width: 80px;">Wallet 2</th> 
	   <th style="width: 80px;">Login</th>
	   <th>Action</th>                 
    </tr>
  
                      
       
    <?php
			$struser = '';	
		$i = 0;foreach($result_dealer->result() as $result) 	
		{  
		$struser .= $result->user_id."#";
		?>
    
    
		<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo $i+1; ?></td>
 <td ><?php echo $result->username; ?></td>
<td ><a href="<?php echo base_url()."_Admin/profile/view/".$this->Common_methods->encrypt("FOS")."/".$this->Common_methods->encrypt($result->user_id);?>" target="_blank"><?php 
if($result->businessname == "")
{
        echo "Unknown"; 
}
else
{
    echo $result->businessname;     
}
?></a></td>
  <td ><?php echo $result->mobile_no; ?></td>
 <td ><?php echo $result->state_name; ?></td>
 <td ><?php echo $result->city_name; ?></td>
<td ><?php echo $result->group_name; ?></td>

<!-- dmr group td -->			
			
<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">
 </td>			
			
<!-- end dmr group td -->
			
<td><span id="spanbalance<?php echo $result->user_id; ?>"></span></td>
<td><span id="spanbalance2<?php echo $result->user_id; ?>"></span></td>
<td>
<?php if($result->status == 0){echo "<span class='red'>Deactive</span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$result->user_id.",0)'>Active</a></span>";} ?>
</td>







 <td width="180px">
  
 <?php 
 
 echo '<a class="fas fa-plus-square" style="font-size:16px;" title="Transfer Money" href="'.base_url().'Distributor/add_balance?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"></a> | ';
 
 
	
	
echo '<a style="font-size:16px;" title="Transfer Money" href="'.base_url().'Distributor/add_balance2?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"><img src="'.base_url().'files/rupee.png" style="width:20px;"/></a> | ';
	
	?>
 </td>
 </tr>
		<?php 	
		$i++;} ?>
		</table>

              </div><!-- card-body -->

            </div>

             <?php  echo $pagination; ?> 

        </div>

        </div>

      </div><!-- br-pagebody -->

      <script language="javascript">
 function setrechargelimit(user_id)
 {
 	document.getElementById("txtminrechargelimit"+user_id).style.backgroundColor = "yellow";
 	var minrechargelimit = document.getElementById("txtminrechargelimit"+user_id).value;
	$.ajax({
	url:'<?php echo base_url()."Distributor/agent_list/minRechargeLimit";?>?minrechargelimit='+minrechargelimit+'&id='+user_id,
	method:'POST',
	cache:false,
	success:function(html)
	{
		document.getElementById("txtminrechargelimit"+user_id).style.backgroundColor = "white";
	}
	
	});
 }
 </script>	
		
<script language="javascript">
function changedmrgroup(id)
{
	var myval = document.getElementById("ddldmrgroup_"+id).value;
	document.getElementById("ddldmrgroup_"+id).style.display="none";
	$.ajax({
	url:'<?php echo base_url()."Distributor/agent_list/changedmrgroup?id=";?>'+id+'&field='+myval,
	cache:false,
	method:'POST',
	success:function(html)
	{
			document.getElementById("ddldmrgroup_"+id).style.display="block";
		document.getElementById("ddldmrgroup_"+id).value = html;
	}
	});
}
</script>		
<script language="javascript">
function actionDeactivate(id,status)
{
	document.getElementById("hiduserid").value = id;
	document.getElementById("hidstatus").value = status;
	document.getElementById("hidaction").value = "Set";
	document.getElementById("frmstatuschange").submit();
}
</script>
 <input type="hidden" id="hidurltoggle" value="<?php echo base_url()."Distributor/agent_list/togglegroup"; ?>">
        <script language="javascript">
		function actionToggle(id,sts)
		{
			$.ajax({
				url:document.getElementById("hidurltoggle").value+'?id='+id+'&sts='+sts,
				cache:false,
				type:'POST',
				success:function(html)
				{
					window.location.reload(1);
				}
			
			});
		}
		
		
		function mtcheck(id)
		{
			if(document.getElementById("chkmt"+id).checked == true)      
			{      
				$.ajax({
				url:'<?php echo base_url()."Distributor/agent_list/setvalues?"; ?>Id='+id+'&field=MT&val=1',
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
				url:'<?php echo base_url()."Distributor/agent_list/setvalues?"; ?>Id='+id+'&field=MT&val=0',
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
		<script language="javascript">
  function getuserbalance()
{
		var struser = document.getElementById("hidusers").value;
		var struserarr = struser.split("#");
		for(i=0;i<struserarr.length;i++)
		{
			var id = struserarr[i];
			if(id > 0)
			{
			$.ajax({
			url:document.getElementById("hidbaseurl").value+'/getbalance?id='+id,
			method:'POST',
			cache:false,
			success:function(html)
			{	
				var strbalarid = html.split("#");
				//alert(html + "0 = "+strbalarid[0]+"  1 = "+strbalarid[1]);
				document.getElementById("spanbalance"+strbalarid[0]).innerHTML = strbalarid[1];
				document.getElementById("spanbalance2"+strbalarid[0]).innerHTML = strbalarid[2];
				
				
			}
			
			});
			}
			
		}
		
	}
	$(document).ready(function()
	{
		getuserbalance();
		
	});	
</script>
		<input type="hidden" id="hidbaseurl" value="<?php echo base_url()."Distributor/agent_list"; ?>">
  <input type="hidden" id="hidusers" value="<?php echo  $struser; ?>">


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