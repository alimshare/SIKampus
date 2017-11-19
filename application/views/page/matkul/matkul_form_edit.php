<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form Mata Kuliah
            <small>Master</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('matkul'); ?>">Mata Kuliah</a></li>
            <li class="active">Edit</li>
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
                  <h3 class="box-title">Data Mata Kuliah</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('matkul/update'); ?>">
                  <div class="box-body">
                    <input type="hidden" name="id_mata_kuliah" value="<?php echo $record['id_mata_kuliah']; ?>">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Mata Kuliah</label>
                      <input type="text" class="form-control" name="nama_mata_kuliah" id="nama_mata_kuliah" placeholder="Enter Nama Mata Kuliah" required maxlength="60" value="<?php echo $record['nama_mata_kuliah']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="sks">Jumlah SKS</label>
                      <input type="text" class="form-control" name="sks" id="sks" placeholder="Jumlah SKS" required maxlength="2" value="<?php echo $record['sks']; ?>">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('matkul'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Edit</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->