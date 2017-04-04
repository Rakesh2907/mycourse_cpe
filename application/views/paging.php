<?php
$config['first_link'] 	= 'First';
$config['div'] 		= 'container'; //Div tag id
$config['base_url'] 	= base_url().'paging/'.$ajax_function;
$config['total_rows']	= $TotalRec;
$config['per_page'] 	= $PerPage;
$config['postVar'] 	= 'page';
 
$this->ajax_pagination->initialize($config);
echo $this->ajax_pagination->create_links();