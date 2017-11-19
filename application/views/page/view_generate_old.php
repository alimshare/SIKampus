<?php 
  function get_hari($id){
    
    switch ($id) {
      case '0':
        $hari = "Senin";
        break;
      case '1':
        $hari = "Selasa";
        break;
      case '2':
        $hari = "Rabu";
        break;
      case '3':
        $hari = "Kamis";
        break;
      case '4':
        $hari = "Jum'at";
        break;
      
      default:
        $hari = "";
        break;
    }

    return $hari;
  }
 ?>
<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>STMIK Mahakarya</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Jadwal</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <form action="<?php echo base_url('proses/simpan_jadwal'); ?>" method="post">
          
              <!-- Custom Tabs (Pulled to the right) -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                  <li class="active"><a href="#tab_2-2" data-toggle="tab">Hasil Generate</a></li>
                  <li class="pull-left header"><i class="fa fa-th"></i> Jadwal</li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_2-2">
                    <?php #echo "<pre>";print_r($fitness);echo "</pre>"; ?>
                  
                    <div class="row">
                      <div class="col-md-12">
                        <p>
                          <h5>Waktu Proses <strong><?php echo number_format($time,3); ?> detik <strong></h5>
                          <h5><strong><?php echo $bentrok; ?> Jadwal Tidak sesuai <strong></h5>
                          <h5><strong>Generasi ke-<?php echo $cursor_iterasi; ?><strong></h5>
                          <h5>Fitness <?php echo round($fitness,3); ?></h5>
                          <!--<h5><strong>Rata-rata Fitness Populasi <?php echo round($avg_populasi,3); ?><strong></h5>-->
                          <br>
                        </p>
                        <div>
                          <a href="<?php echo base_url('myalgen/regenerate')."/".$id_tahun_ajaran; ?>" name="generate_ulang" class="pull-right btn btn-app btn-flat bg-green">
                            <i class="fa fa-refresh"></i> Generate Ulang 
                          </a>
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
                      </div>
                    </div>

                    <input type="hidden" name="countHari" value="<?php echo count($data_hari) ?>">
                    <input type="hidden" name="countSesi" value="<?php echo count($data_sesi) ?>">
                    <input type="hidden" name="countRuang" value="<?php echo count($data_ruang) ?>">

                    <div class="row">
                      <div class="col-md-12">     

                          <?php foreach ($data_hari as $k_hari => $hari): ?>
                            <table border="1" class="table table-bordered text-center">
                              <caption><h2><?php echo $hari['nama_hari']; ?></h2></caption>
                              <?php foreach ($data_sesi as $k_sesi => $sesi): ?>
                                <tr>
                                  <td width="10%"><?php echo substr($sesi['jam_awal'],0,5) . " - " . substr($sesi['jam_akhir'],0,5); ?></td>
                                  <?php foreach ($data_ruang as $k_ruang => $ruang): ?>
                                    <?php $data = $jadwal[($hari['id_hari']-1)][($sesi['id_sesi']-1)][($ruang['id_ruang']-1)]; ?>

                                    <td width="10%" style="<?php echo ($data['status']>0) ? 'color:red' : ''; ?>;vertical-align:middle;">
                                      <input type="hidden" name="jadwal[]" value="<?php echo ($data['id_ajar']); #($hari['id_hari'])."|".($sesi['id_sesi'])."|".($ruang['id_ruang'])."|".($data['id_ajar']); ?>">
                                      <?php echo $data['nama_mata_kuliah']; ?><br>
                                      <?php echo $data['kelp']; ?><br>
                                      <?php echo $data['nama_dosen']; ?>
                                    </td>
                                  
                                  <?php endforeach ?>
                                </tr>
                              <?php endforeach ?>
                            </table>
                          <?php endforeach ?>
                        
                      </div>
                    </div>
                    
                    <!--<div class="row">
                      <div class="col-md-12">     
                          <?php foreach ($jadwal as $k1 => $hari): ?>
                            <table class="table table-bordered table-condensed text-center">
                            <caption><h3><?php echo get_hari($k1); ?></h3></caption>
                            <thead>
                              <tr>
                                <th></th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>E</th>
                                <th>F</th>
                                <th>G</th>
                              </tr>  
                            </thead>
                            
                            <?php foreach ($hari as $k2 => $sesi): ?>

                                <tr>
                                  <td width="8%" style="vertical-align:middle"><?php echo substr($sesi_waktu[$k2]['jam_awal'],0,5) . " - " . substr($sesi_waktu[$k2]['jam_akhir'],0,5); ?></td>
                                  <?php foreach ($sesi as $k3 => $data): ?>
                                    <td width="10%" style="<?php echo ($data['status']==1) ? 'color:red' : ''; ?>;vertical-align:middle">
                                      <input type="hidden" value="<?php echo $data['id_ajar']; ?>" name='id_ajar'>
                                      <?php echo $data['nama_mata_kuliah']; ?><br>
                                      <?php echo (strlen($data['kelp']) == 2)? $data['kelp'] : '-'; ?><br>
                                      <?php echo $data['nama_dosen']; ?>
                                    </td>
                                  <?php endforeach ?>
                                </tr>
                                 
                            <?php endforeach ?>
                            </table>
                            <br>
                          <?php endforeach ?>
                        
                      </div>
                    </div>-->

                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

          </form>
        </section><!-- /.content -->