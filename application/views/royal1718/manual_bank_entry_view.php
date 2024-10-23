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
        <title>Manual Bank Entry</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
    
        <script language="javascript">
		
		
		
		$('document').ready(function(){
		 
		  $('#li_Reports').addClass("pre-open");
		
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
    $( "#txnDate" ).datepicker({dateFormat:'yy-mm-dd'});
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
                            <form id="frmsearch" name="frmsearch" action="" method="post" enctype="multipart/form-data">
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
                                            <th><input type="text" id="txnDate"  name="txnDate" placeholder="Select Date" class="form-control" readonly style="cursor: pointer"></th>
                                            
                                            
                                            
                                            <th>
                                            	<input type="text" id="txtWithdrawal" name="txtWithdrawal" placeholder="Withdrawal" class="form-control">
                                            </th>
                                            
                                            <th>
                                            	<input type="text" id="txtDeposit" name="txtDeposit" placeholder="Deposit" class="form-control">
                                            </th>
                                            <th>
                                            	<input type="text" id="ddlNarration" name="ddlNarration" placeholder="Narrarion" class="form-control">
                                            </th>
                                            
                                            <th>
                                            	<input type="text" id="txtDetails" name="txtDetails" placeholder="Details" class="form-control">
                                            </th>
                                            <th>
                                            	<input type="file" id="image" name="image">
                                            </th>
                                            
											<th><input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary"></th>
                                        </tr>
                                    </thead>
                                    
                                </table>
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
									 foreach($data->result() as $row)
                                    {
									$class = "row1";
									if($row->Deposit > 0)
									{
										$class = "row2";
									}
									if($row->Withdrawal > 10000)
									{
										$class = "row3";
									}
									
									?>
                                    <tr class="<?php echo $class; ?>">
                                           <td><input type="button" id="btnen_<?php echo $row->Id; ?>" class="btn btn-block btn-primary" value="Edit" onClick="enablefields('<?php echo $row->Id; ?>')">
                                           </td>
                                    		
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
                                    <?php $i++; } ?>
                                        
                                       
                                    </tbody>
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
     <!--<script src="../assets/js/lib/jquery-2.1.3.min.js"></script>-->
           <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>