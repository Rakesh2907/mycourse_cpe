<?php 
class Userorder_mod extends CI_Model
{  
	function __construct()
	{
		parent::__construct();
		$this->load->model('course_mod');
		$this->load->model('bundle_mod');
	}
	
	public function get_all_users_order()
	{
			$this->db->select("u.order_id,u.order_number,u.order_total,u.order_date,u.order_status,c.first_name,c.last_name,u.final_total");
			$this->db->from("user_orders AS u");
			$this->db->join("customers AS c", 'c.id = u.user_id', 'inner');
			$orders = $this->db->get();
			if($orders->num_rows()>0)
			{
				return $orders->result_array();
			}
			else
			{
				return 0;
			}			
	}
	
	public function refund_order($id)
	{ 
	  $this->db->where("order_id", $id);
	  $data_update = array('order_status' => 'Refund');
	  $this->db->update("user_orders", $data_update);
	} 
	
   public function get_order_details($oid)
   {
	 		$this->db->select("u.order_id,u.order_number,u.order_total,u.txn_number,u.order_date,u.order_status,c.first_name,c.last_name,u.final_total");
			$this->db->from("user_orders AS u");
			$this->db->join("customers AS c", 'c.id = u.user_id', 'inner');
			$this->db->join("order_courses AS oc", 'oc.order_id = u.order_id', 'inner');
			$this->db->where('u.order_id',$oid);
			$orders = $this->db->get();
			if($orders->num_rows()>0)
			{
				return $orders->result_array();
			}
			else
			{
				return 0;
			}		  
   }
   
   public function get_order_course1($oid)
   {
	 		$this->db->select("o.order_id,o.purchase_type,o.course_amount,o.course_id");
			$this->db->from("order_courses AS o");
			//$this->db->join("courses AS c", 'c.course_id = o.course_id', 'inner');
			$this->db->where('o.order_id',$oid);
			$orders_course = $this->db->get();
			if($orders_course->num_rows()>0)
			{
				$result =$orders_course->result_array();
				$arr_result=array();
				//echo "<pre>";print_r($result);
					$cnt =count($result);
					for($i=0; $i<$cnt; $i++)
					{   //echo '>>>>'.$result[$i] 
					    
						if($result[$i]['purchase_type'] =='Course')
						{
						  $arr_result[$i]['course_amount']=	$result[$i]['course_amount'];
						 
						 
						  $course= $this->course_mod->get_course_details($result[$i]['course_id']);
						  //echo "<pre>";print_r($course);die;
						  $arr_result[$i]['course_name']=	$course[0]['course_name'];    
						}
						if($result[$i]['purchase_type'] =='Bundle')
						{
						  $arr_result[$i]['course_amount']=	$result[$i]['course_amount'];
						  //echo "<pre>";print_r($result);die;
						 
						  $bundle= $this->bundle_mod->get_bundle_details($result[$i]['course_id']);
						  //echo "<pre>";print_r($bundle);die;
						  $arr_result[$i]['course_name'] =	$bundle[0]['bundle_name'];    
						}
						
					}
					//echo "<pre>";print_r($arr_result);die;
				return $arr_result;
				
			}
			else
			{
				return array();
			}		  
   }

     public function get_order_course2($oid,$type)
   {
	        if($type == 'Course')
			{
				$this->db->select("o.order_id,o.purchase_type,o.course_amount,c.course_name");
				$this->db->from("order_courses AS o");
				$this->db->join("courses AS c", 'c.course_id = o.course_id', 'inner');
				$this->db->where('o.order_id',$oid);
			
			}
			if($type == 'Bundle')
			{
				$this->db->select("o.order_id,o.purchase_type,o.course_amount,c.bundle_name as course_name");
				$this->db->from("order_courses AS o");
				$this->db->join("bundles AS c", 'c.bundle_id = o.course_id', 'inner');
				$this->db->where('o.order_id',$oid);
			
			}
			
			$orders_course = $this->db->get();
			if($orders_course->num_rows()>0)
			{
				return $orders_course->result_array();
				
				
			}
			else
			{
				return array();
			}		  
   }
   
   public function get_order_course($oid)
   {
	 		$this->db->select("o.order_id,o.purchase_type,o.course_amount,c.course_name");
			$this->db->from("order_courses AS o");
			$this->db->join("courses AS c", 'c.course_id = o.course_id', 'inner');
			$this->db->where('o.order_id',$oid);
			$orders_course = $this->db->get();
			if($orders_course->num_rows()>0)
			{
				return $orders_course->result_array();
				
				
			}
			else
			{
				return array();
			}		  
   }
	
	public function get_revenue_percentage($param ='')
	{ 
		  if($param == 'last_week')
		  { 
				 $current_week_count = $this->order_count('week');
				 $current_week_count = $current_week_count['total_order'];
				 
				 $last_sunday = date('Y-m-d',strtotime('last monday -8 days'));
				 $last_monday = date('Y-m-d',strtotime('last monday'));
				 
				 $first_date  = '';
				 $second_date  = '';
				 $last_week_count = $this->order_count('default',$last_sunday,$last_monday);
				 $last_week_count = $last_week_count['total_order'];
				 
				 return array('last_week_count' => $last_week_count,'current_week_count' =>$current_week_count);
		  }
		  
		  if($param == 'last_year_month')
		  {
			     $current_month_to = date('m');
				 $last_year_to =  date('Y') - 1;
				 $current_date_to = date('d');
				 
				 $current_month_from = date('m');
				 $last_year_from =  date('Y') - 1;
				 $current_date_from = 01;
				 
				$last_year_date_from = $last_year_from.'-'.$current_month_from.'-'.$current_date_from; 
				$last_year_date_to = $last_year_to.'-'.$current_month_to.'-'.$current_date_to;
				 
				$current_month_count = $this->order_count('month');
				$current_month_count = $current_month_count['total_order'];
				 
				$lastyear_month_count = $this->order_count('default',$last_year_date_from,$last_year_date_to);
				$lastyear_month_count = $lastyear_month_count['total_order']; 
				 
				return array('lastyear_month_count' => $lastyear_month_count, 'current_month_count' => $current_month_count);
				 
		  }
		  
	}
	
	//Dashboard section
	public function order_count($status='',$date1='',$date2='')
	{
		  
		  $this->db->select("COUNT(order_id) AS total_order");
		  $this->db->from("user_orders");
		  $this->db->where("order_status", "Completed");
		  
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
		  if($status == 'default')
		  {
			  $this->db->where("order_date >=",$date1);  
			  $this->db->where("order_date <=",$date2); 
		  }
		  
		  
		  $query_order = $this->db->get();
		  //echo $this->db->last_query();//die;
		  if($query_order->num_rows()>0)
		  {
				foreach($query_order->result_array() as $key => $valcount)
				{
					 return $valcount;	
				}
		  }else{
				return array();
		  }
	 		
	} 
	
	public function order_sale($status='')
	{
		  
		
		  $this->db->select("SUM(final_total) AS total_sale");
		  $this->db->from("user_orders");
		  $this->db->where("order_status", "Completed");
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
		  
		  $query_order = $this->db->get();
		  //echo $this->db->last_query();
		  if($query_order->num_rows()>0)
		  {
				foreach($query_order->result_array() as $key => $valcount)
				{
					 return $valcount;	
				}
		  }else{
				return array();
		  }
	 		
	} 
	


  public function order_list($status='',$stardate='',$enddate='',$state_id='')
	{
		  
		  //$status='';
		  $this->db->select("u.order_id,u.order_number,u.order_total,u.txn_number,u.order_date,u.order_status,c.first_name,c.last_name");
		  $this->db->from("user_orders AS u");
		  $this->db->join("customers AS c", 'c.id = u.user_id', 'inner');
		  //$this->db->from("user_orders");
		  $this->db->where("u.order_status", "Completed");
		 if($state_id !='')
		  {
			 $where = "FIND_IN_SET('".$state_id."', c.state)";  
			
			 $this->db->where( $where );  
		  }
		 
		  if($status == 'today')
		  {
			$today = date('Y-m-d');  
			$this->db->where("u.order_date like '".$today."%'");  
		  }
		  if($status == 'week')
		  {
		
			
            $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$this_week_sd = date("Y-m-d",$monday);
			$this_week_ed = date("Y-m-d",$sunday);
			
			$this->db->where("u.order_date >=",$this_week_sd);  
			$this->db->where("u.order_date <=",$this_week_ed);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		   if($status == 'month')
		  {
			  $search_form = date('Y-m-01',strtotime(date('Y-m-d')));
               $search_to =  date('Y-m-t',strtotime(date('Y-m-d')));
			/*$today = date('Y-m-d');
			$fromdate = strtotime("-30 day", strtotime($today));
			$frm_date=  date('Y-m-d', $fromdate);  */
			$this->db->where("u.order_date >=",$search_form);  
			$this->db->where("u.order_date <=",$search_to);  
			
			//$this->db->where("created like '".$today."%'");  
		  }
		  if($stardate !='' && $enddate!='')
		  {
			$this->db->where("u.order_date  >=",$stardate);  
			$this->db->where("u.order_date  <=",$enddate);    
		  }
		  
		  $query_order = $this->db->get();
		  //echo $this->db->last_query();die;
		  if($query_order->num_rows()>0)
		  {
				return $query_order->result_array();
		  }else{
				return array();
		  }
	 		
	} 	
	
		public function get_order_items($order_id)
	{
				 $this->db->select("*");
				 $this->db->from("order_courses");
				 $this->db->where("order_id",$order_id);
				 $query_orders = $this->db->get();
				 
				 if($query_orders->num_rows()>0){
						return $query_orders->result_array();
				 }else{
				   		return array();
			     }
	}
	
		public function get_order_history($order_id)
	{
		   		 $this->db->select("*");
				 $this->db->from("user_orders");
				 $this->db->where("order_id",$order_id);
				 //$this->db->where("user_id",$user_id);
				 $this->db->where("order_status",'Completed');
				 $this->db->limit(1);
				 $query_orders = $this->db->get();
				 
				 if($query_orders->num_rows()>0){
						return $query_orders->result_array();
				 }else{
				   		return array();
			     } 
		 
	}
}
?>