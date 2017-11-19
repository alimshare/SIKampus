<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form Mata Kuliah
            <small>Master</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('matkul'); ?>">Mata Kuliah</a></li>
            <li class="active">Add</li>
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
                <form role="form" method="post" action="<?php echo base_url('matkul/save'); ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="nama_mata_kuliah">Nama Mata Kuliah</label>
                      <input type="text" class="form-control" name="nama_mata_kuliah" id="nama_mata_kuliah" placeholder="Nama Mata Kuliah" required maxlength="60">
                    </div>
                    <div class="form-group">
                      <label for="sks">Jumlah SKS</label>
                      <input type="text" class="form-control" name="sks" id="sks" placeholder="Jumlah SKS" required maxlength="2">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('matkul'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->