<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form Tahun Ajaran
            <small>Master</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dashboard/mta'); ?>">Tahun Ajaran</a></li>
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
                  <h3 class="box-title">Data Tahun Ajaran</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('proses/simpan_ta'); ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tahun Ajaran</label>
                      <input type="text" class="form-control" name="tahun_ajar" id="tahun_ajar" placeholder="Tahun awal/Tahun AKhir" required maxlength="9">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Semeter</label>
                      <br>
                      <label>
                        <input type="radio" name="semester" value="gasal" class="flat-red" checked>
                        Gasal
                      </label>
                      &nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="semester" value="genap" class="flat-red">
                        Genap
                      </label>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Status</label>
                      <br>
                      <label>
                        <input type="radio" name="status" value="1" class="flat-red" checked>
                        Aktif
                      </label>
                      &nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="status" value="0" class="flat-red">
                        Non Aktif
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('dashboard/mta'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->