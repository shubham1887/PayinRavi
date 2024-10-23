<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-clearmin.min.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/roboto.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/material-design.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/small-n-flat.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
        <title>Filter Bank Ledger</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
    
        <script language="javascript">
		$('document').ready(function(){
		  $('#li_Reports').addClass("pre-open");
		  
		  document.getElementById("ddldebtcrdexp").value = 'DEBT_<?php echo $ddldebtcrdexp_id; ?>';
			document.getElementById("ddlType").value = '<?php echo $ddlType; ?>';
			document.getElementById("ddlaccount").value = '<?php echo $ddlaccount; ?>';
		});
		</script>
        
        <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#txtFromDate,#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
  </script>
    </head>
    <body class="cm-no-transition cm-2-navbar">
        <?php include("files/adminheader.php"); ?>
       
        
            
        <div id="global">
	        <div class="container-fluid">
               <div class="panel panel-default">
                            <div class="panel-heading">Search Filters</div>
                            <div class="panel-body">
                            <form id="frmsearch" name="frmsearch" action="" method="post">
                                <table class="table">
                                   
                                    <thead>
                                        <tr>
                                        	<th>
                                            	<select id="ddlaccount" name="ddlaccount" class="form-control" style="width:120px;">
                                                	<option value="ALL">Select</option>
                                                <?php
													$bankin = $this->db->query("select Id,Account_Name from tblbankdetail order by Account_Name");
													foreach($bankin->result() as $rac)
													{
												 ?>
                                                 		<option value="<?php echo $rac->Id; ?>"><?php echo $rac->Account_Name; ?></option>
                                                 <?php } ?>
                                                </select>
                                            </th>
                                            <th><input type="text" id="txtFromDate" value="<?php echo $from; ?>" name="txtFromDate" placeholder="Select Date" class="form-control" readonly style="cursor: pointer"></th>
                                            <th><input type="text" id="txtToDate" value="<?php echo $to; ?>" name="txtToDate" placeholder="Select Date" class="form-control" readonly style="cursor: pointer"></th>
                                           
                                            <th>
                                            	<select id="ddldebtcrdexp" name="ddldebtcrdexp" class="form-control" style="width:120px">
		                                            <option value="0">Select</option>
                                                    <optgroup label="Debtors">
                                            	<?php
												
													$debtors = $this->db->query("select * from tbldebtors order by Name");
													foreach($debtors->result() as $rdc)
													{?>
														<option value="DEBT_<?php echo $rdc->Id; ?>"><?php echo $rdc->Name; ?></option>
													<?php }
												
													
												 ?>
                                                 </optgroup>
                                                
                                                  
                                                   <optgroup label="Creditors">
                                                 <?php
												
													$creditors = $this->db->query("select * from tblcreditors order by Name");
													foreach($creditors->result() as $rcc)
													{?>
														<option value="CRED_<?php echo $rcc->Id; ?>"><?php echo $rcc->Name; ?></option>
													<?php }
												
												 ?>
                                                  </optgroup>
                                                  
                                                    <optgroup label="Expanse">
                                                 <?php
												
													$expanse = $this->db->query("select * from tblexpences order by Name");
													foreach($expanse->result() as $rexp)
													{?>
														<option value="EXP_<?php echo $rexp->Id; ?>"><?php echo $rexp->Name; ?></option>
													<?php }
												
												 ?>
                                                  </optgroup>
                                            </select>
                                            </th>
											<th><input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary"></th>
											<th><input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-primary" onClick="startexoprt()"></th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                                </form>
                                <script language="javascript">
                                    function startexoprt()
{
		
		
		var from = document.getElementById("txtFromDate").value;
		var to = document.getElementById("txtToDate").value;
		var debtcrdexp = document.getElementById("ddldebtcrdexp").value;
	
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("debtcrdexp_id").value = debtcrdexp;
	
		document.getElementById("frmexport").submit();
	
}
                                </script>
                                <form id="frmexport" name="frmexport" action="<?php echo base_url()."Admin/filter_bank_ledger/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="debtcrdexp_id" name="debtcrdexp_id">
                                    
                                    </form>
                                
                            </div>
                        </div>
            </div>
            <div class="container-fluid">
            <style>
			.row1
			{
				background-color:#FEDDD8;
			}
			.row2
			{
				background-color:#CDF3D2;
			}
			.row3
			{
				background-color:#FD03D0;
			}
			</style>
               <div class="panel panel-default">
                            <div class="panel-heading">Tables</div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <caption>with <code>.table-bordered</code> and <code>.table-hover</code></caption>
                                    <thead>
                                        <tr>
                                        	<th></th>
                                            <th>Bank</th>
                                            <th>Remark</th>
                                            <th>Debtor/Creditor</th>
                                            <th>Sr.</th>
                                            <th>Id</th>
                                            <th>Transaction Date</th>
                                            <th>Withdrawal</th>
                                            <th>Deposit</th>
                                            <th>Balance</th>
                                            <th>Narration</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
								$i=1;
									//print_r($data);exit;
									$totaldeposit = 0;
									$totalentries = "";
									 foreach($data->result() as $row)
                                    {
									$class = "";
																		?>
                                    <tr class="<?php echo $class; ?>">
                                           <td>
                                           </td>
                                    		<td><span id="span_remark_<?php echo $row->Id; ?>"><?php echo $row->Account_Name; ?></span></td>
                                            <td><span id="span_remark_<?php echo $row->Id; ?>"><?php echo $row->Remark; ?></span></td>
                                   			<td style="display:none" id="btnperact_<?php echo $row->Id; ?>"></td>
                                            
                                            <td id="CrDr_<?php echo $row->Id; ?>">
												<?php
													if($row->creditor_id > 0)
													{
														echo "SUPLIER : ". $row->creditor_name;
													}
													if($row->debtor_id > 0)
													{
														echo "DEBTOR : ".$row->DebtorName;
													}
													if($row->expence_id > 0)
													{
														echo "EXPANSE : ".$row->exp_name;
													}
												 ?>
                                            </td>
                                    	    <td><?php echo $i; ?></th>
                                            <td><span id="span_id_<?php echo $row->Id; ?>"><?php echo $row->Id; ?></span></th>
                                            <td><span id="span_tdate_<?php echo $row->Id; ?>"><?php echo $row->transaction_date; ?></span></td>
                                            <td><span id="span_withdraw_<?php echo $row->Id; ?>">
												<?php echo $row->Withdrawal; ?>
                                            </span></td>
                                            <td><span id="span_deposit_<?php echo $row->Id; ?>"><?php echo $row->Deposit; ?></span></td>
                                            <td><span id="span_balance_<?php echo $row->Id; ?>"><?php echo $row->Balance; ?></span></td>
                                            <td><span id="span_narration_<?php echo $row->Id; ?>"><?php echo $row->Narration."<br><br>".$row->Details; ?></span></td>
                                            

                                            
                                            
                                            
                                        </tr>
                                    <?php
                                    $totalentries .= " + ".round($row->Deposit,2);
                                    $totaldeposit += $row->Deposit;
                                    $i++; } ?>
                                        
                                       
                                    </tbody>
                                    <tr>
                                        <td>Total Deposit</td><td><?php echo $totaldeposit; ?></td>
                                        <td>Total Entries </td><td><?php echo $totalentries; ?></td>
                                    </tr>
                                </table>
                                <input type="hidden" id="hidurl" value="<?php echo base_url()."Admin/bank_ledger"; ?>">
                                <script language="javascript">
								
								function updateform(id,cls)
								{
									var did = document.getElementById("ddldebtorcreditor_"+id).value;
									var remark = document.getElementById("txtRemark_"+id).value;
									
									$.ajax({
											url:document.getElementById("hidurl").value,
											data:{"Id":id,"did":did,"class":cls,"Remark":remark},
											cache:false,
											type:'POST',
											success:function(html)
											{
												document.getElementById("DebtorName_").innerHTML = html;
											}
									});	
								}
								function enablefields(id)
								{
									 $("#myModal").modal({"show":true});
									// span_id_#span_tdate_#span_withdraw_#span_deposit_#span_balance_#span_narration_
										document.getElementById("hidpopupid").value = id;
										document.getElementById("spanpopup_tdate").innerHTML = document.getElementById("span_tdate_"+id).innerHTML;
										document.getElementById("spanpopup_withdraw").innerHTML = document.getElementById("span_withdraw_"+id).innerHTML;
										document.getElementById("spanpopup_deposit").innerHTML = document.getElementById("span_deposit_"+id).innerHTML;
										document.getElementById("spanpopup_balance").innerHTML = document.getElementById("span_balance_"+id).innerHTML;
										document.getElementById("spanpopup_narration").innerHTML = document.getElementById("span_narration_"+id).innerHTML;
										
									 
									
								}
								
								</script>
                            </div>
                        </div>
            </div>
            <footer class="cm-footer"><span class="pull-left">Connected as John Smith</span><span class="pull-right">&copy; PAOMEDIA SARL</span></footer>
        </div>
       <!-- <script src="../assets/js/lib/jquery-2.1.3.min.js"></script>-->
        <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>