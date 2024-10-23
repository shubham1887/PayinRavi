<!DOCTYPE html>

<html lang="en">

  <head>
<title>List Recharges</title>
	<?php include("elements/linksheader.php"); ?>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   <style>
.ui-datepicker { position: relative; z-index: 10000 !important; }
.mytable-border
{
    border-top: thin;
    border-bottom: thin;
    border-right: thin;
  border-left:thin;
}
.mytable-border tr td{
    border-top: thin !important;
    border-bottom: thin !important;
  border-left: thin !important;
    border-right: thin !important;
}
.mytable-border  tr{
    border-right: thin;
}
</style>
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     <script>
  function getdata()
  {
      document.getElementById("imageautoload").style.display = "block";
      $.ajax({
          
          
          url:document.getElementById("hidgetuserdataurl").value+"?text="+document.getElementById("ddluser").value,
          cache:false,
          type:'POST',
          success:function(data)
          {
             
              var data = data.split("^-^");
              var dataarr = data;
             
              $( "#ddluser" ).autocomplete({
                  
     
     source: function(request, response) {
        var results = $.ui.autocomplete.filter(dataarr, request.term);
        
        response(results.slice(0, 20));
    }
    });
          },
          complete:function()
          {
               document.getElementById("imageautoload").style.display = "none";
          }
          
      });
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
     <script>
  
$(document).ready(function(){
document.getElementById("ddlstatus").value = '<?php echo $ddlstatus; ?>';
document.getElementById("ddloperator").value = '<?php echo $ddloperator; ?>';
document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
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
    var db = document.getElementById("ddldb").value;
    document.getElementById("hidfrm").value = from;
    document.getElementById("hidto").value = to;
    document.getElementById("hiddb").value = db;
    document.getElementById("frmexport").submit();
  $('.DialogMask').hide();
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

    

    <?php include("elements/sdsidebar.php"); ?><!-- br-sideleft -->

    <!-- ########## END: LEFT PANEL ########## -->



    <!-- ########## START: HEAD PANEL ########## -->

    <?php include("elements/sdheader.php"); ?><!-- br-header -->

    <!-- ########## END: HEAD PANEL ########## -->



    <!-- ########## START: RIGHT PANEL ########## -->

    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## END: RIGHT PANEL ########## --->



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">

      <div class="br-pageheader">

        <nav class="breadcrumb pd-0 mg-0 tx-12">

          <a class="breadcrumb-item" href="<?php echo base_url()."SuperDealer/dashboard"; ?>">Dashboard</a>

          <a class="breadcrumb-item" href="#">Reports</a>

          <span class="breadcrumb-item active">RECHARGE REPORT</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div class="col-sm-6 col-lg-6">

          <h4>RECHARGE REPORT</h4>

        </div>

        <div class="col-sm-6 col-lg-6">

         <span class="breadcrumb-item active">

            <button class="btn btn-success btn-xs" type="button" style="font-size:14px;">Success : <?php echo $totalRecahrge; ?></button>

          </span>

          <span class="breadcrumb-item active">

            <button class="btn btn-primary btn-xs" type="button" style="font-size:14px;">Pending : <?php echo $totalpRecahrge; ?></button>

          </span>

          <span class="breadcrumb-item active">

            <button class="btn btn-danger btn-xs" type="button" style="font-size:14px;">Failure : <?php echo $totalfRecahrge; ?></button>

          </span>

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

                 <form action="<?php echo base_url()."SuperDealer/list_recharge?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmsubmit" id="frmsubmit">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                           <h5>From Date</h5>
                                           <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                      <td style="padding-right:10px;">
                                           <h5>To Date</h5>
                                            <input class="form-control-sm" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                        <td style="padding-right:10px;">
                                           <h5>Status</h5>
                                           <select id="ddlstatus" name="ddlstatus" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            
                                           </select>
                                        </td>
                                         
                                        <td style="padding-right:10px;">
                                           <h5>Operator</h5>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <?php $rsltcompany = $this->db->query("select * from tblcompany order by company_name");
                      foreach($rsltcompany->result() as $r)
                      { ?>
                                            <option value="<?php echo $r->company_id; ?>"><?php echo $r->company_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        
                                        <td style="padding-right:10px;">
                                           <h5>Number / Id</h5>
                                            <input class="form-control-sm" id="txtNumId" name="txtNumId" type="text" value="<?php echo $txtNumId; ?>" style="width:120px;" >
                                        </td>
                    <td style="padding-right:10px;">
                                           <h5>Data</h5>
                                           <select id="ddldb" name="ddldb" class="form-control-sm" style="width: 120px;">
                          <option value="LIVE">LIVE</option>
                         <option value="ARCHIVE">ARCHIVE</option>
                      </select>
                                        </td>
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-xs" style="font-size:12px;">
                                        </td>
                                        <td valign="bottom">
                                       
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-xs" onClick="startexoprt()" style="font-size:12px;">
                                        </td>
                                      
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-12 col-lg-12">

         	<div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">RECHARGE REPORT</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                 <?php  echo $pagination; ?> 
    <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  
    
    <th>Rec.Id</th>
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     <th>Time</th>
     <th>Agent Name</th>
     <th>opcode</th>
   <th>Mobile No</th>    
   <th>Amt</th>  
   <th>Status</th> 

    </tr>
    
    
    <?php $strrecid = "";$totalRecharge = 0;  $i = count($result_recharge->result());foreach($result_recharge->result() as $result)   
  {
    
  ?>
      
              <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
      
           
 <td>
     <a href="javascript:void(0)" >
         <?php echo $result->recharge_id; ?>
    </a>
     </td>
 <td><?php echo $result->operator_id; ?></td>
 <td style="font-size:10px;"><?php echo $result->add_date; ?></td>
 <td>
     <?php 
        if($result->update_time != "0000-00-00 00:00:00")
        {
            $recdatetime =date_format(date_create($result->add_date),'Y-m-d h:i:s');
            $cdate =date_format(date_create($result->update_time),'Y-m-d h:i:s');
            $now_date = strtotime (date ($cdate)); // the current date 
        $key_date = strtotime (date ($recdatetime));
        $diff = $now_date - $key_date;
        echo $diff;
        //echo  "<br>";    
        }
        
     //echo $result->update_time; 
     ?>
 </td>
 <!-- <td><?php echo $result->update_time; ?></td>-->
 <td><?php echo $result->username."<br>".$result->businessname; ?></td>
 <td><?php echo $result->mcode; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 <td>
 <?php 
 if($result->recharge_status == 'Pending'){echo "<span class='label btn-warning'>Pending</span>";}
 if($result->recharge_status == 'Success')
 {
  $totalRecharge += $result->amount;echo "<span class='label btn-success'>Success</span>";
 }
 if($result->recharge_status == 'Failure')
 {
   if($result->edit_date == 3)
   {
      echo "<span class='label btn-primary'>Reverse</span>"; 
   }
   else
   {
     echo "<span class='label btn-danger'>Failure</span>";
   }
  
 }
 
 
 ?></td>


 
 
  
 </tr>
 
    <?php   
    $i--;} ?>
        <tr style="background-color:#CCCCCC;">  
    
    <th></th>  
      <th></th>  
       <th > </th>
      <th > </th>
     <th  > </th>
     <th > </th>
      
     
   <th >Total </th>    
   <th ><?php echo $totalRecharge; ?></th>    
   <th > </th>
  
    </tr>
    </table> 

              </div><!-- card-body -->

            </div>

             <?php  echo $pagination; ?> 

        </div>

        </div>

      </div><!-- br-pagebody -->

      

<form id="frmexport" name="frmexport" action="<?php echo base_url()."SuperDealer/list_recharge/dataexport" ?>" method="get">

                                    <input type="hidden" id="hidfrm" name="from">

                                    <input type="hidden" id="hidto" name="to">

                                    <input type="hidden" id="hiddb" name="db">

                                    

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

