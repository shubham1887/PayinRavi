<?php

ini_set("display_errors",1);
ini_set('max_execution_time', 0);
require_once 'excel_reader2.php';
require_once 'db.php';
//file_get_contents("http://payreflection.com/setplan/deleterecords?circle_id=1");
$data = new Spreadsheet_Excel_Reader("pnb.xls");

echo "Total Sheets in this xls file: ".count($data->sheets)."<br /><br />";

$html="<table border='1'>";
$account_number = false;
$TransactionDate_found = false; 
$ChequeNumber_found = false;
$Withdrawal_found = false;
$Deposit_found = false;
$Balance_found = false;
$Narration_found = false;
$rflagdata = "";
for($i=0;$i<count($data->sheets);$i++) // Loop to get all sheets in a file.
{	
	if(count($data->sheets[$i][cells])>0) // checking sheet not empty
	{
		echo "Sheet $i:<br /><br />Total rows in sheet $i  ".count($data->sheets[$i][cells])."<br />";
		for($j=1;$j<=count($data->sheets[$i][cells]);$j++) // loop used to get each row of the sheet
		{ 
			$html.="<tr>";
			for($k=1;$k<=20;$k++) // This loop is created to get data in a table format.
			{
				$html.="<td>";
				$celdata = $data->sheets[$i][cells][$j][$k];
				$html.=$celdata;
				if($account_number == false)
				{
					if($celdata == "Account Statement for Account Number0964002100019602")
					{
						$account_number = "0964002100019602";
					}
				}
				
				$html.="</td>";
			}
			
			$data->sheets[$i][cells][$j][1];
			$operator_name =$data->sheets[$i][cells][$j][1];
			$TransactionDate = $data->sheets[$i][cells][$j][2];
			//var_dump($circle);
			
			$plan_type =$data->sheets[$i][cells][$j][3];
			$amount = $data->sheets[$i][cells][$j][4];
			$validity = $data->sheets[$i][cells][$j][5];
			$withdrawal = $data->sheets[$i][cells][$j][6];
			$tags = $data->sheets[$i][cells][$j][7];
			$Deposit = $data->sheets[$i][cells][$j][8];
			
			$Balance = $data->sheets[$i][cells][$j][9];
			$Narration = $data->sheets[$i][cells][$j][10];
			
			if($TransactionDate == "Transaction Date")
			{
				$rflagdata = "start";
			}
			if($rflagdata == "start")
			{
				
				
				$TransactionDate = str_replace("/","-",$TransactionDate);
			
				$dt = $stry."-".$strm."-".$strd;
				echo "<hr>";
				echo "operator_name : ".$operator_name."<br>";
				echo "TransactionDate : ".$TransactionDate."  <br>";
				echo "plan_type : ".$plan_type."<br>";
				echo "amount : ".$amount."<br>";
				echo "validity : ".$validity."<br>";
				echo "withdrawal : ".$withdrawal."<br>";
				echo "tags : ".$tags."<br>";
				echo "Deposit : ".$Deposit."<br>";
				echo "Balance : ".$Balance."<br>";
				echo "Narration : ".$Narration."<br>";
				echo  "<hr>";
			}
			/*[Id],[ParentId],[CustName],[Username],[Mobile],[Password],[Email],[Company],[City],[PostalCode],[Address],[Status],[AddDate],[EditDate],[UserType],[StateId],[SchemeId],[Firstime],[ThemeColor],[ResponseURL] ,[APIPassword]*/
			$code = $data->sheets[$i][cells][$j][1];
			$Station_name = $data->sheets[$i][cells][$j][2];
			
		    $add_date = "2017-09-17";//$this->common->getDate();
		    $ipaddress = "1.1.1.1";//$this->common->getRealIpAddr();
			
			//echo "<hr>";
			//$url = 'http://payreflection.com/setplan?operator_name='.urlencode($operator_name).'&circle='.urlencode($circle).'&plan_type='.urlencode($plan_type).'&amount='.urlencode($amount).'&validity='.urlencode($validity).'&talktime='.urlencode($talktime).'&tags='.urlencode($tags).'&Benefits='.urlencode($Benefits);
//echo $url;exit;
			//echo file_get_contents($url);
		//	$query = "insert into master_stations(staion_name,station_code,add_date,edit_date,ipaddress) values('".$Station_name."','".$code."','".$add_date."','".$add_date."','".$ipaddress."')";
			
		//	mysqli_query($connection,$query);
			$html.="</tr>";
		}
	}
	
}

$html.="</table>";



echo $account_number."<hr>";
echo $html;
echo "<br />Data Inserted in dababase";
?>