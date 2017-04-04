<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Checkout_mod.php
# Created on : 12th Sep 2016 by Rakesh Ahirrao
# Update on : 04th Oct 2016 by Rakesh Ahirrao
# Purpose : Checkout related functionality like payment gatways integrations .
*/
 
class Checkout_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_tax_percentage()
	{
			     $this->db->select("tax_percentage");
				 $this->db->from("admin");
				 $this->db->where("status",'active');
				 $this->db->limit(1);
				 $query_admin = $this->db->get();
				 if($query_admin->num_rows()>0){
						return $query_admin->result_array();
				 }else{
				   		return array();
			     }
	}
	
	public function get_amount($order_id,$user_id)
	{
		   		 $this->db->select("*");
				 $this->db->from("user_orders");
				 $this->db->where("order_id",$order_id);
				 $this->db->where("user_id",$user_id);
				 $this->db->where("order_status",'Pending');
				 $this->db->limit(1);
				 $query_orders = $this->db->get();
				 
				 if($query_orders->num_rows()>0){
						return $query_orders->result_array();
				 }else{
				   		return array();
			     } 
				 
	}
	
	public function get_coupon_details($coupon_code)
	{
		        $this->db->select("*");
				$this->db->from("coupon_codes");
				if(is_numeric($coupon_code)){
					$this->db->where("coupon_id",$coupon_code);
				}else{
					$this->db->where("coupon_code",$coupon_code);
				}
				$this->db->where("coupon_status",'Active');
				$this->db->limit(1);
				$query_coupon = $this->db->get();
				// echo $this->db->last_query();
				if($query_coupon->num_rows()>0)
				{
						return $query_coupon->result_array();
				}else{
				   		return array();
			    }
				
	}
	
	public function get_order_details($order_id,$user_id)
	{
		   		 $this->db->select("*");
				 $this->db->from("user_orders");
				 $this->db->where("order_id",$order_id);
				 $this->db->where("user_id",$user_id);
				 $this->db->where("order_status",'Completed');
				 $this->db->limit(1);
				 $query_orders = $this->db->get();
				 
				 if($query_orders->num_rows()>0){
						return $query_orders->result_array();
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
	
	public function checkout_faq()
	{
				 $this->db->select("*");
				 $this->db->from("faq_management");
				 $this->db->where("faq_type","checkout");
				 $this->db->where("faq_status","Active");
				 $query_faq = $this->db->get();
				 
				 if($query_faq->num_rows()>0){
						return $query_faq->result_array();
				 }else{
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
		  $this->db->where("ct.active",'1');
		  $this->db->where_in("c.course_id",$course_id);
		  $this->db->where_in("c.state_id",$state_id);
		  $this->db->order_by("us.state", " ASC");
		  $myquery = $this->db->get();
		  //echo $this->db->last_query();
		  
		 if($myquery->num_rows()>0)
	     {
				return $myquery->result_array();
		 }else{
				return array();
		 }
	}
	
	public function insert_courses($data_insert)
	{
		   $this->db->insert("user_courses", $data_insert); 
		   return $this->db->insert_id();
	}
	
	public function insert_subscriptions($data_insert)
	{
			$this->db->insert("users_subscription", $data_insert); 
		    return $this->db->insert_id();
	}
	
	public function insert_courses_text($data_text)
	{
		   $this->db->insert("course_progress", $data_text); 
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
	
	public function get_maxredemption($coupon_id)
	{
				 $this->db->select("COUNT(coupon_id) AS c_count");
				 $this->db->from("user_orders");
				 $this->db->where("coupon_id",$coupon_id);
				 $this->db->where("order_status",'Completed');
				 $this->db->limit(1);
				 $query_items = $this->db->get();
				  //echo $this->db->last_query();
				 if($query_items->num_rows()>0){
					foreach($query_items->result_array() as $key => $valcount)
					{
					 	return $valcount['c_count'];	
					}
				 }
				 else{
					return 0;
				 }	
	}
	
	public function get_num_order($order_id)
	{
		     $this->db->select("order_number");
			 $this->db->from("user_orders");
			 $this->db->where("order_id",$order_id);
			 $this->db->limit(1);
			 $q_num = $this->db->get();
			   //echo $this->db->last_query();
			  if($q_num->num_rows()>0){
				   return $q_num->result_array();
			  }else{
				   return array();
			  }
	}
	 
	public function update_flag($order_id,$cust_id,$order_number,$character = '')
	{
		        $myorder_num = $character.''.$order_number;
				
				$udate_flag = "UPDATE `user_orders` SET user_course_flag = '1',order_number = '".$myorder_num."' WHERE `order_id` = ".$order_id." AND `user_id` = ".$cust_id." AND `order_status` = 'Completed'";
	   			$Q = $this->db->query($udate_flag);
				
				$neworder_number = $order_number + 1;
				$udate_admin = "UPDATE `admin` SET default_order_number = ".$neworder_number." WHERE `id` = 1";
	   			$Q = $this->db->query($udate_admin);
	}
	
	public function update_landing_status($bundle_id,$user_id)
	{
				 $update_mystatus = "UPDATE `landing_bundle_user` SET status = 'completed' WHERE `bundle_id` = ".$bundle_id." AND `user_id` = ".$user_id." AND `status` = 'pendding'";
				 $Q = $this->db->query($update_mystatus);
	}
	
	
	public function get_order_item_row($order_id)
	{
			 $this->db->select("purchase_type, count(`id`) as cnt");
			 $this->db->from("order_courses");
			 $this->db->where("order_id",$order_id);
			 $this->db->group_by('purchase_type');
			 $myquery_num = $this->db->get();
			   //echo $this->db->last_query();
			 if($myquery_num->num_rows()>0){
				   return $myquery_num->result_array();
			 }else{
				   return array();
			 }
			 
	}
	
}