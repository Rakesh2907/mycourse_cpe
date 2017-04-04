<?php 
class Customer_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_state()
    {
		//$this->db->query_reset();
			$this->db->reset_query();
			$this->db->select('*');
			$this->db->from('us_state');
			
	
	
			$states = $this->db->get();
			 
			if($states->num_rows()>0)
			{  
				return $states->result_array();
			}
			else
			{
				return 0;
			}
			
	 }
		  public function get_subscription_amount($id)
	 {
			$this->db->select("c.price");
			$this->db->from("subscription AS c");
			$this->db->where("c.subscription_id",$id);
			$query_amount = $this->db->get();
			if($query_amount->num_rows()>0)
			{
				return $query_amount->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 public function get_state_details($abbr)
    {
			$this->db->select('state_id,state,state_abbr');
			$this->db->from('us_state');
			 $this->db->where("state_abbr",$abbr);
			$states = $this->db->get();
			
			if($states->num_rows()>0)
			{
				return $states->result_array();
			}
			else
			{
				return 0;
			}
			
	 }
	public function admin_tax()
    {
			$this->db->select('*');
			$this->db->from('admin');
			$this->db->limit(1);
			$admin = $this->db->get();
			if($admin->num_rows()>0)
			{
				return $admin->result_array();
			}
			else
			{
				return array();
			}
			
	 }
	 
	 public function get_states_credits($coures_id,$states_id)
	{
		  $course_id = explode(',',$coures_id);
		  $state_id = explode(',',$states_id);
		  $this->db->select("c.course_id, c.course_type, c.credit_numbers, us.state_id, us.state, us.state_abbr, ct.type");
		  $this->db->join('credits_type AS ct', 'c.course_type = ct.type_id','inner');
		  $this->db->join('us_state AS us', 'c.state_id = us.state_id','inner');
		  $this->db->from("course_credits AS c");
		  $this->db->where_in("c.course_id",$course_id);
		  $this->db->where_in("c.state_id",$state_id);
		  $this->db->order_by("us.state", " ASC");
		  $myquery = $this->db->get();
		  
		  
		 if($myquery->num_rows()>0)
	     {
				return $myquery->result_array();
		 }else{
				return array();
		 }
	}
	
	 public function customer_count($status='')
	 {
		
		  $this->db->select("COUNT(id) AS total_customer");
		  $this->db->from("customers");
		  $this->db->where("delete_flg", "0");
		  if($status == 'today')
		  {
			$today = date('Y-m-d');  
			$this->db->where("created like '".$today."%'");  
		  }
		  if($status == 'week')
		  {
		
			
            $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$this_week_sd = date("Y-m-d",$monday);
			$this_week_ed = date("Y-m-d",$sunday);
			
			$this->db->where("created >=",$this_week_sd);  
			$this->db->where("created <=",$this_week_ed);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		   if($status == 'month')
		  {
			  $search_form = date('Y-m-01',strtotime(date('Y-m-d')));
              $search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
			/*$today = date('Y-m-d');
			$fromdate = strtotime("-30 day", strtotime($today));
			$frm_date=  date('Y-m-d', $fromdate);  */
			$this->db->where("created >=",$search_form);  
			$this->db->where("created <=",$search_to);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		  if($status == 'year')
		  {
			$curyear = date('Y');
			$fromdate = ''.$curyear.'-01-01';
			$todate = date('Y-m-d');    
		    $this->db->where("created >=",$fromdate);  
			$this->db->where("created <=",$todate);   
		  }
		  
		  $query_customer = $this->db->get();
		 // echo $this->db->last_query();die;
		  if($query_customer->num_rows()>0)
		  {
				foreach($query_customer->result_array() as $key => $valcount)
				{
					 return $valcount;	
				}
		  }else{
				return array();
		  }
	 }
	 
	 public function already_exists($email)
	 {
			$this->db->select("c.*");
			$this->db->from("customers AS c");
			$this->db->where("delete_flg", "0");
			$this->db->where("email", $email);
			$query_customer = $this->db->get();
			 //echo $this->db->last_query(); die;
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}	  
	 }
	 
	 public function add_customer($data)
	 {
		   $this->db->insert("customers", $data); 
		   return $this->db->insert_id();
	 }
	 
	 public function update_customer($data_update,$id)
	 {
		 $this->db->where("id", $id);
		 $this->db->update("customers", $data_update); 
		 return $id;
	 }
	 
	 public function get_all_customers()
	 {
		 	$this->db->select("c.*");
			$this->db->from("customers AS c");
			$this->db->where("delete_flg", "0");
			$query_customer = $this->db->get();
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function get_customer_states($state_id)
	 {
		     $state_id = explode(',',$state_id);
			 $this->db->select("s.*");
			 $this->db->from("us_state AS s");
			 $this->db->where_in("s.state_id",$state_id);
		 	 $query_state = $this->db->get();
		 //echo $this->db->last_query();
			 if($query_state->num_rows()>0)
			 {
					return $query_state->result_array();
			 }else{
					return array();
			  }
	 }
	 
	 public function get_customer($id)
	 {
			$this->db->select("c.*");
			$this->db->from("customers AS c");
			$this->db->where("c.id",$id);
			$query_customer = $this->db->get();
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return false;
			}
	 }
	 
	 public function delete_single_customer($cust_id)
	 {
		 	 $this->db->where("id", $cust_id);
			 $data_update = array('delete_flg' => '1');
		 	 $this->db->update("customers", $data_update);
			 return 1;
	 }
	 
	 public function get_all_Cust_orders($custid)
	{      
		    $this->db->select("o.*");
			$this->db->from("user_orders AS o");
			$this->db->where("o.user_id",$custid);
			$this->db->order_by('o.order_id DESC');
			$query_orders = $this->db->get();
			
			if($query_orders->num_rows()>0)
			{
				return $query_orders->result_array();
			}
			else
			{
				return array();
			}
	}
	
   public function get_course_amount($id)
	 {
			$this->db->select("c.course_price");
			$this->db->from("courses AS c");
			$this->db->where("c.course_id",$id);
			$query_amount = $this->db->get();
			if($query_amount->num_rows()>0)
			{
				return $query_amount->result_array();
			}
			else
			{
				return false;
			}
	 }
	public function add_new_order($data)
	 {
		   $this->db->insert("user_orders", $data); 
		   return $this->db->insert_id();
	 }
	 
	public function add_new_order_course($data)
	 {
		   $this->db->insert("order_courses", $data); 
		   return $this->db->insert_id();
	 } 
	public function add_user_course($data)
	 {
		   $this->db->insert("user_courses", $data); 
		   return $this->db->insert_id();
	 }
	
	 
	public function get_bundles()
	{
		 	$this->db->select("b.bundle_id,b.bundle_name,b.bundle_price");
			$this->db->from("bundles AS b");
			$this->db->where("bundle_status <> 'deleted'");
			$this->db->order_by("b.bundle_id", "DESC");
			$query_bundles = $this->db->get();
			if($query_bundles->num_rows()>0)
			{
				return $query_bundles->result_array();
			}
			else
			{
				return array();
			}  
	}
	
	  public function get_bundle_amount($id)
	 {
			$this->db->select("b.bundle_price");
			$this->db->from("bundles AS b");
			$this->db->where("b.bundle_id",$id);
			$query_amount = $this->db->get();
			if($query_amount->num_rows()>0)
			{
				return $query_amount->result_array();
			}
			else
			{
				return false;
			}
	 } 
	
	public function get_order_course_details($ordid)
	{
		 	$this->db->select("o.purchase_type,o.course_id,o.course_amount");
			$this->db->from("order_courses AS o");
			$this->db->where("o.order_id",$ordid);
			$this->db->order_by("o.id", "DESC");
			$query_orders = $this->db->get();
			if($query_orders->num_rows()>0)
			{
				return $query_orders->result_array();
			}
			else
			{
				return array();
			}  
	}
	
	  public function get_course_details($id)
	 {
			$this->db->select("c.course_name,c.course_period");
			$this->db->from("courses AS c");
			$this->db->where("c.course_id",$id);
			$query_amount = $this->db->get();
			if($query_amount->num_rows()>0)
			{
				return $query_amount->result_array();
			}
			else
			{
				return array();
			}
	 }

	  public function get_bundle_name($id)
	 {
			$this->db->select("b.bundle_name");
			$this->db->from("bundles AS b");
			$this->db->where("b.bundle_id",$id);
			$query_name = $this->db->get();
			if($query_name->num_rows()>0)
			{
				return $query_name->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 
	public function get_bundle_details($bid)
	{
		 	$this->db->select("b.bundle_id,b.bundle_name,b.bundle_courses");
			$this->db->from("bundles AS b");
			$this->db->where("b.bundle_id",$bid);
			$query_bundles = $this->db->get();
			if($query_bundles->num_rows()>0)
			{
				return $query_bundles->result_array();
			}
			else
			{
				return array();
			}  
	}
	
public function get_bundle_courses_details($cours_ids)
	{
		 	$this->db->select("c.course_id,c.course_name,c.course_period");
			$this->db->from("courses AS c");
			$this->db->where_in("c.course_id",$cours_ids);
			$query_courses = $this->db->get();
			if($query_courses->num_rows()>0)
			{
				return $query_courses->result_array();
			}
			else
			{
				return array();
			}  
	}
	
	public function get_course_progress($user_id,$status)
		{
				$this->db->select("c.course_id,c.course_name,u.added_date,u.id,u.expiry_date,u.completed_date,u.started_date");
				$this->db->from("user_courses AS u");
				$this->db->join("courses AS c", 'u.course_id = c.course_id', 'inner');
				$this->db->where("u.user_id",$user_id);
				$this->db->where("u.course_status",$status);
				$query_courses = $this->db->get();
				if($query_courses->num_rows()>0)
				{
					return $query_courses->result_array();
				}
				else
				{
					return array();
				}  
		}	
   
   public function course_complete($id)
	 {
		 	 $this->db->where("id", $id);
			 $data_update = array('course_status' => 'Completed','review_percentage' => 25,'exam_percentage'=> 25,'review_competed_date'=> date('Y-m-d'),'completed_date' => date('Y-m-d'));
		 	 $this->db->update("user_courses", $data_update);
			 return 1;
	 }
	 
 public function repeat_cust($status='')
	 {    //$status='';
		  $this->db->distinct();
		  $this->db->select("user_id");
		  $this->db->from("user_orders");
		  
		  if($status == 'today')
		  {
			$today = date('Y-m-d');  
			$this->db->where("order_date like '".$today."%'");  
		  }
		  if($status == 'week')
		  {
		
			
            $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$this_week_sd = date("Y-m-d",$monday);
			$this_week_ed = date("Y-m-d",$sunday);
			
			$this->db->where("order_date >=",$this_week_sd);  
			$this->db->where("order_date <=",$this_week_ed);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		   if($status == 'month')
		  {
			  $search_form = date('Y-m-01',strtotime(date('Y-m-d')));
               $search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
			/*$today = date('Y-m-d');
			$fromdate = strtotime("-30 day", strtotime($today));
			$frm_date=  date('Y-m-d', $fromdate);  */
			$this->db->where("order_date >=",$search_form);  
			$this->db->where("order_date <=",$search_to);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		  
		   if($status == 'year')
		  {
			$curyear = date('Y');
			$fromdate = ''.$curyear.'-01-01';
			$todate = date('Y-m-d');    
		    $this->db->where("order_date >=",$fromdate);  
			$this->db->where("order_date <=",$todate);   
		  }
		  $query_customer = $this->db->get();
		  //echo $this->db->last_query();die;
		  $result = $query_customer->result_array();
		   $repeat_count=0;
		   //echo "<pre>"; print_r($result);die;
		  if(count($result) > 0)
		  {
			  $total=count($result);
			 for($i=0; $i<$total; $i++)
			 { 
			   //echo ">>>".$result[$i]['user_id'];die;
			   $ord_cnt = $this->get_order_cnt($result[$i]['user_id']);
			   //echo "<pre>"; print_r($ord_cnt);die;
			   if(count($ord_cnt) > 0)
			   {
				   if($ord_cnt[0]['cnt'] > 1) 
				   {
					 $repeat_count +=1;   
				   }
			   }
			
			 }
			 //echo $repeat_count;die;
			 return $repeat_count;
			 
		   }
		   else{
			   //echo $repeat_count;die;
			   return $repeat_count;
			  }
		  //echo "<pre>";print_r($result);die;
	
	 }	
	 
	 
	 public function repeat_cust_list($status='',$stardate='',$enddate='',$state_id='')
	 {    //$status='';
		  $this->db->distinct();
		  $this->db->select("user_id");
		  $this->db->from("user_orders");
		  
		  
		
		  
		  if($status == 'today')
		  {
			$today = date('Y-m-d');  
			$this->db->where("order_date like '".$today."%'");  
		  }
		  if($status == 'week')
		  {
		
			
            $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$this_week_sd = date("Y-m-d",$monday);
			$this_week_ed = date("Y-m-d",$sunday);
			
			$this->db->where("order_date >=",$this_week_sd);  
			$this->db->where("order_date <=",$this_week_ed);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		   if($status == 'month')
		  {
			  $search_form = date('Y-m-01',strtotime(date('Y-m-d')));
              $search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
			/*$today = date('Y-m-d');
			$fromdate = strtotime("-30 day", strtotime($today));
			$frm_date=  date('Y-m-d', $fromdate);  */
			$this->db->where("order_date >=",$search_form);  
			$this->db->where("order_date <=",$search_to);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		  
		  if($stardate !='' && $enddate!='')
		  {
			$this->db->where("DATE_FORMAT(order_date,'%Y-%m-%d') >=",$stardate);  
			$this->db->where("DATE_FORMAT(order_date,'%Y-%m-%d') <=",$enddate);    
			
			//$this->db->where("DATE_FORMAT(created,'%m-%d-%Y') >=",$stardate);  
			//$this->db->where("DATE_FORMAT(created,'%m-%d%Y') <=",$enddate);    
		  }
		  
		  $query_customer = $this->db->get();
		  //echo $this->db->last_query();die;
		  $result = $query_customer->result_array();
		   $repeat_count=0;
		   $arr_custi=array();
		   //echo "<pre>"; print_r($result);die;
		  if(count($result) > 0)
		  {
			  $total=count($result);
			 for($i=0; $i<$total; $i++)
			 { 
			   //echo ">>>".$result[$i]['user_id'];die;
			   $ord_cnt = $this->get_order_cnt($result[$i]['user_id']);
			   //echo "<pre>"; print_r($ord_cnt);die;
			   if(count($ord_cnt) > 0)
			   {
				   if($ord_cnt[0]['cnt'] > 1) 
				   {
					 $arr_custid[]=$result[$i]['user_id'];
				   }
			   }
			
			 }
			 
			 //echo "<pre>";print_r($arr_custid);die;
			 
			 $repeat_cust_list = $this->get_explode_customer($arr_custid,$state_id);
			 
			 return $repeat_cust_list;
			 
		   }
		   else{
			   //echo $repeat_count;die;
			   return array();
			  }
		  //echo "<pre>";print_r($result);die;
	
	 }
	 
	 public function get_order_cnt($userid='')
	 {
		  $this->db->select("COUNT(order_id) AS cnt");
		  $this->db->from("user_orders"); 
		  $this->db->where("user_id",$userid);
		   
		  $query_order = $this->db->get();
		  //echo $this->db->last_query();die;
		 
		 if($query_order->num_rows()>0)
			{
					return $query_order->result_array();
			}
			else
			{
					return array();
			} 
		 
	 }
	 
	 public function get_customers_list($status='',$stardate='',$enddate='',$state_id='')
	 {
		 //echo $stardate .'>>>'.$enddate;die;
		//$status='';
		  //$state_id=1;
		  $this->db->select("*");
		  $this->db->from("customers");
		  $this->db->where("delete_flg", "0");
		 
		  if($state_id !='')
		  {
			 $where = "FIND_IN_SET('".$state_id."', state)";  
			
			 $this->db->where( $where );  
		  }
		  if($status == 'today')
		  {
			$today = date('Y-m-d');  
			$this->db->where("created like '".$today."%'");  
		  }
		  if($status == 'week')
		  {
		
			
            $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$this_week_sd = date("Y-m-d",$monday);
			$this_week_ed = date("Y-m-d",$sunday);
			
			$this->db->where("created >=",$this_week_sd);  
			$this->db->where("created <=",$this_week_ed);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		   if($status == 'month')
		  {
			  $search_form = date('Y-m-01',strtotime(date('Y-m-d')));
               $search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
			/*$today = date('Y-m-d');
			$fromdate = strtotime("-30 day", strtotime($today));
			$frm_date=  date('Y-m-d', $fromdate);  */
			$this->db->where("created >=",$search_form);  
			$this->db->where("created <=",$search_to);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		  
		  if($stardate !='' && $enddate!='')
		  {
			$this->db->where("DATE_FORMAT(created,'%Y-%m-%d') >=",$stardate);  
			$this->db->where("DATE_FORMAT(created,'%Y-%m-%d') <=",$enddate);    
			
			//$this->db->where("DATE_FORMAT(created,'%m-%d-%Y') >=",$stardate);  
			//$this->db->where("DATE_FORMAT(created,'%m-%d%Y') <=",$enddate);    
		  }
		  
		  $query_customer = $this->db->get();
		  //echo $this->db->last_query();die;
		  if($query_customer->num_rows()>0)
		  {
			  return $query_customer->result_array();
		  }else{
				return array();
		  }
	 }
	
	
	 public function get_explode_customer($userids,$state_id='')
	 {
		    //echo "---<pre>";print_r($userids);die;
			//echo ">>". $user_ids = explode(',',$userids);
			
			$this->db->select("c.*");
			$this->db->from("customers AS c");
			if($state_id !='')
			{
			 $where = "FIND_IN_SET('".$state_id."', c.state)";  
			
			 $this->db->where( $where );  	
			}
		    $this->db->where_in("id",$userids);
			
			$query_customer = $this->db->get();
				  //echo $this->db->last_query();die;
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
	 } 
	 
	 public function get_top_customers($stardate='',$enddate='')
	 {
		 
		 if($stardate !='' && $enddate!='')
		  {
			  //$condit ='AND o.order_date >='.$stardate.' AND o.order_date <='.$enddate.'';
			  $condit ='AND o.order_date between ("'.$stardate.'") AND ("'.$enddate.'")';
			  
		  }
		  else{
			$today = '2016-09-28';  
			$condit ='AND  o.order_date like "'.$today.'"';  
		 }
		 
		 $query = "select c.*,o.order_date,sum(o.final_total) as total from customers c,user_orders o WHERE c.id = o.user_id AND o.order_status='Completed' ".$condit." GROUP BY o.user_id order by total";
		 
		 $query_customer = $this->db->query($query);
		 if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
		  
	}
	
	public function get_complete_course($stardate='',$enddate='',$state_id='',$cretf='')
	 {
		 
		 if($stardate !='' && $enddate!='')
		  {
			  //$condit ='AND o.order_date >='.$stardate.' AND o.order_date <='.$enddate.'';
			  $condit ='AND u.completed_date between ("'.$stardate.'") AND ("'.$enddate.'")';
			  
		  }
		  else{
			$today = '2016-09-28';  
			$condit ='AND  u.completed_date like "'.$today.'"';  
		 }
		 if($state_id !='')
		  {
			 //$where = "FIND_IN_SET('".$state_id."', state)";  
			 $condit .= " AND FIND_IN_SET('".$state_id."', c.state)";  
			
			 $this->db->where( $where );  
		  }
		   if($cretf !='')
		  {
			 //$where = "FIND_IN_SET('".$state_id."', state)";  
			 $condit .= " AND FIND_IN_SET('".$cretf."', c.certifications)";  
			
			// $this->db->where( $where );  
		  }
		  
		  $query = "select c.*,u.course_id,u.completed_date,u.added_date,cs.course_name from customers c,user_courses u,courses cs WHERE c.id = u.user_id AND u.course_id = cs.course_id AND u.course_status='Completed' ".$condit."";
		 
		 $query_customer = $this->db->query($query);
		//$query_customer->num_rows();die;
		 if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
		  
	}
	
		public function get_order_number()
	{ 
		      $this->db->select("default_order_number");
			  $this->db->from("admin");
			  $this->db->limit(1);
			  $query_num = $this->db->get();
			   if($query_num->num_rows()>0){
				   return $query_num->result_array();
			  }else{
				   return array();
			  }
			  
	}
	
	public function update_flag($order_id,$order_number,$character = '')
	{
		        $myorder_num = $character.''.$order_number;
				
				$udate_flag = "UPDATE `user_orders` SET user_course_flag = '1',order_number = '".$myorder_num."' WHERE `order_id` = ".$order_id."";
	   			$Q = $this->db->query($udate_flag);
				
				$neworder_number = $order_number + 1;
				$udate_admin = "UPDATE `admin` SET default_order_number = ".$neworder_number." WHERE `id` = 1";
	   			$Q = $this->db->query($udate_admin);
	}
	
	
	public function s3_certificate_path($s3path,$user_course_id)
	{
		 	  $update_path = "UPDATE `user_courses` SET s3_course_certificate = '".$s3path."' WHERE id = ".$user_course_id."";
	   	 	  $Q = $this->db->query($update_path);
	}
	
	public function insert_subscriptions($data_insert)
	{
			$this->db->insert("users_subscription", $data_insert); 
		    return $this->db->insert_id();
	}
	public function get_course_text($course_id)
	{
		   		 $this->db->select("*");
				 $this->db->from("course_pdf");
				 $this->db->where("course_id",$course_id);
				 $query_text = $this->db->get();
				 
				 if($query_text->num_rows()>0){
						return $query_text->result_array();
				 }else{
				   		return array();
			     }		 
	}
	public function get_course_video($course_id)
	{
				 $this->db->select("*");
				 $this->db->from("course_video");
				 $this->db->where("course_id",$course_id);
				 $this->db->where("is_intro",'No');
				 $query_video = $this->db->get();
				 
				 if($query_video->num_rows()>0){
						return $query_video->result_array();
				 }else{
				   		return array();
			     }
	}
		public function insert_courses_text($data_text)
	{
		   $this->db->insert("course_progress", $data_text); 
		   return $this->db->insert_id();
	}
	
	public function user_course($user_course_id)
	{
		   	  $this->db->select('*');
		 	  $this->db->where('id', $user_course_id);
			  //$this->db->where('user_id',$user_id);
			  $this->db->limit(1);
			  $query_user_course = $this->db->get('user_courses');
			  // echo $this->db->last_query(); die;
			  if($query_user_course->num_rows() > 0)
			  {
					return $query_user_course->result_array();
			  }
			  else
			  {
				 	return array();
			  }
			  
	}
	
	public function update_course_progress($user_course_id)
	{
			$update_per = "UPDATE `course_progress` SET `completed_percentage` = 100 WHERE `user_course_id` = ".$user_course_id."";
			$Q = $this->db->query($update_per);
	}
	
	public function insert_user_credits($user_id,$creadit_type_id,$states_id,$cpoints,$completed_date,$user_course_id)
	{
		   $data_insert['user_id'] = $user_id;
		   $data_insert['type_id'] = $creadit_type_id;
		   $data_insert['state_id'] = $states_id;
		   $data_insert['total_points'] = $cpoints;
		   $data_insert['credit_date'] = $completed_date;
		   $data_insert['course_type'] = 'internal';
		   $data_insert['user_course_id'] = $user_course_id;
		   $this->db->insert("user_credits", $data_insert); 
		   return $this->db->insert_id();
		   
	}
	
}
?>