	
	<?php if ($this->session->flashdata('message.body')): ?>
	<?php 
		$message_type 	= ($this->session->flashdata('message.type')) 	? $this->session->flashdata('message.type') 	: 'info';
		$message_title 	= ($this->session->flashdata('message.title')) 	? $this->session->flashdata('message.title') 	: 'Info';
		$message_body 	= ($this->session->flashdata('message.body')) 	? $this->session->flashdata('message.body') 	: '';
	?>
		<div class="row">            
          <div class="col-xs-12">
            <div class="alert alert-<?php echo $message_type ?> alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong><i class="icon fa fa-info"></i><?php echo $message_title ?></strong> <?php echo $message_body ?>
            </div>
          </div>
        </div>
	<?php endif ?>