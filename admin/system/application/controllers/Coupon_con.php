<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_con extends CI_Controller {

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
	   $this->load->model('coupon_mod');
	    $this->load->model('landing_mod');
	}
	
	public function index()
	{   //echo "here";die;
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'Coupon';
			$data['pagetitle'] = 'Coupon Management';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Coupon Pages</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			$data['coupon_details'] = $this->coupon_mod->get_all_coupon();
			//echo "<pre>";print_r($data['coupon_details']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('coupon/manage_coupon',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_coupon_details()
	{  
		$data['menutitle'] = 'Coupon';
		$data['pagetitle'] = 'Add Coupon Page';
		
		$data['course_details'] =  $this->landing_mod->get_all_bundle_courses(); 
		$data['customers']			 = $this->landing_mod->get_all_customers();
		
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'coupon_con">Manage Coupons</a><i class="fa fa-angle-right"></i></li><li>Add Coupon</li></ul>';
		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('coupon/add_coupon',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add Coupon Page')
		{ //echo "<pre>";print_r($this->input->post());die;
		   $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		   $this->form_validation->set_rules('coupon_discnt', 'Coupon Discount', 'trim|required|numeric');
		   $this->form_validation->set_rules('startdate', 'Start Date', 'trim|required');
		    $this->form_validation->set_rules('enddate', 'Expiry Date', 'trim|required');
		  
		 	if ($this->form_validation->run() == FALSE)
			{   
				$this->template->set_layout('admin_default')->build('coupon/add_coupon',$data);
			}
			else{
				$data_insert['coupon_code'] 			= trim($this->input->post('coupon_code'));
				$data_insert['coupon_discount'] 		= trim($this->input->post('coupon_discnt'));
				$data_insert['discount_type'] 			= trim($this->input->post('discount_type'));
				$data_insert['coupon_type'] 			= trim($this->input->post('coupon_type'));
				$data_insert['max_redemption'] 			= $this->input->post('coupon_max');
				$data_insert['start_date']				= date('Y-m-d', strtotime($this->input->post('startdate')));
				$data_insert['end_date']				= date('Y-m-d', strtotime($this->input->post('enddate')));
				
			    $data_insert['user_id'] 				=  implode(',',$this->input->post('customer_mail'));
				$data_insert['courseid'] 				=  implode(',',$this->input->post('bundle_courses'));
				
				$data_insert['coupon_status'] 			= 'active';
				
				//echo "<pre>";print_r($data_insert);die;
			    $fid = $this->coupon_mod->add_coupon($data_insert);
				 if($fid > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('coupon_con');

			}
		  	
		}
	}
	
	public function coupon_edit($id=0)
	{
		$data['menutitle'] = 'Coupon Page';
		$data['pagetitle'] = 'Edit Coupon';
		
		$arr_id = array('coupon_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['cid'] = $id;
		$data['coupon_details'] = $this->coupon_mod->get_coupon($id);
		$data['course_details'] =  $this->landing_mod->get_all_bundle_courses(); 
		$data['customers']			 = $this->landing_mod->get_all_customers();
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'coupon_con">Manage Coupons</a><i class="fa fa-angle-right"></i></li><li>Edit Coupon</li></ul>';
		//echo "<pre>";print_r($data['page_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('coupon/edit_coupon',$data);
		}
		else
		{  
			  
		    $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		   $this->form_validation->set_rules('coupon_discnt', 'Coupon Discount', 'trim|required|numeric');
		   $this->form_validation->set_rules('enddate', 'Expiry Date', 'trim|required');
           
		   	if ($this->form_validation->run() == FALSE)
			{
				
				$data_coupon['coupon_id'] =  trim($this->input->post('couponid'));
				
			
                $data_coupon['coupon_code'] 			= trim($this->input->post('coupon_code'));
				$data_coupon['coupon_discount'] 		= trim($this->input->post('coupon_discnt'));
				$data_coupon['discount_type'] 			= trim($this->input->post('discount_type'));
				$data_coupon['coupon_type'] 			= trim($this->input->post('coupon_type'));
				$data_coupon['max_redemption'] 			= $this->input->post('coupon_max');
				$data_coupon['start_date']				= date('Y-m-d', strtotime($this->input->post('startdate')));
				$data_coupon['end_date']				= date('Y-m-d', strtotime($this->input->post('enddate')));
				
			    $data_coupon['user_id'] 				=  implode(',',$this->input->post('customer_mail'));
				$data_coupon['courseid'] 				=  implode(',',$this->input->post('bundle_courses'));
                
				$data['coupon_details'][0] = $data_coupon;
				$this->template->set_layout('admin_default')->build('coupon/edit_coupon',$data);
				
			}
			else{  
				$id = trim($this->input->post('couponid'));
				
				
				$data_update['coupon_code'] 			= trim($this->input->post('coupon_code'));
				$data_update['coupon_discount'] 		= trim($this->input->post('coupon_discnt'));
				$data_update['discount_type'] 			= trim($this->input->post('discount_type'));
				$data_update['coupon_type'] 			= trim($this->input->post('coupon_type'));
				$data_update['max_redemption'] 			= $this->input->post('coupon_max');
				$data_update['start_date']				= date('Y-m-d', strtotime($this->input->post('startdate')));
				$data_update['end_date']				= date('Y-m-d', strtotime($this->input->post('enddate')));
				
			    $data_update['user_id'] 				=  implode(',',$this->input->post('customer_mail'));
				$data_update['courseid'] 				=  implode(',',$this->input->post('bundle_courses'));
				
			    $pageid = $this->coupon_mod->update_coupon($data_update,$id);
				 if($pageid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('coupon_con');

			}
			
		}
	}
	
	public function get_coupon_details($pid)
     {
		  //echo 'here';die; 
	   $data_coupon = $this->coupon_mod->get_coupon($pid);
	  //echo "<pre>";print_r($data_coupon);
	   $userid=$data_coupon[0]['user_id'];
	  $courseid=$data_coupon[0]['courseid'];
	   $data['users']=$data['course']= array();
	  
	   if($userid !='')
	   {
		  $data['users'] = $this->coupon_mod->get_user_detail($userid);
	   }
	    if($courseid !='')
	   {  
		  $data['course'] = $this->coupon_mod->get_course_detail($courseid);
	   }
	   //echo "<pre>";print_r($data['course']);
	   //echo 111;die;
	   $data['coupon_details']= $data_coupon;
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Coupon Details';
	   if($data != false)
		{
			$this->load->view('coupon/coupon_popup',$data);
					
		}
		  
     }
	 
	public function delete_coupon($id)
	{
		 $result=$this->coupon_mod->delete_single_coupon($id);
		 if($result > 0){
			 $arr_msg = array('suc_msg'=>'Record deleted successfully!!!');
			}else{
			 $arr_msg = array('err_msg'=>'Failed to delete record');
			}
		 $this->session->set_userdata($arr_msg);
		 return true;
		// redirect('course_con/manage_course_quest/'.$courseid);
	}
	
	public function check_coupon_code($code)
     {
		 $result = $this->coupon_mod->check_coupon_code($code);
		 echo $result;
		  
     }
}
