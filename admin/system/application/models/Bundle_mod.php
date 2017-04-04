<?php 
class Bundle_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_bundles()
	{ 
		    $this->db->select("b.*, st.*");
			$this->db->from("bundles AS b");
			$this->db->join("us_state AS st", "st.state_id = b.state_id", "inner");
			$this->db->where("bundle_status <> 'deleted'");
			$this->db->where("b.bundle_type", "bundle");
			$this->db->order_by("b.bundle_id", "DESC");
			$query_customer = $this->db->get();
			 // echo $this->db->last_query();
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}  
	}
	
	public function bundle_count()
	{
			$this->db->select("COUNT(bundle_id) AS total_bundle");
			$this->db->from("bundles AS b");
			$this->db->where("bundle_status", "active");
			$query_bundle = $this->db->get();
			if($query_bundle->num_rows()>0)
			{
				foreach($query_bundle->result_array() as $key => $valcount)
				{
					 return $valcount;	
				}
			}
			else
			{
				return array();
			}
	}
	
	public function get_all_bundle_courses()
	{
		    $this->db->select("c.*");
			$this->db->from("courses AS c");
			$this->db->where("c.course_status = 'active'");
			$this->db->order_by("c.course_id", "ASC");
			$query_course = $this->db->get();
			
			if($query_course->num_rows()>0)
			{
				return $query_course->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function get_bundle_details($bundle_id)
	{
		    $this->db->select("b.*, st.*");
			$this->db->from("bundles AS b");
			$this->db->join("us_state AS st", "st.state_id = b.state_id", "inner");
			$this->db->where("bundle_status <> 'deleted'");
			$this->db->where("bundle_id",$bundle_id);
			
			$query_customer = $this->db->get();
			if($query_customer->num_rows()>0)
			{
				return $query_customer->result_array();
			}
			else
			{
				return array();
			}  
	}
	
	public function delete_bundle($bundle_id)
	{
		  $this->db->where("bundle_id", $bundle_id);
		  $data_update = array('bundle_status' => 'deleted');
		  $this->db->update("bundles", $data_update);
		  return 1;
	}
	
	public function add_bundle($data)
	{
		   $this->db->insert("bundles", $data); 
		   return $this->db->insert_id();
	}
	
	public function update_bundle($data_update,$bundle_id)
	{
		  $this->db->where("bundle_id", $bundle_id);
		  $this->db->update("bundles", $data_update);
		  return 1;
	}
	
}
?>