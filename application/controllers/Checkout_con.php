<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Checkout_con.php
# Created on : 12th Sep 2016 by Rakesh Ahirrao
# Update on : 04th Oct 2016 by Rakesh Ahirrao
# Purpose : Checkout related functionality like payment gatways integrations .
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_con extends CI_Controller {

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
	public $tax_amount = 0;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cart_mod');
		$this->load->model('bundle_mod');
		$this->load->model('course_mod');
		$this->load->model('customer_mod');
		$this->load->model('checkout_mod');
		$this->load->model('state_mod');
		$this->load->model('subscription_mod');
		$this->load->library('email');
		$this->load->library('paypal_lib');
		$this->current_user_id = is_logged_in();
		if($this->session->userdata['state_id']=='')
		{
			$this->current_state = find_states();
		}else{
			$this->current_state =  $this->session->userdata['state_id'];
		}
		
		$tax_per = $tax_per  = $this->checkout_mod->get_tax_percentage();
		$this->tax_amount =  $tax_per[0]['tax_percentage'];
	} 
	 
	public function index()
	{
		$data['page_title'] = 'Checkout | CPE Nation';
		
		if($this->session->userdata('error_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('error_msg');
				$this->session->unset_userdata('error_msg');
		}
		if($this->session->userdata('error_msg1') != '')
		{
				$data['err_msg1'] = $this->session->userdata('error_msg1');
				$this->session->unset_userdata('error_msg1');
		}
		
		
		if(isset($this->session->userdata['order_id']))
		{
			$order_id = $this->session->userdata['order_id'];
			$data['order_item_details'] = $this->cart_mod->get_cart_items($order_id,$this->current_user_id);
		
		$data['cuser_id'] = $this->current_user_id;
		$tax_per = $this->checkout_mod->get_tax_percentage();
		$data['tax_per'] = $this->tax_amount;
		if(isset($this->current_user_id) && $this->current_user_id!=0){
			$data['customers'] = $cdetails = $this->customer_mod->get_customer_details($this->current_user_id);
			if(isset($cdetails[0]['stripe_id']))
			{
				try {
					 require_once(APPPATH.'libraries/stripe/Stripe.php'); 
					 Stripe::setApiKey(STRIP_KEY_PHP);
					 $getcustomer = Stripe_Customer::retrieve($cdetails[0]['stripe_id']);
					 
					 foreach($getcustomer->sources->data as $key => $strip_val)
					 {
						 
						 $card_details[$strip_val->id]['customer'] = $strip_val->customer;
						 $card_details[$strip_val->id]['card_brand'] = $strip_val->brand;
						 $card_details[$strip_val->id]['exp_month'] = $strip_val->exp_month;
						 $card_details[$strip_val->id]['exp_year'] = $strip_val->exp_year;
						 $card_details[$strip_val->id]['last4'] = $strip_val->last4;
					 }
					 
					 $data['cards'] = $card_details; 
					 
				}catch (Exception $e) {
				  
				}
			}
		}
		$data['checkout_faq'] = $this->checkout_mod->checkout_faq();
		$this->template->load('layouts/default_layout.php','checkout/checkout.php',$data); 
		}else{
			redirect(base_url().'cart');
		}
	}
	
	public function stripe_payment($post,$user_id = 0)
	{
		  try {
			    $this->current_user_id = $user_id;
	     		require_once(APPPATH.'libraries/stripe/Stripe.php');
		   		$token = $post['stripeToken'];
				Stripe::setApiKey(STRIP_KEY_PHP);
				
				if(isset($this->current_user_id) && $this->current_user_id!=0)
				{
					$customer_details = $this->customer_mod->get_customer_details($this->current_user_id);
					$full_name = $customer_details[0]['first_name'].' '.$customer_details[0]['last_name'];
					$toemail=$customer_details[0]['email'];
					$customer = Stripe_Customer::create(array(
		  				"source" => $token,
		  				"description" => $full_name)
					);
    				
					$strip_cust_id = trim($customer->id);
					$card_id = trim($customer->default_source);
					$this->customer_mod->update_strip_id($strip_cust_id,$this->current_user_id);
					$promo_id = $post['counpon_id'];
					$prices = $this->calculate_price($promo_id);
				    $amount = ($prices['new_amount']*100);
					
					$payment_status = Stripe_Charge::create(array("amount" => $amount,
                                "currency" => "usd",
                                "card" => $card_id,
								"customer" => $strip_cust_id,
								"description" => trim($customer_details[0]['email']))
								);
								
					if(isset($payment_status->id))
					{
						   $confim_order_id = $this->session->userdata['order_id'];
						   $this->customer_mod->update_payment($payment_status,$this->current_user_id,$prices,$confim_order_id);
						   $arr_order_data = array(
						   					'order_id' => '',
											'cart_count' => ''
						   );
						   
						   $this->session->set_userdata($arr_order_data);
						   $_SESSION['order_id'] =	'';
						
						   unset($_SESSION['order_id']);
						   unset($_SESSION['cart_count']);
						
						   redirect('success?id='.$confim_order_id);
					
					
					}else{
						   $arr_msg = array('error_msg'=> 'Transaction failed.Please try again...!'); 
			 			   $this->session->set_userdata($arr_msg);
						   redirect(base_url().'checkout?failed');
					}
								
				}
				
				
		   
		  }catch (Exception $e) {
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  $arr_msg = array('error_msg1'=> $err['message']); 
			  $this->session->set_userdata($arr_msg); 
			  redirect(base_url().'checkout?failed');
		  }
	}
	 
	function order_email($confim_order_id,$customer_details)
	{
		  $mydata['data_order'] = $this->checkout_mod->get_order_items($confim_order_id);
		  $mydata['order_details'] = $this->checkout_mod->get_order_details($confim_order_id,$customer_details[0]['id']);
		  $mydata['prices'] = $this->calculate_price($order_details[0]['coupon_id'],$confim_order_id);
		  $mydata['cemail'] = trim($customer_details[0]['email']); 
		  $mydata['full_name'] = $customer_details[0]['first_name'].' '.$customer_details[0]['last_name']; 
			
		  		  
		  $TO = $mydata['cemail'];
		  $SUBJECT = "Order Completed | Receipt";  
		  $html = $this->load->view('email_template/order_recipt.php',$mydata,true);
						  
		  $this->email->initialize($config);
		  $this->email->set_mailtype('html');
		  $this->email->from('info@cpenation.com', 'CPE Nation');
		  $this->email->to($TO);
		  $this->email->subject($SUBJECT);
		  $this->email->message($html);
		  $result1=$this->email->send();
	}
	
	
	public function payment_direct()
	{
		 $card_id = trim($this->input->post('mycards'));
		 $promo_id = $this->input->post('counpon_id');
		 $payment_type = $this->input->post('payment_type');
		 
		 if(trim($this->input->post('mysubmit')) == 'registration')
		 {
			   if(isset($this->current_user_id) && $this->current_user_id!=0)
		       {
				   if($payment_type == 'mystrip')
				   {
					  if($card_id!='add_new')
					  { 
						   try {
							 require_once(APPPATH.'libraries/stripe/Stripe.php'); 
							 Stripe::setApiKey(STRIP_KEY_PHP);
							  $customer_details = $this->customer_mod->get_customer_details($this->current_user_id);
							 /* if(isset($this->session->userdata['order_id']) && $this->session->userdata['order_id'] > 0)
							  {
									$order_id = $this->session->userdata['order_id'];
									$order_detail = $this->checkout_mod->get_amount($order_id,$this->current_user_id);
									$new_amount = ($order_detail[0]['order_total'] - $order_detail[0]['discount']);
									
							  }*/
							  $prices = $this->calculate_price($promo_id);
							  $amount = ($prices['new_amount']*100);
							  $strip_cust_id = trim($customer_details[0]['stripe_id']);
							  $payment_status = Stripe_Charge::create(array("amount" => $amount,
										"currency" => "usd",
										"card" => $card_id,
										"customer" => $strip_cust_id,
										"description" => trim($customer_details[0]['email']))
							  );
							  
							  
							  if(isset($payment_status->id))
							  {
								   $confim_order_id = $this->session->userdata['order_id'];
								   $this->customer_mod->update_payment($payment_status,$this->current_user_id,$prices,$confim_order_id);
								   $arr_order_data = array(
													'order_id' => '',
													'cart_count' => ''
								   );
								   $this->session->set_userdata($arr_order_data);
								   $_SESSION['order_id'] =	'';
								   unset($_SESSION['order_id']);
								   unset($_SESSION['cart_count']);
								   redirect('success?id='.$confim_order_id);
							  }else{
								   redirect(base_url().'checkout?failed');
							  }
						   }catch (Exception $e) {
							   $body = $e->getJsonBody();
							   $err  = $body['error'];
							   $arr_msg = array('error_msg'=> $err['message']); 
							   $this->session->set_userdata($arr_msg);
							   redirect(base_url().'checkout?failed');
						   }
					  }else{
						   	   $arr_msg = array('error_msg'=> 'Please add/select card after that place order.'); 
							   $this->session->set_userdata($arr_msg);
							   redirect(base_url().'checkout?failed');
					  }
				   }else{
					   $this->paypal_pay($promo_id);
				   }
					  
			   }
		 } 
	}
	
	public function get_course_discount($coupon_details,$order_id)
	{
		  $selected_course = explode(',', $coupon_details[0]['courseid']);
		  
		  $order_items = $this->checkout_mod->get_order_items($order_id);
		  $course_damount = 0;
		  foreach($order_items as $key => $items)
		  {  
			    if(in_array($items['course_id'], $selected_course)) {
					if($coupon_details[0]['discount_type'] == 'percent')
					{
						 $coupon_cal_value = ($coupon_details[0]['coupon_discount']/100);
						 $coupon_cal_value =  number_format(($items['course_amount'] * $coupon_cal_value),2);
					}else{
						 $coupon_cal_value = ($items['course_amount'] - $coupon_details[0]['coupon_discount']);
					}
				 	$course_damount +=$coupon_cal_value;
				}else{
					$course_damount = 0;
				}
		  }
		  
		  return $course_damount;
		 
	}
	
	public function get_user_discount($coupon_details,$user_id,$order_total)
	{  
		   $selected_users = explode(',', $coupon_details[0]['user_id']);
		   $coupon_cal_value = 0;
		   foreach($selected_users as $key => $sel_user)
		   {
			    if($sel_user == $user_id)
				{
					if($coupon_details[0]['discount_type'] == 'percent')
					{
						 $coupon_cal_value = ($coupon_details[0]['coupon_discount']/100);
						 $coupon_cal_value = number_format(($order_total * $coupon_cal_value),2);
					}else{
						 $coupon_cal_value = $coupon_details[0]['coupon_discount'];
					}
				 	
				}else{
					$coupon_cal_value = 0;
				}
		   } 
		   return $coupon_cal_value;
	}
	
	public function calculate_price($promo,$myorder_id = 0,$myuser_id = 0)
	{
		  $user_id = $this->current_user_id;
		  if($myuser_id > 0)
		  {
			  $user_id = $myuser_id;
		  }
		  $order_id = $this->session->userdata['order_id'];
					
		  if($myorder_id)
		  {
						$order_id = $myorder_id;
		  }
		  
		  if((isset($this->session->userdata['order_id']) && $this->session->userdata['order_id'] > 0) || (isset($myorder_id) && $myorder_id > 0))
		  {
			  		$order_detail = $this->checkout_mod->get_amount($order_id,$user_id);
		  }
		  
		  if(isset($promo))
		  {
			   $coupon_details = $this->checkout_mod->get_coupon_details($promo);
			  
			   if(count($coupon_details) > 0)
			   {
				    $current_date = date('Y-m-d');
					$coupon_cal_value = 0.00;
					
					$coupon_used_count = $this->checkout_mod->get_maxredemption($coupon_details[0]['coupon_id']); 
					
				    if(($coupon_details[0]['start_date'] <= $current_date) && ($current_date <= $coupon_details[0]['end_date']))
					{
					  if($coupon_details[0]['max_redemption'] >= $coupon_used_count)
					  {	
						   if($coupon_details[0]['coupon_type'] == 'percourse')
						   {
							 $coupon_cal_value = $this->get_course_discount($coupon_details,$order_id);
							 if($coupon_cal_value == 0)
							 {
								 $coupon_cal_value = 0.00;
						  		 $coupon_details[0]['coupon_id'] = 'Coupon not for added cart items/courses.'; 
							 }  
						   }else if($coupon_details[0]['coupon_type'] == 'peruser' && $user_id > 0)
						   {
							   $coupon_cal_value = $this->get_user_discount($coupon_details,$user_id,$order_detail[0]['order_total']);
							   if($coupon_cal_value == 0)
							   {
								 $coupon_cal_value = 0.00;
						  		 $coupon_details[0]['coupon_id'] = 'Coupon not for you.'; 
							   }
						   }else if($coupon_details[0]['coupon_type'] == 'allcourse')
						   {
							   if($coupon_details[0]['discount_type'] == 'amount')
							   {
								   $coupon_cal_value = $coupon_details[0]['coupon_discount'];
							   }else{
								   $cal_value = ($coupon_details[0]['coupon_discount']/100);
								   $coupon_cal_value = number_format(($order_detail[0]['order_total'] * $cal_value),2);
							   } 
						   }
					  }else{
						  $coupon_cal_value = 0.00;
						  $coupon_details[0]['coupon_id'] = 'Coupon reached to max limit.';
					  }
					}else{
						$coupon_cal_value = 0.00;
						$coupon_details[0]['coupon_id'] = 'This coupon code is expired.';
					}
				    
			   }else{
				    $coupon_cal_value = 0.00;
					$coupon_details[0]['coupon_id'] = 'Enter correct promo code.';
			   }
		  }
		  
		if((isset($this->session->userdata['order_id']) && $this->session->userdata['order_id'] > 0) || (isset($myorder_id) && $myorder_id > 0))
		{
			  		//$order_detail = $this->checkout_mod->get_amount($order_id,$user_id);
					$discount_amount = $coupon_cal_value;//number_format(($order_detail[0]['order_total'] * $coupon_cal_value),2);
					
					$mytax_amount = $this->calculate_tax($order_detail[0]['order_total'],$this->tax_amount);
					
					$new_total = (number_format($order_detail[0]['order_total'],2) + $mytax_amount); 
					$new_total = ($new_total - $discount_amount);
					
					$response = array(
								'coupon_id' => $coupon_details[0]['coupon_id'],
								'discount_amount' => $discount_amount,
								'new_amount' => $new_total,
								'tax_amount' => $mytax_amount
					);	
	    } 
		
		return $response; 
	}
	
	public function calculate_tax($order_items_total,$tax_percentage)
	{      
		   $tax_amount =  number_format(($tax_percentage/100)*$order_items_total,2);
		   return $tax_amount;
	}
	
	public function apply_coupon()
	{
		$promocode = trim($this->input->post('promocode'));
		$coupons = $this->calculate_price($promocode);
		if(is_numeric($coupons['coupon_id']))
		{
			echo json_encode($coupons);	
		}else{
			echo json_encode($coupons);	
		}
			
	    exit;	
		
	}
	public function paypal_pay($mypromo_id)
	{
	  if(isset($this->session->userdata['order_id']))
	  {	
	    	$order_id = $this->session->userdata['order_id'];
	    	$order_item_details = $this->cart_mod->get_cart_items($order_id,$this->current_user_id);
			
			$returnURL = base_url().'checkout_con/paysuccess?id='.$order_id; //payment success url
			$cancelURL = base_url().'checkout_con/index'; //payment cancel url
			$notifyURL = base_url().'checkout_con/ipn'; //ipn url
		
			$userID = $this->current_user_id; 
			$logo = base_url().'assets/images/logo.jpg';
		
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('cmd', '_cart');
			$this->paypal_lib->add_field('upload', '1');
			
			$icount = 1;
			$subtotal = 0; 
			foreach($order_item_details as $key => $items)
			{
				if($items['purchase_type'] == 'Bundle')
				{
					$bundle_details = $this->bundle_mod->get_bundle_details($items['course_id']); 
				    $this->paypal_lib->add_field('item_name_'.$icount, trim($bundle_details[0]['bundle_name'])); 
					$this->paypal_lib->add_field('amount_'.$icount,  number_format($items['course_amount'],2)); 
				}
				if($items['purchase_type'] == 'Course')
				{
					$course_details = $this->course_mod->get_course_details($items['course_id']); 
					$this->paypal_lib->add_field('item_name_'.$icount, trim($course_details[0]['course_name'])); 
					$this->paypal_lib->add_field('amount_'.$icount, number_format($items['course_amount'],2)); 
				}
				if($items['purchase_type'] == 'Subscription')
				{
					$sub_details = $this->subscription_mod->get_subscription_details($items['course_id']);
					$this->paypal_lib->add_field('item_name_'.$icount, trim($sub_details[0]['title'])); 
					$this->paypal_lib->add_field('amount_'.$icount, number_format($items['course_amount'],2));  
				}
				
				$icount++;
				$subtotal =  ($subtotal + $items['course_amount']);  
			}
			$tax = $this->calculate_tax($subtotal,$this->tax_amount);
			if($tax > 0)
			{
				 $this->paypal_lib->add_field('tax', number_format($tax,2)); 
			}
			
			$prices = $this->calculate_price($mypromo_id);
		    $discount_amount = $prices['discount_amount'];
			if($discount_amount > 0)
			{
				 $this->paypal_lib->add_field('discount_amount_cart', $discount_amount); 
			}
			 $total_amount = ($subtotal + $tax);
			 $this->paypal_lib->add_field('custom', $userID.'###'.$order_id.'###'.$mypromo_id);
			 $this->paypal_lib->image($logo);
			 $this->paypal_lib->paypal_auto_form();
			
	  }else{
		  redirect(base_url().'cart');
	  }
		
	}
	
	public function add_card()
	{
		 
		if(isset($this->current_user_id) && $this->current_user_id!=0)
		{ 
		   if(trim($this->input->post('mysubmit')) =='registration')
		   {
			
			 $token = trim($this->input->post('stripeToken'));	
			 $custmoer_details  = $this->customer_mod->get_customer_details($this->current_user_id);
			 
			 if($custmoer_details[0]['stripe_id'] == '')
			 {
			 	$full_name = $custmoer_details[0]['first_name'].' '.$custmoer_details[0]['last_name'];
				$customer = Stripe_Customer::create(array(
		  				"source" => $token,
		  				"description" => $full_name)
					);
					$strip_cust_id = trim($customer->id);
					$this->customer_mod->update_strip_id($strip_cust_id,$this->current_user_id);
			 }
			 else
			 {
			  	 try { 
					$strip_cust_id = $custmoer_details[0]['stripe_id'];
			    	require_once(APPPATH.'libraries/stripe/Stripe.php'); 
			   		Stripe::setApiKey(STRIP_KEY_PHP);
			 		$getcustomer = Stripe_Customer::retrieve($strip_cust_id);
			 		$getcustomer->sources->create(array("source" => $token)); 
					$data['success_msg']='Add Card Successfully....';
				 }catch (Exception $e) {
					  $body = $e->getJsonBody();
  					  $err  = $body['error'];
					  $arr_msg = array('error_msg'=> $err['message']); 
					  $this->session->set_userdata($arr_msg);
			     }	
			 }
			  redirect('checkout');
		   }
		}else{
			redirect('checkout');
		}
	}
	
	public function registration()
	{  
		$data['page_title'] = 'Registration | CPE Nation';
		$payment_type = $this->input->post('payment_type');
		$mypromoid = $this->input->post('counpon_id');
		
		if(trim($this->input->post('mysubmit')) == '')
		{       
			
		}
		elseif(trim($this->input->post('mysubmit')) == 'registration')
		{ 
		   if(isset($this->current_user_id) && $this->current_user_id!=0)
		   {
			   if($payment_type == 'mystrip')
			   { 
		  			$this->stripe_payment($_POST,$this->current_user_id);
			   }else{
				    $this->paypal_pay($mypromoid);
			   }
		   }else
		   {
			
				$this->form_validation->set_rules('email', ' Email', 'required|valid_email');
				$this->form_validation->set_rules('password', ' Password', 'required');
				$this->form_validation->set_rules('fname', ' First Name', 'required');
				$this->form_validation->set_rules('lname', ' Last Name', 'required');
			    
				
				
				if ($this->form_validation->run($this) == FALSE)
				{
					   //$this->template->load('layouts/default_layout.php','checkout/checkout.php',$data); 
				}else if(count($this->customer_mod->already_exists(trim($this->input->post('email')))) > 0){ 
					   $arr_msg = array('error_msg'=>'Email already exists. Please enter another one.'); 
					   $this->session->set_userdata($arr_msg);
					   //$this->template->load('layouts/default_layout.php','checkout/checkout.php',$data); 
					  redirect('checkout');
				} 
			    else
			   {
				 $usrname	= trim($this->input->post('email'));
				 $password	= trim($this->input->post('password'));
				 $to = $email = trim($this->input->post('email'));
				 $data_insert['username'] = trim($this->input->post('email'));
				 $data_insert['password'] = md5(trim($this->input->post('password')));
				 $data_insert['str_password'] = trim($this->input->post('password'));
				 $data_insert['email'] = trim($this->input->post('email'));
				 $data_insert['first_name'] = trim($this->input->post('fname'));
				 $data_insert['last_name'] = trim($this->input->post('lname'));
			     $data_insert['state'] = trim($this->input->post('selected_states'));
				 $data_insert['certifications'] = implode(',',$this->input->post('certifications'));
				 $data_insert['created'] = date('Y-m-d H:i:s');
				 $data_insert['modified'] = date('Y-m-d H:i:s');
				 $data_insert['active'] = '1';	
				
				 $stateids =  trim($this->input->post('selected_states'));
				 $id = $this->customer_mod->add_customer($data_insert);
				 $tracker_date = $this->customer_mod->user_credit_daterenge($id,$stateids);
				 
				 if($id > 0)
				 {
					$from='info@cpenation.com';
					$subject="CPE Nation: Account created successfully";
					
					$mydata['first_name'] =  $data_insert['first_name'];
					$mydata['last_name'] = $data_insert['last_name'];
					$mydata['e_mail'] =  $data_insert['email'];
					$mydata['designations'] = $data_insert['certifications'];
					
					$message = $this->load->view('email_template/registration.php',$mydata,true);
					$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('info@cpenation.com', 'CPE Nation');
					$this->email->to($to);
					$this->email->subject($subject);
					$this->email->message($message);
					$result1=$this->email->send();
					
					$arr_user_data = array('user_id'=> $id,
										   'user_email'=> $email,
										   'is_login'=>'1',
										   'user_name'=> trim($this->input->post('fname'))
										   );
				   $this->session->set_userdata($arr_user_data);
				   
				   if(isset($this->session->userdata['order_id'])){
					   $this->customer_mod->update_cart($id,$this->session->userdata['order_id']);
		  		   }
				  if($payment_type == 'mystrip')
			   	  {  
				     	$this->stripe_payment($_POST,$id); 
				  }else{
					  	$this->paypal_pay($mypromoid);
				  }
				   
				 }else{
					 $arr_msg = array('error_msg'=>'Failed to Register.');
					 $this->session->set_userdata($arr_msg);
					 redirect('checkout');
				 }
				 
				// $this->session->set_userdata($arr_msg);
				// redirect('checkout');
				 
			 }
		   }
		}  
	}
	
	public function ipn()
	{
		//paypal return transaction details array
		$paypalInfo	= $this->input->post();

		$data['user_id'] = $paypalInfo['custom'];
		$data['product_id']	= $paypalInfo["item_number"];
		$data['txn_id']	= $paypalInfo["txn_id"];
		$data['payment_gross'] = $paypalInfo["payment_gross"];
		$data['currency_code'] = $paypalInfo["mc_currency"];
		$data['payer_email'] = $paypalInfo["payer_email"];
		$data['payment_status']	= $paypalInfo["payment_status"];

		$paypalURL = $this->paypal_lib->paypal_url;		
		$result	= $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
		
		$mydata = explode('###',$paypalInfo['custom']);
		//check whether the payment is verified
		if(preg_match("/VERIFIED/i",$result)){
		    $user_id = trim($mydata[0]);
			$order_id = trim($mydata[1]);
			$coupon_id = trim($mydata[2]);
			
			if(isset($user_id) && $user_id!=0)
		    {
				$prices = $this->calculate_price($coupon_id,$order_id,$user_id);
				$order_number = $this->checkout_mod->get_order_number();
			    $order_number = $order_number[0]['default_order_number'];
				
				$payment_status['status'] = $paypalInfo["payment_status"];
				$payment_status['txn_id'] = $paypalInfo["txn_id"];
				$this->customer_mod->update_payment($payment_status,$user_id,$prices,$order_id);
				
				$customer_details = $this->customer_mod->get_customer_details($user_id);
				$order_details = $this->checkout_mod->get_order_details($order_id,$user_id);
				$order_item = $this->checkout_mod->get_order_items($order_id);
				$item_first_character = $this->get_character($order_id);
				if(isset($order_details[0]['user_course_flag']) && $order_details[0]['user_course_flag']==0)
			    {
					  $customer_states = $customer_details[0]['state'];
					  $user_course = $this->add_users_courses($customer_states,$order_item,$user_id);
					  if($user_course)
					  {
					  	   $this->checkout_mod->update_flag($order_id,$user_id,$order_number,$item_first_character);
					  }
				}
				
				//order complete mail function
				$this->order_email($order_id,$customer_details);
		    	//end order mail function
			}
			
			
		}
    }
	
	public function success($id)
	{
		 $data['page_title'] = 'Order Completed | CPENATION';
		 $data['order_id'] = $order_id = $_REQUEST['id'];
		 
		 $order_number = $this->checkout_mod->get_order_number();
		 $order_number = $order_number[0]['default_order_number'];
		 
		 if(isset($this->current_user_id) && $this->current_user_id!=0)
		 {
					$customer_details = $this->customer_mod->get_customer_details($this->current_user_id);
					$data['cust_email'] = trim($customer_details[0]['email']);
		 			$order_details = $this->checkout_mod->get_order_details($order_id,$this->current_user_id);
		 
					$data['tax'] = $order_details[0]['order_tax'];
		 			$data['discount'] = $order_details[0]['discount'];
		 
				 if(isset($order_details[0]['coupon_id']) && $order_details[0]['coupon_id']!=0)
				 {
						$coupon_details = $this->checkout_mod->get_coupon_details($order_details[0]['coupon_id']);
						$data['coupon_code'] = $coupon_details[0]['coupon_code'];	
				 }
		 
		 	  $data['checkout_faq'] = $this->checkout_mod->checkout_faq();
		 	  $data['order_item_details'] = $order_item = $this->checkout_mod->get_order_items($order_id);
			  $item_first_character = $this->get_character($order_id);
			  if(isset($order_details[0]['user_course_flag']) && $order_details[0]['user_course_flag']==0)
			  {
				      $customer_states = $customer_details[0]['state'];
					  $user_course = $this->add_users_courses($customer_states,$order_item,$this->current_user_id);
					  if($user_course)
					  {
					  		$this->checkout_mod->update_flag($order_id,$this->current_user_id,$order_number,$item_first_character);
					  }
					 
			  }
			  
			   $my_order_num = $this->checkout_mod->get_num_order($order_id);
			   $data['order_num'] = $my_order_num[0]['order_number'];
			    //order complete mail function		   
				$this->order_email($order_id,$customer_details);
				//end order mail function
		 	  $this->template->load('layouts/default_layout.php','checkout/order_completed.php',$data); 
		 }else{
			  redirect('checkout');
		 }
	}
	
	public function get_character($order_id)
	{
		 $num_of_rows = $this->checkout_mod->get_order_item_row($order_id);
		 if(count($num_of_rows) > 1)
		 {
			 return 'M';
	     }else{
			   switch ($num_of_rows[0]['purchase_type']) 
			   {
					case 'Course':
					  return 'C';
					break;
					
					case 'Bundle':
					   return 'B';
					break;
					
					case 'Subscription':
					   return 'S';
					break;
			   }
	     }
		 
	}
	
	public function paysuccess()
	{
	    //get the transaction data
		$paypalInfo = $this->input->get();
		
		$data['item_number'] = $paypalInfo['item_number']; 
		$data['txn_id'] = $paypalInfo["tx"];
		$data['payment_amt'] = $paypalInfo["amt"];
		$data['currency_code'] = $paypalInfo["cc"];
		$data['status'] = $paypalInfo["st"];
		
		$data['page_title'] = 'Order Completed | CPENATION';
		$data['order_id'] = $order_id = $paypalInfo['id'];
		
		
		 if(isset($this->current_user_id) && $this->current_user_id!=0)
		 {
			 $customer_details = $this->customer_mod->get_customer_details($this->current_user_id);
			 $data['cust_email'] = trim($customer_details[0]['email']);
		 	 $order_details = $this->checkout_mod->get_order_details($order_id,$this->current_user_id);
		 
			 $data['tax'] = $order_details[0]['order_tax'];
		 	 $data['discount'] = $order_details[0]['discount'];
		 
			 if(isset($order_details[0]['coupon_id']) && $order_details[0]['coupon_id']!=0)
			 {
						$coupon_details = $this->checkout_mod->get_coupon_details($order_details[0]['coupon_id']);
						$data['coupon_code'] = $coupon_details[0]['coupon_code'];	
			 }
		     
		 	$data['checkout_faq'] = $this->checkout_mod->checkout_faq();
		 	$data['order_item_details'] = $order_item = $this->checkout_mod->get_order_items($order_id);
		    $my_order_num = $this->checkout_mod->get_num_order($order_id);
		    $data['order_num'] = $my_order_num[0]['order_number'];
			$arr_order_data = array(
												'order_id' => '',
												'cart_count' => ''
							   );
			$this->session->set_userdata($arr_order_data);
			$_SESSION['order_id'] =	'';
			unset($_SESSION['order_id']);
			unset($_SESSION['cart_count']);				   
			$this->template->load('layouts/default_layout.php','checkout/order_completed.php',$data); 
		 }else{
			  redirect('checkout');
		 }
	}
	
	
	public function add_users_courses($customer_states,$order_item,$user_id = 0)
	{
		     $user_course_id = 0;
			 
			 $state = $this->state_mod->state_details($this->current_state);
			 
		     foreach($order_item as $key => $items)
			 {
				  if($items['purchase_type'] == 'Bundle')
				  {
				  		$bundle_details = $this->bundle_mod->get_bundle_details($items['course_id']);
						$bundle_courses = $this->bundle_mod->get_bundle_courses($bundle_details[0]['bundle_courses']);
						$state_drop_id =  $this->state_mod->state_details($items['course_state']);
						$customer_states = $customer_states.','.$state_drop_id[0]['state_id'];
						$customer_states = implode(',', array_unique(explode(',',$customer_states)));
						 
						foreach($bundle_courses as $key => $mycourses)
						{
							$course_details = $this->course_mod->get_course_details($mycourses['course_id']); 
							$course_credits = $this->checkout_mod->get_states_credits($mycourses['course_id'],$customer_states);
							$dataArray = array();
					        if(count($course_credits) > 0)
							{
							 foreach($course_credits as $ckey => $mycredits)
							 {
								 $dataArray[$mycredits['state_abbr']][$mycredits['course_type']] = $mycredits['credit_numbers']; 
							 }
							}
							$data_binsert['user_id'] =  $user_id;//$this->current_user_id;
							$data_binsert['course_id'] = $mycourses['course_id'];
							$data_binsert['order_id'] =  $items['order_id'];
							$data_binsert['course_credits'] = json_encode($dataArray);
							$data_binsert['added_date'] = date('Y-m-d');
						    $data_binsert['expiry_date'] = date('Y-m-d', strtotime('+'.$mycourses['course_period'].' months'));
							$data_binsert['course_status'] = 'Not Started';
							$data_binsert['course_state'] = $items['course_state'];
							$data_binsert['type'] = 'Bundle';
							$data_binsert['parchase_type_id'] = $items['course_id'];
							$data_binsert['pdf_name'] = trim($course_details[0]['course_name']);
							$user_course_id = $this->checkout_mod->insert_courses($data_binsert);
							if($user_course_id)
							{
								$this->added_course_materials($user_course_id,$mycourses['course_id'],$items['order_id'],$user_id);
							}
						}
						
					/*	if($bundle_details[0]['bundle_type'] == 'landing')
						{
							 $this->checkout_mod->update_landing_status($bundle_details[0]['bundle_id'],$user_id);
						}*/
						
				  }
				  elseif($items['purchase_type'] == 'Course')
				  {
					  	$course_details = $this->course_mod->get_course_details($items['course_id']); 
						
						$state_drop_id =  $this->state_mod->state_details($items['course_state']);
						$customer_states = $customer_states.','.$state_drop_id[0]['state_id'];
						$customer_states = implode(',', array_unique(explode(',',$customer_states)));
						
						$course_credits = $this->checkout_mod->get_states_credits($course_details[0]['course_id'],$customer_states);
						$dataArray = array();
						
						if(count($course_credits) > 0)
						{
							 foreach($course_credits as $ckey => $mycredits)
							 {
								 $dataArray[$mycredits['state_abbr']][$mycredits['course_type']] = $mycredits['credit_numbers']; 
							 }
						}
						
						$data_cinsert['user_id'] =  $user_id;//$this->current_user_id;
						$data_cinsert['course_id'] = $items['course_id'];
						$data_cinsert['order_id'] =  $items['order_id'];
						$data_cinsert['course_credits'] = json_encode($dataArray);
						$data_cinsert['added_date'] = date('Y-m-d');
						$data_cinsert['expiry_date'] = date('Y-m-d', strtotime('+'.$course_details[0]['course_period'].' months'));
						$data_cinsert['course_status'] = 'Not Started';
						$data_cinsert['course_state'] = $items['course_state'];
						$data_cinsert['type'] = 'Course';
						$data_cinsert['parchase_type_id'] = $items['course_id'];
						$data_cinsert['pdf_name'] = trim($course_details[0]['course_name']);
						$user_course_id = $this->checkout_mod->insert_courses($data_cinsert);
						if($user_course_id)
						{
								$this->added_course_materials($user_course_id,$items['course_id'],$items['order_id'],$user_id);
						}
				  }
				  
				  elseif($items['purchase_type'] == 'Subscription')
				  {
					   $sdetails = $this->subscription_mod->get_subscription_details($items['course_id']);
					   $duration = $sdetails[0]['duration'];
					   $data_sinsert['subscription_id'] = $items['course_id'];
					   $data_sinsert['user_id'] = $user_id;
					   $data_sinsert['expiry_date'] = date('Y-m-d', strtotime('+'.$duration.' months'));
					   $data_sinsert['added_date'] = date('Y-m-d');
					   $data_sinsert['order_id'] = $items['order_id'];
					   $data_sinsert['status'] = 'active';
					   $user_course_id = $this->checkout_mod->insert_subscriptions($data_sinsert);
				  }  
				  
			 }
			 
			 if($user_course_id)
			 {
				  return true;
			 }else{
				  return false;
			 }
			
	}
	
	public function added_course_materials($user_course_id,$course_id,$order_id,$user_id = 0)
	{
		
			 $course_text = $this->checkout_mod->get_course_text($course_id);
			 if(count($course_text) > 0)
			 {
				foreach($course_text as $ckey => $mytext)
				{
						$data_text['user_id'] = $user_id;//$this->current_user_id;	
						$data_text['order_id'] = $order_id;
						$data_text['user_course_id'] = 	$user_course_id;
						$data_text['course_id'] = $course_id;
						$data_text['video_pdf_id'] = $mytext['id'];
						$data_text['completed_percentage'] = 0; 
						$data_text['material_type'] = 'Text';
						$user_course_text = $this->checkout_mod->insert_courses_text($data_text);
				}
			 }
			 
			 $course_video = $this->checkout_mod->get_course_video($course_id);
			 if(count($course_video) > 0)
			 {
				     foreach($course_video as $ckey => $myvideo)
				     {
						$data_text['user_id'] = $user_id;//$this->current_user_id;	
						$data_text['order_id'] = $order_id;
						$data_text['user_course_id'] = 	$user_course_id;
						$data_text['course_id'] = $course_id;
						$data_text['video_pdf_id'] = $myvideo['id'];
						$data_text['completed_percentage'] = 0; 
						$data_text['material_type'] = 'Video';
						$user_course_text = $this->checkout_mod->insert_courses_text($data_text);
				    }
			 }
			  	
	}
	
}
