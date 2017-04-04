<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function is_logged_in() 
{
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('user_id');
	$isLogin = $CI->session->userdata('is_login');
    if (!isset($user) && $isLogin == '') { return 0; } else { return $user; }
}


function find_states()
{
	    $CI =& get_instance();
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
		
		$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
				
		if($query && $query['status'] == 'success' && $query['countryCode'] == 'US') 
		{
		      $region_abr = $query['region'];
			  $state_details = state_details($region_abr);
			
	   		  $state_id =  $state_details[0]['state_id'];
		      $state_name = $state_details[0]['state'];
			  $state_abr = $state_details[0]['state_abbr'];
			  $arr_state = array('state_id'=> $state_id);
			  $CI->session->set_userdata($arr_state); 			  
			  return $state_id;
		} 
		else{
			  $arr_state = array('state_id'=> 5);
			  $CI->session->set_userdata($arr_state); 			  
		      return 5;
		}
		
}

function state_details($states = '')
{
			$CI =& get_instance();
		   	$CI->db->select("s.*");
			$CI->db->from("us_state AS s");
			$CI->db->where("s.state_abbr",$states);
			
			$CI->db->where("s.status",'Active');
			$CI->db->order_by("s.state", "ASC");
			$CI->db->limit(1);
			$query_state = $CI->db->get();
			
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}	
}


?>