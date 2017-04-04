<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : State_con.php
# Created on : 19th Sep 2016 by Rakesh Ahirrao
# Update on : 19th Sep 2016 by Rakesh Ahirrao
# Purpose : Get state details and set default set.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class State_con extends CI_Controller {

	/**
	 * States Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public $current_state = 0;		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('state_mod');
		if($this->session->userdata['state_id']=='')
		{
			$this->current_state = find_states();
		}else{
			$this->current_state =  $this->session->userdata['state_id'];
		}
		
	} 
	 
	public function index()
	{
		 
	}
	
	public function state_equirement($sid='')
	{
		
		$data['page_title'] = 'State Requirement | CPE Nation';
		$data['states'] = $this->state_mod->get_us_states();
		
		$stid=  $this->current_state;
		$stateid	=	$this->session->userdata('stateid');
		if($sid !='')
		{  
			$stateid	=	$sid;
			
		}
		elseif($stid !='')
		{
			$stateid	=	$stid;
		}
			$data['stateid']=	$stateid;
			$data['states'] 	 = $this->state_mod->get_us_states();
			$data['state_detail'] = $this->state_mod->state_details($stateid);
			$data['state_reuirement'] = $this->state_mod->get_state_requirement($stateid);
			$datahour = $this->state_mod->state_requirement_hour($stateid);
			$data['totalhr']=$datahour[0]['total'];
			//echo "<pre>";print_r($data['state_reuirement']);die;
		    $this->template->load('layouts/default_layout.php','state/state_requirement.php',$data); 
		
	}
	
	public function get_states()
	{
		 $mysearch_query = trim($_REQUEST['query']);
		 $data_array['suggestions'] = $this->state_mod->state_search_details($mysearch_query);
		 echo json_encode($data_array);
		 /*$query = '{"suggestions": [{ "value": "United Arab Emirates", "data": "AE"},{ "value": "United Kingdom","data": "UK"},{"value": "United States","data": "US"}]}';
		 echo $query;*/
	}
	
}
