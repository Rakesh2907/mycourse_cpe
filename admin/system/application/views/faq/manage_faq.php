<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>FAQ</div>
        <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <a href="<?php echo base_url();?>faq_con/add_faq/"><button id="sample_editable_1_new" class="btn green"> Add FAQ <i class="fa fa-plus"></i> </button></a>
              </div>
            </div>
          </div>
        </div>
       <?php 
	  if(isset($suc_msg) && $suc_msg!=''){ ?> 
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
              <th width="60%"> Question</th>
               <th width="10%"> FAQ type </th>
              <th width="10%"> Status </th>
              <th width="20%"> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			
				$count_cms_pages = count($cms_pages);
				if($count_cms_pages > 0)
				{ 
				  foreach($cms_pages as $row )
				  {
			?>
                    <tr class="odd gradeX" style="color:<?php echo ($row['faq_status'] == 'Deleted' ? 'red' : '');?>" >
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php echo $row['question'];?></td>
                       <td><?php echo $row['faq_type'];?></td>
                      <td><?php echo $row['faq_status'];?></td>
                      <td><a href="javascript:void(0)" class="btn default btn-xs purple" onclick="return view_faq(<?php echo $row['id'];?>)" title="View" alt="View"> <i class="fa fa-eye"></i></a>
                      <a href="<?php echo base_url();?>faq_con/faq_edit/<?php echo $row['id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"> <i class="fa fa-edit"></i></a>
                      <?php if($row['faq_status']!='Deleted'){ ?>
                      <a class="btn default btn-xs red" href="javascript:void(0)" id="<?php echo $row['id'];?>" alt="Delete" title="Delete">
<i class="fa fa-trash-o del_faq" id="<?php echo $row['id'];?>"></i>
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
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/view_cms.js"></script>
<div id="ajax1">
	<div id="appts_popup_faq" class="modal fade" tabindex="-1" data-width="400">
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
