// JavaScript Document
function add_to_cart(itemid,type,flag)
{
		var url = base_url+'cart_con/add_to_cart';
		var state_abr = $("#drop-down_state").val();
		$(".add-cart").hide();
		$.post(url,{cuser_id : current_user_id,item_id:itemid,item_type:type,state_abr:state_abr},
				   function(responseText)
				   {
					    $(".mycount").html('');
						$(".mycount").html('CART ('+responseText+')');
						$(".cart-number").html(responseText);
						if(flag == 'true'){
							 $('.add').hide();
				   			 $('.remove').show();
						}
											
						if(type == 'bundle')
						{  
							$('#show_message').html('Bundle added successfully to your cart.<br /><a class="btn fad-orange medium" style="margin: 30px auto 0;display: block;width: 50%;" href="/index.php/cart">View Cart</div>');
				  
						}else if(type == 'landing')
						{  
							$('#show_message').html('Bundle added successfully to your cart.<br /><a class="btn fad-orange medium" style="margin: 30px auto 0;display: block;width: 50%;" href="/index.php/cart">View Cart</div>');
				  
						}
						else if(type == 'course'){
							
							$('#show_message').html('Course added successfully to your cart.<br /><a class="btn fad-orange medium" style="margin: 30px auto 0;display: block;width: 50%;" href="/index.php/cart">View Cart</div>');
						}
						else if(type == 'subscription'){
							$('#show_message').html('Subscription added successfully to your cart.<br /><a class="btn fad-orange medium" style="margin: 30px auto 0;display: block;width: 50%;" href="/index.php/cart">View Cart</div>');
						}
						$('#added_to_cart').modal('show');
				   });
}

function remove_item(type,order_id,course_id,flag)
{
	 /*var contirm = confirm("Are you sure want to delete?");
	
	   if(contirm == true)
	   {*/
		   var url = base_url+'cart_con/remove_from_cart';
		   $(".add-cart").hide();
		   $.post(url,{item_type:type,orderid:order_id,courseid:course_id},
		   function(responseText){
			   if(flag == 'true'){
				   $('.add').show();
				   $('.remove').hide();
				   $(".mycount").html('');
				   $(".mycount").html('CART ('+responseText+')');
				   $(".cart-number").html(responseText);
				   $('#show_message').html('Removed Item successfully from your cart');
				   $('#added_to_cart').modal('show');				   
			   }else{
				 location.reload();
			   }
		   });
	   /*}else{
		   return false;
	   }*/
	  	   
}

function add_to_mycourse(itemid,type,flag,order_id)
{
	 	var url = base_url+'course_con/add_to_mycourse';
		var state_abr = $("#drop-down_state").val();
		$.post(url,{cuser_id : current_user_id,item_id:itemid,item_type:type,state_abr:state_abr,order_id:order_id},
			function(responseText){
				if(flag == 'true'){
					$("#mycourse_link").removeAttr('onclick');
					$("#mycourse_link").attr('href',base_url+'mycourses');
					$("#mycourse_link").text('View My Course');
				}
		});
}