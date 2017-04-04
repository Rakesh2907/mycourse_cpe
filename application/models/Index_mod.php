<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Index_mod.php
# Created on : 7th Sep 2016 by Rakesh Ahirrao
# Update on : 7th Sep 2016 by Rakesh Ahirrao
# Purpose : Front End functionality.
*/

class Index_mod extends CI_Model
{
	protected $table_cms 	= 'cms_pages';
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_cms($page)
	{      
		 	$this->db->select("c.*");
			$this->db->from($this->table_cms.' as c');
			
			if($page =='about'){
			$this->db->where("(c.page_title = 'about us')");
			}
			elseif($page =='terms')
			{
				$this->db->where("(c.page_title = 'Terms and Conditions')");
			}
			elseif($page =='help')
			{
				$this->db->where("(c.page_title = 'Help')");
			}
			$query_cms = $this->db->get();
			if($query_cms->num_rows()>0)
			{
				return $query_cms->result_array();
			}
			else
			{
				return array();
			}	
	}
	
} 
?>