<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Bundle_mod.php
# Created on : 10th Sep 2016 by Rakesh Ahirrao
# Update on : 01th Oct 2016 by Rakesh Ahirrao
# Purpose : Bundle related functionality like Bundle listing and Other Bundle functions.
*/

class Bundle_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('customer_mod');
	}
	public function getRows()
	{
		    
	}
	
	public function bundles_count($states = '',$state_search = '')
	{
			$this->db->select("b.*");
			$this->db->from("bundles AS b");
			if($states!='')
			{
				$this->db->where_in("b.state_id",$states);
			}
			if($state_search!=''){
				$this->db->where("(b.bundle_name LIKE '%".$state_search."%' OR b.bundle_desc LIKE '%".$state_search."%')", NULL, FALSE);
			}
			$this->db->where("bundle_status = 'active'");
			$this->db->where("bundle_type = 'bundle'");
			$this->db->order_by("b.bundle_name", "ASC");
			$query_bundle = $this->db->get();
			 //echo $this->db->last_query();
			if($query_bundle->num_rows()>0)
			{
				return $query_bundle->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function bundles_list($states = '',$state_search = '',$limit = '',$offset = '')
	{
		 	$this->db->select("b.*");
			$this->db->from("bundles AS b");
			if($states!=''){
				$this->db->where_in("b.state_id",$states);
			}
			if($state_search!=''){
				$this->db->where("(b.bundle_name LIKE '%".$state_search."%' OR b.bundle_desc LIKE '%".$state_search."%')", NULL, FALSE);
			}
			$this->db->where("bundle_status = 'active'");
			$this->db->where("bundle_type = 'bundle'");
			$this->db->order_by("b.bundle_name", "ASC");
			if($limit!='' && $offset!='')
			{
				$this->db->limit($limit,$offset);
			}else if($offset == '' && $limit!='')
			{
				$this->db->limit($limit);
			}
			$query_bundle = $this->db->get();
			 //echo $this->db->last_query();
			if($query_bundle->num_rows()>0)
			{
				return $query_bundle->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_course_credits($bundle_courses,$state_id = '')
	{
		    $courses_id = explode(',',$bundle_courses);
		  	$this->db->select("SUM(credit_numbers) as total_credits");
			$this->db->from("course_credits");
			$this->db->where_in("course_id",$courses_id);
			if($state_id!=''){
				$this->db->where("state_id",$state_id);
			}
			$query_credits = $this->db->get();
			//echo $this->db->last_query(); echo "<br>";
			if($query_credits->num_rows() > 0)
			{
				foreach($query_credits->result_array() as $crecount)
				{
					if($crecount['total_credits']!='' || $crecount['total_credits']!='NULL' ){		
						return $crecount['total_credits'];   
					}else{
						return 0;
					}
				}
			}
			else
			{
				return array();
			}
			
	}
	
	public function get_ctype_credits($state_id,$courses)
	{
		  $courses_id = explode(',',$courses);
		  
		  $this->db->select("c.course_id, c.course_type, c.credit_numbers, us.state_id, us.state, us.state_abbr, ct.type, ct.type_id");
		  $this->db->join('credits_type AS ct', 'c.course_type = ct.type_id','inner');
		  $this->db->join('us_state AS us', 'c.state_id = us.state_id','inner');
		  $this->db->from("course_credits AS c");
		  $this->db->where_in("c.course_id",$courses_id);
		  $this->db->where("us.state_id",$state_id);
		  $this->db->where("ct.active",'1');
		  $this->db->order_by("us.state", " ASC");
		  $myquery = $this->db->get();
		 // echo $this->db->last_query(); die;
		  if($myquery->num_rows()>0)
	      {
				return $myquery->result_array();
		  }else{
				return array();
		  }
		  
	}
	
	public function get_bundle_courses($courses_id)
	{
		 $course_id = explode(',',$courses_id);
		 $this->db->select("c.*");
		 $this->db->from("courses AS c");
		 $this->db->where_in("c.course_id",$course_id);
		 $this->db->where("c.course_status",'active');
		 $this->db->order_by("c.course_name", "ASC");
		 $query_course = $this->db->get();
		 // echo $this->db->last_query();
		 if($query_course->num_rows()>0)
	     {
				return $query_course->result_array();
		 }else{
				return array();
		 }
		 
	}
	
	public function get_bundle_details($bundle_id)
	{
		    $this->db->select("b.*");
			$this->db->from("bundles AS b");
			$this->db->where("b.bundle_id",$bundle_id);
			$this->db->where("bundle_status = 'active'");
			$this->db->order_by("b.bundle_name", "ASC");
			$this->db->limit(1);
			$query_bundle = $this->db->get();
			// echo $this->db->last_query();
			if($query_bundle->num_rows()>0)
			{
				return $query_bundle->result_array();
			}
			else
			{
				return array();
			}
	}
	
  public function get_state_credits($stateid)
	{
		 
		 $this->db->select("sc.*,ct.type,ct.back_color,ct.grouped,ct.grouped_cats"); //tony added grouped categories so we can add credits properly in the tracker
		 $this->db->from("state_credits AS sc");
		  $this->db->join('credits_type AS ct', 'sc.cat_id = ct.type_id','inner');
		 $this->db->where("sc.state_id",$stateid);
		  $this->db->where("ct.active",'1');
		 $query_state_credit = $this->db->get();
		 // echo $this->db->last_query();
		 if($query_state_credit->num_rows()>0)
	     {
				return $query_state_credit->result_array();
		 }else
		 {
				return array();
		 }
		 
	}
	
	public function get_user_state_credits($userid,$stateid,$user_course_id = 0)
	{
		 
		 $daterenage = $this->customer_mod->get_user_trackerrenge($userid,$stateid);
		 
		 //echo "<pre>";print_r($daterenage);die;
		 $this->db->select("uc.*");
		 $this->db->from("user_credits AS uc");
		  //$this->db->join('credits_type AS ct', 'sc.cat_id = ct.type_id','inner');
		  $this->db->where("uc.user_id",$userid);
		  if($user_course_id > 0)
		  {
		   	 $this->db->where("uc.user_course_id <> ".$user_course_id.""); //what does this do?
		  }
		  $this->db->where("uc.state_id",$stateid);
		  if(count($daterenage) > 0)
		  {
			$sdate = $daterenage[0]['start_date'];  
			$edate = $daterenage[0]['end_date'];  
		  
		     $this->db->where("uc.credit_date >=",$sdate);
		     $this->db->where("uc.credit_date <=",$edate);
		  }
		  
		 $query_user_state_credit = $this->db->get();
		  //echo $this->db->last_query(); die;
		 if($query_user_state_credit->num_rows()>0)
	     {
				return $query_user_state_credit->result_array();
		 }else{
				return array();
		 }
		 
	}
	
	public function get_user_state($uid,$state_id='')
	{
		  $this->db->select("*");
		  $this->db->from("customers");
		  $this->db->where("delete_flg", "0");
		    $this->db->where("id", $uid);
		 
		  if($state_id !='')
		  {
			 $where = "FIND_IN_SET('".$state_id."', state)";  
			
			 $this->db->where( $where );  
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
	
	public function get_user_state_name($state_id='')
	{
		  $this->db->select("state_id,state");
		  $this->db->from("us_state");
		  $this->db->where("status", "Active");
		  $this->db->where("state_id", $state_id);
		 
		  $query_state = $this->db->get();
		  //echo $this->db->last_query();die;
		  if($query_state->num_rows()>0)
		  {
			  return $query_state->result_array();
		  }else{
				return array();
		  }
	}
	
} 
?>