<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Dosen
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dosen'); ?>">Dosen</a></li>
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
                <form role="form" method="post" action="<?php echo base_url('dosen/update'); ?>">
                  <div class="box-body">
                    <table class="table table-bordered">
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
                    <br>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('dosen'); ?>" class="btn btn-default">Cancel</a>
                    <a href="<?php echo base_url('dosen/jadwal/'.$record['id_dosen']); ?>" class="btn btn-flat btn-success pull-right">Lihat Jadwal</a>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->