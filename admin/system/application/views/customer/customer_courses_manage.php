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
						<div class="portlet-body">
							<div class="tabbable-custom nav-justified">
								<ul class="nav nav-tabs nav-justified">
									<li class="active">
										<a href="#tab_1_1_1" data-toggle="tab">
										<b>Not Started</b> </a>
									</li>
									<li id="inprogess">
										<a href="#tab_1_1_2" data-toggle="tab">
										<b>In Progress</b> </a>
									</li>
									<li>
										<a href="#tab_1_1_3" data-toggle="tab">
										<b>Completed</b> </a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1_1_1">
										<table class="table table-striped table-bordered table-hover" id="sample_6">
                                          <thead>
                                            <tr>
                                              <th>Course Name </th>
                                              <th> Added Date </th>
                                              <th> Expiration Date </th>
                                              <th> Actions </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php 
                                                $count_notstared = count($course_notstared);
                                                if($count_notstared > 0)
                                                { 
                                                  foreach($course_notstared as $row )
                                                  {
                                            ?>
                                                    <tr class="odd gradeX">
                                                      <td><?php echo $row['course_name'];?></td>
                                                      <td><?php echo $row['added_date'];?></td>	  
                                                      <td><?php echo $row['expiry_date'];?> </td>
                                                      <td>
                                              <a class="btn default btn-xs red" href="javascript:void(0)"  alt="Delete" title="Make It Complete" /><i class="fa fa-book del" id="<?php echo $row['id'];?>"></i></a>
                                                      </td>
                                                    </tr>
                                            <?php
                                                 }
                                            }?>
                                         </tbody>
        								</table>
										
									</div>
									<div class="tab-pane" id="tab_1_1_2">
										
									    <table class="table table-striped table-bordered table-hover" id="sample_6">
                                          <thead>
                                            <tr>
                                              <th>Course Name </th>
                                              <th> Started Date </th>
                                              <th> Expiration Date </th>
                                              <th> Actions </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php 
                                                $count_progress = count($course_inprogress);
                                                if($count_progress > 0)
                                                { 
                                                  foreach($course_inprogress as $row1 )
                                                  {
                                                   
                                            ?>
                                                    <tr class="odd gradeX">
                                                      <td><?php echo $row1['course_name'];?></td>
                                                      <td><?php echo $row1['started_date'];?></td>	  
                                                      <td><?php echo $row1['expiry_date'];?> </td>
                                                      <td>
                                         <a class="btn default btn-xs red" href="javascript:void(0)"  alt="Delete" title="Make It Complete" /><i class="fa fa-book del1" id="<?php echo $row1['id'];?>"></i></a>
                                                      </td>
                                                    </tr>
                                            <?php
                                                 }
                                            }?>
                                         </tbody>
        								</table>
									</div>
									<div class="tab-pane" id="tab_1_1_3">
										<table class="table table-striped table-bordered table-hover" id="sample_6">
                                          <thead>
                                            <tr>
                                              <th>Course Name </th>
                                              <th> Completed Date </th>
                                              <th> Expiration Date </th>
                                             
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php 
                                                $count_completed = count($course_completed);
                                                if($count_completed > 0)
                                                { 
                                                  foreach($course_completed as $row2 )
                                                  {
                                                   
                                            ?>
                                                    <tr class="odd gradeX">
                                                      <td><?php echo $row2['course_name'];?></td>
                                                      <td><?php echo $row2['completed_date'];?></td>	  
                                                      <td><?php echo $row2['expiry_date'];?> </td>
                                                     
                                                    </tr>
                                            <?php
                                                 }
                                            }?>
                                         </tbody>
        								</table>
									</div>
								</div>
							</div>
						</div>
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/course_progres.js"></script>
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
				<button type="button" data-dismiss="modal" class="btn red" onclick="javascript:closePopup()" id="delt">Ok</button>
			</div>
		</div>
	</div>	
	</div>
</div>
<div class="modal fade" id="course_completed" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Course Complete Inprogress.</h4>
        </div>
        <div class="modal-body">
           <img id="course_loader" src="<?php echo $this->config->item("base_url_asset")?>assets/admin/layout/img/ajax-loading.gif" style="display:none;"/>
           <div id="completed_course" style="display:none;">
             Course completed successfully.
              <button type="button" class="btn default" id="yes">Close</button>
           </div>
        </div>
        
    </div>
   </div>
</div>
