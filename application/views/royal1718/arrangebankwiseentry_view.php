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
        <title>Ledger Filter</title>
    </head>
    <body class="cm-no-transition cm-2-navbar">
        <?php include("files/adminheader.php"); ?>
        <div id="global">
	        <div class="container-fluid">
               <div class="panel panel-default">
                            <div class="panel-heading">Add New Keyword</div>
                            <div class="panel-body">
                            <form id="frmsearch" name="frmsearch" action="" method="post">
                                <table class="table">
                                   
                                    <thead>
                                        <tr>
                                        	 <th>
                                            	<select id="ddlaccount" name="ddlaccount" class="form-control" style="width:120px;">
                                                	<option value="">Select</option>
                                                <?php
													$bankin = $this->db->query("select Id,Account_Name from tblbankdetail order by Account_Name");
													foreach($bankin->result() as $rac)
													{
												 ?>
                                                 		<option value="<?php echo $rac->Id; ?>"><?php echo $rac->Account_Name; ?></option>
                                                 <?php } ?>
                                                </select>
                                            </th>
                                            
                                            <th><input type="text" id="txtKeyword"  name="txtKeyword" placeholder="Add Keyword" class="form-control"></th>
                                            
                                            <th>
                                            	<select id="ddldebtorcreditor" name="ddldebtorcreditor" class="form-control" style="width:120px">
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
                                            <th><input type="text" id="txtRemark" name="txtRemark"  class="form-control"></th>
                                           	<th><input type="submit" id="btnAdd" name="btnAdd" value="Add" class="btn btn-primary"></th>
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
			</style>
               <div class="panel panel-default">
                            <div class="panel-heading">Tables</div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <caption>with <code>.table-bordered</code> and <code>.table-hover</code></caption>
                                    <thead>
                                        <tr>
                                        	<th></th>
                                            <th>Id</th>
                                            <th>BankAccount</th>
                                            <th>Keyword</th>
                                            <th>Creditor</th>
                                            <th>Debtor</th>
                                            <th>Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
								$i=1;
									//print_r($data);exit;
									 foreach($data->result() as $row)
                                    {
									
									
									?>
                                    <tr>
                                    		<td><?php echo $i; ?></th>
                                            <td><?php echo $row->Id; ?></td>
                                    	    <td><?php echo $row->BankAccountName; ?></th>
                                            <td><?php echo $row->keyword; ?></td>
                                          
                                            <td><?php echo $row->CreditorName; ?></td>
                                            <td><?php echo $row->DebtorName; ?></td>
                                            <td><?php echo $row->exp_name; ?></td>
                                            
                                           
                                   </tr>
                                    <?php $i++; } ?>
                                        
                                       
                                    </tbody>
                                </table>
                                <input type="hidden" id="hidurl" value="<?php echo base_url()."Admin/bank_ledger"; ?>">
                                <script language="javascript">
								$( document ).ready(function() {
									document.getElementById("ddlType").value = '<?php echo $ddlType; ?>';
								});
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
									 if(document.getElementById("btnen_"+id).value == "SHOW")
									 {
									 	document.getElementById("btnen_"+id).value = "Hide";
										
										
										 
										 document.getElementById("ddlcreddeb_"+id).style.display = 'table-cell';
										 document.getElementById("tdremark_"+id).style.display = 'table-cell';
										 document.getElementById("btnperact_"+id).style.display = 'table-cell';
									 }
									 else
									 {
									 	document.getElementById("btnen_"+id).value = "SHOW";
										
									
										
										 document.getElementById("ddlcreddeb_"+id).style.display = 'none';
										 document.getElementById("tdremark_"+id).style.display = 'none';
										 document.getElementById("btnperact_"+id).style.display = 'none';
									 }
									
								}
								
								</script>
                            </div>
                        </div>
            </div>
            <footer class="cm-footer"><span class="pull-left">Connected as John Smith</span><span class="pull-right">&copy; PAOMEDIA SARL</span></footer>
        </div>
        <script src="../assets/js/lib/jquery-2.1.3.min.js"></script>
        <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>