<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title"> 
        <div class="caption"> <i class="fa fa-globe"></i>States</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
              </div>
            </div>
          </div>
        </div>
       <?php if(isset($suc_msg) && $suc_msg!=''){ ?> 
         <div class="alert alert-success">
          <?php echo $suc_msg;?>
        </div>
        <?php } ?>
        <div class="alert alert-success" style="display:none;" id="delmsg">
        <span>Record deleted succesfully</span>
        </div>
        <table class="table table-striped table-bordered table-hover" id="sample_5">
          <thead>
            <tr>
            <!--  <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
              </th>-->
              <th width="30%">State Name</th>
               <th width="25%">Phone No</th>
              <th width="10%">Fax </th>
              <th width="15%">Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			
				$count_state_details = count($state_details);
				if($count_state_details > 0)
				{ 
				  foreach($state_details as $row )
				  {
			?>
                    <tr class="odd gradeX">
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php echo $row['state']." (".$row['state_abbr'].")";?></td>
                       <td><?php echo $row['state_phone'];?></td>
                       
                      <td><?php echo $row['state_fax'];?></td>
                      <td><a href="javascript:void(0)" title="View" alt="View" class="btn default btn-xs purple" onclick="return view_state(<?php echo $row['state_id'];?>)"> <i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo base_url();?>state_con/state_edit/<?php echo $row['state_id'];?>" title="Edit" class="btn default btn-xs purple"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a href="<?php echo base_url();?>state_con/manage_requirement/<?php echo $row['state_id'];?>" title="State Requirement" class="btn default btn-xs red"> <i class="icon-flag"></i></a><a href="state_con/manage_credits/<?php echo $row['state_id'];?>" alt="Add Credits" title="Add Credits" class="btn default btn-xs purple"><i class="fa fa-trophy"></i></a>
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
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/view_state.js"></script>
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
				
			</div>
		</div>
	</div>	
	</div>
</div>
