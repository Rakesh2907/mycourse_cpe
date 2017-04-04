<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Index_con.php
# Created on : 7th Sep 2016 by Rakesh Ahirrao
# Update on : 7th Sep 2016 by Rakesh Ahirrao
# Purpose : Front End functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Index_con extends CI_Controller {

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
    public $current_state = 0;
	public $current_user_id = 0;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('index_mod');
		$this->load->model('state_mod');
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
		$data['current_state'] = $this->current_state; 
		$data['states'] = $this->state_mod->get_us_states();
		$this->load->view('frontpage',$data);
	}
	
	public function get_cms($page='')
	{   
		switch($page){
			case 'about':
				$data['page_title'] = 'About Us | CPE Nation';
				break;
			case 'terms':
				$data['page_title'] = 'Terms & Conditions | CPE Nation';
				break;
			case 'help':	
				$data['page_title'] = 'Help | CPE Nation';
				break;
		}
		
		$data['page_details']	= $this->index_mod->get_cms($page);
		
		
		//echo "<pre>";print_r($date['page_details']);die;
		$this->template->load('layouts/default_layout.php','faq/cms.php',$data); 
	}
}
