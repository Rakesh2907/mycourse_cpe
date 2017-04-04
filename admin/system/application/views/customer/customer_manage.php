<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Manage <?php echo $pagetitle;?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group">
                <a href="<?php echo base_url();?>customer_con/add_customer"><button id="sample_editable_1_new" class="btn green"> Add New <i class="fa fa-plus"></i> </button></a>
              </div>
            </div>
            <!--<div class="col-md-6">
              <div class="btn-group pull-right">
                <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i> </button>
                <ul class="dropdown-menu pull-right">
                  <li> <a href="#"> Print </a> </li>
                  <li> <a href="#"> Save as PDF </a> </li>
                  <li> <a href="#"> Export to Excel </a> </li>
                </ul>
              </div>
            </div>-->
          </div>
        </div>
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
              <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
              </th>
              <!--<th> #ID </th>-->
              <th> Name </th>
              <th> Email </th>
              <th> States </th>
              <th> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_customer = count($customer_details);
				if($count_customer > 0)
				{ 
				  foreach($customer_details as $row )
				  {
					  if(isset($row['state']))
					  {
						   	$customer_states = $this->customer_mod->get_customer_states($row['state']);
							if(count($customer_states) > 0){
										$state_param = array();
										foreach($customer_states as $myrows){
											$state_param[] = $myrows['state'];
										}
							}
								
					  }
			?>
                    <tr class="odd gradeX">
                      <td><input type="checkbox" class="checkboxes" value="1"/></td>
                     <!-- <td><?php //echo $row['id']?></td>-->
                      <td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
                      <td><a href="mailto:<?php echo trim($row['email']);?>"><?php echo trim($row['email']);?></a></td>	  
                      <td> <?php 
					    if(is_array($state_param)){
						  echo $states = wordwrap(implode(',',$state_param),35,"<br>\n",'1');    
						}
					   ?></td>
                      <td>
                        <a href="<?php echo base_url();?>customer_con/edit_customer/<?php echo $row['id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_customer(<?php echo $row['id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs purple" href="<?php echo base_url();?>customer_con/custome_orders/<?php echo $row['id'];?>" alt="Orders" title="Orders"/><i class="icon-basket-loaded"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs purple" href="<?php echo base_url();?>customer_con/custome_courses_report/<?php echo $row['id'];?>" alt="Orders" title="Course Progress"/><i class="fa fa-book"></i></a>
                      </td>
                    </tr>
            <?php
				 }
			}?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
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