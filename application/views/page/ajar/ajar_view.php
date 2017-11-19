<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Mengajar
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('ajar'); ?>">Mengajar</a></li>
            <li class="active">View</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('ajar/update'); ?>">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-lg-5">
                        <table class="table table-bordered">
                          <tr>
                            <th>Tahun Ajaran</th>
                            <td><?php echo $record['tahun_ajar']." ".strtoupper($record['semester']); ?></td>
                          </tr>
                          <tr>
                            <th>Mata Kuliah</th>
                            <td><?php echo $record['nama_mata_kuliah']; ?></td>
                          </tr>
                          <tr>
                            <th>Dosen</th>
                            <td><?php echo $record['nama_dosen']; ?></td>
                          </tr>
                          <tr>
                            <th>Kelompok</th>
                            <td><?php echo $record['kelp']; ?></td>
                          </tr>
                          <tr>
                            <th>Waktu</th>
                            <td><?php echo $record['nama_hari'].', '.substr($record['jam_awal'],0,5) ?></td>
                          </tr>
                          <tr>
                            <th>Ruang</th>
                            <td><?php echo 'Gedung '.$record['gedung'].' , Ruang '.$record['nama_ruang']; ?></td>
                          </tr>
                        </table>                        
                      </div>
                      <div class="col-lg-7">
                        <table class="table table-bordered">
                          <tr>
                            <th>Peserta</th>
                            <th style="text-align: right;">
                              <a href="<?php echo base_url('ajar/exportExcel/'.$record['id_ajar']) ?>" class="btn btn-success btn-sm btn-flat" data-toggle="tooltip" title="Export data to excel file"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            </th>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <table class="table table-bordered table-condensed" id="example1">
                              <thead>
                                <tr>
                                  <th>NIM</th>
                                  <th>Nama</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($data_peserta as $value): ?>                          
                                  <tr>
                                    <td><?php echo $value['nim']; ?></td>
                                    <td><?php echo $value['nama']; ?></td>
                                  </tr>                                  
                                <?php endforeach ?>
                              </tbody>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <br>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <?php if (isset($url_cancel)): ?>
                      <a href="<?php echo $url_cancel; ?>" class="btn btn-default">Cancel</a>  
                    <?php else: ?>                    
                      <a href="<?php echo base_url('ajar'); ?>" class="btn btn-default">Cancel</a>
                    <?php endif ?>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->


