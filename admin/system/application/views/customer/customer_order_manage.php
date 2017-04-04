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
                <a href="<?php echo base_url();?>customer_con/add_course_order/<?php echo $userid;?>"><button id="sample_editable_1_new" class="btn green"> Add Course <i class="fa fa-plus"></i> </button></a>
              </div>
              <div class="btn-group">
                <a href="<?php echo base_url();?>customer_con/add_bunddle_order/<?php echo $userid;?>"><button id="sample_editable_1_new" class="btn green"> Add Bundle <i class="fa fa-plus"></i> </button></a>
              </div>
              
              <div class="btn-group">
                <a href="<?php echo base_url();?>customer_con/add_subscription_order/<?php echo $userid;?>"><button id="sample_editable_1_new" class="btn green"> Add Subscription <i class="fa fa-plus"></i> </button></a>
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
         <input type="hidden" name="userid" id="userid" value="<?php echo $userid;?>" />
        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
              <!--<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
              </th>-->
             
              <th> Order Number </th>
              <th> Date </th>
              <th> Amount </th>
              <th> Trans Id </th>
              <th> Action </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_customer = count($order_details);
				if($count_customer > 0)
				{ 
				  foreach($order_details as $row )
				  {
					  $orderdate=date('Y-m-d', strtotime($row['order_date']));
				
			?>
                    <tr class="odd gradeX">
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php if($row['order_number']){ echo $row['order_number'];}else{ echo $row['order_id'];}?></td>
                      <td><?php echo $orderdate;?></td>	  
                      <td> <?php echo $row['order_total']; ?></td>
                      <td> <?php echo $row['txn_number']; ?></td>
                      <td>
                        <a href="javascript:void(0)" class="btn default btn-xs purple" onclick="return view_order(<?php echo $row['order_id'];?>)"> <i class="fa fa-eye"></i></a>
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
<div class="modal fade" order_id="delete_record" tabindex="-1" role="basic" aria-horder_idden="true">
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
<div id="ajax1">
	<div id="appts_popup" class="modal fade" tabindex="-1" data-width="400">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:closePopup()"></button>
				<h4 class="modal-title" ><b id="popup_title"></b></h4>
			</div>
			<div id="appts-details" class="modal-body row"></div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn" 	onclick="javascript:closePopup()">Close</button>
				<button type="button" data-dismiss="modal" class="btn red" onclick="javascript:closePopup()">Ok</button>
			</div>
		</div>
	</div>	
	</div>
</div>
<script>
function view_order(ordid)
{
  
  	$.ajax({
				url: SITE_URL+"customer_con/get_order_details/"+ordid, 
				async:false,
				success: function(result){
					$("#popup_title").html("Order Course Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});	
}
</script>