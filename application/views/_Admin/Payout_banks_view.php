<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>PAYOUT BANKS</title>

    
    
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

<style>
.myselect {
  margin: 1px  !important; ;
  width: 70px  !important; ;
  padding: 1px 5px 1px 1px  !important; ;
  font-size: 12px  !important; ;
  border: 1px solid #ccc  !important; ;
  height: 24px  !important; ;
}
.retry
{
	background:#FBC6FB;
}
.dont
{
	background:#C0C0C0;
}
.manual
{
background:#C0C6C0;
}
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


.modal-ku {
  width: 950px;
  margin: auto;
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
          <a class="breadcrumb-item" href="#">REPORT</a>
          <span class="breadcrumb-item active">PAYOUT BANKS</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        
        <div class="col-sm-6 col-lg-12">
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-14 col-lg-14">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">PAYOUT BANKS</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  
                
    <table class="table is-narrow is-hoverable is-fullwidth" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  
    
    <th>Sr</th>
    <th>Agent Name</th>
    <th>BankName</th>
    <th>AccountName</th>
	  <th>Account Number</th>    
	  <th>IFSC</th>  
	  <th>Status</th> 
	  <th></th>
	 
	 
    
   
    </tr>
    
    
    <?php $i = 1;
    foreach($result_data->result() as $result) 	
	{?>
    
            	<tr  id="tr_<?php echo $result->Id; ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
			
           
 <td style="font-size:10px;"><?php echo $i; ?></td>
 
 <td><?php echo $result->username."<br>".$result->businessname; ?></td>
 <td><?php echo $result->bank_name; ?></td>
 <td><?php echo $result->account_name; ?></td>
 <td><?php echo $result->account_number; ?></td>
 
 <td><?php echo $result->ifsc;?></td>
 <td>
    <span id="spanstatus<?php echo $result->Id; ?>">
    <?php 
      if($result->status == "Active")
      { ?>
          <b class="btn btn-success btn-sm"><?php echo $result->status;?></b>
      <?php }
      else
      {?>
        <b class="btn btn-danger btn-sm"><?php echo $result->status;?></b>
      <?php }
          
    ?>
    </span></td>

<td>
	<select id="ddlstatus<?php echo $result->Id; ?>">
		<option value="0">Select</option>
		<option value="Active">Active</option>
		<option value="Deactive">Deactive</option>
	</select>
	<img id="imgloading<?php echo $result->Id; ?>" src="<?php echo base_url()."Loading.gif" ?>" style="width:30px;display: none;" >
</td>

<td>
  <input type="button" name="btnSubmitUpdate" value="Submit" class="btn btn-warning btn-sm" onclick="updatestatusbyddl('<?php echo $result->Id; ?>')">
 </td>
</tr>

		<?php 	
		$i--;} ?>
		</table> 
              </div><!-- card-body -->
            </div>

        </div>
        </div>
      </div><!-- br-pagebody -->
      <input type="hidden" id="hidstatusupdateurl" value="<?php echo base_url();?>_Admin/payout_banks/updatastatus">
<script type="text/javascript">
    function updatestatusbyddl(id)
    {

          var status = document.getElementById("ddlstatus"+id).value;
           $.ajax({
					type:"POST",
					url:document.getElementById("hidstatusupdateurl").value,
					data:{'Id':id,'status':status},
					beforeSend: function() 
					{
						 $('#tr_'+id).addClass("primary");
						document.getElementById("imgloading"+id).style.display="block";
            		   //document.getElementById("spanpopupalertmessage").innerHTML="";
					   //document.getElementById("popupalertdiv").style.display="none";
                       //document.getElementById("spanloader").style.display="block";
                    },
					success: function(response)
					{
           document.getElementById("imgloading"+id).style.display="none";

					    //alert(response);
					    //document.getElementById("spanloader").style.display="none";
					    //document.getElementById("popupalertdiv").style.display="block";
						var jsonobj = JSON.parse(response);
						var msg = jsonobj.message;
						var sts = jsonobj.status;
						if(sts == "0")
						{

              if(status == "Active")
              {
                document.getElementById("spanstatus"+id).innerHTML = '<b class="btn btn-success btn-sm">'+status+'</b>';     
              }
              else
              {
                document.getElementById("spanstatus"+id).innerHTML = '<b class="btn btn-danger btn-sm">'+status+'</b>';   
              }

              
						    //$('#tr_'+id).fadeOut("fast");
               // document.getElementById('#tr_'+id).style.display = "none";
						    //$("#popupalertdiv").addClass('alert-success');
						    //document.getElementById("spanpopupalertmessage").innerHTML = msg;   
						    //document.getElementById("tdstatus"+id).innerHTML = "<span class='label btn-success'>Success</span>";
						}
						else
						{
						
						     //$("#popupalertdiv").addClass('alert-danger');
						    //document.getElementById("spanpopupalertmessage").innerHTML = msg;
						}
						
						 
					
						console.log(response);  
					},
					error:function(response)
					{
					    //$("#popupalertdiv").addClass('alert-danger');
					  //document.getElementById("spanloader").style.display="none";
					  //document.getElementById("popupalertdiv").style.display="block";
					  //document.getElementById("spanpopupalertmessage").innerHTML = "Some Error Occured";
					},
					complete:function()
					{
					    //document.getElementById("popupalertdiv").style.display="block";
					    //document.getElementById("spanloader").style.display="none";
						
					}
				});

							 
       
    }
</script>




<div class="modal fade" id="myResponseModal" role="dialog">
    <div class="modal-dialog modal-lg"   >
      <div class="modal-content">
        <div class="modal-header btn-success">
            <h4 class="modal-title ">Request/Response Log</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
              
            </div>
        <div class="modal-body">
            <span id="log_spanloader" style="display:none">
              <img id="log_imgloading" src="<?php echo base_url()."Loading.gif"; ?>" style="max-width:80px">
            </span>
           
            
          
          <div id="log_reqresp" style="overflow:auto;height:500px;word-break: break-all;">
              
          	
                
          </div>
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
    <style>
        .modal-footer {
    /* display: flex; */
    align-items: left;
    justify-content: flex-end;
    padding: 1rem;
    border-top: 1px solid #e9ecef;
}
    </style>
     
  </body>
</html>
