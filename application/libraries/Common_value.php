<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Common_value {
	public function getFromEmail()   
	{  
		return "rpay.in6050@gmail.com";
		
	}
	public function getSubject()
	{ 
		return "Account Details - ".$this->getName(); 
	}
	public function getForgetSubject()
	{
		return "Forget Password - ".$this->getName(); 
	}
	public function getForgetUserNameSubject()
	{
		return "Forget User Name - ".$this->getName();; 
	}

	public function getSMSUserName()
	{
		return ""; 
	}
	public function getSMSPassword()
	{
		return ""; 
	}
	public function getServiceName()
	{
		return "<option value='1'>Mobile</option><option value='2'>DTH</option><option value='4'>UTILITY</option>"; 
	}
	public function getEmailMessage($UserName,$Password,$name)
	{
	$table = '<table>
<tr bgcolor="#add8e6" style="color:#000;height:200px;">
<td style="color:#000;height:200px;" colspan="2"><b style="font-size:18px;color:#000;">Welcome to '.$this->getName().'. Recharge System</b></td></tr><br>
<tr style="color:#000;">
<td style="padding-top:10px;">Dear,</td>
</tr>
<tr><td>Mr.&nbsp;&nbsp;<b style="color:#FF3535;">' . $name . '</b></td></tr> 
<tr><td>Welcome to <b>RPays.!</b> Kindly Find your account information below:</td></tr><br>
<hr><br>
<tr style="color:#000;padding-left:30px;"> 
<td align="right">
<label style="color:#000;font-weight:bold;">User ID:</label>
<label style="color:#000;">' . $UserName . '</label>
</td>
</tr>
<tr style="color:#000;padding-left:30px;">
<td align="right">
<label style="color:#000;font-weight:bold;">Password:</label>
<label style="color:#000;">' . $Password . '</label>
</td>  
</tr><br>
<hr>
<tr style="color:#000;"> 
<td style="padding-top:10px;"><p>As a member of <b style="color:#00F;border-bottom:medium;" onClick="http://jantaestore.com/">RPays.</b> you are entitled to savings and benefits on mobile/ DTH Recharge, Printing work, Ad. booking</p></td>
</tr> 
</table>';

		$message = 'Dear Business Partner 
						'.$table.'
						  <br />The '.$this->getName().'. Team<br />';
		return $message; 
	}
	public function getForgetEmailMessage($Password)
	{
		$message = "Dear Business Partner<br /><br /> <hr /> <strong>Account Details</strong><br />
						New Password : $Password <hr /> Thank you ";
		return $message; 
	}	
	public function getForgetUserNameMessage($userName)
	{
		$message = "Dear Business Partner<br /><br /> <hr /> <strong>Account Details</strong><br />
						User Name : $userName <hr /> Thank you ";
		return $message; 
	}	

	public function getTDS()
	{
		return 10; 
	}
	public function getBankDetails()
	{		
		return ""; 
	}	
	public function getPerPage()
	{
		return 1000; 
	}
	
	public function binarytree($id = 1, $link , $supermember = false, $float = "left", $level =1)
		{
			$level++;
			if($level>3)
			{
				return false;
			}
			$width = 100;
			$res_count = 1;
			if($supermember)
			{	 
				$res_count = 2;  	
			}
			$query = "Select * from binary_tbl where id = $id";
			$res = mysql_query($query, $link) or die(mysql_error());
			$div_witdh =  $width/$res_count;
			while($r = mysql_fetch_object($res))
			{
					echo "<div style='width:$div_witdh%;text-align:center;float:$float'>$r->name<br>";
					$query_member = "Select * from binary_tbl where supermember = $id";
					$res_member = mysql_query($query_member, $link) or die(mysql_error());
					while($rm = mysql_fetch_object($res_member))
					{
								$this->binarytree($rm->id, $link, true, $float, $level);
								$float = ($float=='left')?'right': 'left';
					}		
					echo "</div>";
			}
}
public function getWebUrl()
	{
		return "http://jantaestore.com";
	}
	public function getWebName()
	{
		return "jantaestore.com";									
	}
	public function getName()
	{
		return "RPays";										
	}
}