<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Cart_con.php
# Created on : 21th Sep 2016 by Shailesh Khairnar
# Update on : 
# Purpose : Add to cron related functionality.
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_con extends CI_Controller {

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
		$this->load->model('cron_mod');
		
	} 
	
	public function update_user_expired_course()
	{
		
		  $result = $this->cron_mod->update_user_expired_course();
		      if($result == 1)
			  {
					echo "Successfully updated user courses expired status";  
			  }
		 
	}
	
	public function update_expired_coupons()
	{
		 $result = $this->cron_mod->update_coupons_expiry();
		      if($result == 1)
			  {
					echo "Successfully updated expired coupon status as Inactive";  
			  }	
	}
	
		
	public function delete_zero_userids_orders()
	{
		      $result = $this->cron_mod->delt_zero_orders();
		      if($result == 1)
			  {
					echo "Successfully deleted Inactive orders.";  
			  }	
	}
}
