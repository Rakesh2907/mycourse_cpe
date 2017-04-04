<?php 
$data_state = array();
			$data_state[''] = '--Select state--';
			foreach($states as $state)
			{
				$state_id = $state['state_id'];
				$data_state[$state_id] = $state['state'];
			}		
			$state_data = set_value('state_id');

//echo "<pre>";print_r($top_customer);die;
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
			echo form_open('index_con/top_customers/',$attributes);
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
  
<!--  <div class="form-group">
   
                     <?php //echo form_dropdown('state_id',$data_state,$state_data,'class="select2_category form-control" tabindex="0"');?>

  </div>-->
  
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
          </div>
        </div>

        <table class="table table-striped table-bordered table-hover" id="sample_2">
          <thead>
            <tr>
              <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
              </th>
              <!--<th> #ID </th>-->
              <th> Customer Name </th>
              <th> Email </th>
              <th> Amount</th>
              <th> Added Date </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$top_customer1 = count($top_customer);
				if($top_customer1 > 0)
				{ 
				  foreach($top_customer as $row )
				  {
					/*  if(isset($row['state']))
					  {
						   	$customer_states = $this->customer_mod->get_customer_states($row['state']);
							if(count($customer_states) > 0){
										$state_param = array();
										foreach($customer_states as $myrows){
											$state_param[] = $myrows['state'];
										}
							}
								
					  }*/
			?>
                    <tr class="odd gradeX">
                      <td><input type="checkbox" class="checkboxes" value="1"/></td>
                     <!-- <td><?php //echo $row['id']?></td>-->
                      <td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
                      <td><a href="mailto:<?php echo trim($row['email']);?>"><?php echo trim($row['email']);?></a></td>	  
                      <td><?php echo trim($row['total']);?></td>
                      <td>
                     <?php echo date('m-d-Y',strtotime($row['created'])); ?>
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

        </script>