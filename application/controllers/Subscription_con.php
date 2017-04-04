<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Subscription_con.php
# Created on : 24th Sep 2016 by Rakesh Ahirrao
# Update on : 24th Sep 2016 by Rakesh Ahirrao
# Purpose : Subscription Front page with add to cart functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_con extends CI_Controller 
{
	  public function __construct()
	  {
			parent::__construct();
			$this->load->model('subscription_mod');
			$this->load->model('cart_mod');
			$this->load->model('state_mod');
			$this->current_user_id = is_logged_in();
		
			if($this->session->userdata['state_id']=='')
			{
				 $this->current_state = find_states();
			}else{
				 $this->current_state =  $this->session->userdata['state_id'];
			}
	  }
	  
	  public function index()
	  {
		  $data['page_title'] = 'Subscription | CPE Nation';
		  $data['cuserid'] = $this->current_user_id;
		 
		  $data['subscription_details'] = $this->subscription_mod->get_subscription(); 
		  $data['subscription_faq'] = $this->subscription_mod->subscription_faq();
		  
		  $sel_state_id = $this->input->post('dropdown_states');
	      $data['selected_state_id'] = $this->current_state;
		  if(isset($sel_state_id) && $sel_state_id!='')
		  {
				 $arr_state = array('state_id'=> $sel_state_id);
				 $this->session->set_userdata($arr_state); 
				 $data['selected_state_id'] = $sel_state_id;		
		  }else if($this->session->userdata('state_id') == ''){
				$data['selected_state_id'] = $this->session->userdata('state_id');
		  }
		  
		  $state_abr = $this->state_mod->state_details($data['selected_state_id']);
		  $data['mystate_abr'] = trim($state_abr[0]['state_abbr']);
		  
		  if(isset($this->session->userdata['order_id'])){
				$data['cart_id'] = $this->session->userdata['order_id'];
		  }else{
				$data['cart_id'] = '';
		  }
		  $this->template->load('layouts/default_layout.php','subscription/subscription.php',$data);  
	  }
}
?>