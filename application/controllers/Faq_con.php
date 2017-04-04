<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Faq_mod.php
# Created on : 16th Sep 2016 by Shailesh Khairnar
# Update on : 16th Sep 2016 by Shailesh Khairnar
# Purpose : Faculties listing and related functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_con extends CI_Controller {

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
		
	public function __construct()
	{
		parent::__construct();
		$this->load->model('faq_mod');
		$this->load->model('customer_mod');
		$this->load->library('email');
		$this->load->helper('general');
		
	} 
	 
	public function index()
	{
		
	}
	public function get_faq()
	{  
	    
		$data['page_title'] = 'Faq | CPE Nation';
		$data['faq_list']	= $this->faq_mod->get_faq();
		$data['navigation'] = 'faq';
		//echo "here";die;
		//echo "<pre>";print_r($date['faq_list']);die;
		$this->template->load('layouts/default_layout.php','faq/faq.php',$data); 
	}
	
	public function get_faq_search()
	{
	   $key = trim($this->input->post('key'));
	   $faq_list = $this->faq_mod->get_faq_search($key);   
	/*echo "<pre>";print_r($faq_list); 
	 die;*/
		 $html = "";
		  if(count($faq_list) > 0)
		  {  
		  	foreach($faq_list as $faq_data)
			{	//echo "<pre>";print_r($faq_data); 
			  $html .=' <div id="faqlist" class="faqlist"> <h4>'.$faq_data['question'].'</h4>'.$faq_data['answer'].'</div>';
			 //echo $this->getHTML($faq_data);
		  	}
		  	
		  }else{
			  $html= 'No records found';
		  }
	  echo $html;
	   exit;
	   //echo "<pre>";print_r($faq_list);die;   	
	}
	
	public function contactus()
	{ 
	    
	    $data['page_title'] = 'Contact Us | CPE Nation';
		$data['navigation'] = 'contact';
		$data['suc_msg']='';
		
		if(trim($this->input->post('submit')) == '')
		{       
			$this->template->load('layouts/default_layout.php','faq/contact-us.php',$data); 
		}
		elseif(trim($this->input->post('submit')) == 'SUBMIT')
		{ 
		
		    //echo "<pre>";print_r($this->input->post());die;
			//echo "4545";die;
		 	$this->form_validation->set_rules('email', ' Email', 'required');
			$this->form_validation->set_rules('name', ' name', 'required');
			$this->form_validation->set_rules('subject', ' subject', 'required');
			$this->form_validation->set_rules('message', ' message', 'required');
			
			 if($this->form_validation->run($this) == FALSE)
			 { 
				 $this->template->load('layouts/default_layout.php','faq/contact-us.php',$data); 
			 }
			 else{
				 
					 $name     = trim($this->input->post('name'));
					 $email    = trim($this->input->post('email'));
					 $subject  = trim($this->input->post('subject')); 
					 $message  = trim($this->input->post('message')); 
				 
				    //$admin_detail=$this->customer_mod->get_admin_email();
					//admin_email=$admin_detail[0]['email'];
					$admin_email='info@cpenation.com';
					$messagebody="Contact Us Details<br>Name-".$name."<br>Email :-".$email."<br>Subject :-".$subject."<br>Message :-".$message."";
					$mydata['name']= $name;
					$mydata['email']= $email;
					$mydata['subject']= $subject;
					$mydata['message']= $message;
					
					$myhtml = $this->load->view('email_template/contact_us.php',$mydata,true);	
					//echo "<pre>";print_r($myhtml);die;
					$this->email->initialize($config);
					$this->email->set_mailtype('html');
					$this->email->from('info@cpenation.com', 'cpenation');
					$this->email->to($admin_email);
					$this->email->subject('CPE-Nation:Contact-us form submitted ');
					$this->email->message($myhtml);
					$result=$this->email->send();
				
				 if($result > 0)
				 {
					  $arr_msg = array('suc_msg'=>'Send email successfully!!!');
				 }else{
					  $arr_msg = array('err_msg'=>'Failed to send record');
				 }
				 //print_r($arr_msg);die;
				 $this->session->set_userdata($arr_msg);
				 //redirect(base_url().'faq_con/contactus');
				 $data['suc_msg']='Your message was successfuly sent. Someone from our support team with contact you within the next 24 hours.';
				 
				
				 $this->template->load('layouts/default_layout.php','faq/contact-us.php',$data); 
			
			}
		}
	   	
	}
	
}
