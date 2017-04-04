<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Cart_con.php
# Created on : 13th Sep 2016 by Rakesh Ahirrao
# Update on : 29th Sep 2016 by Rakesh Ahirrao
# Purpose : Add to cart related functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_con extends CI_Controller {

	/**
	 * Index Page for this controller.
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
	public $current_user_id = 0;
	public $current_state = 0;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bundle_mod');
		$this->load->model('course_mod');
		$this->load->model('cart_mod');
		$this->load->model('landing_mod');
		$this->load->model('state_mod');
		$this->load->model('subscription_mod');
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
		$data['page_title'] = 'Cart | CPE Nation';
	    
		
		if(isset($this->session->userdata['order_id'])){
			$order_id = $this->session->userdata['order_id'];
			$data['order_item_details'] = $this->cart_mod->get_cart_items($order_id,$this->current_user_id);
		}
		
		$data['stateid'] = $state_id = $this->current_state;
		if(isset($state_id)){
			 $data['cart_similar_courses'] = $this->course_mod->get_cart_similar_courses($state_id);
		}
		$this->template->load('layouts/default_layout.php','cart/cart.php',$data); 
	}
	
	public function add_to_cart()
	{
		 $cus_id = $this->input->post('cuser_id');
		 $item_type = trim($this->input->post('item_type'));
		 $item_id = $this->input->post('item_id');
		 $state_abr = $this->input->post('state_abr');
		 
		  switch ($item_type) {
			case 'bundle':
			 	   $bdetails = $this->bundle_mod->get_bundle_details($item_id);
				   if(count($bdetails) > 0)
				   {  
					  $bdetails[0]['item_id'] = $bdetails[0]['bundle_id']; 	
					  $bdetails[0]['price'] = $bdetails[0]['bundle_price']; 
				   	  $cart_count = $this->cart_mod->add_to_cart($bdetails[0],'Bundle',$cus_id,$state_abr);
					  $cart_count = $cart_count['cartcount'];
				   }
				  break;
			case 'landing':
				   
			 	   $bdetails = $this->bundle_mod->get_bundle_details($item_id);
				   if(count($bdetails) > 0)
				   {
					  $offer_price =$bdetails[0]['offer_price'];   
					  $price =$bdetails[0]['bundle_price'];   
					   
					  $bdetails[0]['item_id'] = $bdetails[0]['bundle_id']; 	
					  if(($offer_price < $price) && ($offer_price != '0.00')) 
					 {
					 $bdetails[0]['price'] = $offer_price; 
					 }else{
						$bdetails[0]['price'] = $price;  
					 }
					  //echo "<pre>";print_r($bdetails[0]);die;
				   	  //$cart_count = $this->cart_mod->add_to_cart($bdetails[0],'landing',$cus_id,$state_abr);
					  $cart_count = $this->cart_mod->add_to_cart($bdetails[0],'Bundle',$cus_id,$state_abr);
					  $cart_count = $cart_count['cartcount'];
				   }
				  break;
				 
			case 'course':
			        $cdetails = $this->course_mod->get_course_details($item_id);
					if(count($cdetails) > 0)
					{
					   $cdetails[0]['item_id'] = $cdetails[0]['course_id'];
					   if($cdetails[0]['discount_price'] > 0){
						   $cdetails[0]['price'] = $cdetails[0]['discount_price'];
					   }else{
						   $cdetails[0]['price'] = $cdetails[0]['course_price']; 
					   }
					   $cart_count = $this->cart_mod->add_to_cart($cdetails[0],'Course',$cus_id,$state_abr);
					   $cart_count = $cart_count['cartcount'];
					} 
				  break;
			case 'subscription':
				    $sdetails = $this->subscription_mod->get_subscription_details($item_id);
					//print_r($sdetails); die;
					if(count($sdetails))
					{
						$sdetails[0]['item_id'] = $sdetails[0]['subscription_id'];
						$sdetails[0]['price'] = $sdetails[0]['price'];
						$cart_count = $this->cart_mod->add_to_cart($sdetails[0],'Subscription',$cus_id,$state_abr);
						$cart_count = $cart_count['cartcount'];
				    }
				break;
			default:
				
		}
		  if(count($cart_count) > 0){
		  	 	$arr_count = array('cart_count'=> $cart_count);
		   		$this->session->set_userdata($arr_count); 
		  		echo $cart_count;
		  }else{
			  echo 0;
		  }
	}
	
	public function remove_from_cart()
	{
		 $order_id = $this->input->post('orderid');
		 $item_type = trim($this->input->post('item_type'));
		 $course_id =  $this->input->post('courseid');
		 
		  switch ($item_type) {
			case 'bundle':
			       $bdetails = $this->bundle_mod->get_bundle_details($course_id);
				    if(count($bdetails) > 0)
				    {
						  $bdetails[0]['price'] = $bdetails[0]['bundle_price'];
						  $bdetails[0]['course_id'] = $bdetails[0]['bundle_id'];
						  $bdetails[0]['order_id'] = $order_id; 
						  $cart_count = $this->cart_mod->remove_cart_items($bdetails[0],'Bundle');
						  $cart_count = $cart_count['cartcount'];
					}
			break;
		    case 'course':
				    $cdetails = $this->course_mod->get_course_details($course_id);
					if(count($cdetails) > 0)
					{
						  if($cdetails[0]['discount_price'] > 0)
						  {
						   	$cdetails[0]['price'] = $cdetails[0]['discount_price'];
					   	  }else{
						    $cdetails[0]['price'] = $cdetails[0]['course_price']; 
					   	  }
						 $cdetails[0]['course_id'] = $cdetails[0]['course_id'];
						 $cdetails[0]['order_id'] = $order_id; 
						 $cart_count = $this->cart_mod->remove_cart_items($cdetails[0],'Course');
						 $cart_count = $cart_count['cartcount'];
					}
			break;
			case 'landing':
				   $bdetails = $this->bundle_mod->get_bundle_details($course_id);
				  
				   if(count($bdetails) > 0)
				   {
					  $offer_price =$bdetails[0]['offer_price'];   
					  $price =$bdetails[0]['bundle_price'];   
					   
					  $bdetails[0]['item_id'] = $bdetails[0]['bundle_id']; 	
					  if(($offer_price < $price) && ($offer_price != '0.00')) 
					  {
					 	$bdetails[0]['price'] = $offer_price; 
					  }else{
						$bdetails[0]['price'] = $price;  
					  }
					  $bdetails[0]['course_id'] = $bdetails[0]['bundle_id'];
					  $bdetails[0]['order_id'] = $order_id; 
					  $cart_count = $this->cart_mod->remove_cart_items($bdetails[0],'Bundle');
				      $cart_count = $cart_count['cartcount'];
				   }
			break;
			case 'subscription':
			 		 $sdetails = $this->subscription_mod->get_subscription_details($course_id);
					 if(count($sdetails) > 0)
				     {
						  $sdetails[0]['price'] = $sdetails[0]['price'];
						  $sdetails[0]['course_id'] = $sdetails[0]['subscription_id'];
						  $sdetails[0]['order_id'] = $order_id; 
						  $cart_count = $this->cart_mod->remove_cart_items($sdetails[0],'Subscription');
						  $cart_count = $cart_count['cartcount'];
					 }
				break;
			default:
		  }
		 
		 
		if(count($cart_count) > 0){
		  	 	$arr_count = array('cart_count'=> $cart_count);
		   		$this->session->set_userdata($arr_count); 
		  		echo $cart_count;
		}else{
			    echo 0;
	    }
	}
}
