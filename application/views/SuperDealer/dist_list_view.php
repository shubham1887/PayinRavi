<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Destributor List</title>
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
  <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
<script language="javascript">
    function getCityName(urlToSend)
  {
    if(document.getElementById('ddlState').selectedIndex != 0)
    {
      document.getElementById('hidStateCode').value = $("#ddlState")[0].options[document.getElementById('ddlState').selectedIndex].getAttribute('code');          
    $.ajax({
  type: "GET",
  url: urlToSend+""+document.getElementById('ddlState').value,
  success: function(html){
    $("#ddlCity").html(html);
  }
});
    }
  }
</script>
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
    
    </head><body>
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
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
            <div class="br-pageheader">
            <nav class="breadcrumb pd-0 mg-0 tx-12">
              <a class="breadcrumb-item" href="<?php echo base_url()."SuperDealer/dashboard"; ?>">Dashboard</a>
              <a class="breadcrumb-item" href="#">Distributor</a>
              <span class="breadcrumb-item active">Distributor List</span>
            </nav>
            </div><!-- br-pageheader -->
            <!-- d-flex -->
             
               <div class="br-pagebody">
                     <?php include("elements/messagebox.php"); ?>
            <div class="row row-sm mg-t-20">
                    <div class="col-sm-12 col-lg-12">
                    <div class="card shadow-base bd-0">
                      <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                      <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                      
                      </div><!-- card-header -->
                      <div class="card-body">
                                          
                                          <form action="<?php echo base_url()."SuperDealer/dist_list?crypt=".$this->Common_methods->encrypt("MyData") ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                      <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label">Dist. Name</h5>
                                          <input class="form-control-sm datepicker" type="text" value="<?php echo $txtAGENTName; ?>"  id="txtAGENTName" name="txtAGENTName"  placeholder="Distributor Name" >    
                                      </div>
                                          
                                        </td>
                                        <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label">Dist. ID</h5>
                                            <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text"  placeholder="Distributor USER ID">
                         
                                      </div>
                                        </td>
                                         <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label">Mobile No</h5>
                                         <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text"  placeholder="Distributor MOBILE NO">
                         
                                      </div>
                                        </td>
                                        
                                        <td style="padding-right:10px;">
                                         <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label"><br></h5>
                                         <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-sm">
                         
                                      </div>
                                        
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                          
                                        </div>
                              </div>
                        </div>
                  </div>
             <div class="row row-sm mg-t-20">
                    <div class="col-sm-12 col-lg-12">
                    <div class="card shadow-base bd-0">
                      <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                      <h6 class="card-title tx-uppercase tx-12 mg-b-0">UserList List</h6>
                      <span class="tx-12 tx-uppercase">
                        <a href="<?php echo base_url()."SuperDealer/dist_registration" ?>"  class="blue btn btn-primary btn-sm" > <i class="ace-icon fa fa-plus bigger-120"></i>Add New User </a>
                      
                      </span>
                      </div><!-- card-header -->
                      <div class="card-body">
                                          
                                          
                                          
                                          <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
      <th>Sr No</th>
     <th>Agent Id</th>
     <th>Agent Name</th>
     <th >Parent Name</th>
     <th>Mobile</th>
     <th>State</th>   
     <th>City</th> 
     <th>Group Name</th> 
     <th style="width: 80px;">Grouping</th> 
     <th>DMR.GROUP</th>
     <th style="width: 80px;">Balance</th> 
     <th style="width: 80px;">Login</th>
     <th>DMR</th>
     <th>Action</th>                 
    </tr>
  
                      
       
    <?php
        $dmrgroup_dropdownitem = '';
        $rsltdmrgroup = $this->db->query("select * from mt3_group ");
        foreach($rsltdmrgroup->result() as $dmrrow)
        {
          $dmrgroup_dropdownitem .='<option value="'.$dmrrow->Id.'">'.$dmrrow->Name.'</option>';
        } 
                  
      $struser = '';            
    $i = 0;foreach($result_dealer->result() as $result)   
    {  
      $balance = '';
      $balance2 = '';
      $struser .= $result->user_id."#";
    ?>
    
    
    <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo $i+1; ?></td>
 <td ><?php echo $result->username; ?></td>
<td ><a href="<?php echo base_url()."SuperDealer/profile?usertype=".$this->Common_methods->encrypt("Distributor")."&user_id=".$this->Common_methods->encrypt($result->user_id);?>" target="_blank"><?php 
if($result->businessname == "")
{
        echo "Unknown"; 
}
else
{
    echo $result->businessname;     
}
?></a></td>
<td ><a href="<?php echo base_url()."SuperDealer/profile/view/".$this->Common_methods->encrypt("Distributor")."/".$this->Common_methods->encrypt($result->parentid);?>" target="_blank"><?php echo $result->parent_name; ?></a></td>
  <td ><?php echo $result->mobile_no; ?></td>
 <td ><?php echo $result->state_name; ?></td>
 <td ><?php echo $result->city_name; ?></td>
<td ><?php echo $result->group_name; ?></td>
<td>
<?php if($result->grouping == 0)
{?>
<span class='btn btn-success' >
  <a href='#' style="color:#FFFFFF" onclick='actionToggle("<?php echo $result->user_id;?>",1)'>Individual</a>
</span>
<?php }
else
{?>
  <span class='btn btn-success btn-sm'>
    <a href='#' style="color:#FFFFFF" onclick='actionToggle("<?php echo $result->user_id;?>",0)'>GroupWise</a>
  </span>
<?php } ?>
</td>
<!-- dmr group td -->     
      
<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">
 
  <select id="ddldmrgroup_<?php echo $result->user_id; ?>" onChange="changedmrgroup('<?php echo $result->user_id; ?>')" style="width:100px;">
    <option value="0">Select</option>
    <option value="0">Default</option>
    <?php echo $dmrgroup_dropdownitem;?>
  </select>
  <script language="javascript">
    document.getElementById("ddldmrgroup_"+<?php echo $result->user_id; ?>).value = '<?php echo $result->dmr_group; ?>';
  </script>
 </td>      
      
<!-- end dmr group td -->
      
<td style="width:140px;min-width:140px;"><span id="spanbalance<?php echo $result->user_id; ?>"></span></td>
<td>
<?php if($result->status == 0){echo "<span class='red'><a href='#' onclick='actionDeactivate(".$result->user_id.",1)'>Deactive</a></span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$result->user_id.",0)'>Active</a></span>";} ?>
</td>



<td>
<?php
  //echo $result->mt_access;
  if($result->enabled == 'yes')
  {
   ?>
  <div class="panel panel-default"> 
      <input checked class="filled-in chk-col-purple" type="checkbox" id="chksts<?php echo $result->user_id; ?>" name="chksts<?php echo $result->user_id; ?>" value="<?php echo $result->user_id; ?>" onClick="stscheck('<?php echo $result->user_id; ?>')">
        <label for="chksts<?php echo $result->user_id; ?>"></label>
    </div>
  <?php }
  else
  {?>
  <div class="panel panel-default"> 
      <input  class="filled-in chk-col-purple"  type="checkbox" id="chksts<?php echo $result->user_id; ?>" name="chksts<?php echo $result->user_id; ?>" value="<?php echo $result->user_id; ?>" onClick="stscheck('<?php echo $result->user_id; ?>')">
        <label for="chksts<?php echo $result->user_id; ?>"></label>
    </div>
    
  <?php }
 ?>
</td>



 <td width="180px">
  <a class="far fa-edit" style="font-size:18px;" href="<?php echo base_url()."SuperDealer/dist_edit?id=".$this->Common_methods->encrypt($result->user_id); ?>" title="Edit Franchise"></a> 
   |       

 <?php 
 
 echo '<a class="fas fa-plus-square" style="font-size:16px;" title="Transfer Money" href="'.base_url().'SuperDealer/add_balance?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"></a> | ';
 
 echo '<a class="fas rupee" style="font-size:16px;" title="Transfer Money" href="'.base_url().'SuperDealer/add_balance2?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"><img style="width:30px;" src="'.base_url().'files/rupee.png"></a> | ';
  
  
  if($this->session->userdata("ausertype") == "Admin"){
 echo ' <a style="font-size:16px;" class="fas fa-share" href="'.base_url().'directaccess/process/'.$this->Common_methods->encrypt($result->user_id).'" target=_blank></a>';} ?>
 <a style="cursor:pointer" class="fas fa-trash-alt" onClick="Confirmation('<?php echo $result->user_id; ?>')"></a> 
 </td>
 </tr>
    <?php   
    $i++;} ?>
    </table>
                    
                    
                                        
                                        <?php  echo $pagination; ?>         
                                      <form id="frmstatuschange" action="<?php echo base_url()."SuperDealer/distributor_list"; ?>" method="post"> 
                                      <input type="hidden" id="hiduserid" name="hiduserid"> <input type="hidden" id="hidstatus" name="hidstatus"> 
                                      <input type="hidden" id="hidaction" name="hidaction"> 
                                      </form>         
                                      <!-- end page-wrapper -->          
                                      <script language="javascript">  
                                      function setrechargelimit(user_id)  
                                      {   
                                          document.getElementById("txtminrechargelimit"+user_id).style.backgroundColor = "yellow";    
                                          var minrechargelimit = document.getElementById("txtminrechargelimit"+user_id).value;  
                                          $.ajax({  
                                              url:'<?php echo base_url()."SuperDealer/distributor_list/minRechargeLimit";?>?minrechargelimit='+minrechargelimit+'&id='+user_id,  
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
                                              url:'<?php echo base_url()."SuperDealer/distributor_list/changedmrgroup?id=";?>'+id+'&field='+myval,   
                                              cache:false,  method:'POST',  
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
                                      <input type="hidden" id="hidurltoggle" value="<?php echo base_url()."SuperDealer/distributor_list/togglegroup"; ?>">         
                                      <script language="javascript">    
                                      function actionToggle(id,sts)     
                                      {       $.ajax({        
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
                                                  url:'<?php echo base_url()."SuperDealer/distributor_list/setvalues?"; ?>Id='+id+'&field=MT&val=1',         
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
                                                  url:'<?php echo base_url()."SuperDealer/distributor_list/setvalues?"; ?>Id='+id+'&field=MT&val=0',         
                                                  cache:false,        
                                                  method:'POST',        
                                                  success:function(html)        
                                                  {           
                                                      alert(html);        
                                                      
                                                  }         
                                                  
                                              });             
                                              
                                          }       
                                          
                                      } 
                                      function stscheck(id)
                                    {
                                      if(document.getElementById("chksts"+id).checked == true)      
                                      {      
                                        $.ajax({
                                        url:'<?php echo base_url()."SuperDealer/agent_list/setvalues?"; ?>Id='+id+'&field=ENABLED&val=yes',
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
                                        url:'<?php echo base_url()."SuperDealer/agent_list/setvalues?"; ?>Id='+id+'&field=ENABLED&val=no',
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
                                                        document.getElementById("spanbalance"+strbalarid[0]).innerHTML = strbalarid[1]+" | "+strbalarid[2];
                                                        }             
                                                        }); 
                                                        
                                                }           
                                            }       
                                        }   
                                        $(document).ready(function()  
                                        {   
                                          
                                        getuserbalance();       
                                        }); 
                                        
                                        
    function Confirmation(value)
  {
  
    if(confirm("Are you sure?\nyou want to delete ") == true)
    {
      document.getElementById('hidValue').value = value;
      document.getElementById('frmDelete').submit();
    }
  }
                                                        </script>   
                                      <input type="hidden" id="hidbaseurl" value="<?php echo base_url()."SuperDealer/Md_list"; ?>">  
                                      <input type="hidden" id="hidusers" value="<?php echo  $struser; ?>">  
                                       <form action="<?php echo base_url()."SuperDealer/md_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="delete" />
</form>
                                        
                                        
                                        
                    
                    <script language="javascript">
                          function editform(id)
                          {
                            
                            document.getElementById("hidPrimaryId").value =  id;
                  document.getElementById("HIDACTION").value =  "UPDATE";document.getElementById("txtUserId").value =  document.getElementById("hidusername"+id).value;document.getElementById("txtName").value =  document.getElementById("hidbusinessname"+id).value;document.getElementById("txtMobile").value =  document.getElementById("hidmobile_no"+id).value;document.getElementById("txtEmail").value =  document.getElementById("hidemailid"+id).value;document.getElementById("txtAddress").value =  document.getElementById("hidpostal_address"+id).value;document.getElementById("txtState").value =  document.getElementById("hidstate_id"+id).value;document.getElementById("txtCity").value =  document.getElementById("hidCity"+id).value;document.getElementById("txtGroup").value =  document.getElementById("hiddmr_group"+id).value;
                          }
                          </script></div>
                              </div>
                        </div>
                  </div><!-- end <div class=row -->
                </div><!-- br-pagebody -->
        <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
  
  
  <!-- ########## END: MAIN PANEL ########## -->
  
  
  
  <script src="<?php echo base_url(); ?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url(); ?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/rickshaw/vendor/d3.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/rickshaw/vendor/d3.layout.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/rickshaw/rickshaw.min.js"></script>

    <script src="<?php echo base_url(); ?>js/bracket.js"></script>
    <script src="<?php echo base_url(); ?>js/ResizeSensor.js"></script>
    <script src="<?php echo base_url(); ?>js/widgets.js"></script>
      <script language="javascript">
    function gethourlysale()
    {
      
    $.ajax({
          type: "GET",
          url: '<?php echo base_url(); ?>SuperDealer/dashboard/getTodaysHourSale',
          cache: false,
          success: function(html)
          {
            var jsonobj = JSON.parse(html);
            var hourlysale = jsonobj.hourlysale;
            var totalsale = jsonobj.totalsale;
            var totalcount = jsonobj.totalcount;
            var totalcharge = jsonobj.totalcharge;
            
            
            document.getElementById("spark1").innerHTML = hourlysale;
            document.getElementById("spark1_totalsale").innerHTML = totalsale;
            document.getElementById("spark1_totalsale2").innerHTML = totalsale;
            document.getElementById("spark1_totalcharge").innerHTML = totalcharge;
            
            document.getElementById("spark1_totalcount").innerHTML = totalcount;
            
            //sidebar
            document.getElementById("sidebargrosssuccess").innerHTML = totalsale;
            
            
            
          },
          complete:function()
          {
          
            $('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
            //document.getElementById("sp"+tempapiname+"bal").style.display="block";
            //document.getElementById("spin"+tempapiname+"balload").style.display="none";
          } });
    }
    
    
    function gethourlyRickshawGraph()
    {
      
    $.ajax({
          type: "GET",
          url: '<?php echo base_url(); ?>SuperDealer/dashboard/getTodaysHourSale',
          cache: false,
          success: function(html)
          {
            var jsonobj = JSON.parse(html);
            var hourlysale = jsonobj.hourlysale;
            var totalsale = jsonobj.totalsale;
            var totalcount = jsonobj.totalcount;
            var totalcharge = jsonobj.totalcharge;
            
            
            
            var arr = [];
            var t =hourlysale.split(",");
            var r2_graf_max = 0;
            for (var i = 0; i < t.length-1; i++) 
            {
                var temparr = {};
                temparr = {x:i,y:+t[i]};
                arr.push(temparr);
                if(+t[i] > r2_graf_max) 
                {
                  r2_graf_max = +t[i];
                }
            }
             
            
            
            console.log(Math.max(+t));
            var rs2 = new Rickshaw.Graph({
            element: document.querySelector('#rickshaw2'),
            renderer: 'area',
            max: r2_graf_max,
            series: [{
              data: arr,
              color: '#1CAF9A'
            }]
            });
            rs2.render();
             // Responsive Mode
  new ResizeSensor($('.br-mainpanel'), function(){
    rs2.configure({
      width: $('#rickshaw2').width(),
      height: $('#rickshaw2').height()
    });
    rs2.render();
  });
            
            
          },
          complete:function()
          {
          
            $('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
            //document.getElementById("sp"+tempapiname+"bal").style.display="block";
            //document.getElementById("spin"+tempapiname+"balload").style.display="none";
          } });
    }
    
$(document).ready(function()
  {
   // setTimeout(function(){window.location.reload(1);}, 50000);
    //get_load();
    //get_load2()
    gethourlysale();
    gethourlyRickshawGraph();
    //get_operatorpendings();
    //get_operatorrouting();
      get_Paytmbalance();
      //get_M2mbalance();
    //get_Maharshibalance();
    //get_Dmrbalance();
    //get_DMRValues();
  
    //get_SuccessRecharge();
      //window.setInterval(get_load, 60000 * 10);
    window.setInterval(gethourlysale, 2000);  
    window.setInterval(gethourlyRickshawGraph, 60000);  
    //window.setInterval(get_operatorrouting, 60000); 
    //window.setInterval(get_balance, 60000 * 10);
    window.setInterval(get_Paytmbalance, 60000);
    //window.setInterval(get_M2mbalance, 60000);
    //window.setInterval(get_Maharshibalance, 60000);
    //window.setInterval(get_SuccessRecharge, 60000);
  
    //window.setInterval(get_DMRValues, 60000);
  
    
    setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
               });
               
               
               
  function get_Paytmbalance(){$.ajax({type: "GET",url: '<?php echo base_url(); ?>/SuperDealer/Dashboard/getAllBalance?api_name=PAYTM',cache: false,success: function(html){$("#spanPAYTMbal").html(html);}});$("#spanPAYTMbal").fadeOut(1000);$("#spanPAYTMbal").fadeIn(2000);}  
  </script>
    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1199px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1199px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1200px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>
  </body>
</html>
  
  <!-------------------------------------- DELETE MODEL START ----------------------->                
                <div id="modal-formdelete" class="modal" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">Are You Soure Want To Delete <span id="spanDeletePopupName"></span></h4>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                          <i class="ace-icon fa fa-times"></i>
                          Cancel
                        </button>

                        <button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="deletesubmit()">
                          <i class="ace-icon fa fa-check"></i>
                          Yes
                        </button>
                        <script language="javascript">
                          function deletesubmit()
                          {
                            document.getElementById("HIDACTION").value="DELETE";
                            document.getElementById("frmPopup").submit();
                          }
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------><!-------------------------------------- INSERT EDIT MODEL START ----------------------->                
                <div id="modal-form" class="modal" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">Please fill the following form fields</h4>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          
                          <div class="col-xs-12 col-sm-7">
                          <?php echo form_open('',array('id'=>"frmPopup",'method'=>'post'))?>
                        
                          <input type="hidden" id="hidPrimaryId" name="hidPrimaryId">
                          
                                        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
                                        <div class="form-group">
                                            <label for="form-field-select-3">UserId</label>
                                            <div>
                                              <input type="text" name="txtUserId" id="txtUserId" class="form-control">
                                            </div>
                                          </div>
                                          <div class="space-4"></div>
                                        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
                                        <div class="form-group">
                                            <label for="form-field-select-3">Name</label>
                                            <div>
                                              <input type="text" name="txtName" id="txtName" class="form-control">
                                            </div>
                                          </div>
                                          <div class="space-4"></div>
                                        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
                                        <div class="form-group">
                                            <label for="form-field-select-3">Mobile</label>
                                            <div>
                                              <input type="text" name="txtMobile" id="txtMobile" class="form-control">
                                            </div>
                                          </div>
                                          <div class="space-4"></div>
                                        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
                                        <div class="form-group">
                                            <label for="form-field-select-3">Email</label>
                                            <div>
                                              <input type="text" name="txtEmail" id="txtEmail" class="form-control">
                                            </div>
                                          </div>
                                          <div class="space-4"></div>
                                        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
                                        <div class="form-group">
                                            <label for="form-field-select-3">Address</label>
                                            <div>
                                              <input type="text" name="txtAddress" id="txtAddress" class="form-control">
                                            </div>
                                          </div>
                                          <div class="space-4"></div>
                              
                                <div class="form-group">
                                <label for="form-field-select-3">State</label>
                                <div>
                                  <select name="txtState" id="txtState" class="form-control">
                                  <option value="0">Select</option><?php 
                                $qry = "select * from tblstate";
                                  $rsltddl6 = $this->db->query($qry);
                                  foreach($rsltddl6->result() as $rdd)
                                  {?>
                                    <option value="<?php echo $rdd->Id?>"><?php echo $rdd->state_name?></option>
                                  <?php } ?>
                                  
                                  </select>
                                  
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                                <div class="form-group">
                                <label for="form-field-select-3">City</label>
                                <div>
                                  <select name="txtCity" id="txtCity" class="form-control">
                                  <option value="0">Select</option>
                                  </select>
                                  
                                </div>
                              </div>
                              <div class="space-4"></div>
                              
                                <div class="form-group">
                                <label for="form-field-select-3">Group</label>
                                <div>
                                  <select name="txtGroup" id="txtGroup" class="form-control">
                                  <option value="0">Select</option><?php 
                                $qry = "select * from mt3_group";
                                  $rsltddl8 = $this->db->query($qry);
                                  foreach($rsltddl8->result() as $rdd)
                                  {?>
                                    <option value="<?php echo $rdd->Id?>"><?php echo $rdd->Name?></option>
                                  <?php } ?>
                                  
                                  </select>
                                  
                                </div>
                              </div>
                              <div class="space-4"></div>
                            <?php echo form_close();?>
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                          <i class="ace-icon fa fa-times"></i>
                          Cancel
                        </button>

                        <button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="validateandsubmit()">
                          <i class="ace-icon fa fa-check"></i>
                          Save
                        </button>
                        <script language="javascript">
                        function validateandsubmit()
                        {
                          document.getElementById("frmPopup").submit();
                        }
                        </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------> 