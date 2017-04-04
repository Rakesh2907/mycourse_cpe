<?php $this->load->view('layouts/admin_header'); ?>
<div class="page-container">
   <!-- BEGIN SIDEBAR -->
    	<?php $this->load->view('layouts/admin_sidebar'); ?> 
   <!-- END SIDEBAR MENU --> 
   <!-- BEGIN CONTENT --> 
   <div class="page-content-wrapper">
      <div class="page-content">  
        <?php $this->load->view('layouts/admin_subheader'); ?>    
		<?php echo $template['body']; ?>
      </div>
   </div>     
   <!-- END CONTENT --> 
   <!-- BEGIN QUICK SIDEBAR -->
        <?php $this->load->view('layouts/admin_quicksidebar'); ?> 
   <!-- END QUICK SIDEBAR -->  
</div> 
<?php $this->load->view('layouts/admin_footer'); ?> 