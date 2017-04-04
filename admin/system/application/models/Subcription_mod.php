<?php 
class Subcription_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_subcription()
	{
		    $this->db->select("sub.*");
			$this->db->from("subscription AS sub");
			$this->db->where("sub.status <> 'deleted'");
			$this->db->order_by("sub.subscription_id", "ASC");
			$query_sub = $this->db->get();
			
			if($query_sub->num_rows()>0)
			{
				return $query_sub->result_array();
			}
			else
			{
				return array();
			}
	}
	public function get_subcription_details($subcription_id)
	{
			$this->db->select("sub.*");
			$this->db->from("subscription AS sub");
			$this->db->where("sub.status <> 'deleted'");
			$this->db->where("sub.subscription_id = ".$subcription_id."");
			$this->db->order_by("sub.subscription_id", "ASC");
			$query_sub = $this->db->get();
			
			if($query_sub->num_rows()>0)
			{
				return $query_sub->result_array();
			}
			else
			{
				return array();
			}
	}
	
	public function add_subcription($data)
	{
			 $this->db->insert("subscription", $data); 
		     return $this->db->insert_id();
	}
	
	public function update_subcription($data,$subcription_id)
	{
			 $this->db->where("subscription_id", $subcription_id);	
			 $this->db->update("subscription", $data);
		  	 return 1;
	}
	
	public function delete_subcription($subcription_id)
	{
	      $this->db->where("subscription_id", $subcription_id);
		  $data_update = array('status' => 'deleted');
		  $this->db->update("subscription", $data_update);
		  return 1;
	}
	
	 public function get_subscription_details($subscription_id)
	   {
		     $this->db->select("sub.*");
			 $this->db->from("subscription AS sub");
		 	 $this->db->where("sub.status",'active');
			 $this->db->where("sub.subscription_id",$subscription_id);
		 	 $this->db->order_by("sub.title", "ASC");
			 $this->db->limit(1);
		 	 $query_sub = $this->db->get();
		
			 if($query_sub->num_rows()>0)
			 {
					return $query_sub->result_array();
			 }else{
					return array();
			 }
	   }
}
?>