<?php 
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Customer_mod.php
# Created on : 9th Sep 2016 by Rakesh Ahirrao
# Update on : 4th Oct 2016 by Rakesh Ahirrao
# Purpose : Customer related functionality like Registration,Login,Forgotpassword etc.
*/

class Customer_mod extends CI_Model
{
	protected $table_faq 	= 'faq_management';
	
	function __construct()
	{
		parent::__construct();
	}
   
    public function add_customer($data)
	 {
		   $this->db->insert("customers", $data); 
		   return $this->db->insert_id();
	 }
   
    public function get_customer_details($cust_id)
	{
			$this->db->select("c.*");
			$this->db->from("customers AS c");
			$this->db->where("delete_flg", "0");
			$this->db->where("id", $cust_id);
			$query_customer = $this->db->get();
			 //echo $this->db->last_query(); die;
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}
	}
	
    public function already_exists($email)
	 {
			$this->db->select("c.email");
			$this->db->from("customers AS c");
			$this->db->where("delete_flg", "0");
			$this->db->where("email", $email);
			$query_customer = $this->db->get();
			 //echo $this->db->last_query(); die;
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}	  
	 }	
	 
	public function get_customer_from_field($field='',$value='')
	 {
			$this->db->select("c.*");
			$this->db->from("customers AS c");
			$this->db->where("delete_flg", "0");
			$this->db->where($field, $value);
			$this->db->limit(1);
			$query_customer = $this->db->get();
			 //echo $this->db->last_query(); die;
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}	  
	 }	
	 
	public function update_token($email,$code)
	{
		$this->db->where('email', $email);
		$query = $this->db->get("customers");
		if($query->num_rows() > 0)
		{		$this->db->set('token', $code);
				$this->db->where('email', $email);
				return $this->db->update('customers');
		}
		else 
		{ 
				return false; 
		}
	}
	
	public function get_course_evalution($user_id,$user_course_id)
	{
		  	$this->db->select("ce.*");
			$this->db->from("course_evalution AS ce");
			$this->db->where("ce.user_id", $user_id);
			$this->db->where("ce.user_course_id", $user_course_id);
			$query_review = $this->db->get();
		    //echo $this->db->last_query(); die;
			if($query_review->num_rows()>0)
			{
				 return $query_review->result_array(); 
		    }else{
				 return array();
			}   
	}
	
	public function insert_review($data_insert,$user_id,$user_course_id)
	{
		   	$this->db->select("cv.*");
			$this->db->from("course_evalution AS cv");
			$this->db->where("cv.user_id", $user_id);
			$this->db->where("cv.user_course_id", $user_course_id);
			$query_review = $this->db->get();
		    //echo $this->db->last_query(); die;
			if($query_review->num_rows()>0)
			{    
			     $this->db->set('ques1', $data_insert['ques1']);
				 $this->db->set('ques2', $data_insert['ques2']);
				 $this->db->set('ques3', $data_insert['ques3']);
				 $this->db->set('ques4', $data_insert['ques4']);
				 $this->db->set('ques5', $data_insert['ques5']);
				 $this->db->set('ques6', $data_insert['ques6']);
			     $this->db->set('notes', $data_insert['notes']);
				 $this->db->where("user_id", $user_id);
				 $this->db->where("user_course_id", $user_course_id);
				 $this->db->update('course_evalution');	
				 return 1;
			}else
			{
				 $this->db->insert("course_evalution", $data_insert); 
				 return $this->db->insert_id();  
			}
	}
	
	public function get_completed_courses($user_id,$from_date='',$end_date='',$sort='')
	{
		   $this->db->select("uc.*,c.course_name");
		   $this->db->from("user_courses AS uc");
		   $this->db->join("courses AS c", 'uc.course_id = c.course_id', 'inner');
		   $this->db->where("uc.user_id", $user_id);
		   $this->db->where("uc.course_status", 'Completed');
		   if($from_date!='' && $end_date!='')
		   {
			   $this->db->where("uc.completed_date BETWEEN '".$from_date."' and '".$end_date."'");
		   }else{
		   
			   if($from_date!='')
			   {
				   $this->db->where("uc.completed_date",$from_date);
			   }
			   
			   if($end_date!='')
			   {
				   $this->db->where("uc.completed_date",$end_date);
			   }
		   }
		   if($sort!='')
		   {
			   if($sort == 'ASC')
			   {
				  $this->db->order_by("c.course_name ".$sort.""); 
			   }else if($sort == 'DESC')
			   {
				  $this->db->order_by("c.course_name ".$sort.""); 
			   }else if($sort == 'new'){
				   $this->db->order_by("uc.id DESC"); 
			   }else if($sort == 'old'){
				   $this->db->order_by("uc.id ASC");
			   }
		   }
		   //
		   $query_clist = $this->db->get();
		    //echo $this->db->last_query(); die;
		   if($query_clist->num_rows()>0)
		   {
				return $query_clist->result_array();
		   }else
		   {
				return array();
		   }
		   
	}
	
	public function get_percetage($material_id,$course_id,$usercourseid,$user_id,$type)
	{
			$this->db->select("cp.*");
			$this->db->from("course_progress AS cp");
			$this->db->where("video_pdf_id", $material_id);
			$this->db->where("course_id", $course_id);
			$this->db->where("user_course_id", $usercourseid);
			$this->db->where("user_id", $user_id);
			$this->db->where("material_type", $type);
			$this->db->limit(1);
			$query_per = $this->db->get();
			if($query_per->num_rows()>0)
			{
				return $query_per->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function user_course($user_course_id,$user_id)
	{
		   	  $this->db->select('*');
		 	  $this->db->where('id', $user_course_id);
			  $this->db->where('user_id',$user_id);
			  $this->db->limit(1);
			  $query_user_course = $this->db->get('user_courses');
			  // echo $this->db->last_query(); die;
			  if($query_user_course->num_rows() > 0)
			  {
					return $query_user_course->result_array();
			  }
			  else
			  {
				 	return array();
			  }
			  
	}
	
	public function store_video_details($video_id,$course_id,$user_course_id,$user_id,$type,$current_percentage,$played_time)
	{
		    $this->db->select('*');
		 	$this->db->where('course_id', $course_id);
		 	$this->db->where('video_pdf_id',$video_id);
		 	$this->db->where('user_id',$user_id);
		 	$this->db->where('user_course_id',$user_course_id);
			$this->db->where('material_type',$type);
		 	$details = $this->db->get('course_progress');
			
			$tracking_data['completed_percentage'] = $current_percentage;
			$tracking_data['video_played_time'] = $played_time;
			
			if($details->num_rows() > 0)
			{
				$mydata = $details->result_array();
				if($mydata[0]['completed_percentage']!=100)
				{
					$this->db->where('course_id', $course_id);
				    $this->db->where('video_pdf_id',$video_id);
					$this->db->where('user_id', $user_id);
					$this->db->where('user_course_id',$user_course_id);
					$this->db->where('material_type',$type);
					$result = $this->db->update('course_progress',$tracking_data);
				}
			}else{
				
			}
			
	}
	
	public function update_course_status($course_id,$usercourseid,$user_id)
	{
			  $this->db->select('*');
		 	  $this->db->where('course_id', $course_id);
			  $this->db->where('user_id',$user_id);
		 	 // $this->db->where('order_id',$order_id);
			  $this->db->where('id',$usercourseid);
			  $mydetails = $this->db->get('user_courses');
			  
			  if($mydetails->num_rows() > 0)
			  {
				   $mydata = $mydetails->result_array();
				   if($mydata[0]['course_status'] == 'Not Started')
				   {
					    $status_data['course_status'] = 'In-Progress';
					    $this->db->where('course_id', $course_id);
					    $this->db->where('user_id', $user_id);
						//$this->db->where('order_id',$order_id);
						$this->db->where('id',$usercourseid);
					    $result = $this->db->update('user_courses',$status_data);
				   }
			  }
			  
	}
	
	public function review_questions($chapter_id,$user_course_id,$user_id,$course_id)
	{
		      $this->db->select('*');
			  $this->db->where('course_id', $course_id);
			  $this->db->where('user_id', $user_id);
			  $this->db->where('user_course_id', $user_course_id);
			  $this->db->where('chapter_id', $chapter_id);
			 // $this->db->where('status', 'pending');
			  $this->db->limit(1);
			  $chpdetails = $this->db->get('user_courses_chapter_progress');
			  if($chpdetails->num_rows() > 0)
			  {
				   $mydata = $chpdetails->result_array();  
				   if($mydata[0]['status'] == 'pending')
				   {
					   foreach($mydata as $key => $chap)
					   {
							return $chap['id'];
					   } 
				   }else{
					   return 0;
				   }
				   
			  }else
			  {
				  $data_insert['user_id'] = $user_id;
				  $data_insert['user_course_id'] = $user_course_id;
				  $data_insert['course_id'] = $course_id;
				  $data_insert['chapter_id'] = $chapter_id;
				  $data_insert['status'] = 'pending';
				  $this->db->insert("user_courses_chapter_progress", $data_insert); 
		   		  return $this->db->insert_id();
			  }
			  
			  
	}
	
	public function get_correct_ans($user_courses_id,$user_id,$chapter_id)
	{
			$this->db->select("uc.*,cp.*");
			$this->db->from("user_courses_chapter_progress AS uc");
			$this->db->join("course_chapter_review_progress AS cp", 'cp.user_course_chapter_id = uc.id', 'inner');
			$this->db->where("uc.user_course_id",$user_courses_id);
			$this->db->where("uc.user_id",$user_id);
			$this->db->where("uc.chapter_id",$chapter_id);
			//$this->db->order_by('oc.id DESC');
			$query_ans = $this->db->get();
			  //echo $this->db->last_query(); //die;
			if($query_ans->num_rows()>0)
			{
				return $query_ans->result_array();
			}
			else
			{
				return array();
			} 
			  
	}
	
	public function insert_review_ans($data_inset)  
	{
	          $this->db->select('*');
			  $this->db->where('user_course_chapter_id', $data_inset['user_course_chapter_id']);
			  $this->db->where('question_id', $data_inset['question_id']);
			  $this->db->where('answer_id', $data_inset['answer_id']);
			  $this->db->where('user_id', $data_inset['user_id']);
			  $this->db->limit(1);
			  $chpdetails = $this->db->get('course_chapter_review_progress');
			  if($chpdetails->num_rows() > 0)
			  {
			  }else{
		 		$this->db->insert("course_chapter_review_progress",$data_inset);
		  		return $this->db->insert_id();
			  }	
	}
	
	public function insert_exam_ans($data_inset)
	{
		    $this->db->insert("users_exam_progress",$data_inset);
		    return $this->db->insert_id();
	}
	
	public function get_review_answers($chapter_id,$user_courses_id,$user_id)
	{
			$this->db->select("uc.*,cp.*");
			$this->db->from("user_courses_chapter_progress AS uc");
			$this->db->join("course_chapter_review_progress AS cp", 'cp.user_course_chapter_id = uc.id', 'inner');
			$this->db->where("uc.user_course_id",$user_courses_id);
			$this->db->where("uc.user_id",$user_id);
			$this->db->where("uc.chapter_id",$chapter_id);
			//$this->db->order_by('oc.id DESC');
			$query_ans = $this->db->get();
			  //echo $this->db->last_query(); //die;
			if($query_ans->num_rows()>0)
			{
				return $query_ans->result_array();
			}
			else
			{
				return array();
			} 
	}
	
	public function chapter_progress_count($course_id,$user_course_id,$user_id,$ajax = 0)
	{
		         $this->db->select("COUNT(id) AS progress");
				 $this->db->from("user_courses_chapter_progress");
				 $this->db->where("user_course_id",$user_course_id);
				 $this->db->where("user_id",$user_id);
				 $this->db->where("course_id",$course_id);
				 if($ajax != 1){
					 $this->db->where("status",'completed');
			     }
				 $this->db->limit(1);
				 $query_items = $this->db->get();
				  //echo $this->db->last_query();
				 if($query_items->num_rows()>0){
					foreach($query_items->result_array() as $key => $valcount)
					{
					 	return $valcount['progress'];	
					}
				 }
				 else{
					return array();
				 }
			
	}
	
	public function get_exam_answer($question_id,$user_ans)
	{
		      $this->db->select('*');
			  $this->db->where('ques_id', $question_id);
			  $this->db->where('correct_ans_id', $user_ans);
			  $this->db->limit(1);
			  $quedetails = $this->db->get('course_exam_questions');  
			   // echo $this->db->last_query();
			  if($quedetails->num_rows() > 0){
				  return 1;
			  }else{
				  return 0;
			  }
	}
	
	public function insert_user_credits($user_id,$creadit_type_id,$states_id,$cpoints,$completed_date,$user_course_id)
	{
		   $data_insert['user_id'] = $user_id;
		   $data_insert['type_id'] = $creadit_type_id;
		   $data_insert['state_id'] = $states_id;
		   $data_insert['total_points'] = $cpoints;
		   $data_insert['credit_date'] = $completed_date;
		   $data_insert['course_type'] = 'internal';
		   $data_insert['user_course_id'] = $user_course_id;
		   $this->db->insert("user_credits", $data_insert); 
		   return $this->db->insert_id();
		   
	}
	
	public function customer_notes($data_insert)
	{
		$this->db->insert("user_course_notes", $data_insert); 
		return $this->db->insert_id();
	}
	
	public function get_user_course_notes($user_id,$user_course_id,$video_id)
	{
		  	 	 $this->db->select("*");
				 $this->db->from("user_course_notes");
				 $this->db->where("user_course_id",$user_course_id);
				 $this->db->where("user_id",$user_id);
				 $this->db->where("video_id",$video_id);
				 $this->db->order_by("date_time","DESC");
				 $this->db->order_by("notes_time","DESC");
				 $query_notes = $this->db->get();
				 if($query_notes->num_rows()>0)
				 {
					return $query_notes->result_array();
				 }
				 else{
					return array();
				 }
	}
	
	public function get_user_course_notes_spread_sheet($user_id,$user_course_id,$video_id)
	{
		  	 	 $this->db->select("notes,date_time,video_seconds");
				 $this->db->from("user_course_notes");
				 $this->db->where("user_course_id",$user_course_id);
				 $this->db->where("user_id",$user_id);
				 $this->db->where("video_id",$video_id);
				 $this->db->order_by("id","DESC");
				 $query_notes = $this->db->get();
				 if($query_notes->num_rows()>0)
				 {
					return $query_notes->result_array();
				 }
				 else{
					return array();
				 }
	}
	
	
	public function delete_notes($user_id,$notes_id)
	{
		  $query = $this->db->delete('user_course_notes',array('id'=>$notes_id,'user_id' =>$user_id));
		  return $query;
	}
	
	public function update_notes($edit_notes,$notes_id,$user_id)
	{
		   $update_notes = "UPDATE `user_course_notes` SET `notes` = '".$edit_notes."' WHERE `user_id` = ".$user_id." AND `id` = ".$notes_id."";
		   $Q = $this->db->query($update_notes);
	}
	
	public function update_review_exam_course_status($course_id,$user_course_id,$user_id)
	{
		 $update_coures = "UPDATE `user_courses` SET `review_percentage` = 25, `review_competed_date` = '".date('Y-m-d')."' WHERE `user_id` = ".$user_id." AND `id` = ".$user_course_id." AND `course_id` = ".$course_id." AND `review_percentage` = '0'";
		 $Q = $this->db->query($update_coures);
	}
	
	public function update_final_exam_course_status($course_id,$user_course_id,$user_id,$pdf_name)
	{
		 $update_coures = "UPDATE `user_courses` SET `exam_percentage` = 25, `course_status` = 'Completed', `completed_date` = '".date('Y-m-d')."'  WHERE `user_id` = ".$user_id." AND `id` = ".$user_course_id." AND `course_id` = ".$course_id." AND `exam_percentage` = '0'";
		 $Q = $this->db->query($update_coures);
	}
	
	public function update_chapter_status($chapter_id,$user_course_id,$user_id,$course_id)
	{
		     $update_ch = "UPDATE `user_courses_chapter_progress` SET `status` = 'completed' WHERE `user_id` = ".$user_id." AND `user_course_id` = ".$user_course_id." AND `course_id` = ".$course_id." AND `status` = 'pending' AND `chapter_id` = ".$chapter_id."";
			 $Q = $this->db->query($update_ch);
	}
	
	public function update_percentage($material_id,$course_id,$usercourseid,$user_id,$type)
	{
			 $update_per = "UPDATE `course_progress` SET `completed_percentage` = '100' WHERE `user_id` = ".$user_id." AND `user_course_id` = ".$usercourseid." AND `course_id` = ".$course_id." AND `video_pdf_id` = ".$material_id." AND `material_type` = '".$type."'";
			 $Q = $this->db->query($update_per);
			 return 1;
	}
	
   public function reset_password($data_update,$id)
	{ 
	  $this->db->where("id", $id);
	  $id=$this->db->update('customers',$data_update);
	  return $id;
	} 
	 public function get_admin_email()
	 {
			$this->db->select("a.email");
			$this->db->from("admin AS a");
			//$this->db->where("c.course_id",$id);
			$query_admin = $this->db->get();
			if($query_admin->num_rows()>0)
			{
				return $query_admin->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function check_login($username,$password)
	{
		    $this->db->where('username', $username);
			$this->db->where('password', md5($password));
			$this->db->where("delete_flg", "0");
			$this->db->where("active", "1");
			$this->db->limit(1);
			$query = $this->db->get('customers');
			//$this->db->last_query();
			if($query->num_rows() > 0)
		    {
				foreach($query->result_array() as $row)
				{
					
					$arr_session = array('user_id'=> $row['id'],
										   'user_email'=> $row['username'],
										   'user_name'=> $row['first_name'],
										   'is_login'=>'1'
										   );			
					$this->session->sess_expiration = 172800; 			
					$this->session->set_userdata($arr_session);
				}
				return $query->result_array();
			}else{
				return array();
			}	
	}
	
	public function update_payment($payment_status,$cust_id,$prices,$order_id)
	{
		if($payment_status->status=='succeeded')
		{
			$update_status = "UPDATE `user_orders` SET `txn_number` = '".$payment_status->id."', `order_status` = 'Completed', `discount` = '".$prices['discount_amount']."', `coupon_id` = '".$prices['coupon_id']."', `order_tax` = '".$prices['tax_amount']."', `final_total` = '".$prices['new_amount']."' WHERE `user_id` = ".$cust_id." AND `order_id` = ".$order_id."";
			$Q = $this->db->query($update_status);
		}else if($payment_status['status'] == 'Completed')
		{
			$update_status = "UPDATE `user_orders` SET `txn_number` = '".$payment_status['txn_id']."', `order_status` = 'Completed', `discount` = '".$prices['discount_amount']."', `coupon_id` = '".$prices['coupon_id']."', `order_tax` = '".$prices['tax_amount']."', `final_total` = '".$prices['new_amount']."' WHERE `user_id` = ".$cust_id." AND `order_id` = ".$order_id."";
			$Q = $this->db->query($update_status);
		}
	}
	
	public function update_strip_id($strip_id,$cust_id)
	{
		$update_strip =  "UPDATE `customers` SET `stripe_id` = '".$strip_id."' WHERE `id` = ".$cust_id." AND `active` = '1'";
	    $Q = $this->db->query($update_strip);
	}
	
	public function update_cart($cust_id,$cart_id)
	{
	   $udate_users = "UPDATE `user_orders` SET `user_id` = ".$cust_id." WHERE `order_id` = ".$cart_id." AND `order_status` = 'Pending'";
	   $Q = $this->db->query($udate_users);
	}
	
	public function update_cart_user_course($cust_id,$new_oder_total,$new_tax,$last_order_id)
	{
		 $udate_users = "UPDATE `user_orders` SET `user_id` = ".$cust_id.", `order_total` = ".$new_oder_total.", `order_tax` = ".$new_tax." WHERE `order_id` = ".$last_order_id." AND `order_status` = 'Pending'";
	     $Q = $this->db->query($udate_users);
	}
	
	
		public function get_order_details($user_id,$startdate='',$enddate='',$order_id='')
		{    
			$this->db->select("o.order_id,o.order_number,o.order_date,o.order_status,o.order_tax,o.discount,o.order_total");
			$this->db->from("user_orders AS o");
			$this->db->where("o.user_id",$user_id);
			$this->db->where("o.order_status",'Completed');
			if($order_id!='')
			{
				$this->db->where("o.order_id",$order_id);
			}
			if( $startdate !='' && $enddate !='')
			{
				$this->db->where("o.order_date >=",$startdate);
				$this->db->where("o.order_date <= ",$enddate);
			}
			$this->db->order_by('o.order_id DESC');
			$query_orders = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_orders->num_rows()>0)
			{
				return $query_orders->result_array();
			}
			else
			{
				return array();
			} 
		}
		public function get_order_states($cid,$orderid,$type='')
		{    
			$this->db->select("oc.*");
			$this->db->from("user_courses AS oc");
			//$this->db->join("user_orders AS o", 'o.order_id = oc.order_id', 'inner');
			if($type == 'Bundle')
			{
			  $this->db->where("type",'Bundle');	
			}
			if($type == '')
			{
				$this->db->where("oc.course_id",$cid);
			}
			
		
			$this->db->where("oc.order_id",$orderid);
			$this->db->order_by('oc.id DESC');
			$query_orders = $this->db->get();
			//echo $this->db->last_query();die;
			if($query_orders->num_rows()>0)
			{
				return $query_orders->result_array();
			}
			else
			{
				return array();
			} 
		}
	
		public function get_order_courses($orderid)
		{    
			$this->db->select("oc.*");
			$this->db->from("order_courses AS oc");
			//$this->db->join("user_orders AS o", 'o.order_id = oc.order_id', 'inner');
			$this->db->where("oc.order_id",$orderid);
			$this->db->order_by('oc.id DESC');
			$query_orders = $this->db->get();
			
			if($query_orders->num_rows()>0)
			{
				return $query_orders->result_array();
			}
			else
			{
				return array();
			} 
		}
	
		public function get_course_progress($user_id,$status,$archive='')
		{
			   $oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " - 365 day"));
		        
				$this->db->select("c.course_id,c.course_name,c.course_author,c.course_price,c.course_image,c.s3_images,c.back_color,c.course_format,u.added_date,u.id,u.expiry_date,u.course_state,c.course_author,u.completed_date,u.course_credits,u.started_date,u.id,u.order_id,u.review_percentage,u.exam_percentage,u.pdf_name,u.s3_course_certificate");
				$this->db->from("user_courses AS u");
				$this->db->join("courses AS c", 'u.course_id = c.course_id', 'inner');
				$this->db->where("u.user_id",$user_id);
				$this->db->where("u.course_status",$status);
				
				if($archive == 'notarchive')
				{
					$this->db->where("u.completed_date >",$oneYearOn);
				}
				if($archive == 'archive')
				{
					$this->db->where("u.completed_date <",$oneYearOn);
				}
				$query_courses = $this->db->get();
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
		
		
	 public function get_course_percentage($id='',$courseid='')
	 {
			$this->db->select("cp.*");
			$this->db->from("course_progress AS cp");
			$this->db->where("cp.user_course_id",$id);
			$this->db->where("cp.course_id",$courseid);
			$query_course_perc = $this->db->get();
			if($query_course_perc->num_rows()>0)
			{
				return $query_course_perc->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	  public function get_state_details($stateid)
	 {
			$this->db->select("s.*");
			$this->db->from("us_state AS s");
		    $this->db->where_in("state_id",$stateid);
			$query_state = $this->db->get();
			if($query_state->num_rows()>0)
			{
				return $query_state->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	 public function update_user($data_update,$id)
	{ 
	  $this->db->where("id", $id);
	  $this->db->update('customers',$data_update);
	   return $id;
	}
	
	public function change_password($userid,$old_pwd,$new_pwd)
	{
		$data = array('password' => md5($new_pwd),'str_password' =>$new_pwd);
		$this->db->where('id', $userid);
		$this->db->where('password', md5($old_pwd));	
		$query = $this->db->get('customers');
		if($query->num_rows() > 0)
		{
			$this->db->where('id', $userid);
			$this->db->update('customers', $data); 
		/*	if(isset($_COOKIE['user_pwd']))
			{
				setcookie('user_pwd',$new_pwd, time()+(30*60*60*24)); 			
			}*/
			return true;
		}else{
		    return false;
		}	
	}
	
	public function get_billing_details($custid)
	{
		   	  $this->db->select('*');
		 	  $this->db->where('course_id', $course_id);
			  $this->db->where('user_id',$user_id);
		 	  $this->db->where('order_id',$order_id);
			  $this->db->limit(1);
			  $query_user_course = $this->db->get('user_courses');
			  // echo $this->db->last_query(); die;
			  if($query_user_course->num_rows() > 0)
			  {
					return $query_user_course->result_array();
			  }
			  else
			  {
				 	return array();
			  }
			  
	}
	
  public function get_user_state_credit($userid,$stateid,$sdate,$edate)
	{
		 
		 $this->db->select("uc.*");
		 $this->db->from("user_credits AS uc");
		  //$this->db->join('credits_type AS ct', 'sc.cat_id = ct.type_id','inner');
		  $this->db->where("uc.user_id",$userid);
		  $this->db->where("uc.state_id",$stateid);
		   $this->db->where("uc.credit_date >=",$sdate);
		   $this->db->where("uc.credit_date <=",$edate);
		  
		 $query_user_state_credit = $this->db->get();
		 // echo $this->db->last_query();
		 if($query_user_state_credit->num_rows()>0)
	     {
				return $query_user_state_credit->result_array();
		 }else{
				return array();
		 }
		 
	}
	
public function get_credit_types()
	{
		    $this->db->select('type_id,type,active');
			$this->db->from('credits_type');
			$this->db->where('active','1');
			$this->db->where('grouped','0'); //exclude grouped categories user-facing
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
	
 public function get_external_courses($userid,$stateid)
	{
		    $this->db->select('uc.id,uc.total_points,uc.credit_date,uc.type_id,uc.course_type,uc.external_course_name,ct.type');
			$this->db->from('user_credits as uc');
			$this->db->join("credits_type AS ct", 'uc.type_id = ct.type_id', 'inner');
			$this->db->where('uc.user_id',$userid);
			$this->db->where('uc.state_id',$stateid);
			$this->db->where("ct.active",'1');
			$this->db->where('uc.course_type','external');
			$this->db->order_by('uc.id','DESC');
			$credits = $this->db->get();
			
			if($credits->num_rows()>0)
			{
				return $credits->result_array();
			}
			else
			{
				return array();
			}
	}
public function add_external_credits($data_insert)
	{
			$this->db->insert('user_credits', $data_insert); 
			$credit_id =  $this->db->insert_id();
			return $credit_id;
	}
	
public function delete_credit($id)
	{
		   $query = $this->db->delete('user_credits',array('id'=>$id));
		   return $query;
	}
	
public function get_user_credit($id)
	{
		   	  $this->db->select('*');
		 	  $this->db->where('id', $id);
			  $this->db->where('course_type','external');
			  $this->db->limit(1);
			  $query_user_credit = $this->db->get('user_credits');
			  // echo $this->db->last_query(); die;
			  if($query_user_credit->num_rows() > 0)
			  {
					return $query_user_credit->result_array();
			  }
			  else
			  {
				 	return array();
			  }
			  
	}
	
public function update_external_credits($data_update,$id)
{ 
	  $this->db->where("id", $id);
	  $this->db->update('user_credits',$data_update);
	   return $id;
}

 public function update_customer($data_update,$id)
	 {
		 $this->db->where("id", $id);
		 $this->db->update("customers", $data_update); 
		 return $id;
	 }
	 
public function user_credit_daterenge($userid,$stateids)
{
	
   $stateid = explode(',',$stateids);
    //$courses_id = explode(',',$bundle_courses);
   //echo $userid;
  //echo "<pre>";print_r($stateid);die;
   if(count($stateid) > 0)
   {
	    foreach($stateid as $state)
		{
			//echo ">>>". $state;die;
			$state_detail = $this->state_date_renge($state);
			//echo "<pre>";print_r($state_detail);die;
			
			$prevyear	=	$state_detail[0]['prev_year'];
			$nextyear	=	$state_detail[0]['next_year'];
			
			
			$preyear = date("Y",strtotime("-".$prevyear." year"));
			$nxtyear = date("Y",strtotime("+".$nextyear." year"));
			
			$data_insert['user_id'] = $userid;
			$data_insert['state_id'] = $state;
			
			$data_insert['start_date']  = $preyear.'-'.$state_detail[0]['start_date'];
			$data_insert['end_date'] 	= $nxtyear.'-'.$state_detail[0]['end_date'];
			
			$final_sdate    = $preyear.'-'.$state_detail[0]['start_date'];
			$final_edate 	= $nxtyear.'-'.$state_detail[0]['end_date'];
			
			 $today_date = date('Y-m-d');
			 if($today_date <= $final_sdate)
			 {
				 $data_insert['start_date']  = date('Y-m-d', strtotime('-1 year', strtotime($final_sdate)) );
			     $data_insert['end_date'] 	=  date('Y-m-d', strtotime('-1 year', strtotime($final_edate)) );
				 
			 }elseif($today_date >= $final_edate){
				 
				$data_insert['start_date']  = date('Y-m-d', strtotime('+1 year', strtotime($final_sdate)) );
			    $data_insert['end_date'] 	= date('Y-m-d', strtotime('+1 year', strtotime($final_edate)) );
				 
			}else{
				
				$data_insert['start_date']  = $preyear.'-'.$state_detail[0]['start_date'];
			    $data_insert['end_date'] 	= $nxtyear.'-'.$state_detail[0]['end_date']; 	
				
			}
			
			//echo "<pre>";print_r($data_insert);die;
			$this->db->insert('user_credits_daterenge', $data_insert); 
			//echo $this->db->last_query(); die;
			$credit_id =  $this->db->insert_id();
		}
		return true;
   }
   
   
}

public function state_date_renge($sid)
	{
		   	  $this->db->select('state_id,start_date,end_date,prev_year,next_year');
		 	  $this->db->where('state_id', $sid);
			  $this->db->where('status','Active');
			  $this->db->limit(1);
			  $query_user_credit = $this->db->get('us_state');
			  //echo $this->db->last_query(); die;
			  if($query_user_credit->num_rows() > 0)
			  {
					return $query_user_credit->result_array();
			  }
			  else
			  {
				 	return array();
			  }
			  
	}	
	
	public function delete_user_renge($stateid,$userid)
	{
		  $query = $this->db->delete('user_credits_daterenge',array('state_id'=>$stateid,'user_id' =>$userid));
		  return $query;
	} 
	
  public function get_user_trackerrenge($uid,$stateid)
	{
		   	  $this->db->select('*');
		 	  $this->db->where('state_id', $stateid);
			  $this->db->where('user_id', $uid);
			  
			  $this->db->limit(1);
			  $query_user_credit = $this->db->get('user_credits_daterenge');
			  // echo $this->db->last_query(); die;
			  if($query_user_credit->num_rows() > 0)
			  {
					return $query_user_credit->result_array();
			  }
			  else
			  {
				 	return array();
			  }
			  
	}	

 	public function update_user_state_renage($data_update,$uid,$stateid)
	 {
		 $this->db->where("state_id", $stateid);
		 $this->db->where("user_id", $uid);
		 $this->db->update("user_credits_daterenge", $data_update); 
		 return $id;
	 }	
	 
	public function check_user_order($userid = 0)
	{
	  		  $this->db->select('*');
			  $this->db->where('user_id', $userid);
			  $this->db->where('order_status', 'Pending');
			  $this->db->order_by('order_id','DESC');
			  $this->db->limit(1);
			  $query_user_order = $this->db->get('user_orders');
			  //echo $this->db->last_query(); die;
			  if($query_user_order->num_rows() > 0)
			  {
					return $query_user_order->result_array();
			  }
			  else
	
			  {
				 	return array();
			  } 	
	}	
	
	public function get_user_orders($orderid = 0)
	{
		      $this->db->select('*');
			  $this->db->where('order_id', $orderid);
			  $this->db->where('order_status', 'Pending');
			  $this->db->order_by('order_id','DESC');
			  $query_user_order = $this->db->get('user_orders');
			  //echo $this->db->last_query(); die;
			  if($query_user_order->num_rows() > 0)
			  {
					return $query_user_order->result_array();
			  }
			  else
	
			  {
				 	return array();
			  } 
	}
	
	
	public function check_user_order_items($orderid = 0)
	{
	  		  $this->db->select('*');
			  $this->db->where('order_id', $orderid);
			  $query_user_order = $this->db->get('order_courses');
			  //echo $this->db->last_query(); die;
			  if($query_user_order->num_rows() > 0)
			  {
					return $query_user_order->result_array();
			  }
			  else
			  {
				 	return array();
			  } 	
	} 
	
	public function update_ordercourse($id,$orderid)
	{
		
		foreach($id as $key)
		{
		   $udate_order = "UPDATE `order_courses` SET `order_id` = ".$orderid." WHERE `id` = ".$key."";
	      $id = $this->db->query($udate_order);
		
		}
		return true;
	}
	
	public function delete_user_orderid($user_id,$order_id)
	{
		  $query = $this->db->delete('user_orders',array('order_id'=>$order_id,'user_id' =>$user_id));
		  return $query;
		   
	
	}
	
	public function s3_certificate_path($s3path,$user_course_id)
	{
		 	  $update_path = "UPDATE `user_courses` SET s3_course_certificate = '".$s3path."' WHERE id = ".$user_course_id."";
	   	 	  $Q = $this->db->query($update_path);
	}
}
?>