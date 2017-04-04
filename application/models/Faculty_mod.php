<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Faculty_mod.php
# Created on : 9th Sep 2016 by Shailesh Khairnar
# Update on : 9th Sep 2016 by Shailesh Khairnar
# Purpose : Faculties listing and related functionality.
*/

class Faculty_mod extends CI_Model
{
	protected $table_faculty	= 'faculty_members';
	protected $table_course		= 'courses';
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_faculty_details($fid)
	{      
		 	$this->db->select("f.*");
			$this->db->from($this->table_faculty.' as f');
			$this->db->where('f.faculty_member_id',$fid);
			
			$query_faculty = $this->db->get();
			if($query_faculty->num_rows()>0)
			{
				return $query_faculty->result_array();
			}
			else
			{
				return array();
			}	
	}
	public function get_faculty()
	{      
		    $this->db->select("f.*");
			$this->db->from("faculty_members AS f");
			$this->db->where('f.active','1');
			$this->db->order_by('f.faculty_member_id DESC');
			$query_faculty = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_faculty->num_rows()>0)
			{
				return $query_faculty->result_array();
			}
			else
			{
				return array();
			}	
				
	}
	
	public function get_faculty_courses($fid='',$stateid='')
	{      
		 	$this->db->select("c.*,cr.credit_numbers");
			$this->db->from($this->table_course.' as c');
			//$this->db->where_in('c.course_author',$fid);
			$this->db->join('course_credits AS cr', 'c.course_id = cr.course_id','inner');
			$this->db->where("find_in_set (".$fid.",c.course_author)");
			$this->db->where("c.course_status",'active');
			$this->db->where("cr.state_id",$stateid);
			$this->db->group_by('c.course_id'); 
			$query_courses = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_courses->num_rows()>0)
			{
				return $query_courses->result_array();
			}
			else 
			{
				return array();
			}	
	}
	
	public function get_faculty_course_credit($cid,$stateid)
	{
	 
	 $query="SELECT SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR,credits_type CT WHERE CCR.state_id =".$stateid." AND CCR.course_id =".$cid." AND CT.type_id = CCR.course_type AND CT.active = 1 GROUP BY course_id"	;
	 $query_courses = $this->db->query($query);
			
			//echo $this->db->last_query();die;
			if($query_courses->num_rows()>0)
			{
				return $query_courses->result_array();
			}
			else
			{
				return array();
			}
	}
	
} 
?>