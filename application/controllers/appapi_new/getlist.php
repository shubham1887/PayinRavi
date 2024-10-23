<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlist extends CI_Controller {
	
	
	
    public function getlasttxns()
    {
     
        if(isset($_GET["username"]) and isset($_GET["password"]))
        {
           $username =  trim($_GET["username"]);
           $password =  trim($_GET["password"]);
           $host_id = 1;
           $userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ? ",array($username,$password,$host_id));
			if($userinfo->num_rows() == 1)
			{
				$user_id = $userinfo->row(0)->user_id;
				 $rslt = $this->db->query('
				 select Id,number,amount, company_name,status,add_date,mcode,type,transaction_id
                from (
                    select t.recharge_id as Id,t.mobile_no as number,t.amount as amount,t.add_date,t.recharge_status as status, o.company_name,o.mcode,(select "RECHARGE") as type,t.transaction_id
                    from tblrecharge t
                    left join tblcompany o on t.company_id = o.company_id
                    where t.user_id = ? and (t.edit_date != "60" and t.edit_date != "5")  and t.amount > 0 
                    
                
                    
                    
                ) t
                order by Id desc limit 10',array($user_id));
                $resparray = array();
        		$resparray["data"] = array();
        		foreach($rslt->result() as $row)
        		{
        		
        		if($row->type == "RECHARE")
        		{
            		 $recdt = $row->add_date;
                	 $recdatetime =date_format(date_create($recdt),'Y-m-d H:i:s');
                	 $cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
                	 $this->load->model("Update_methods");
                	 $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
                	 $dtfr = date_format(date_create($this->common->getDate()),'YmdHis');
                	 //$operator_trans_id = "MP".$dtfr.$row->transaction_id;
                	 $status = $row->status;
                	 
                	 if($row->status == 'Pending')
                     {
                        if($diff > 5)
                        {
                            $status = "Success";
                        }
                     }   
        		}
        		else
        		{
        		    $status = $row->status;
        		}
        		 
        		
        		
        		$data = array(
        				'id'=>$row->Id,
        				'mcode'=>$row->mcode,
        				'operator'=>$row->company_name,
        				'mobile'=>$row->number,
        				'amount'=>$row->amount,
        				'status'=>$status,
        				'recDate'=>$row->add_date,
        				);
        				array_push($resparray["data"],$data);
        		
        		}
        		echo json_encode($resparray);exit;
			}
           
          
        }
        
    }
	public function index() 
	{
	 
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET["number"]) and isset($_GET["username"]) and isset($_GET["password"]))
			{
				$number = trim($_GET["number"]);
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$host_id = 1;
				$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					$rslt = $this->db->query("select 
					b.company_name,
					b.mcode,
					a.recharge_id,
					a.mobile_no,
					a.amount,
					a.add_date,
					a.operator_id,
					a.commission_amount,
					a.recharge_status 
					from tblrecharge a
					left join tblcompany b on a.company_id = b.company_id 
					where a.mobile_no = ? and a.amount > 0 and
					a.user_id = ? order by a.recharge_id desc limit 50",array($number,$user_id));	
				}
			}
			else if(isset($_GET["date"]) and isset($_GET["username"]) and isset($_GET["password"]))
			{
				$date = trim($_GET["date"]);
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');								
				$date = date_format(date_create($date),'Y-m-d');
				$host_id = 1;
				$userinfo = $this->db->query("select user_id from tblusers where username = ? and password = ? ",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					$rslt = $this->db->query("
					select 
					b.company_name,
					b.mcode,
					a.recharge_id,
					a.mobile_no,
					a.amount,
					a.add_date,
					a.operator_id,
					a.recharge_status,
					a.commission_amount 
					from tblrecharge a
					left join tblcompany b on a.company_id = a.company_id 
					where Date(a.add_date) = ? and a.user_id = ? and  (a.edit_date != '60' and a.edit_date != '5') and a.amount > 0  order by a.recharge_id desc",array($date,$user_id));	
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			else if(isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["username"]) and isset($_GET["password"]) )
			{
			    //echo "sdfsdf";exit;
				$from = trim($_GET["from"]);
				$to = trim($_GET["to"]);
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$number = '';
				if(isset($_GET["number"]))
				{
				$number = trim($_GET["number"]);
				}
				
				putenv("TZ=Asia/Calcutta");
				date_default_timezone_set('Asia/Calcutta');								
				$from = date_format(date_create($from),'Y-m-d');
				$to = date_format(date_create($to),'Y-m-d');
				
				$host_id = 1;
				$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
				   
					$user_id = $userinfo->row(0)->user_id;
					$rslt = $this->db->query("select 
					b.company_name,
					b.mcode,
					a.recharge_id,
					a.transaction_id,
					a.mobile_no,
					a.amount,
					a.add_date,
					a.operator_id,
					a.commission_amount,
					a.recharge_status 
					from 
					tblrecharge a
					left join tblcompany b on a.company_id = b.company_id 
					where  
					Date(a.add_date) >= ? and 
					Date(a.add_date) <= ? and 
					a.user_id = ?  and
					if( ? != '',a.mobile_no = ?,true)
					order by a.recharge_id desc ",array($from,$to,$user_id,$number,$number));	
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			else if(isset($_GET["username"]) and isset($_GET["password"]))
			{
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$host_id = 1;
				$userinfo = $this->db->query("select user_id from tblusers where username = ? and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;	
					$rslt = $this->db->query("select 
					b.company_name,
					b.mcode,
					a.recharge_id,
					a.mobile_no,
					a.amount,
					a.add_date,
					a.transaction_id,
					a.operator_id,
					a.commission_amount,
					a.recharge_status 
					from tblrecharge a
					left join tblcompany b on a.company_id = b.company_id 
					where a.user_id = ? and (a.edit_date != '60' and a.edit_date != '5') and a.amount > 0 order by a.recharge_id desc limit 50",array($user_id));
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			
			
		}
	
		
	if((isset($_POST["username"]) and isset($_POST["password"])) or (isset($_GET["username"]) and isset($_GET["password"])))
        {
		$resparray = array();
		$resparray["data"] = array();
		foreach($rslt->result() as $row)
		{
		
		
		 $recdt = $row->add_date;
    	 $recdatetime =date_format(date_create($recdt),'Y-m-d H:i:s');
    	 $cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
    	 $this->load->model("Update_methods");
    	 $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
    	 $dtfr = date_format(date_create($this->common->getDate()),'YmdHis');
    	 $operator_trans_id = "MP".$dtfr.$row->transaction_id;
    	 $status = $row->recharge_status;
    	 $operator_id =  $row->operator_id;
    	 
		
		$data = array(
				'id'=>$row->recharge_id,
				'mcode'=>$row->mcode,
				'operator'=>$row->company_name,
				'mobile'=>$row->mobile_no,
				'amount'=>$row->amount,
				'commission'=>$row->commission_amount,
				'status'=>$status,
				'operator_id'=>$operator_id,
				'recDate'=>$row->add_date,
				);
				array_push($resparray["data"],$data);
		
		}
		echo json_encode($resparray);exit;
         }
         else
         {
               echo "Paramter Missing";exit;
         }
	
		

	}
	
}