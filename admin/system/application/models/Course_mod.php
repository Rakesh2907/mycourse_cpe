<?php 
class Course_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function course_count()
	{
		  $this->db->select("COUNT(course_id) AS total_courses");
		  $this->db->from("courses");
		  $this->db->where("course_status <> 'deleted'");
		  $query_course = $this->db->get();
		 // echo $this->db->last_query();
		  if($query_course->num_rows()>0)
		  {
				foreach($query_course->result_array() as $key => $valcount)
				{
					 return $valcount;	
				}
		  }else{
				return array();
		  }
	}
	
	public function add_course($data_insert)
	{
		 	$this->db->insert('courses', $data_insert); 
			$course_id =  $this->db->insert_id();
			return $course_id;
	}
	
	public function update_course($data_update,$id)
	{
		  	$this->db->where("course_id", $id);
		 	$this->db->update("courses", $data_update); 
		 	return $id;
	}
	
	public function add_credits($data_insert)
	{
			$this->db->insert('course_credits', $data_insert); 
			$credit_id =  $this->db->insert_id();
			return $credit_id;
	}
	
	public function update_credits($data_update,$credit_id)
	{
		 	$this->db->where("id", $credit_id);
			$this->db->update("course_credits", $data_update); 
		 	return $credit_id;
	}
	
	public function add_pdf($data_insert)
	{
			$this->db->insert('course_pdf', $data_insert); 
			$pdf_id =  $this->db->insert_id();
			return $pdf_id;
	}
	
	public function update_pdf($data_update,$pdf_id,$course_id)
	{
		  	$this->db->where("id", $pdf_id);
			$this->db->where("course_id", $course_id);
			$this->db->update("course_pdf", $data_update); 
		 	return $pdf_id;
	}
	
	public function add_course_video($data_insert)
	{
			$this->db->insert('course_video', $data_insert); 
			$video_id =  $this->db->insert_id();
			return $video_id;
	}
	
	public function update_course_video($data_update,$video_id,$course_id)
	{
		    $this->db->where("id", $video_id);
			$this->db->where("course_id", $course_id);
			$this->db->update("course_video", $data_update); 
			return $video_id;
	}
	
	public function exits_credit($data_insert)
	{
			  $this->db->select("cr.*");
			  $this->db->from("course_credits AS cr");
			  $this->db->where("cr.course_id",$data_insert['course_id']);
			  $this->db->where("cr.course_type",$data_insert['course_type']);
			  $this->db->where("cr.state_id",$data_insert['state_id']);
			 // $this->db->where("cr.credit_numbers",trim($data_insert['credit_numbers']));
			  
			  $query_credits = $this->db->get();
			
			  if($query_credits->num_rows() > 0)
			  {
					return true;
			  }else{
					return false;
			  }
			  
			  
	}
	
	public function get_credits($id)
	{
		    $this->db->select("cr.id,cr.course_type,cr.state_id,cr.credit_numbers,ct.type,us.state");
			$this->db->from("course_credits AS cr");
			$this->db->join("credits_type AS ct", 'ct.type_id = cr.course_type', 'inner');
			$this->db->join("us_state AS us", 'us.state_id = cr.state_id', 'inner');
			$this->db->where("ct.active",'1');
			$this->db->where("cr.id",$id);
			$this->db->limit(1);
			$credits = $this->db->get();
			//echo $this->db->last_query(); die;
			if($credits->num_rows()>0)
			{
				return $credits->result_array();
			}
			else
			{
				return 0;
			}
	}
	
	public function get_state_credit($course_id)
	{
		    $this->db->select("cr.id,cr.course_id,cr.course_type,cr.state_id,cr.credit_numbers,ct.type,us.state");
			$this->db->from("course_credits AS cr");
			$this->db->join("credits_type AS ct", 'ct.type_id = cr.course_type', 'inner');
			$this->db->join("us_state AS us", 'us.state_id = cr.state_id', 'inner');
			$this->db->where("ct.active",'1');
			$this->db->where("cr.course_id",$course_id);
			$credits = $this->db->get();
			//echo $this->db->last_query(); die;
			if($credits->num_rows()>0)
			{
				return $credits->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_state_credit_dublicate($course_id)
	{
			$this->db->select("cr.*");
			$this->db->from("course_credits AS cr");
			$this->db->where("cr.course_id",$course_id);
			$credits = $this->db->get();
			//echo $this->db->last_query(); die;
			if($credits->num_rows()>0)
			{
				return $credits->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_credit_types()
	{
		    $this->db->select('type_id,type,active');
			$this->db->from('credits_type');
			$this->db->where('active','1');
			$this->db->order_by('type','ASC');
			$faculty = $this->db->get();
			
			if($faculty->num_rows()>0)
			{
				return $faculty->result_array();
			}
			else
			{
				return 0;
			}
	}
	
	public function get_faculty()
	{
			$this->db->select('*');
			$this->db->from('faculty_members');
			$this->db->where('active','1');
			$this->db->order_by('first_name','ASC');
			$faculty = $this->db->get();
			
			if($faculty->num_rows()>0)
			{
				return $faculty->result_array();
			}
			else
			{
				return array();
			}
			
	}
	
	public function get_file_extension($filename)
	{
		 	$data = array();
			$data = explode(".",$filename);
			return $data[1];
	}
	
	public function get_all_courses()
	{
		    $this->db->select("c.*");
			$this->db->from("courses AS c");
			$this->db->where("c.course_status != 'deleted'");
			$this->db->order_by('c.course_name ASC');
			$query_course = $this->db->get();
			
			if($query_course->num_rows()>0)
			{
				return $query_course->result_array();
			}
			else
			{
				return false;
			}
	}
	
	public function get_course_details($course_id)
	{
		    $this->db->select('c.*');
			$this->db->from('courses'." AS c");
			$this->db->where('c.course_id',$course_id);
			$query_course = $this->db->get();
			if($query_course->num_rows()>0)
			{
				return $query_course->result_array();
			}
			else
			{
				return false;
			}
	}
	
	public function get_pdf_details($course_id,$pdf_id = 0)
	{
			$this->db->select("cpdf.*");
			$this->db->from("course_pdf AS cpdf");
			if($pdf_id != 0){
				$this->db->where('cpdf.id',$pdf_id);
			}
			$this->db->where('cpdf.course_id',$course_id);
			if($pdf_id != 0){
				$this->db->limit(1);
			}
			$query_coursepdf = $this->db->get();
			
			if($query_coursepdf->num_rows()>0)
			{
				return $query_coursepdf->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_video_details($course_id,$video_id = 0)
	{
		  	$this->db->select("cv.*");
			$this->db->from("course_video AS cv");
			if($video_id != 0){
				$this->db->where('cv.id',$video_id);
			}
			$this->db->where('cv.course_id',$course_id);
			if($video_id != 0){
				$this->db->limit(1);
			}
			$query_coursevideo = $this->db->get();
			
			if($query_coursevideo->num_rows()>0)
			{
				return $query_coursevideo->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function delete_course($course_id)
	{
		  $this->db->where("course_id", $course_id);
		  $data_update = array('course_status' => 'deleted');
		  $this->db->update("courses", $data_update);
		  return 1;
	}
	
	public function delete_credit($course_id,$credit_id)
	{
		   $query = $this->db->delete('course_credits',array('id'=>$credit_id,'course_id'=>$course_id));
		   return $query;
	}
	
	public function delete_video($course_id,$video_id)
	{
		   $query = $this->db->delete('course_video',array('id'=>$video_id,'course_id'=>$course_id));
		   if($query)
		   {    
		   		$query1 = $this->db->delete('course_progress',array('video_pdf_id'=>$video_id,'course_id'=>$course_id,'completed_percentage'=>'0','material_type'=>'Video'));
		   }
		   return $query;
		   
	}
	
	public function delete_pdf($course_id,$pdf_id)
	{
		   $query = $this->db->delete('course_pdf',array('id'=>$pdf_id,'course_id'=>$course_id));
		   return $query;
	}
	
	public function get_course_faculties($faculties_id)
	{
		 $faculties_id = explode(',',$faculties_id);
		 $this->db->select("f.*");
		 $this->db->from("faculty_members AS f");
		 $this->db->where_in("f.faculty_member_id",$faculties_id);
		 $query_course = $this->db->get();
		 //echo $this->db->last_query();
		 if($query_course->num_rows()>0)
		 {
				return $query_course->result_array();
		 }else{
				return array();
		  }
	}
	
	//shailesh code
	 public function get_all_course_quest($courseid)
	 {		
			$this->db->select('cq.*,c.course_name');
			$this->db->from('course_exam_questions AS cq');
			$this->db->join('courses AS c', 'cq.course_id = c.course_id', 'inner');
			$this->db->where('cq.course_id', $courseid);
			$this->db->order_by('cq.ques_id','DESC');
			//$this->db->where('cq.ques_status','Active');
			$query_course_quest = $this->db->get();
			if($query_course_quest->num_rows()>0)
			{
				return $query_course_quest->result_array();
			}
			else
			{
				return array();
			}
	 }
	
	public function add_course_question($data_insert)
	{
		 	$this->db->insert('course_exam_questions', $data_insert); 
			$question_id =  $this->db->insert_id();
			return $question_id;
	}
	
    public function get_question($id)
	 {
			$this->db->select("c.*");
			$this->db->from("course_exam_questions AS c");
			$this->db->where("c.ques_id",$id);
			$query_question = $this->db->get();
			if($query_question->num_rows()>0)
			{
				return $query_question->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function update_question($data_update,$id)
	 {
		 $this->db->where("ques_id", $id);
		 $this->db->update("course_exam_questions", $data_update); 
		 return $id;
	 }
	 
	 public function delete_single_question($course_id,$ques_id)
	 {
		 	 $this->db->where("ques_id", $ques_id);
			 $this->db->where("course_id", $course_id);
			 $data_update = array('ques_status' => 'deleted');
		 	 $this->db->update("course_exam_questions", $data_update);
			 return 1;
	 }
	 
	 // Course Chapter section	 
	 public function get_all_course_chapter($courseid)
	 {
			
			$this->db->select('cp.*,c.course_name');
			$this->db->from('course_chapters AS cp');
			$this->db->join('courses AS c', 'cp.course_id = c.course_id', 'inner');
			$this->db->where('cp.course_id', $courseid);
			$this->db->order_by('cp.order_seq','ASC');
			$this->db->where('cp.status','Active');
			$query_course_quest = $this->db->get();
			if($query_course_quest->num_rows()>0)
			{
				return $query_course_quest->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	public function add_course_chapter($data_insert)
	{
		 	$this->db->insert('course_chapters', $data_insert); 
			$chapter_id =  $this->db->insert_id();
			return $chapter_id;
	}
	
    public function get_chapter($id)
	 {
			$this->db->select("c.*");
			$this->db->from("course_chapters AS c");
			$this->db->where("c.chapter_id",$id);
			$query_chapter = $this->db->get();
			if($query_chapter->num_rows()>0)
			{
				return $query_chapter->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function update_chapter($data_update,$id)
	 {
		 $this->db->where("chapter_id", $id);
		 $this->db->update("course_chapters", $data_update); 
		 return $id;
	 }
	 
	 public function delete_single_chapter($id)
	 {
		 	 $this->db->where("chapter_id", $id);
			 $data_update = array('status' => 'Deleted');
		 	 $this->db->update("course_chapters", $data_update);
	 }
	 
	 //Chapter Question Section
	public function get_chapter_quest($chapterid)
	{
		 
		 $this->db->select('cr.*,c.chapter_name');
		 $this->db->from('chapter_review_questions AS cr');
		 $this->db->join('course_chapters AS c', 'cr.chapter_id = c.chapter_id', 'inner');
		 $this->db->where('cr.chapter_id', $chapterid);
		 $this->db->where('cr.rev_ques_status','Active');
		 $this->db->order_by('cr.rev_ques_id','DESC');
		
		 $query_chapter_ques = $this->db->get();
		 if($query_chapter_ques->num_rows()>0)
			{
				return $query_chapter_ques->result_array();
			}
			else
			{
				return array();
			}
	}
	
	
	 public function get_courseid($id)
	 {
			$this->db->select("c.course_id");
			$this->db->from("course_chapters AS c");
			$this->db->where("c.chapter_id",$id);
			$query_question = $this->db->get();
			if($query_question->num_rows()>0)
			{
				return $query_question->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	public function add_chapter_question($data_insert)
	{
		 	$this->db->insert('chapter_review_questions', $data_insert); 
			$chapter_id =  $this->db->insert_id();
			return $chapter_id;
	}

    public function get_chapter_question($id)
	 {
			$this->db->select("c.*");
			$this->db->from("chapter_review_questions AS c");
			$this->db->where("c.rev_ques_id",$id);
			$query_question = $this->db->get();
			if($query_question->num_rows()>0)
			{
				return $query_question->result_array();
			}
			else
			{
				return array();
			}
	 }	
	
	 public function update_chapter_question($data_update,$id)
	 {
		 $this->db->where("rev_ques_id", $id);
		 $this->db->update("chapter_review_questions", $data_update); 
		 return $id;
	 }
	 
	 public function delete_single_chapter_question($id)
	 {
		 	 $this->db->where("rev_ques_id", $id);
			 $data_update = array('rev_ques_status' => 'Deleted');
		 	 $this->db->update("chapter_review_questions", $data_update);
	 }
	 
	 /*
	 # Function returns the course requirments array
	 # Table: course_requirments
	 */
	 public function get_course_requirments()
	{
			$this->db->select('*');
			$this->db->from('course_requirments');
			$this->db->order_by('req_name','ASC');
			$faculty = $this->db->get();
			
			if($faculty->num_rows()>0)
			{
				return $faculty->result_array();
			}
			else
			{
				return array();
			}
			
	}
	
	public function update_chapter_order($id,$order)
	{
		  	$this->db->where("chapter_id", $id);
			$data_update = array('order_seq' => $order);
		 	$this->db->update("course_chapters", $data_update); 
		 	return $id;
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
	
	public function get_course_credits($courses_id,$state_id)
	{
		  $this->db->select("c.course_id, c.course_type, c.credit_numbers, us.state_id, us.state, us.state_abbr, ct.type");
		  $this->db->join('credits_type AS ct', 'c.course_type = ct.type_id','inner');
		  $this->db->join('us_state AS us', 'c.state_id = us.state_id','inner');
		  $this->db->from("course_credits AS c");
		  $this->db->where("ct.active = '1'");
		  $this->db->where("course_id",$courses_id);
		  $this->db->where("c.state_id",$state_id);
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
	
	public function state_courses($state_id)
	{
		  $this->db->select("c.course_id, c.course_type, c.credit_numbers, us.state_id, us.state, us.state_abbr, ct.type, cou.course_id, cou.course_name, cou.cpe_credits");
		  $this->db->join("courses AS cou", "c.course_id = cou.course_id",'inner');
		  $this->db->join("credits_type AS ct", "c.course_type = ct.type_id",'inner');
		  $this->db->join('us_state AS us', 'c.state_id = us.state_id','inner');
		  $this->db->from("course_credits AS c");
		  $this->db->where("ct.active = '1'");
		  $this->db->where("c.state_id",$state_id);
		  $this->db->where("cou.course_status",'active');
		  $this->db->group_by("cou.course_id");
		  $this->db->order_by("us.state", " ASC");
		  $myquery = $this->db->get();
		 //echo $this->db->last_query();
		 
		 if($myquery->num_rows()>0)
	     {
				return $myquery->result_array();
		 }else{
				return array();
		 }  
		 
	}
	
	
}
?>