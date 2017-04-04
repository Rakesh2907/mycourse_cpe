<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
    <div class="portlet box green">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-gift"></i><?php echo $course_details[0]['course_name'];?></div>
        <div class="tools"><a href="javascript:;" class="collapse"></a></div>
      </div>
      <div class="portlet-body">
        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-6">
              <div class="btn-group"> <a href="#coursepdf" data-toggle="modal">
                <button id="sample_editable_1_new" class="btn green"> Add PDF <i class="fa fa-plus"></i> </button>
                </a> </div>
              <div class="btn-group"> <a href="#coursevideo" data-toggle="modal">
                <button id="sample_editable_1_new" class="btn green"> Add Video <i class="fa fa-plus"></i> </button>
                </a> </div>
            </div>
          </div>
        </div>
         <?php if(isset($suc_msg) && $suc_msg!=''){ ?> 
             <div class="alert alert-success">
              <?php echo $suc_msg;?>
            </div>
        <?php } ?>
        <?php if(isset($err_msg) && $err_msg!=''){ ?> 
             <div class="alert alert-danger">
              <?php echo $err_msg;?>
            </div>
        <?php } ?>
        <div class="row">
          <div class="col-md-6"> 
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
              <div class="portlet-title">
                <div class="caption">PDF</div>
                <div class="tools"> <a href="javascript:;" class="collapse"></a></div>
              </div>
              <div class="portlet-body">
                <div class="table-scrollable">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th> PDF Name </th>
                        <th> Actions </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
						    if(count($course_pdf_details) > 0)
							{
						      foreach($course_pdf_details as $rows)
							  {
					  ?>
                      <tr>
                        <td><?php echo $rows['id'];?></td>
                        <td><?php echo $rows['pdf_name'];?></td>
                        <td><a href="javascript:void(0);" class="btn default btn-xs purple" title="Edit" alt="Edit" onClick="edit_pdf(<?php echo $rows['course_id'];?>,<?php echo $rows['id'];?>)"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_pdf(<?php echo $rows['course_id'];?>,<?php echo $rows['id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a></td>
                      </tr>
                      <?php
							 }
					      }else{
						    echo '<tr><td colspan="3">No record found...!</td></tr>';
					        }
					  ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET--> 
          </div>
          <div class="col-md-6"> 
            <!-- BEGIN CONDENSED TABLE PORTLET-->
            <div class="portlet box grey-cascade">
              <div class="portlet-title">
                <div class="caption">Videos</div>
                <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
              </div>
              <div class="portlet-body">
                <div class="table-scrollable">
                  <table class="table table-condensed table-hover">
                    <thead>
                      <tr>
                        <th> # </th>
                        <th> Video Name </th>
                        <th> Video URL </th>
                        <th> Actions </th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php 
					       if(count($course_video_details) > 0){ 
						    foreach($course_video_details as $myrows)
							{
					   ?>
                      <tr>
                        <td> <?php echo $myrows['id'];?> </td>
                        <td> <?php echo $myrows['video_name'];?> </td>
                        <td> <?php echo $myrows['video_url'];?> </td>
                        <td> <a href="javascript:void(0);" class="btn default btn-xs purple" title="Edit" alt="Edit" onClick="edit_video(<?php echo $myrows['course_id'];?>,<?php echo $myrows['id'];?>)"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)" onclick="delete_video(<?php echo $myrows['course_id'];?>,<?php echo $myrows['id'];?>)" alt="Delete" title="Delete"/><i class="fa fa-trash-o"></i></a> </td>
                      </tr>
                       <?php
							}
					   }else{
						   	 echo '<tr><td colspan="3">No record found...!</td></tr>';
					   } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- END CONDENSED TABLE PORTLET--> 
          </div>
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
  
<div class="modal fade" id="coursepdf" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php $attributes = array('class' => 'horizontal-form', 'id' => 'myform_pdf');
			echo form_open_multipart('course_con/add_pdf_material',$attributes);
	 ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $course_details[0]['course_name'];?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="course_id" value="<?php echo $course_details[0]['course_id'];?>" />
        <input type="hidden" name="pdf_id" value="" id="pdf_id"/>
        <input type="hidden" name="old_pdf" value="" id="old_pdf"/>
        <?php 
			  $course_pdf_name = set_value('course_pdf_name');				  
			  $data_coursepdf = array(
						  		 'name'         => 'course_pdf_name',
								  'id'          => 'course_pdf_name',
								  'value'       => $course_pdf_name,
								  'class'		=> 'form-control',
								  'required'  => 'required',
								  'placeholder' => 'PDF Name'
								 );
		     ?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Pdf Name<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_coursepdf); ?> </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">PDF<span class="required" aria-required="true"> *</span></label>
                <input type="file" name="course_pdf" id="course_pdf"/>
                <div id="pdf_url" style="display:none"><a href="" target="_blank" style="word-wrap:break-word;"></a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn green" value="Add" name="submit" id="mysubmit"/>
      </div>
    </div>
    <?php	
			echo form_fieldset_close(); 
			echo form_close();
     ?>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<div class="modal fade" id="coursevideo" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php $attributes = array('class' => 'horizontal-form', 'id' => 'myform_video');
			echo form_open('course_con/add_video_material',$attributes);
	    ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $course_details[0]['course_name'];?></h4>
      </div>
      <div class="modal-body">
       <input type="hidden" name="course_id" value="<?php echo $course_details[0]['course_id'];?>" />
        <input type="hidden" name="video_id" value="" id="video_id"/>
          <?php 
			  $course_video_name = set_value('course_video_name');				  
			  $data_coursevideo = array(
						  		 'name'         => 'course_video_name',
								  'id'          => 'course_video_name',
								  'value'       => $course_video_name,
								  'class'		=> 'form-control',
								  'required'  => 'required',
								  'placeholder' => 'Video Name'
								 );
		     ?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Video Name<span class="required" aria-required="true"> *</span></label>
                <?php echo form_input($data_coursevideo); ?> </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
               <label class="control-label">Video URL<span class="required" aria-required="true"> *</span></label>
               <input type="url" required="required" class="form-control" placeholder="Video URL" rows="2" cols="30" name="video_url" id="video_url">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn green" value="Add" name="submit" id="mysubmit"/>
      </div>
      <?php	
			echo form_fieldset_close(); 
			echo form_close();
     ?>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<!-- END PAGE CONTENT--> 