<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Course_con.php
# Created on : 6th Sep 2016 by Rakesh Ahirrao
# Update on : 15th Oct 2016 by Rakesh Ahirrao
# Purpose : Course listing and Other Course functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Course_con extends CI_Controller {

	/**
	 * Index Page for this controller.
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
	public $subexpiry_date = '';
	public function __construct()
	{
		parent::__construct();
	    $this->load->model('state_mod');
		$this->load->model('bundle_mod');
		$this->load->model('course_mod');
		$this->load->model('customer_mod');
		$this->load->model('checkout_mod');
		$this->load->model('cart_mod');
		$this->load->model('subscription_mod');
		$this->load->helper('cookie');
		$this->current_user_id = is_logged_in();
		if($this->session->userdata['state_id']=='')
		{
			$this->current_state = find_states();
		}else{
			$this->current_state =  $this->session->userdata['state_id'];
		}
		
		
	} 
	 
	public function index($stateid='')
	{   
	  
		$data['page_title'] = 'Courses | CPE Nation';
		$sel_state_id = $this->input->post('dropdown_states');
		$data['selected_state_id'] = $this->current_state;
	 
		//echo "<pre>";print_r($_SESSION['state_id']);echo "</pre>"; 
		
		 $refering_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		 $new_url = parse_url($refering_url);
		 $new_url = explode('/',$new_url['path']);
		
		 
		if($stateid !='')
		{
		 $data['selected_state_id'] = $sel_state_id = $stateid;
		}
	
		if(isset($sel_state_id) && $sel_state_id!='' || $new_url[4]!='')
		{
			/*$_SESSION['state_id'] =	array();
		    unset($_SESSION['state_id']);
			$_SESSION['states_f'] =	array();
		    unset($_SESSION['states_f']);*/
			 $arr_state = array('state_id'=> $sel_state_id);
			 $this->session->set_userdata($arr_state); 
			 $data['selected_state_id'] = $sel_state_id;
		}else if($this->session->userdata('state_id') == ''){
			$data['selected_state_id'] = $this->session->userdata('state_id');
		}else{
			$_SESSION['state_id'] =	array();
		    unset($_SESSION['state_id']);
			$_SESSION['states_f'] =	array();
		    unset($_SESSION['states_f']);
			$_SESSION['topic_f'] = array();
			unset($_SESSION['topic_f']);
			$_SESSION['format_f'] = array();
			unset($_SESSION['format_f']);
			$_SESSION['faculty_f'] = array();
			unset($_SESSION['faculty_f']);
			$_SESSION['credit_f'] = array();
			unset($_SESSION['credit_f']);
			$_SESSION['require_f'] = array();
			unset($_SESSION['require_f']);
			$data['selected_state_id'] = '';
		}
		
		$data['states'] 	 = $this->state_mod->get_us_states();
		$data['coursetypes'] = $this->course_mod->get_course_types();
		$data['faculty_list']	 = $this->course_mod->get_faculty();
		$data['course_require']	 = $this->course_mod->get_course_requirement();
		//echo "<pre>";print_r($data['course_require']);die;
		
		$this->template->load('layouts/default_layout.php','courses/course.php',$data); 
		
	}
	
	public function course_details($course_id,$state_id)
	{
		$data['page_title'] = 'Courses | CPE Nation';
		$user_id = $this->current_user_id;
	    $data['cuserid'] = $user_id;
		$data['course_state'] = $state_id;
			if(isset($this->session->userdata['order_id'])){
				$data['cart_id'] = $this->session->userdata['order_id'];
		  	}else{
				$data['cart_id'] = '';
			}
		$data['course_details'] = $this->course_mod->get_course_details($course_id);
		if($user_id > 0)
		{
			$user_sub = $this->subscription_mod->get_user_subscription($user_id);
			if($user_sub[0]['expiry_date']!='')
			{
				$daylen 	    = 60*60*24;
				$today_date	    = date('Y-m-d');
				$this->subexpiry_date =  $expiry_date    = date('Y-m-d',strtotime($user_sub[0]['expiry_date']));
				$data['remaining_days'] = $remaining_days = round((strtotime($expiry_date)-strtotime($today_date))/$daylen);
				$data['order_id'] = $user_sub[0]['order_id'];
			}else{
				$data['remaining_days'] = 0;
			}
		}else{
			$data['remaining_days'] = 0;
		}
		
		$this->template->load('layouts/default_layout.php','courses/course_details.php',$data); 
	}
	public function add_to_mycourse()
	{
		 $cus_id = $this->input->post('cuser_id');
		 $item_type = trim($this->input->post('item_type'));
		 $course_id = $this->input->post('item_id');
		 $state_abr = $this->input->post('state_abr');
		 $order_id = $this->input->post('order_id');
		 
		 $user_sub = $this->subscription_mod->get_user_subscription($cus_id);
		 if($user_sub[0]['expiry_date']!='')
		 {
			 $myexpiry_date = $user_sub[0]['expiry_date'];
		 }
		 $customer_details = $this->customer_mod->get_customer_details($cus_id);
		 $customer_states = $customer_details[0]['state'];
		 $course_details = $this->course_mod->get_course_details($course_id); 
		 $state_drop_id =  $this->state_mod->state_details($state_abr);
		 
		 $customer_states = $customer_states.','.$state_drop_id[0]['state_id'];
		 $customer_states = implode(',', array_unique(explode(',',$customer_states)));
		 
		 $course_credits = $this->checkout_mod->get_states_credits($course_id,$customer_states);
		 $dataArray = array();
						
		 if(count($course_credits) > 0)
		 {
				foreach($course_credits as $ckey => $mycredits)
				{
					$dataArray[$mycredits['state_abbr']][$mycredits['course_type']] = $mycredits['credit_numbers']; 
				}
		 }
		 
		 
		 $data_insert['user_id'] =  $cus_id;//$this->current_user_id;
		 $data_insert['course_id'] = $course_id;
		 $data_insert['order_id'] =  $order_id;
		 $data_insert['course_credits'] = json_encode($dataArray);
		 $data_insert['added_date'] = date('Y-m-d');
		 $data_insert['expiry_date'] = date('Y-m-d', strtotime($myexpiry_date));
		 $data_insert['course_status'] = 'Not Started';
		 $data_insert['course_state'] = $state_abr;
		 $data_insert['type'] = 'Course';
		 $data_insert['parchase_type_id'] = $course_id;
		 $data_insert['pdf_name'] = trim($course_details[0]['course_name']);
		 $user_course_id = $this->checkout_mod->insert_courses($data_insert);
		 if($user_course_id)
		 {
				$this->added_course_materials($user_course_id,$course_id,$order_id,$cus_id);
		 }
		 echo $user_course_id;
	}
	
	public function added_course_materials($user_course_id,$course_id,$order_id,$user_id = 0)
	{
		
			 $course_text = $this->checkout_mod->get_course_text($course_id);
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
						$user_course_text = $this->checkout_mod->insert_courses_text($data_text);
				}
			 }
			 
			 $course_video = $this->checkout_mod->get_course_video($course_id);
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
						$user_course_text = $this->checkout_mod->insert_courses_text($data_text);
				    }
			 }
			  	
	}
	
	
	public function get_courses()
	{    
		   
		 $refering_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		 $new_url = parse_url($refering_url);
		 $new_url = explode('/',$new_url['path']);
		   
		   $_SESSION['states_f'] =	array();
		   unset($_SESSION['states_f']);
		   $_SESSION['topic_f'] =	array();
		  unset($_SESSION['topic_f']);
		   $_SESSION['format_f'] =	array();
		  unset($_SESSION['format_f']);
		   
		   $_SESSION['faculty_f'] =	array();
		  unset($_SESSION['faculty_f']);
		   
		   $_SESSION['credit_f'] =	array();
		   unset($_SESSION['credit_f']);
		 
		  $_SESSION['require_f'] =	array();
		  unset($_SESSION['require_f']);
		  
		  $state_id = $this->input->post('state_id');
		 // $_SESSION['states_f'] =	$_SESSION['topic_f'] ='';
		  if(sizeof($state_id) == 0) 
		  {
			   //$state_id =array($this->current_state);
			   $data['selected_state_id'] = '';//$this->current_state;
		  }/*else{
			  
			  $state_id =array($state_id[0]); 
		}*/
		   
		
		  $course_type=$this->input->post('topic_ids');
		  $format_type=$this->input->post('format');
		  $faculty_id=$this->input->post('faculty');
		  $colspan=$this->input->post('colum');
		  $creditlimt=$this->input->post('creditlimit');
		  $coursereq=$this->input->post('coursereq');
		  
		   //cookie section 
		 //print_r($faculty_id);die;
		 $arr_filter_session = array('states_f' => $state_id,'topic_f' => $course_type,'format_f' =>$format_type,'faculty_f'=>$faculty_id ,'credit_f'=>$creditlimt,'require_f' =>$coursereq);	
		 
		  //print_r($arr_filter_session);		
		 $this->session->sess_expiration = 172800; 			
		 $this->session->set_userdata($arr_filter_session);
		
		  $pageno=$this->input->post('page_no');
		  
		  $search_course = trim($this->input->post('searchcourse'));
		  
		  $reset_filter = $this->input->post('reset_filter');
		  $order_filter = $this->input->post('orderby');
		  if($order_filter !='')
		  {
			 $orderby= $order_filter;
		  }
		  else{
			   $orderby= 'course_name ASC';
		  }
		 
		  	
				 // $config['total_rows'] = 
		 $course_total = $this->course_mod->course_total($state_id,$search_course,$orderby,$course_type,$format_type,$faculty_id,$creditlimt,$coursereq);
	
		  
		  $totalRecord=$course_total;
		  
		  $course_list = $this->course_mod->course_list($state_id,$search_course,$orderby,$course_type,$format_type,$faculty_id,$creditlimt,$coursereq,$pageno);
		  //echo "<pre>";print_r($course_list);die;
		  $html = "";
		  if(count($course_list) > 0)
		  {  
		  	foreach($course_list as $course_data)
			{	
			  $html .= $this->getHTML($course_data,$colspan,$state_id[0]);
		  	}
			 
			$paginationHtml = $this->getPegination($totalRecord,$pageno);	
			  
			
		  	$arrResult['sucess'] = 'True';
			$arrResult['html'] = $html;
			$arrResult['pagination'] = $paginationHtml;
			
		  }else{
			  $arrResult['sucess'] = 'False';
		  }
		  
		  if($reset_filter)
		  {
			   $this->session->unset_userdata('state_id');
			   $arr_state = array('state_id'=> '');
			   $this->session->set_userdata($arr_state); 
		  }
		  //echo "<pre>";print_r($arrResult);die;
		  echo json_encode($arrResult); 
		  exit;
	}
	
	public function getHTML($items,$colspan,$state_id)
	{
		/*$bundle_credit_count = 0;
		$bundle_credit_count = $this->course_mod->get_course_credits($items['course_id'],$items['state_id']);
		
		if($bundle_credit_count == ''){
			$bundle_credit_count = '0.00';
		}*/
		$faculty=$items['course_author'];
		$fname='';
		$faculty_name = $this->course_mod->get_faculty_name($faculty);
		//echo "<pre>";print_r($items);
			foreach($faculty_name as $faculty)
			{
			  $fname.=$faculty;
			}
			if(strlen($fname) > 75)
			{
			  $fname =	substr($fname, 0, 75);
			}
			$course_name=$items['course_name'];
			if(strlen($course_name) > 55)
			{
			$pos = strpos($course_name,' ',50);
			if($pos)
				$course_name=substr($course_name, 0, $pos).'...';	
			}
		
		$back_color='#c7b3df';
		if(isset($items['back_color']) && $items['back_color']!=''){ $back_color= $items['back_color'];}
		if($colspan == 0)
		{
		  $cssclass='col-sm-4 col-md-3';
		}
		else
		{
		$cssclass='col-sm-6 col-md-4';
		}	
		$img_name='';
		if($items['course_format'] == 'Webcast')
		{
			$img_name='bund-video-icon.png';
		}
		if($items['course_format'] == 'Text')
		{
			$img_name='bund-pdf.png';
		}
		
		$img_file = DIR_IMAGES.''.$items['course_image']; 
		if(isset($items['s3_images']) && $items['s3_images']!='')
	    {
			$thumb_url = $items['s3_images'];
	    }else if ($items['course_image']!='') 
		{
			//$thumb_url = $this->config->item("upload_path").'image/'.$items['course_image']; 
			$thumb_url = CLOUDFRONT_URL.'images/'.$items['course_image']; 
		}else{
			$thumb_url = $this->config->item("cdn_css_image").'images/bundle-starcbuks.png';
		}
		
		$html = '';
	
		$html='<div class="bdl-col-adj '.$cssclass.'">
				<div class="bund-list-sec bdl_Small">
				<div class="bund-img-sec" style="background-color:'.$back_color.';" >
				<a href="'.base_url().'individual-courses/'.$items['course_id'].'/'.$state_id.'"><img width="69" alt="bundle" src="'.$thumb_url.'" class="bdl-img" /></a>
				<div class="bund-type"><img width="18" alt="PDF" src="'.$this->config->item("cdn_css_image").'images/'.$img_name.'" /></div>
				<div class="bund-price">$'.$items['course_price'].'</div>
				</div> <!-- /bund-img-sec -->
				
				<div class="bund-desc">
				<div class="bdl-hd">
				<h5><a href="'.base_url().'individual-courses/'.$items['course_id'].'/'.$state_id.'" class="link-title">'.$course_name.' </a></h5>
				<div class="bdl_small"><i>'.$fname.'</i></div>
				</div>';
			if($state_id == '')
			{
				$html.='<div class="ttl-credit"><img alt="credit-icon" src="'.$this->config->item("cdn_css_image").'images/credit-icon.png" />'.$items['cpe_credits'].'</div>';
				$html.='<a class="btn small_btn btn-blue-text" href="'.base_url().'individual-courses/'.$items['course_id'].'/1">VIEW Course</a>';
			}else
			{
			    $html.='<div class="ttl-credit"><img alt="credit-icon" src="'.$this->config->item("cdn_css_image").'images/credit-icon.png" />'.$items['cpe_credits'].'</div>';
				$html.='<a class="btn small_btn btn-blue-text" href="'.base_url().'individual-courses/'.$items['course_id'].'/'.$state_id.'">VIEW Course</a>';
			}
		$html.='</div> <!-- /bund-desc -->
				</div>
				</div>';		
	
		  
		  return $html;
	}
	
	public function getPegination($total,$pageno=0)
	{
		$prev=0;
		$link=($total/12);
		$next=($pageno)+1;
		if($pageno!= 0)
		{
		   $prev=($pageno)-1;
		}
	    
		
		$pegination='<ul class="pagination" id="pegination">';
					 
		if($pageno > 0)
			$pegination.='<li class="pre"><a href="javascript:void(0);" id="prev_'.$prev.'" class="page_no">Previous</a></li>';
					
					  for($i=0; $i<$link;$i++)
					  {  $cls='';
						 if($pageno == $i){
		                    $cls='active';   
		                   }  
						if($link > 1)
							$pegination.='<li class="'.$cls.'"><a href="javascript:void(0);" id="page_'.$i.'" class="page_no">'.($i+1).'</a></li>';    
					  }
					  
		if($next < ceil($link))
			$pegination.='<li class="nex" ><a href="javascript:void(0);" id="next_'.$next.'" class="page_no">Next</a></li>
					</ul>';
					
					
		return 	$pegination;		
	
	}
	
	function get_file(){
		
		$file = trim($_GET['file']);
		if($file !='')
		{
			$filepath = FCPATH.'admin/uploads/image/'.$file; 
			$filename = $file;
  			header('Content-type: application/pdf');
  			header('Content-Disposition: inline; filename="' . $filename . '"');
  			header('Content-Transfer-Encoding: binary');
  			header('Accept-Ranges: bytes');
  			readfile($filepath);
			exit;
		}
	}
	
}
