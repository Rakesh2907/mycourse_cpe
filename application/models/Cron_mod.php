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

class Cron_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function update_user_expired_course()
	{
		$today_date = date('Y-m-d');
	    $update_user_course = "UPDATE `user_courses` SET `course_status` = 'Expired' WHERE `expiry_date`<'".$today_date."' AND `course_status` NOT IN( 'Expired','Completed')";
		 return $result = $this->db->query($update_user_course);
	}
	
	public function update_coupons_expiry()
	{
		$today_date = date('Y-m-d');
	    $update_coupon = "UPDATE `coupon_codes` SET `coupon_status` = 'inactive' WHERE `end_date`<'".$today_date."'";
		 return $result = $this->db->query($update_coupon);
	}
	
	public function delt_zero_orders()
	{
		  $uid= 0;
		  $this->db->select("o.order_id");
		  $this->db->from("user_orders AS o");
		  $this->db->where("o.user_id", $uid);
		 
		  $this->db->order_by("o.order_id", "DESC");
		  $myquery = $this->db->get();
		 //echo $this->db->last_query();die;
		  if($myquery->num_rows()>0)
		  {
					$resutlt= $myquery->result_array();
					
					foreach ($resutlt as $row)
				    {
						//echo $row['order_id'];
						$query = $this->db->delete('order_courses',array('order_id'=>$row['order_id']));
						
					}
					//echo "<pre>";print_r($resutlt);die;
					
		          $query = $this->db->delete('user_orders',array('user_id'=>0));
		  }
		  return 1;
	}

	
}
