<?php 
class State_mod extends CI_Model
{  
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all_state()
	{
    		$this->db->select("s.*");
			$this->db->from("us_state AS s");
			$this->db->where("s.status",'Active');
			$this->db->order_by('s.state_id DESC');
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
	


	public function get_state($id)
	 {
			$this->db->select("s.*");
			$this->db->from("us_state AS s");
			$this->db->where("s.state_id",$id);
			$this->db->where("s.status",'Active');
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
	 
	public function update_state($data_update,$id)
	{ 
	  $this->db->where("state_id", $id);
	  $this->db->update('us_state',$data_update);
	   return $id;
	} 
	
	public function delete_single_coupon($id)
	 {
		 	 $this->db->where("coupon_id", $id);
			 $data_update = array('coupon_status' => 'Deleted');
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
				return '1';
			}
			else
			{
				return '0';
			}
	 }
	 
	public function get_all_state_requirement($stateid)
	{
			$this->db->select('sr.*,s.state');
			$this->db->from('state_requirement AS sr');
			$this->db->join('us_state AS s', 'sr.state_id = s.state_id', 'inner');
			$this->db->where('sr.state_id', $stateid);
			$this->db->order_by('sr.requirment_id','DESC');
			//$this->db->where('cq.ques_status','Active');
			$query_state_req = $this->db->get();
			if($query_state_req->num_rows()>0)
			{
				return $query_state_req->result_array();
			}
			else
			{
				return array();
			}	
			
	}
	
	public function add_state_requirement($data_insert)
	{
		 	$this->db->insert('state_requirement', $data_insert); 
			$req_id =  $this->db->insert_id();
			return $req_id;
	}
	
	public function get_state_requirement($id)
	 {
			$this->db->select("s.*");
			$this->db->from("state_requirement AS s");
			$this->db->where("s.requirment_id",$id);
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
	 
	 public function get_requirement($id)
	 {
			$this->db->select("s.*");
			$this->db->from("state_requirement AS s");
			$this->db->where("s.requirment_id",$id);
			$query_state_req = $this->db->get();
			if($query_state_req->num_rows()>0)
			{
				return $query_state_req->result_array();
			}
			else
			{
				return array();
			}
	 }
	 
	public function update_requirement($data_update,$id)
	{ 
	  $this->db->where("requirment_id", $id);
	  $this->db->update('state_requirement',$data_update);
	   return $id;
	}
	
	public function get_state_credit($id)
	{
		    $this->db->select("cr.id,cr.state_id,cr.cat_id,cr.credits,ct.type");
			$this->db->from("state_credits AS cr");
			$this->db->join("credits_type AS ct", 'ct.type_id = cr.cat_id', 'inner');
			//$this->db->join("us_state AS us", 'us.state_id = cr.state_id', 'inner');
			$this->db->where("ct.active",'1');
			$this->db->where("cr.state_id",$id);
			
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
	
	public function get_credits($id)
	{
		    $this->db->select("cr.id,cr.state_id,cr.cat_id,cr.credits,ct.type");
			$this->db->from("state_credits AS cr");
			$this->db->join("credits_type AS ct", 'ct.type_id = cr.cat_id', 'inner');
			//$this->db->join("us_state AS us", 'us.state_id = cr.state_id', 'inner');
			$this->db->where("ct.active",'1');
			$this->db->where("cr.id",$id);
			
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
	
	public function exits_credit($data_insert)
	{
			  $this->db->select("cr.*");
			  $this->db->from("state_credits AS cr");
			  $this->db->where("cr.state_id",$data_insert['state_id']);
			  $this->db->where("cr.cat_id",$data_insert['cat_id']);
			  //echo $this->db->last_query();die;
			  $query_credits = $this->db->get();
			
			  if($query_credits->num_rows() > 0)
			  {
					return true;
			  }else{
					return false;
			  }
			  
			  
	}
	
	public function add_credits($data_insert)
	{
			$this->db->insert('state_credits', $data_insert); 
			$credit_id =  $this->db->insert_id();
			return $credit_id;
	}
	
	public function update_credits($data_update,$credit_id)
	{
		 	$this->db->where("id", $credit_id);
			$this->db->update("state_credits", $data_update); 
		 	return $credit_id;
	}
	
	public function delete_credit($state_id,$credit_id)
	{
		   $query = $this->db->delete('state_credits',array('id'=>$credit_id,'state_id'=>$state_id));
		   return $query;
	}
	
	public function state_details($states = '')
	{
		   	$this->db->select("s.*");
			$this->db->from("us_state AS s");
			if(is_numeric($states)){
				$this->db->where("s.state_id",$states);
			}else{
				$this->db->where("s.state_abbr",$states);
			}
			$this->db->where("s.status",'Active');
			$this->db->order_by("s.state", "ASC");
			$this->db->limit(1);
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
	
}


?>