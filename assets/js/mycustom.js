// JavaScript Document
function state_filter(element) 
{
  var value = $(element).val();
  $("#stateList li").each(function() {
    if ($(this).text().search(new RegExp(value, "i")) > -1) {
		//console.log(111);
		//$("#stshow").hide();
      $(this).show();
    } else {
		//console.log(222);
		
      //$(this).hide();
	  $("#stshow").show();
    }
  });
}

function credit_type(elm,param_courses)
{
	//alert(elm);
	var sel_state_id = $(elm).val();
	var courses = param_courses;
	var sel_state_abr = $('option:selected', elm).attr('id');
	$("#drop-down_state").val(sel_state_abr);
	 $.ajax({
			  url: base_url+'bundle_con/get_type_credits',
			  dataType: 'json',
			  type: 'POST',
			  data: {
        					stateid: sel_state_id,
							bundle_courses: courses,
    		  	}
			}).done(function(response) {
				$('#credit_types').html('');
				if(response['sucess'] =='True'){
					
					  	 $('#cr_inf').show();
						 $('#stae_credit_types').html();
							$('#credit_types').html(response['html']);
							$('#stae_credit_types').html(response['trackhtml']);
							$('#addcredit').html(response['addcredit']);
							
							if(response['creditcats'] != false)
							{
							 $('#creditcats').html('In '+response['creditcats']);
							}
							$('#ckstate').val(response['cust_state']);
							$('#statename').val(response['state_name']);
							$('#addcredit1').html(response['addcredit']);
							$('#creditcats1').html(response['creditcats']);
							
							
							 $('#cr_inf').hide();
							
				}else{
							$('#credit_types').html('<li>No credits are found</li>');
				}
		    });
	
	
}

$('document').ready(function(){	
    var state_id;
    var checked_state = new Array();
	var states = [];
	var search_bundle = '';
	var reset_search = 0;
    $('#stateList input[type=checkbox]').click(function () {
        if(this.checked){
           state_id = this.value;
		   checked_state.push(state_id);
		   $(".list-inline #state_line_item"+state_id).show();
        }else{
			  $(".list-inline #state_line_item"+this.value).hide();
			  if ((index = checked_state.indexOf(this.value)) !== -1) {
                    checked_state.splice(index, 1);
              }  
		}
		search_ajax(base_url,checked_state,search_bundle,reset_search);
    });
	
	$('#bundle_filter').keyup(function( event ) {
		 if($(this).val().length > 0){
			 search_bundle = $(this).val();
		 }else{
			 search_bundle = '';
		 }
		 search_ajax(base_url,checked_state,search_bundle,reset_search); 
	});
	
	$('#selected_state li').each(function() {
		$('#'+$(this).attr('id')+' .close_selected').click(function(){
			var removed_state_id = $(this).attr('data-close');
			if ((index = checked_state.indexOf(removed_state_id)) !== -1) 
			{
                    checked_state.splice(index, 1);
					$(this).parent().hide();
					$('#checkboxG'+removed_state_id).attr('checked', false);
					search_ajax(base_url,checked_state,search_bundle,reset_search);	 
            }
			
			
		});
	});
	
	$('#reset_filter, .reset_fl').click(function(){
		   checked_state = [];
		   search_bundle = '';
		  // reset_search = 1;
		   $('#stateList input:checkbox').removeAttr('checked');
		   $('#selected_state .state_list').hide();
		   search_ajax(base_url,checked_state,search_bundle);
		   //location.href=base_url+'compliance-bundles';
	});
	
	
	function search_ajax(base_url,checked_state,search_bundle)
	{
		   $("#loader").show();
		   $("#norecord").hide();
		   $.ajax({
			  url: base_url+'bundle_con/get_bundles',
			  dataType: 'html',
			  type: 'POST',
			  data: {
        					stateid: checked_state,
							searchbundle: search_bundle,
							reset_filter: reset_search
    		  	}
			}).done(function(response) {
				$("#loader").hide();
				$('.bund_Lst_sec').html('');
				if(response !='no'){
							$('.bund_Lst_sec').html(response);
				}else{
							$("#norecord").show();
				}
		    });
	}
	
	
});