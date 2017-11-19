      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      	
	    <?php echo $this->load->view('inc/message'); ?>

	      <?php if (file_exists(APPPATH.'views/'.$content.EXT)): ?>
	      	<?php echo $this->load->view($content); ?>
	      <?php else: ?>
	      	<?php echo $this->load->view('404'); ?>	      	      	
	      <?php endif ?>


      </div><!-- /.content-wrapper -->


