<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>Coupons</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <a href="<?php echo base_url();?>coupon_con/add_coupon_details/"><button id="sample_editable_1_new" class="btn green"> Add Coupon <i class="fa fa-plus"></i> </button></a>
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
        <span>Record deleted successfully</span>
        </div>
        <table class="table table-striped table-bordered table-hover" id="coupon_table">
          <thead>
            <tr>
            <!--  <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
              </th>-->
            <!--  <th width="30%">Coupon Code</th>
               <th width="30%">Coupon Type</th>
               <th width="25%">Discount</th>
               <th width="25%">Discount Type</th>
              <th width="10%">Status </th>
              <th width="15%">Actions </th>-->
                <th>Coupon Code</th>
               <th>Coupon Type</th>
               <th>Discount</th>
               <th>Expiration Date</th>
              <th>Status </th>
              <th>Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			
				$count_coupon_details = count($coupon_details);
				if($count_coupon_details > 0)
				{ 
				  foreach($coupon_details as $row )
				  {
			?>
                    <tr class="odd gradeX" style="color:<?php echo ($row['coupon_status'] == 'Deleted' ? 'red' : '');?>">
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php echo $row['coupon_code'];?></td>
                      <td><?php echo ucfirst($row['coupon_type']);?></td>
                      
                      <td><?php
					   if($row['discount_type'] == 'percent')
					   {
					   echo $row['coupon_discount'].' %';
					   }else{
					   echo '$ '.$row['coupon_discount'];
					   }
					   
					   ?></td>
                      <td><?php echo $row['end_date'];?></td>
                       
                      <td><?php echo ucfirst($row['coupon_status']);?></td>
                      <td><a href="javascript:void(0)" class="btn default btn-xs purple" onclick="return view_faculty(<?php echo $row['coupon_id'];?>)"> <i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo base_url();?>coupon_con/coupon_edit/<?php echo $row['coupon_id'];?>" class="btn default btn-xs purple"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                      <?php if($row['coupon_status']!= 'Deleted'){ ?>
                      <a class="btn default btn-xs red" href="javascript:void(0)"  id="<?php echo $row['coupon_id'];?>" alt="Delete" title="Delete">
<i class="fa fa-trash-o del" id="<?php echo $row['coupon_id'];?>"></i>
</a><?php }?></td>
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
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/view_coupon.js"></script>
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
