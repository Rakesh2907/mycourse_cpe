<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userorder_con extends CI_Controller {

	/**
	 * Course Page for this controller.
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
	function __construct()
	{
	  	parent::__construct();
		is_logged_admin();
		$this->load->model('customer_mod');
		$this->load->model('userorder_mod');
		$this->load->model('course_mod');
		$this->load->model('bundle_mod');
		$this->load->model('subcription_mod');
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'Users Order';
			$data['pagetitle'] = 'Users Order Management';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage User Orders</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			$data['order_details'] = $this->userorder_mod->get_all_users_order();
			//echo "<pre>";print_r($data['order_details']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('orders/manage_orders',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}

	
	public function get_order_details($oid)
     {
		  //echo 'here';die; 
	   $data['order_details'] = $this->userorder_mod->get_order_details($oid);
	   //echo "<pre>";print_r( $data['order_details']);die;
	   $data['order_course'] = $this->userorder_mod->get_order_course1($oid);
	  //echo "<pre>";print_r( $data['order_course']);die;
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Manage Order';
	   if($data != false)
		{
			$this->load->view('orders/order_popup',$data);
					
		}
		  
     }
	 
	  
	public function refund_order($id)
	{
		 $result=$this->userorder_mod->refund_order($id);
		 if($result > 0){
			 $arr_msg = array('suc_msg'=>'Order Refund successfully!!!');
			}else{
			 $arr_msg = array('err_msg'=>'Failed to Order Refund');
			}
		 $this->session->set_userdata($arr_msg);
		 return true;
		// redirect('course_con/manage_course_quest/'.$courseid);
	}
	
	public function send_order_receipt()
	{
		//echo "<pre>";print_r($this->input->post());die;
		  $confim_order_id=$this->input->post('orderid');
		  $mydata['data_order'] = $this->userorder_mod->get_order_items($confim_order_id);
		 
		  $myorderdata = $this->userorder_mod->get_order_history($confim_order_id);
		  $mydata['order_details'] = $myorderdata;
		  	
		  //$mydata['prices'] = $this->calculate_price($order_details[0]['coupon_id'],$confim_order_id);
		  $customer_details = $this->customer_mod->get_customer($myorderdata[0]['user_id']);
		 
		  $mydata['cemail'] = trim($customer_details[0]['email']); 
		  $mydata['full_name'] = $customer_details[0]['first_name'].' '.$customer_details[0]['last_name']; 
		   //echo "<pre>";print_r($customer_details);die;	
		  		  
		  $TO = $mydata['cemail'];
		  $SUBJECT = "Order Completed | Receipt";  
		  $html = $this->load->view('orders/order_recipt.php',$mydata,true);
		   //echo "<pre>";print_r($html);die;	
		  $this->email->initialize($config);
		  $this->email->set_mailtype('html');
		  $this->email->from('info@cpenation.com', 'cpenation');
		  $this->email->to($TO);
		  $this->email->subject($SUBJECT);
		  $this->email->message($html);
		  $result1=$this->email->send();
		  return true;
	}
	
}
