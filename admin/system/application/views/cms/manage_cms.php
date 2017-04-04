<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i>CMS Pages</div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>	
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <a href="<?php echo base_url();?>cms_con/add_cms_pages/"><button id="sample_editable_1_new" class="btn green"> Add Page <i class="fa fa-plus"></i> </button></a>
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
        <table class="table table-striped table-bordered table-hover" id="sample_4">
          <thead>
            <tr>
            <!--<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
              </th>-->
              <th width="70%"> Chapter Name</th>
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
                    <tr class="odd gradeX" style="color:<?php echo ($row['page_status'] == 'Deleted' ? 'red' : '');?>">
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php echo $row['page_title'];?></td>
                      <td><?php echo $row['page_status'];?></td>
                      <td><a href="javascript:void(0)" class="btn default btn-xs purple" title="View" alt="View" onclick="return view_chapter(<?php echo $row['page_id'];?>)"> <i class="fa fa-eye"></i></a>
                      <a title="Edit" alt="Edit"  href="<?php echo base_url();?>cms_con/page_edit/<?php echo $row['page_id'];?>" class="btn default btn-xs purple"> <i class="fa fa-edit"></i></a>
                      <?php if($row['page_status']!='Deleted'){ ?>
                     <a class="btn default btn-xs red" href="javascript:void(0)" title="Delete" alt="Delete"   id="<?php echo $row['page_id'];?>" alt="Delete" title="Delete">
<i class="fa fa-trash-o del" id="<?php echo $row['page_id'];?>"></i>
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
