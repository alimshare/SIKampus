<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form Mengajar
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('ajar'); ?>">Mengajar</a></li>
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
                  <h3 class="box-title">Data Mengajar</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('ajar/save'); ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Tahun Ajaran</label>
                      <select class="form-control select2" style="width: 100%;" name="id_tahun_ajaran">
                      <?php foreach ($data_ta as $data): ?>
                        <option value="<?php echo $data['id_tahun_ajaran']; ?>"><?php echo $data['tahun_ajar']." ".strtoupper($data['semester']); ?></option>                        
                      <?php endforeach ?>
                      </select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                      <label>Mata Kuliah</label>
                      <select class="form-control select2" style="width: 100%;" name="id_mata_kuliah">
                      <?php foreach ($data_mata_kuliah as $data): ?>
                        <option value="<?php echo $data['id_mata_kuliah']; ?>"><?php echo $data['nama_mata_kuliah']; ?></option>                        
                      <?php endforeach ?>
                      </select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                      <label>Dosen</label>
                      <select class="form-control select2" style="width: 100%;" name="id_dosen">
                      <?php foreach ($data_dosen as $data): ?>
                        <option value="<?php echo $data['id_dosen']; ?>"><?php echo $data['nama_dosen']; ?></option>                        
                      <?php endforeach ?>
                      </select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Kelompok</label>
                      <input type="text" class="form-control" name="kelp" id="kelompok" placeholder="Kelompok Mata Kuliah" maxlength="2" required>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('ajar'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->