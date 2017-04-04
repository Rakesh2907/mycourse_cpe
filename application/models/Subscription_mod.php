<?php 
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Subscription_mod.php
# Created on : 24th Sep 2016 by Rakesh Ahirrao
# Update on : 24th Sep 2016 by Rakesh Ahirrao
# Purpose : Subscription Front page with add to cart functionality.
*/

  class Subscription_mod extends CI_Model
  {
	   function __construct()
	   {
			parent::__construct();
	   }
	   
	   public function get_subscription()
	   {
		     $this->db->select("sub.*");
			 $this->db->from("subscription AS sub");
		 	 $this->db->where("sub.status",'active');
		 	 $this->db->order_by("sub.title", "ASC");
			 $this->db->limit(1);
		 	 $query_sub = $this->db->get();
		
			 if($query_sub->num_rows()>0)
			 {
					return $query_sub->result_array();
			 }else{
					return array();
			 }
	   }
	   
	   public function get_user_subscription($user_id)
	   {
		     $this->db->select("sub.*");
			 $this->db->from("users_subscription AS sub");
		 	 $this->db->where("sub.status",'active');
		 	 $this->db->where("sub.user_id",$user_id);
			 $this->db->order_by("sub.user_sub_id", "ASC");
			 $this->db->limit(1);
		 	 $query_sub = $this->db->get();
		
			 if($query_sub->num_rows()>0)
			 {
					return $query_sub->result_array();
			 }else{
					return array();
			 }
	   }
	   
	   public function get_subscription_details($subscription_id)
	   {
		     $this->db->select("sub.*");
			 $this->db->from("subscription AS sub");
		 	 $this->db->where("sub.status",'active');
			 $this->db->where("sub.subscription_id",$subscription_id);
		 	 $this->db->order_by("sub.title", "ASC");
			 $this->db->limit(1);
		 	 $query_sub = $this->db->get();
		
			 if($query_sub->num_rows()>0)
			 {
					return $query_sub->result_array();
			 }else{
					return array();
			 }
	   }
	   public function subscription_faq()
	   {
		     $this->db->select("faq.*");
			 $this->db->from("faq_management AS faq");
		 	 $this->db->where("faq.faq_status",'Active');
			 $this->db->where("faq.faq_type",'subscription');
		 	 $this->db->order_by("faq.question", "ASC");
			 
			 $query_faq = $this->db->get();
		
			 if($query_faq->num_rows()>0)
			 {
					return $query_faq->result_array();
			 }else{
					return array();
			 }
	   }
	   
  }
?>