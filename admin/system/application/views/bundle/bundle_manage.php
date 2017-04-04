<?php $del = $_REQUEST['did'];

if($del == 1)
{
	$suc_msg ='Record deleted successfully!!!';
}
?>
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
                <a href="<?php echo base_url();?>bundle_con/add_bundle"><button id="sample_editable_1_new" class="btn green"> Add New <i class="fa fa-plus"></i> </button></a>
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
              <th> Bundle name </th>
              <th> Price </th>
              <th> State </th>
              <th> Status </th>
              <th> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_bundle = count($bundle_details);
				if($count_bundle > 0)
				{ 
				  foreach($bundle_details as $row)
				  {		
							
			?>
                    <tr class="odd gradeX">
                      <td><input type="checkbox" class="checkboxes" value="1"/></td>
                      <td><?php echo $row['bundle_name'];?></td>
                      <td><?php echo $row['bundle_price'];?></td>
                      <td><?php echo $row['state']?></td>
                      <td><?php echo $row['bundle_status'];?></td>
                      <td>
                        <a href="<?php echo base_url();?>bundle_con/edit_bundle/<?php echo $row['bundle_id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_bundle(<?php echo $row['bundle_id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a>&nbsp;&nbsp;
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
