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
                <a href="<?php echo base_url();?>course_con/add_course"><button id="sample_editable_1_new" class="btn green"> Add Course <i class="fa fa-plus"></i> </button></a>
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
              <th style="width:30%"> Course Name </th>
              <th style="width:15%"> Price </th>
              <th style="width:23%"> Author </th>
              <th style="width:12%"> Status </th>
              <th style="width:20%"> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
				$count_course = count($course_details);
				if($count_course > 0)
				{ 
				  foreach($course_details as $row)
				  {
					  
								if(isset($row['course_author']))
								{
									$course_faculties = $this->course_mod->get_course_faculties($row['course_author']);	
									if(count($course_faculties) > 0){
										$param = array();
										foreach($course_faculties as $myrows){
											$param[] = $myrows['first_name'].' '.$myrows['last_name'];
										}
									}									
								}
							
			?>
                    <tr class="odd gradeX">
                      <td><input type="checkbox" class="checkboxes" value="1"/></td>
                      <td><?php echo $row['course_name'];?></td>
                      <td><?php echo $row['course_price'];?></td>
                      <td>
					   <?php 
					    if(is_array($param)){
						  echo $authors = wordwrap(implode(',',$param),35,"<br>\n",'1');    
						}
					   ?>
                       </td>
                      <td><?php echo $row['course_status'];?></td>
                      <td>
                        <a href="<?php echo base_url();?>course_con/edit_course/<?php echo $row['course_id'];?>" class="btn default btn-xs purple" title="Edit" alt="Edit"><i class="fa fa-edit"></i></a>
                        <a href="course_con/manage_credits/<?php echo $row['course_id'];?>" alt="Add Credits" title="Add Credits" class="btn default btn-xs purple"><i class="fa fa-trophy"></i></a>
                        <a href="course_con/manage_material/<?php echo $row['course_id'];?>" alt="Add Material" title="Add Material" class="btn default btn-xs purple"><i class="fa fa-file-movie-o"></i></a>
                        <a href="course_con/manage_course_chapter/<?php echo $row['course_id'];?>" alt="Add Chapter" title="Add Chapter" class="btn default btn-xs purple"><i class="fa fa-book"></i></a>
                        <a href="<?php echo base_url();?>course_con/manage_course_quest/<?php echo $row['course_id'];?>" alt="Add Questions" title="Add Questions" class="btn default btn-xs purple"><i class="icon-question"></i></a>
                        <a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_courses(<?php echo $row['course_id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a>
                         <a class="btn default btn-xs green" href="javascript:void(0)" onclick="dublicate_courses(<?php echo $row['course_id'];?>)" alt="Duplicate" title="Duplicate"/><i class="icon-docs"></i></a>
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
<div class="modal fade" id="dublicate_record" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Clone</h4>
        </div>
        <div class="modal-body">
           <img id="dublicate_loader" src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/img/ajax-loading.gif" style="display:none;"/>
           <div id="clone_completed" style="display:none;">
             Course cloned successfully.
              <button type="button" class="btn default" id="yes">Close</button>
           </div>
        </div>
        
    </div>
   </div>
</div>
