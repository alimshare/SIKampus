<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form Dosen
            <small>Master</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dosen'); ?>">Dosen</a></li>
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
                  <h3 class="box-title">Data Dosen</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('dosen/save'); ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Dosen</label>
                      <input type="text" class="form-control" name="nama_dosen" id="nama_dosen" placeholder="Enter Name" required maxlength="50">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nomor Telepon</label>
                      <input type="text" class="form-control" name="nomor_dosen" id="nomor_dosen" placeholder="Enter Phone Number" maxlength="15">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control" name="email_dosen" id="email_dosen" placeholder="Enter email" maxlength="30">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('dosen'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->