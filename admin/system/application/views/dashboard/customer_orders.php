<?php 
$data_state = array();
			$data_state[''] = '--Select state--';
			foreach($states as $state)
			{
				$state_id = $state['state_id'];
				$data_state[$state_id] = $state['state'];
			}		
			$state_data = set_value('state_id');

?>
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i><?php echo $pagetitle;?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
        
        <div class="filter-form hidden-xs">
 <style>
 .form-inline .input-parent {
  display: inline-block;
}
.filter-form .form-control {
  background-color: #fff;
  border:1px solid #979797 !important;
  background-image: none !important;
  
}
.beatpicker-clear beatpicker-clearButton button{ display:none !important;
	}
 </style>
<!--<form class="form-inline">-->
<?php  
       
	    	$attributes = array('class' => 'form-inline', 'id' => 'myform');
			echo form_open('index_con/customer_order_list/',$attributes);
				$arr_submit = array(
								'name' => 'submit',
								'value' => $pagetitle,
								'class' => 'btn green'
			);
			
			 ?>

  <div class="form-group">
       <label class="control-label">From</label>
                  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
				  <input type="text" class="form-control" id="fromdate" name="fromdate" required="required" value="<?php echo $sdate; ?>" readonly >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>
  </div>
  
  <div class="form-group">
  <label class="control-label">To</label>
                  <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
				  <input type="text" class="form-control" id="todate" name="todate" required="required" value="<?php echo $todate; ?>" readonly >
				  <span class="input-group-btn">
				  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				  </span>
				</div>

  </div>
  <div class="form-group">
   
                     <?php echo form_dropdown('state_id',$data_state,$state_data,'class="select2_category form-control" tabindex="0"');?>

  </div>
  <input  type="submit" name="submit" value="Filter"   class="btn btn-wht"/>
  <!--<button type="submit"  value="submit" class="btn btn-wht">Filter</button>-->
  <?php //echo form_submit($arr_submit)?>
       <?php	
			//echo form_fieldset_close(); 
			echo form_close();
		  ?>
  <!--</form>-->
 </div>
        <div class="row">
        </div>
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group">
               
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
              <th> User Name </th>
              <th> Order Number </th>
              <th> Order Amount </th>
              <th> Order Date </th> 
              <th> Action </th>           
            </tr>
          </thead>
          <tbody>
             <?php 
			
				$count_order_details = count($order_details);
				if($count_order_details > 0)
				{ 
				//Get total for all orders with set filters
				$total = 0;
				  foreach($order_details as $row )
				  {
					  
					  $total += $row['order_total'];
			?>
             <tr class="odd gradeX">
                       <td><input type="checkbox" class="checkboxes" value="1"/></td>
                      <td><?php echo ucfirst($row['first_name'])." ".ucfirst($row['last_name']);?></td>
                      <td><?php echo $row['order_number'];?></td>
                       <td><?php echo $row['order_total'];?></td>
                        <td><?php echo date('m-d-Y',strtotime($row['order_date']));?></td>
                        
                      <td><a href="javascript:void(0)" title="view" class="btn default btn-xs purple" onclick="return view_order(<?php echo $row['order_id'];?>)"> <i class="fa fa-eye"></i></a></td>
                    </tr>
            <?php
				 }
			}
			
			echo '<p class="total-orders">Total of '.count($order_details).' orders totaling $'.number_format($total).'</p>';
			?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
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
<script  src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/BeatPicker.min.js"></script>    
        <!-- Sticky -->
     <script type="text/javascript" >
            $(document).ready(function(){ 
                customOptions = {
                view : {
                    alwaysVisible:true
                },
                buttons: {
                    clear: false,
                    icon: false
                }
            }
            })

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
        </script>