<div class="section-full bd-min-hgt open_Filter">
<div class="bd-pd-tp-16 mng-filter" style="height:auto;">
  <div id="filt_Cont" class="filter-sidebar">
    <div class="filter_inner">
      <div class="close-sec">Filters <span class="close icon-cross" onclick="toggler('filt_Cont');"></span></div>
      <div class="panel-group custom-panel" id="accordion">
        <div class="panel">
          <div class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> State <span class="glyphicon glyphicon-menu-down"></span> </a> </div>
          <div id="collapseOne" class="panel-collapse collapse in">
            <div class="search-sec">
              <button class="btn" type="submit"><span class="icon-search"></span></button>
              <input type="text" class="form-control" placeholder="Search States" onkeyup="state_filter(this)"/>
            </div>
            <div class="panel-body filter-max-ht cust-scroll">
              <ul class="list-unstyled" id="stateList">
                <?php foreach($states as $key => $stateval){?>
                <li>
                  <input type="checkbox" name="states[]" id="checkboxG<?php echo $stateval['state_id'];?>" class="css-checkbox" value="<?php echo $stateval['state_id'];?>" data-label="<?php echo trim($stateval['state']);?>"/>
                  <label for="checkboxG<?php echo $stateval['state_id'];?>" class="css-label"><?php echo trim($stateval['state']);?></label>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /filter_inner --> 
  </div>
  <!-- /filter-sidebar  -->
  
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-8 col-lg-8 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
        <div class="search-area">
          <div class="form-group text-center">
            <input type="text" class="form-control" placeholder="Search bundles" id="bundle_filter"/>
            <button class="btn" type="submit"><span class="icon-search"></span></button>
          </div>
        </div>
        <div class="filter-btn"><a href="#" class="btn fad-orange medium" onclick="toggler('filt_Cont');">Filter By State</a></div>
        <div class="filter-tags">
          <div class="filter-head">
             <strong class="pull-left">Selected States:</strong> <a href="javascript:void(0)" class="reset_fl pull-right">Reset All</a>
          </div>
          <ul class="list-inline list-unstyled" id="selected_state">
            <li class="select-flt-head"><strong>Selected <span class="f_fil">States</span><span class="f_state">states</span>:</strong></li>
            <?php foreach($states as $key => $stateval){?>
            <li class="state_list" id="state_line_item<?php echo $stateval['state_id'];?>" style="display:none"><span><?php echo trim($stateval['state']);?></span> <a class="close-tag close_selected" href="javascript:void(0)" id="" data-close="<?php echo $stateval['state_id'];?>"><img src="<?php echo $this->config->item("cdn_css_image")?>images/close-tag.png" alt="close" /></a></li>
            <?php } ?>
            <li class="reset-flt"><a href="javascript:void(0)" id="reset_filter">Reset All<!--<span>Filters</span>--></a></li>
          </ul>
        </div>
        <!-- /filter-tags -->
        <div class="bund_Lst_sec">
           <div id="loader" style="display:none; position:relative; left:40%; top:35%;"><img src="<?php echo $this->config->item("cdn_css_image")?>images/ajax-loader.gif" alt="close" /></div>
        </div>
        <!-- /bund_Lst_sec --> 
        <div id="norecord" class="col-md-8 col-md-offset-2" style="display:none;">
			<div class="not-found">
			<img src="<?php echo $this->config->item("cdn_css_image")?>images/not-found.png" alt="Not Found" width="50">
			<i>Sorry, no bundles were found with that combination of filters and search terms. Try a different search term, or reset your filters.</i>
			</div>
		</div>
      </div>
      <!-- /col --> 
      
    </div>
  </div>
  </div>
</div>
<script>
  $('document').ready(function(){
	  var sel_state_id = '<?php echo $selected_state_id;?>';
	  var checked_state = new Array();
	  if(sel_state_id!=''){
	  	checked_state.push(sel_state_id);
	  }
	     $("#loader").show();
		  $.ajax({
				  url: base_url+'bundle_con/get_bundles',
				  dataType: 'html',
				  type: 'POST',
				  data: {
						stateid: checked_state
				  }
			}).done(function(response) {
				 $("#loader").hide();
				 $('.bund_Lst_sec').html('');
				 $("#norecord").hide();
				if(response !='no'){
					if(sel_state_id!=''){
						$('#checkboxG'+sel_state_id).trigger('click');
					}
					$('.bund_Lst_sec').html(response);
				}else{
					if(sel_state_id!=''){
						$('#checkboxG'+sel_state_id).trigger('click');
					}
					$("#norecord").show();
				}
		   });
	  
  });
</script>