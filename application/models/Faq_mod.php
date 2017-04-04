<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Faq_mod.php
# Created on : 16th Sep 2016 by Shailesh Khairnar
# Update on : 16th Sep 2016 by Shailesh Khairnar
# Purpose : Faculties listing and related functionality.
*/
 
class Faq_mod extends CI_Model
{
	protected $table_faq 	= 'faq_management';
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_faq()
	{
		 	$this->db->select("f.*");
			$this->db->from($this->table_faq.' as f');
			 $this->db->where("f.faq_type","support");
			$this->db->where('f.faq_status','Active');
			$this->db->order_by("f.id", "Desc");
			$query_faq = $this->db->get();
			//echo "<pre>";print_r($date[$faq]);die;
			if($query_faq->num_rows()>0)
			{
				return $query_faq->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	public function get_faq_search($key)
	{
		 	$this->db->select("f.*");
			$this->db->from($this->table_faq.' as f');
			//$this->db->where("s.state_id",$states);
			 $this->db->where("f.faq_type","support");
			$this->db->where('f.faq_status','Active');
			$this->db->where("(f.question LIKE '%".$key."%' OR f.answer LIKE '%".$key."%')", NULL, FALSE);
			$this->db->order_by("f.id", "Desc");
			$query_faq = $this->db->get();
			// echo $this->db->last_query();
			//echo "<pre>";print_r($date[$faq]);die;
			if($query_faq->num_rows()>0)
			{
				return $query_faq->result_array();
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
		$ip = '65.49.22.66';//$this->get_user_ip();
		//$ip = $this->get_user_ip();
		
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
		       return array();
		}
		
	}
	
}
?>