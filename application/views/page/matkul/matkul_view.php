<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Mata Kuliah
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('matkul'); ?>">Mata Kuliah</a></li>
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
                <form role="form" method="post">
                  <div class="box-body">
                    <table class="table table-bordered">
                      <tr>
                        <th>Nama Mata Kuliah</th>
                        <td><?php echo $record['nama_mata_kuliah']; ?></td>
                      </tr>
                      <tr>
                        <th>Jumlah SKS</th>
                        <td><?php echo $record['sks']; ?></td>
                      </tr>
                    </table>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('matkul'); ?>" class="btn btn-default">Cancel</a>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->