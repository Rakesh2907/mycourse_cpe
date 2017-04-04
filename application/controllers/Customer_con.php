<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Customer_con.php
# Created on : 9th Sep 2016 by Rakesh Ahirrao
# Update on : 4th Oct 2016 by Rakesh Ahirrao
# Purpose : Customer related functionality like Registration,Login,Forgotpassword etc.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_con extends CI_Controller {

	/**
	 * States Page for this controller.
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
	public $current_user_id = 0; 
	public $current_state = 0;	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_mod');
		$this->load->library('email');
		$this->load->helper('general');
		$this->load->model('bundle_mod');
		$this->load->model('course_mod');
		$this->load->model('state_mod');
		$this->load->model('subscription_mod');
		$this->current_user_id = is_logged_in();
		
		if($this->session->userdata['state_id']=='')
		{
			 $this->current_state = find_states();
		}else{
			 $this->current_state =  $this->session->userdata['state_id'];
		}
		
	} 
	 
	public function index()
	{
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
	}
	
	public function customer_notes()
	{
		if($this->current_user_id!=0)
		{
			$course_id = $this->input->post('course_id');
		  	$user_id = $this->input->post('user_id');
		  	$user_course_id = $this->input->post('user_course_id');
		  	$my_notes = $this->input->post('my_notes');
			$current_date = $this->input->post('current_date');
			$current_time = $this->input->post('current_time');
			$my_video_id = $this->input->post('myvideo_id');
			$video_seconds = $this->input->post('video_seconds');
			
			$video_seconds = gmdate("i:s", $video_seconds);
			
			$data_insert['user_course_id'] = $user_course_id;
			$data_insert['user_id'] = $user_id;
			$data_insert['course_id'] = $course_id;
			$data_insert['notes'] = $my_notes;
			$data_insert['date_time'] = $current_date;
			$data_insert['notes_time'] = $current_time;
			$data_insert['video_id'] = $my_video_id;
			$data_insert['video_seconds'] = $video_seconds;
			
			echo $notes_id = $this->customer_mod->customer_notes($data_insert);
		}else{
			echo "Please login";
		}
	}
	
	public function delete_notes()
	{
		if($this->current_user_id!=0)
		{
			$user_id = $this->input->post('user_id');
		  	$notes_id = $this->input->post('notes_id');
			$deleted = $this->customer_mod->delete_notes($user_id,$notes_id);
			echo 1;
		}else{
			echo "Please login";
		}
	}
	
	public function edit_notes()
	{
		if($this->current_user_id!=0)
		{
			$user_id = $this->input->post('user_id');
		  	$notes_id = $this->input->post('notes_id');
			$edit_notes = $this->input->post('edit_text');
		
			//$data_update['notes'] = $edit_text;
			$update = $this->customer_mod->update_notes($edit_notes,$notes_id,$user_id);
			echo 1;
		}else{
			echo "Please login";
		}
	}
	
	public function get_video_notes()
	{
		if($this->current_user_id!=0)
		{
			  $user_id = $this->input->post('user_id');
			  $video_id = $this->input->post('video_id');
			  $user_course_id = $this->input->post('user_course_id');
			  $course_id = $this->input->post('course_id');
			 
			  $course_notes = $this->customer_mod->get_user_course_notes($this->current_user_id,$user_course_id,$video_id);  
			  $htmlnote = '<div class="nts_head"><h4>Your Notes</h4>';
			  $htmlnote .='<div class="close-panel" onclick="hide_note();" href="javascript:void(0)"><span class="hide-name">HIDE NOTES</span><a class="close-tag" ></a></div></div>
<div class="notes_sec"><ul class="list-unstyled notes-listing" id="showing_notes_list">';
			if(count($course_notes) > 0) 
			{
  				foreach($course_notes as $key => $mynotes)
				{
     				$htmlnote .='<li id="notes_list_'.$mynotes['id'].'"><div class="notes-head"><span class="vr-line"></span>';
    				$htmlnote .='<a href="#" class="nts-hd">'.$mynotes['video_seconds'].'</a>';
     				$htmlnote .='<ul class="nts-action"><li><a href="javascript:void(0)" class="delete" onclick="delete_notes('.$mynotes['id'].');">';
	 				$htmlnote .='<span class="icon icon-trash"></span></a></li><li><a data-toggle="modal" data-target="#chg_report_Period" href="javascript:void(0)" class="sprite-icons crs-edit-Icon" onclick="edit_notes('.$mynotes['id'].')"></a></li></ul></div> <!-- /notest-head --><div class="notes-txt" id="current_text_'.$mynotes['id'].'">'.$mynotes['notes'].'</div></li>';
     				$htmlnote .='<li class="edt-notes" id="my_edit_'.$mynotes['id'].'" style="display:none;"><div class="notes-txt"><textarea class="form-control" id="edit_text_'.$mynotes['id'].'">'.trim($mynotes['notes']).'</textarea></div>';
     				$htmlnote .='<div class="save-nts-action text-right"> <a class="cancel" href="javascript:void(0)" onclick="cancel_edit('.$mynotes['id'].')">Cancel</a><a class="btn fad-orange" onclick="save_edit('.$mynotes['id'].')">Save</a></div></li>';
    			}
  			} 
 			$htmlnote .='</ul>';
	    	$htmlnote .='<div class="add-notes-lnk"><a class="add-note" href="javascript:void(0)" onclick="add_new_notes()">Add Note</a></div>';
 	    	$htmlnote .='<div id="mynotes" class="notes-txt edt-notes" style="display:none;"><textarea class="form-control" name="uses_note" id="add_my_new_notes"></textarea><div class="save-nts-action text-right"> <a class="cancel" href="javascript:void(0)" onclick="canel_add_notes();">Cancel</a> <a id="add_new_notes" class="btn fad-orange" onclick="add_new_video_notes('.$video_id.','.$user_course_id.','.$course_id.')">Add</a></div></div></div>';
			$htmlnote .='<div class="down-footer"><ul><li><a href="'.base_url().'customer_con/download_notes_pdf/'.$user_course_id.'/'.$video_id.'">DOWNLOAD PDF</a></li><li><a href="'.base_url().'customer_con/download_notes_spredsheet/'.$user_course_id.'/'.$video_id.'">DOWNLOAD SPREADSHEET</a></li></ul></div>';
			echo $htmlnote;
		}
	}
	
	public function take_courses($user_course_id)
	{
		 if($this->current_user_id!=0)
		 {
			$data['page_title'] = 'Take Course | CPE Nation';
			$data['order_id'] = $order_id;
		 	$data['cuserid'] = $this->current_user_id;
			$data['course_state'] = $this->current_state;
			
			$data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			
			
			 if($user_course[0]['user_id'] == $this->current_user_id)// && $user_course[0]['course_status'] != 'Completed'
			 {
				 $data['orders_details'] = $this->customer_mod->get_order_details($this->current_user_id,'','',$user_course[0]['order_id']);	
		 	     $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1);
				 $data_course_percentage = $this->customer_mod->get_course_percentage($user_course_id,$user_course[0]['course_id']);
				 $data['course_progress'] = [];
				 foreach($data_course_percentage as $progress){
					 $data['course_progress'][$progress['video_pdf_id']] = $progress['completed_percentage'];
				 }
				 $data['first_chapters'] = $this->course_mod->get_chapters($course_details[0]['course_id']); 
				 $data['user_course_id'] = $user_course[0]['id'];
			 	 $data['totalpercent'] = 0;
				 $data['totalpercent'] = $this->get_total_percentage($data_course_percentage,$user_course[0]['review_percentage'],$user_course[0]['exam_percentage']);
				 $chapter_count = count($this->course_mod->get_chapters($course_details[0]['course_id']));
				 
				 $review_progres_count = $this->customer_mod->chapter_progress_count($course_details[0]['course_id'],$user_course_id,$this->current_user_id);
				 if($chapter_count == $review_progres_count)
				 {
					  $this->customer_mod->update_review_exam_course_status($course_details[0]['course_id'],$user_course_id,$this->current_user_id);
				 }
				  
				 $this->template->load('layouts/default_layout.php','customer/take_course.php',$data);  
			 }else{
				 redirect(base_url().'mycourses');
			 }
	     }else{
			  redirect(base_url().'login'); 
		 }
	}
	public function course_evalution($user_course_id)
	{
		  if($this->current_user_id!=0)
		  {
			  $data['page_title'] = 'Course Evalution | CPE Nation';
			  $data['cuserid'] = $this->current_user_id;
			  $data['course_state'] = $this->current_state;
			  $data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			   if($user_course[0]['user_id'] == $this->current_user_id && $user_course[0]['course_status'] == 'Completed')
			   {    $data['rew_success'] = '';
				    $data['user_course_id'] = $user_course_id;
				  	$data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1); 
					 $states =  $this->state_mod->state_details($user_course[0]['course_state']);
			 		$data['mystate_id'] = $states[0]['state_id'];
				  	$data['course_id'] = $course_details[0]['course_id'];
					$data['coursename'] = $this->clean_filename($course_details[0]['course_name']);
					$data['certificate_file'] = $this->clean_filename($course_details[0]['course_name']).'_'.$user_course_id.'.pdf';
					$data['course_evalution'] =  $this->customer_mod->get_course_evalution($this->current_user_id,$user_course_id);
					
				    if($this->input->post('submit')=='SUBMIT')
				    {
						 $data_insert['user_id'] = $this->current_user_id;
						 $data_insert['course_id'] = $course_details[0]['course_id'];
						 $data_insert['user_course_id'] = $user_course_id;
						 $data_insert['ques1'] = $this->input->post('ques_1');
						 $data_insert['ques2'] = $this->input->post('ques_2');
						 $data_insert['ques3'] = $this->input->post('ques_3');
						 $data_insert['ques4'] = $this->input->post('ques_4');
						 $data_insert['ques5'] = $this->input->post('ques_5');
						 $data_insert['ques6'] = $this->input->post('ques_6');
						 $data_insert['notes'] = trim($this->input->post('comment'));
						 $myreviewRes = $this->customer_mod->insert_review($data_insert,$this->current_user_id,$user_course_id);
						 if($myreviewRes){
							 $data['rew_success'] = 'Thanks for review/feedback';
					     }else{
							 $data['rew_success'] = '';
					     }
					}
				    $this->template->load('layouts/default_layout.php','customer/course_evalution.php',$data);   
			   }else{
				    redirect(base_url().'mycourses');
			   }
		  }else{
			   redirect(base_url().'login'); 
		  }
	}
	
	public function clean_filename($string){
		$string = trim($string);
		$string = strtolower($string);
		$string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.

		return preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
	}
	
	public function start_review_exam($user_course_id)
	{
		  if($this->current_user_id!=0)
		  {
			  $data['page_title'] = 'Take Review Exam | CPE Nation';
			  $data['cuserid'] = $this->current_user_id;
			  $data['course_state'] = $this->current_state;
			  $data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			  if($user_course[0]['user_id'] == $this->current_user_id && $user_course[0]['course_status'] != 'Completed')
			  {
				  $data['current_chapter'] = $chapter_id = $_REQUEST['chapter_id'];
				  $data['user_course_id'] = $user_course_id;
				  $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1); 
				  $data['course_id'] = $course_details[0]['course_id'];
				  $data['course_chapters'] = $this->course_mod->get_chapters($course_details[0]['course_id']); 
				  $data['chapter_questions'] = $this->course_mod->get_chapter_questions($chapter_id,$course_details[0]['course_id']);
				  $data['review_progress_id'] = $this->customer_mod->review_questions($chapter_id,$user_course_id,$this->current_user_id,$course_details[0]['course_id']);
				  $data['answers'] = $this->customer_mod->get_review_answers($chapter_id,$user_course_id,$this->current_user_id,$course_details[0]['course_id']);
				 // echo count($data['chapter_questions'])." == ".count($data['answers']);
				  
				  if(count($data['chapter_questions']) == count($data['answers']))
				  {
					 $this->customer_mod->update_chapter_status($chapter_id,$user_course_id,$this->current_user_id,$course_details[0]['course_id']); 
				  }
				  
				 $chapter_count = count($this->course_mod->get_chapters($course_details[0]['course_id']));
				 
				 $review_progres_count = $this->customer_mod->chapter_progress_count($course_details[0]['course_id'],$user_course_id,$this->current_user_id);
				 if($chapter_count == $review_progres_count)
				 {
					  $this->customer_mod->update_review_exam_course_status($course_details[0]['course_id'],$user_course_id,$this->current_user_id);
				 }
				  
			     $this->template->load('layouts/default_layout.php','customer/start_review_exam.php',$data);   
			  }else{
				  redirect(base_url().'mycourses');
			  }
			  
		  }else{
			   redirect(base_url().'login'); 
		  }
	}
	
	public function start_final_exam($user_course_id)
	{
		 if($this->current_user_id!=0)
		 {
		      $data['page_title'] = 'Take Review Exam | CPE Nation';
			  $data['cuserid'] = $this->current_user_id;
			  $data['course_state'] = $this->current_state;
			  $data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			  if($user_course[0]['user_id'] == $this->current_user_id && $user_course[0]['course_status'] != 'Completed')
			  {
				 $data['user_course_id'] = $user_course_id;
				 $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1); 
				 $data['course_id'] = $course_details[0]['course_id'];
				 $data['course_exam'] = $this->course_mod->get_exam_details($course_details[0]['course_id']); 
				 $data['examResult'] = '';
				 $data['passingPercentage'] = 0;
				 $pdf_name = $this->clean_filename($user_course[0]['pdf_name']);

				 if($this->input->post('submit')=='Submit')
				 {
					   $examanswer = $this->input->post('radiog_dark');
					   //echo '<pre>'; print_r($_POST); die();
					   $pass = 0;
					   foreach($examanswer as $key => $userans)
					   {
						    $correct = $this->check_exam_ans($key,$userans);
							
							 
							 if($correct == 1){
								 $pass += 1;
							 }
							 
					   }
					 
					   $totalQuesNo = sizeof($data['course_exam']);
					   $passingPercentage = ((100/$totalQuesNo)*$pass); 
					   $passing_grade = $course_details[0]['passing_grade'];
					   $data['examResult']= 'failed';
					   $data['passingPercentage']= $passingPercentage;
					  			  
					   if($passingPercentage >= $passing_grade)
					   {
						  $this->customer_mod->update_final_exam_course_status($course_details[0]['course_id'],$user_course_id,$this->current_user_id);
						  $this->download_certificate($user_course_id,$pdf_name);  
						  foreach($examanswer as $key => $userans_id)
						  {
								// insert into exam progress table	 
								$this->insert_exam_ans($key,$userans_id,$user_course_id,$course_details[0]['course_id'],$this->current_user_id);
									 
						  } 
						  $data['examResult']= 'success';
					   }
					   
				 }
				 
				   
				 $this->template->load('layouts/default_layout.php','customer/start_final_exam.php',$data);    
			  }else{
				   redirect(base_url().'mycourses');
			  }
		 }else{
			   redirect(base_url().'login'); 
		  }
	}
	
	public function user_certificates()
	{
		 if($this->current_user_id!=0)
		 {
			    $data = array();
				$data['sider_bar'] = 'certificate';
				$data['page_title'] = 'Certificates | CPENATION';
				$data['start'] = $start_date = '';
		        $data['end'] = $end_date = '';
				$data['mysort'] = $sort = '';
				if($this->input->post('submit') == 'Filter')
				{
				   if($this->input->post('fromdate')!='' || $this->input->post('enddate')!='')
				   {	
						if($this->input->post('fromdate')!=''){
							$start_date = date('Y-m-d',strtotime($this->input->post('fromdate')));
							$data['start'] = $start_date;
						}else{
							$data['err_msg'] = 'Please enter start date';
						}
						if($this->input->post('enddate')!='')
						{
							$end_date =  date('Y-m-d',strtotime($this->input->post('enddate')));
							$data['end'] = $end_date;
						}else{
							$data['err_msg'] = 'Please enter end date';
						}
				   }else{
					   $data['err_msg'] = 'Please enter start and end date';
				   }
					
					 $sort = $this->input->post('sorting');
					 $data['mysort'] =  $sort;
				}
				
				$data['certificates'] = $mycertificates = $this->customer_mod->get_completed_courses($this->current_user_id,$start_date,$end_date,$sort);	
				
				foreach($data['certificates'] as $key=>$certificate){
					
					$data['certificates'][$key]['course_name_clean'] = $this->clean_filename($certificate['pdf_name']);
					
				}
				
				$data['user_id'] = $this->current_user_id;
			 	$this->template->load('layouts/default_layout.php','customer/certificate_list.php',$data); 
		 }else{
			  redirect(base_url().'login');
		 }
	}
	
	public function download_zip($user_id)
	{
		 if($this->current_user_id!=0)
		 {
			  $start_date = $_REQUEST['start'];
			  $end_date = $_REQUEST['end'];
			  $sort = $_REQUEST['sort'];
			  
			  $mycertificates = $this->customer_mod->get_completed_courses($this->current_user_id,$start_date,$end_date,$sort);	
			  $this->load->library('zip');
			  unlink(FCPATH.'uploads/certificate_zip/my_certificate_'.$this->current_user_id.'.zip');	
			  foreach($mycertificates as $key => $course_list)
			  {
					$download_pdf = $this->clean_filename($course_list['pdf_name']).'_'.$course_list['id'].'.pdf';
					$mypdf = FCPATH.'uploads/'.$download_pdf;
					$this->zip->read_file($mypdf);
			  }
				
			  $this->zip->archive(FCPATH.'uploads/certificate_zip/my_certificate_'.$this->current_user_id.'.zip');
			  $this->zip->download('my_certificates_'.$user_id.'.zip');
			  
		 }else{
			  redirect(base_url().'login');
		 }
	}
	
	public function dowload_pdf()
	{
		$file = trim($_GET['file']);
		if($file !=''){
		$filepath = FCPATH.'uploads/'.$file; 
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header("Content-Type: application/force-download");
			header('Content-Disposition: attachment; filename=' . $file);
			// header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));					
			ob_clean();
			flush();
			readfile($filepath);
			exit;
		}
		 
	}
	
	public function download_awspdf()
	{
		$file = trim($_GET['file']);
		$course_name = trim($_GET['course_name']);
		$fileurl = $file;
		header("Content-type:application/pdf");
		header('Content-Disposition: attachment; filename=' . $course_name.'.pdf');
		readfile($fileurl);
		exit;
	}
	
	
	public function download_receipt($order_id)
	{
		 if($this->current_user_id!=0)
		 {
			 $data['page_title'] = 'Certificate | CPENATION';
			 $data['cuserid'] = $userid = $this->current_user_id;
			 $data['course_state'] = $this->current_state;
			 
			 $data_order = $this->customer_mod->get_order_details($userid,'','',$order_id);
		
			 $orderData= array();
		
			for($j=0; $j<(count($data_order)) ;$j++)
			{
				$data['result'] = 'true';
				$data_order1 = $this->customer_mod->get_order_courses($data_order[$j]['order_id']);
				$orderData[$j]['order_id']=$data_order[$j]['order_id'];
				$orderData[$j]['order_no']=$data_order[$j]['order_number'];
				$orderData[$j]['order_date']=$data_order[$j]['order_date'];
				$orderData[$j]['order_tax']=$data_order[$j]['order_tax'];
				$orderData[$j]['discount']=$data_order[$j]['discount'];
				$orderData[$j]['ordertotal']=$data_order[$j]['order_total'];
				//get order items from order_courses table
				
				for($i=0; $i<(count($data_order1)) ;$i++)
				{    $totalcredit=0;
					 $type = $data_order1[$i]['purchase_type'];
					 $cid =  $data_order1[$i]['course_id'];
						if($type =='Bundle')
						{
							 $stateid = $this->customer_mod->get_order_states($cid,$data_order[$j]['order_id'],'Bundle');
							 
							 if(sizeof($stateid) > 0)
							 {
									 foreach($stateid as $state)
										 {
											 $course_course_credit		=	json_decode($state['course_credits'],true);
											 $course_state				=	$state['course_state'];
										   if (array_key_exists($course_state, $course_course_credit))
											{
											   foreach($course_course_credit[$course_state] as $credits)
												{  
															  $totalcredit +=$credits; 
												}
											 }
									 }
								 
							 }
							
							$itemdata[$i]['credit']=$totalcredit;
							$item_name = $this->bundle_mod->get_bundle_details($cid);
							$itemdata[$i]['Type']='Compliance Bundle';
							$itemdata[$i]['name']=$item_name[0]['bundle_name'];
							$itemdata[$i]['itemprice']=$data_order1[$i]['course_amount'];
							
						}else if($type =='Course'){
							
							 $stateid = $this->customer_mod->get_order_states($cid,$data_order[$j]['order_id']);
							 //echo "<pre>";print_r($stateid);die;
							 $course_course_credit		=	json_decode($stateid[0]['course_credits'],true);
							 $course_state				=	$stateid[0]['course_state'];
							 if (array_key_exists($course_state, $course_course_credit))
							{
							   foreach($course_course_credit[$course_state] as $credits)
								{  
											  $totalcredit +=$credits; 
								}
							 }
							$itemdata[$i]['credit']=$totalcredit;
							 
							$item_name = $this->course_mod->get_course_details($cid,1);
							$itemdata[$i]['Type']='Self-Study Course';
							$itemdata[$i]['name']=$item_name[0]['course_name'];
							$itemdata[$i]['itemprice']=$data_order1[$i]['course_amount'];
							
						}else if($type =='Subscription')
						{
						 	$item_name = $this->subscription_mod->get_subscription_details($cid);
							$itemdata[$i]['Type']='Subscription';
						    $itemdata[$i]['name']=$item_name[0]['title'];
						    $itemdata[$i]['itemprice']=$data_order1[$i]['course_amount'];
						 //$itemdata[$i]['credit']= '-';
					    }
						$orderData[$j]['items']=$itemdata;
					}
			  }
		
			 $data['order_details']  = $orderData;
			 $customer_details = $this->customer_mod->get_customer_details($this->current_user_id);
			 $data['full_name'] = $customer_details[0]['first_name'].' '.$customer_details[0]['last_name']; 
			 $data['cemail'] = $customer_details[0]['email'];
			 $full_name = $customer_details[0]['first_name'].'_'.$customer_details[0]['last_name'];
			 $html = $this->load->view('download_recipt.php',$data,true);
			 $this->load->library('m_pdf'); 
			 $file_name = $full_name."_".$order_id.".pdf";
			 $pdfFilePath = $file_name;
			 $this->m_pdf->pdf->WriteHTML($html);
			 $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
		 }else{
			  redirect(base_url().'login');
		 }
	}
	
	public function download_notes_spredsheet($user_course_id,$video_id)
	{
		 if($this->current_user_id!=0)
		 {
			 $data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			 if($user_course[0]['user_id'] == $this->current_user_id)
			 {
				 $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1); 
				 $course_name = trim($course_details[0]['course_name']);  
				 $course_name = str_replace(' ','_',$course_name);
				 $course_notes = $this->customer_mod->get_user_course_notes_spread_sheet($this->current_user_id,$user_course_id,$video_id); 
				 
				 $this->load->library('excel');
				 $this->excel->setActiveSheetIndex(0);
				 $this->excel->getActiveSheet()->setTitle($this->current_user_id."_notes_".$user_course_id);
				 $this->excel->getActiveSheet()->fromArray($course_notes);
				 $filename =  $course_name.'_'.$user_course_id.'.xls';
       			 header('Content-Type: application/vnd.ms-excel'); 
        		 header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        		 header('Cache-Control: max-age=0');
       			 $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
        		 $objWriter->save('php://output'); 
			 }else{
				 redirect(base_url().'mycourses');
			 }
		 }else{
			  redirect(base_url().'login');
		 }
	}
	
	public function download_notes_pdf($user_course_id,$video_id)
	{
		 if($this->current_user_id!=0)
		 {
			 $data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			 
			 if($user_course[0]['user_id'] == $this->current_user_id)
			 {
				 $data['course_notes'] = $this->customer_mod->get_user_course_notes($this->current_user_id,$user_course_id,$video_id); 
				 $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1); 
				 $data['course_name'] = trim($course_details[0]['course_name']); 
				 $html = $this->load->view('notes_layout.php',$data,true);
				 $this->load->library('m_pdf'); 
				 $file_name = $this->current_user_id."_notes_".$user_course_id.".pdf";
				 $pdfFilePath = $file_name;
				 $this->load->library('m_pdf'); 
				 $this->m_pdf->pdf->WriteHTML($html);
				 $this->m_pdf->pdf->Output($pdfFilePath, "D"); 
			 }else{
				  redirect(base_url().'mycourses');
			 }
		 }else{
			  redirect(base_url().'login');
		 }
	}
	
	public function download_certificate($user_course_id,$pdf_name)
	{
		 if($this->current_user_id!=0)
		 {
		     $data['page_title'] = 'Certificate | CPENATION';
			 $data['cuserid'] = $this->current_user_id;
			 $data['course_state'] = $this->current_state;
			 $data['user_course'] = $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
			 
			 if($user_course[0]['user_id'] == $this->current_user_id)
			 {
			 
			     $data['user_course_id'] = $user_course_id;
				 $data['course_details'] = $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1);
				 $customer_details = $this->customer_mod->get_customer_details($this->current_user_id);
				 $data['full_name'] = $customer_details[0]['first_name'].' '.$customer_details[0]['last_name'];  
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
							   
						$this->customer_mod->insert_user_credits($this->current_user_id,$creadit_type_id,$mystates_id,$val,$user_course[0]['completed_date'],$user_course_id);
					 }
					 
					 
			     }
				  
				 $data['mycredits'] = $mydata;
				 $course_name = $this->clean_filename($user_course[0]['pdf_name']);
				 
				 $html = $this->load->view('certificate_layout.php',$data,true);
				 $file_name = $course_name."_".$user_course_id.".pdf";
				 $pdfFilePath = FCPATH.'uploads/'.$file_name;
				
				 $this->load->library('m_pdf_new');
				 $this->m_pdf_new->pdf->WriteHTML($html);
				  //download it.
				 ob_clean(); 
				 $this->m_pdf_new->pdf->Output($pdfFilePath, "F"); 
				 //$this->dowload_pdf($pdfFilePath, $file_name);		 
			}else{
				 redirect(base_url().'mycourses');
			}
		 }else{
			 redirect(base_url().'login');
		 }
			  
	}
	
	public function insert_exam_ans($key,$userans_id,$user_course_id,$course_id,$user_id)
	{
		   $data_insert['question_id'] = $key;
		   $data_insert['user_ans_id'] = $userans_id;
		   $data_insert['user_course_id'] = $user_course_id;
		   $data_insert['course_id'] = $course_id;
		   $data_insert['user_id'] = $user_id;
		   $data_insert['exam_date'] = date('Y-m-d');
		   $this->customer_mod->insert_exam_ans($data_insert);
	}
	
	public function check_exam_ans($question_id,$user_ans)
	{
		    $get_correct_ans = $this->customer_mod->get_exam_answer($question_id,$user_ans); //echo '<br>';
			return  $get_correct_ans;
			
	}
	
	public function get_review_correct_ans()
	{
		  $user_course_id = $this->input->post('user_course_id');
		  $chapter_id = $this->input->post('chapter_id');
		  $user_id = $this->current_user_id;
		  $ques_ans = $this->customer_mod->get_correct_ans($user_course_id,$user_id,$chapter_id);
		  echo json_encode($ques_ans);
	}
	
	public function review_correct_ans()  
	{
		  $review_progress_id = $this->input->post('review_progress_id');
		  $review_id = $this->input->post('review_id');
		  $correct_ans_id = $this->input->post('correct_ans_id');
		  $login_user_id = $this->input->post('login_user_id');
		  $user_course_id = $this->input->post('user_course_id');
		  $ajax = $this->input->post('ajax');
		  $chapter_id = $this->input->post('chapter_id');
		  
		  $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
		  $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1);
		  
		  $chapter_count = count($this->course_mod->get_chapters($course_details[0]['course_id'])); 
		  $review_progres_count = $this->customer_mod->chapter_progress_count($course_details[0]['course_id'],$user_course_id,$this->current_user_id,$ajax);
		   
		  $data_inset['user_course_chapter_id'] = $review_progress_id;
		  $data_inset['question_id'] = $review_id;
		  $data_inset['answer_id'] = $correct_ans_id;
		  $data_inset['user_id'] = $login_user_id;
		  $this->customer_mod->insert_review_ans($data_inset);
		  
		   $chapter = count($this->course_mod->get_chapter_questions($chapter_id,$course_details[0]['course_id']));
		   $ans =  count($this->customer_mod->get_review_answers($chapter_id,$user_course_id,$this->current_user_id));
		
		   //echo $chapter." == ".$ans; 	   
			if($chapter == $ans)
			{
				 $this->customer_mod->update_chapter_status($chapter_id,$user_course_id,$this->current_user_id,$course_details[0]['course_id']); 
			}  
		  
		  //echo $chapter_count." == ".$review_progres_count;
		  
		  if($chapter_count == $review_progres_count)
		  {
			  if($chapter == $ans){
				  $this->customer_mod->update_review_exam_course_status($course_details[0]['course_id'],$user_course_id,$this->current_user_id);
				  echo 'complete';exit;
			  }
		  }
	}
	
	
	public function update_percentage()
	{
		  $material_id = $this->input->post('docid');
		  $course_id =  $this->input->post('courseid');
		  $usercourseid = $this->input->post('usercourseid');
		  $user_id = $this->input->post('userid');
		  $type = $this->input->post('type');
		  
		  $percentage = $this->customer_mod->get_percetage($material_id,$course_id,$usercourseid,$user_id,$type);
		  if($percentage[0]['completed_percentage'] == 0)
		  {		  
				  $update = $this->customer_mod->update_percentage($material_id,$course_id,$usercourseid,$user_id,$type);
				  if($update)
				  {  
					 $result = $this->customer_mod->update_course_status($course_id,$usercourseid,$user_id);
				  }
		  }
		  
	}
	
	public function get_doc()
	{
		$file = trim($_GET['file']);
		if($file !=''){
		$filepath = FCPATH.'admin/uploads/pdf/'.$file; 
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header("Content-Type: application/force-download");
			header('Content-Disposition: attachment; filename=' . $file);
			// header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filepath));					
			ob_clean();
			flush();
			readfile($filepath);
			exit;
		}
	 
	} 
	
	public function get_video_details()
	{
		  $material_id = $this->input->post('video_id');
		  $course_id =  $this->input->post('course_id');
		  $user_course_id = $this->input->post('user_course_id');
		  $user_id = $this->input->post('user_id');
		  $type = $this->input->post('type');
		  
		  $percentage = $this->customer_mod->get_percetage($material_id,$course_id,$user_course_id,$user_id,$type);
		  echo json_encode($percentage); 
	}
	
	public function tracking_video()
	{
			$material_id = $this->input->post('video_id');
		    $course_id =  $this->input->post('course_id');
			$user_course_id = $this->input->post('user_course_id');
			$user_id = $this->input->post('user_id');
			$type = $this->input->post('type');
			$current_percentage = $this->input->post('percentage');
			$played_time = $this->input->post('played_time');
			$video = $this->customer_mod->store_video_details($material_id,$course_id,$user_course_id,$user_id,$type,$current_percentage,$played_time);
	}
	
	public function feedback()
	{
	     $course_id = $this->input->post('course_id');
		 $feed_back = trim($this->input->post('feed_back'));
		 $user_id = $this->input->post('user_id');
		 
		 $user_details = $this->customer_mod->get_customer_details($user_id);
		 $fullname = trim($user_details[0]['first_name'].' '.$user_details[0]['last_name']);
		 $user_email = trim($user_details[0]['email']);
		 
		 $course_details = $this->course_mod->get_course_details($course_id,1);
		 $authors_details = $this->course_mod->get_course_faculties($course_details[0]['course_author']); 
		 
		 			$TO = 'eluminous_sse22@eluminoustechnologies.com';
					$SUBJECT = "Feedback  - ".$fullname;
					$Header = 'MIME-Version: 1.0' . "\r\n";
					$Header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$html ='<table border="0" cellspacing="0" cellpadding="0" style="background:#eaeaea; max-width:800px; width:100%; padding:0px 15px;" align="center">
							  <tr>
								<td style="background:#fff;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td style="text-align: justify; padding: 5%">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td> Dear Author <br/><br/> Following feedback related to '.trim($course_details[0]['course_name']).' course.<br/>
											  <br/>
											  <p>'.$feed_back.'</p>
											  <br/>
											  </td>
											  </tr>
											  </table>
											  </td>
											  </tr>
											  </table>
											  </td>
                  </tr>
                  </table>';
				  
				 
				  	$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('help@cpenation.com', 'CPE Nation');
					$this->email->reply_to($user_email, $fullname);
					//$this->email->from('info@cpenation.com', 'CPE Nation');
					foreach($authors_details as $key => $authorsVal)
	     			{
						 if(isset($authorsVal['email']) && $authorsVal['email']!='')
						 {
							$this->email->to(trim($authorsVal['email']));
							//$this->email->to($TO);
							$this->email->subject($SUBJECT);
							$this->email->message($html);
							$email_result = $this->email->send();
						 }
					}
					
					if($email_result){
						echo "success";
					}else{
						echo "failed";
					}	
		 
	}

//start login function
    public function login()
	{
	    $data['page_title'] = 'Login | CPE Nation';
		//$data['error_text'] = '';
		//$data['username'] = '';
		if(trim($this->input->post('submit')) == '')
		{       
			$this->template->load('layouts/default_layout.php','customer/login.php',$data); 
		}
		elseif(trim($this->input->post('submit')) == 'login')
		{
			//echo "<pre>";print_r($this->input->post());die;
		    $this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{   
				$this->load->view('customer/login.php');
				
			}else{
			
			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			
			$return   = $this->customer_mod->check_login($username,$password);
			
			if(sizeof($return) > 0)
			{
				
				if(isset($this->session->userdata['order_id']))
				{   
				        //echo $this->session->userdata['order_id'];die;
					   $delet_ordid 	=$this->session->userdata['order_id'];
				     
					   $last_order   = $this->customer_mod->check_user_order($this->session->userdata['user_id']);	
					  // echo "<pre>";print_r($last_order); die;
						if(sizeof($last_order) > 0)
						{
							
						  $cart_count   = $this->customer_mod->check_user_order_items($last_order[0]['order_id']);
						 // echo "<pre>";print_r($cart_count);
						  $last_ordcnt = count($cart_count);	
						 
						  $session_order   = $this->customer_mod->check_user_order_items($this->session->userdata['order_id']);
						 // echo "<pre>";print_r($session_order);
						  if(count($session_order) > 0)
							{  
							   $sess_cnt = count($session_order);
							  
							   for($i=0; $i < $sess_cnt; $i++)	
							   {    
							        $updateid[]=$session_order[$i]['id'];
								    for($j=0; $j < $last_ordcnt; $j++) 
									{
							//echo $session_order[$i]['purchase_type'].'>>'.	$cart_count[$j]['purchase_type'].'---'.$session_order[$i]['course_id'].'<<'.$cart_count[$j]['course_id'];	
					if(($session_order[$i]['purchase_type'] == $cart_count[$j]['purchase_type']) && ($session_order[$i]['course_id'] == $cart_count[$j]['course_id']))
								{
										
									$delid[]=$session_order[$i]['id'];
						     //$cart_count = $this->customer_mod->update_ordercourse($session_order[$i]['id'],$cart_count[$j]['order_id']);
									
								}
										
									} 
									
							   }
							 
							    if(sizeof($delid) > 0)
								{
							     $final_update = array_merge(array_diff($delid, $updateid), array_diff($updateid, $delid));
								}
								else{
									
									$final_update  = $updateid;
								}
								//echo "<pre>";print_r($final_update);die;
							    $newcnt = $last_ordcnt + sizeof( $final_update);
							    $cart_count = $this->customer_mod->update_ordercourse($final_update,$last_order[0]['order_id']);
							  
							   //echo "<pre>";print_r($final_delt);die;
							   $this->session->set_userdata('cart_count', $newcnt);
							}
							
							
							$del_details = $this->customer_mod->get_user_orders($delet_ordid);
							$del_order_total = 0;
							$del_order_tax = 0;
							foreach($del_details as $valdel)
							{
								 $del_order_total += $valdel['order_total'];
								 $del_order_tax += $valdel['order_tax'];
							}
							
							$last_order_details = $this->customer_mod->get_user_orders($last_order[0]['order_id']);
							
							$last_order_total = 0;
							$last_order_tax = 0;
							
							foreach($last_order_details as $vallast)
							{
								 $last_order_total += $vallast['order_total'];
								 $last_order_tax += $vallast['order_tax'];
							}
							
							
							$new_order_total = ($del_order_total + $last_order_total);
							$new_order_tax = ($del_order_tax + $last_order_tax);
							
							
							$this->customer_mod->delete_user_orderid($this->session->userdata['user_id'],$delet_ordid);
							$this->session->set_userdata('order_id', $last_order[0]['order_id']);
							$id=$return[0]['id'];
							$this->customer_mod->update_cart_user_course($id,$new_order_total,$new_order_tax,$this->session->userdata['order_id']);	
							 
						}else{	
							$id=$return[0]['id'];
							$this->customer_mod->update_cart($id,$this->session->userdata['order_id']);	
						}
				}
				else{
						$last_order   = $this->customer_mod->check_user_order($this->session->userdata['user_id']);	
						if(sizeof($last_order) > 0)
						{
							
							$this->session->set_userdata('order_id', $last_order[0]['order_id']);
							$id=$return[0]['id'];
							$this->customer_mod->update_cart($id,$this->session->userdata['order_id']);
							$cart_count   = $this->customer_mod->check_user_order_items($last_order[0]['order_id']);
							//echo "<pre>";print_r($cart_count);die;
							if(sizeof($cart_count) > 0)
							{
							   $cnt = sizeof($cart_count);
							   $this->session->set_userdata('cart_count', $cnt);
							}
							
						}
					
				}
				
				//echo "tere";die;
				if($this->input->post('page') == 'checkout')
				{  //echo "tere";die;
					redirect('checkout');
				}else{
					redirect('customer_con/get_order_details');
				}
			}else{
				if($this->input->post('page') == 'checkout')
				{		
					   $arr_msg = array('error_msg'=>'Email or Password is incorrect!'); 
					   $this->session->set_userdata($arr_msg);
					   redirect('checkout');
				}else{
					
					//$error_array = array("error_text"=>'Email or Password is incorrect!');
					$data['error_text'] = 'Email or Password is incorrect!';
					$data['username'] = trim($this->input->post('username'));
					//echo <pre>;print_r($data);die;
					$this->template->load('layouts/default_layout.php','customer/login.php',$data); 
				}
				//$this->load->view('customer_con/login',$error_array);
			}
		}
		
		}
			
}

//end login function	

//forgot password
 public function forgotpassword()
 {
	  
	   if(trim($this->input->post('submit')) == 'RESET PASSWORD')
		{
			   $usercnt = $this->customer_mod->get_customer_from_field('email',trim($this->input->post("forgotmail")));
				 //echo '11111<pre>';print_r($usercnt);die;
				
				if(count($usercnt) > 0)
				{
			      	
				  	$fullname = $usercnt[0]['first_name'].' '.$usercnt[0]['last_name']; 
					
				 	$email=$this->input->post("forgotmail");
					$code =md5(time());
					$this->customer_mod->update_token($email,$code);
					$TO = $email;
					$SUBJECT = "Change Password";
					$Header = 'MIME-Version: 1.0' . "\r\n";
					$Header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					$mydata['first_name'] = trim($usercnt[0]['first_name']);
					$mydata['code'] =  $code;
					
					$myhtml = $this->load->view('email_template/reset_password.php',$mydata,true);
				  	$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('info@cpenation.com', 'cpenation');
					$this->email->to($email);
					$this->email->subject($SUBJECT);
					$this->email->message($myhtml);
					//echo "<pre>";print_r($myhtml);die;
					$result1=$this->email->send();
				  if($this->input->post('page') == 'checkout')
				  {
					   	$arr_msg = array('error_msg'=>'We have sent you password reset instructions.'); 
					   	$this->session->set_userdata($arr_msg);
					   	redirect('checkout');
				  }else{
					   
				   		$error_array = array("error_text"=>'We have sent you password reset instructions.');
				   		$this->template->load('layouts/default_layout.php','customer/login.php',$error_array); 
				  }
				}
				else
				{
					if($this->input->post('page') == 'checkout')
				    {
						$arr_msg = array('error_msg'=>'Email doesn\'t exist.'); 
					    $this->session->set_userdata($arr_msg);
					    redirect('checkout');
					}else{
			     	 	$error_array = array("error_text"=>'Email doesn\'t exist.');
					 	$this->template->load('layouts/default_layout.php','customer/login.php',$error_array); 
					}
				}
			
		}
 }
//end forgot password

//reset  password

public function resetpassword($token)
{     
    
     $data['page_title'] = 'Reset Password | CPE Nation';
	 $chkuser=$this->customer_mod->get_customer_from_field('token',$token);
	 //echo "<pre>";print_r($chkuser);die;
	 $cnt=count( $chkuser);
	 //echo "<pre>";print_r($chkuser);die;
	  if($cnt == 0)
	  {  
		  $data['resetlink']= "expire";
		  //print_r($data);die;
		  $this->template->load('layouts/default_layout.php','customer/reset_password.php',$data);  
	  }
	  if(count($chkuser) > 0)
	  {  $data['resetlink']= "";
		 $data['custid']=$chkuser[0]['id'];
		 $data['email']=$chkuser[0]['email'];
		 $this->template->load('layouts/default_layout.php','customer/reset_password.php',$data);  
	  }
	    
		    if(trim($this->input->post('submit')) == 'reset')
			{ 
			  $custid			= trim($this->input->post('custid'));
			  $email			= trim($this->input->post('email'));
			  $password 		= trim($this->input->post('password'));
			  $confirmpassword  = trim($this->input->post('confpassword'));	
			  
			  $this->form_validation->set_rules('password', 'password', 'trim|required');
		      $this->form_validation->set_rules('confpassword', 'confirm password', 'trim|required|matches[password]');
		  
		  
				if ($this->form_validation->run() == FALSE)
				{  
					$data['custid'] = $custid;
					$data['error_text'] = 'enter valid password';
				    $this->template->load('layouts/default_layout.php','customer/reset_password.php',$error_array);  
				}
				else
				{    
					 $data_update['password']=md5($password);
					 $data_update['token']='';
				   	 $updatepassword=$this->customer_mod->reset_password($data_update,$custid); 
					 
					 $arr_session = array('user_id'=> $custid,
										   'user_email'=> $email,
										   'is_login'=>'1'
										   );	
			         $this->session->set_userdata($arr_session);		
					redirect('customer_con/get_order_details'); 	
				}
			}
			  $token = trim($token);
			if($token =='')
			{   
		  		$data['error_msg']="Incorrect Token";
			
		 	}
			 //$this->template->load('layouts/default_layout.php','customer/reset_password.php',$data);  
		 
		
}
//end reset password
//start change password function

	public function change_password()
	{ 
		 if($this->session->userdata('custid')!="")
		 {
			$data['pagetitle'] = 'Change Password'; 
			$custid = $this->session->userdata('custid');
			
			if($this->input->post('submit')=='Save')
			{
				$old_pwd = trim($this->input->post('old_pwd'));
				$new_pwd = trim($this->input->post('new_pwd'));
				$confirm_pwd = trim($this->input->post('confirm_pwd'));
				if($new_pwd == $confirm_pwd)
				{
					$return   = $this->login_mod->change_password($userid,$old_pwd,$new_pwd);
					if($return == true)
					{
						$data['suc_msg'] = 'Password changed successfully!';
					}
					else
					{
						$data['err_msg'] = 'Old password is incorrect!';
					}
					
				}else
				{
					$data['err_msg'] = 'New password and Confirm password is not same!';
				}
				$this->template->set_layout('admin_default')->build('login/change_password',$data); 
			}else{
				$this->template->set_layout('admin_default')->build('login/change_password',$data);
			}
		 }else{
			 redirect(base_url().'login');
		 }
	}
	
//end change password function	
	
//Start Customer registration function	
	public function registration()
	{  
	   
		$data['page_title'] = 'Registration | CPE Nation';
		if($this->session->userdata('err_msg') != '')
		{
				$data['err_msg'] = $this->session->userdata('err_msg');
				$this->session->unset_userdata('err_msg');
		}
		$data['data_register'] = '';
		if(trim($this->input->post('mysubmit')) == '')
		{       
		  
		  $this->template->load('layouts/default_layout.php','customer/registration.php',$data);  
		}
		elseif(trim($this->input->post('mysubmit')) == 'registration')
		{   
		   
			$this->form_validation->set_rules('email', ' Email', 'required|valid_email');
			$this->form_validation->set_rules('password', ' Password', 'required');
			$this->form_validation->set_rules('fname', ' First Name', 'required');
			$this->form_validation->set_rules('lname', ' Last Name', 'required');
			$this->form_validation->set_rules('selected_states', 'State', 'required');
			
	
			$data_registr['email'] = trim($this->input->post('email'));
			$data_registr['first_name'] = trim($this->input->post('fname'));
			$data_registr['last_name'] = trim($this->input->post('lname'));
			
			
			 if ($this->form_validation->run($this) == FALSE)
			 {
				 if($this->input->post('selected_states') == '')
				 {
					//$arr_msg = array('err_msg'=>'Please select atleast one state.');
					//$data_registr['data_err']='Please select atleast one state.'; 
				   	//$this->session->set_userdata($arr_msg); 
				 }
				 //$this->template->set_layout('admin_default')->build('customer/registration',$data);
				 $data['data_register'] = $data_registr;	 
				$this->template->load('layouts/default_layout.php','customer/registration.php',$data); 
				  //redirect('customer_con/registration');
		     }else if(count($this->customer_mod->already_exists(trim($this->input->post('email')))) > 0){ 
			       if($this->input->post('ajax_login'))
				   {
					    echo 'email_exits'; die;
				   }else{
				   		$arr_msg = array('err_msg'=>'Email already exists. Please enter another one.'); 
				   		$this->session->set_userdata($arr_msg);
						
				   	    //redirect('customer_con/registration');
						$data_registr['email']='';
						$data_registr['data_err']='Email already exists. Please enter another one.';
						$data['data_register'] = $data_registr;	 
						$this->template->load('layouts/default_layout.php','customer/registration.php',$data); 
						
				   }
			 } 
			 else
			 {
				 $usrname	= trim($this->input->post('email'));
				 $password	= trim($this->input->post('password'));
				 $to = $email = trim($this->input->post('email'));
				 $data_insert['username'] = trim($this->input->post('email'));
				 $data_insert['password'] = md5(trim($this->input->post('password')));
				 $data_insert['str_password'] = '';
				 $data_insert['email'] = trim($this->input->post('email'));
				 $data_insert['first_name'] = trim($this->input->post('fname'));
				 $data_insert['last_name'] = trim($this->input->post('lname'));
				  if($this->input->post('ajax_login'))
				   {
				 		$data_insert['state'] = implode(',',$this->input->post('course_state'));
				   }else{
					    $data_insert['state'] = trim($this->input->post('selected_states'));
				   }
				 $data_insert['certifications'] = implode(',',$this->input->post('certifications'));
				 $data_insert['created'] = date('Y-m-d H:i:s');
				 $data_insert['modified'] = date('Y-m-d H:i:s');
				 $data_insert['tracker_startdate'] = date('Y-m-d H:i:s');
				 $data_insert['tracker_enddate'] = date('Y-m-d',strtotime(date('Y-m-d') . " + 1 year"));
				 $data_insert['active'] = '1';	
				
				
				$stateids =  trim($this->input->post('selected_states'));
				 //echo "<pre>";print_r($data_insert);die;
				 $id = $this->customer_mod->add_customer($data_insert);
				 $tracker_date = $this->customer_mod->user_credit_daterenge($id,$stateids);
				 if($id > 0)
				 {
					
					$from='info@cpenation.com';
					
					$subject="CPE Nation: Account created successfully";
					$mydata['first_name'] = $data_insert['first_name'];
					$mydata['username'] =  $usrname;
					$mydata['password'] =  $password;
					$mydata['last_name'] = $data_insert['last_name'];
					$mydata['e_mail'] =  $data_insert['email'];
					$mydata['designations'] = $data_insert['certifications'];
					
					$myhtml = $this->load->view('email_template/registration.php',$mydata,true);		
					$adminSubject="CPE Nation: A user registered";
					$adminMessage="Hello Admin <br> A user '".$data_insert['first_name']."' '".$data_insert['last_name']."' registered successfully on CPE Nation.<br>
					Below given are the Details,<br><br> 
					<b>Name:</b>'".$data_insert['first_name']."' '".$data_insert['last_name']."'<br/>
					<b>Email:</b>'".$usrname."'<br/>
					<b>Password:</b>'".$password."'<br/><br>Thank You<br>CPE Nation Team";
					
					
					$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('info@cpenation.com', 'CPE Nation');
					$this->email->to($to);
					$this->email->subject($subject);
					$this->email->message($myhtml);
					$result1=$this->email->send();
					
					$admin_detail=$this->customer_mod->get_admin_email();
					$admin_email=$admin_detail[0]['email'];
					
					$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('info@cpenation.com', 'CPE Nation');
					$this->email->to($admin_email);
					$this->email->subject($adminSubject);
					$this->email->message($myhtml);
					$result=$this->email->send();
					
					$arr_user_data = array('user_id'=> $id,
										   'user_email'=> $email,
										   'is_login'=>'1',
										   'user_name'=> trim($this->input->post('fname'))
										   );
				   $this->session->sess_expiration = 172800; 							   
				   $this->session->set_userdata($arr_user_data);
				   
				   
				   
				   if(isset($this->session->userdata['order_id'])){
					   $this->customer_mod->update_cart($id,$this->session->userdata['order_id']);
		  		   }
				   
				   
				   	  echo 'success';
				 }else{
					 if($this->input->post('ajax_login'))
				     {
						echo 'failed'; 
					 }else{
					    $arr_msg = array('err_msg'=>'Failed to Registration');
					 }
				 }
				 if($this->input->post('ajax_login'))
				 {
				 }else{
				 	$this->session->set_userdata($arr_msg);
				 	redirect(base_url());
				 }
			 }
		
		}
		
		
	}
	//End Customer registration function
	
	public function logout()
	{
			$arr_user_data = array( 'user_id'=>'',
									'user_email'=>'',
									'user_lawyer_type'=>'',
									'is_login'=>'0',
									'user_name'=>''
								  );
			$this->session->set_userdata($arr_user_data);
			session_start();
			$_SESSION['user_name'] =	'';
			session_destroy();
			if($_GET['page'] == 'checkout')
			{
				redirect(base_url().'checkout');
			}else{
				redirect(base_url());	
			}
	}	
	
	public function get_order_details()
	{  //echo "<pre>";print_r($this->input->post());die;	
		//echo 111;die;
		$stardate = $enddate = '';
		$data['sider_bar'] = 'orders';
	   if($this->current_user_id != 0)
		 {
		 
		   $userid = $this->current_user_id;
		   $stardate= $enddat='';
	    if($this->input->post('submit') != '')
		{ 
	      //echo "<pre>";print_r($this->input->post());die;	
		  $stardate=trim($this->input->post('fromdate'));
		  $enddate=trim($this->input->post('enddate'));
		  
		}
	    $data['page_title'] = 'Order | CPE Nation';
		$data['stardate'] = $stardate;
		$data['enddate'] = $enddate;
		$data['custid'] = $userid;
		$data['result'] = 'false';
		//$data['customer_order'] = $this->customer_mod->get_order_details($userid);
		$data_order = $this->customer_mod->get_order_details($userid,$stardate,$enddate);
		//echo "<pre>";print_r($data_order);die;
		$orderData= array();
		$where='';
		
		//foreach ($data_order as $key)
		for($j=0; $j<(count($data_order)) ;$j++)
		{
			$data['result'] = 'true';
			$data_order1 = $this->customer_mod->get_order_courses($data_order[$j]['order_id']);
			//echo "<pre>";print_r($data_order1);die;
			$orderData[$j]['order_id']=$data_order[$j]['order_id'];
			$orderData[$j]['order_no']=$data_order[$j]['order_number'];
			$orderData[$j]['order_date']=$data_order[$j]['order_date'];
			$orderData[$j]['order_tax']=$data_order[$j]['order_tax'];
			$orderData[$j]['discount']=$data_order[$j]['discount'];
			$orderData[$j]['ordertotal']=$data_order[$j]['order_total'];
			//get order items from order_courses table
			
			for($i=0; $i<(count($data_order1)) ;$i++)
			{    $totalcredit=0;
				 $type = $data_order1[$i]['purchase_type'];
				 $cid =  $data_order1[$i]['course_id'];
					if($type =='Bundle')
					{
						 $stateid = $this->customer_mod->get_order_states($cid,$data_order[$j]['order_id'],'Bundle');
						 
						 //echo "<pre>";print_r($stateid);die;
						 if(sizeof($stateid) > 0)
						 {
								 foreach($stateid as $state)
									 {
										 $course_course_credit		=	json_decode($state['course_credits'],true);
										 $course_state				=	$state['course_state'];
									   if (array_key_exists($course_state, $course_course_credit))
										{
										   foreach($course_course_credit[$course_state] as $credits)
											{  
														  $totalcredit +=$credits; 
											}
										 }
								 }
							 
						 }
						
						$itemdata[$i]['credit']=$totalcredit;
						$item_name = $this->bundle_mod->get_bundle_details($cid);
						$itemdata[$i]['Type']='Compliance Bundle';
						$itemdata[$i]['name']=$item_name[0]['bundle_name'];
						$itemdata[$i]['itemprice']=$data_order1[$i]['course_amount'];
						
					}
					if($type =='Course')
					 {
						
						 $stateid = $this->customer_mod->get_order_states($cid,$data_order[$j]['order_id']);
						 //echo "<pre>";print_r($stateid);die;
						 $course_course_credit		=	json_decode($stateid[0]['course_credits'],true);
						 $course_state				=	$stateid[0]['course_state'];
						 if (array_key_exists($course_state, $course_course_credit))
						{
						   foreach($course_course_credit[$course_state] as $credits)
							{  
										  $totalcredit +=$credits; 
							}
						 }
						$itemdata[$i]['credit']=$totalcredit;
						 
						$item_name = $this->course_mod->get_course_details($cid);
						$itemdata[$i]['Type']='Self-Study Course';
						$itemdata[$i]['name']=$item_name[0]['course_name'];
						$itemdata[$i]['itemprice']=$data_order1[$i]['course_amount'];
					}
					
					if($type =='Subscription')
					{
						 $item_name = $this->subscription_mod->get_subscription_details($cid);
						 $itemdata[$i]['Type']='Subscription';
						 $itemdata[$i]['name']=$item_name[0]['title'];
						 $itemdata[$i]['itemprice']=$data_order1[$i]['course_amount'];
						 //$itemdata[$i]['credit']= '-';
					}
					
					
					$orderData[$j]['items']=$itemdata;
				}
				//echo "<pre>";print_r($orderData);die;
			
			
		  }
		
		//echo "<pre>";print_r($orderData);die;
		/*for($i=0; $i<(count($data_order)) ;$i++)
		{  
		
		    $type = $data_order[$i]['purchase_type'];
		    $cid =  $data_order[$i]['course_id'];
			
			if($type !='Course')
			{
				$item_name = $this->bundle_mod->get_bundle_details($cid);
				$itemdata[$i]['Type']='Compliance Bundle';
				$itemdata[$i]['name']=$item_name[0]['bundle_name'];
				
			}else{
				$item_name = $this->course_mod->get_course_details($cid);
				$itemdata[$i]['Type']='Self-Study Course';
				$itemdata[$i]['name']=$item_name[0]['course_name'];
				
			}
			
			
			$itemdata[$i]['order_no']=$data_order[$i]['purchase_type'];
			$itemdata[$i]['order_no']=$data_order[$i]['purchase_type'];
		
		}*/
		
		$data['order_details']  =$orderData;
	    //$data['course_inprogress'] = $this->customer_mod->get_user_course_progress($userid,'In-Progress');
		//$data['course_completed'] = $this->customer_mod->get_user_course_progress($userid,'Completed');
	
		$this->template->load('layouts/default_layout.php','customer/order_history.php',$data); 
	  	
	}
}

//my courses
    public function get_total_percentage($data_course_percentage,$review_percentage = 0,$exam_percentage = 0)
	{
		   if(count($data_course_percentage) > 0)
		   {
				foreach($data_course_percentage as $percent)	
						  $percentage +=$percent['completed_percentage'];	
		   }
		   if($percentage > 0)
		   {
				$totalpercent = (($percentage)/(count($data_course_percentage))/2) + ($review_percentage + $exam_percentage);
		   }else{
				$totalpercent = 0;
				
				if($review_percentage == 25){ //tony added this temporarily to deal with changing course content which is causing customers to lose their progress
					$totalpercent = 75;
				}
		   }
			
		  return number_format($totalpercent,0);
	}
	
	public function user_courses()
		{  
		   
		   if($this->current_user_id != 0)
			 {
				    $userid = $this->current_user_id;
					$data['sider_bar'] = 'courses';
					$data['page_title'] = 'My Courses | CPE Nation';
					$data['custid'] = $userid;
					$course_notstarted = $this->customer_mod->get_course_progress($userid,'Not Started');
					//echo "<pre>";print_r($course_notstarted);die;
					$totalcredit=0;
					$course_archive_Data= $course_notstart_Data=$course_inprogress_Data=$course_complete_Data=array();
					for($i=0; $i<(count($course_notstarted)) ;$i++)
					{  $totalcredit=0;
					  
					   $course_notstart_Data[$i]['course_id']			= 	$course_notstarted[$i]['course_id'];
					   $course_notstart_Data[$i]['course_name']			=	$course_notstarted[$i]['course_name'];
					   $course_notstart_Data[$i]['course_price']		=	$course_notstarted[$i]['course_price'];
					   $course_notstart_Data[$i]['order_id']			=	$course_notstarted[$i]['order_id'];
					   $course_notstart_Data[$i]['user_courses_id']     =   $course_notstarted[$i]['id'];  
					   $course_notstart_Data[$i]['course_format']     =   $course_notstarted[$i]['course_format'];
					   $course_notstart_Data[$i]['course_img']     =   $course_notstarted[$i]['course_image'];
					   $course_notstart_Data[$i]['s3_images']     =   $course_notstarted[$i]['s3_images'];
					   $course_notstart_Data[$i]['course_backcor']     =   $course_notstarted[$i]['back_color'];
					   //$course_notstart_Data[$i]['course_credit']		=	'4';
					   
					 
					    $course_course_credit		=	json_decode($course_notstarted[$i]['course_credits'],true);
					    $course_state		=	$course_notstarted[$i]['course_state'];
	 	             
					    
					    
						if (array_key_exists($course_state, $course_course_credit))
						{
						 	   foreach($course_course_credit[$course_state] as $credits)
							   {  
								  $totalcredit +=$credits; 
								}
					    }
						
					   //echo $totalcredit;die;//print_r($course_course_credit);die;
					   
					  $course_notstart_Data[$i]['course_credit']		=	$totalcredit;
					   
					   $faculty=$course_notstarted[$i]['course_author'];
					   $fname ='';
					   $faculty_name = $this->course_mod->get_faculty_name($faculty);
					   
					   foreach($faculty_name as $faculty)
						{
						  $fname.=$faculty;
						}
						
					   $course_notstart_Data[$i]['faculty_name']=$fname;
					}
					
					
					$inprogresscredit=0;
					$data_course_inprogress = $this->customer_mod->get_course_progress($userid,'In-Progress');
					//echo "<pre>".$fname;print_r($data_course_inprogress);die;
					for($j=0; $j<(count($data_course_inprogress)) ;$j++)
					{  $inprogresscredit=0;
					   $course_inprogress_Data[$j]['course_id']			= 	$data_course_inprogress[$j]['course_id'];
					   $course_inprogress_Data[$j]['course_name']		=	$data_course_inprogress[$j]['course_name'];
					   $course_inprogress_Data[$j]['course_price']		=	$data_course_inprogress[$j]['course_price'];
					   $course_inprogress_Data[$j]['order_id']			=   $data_course_inprogress[$j]['order_id'];
					   $course_inprogress_Data[$j]['user_courses_id']	=   $data_course_inprogress[$j]['id'];
					   $course_inprogress_Data[$j]['course_format']		=   $data_course_inprogress[$j]['course_format'];
					   $course_inprogress_Data[$j]['course_img']		=   $data_course_inprogress[$j]['course_image'];
					   $course_inprogress_Data[$j]['s3_images']			=   $data_course_inprogress[$j]['s3_images'];
					   $course_inprogress_Data[$j]['course_backcor']	=   $data_course_inprogress[$j]['back_color'];
					   //$course_inprogress_Data[$j]['course_credit']		=	'4';
					    $user_cid=$data_course_inprogress[$j]['id'];
						$cid=$data_course_inprogress[$j]['course_id'];
						$percentage=$totalpercent=0;
						$data_course_percentage = $this->customer_mod->get_course_percentage($user_cid,$cid);
						
						$totalpercent = $this->get_total_percentage($data_course_percentage,$data_course_inprogress[$j]['review_percentage'],$data_course_inprogress[$j]['exam_percentage']);
						//echo "<pre>".$totalpercent;print_r($data_course_percentage);die;
						$course_inprogress_Data[$j]['completed_percentage'] = $totalpercent;
						$course_course_credit		=	json_decode($data_course_inprogress[$j]['course_credits'],true);
					    $course_state		=	$data_course_inprogress[$j]['course_state'];
	 	             
					    
						if (array_key_exists($course_state, $course_course_credit))
						  {
							  
							   
						 	   foreach($course_course_credit[$course_state] as $credits)
							   {  
								  $inprogresscredit +=$credits; 
								}
						  }
						
					   //echo $totalcredit;die;//print_r($course_course_credit);die;
					   
					  $course_inprogress_Data[$j]['course_credit']		=	$inprogresscredit;
					   
					   $faculty1=$data_course_inprogress[$j]['course_author'];
					   $fname ='';
					   $faculty_name = $this->course_mod->get_faculty_name($faculty1);
					   foreach($faculty_name as $faculty)
						{
						  $fname.=$faculty;
						}
						//echo "<pre>".$fname;print_r($faculty_name);die;
					   $course_inprogress_Data[$j]['faculty_name']=$fname;
					}
					
					 $completecredit=0;	
					$data_course_completed = $this->customer_mod->get_course_progress($userid,'Completed','notarchive');
					//echo "<pre>";print_r($data_course_completed);die;
					for($k=0; $k<(count($data_course_completed)) ;$k++)
					{
					   $completecredit=0;	
					   $course_complete_Data[$k]['course_id']					= 	$data_course_completed[$k]['course_id'];
					   $course_complete_Data[$k]['course_name']					=	$data_course_completed[$k]['course_name'];
					   $course_complete_Data[$k]['course_name_clean']			=   $this->clean_filename($data_course_completed[$k]['pdf_name']);
					   $course_complete_Data[$k]['course_price']				=	$data_course_completed[$k]['course_price'];
					   $course_complete_Data[$k]['course_complete_date']		=	$data_course_completed[$k]['completed_date'];
					   $course_complete_Data[$k]['order_id']					=   $data_course_completed[$k]['order_id'];
					   $course_complete_Data[$k]['user_courses_id']				=   $data_course_completed[$k]['id'];
					   $course_complete_Data[$k]['course_format']				=   $data_course_completed[$k]['course_format'];
					   $course_complete_Data[$k]['course_img']					=   $data_course_completed[$k]['course_image'];
					   $course_complete_Data[$k]['course_backcor']				=   $data_course_completed[$k]['back_color'];
					   $course_complete_Data[$k]['pdf_name']				    =   $data_course_completed[$k]['pdf_name'];
					   $course_complete_Data[$k]['s3_images']				    =   $data_course_completed[$k]['s3_images'];
					   $course_complete_Data[$k]['s3_course_certificate']	    =   $data_course_completed[$k]['s3_course_certificate'];
					   
					    $course_course_credit		=	json_decode($data_course_completed[$k]['course_credits'],true);
					    $course_state		=	$data_course_completed[$k]['course_state'];
	 	             
					    
						if (array_key_exists($course_state, $course_course_credit))
						  {
							  
							   
						 	   foreach($course_course_credit[$course_state] as $credits)
							   {  
								  $completecredit +=$credits; 
								}
						  }
						
					   //echo $totalcredit;die;//print_r($course_course_credit);die;
					   
					  $course_complete_Data[$k]['course_credit']		=	$completecredit;
					   
					   $faculty1=$data_course_completed[$k]['course_author'];
					   $fname ='';
					   $faculty_name = $this->course_mod->get_faculty_name($faculty1);
					   foreach($faculty_name as $faculty)
						{
						  $fname.=$faculty;
						}
						//echo "<pre>".$fname;print_r($faculty_name);die;
					   $course_complete_Data[$k]['faculty_name']=$fname;
					}
			
					
					$archivecredit=0;
					$data_coursearchive = $this->customer_mod->get_course_progress($userid,'Completed','archive');
					$cnt_arrcive=count($data_coursearchive);
					//echo "<pre>";print_r($data_coursearchive);die;
					for($l=0; $l < $cnt_arrcive; $l++)
					{
					   $archivecredit=0;	
					   $course_archive_Data[$l]['course_id']			= 	$data_coursearchive[$l]['course_id'];
					   $course_archive_Data[$l]['course_name']			=	$data_coursearchive[$l]['course_name'];
					   $course_archive_Data[$l]['course_price']			=	$data_coursearchive[$l]['course_price'];
					   $course_archive_Data[$l]['order_id']				=	$data_coursearchive[$l]['order_id'];
					   $course_archive_Data[$l]['user_courses_id']      =   $data_coursearchive[$l]['id']; 
					   $course_archive_Data[$l]['course_format']      	=   $data_coursearchive[$l]['course_format']; 
					   $course_archive_Data[$l]['course_img']      		=   $data_coursearchive[$l]['course_image'];
					   $course_archive_Data[$l]['s3_images']      		=   $data_coursearchive[$l]['s3_images'];  
					   $course_archive_Data[$l]['course_backcor']      	=   $data_coursearchive[$l]['back_color']; 
					   $course_archive_Data[$l]['pdf_name']				=   $data_coursearchive[$l]['pdf_name'];
					   $course_archive_Data[$l]['s3_course_certificate'] =   $data_coursearchive[$l]['s3_course_certificate'];
					   
					    $course_course_credit		=	json_decode($data_coursearchive[$l]['course_credits'],true);
					    $course_state				=	$data_coursearchive[$l]['course_state'];
	 	              //echo $totalcredit;die;//print_r($course_course_credit);die;
					    
						if (array_key_exists($course_state, $course_course_credit))
						  {
							  
							   
						 	   foreach($course_course_credit[$course_state] as $credits)
							   {  
								  $archivecredit +=$credits; 
								}
						  }
						
					   //echo "<pre>";print_r($course_archive_Data);die;
					   
					  $course_archive_Data[$l]['course_credit']		=	$archivecredit;
					   
					   $faculty1=$data_coursearchive[$l]['course_author'];
					   $fname ='';
					   $faculty_name = $this->course_mod->get_faculty_name($faculty1);
					   foreach($faculty_name as $faculty)
						{
						  $fname.=$faculty;
						}
						//echo "<pre>".$fname;print_r($faculty_name);die;
					   $course_archive_Data[$l]['faculty_name']=$fname;
					}
					
					$data['course_archive']	= $course_archive_Data;
					$data['course_not_started']=$course_notstart_Data;
					$data['course_inprogres']=$course_inprogress_Data;
					
					$data['course_complete']=$course_complete_Data;
					
				 //echo "<pre>";print_r($data['course_complete']);die;
					$this->template->load('layouts/default_layout.php','customer/my_courses.php',$data); 			 
			}else{
				redirect(base_url().'login'); 
			}
		}


		public function user_setting()
		 {
			// echo 111;die;
			 $data['page_title'] = 'My Account | CPE Nation';
			 $data['sider_bar']='setting';
		     $suc_msg='';
			if(isset($this->current_user_id) && $this->current_user_id!=0)
			{
				
			    if(trim($this->input->post('submit')) =='save')
				{
				  //echo "<pre>"; print_r($this->input->post());die;	
				  	$this->form_validation->set_rules('emailid', ' Email', 'required|valid_email');
					$this->form_validation->set_rules('fname', ' First Name', 'required');
					$this->form_validation->set_rules('lname', ' Last Name', 'required');
			        
					 if ($this->form_validation->run($this) == FALSE)
					 {
						 //$this->template->set_layout('admin_default')->build('customer/registration',$data);
					 }	
					 else
					 {
						 $uid=$this->current_user_id;
					     $data_update['first_name']	= trim($this->input->post('fname'));
				 		 $data_update['last_name']	= trim($this->input->post('lname'));	 
						 $data_update['email']	= trim($this->input->post('emailid'));	
						 $data_update['state'] = trim($this->input->post('selected_states')); 
						 $data_update['certifications'] = implode(',',$this->input->post('certifications'));
						 $data_update['modified'] = date('Y-m-d H:i:s');
						
						 $custid = $this->customer_mod->update_user($data_update,$uid);
						 
						 $curr_state = explode(',',trim($this->input->post('selected_states')));
						 $prev_state = explode(',',trim($this->input->post('prev_states')));
						 
						$delete_state = array_diff($prev_state, $curr_state);
						$insert_state = array_diff($curr_state, $prev_state);
						 
						 if(count($delete_state) > 0)
						 {
							 foreach($delete_state as $delt) 
							 {
								   $id = $this->customer_mod->delete_user_renge($delt,$uid);
							 }
						 }
						 
						 if(count($insert_state) > 0)
						 {
							
						   $id = $this->customer_mod->user_credit_daterenge($uid,implode(',',$insert_state));
							
						 }
						 
						 
						 
						  if($custid > 0){
						   $suc_msg = 'Succesfully updated account setting';
					 		}else{
						 			$suc_msg = '';
					 			}
						 }
				}
				
					if(trim($this->input->post('mysubmit')) =='save')
					{
						//echo "<pre>";print_r($_POST);die;
						$this->form_validation->set_rules('firm_size', ' Firm Size', 'required');
						
						 if ($this->form_validation->run($this) == FALSE)
						 {
							 //$this->template->set_layout('admin_default')->build('customer/registration',$data);
							// $this->template->load('layouts/default_layout.php','customer/my_setting.php',$data); 
						 }	
						 else
						 {
							 $uid=$this->current_user_id;
							
							 $data_update['firm_size']	= trim($this->input->post('firm_size'));
							 if($this->input->post('preferred_course')!='')
							 {
								 $data_update['preferred_course'] = implode(',',$this->input->post('preferred_course'));
							 }else{
								 $data_update['preferred_course'] = '';
							 }
							 if($this->input->post('interest_area') !='')
							 {
								 $data_update['interest_area'] = implode(',',$this->input->post('interest_area'));
							 }else{
							$data_update['interest_area']='';	 
							}
							 $data_update['modified'] = date('Y-m-d H:i:s');
							 //echo "<pre>";print_r($data_update);die;
							 $custid = $this->customer_mod->update_user($data_update,$uid);
							 
							  if($custid > 0){
							    $suc_msg = 'Succesfully updated account setting';
								}else{
										$suc_msg = '';
									}
							 }	
					}
					
					if(trim($this->input->post('mypassword')) =='save')
					{
						$uid=$this->current_user_id;
					  $old_pwd = trim($this->input->post('oldpassword'));
					  $new_pwd = trim($this->input->post('password'));
						
								$return   = $this->customer_mod->change_password($uid,$old_pwd,$new_pwd);
								if($return == true)
								{
									$suc_msg =  'Password changed successfully!';
								}
								else
								{
									$suc_msg =  'Old password is incorrect!';
								}
								
							
					}
			   $userid	=	$this->current_user_id;
			   $user_details = $this->customer_mod->get_customer_details($userid);	
			  
			   $data['comm_states'] = $user_details[0]['state'];
			   $states=$user_details[0]['state'];
			   $arrstate = explode(',',$states);
			   $data['push_state'] = $arrstate;
			   $states = $this->customer_mod->get_state_details($arrstate);	
			   //echo "<pre>";print_r($states);die;
			    $data['userinfo'] = $user_details;
			    $data['states'] = $states;
				$data['suc_msg'] = $suc_msg;
			   //echo "<pre>";print_r($user_details);die;
			   
			   $this->template->load('layouts/default_layout.php','customer/my_setting.php',$data); 			
			} 
			else{
				redirect(base_url().'login'); 
			}
			
		 }
		 
		 
	public function my_billing()
	{
		if(isset($this->current_user_id) && $this->current_user_id!=0){
			$date['success_msg']='';
			$data['page_title'] = 'My Billing | CPE Nation';
			$date['sider_bar'] ='billing';
			 $data['cid'] ='';
		  $data['cmonth'] ='';
		  $data['cyear'] = '';
		  $data['cccv'] = '';
		  $data['czip'] = '';
			if(trim($this->input->post('editcard')) !='')
			{
				//echo "<pre>";print_r($this->input->post());die;
				
			          $cardid=trim($this->input->post('edit_cardid'));
			 		  $custid=trim($this->input->post('edit_custid'));
			          $month = trim($this->input->post('edit_card_month'));
					  $year = trim($this->input->post('edit_card_year'));
					  $zip = trim($this->input->post('edit_card_zip'));
					try {	  
				      
					 require_once(APPPATH.'libraries/stripe/Stripe.php'); 
					 Stripe::setApiKey(STRIP_KEY_PHP);
					 
					 
					 $getcustomer = Stripe_Customer::retrieve($custid);
					 //echo "<pre>";print_r($getcustomer);die;	
					 $card = $getcustomer->sources->retrieve($cardid);
					  
					 $card->exp_month = $month;
					 $card->exp_year = $year;
					 $card->address_zip = $zip;
                     
					 $result =$card->save();
					 $date['success_msg']='Card Updated Successfully....';
				  }catch(Exception $e){
					  $data['err_msg']= 'Please check values for Expires or Zip Code.';
				 }	 
			}
			if(trim($this->input->post('mysubmit')) =='registration')
			{
			
				$token = trim($this->input->post('stripeToken'));	
			 $custmoer_details  = $this->customer_mod->get_customer_details($this->current_user_id);
			 
			 if($custmoer_details[0]['stripe_id'] == '')
			 {
			 	$full_name = $custmoer_details[0]['first_name'].' '.$custmoer_details[0]['last_name'];
				$customer = Stripe_Customer::create(array(
		  				"source" => $token,
		  				"description" => $full_name)
					);
					$strip_cust_id = trim($customer->id);
					$this->customer_mod->update_strip_id($strip_cust_id,$this->current_user_id);
			 }
			 else{
				 try {
					$strip_cust_id = $custmoer_details[0]['stripe_id'];
			       require_once(APPPATH.'libraries/stripe/Stripe.php'); 
			    	Stripe::setApiKey(STRIP_KEY_PHP);
				 	$getcustomer = Stripe_Customer::retrieve($strip_cust_id);
			 		$getcustomer->sources->create(array("source" => $token));
			 		$data['success_msg']='Card Added Successfully....';
				   
				setcookie('cokecid', null, -1, '/');
				setcookie('cokemonth', null, -1, '/');
				setcookie('cokeyear', null, -1, '/');
				setcookie('cokecvv', null, -1, '/');
				setcookie('cokezip', null, -1, '/');

				
				 }catch(Exception $e){
					  $body = $e->getJsonBody();
  					  $err  = $body['error'];
					  $data['err_msg']= $err['message'];
					  $data['cid'] = $_COOKIE['cokecid'];
					  $data['cmonth'] = $_COOKIE['cokemonth'];
					  $data['cyear'] = $_COOKIE['cokeyear'];
					  $data['cccv'] = $_COOKIE['cokecvv'];
					  $data['czip'] = $_COOKIE['cokezip'];
					
				
				setcookie('cokecid', null, -1, '/');
				setcookie('cokemonth', null, -1, '/');
				setcookie('cokeyear', null, -1, '/');
				setcookie('cokecvv', null, -1, '/');
				setcookie('cokezip', null, -1, '/');
				
					 //echo "<pre>";print_r($data);
					 //echo "<pre>";print_r($_COOKIE);die;
				 }
			 }
			 
			}
			$data['customers'] = $cdetails = $this->customer_mod->get_customer_details($this->current_user_id);
			$data['custid']=$cdetails[0]['stripe_id'];
			if(isset($cdetails[0]['stripe_id']))
			{
				try {
					 require_once(APPPATH.'libraries/stripe/Stripe.php'); 
					 Stripe::setApiKey(STRIP_KEY_PHP);
					 $getcustomer = Stripe_Customer::retrieve($cdetails[0]['stripe_id']);
					 
					// echo "<pre>";print_r($getcustomer);die;
					 foreach($getcustomer->sources->data as $key => $strip_val)
					 {
						 
						 $card_details[$strip_val->id]['customer'] = $strip_val->customer;
						 $card_details[$strip_val->id]['card_brand'] = $strip_val->brand;
						 $card_details[$strip_val->id]['exp_month'] = $strip_val->exp_month;
						 $card_details[$strip_val->id]['exp_year'] = $strip_val->exp_year;
						 $card_details[$strip_val->id]['last4'] = $strip_val->last4;
						 $card_details[$strip_val->id]['zipcode'] = $strip_val->address_zip;
						 $card_details[$strip_val->id]['name'] = $strip_val->name;
						 $card_details[$strip_val->id]['cardid'] = $strip_val->id;
					 }
					 
					 $data['cards'] = $card_details; 
					 //echo "<pre>";print_r($card_details);die;
				}catch (Exception $e) {
				      $body = $e->getJsonBody();
  					  $err  = $body['error'];
					  $data['err_msg']= $err['message'];
				}
			}
			
			  $data['sider_bar'] ='billing';
			
			  $this->template->load('layouts/default_layout.php','customer/my_billing.php',$data); 	
		}
		else{
				redirect(base_url().'login'); 
			}
	
	}
	
	public function delete_card()
	{       
	         
	         //echo "<pre>";print_r($this->input->post());die;
			//$cardid='card_18npXcFuhlOTH1SPR27d7bdR';
			 //$custid='cus_92FMuFxiY3bKHK';
			 $cardid=trim($this->input->post('card_id'));
			 $custid=trim($this->input->post('cust_id'));
			try {
			
			 require_once(APPPATH.'libraries/stripe/Stripe.php'); 
			 Stripe::setApiKey(STRIP_KEY_PHP);
			 $getcustomer = Stripe_Customer::retrieve($custid);
			 
			$response=$getcustomer->sources->retrieve($cardid)->delete();
			//echo "<pre>";print_r($response);die;
			echo true;
			exit;
			}catch (Exception $e) {
	              $error = '<div class="alert alert-danger">
			  <strong>Error!</strong> '.$e->getMessage().'
			  </div>';
			 
			 echo false;
  }
			
			
	}
	
	public function set_default_card()
	{       
	         
	         //echo "<pre>";print_r($this->input->post());die;
			//$cardid='card_18npXcFuhlOTH1SPR27d7bdR';
			 //$custid='cus_92FMuFxiY3bKHK';
			 $cardid=trim($this->input->post('card_id'));
			 $custid=trim($this->input->post('cust_id'));
			try {
			
			 require_once(APPPATH.'libraries/stripe/Stripe.php'); 
			 Stripe::setApiKey(STRIP_KEY_PHP);
			 $getcustomer = Stripe_Customer::retrieve($custid);
			 
			 $getcustomer->default_source = $cardid;
			 $getcustomer->save();
			//$response=$getcustomer->sources->retrieve($cardid)->delete();
			//echo "<pre>";print_r($response);die;
			echo true;
			exit;
			}catch (Exception $e) {
	              $error = '<div class="alert alert-danger">
			  <strong>Error!</strong> '.$e->getMessage().'
			  </div>';
			 
			 echo false;
  }
			
			
	}
	
	//Function or get my credit 
	public function my_credit($stateid)
	{
		
		$data['page_title'] = 'My Account | CPE Nation';
		$data['sider_bar']='credits';
		$suc_msg='';
		if(isset($this->current_user_id) && $this->current_user_id!=0)
		{
			$user_detail = $this->customer_mod->get_customer_details($this->current_user_id);
			
			 $state_id = $user_detail[0]['state'];
			 $stid= explode(',',$state_id);
			 //echo "<pre>";print_r($stid);die;
			// echo $state_id ;die;
			if(trim($this->input->post('my_submit')) !='')
			{
			 // echo "<pre>";print_r($this->input->post());die;
			    $data['reg_date']= trim($this->input->post('fromdate')); 
			    $data['to_date']= trim($this->input->post('enddate')); 
			    //$data['to_date']= trim($this->input->post('enddate')); 
			    $stateid_post= trim($this->input->post('stateid')); 
				
				//$data_update['tracker_startdate']=trim($this->input->post('fromdate')); 
				//$data_update['tracker_enddate']=trim($this->input->post('enddate')); 
				
				$data_update['start_date']=trim($this->input->post('fromdate')); 
				$data_update['end_date']  =trim($this->input->post('enddate')); 
				
				//$this->customer_mod->update_customer($data_update,$this->current_user_id);
				$this->customer_mod->update_user_state_renage($data_update,$this->current_user_id,$stateid_post);
				
			}
			else{
				
				/*$reg_date=date('Y-m-d',strtotime($user_detail[0]['created']));
				$data['reg_date']= $reg_date;
				$enddate = date('Y-m-d',strtotime(date($reg_date) . " + 1 year"));
				$data['to_date']= $enddate;*/
				
				$reg_date=date('Y-m-d',strtotime($user_detail[0]['tracker_startdate']));
				$data['reg_date']= $reg_date;
				$enddate = date('Y-m-d',strtotime($user_detail[0]['tracker_enddate']));
				$data['to_date']= $enddate;
			}
				
			if($stateid !='')
			{
			 $external_stateid =$stateid;
			 
			 $data['select_state']=$external_stateid;
			}elseif($stateid_post !='')
			{
			 $data['select_state']=$stateid_post;
			}
			elseif($state_id !='')
			{
			//$external_stateid =$state_id;
			//$data['select_state']=$state_id;
			 $external_stateid =$stid[0];
			 $data['select_state']=$stid[0];
			}
			
			else{
			
			  $external_stateid =$this->current_state;
			  $data['select_state']=$this->current_state;
			}
			
			$arrstate = explode(',',$state_id);
			$user_states = $this->customer_mod->get_state_details($arrstate);
			
			$tracker_renge = $this->customer_mod->get_user_trackerrenge($this->current_user_id,$data['select_state']);
			//echo "<pre>";print_r($tracker_renge);
			
			$reg_date= $tracker_renge[0]['start_date'];
			$data['reg_date']= $reg_date;
			$enddate = $tracker_renge[0]['end_date'];
			$data['to_date']= $enddate;
			
			$data['user_state']=$user_states;
			$data['credit_type'] = $this->customer_mod->get_credit_types();
			$data['external_courses'] = $this->customer_mod->get_external_courses($this->current_user_id,$external_stateid);
			
			//echo "<pre>";print_r($data['select_state']);die;
			//get_state_details
		 	$this->template->load('layouts/default_layout.php','customer/my-credits.php',$data); 	
		}
		else{
				redirect(base_url().'login'); 
			}
	}
	
	
	public function get_my_credits()
	{
	  $state_id   = $this->input->post('stateid');
	  $user_course_id   = $this->input->post('user_course_id');
	  if($user_course_id !='')
	  {
		  $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
		  $courseid = $user_course[0]['course_id'];
		   $credit_type_list = $this->bundle_mod->get_ctype_credits($state_id,$courseid);
	  }
	  $sdate = $this->input->post('sdate');
	  $edate = $this->input->post('edate');
	  $eval = $this->input->post('evalution');
	  $user_id = $this->current_user_id;
	  if($sdate =='' &&  $edate == '')
	  {
		 $daterenage = $this->customer_mod->get_user_trackerrenge($user_id,$state_id);  
		  //echo "<pre>";print_r($daterenage);die; 
		   if(count($daterenage) > 0)
		  {
			$sdate = $daterenage[0]['start_date'];  
			$edate = $daterenage[0]['end_date'];  
		  }
	  }
	  
	  $state_credits 		= $this->bundle_mod->get_state_credits($state_id);
	  $user_state_credits 	= $this->customer_mod->get_user_state_credit($user_id,$state_id,$sdate,$edate);
	  
	 
	  //echo "<pre>";print_r($state_credits );die; 	$state_id;die;
	    $trackinghtml='';
		$arrchart ='';
		 $creditcatsname='';
		  $addpercentag=$addcreditpts=0;
$final_percenatge=0;
 $tracker_total=0;
 $getcredit=0;
	  if(count($state_credits) > 0)
		{     $i=0; 
			$colors = array(
				
				'#00C8F8',
				'#39B54A',
				'#FCEE21',
				'#F7931E',
				'#D0021B',
				
			);
		    
		    $general = '';
		    $gen_key = 0;
		    foreach($state_credits as $key=>$state_credit)
			 {
				$tracker_total +=$state_credit['credits'];
				if($state_credit['cat_id'] == 24){ //check to see if we have the general category in the state requirements
					$general = $state_credit;
					$gen_key = $key;
				}
			 }
			 if(isset($general) && isset($key)){ //move the general case to the end of the array
				 unset($state_credits[$key]);
				 $state_credits[] = $general;
			 }
			 
			 $used = 0; //keep track of the number of credits attributed to a category so we can assign the remainder to general
			 
			 foreach($state_credits as $state_credit)
			 {  
				 $i+=1;
				 $user_credits_earned = 0;
				 $addcredit=$percentage=$addpercentage=0;
			      $percentage=$track_perc=0;
			      $type=$state_credit['type'];
				  $total=$state_credit['credits'];
				  $grouped = $state_credit['grouped']; //is this category a grouped category?
				  $grouped_cats = explode(',',$state_credit['grouped_cats']); //load the category IDs that contribute to the group if it is grouped
				  $back_color =$state_credit['back_color'];
				  $back_color = $colors[$i - 1]; //tony added this so we are using 5 preset colors instead of relying on setting 28 different colors in the DB
				  if(count($user_state_credits) > 0)
				  {   $getcredit=0;
					  foreach($user_state_credits as $use_credit)
					 	{
					         if($grouped && count($grouped_cats)){ //we have to check all categories in the group and add their points together. Excluding 'General'
						         
						         if(in_array($use_credit['type_id'],$grouped_cats)){
							         
							         $getcredit +=	 $use_credit['total_points'];
							         
						         }
						         
					         }else{ //it's not a grouped category so we can just compare directly
						         if($use_credit['type_id'] == $state_credit['cat_id']) //check each user's credit category against each state requirement category
								 {
								      $getcredit +=	 $use_credit['total_points'];
								 }
							 }
							 
							 $user_credits_earned += $use_credit['total_points']; //get total number of credits earned by the user regardless of category
					 	}
				  }
				  
				   if(count($credit_type_list) > 0)
					{
						 foreach($credit_type_list as $credit_type)
						 {   
							  if($credit_type['type'] == $type)
							  {
							  	$addcredit +=$credit_type['credit_numbers'];
								$addcreditpts +=$credit_type['credit_numbers'];
								$creditcatsname .=$type.', ';
							  }
							  
						 }
						 
						//echo $myhtml; 
					}
				  $totalcredit=$state_credit['credits'];
				  
				
				    if($getcredit >= $total) //max out categories, users can't earn more than the category allows
						  {
							$getcredit=  $total;
							$used += $total;
					 } else{
							$used += $getcredit;
						}
					
					if($state_credit['cat_id'] == 24){
						$getcredit = $user_credits_earned - $used; //assign any leftover credits to the general category, if it exists
						if($getcredit >= $total){
							$getcredit=  $total; // we still have to check to make sure we're not overloading the general category
						}
					}
					
					
				  if($getcredit > 0)
				  {
					   $percentage=($getcredit * 100)/$total;
					   $track_perc=($getcredit * 100)/$tracker_total;
					   $final_percenatge +=$track_perc;
					   $string .='{value: '.number_format($track_perc,2).',color: "'.$back_color.'"},'; 
				  }
				  
				  $addpercentage=($addcredit * 100)/$total;		  
				  
				 
				  $getpt +=$getcredit;
				  $outof +=$total;
				  
				  //$final_percenatge += $percentage;
				 if($eval != 1)
				 {
				  $trackinghtml .='<li><div class="gr_head">'.$type.'</div>
									<div class="gr-sec">
									<div class="prg-sec">
									<div class="thm-progress clearfix">
									 <div class="progress">
									 <div style="width:'.$percentage.'%;background-color:'.$back_color.';" aria-valuemax="100" aria-valuemin="0" aria-valuenow="70" role="progressbar" class="progress-bar"></div>
									</div>
									</div>
									<span class="gr-fig" style="color:'.$back_color.';">'.$getcredit.' / '.round($total,1).'</span>
									</div> <!-- /prg-sec -->
									</div>
									</li>';
				 }else{
					$percentage = $percentage-$addpercentage; 
					 
				$trackinghtml .='<li><div class="gr_head">'.$type.'</div>
													<div class="gr-sec">
													<div class="prg-sec">
													<div class="thm-progress clearfix">
													 <div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%; background-color:'. $back_color.';">
							</div>
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:'.$addpercentage.'%;background-color:#000;"></div> <span class="inner-fig">+'.$addcredit.'</span>
													</div>
													</div>
													<span class="gr-fig">'.$getcredit.' / '.round($total,1).'</span>
													</div> <!-- /prg-sec -->
													
													
													</div>
							</li>';	
				 }
													  
			 } //endloop $state_credits
			 
			 
		}
		if($trackinghtml !='')
		{
			//echo $getpt.'>>'.$outof;die;
			$percentage_final= (100 - $final_percenatge);
			$string .='{value: '.(number_format($percentage_final,2)).',color: "#F6F6F6"}'; 
			//echo $string;die;
			$trackinghtml.='<script>Chart.types.Doughnut.extend({
								name: "DoughnutTextInside",
								showTooltip: function() {
									this.chart.ctx.save();
									Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
									this.chart.ctx.restore();
								},
								draw: function() {
									Chart.types.Doughnut.prototype.draw.apply(this, arguments);
						
									var width = this.chart.width,
										height = this.chart.height;
						
									var fontSize = (height / 150).toFixed(2);
									this.chart.ctx.font = fontSize + "em Verdana";
									this.chart.ctx.textBaseline = "middle";
						            this.chart.ctx.fillStyle = "black";
									var text = "'.$getpt.'/'.$outof.'" ,
										textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
										textY = height / 2;
						
									this.chart.ctx.fillText(text, textX, textY);
								}
							});
						   
					   
					var data = ['.$string.'];
						
							var DoughnutTextInsideChart = new Chart($("#myChart")[0].getContext("2d")).DoughnutTextInside(data, {
								responsive: true
							});</script> ';
							$arrResult['trackhtml'] = $trackinghtml;
							$arrResult['addcredit'] = $addcreditpts;
		$arrResult['creditcats'] = substr($creditcatsname, 0, -2);
		$arrResult['sucess'] = 'True';
		}else{
			$arrResult['sucess'] = 'false';
			$arrResult['trackhtml'] = $trackinghtml;
			$arrResult['addcredit'] = $addcreditpts;
		$arrResult['creditcats'] = substr($creditcatsname, 0, -2);
			}
							
		
	    echo json_encode($arrResult); 
	  
	}
	
public function add_credit()
	{
		//echo "<pre>";print_r($this->input->post());die;
		$user_credit_id=$this->input->post('credit_id');
		
		$data_insert['external_course_name'] = trim($this->input->post('course_name'));
		$data_insert['type_id'] = trim($this->input->post('credit_type'));
		$data_insert['credit_date'] = trim($this->input->post('adddate'));
		$data_insert['total_points'] = trim($this->input->post('credits'));
		$data_insert['state_id'] = trim($this->input->post('stateid'));
		$data_insert['user_id'] = $this->current_user_id;
		$data_insert['course_type'] = 'external';
		
		if($user_credit_id > 0)
		{
		$credit_id = $this->customer_mod->update_external_credits($data_insert,$user_credit_id);
		}else{
		$credit_id = $this->customer_mod->add_external_credits($data_insert);	
		}
		
		//echo json_encode($credit_id);
		echo 'true';
	}
	
public function delete_credits()
	{
		 $id = $this->input->post('credit_id');
		
		 echo $id = $this->customer_mod->delete_credit($id);
	}
	
public function edit_credit()
	{
		 $id = $this->input->post('creditid');
		
		  $result = $this->customer_mod->get_user_credit($id);
		  $arrResult['points'] = $result[0]['total_points'];
		  $arrResult['cdate'] = $result[0]['credit_date'];
		  $arrResult['type'] = $result[0]['type_id'];
		  $arrResult['cname'] = $result[0]['external_course_name'];
		  echo json_encode($arrResult);
		 //echo "<pre>";print_r( $result);die;
	}
	
public function certificate_upload_aws()
{
		   $user_course_id = $this->input->post('user_course_id');
		   $user_course = $this->customer_mod->user_course($user_course_id,$this->current_user_id);
		   $pdf_name = $this->clean_filename($user_course[0]['pdf_name']);
		   $course_details = $this->course_mod->get_course_details($user_course[0]['course_id'],1);
		   $course_name = $this->clean_filename($course_details[0]['course_name']);
		   $file_name = $course_name."_".$user_course_id.".pdf";
		   $base_path = FCPATH.'uploads/';
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

?>