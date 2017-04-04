<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bundle_con extends CI_Controller 
{
	function __construct()
	{
	  	parent::__construct();
		 is_logged_admin();
		$this->load->model('bundle_mod');
		$this->load->model('customer_mod');
		$this->load->model('course_mod');
	}
	
    public function index($del=0)
	{
		   if($this->session->userdata('userid') != "")
		   {
			 
				$data['bundle_details'] = $this->bundle_mod->get_all_bundles();
				$data['menutitle'] = 'Bundles';
				$data['pagetitle'] = 'Bundles';
				$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Bundles</li></ul>';
				
				if($this->session->userdata('suc_msg') != '')
				{
					$data['suc_msg'] = $this->session->userdata('suc_msg');
					$this->session->unset_userdata('suc_msg');
				}
				if($data != false)
				{
					$this->template
						 ->set_layout('admin_default')
						 ->build('bundle/bundle_manage',$data);
						
				}
		    
		   }else{
				$this->load->view('index');
		   }
	}
	
	public function delete_bundle()
	{
		   $bundle_id = $this->input->post('bundle_id');
		    $arr_msg = array('suc_msg'=>'Record deleted successfully!!!');
		    $this->session->set_userdata($arr_msg); 
		   echo $deleted = $this->bundle_mod->delete_bundle($bundle_id);
		  
	}
	
	public function add_bundle()
	{
	   if($this->session->userdata('userid') != "")
	   {
		$data['menutitle'] = 'Bundles';
		$data['err_msg'] = '';
		$data['pagetitle'] = 'Add Bundle';
		$data['states']			 = $this->customer_mod->get_all_state();	
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'bundle_con">Manage Bundles</a><i class="fa fa-angle-right"></i></li><li>Add Bundles</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('bundle/add_bundle',$data);
		}elseif(trim($this->input->post('submit')) == 'Add Bundle')
		{
			  $this->load->library('s3');
			  
			  $bundle_title = trim($this->input->post('bundle_name'));
			 
			  $this->form_validation->set_rules('bundle_name', 'Bundle Name', 'trim|required|min_length[5]');
			  $this->form_validation->set_rules('bundle_desc', 'Bundle Description', 'trim|required');
			  $this->form_validation->set_rules('bundle_courses[]', 'Courses', 'trim|required');
			  $this->form_validation->set_rules('bundle_price', 'Bundle Price', 'trim|required|numeric|greater_than[0]');
			  $this->form_validation->set_rules('state_id', 'States', 'trim|required');
			  
			  
			  // Upload image
			 $file_error = 0;
			 $imagefile_error = '';
			 if($_FILES['bundle_image']['name'])
			 {
				 $bundle_image = $_FILES['bundle_image']['name'];
				 if(strlen(trim($bundle_image)) > 0) 
				 {
					  $upload_filename_image = $bundle_title.'_'.$bundle_image;
					 $upload_filename_image = str_replace(' ', '_', strtolower($upload_filename_image));
					  if (preg_match('/[\'^£$%&*}{#~?><>,;!|=+¬]/', $upload_filename_image))
				     {
    					 
						  $file_error = 1;
						  $arr_msg = array('err_msg'=>'PDF file format not correct,Not used special character!');
						  $data['err_msg'] = 'Bundle image name format not correct,Not used special character!';
					  }else{
						 
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png','bmp');
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['bundle_image']['tmp_name'], IMAGE_UPLOAD_PATH.$upload_filename_image)) 
								{
									$data['image_file'] = $upload_filename_image;
									
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									
									$targetFile = IMAGE_UPLOAD_PATH_S3.$upload_filename_image;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'images/'.$upload_filename_image, ACL_PUBLIC_READ))
									{
										$s3file = CLOUDFRONT_URL.'images/'.$upload_filename_image;
										
									}else{
										echo "S3 Upload Fail.";
									}
									
								}
					  }
					 
					  }
					  
				 }
				
		     }
			  
			   
			  if ($this->form_validation->run($this) == FALSE)
			  {
					if ($file_error == 1)
				    {
						 $data['fileerror']['imagefile_upload_error'] = $imagefile_error;
					}
					
					$this->template->set_layout('admin_default')->build('bundle/add_bundle',$data); 
			  }elseif(($file_error == 1))
			  {
				  
				   $data['fileerror']['imagefile_upload_error'] = $imagefile_error;
				   
				$this->template->set_layout('admin_default')->build('bundle/add_bundle',$data); 
					
				 }else{
				  
				   $data_insert['bundle_name'] =  trim($this->input->post('bundle_name')); 
				   $data_insert['bundle_desc'] =  trim($this->input->post('bundle_desc'));   
				   $data_insert['bundle_courses'] =  implode(',',$this->input->post('bundle_courses'));
				   $data_insert['bundle_price'] =  trim($this->input->post('bundle_price'));  
				   $data_insert['state_id'] =  trim($this->input->post('state_id')); 
				   $data_insert['bundle_status'] =  trim($this->input->post('bundle_status'));
				   $data_insert['bundle_image'] = trim($data['image_file']); 
				   $data_insert['bundle_created'] = date('Y-m-d H:i:s');
				   $data_insert['back_color'] = trim($this->input->post('back_color'));
				   $data_insert['s3_images'] = trim($s3file);
				   $bundle_id = $this->bundle_mod->add_bundle($data_insert);
				   if($bundle_id > 0){
					    $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				   }else{
					    $arr_msg = array('err_msg'=>'Failed to add record');
				   }
				   //echo "<pre>";print_r($arr_msg);die;
				   $this->session->set_userdata($arr_msg);
				  redirect('bundle_con');
			  }
		  }
		}else{
				$this->load->view('index');
	    }
	}
	
	public function edit_bundle($bundle_id = 0)
	{
		$data['menutitle'] = 'Bundles';
		$data['pagetitle'] = 'Edit Bundle';
		$data['err_msg'] = '';
		$data['states']			 = $this->customer_mod->get_all_state();
		$data['course_details'] =  $this->bundle_mod->get_all_bundle_courses(); 
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'bundle_con">Manage Bundle</a><i class="fa fa-angle-right"></i></li><li>Edit Bundle</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if($this->input->post('bundle_id') && $bundle_id == 0)
		{
			$bundle_id = $this->input->post('bundle_id');
	    }
		
		if(trim($this->input->post('submit')) == '')
		{
			$data['bundle_details'] = $this->bundle_mod->get_bundle_details($bundle_id);
			
			$this->template->set_layout('admin_default')->build('bundle/edit_bundle',$data);
		}elseif(trim($this->input->post('submit')) == 'Edit Bundle')
		{
			  $this->load->library('s3');
			  $bundle_title = trim($this->input->post('bundle_name'));
			 
			  $this->form_validation->set_rules('bundle_name', 'Bundle Name', 'trim|required|min_length[5]');
			  $this->form_validation->set_rules('bundle_desc', 'Bundle Description', 'trim|required');
			  $this->form_validation->set_rules('bundle_courses[]', 'Courses', 'trim|required');
			  $this->form_validation->set_rules('bundle_price', 'Bundle Price', 'trim|required|numeric|greater_than[0]');
			  $this->form_validation->set_rules('state_id', 'States', 'trim|required');
			  
			  // Upload image
			 $file_error = 0;
			 $imagefile_error = '';
			 if($_FILES['bundle_image']['name'])
			 {
				 $bundle_image = $_FILES['bundle_image']['name'];
				 if(strlen(trim($bundle_image)) > 0) 
				 {
					  $upload_filename_image = $bundle_title.'_'.$bundle_image;
					  $upload_filename_image = str_replace(' ', '_', strtolower($upload_filename_image));
					 
					   if (preg_match('/[\'^£$%&*}{#~?><>,;!|=+¬]/', $upload_filename_image))
				     {
    					 
						  $file_error = 1;
						  $arr_msg = array('err_msg'=>'Bundle image name format not correct,Not used special character!');
						  $data['err_msg'] = 'Bundle image name format not correct,Not used special character!';
					  }else{
						   
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png','bmp');
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['bundle_image']['tmp_name'], IMAGE_UPLOAD_PATH.$upload_filename_image)) 
								{
									$data['image_file'] = $upload_filename_image;
									
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									
									$targetFile = IMAGE_UPLOAD_PATH_S3.$upload_filename_image;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'images/'.$upload_filename_image, ACL_PUBLIC_READ))
									{
										$s3file = CLOUDFRONT_URL.'images/'.$upload_filename_image;
										$data_update['s3_images'] = trim($s3file);
										
									}else{
										echo "S3 Upload Fail.";
									}
									
								}
					  }
					  
					  }
				 }
		     } 
			 
			 if ($this->form_validation->run($this) == FALSE)
			 {
					if ($file_error == 1)
				    {
						 $data['fileerror']['imagefile_upload_error'] = $imagefile_error;
					}
					$arr_course_details['bundle_id'] = $this->input->post('bundle_id');
					$arr_course_details['bundle_name'] = trim($this->input->post('bundle_name')); 
					$arr_course_details['bundle_desc'] = trim($this->input->post('bundle_desc'));
					$arr_course_details['bundle_courses'] = implode(',',$this->input->post('bundle_courses'));
					$arr_course_details['bundle_price'] =  trim($this->input->post('bundle_price'));  
				    $arr_course_details['state_id'] =  trim($this->input->post('state_id')); 
				    $arr_course_details['bundle_status'] =  trim($this->input->post('bundle_status'));
				    $arr_course_details['bundle_image'] = trim($this->input->post('old_image')); 
					$arr_course_details['back_color'] = trim($this->input->post('back_color'));
					$data['bundle_details'][0] = $arr_course_details;
					$this->template->set_layout('admin_default')->build('bundle/edit_bundle',$data);
			 }elseif($file_error == 1){
				 	$arr_course_details['bundle_id'] = $this->input->post('bundle_id');
					$arr_course_details['bundle_name'] = trim($this->input->post('bundle_name')); 
					$arr_course_details['bundle_desc'] = trim($this->input->post('bundle_desc'));
					$arr_course_details['bundle_courses'] = implode(',',$this->input->post('bundle_courses'));
					$arr_course_details['bundle_price'] =  trim($this->input->post('bundle_price'));  
				    $arr_course_details['state_id'] =  trim($this->input->post('state_id')); 
				    $arr_course_details['bundle_status'] =  trim($this->input->post('bundle_status'));
				    $arr_course_details['bundle_image'] = trim($this->input->post('old_image')); 
					$arr_course_details['back_color'] = trim($this->input->post('back_color'));
					$data['bundle_details'][0] = $arr_course_details;
				 $this->template->set_layout('admin_default')->build('bundle/edit_bundle',$data);
				 }else{
				    $bundle_id = $this->input->post('bundle_id');
					$data_update['bundle_name'] =  trim($this->input->post('bundle_name')); 
				    $data_update['bundle_desc'] =  trim($this->input->post('bundle_desc'));   
				    $data_update['bundle_courses'] =  implode(',',$this->input->post('bundle_courses'));
				    $data_update['bundle_price'] =  trim($this->input->post('bundle_price'));  
				    $data_update['state_id'] =  trim($this->input->post('state_id')); 
				    $data_update['bundle_status'] =  trim($this->input->post('bundle_status'));
					$data_update['back_color'] = trim($this->input->post('back_color'));
					if(isset($data['image_file']) && $data['image_file']!=''){
						$data_update['bundle_image'] = trim($data['image_file']);
					}else{
						$data_update['bundle_image'] = trim($this->input->post('old_image'));
					}
				     
				    $data_update['bundle_created'] = date('Y-m-d H:i:s');
					
					$bundle_id = $this->bundle_mod->update_bundle($data_update,$bundle_id);
					
				    if($bundle_id > 0){
							$arr_msg = array('suc_msg'=>'Record updated successfully!!!');
					}else{
							$arr_msg = array('err_msg'=>'Failed to add record');
					}
				   $this->session->set_userdata($arr_msg);
				  redirect('bundle_con');
					
			 }
		}
		
	}	
	
}