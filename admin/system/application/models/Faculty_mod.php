<?php 
class Faculty_mod extends CI_Model
{  
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_faculty()
	{
    		$this->db->select("f.*");
			$this->db->from("faculty_members AS f");
			$this->db->order_by('f.faculty_member_id DESC');
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
	
	public function add_faculty($data_insert)
	{
		 	$this->db->insert('faculty_members', $data_insert); 
			$fid =  $this->db->insert_id();
			return $fid;
	}

	public function get_faculty($id)
	 {
			$this->db->select("c.*");
			$this->db->from("faculty_members AS c");
			$this->db->where("c.faculty_member_id",$id);
			$query_page = $this->db->get();
			if($query_page->num_rows()>0)
			{
				return $query_page->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	public function update_faculty($data_update,$id)
	{ 
	  $this->db->where("faculty_member_id", $id);
	  $this->db->update('faculty_members',$data_update);
	   return $id;
	} 
	
	public function delete_single_faculty($id)
	 {
		 	 $this->db->where("faculty_member_id", $id);
			 $data_update = array('active' => '0');
		 	 $this->db->update("faculty_members", $data_update);
	 }
}
?>