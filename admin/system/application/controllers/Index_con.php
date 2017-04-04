<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_con extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
	  	parent::__construct();
		
		$this->load->model('customer_mod');
		$this->load->model('course_mod');
		$this->load->model('bundle_mod');
		$this->load->model('userorder_mod');
		
	}
	
	public function index()
	{
		if($this->session->userdata('userid') != "")
		{
			
			
			$data['menutitle'] = 'Dashboard';
			$data['pagetitle'] = 'Dashboard';
			
			$todays_customers_count = $this->customer_mod->customer_count('today'); 
			
			$data['todays_total_customers'] = $todays_customers_count['total_customer'];
			
			$weekly_customers_count = $this->customer_mod->customer_count('week'); 
			
			$data['week_total_customers'] = $weekly_customers_count['total_customer'];
			
			$month_customers_count = $this->customer_mod->customer_count('month'); 
			
			$data['month_total_customers'] = $month_customers_count['total_customer'];
			
			$year_customers_count = $this->customer_mod->customer_count('year'); 
			
			$data['year_total_customers'] = $year_customers_count['total_customer'];
			
			
			$todays_order_count = $this->userorder_mod->order_count('today'); 
			
			$data['todays_total_order'] = $todays_order_count['total_order'];
			
			$weekly_order_count = $this->userorder_mod->order_count('week'); 
			
			$data['week_total_order'] = $weekly_order_count['total_order'];
			
			$month_order_count = $this->userorder_mod->order_count('month'); 
			
			$data['month_total_order'] = $month_order_count['total_order'];
			
			$year_order_count = $this->userorder_mod->order_count('year'); 
			
			$data['year_total_order'] = $year_order_count['total_order'];
			
			
			$todays_order_sale = $this->userorder_mod->order_sale('today'); 
			
			$data['todays_total_sale'] = $todays_order_sale['total_sale'];
			
			$weekly_order_sale = $this->userorder_mod->order_sale('week'); 
			
			$data['week_total_sale'] = $weekly_order_sale['total_sale'];
			
			$month_order_sale = $this->userorder_mod->order_sale('month'); 
			
			$data['month_total_sale'] = $month_order_sale['total_sale'];
			
			$year_order_sale = $this->userorder_mod->order_sale('year'); 
			
			$data['year_total_sale'] = $year_order_sale['total_sale'];
			
			
			
		   	$todays_repeat_cust = $this->customer_mod->repeat_cust('today'); 
		    //echo "<pre>";print_r($todays_repeat_cust);die;
			$data['todays_repeat_cust'] = $todays_repeat_cust;
			
			$weekly_repeat_cust = $this->customer_mod->repeat_cust('week'); 
			
			$data['week_repeat_cust'] = $weekly_repeat_cust;
			
			$month_repeat_cust = $this->customer_mod->repeat_cust('month'); 
			
			$data['month_repeat_cust'] = $month_repeat_cust;
			
			$year_repeat_cust = $this->customer_mod->repeat_cust('year'); 
			
			$data['year_repeat_cust'] = $year_repeat_cust;
			
			$percentage_last_week = $this->userorder_mod->get_revenue_percentage('last_week');
			if(is_array($percentage_last_week))
		    {
				   if($percentage_last_week['last_week_count'] > $percentage_last_week['current_week_count'])
				   {
					   $class = 'top';
				   }else{
					   $class = 'bottom';
				   }	
					
				 $differance = (($percentage_last_week['last_week_count'] -  $percentage_last_week['current_week_count'])/$percentage_last_week['last_week_count']);
				 $percentage = number_format(($differance*100),2);
				 $data['last_week_percentage'] = $percentage;
			}
			
			$percentage_last_year = $this->userorder_mod->get_revenue_percentage('last_year_month');
			
			if(is_array($percentage_last_year))
		    {
				if($percentage_last_year['lastyear_month_count'] > $percentage_last_year['lastyear_month_count']){
					$class = 'top';
				}else{
					$class = 'bottom';
				}
				
				 $differance_month = @(($percentage_last_year['lastyear_month_count'] - $percentage_last_year['current_month_count'])/$percentage_last_year['lastyear_month_count']);
				 $percentage_month = number_format(($differance_month*100),2);
				 $data['last_year_month_percentage'] = $percentage_month;
				
			}
			
			
			
			$this->template
				 ->set_layout('admin_default')
		     	 ->build('admin_index', $data);
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	
 public function customer_listing($status='')
	{
		//echo 'here';die;
		if($this->session->userdata('userid') != "")
		{
			//echo "<pre>";print_r($this->input->post());die;	
			$data['menutitle'] = 'Reports';
			$data['pagetitle'] = 'Reports';
			
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Customer Report</li></ul>';
			 $stardate= $enddate=$state_id='';
			if($status == 'today')
		    {
			   $sdate = date('Y-m-d');  
			   $todate = date('Y-m-d');  
			   
		    }elseif($status == 'week')
			{
			
			  $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$sdate = date("Y-m-d",$monday);
			$todate = date("Y-m-d",$sunday);	
			}elseif($status == 'month')
			{
				
			   $sdate = date('Y-m-01',strtotime(date('Y-m-d')));
               $todate =  date('Y-m-t',strtotime(date('Y-m-d')));	
			}
			elseif($status == 'year')
			{
				$curyear = date('Y');
			    $stardate = ''.$curyear.'-01-01';
			    $enddate = date('Y-m-d'); 
				$sdate=$stardate ;
			   $todate=$enddate;  
			}
			else{
				
			   $sdate = date('Y-m-d');  
			   $todate = date('Y-m-d');  	
			}
			
			$data['sdate']=$sdate ;
			$data['todate']=$todate;
			 
			if($this->input->post('submit') != '')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate = date('Y-m-d',strtotime($this->input->post('fromdate')));
			  $enddate  = date('Y-m-d',strtotime($this->input->post('todate')));
			  $state_id =trim($this->input->post('state_id'));
			  
			  $data['sdate']= $stardate ;
			  $data['todate']=$enddate;
			  
			}
			$data['customer_details'] = $this->customer_mod->get_customers_list($status,$stardate,$enddate,$state_id);
			$data['states']			 = $this->customer_mod->get_all_state();
		    //echo "<pre>";print_r($data['states']);die;
			$data['menutitle'] = 'Customers';
			$data['pagetitle'] = ucfirst($status).' Customers';
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('dashboard/customer_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	
	public function repeat_customer_listing($status='')
	{
		//echo 'here';die;
		if($this->session->userdata('userid') != "")
		{
			//echo "<pre>";print_r($this->input->post());die;
			$data['menutitle'] = 'Reports';
			$data['pagetitle'] = 'Reports';	
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Repeated Customers Report</li></ul>';
			 $stardate= $enddate=$state_id='';
			if($status == 'today')
		    {
			   $sdate = date('Y-m-d');  
			   $todate = date('Y-m-d');  
			   
		    }elseif($status == 'week')
			{
			
			  $monday = strtotime("last monday");
			  $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$sdate = date("Y-m-d",$monday);
			$todate = date("Y-m-d",$sunday);	
			}elseif($status == 'month')
			{
				
			   $sdate = date('Y-m-01',strtotime(date('Y-m-d')));
               $todate =  date('Y-m-t',strtotime(date('Y-m-d')));	
			}
			elseif($status == 'year')
			{
			    $curyear = date('Y');
			    $stardate = ''.$curyear.'-01-01';
			    $enddate = date('Y-m-d'); 	
			    $data['sdate']=$stardate ;
			    $data['todate']=$enddate;
			}
			else{
				
			   $sdate = date('Y-m-d');  
			   $todate = date('Y-m-d');  	
			}
			
			$data['sdate']=$sdate ;
			$data['todate']=$todate;
			 
			if($this->input->post('submit') != '')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $state_id =trim($this->input->post('state_id'));
			  
			   $data['sdate']=$stardate ;
			   $data['todate']=$enddate;
			}
			
			$data['customer_details'] = $this->customer_mod->repeat_cust_list($status,$stardate,$enddate,$state_id);
			$data['states']			 = $this->customer_mod->get_all_state();
			//echo "<pre>";print_r($data['customer_details']);die;
			$data['menutitle'] = 'Repeated Customers';
			$data['pagetitle'] = ucfirst($status).' Repeated Customers';
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('dashboard/repeat_customer_manage',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	
	public function customer_order_list($status='')
	{
		//echo 'here';die;
		if($this->session->userdata('userid') != "")
		{
			$data['menutitle'] = 'Reports';
			$data['pagetitle'] = 'Reports';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Order Report</li></ul>';
			//echo "<pre>";print_r($this->input->post());die;	
			 $stardate= $enddate=$state_id= '';
			if($status == 'today')
		    {
			   $sdate = date('Y-m-d');  
			   $todate = date('Y-m-d');  
			   
		    }elseif($status == 'week')
			{
			
			  $monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			 
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			 
			$sdate = date("Y-m-d",$monday);
			$todate = date("Y-m-d",$sunday);	
			}elseif($status == 'month')
			{
				
			   $sdate = date('Y-m-01',strtotime(date('Y-m-d')));
               $todate =  date('Y-m-t',strtotime(date('Y-m-d')));	
			}
			elseif($status == 'year')
			{
				
			    $curyear = date('Y');
			    $stardate = ''.$curyear.'-01-01';
			    $enddate = date('Y-m-d'); 
				$data['sdate']=$stardate ;
			    $data['todate']=$enddate;  
			}
			else{
				
			   $sdate = date('Y-m-d');  
			   $todate = date('Y-m-d');  	
			}
			
			$data['sdate']=$sdate ;
			$data['todate']=$todate;
			 
			if($this->input->post('submit') != '')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $state_id =trim($this->input->post('state_id'));
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  
			}
			$data['order_details'] = $this->userorder_mod->order_list($status,$stardate,$enddate,$state_id);
			$data['states']			 = $this->customer_mod->get_all_state();
			//echo "<pre>";print_r($data['customer_details']);die;
			$data['menutitle'] = 'Orders';
			$data['pagetitle'] = ucfirst($status).' Orders';
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('dashboard/customer_orders',$data);
					
			}
		}
		else
		{
			$this->load->view('index');
		}
	}
	
	public function top_customers()
	{
		if($this->session->userdata('userid') != "")
		{
			$stardate=$enddate='';
			$data['menutitle'] = 'Reports';
			$data['pagetitle'] = 'Reports';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Top Customers</li></ul>';
			 $data['sdate']=date('Y-m-d'); ;
			 $data['todate']=date('Y-m-d');;
			 
		   if($this->input->post('submit') != '')
			{ 
			  //echo "<pre>";print_r($this->input->post());die;	
			  $stardate=trim($this->input->post('fromdate'));
			  $enddate=trim($this->input->post('todate'));
			  $state_id =trim($this->input->post('state_id'));
			  
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  
			}
			$data['top_customer'] = $this->customer_mod->get_top_customers($stardate,$enddate);
			$data['states']			 = $this->customer_mod->get_all_state();
			//echo "<pre>";print_r($data['top_customer']);die;
			$data['menutitle'] = 'Customers';
			$data['pagetitle'] = 'Top Customers';
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('dashboard/top_customers',$data);
					
			}
		}else
		{
			$this->load->view('index');
		}	
	}
	
	public function completed_course()
	{
		if($this->session->userdata('userid') != "")
		{
			$stardate=$enddate=$state_id=$certf ='';
			$data['menutitle'] = 'Reports';
			$data['pagetitle'] = 'Reports';
			$data['bredcrumbs'] = '<ul class="page-breadcrumb"><li> <i class="fa fa-home"></i> <a href="'.base_url().'index_con">Home</a> <i class="fa fa-angle-right"></i> </li><li>Completed Courses Report</li></ul>';
			 $data['sdate']= $stardate=date('Y-m-d'); ;
			 $data['todate']= $enddate=date('Y-m-d');;
			 
		   if($this->input->post('submit') != '')
			{ 
			 //echo "<pre>";print_r($this->input->post());die;	
			  $stardate	=	trim($this->input->post('fromdate'));
			  $enddate	=	trim($this->input->post('todate'));
			  $state_id =	trim($this->input->post('state_id'));
			  $certf 	=	trim($this->input->post('certificate'));
			 
			  $data['sdate']=$stardate ;
			  $data['todate']=$enddate;
			  
			}
			$data['completed_course'] = $this->customer_mod->get_complete_course($stardate,$enddate,$state_id,$certf);
			 
			$data['states']	= $this->customer_mod->get_all_state();
			//echo "<pre>";print_r($data['completed_course']);die;
			
			$data['menutitle'] = 'Courses Complete Report';
			$data['pagetitle'] = 'Courses Complete Report';
			
			if($data != false)
			{
				$this->template
					 ->set_layout('admin_default')
		     	 	 ->build('dashboard/complete_course',$data);
					
			}
		}else
		{
			$this->load->view('index');
		}	
	}
	
	
}
