<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing_con extends CI_Controller 
{
	function __construct()
	{
	  	parent::__construct();
		is_logged_admin();
		$this->load->model('landing_mod');
		$this->load->model('customer_mod');
		$this->load->model('course_mod');
		$this->load->library('email');
		
	}
	
    public function index()
	{
		   if($this->session->userdata('userid') != "")
		   {
			 
				$data['bundle_details'] = $this->landing_mod->get_all_bundles();
				//echo "<pre>";print_r($data['bundle_details']);die;		
				$data['menutitle'] = 'Landing Bundles';
				$data['pagetitle'] = 'Landing Bundles';
				$data['suc_msg'] = '';
				$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Landing Bundles</li></ul>';
				//echo $this->session->flashdata('success_msg');die;
				if($this->session->userdata('suc_msg') != '')
			{
				$data['suc_msg'] = $this->session->userdata('suc_msg');
				$this->session->unset_userdata('suc_msg');
			}
				if($this->session->flashdata('success_msg') != '')
				{      //echo $this->session->flashdata('success_msg');die;
						$data['suc_msg'] = $this->session->flashdata('success_msg');
						
				}
				
				if($data != false)
				{
					$this->template
						 ->set_layout('admin_default')
						 ->build('landing/landing_manage',$data);
						
				}
		    
		   }else{
				$this->load->view('index');
		   }
	}
	
	public function delete_bundle()
	{
		   $bundle_id = $this->input->post('bundle_id');
		   echo $deleted = $this->landing_mod->delete_bundle($bundle_id);
	}
	
	public function add_bundle()
	{
		$data['menutitle'] = 'Landing Bundles';
		$data['pagetitle'] = 'Add Landing Bundle';
		$data['states']			 = $this->customer_mod->get_all_state();
		$data['course_details'] =  $this->landing_mod->get_all_bundle_courses(); 
		$data['bundle_details'] =  $this->landing_mod->get_bundles(); 
		//echo "<pre>";print_r($data['bundle_details']);	die;
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'landing_con">Manage Landing Bundles</a><i class="fa fa-angle-right"></i></li><li>Add Landing Bundles</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('landing/add_landing',$data);
		}elseif(trim($this->input->post('submit')) == 'Add Landing Bundle')
		{    
			  $this->load->library('s3');
			 //echo "<pre>";print_r($this->input->post());
			  $bundle_title = trim($this->input->post('bundle_name'));
			  
			  $this->form_validation->set_rules('bundle_name', 'Bundle Name', 'trim|required|min_length[5]');
			  $this->form_validation->set_rules('bundle_desc', 'Bundle Description', 'trim|required');
			  $this->form_validation->set_rules('expdate', 'expiry date', 'trim|required');
			 if($this->input->post('bundles') == '') 
			 {
			  $this->form_validation->set_rules('bundle_courses[]', 'Courses', 'trim|required');
			 }
			 
			  $this->form_validation->set_rules('bundle_price', 'Bundle Price', 'trim|required|numeric');
			  $this->form_validation->set_rules('state_id', 'States', 'trim|required');
			  
			  // Upload image
			 $file_error = 0;
			 $imagefile_error = '';
			 if($_FILES['bundle_image']['name'])
			 {
				 $bundle_image = $_FILES['bundle_image']['name'];
				 if(strlen(trim($bundle_image)) > 0) 
				 {
					  $upload_filename_image = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $bundle_title).'_'.$bundle_image;
					  $upload_filename_image = str_replace(' ', '_', strtolower($upload_filename_image));
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png');
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
			  
			   
			  if ($this->form_validation->run($this) == FALSE)
			  {
					if ($file_error == 1)
				    {
						 $data['fileerror']['imagefile_upload_error'] = $imagefile_error;
					}
					
					$this->template->set_layout('admin_default')->build('landing/add_landing',$data); 
			  }else{
				  $landing_courses ='';
						if(count($this->input->post('bundle_courses')) > 0)
					   {
						  $landing_courses = implode(',',$this->input->post('bundle_courses')).',';
					   }
				  
				   if(count($this->input->post('bundles')) > 0)
				   {
					  $selected_bundle =  implode(',',$this->input->post('bundles'));
					  $get_courses =  $this->landing_mod->get_bundles_courses($selected_bundle); 
					 
					  if(count($get_courses) > 0)
					  {
						 $cntcid = count($get_courses);
						 for($i=0; $i<$cntcid;$i++) 
						 {
						  	$landing_courses .=  $get_courses[$i]['bundle_courses'].','; 
						 }
						 
					  }
					  
					 
				   }
				   
				   $landincids = explode(',',$landing_courses);
				   //echo "<pre>";print_r($landincids);
				     $landincids =array_filter($landincids);
					 $landincids =array_unique($landincids);
					  //echo "<pre>";print_r(array_unique($landincids));
				 
				   $data_insert['bundle_name'] =  trim($this->input->post('bundle_name')); 
				   $data_insert['bundle_desc'] =  trim($this->input->post('bundle_desc'));   
				   $data_insert['bundle_courses'] =  implode(',',$landincids);
				   $data_insert['bundle_price'] =  trim($this->input->post('bundle_price'));  
				   $data_insert['offer_price'] =  trim($this->input->post('bundle_dprice'));
				   $data_insert['state_id'] =  trim($this->input->post('state_id')); 
				   $data_insert['bundle_status'] =  trim($this->input->post('bundle_status'));
				   $data_insert['bundle_image'] = trim($data['image_file']); 
				   $data_insert['bundle_created'] = date('Y-m-d H:i:s');
				 
				   $data_insert['end_date'] = date('Y-m-d', strtotime($this->input->post('expdate')));
				  
				   $data_insert['intro_video'] = trim($this->input->post('intro_video'));
				   $data_insert['bundle_type'] = 'landing';
				   $data_insert['landing_courseids'] =  implode(',',$this->input->post('bundle_courses'));
				   $data_insert['landing_bundleids'] = implode(',',$this->input->post('bundles'));
				   $data_insert['s3_images'] = trim($s3file);
				   $data_insert['back_color'] = trim($this->input->post('back_color'));
				   $data_insert['hidedays'] = trim($this->input->post('hidedays'));
				   $data_insert['hidecountdown'] = trim($this->input->post('hidecountdown'));
				   //echo "<pre>";print_r($data_insert);die;
				   $bundle_id = $this->landing_mod->add_bundle($data_insert);
				   if($bundle_id > 0){
					    $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				   }else{
					    $arr_msg = array('err_msg'=>'Failed to add record');
				   }
				   $this->session->set_userdata($arr_msg);
				  redirect('landing_con');
			  }
		}
	}
	
	public function edit_bundle($bundle_id = 0)
	{
		
		$data['menutitle'] = 'Landing Bundles';
		$data['pagetitle'] = 'Edit Landing Bundle';
		$data['states']			 = $this->customer_mod->get_all_state();
		$data['course_details'] =  $this->landing_mod->get_all_bundle_courses(); 
		$data['bundle_detail'] =  $this->landing_mod->get_bundles(); 
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'landing_con">Manage Landing Bundle</a><i class="fa fa-angle-right"></i></li><li>Update Landing Bundle</li></ul>';
		
		//echo "<pre>";print_r($data['bundle_detail']);die;
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
			$data['bundle_details'] = $this->landing_mod->get_bundle_details($bundle_id);
			
			$this->template->set_layout('admin_default')->build('landing/edit_landing',$data);
		}elseif(trim($this->input->post('submit')) == 'Edit Landing Bundle')
		{
			  $this->load->library('s3');
			//echo "<pre>";print_r($this->input->post());die;
			  $bundle_title = trim($this->input->post('bundle_name'));
			 
			  $this->form_validation->set_rules('bundle_name', 'Bundle Name', 'trim|required|min_length[5]');
			  $this->form_validation->set_rules('bundle_desc', 'Bundle Description', 'trim|required');
			  //$this->form_validation->set_rules('bundle_courses[]', 'Courses', 'trim|required');
			  $this->form_validation->set_rules('bundle_price', 'Bundle Price', 'trim|required|numeric');
			  $this->form_validation->set_rules('state_id', 'States', 'trim|required');
			  
			 if($this->input->post('bundles') == '') 
			 {
			  $this->form_validation->set_rules('bundle_courses[]', 'Courses', 'trim|required');
			 }
			 
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
					  $image_fileExtension = $this->course_mod->get_file_extension($upload_filename_image);
					  $allowed_type = array('gif','jpg','jpeg','png');
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
				    $arr_course_details['offer_price'] =  trim($this->input->post('bundle_dprice'));
				    $arr_course_details['state_id'] =  trim($this->input->post('state_id')); 
				    $arr_course_details['bundle_status'] =  trim($this->input->post('bundle_status'));
				    $arr_course_details['bundle_image'] = trim($this->input->post('old_image')); 
					$arr_course_details['back_color'] = trim($this->input->post('back_color'));
					$arr_course_details['end_date'] = date('Y-m-d', strtotime($this->input->post('expdate')));
					$arr_course_details['intro_video'] = trim($this->input->post('intro_video'));	
					$arr_course_details['landing_courseids'] = implode(',',$this->input->post('bundle_courses'));
					$arr_course_details['landing_bundleids'] = implode(',',$this->input->post('bundles'));
					$arr_course_details['hidedays'] = trim($this->input->post('hidedays'));
					$arr_course_details['hidecountdown'] = trim($this->input->post('hidecountdown'));
					
					$data['bundle_details'][0] = $arr_course_details;
					$this->template->set_layout('admin_default')->build('landing/edit_landing',$data);
			 }else{
				    $bundle_id = $this->input->post('bundle_id');
					
					$landing_courses ='';
						if(count($this->input->post('bundle_courses')) > 0)
					   {
						  $landing_courses = implode(',',$this->input->post('bundle_courses')).',';
					   }
				  
				   if(count($this->input->post('bundles')) > 0)
				   {
					  $selected_bundle =  implode(',',$this->input->post('bundles'));
					  $get_courses =  $this->landing_mod->get_bundles_courses($selected_bundle); 
					 
					  if(count($get_courses) > 0)
					  {
						 $cntcid = count($get_courses);
						 for($i=0; $i<$cntcid;$i++) 
						 {
						  	$landing_courses .=  $get_courses[$i]['bundle_courses'].','; 
						 }
						 
					  }
					  
					 
				   }
				   
				     $landincids = explode(',',$landing_courses);
				   //echo "<pre>";print_r($landincids);
				     $landincids =array_filter($landincids);
					 $landincids =array_unique($landincids);
					  //echo "<pre>";print_r(array_unique($landincids));
					  
					$data_update['bundle_name'] =  trim($this->input->post('bundle_name')); 
				    $data_update['bundle_desc'] =  trim($this->input->post('bundle_desc'));   
				    //$data_update['bundle_courses'] =  implode(',',$this->input->post('bundle_courses'));
					$data_update['bundle_courses'] =  implode(',',$landincids);
				    $data_update['bundle_price'] =  trim($this->input->post('bundle_price'));  
				    $data_update['offer_price'] =  trim($this->input->post('bundle_dprice'));
				    $data_update['state_id'] =  trim($this->input->post('state_id')); 
				    $data_update['bundle_status'] =  trim($this->input->post('bundle_status'));
					$data_update['back_color'] = trim($this->input->post('back_color'));
					$data_update['end_date'] = date('Y-m-d', strtotime($this->input->post('expdate')));
					$data_update['intro_video'] = trim($this->input->post('intro_video'));
				    $data_update['landing_courseids'] =  implode(',',$this->input->post('bundle_courses'));
				    $data_update['landing_bundleids'] = implode(',',$this->input->post('bundles'));
				    $data_update['hidedays'] = trim($this->input->post('hidedays'));
					$data_update['hidecountdown'] = trim($this->input->post('hidecountdown'));
					
					if(isset($data['image_file']) && $data['image_file']!=''){
						$data_update['bundle_image'] = trim($data['image_file']);
					}else{
						$data_update['bundle_image'] = trim($this->input->post('old_image'));
					}
				     
				    $data_update['bundle_created'] = date('Y-m-d H:i:s');
					
					$bundle_id = $this->landing_mod->update_bundle($data_update,$bundle_id);
					
				    if($bundle_id > 0){
							$arr_msg = array('suc_msg'=>'Record updated successfully!!!');
					}else{
							$arr_msg = array('err_msg'=>'Failed to add record');
					}
					
				   $this->session->set_userdata($arr_msg);
				  redirect('landing_con');
					
			 }
		}
		
	}
	
	public function send_bundle_mail($bid=0)
	{
		
		$data['menutitle'] = 'Send Mail Landing Bundles';
		$data['pagetitle'] = 'Send Mail Landing Bundles';
		$data['bundle_details']			 = $this->landing_mod->get_bundle_details($bid);
		$data['customers']			 = $this->landing_mod->get_all_customers();
		$data['err_msg'] = '';
		//$data['course_details'] =  $this->landing_mod->get_all_bundle_courses(); 
		//echo ">><pre>";print_r($data['bundle_details']);	die;
		$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'landing_con">Manage Landing Bundles</a><i class="fa fa-angle-right"></i></li><li>Landing Bundles URL</li></ul>';
		
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		
		if(trim($this->input->post('submit')) == '')
		{
			$this->template->set_layout('admin_default')->build('landing/send_landing',$data);
		}
		elseif(trim($this->input->post('submit')) == 'Send Mail Landing Bundles')
		{   //echo "<pre>";print_r( $this->input->post());die;
			$custids= $this->input->post('customer_mail');
			$exp_date= $this->input->post('expiry_date');
			$offer_price =$this->input->post('offer_price');
			
			$bid=$this->input->post('bid');
			if(sizeof($custids) > 0)
			{
				foreach($custids as $custid)
				{
				 $data_insert['user_id'] = $custid;
				 $data_insert['bundle_id'] = $bid;
				  $data_insert['offer_price'] = $offer_price;
				 $data_insert['expiry_date'] = date("Y-m-d",strtotime($exp_date));
				 
				  $id = $this->landing_mod->add_landing_user($data_insert);	
				
				  $customer =$this->customer_mod->get_customer($custid);	
				  $bundle_details = $this->landing_mod->get_bundle_details($bid); 
				 if($id > 0)
				{
			      	
				  	$fullname = $customer[0]['first_name'].' '.$customer[0]['last_name']; 
					
				 	$email=$customer[0]['email'];
					$code =md5($id);
					
					$TO = $email;
					$SUBJECT = "Landing Bundle";
					$Header = 'MIME-Version: 1.0' . "\r\n";
					$Header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$html ='<table border="0" cellspacing="0" cellpadding="0" style="background:#eaeaea; max-width:800px; width:100%; padding:0px 15px;" align="center">
							  <tr>
								<td style="background:#fff;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td style="text-align: justify; padding: 5%">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td> Hello '.$fullname.', <br/><br/>CPE Admin created a landing page for you. <br/>
											  Below given are the landing page details<br/>
											  <b>Name</b>: '. $bundle_details[0]['bundle_name'].'<br/>
											  <b>Price</b>: '.$offer_price.'<br/>
											  <b>Expiry Date</b>: '.date("Y-m-d",strtotime($bundle_details[0]['end_date'])).'<br/><br/>
											  Please login with your CPE Nation credentials to access the below given link. Once login click on below given link or you can copy and paste the URL in browser. 
											  <br/>';
											  $html.= '<a href="'.$this->config->item('front_url')."compliance-landing/".$code.'">'.$this->config->item('front_url')."compliance-landing/".$code.'</a>'; 
											  $html.= '<br/><br>
											  Regards,<br/>
											  Team CPE Nation
											  </td>
											  </tr>
											  </table>
											  </td>
											  </tr>
											  </table>
											  </td>
                  </tr>
                  </table>';
				  
				 //echo $html;die;
				  	@$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('info@cpenation.com', 'CPE Nation');
					$this->email->to($email);
					$this->email->subject($SUBJECT);
					$this->email->message($html);
					$result1=$this->email->send();
	
				}
				 //echo ">><pre>";print_r($customer);	die;
				} 
				 //$this->session->set_userdata($arr_msg);
				 $this->session->set_flashdata('success_msg', 'Landing Bundle Send Successfully');
				 //echo $this->session->set_userdata($arr_msg);die;
				redirect('landing_con');
			}
			else{
				//echo "test<pre>";print_r($custids);	die;
				$data['bundle_details']			 = $this->landing_mod->get_bundle_details($bid);
				$data['err_msg'] = 'Please Select Atleast One Customer';
				$this->template->set_layout('admin_default')->build('landing/send_landing',$data);
			}
		}
	}	
}