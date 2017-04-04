<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Cart_mod.php
# Created on : 13th Sep 2016 by Rakesh Ahirrao
# Update on : 29th Sep 2016 by Rakesh Ahirrao
# Purpose : Add to cart related functionality.
*/

class Cart_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function add_to_cart($item_details,$type,$cus_id = 0,$state_abr)
	{
		   $order_data['user_id'] = $cus_id;
		   $order_data['order_date'] = date('Y-m-d');
		   $order_data['order_status'] = 'Pending';
		   $order_data['order_by'] = 'user';
		   if(isset($this->session->userdata['order_id']))
		   {
			    $order_item['order_id'] = $this->session->userdata['order_id'];
				$order_item['purchase_type'] = trim($type);
				$order_item['course_id'] = $item_details['item_id'];
				$order_item['course_amount'] = $item_details['price'];
				$order_item['course_state'] = $state_abr;
				$order_item_id = $this->db->insert("order_courses", $order_item); 
				if($order_item_id)
				{
					$this->db->set('order_total', 'order_total + ' . (float) $item_details['price'], FALSE);
					$this->db->where('order_id', $this->session->userdata['order_id']);
					$this->db->where('user_id', $cus_id);
					$this->db->where('order_status', 'Pending');
					$this->db->update('user_orders'); 
				}
				
	       }else{
			    $order_data['order_total'] = $item_details['price'];
			    $this->db->insert("user_orders", $order_data); 
		     	$orderid = $this->db->insert_id(); 
				$arr_order = array('order_id'=> $orderid);
				$this->session->set_userdata($arr_order); 
				
				$order_item['order_id'] = $orderid;
				$order_item['purchase_type'] = trim($type);
				$order_item['course_id'] = $item_details['item_id'];
				$order_item['course_amount'] = $item_details['price'];
				$order_item['course_state'] = $state_abr;
				$this->db->insert("order_courses", $order_item); 
		   }
		   
		   
		   if(isset($this->session->userdata['order_id']))
		   {
			     return $this->cart_count($this->session->userdata['order_id']);
		   }
		   
	}
	
	public function get_cart_items($order_id,$userid)
	{
		    $this->db->select("order_item.*");
		    $this->db->from("order_courses AS order_item");
			$this->db->where("order_item.order_id",$order_id);
			$query_items = $this->db->get();
				 //echo $this->db->last_query(); die;
			if($query_items->num_rows()>0){
				return $query_items->result_array();
			}else{
				return array();
			}
	}
	
	public function remove_cart_items($details,$item_type,$item_id = '')
	{
			if(isset($details['course_id']) && isset($details['order_id'])){
				$this->db->where('course_id', $details['course_id']);
				$this->db->where('order_id', $details['order_id']);
				$this->db->where('purchase_type', $item_type);
			}
   			$deleted = $this->db->delete('order_courses'); 
			
			if($deleted){
					$udate_order = "UPDATE `user_orders` SET `order_total` = order_total - ".(float)$details['price']." WHERE `order_id` = ".$this->session->userdata['order_id']." AND `order_status` = 'Pending'";
				 	$Q = $this->db->query($udate_order);
					//echo $this->db->last_query(); die;
			}
			
			if(isset($this->session->userdata['order_id']))
		    {
				 return $this->cart_count($this->session->userdata['order_id']);
			}
	}
	
	public function cart_count($order_id)
	{
		   		 $this->db->select("COUNT(id) AS cartcount");
				 $this->db->from("order_courses");
				 $this->db->where("order_id",$order_id);
				 $this->db->limit(1);
				 $query_items = $this->db->get();
				 if($query_items->num_rows()>0){
					foreach($query_items->result_array() as $key => $valcount)
					{
					 	return $valcount;	
					}
				 }
				 else{
					return array();
				 } 
	}
	
	public function check_item($type,$type_id,$cart_id)
	{
		  	$this->db->select("order_item.*");
		    $this->db->from("order_courses AS order_item");
			$this->db->where("order_item.order_id",$cart_id);
			$this->db->where("order_item.purchase_type",$type);
			$this->db->where("order_item.course_id",$type_id);
	        $this->db->limit(1);
			$query_items = $this->db->get();
				 //echo $this->db->last_query(); die;
			if($query_items->num_rows()>0){
				return $query_items->result_array();
			}else{
				return array();
			} 
	}
	
}

?>