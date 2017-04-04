<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_con extends CI_Controller {

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
		$this->load->model('faculty_mod');
	   $this->load->model('course_mod');
	   $this->load->library('ckeditor');
	   is_logged_admin();
	}
	
	public function index()
	{   //echo "here";die;
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'Faculty';
			$data['pagetitle'] = 'Faculty Management';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Faculty</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			$data['faculty_details'] = $this->faculty_mod->get_all_faculty();
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('faculty/manage_faculty',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_faculty_details()
	{  
		$data['menutitle'] = 'Faculty';
		$data['pagetitle'] = 'Add Faculty';
		$data['err_msg'] ='';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'faculty_con">Manage Faculty</a><i class="fa fa-angle-right"></i></li><li>Add Faculty</li></ul>';
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		

		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('faculty/add_faculty',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add Faculty')
		{  
		   //echo "<pre>";print_r($this->input->post());die;
		   $fname=	trim($this->input->post('fname'));
		   $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
		   $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
		   $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		  
		    $file_error=0;
		  	$imagefile_error = '';
			$imagefile_error = 'Please upload gif|jpg|png file for Faculty image';
			
			 if($_FILES['fimage']['name'])
			 {
				$faculty_image = $_FILES['fimage']['name'];
				 if(strlen(trim($faculty_image)) > 0) 
				 {
					  $fname = preg_replace('/[^A-Za-z0-9\_]/', '', $fname);
					  $upload_filename_image = $fname.'_'.$faculty_image;
					  $upload_filename_image = str_replace(' ', '_', strtolower($upload_filename_image));
					   if (preg_match('/[\'^£$%&*}{#~?><>,;!|=+¬]/', $upload_filename_image))
				     {
    					 
						  $file_error = 1;
						  $arr_msg = array('err_msg'=>'PDF file format not correct,Not used special character!');
						  $data['err_msg'] = 'Faculty image name format not correct,Not used special character!';
					  }else{
					  
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png','bmp');
					 
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['fimage']['tmp_name'], IMAGE_FACULTY_UPLOAD_PATH.$upload_filename_image)) 
								{
									$data['image_file'] = $upload_filename_image;
									
									$this->load->library('s3');
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									$targetFile = FACULTIES_IMAGE_UPLOAD_PATH_S3.$upload_filename_image;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'faculties/'.$upload_filename_image, ACL_PUBLIC_READ))
									{
										 $s3facultiesfile = CLOUDFRONT_URL.'faculties/'.$upload_filename_image;
													
									}else{
										 echo "S3 Upload Fail.";
									}
									
								}
					  }
					  
					  }
				
				 }
				 
		     }
			
		 	if ($this->form_validation->run() == FALSE)
			{
				if ($file_error == 1)
				{
					 $data['fileerror']['imagefile_upload_error'] = $imagefile_error;
				}
				$this->template->set_layout('admin_default')->build('faculty/add_faculty',$data);
			}elseif($file_error == 1){
				$this->template->set_layout('admin_default')->build('faculty/add_faculty',$data);
				}
			else{
				
				$data_insert['first_name'] 		= trim($this->input->post('fname'));
				$data_insert['last_name'] 		= trim($this->input->post('lname'));
				$data_insert['email'] 			= trim($this->input->post('email'));
				$data_insert['firm_name'] 		= trim($this->input->post('firm'));
				$data_insert['phone'] 			= trim($this->input->post('phone'));
				$data_insert['practice_area_id'] = trim($this->input->post('practice_area'));
				$data_insert['bio_data'] 		 = trim($this->input->post('biography'));
				$data_insert['faculty_image'] = trim($data['image_file']);
				$data_insert['active'] 			= '1';
				$data_insert['s3_image_path'] = trim($s3facultiesfile);
				//echo "<pre>";print_r($data_insert);die;
			    $fid = $this->faculty_mod->add_faculty($data_insert);
				 if($fid > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('faculty_con');

			}
		  	
		}
	}
	
	public function faculty_edit($id=0)
	{
		$data['menutitle'] = 'Faculty';
		$data['pagetitle'] = 'Edit Faculty';
		 $data['err_msg'] ='';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'faculty_con">Manage Faculty</a><i class="fa fa-angle-right"></i></li><li>Edit Faculty</li></ul>';
		$arr_id = array('faculty_member_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['fid'] = $id;
		$data['faculty_details'] = $this->faculty_mod->get_faculty($id);
		//echo "<pre>";print_r($data['page_details']);die;
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('faculty/edit_faculty',$data);
		}
		else
		{  
			//echo "<pre>";print_r($this->input->post());
			
		   $fname=	trim($this->input->post('fname'));
		   $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
		   $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
		   $this->form_validation->set_rules('email', 'Email', 'trim|required');
		   $this->form_validation->set_rules('status', 'Status', 'trim|required');
		  
		    $file_error=0;
		  	$imagefile_error = '';
			$imagefile_error = 'Please upload gif|jpg|png file for Faculty image';
			
			 if($_FILES['fimage']['name'])
			 {
				 $faculty_image = $_FILES['fimage']['name'];
				 if(strlen(trim($faculty_image)) > 0) 
				 {
					  $fname = preg_replace('/[^A-Za-z0-9\_]/', '', $fname);
					  $upload_filename_image = $fname.'_'.$faculty_image;
					  $upload_filename_image = str_replace(' ', '_', strtolower($upload_filename_image));
					 
					 if (preg_match('/[\'^£$%&*}{#~?><>,;!|=+¬]/', $upload_filename_image))
				     {
    					 
						  $file_error = 1;
						  $arr_msg = array('err_msg'=>'PDF file format not correct,Not used special character!');
						  $data['err_msg'] = 'Faculty image name format not correct,Not used special character!';
					  }else{
					  
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png');
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['fimage']['tmp_name'], IMAGE_FACULTY_UPLOAD_PATH.$upload_filename_image)) 
								{
									$data['image_file'] = $upload_filename_image;
									
									$this->load->library('s3');
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									$targetFile = FACULTIES_IMAGE_UPLOAD_PATH_S3.$upload_filename_image;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'faculties/'.$upload_filename_image, ACL_PUBLIC_READ))
									{
										 $s3facultiesfile = CLOUDFRONT_URL.'faculties/'.$upload_filename_image;
										 $data_update['s3_image_path'] = trim($s3facultiesfile);
													
									}else{
										 echo "S3 Upload Fail.";
									}
									
								}
					  }
					  }
					  
				 }
		     }
           
		   	if ($this->form_validation->run() == FALSE)
			{
				if ($file_error == 1)
				{
					 $data['fileerror']['imagefile_upload_error'] = $imagefile_error;
				}
				$data['fid'] =  trim($this->input->post('fid'));
				
				$faculty_details['faculty_member_id'] 		= trim($this->input->post('fid'));
				$faculty_details['first_name'] 		= trim($this->input->post('fname'));
				$faculty_details['last_name'] 		= trim($this->input->post('lname'));
				$faculty_details['email'] 			= trim($this->input->post('email'));
				$faculty_details['firm_name'] 		= trim($this->input->post('firm'));
				$faculty_details['phone'] 			= trim($this->input->post('phone'));
				$faculty_details['faculty_image'] 	= trim($this->input->post('old_image'));
				$faculty_details['active'] 			= trim($this->input->post('status'));
                $faculty_details['practice_area_id'] 	= trim($this->input->post('practice_area'));
				$faculty_details['bio_data'] 			= trim($this->input->post('biography'));
				
				$data['faculty_details'][0] = $faculty_details;
				//echo "<pre>";print_r($data);die;  
				$this->template->set_layout('admin_default')->build('faculty/edit_faculty',$data);
				
			}elseif($file_error == 1){
				
				$faculty_details['faculty_member_id'] 		= trim($this->input->post('fid'));
				$faculty_details['first_name'] 		= trim($this->input->post('fname'));
				$faculty_details['last_name'] 		= trim($this->input->post('lname'));
				$faculty_details['email'] 			= trim($this->input->post('email'));
				$faculty_details['firm_name'] 		= trim($this->input->post('firm'));
				$faculty_details['phone'] 			= trim($this->input->post('phone'));
				$faculty_details['faculty_image'] 	= trim($this->input->post('old_image'));
				$faculty_details['active'] 			= trim($this->input->post('status'));
                $faculty_details['practice_area_id'] 	= trim($this->input->post('practice_area'));
				$faculty_details['bio_data'] 			= trim($this->input->post('biography'));
				
				$data['faculty_details'][0] = $faculty_details;
				//echo "<pre>";print_r($data);die;  
				$this->template->set_layout('admin_default')->build('faculty/edit_faculty',$data);
			}
			else{  
				$id = trim($this->input->post('fid'));
				$data_update['first_name'] 		= trim($this->input->post('fname'));
				$data_update['last_name'] 		= trim($this->input->post('lname'));
				$data_update['email'] 			= trim($this->input->post('email'));
				$data_update['firm_name'] 		= trim($this->input->post('firm'));
				$data_update['phone'] 			= trim($this->input->post('phone'));
				$data_update['active'] 			= trim($this->input->post('status'));
                $data_update['practice_area_id'] 	= trim($this->input->post('practice_area'));
				$data_update['bio_data'] 			= trim($this->input->post('biography'));
				
				 if(isset($upload_filename_image) && $upload_filename_image!='')
				 {
				 	$data_update['faculty_image'] = trim($upload_filename_image);
				 }else{
					$data_update['faculty_image'] = trim($this->input->post('old_image')); 
				 }
			     
			    $pageid = $this->faculty_mod->update_faculty($data_update,$id);
				 if($pageid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('faculty_con');

			}
			
		}
	}
	
	public function get_faculty_details($pid)
     {
		  //echo 'here';die; 
	   $data['faculty_details'] = $this->faculty_mod->get_faculty($pid);
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Faculty Details';
	   if($data != false)
		{
			$this->load->view('faculty/faculty_popup',$data);
					
		}
		  
     }
	 
	public function delete_faculty($id)
	{
		 $result=$this->faculty_mod->delete_single_faculty($id);
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
