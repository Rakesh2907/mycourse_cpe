<?php 
$attributes = array('class' => 'horizontal-form', 'id' => 'myform');
			echo form_open(base_url().'faq_con/contactus',$attributes);
			
			$name = set_value('name');	
			$data_name = array(
						  		 'name'         => 'name',
								  'id'          => 'name',
								  'value'       => $name,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'First Name',
								   'required'     =>'required'
									);
			
			$email = set_value('email');				  
			$data_email = array(
						  		 'name'         => 'email',
								  'id'          => 'email',
								  'type'        =>'email',
								  'value'       => $email,
								  'class'		=> 'form-control',
								  'placeholder' => 'Email',
								  'required'     =>'required'
								 );
			$subject = set_value('subject');	
			$data_subject = array(
						  		 'name'         => 'subject',
								  'id'          => 'subject',
								  'value'       => $subject,
								  'class'		=> 'form-control',
								  'placeholder'		=> 'subject',
								   'required'     =>'required'
									);
			$message = set_value('message');				  
			$data_message = array(
						  		  'name'        => 'message',
								  'id'          => 'message',
								  'value'       => $message,
								  'rows'		=> '2',
								  'cols'		=> '10',
								  'class'		=> 'form-control',
								  'required' 	=> 'required',
								  'placeholder'		=> 'Message',
								   'required'     =>'required'
								 ); 											 	  
			
			
			$arr_submit = array(
								'name' => 'submit',
								'value' => 'SUBMIT',
								'class' => 'btn green'
			
			);
												  
								  
?>

<div class="section-full mng-filter bd-pd-tp-16">
  <div id="filt_Cont" class="filter-sidebar">
    <div class="filter_inner">
      <div class="close-sec">Filters <span class="close icon-cross" onclick="toggler('filt_Cont');"></span></div>
      <div class="panel-group custom-panel" id="accordion">
        <div class="panel">
          <div class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> Faq </a> </div>
          <div class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#faq_con/contactus"> Contact Us </a> </div>
          <div id="collapseOne" class="panel-collapse collapse in">
            <div class="search-sec">
            </div>
            <div class="panel-body filter-max-ht cust-scroll">
              <ul class="list-unstyled" id="stateList">
                
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /filter_inner --> 
  </div>
  <!-- /filter-sidebar  -->
  
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-8 col-lg-8 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
        <h3>Get In Touch</h3>
        <span>Please fill out the enquiry below forms</span>
      
              <div class="form-body">
             
					<?php if(validation_errors()){?>
                        <div class="alert alert-danger display-hide" style="display: block;">
                            <button class="close" data-close="alert"></button>
                            You have some form errors. Please check below.
                        </div>
                    <?php } ?>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Name</label>
                          <?php echo form_input($data_name); ?>
                           <span class="help-block help-block-error" for="name" style="color:#F30;"><?php echo form_error('name'); ?></span>
                        </div>
                      </div>
                      <!--/span-->
                      
                      <!--/span--> 
                    </div>
                    
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                        <label> Email</label>
                          <?php echo form_input($data_email); ?>
                           <span class="help-block help-block-error" for="email" style="color:#F30;"><?php echo form_error('email'); ?></span>
                        </div>
                      </div>
                      <!--/span-->
                      
                      <!--/span--> 
                    </div>
                    
                            <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                        <label> Subject</label>
                          <?php echo form_input($data_subject); ?>
                           <span class="help-block help-block-error" for="subject" style="color:#F30;"><?php echo form_error('subject'); ?></span>
                        </div>
                      </div>
                      <!--/span-->
                    
                      <!--/span--> 
                    </div>
                   
                     <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                        <label> Message</label>
                           <?php echo form_textarea($data_message); ?>
                  <span class="help-block help-block-error" for="message" style="color:#F30;"><?php echo form_error('message'); ?></span>
                        </div>
                      </div>
                      <!--/span-->
                      
                      <!--/span--> 
                    </div>
                  <?php echo form_submit($arr_submit)?>   
              </div>
           <?php	
			echo form_fieldset_close(); 
			echo form_close();
		  ?>
        
      </div>
      <!-- /col --> 
      
    </div>
  </div>
</div>
<script>
 
</script>