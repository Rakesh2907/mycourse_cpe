// JavaScript Document
jQuery(document).ready(function() {
	jQuery('#save_credit').click(function(){
		var courseid = jQuery('#course_id').val();
		var credittype = jQuery('#credit_type').val();
		var stateid = jQuery('#state').val();
		var credits = jQuery('#credits').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(stateid == '')
		{
			alert('Please select states.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		else if(!$.isNumeric(credits))
		{
			alert('Please enter numeric credit.')
			return false;
		}
		var url = base_url+'course_con/add_credits'
		$.post(url,
		    {
				course_id:courseid,
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				action: 'add'
			},
			function(responseText){
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'course_con/manage_credits/'+courseid;
				}else{
					 alert(obj.message);
				}
				
		});
	});
	
	jQuery('#edit_credit').click(function(){
		var courseid = jQuery('#course_id').val();
		var credittype = jQuery('#credit_type').val();
		var stateid = jQuery('#state').val();
		var credits = jQuery('#credits').val();
		var creditsid = jQuery('#credit_id').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(stateid == '')
		{
			alert('Please select states.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		var url = base_url+'course_con/edit_credits'
		
		$.post(url,
		    {
				course_id:courseid,
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				credit_id:creditsid,
				action: 'edit'
			},
			function(responseText){
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'course_con/manage_credits/'+courseid;
				}else{
					 alert(obj.message);
				}
				
		});
		
		
		
	});
	
	jQuery('#save_state_credit').click(function(){
		var stateid = jQuery('#state_id').val();
	
		var credittype = jQuery('#credit_type').val();
		//var stateid = jQuery('#state').val();
		var credits = jQuery('#credits').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		$("#save_credit").hide();
		var url = base_url+'state_con/add_credits'
		$.post(url,
		    {
				
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				action: 'add'
			},
			function(responseText){
				
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'state_con/manage_credits/'+stateid;
				}else{
					 alert(obj.message);
					 $("#save_credit").show();
				}
				
		});
	});
	
	jQuery('#edit_state_credit').click(function(){
		
		var credittype = jQuery('#credit_type').val();
		
		var stateid = jQuery('#state_id').val();
		var credits = jQuery('#credits').val();
		var creditsid = jQuery('#credit_id').val();
		if(credittype == '')
		{
			alert('Please select credit type.');
			return false;
		}
		if(stateid == '')
		{
			alert('Please select states.');
			return false;
		}
		
		if(credits == '')
		{
			alert('Please enter credit.')
			return false;
		}
		var url = base_url+'state_con/edit_credits'
		
		$.post(url,
		    {
				
				state_id:stateid,
				credit_type:credittype,
				credits:credits,
				credit_id:creditsid,
				action: 'edit'
			},
			function(responseText){
				var obj = jQuery.parseJSON(responseText);
			    if(obj.length > 0)
				{
					location.href = base_url+'state_con/manage_credits/'+stateid;
				}else{
					 alert(obj.message);
				}
				
		});
		
		
		
	});
	
	
});

function edit_pdf(course_id,pdf_id)
{
	var url = base_url+'course_con/get_course_pdf';
	$.post(url,
	{
		course_id:course_id,
		pdf_id:pdf_id
	},
	function(responseText){
		 var obj = jQuery.parseJSON(responseText);
		  if(obj.length > 0)
		  {
			   for(var i = 0;i < obj.length;i++)
			   {
				   $("#course_pdf_name").val(obj[i].pdf_name);
				   $("#myform_pdf").attr('action',base_url+'course_con/edit_pdf_material');
				   $("#coursepdf #mysubmit").val('Edit');
				   $("#pdf_url a").attr('href',obj[i].s3_pdf);
				   $("#pdf_url a").html(obj[i].s3_pdf);
				   $("#pdf_id").val(obj[i].id);
				   $("#old_pdf").val(obj[i].s3_pdf);
				   $("#pdf_url").show();
				   $('#coursepdf').modal();
			   }
		  }else{
			  alert('No record found...!');
		  }
	    }
	);
}

function edit_video(course_id,video_id)
{
	var url = base_url+'course_con/get_course_video';
	
	$.post(url,
	{
		course_id:course_id,
		video_id:video_id
	},
	function(responseText){
		 var obj = jQuery.parseJSON(responseText);
		 if(obj.length > 0)
		 {
			  for(var i = 0;i < obj.length;i++)
			  {
				   $("#course_video_name").val(obj[i].video_name);
				   $("#video_url").val(obj[i].video_url);
				   $("#video_id").val(obj[i].id);
				   $("#myform_video").attr('action',base_url+'course_con/edit_video_material');
				   $("#coursevideo #mysubmit").val('Edit');
				   $('#coursevideo').modal();
			  }
		 }else{
			 alert('No record found...!');
		}
	}
	);
}
function delete_pdf(course_id,pdf_id)
{
	var url = base_url+'course_con/delete_pdf';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  pdf_id:pdf_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_material/'+course_id;
			  }
		  }
		 );  
	});
	
	$('#delete_record').modal();
}

function delete_video(course_id,video_id)
{
	var url = base_url+'course_con/delete_video';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  video_id:video_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_material/'+course_id;
			  }
		  }
		 );  
	});
	
	$('#delete_record').modal();
}
function delete_credits(course_id,credit_id)
{
	var url =  base_url+'course_con/delete_credits';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  credit_id:credit_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_credits/'+course_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_state_credits(state_id,credit_id)
{
	var url =  base_url+'state_con/delete_credits';
	
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  stateid:state_id,
			  creditid:credit_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'/state_con/manage_credits/'+state_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_questions(course_id,ques_id)
{
	 var url =  base_url+'course_con/delete_questions';
	 $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id,
			  ques_id:ques_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con/manage_course_quest/'+course_id;
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_customer(cust_id)
{
	 var url =  base_url+'customer_con/delete_customer';
	  $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  cust_id:cust_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'customer_con';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_courses(course_id)
{
	var url =  base_url+'course_con/delete_course';
	
	 $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  course_id:course_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'course_con';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_bundle(bundle_id)
{
	 var url =  base_url+'bundle_con/delete_bundle';
	 
	  $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  bundle_id:bundle_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'bundle_con/?did=1';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}

function delete_subcription(subcription_id)
{
	var url =  base_url+'subcription_con/delete_subcription';
	$('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  subcription_id:subcription_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'subcription_con';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function delete_landing_bundle(bundle_id)
{
	 var url =  base_url+'landing_con/delete_bundle';
	 
	  $('#delete_record #yes').click(function(){
		 $.post(url,
		  {
			  bundle_id:bundle_id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'landing_con';
			  }
		  }
		 );  
	});
	$('#delete_record').modal();
}
function make_course_complete(id)
{   
	 var url =  base_url+'customer_con/complete_course';
	 alert(id)
	 /* $('#course_complted #yes').click(function(){
		  alert(11)
		 $.post(url,
		  {
			  uid:id
		  },function(responseText){
			  if(responseText == 1){
				   location.href = base_url+'userorder_con';
			  }
		  }
		 );  
	});*/
	$('#course_complted').modal();
}

function dublicate_courses(course_id)
{
	$('#dublicate_record').modal();
	$("#dublicate_loader").show();
	var course_dublicate =  base_url+'course_con/course_dublicate';
	$.post(course_dublicate,
		  {
			  course_id:course_id
		  },function(responseTextCourseId){
			  if(responseTextCourseId > 0){
				  dublicate_course_credits(course_id,responseTextCourseId);
			  }else{
				  alert('Course clone creation failed...!');
			  }
		  }
		 );
	
}

function dublicate_course_credits(old_course_id,new_course_id)
{
	 var credit_dublicate = base_url+'course_con/credit_dublicate';
	 $.post(credit_dublicate,
		  {
			  old_course_id:old_course_id,
			  new_course_id:new_course_id  
		  },function(responseTextCredit){
			  if(responseTextCredit > 0){
				  dublicate_course_pdf(old_course_id,new_course_id);
			  }else{
				  dublicate_course_pdf(old_course_id,new_course_id);
				  alert('Credit records not found...! Please Enter manually.');
			  }
		  }
		 );
	 
}

function dublicate_course_pdf(old_course_id,new_course_id)
{
	var pdf_dublicate = base_url+'course_con/pdf_dublicate';
	$.post(pdf_dublicate,{
			 old_course_id:old_course_id,
			 new_course_id:new_course_id 
	},function(responseTextPdf){
		if(responseTextPdf > 0)
		{
			dublicate_course_video(old_course_id,new_course_id)
		}else{
			dublicate_course_video(old_course_id,new_course_id)
			alert('PDF records not found...! Please Enter manually.');
		}
	});
}

function dublicate_course_video(old_course_id,new_course_id)
{
	var video_dublicate = base_url+'course_con/video_dublicate';
	$.post(video_dublicate,{
			 old_course_id:old_course_id,
			 new_course_id:new_course_id 
	},function(responseTextVideo){
		if(responseTextVideo > 0)
		{
			dublicate_final_exam(old_course_id,new_course_id);
		}else{
			dublicate_final_exam(old_course_id,new_course_id);
			alert('Video records not found...! Please Enter manually.');
		}
	});
}

function dublicate_final_exam(old_course_id,new_course_id)
{
	 var final_exam_dublicate = base_url+'course_con/final_exam_dublicate';
	 $.post(final_exam_dublicate,{
		 	old_course_id:old_course_id,
			new_course_id:new_course_id 	
	 },function(responsiveExam){
		 if(responsiveExam > 0)
		 {
			 dublicate_chapter(old_course_id,new_course_id);
		 }else{
			 dublicate_chapter(old_course_id,new_course_id);
			 alert('Final exam records not found...! Please Enter manually.');
		 }
	 });
}

function dublicate_chapter(old_course_id,new_course_id)
{
	 var chapter_dupliacate = base_url+'course_con/chapter_dublicate';
	  $.post(chapter_dupliacate,{
		 	old_course_id:old_course_id,
			new_course_id:new_course_id 	
	 },function(responsiveChapter){
		 if(responsiveChapter > 0)
		 {
			 $("#dublicate_loader").hide(); 
			 $("#clone_completed").show();
			 $("#dublicate_record #yes").click(function(){
				 location.href = base_url+'course_con';
			 });
		 }else{
			 alert('Chapter records not found...! Please Enter manually.');
		 }
	 });
}