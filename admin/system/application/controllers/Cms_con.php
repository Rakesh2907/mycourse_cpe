<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_con extends CI_Controller {

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
		$this->load->model('cms_mod');
		$this->load->library('ckeditor');
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'CMS';
			$data['pagetitle'] = 'CMS Pages Management';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage CMS Pages</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			$data['cms_pages'] = $this->cms_mod->get_all_cmspages();
			//echo "<pre>";print_r($data['cms_pages']);die;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('cms/manage_cms',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_cms_pages()
	{  
		$data['menutitle'] = 'CMS';
		$data['pagetitle'] = 'Add CMS Page';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'cms_con">Manage CMS Pages</a><i class="fa fa-angle-right"></i></li><li>Add CMS Page</li></ul>';
		
		$this->ckeditor->basePath = $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
      
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';      

		//$this->load->view('welcome_message');
		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('cms/add_cms',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add CMS Page')
		{
		   $this->form_validation->set_rules('cmstitl', 'Page Title', 'trim|required');
		   $this->form_validation->set_rules('cmsdesc', 'Page Description', 'trim|required');
		  
		   $file_error=0;
		  
		 	if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('cms/add_cms',$data);
			}
			else{
				$data_insert['page_title'] 		= trim($this->input->post('cmstitl'));
				$data_insert['page_desc'] 		= trim($this->input->post('cmsdesc'));
				$data_insert['page_status'] 	= 'Active';
				$data_insert['page_updated'] 	=  date('Y-m-d H:i:s');
				

			    $page_id = $this->cms_mod->add_cms_page($data_insert);
				 if($page_id > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('cms_con');

			}
		  	
		}
	}
	
	public function page_edit($id=0)
	{
		$data['menutitle'] = 'CMS Page';
		$data['pagetitle'] = 'Update Page';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'cms_con">Manage CMS Pages</a><i class="fa fa-angle-right"></i></li><li>Update CMS Page</li></ul>';
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','-','FontSize','-','JustifyLeft', 'JustifyCenter', 'JustifyRight')
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		
		$arr_id = array('page_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['page_id'] = $id;
		$data['page_details'] = $this->cms_mod->get_page($id);
		//echo "<pre>";print_r($data['page_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('cms/edit_page',$data);
		}
		else
		{  
		    
		    $this->form_validation->set_rules('pagename', 'Page title', 'trim|required');
		    $this->form_validation->set_rules('pagedesc', 'Page Description', 'trim|required');
           
		   	if ($this->form_validation->run() == FALSE)
			{
				$data['page_id'] =  trim($this->input->post('pageid'));
				$page_details['page_title'] 		    = trim($this->input->post('pagename'));
				$page_details['page_desc'] 		    = trim($this->input->post('pagedesc'));
				$page_details['page_status'] 	    = trim($this->input->post('status'));
				
				$data['page_details'][0] = $page_details;
				$this->template->set_layout('admin_default')->build('cms/edit_page',$data);
				
			}
			else{  
				$id = trim($this->input->post('pageid'));
				$data_update['page_title'] 		= trim($this->input->post('pagename'));
				$data_update['page_desc'] 		= trim($this->input->post('pagedesc'));
				$data_update['page_status']     = trim($this->input->post('status'));
				$data_update['page_updated'] 	=  date('Y-m-d H:i:s');
			    $pageid = $this->cms_mod->update_page($data_update,$id);
				 if($pageid > 0){
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('cms_con');
			}
			
		}
	}
	
	public function get_page_details($pid)
     {
		  //echo 'here';die; 
	   $data['page_details'] = $this->cms_mod->get_page($pid);
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Manage CMS Page';
	   if($data != false)
		{
			$this->load->view('cms/page_popup',$data);
					
		}
		  
     }
	 
	public function delete_cms_page($id)
	{
		 $result=$this->cms_mod->delete_single_page($id);
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
