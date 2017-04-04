<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_con extends CI_Controller {

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
		$this->load->model('faq_mod');
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'FAQ';
			$data['pagetitle'] = 'FAQ Management';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage FAQ</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			$data['cms_pages'] = $this->faq_mod->get_all_faq();
			//echo "<pre>";print_r($data['cms_pages']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('faq/manage_faq',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_faq()
	{  
		$data['menutitle'] = 'FAQ';
		$data['pagetitle'] = 'Add FAQ';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'faq_con">Manage FAQ</a><i class="fa fa-angle-right"></i></li><li>Add FAQ</li></ul>';
		
		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('faq/add_faq',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add FAQ')
		{
			//echo "<pre>";print_r($this->input->post());die;
		   $this->form_validation->set_rules('ques', 'Question', 'trim|required');
		   $this->form_validation->set_rules('answer', 'Answer', 'trim|required');
		    $this->form_validation->set_rules('type', 'Faq Type', 'trim|required');
		    
		   $file_error=0;
		  
		 	if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('faq/add_faq',$data);
			}
			else{
				$data_insert['question'] 	= trim($this->input->post('ques'));
				$data_insert['answer'] 		= trim($this->input->post('answer'));
				$data_insert['faq_status'] 	= 'Active';
				$data_insert['faq_type'] 	= trim($this->input->post('type'));
				//$data_insert['page_updated'] 	=  date('Y-m-d H:i:s');
				

			    $page_id = $this->faq_mod->add_new_faq($data_insert);
				 if($page_id > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('faq_con');

			}
		  	
		}
	}
	
	public function faq_edit($id=0)
	{
		$data['menutitle'] = 'FAQ';
		$data['pagetitle'] = 'Update FAQ';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'faq_con">Manage FAQ</a><i class="fa fa-angle-right"></i></li><li>Update FAQ</li></ul>';
		$arr_id = array('page_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['id'] = $id;
		$data['page_details'] = $this->faq_mod->get_faq($id);
		//echo "<pre>";print_r($data['page_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('faq/edit_faq',$data);
		}
		else
		{  
		    
		    $this->form_validation->set_rules('ques', 'Question', 'trim|required');
		    $this->form_validation->set_rules('answer', 'Answer', 'trim|required');
           
		   	if ($this->form_validation->run() == FALSE)
			{
				$data['id'] =  trim($this->input->post('faqid'));
				$page_details['question'] 		    = trim($this->input->post('ques'));
				$page_details['answer'] 		    = trim($this->input->post('answer'));
				$page_details['faq_status'] 	    = trim($this->input->post('status'));
				
				$data['page_details'][0] = $page_details;
				$this->template->set_layout('admin_default')->build('faq/edit_faq',$data);
				
			}
			else{  
				$id = trim($this->input->post('faqid'));
				$data_update['question'] 		= trim($this->input->post('ques'));
				$data_update['answer'] 		= trim($this->input->post('answer'));
				$data_update['faq_type'] 	= trim($this->input->post('type'));
				$data_update['faq_status']     = trim($this->input->post('status'));
				//$data_update['page_updated'] 	=  date('Y-m-d H:i:s');
			    $pageid = $this->faq_mod->update_faq($data_update,$id);
				 if($pageid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('faq_con');

			}
			
		}
	}
	
	public function get_faq_details($pid)
     {
		  //echo 'here';die; 
	   $data['page_details'] = $this->faq_mod->get_faq($pid);
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Manage FAQ';
	   if($data != false)
		{
			$this->load->view('faq/faq_popup',$data);
					
		}
		  
     }
	  
	public function delete_faq($id)
	{
		 $result=$this->faq_mod->delete_single_faq($id);
		 if($result > 0){
			 $arr_msg = array('suc_msg'=>'Record deleted successfully!!!');
			}else{
			 $arr_msg = array('err_msg'=>'Failed to delete record');
			}
		 $this->session->set_userdata($arr_msg);
		 return true;
		// redirect('course_con/manage_course_quest/'.$courseid);
	}
	
}
