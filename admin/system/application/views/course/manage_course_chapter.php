<?php 
$del_msg = $_REQUEST['delete'];

?>
<link href="<?php echo $this->config->item("global_url")?>plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $this->config->item("global_url")?>plugins/jquery-nestable/jquery.nestable.js"></script>

<div class="row">
  <div class="col-md-12"> 
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet box grey-cascade">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-globe"></i><?php echo isset($course_chapter[0]['course_name']) ? $course_chapter[0]['course_name'] : "";?></div>
        <div class="tools"> <a href="javascript:;" class="collapse"> </a></div>
      </div>
      <div class="portlet-body">

        <div class="table-toolbar">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group">
                <a href="<?php echo base_url();?>course_con/add_course_chapter/<?php echo $courseid;?>"><button id="sample_editable_1_new" class="btn green"> Add Chapter <i class="fa fa-plus"></i> </button></a>
              </div>
            </div>
          </div>
        </div>
       <?php if(isset($suc_msg) && $suc_msg!=''){ ?> 
         <div class="alert alert-success">
          <?php echo $suc_msg;?>
        </div>
        <?php } ?>
        <?php if($del_msg == 1){?>
        <div class="alert alert-success" id="delmsg">
        <span>Record deleted succesfully</span>
        </div>
        <?php }?>
          <input type="hidden" name="course_id" id="course_id" value="<?php echo $courseid;?>" />
          
          <div>
				<table class="table table-striped table-bordered table-hover" id="sample_4">
                 <thead>
                  <tr>
                    <th class="table-checkbox sorting">Chapter id</th>
                    <th class="sorting">Chapter name</th>
                    <th class="sorting_disabled">Status</th>
                    <th class="sorting_disabled">Actions</th>
                  </tr>		
                 </thead> 		 	
												<?php 
													$count_course_chapter = count($course_chapter);
			    ?>
                <tbody>
                <?php										
				if($count_course_chapter > 0)
				{
				  $id = 1; 
				  foreach($course_chapter as $row )
				  { 							
				?>
                   <tr id="<?php echo $row['chapter_id']; ?>" class="odd gradeX">                             
					<td><?php echo $row['chapter_id']; ?></td>
					<td><?php echo $row['chapter_name'];?></td> 		
					<td><?php echo $row['status'];?></td>		
					<td><a href="javascript:void(0)" class="btn default btn-xs purple" onclick="return view_chapter(<?php echo $row['chapter_id'];?>)"> <i class="fa fa-eye"></i></a>&nbsp;&nbsp;<a  href="<?php echo base_url();?>course_con/edit_chapter/<?php echo $row['chapter_id'];?>/<?php echo $courseid;?>" target="_blank" class="btn default btn-xs purple"> <i class="fa fa-edit"></i></a>&nbsp;&nbsp;<a class="btn default btn-xs red" href="javascript:void(0)"  id="<?php echo $row['chapter_id'];?>" alt="Delete" title="Delete" onclick="return delete_chapter(<?php echo $row['chapter_id'];?>,<?php echo $courseid;?>)">
<i class="fa fa-trash-o del" id="<?php echo $row['chapter_id'];?>"></i>
</a>&nbsp;&nbsp;<a class="" href="<?php echo base_url();?>course_con/manage_chapter_question/<?php echo $row['chapter_id'];?>/<?php echo $courseid;?>" alt="Question" title="Question">
<i class="fa icon-question"></i>
</a>
												 </td>	
                                                </tr>
				<?php 
				  $id++; 
												} } 
				?>
                                                 </tbody>
											</table>	
                                            <br />
                                            
											<div class="form-group">
											<form name="order_form" id="order_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal" role="form" >
												<input type="hidden" name="order[]" id="order" value="" />
												<!--<input type="submit" value="Update Order" class="btn green" />-->
											</form>
											</div>
											
										</div></div>
									</div>
        
      </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET--> 
  </div>
</div>
<script src="<?php echo $this->config->item("base_url_asset")?>assets/admin/pages/scripts/view_chapter.js"></script>
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
<script>
    jQuery(document).ready(function() {    
	 // UINestable.init();
	 var output = $('#order');
	  $('tbody').sortable({
		   update: function( event, ui ) {
			 //alert($(this).sortable('toArray'));
			  output.val(window.JSON.stringify($(this).sortable('toArray'))); //, null, 2));
			  var order = $("#order").val();
			  if(order !='')
			  {
			    $.ajax({
					url: SITE_URL+"course_con/chapter_order/", 
					dataType: 'html',
                 	type: 'POST',
                  	data: {order:order}
				});		
			  }
  		   }
	  }).disableSelection();
    });

function delete_chapter(id,courseid)
{
	
	  var qid=id;
			  
                bootbox.confirm("Are you sure?", function(result) {
					
					if(result == true)
					{
				   	$.ajax({
				url: SITE_URL+"course_con/delete_chapter/"+qid, 
				async:false,
				success: function(result){
					
					window.location.href=SITE_URL+"course_con/manage_course_chapter/"+courseid+'/?delete=1';
					
				}
			});	
					}
                }); 
	
}	
    
</script>
