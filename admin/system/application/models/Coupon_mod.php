<?php 
class Coupon_mod extends CI_Model
{  
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_coupon()
	{
    		$this->db->select("c.*");
			$this->db->from("coupon_codes AS c");
			$this->db->order_by('c.coupon_id DESC');
			$query_coupon = $this->db->get();
			
			if($query_coupon->num_rows()>0)
			{
				return $query_coupon->result_array();
			}
			else
			{
				return array();
			}	
			
	}
	
	public function add_coupon($data_insert)
	{
		 	$this->db->insert('coupon_codes', $data_insert); 
			$fid =  $this->db->insert_id();
			return $fid;
	}

	public function get_coupon($id)
	 {
			$this->db->select("c.*");
			$this->db->from("coupon_codes AS c");
			$this->db->where("c.coupon_id",$id);
			$query_coupon = $this->db->get();
			if($query_coupon->num_rows()>0)
			{
				return $query_coupon->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	public function update_coupon($data_update,$id)
	{ 
	  $this->db->where("coupon_id", $id);
	  $this->db->update('coupon_codes',$data_update);
	   return $id;
	} 
	
	public function delete_single_coupon($id)
	 {
		 	 $this->db->where("coupon_id", $id);
			 $data_update = array('coupon_status' => 'inactive');
		 	 $this->db->update("coupon_codes", $data_update);
	 }
	 
	 public function check_coupon_code($code)
	 {
			$this->db->select("c.coupon_code");
			$this->db->from("coupon_codes AS c");
			$this->db->where("c.coupon_code",$code);
			$query_coupon = $this->db->get();
			//print_r($query_coupon);die;
			if($query_coupon->num_rows()>0)
			{  
			   
				return 'true';
			}
			else
			{
				return 'false';
			}
	 }
	 
	 public function get_user_detail($userid)
	{
		$user_id = explode(',',$userid);
		 $this->db->select("c.id,c.first_name,c.last_name,c.email");
		 $this->db->from("customers AS c");
		 $this->db->where_in("c.id",$user_id);
		 $query_users = $this->db->get();
		 //echo $this->db->last_query();
		 if($query_users->num_rows()>0)
		 {
				return $query_users->result_array();
		 }else{
				return array();
		  }
	}
	
	 public function get_course_detail($cid)
	{
		 $cids = explode(',',$cid);
		 $this->db->select("c.course_id,c.course_name");
		 $this->db->from("courses AS c");
		 $this->db->where_in("c.course_id",$cids);
		 $query_course = $this->db->get();
		 //echo $this->db->last_query();
		 if($query_course->num_rows()>0)
		 {
				return $query_course->result_array();
		 }else{
				return array();
		  }
	}
}
?>