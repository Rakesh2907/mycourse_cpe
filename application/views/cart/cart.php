<div class="bd-min-hgt">

<div class="section-full cart-header">
  <div class="container text-center">
    <div class="cart-top-sec">
     <?php
	   if($this->session->userdata('cart_count') == '' || $this->session->userdata('cart_count') == '0') {?>
      	<div class="crt_Head">You have 0 items in your cart.</div>
     <?php }else{ ?> 
        <div class="crt_Head">You have <?php echo $this->session->userdata('cart_count'); ?> items in your cart.</div>
        <a class="btn fad-orange medium" href="<?php echo base_url()?>checkout">CHECKOUT NOW</a>
        <div class="trs_text"><i>We use 256-bit encryption. Your transaction is 100% secure.</i></div>
     <?php } ?>   
    </div>
  </div>
</div>
<!-- /cart-header -->

<div class="section-full pad-tb">
  <div class="container">
    <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1">
      <div class="row">
        <?php if($this->session->userdata('cart_count') != '') {?>
     	<?php 
	   		if(count($order_item_details) > 0) { 
	 	?>
        <table class="table cst-tbl cart_bdl_Listing bund-list-sec">
           <?php
		      $subtotal = 0; 
		      foreach($order_item_details as $items)
			  { 
			      if($items['purchase_type'] == 'Bundle')
				  {
					   $bundle_credit_count = '0.00';
					   $bundle_courses = array();
					   $bundle_details = $this->bundle_mod->get_bundle_details($items['course_id']);
					   $bundle_credit_count = $this->bundle_mod->get_course_credits($bundle_details[0]['bundle_courses'],$bundle_details[0]['state_id']);
		
					   if($bundle_credit_count == ''){
							$bundle_credit_count = '0.00';
					   }
					   
					   $bundle_courses = $this->bundle_mod->get_bundle_courses($bundle_details[0]['bundle_courses']);
					   if(count($bundle_courses) > 0)
					   {    
					        $authors = array();
							foreach($bundle_courses as $key => $courses){
								$authors[] = $courses['course_author'];
							}
					    	$myauthors = implode(',',$authors);
							$myauthors = implode(',', array_unique(explode(',',$myauthors)));
							$authors_details = $this->course_mod->get_course_faculties($myauthors);
							
							$bud_auth = array();
							foreach($authors_details as $auth_items)
							{
								$bud_auth[] = $auth_items['first_name'].' '.$auth_items['last_name'];
							}
							
							//$total_authors = implode(', ',$bud_auth);
						   $total_authors='';
					   } 
					  
					   
		    ?>
                      <tr>
                        <td class="cart_bdl_img" <?php if(isset($bundle_details[0]['back_color']) && $bundle_details[0]['back_color']!=''){ echo 'style="background-color:'.$bundle_details[0]['back_color'].'"';} ?>><div class="bund-type"><img width="15" src="<?php echo $this->config->item("cdn_css_image")?>images/bund-pdf.png" alt="Bag"></div>
                          <div class="bund-img-sec" <?php if(isset($bundle_details[0]['back_color']) && $bundle_details[0]['back_color']!=''){ echo 'style="background-color:'.$bundle_details[0]['back_color'].'"';} ?>>
                            <?php $img_file = DIR_IMAGES.''.$bundle_details[0]['bundle_image']; 
							if(isset($bundle_details[0]['s3_images']) && $bundle_details[0]['s3_images']!='')
							{
							?>
                              <a href="<?php echo base_url()."compliance-bundles/".$bundle_details[0]['bundle_id']."/".$bundle_details[0]['state_id'];?>"><img class="bdl-img" src="<?php echo $bundle_details[0]['s3_images'];?>" alt="<?php echo $bundle_details[0]['bundle_name'];?>" title="<?php echo $bundle_details[0]['bundle_name'];?>"></a>
                            <?php	
							}else if (file_exists($img_file) || $bundle_details[0]['bundle_image']!='') { 
							?>
                              <a href="<?php echo base_url()."compliance-bundles/".$bundle_details[0]['bundle_id']."/".$bundle_details[0]['state_id'];?>"><img class="bdl-img" src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $bundle_details[0]['bundle_image'];?>" alt="<?php echo $bundle_details[0]['bundle_name'];?>" title="<?php echo $bundle_details[0]['bundle_name'];?>"></a>
							<?php }else{?> 
                             <a href="<?php echo base_url()."compliance-bundles/".$bundle_details[0]['bundle_id']."/".$bundle_details[0]['state_id'];?>"><img class="bdl-img" src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-starcbuks.png" alt="<?php echo $bundle_details[0]['bundle_name'];?>" title="<?php echo $bundle_details[0]['bundle_name'];?>"></a>
                             <?php } ?>   
                             
                          </div></td>
                        <td class="cart_bdl_inf"><div class="bund-desc">
                            <h4><a href="<?php echo base_url()."compliance-bundles/".$bundle_details[0]['bundle_id']."/".$bundle_details[0]['state_id'];?>"><?php echo trim($bundle_details[0]['bundle_name']);?></a></h4>
                            <div class="bdl_small"><i><?php echo wordwrap($total_authors,45,"<br>\n");?></i></div>
                            <div class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $bundle_credit_count;?> credits</div>
                          </div></td>
                        <td class="cart_prs rem-prs text-right"><b class="prs">$<?php echo number_format($items['course_amount'],2);?></b> <a class="remv" href="javascript:void(0)" onclick="remove_item('bundle',<?php echo $items['order_id']?>,<?php echo $items['course_id'];?>,'false')">Remove</a></td>
                      </tr>
          <?php  }
		         elseif($items['purchase_type'] == 'Course')
				 {
					  $credit_count = 0;
					  
					  if($items['course_state']!='')
					  {
						   $state_id =  $this->state_mod->state_details($items['course_state']);
						   $stateid = $state_id[0]['state_id'];
					  }
					  
					  $credit_count = $this->bundle_mod->get_course_credits($items['course_id'],$stateid);
		
					  if($credit_count == ''){
							$credit_count = '0.00';
					  }
					  
					  $course_details = $this->course_mod->get_course_details($items['course_id']); 
					  $authors_details = $this->course_mod->get_course_faculties($course_details[0]['course_author']); 
					  
					  $auth_name = array();
					  
					  foreach($authors_details as $key => $authorsVal)
	 				  {
						   $auth_name[] = $authorsVal['first_name'].' '.$authorsVal['last_name'];
					  } 
					  $author_name = implode(', ',$auth_name); 
		  ?>
                       <tr>
                        <td class="cart_bdl_img" <?php if(isset($course_details[0]['back_color']) && $course_details[0]['back_color']!=''){ echo 'style="background-color:'.$course_details[0]['back_color'].'"';} ?>><div class="bund-type">
                        
                                 <?php 
								  if($course_details[0]['course_format'] == 'Text')
								  {
									  $icon_image = 'bund-pdf.png';
								  }else if($course_details[0]['course_format'] == 'Webcast'){
									  $icon_image = 'bund-video-icon.png';
								  }
					 			?>
                                <img width="15" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo $icon_image;?>" alt="Bag">
                             </div>
                          <div class="bund-img-sec" <?php if(isset($course_details[0]['back_color']) && $course_details[0]['back_color']!=''){ echo 'style="background-color:'.$course_details[0]['back_color'].'"';} ?>> 
                                  <?php $img_file = DIR_IMAGES.''.$course_details[0]['course_image']; 
								  if(isset($course_details[0]['s3_images']) && $course_details[0]['s3_images']!='')
								  {
								  ?>
                                     <a href="<?php echo base_url()?>individual-courses/<?php echo $course_details[0]['course_id'];?>/<?php echo $stateid;?>"><img class="bdl-img" src="<?php echo $course_details[0]['s3_images'];?>" alt="<?php echo $course_details[0]['course_name'];?>" title="<?php echo $course_details[0]['course_name'];?>"></a>
                                  <?php	  
								  }else if (file_exists($img_file) || $course_details[0]['course_image']!='') {?> 	
                                    <a href="<?php echo base_url()?>individual-courses/<?php echo $course_details[0]['course_id'];?>/<?php echo $stateid;?>"><img class="bdl-img" src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $course_details[0]['course_image'];?>" alt="<?php echo $course_details[0]['course_name'];?>" title="<?php echo $course_details[0]['course_name'];?>"></a>
								  <?php }else{?> 
                                	<a href="<?php echo base_url()?>individual-courses/<?php echo $course_details[0]['course_id'];?>/<?php echo $stateid;?>"><img class="bdl-img" src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-starcbuks.png" alt="<?php echo $course_details[0]['course_name'];?>" title="<?php echo $course_details[0]['course_name'];?>"></a>
                                  <?php } ?>  
                            
                          </div></td>
                        <td class="cart_bdl_inf"><div class="bund-desc">
                            <h4><a href="<?php echo base_url()?>individual-courses/<?php echo $course_details[0]['course_id'];?>/<?php echo $stateid;?>"><?php echo trim($course_details[0]['course_name']);?></a></h4>
                            <div class="bdl_small"><i><?php echo wordwrap($author_name,45,"<br>\n");?></i></div>
                            <div class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $course_details[0]['cpe_credits'];//$credit_count;?> credits</div>
                          </div></td>
                        <td class="cart_prs rem-prs text-right"><b class="prs">$<?php echo number_format($items['course_amount'],2);?></b> <a class="remv" href="javascript:void(0)" onclick="remove_item('course',<?php echo $items['order_id']?>,<?php echo $items['course_id'];?>,'false')">Remove</a></td>
                      </tr>
		  <?php 
		         }
				  elseif($items['purchase_type'] == 'Subscription')
				  {
					    $sub_details = $this->subscription_mod->get_subscription_details($items['course_id']);
		  ?>
          				<tr>
                         <td class="cart_bdl_img">
                         <div class="bund-img-sec subscription"><img class="bdl-img" src="<?php echo $this->config->item("cdn_css_image")?>images/subscription_icon_02.png" title="<?php echo trim($sub_details[0]['title']);?>"></div></td>
                          <td class="cart_bdl_inf"><div class="bund-desc"><h4><?php echo trim($sub_details[0]['title']);?></h4></div></td>
                          <td class="cart_prs rem-prs text-right"><b class="prs">$<?php echo number_format($items['course_amount'],2);?></b> <a class="remv" href="javascript:void(0)" onclick="remove_item('subscription',<?php echo $items['order_id']?>,<?php echo $items['course_id'];?>,'false')">Remove</a></td>
                        </tr> 
          <?php				 
				  }
		   ?>        
          <?php
		      $subtotal =  ($subtotal + number_format($items['course_amount'],2));  
		  } ?>
          <tr class="cart_ttl">
            <td colspan="3" class="text-right"><b class="crt_sub_ttl">Subtotal -   $<?php echo $subtotal;?></b></td>
          </tr>
        </table>
        <?php
	      	}
		 }  
		?> 
        <div class="more-cr text-center">
          <div class="text-inf">Need more credits?</div>
          <a href="<?php echo base_url();?>" class="btn btn-blue-no-sh medium">CONTINUE SHOPPING</a> </div>
      </div>
          
   
      <div class="row">
        <div class="row bdl_sc_Grd all_bdl_grd sugg_bdl">
          <h4 class="head-16">Suggested Courses</h4>
          <?php 
		       if(count($cart_similar_courses) > 0)
		       { 
		        foreach($cart_similar_courses as $simi_courses)
				{ 
					  $credit_count = 0;
					  $credit_count = $this->bundle_mod->get_course_credits($simi_courses['course_id'],$stateid);
		
					   if($credit_count == ''){
							$credit_count = '0.00';
					   }
					
					  $auth_details = $this->course_mod->get_course_faculties($simi_courses['course_author']); 
					  
					  $author_name = array();
					  
					  foreach($auth_details as $key => $authorsVal)
	 				  {
						   $author_name[] = $authorsVal['first_name'].' '.$authorsVal['last_name'];
					  } 
					  $author_name = implode(', ',$author_name); 	
		  ?>
                  <div class="col-sm-4">
                    <div class="bund-list-sec bdl_Small">
                      <div class="bund-img-sec" <?php if(isset($simi_courses['back_color']) && $simi_courses['back_color']!=''){ echo 'style="background-color:'.$simi_courses['back_color'].'"';} ?>>
                          <?php 
						      $img_file = DIR_IMAGES.''.$simi_courses['course_image']; 
							   if(isset($simi_courses['s3_images']) && $simi_courses['s3_images']!='')
							   {
						 ?>
                         		<a href="<?php echo base_url()?>individual-courses/<?php echo $simi_courses['course_id'];?>/<?php echo $stateid;?>"><img width="69" class="bdl-img" src="<?php echo $simi_courses['s3_images'];?>" alt="<?php echo $simi_courses['course_name'];?>" title="<?php echo $simi_courses['course_name'];?>"></a>
                         <?php 		   
							   }elseif (file_exists($img_file) || $simi_courses['course_image']!='') {
						   ?> 
                           	 	<a href="<?php echo base_url()?>individual-courses/<?php echo $simi_courses['course_id'];?>/<?php echo $stateid;?>"><img width="69" class="bdl-img" src="<?php echo CLOUDFRONT_URL;?>images/<?php echo $simi_courses['course_image'];?>" alt="<?php echo $simi_courses['course_name'];?>" title="<?php echo $simi_courses['course_name'];?>"></a>
                          <?php }else{?>
                        		<a href="<?php echo base_url()?>individual-courses/<?php echo $simi_courses['course_id'];?>/<?php echo $stateid;?>"><img width="69" class="bdl-img" src="<?php echo $this->config->item("cdn_css_image")?>images/bundle-starcbuks.png" alt="bundle"></a>
                          <?php } ?>      
                        <div class="bund-type">
                           <?php 
							  if($simi_courses['course_format'] == 'Text')
							  {
								  $icon_image = 'bund-pdf.png';
							  }else if($simi_courses['course_format'] == 'Webcast'){
								  $icon_image = 'bund-video-icon.png';
							  }
					 	   ?>
                          <img width="18" src="<?php echo $this->config->item("cdn_css_image")?>images/<?php echo $icon_image;?>" alt="PDF"></div>
                        <div class="bund-price">$<?php echo trim($simi_courses['course_price']);?></div>
                      </div>
                      <!-- /bund-img-sec -->
                      
                      <div class="bund-desc">
                      	<div class="bdl-hd">
                        <h5><a href="<?php echo base_url()?>individual-courses/<?php echo $simi_courses['course_id'];?>/<?php echo $stateid;?>" class="link-title"><?php echo trim($simi_courses['course_name']);?></a></h5>
                        <div class="bdl_small"><i><?php echo wordwrap($author_name,45,"<br>\n");?></i></div>
                        </div>
                        <div class="ttl-credit"><img src="<?php echo $this->config->item("cdn_css_image")?>images/credit-icon.png" alt="credit-icon"><?php echo $simi_courses['cpe_credits'];//$credit_count;?> credits</div>
                        <a href="<?php echo base_url()?>individual-courses/<?php echo $simi_courses['course_id'];?>/<?php echo $stateid;?>" class="btn small_btn btn-blue-text">VIEW Course</a> </div>
                      <!-- /bund-desc --> 
                    </div>
                  </div>
          <?php
			 }
		  } ?>
        </div>
      </div>
      <!-- row --> 
      
    </div>
    <!-- col --> 
    
  </div>
  <!-- container --> 
  
</div>

</div>
<!-- /bd-min-hgt -->
<script type="text/javascript" src="<?php echo $this->config->item("cdn_css_image")?>js/cart.js"></script>