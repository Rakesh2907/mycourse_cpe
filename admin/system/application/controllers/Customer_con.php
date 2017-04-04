<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_con extends CI_Controller {

	/**
	 * Customer Page for this controller.
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
		$this->load->model('course_mod');
		$this->load->model('subcription_mod');
		$this->load->model('state_mod');
		$this->load->library('pagination');//load pagination library
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
			$data['customer_details'] = $this->customer_mod->get_all_customers();
			$data['menutitle'] = 'Customers';
			$data['pagetitle'] = 'Customers';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Customers</li></ul>';
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('customer/customer_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_customer()
	{
		$data['menutitle'] = 'Customers';
		$data['pagetitle'] = 'Add Customer';
		$data['states']			 = $this->customer_mod->get_all_state();	
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li>Add Customer</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('customer/add_customer',$data);
		}elseif(trim($this->input->post('submit')) == 'Add Customer')
		{ 
			$this->form_validation->set_rules('email', ' Email', 'required|valid_email');
			$this->form_validation->set_rules('password', ' Password', 'required');
			$this->form_validation->set_rules('fname', ' First Name', 'required');
			$this->form_validation->set_rules('lname', ' Last Name', 'required');
			$this->form_validation->set_rules('firm_size', 'Firm size', 'required');
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 $this->template->set_layout('admin_default')->build('customer/add_customer',$data);
		     }else if(count($this->customer_mod->already_exists(trim($this->input->post('email')))) > 0){ 
				   $arr_msg = array('err_msg'=>'Email already exists.Please enter another one.'); 
				   $this->session->set_userdata($arr_msg);
				   redirect('customer_con/add_customer');
			 } 
			 else
			 {
				 $data_insert['username'] = trim($this->input->post('email'));
				 $data_insert['password'] = md5(trim($this->input->post('password')));
				 $data_insert['str_password'] = trim($this->input->post('password'));
				 $data_insert['email'] = trim($this->input->post('email'));
				 $data_insert['first_name'] = trim($this->input->post('fname'));
				 $data_insert['last_name'] = trim($this->input->post('lname'));
				 $data_insert['state'] = implode(',',$this->input->post('course_state'));
				 $data_insert['certifications'] = implode(',',$this->input->post('certifications'));
				 $data_insert['firm_size'] = trim($this->input->post('firm_size'));
				 $data_insert['preferred_course'] = implode(',',$this->input->post('preferred_course'));
				 $data_insert['interest_area'] = implode(',',$this->input->post('interest_area'));
				 $data_insert['created'] = date('Y-m-d H:i:s');
				 $data_insert['modified'] = date('Y-m-d H:i:s');
				 
				 if(trim($this->input->post('active_check')) == '1')
				 {
					$data_insert['active'] = '1';	
				 }else{
					$data_insert['active'] = '0'; 
				 }
				 
				 $id = $this->customer_mod->add_customer($data_insert);
				 if($id > 0){
					 $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('customer_con');
			 }
		}
	}
	
	
	public function edit_customer($id = 0)
	{
		$data['menutitle'] = 'Customers';
		$data['pagetitle'] = 'Edit Customer';
		$data['states']			 = $this->customer_mod->get_all_state();	
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li>Edit Customer</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if($this->input->post('cust_id') && $id == 0)
		{
			$id = $this->input->post('cust_id');
	    }
		
		$arr_id = array('cust_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['customer_details'] = $this->customer_mod->get_customer($id);
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('customer/edit_customer',$data);
		}elseif(trim($this->input->post('submit')) == 'Edit Customer')
		{ 
		    $id = trim($this->input->post('cust_id'));
			$arr_id = array('cust_id'=>$id);
			$this->session->set_userdata($arr_id);	
			
			$this->form_validation->set_rules('email', ' Email', 'required|valid_email');
			$this->form_validation->set_rules('password', ' Password', 'required');
			$this->form_validation->set_rules('fname', ' First Name', 'required');
			$this->form_validation->set_rules('lname', ' Last Name', 'required');
			 
			 if ($this->form_validation->run($this) == FALSE)
			 {
				$cust_details['id'] =  trim($this->input->post('cust_id'));
				$cust_details['email'] =  trim($this->input->post('email'));
				$cust_details['str_password'] =  trim($this->input->post('password'));
				$cust_details['first_name'] =  trim($this->input->post('fname'));
				$cust_details['last_name'] =  trim($this->input->post('lname'));
				$cust_details['active'] =  trim($this->input->post('active_check'));
				$data['customer_details'][0] = $cust_details;
				$this->template->set_layout('admin_default')->build('customer/edit_customer',$data);
		     }else
			 { 
				 $id = trim($this->input->post('cust_id'));
				 $data_update['username'] = trim($this->input->post('email'));
				 $data_update['password'] = md5(trim($this->input->post('password')));
				 $data_update['str_password'] = trim($this->input->post('password'));
				 $data_update['email'] = trim($this->input->post('email'));
				 $data_update['first_name'] = trim($this->input->post('fname'));
				 $data_update['last_name'] = trim($this->input->post('lname'));
				 $data_update['state'] = implode(',',$this->input->post('course_state'));
				 $data_update['certifications'] = implode(',',$this->input->post('certifications'));
				 $data_update['firm_size'] = trim($this->input->post('firm_size'));
				 $data_update['preferred_course'] = implode(',',$this->input->post('preferred_course'));
				 $data_update['interest_area'] = implode(',',$this->input->post('interest_area'));
				 $data_update['zip_code'] = trim($this->input->post('zipcode'));
				 $data_update['modified'] = date('Y-m-d H:i:s');
				 if(trim($this->input->post('active_check')) == '1')
				 {
					$data_update['active'] = '1';	
				 }else{
					$data_update['active'] = '0'; 
				 }
				 
				 $cusid = $this->customer_mod->update_customer($data_update,$id);
				 if($cusid > 0){
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('customer_con');
			 }
		}
	}
	
	public function delete_customer()
	{
		$cust_id = $this->input->post('cust_id');
		echo $deleted = $this->customer_mod->delete_single_customer($cust_id);	
	}
	
	public function custome_orders($custid=0)
	{
		if($this->session->userdata('userid') != "")
		{ 
		    $data['menutitle'] = 'Customers';
			$data['pagetitle'] = 'Customer Orders';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i><a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li>Manage Customer Orders</li></ul>';
			  $data['userid'] = $custid;
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			
			$data['order_details'] = $this->customer_mod->get_all_Cust_orders($custid);
			//echo "<pre>";print_r($data['order_details']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('customer/customer_order_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_course_order($userid=0)
	{
		$data['menutitle'] = 'Customers';
		$data['pagetitle'] = 'Add Course';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i><a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'customer_con/custome_orders/'.$userid.'">Manage Customer Orders</a><i class="fa fa-angle-right"></i></li><li>Add Course</li></ul>';
		$data['userid'] = $userid;
		
		$data['states']			 = $this->customer_mod->get_all_state();
		$data['course_details'] = $this->course_mod->get_all_courses();
		//echo "<pre>";print_r($data['course_details']);die;
		if($this->input->post('submit') == '')
		{
			
			if(sizeof($data) > 0)//if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('customer/add_course',$data);
						
			}
		}elseif($this->input->post('submit') == 'Add Course')
		{
			//echo "<pre>";print_r($this->input->post());die;
		    $this->form_validation->set_rules('course_id', 'Course', 'trim|required');
			$this->form_validation->set_rules('amount', 'Course Amount', 'trim|required');
            
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('customer/add_course',$data);
			}
			else{
				
				
				$tax_amt= $this->customer_mod->admin_tax();
				$tax=$tax_amt[0]['tax_percentage'];
				$uid=trim($this->input->post('userid'));
				$data_order_insert['user_id'] 		= trim($this->input->post('userid'));
				$data_order_insert['order_total'] 	= trim($this->input->post('amount'));
				$data_order_insert['txn_number'] 	= 'added by admin';
				$data_order_insert['order_date'] 	= date('Y-m-d H:i:s');
				$data_order_insert['order_status'] 	= 'Completed';
				$data_order_insert['order_by'] 		= 'admin';
				$data_order_insert['order_tax'] 	= round((($this->input->post('amount')* $tax)/100),2);
				$data_order_insert['final_total'] 	= ($data_order_insert['order_total'] - $data_order_insert['order_tax']);
				
			    $order_id = $this->customer_mod->add_new_order($data_order_insert);
				
				 if($order_id > 0)
				 {   
					$order_number = $this->customer_mod->get_order_number();
                    $order_number = $order_number[0]['default_order_number']; 
					$item_first_character = 'C';
					$this->customer_mod->update_flag($order_id,$order_number,$item_first_character);  
					 
					$data_order_course['order_id'] 		=  $order_id;
					$data_order_course['purchase_type'] = 'Course';
					$data_order_course['course_id'] 	= trim($this->input->post('course_id'));
					$data_order_course['course_amount'] 	= trim($this->input->post('amount'));
					$data_order_course['course_state'] 	= trim($this->input->post('state_id'));
					$order_course_id = $this->customer_mod->add_new_order_course($data_order_course);
					
				
				    $uid = trim($this->input->post('userid'));
				    $user_stateid=$this->customer_mod->get_customer($uid);
					//echo "<pre>";print_r($user_stateid);die;
					$user_all_state= $user_stateid[0]['state'];
					$cid =trim($this->input->post('course_id'));
					
					$state_abbr=$this->input->post('state_id');
					$get_abbr_stateid=$this->customer_mod->get_state_details($state_abbr);
					$user_abbr_state =$get_abbr_stateid[0]['state_id'];
					$state_check =strpos($user_all_state,$user_abbr_state);
					if($state_check =='')
					{
						$user_all_state .=','.$get_abbr_stateid[0]['state_id'].'';	
					}
					
			
					$course_credits = $this->customer_mod->get_states_credits($cid,$user_all_state);
					//echo "<pre>";print_r($course_credits);die;
					$dataArray = array();
					    if(count($course_credits) > 0)
						{
						  foreach($course_credits as $ckey => $mycredits)
							{
								 $dataArray[$mycredits['state_abbr']][$mycredits['course_type']] = $mycredits['credit_numbers']; 
						 }
						}
					
					$courseid=trim($this->input->post('course_id'));
					$course_detail = $this->customer_mod->get_course_details($courseid);					
					
					$data_user_course['user_id'] 	= trim($this->input->post('userid'));
					$data_user_course['course_id'] 	= trim($this->input->post('course_id'));
					$data_user_course['course_status'] 	= 'Not Started';
					$data_user_course['course_credits'] 	= '';
					$data_user_course['added_date'] 	=  date('Y-m-d');
					$data_user_course['course_state'] 	=  trim($this->input->post('state_id'));
					$data_user_course['type'] 	=  'Course';
					$data_user_course['course_credits'] 	=  json_encode($dataArray);
					$data_user_course['order_id'] 	=   $order_id;
					$data_user_course['pdf_name']   =   $course_detail[0]['course_name'];
					
					
					//echo "<pre>";print_r($course_detail);die;
					$expiry_period= $course_detail[0]['course_period'];
					$data_user_course['expiry_date'] 	=  date('Y-m-d', strtotime('+'.$expiry_period.' months'));
					$order_user_id = $this->customer_mod->add_user_course($data_user_course);
				  
					//echo $order_user_id;die;
					$this->added_course_materials($order_user_id,$courseid,$order_id,$uid);
					 
				    $arr_msg = array('suc_msg'=>'Record added successfully!!!');
					
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('customer_con/custome_orders/'.$uid);

			}
		    
		}
	}
	
	public function added_course_materials($user_course_id,$course_id,$order_id,$user_id = 0)
	{
		
			 $course_text = $this->customer_mod->get_course_text($course_id);
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
						$user_course_text = $this->customer_mod->insert_courses_text($data_text);
				}
			 }
			 
			 $course_video = $this->customer_mod->get_course_video($course_id);
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
						$user_course_text = $this->customer_mod->insert_courses_text($data_text);
				    }
			 }
			  	
	}
	
	public function add_subscription_order($userid=0)
	{
		$data['menutitle'] = 'Customers';
		$data['pagetitle'] = 'Add Subscription';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i><a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'customer_con/custome_orders/'.$userid.'">Manage Customer Orders</a><i class="fa fa-angle-right"></i></li><li>Add Subscription</li></ul>';
		$data['userid'] = $userid;
		
		//$data['states']			 = $this->customer_mod->get_all_state();
		$data['course_details'] = $this->subcription_mod->get_all_subcription();
		//echo "<pre>";print_r($data['course_details']);die;
		if($this->input->post('submit') == '')
		{
			
			if(sizeof($data) > 0)//if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('customer/add_subscription',$data);
						
			}
		}elseif($this->input->post('submit') == 'Add Subscription')
		{
			//echo "<pre>";print_r($this->input->post());die;
		    $this->form_validation->set_rules('course_id', 'Course', 'trim|required');
			$this->form_validation->set_rules('amount', 'Course Amount', 'trim|required');
            
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('customer/add_course',$data);
			}
			elseif($this->input->post('submit') == 'Add Subscription')
		{
			//echo "<pre>";print_r($this->input->post());die;
			$subsr_id= trim($this->input->post('course_id'));
		    $this->form_validation->set_rules('course_id', 'Course', 'trim|required');
			$this->form_validation->set_rules('amount', 'Course Amount', 'trim|required');
            
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('customer/add_subscription',$data);
			}
			else{
				
				//$tax_amt= $this->customer_mod->admin_tax();
				//echo "<pre>";print_r($this->input->post());die;
				
				$order_number = $this->customer_mod->get_order_number();
			    $order_number = $order_number[0]['default_order_number'];
				
				$tax='0.0';
				$uid=trim($this->input->post('userid'));
				$data_order_insert['user_id'] 		= trim($this->input->post('userid'));
				$data_order_insert['order_total'] 	= trim($this->input->post('amount'));
				$data_order_insert['txn_number'] 	= 'added by admin';
				$data_order_insert['order_date'] 	= date('Y-m-d');
				$data_order_insert['order_status'] 	= 'Completed';
				$data_order_insert['order_by'] 		= 'admin';
				$data_order_insert['order_tax'] 	= $tax;
				$data_order_insert['final_total'] 	= trim($this->input->post('amount'));

				//echo "<pre>";print_r($data_order_insert);die;
				
			    $order_id = $this->customer_mod->add_new_order($data_order_insert);
				
				 if($order_id > 0)
				 { 
					 $item_first_character = 'S';
					 $this->customer_mod->update_flag($order_id,$order_number,$item_first_character); 
					 
					$data_order_course['order_id'] 		=  $order_id;
					$data_order_course['purchase_type'] = 'Subscription';
					$data_order_course['course_id'] 	= trim($this->input->post('course_id'));
					$data_order_course['course_amount'] = trim($this->input->post('amount'));
					$data_order_course['course_state'] 	= '';
					$order_course_id = $this->customer_mod->add_new_order_course($data_order_course);
					
					 
					$sdetails = $this->subcription_mod->get_subscription_details($this->input->post('course_id'));
					$duration = $sdetails[0]['duration']; 
				    $data_sinsert['subscription_id'] = trim($this->input->post('course_id'));
					$data_sinsert['user_id'] = trim($this->input->post('userid'));
				    $data_sinsert['expiry_date'] = date('Y-m-d', strtotime('+'.$duration.' months'));
					$data_sinsert['added_date'] = date('Y-m-d');
					$data_sinsert['order_id'] = $order_id;
				    $data_sinsert['status'] = 'active';
					$user_course_id = $this->customer_mod->insert_subscriptions($data_sinsert);
					 
				    
				    $arr_msg = array('suc_msg'=>'Record added successfully!!!');
					
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('customer_con/custome_orders/'.$uid);

			}
		    
		}
		    
		}
	}
	
	public function get_course_amount($courseid)
     {
		 $result = $this->customer_mod->get_course_amount($courseid);
		 echo  $course_price=$result[0]['course_price'];
		 
		  
     }
	public function get_subscription_amount($courseid)
     {
		 $result = $this->customer_mod->get_subscription_amount($courseid);
		 echo  $course_price=$result[0]['price'];
		 
		  
     }
	 
	public function add_bunddle_order($userid=0)
	{
		$data['menutitle'] = 'Customers';
		$data['pagetitle'] = 'Add Bundle';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'customer_con/custome_orders/'.$userid.'">Manage Customer Orders</a><i class="fa fa-angle-right"></i></li><li>Add Bundle</li></ul>';
		$data['userid'] = $userid;
		$data['states']			 = $this->customer_mod->get_all_state();
		$data['bundle_details'] = $this->customer_mod->get_bundles();
		//echo "<pre>";print_r($data['bundle_details']);die;
		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('customer/add_bundle',$data);
						
			}
		}elseif($this->input->post('submit') == 'Add Bundle')
		{
			//echo "<pre>";print_r($this->input->post());die;
		    $this->form_validation->set_rules('bundle_id', 'Bundle', 'trim|required');
			$this->form_validation->set_rules('amount', 'Bundle Amount', 'trim|required');
            
			if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('customer/add_bundle',$data);
			}
			else{
				
				$tax_amt= $this->customer_mod->admin_tax();
				$tax=$tax_amt[0]['tax_percentage'];
				
				$uid=trim($this->input->post('userid'));
				$data_order_insert['user_id'] 		= trim($this->input->post('userid'));
				$data_order_insert['order_total'] 	= trim($this->input->post('amount'));
				$data_order_insert['txn_number'] 	= 'added by admin';
				$data_order_insert['order_date'] 	= date('Y-m-d H:i:s');
				$data_order_insert['order_status'] 	= 'Completed';
				$data_order_insert['order_by'] 		= 'admin';
                $data_order_insert['order_tax'] 	= round((($this->input->post('amount')*$tax)/100),2);

				

			    $order_id = $this->customer_mod->add_new_order($data_order_insert);
				
				 if($order_id > 0)
				 {  
				    $order_number = $this->customer_mod->get_order_number();
					$order_number = $order_number[0]['default_order_number'];

					$item_first_character = 'B';
					$this->customer_mod->update_flag($order_id,$order_number,$item_first_character);  
					 
					$data_order_course['order_id'] 		=  $order_id;
					$data_order_course['purchase_type'] = 'Bundle';
					$data_order_course['course_id'] 	= trim($this->input->post('bundle_id'));
					$data_order_course['course_amount'] 	= trim($this->input->post('amount'));
				    $data_order_course['course_state'] 	= trim($this->input->post('state_id'));
					$order_course_id = $this->customer_mod->add_new_order_course($data_order_course);
					
					
					$bundleid=trim($this->input->post('bundle_id'));
					$bundledetails = $this->customer_mod->get_bundle_details($bundleid);
					//echo "<pre>";print_r($bundledetails);die;
					$cours_ids=$bundledetails[0]['bundle_courses'];
					$cours = explode(",", $cours_ids);
					
					$coursedetails = $this->customer_mod->get_bundle_courses_details($cours);
					$count_course = count($coursedetails);
					
					
					$usrid=trim($this->input->post('userid'));
					$user_stateid=$this->customer_mod->get_customer($usrid);
					
					$user_all_state= $user_stateid[0]['state'];
					
					$state_abbr=$this->input->post('state_id');
					$get_abbr_stateid=$this->customer_mod->get_state_details($state_abbr);
					
					$user_abbr_state =$get_abbr_stateid[0]['state_id'];
					$state_check =strpos($user_all_state,$user_abbr_state);
					
					if($state_check =='')
					{
						$user_all_state .=','.$get_abbr_stateid[0]['state_id'].'';	
					}
					//echo "<pre>".$user_all_state;print_r($get_abbr_stateid);die;
					if($count_course > 0)
					{ 
					  foreach($coursedetails as $row )
					  {
						  
							$course_credits = $this->customer_mod->get_states_credits($row['course_id'],$user_all_state);
					//echo "<pre>";print_r($course_credits);die;
							$dataArray = array();
								if(count($course_credits) > 0)
								{
								  foreach($course_credits as $ckey => $mycredits)
									{
										 $dataArray[$mycredits['state_abbr']][$mycredits['course_type']] = $mycredits['credit_numbers']; 
								 }
								}  
								
						$data_user_course['user_id'] 	= $usrid;
						$data_user_course['course_id'] 	= $row['course_id'];
						$data_user_course['course_status'] 	=  'Not Started';
						$data_user_course['course_credits'] 	=   json_encode($dataArray);
						$data_user_course['course_state'] 	=   $state_abbr;
						$data_user_course['order_id'] 	=   $order_id;
						$data_user_course['type'] 	=  'Bundle';
						$data_user_course['added_date'] 	=  date('Y-m-d');
						
						$expiry_period= $row['course_period'];
						$data_user_course['expiry_date'] 	=  date('Y-m-d', strtotime('+'.$expiry_period.' months'));
						
						$order_user_id = $this->customer_mod->add_user_course($data_user_course); 
						 if($order_user_id)
							{ 
								$this->added_course_materials($order_user_id,$row['course_id'],$order_id,$usrid);  
							}
						  
					  }
					}
					//echo "<pre>";print_r($coursedetails);die;
		
				   //echo $order_user_id;die;
				    $arr_msg = array('suc_msg'=>'Record added successfully!!!');
					
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('customer_con/custome_orders/'.$uid);

			}
		    
		}
	} 
	
	public function get_bundle_amount($bundleid)
     {
		 $result = $this->customer_mod->get_bundle_amount($bundleid);
		 echo  $bundle_price=$result[0]['bundle_price'];
		 
		  
     }
     
     public function clean_filename($string){
		$string = trim($string);
		$string = strtolower($string);
		$string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.

		return preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
	}
	
	public function get_order_details($ordid)
     {
	   $data['order_details'] = $this->customer_mod->get_order_course_details($ordid);
	  //echo "<pre>";print_r($data['order_details']);die;
	   $count_order = count($data['order_details']);
		$arrdata=array();
		if($count_order > 0)
		{   $i=0;
		    foreach($data['order_details'] as $row )
			{
			  $arrdata[$i]['type']			= $row['purchase_type'];
			  $arrdata[$i]['course_amount']	= $row['course_amount'];	
			  
			  if($row['purchase_type'] == 'Course')	
			  {
				   $result = $this->customer_mod->get_course_details($row['course_id']);
				   $arrdata[$i]['name']= $result[0]['course_name'];
			  }
			  else if($row['purchase_type'] == 'Bundle')	
			  {
			  	   $result = $this->customer_mod->get_bundle_name($row['course_id']);
				   $arrdata[$i]['name']= $result[0]['bundle_name'];
			  }  
			  else
			  {
				$arrdata[$i]['name']='';  
			  }
			 $i++;
			}
		}
		
		$data['order']=$arrdata;
		//echo "<pre>";print_r($data['order']);die;		
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Order Details';
	   if($data != false)
		{
			$this->load->view('customer/order_popup',$data);
					
		}
		  
     } 
	 
	public function custome_courses_report($custid=0)
	{
		if($this->session->userdata('userid') != "")
		{ 
		    $data['menutitle'] = 'Customer Courses Progress';
			$data['pagetitle'] = 'Customer Courses Progress';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i><a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'customer_con">Manage Customers</a><i class="fa fa-angle-right"></i></li><li>Customer Courses Progress</li></ul>';
			  $data['userid'] = $custid;
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			
			$data['course_notstared']  = $this->customer_mod->get_course_progress($custid,'Not Started');
			$data['course_inprogress'] = $this->customer_mod->get_course_progress($custid,'In-Progress');
			$data['course_completed'] = $this->customer_mod->get_course_progress($custid,'Completed');
			
			//echo "<pre>";print_r($data['course_notstared']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('customer/customer_courses_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function make_course_complete($user_course_id)
	{ 
		 	  $user_course = $this->customer_mod->user_course($user_course_id);
			  $pdf_name = $this->clean_filename($user_course[0]['pdf_name']);
			  $this->customer_mod->update_course_progress($user_course_id);	
			  $result=$this->customer_mod->course_complete($user_course_id);
		     
			 if($result > 0)
			 {
				 $pdfresult = $this->download_certificate($user_course_id,$pdf_name);
				 $arr_msg = array('suc_msg'=>'Course has been marked complete.');
				 if($pdfresult){
				 	echo '1';
				 }
			 }else{
				 $arr_msg = array('err_msg'=>'Failed to mark course complete.');
				 echo '0';
			 }
				$this->session->set_userdata($arr_msg);
		
		// redirect('course_con/manage_course_quest/'.$courseid);
	}
	
	public function download_certificate($user_course_id,$pdf_name)
	{
		     
			 $user_course = $this->customer_mod->user_course($user_course_id);
			 $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1);
			 $customer_details = $this->customer_mod->get_customer($user_course[0]['user_id']);
			 
			  $data['full_name'] = $customer_details[0]['first_name'].' '.$customer_details[0]['last_name']; 
			  $full_name =  $customer_details[0]['first_name'].' '.$customer_details[0]['last_name'];
			  $data['course_id'] = $course_details[0]['course_id'];
			  $data['completed_date'] = trim($user_course[0]['completed_date']);
			  
			  $states =  $this->state_mod->state_details($user_course[0]['course_state']);
			   $data['state_name'] = trim($states[0]['state']); 
				// $data['state_name'] = $states[0]['state'];
				 $credits = json_decode($user_course[0]['course_credits']);
				 
			     foreach($credits as $key => $mycredits)
				 {
					 $mystates_id = $this->state_mod->state_details($key);
					 $mystates_id = $mystates_id[0]['state_id']; 
					 
					 if($key == $user_course[0]['course_state'])
					 {
					      foreach($mycredits as $creadit_type_id => $val)
						  {
							  $mydata[$creadit_type_id][$val] = $this->course_mod->course_type($creadit_type_id);
						  }	 
					 }
					 
				     foreach($mycredits as $creadit_type_id => $val)
				     {
							   
						$this->customer_mod->insert_user_credits($user_course[0]['user_id'],$creadit_type_id,$mystates_id,$val,$user_course[0]['completed_date'],$user_course_id);
					 }
					  
			     }
				  
				 $data['mycredits'] = $mydata;
				 $course_name = $this->clean_filename($course_details[0]['course_name']);
				 $base_path = str_replace('admin','uploads',FCPATH);
				 
				 $html = $this->load->view('certificate_layout.php',$data,true);
				 $file_name = $course_name."_".$user_course_id.".pdf";
				 $pdfFilePath = $base_path.''.$file_name;
				 $this->load->library('m_pdf_new');
				 $this->m_pdf_new->pdf->WriteHTML($html);
				  //download it.
				 ob_clean(); 
				 $this->m_pdf_new->pdf->Output($pdfFilePath, "F"); 
				return 1;		 
			  
	}
	
	 public function amazon_upload_certificate($user_course_id)
	 {
		   $user_course = $this->customer_mod->user_course($user_course_id);
		   $pdf_name = $this->clean_filename($user_course[0]['pdf_name']);
		   $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1);
		   $course_name = $this->clean_filename($course_details[0]['course_name']);
		   $file_name = $course_name."_".$user_course_id.".pdf";
		   $base_path = str_replace('admin','uploads',FCPATH);
		   $targetFile = $base_path.$file_name;
		   
		   $this->load->library('s3');
		   if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'certificates/'.$file_name, ACL_PUBLIC_READ))
		   {
				$s3file = CLOUDFRONT_URL.'certificates/'.$file_name;
				if($this->customer_mod->s3_certificate_path($s3file,$user_course_id))
				{
					echo '1';
				}			
		  }else{
				echo "S3 Upload Fail.";
		  }
		   
		   
	 }
	
}
