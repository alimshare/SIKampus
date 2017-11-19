<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Manajemen Mahasiswa
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Mahasiswa</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <a href="<?php echo base_url('mahasiswa/form'); ?>" class="btn btn-flat btn-primary">Add</a>
            </div>
          </div>
          
          <?php #$this->load->view('inc/message'); ?>

          <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Mahasiswa</h3>
                  <div class="pull-right">
                    <a href="<?php echo base_url('mahasiswa/exportExcel') ?>" class="btn btn-flat btn-success" data-toggle="tooltip" title="Export data to excel file"><i class="fa fa-file-excel-o"></i> Excel</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($record as $value): ?>
                        <tr>
                          <td><?php echo $value['nim']; ?></td>
                          <td><?php echo $value['nama']; ?></td>
                          <td>
                            <a href="<?php echo base_url('mahasiswa/view')."/".$value['nim']; ?>" class="btn btn-xs btn-flat btn-primary">View</a>
                            <a href="<?php echo base_url('mahasiswa/view')."/".$value['nim']; ?>" class="btn btn-xs btn-flat btn-info">Jadwal</a>
                            <a href="<?php echo base_url('mahasiswa/edit')."/".$value['nim']; ?>" class="btn btn-xs btn-flat btn-success">Edit</a>
                            <a href="<?php echo base_url('mahasiswa/delete')."/".$value['nim']; ?>" class="btn btn-xs btn-flat bg-orange" onclick="return konfirmasi()">Hapus</a>
                            <script type="text/javascript">
                            function konfirmasi(){
                              var x = confirm('Yakin ingin menghapus data ini ?');
                              if(x){
                                return true;
                              } else {
                                return false;
                              }
                            }
                            </script>
                          </td>
                        </tr>
                      <?php endforeach ?>

                    <tfoot>
                      <tr>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
