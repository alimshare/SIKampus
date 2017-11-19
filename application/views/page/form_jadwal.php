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

          
              <!-- Custom Tabs (Pulled to the right) -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                  <li class="<?php echo (count($jadwal) > 0)? 'active' : '' ?>"><a href="#tab_1-1" data-toggle="tab">Jadwal Perkuliahan</a></li>
                  <li class="<?php echo (count($jadwal) == 0)? 'active' : '' ?>"><a href="#tab_2-2" data-toggle="tab">Generate Jadwal</a></li>
                  <li class="pull-left header"><i class="fa fa-th"></i> Jadwal</li>
                </ul>
                <div class="tab-content">


                  <div class="tab-pane <?php echo (count($jadwal) > 0)? 'active' : '' ?>" id="tab_1-1">
                    <b>Jadwal Perkuliahan</b>
                    <?php if (count($jadwal) == 0): ?>
                      <h3>Belum ada jadwal yang dibuat</h3>    
                    
                    <?php else: ?>               

                      <div>
                        <a href="<?php echo base_url('dashboard/lapjadwal'); ?>" class="pull-right btn btn-flat btn-danger">
                          <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a href="<?php echo base_url('dashboard/exportExcel'); ?>" class="pull-right btn btn-flat btn-success">
                          <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                      </div>

                      <?php foreach ($jadwal as $k_jadwal_perhari => $jadwal_perhari): ?>
                        <table class="table table-bordered text-center">
                          <caption>
                            <h2><?php echo get_hari($k_jadwal_perhari); ?></h2>
                          </caption>

                          <?php foreach ($jadwal_perhari as $k_jadwal_persesi => $jadwal_persesi): ?>
                            <tr>
                              <?php foreach ($jadwal_persesi as $k_jadwal_perruang => $jadwal_perruang): ?>
                                <td width="10%">
                                  <p>
                                    <a href="<?php echo base_url('ajar/view/').'/'.$jadwal_perruang['id_ajar'].'/1' ?>"><?php echo $jadwal_perruang['nama_mata_kuliah'] ?></a><br>
                                    <?php echo $jadwal_perruang['nama_dosen'] ?><br>
                                    <?php echo $jadwal_perruang['kelp'] ?>
                                  </p>
                                </td>
                              <?php endforeach ?>
                            </tr>
                          <?php endforeach ?>

                        </table>
                      <?php endforeach ?>
                    
                    
                    <?php endif ?>



                    <p>
                    </p>
                  </div><!-- /.tab-pane -->


                  <div class="tab-pane <?php echo (count($jadwal) == 0)? 'active' : '' ?>" id="tab_2-2">
                    <b>Form Generate Jadwal</b>
                    <div class="row">
                      <div class="col-md-6">     

                        <div class="box box-success">
                          <!-- form start -->
                          <form role="form" method="post" action="<?php echo base_url('myalgen'); ?>">
                            <div class="box-body">
                              <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <select class="form-control" style="width: 100%;" name="id_tahun_ajaran">
                                <?php foreach ($data_ta as $data): ?>
                                  <option value="<?php echo $data['id_tahun_ajaran']; ?>"><?php echo $data['tahun_ajar']." ".strtoupper($data['semester']); ?></option>                        
                                <?php endforeach ?>
                                  </select>
                              </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                              <button type="submit" class="btn btn-success pull-right">Generate</button>
                            </div>
                          </form>
                        </div><!-- /.box -->

                      </div>
                    </div>

                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

        </section><!-- /.content -->