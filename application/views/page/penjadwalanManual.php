
	    <!--<link rel="stylesheet" href="<?php echo base_url()."assets/"; ?>redips_drag/style.css" type="text/css" media="screen">-->
		<!--<script type="text/javascript" src="<?php echo base_url()."assets/"; ?>redips_drag/header.js"></script>-->
		<script type="text/javascript" src="<?php echo base_url()."assets/"; ?>redips_drag/redips-drag-min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()."assets/"; ?>redips_drag/script.js"></script>	

		<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Jadwal Manual
            <small>STMIK Mahakarya</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Jadwal</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

        <form action="<?php echo base_url('proses/simpan_jadwalManual'); ?>" method="post">
          
              <!-- Custom Tabs (Pulled to the right) -->
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs pull-right">
			  <li class="pull-left header"><i class="fa fa-th"></i> Jadwal</li>
			</ul>
			<div class="tab-content">


				<div class="tab-pane active table-responsive" id="redips-drag">         

					<?php if ($this->session->flashdata('message')): ?>
						<div class="row"> 
                      		<div class="col-md-12">
								<div class="alert alert-warning alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php 
									echo $this->session->flashdata('message');
									?>
								</div>    
							</div>        
						</div>            
					<?php endif ?>

                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <?php if ($jadwalTersedia == false): ?>
                            <button type="submit" class="pull-right btn btn-app btn-flat bg-blue">
                              <i class="fa fa-save"></i> Simpan
                            </button>
                          <?php else: ?>      
							<div class="alert alert-warning">
								Data Jadwal Sudah dibuat . Silahkan Hubungi Pihak Pengajaran untuk perubahan Jadwal.
							</div>               
                          <?php endif ?>
                        </div>
                        <div>
							<blockquote>
								<p>Lakukan Drag & Drop Pada Jadwal untuk merubah posisi</p>
							</blockquote>
                        </div>
                      </div>
                    </div>

                    <input type="hidden" name="countHari" value="<?php echo count($data_hari) ?>">
                    <input type="hidden" name="countSesi" value="<?php echo count($data_sesi) ?>">
                    <input type="hidden" name="countRuang" value="<?php echo count($data_ruang) ?>">

					<?php foreach ($data_hari as $k_hari => $hari): ?>
						<table border="1" id="table<?php echo $hari['id_hari']; ?>" class="table table-bordered text-center text-xs">
						  <caption><h2><?php echo $hari['nama_hari']; ?></h2></caption>
						  <?php foreach ($data_sesi as $k_sesi => $sesi): ?>
						    <tr>
						      <td width="10%" class="redips-mark"><?php echo substr($sesi['jam_awal'],0,5) . " - " . substr($sesi['jam_akhir'],0,5); ?></td>
						      <?php foreach ($data_ruang as $k_ruang => $ruang): ?>

						        <td width="10%" style="vertical-align:middle;" id="td<?php echo $hari['id_hari'].$sesi['id_sesi'].$ruang['id_ruang'] ?>">						        	
                                    <?php $data = $jadwal[($hari['id_hari']-1)][($sesi['id_sesi']-1)][($ruang['id_ruang']-1)]; ?>
						        	<div id="d<?php echo ($data['id_ajar']); ?>" class="redips-drag t<?php echo $hari['id_hari']; ?>" style="border:0px solid white;width:125px">
										<input type="hidden" name="jadwal[]" value="<?php echo ($data['id_ajar']); ?>">
										<?php echo $data['nama_mata_kuliah']; ?><br>
										<?php echo $data['kelp']; ?><br>
										<?php echo $data['nama_dosen']; ?>
						        	</div>
						        </td>
						      
						      <?php endforeach ?>
						    </tr>
						  <?php endforeach ?>
						</table>
					<?php endforeach ?>

				</div><!-- /.tab-pane -->

			</div><!-- /.tab-content -->
		</div><!-- nav-tabs-custom -->

		</form>

        </section><!-- /.content -->