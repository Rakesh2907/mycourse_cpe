<?php 
class Faq_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_faq()
	{
    		$this->db->select("f.*");
			$this->db->from("faq_management AS f");
			$this->db->order_by('f.id DESC');
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
	
	public function add_new_faq($data_insert)
	{
		 	$this->db->insert('faq_management', $data_insert); 
			$id =  $this->db->insert_id();
			return $id;
	}

	public function get_faq($id)
	 {
			$this->db->select("c.*");
			$this->db->from("faq_management AS c");
			$this->db->where("c.id",$id);
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

	public function update_faq($data_update,$id)
	{ 
	  $this->db->where("id", $id);
	  $this->db->update('faq_management',$data_update);
	   return $id;
	} 

	public function delete_single_faq($id)
	 {
		 	/* $this->db->where("id", $id);
			 $data_update = array('faq_status' => 'Deleted');
		 	 $this->db->update("faq_management", $data_update);*/
			 $query = $this->db->delete('faq_management',array('id'=>$id));
		     return $query;
	 }
}
?>