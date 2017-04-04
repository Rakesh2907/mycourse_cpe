<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Faculty_con.php
# Created on : 9th Sep 2016 by Shailesh Khairnar
# Update on : 9th Sep 2016 by Shailesh Khairnar
# Purpose : Faculties listing and related functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_con extends CI_Controller {

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
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('faculty_mod');
		$this->load->model('course_mod');
		$this->load->model('customer_mod');
		$this->load->library('email');
		if($this->session->userdata['state_id']=='')
		{
			$this->current_state = find_states();
		}else{
			$this->current_state =  $this->session->userdata['state_id'];
		}
	} 
	 
	public function index()
	{
		$data['page_title'] = 'Faculty | CPE Nation';
		$data['faculty'] = $this->faculty_mod->get_faculty();
		//echo "<pre>";print_r($data['faculty']);die;
		$this->template->load('layouts/default_layout.php','faculty/faculty.php',$data); 
	}
	
	public function faculty_details($fid='')
	{
		 $cnt=0;
		$data['page_title'] = 'Faculty | CPE Nation';
		$data['faculty_info'] = $this->faculty_mod->get_faculty_details($fid);
		$stateid	= $this->current_state;
		$data['stateid']=$stateid;
		$data_course = $this->faculty_mod->get_faculty_courses($fid,$stateid);
		 //echo "<pre>";print_r($data_course);die;
		$cnt=count($data_course );
		if($cnt > 0)
		{
			    for($i=0 ; $i< $cnt; $i++) 
				{
					     $fname=$coursename='';
						$faculty=$data_course[$i]['course_author'];
						
						//echo $this->current_state;die;
						$faculty_name = $this->course_mod->get_faculty_name($faculty);
						$faculty_course_credit = $this->faculty_mod->get_faculty_course_credit($data_course[$i]['course_id'],$this->current_state);
					     //echo "<pre>";print_r($faculty_course_credit);die;
						foreach($faculty_name as $faculty)
						{
						  $fname.=$faculty;
						}
						if(strlen($fname) > 35)
						{
						  $fname =	substr($fname, 0, 35);
						}
						
						$coursename = $data_course[$i]['course_name'];
						
						if(strlen($coursename) > 55)
						{
						$pos = strpos($coursename,' ',50);
						if($pos)
							$coursename=substr($coursename, 0, $pos).'...';	
						}
							
						//echo ">>".$coursename;die;
						$faculty_course[$i]['cid']			= $data_course[$i]['course_id'];
						$faculty_course[$i]['coursename']	= $coursename;
						$faculty_course[$i]['course_price']	= $data_course[$i]['course_price'];
						$faculty_course[$i]['back_color']	= $data_course[$i]['back_color'];
						$faculty_course[$i]['course_image']	= $data_course[$i]['course_image'];
						$faculty_course[$i]['s3_images']	= $data_course[$i]['s3_images'];
						$faculty_course[$i]['cpe_credits']	= $data_course[$i]['cpe_credits'];
						$faculty_course[$i]['course_format']	= $data_course[$i]['course_format'];
						
						if($faculty_course_credit[0]['credit_numbers'] !='')
						{
							$faculty_course[$i]['credit']		= $faculty_course_credit[0]['credit_numbers'];
						}else{
							$faculty_course[$i]['credit']=0;
						}
						
						$faculty_course[$i]['faculty_name']	= $fname;
					
				}
				
				
		
		}
		//echo "<pre>";print_r($faculty_course);die;
		$data['facultt_course'] = $faculty_course;
		
		
	
		
		$this->template->load('layouts/default_layout.php','faculty/faculty-bio.php',$data); 
	}
	
	public function join_faculty()
	{
		//echo "<pre>";print_r($this->input->post());die;
		$data['page_title'] = 'Faculty Join | CPE Nation';
		//$data['faculty'] = $this->faculty_mod->get_faculty();
		//echo "<pre>";print_r($data['faculty']);die;
		if(trim($this->input->post('mysubmit')) == '')
		{       
			$this->template->load('layouts/default_layout.php','faculty/join-faculty.php',$data); 
		}
		elseif(trim($this->input->post('mysubmit')) =='joinus')
		{
		  
		//echo "<pre>";print_r($this->input->post());die;
		
		  
		$this->form_validation->set_rules('emailid', ' Emailid', 'required|valid_email');
		$this->form_validation->set_rules('fullname', ' Full Name', 'required');
		$this->form_validation->set_rules('phoneno', ' Phone Number', 'required');
		$this->form_validation->set_rules('biodata', ' Short Bio', 'required');
		
		
		if ($this->form_validation->run($this) == FALSE)
		{   //echo 1111;die;
			//$data['msg']='Please fill all information';
			//$this->template->set_layout('admin_default')->build('faculty/join-faculty.php',$data);
			$this->template->load('layouts/default_layout.php','faculty/join-faculty.php',$data); 
		}
		else{
			
			$fromemail	=	trim($this->input->post('emailid'));
			$fullname 	=	trim($this->input->post('fullname'));
			$phonenum 	=	trim($this->input->post('phoneno'));
			$firm	  	= 	trim($this->input->post('firm'));
			$linkldn	=	trim($this->input->post('linkldn'));
			$biodata	=	trim($this->input->post('biodata'));
			
			$data['msg']='Thank you for your interest, we will back to you soon.';
			$admin_detail=$this->customer_mod->get_admin_email();
			//echo "<pre>";print_r($admin_detail);die;
			$admin_email=$admin_detail[0]['email'];
			
			$from=$fromemail;
			$subject="Faculty Join US";
			$message="Hello Admin<br> Someone submit the 'Join us as Faculty' form on CPE-Nation<br>Below are the submited details<br><br>
			<b>Full Name:-</b>".$fullname."<br><b>Email ID:-</b>".$fromemail."<br><b>Phone No:-</b>".$phonenum."<br><b>Firm Name:-</b>".$firm."<br><b>LinkedIn Profile:-</b>".$linkldn."<br><b>Short Bio:-</b>".$biodata."<br><br>Thank You<br> CPE Team";
					
			//echo $message;die;		
			$this->email->initialize($config);
			$this->email->set_mailtype('html');
			$this->email->from($fromemail, $fullname);
			$this->email->to($admin_email);
			$this->email->subject($subject);
			$this->email->message($message);
			$result=$this->email->send();
			//$this->template->load('layouts/default_layout.php','faculty/join-faculty.php',$data); 
		}
		
		
		$this->template->load('layouts/default_layout.php','faculty/join-faculty.php',$data); 
		}
		
	}
	
}
