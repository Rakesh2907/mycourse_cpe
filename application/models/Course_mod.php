<?php 
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Course_mod.php
# Created on : 6th Sep 2016 by Rakesh Ahirrao
# Update on : 15th Oct 2016 by Rakesh Ahirrao
# Purpose : Course listing and Other Course functionality.
*/
class Course_mod extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_credits($courses_id)
	{
		  $course_id = explode(',',$courses_id);
		  $this->db->select("c.course_id, c.course_type, c.credit_numbers, us.state_id, us.state, us.state_abbr, ct.type");
		  $this->db->join('credits_type AS ct', 'c.course_type = ct.type_id','inner');
		  $this->db->join('us_state AS us', 'c.state_id = us.state_id','inner');
		  $this->db->from("course_credits AS c");
		  $this->db->where("ct.active = '1'");
		  $this->db->where_in("course_id",$course_id);
		  $this->db->order_by("us.state", " ASC");
		  $myquery = $this->db->get();
		 // echo $this->db->last_query();
		  
		 if($myquery->num_rows()>0)
	     {
				return $myquery->result_array();
		 }else{
				return array();
		 }  
	}
	
	public function get_chapters($course_id)
	{
		  $this->db->select("ch.*");
		  $this->db->from("course_chapters AS ch");
		  $this->db->where("ch.course_id",$course_id);
		  $this->db->where("ch.status = 'Active'");
		  //$this->db->order_by("ch.chapter_name", "ASC");
		  $this->db->order_by("ch.order_seq", "ASC");
		  $myquery = $this->db->get();
		  if($myquery->num_rows()>0)
		  {
					return $myquery->result_array();
		  }else{
					return array();
		  } 
	}
	
	public function get_exam_details($course_id)
	{
		  $this->db->select("cq.*");
		  $this->db->from("course_exam_questions AS cq");
		  $this->db->where("cq.course_id",$course_id);
		  $this->db->where("cq.ques_status = 'Active'");
		  $this->db->order_by("cq.ques_title", "ASC");
		  $myquery = $this->db->get();
		  if($myquery->num_rows()>0)
		  {
					return $myquery->result_array();
		  }else{
					return array();
		  }
    }
	
	public function get_similar_courses($state_id,$course_id)
	{
		  $state_f		=	$_SESSION['states_f'];
		  $topic_f  	= 	$_SESSION['topic_f'];
		  $format_f 	= 	$_SESSION['format_f'];
		  $faculty_f	=	$_SESSION['faculty_f'];
		  $credit_f		=	$_SESSION['credit_f'];
		  $require_f	=	$_SESSION['require_f'];
		  
		  //echo "<pre>";print_r($credit_f);die;
		  
		  $statesid = implode(",", $state_f);
		  $typeid = implode(",", $topic_f);
		  $format_type = implode(",", $format_f);
		  $facultyid = implode(",", $faculty_f);
	      $reqid = implode(",", $require_f);
		  
		   $where_cond='1=1';
		
			if( $statesid !='')
			{
				 $where_cond.=' AND CCR.`state_id` IN ('.$statesid.')';
			}
			 if( $typeid !='')
			{
				 $where_cond.=' AND CCR.`course_type` IN ('.$typeid.')';
			}
			
			if( $format_type !='')
			{
				 $where_cond.=" AND FIND_IN_SET (course_format,'".$format_type."')";
			}
			if( $facultyid !='')
			{
				 $where_cond.=' AND CR.`course_author` IN ('.$facultyid.')';
			}
			if( $reqid !='')
			{
				 $where_cond.=' AND CR.`course_req` IN ('.$reqid.')';
			}
			if( $course_id !='')
			{
				//$this->db->where_not_in("cc.course_id",$course_id);
				$where_cond.=' AND CR.`course_id` NOT IN  ('.$course_id.')';
			}
				$i=1;
			 if(sizeof($credit_f) > 0)
			 {
				 foreach($credit_f as $key => $credit)
				 {  
					if($i == 1)
					{
						$where_cond.= ' AND ((credit_numbers >= '.$credit.' AND credit_numbers < '.(($credit)+1).') '; 
					}else{
						$where_cond.= ' OR (credit_numbers >= '.$credit.' AND credit_numbers < '.(($credit)+1).')'; 
					}
					
					$i=0;
				 }
				 $where_cond.=')';
			 }
			
			 $query="SELECT CR.*, CCR.state_id, SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR, courses CR, credits_type CT WHERE ".$where_cond." AND CCR.course_id = CR.course_id AND CR.course_status = 'active' AND CT.type_id = CCR.course_type AND CT.active = 1 GROUP BY course_id  limit 7" ;
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
	public function get_similar_courses_back($state_id,$course_id)
	{
		  $this->db->select("c.*, cc.state_id");
		  $this->db->from("courses AS c");
		  if(isset($state_id)){
			  $this->db->join("course_credits AS cc","c.course_id = cc.course_id");
			  $this->db->where("cc.state_id",$state_id);
			  $this->db->group_by("cc.course_id"); 
		  } 
		  $this->db->where_not_in("cc.course_id",$course_id);
		  $this->db->where("c.course_status = 'active'");
		  $this->db->order_by("rand()");
		  $this->db->limit(7);
		  $query_course = $this->db->get();
			// echo $this->db->last_query();
		  if($query_course->num_rows()>0)
		  {
				return $query_course->result_array();
		  }else{
				return array();
		  }
   }
	
    public function get_cart_similar_courses($state_id)
	{
		  $this->db->select("c.*, cc.state_id");
		  $this->db->from("courses AS c");
		  if(isset($state_id)){
			  $this->db->join("course_credits AS cc","c.course_id = cc.course_id");
			  $this->db->where("cc.state_id",$state_id);
			  $this->db->group_by("cc.course_id"); 
		  } 
		  $this->db->where("c.course_status = 'active'");
		  $this->db->order_by("rand()");
		  $this->db->limit(3);
		  $query_course = $this->db->get();
			// echo $this->db->last_query();
		  if($query_course->num_rows()>0)
		  {
				return $query_course->result_array();
		  }else{
				return array();
		  }
	}	
	
	public function get_course_credits_count($courses_id,$state_id)
	{
		    $courses_id = explode(',',$courses_id);
		  	$this->db->select("SUM(credit_numbers) as total_credits");
			$this->db->from("course_credits");
			$this->db->where_in("course_id",$courses_id);
			$this->db->where("state_id",$state_id);
			$query_credits = $this->db->get();
			//echo $this->db->last_query(); echo "<br>";
			if($query_credits->num_rows() > 0)
			{
				foreach($query_credits->result_array() as $crecount)
				{
					if($crecount['total_credits']!='' || $crecount['total_credits']!='NULL' ){		
						return $crecount['total_credits'];   
					}else{
						return 0;
					}
				}
			}
			else
			{
				return array();
			}
			
	}
	
	public function get_course_faculties($faculties_id)
	{
		 $author_id = explode(',',$faculties_id);
		 if(is_array($author_id))
		 {
			 $this->db->select("f.*");
			 $this->db->from("faculty_members AS f");
			 $this->db->where_in("f.faculty_member_id",$author_id);
			 $this->db->order_by("f.first_name", "ASC");
			 $query_faculties = $this->db->get();
			 //echo $this->db->last_query();
			 if($query_faculties->num_rows()>0)
			 {
					return $query_faculties->result_array();
			 }else{
					return array();
			 }
		 }else{
			 return array();
		 }
		 
	}
	
	public function get_course_details($course_id,$purchase = 0)
	{
		 	$this->db->select("c.*");
			$this->db->from("courses AS c");
			$this->db->where("c.course_id",$course_id);
			if($purchase == 0)
			{
				$this->db->where("c.course_status = 'active'");
			}
			$this->db->order_by("c.course_name", "ASC");
			$this->db->limit(1);
			$query_course = $this->db->get();
			// echo $this->db->last_query();
			if($query_course->num_rows()>0)
			{
				return $query_course->result_array();
			}
			else
			{
				return array();
			}
	}
	public function get_chapter_questions($chapter_id,$course_id)
	{
		   $this->db->select("ch_que.*");
		   $this->db->from("chapter_review_questions AS ch_que");
		   $this->db->where("ch_que.course_id",$course_id);
		   $this->db->where("ch_que.chapter_id",$chapter_id);
		   $this->db->where("ch_que.rev_ques_status",'Active');
		   $query_chap = $this->db->get();
		   
		    if($query_chap->num_rows()>0)
			{
				return $query_chap->result_array();
			}
			else
			{
				return array();
			}
	}
	 
	public function get_text_doc($course_id)
	{
		   $this->db->select("doc.*");
		   $this->db->from("course_pdf AS doc");
		   $this->db->where("doc.course_id",$course_id);
		   $this->db->order_by("doc.course_id", "ASC");
		   $query_doc = $this->db->get();
		   
		    if($query_doc->num_rows()>0)
			{
				return $query_doc->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_video($course_id)
	{
		   $this->db->select("video.*");
		   $this->db->from("course_video AS video");
		   $this->db->where("video.course_id",$course_id);
		   $this->db->where("video.is_intro",'No');
		   $this->db->order_by("video.video_name", "ASC");
		   $query_video = $this->db->get();
		   
		    if($query_video->num_rows()>0)
			{
				return $query_video->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function course_list($states = '',$state_search = '',$order_name='course_name ASC',$course_types='',$format='',$faculty='',$creditlimt='',$coursereq='',$pageno=0)
	{
		    
			 $statesid = implode(",", $states);
			 $typeid = implode(",", $course_types);
			 $format_type = implode(",", $format);
			 $facultyid = implode(",", $faculty);
			 $reqid = implode(",", $coursereq);
			$where_cond_having='';
			 if($pageno != 0)
			 {
				$page_offset=($pageno) * 12; 
				$set_limit=' limit '.$page_offset.', 12'; 
			 }else{
				$set_limit=' limit 0, 12';  
			}
			 
			 
			 $where_cond='1=1';
			 if($order_name == 'credit_numbers ASC')
			 {  
				 $order_name1 = $order_name;
			 }
			 else
			 {  
			  	 $order_name1 = " CR.".$order_name;
			 }
			
			if( $statesid !='')
			{
				 $where_cond.=' AND CCR.`state_id` IN ('.$statesid.')';
			}
			 if( $typeid !='')
			{
				 $where_cond.=' AND CCR.`course_type` IN ('.$typeid.')';
			}
			 if( $format_type !='')
			{
				 $where_cond.=" AND FIND_IN_SET (course_format,'".$format_type."')";
			}
			if( $facultyid !='')
			{
				 $where_cond.=' AND CR.`course_author` IN ('.$facultyid.')';
			}
			if( $reqid !='')
			{
				 $where_cond.=' AND CR.`course_req` IN ('.$reqid.')';
			}
			if($state_search !='')
			{
				$where_cond.=' AND (CR.course_name LIKE "%'.$state_search.'%" OR CR.course_description LIKE "%'.$state_search.'%")';
			}
			
			$i=1;
			 if(sizeof($creditlimt) > 0)
			 {
				 foreach($creditlimt as $key => $credit)
				 {  
					if($i == 1)
					{
						if($credit == 6)
						{
							$where_cond_having.= ' Having ((credit_numbers >= '.$credit.') '; 
						}else{
						$where_cond_having.= ' Having ((credit_numbers >= '.$credit.' AND credit_numbers < '.(($credit)+1).') '; 
						}
					}else{
						if($credit == 6)
						{
							$where_cond_having.= ' OR (credit_numbers >= '.$credit.')'; 
						}else{
							
							$where_cond_having.= ' OR (credit_numbers >= '.$credit.' AND credit_numbers < '.(($credit)+1).')'; 
						}
						
					}
					
					$i=0;
				 }
				 $where_cond_having.=')';
			 }
			
			
	/*		switch ($creditlimt) {
				        
						case 1:
								$where_cond.= ' AND credit_numbers >= 1 AND credit_numbers < 2 ';
								break;
						case 2:
								$where_cond.= ' AND credit_numbers >= 2 AND credit_numbers < 3 ';
								break;
						case 3:
								$where_cond.= ' AND credit_numbers >= 3 AND credit_numbers < 4 ';
								break;
						case 4:
								$where_cond.= ' AND credit_numbers >= 4 AND credit_numbers < 5 ';
								break;	
						case 5:
								$where_cond.= ' AND credit_numbers >= 5 AND credit_numbers < 6 ';
								break;
						case 6:
								$where_cond.= ' AND credit_numbers >= 6';
								break;
						default:
							
						} */
		 	/*$this->db->select("c.*,ct.state_id");
			$this->db->join('courses AS c', 'ct.course_id = ct.course_id','inner');
			$this->db->from("course_credits AS ct");
			if($states!=''){
				$this->db->where_in("ct.state_id",$states);
			}
			if($state_search!=''){
				$this->db->where("(c.course_name LIKE '%".$state_search."%' OR c.course_description LIKE '%".$state_search."%')", NULL, FALSE);
			}
			$this->db->where("c.course_status = 'active'" );
			$this->db->group_by('ct.state_id');
			$this->db->order_by("c.course_name", "ASC");*/
	/*		if( $statesid =='')
			{
				$query='SELECT CR.*, CCR.state_id, SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR, courses CR WHERE CCR.course_id = CR.course_id GROUP BY course_id ORDER BY '.$order_name1.'' ;
			}
			elseif($state_search !='')
			{
				$query='SELECT CR.*, CCR.state_id, SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR, courses CR WHERE CCR.`state_id` IN ('.$statesid.') AND CCR.course_id = CR.course_id AND (CR.course_name LIKE "%'.$state_search.'%" OR CR.course_description LIKE "%'.$state_search.'%") GROUP BY course_id ORDER BY '.$order_name1.'' ;
			}
			else{
			$query='SELECT CR.*, CCR.state_id, SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR, courses CR WHERE CCR.`state_id` IN ('.$statesid.') AND CCR.course_id = CR.course_id GROUP BY course_id ORDER BY '.$order_name1.'' ;
			}*/
			
			 $query="SELECT CR.*, CCR.state_id, SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR, courses CR, credits_type CT WHERE ".$where_cond." AND CCR.course_id = CR.course_id AND CR.course_status = 'active' AND CT.type_id = CCR.course_type AND CT.active = 1 GROUP BY course_id ".$where_cond_having."  ORDER BY ".$order_name1."".$set_limit."" ;
			$query_courses = $this->db->query($query);
			 
			//echo $this->db->last_query();
			if($query_courses->num_rows()>0)
			{
				return $query_courses->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function course_total($states = '',$state_search = '',$order_name='course_name ASC',$course_types='',$format='',$faculty='',$creditlimt='',$coursereq='',$pageno=0)
	{
		    
			$where_cond_having='';
			 $statesid = implode(",", $states);
			 $typeid = implode(",", $course_types);
			 $format_type = implode(",", $format);
			 $facultyid = implode(",", $faculty);
			 $reqid = implode(",", $coursereq);
			 if($pageno != 0)
			 {
				$page_offset=($pageno) * 12; 
				$set_limit=' limit '.$page_offset.', 12'; 
			 }else{
				$set_limit=' limit 0, 12';  
			}
			 
			 
			 $where_cond='1=1';
			 if($order_name == 'credit_numbers ASC')
			 {  
				 $order_name1 = $order_name;
			 }
			 else
			 {  
			  	 $order_name1 = " CR.".$order_name;
			 }
			
			if( $statesid !='')
			{
				 $where_cond.=' AND CCR.`state_id` IN ('.$statesid.')';
			}
			 if( $typeid !='')
			{
				 $where_cond.=' AND CCR.`course_type` IN ('.$typeid.')';
			}
			 if( $format_type !='')
			{
				 $where_cond.=" AND FIND_IN_SET (course_format,'".$format_type."')";
			}
			if( $facultyid !='')
			{
				 $where_cond.=' AND CR.`course_author` IN ('.$facultyid.')';
			}
			if( $reqid !='')
			{
				 $where_cond.=' AND CR.`course_req` IN ('.$reqid.')';
			}
			if($state_search !='')
			{
				$where_cond.=' AND (CR.course_name LIKE "%'.$state_search.'%" OR CR.course_description LIKE "%'.$state_search.'%")';
			}
			
			 //echo "<pre>";print_r($creditlimt);die;
			 $i=1;
			 if(sizeof($creditlimt) > 0)
			 {
				 foreach($creditlimt as $key => $credit)
				 { 
					if($i == 1)
					{
						if($credit == 6)
						{
							$where_cond_having.= ' Having ((credit_numbers >= '.$credit.')'; 
						}else{
						$where_cond_having.= ' Having ((credit_numbers >= '.$credit.' AND credit_numbers < '.(($credit)+1).') '; 
						}
					}else{
						if($credit == 6)
						{  
							$where_cond_having.= ' OR (credit_numbers >= '.$credit.')'; 
						}else{
							
							$where_cond_having.= ' OR (credit_numbers >= '.$credit.' AND credit_numbers < '.(($credit)+1).')'; 
						}
						
					}
					
					$i=0;
				 }
				 $where_cond_having.=')';
			 }
	/*		switch ($creditlimt) {
				        
						case 1:
								$where_cond.= ' AND credit_numbers >= 1 AND credit_numbers < 2 ';
								break;
						case 2:
								$where_cond.= ' AND credit_numbers >= 2 AND credit_numbers < 3 ';
								break;
						case 3:
								$where_cond.= ' AND credit_numbers >= 3 AND credit_numbers < 4 ';
								break;
						case 4:
								$where_cond.= ' AND credit_numbers >= 4 AND credit_numbers < 5 ';
								break;	
						case 5:
								$where_cond.= ' AND credit_numbers >= 5 AND credit_numbers < 6 ';
								break;
						case 6:
								$where_cond.= ' AND credit_numbers >= 6';
								break;
						default:
							
						}*/ 
			
			 $query="SELECT CR.*, CCR.state_id, SUM(CCR.credit_numbers) AS credit_numbers  FROM `course_credits` CCR, courses CR WHERE ".$where_cond." AND CCR.course_id = CR.course_id AND CR.course_status = 'active' GROUP BY course_id ".$where_cond_having." ORDER BY ".$order_name1."" ;
			$query_courses = $this->db->query($query);
			
			//echo $this->db->last_query();die;
			if($query_courses->num_rows()>0)
			{
				return $query_courses->num_rows();
			}
			else
			{
				return 0;
			}
	}
	
	
	
	public function get_course_credits($courses,$state_id)
	{
		    $courses_id = explode(',',$courses);
		  	$this->db->select("SUM(credit_numbers) as total_credits");
			$this->db->from("course_credits");
			$this->db->where_in("course_id",$courses_id);
			$this->db->where("state_id",$state_id);
			$query_credits = $this->db->get();
			//echo $this->db->last_query(); echo "<br>";
			if($query_credits->num_rows() > 0)
			{
				foreach($query_credits->result_array() as $crecount)
				{
					if($crecount['total_credits']!='' || $crecount['total_credits']!='NULL' ){		
						return $crecount['total_credits'];   
					}else{
						return 0;
					}
				}
			}
			else
			{
				return array();
			}
			
	}
	
	public function course_type($credit_type_id = 0)
	{
		   
		 	$this->db->select("ct.type");
			$this->db->from("credits_type AS ct");
			$this->db->where("ct.active",'1');
			$this->db->where("ct.type_id",$credit_type_id);
			$this->db->order_by("ct.type_id", "ASC");
			$this->db->limit(1);
			$query_type = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query_type->num_rows()>0)
			{
				foreach($query_type->result_array() as $key => $val)
				{
					  return $val['type'];
				}
			}
			else
			{
				return array();
			}
	}
	
	public function get_course_types()
	{
		 	$this->db->select("ct.*");
			$this->db->from("credits_type AS ct");
			$this->db->where("ct.active",'1');
			$this->db->where("ct.grouped",'0');
			$this->db->order_by("ct.type", "ASC");
			$query_type = $this->db->get();
			
			if($query_type->num_rows()>0)
			{
				return $query_type->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	public function get_faculty_name($faculty)
	{
		     $fname=array();
             $facult=explode(",",$faculty);
			 //echo "<pre>";print_r($facult);die;
			 
			 foreach($facult as $val)
			 {
				$this->db->select('CONCAT(f.first_name," "'.',f.last_name) AS name', FALSE);
				$this->db->from("faculty_members AS f");
				
				$this->db->where("f.faculty_member_id",$val);
				$this->db->where("f.active",'1');
				$query_faculty = $this->db->get();
				//echo $this->db->last_query(); die;
				if($query_faculty->num_rows()>0)
				{
					$name=$query_faculty->result_array();
					$fname[]=$name[0]['name'];
				}
				//echo $this->db->last_query(); die;
				
			 }
			
			 //echo "<pre>";print_r($fname);die;
		return $fname;
	}
	
	
	public function get_course_requirement()
	{
		 	$this->db->select("cr.*");
			$this->db->from("course_requirments AS cr");
			
			$this->db->order_by("cr.req_id", "ASC");
			$query_req = $this->db->get();
			
			if($query_req->num_rows()>0)
			{
				return $query_req->result_array();
			}
			else
			{
				return array();
			}	
	}
	
	public function check_mycourse($course_id,$customer_id)
	{
				 $this->db->select("COUNT(id) AS mycourse");
				 $this->db->from("user_courses");
				 $this->db->where("course_id",$course_id);
				 $this->db->where("user_id",$customer_id);
				 $this->db->where("course_status NOT IN ('Completed','Expired')");
				 $cquery = $this->db->get();
				  //echo $this->db->last_query();die;
				 if($cquery->num_rows()>0)
				 {
					foreach($cquery->result_array() as $key => $ccount)
					{
					 	return $ccount;	
					}
				 }
				 else{
					return array();
				 } 
	}
	
	public function get_faculty()
	{
		 	$this->db->select("f.faculty_member_id,f.first_name,f.last_name");
			$this->db->from("faculty_members AS f");
			$this->db->where("f.active",'1');
			$this->db->order_by("f.last_name", "ASC");
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
	
}
?>