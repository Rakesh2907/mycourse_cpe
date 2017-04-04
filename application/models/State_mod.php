<?php 
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : State_mod.php
# Created on : 19th Sep 2016 by Rakesh Ahirrao
# Update on : 19th Sep 2016 by Rakesh Ahirrao
# Purpose : Get state details and set default set.
*/

class State_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_us_states()
	{
		 	$this->db->select("s.*");
			$this->db->from("us_state AS s");
			$this->db->where("s.status",'Active');
			$this->db->order_by("s.state", "ASC");
			$query_state = $this->db->get();
			
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	public function state_details($states = '')
	{
		   	$this->db->select("s.*");
			$this->db->from("us_state AS s");
			if(is_numeric($states)){
				$this->db->where("s.state_id",$states);
			}else{
				$this->db->where("s.state_abbr",$states);
			}
			$this->db->where("s.status",'Active');
			$this->db->order_by("s.state", "ASC");
			$this->db->limit(1);
			$query_state = $this->db->get();
			
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	public function state_search_details($query = '')
	{
		    $this->db->select("s.state_id as data, s.state as value");
			$this->db->from("us_state AS s");				
			$this->db->where("(s.state LIKE '%".$query."%')", NULL, FALSE);
			$this->db->where("s.status",'Active');
			$this->db->order_by("s.state", "ASC");
			$query_state = $this->db->get();
			 // echo $this->db->last_query(); die;
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_user_ip()
    {
		  	$client  = @$_SERVER['HTTP_CLIENT_IP'];
    	  	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    		$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP))
			{
				$ip = $client;
			}
			elseif(filter_var($forward, FILTER_VALIDATE_IP))
			{
				$ip = $forward;
			}
			else
			{
				$ip = $remote;
			}
		
			return $ip;
	}
	
	public function find_states()
	{
		$ip = $this->get_user_ip();
		
		$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
		if($query && $query['status'] == 'success') 
		{
		      $region_abr = $query['region'];
			  $state_details = $this->state_details($region_abr);
			
	   		  $state_id =  $state_details[0]['state_id'];
		      $state_name = $state_details[0]['state'];
			  $state_abr = $state_details[0]['state_abbr'];
			  $arr_state = array('state_id'=> $state_id);
			  $this->session->set_userdata($arr_state); 
			  return  $query;
		} 
		else{
			  $arr_state = array('state_id'=> 5);
			  $this->session->set_userdata($arr_state); 
		      return array();
		}
		
	}
	
	
	public function get_state_requirement($stateid)
	{
		   	$this->db->select("s.*");
			$this->db->from("state_requirement AS s");
			$this->db->where("s.state_id",$stateid);
			$this->db->order_by("s.requirment_id", "ASC");
			$query_state = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	public function state_requirement_hour($stateid)
	{
		   	$this->db->select("SUM(s.requirment_hours) as total");
			$this->db->from("state_requirement AS s");
			$this->db->where("s.state_id",$stateid);
			$this->db->order_by("s.requirment_id", "ASC");
			$query_state = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	
}
?>