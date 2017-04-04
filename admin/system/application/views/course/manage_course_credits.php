<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i><?php echo $course_details[0]['course_name'];?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body form">    
        <!-- BEGIN FORM-->
       <form id="bookForm" method="post" class="form-horizontal">
        <?php
            $data_state = array();
			$data_state[''] = '--Select State--';
			if($action != 'edit'){
			   $data_state['all'] = 'All State';
			}
			
			foreach($states as $state)
			{
				$state_id = $state['state_id'];
				$data_state[$state_id] = $state['state'];
			}	
			
			if($action == 'edit'){
				$state_data = $course_credit_details[0]['state_id'];
			}else{
				$state_data = set_value('state');	
			}
			
			$data_credit_types = array();
			$data_credit_types[''] = '--Select Credit Type--';
			foreach($credit_type as $types)
			{
				$type_id = $types['type_id'];
				$data_credit_types[$type_id] = $types['type'];
			}
			if($action == 'edit'){
				$ctype_data = $course_credit_details[0]['course_type'];
			}else{		
				$ctype_data = set_value('credit_type');
			}
			
			if($action == 'edit')
			{
				$credits = $course_credit_details[0]['credit_numbers'];
			}else{
				$credits = set_value('credits');	
			}
			$data_credits = array(
						  		 'name'         => 'credits',
								  'id'          => 'credits',
								  'value'       => $credits,
								  
								  'class'		=> 'form-control',
								  'placeholder'		=> 'Credit*'
							   );
			
			
        ?>
          <div class="form-body">
           <?php if($action == 'edit'){ ?>
              <h3 class="form-section">Edit Credits</h3>
           <?php }else{?>
              <h3 class="form-section">Add Credits</h3>
           <?php } ?>
          
            <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>"/>
            <?php if($action == 'edit'){ ?>
             	<input type="hidden" name="credit_id" id="credit_id" value="<?php echo $mycredit_id;?>" />
            <?php }?>    
            <div class="form-group">
              <div class="col-xs-4">
                	<?php echo form_dropdown('credit_type',$data_credit_types,$ctype_data,'class="form-control" id="credit_type"'); ?>
              </div>
              <div class="col-xs-4">
               		<?php echo form_dropdown('state',$data_state,$state_data,'class="form-control" id="state"'); ?>
              </div>
              <div class="col-xs-2">
                	<?php echo form_input($data_credits); ?>
              </div>
              <div class="col-xs-2">
                <?php if($action == 'edit'){?>
                	<button type="button" class="btn green" id="edit_credit">Edit</button>
                <?php }else{?>
                	<button type="button" class="btn green" id="save_credit">Add Credit</button> 
                <?php }?>   
               <!-- <button type="button" class="btn btn-default addButton"><i class="fa fa-plus"></i></button>-->
              </div>
            </div>
            <h3 class="form-section">Credits</h3>
             <table id="sample_2" class="table table-striped table-bordered table-hover">
             <thead>
                   <tr id="head">
                      <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
              </th>
                     <!--<th>Credit Id</th>-->
                     <th>Credits Type</th>
                     <th>States</th>
                     <th>Credits</th>
                     <th>Actions</th>
                   </tr>
              </thead>     
                   <tbody>
                   <?php
				      if(count($credit_details) > 0)
					  {
						  foreach($credit_details as $key => $val)
						  { 
						      
				   ?>
                  				<tr>
                                   <td><input type="checkbox" class="checkboxes" value="1"/></td>
                                  <!-- <td><?php //echo $val['id']?></td>-->
                                   <td><?php echo $val['type']?></td>
                                   <td><?php echo $val['state']?></td>
                                   <td><?php echo $val['credit_numbers']?></td>
                                   <td><a href="<?php echo base_url();?>course_con/manage_credits/<?php echo $val['course_id'];?>/<?php echo $val['id'];?>" class="btn default btn-xs purple" title="Edit credit" alt="Edit credit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp <a href="javascript:void(0)" class="btn default btn-xs red" title="Delete Credit" alt="Delete Credit" onclick="delete_credits(<?php echo $val['course_id'];?>,<?php echo $val['id'];?>)"><i class="fa fa-trash-o"></i></a></td>
                                </tr>
                   <?php
						  }
				   }?>
                 </tbody>
        	 </table>
          </div>
      </form>
        <!-- END FORM--> 
      </div>
    </div>
  </div>
</div>
<!-- END PAGE CONTENT--> 
<div class="modal fade" id="delete_record" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Delete</h4>
        </div>
        <div class="modal-body">
          Are you sure want delete?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" id="yes">Yes</button>
        	<button type="button" class="btn default" id="no" data-dismiss="modal">No</button>
        </div>
    </div>
   </div>
</div>  