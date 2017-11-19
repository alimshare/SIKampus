<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form Tahun Ajaran
            <small>Master</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dashboard/mta'); ?>">Tahun Ajaran</a></li>
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
                  <h3 class="box-title">Data Tahun Ajaran</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('proses/edit_ta'); ?>">
                  <div class="box-body">
                    <input type="hidden" name="id_tahun_ajaran" value="<?php echo $record['id_tahun_ajaran']; ?>">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Tahun Ajar</label>
                      <input type="text" class="form-control" name="tahun_ajar" id="tahun_ajar" placeholder="Tahun awal/Tahun AKhir" required maxlength="9" value="<?php echo $record['tahun_ajar']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Semeter</label>
                      <br>
                      <label>
                        <input type="radio" name="semester" value="gasal" class="flat-red" <?php echo ($record['semester']=='gasal') ? 'checked' : '' ; ?>>
                        <label for="exampleInputEmail1">Gasal</label>
                      </label>
                      &nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="semester" value="genap" class="flat-red" <?php echo ($record['semester']=='genap') ? 'checked' : '' ; ?>>
                        <label for="exampleInputEmail1">Genap</label>
                      </label>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Status</label>
                      <br>
                      <label>
                        <input type="radio" name="status" value="1" class="flat-red" <?php echo ($record['status']=='1') ? 'checked' : '' ; ?>>
                        Aktif
                      </label>
                      &nbsp;&nbsp;&nbsp;
                      <label>
                        <input type="radio" name="status" value="0" class="flat-red" <?php echo ($record['status']=='0') ? 'checked' : '' ; ?>>
                        Non Aktif
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('dashboard/mta'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Edit</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->