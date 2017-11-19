<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Jadwal Dosen
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dosen'); ?>">Dosen</a></li>
            <li class="active">Jadwal</li>
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
                <form role="form" method="post" action="<?php echo base_url('dosen/update'); ?>">
                  <div class="box-body">

                    <div class="row">
                      <div class="col-md-5">

                        <table class="table table-bordered col-md-6">
                          <tr>
                            <th>Nama Dosen</th>
                            <td><?php echo $record['nama_dosen']; ?></td>
                          </tr>
                          <tr>
                            <th>Nomor Telepon</th>
                            <td><?php echo $record['no_telp']; ?></td>
                          </tr>
                          <tr>
                            <th>Email</th>
                            <td><?php echo $record['email']; ?></td>
                          </tr>
                        </table>

                      </div>
                      <div class="col-md-7">
                        <table class="table table-bordered">
                          <thead>
                            <th>Waktu</th>
                            <th>Ruang</th>
                            <th>Matakuliah</th>
                            <th>Kelp</th>
                            <th></th>
                          </thead>
                          <tbody>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><a href="#" class="btn btn-info btn-flat btn-sm">Detail</a></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('dosen'); ?>" class="btn btn-default">Cancel</a>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>

        </section><!-- /.content -->