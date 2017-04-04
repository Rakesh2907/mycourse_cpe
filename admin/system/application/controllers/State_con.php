<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_con extends CI_Controller {

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
	    $this->load->model('state_mod');
	    $this->load->model('course_mod');
		$this->load->library('ckeditor');
	}
	
	public function index()
	{   //echo "here";die;
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'State';
			$data['pagetitle'] = 'State Management';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage State Pages</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			$data['state_details'] = $this->state_mod->get_all_state();
			//echo "<pre>";print_r($data['state_details']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('state/manage_state',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	

	public function state_edit($id=0)
	{
		$data['menutitle'] = 'State Page';
		$data['pagetitle'] = 'Edit State';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'state_con">Manage State</a><i class="fa fa-angle-right"></i></li><li>Edit State</li></ul>';
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		
		$arr_id = array('state_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['sid'] = $id;
		$data['state_details'] = $this->state_mod->get_state($id);
		//echo "<pre>";print_r($data['page_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('state/edit_state',$data);
		}
		else
		{
			  
		//echo "<pre>";print_r($this->input->post());die;	  
		   $this->form_validation->set_rules('state_phone', 'State Phone', 'trim|required');
		   $this->form_validation->set_rules('state_fax', 'State Fax', 'trim|required');
		   $this->form_validation->set_rules('statedesc', 'State Description', 'trim|required');
		   $this->form_validation->set_rules('statecont', 'State Contact', 'trim|required');
           
		   	if ($this->form_validation->run() == FALSE)
			{
				
				$data['sid'] =  trim($this->input->post('sid'));
				
				$state_details['state_desc'] 			= trim($this->input->post('statedesc'));
				$state_details['state_contact'] 		= trim($this->input->post('statecont'));
				$state_details['state_phone'] 			= trim($this->input->post('state_phone'));
				$state_details['state_fax'] 			= trim($this->input->post('state_fax'));
				$state_details['state_web'] 			= trim($this->input->post('state_website'));

				$data['state_details'][0] = $state_details;
				$this->template->set_layout('admin_default')->build('state/edit_state',$data);
				
			}
			else{  
				$id = trim($this->input->post('sid'));
				$data_update['state_desc'] 			= trim($this->input->post('statedesc'));
				$data_update['state_contact'] 		= trim($this->input->post('statecont'));
				$data_update['state_phone'] 		= trim($this->input->post('state_phone'));
				$data_update['state_fax'] 			= trim($this->input->post('state_fax'));
				$data_update['state_website'] 			= trim($this->input->post('state_web'));
			   
			    $stateid = $this->state_mod->update_state($data_update,$id);
				 if($stateid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('state_con');

			}
			
		}
	}
	
	public function get_state_details($pid)
     {
		  //echo 'here';die; 
	   $data['state_details'] = $this->state_mod->get_state($pid);
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'State Details';
	   if($data != false)
		{
			$this->load->view('state/state_popup',$data);
					
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
		 $result=$this->coupon_mod->check_coupon_code($code);
		 return $result;
		  
     }
	 
	 
	//State Requirement
	public function manage_requirement($stateid)
	{   
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'State';
			$data['pagetitle'] = 'State Requirement';
			
			
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'state_con">Manage State</a><i class="fa fa-angle-right"></i></li><li>Manage State Requirement</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			$data['stateid'] = $stateid;
			$data['state_reqdetails'] = $this->state_mod->get_all_state_requirement($stateid);
			//echo "<pre>";print_r($data['state_reqdetails']); echo "</pre>";
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('state/manage_requirement',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_state_requirement($stateid=0)
	{  
		$data['menutitle'] = 'Coupon';
		$data['pagetitle'] = 'Add State Requirement';
		$data['stateid'] = $stateid;
		
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'state_con">Manage State</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'state_con/manage_requirement/'.$stateid.'">Manage State Requirement</a><i class="fa fa-angle-right"></i></li><li>Add State Requirement</li></ul>';
		
		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('state/add_requirement',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add State Requirement')
		{ 
		  
		   $this->form_validation->set_rules('reqtitle', 'Requirement Title', 'trim|required');
		   $this->form_validation->set_rules('reqdesc', 'Requirement Description', 'trim|required');
		   $this->form_validation->set_rules('reqhour', 'Requirement Hour', 'trim|required|numeric');
		   $data['stateid'] =  trim($this->input->post('stateid'));
		 	
			if ($this->form_validation->run() == FALSE)
			{    //echo "hiii";die;
				$this->template->set_layout('admin_default')->build('state/add_requirement',$data);
			}
			else{
				
				$data_insert['requirment_title'] 			=  trim($this->input->post('reqtitle'));
				$data_insert['requirment_desc'] 			=  trim($this->input->post('reqdesc'));
				$data_insert['requirment_hours'] 			=  trim($this->input->post('reqhour'));
				$data_insert['state_id'] 					=  trim($this->input->post('stateid'));
				$data_insert['back_color'] 					=  trim($this->input->post('back_color'));
				$sid=trim($this->input->post('stateid'));
				//echo "<pre>";print_r($data_insert);die;
			    $rid = $this->state_mod->add_state_requirement($data_insert);
				 if($rid > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('state_con/manage_requirement/'.$sid);

			}
		  	
		}
	}
	
	public function get_state_req_details($rid)
     {
		  //echo 'here';die; 
	   $data['state_details'] = $this->state_mod->get_state_requirement($rid);
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'State Requirement Details';
	   if($data != false)
		{
			$this->load->view('state/state_req_popup',$data);
					
		}
		  
     }
	 
	 
	public function requirement_edit($stateid=0,$id=0)
	{
		$data['menutitle'] = 'Requirement';
		$data['pagetitle'] = 'Update Requirement';
	
		
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'state_con">Manage State</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'state_con/manage_requirement/'.$stateid.'">Manage State Requirement</a><i class="fa fa-angle-right"></i></li><li>Edit State Requirement</li></ul>';
		$arr_id = array('requirment_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['reqid'] = $id;
		$data['stateid'] = $stateid;
		$data['req_details'] = $this->state_mod->get_requirement($id);
	//echo "<pre>";print_r($data['req_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('state/edit_requirement',$data);
		}
		else
		{ 
		   $this->form_validation->set_rules('reqtitle', 'Requirement Title', 'trim|required');
		   $this->form_validation->set_rules('reqdesc', 'Requirement Description', 'trim|required');
		   $this->form_validation->set_rules('reqhour', 'Requirement Hour', 'trim|required|numeric');
		   $data['stateid'] =  trim($this->input->post('stateid'));
		   $stateid=trim($this->input->post('stateid'));
		   $data['reqid'] =  trim($this->input->post('reqid'));
           
		   	if ($this->form_validation->run() == FALSE)
			{ 
				$data['reqid'] =  trim($this->input->post('reqid'));
				$req_details['requirment_title'] 		    = trim($this->input->post('reqtitle'));
				$req_details['requirment_desc'] 		    = trim($this->input->post('reqdesc'));
				$req_details['requirment_hours'] 	    	= trim($this->input->post('reqhour'));
				$req_details['back_color'] 	    	= trim($this->input->post('back_color'));
				$data['req_details'][0] = $req_details;
				$this->template->set_layout('admin_default')->build('state_con/requirement_edit/'.$stateid,$data);
				
			}
			else{   
				$id = trim($this->input->post('reqid'));
				$stateid = trim($this->input->post('stateid'));
				$data_update['requirment_title'] 		= trim($this->input->post('reqtitle'));
				$data_update['requirment_desc'] 		= trim($this->input->post('reqdesc'));
				$data_update['requirment_hours']     	= trim($this->input->post('reqhour'));
				$data_update['back_color']     	= trim($this->input->post('back_color'));
				//$data_update['page_updated'] 	=  date('Y-m-d H:i:s');
			    $reqid = $this->state_mod->update_requirement($data_update,$id);
				//echo "here".$reqid;die;
				 if($reqid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('state_con/manage_requirement/'.$stateid);

			}
			
		}
	}
	
	public function manage_credits($stateid,$credit_id = 0)
	{	
	     $data['menutitle'] = 'Courses';
		 $data['pagetitle'] = 'Manage Credits';	
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'state_con">Manage State</a><i class="fa fa-angle-right"></i></li><li>Manage State Credits</li></ul>';
		 
		 $data['state_details'] = $this->state_mod->get_state($stateid);
		 //$data['states']    = $this->customer_mod->get_all_state();
		 $data['credit_type'] = $this->course_mod->get_credit_types();
		 $data['state_id'] = $stateid;
		 
		 $data['credit_details'] = $this->state_mod->get_state_credit($stateid);
		//echo "<pre>";print_r($data['credit_details']);die;
		 if($credit_id > 0)
		 {
				$data['action'] = 'edit';
				$data['mycredit_id'] = $credit_id;
				$data['course_credit_details'] = $this->state_mod->get_credits($credit_id); 
		 }else{
			    $data['action'] = 'add';
		 }
		 
		 if($data != false)
	     {
					$this->template
						 ->set_layout('admin_default')
						 ->build('state/manage_state_credits',$data);
						
		 }
	}
	
	public function add_credits()
	{
		
		$data_insert['state_id'] = trim($this->input->post('state_id'));
		$data_insert['cat_id'] = trim($this->input->post('credit_type'));
		
		$data_insert['credits'] = trim($this->input->post('credits'));
		
		if($this->state_mod->exits_credit($data_insert))
		{
			$msg = array(
					'message' => 'Already exists record...!'
			);
			echo json_encode($msg);
		}else{
			$credit_id = $this->state_mod->add_credits($data_insert);
			if($credit_id){
			    $credit_details = $this->state_mod->get_credits($credit_id);
				if(is_array($credit_details))
				{
					echo json_encode($credit_details);
				}else{
					  
				}
			}
		}
	}
	
	public function edit_credits()
	{
		$data_update['state_id'] = trim($this->input->post('state_id'));
		$data_update['cat_id'] = trim($this->input->post('credit_type'));
		$data_update['credits'] = trim($this->input->post('credits'));
		
	    $credit_id = $this->input->post('credit_id');
			$mycredit_id = $this->state_mod->update_credits($data_update,$credit_id);
			if($credit_id){
				$credit_details = $this->state_mod->get_credits($credit_id);
				if(is_array($credit_details))
				{
					echo json_encode($credit_details);
				}else{
					  
				}
			}
		
	}
	
	public function delete_credits()
	{
		 $state_id = $this->input->post('stateid');
		 $credit_id = $this->input->post('creditid');
		 echo $id = $this->state_mod->delete_credit($state_id,$credit_id);
	}
}
