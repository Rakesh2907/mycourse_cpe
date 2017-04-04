<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal_con extends CI_Controller 
{
	 function  __construct(){
		parent::__construct();
		$this->load->model('cart_mod');
		$this->load->model('bundle_mod');
		$this->load->model('course_mod');
		$this->load->model('customer_mod');
		$this->load->model('checkout_mod');
		$this->load->model('state_mod');
		$this->load->library('paypal_lib');
		$this->load->library('email');
		$this->current_user_id = is_logged_in();
		
		if($this->session->userdata['state_id']=='')
		{
			 $this->current_state = find_states();
		}else{
			 $this->current_state =  $this->session->userdata['state_id'];
		}
	 }
	 
	 function success(){
	    //get the transaction data
		$paypalInfo = $this->input->get();
		
		$data['item_number'] = $paypalInfo['item_number']; 
		$data['txn_id'] = $paypalInfo["tx"];
		$data['payment_amt'] = $paypalInfo["amt"];
		$data['currency_code'] = $paypalInfo["cc"];
		$data['status'] = $paypalInfo["st"];
		
		$data['page_title'] = 'Order Completed | CPE Nation';
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
	 
	 function cancel(){
        $this->load->view('paypal/cancel');
	 }
	 
	 function ipn(){
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
		
		//check whether the payment is verified
		if(preg_match("/VERIFIED/i",$result)){
		    //insert the transaction data into the database
			//$this->product->insertTransaction($data);
		}
    }
}