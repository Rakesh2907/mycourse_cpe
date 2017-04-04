<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function is_logged_admin() 
{
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('userid');
	
    if (!isset($user)) {
		
		redirect('index_con');
		 
		 } 
}

?>