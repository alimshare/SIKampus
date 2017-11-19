<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Mahasiswa
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('mahasiswa'); ?>">mahasiswa</a></li>
            <li class="active">View</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" >
                  <div class="box-body">
                    <table class="table table-bordered">
                      <tr>
                        <th>NIM</th>
                        <td><?php echo $record['nim']; ?></td>
                      </tr>
                      <tr>
                        <th>Nama mahasiswa</th>
                        <td><?php echo $record['nama']; ?></td>
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
                    <br>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('mahasiswa'); ?>" class="btn btn-default">Cancel</a>
                    <a href="#" class="btn btn-flat btn-success pull-right">Lihat Jadwal</a>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->