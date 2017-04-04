<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Orders</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
               <!-- <a href="<?php //echo base_url();?>faculty_con/add_order_details/"><button id="sample_editable_1_new" class="btn green"> Add Faculty <i class="fa fa-plus"></i> </button></a>-->
              </div>
            </div>
          </div>
        </div>
       <?php if(isset($suc_msg) && $suc_msg!=''){ ?> 
         <div class="alert alert-success">
          <?php echo $suc_msg;?>
        </div>
        <?php } ?>
         <div class="alert alert-success" id="mailsend" style="display:none;">
         <span>Oreder Receipt mail succefully send...</span>
        </div>
        <div class="alert alert-success" style="display:none;" id="delmsg">
        <span>Order Refund succesfully</span>
        </div>
        <table class="table table-striped table-bordered table-hover" id="orders_table">
          <thead>
            <tr>
            <!--  <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
              </th>-->
              <th width="25%">User Name</th>
               <th width="15%">Order Number</th>
              <th width="10%">Order Amount</th>
              <th width="25%">Order Date </th>
               <th width="10%">Order Status </th>
              <th width="20%">Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			
				$count_order_details = count($order_details);
				if($count_order_details > 0)
				{ 
				  foreach($order_details as $row )
				  {
			?>
                    <tr class="odd gradeX">
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php echo ucfirst($row['first_name'])." ".ucfirst($row['last_name']);?></td>
                      <td><?php echo $row['order_number'];?></td>
                       <td><?php echo $row['final_total'];?></td>
                        <td><?php echo date('m-d-Y',strtotime($row['order_date']));?></td>
                        <td><?php echo $row['order_status'];?></td>
                      <td><a href="javascript:void(0)" title="view" class="btn default btn-xs purple" onclick="return view_order(<?php echo $row['order_id'];?>)"> <i class="fa fa-eye"></i></a>
                 <?php if($row['order_status']== 'Completed'){ ?>
                      <a class="btn default btn-xs red" href="javascript:void(0)"  id="<?php echo $row['order_id'];?>"  alt="Delete" title="Delete">
<i class="fa fa-trash-o del" id="<?php echo $row['order_id'];?>"></i>
</a>
<a href="javascript:void(0)" title="Email Receipt" class="btn default btn-xs purple" onclick="return order_receipt(<?php echo $row['order_id'];?>)"> <i class="fa fa-envelope"></i></a>
<?php }?></td>
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
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/view_state_req.js"></script>
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
				<button type="button" data-dismiss="modal" class="btn red" id="yes" onclick="javascript:closePopup()">Ok</button>
			</div>
		</div>
	</div>	
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

<script>
function view_order(oid)
{
  
  	$.ajax({
				url: SITE_URL+"userorder_con/get_order_details/"+oid, 
				async:false,
				success: function(result){
					$("#popup_title").html("Order Details");
					$("#selDispo").attr("data-target","#appts_popup");
					$("#appts-details").html(result);
					$("#appts_popup").modal('toggle');
				}
			});	
}

function order_receipt(oid)
{
  
   $.ajax({
		     url: base_url+'userorder_con/send_order_receipt',
			 dataType: 'html',
			 type: 'POST',
			 data: {
				 orderid :  oid
			 }
		  }).done(function(response){
			  if(response == true){
				
				  $("#mailsend").show();
			  }
		 });
}

var UIAlertDialogApi = function () {
  
    var handleDialogs = function() {
		
            $('.del').click(function(){ 
			  var oid=$(this).attr('id');
			 
                bootbox.confirm("Are you sure want to Refund?", function(result) {
					
					if(result == true)
					{
				   	$.ajax({
			
				url: SITE_URL+"userorder_con/refund_order/"+oid, 
				async:false,
				success: function(result){
					
					window.location.reload()
					$("#delmsg").show();
				}
			
			});	
					}
                }); 
            });
			
			
    }

    var handleAlerts = function() {
        
        $('#alert_show').click(function(){

            Metronic.alert({
                container: $('#alert_container').val(), // alerts parent container(by default placed after the page breadcrumbs)
                place: $('#alert_place').val(), // append or prepent in container 
                type: $('#alert_type').val(),  // alert's type
                message: $('#alert_message').val(),  // alert's message
                close: $('#alert_close').is(":checked"), // make alert closable
                reset: $('#alert_reset').is(":checked"), // close all previouse alerts first
                focus: $('#alert_focus').is(":checked"), // auto scroll to the alert after shown
                closeInSeconds: $('#alert_close_in_seconds').val(), // auto close after defined seconds
                icon: $('#alert_icon').val() // put icon before the message
            });

        });

    }

    return {

        //main function to initiate the module
        init: function () {
            handleDialogs();
            handleAlerts();
        }
    };

}();


</script>