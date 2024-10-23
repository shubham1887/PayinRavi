<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>APIUSER LIST</title>
		<?php include("elements/linksheader.php"); ?><link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	
	</script>
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
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
					  <div class="br-pageheader">
						<nav class="breadcrumb pd-0 mg-0 tx-12">
						  <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
						  <a class="breadcrumb-item" href="#">APIUSER</a>
						  <span class="breadcrumb-item active">APIUSER LIST</span>
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
                                          
                                          <form action="<?php echo base_url()."_Admin/UserLIst" ?>" method="post" name="frmCallAction" id="frmCallAction">                            
                                    <input type="hidden" id="hidID" name="hidID">                                     
                                    <table cellspacing="10" cellpadding="3">                                     
                                    <tr>                                     	
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>AGENT NAME</h5>                                             
                                    <input class="form-control-sm" id="txtAGENTName" value="<?php echo $txtAGENTName; ?>" name="txtAGENTName" type="text" style="width:120px;" placeholder="AGENT NAME">                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>AGENT ID</h5>                                             
                                    <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text" style="width:120px;" placeholder="AGENT USER ID">                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>MOBILE NO</h5>                                              
                                    <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text" style="width:120px;" placeholder="AGENT MOBILE NO">                                         
                                    </td>        
                                    <td valign="bottom">                                         
                                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-sm">       
                                    <input type="button" id="btnExport" name="btnExport" value="Export To Excel" class="btn btn-success btn-sm" onClick="startexoprttwo()">
                                                                    
                                    </td>                                     </tr>                                     </table>                            </form>
                                          
                                        </div>
            									</div>
        								</div>
									</div>
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Retailer List</h6>
											<span class="tx-12 tx-uppercase">
												<a href="<?php echo base_url()."_Admin/User_registration" ?>"  class="blue btn btn-primary btn-sm" > <i class="ace-icon fa fa-plus bigger-120"></i>Add New User </a>
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body">
                                          
                                          
                                          
                                          <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
  		<th>Sr No</th>
	   <th>API Id</th>
	   <th>API Name</th>
	   <th>Mobile</th>
     
	   <th>Group Name</th> 
     <th>DMR.GROUP</th>
	   <th style="width: 80px;">Balance</th> 
     <th style="width: 80px;">AEPS Wallet</th> 
	   <th style="width: 80px;">Login</th>
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
<td ><a href="<?php echo base_url()."_Admin/profile?usertype=".$this->Common_methods->encrypt("APIUSER")."&user_id=".$this->Common_methods->encrypt($result->user_id);?>" target="_blank"><?php 
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
   
 
<td ><?php echo $result->group_name; ?></td>



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
	
<td><span id="spanbalance<?php echo $result->user_id; ?>"></span></td>
<td><span id="spanbalance_aeps<?php echo $result->user_id; ?>"></span></td>
<td>
<?php if($result->status == 0){echo "<span class='red'><a href='#' onclick='actionDeactivate(".$result->user_id.",1)'>Deactive</a></span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$result->user_id.",0)'>Active</a></span>";} ?>
</td>







 <td width="180px">
  <a class="far fa-edit" style="font-size:18px;" href="<?php echo base_url()."_Admin/User_edit?id=".$this->Common_methods->encrypt($result->user_id); ?>" title="Edit Franchise"></a> 
   |       

 <?php 
 
 echo '<a class="fas fa-plus-square" style="font-size:16px;" title="Transfer Money" href="'.base_url().'_Admin/add_balance?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"></a> | ';
 
 
  if($this->session->userdata("ausertype") == "Admin"){
 echo ' <a style="font-size:16px;" class="fas fa-share" href="'.base_url().'directaccess/process/'.$this->Common_methods->encrypt($result->user_id).'" target=_blank></a>';} ?>
 <a style="cursor:pointer" class="fas fa-trash-alt" onClick="Confirmation('<?php echo $result->user_id; ?>')"></a> 
 
 </td>
 </tr>
		<?php 	
		$i++;} ?>
		</table>
										
										
                                        
                                        <?php  echo $pagination; ?>         
                                      <form id="frmstatuschange" action="<?php echo base_url()."_Admin/UserList"; ?>" method="post"> 
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
                                              url:'<?php echo base_url()."_Admin/UserList/minRechargeLimit";?>?minrechargelimit='+minrechargelimit+'&id='+user_id, 	
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
                                              url:'<?php echo base_url()."_Admin/UserList/changedmrgroup?id=";?>'+id+'&field='+myval, 	
                                              cache:false, 	method:'POST', 	
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
                                      <input type="hidden" id="hidurltoggle" value="<?php echo base_url()."_Admin/UserList/togglegroup"; ?>">         
                                      <script language="javascript"> 		
                                      function actionToggle(id,sts) 		
                                      { 			$.ajax({ 				
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
                                                  url:'<?php echo base_url()."_Admin/UserList/setvalues?"; ?>Id='+id+'&field=MT&val=1', 				
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
                                                  url:'<?php echo base_url()."_Admin/UserList/setvalues?"; ?>Id='+id+'&field=MT&val=0', 				
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
                                				url:'<?php echo base_url()."_Admin/UserList/setvalues?"; ?>Id='+id+'&field=ENABLED&val=yes',
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
                                				url:'<?php echo base_url()."_Admin/UserList/setvalues?"; ?>Id='+id+'&field=ENABLED&val=no',
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
                                                        document.getElementById("spanbalance_aeps"+strbalarid[0]).innerHTML = strbalarid[3];
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
                                      <input type="hidden" id="hidbaseurl" value="<?php echo base_url()."_Admin/UserList"; ?>">  
                                      <input type="hidden" id="hidusers" value="<?php echo  $struser; ?>">  
                                      <form action="<?php echo base_url()."_Admin/UserList?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="delete" />
</form> 
                                        
                                        
                                        
										
										</div>
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
					url: '<?php echo base_url(); ?>_Admin/dashboard/getTodaysHourSale',
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
					}	});
		}
		
		
		function gethourlyRickshawGraph()
		{
			
		$.ajax({
					type: "GET",
					url: '<?php echo base_url(); ?>_Admin/dashboard/getTodaysHourSale',
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
					}	});
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
						   
						   
						   
	function get_Paytmbalance(){$.ajax({type: "GET",url: '<?php echo base_url(); ?>/_Admin/Dashboard/getAllBalance?api_name=PAYTM',cache: false,success: function(html){$("#spanPAYTMbal").html(html);}});$("#spanPAYTMbal").fadeOut(1000);$("#spanPAYTMbal").fadeIn(2000);}	
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