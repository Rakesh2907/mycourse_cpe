<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcription_con extends CI_Controller 
{
	function __construct()
	{
		 parent::__construct();
		 is_logged_admin();
		 $this->load->model('subcription_mod');
	}
	
	public function index()
	{
		  if($this->session->userdata('userid') != "")
		  {
			     if($this->session->userdata('err_msg') != '')
		  		 {
					$data['err_msg'] = $this->session->userdata('err_msg');
					$this->session->unset_userdata('err_msg');
		         } 
				 if($this->session->userdata('suc_msg') != '')
				 {
					   $data['suc_msg'] = $this->session->userdata('suc_msg');
					   $this->session->unset_userdata('suc_msg');
				 }
			  
			  
			    $data['menutitle'] = 'Subscription';
				$data['pagetitle'] = 'Subscription';
				$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Manage Subscription</li></ul>'; 
				$data['subcription_details'] = $this->subcription_mod->get_all_subcription();
				if($data != false)
				{
					$this->template
						 ->set_layout('admin_default')
						 ->build('subcription/subcription_manage',$data);
						
				}
				 
		  }else{
				$this->load->view('index');
		  }
	}
	
	public function add_subcription()
	{
		if($this->session->userdata('userid') != "")
	    {
		   $data['menutitle'] = 'Subscription';
		   $data['pagetitle'] = 'Add Subcription';
		   $data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'subcription_con">Manage Subcription</a><i class="fa fa-angle-right"></i></li><li>Add Subcription</li></ul>';   
		 
		  if(trim($this->input->post('submit')) == '')
		  {
			 $this->template->set_layout('admin_default')->build('subcription/add_subcription',$data);
		  }elseif(trim($this->input->post('submit')) == 'Add Subcription')
		  {
			  $this->form_validation->set_rules('title', 'Suncription Name', 'trim|required|min_length[5]');
			  $this->form_validation->set_rules('price', 'Suncription price', 'trim|required|numeric');
			  $this->form_validation->set_rules('duration', 'Duration', 'trim|required|numeric');
			   
			  if ($this->form_validation->run($this) == FALSE)
			  {
				   $this->template->set_layout('admin_default')->build('subcription/add_subcription',$data);
			  }else{
				   $data_insert['title'] =  trim($this->input->post('title')); 
				   $data_insert['price'] =  trim($this->input->post('price'));   
				   $data_insert['duration'] = $this->input->post('duration');
				   $data_insert['status'] =  $this->input->post('status'); 
				   $subcription_id = $this->subcription_mod->add_subcription($data_insert); 
				   if($subcription_id > 0){
					    $arr_msg = array('suc_msg'=>'Record added successfully!!!');
				   }else{
					    $arr_msg = array('err_msg'=>'Failed to add record');
				   }
				   $this->session->set_userdata($arr_msg);
				  redirect('subcription_con');
		      }
			   
		  }
		}else{
				$this->load->view('index');
		}  
	}
	
	public function edit_subcription($subcription_id = 0)
	{
		if($this->session->userdata('userid') != "")
	    {
	       
		   	$data['menutitle'] = 'Subcription';
			$data['pagetitle'] = 'Edit Subcription';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li><a href="'.base_url().'subcription_con">Manage Subcription</a><i class="fa fa-angle-right"></i></li><li>Update Subcription</li></ul>';
		   
		   
		   if($this->input->post('subcription_id') && $subcription_id == 0)
		   {
			  $subcription_id = $this->input->post('subscription_id');
	       }
		   if(trim($this->input->post('submit')) == '')
		   {
			   $data['subcription_details'] = $this->subcription_mod->get_subcription_details($subcription_id);
			   $this->template->set_layout('admin_default')->build('subcription/edit_subcription',$data);
		   }elseif(trim($this->input->post('submit')) == 'Edit Subcription')
		   {
			      $this->form_validation->set_rules('title', 'Suncription Name', 'trim|required|min_length[5]');
			  	  $this->form_validation->set_rules('price', 'Suncription price', 'trim|required|numeric');
			      $this->form_validation->set_rules('duration', 'Duration', 'trim|required|numeric');
				  
				  if ($this->form_validation->run($this) == FALSE)
			      {
					  $arr_sub_details['title'] = $this->input->post('title');
					  $arr_sub_details['price'] = trim($this->input->post('price')); 
					  $arr_sub_details['duration'] = trim($this->input->post('duration'));
					  $data['subcription_details'][0] = $arr_sub_details;
					  $this->template->set_layout('admin_default')->build('subcription/edit_subcription',$data);
				  }else{
					   $subcription_id = $this->input->post('subscription_id');
					   $data_update['title'] = $this->input->post('title');
					   $data_update['price'] = trim($this->input->post('price')); 
					   $data_update['duration'] = trim($this->input->post('duration'));
					   $data_update['status'] = trim($this->input->post('status'));
					   $subcription_id = $this->subcription_mod->update_subcription($data_update,$subcription_id);
					
						if($subcription_id > 0){
								$arr_msg = array('suc_msg'=>'Record updated successfully!!!');
						}else{
								$arr_msg = array('err_msg'=>'Failed to add record');
						}
						
					   $this->session->set_userdata($arr_msg);
					   redirect('subcription_con');
				  }
				  
				  
		   }
		   	
		}else{
				$this->load->view('index');
		}
	}
	
	public function delete_subcription()
	{
		if($this->session->userdata('userid') != "")
	    {
			 $subcription_id = $this->input->post('subcription_id');
		     echo $deleted = $this->subcription_mod->delete_subcription($subcription_id);
		}else{
				$this->load->view('index');
		}  
	}
	
	
}

?>