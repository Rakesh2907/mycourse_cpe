<?php
/*
#############################################################################
# eLuminous Technologies - Copyright@ http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
# eLuminous Technologies and cant be used / modified without license.
# Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
# prohibhited
#############################################################################
# Name : Landing_con.php
# Created on : 22th Sep 2016 by Shailesh Khairnar
# Update on : 22th Sep 2016 by Shailesh Khairnar
# Purpose : Landing Bundle front page.
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Landing_con extends CI_Controller {
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
	public $current_user_id = 0;
	public $current_state = 0;
	public $search_state_id = 0;
	public $mysearch_bundle = '';
	
	public function __construct()
	{
		
		parent::__construct();
		$this->load->model('state_mod');
		$this->load->model('landing_mod');
		$this->load->model('course_mod');
		$this->load->model('state_mod');
		$this->load->model('cart_mod');
		$this->load->library('Ajax_pagination');
        $this->perPage = 5;
		
		$this->current_user_id = is_logged_in();
		if($this->session->userdata['state_id']=='')
		{
			$this->current_state = find_states();
		}else{
			$this->current_state =  $this->session->userdata['state_id'];
		}
	} 
	 
	public function index($cid='')
	{   
	      
		  $data['page_title'] = 'Bundles | CPE Nation';
		  $data['cuserid'] = $this->current_user_id;
		  
		   if(isset($this->session->userdata['order_id']) && $this->session->userdata['order_id'] > 0){
			$data['cart_id'] = $this->session->userdata['order_id'];
		  }else{
			$data['cart_id'] = 0;  
		  }
		   
			   $bundle_details = $this->landing_mod->get_bundle_details($cid);
			   //echo "<pre>";print_r($bundle_details)  ;die;
			 $landing_details = $this->landing_mod->get_landing_details($cid,$this->current_user_id);
			 if(sizeof($bundle_details) > 0)
			 {
				  
				  $states = $this->state_mod->state_details( $bundle_details[0]['state_id']);
				 //echo "<pre>";print_r($landing_details)  ;die;
				  $data['state_abr'] = $states[0]['state_abbr'];
				  //$data['cuserid'] = $this->current_user_id;
				  //$data['offer_price'] 	  	  =  $bundle_details[0]['bundle_price'];
				  $data['offer_price'] 	  	  =  $bundle_details[0]['offer_price'];
				  $data['landing_status'] 	  =  'pendding';
				   
				   $stateid  =	$bundle_details[0]['state_id'];
				   $coursids =	$bundle_details[0]['bundle_courses'];
				   
				    $credits  =$this->landing_mod->get_ctype_credits($stateid,$coursids); 
					//echo "<pre>";print_r( $credits)  ;die;
					$total_credit = 0;
					if(sizeof($credits) > 0)
					{
					   foreach($credits as $credit)
					   {
						 $total_credit += $credit['credit_numbers'];   
					    }	
						
					}
					$data['total_credit'] 	  =  $total_credit;
					$data['credits'] 		  = $credits;
				    $data['bundle_details']   =  $bundle_details; 
				  //echo "<pre>";print_r($data['bundle_details'])  ;die;
			 
			 $this->template->load('layouts/default_layout.php','bundles/landing.php',$data);    
				 
			 }else{
				redirect(base_url().'login');  
				 
			}
			 
			
			
			
		  
		  
		
		  
	}
    
	public function getHTML($items)
	{
		$bundle_credit_count = 0;
		$bundle_credit_count = $this->bundle_mod->get_course_credits($items['bundle_courses'],$items['state_id']);
		
		if($bundle_credit_count == ''){
			$bundle_credit_count = '0.00';
		}
		
		
		if(isset($items['back_color']) && $items['back_color']!='')
		{ 
		    $inline = 'style="background-color:'.$items['back_color'].'"';
		}else{
			$inline = '';
		}
		
		
		 $img_file = DIR_IMAGES.''.$items['bundle_image']; 
		        if (file_exists($img_file)) {
					$thumb_url = $this->config->item("upload_path").'image/'.$items['bundle_image']; 
				}else{
					$thumb_url = $this->config->item("cdn_css_image").'images/bundle-starcbuks.png';
				}
		
			
		$html = '';
		$html .= '<div class="bund-list-sec">
            <div class="bund-img-sec" '.$inline.'> <img class="bdl-img" src="'.$thumb_url.'" alt="bundle">
              <div class="bund-type"><img src="'.$this->config->item("cdn_css_image").'images/bund-bag.png" alt="Bag" width="57"></div>
              <div class="bund-price">$'.$items['bundle_price'].'</div>
            </div> 
            <div class="bund-desc">
              <h4>'.$items['bundle_name'].'</h4>
              <div class="ttl-credit"><img src="'.$this->config->item("cdn_css_image").'images/credit-icon.png" alt="credit-icon">'.$bundle_credit_count.' credits</div>
              <p class="shr-desc">'.$items['bundle_desc'].'</p>
              <a href="'.base_url().'compliance-bundles/'.$items['bundle_id'].'/'.$items['state_id'].'" class="btn small_btn btn-blue-text">VIEW BUNDLE</a> </div>
          </div>';
		  
		  return $html;
	}
		
	public function get_bundles()
	{
		  $this->search_state_id = $state_id = $this->input->post('stateid');
		  $this->mysearch_bundle = $search_bundle = trim($this->input->post('searchbundle'));
		  $reset_filter = $this->input->post('reset_filter');
		
		  $totalRec = count($this->bundle_mod->bundles_count($state_id,$search_bundle));
		  
		   //pagination configuration
          $config['target']      = '.bund_Lst_sec';
       	  $config['base_url']    = base_url().'bundle_con/ajaxPaginationData';
          $config['total_rows']  = $totalRec;
          $config['per_page']    = $this->perPage;
        
          $this->ajax_pagination->initialize($config);
		  
		  $bundle_list = $this->bundle_mod->bundles_list($state_id,$search_bundle,$this->perPage);
		  $html = "";
		  if(count($bundle_list) > 0)
		  {  
		  	foreach($bundle_list as $bundles_data)
			{	
			  $html .= $this->getHTML($bundles_data);
		  	}
			if($totalRec >= $this->perPage)
			{
				$html .= $this->ajax_pagination->create_links();
		    }
		  	echo $html;
		  }else{
			  echo 'no';
		  }
		  
		  if($reset_filter)
		  {
			   $this->session->unset_userdata('state_id');
			   $arr_state = array('state_id'=> '');
			   $this->session->set_userdata($arr_state); 
		  }
		  exit;
	}
    
	public function ajaxPaginationData()
	{
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$totalRec = count($this->bundle_mod->bundles_count());
		   //pagination configuration
         $config['target']      = '.bund_Lst_sec';
       	 $config['base_url']    = base_url().'bundle_con/ajaxPaginationData';
         $config['total_rows']  = $totalRec;
         $config['per_page']    = $this->perPage;
        
         $this->ajax_pagination->initialize($config);
		  
		  $bundle_list = $this->bundle_mod->bundles_list($this->search_state_id,$this->mysearch_bundle,$this->perPage,$offset);
		  $html = "";
		  if(count($bundle_list) > 0)
		  {  
		  	foreach($bundle_list as $bundles_data)
			{	
			  $html .= $this->getHTML($bundles_data);
		  	}
			if($totalRec >= $this->perPage)
			{
				$html .= $this->ajax_pagination->create_links();
		    }
		  	echo $html;
		  }else{
			  echo 'no';
		  }
		  
		  if($reset_filter)
		  {
			   $this->session->unset_userdata('state_id');
			   $arr_state = array('state_id'=> '');
			   $this->session->set_userdata($arr_state); 
		  }
		  exit;
		
		
		
	}
	
	public function get_type_credits()
	{
		$courses = trim($this->input->post('bundle_courses'));
		$state_id = $this->input->post('stateid');
		$user_course_id = 0;
		if($this->input->post('user_course_id')!=''){
			$user_course_id = $this->input->post('user_course_id');
		}
		//tracking code
		$user_id = $this->current_user_id;
		$state_credits 		= $this->bundle_mod->get_state_credits($state_id);
		//echo "<pre>";print_r($state_credits);die;
		$user_state_credits = $this->bundle_mod->get_user_state_credits($user_id,$state_id,$user_course_id);
		//echo "<pre>";print_r($user_state_credits);die;
		//End tracking code
		
		$credit_type_list = $this->bundle_mod->get_ctype_credits($state_id,$courses);
		//echo "<pre>";print_r($credit_type_list);die;
		$myhtml = "";
		if(count($credit_type_list) > 0)
		{
			 foreach($credit_type_list as $credit_type)
			 {
				  //make sure we make 1 credit singular, and more than one plural. Also round to 1 decimal place.
				  if($credit_type['credit_numbers'] == 1){
					  $myhtml .='<li>'.round($credit_type['credit_numbers'],1).' credit - '.$credit_type['type'].'</li>';
				  }else{
				  	$myhtml .='<li>'.round($credit_type['credit_numbers'],1).' credits - '.$credit_type['type'].'</li>';
				  	}
				  
			 }
			 
			//echo $myhtml; 
		}else{
			echo 'no';
		}
		$trackinghtml='';
		$arrchart ='';
		 $creditcatsname='';
		  $addpercentag=$addcreditpts=0;
		  $final_percenatge=0;
		  $tracker_total=0;
		  $getcredit=0;
		if(count($state_credits) > 0)
		{     $i=0; 
			$colors = array(
				
				'#00C8F8',
				'#39B54A',
				'#FCEE21',
				'#F7931E',
				'#D0021B',
				
			);
		    
			foreach($state_credits as $state_credit)
			 {
				$tracker_total +=$state_credit['credits'];
			 }
			 
			 foreach($state_credits as $state_credit)
			 {   
			      $i+=1;
			      //$percentage=$addpercentag=0;
				  $addcredit=$percentage=0;
				 $track_per=0;
				 $track_perc_add=0;
				  $type=$state_credit['type'];
				  $total=$state_credit['credits'];
				  $back_color =$state_credit['back_color'];
				  $back_color = $colors[$i-1]; //tony added this so we are using 5 preset colors instead of relying on setting 28 different colors in the DB
				 
				  if(count($user_state_credits) > 0)
				  {   $getcredit=0;
					  foreach($user_state_credits as $use_credit)
					 	{
					         if($use_credit['type_id'] == $state_credit['cat_id'])
							 {
							      $getcredit +=	 $use_credit['total_points'];
							 }
					 	}
				  }
				  
				  $totalcredit=$state_credit['credits'];
				 
				  if($getcredit > 0)
				  {
					   $percentage=($getcredit * 100)/$total;
					   
					   $track_perc=($getcredit * 100)/$tracker_total;
					   $final_percenatge +=$track_perc;
				  }
				  
				  //echo $percentage.'>>>'.$total;
				  if(count($credit_type_list) > 0)
					{
						 foreach($credit_type_list as $credit_type)
						 {   
							  if($credit_type['type'] == $type)
							  {
							  	$addcredit +=$credit_type['credit_numbers'];
								$addcreditpts +=$credit_type['credit_numbers'];
								$creditcatsname .=$type.', ';
							  }
							  
						 }
						 
						//echo $myhtml; 
					}
					 
					  	  $addpercentage=($addcredit * 100)/$total;
						 
						  $track_perc_add=($addcredit * 100)/$tracker_total;
						   $final_percenatge +=$track_perc_add;
						 //$arrchart[''.$i.''-1]['total']=$total;
						 //$arrchart[''.$i.''-1]['color']=$back_color;
						 //$arrchart[''.$i.''-1]['addpoint']=$addcredit;
					 
					  if($addcredit > 0)
					  {
						  //echo ">>>".$addpercentage;	die;
						  if($percentage > 0)
						  {
						   	$string .='{value: '.number_format ($track_perc,2).',color: "'.$back_color.'"},';
						  }
						   $string .='{value: '.number_format ($track_perc_add,2).',color: "#000000"},';
						   //echo $track_perc.'>>'.$track_perc_add;
						  $getpt +=$getcredit;
						  $outof +=$total;
					      $trackinghtml .='<li><div class="gr_head">'.$type.'</div>
													<div class="gr-sec">
													<div class="prg-sec">
													<div class="thm-progress clearfix">
													 <div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%; background-color:'. $back_color.';">
							</div>
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:'.$addpercentage.'%;background-color:#000;"></div> <span class="inner-fig">+'.$addcredit.'</span>
													</div>
													</div>
													<span class="gr-fig">'.$getcredit.' / '.$total.'</span>
													</div> <!-- /prg-sec -->
													
													
													</div>
							</li>';
					  }
					  else{
						  $string .='{value: '.number_format ($track_perc,2).',color: "'.$back_color.'"},'; 
						  //echo '<<'.$track_perc;
						  $getpt +=$getcredit;
						  $outof +=$total;
						 $trackinghtml .='<li><div class="gr_head">'.$type.'</div>
													<div class="gr-sec">
													<div class="prg-sec">
													<div class="thm-progress clearfix">
													 <div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%; background-color:'.$back_color.';">
							</div>
							
							
													</div>
													</div>
													<span class="gr-fig">'.$getcredit.' / '.$total.'</span>
													</div> <!-- /prg-sec -->
													
													
													</div>
							</li>';  
							
							
						  
						  
						  }
				
                 }
				 
				 
		}
		
		$percentage_final= (100 - $final_percenatge);
		$string .='{value: '.number_format($percentage_final,2).',color: "#F6F6F6"}'; 
		$trackinghtml.='<script>Chart.types.Doughnut.extend({
								name: "DoughnutTextInside",
								showTooltip: function() {
									this.chart.ctx.save();
									Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
									this.chart.ctx.restore();
								},
								draw: function() {
									Chart.types.Doughnut.prototype.draw.apply(this, arguments);
						
									var width = this.chart.width,
										height = this.chart.height;
						
									var fontSize = (height / 150).toFixed(2);
									this.chart.ctx.font = fontSize + "em Verdana";
									this.chart.ctx.textBaseline = "middle";
						            this.chart.ctx.fillStyle = "black";
									var text = "'.$getpt.'/'.$outof.'" ,
										textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
										textY = height / 2;
						
									this.chart.ctx.fillText(text, textX, textY);
								}
							});
						   
					   
					var data = ['.$string.'];
						
							var DoughnutTextInsideChart = new Chart($("#myChart")[0].getContext("2d")).DoughnutTextInside(data, {
								responsive: true
							});</script> ';
		
		$arrResult['sucess'] = 'True';
		$arrResult['html'] = $myhtml;
		$arrResult['trackhtml'] = $trackinghtml;
		$arrResult['addcredit'] = $addcreditpts;
		$arrResult['creditcats'] = substr($creditcatsname, 0, -2);
		$arrResult['trackcircle'] = $arrchart;
		//echo "<pre>";print_r($arrResult);die;
		echo json_encode($arrResult); 
	}
	
	public function bundle_details($bundle_id,$state_id)
	{
		  $data['page_title'] = 'Bundles | CPE Nation';
		  $data['cuserid'] = $this->current_user_id;
		  
		  if(isset($this->session->userdata['order_id']) && $this->session->userdata['order_id'] > 0){
			$data['cart_id'] = $this->session->userdata['order_id'];
		  }else{
			$data['cart_id'] = 0;  
		  }
		  
		  $data['details'] = $this->bundle_mod->get_bundle_details($bundle_id);
		  $this->template->load('layouts/default_layout.php','bundles/bundle_details.php',$data); 
	}
	
}