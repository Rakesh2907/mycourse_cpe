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
                <a href="<?php echo base_url();?>subcription_con/add_subcription"><button id="sample_editable_1_new" class="btn green"> Add New <i class="fa fa-plus"></i> </button></a>
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
        <?php if(isset($suc_msg) && $suc_msg!=''){ ?> 
       	 <div class="alert alert-success">
        	 <?php echo $suc_msg;?>
       	</div>
        <?php } ?>
        <table class="table table-striped table-bordered table-hover" id="sample_1">
          <thead>
            <tr>
              <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
              </th>
              <th> Subscription Title </th>
              <th> Price </th>
              <th> Duration </th>
              <th> Status </th>
              <th> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_subcription = count($subcription_details);
				if($count_subcription > 0)
				{ 
				  foreach($subcription_details as $row)
				  {		
							
			?>
                   <tr class="odd gradeX">
                      <td><input type="checkbox" class="checkboxes" value="1"/></td>
                      <td><?php echo $row['title'];?></td>
                      <td><?php echo $row['price'];?></td>
                      <td><?php echo $row['duration']?></td>
                      <?php if($row['status']=='active'){?>
                        <td><?php echo 'Active';?></td>
                      <?php }else{ ?>
                        <td><?php echo 'In-Active';?></td>
                      <?php } ?>
                      
                      <td>
                        <a href="<?php echo base_url();?>subcription_con/edit_subcription/<?php echo $row['subscription_id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_subcription(<?php echo $row['subscription_id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a>&nbsp;&nbsp;
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
