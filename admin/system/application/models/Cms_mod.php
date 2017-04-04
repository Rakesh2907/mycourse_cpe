<?php 
class Cms_mod extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_cmspages()
	{
    		$this->db->select("c.*");
			$this->db->from("cms_pages AS c");
			$this->db->order_by('c.page_id DESC');
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
	
	public function add_cms_page($data_insert)
	{
		 	$this->db->insert('cms_pages', $data_insert); 
			$page_id =  $this->db->insert_id();
			return $page_id;
	}

	public function get_page($id)
	 {
			$this->db->select("c.*");
			$this->db->from("cms_pages AS c");
			$this->db->where("c.page_id",$id);
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
	 
	public function update_page($data_update,$id)
	{ 
	  $this->db->where("page_id", $id);
	  $this->db->update('cms_pages',$data_update);
	   return $id;
	} 
	
	public function delete_single_page($id)
	 {
		 	 $this->db->where("page_id", $id);
			 $data_update = array('page_status' => 'Deleted');
		 	 $this->db->update("cms_pages", $data_update);
	 }
}
?>