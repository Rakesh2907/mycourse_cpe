<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_con extends CI_Controller {

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
	 
	public $coursePrice = 0.00; 
	function __construct()
	{
	  	parent::__construct();
		 is_logged_admin();
		$this->load->model('course_mod');
		$this->load->model('customer_mod');
		$this->load->model('state_mod');
		$this->load->library('ckeditor');
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
		    $data['menutitle'] = 'Courses';
			$data['pagetitle'] = 'Courses';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Courses</li></ul>';
			if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
			
			
			$data['course_details'] = $this->course_mod->get_all_courses();
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('course/course_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function manage_credits($course_id,$credit_id = 0)
	{	
	     $data['menutitle'] = 'Courses';
		 $data['pagetitle'] = 'Manage Credits';	
		 $data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <a href="'.base_url().'course_con">Manage Courses</a> <i class="fa fa-angle-right"></i> </li><li>Credits</li></ul>';
		 $data['course_details'] = $this->course_mod->get_course_details($course_id);
		 $data['states']    = $this->customer_mod->get_all_state();
		 $data['credit_type'] = $this->course_mod->get_credit_types();
		 $data['course_id'] = $course_id;
		 
		 $data['credit_details'] = $this->course_mod->get_state_credit($course_id);
		 
		 if($credit_id > 0)
		 {
				$data['action'] = 'edit';
				$data['mycredit_id'] = $credit_id;
				$data['course_credit_details'] = $this->course_mod->get_credits($credit_id); 
		 }else{
			    $data['action'] = 'add';
		 }
		 
		 if($data != false)
	     {
					$this->template
						 ->set_layout('admin_default')
						 ->build('course/manage_course_credits',$data);
						
		 }
	}
	
	public function manage_material($course_id)
	{
		 
		 $data['menutitle'] = 'Courses';
		 $data['pagetitle'] = 'Manage Material';	
		 $data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li> <a href="'.base_url().'course_con">Manage Courses</a> <i class="fa fa-angle-right"></i> </li><li>Material</li></ul>';
		 $data['course_details'] = $this->course_mod->get_course_details($course_id);
		 $data['course_pdf_details'] = $this->course_mod->get_pdf_details($course_id);
		 $data['course_video_details'] = $this->course_mod->get_video_details($course_id);	
		
		 if($this->session->userdata('suc_msg') != '')
	     {
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
		 }
		 
		 if($this->session->userdata('err_msg') != '')
		 {
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		 }
		
		
		 if($data != false)
	     {
					$this->template
						 ->set_layout('admin_default')
						 ->build('course/manage_course_material',$data);
						
		 }
		 
	}
	
	public function add_credits()
	{
		
		$data_insert['course_id'] = trim($this->input->post('course_id'));
		$data_insert['course_type'] = trim($this->input->post('credit_type'));
		$data_insert['state_id'] = trim($this->input->post('state_id'));
		$data_insert['credit_numbers'] = trim($this->input->post('credits'));
		if($this->input->post('state_id')!='all')
		{
			if($this->course_mod->exits_credit($data_insert))
			{
				$msg = array(
						'message' => 'Already exists record...!'
				);
				echo json_encode($msg);
			}else{
				$credit_id = $this->course_mod->add_credits($data_insert);
				if($credit_id){
					$credit_details = $this->course_mod->get_credits($credit_id);
					if(is_array($credit_details))
					{
						echo json_encode($credit_details);
					}else{
						  
					}
				}
			}
		}else{
			$states_list = $this->state_mod->get_all_state();
			foreach($states_list as $key => $state_val)
			{
				  $insert['course_id'] = $data_insert['course_id'];
				  $insert['course_type'] = $data_insert['course_type'];
				  $insert['credit_numbers'] = $data_insert['credit_numbers'];
				  $insert['state_id'] = $state_val['state_id'];
				  
				  if($this->course_mod->exits_credit($insert))
			      {
				  }else{
					  $credit_id = $this->course_mod->add_credits($insert);
					  $credit_details = $this->course_mod->get_credits($credit_id);
				  }  
			} 
			
			if(is_array($credit_details))
		    {
						echo json_encode($credit_details);
		    }else{
						  
			}
			
		}
	}
	
	public function edit_credits()
	{
		$data_update['course_id'] = trim($this->input->post('course_id'));
		$data_update['course_type'] = trim($this->input->post('credit_type'));
		$data_update['state_id'] = trim($this->input->post('state_id'));
		$data_update['credit_numbers'] = trim($this->input->post('credits'));
		
			if($this->course_mod->exits_credit($data_update))
			{
				$msg = array(
						'message' => 'Already exists record...!'
				);
				echo json_encode($msg);
			}else{
				$credit_id = $this->input->post('credit_id');
				$mycredit_id = $this->course_mod->update_credits($data_update,$credit_id);
				if($credit_id){
					$credit_details = $this->course_mod->get_credits($credit_id);
					if(is_array($credit_details))
					{
						echo json_encode($credit_details);
					}else{
						  
					}
				}
			}
		
	}
	
	public function delete_credits()
	{
		 $course_id = $this->input->post('course_id');
		 $credit_id = $this->input->post('credit_id');
		 echo $id = $this->course_mod->delete_credit($course_id,$credit_id);
	}
	
	public function add_pdf_material()
	{
		if($this->input->post('submit') == '')
		{
		}else if($this->input->post('submit') == 'Add')
		{
			$course_id = $this->input->post('course_id');
			$course_pdf_name = $this->input->post('course_pdf_name');
			
			 if($_FILES['course_pdf']['name'] && $course_pdf_name!='')
			 {
					$course_pdf = $_FILES['course_pdf']['name'];
					$ext = pathinfo($course_pdf, PATHINFO_EXTENSION);
				    if (preg_match('/[\'^£$%&*}{#~?><>,;!|=+¬]/', $course_pdf))
				    {
    					 /*$course_pdf = preg_replace(array('/[\'^£$%&*()}{@#~?><>,;!|=_+¬-]/'), '_',$course_pdf);*/
						 $arr_msg = array('err_msg'=> 'PDF file format not correct,Not used special character!');
					}else{
					$course_title = str_replace('/', '_', strtolower($course_pdf_name));
					$upload_filename = $course_title.'_'.$course_pdf;
					$upload_filename = str_replace(' ', '_', strtolower($upload_filename));
					$upload_filename = 'mycourse_'.strtotime(date("Y-m-d H:i:s")).'.'.$ext;//preg_replace('/\'/','',$upload_filename);
					
				    $config['upload_path'] = './uploads/pdf/';
        			$config['allowed_types'] = 'pdf|csv|xls|xlsx';
					$config['file_name']	= $upload_filename;
        			$config['max_size']    = 0;
					$this->load->library('upload', $config);
					
					if (!$this->upload->do_upload('course_pdf'))
        			{
						$file_error = 1;
						$arr_msg = array('err_msg'=> $this->upload->display_errors());
						
         			}
        			else
        			{
						$this->load->library('s3');
						
						$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									
						$targetFile = PDF_UPLOAD_PATH_S3.$upload_filename;
									
						 if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'material/'.$upload_filename, ACL_PUBLIC_READ))
						 {
							 $s3pdffile = CLOUDFRONT_URL.'material/'.$upload_filename;
										
						 }else{
							 echo "S3 Upload Fail.";
						 }
						
						
						$data_insert['course_pdf'] = $upload_filename;
						$data_insert['course_id'] = $course_id;
						$data_insert['pdf_name'] = $course_pdf_name;
						$data_insert['s3_pdf'] = $s3pdffile;
						
						$pdf_id = $this->course_mod->add_pdf($data_insert);
						if($pdf_id > 0){
							$arr_msg = array('suc_msg'=>'PDF uploaded successfully..!');
						}
        			}
				}
			 }else{
				  $file_error = 1;
				  $arr_msg = array('err_msg'=> 'Please select pdf file..!');
			 }
			   $this->session->set_userdata($arr_msg);
			  redirect('course_con/manage_material/'.$course_id);
			 
		}  
	}
	
	public function edit_pdf_material()
	{
		 	if($this->input->post('submit') == '')
		    {
			}else if($this->input->post('submit') == 'Edit')
			{
				 $course_id = $this->input->post('course_id');
				 $course_pdf_name = $this->input->post('course_pdf_name');
				 $pdf_id = $this->input->post('pdf_id');
				 $old_pdf = trim($this->input->post('old_pdf')); 
				 $file_error = 0;
				  if($_FILES['course_pdf']['name'] && $course_pdf_name!='')
				  {
						$course_pdf = $_FILES['course_pdf']['name'];
						$ext = pathinfo($course_pdf, PATHINFO_EXTENSION);
						if (preg_match('/[\'^£$%&*}{#~?><>,;!|=+¬]/', $course_pdf))
						{
    							/*$course_pdf = preg_replace(array('/[\'^£$%&*()}{@#~?><>,;!|=_+¬-]/'), '_',$course_pdf);*/
								$arr_msg = array('err_msg'=> 'PDF file format not correct,Not used special character in pdf file name..!');
								$file_error = 1;
						}else
						{
						
							$course_title = str_replace('/', '_', strtolower($course_pdf_name));
							$upload_filename = $course_title.'_'.$course_pdf;
							$upload_filename = str_replace(' ', '_', strtolower($upload_filename));
							$upload_filename = 'mycourse_'.strtotime(date("Y-m-d H:i:s")).'.'.$ext;//preg_replace('/\'/','',$upload_filename);
							
							$config['upload_path'] = './uploads/pdf/';
							$config['allowed_types'] = 'pdf|csv|xls|xlsx';
							$config['file_name']	= $upload_filename;
							$config['max_size']    = 0;
							$this->load->library('upload', $config);
							
							if (!$this->upload->do_upload('course_pdf'))
							{
								$file_error = 1;
								$arr_msg = array('err_msg'=> $this->upload->display_errors());
								
							}
							else
							{
								$this->load->library('s3');
								$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
								$targetFile = PDF_UPLOAD_PATH_S3.$upload_filename;
									
								 if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'material/'.$upload_filename, ACL_PUBLIC_READ))
								 {
									 $s3pdffile = CLOUDFRONT_URL.'material/'.$upload_filename;
												
								 }else{
									 echo "S3 Upload Fail.";
								 }
								
								$data_update['course_pdf'] = $upload_filename;
								$data_update['pdf_name'] = $course_pdf_name;
								$data_insert['s3_pdf'] = $s3pdffile;
							}
					   }
				 
				  }else{
					  $data_update['pdf_name'] = $course_pdf_name;
					  $data_update['course_pdf'] = $old_pdf;
				  }
				  
				   if($file_error == 0)
				   {
				  		$pdf_id = $this->course_mod->update_pdf($data_update,$pdf_id,$course_id);
						$arr_msg = array('suc_msg'=>'PDF uploaded successfully..!');
				   }
					$this->session->set_userdata($arr_msg);
			  		redirect('course_con/manage_material/'.$course_id);
				 
			}
	}
	
	public function edit_video_material()
	{
		 $video_name = trim($this->input->post('course_video_name'));
		 $video_url = trim($this->input->post('video_url'));
		 $course_id = $this->input->post('course_id');
		 $video_id = $this->input->post('video_id');
		 
		 if($this->input->post('submit') == '')
		 {
		 }else if($this->input->post('submit') == 'Edit')
		 {
			  if($video_name != '' && $video_url !='')
			  {
				  $upadate['video_name'] = $video_name;
				  $upadate['video_url'] = $video_url;
				  $video_id = $this->course_mod->update_course_video($upadate,$video_id,$course_id);
				  if($video_id > 0){
							$arr_msg = array('suc_msg'=>'Video updated successfully..!');
			      }else{
					  		$arr_msg = array('err_msg'=>'Failed to edit.Try again..!');	
				  }
				  
			  }else{
				   	$arr_msg = array('err_msg'=>'Please enter values in related fields.Try again..!');	
			  }
			   $this->session->set_userdata($arr_msg);
		 	   redirect('course_con/manage_material/'.$course_id);
		 }
	}
	
	public function add_video_material()
	{
		 $video_name = trim($this->input->post('course_video_name'));
		 $video_url = trim($this->input->post('video_url'));
		 $course_id = $this->input->post('course_id');
		 
		 if($video_name !='' && $video_url !='')
		 {
			   $data_insert['course_id'] = $course_id;
			   $data_insert['video_name'] = $video_name;
			   $data_insert['video_url'] = $video_url;
			   
			   $video_id = $this->course_mod->add_course_video($data_insert);
			   if($video_id > 0){
							$arr_msg = array('suc_msg'=>'Video added successfully..!');
			   }
		 }else{
			 $arr_msg = array('err_msg'=>'Failed to save.Try again..!');	
		 }
		 $this->session->set_userdata($arr_msg);
		 redirect('course_con/manage_material/'.$course_id);
		 
	}
	
	public function get_course_pdf()
	{
		 $course_id = $this->input->post('course_id');
		 $pdf_id = $this->input->post('pdf_id');
		 $pdf_details = $this->course_mod->get_pdf_details($course_id,$pdf_id);	
		 echo json_encode($pdf_details); exit;
	}
	
	public function get_course_video()
	{
		 $course_id = $this->input->post('course_id');
		 $video_id = $this->input->post('video_id');
		 $video_details = $this->course_mod->get_video_details($course_id,$video_id);
		 echo json_encode($video_details); exit;
	}
	
	public function delete_video()
	{
		 $course_id = $this->input->post('course_id');
		 $video_id = $this->input->post('video_id');
		 echo $deleted = $this->course_mod->delete_video($course_id,$video_id);
		 
	}
	
	public function delete_pdf()
	{
		 $course_id = $this->input->post('course_id');
		 $pdf_id = $this->input->post('pdf_id');
		 echo $deleted = $this->course_mod->delete_pdf($course_id,$pdf_id);
	}
	
	public function add_course()
	{
		$data['menutitle'] = 'Courses';
		$data['pagetitle'] = 'Add Course';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li>Add Courses</li></ul>';
		$data['faculty_details'] = $this->course_mod->get_faculty();
		$data['course_requirments'] = $this->course_mod->get_course_requirments();
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '1000px';
		$this->ckeditor->config['height'] = '300px';
		
		if($this->input->post('submit') == '')
		{
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('course/add_course',$data);
						
			}
		}elseif($this->input->post('submit') == 'Add Course')
		{
			$this->load->library('s3');
			//echo "<pre>";print_r($this->input->post());die;
			$course_title = trim($this->input->post('course_name'));
			
			$this->form_validation->set_rules('course_name', 'Course Name', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('field_study', 'Study of field', 'trim|required');
			$this->form_validation->set_rules('course_description', 'Course Description', 'trim|required');
			$this->form_validation->set_rules('instructional_delivery_method', 'Instructional Delivery Method', 'trim|required');
			$this->form_validation->set_rules('prerequisites', 'Prerequisites', 'trim|required');
			$this->form_validation->set_rules('knowledge_level', 'Knowledge Level', 'trim|required');
			$this->form_validation->set_rules('cpe_credits', 'CPE Credits', 'trim|required|numeric|numeric');
			$this->form_validation->set_rules('course_faculty[]', 'Course Authors', 'trim|required');
			$this->form_validation->set_rules('course_period', 'Course Period', 'trim|required');
			$this->form_validation->set_rules('passing_grade', 'Passing Grade', 'trim|required|numeric');
			$this->form_validation->set_rules('course_price', 'Course Price', 'trim|required|numeric');
			$this->form_validation->set_rules('discount_price', 'Discounted Price must be less then course price', 'trim|numeric|callback_validate_price');
			$this->form_validation->set_rules('course_format', 'Course Price', 'trim|required');
			
			// Upload image
			 $file_error = 0;
			 $imagefile_error = '';
			 if($_FILES['course_image']['name'])
			 {
				 $course_image = $_FILES['course_image']['name'];
				 if(strlen(trim($course_image)) > 0) 
				 {
					  $upload_filename_image = $this->clean_filename($course_title).'_'.$course_image;
					  $upload_filename_image = str_replace(' ', '_', strtolower($upload_filename_image));
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png');
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['course_image']['tmp_name'], IMAGE_UPLOAD_PATH.$upload_filename_image)) 
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
			 
			 // Upload intro PDF
			 $file_error = 0;
			 $imagefile_error = '';
			 if($_FILES['introPDF']['name'] != '')
			 {
				 $introPDF = $_FILES['introPDF']['name'];
				 if(strlen(trim($introPDF)) > 0) 
				 {
					  $upload_introPDF = $this->clean_filename($course_title).'_'.$introPDF;
					  $upload_filename_PDF = str_replace(' ', '_', strtolower($upload_introPDF));
					  $PDF_fileExtension = $this->course_mod->get_file_extension($upload_filename_PDF);
					  $allowed_type = array('pdf');
					  if (!in_array($PDF_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload PDF file for course introduction';
					  }else{
								if (copy($_FILES['introPDF']['tmp_name'], IMAGE_UPLOAD_PATH.$upload_filename_PDF)) 
								{
									$data['introPDF'] = $upload_filename_PDF;
									
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									
									$targetFile = IMAGE_UPLOAD_PATH_S3.$upload_filename_PDF;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'material/intropdf/'.$upload_filename_PDF, ACL_PUBLIC_READ))
									{
										$s3introfile = CLOUDFRONT_URL.'material/intropdf/'.$upload_filename_PDF;
										
									}else{
										echo "S3 Upload Fail.";
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
				$this->template->set_layout('admin_default')->build('course/add_course',$data);
			}else{
				
				 $data_insert['course_name'] = trim($this->input->post('course_name'));
				 $data_insert['field_of_study'] = trim($this->input->post('field_study'));
				 $data_insert['course_description'] = trim($this->input->post('course_description'));
				 $data_insert['instructional_delivery_method'] = trim($this->input->post('instructional_delivery_method'));
				 $data_insert['prerequisites'] = trim($this->input->post('prerequisites'));
				 $data_insert['knowledge_level'] = trim($this->input->post('knowledge_level'));
				 $data_insert['cpe_credits'] = trim($this->input->post('cpe_credits'));
				 $data_insert['passing_grade'] = trim($this->input->post('passing_grade'));
				 $data_insert['advance_preparation'] = trim($this->input->post('advance_preparation'));
				 $data_insert['course_author'] = implode(',',$this->input->post('course_faculty'));
				 $data_insert['course_period'] = trim($this->input->post('course_period'));
				 $data_insert['course_price'] = trim($this->input->post('course_price'));
				 $data_insert['course_date'] = date("Y-m-d",strtotime($this->input->post('course_date')));
				 $data_insert['course_status'] = trim($this->input->post('course_status'));
				 $data_insert['course_image'] = trim($data['image_file']);
				 $data_insert['back_color'] = trim($this->input->post('back_color'));
				 $data_insert['discount_price'] = trim($this->input->post('discount_price'));
				 $data_insert['course_format'] = trim($this->input->post('course_format'));
				 if(count($this->input->post('requirments')) > 0)
				 	$data_insert['course_req'] = implode(',',$this->input->post('requirments'));
				 $data_insert['introPDF'] = trim($data['introPDF']);
				 $data_insert['intro_video'] = trim($this->input->post('intro_video'));
				 $data_insert['s3_images'] = trim($s3file);
				 $data_insert['s3_intropdf'] = trim($s3introfile);
				 
				 $course_id = $this->course_mod->add_course($data_insert);
				 if($course_id > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con');
				 
			}
		}
	}
	public function validate_price($str)
	{
		  if($str < $this->input->post('course_price')){
			  return TRUE;
		  }else{
			  $this->form_validation->set_message('validate_price', 'Discounted Price must be less then course price.');
			  return FALSE;
		  }
	}
	public function edit_course($course_id = 0)
	{
		$data['menutitle'] = 'Courses';
		$data['pagetitle'] = 'Edit Course';
		$data['faculty_details'] = $this->course_mod->get_faculty();
		$data['course_requirments'] = $this->course_mod->get_course_requirments();
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li>Edit Courses</li></ul>';
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '1000px';
		$this->ckeditor->config['height'] = '500px';
		
		
		
		if($this->input->post('course_id') && $course_id == 0)
		{
			$course_id = $this->input->post('course_id');
	    }
		
		if($this->input->post('submit') == '')
		{
			$data['course_details'] = $this->course_mod->get_course_details($course_id);
			$this->template->set_layout('admin_default')->build('course/edit_course',$data);
		}elseif(trim($this->input->post('submit')) == "Edit Course")
		{
			  $this->load->library('s3');
			  $this->coursePrice = trim($this->input->post('course_price'));
			  $course_title = trim($this->input->post('course_name'));
			  $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required|min_length[5]');
			   $this->form_validation->set_rules('field_study', 'Field Of Study', 'trim|required');
			   
			  $this->form_validation->set_rules('course_description', 'Course Description', 'trim|required');
			  $this->form_validation->set_rules('instructional_delivery_method', 'Instructional Delivery Method', 'trim|required');
			  $this->form_validation->set_rules('prerequisites', 'Prerequisites', 'trim|required');
			  $this->form_validation->set_rules('knowledge_level', 'Knowledge Level', 'trim|required');
			  $this->form_validation->set_rules('cpe_credits', 'CPE Credits', 'trim|required|numeric');
			  $this->form_validation->set_rules('course_faculty[]', 'Course Authors', 'trim|required');
			  $this->form_validation->set_rules('course_period', 'Course Period', 'trim|required');
			  $this->form_validation->set_rules('course_price', 'Course Price', 'trim|required');
			  $this->form_validation->set_rules('passing_grade', 'Passing Grade', 'trim|required|numeric');
			  $this->form_validation->set_rules('discount_price', 'Discounted Price must be less then course price', 'trim|numeric|callback_validate_price');
			  // Upload image
			 $file_error = 0;
			 $imagefile_error = '';
			 $upload_filename_image = '';
			 if($_FILES['course_image']['name'])
			 {
				 $course_image = $_FILES['course_image']['name'];
				 if(strlen(trim($course_image)) > 0) 
				 {
					  $upload_filename_image = $this->clean_filename($course_title).'_'.$course_image;
					  $upload_filename_image = $upload_filename_image;
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png');
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['course_image']['tmp_name'], IMAGE_UPLOAD_PATH.$upload_filename_image)) 
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
			 
			 // Upload intro PDF
			 $file_error = 0;
			 $imagefile_error = '';
			 if($_FILES['introPDF']['name'] != '')
			 {
				 $introPDF = $_FILES['introPDF']['name'];
				 if(strlen(trim($introPDF)) > 0) 
				 {
					  $upload_introPDF = $this->clean_filename($course_title).'_'.$introPDF;
					  $upload_filename_PDF = str_replace(' ', '_', strtolower($upload_introPDF));
					  $PDF_fileExtension = $this->course_mod->get_file_extension($upload_filename_PDF);
					  $allowed_type = array('pdf');
					  if (!in_array($PDF_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload PDF file for course introduction';
					  }else{
								if (copy($_FILES['introPDF']['tmp_name'], IMAGE_UPLOAD_PATH.$upload_filename_PDF)) 
								{
									$data['introPDF'] = $upload_filename_PDF;
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									
									$targetFile = IMAGE_UPLOAD_PATH_S3.$upload_filename_PDF;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'material/intropdf/'.$upload_filename_PDF, ACL_PUBLIC_READ))
									{
										$s3introfile = CLOUDFRONT_URL.'material/intropdf/'.$upload_filename_PDF;
										$data_update['s3_intropdf'] = trim($s3introfile);
										
									}else{
										echo "S3 Upload Fail.";
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
				$arr_course_details['course_id'] = $course_id;
				$arr_course_details['course_name'] = trim($this->input->post('course_name'));
				$arr_course_details['field_of_study'] = trim($this->input->post('field_study'));
				$arr_course_details['course_description'] = trim($this->input->post('course_description'));
				$arr_course_details['instructional_delivery_method'] = trim($this->input->post('instructional_delivery_method'));
				$arr_course_details['prerequisites'] = trim($this->input->post('prerequisites'));
				$arr_course_details['knowledge_level'] = trim($this->input->post('knowledge_level'));
				$arr_course_details['cpe_credits'] = trim($this->input->post('cpe_credits'));
				$arr_course_details['passing_grade'] = trim($this->input->post('passing_grade'));
				$arr_course_details['advance_preparation'] = trim($this->input->post('advance_preparation'));
				$arr_course_details['course_author'] =  implode(',',$this->input->post('course_faculty'));
				$arr_course_details['course_period'] = trim($this->input->post('course_period'));
				$arr_course_details['course_price'] = trim($this->input->post('course_price'));
				$arr_course_details['discount_price'] = trim($this->input->post('discount_price'));
				$arr_course_details['course_date'] = date("Y-m-d",strtotime($this->input->post('course_date')));
				$arr_course_details['course_status'] = trim($this->input->post('course_status'));
				$arr_course_details['course_image'] = trim($this->input->post('old_image'));
				$arr_course_details['back_color'] = trim($this->input->post('back_color'));				
				$arr_course_details['introPDF'] = trim($this->input->post('introPDF'));
				$arr_course_details['intro_video'] = trim($this->input->post('intro_video'));				
				$arr_course_details['course_req'] = implode(',',$this->input->post('requirments'));
				$data['course_details'][0] = $arr_course_details;
				
				$this->template->set_layout('admin_default')->build('course/edit_course',$data);
			}else{
				 $course_id = $this->input->post('course_id');
				 $data_update['course_name'] = trim($this->input->post('course_name'));
				 $data_update['field_of_study'] = trim($this->input->post('field_study'));
				 $data_update['course_description'] = trim($this->input->post('course_description'));
				 $data_update['instructional_delivery_method'] = trim($this->input->post('instructional_delivery_method'));
				 $data_update['prerequisites'] = trim($this->input->post('prerequisites'));
				 $data_update['knowledge_level'] = trim($this->input->post('knowledge_level'));
				 $data_update['cpe_credits'] = trim($this->input->post('cpe_credits'));
				 $data_update['passing_grade'] = trim($this->input->post('passing_grade'));
				 $data_update['advance_preparation'] = trim($this->input->post('advance_preparation'));
				 $data_update['course_author'] = implode(',',$this->input->post('course_faculty'));
				 $data_update['course_period'] = trim($this->input->post('course_period'));
				 $data_update['course_price'] = trim($this->input->post('course_price'));
				 $data_update['discount_price'] = trim($this->input->post('discount_price'));				 
				 $data_update['course_date'] = date("Y-m-d",strtotime($this->input->post('course_date'))); 
				 $data_update['course_status'] = trim($this->input->post('course_status'));
				 $data_update['back_color'] = trim($this->input->post('back_color'));
				 $data_update['course_format'] = trim($this->input->post('course_format'));
				 if(count($this->input->post('requirments')) > 0)
				 	$data_update['course_req'] = implode(',',$this->input->post('requirments'));
				 //$data_update['introPDF'] = trim($this->input->post('introPDF'));
				 $data_update['intro_video'] = trim($this->input->post('intro_video'));
				 
				 if(isset($upload_filename_image) && $upload_filename_image!='')
				 {
				 	$data_update['course_image'] = trim($upload_filename_image);
				 }else{
					$data_update['course_image'] = trim($this->input->post('old_image')); 
				 }
				 
				  if(isset($upload_filename_PDF) && $upload_filename_PDF!='')
				 {
				 	$data_update['introPDF'] = trim($upload_filename_PDF);
				 }
				 
				 
				 $course_id = $this->course_mod->update_course($data_update,$course_id);
				 if($course_id > 0)
				 {
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con');
			} 
			   
		}
	}
	
	 public function clean_filename($string){
		$string = trim($string);
		$string = strtolower($string);
		$string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.

		return preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
	}
	
	public function delete_course()
	{
		$course_id = $this->input->post('course_id');
		echo $deleted = $this->course_mod->delete_course($course_id);
	}
	
	//shilesh code
	//My code	
	public function manage_course_quest($courseid)
	{
		if($this->session->userdata('userid') != "")
		{  
		    if($this->session->userdata('suc_msg') != '')
		   {
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
		   }
				$data['course_questions'] = $this->course_mod->get_all_course_quest($courseid);
			  //echo "<pre>";print_r($data['course_questions']);die;
			  $data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li>Manage Course Exam Question</li></ul>';
			  
			$data['menutitle'] = 'Course Exam Question';
			$data['pagetitle'] = 'Manage Course Exam Question';
			
			$data['courseid'] = $courseid;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('course/course_ques_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_course_question($id=0)
	{
		$data['menutitle'] = 'Question';
		$data['pagetitle'] = 'Add Question';
		//$data['faculty_details'] = $this->course_mod->get_faculty();
		
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'course_con/manage_course_quest/'.$id.'"> Manage Course Exam Question</a><i class="fa fa-angle-right"></i></li><li>Add Question</li></ul>';
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','-','FontSize','-','JustifyLeft', 'JustifyCenter', 'JustifyRight')
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		if($this->input->post('submit') == '' && $id!='')
		{
			$data['courseid'] = $id;
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('course/add_question',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add Question')
		{
		 // echo "<pre>";print_r($this->input->post());die;
		   $this->form_validation->set_rules('qtitle', 'Question Title', 'trim|required');
		   $this->form_validation->set_rules('qanswer1', 'Answer1', 'trim|required');
		   $this->form_validation->set_rules('qanswer2', 'Answer2', 'trim|required');
		   $this->form_validation->set_rules('qanswer3', 'Answer3', 'trim|required');
		   /*$this->form_validation->set_rules('qanswer4', 'Answer4', 'trim|required');
		   $this->form_validation->set_rules('qanswer5', 'Answer5', 'trim|required');*/
			
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
						  $data['err_msg'] = 'Question image name format not correct,Not used special character!';
					  }else{
					  
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png','bmp');
					 
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['fimage']['tmp_name'], IMAGE_QUESTION_UPLOAD_PATH.$upload_filename_image)) 
								{
									$data['image_file'] = $upload_filename_image;
									
									$this->load->library('s3');
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									$targetFile = QUE_IMAGE_UPLOAD_PATH_S3.$upload_filename_image;
									
									 if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'questions/'.$upload_filename_image, ACL_PUBLIC_READ))
									 {
										 $s3Questionfile = CLOUDFRONT_URL.'questions/'.$upload_filename_image;
													
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
				$this->template->set_layout('admin_default')->build('course/add_question',$data);
			}elseif($file_error == 1){
				$this->template->set_layout('admin_default')->build('course/add_question',$data);
				}
			else{
				//echo "true";die;
				$courseid= trim($this->input->post('course_id'));
				$data_insert['course_id'] 		= trim($this->input->post('course_id'));
				$data_insert['ques_title'] 		= trim($this->input->post('qtitle'));
				$data_insert['ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$data_insert['ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$data_insert['ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$data_insert['ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$data_insert['ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$data_insert['correct_ans_id'] 	= trim($this->input->post('correct_ans'));
			    $data_insert['question_image'] = trim($data['image_file']);
				$data_insert['s3_images'] = trim($s3Questionfile);
				
			   $question_id = $this->course_mod->add_course_question($data_insert);
				 if($question_id > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con/manage_course_quest/'.$courseid);

			}
		  	
		}
		
	}
	
	public function edit_question($id=0,$cid=0)
	{
		$data['menutitle'] = 'Question';
		$data['pagetitle'] = 'Edit Question';
		
		
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'course_con/manage_course_quest/'.$cid.'"> Manage Course Exam Question</a><i class="fa fa-angle-right"></i></li><li>Edit Question</li></ul>';
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','-','FontSize','-','JustifyLeft', 'JustifyCenter', 'JustifyRight')
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		
		if($this->input->post('question_id') && $id == 0)
		{
			
			$id = $this->input->post('question_id');
	    }
		
		$arr_id = array('ques_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['ques_id'] = $id;
		$data['question_details'] = $this->course_mod->get_question($id);
		//echo "<pre>";print_r($data['question_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('course/edit_question',$data);
		}
		else
		{   //echo "hewe";die;
		  /* echo ">>". $id = trim($this->input->post('cust_id'));die;
			$arr_id = array('cust_id'=>$id);
			$this->session->set_userdata($arr_id);	*/
			
		   $this->form_validation->set_rules('qtitle', 'Question Title', 'trim|required');
		   $this->form_validation->set_rules('qanswer1', 'Answer1', 'trim|required');
		   $this->form_validation->set_rules('qanswer2', 'Answer2', 'trim|required');
		   $this->form_validation->set_rules('qanswer3', 'Answer3', 'trim|required');
		   /*$this->form_validation->set_rules('qanswer4', 'Answer4', 'trim|required');
		   $this->form_validation->set_rules('qanswer5', 'Answer5', 'trim|required');*/
           
		   
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
						  $data['err_msg'] = 'Question image name format not correct,Not used special character!';
					  }else{
					  
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png');
					  if (!in_array($image_fileExtension,$allowed_type)) 
					  {
								$file_error = 1;
								$imagefile_error = 'Please upload gif|jpg|png file for course image';
					  }else{
								if (copy($_FILES['fimage']['tmp_name'], IMAGE_QUESTION_UPLOAD_PATH.$upload_filename_image)) 
								{
									$data['image_file'] = $upload_filename_image;
									
									$this->load->library('s3');
									$this->s3->putBucket(AWS_BUCKET_NAME, ACL_PUBLIC_READ);
									$targetFile = QUE_IMAGE_UPLOAD_PATH_S3.$upload_filename_image;
									
									if($this->s3->putObjectFile($targetFile, AWS_BUCKET_NAME , 'questions/'.$upload_filename_image, ACL_PUBLIC_READ))
									{
										 $s3Questionfile = CLOUDFRONT_URL.'questions/'.$upload_filename_image;
										 $data_update['s3_images'] = trim($s3Questionfile);
													
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
				$data['ques_id'] = trim($this->input->post('qid'));
				$question_details['course_id'] 			= trim($this->input->post('course_id'));
				$question_details['ques_title'] 		= trim($this->input->post('qtitle'));
				$question_details['ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$question_details['ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$question_details['ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$question_details['ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$question_details['ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$question_details['correct_ans_id'] 	= trim($this->input->post('correct_ans'));
				$question_details['question_image'] 	= trim($this->input->post('old_image'));
				$data['question_details'][0] = $question_details;
				$this->template->set_layout('admin_default')->build('course/edit_question',$data);
				
			}elseif($file_error == 1){
				
				$data['ques_id'] = trim($this->input->post('qid'));
				$question_details['course_id'] 			= trim($this->input->post('course_id'));
				$question_details['ques_title'] 		= trim($this->input->post('qtitle'));
				$question_details['ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$question_details['ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$question_details['ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$question_details['ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$question_details['ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$question_details['correct_ans_id'] 	= trim($this->input->post('correct_ans'));
				$question_details['question_image'] 	= trim($this->input->post('old_image'));
				$data['question_details'][0] = $question_details;
				$this->template->set_layout('admin_default')->build('course/edit_question',$data);
				
				}
			else{
				$id = trim($this->input->post('qid'));
				$courseid=trim($this->input->post('course_id'));
				$data_update['ques_title'] 		= trim($this->input->post('qtitle'));
				$data_update['ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$data_update['ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$data_update['ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$data_update['ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$data_update['ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$data_update['correct_ans_id'] 	= trim($this->input->post('correct_ans'));
			   
			   	 if(isset($upload_filename_image) && $upload_filename_image!='')
				 {
				 	$data_update['question_image'] = trim($upload_filename_image);
				 }else{
					$data_update['question_image'] = trim($this->input->post('old_image')); 
				 }
				 
			     $questionid = $this->course_mod->update_question($data_update,$id);
				 if($questionid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con/manage_course_quest/'.$courseid);

			}
			
		}
	}
	
	public function delete_questions()
	{
		 $course_id = $this->input->post('course_id');
		 $ques_id = $this->input->post('ques_id');
		 
		 $result = $this->course_mod->delete_single_question($course_id,$ques_id);
		 
		 if($result > 0){
			 $arr_msg = array('suc_msg'=>'Record deleted successfully!!!');
			}else{
			 $arr_msg = array('err_msg'=>'Failed to delete record');
			}
		 $this->session->set_userdata($arr_msg);
		echo $result;
	}
	public function get_question_details($qid)
     {
		  //echo 'here';die; 
	   $data['question_details'] = $this->course_mod->get_question($qid);
			  //echo "<pre>";print_r($data['course_questions']);die;
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Manage Course Exam Question';
	   if($data != false)
		{
			$this->load->view('course/ques_popup',$data);
					
		}
		  
     }	
// Course Chapter section	 
	
	public function manage_course_chapter($courseid)
	{
		
		if($this->session->userdata('userid') != "")
		{  
		    if($this->session->userdata('suc_msg') != '')
		   {
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
		   }
			$data['course_chapter'] = $this->course_mod->get_all_course_chapter($courseid);
			 //echo "<pre>";print_r($data['course_chapter']);die;
			$data['menutitle'] = '';
			$data['pagetitle'] = 'Manage Course Chapter';
			//$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Course Chapter</li></ul>';
			
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li>Manage Course Chapter</li></ul>';
			$data['courseid'] = $courseid;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('course/manage_course_chapter',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function add_course_chapter($id=0)
	{
		$data['menutitle'] = 'Chapter';
		$data['pagetitle'] = 'Add Chapter';
		//$data['faculty_details'] = $this->course_mod->get_faculty();
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con">Manage Courses</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'course_con/manage_course_chapter/'.$id.'">Manage Course Chapter</a><i class="fa fa-angle-right"></i></li><li>Add Course Chapter</li></ul>';
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		
		
		if($this->input->post('submit') == '' && $id!='')
		{
			$data['courseid'] = $id;
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('course/add_chapter',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add Chapter')
		{
		  //echo "<pre>";print_r($this->input->post());die;
		   $data['courseid'] =  trim($this->input->post('course_id'));
		   $this->form_validation->set_rules('chptname', 'Chapter Name', 'trim|required');
		   $this->form_validation->set_rules('chptdesc', 'Chapter Description', 'trim|required');
		  
		   $file_error=0;
		  
		 	if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('course/add_chapter',$data);
			}
			else{
				//echo "true";die;
				$courseid= trim($this->input->post('course_id'));
				$data_insert['course_id'] 			= trim($this->input->post('course_id'));
				$data_insert['chapter_name'] 		= trim($this->input->post('chptname'));
				$data_insert['chapter_desc'] 		= trim($this->input->post('chptdesc'));
				$data_insert['status'] 				= 'Active';
				$data_insert['back_color'] = trim($this->input->post('back_color'));
				
			   $chapter_id = $this->course_mod->add_course_chapter($data_insert);
				 if($chapter_id > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con/manage_course_chapter/'.$courseid);

			}
		  	
		}
		
	}
	
	public function edit_chapter($id=0,$cid=0)
	{
		$data['menutitle'] = 'Chapter';
		$data['pagetitle'] = 'Edit Chapter';
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con/manage_course_chapter/'.$cid.'">Manage Course Chapter</a><i class="fa fa-angle-right"></i></li><li>Edit Course Chapter</li></ul>';
		$arr_id = array('ques_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['chapter_id'] = $id;
		$data['chapter_details'] = $this->course_mod->get_chapter($id);
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('course/edit_chapter',$data);
		}
		else
		{  
		    //echo "<pre>";print_r($this->input->post());die;
		    $this->form_validation->set_rules('chptname', 'Chapter Name', 'trim|required');
		    $this->form_validation->set_rules('chptdesc', 'Chapter Description', 'trim|required');
			 $this->form_validation->set_rules('status', 'Status', 'trim|required');
           
		   	if ($this->form_validation->run() == FALSE)
			{
				$data['courseid'] =  trim($this->input->post('course_id'));
				$chapter_details['course_id'] 			    = trim($this->input->post('course_id'));
				$chapter_details['chapter_name'] 		    = trim($this->input->post('chptname'));
				$chapter_details['chapter_desc'] 		    = trim($this->input->post('chptdesc'));
				$chapter_details['status'] 		    = trim($this->input->post('status'));
				$chapter_details['back_color'] = trim($this->input->post('back_color'));
				$data['chapter_details'][0] = $chapter_details;
				$this->template->set_layout('admin_default')->build('course/edit_chapter',$data);
				
			}
			else{  
				$id = trim($this->input->post('cptid'));
				$courseid=trim($this->input->post('course_id'));
				$data_update['chapter_name'] 		= trim($this->input->post('chptname'));
				$data_update['chapter_desc'] 		= trim($this->input->post('chptdesc'));
				$data_update['status'] 		    = trim($this->input->post('status'));
				$data_update['back_color'] = trim($this->input->post('back_color'));
				
			    $chapterid = $this->course_mod->update_chapter($data_update,$id);
				 if($chapterid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con/manage_course_chapter/'.$courseid);

			}
			
		}
	}
	
	public function get_chapter_details($qid)
     {
		  //echo 'here';die; 
	   $data['chapter_details'] = $this->course_mod->get_chapter($qid);
			  //echo "<pre>";print_r($data['course_questions']);die;
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Manage Course Chapter';
	   if($data != false)
		{
			$this->load->view('course/chapter_popup',$data);
					
		}
		  
     }
	 
	 	
	public function delete_chapter($id)
	{
		 $result=$this->course_mod->delete_single_chapter($id);
		 if($result > 0){
			 $arr_msg = array('suc_msg'=>'Record deleted successfully!!!');
			}else{
			 $arr_msg = array('err_msg'=>'Failed to delete record');
			}
		 $this->session->set_userdata($arr_msg);
		 return true;
		// redirect('course_con/manage_course_quest/'.$courseid);
	}
	
	//End Course chapter sections
	
//Start Chapter Questions section 
public function manage_chapter_question($chapterid,$courseid)
	{
		if($this->session->userdata('userid') != "")
		{  
		    if($this->session->userdata('suc_msg') != '')
		   {
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
		   }
			$data['chapter_questions'] = $this->course_mod->get_chapter_quest($chapterid);
			  //echo ">>". "<pre>";print_r($data['chapter_questions']);die;
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con/manage_course_chapter/'.$courseid.'">Manage Course Chapter</a><i class="fa fa-angle-right"></i></li><li>Manage Course Chapter Question</li></ul>';
			
			$data['courseid'] = $courseid;
			$data['menutitle'] = '';
			$data['pagetitle'] = 'Manage Chapter Review Question';
			$data['chapterid'] = $chapterid;
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('course/manage_chapter_questions',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}	
	
	public function add_chapter_question($id=0,$courseid=0)
	{
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con/manage_course_chapter/'.$courseid.'">Manage Course Chapter</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'course_con/manage_chapter_question/'.$id.'/'.$courseid.'">Manage Course Chapter Question</a><i class="fa fa-angle-right"></i></li><li>Add Chapter Review Question</li></ul>';
		$data['menutitle'] = 'Question';
		$data['pagetitle'] = 'Add Chapter Review Question';
		//$data['faculty_details'] = $this->course_mod->get_faculty();
		
		$this->ckeditor->basePath = $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList' )
					);
      
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';  
		
		if($this->input->post('submit') == '' && $id!='')
		{
			$data['chapterid'] = $id;
			$data['courseid'] = $courseid;
			if($data != false)
			{
					$this->template
						 ->set_layout('admin_default')
						 ->build('course/add_chapter_question',$data);
						
			}
		}
		elseif($this->input->post('submit') == 'Add Chapter Review Question')
		{
		 //echo "<pre>";print_r($this->input->post());die;
		   $data['chapterid'] = trim($this->input->post('chapterid'));
		   $data['courseid'] = trim($this->input->post('courseid'));
		   $this->form_validation->set_rules('qtitle', 'Question Title', 'trim|required');
		   $this->form_validation->set_rules('qanswer1', 'Answer1', 'trim|required');
		   $this->form_validation->set_rules('qanswer2', 'Answer2', 'trim|required');
		   $this->form_validation->set_rules('qanswer1text','Answer1 Text', 'trim|required');
		   $this->form_validation->set_rules('qanswer2text','Answer2 Text', 'trim|required');
		    $this->form_validation->set_rules('qanswer3text','Answer3 Text', 'trim|required');
			
		   $this->form_validation->set_rules('qanswer3', 'Answer3', 'trim|required');
	/*	   $this->form_validation->set_rules('qanswer4', 'Answer4', 'trim|required');
		   $this->form_validation->set_rules('qanswer5', 'Answer5', 'trim|required');*/
			
		   $file_error=0;
		  
		 	if ($this->form_validation->run() == FALSE)
			{
				$this->template->set_layout('admin_default')->build('course/add_chapter_question',$data);
			}
			else{
				//echo "true";die;

			   $chapterid= trim($this->input->post('chapterid'));
				$courseid=$this->course_mod->get_courseid($chapterid);
				$cid=$courseid[0]['course_id'];
				$count_courseid = count($courseid);
				if($count_courseid > 0)
				{ 
				  $data_insert['course_id'] =	$courseid[0]['course_id'];
				}
     			$data_insert['chapter_id'] 			= trim($this->input->post('chapterid'));
				
				$data_insert['rev_ques_title'] 		= trim($this->input->post('qtitle'));
				$data_insert['rev_ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$data_insert['rev_ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$data_insert['rev_ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$data_insert['rev_ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$data_insert['rev_ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$data_insert['rev_correct_ans_id'] 	= trim($this->input->post('correct_ans'));
				$data_insert['ans1_text'] 	= trim($this->input->post('qanswer1text'));
				$data_insert['ans2_text'] 	= trim($this->input->post('qanswer2text'));
				$data_insert['ans3_text'] 	= trim($this->input->post('qanswer3text'));
				$data_insert['ans4_text'] 	= trim($this->input->post('qanswer4text'));
				$data_insert['ans5_text'] 	= trim($this->input->post('qanswer5text'));
				
				//$data_insert['rev_correct_ans_text'] 		= trim($this->input->post('correctAnswer'));
				//$data_insert['rev_wronge_ans_text'] 		= trim($this->input->post('wrongAnswer'));
				
			    
			    $question_id = $this->course_mod->add_chapter_question($data_insert);
				 if($question_id > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to add record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 redirect('course_con/manage_chapter_question/'.$chapterid.'/'.$cid);

			}
		  	
		}
		
	}
	
	public function edit_review_question($id=0,$chpterid=0,$courseid=0)
	{
		$data['menutitle'] = 'Question';
		$data['pagetitle'] = 'Edit Review Question ';
		
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'course_con/manage_course_chapter/'.$courseid.'">Manage Course Chapter</a><i class="fa fa-angle-right"></i></li><li><a href="'.base_url().'course_con/manage_chapter_question/'.$chpterid.'/'.$courseid.'">Manage Course Chapter Question</a><i class="fa fa-angle-right"></i></li><li>Edit Review Question</li></ul>';
		
		$this->ckeditor->basePath =  $this->config->item("base_url_asset").'assets/ckeditor/';
		$this->ckeditor->config['toolbar'] = array(
						array( 'Image', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList','-','FontSize','-','JustifyLeft', 'JustifyCenter', 'JustifyRight')
					);
		$this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '500px';
		$this->ckeditor->config['height'] = '250px';
		if($this->input->post('question_id') && $id == 0)
		{
			
			$id = $this->input->post('question_id');
	    }
		
		$arr_id = array('rev_ques_id'=>$id);
		$this->session->set_userdata($arr_id);
		$data['rev_ques_id'] = $id;
		$data['courseid'] = $courseid;
		$data['question_details'] = $this->course_mod->get_chapter_question($id);
		//echo "<pre>";print_r($data['question_details']);die;
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('course/edit_chapter_question',$data);
		}
		else
		{   //echo "hewe";die;
		  /* echo ">>". $id = trim($this->input->post('cust_id'));die;
			$arr_id = array('cust_id'=>$id);
			$this->session->set_userdata($arr_id);	*/
			
		   $this->form_validation->set_rules('qtitle', 'Question Title', 'trim|required');
		   $this->form_validation->set_rules('qanswer1', 'Answer1', 'trim|required');
		   $this->form_validation->set_rules('qanswer2', 'Answer2', 'trim|required');
		   $this->form_validation->set_rules('qanswer1text','Answer1 Text', 'trim|required');
		   $this->form_validation->set_rules('qanswer2text','Answer2 Text', 'trim|required');
		   //$this->form_validation->set_rules('qanswer3text','Answer3 Text', 'trim|required');
		   //$this->form_validation->set_rules('qanswer3', 'Answer3', 'trim|required');
		   //$this->form_validation->set_rules('qanswer4', 'Answer4', 'trim|required');
		  // $this->form_validation->set_rules('qanswer5', 'Answer5', 'trim|required');
           
		   	if ($this->form_validation->run() == FALSE)
			{
				$data['rev_ques_id'] = trim($this->input->post('rqid'));
				$data['courseid'] = trim($this->input->post('courseid'));
				$question_details['chapter_id'] 		= trim($this->input->post('chapter_id'));
				$question_details['rev_ques_title'] 		= trim($this->input->post('qtitle'));
				$question_details['rev_ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$question_details['rev_ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$question_details['rev_ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$question_details['rev_ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$question_details['rev_ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$question_details['rev_correct_ans_text'] 		= trim($this->input->post('correctAnswer'));
				
				$question_details['ans1_text'] 	= trim($this->input->post('qanswer1text'));
				$question_details['ans2_text'] 	= trim($this->input->post('qanswer2text'));
				$question_details['ans3_text'] 	= trim($this->input->post('qanswer3text'));
				$question_details['ans4_text'] 	= trim($this->input->post('qanswer4text'));
				$question_details['ans5_text'] 	= trim($this->input->post('qanswer5text'));
				//$question_details['rev_wronge_ans_text'] 		= trim($this->input->post('wrongAnswer'));
				//$question_details['rev_correct_ans_id'] 	= trim($this->input->post('correct_ans'));
				
				$data['question_details'][0] = $question_details;
				$this->template->set_layout('admin_default')->build('course/edit_review_question',$data);
				
			}
			else{
				$id = trim($this->input->post('rqid'));
				$chapterid=trim($this->input->post('chapter_id'));
				$courseid=trim($this->input->post('courseid'));

				$data_update['rev_ques_title'] 		= trim($this->input->post('qtitle'));
				$data_update['rev_ques_ans_1'] 		= trim($this->input->post('qanswer1'));
				$data_update['rev_ques_ans_2'] 		= trim($this->input->post('qanswer2'));
				$data_update['rev_ques_ans_3'] 		= trim($this->input->post('qanswer3'));
				$data_update['rev_ques_ans_4'] 		= trim($this->input->post('qanswer4'));
				$data_update['rev_ques_ans_5'] 		= trim($this->input->post('qanswer5'));
				$data_update['rev_correct_ans_id'] 	= trim($this->input->post('correct_ans'));
				
				$data_update['ans1_text'] 	= trim($this->input->post('qanswer1text'));
				$data_update['ans2_text'] 	= trim($this->input->post('qanswer2text'));
				$data_update['ans3_text'] 	= trim($this->input->post('qanswer3text'));
				$data_update['ans4_text'] 	= trim($this->input->post('qanswer4text'));
				$data_update['ans5_text'] 	= trim($this->input->post('qanswer5text'));

				
				//$data_update['rev_correct_ans_text'] 		= trim($this->input->post('correctAnswer'));
				//$data_update['rev_wronge_ans_text'] 		= trim($this->input->post('wrongAnswer'));
			   
			     $questionid = $this->course_mod->update_chapter_question($data_update,$id);
				 if($questionid > 0){
					 
					 $arr_msg = array('suc_msg'=>'Record updated successfully!!!');
				 }else{
					 $arr_msg = array('err_msg'=>'Failed to update record');
				 }
				 $this->session->set_userdata($arr_msg);
				 //redirect('course_con/manage_chapter_question/'.$chapterid);
				  redirect('course_con/manage_chapter_question/'.$chapterid.'/'.$courseid);

			}
			
		}
	}
	
	public function get_chapter_quest_details($qid)
     {
		  //echo 'here';die; 
	   $data['chapter_quest_details'] = $this->course_mod->get_chapter_question($qid);
			  //echo "<pre>";print_r($data['course_questions']);die;
	   $data['menutitle'] = '';
	   $data['pagetitle'] = 'Manage Course Chapter';
	   if($data != false)
		{
			$this->load->view('course/chapter_ques_popup',$data);
					
		}
		  
     }
	 
	 public function delete_chapter_quest($id)
	{
		 $result=$this->course_mod->delete_single_chapter_question($id);
		 if($result > 0){
			 $arr_msg = array('suc_msg'=>'Record deleted successfully!!!');
			}else{
			 $arr_msg = array('err_msg'=>'Failed to delete record');
			}
		 $this->session->set_userdata($arr_msg);
		 return true;
		// redirect('course_con/manage_course_quest/'.$courseid);
	}
	//End Chapter Question 
	
	public function chapter_order($order)
	{
	  
	  $order 	= trim($this->input->post('order'));
	  $ordernum=json_decode($order , true);
	 // echo "<pre>";print_r($ordernum); die;
	  if(count($ordernum) > 0)
	  {
		 foreach($ordernum as $key => $ordeVal)
		 {
			 $result = $this->course_mod->update_chapter_order($ordeVal,$key);
			 //echo $ordeVal;
		 } 
	  }
	  echo true;
	}

	public function get_state_courses()
	{
		$state_id = $this->input->post('state_id');
		$bundle_courses = $this->input->post('bundle_courses');
		
		if(isset($bundle_courses) && $bundle_courses!='')
		{
			$mybundle_course = explode(',',$bundle_courses);
			$data_course = array();
			if(count($mybundle_course) > 0)
			{	
				foreach($mybundle_course as $keyval => $cval)
				{
					$data_course[$cval] = $cval;
				} 
		    }	
		}
		
		
		$course_details = $this->course_mod->state_courses($state_id);
		$html = '';
		$html .='<table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>&nbsp;</th>
              <th>Course name </th>
              <th>Credits</th>
              <th>Categories</th>
            </tr>
          </thead>
          <tbody>';
				   foreach($course_details as $courses)
			       {
				      $total_credit = 0;
				      $course_credits = $this->course_mod->get_course_credits($courses['course_id'],$state_id);
					  foreach($course_credits as $mycredits)
					  {
						   $total_credit += $mycredits['credit_numbers'];
					  }
		              
					  if(isset($data_course) && count($data_course) > 0)
					   {
							if($data_course[$courses['course_id']] == $courses['course_id']){
								 $checked = 'checked="checked"';
							}else{
								 $checked = '';
							}
					   }else{
						    $checked = '';
					   }
					  
					  
            $html .='<tr class="odd gradeX">
                      <td><input type="checkbox" '.$checked.' name="bundle_courses[]" value="'.$courses['course_id'].'" /></td>
                      <td>'.$courses['course_name'].'</td>
                      <td>'.$courses['cpe_credits'].'</td>
                      <td>'.$courses['type'].'</td>
                    </tr>';
            
				    }
          $html .='</tbody>
        </table>';
	   echo $html;	
	}
	
	public function course_dublicate()
	{
		$course_id 	= $this->input->post('course_id');
		$course_details = $this->course_mod->get_course_details($course_id);
		$course_details[0]['course_id'] = '';
		$course_details[0]['course_name'] = trim($course_details[0]['course_name'].' [clone]');
		$course_details[0]['course_status'] = 'pending';
		
		$new_course_id = $this->course_mod->add_course($course_details[0]);
		if($new_course_id > 0)
		{
			echo $new_course_id;
		}else{
			echo 0;
		}
	}
	
	public function credit_dublicate()
	{
		$old_course_id 	= $this->input->post('old_course_id'); 
		$new_course_id 	= $this->input->post('new_course_id');
		$credit_details = $this->course_mod->get_state_credit_dublicate($old_course_id);
		$mycount = 0;
		foreach($credit_details as $key => $val_credit)
		{
			$data_insert['course_id'] = $new_course_id;
			$data_insert['course_type'] = $val_credit['course_type'];
			$data_insert['state_id'] = $val_credit['state_id'];
			$data_insert['credit_numbers'] = $val_credit['credit_numbers'];
			$credit_id = $this->course_mod->add_credits($data_insert);
		 $mycount ++;	
		}
		if($mycount > 0){
			echo $mycount;
		}else{
			echo 0;
		}
	}
	
	public function pdf_dublicate()
	{
		$old_course_id 	= $this->input->post('old_course_id'); 
		$new_course_id 	= $this->input->post('new_course_id');
		$course_pdf_details = $this->course_mod->get_pdf_details($old_course_id);
		$mycount = 0;
		foreach($course_pdf_details as $key => $val_pdf)
		{
			 $data_insert['course_id'] = $new_course_id;
			 $data_insert['pdf_name'] = $val_pdf['pdf_name'];
			 $data_insert['course_pdf'] = $val_pdf['course_pdf'];
			 $pdf_id = $this->course_mod->add_pdf($data_insert);
			$mycount ++; 
		}
		
		if($mycount > 0)
		{
			echo $mycount;
		}else{
			echo 0;
		}
		
	}
	
	public function video_dublicate()
	{
		 $old_course_id 	= $this->input->post('old_course_id'); 
		 $new_course_id 	= $this->input->post('new_course_id');
		 
		 $course_video_details = $this->course_mod->get_video_details($old_course_id);
		 $mycount = 0;
		 foreach($course_video_details as $key => $val_video)
		 {
			  $data_insert['course_id'] = $new_course_id;
			  $data_insert['video_name'] = $val_video['video_name'];
			  $data_insert['video_url'] = $val_video['video_url'];
			  $data_insert['is_intro'] = $val_video['is_intro'];
			  $video_id = $this->course_mod->add_course_video($data_insert);
			  $mycount ++; 
		 }
		 
		if($mycount > 0)
		{
			echo $mycount;
		}else{
			echo 0;
		}
	}
	
	public function final_exam_dublicate()
	{
		 $old_course_id 	= $this->input->post('old_course_id'); 
		 $new_course_id 	= $this->input->post('new_course_id');
		 $course_final_exam = $this->course_mod->get_all_course_quest($old_course_id);
		 $mycount = 0;
		 foreach($course_final_exam as $key => $val_exam)
		 {
			  $data_insert['course_id'] = $new_course_id;
			  $data_insert['ques_title'] = $val_exam['ques_title'];
			  $data_insert['ques_ans_1'] = $val_exam['ques_ans_1'];
			  $data_insert['ques_ans_2'] = $val_exam['ques_ans_2'];
			  $data_insert['ques_ans_3'] = $val_exam['ques_ans_3'];
			  $data_insert['ques_ans_4'] = $val_exam['ques_ans_4'];
			  $data_insert['ques_ans_5'] = $val_exam['ques_ans_5'];
			  $data_insert['correct_ans_id'] = $val_exam['correct_ans_id'];
			  $data_insert['ques_status'] = $val_exam['ques_status'];
			  $data_insert['question_image'] = $val_exam['question_image'];
			  $question_id = $this->course_mod->add_course_question($data_insert);
			 $mycount ++; 
		 }
		 
		if($mycount > 0)
		{
			echo $mycount;
		}else{
			echo 0;
		} 
	}
	
	public function chapter_dublicate()
	{
		 $old_course_id 	= $this->input->post('old_course_id'); 
		 $new_course_id 	= $this->input->post('new_course_id');
		 $course_chapter = $this->course_mod->get_all_course_chapter($old_course_id);
		 $mycount = 0;
		 foreach($course_chapter as $key => $val_chapter)
		 {
			   $data_insert['course_id'] = $new_course_id;
			   $data_insert['chapter_name'] = $val_chapter['chapter_name'];
			   $data_insert['chapter_desc'] = $val_chapter['chapter_desc'];
			   $data_insert['back_color'] = $val_chapter['back_color'];
			   $data_insert['status'] = $val_chapter['status'];
			   $data_insert['order_seq'] = $val_chapter['order_seq']; 	
			   $new_chapter_id = $this->course_mod->add_course_chapter($data_insert);
			   if($new_chapter_id > 0)
			   {
				   $chapter_questions = $this->course_mod->get_chapter_quest($val_chapter['chapter_id']);
				   if(sizeof($chapter_questions) > 0)
				   {
						foreach($chapter_questions as $key => $val_question)
						{
							$data_ins['course_id'] = $new_course_id;
							$data_ins['chapter_id'] = $new_chapter_id;
							$data_ins['rev_ques_title'] = $val_question['rev_ques_title'];
							$data_ins['rev_ques_ans_1'] = $val_question['rev_ques_ans_1'];
							$data_ins['rev_ques_ans_2'] = $val_question['rev_ques_ans_2'];
							$data_ins['rev_ques_ans_3'] = $val_question['rev_ques_ans_3'];
							$data_ins['rev_ques_ans_4'] = $val_question['rev_ques_ans_4'];
							$data_ins['rev_ques_ans_5'] = $val_question['rev_ques_ans_5'];
							$data_ins['rev_correct_ans_id'] = $val_question['rev_correct_ans_id'];
							$data_ins['rev_ques_status'] = $val_question['rev_ques_status'];
							$data_ins['ans1_text'] = $val_question['ans1_text'];
							$data_ins['ans2_text'] = $val_question['ans2_text'];
							$data_ins['ans3_text'] = $val_question['ans3_text'];
							$data_ins['ans4_text'] = $val_question['ans4_text'];
							$data_ins['ans5_text'] = $val_question['ans5_text'];
							$question_id = $this->course_mod->add_chapter_question($data_ins);
						}
				   }
			   
			  }
			$mycount ++;  
		 }
		 
		if($mycount > 0)
		{
			echo $mycount;
		}else{
			echo 0;
		} 
		 
	}
	
}
