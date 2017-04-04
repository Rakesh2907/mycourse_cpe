
<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i><?php echo isset($chapter_questions[0]['chapter_name']) ? $chapter_questions[0]['chapter_name'] : "";?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <a href="<?php echo base_url();?>course_con/add_chapter_question/<?php echo $chapterid; ?>/<?php echo $courseid;?>"/><button id="sample_editable_1_new" class="btn green"> Add Chapter Question <i class="fa fa-plus"></i> </button></a>
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
        <div class="alert alert-success" style="display:none;" id="delmsg">
        <span>Record deleted succesfully</span>
        </div>
          <input type="hidden" name="chapterid" id="chapterid" value="<?php echo $chapterid;?>" />
          <input type="hidden" name="course_id" id="course_id" value="<?php echo $courseid;?>" />
        <table class="table table-striped table-bordered table-hover" id="sample_4">
          <thead>
            <tr>
            <!--  <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
              </th>-->
              <th width="70%"> Question Title </th>
              <th width="10%"> Status </th>
              <th width="20%"> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			   
				$count_chapter_questions = count($chapter_questions);
				if($count_chapter_questions > 0)
				{ 
				  foreach($chapter_questions as $row )
				  {
			?>
                    <tr class="odd gradeX" style="color:<?php echo ($row['rev_ques_status'] == 'Deleted' ? 'red' : '');?>">
                      <!--<td><input type="checkbox" class="checkboxes" value="1"/></td>-->
                      <td><?php
					    $qtitle = stripslashes($row['rev_ques_title']);
					  	if(strlen($qtitle) > 120)
						{
						$pos = strpos($qtitle,' ',120);
						if($pos)
							$qtitle=substr($qtitle, 0, $pos).'......';	
						}
					   echo $qtitle;
					   
					   ?></td>
                      <td><?php echo $row['rev_ques_status'];?></td>
                      <td><a href="javascript:void(0)" class="btn default btn-xs purple" onclick="return view_chapter_quest(<?php echo $row['rev_ques_id'];?>)"> <i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a href="<?php echo base_url();?>course_con/edit_review_question/<?php echo $row['rev_ques_id'];?>/<?php echo $chapterid;?>/<?php echo $courseid;?>" class="btn default btn-xs purple"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)"  id="<?php echo $row['rev_ques_id'];?>" alt="Delete" title="Delete">
<i class="fa fa-trash-o del" id="<?php echo $row['rev_ques_id'];?>"></i>
</a></td>
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
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/view_chapter_quest.js"></script>
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
