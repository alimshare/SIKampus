<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Form mahasiswa
            <small>Master</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('mahasiswa'); ?>">mahasiswa</a></li>
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
                  <h3 class="box-title">Data mahasiswa</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url('mahasiswa/update'); ?>">
                  <div class="box-body">
                    <input type="hidden" name="id_mahasiswa" value="<?php echo $record['nim']; ?>">
                    <div class="form-group">
                      <label for="exampleInputEmail1">NIM</label>
                      <input type="text" class="form-control" name="nim" id="nim_mahasiswa" placeholder="Enter Name" maxlength="10" value="<?php echo $record['nim']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama mahasiswa</label>
                      <input type="text" class="form-control" name="nama" id="nama_mahasiswa" placeholder="Enter Name" required maxlength="50" value="<?php echo $record['nama']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nomor Telepon</label>
                      <input type="text" class="form-control" name="telp" id="telp_mahasiswa" placeholder="Enter Phone Number" maxlength="15" value="<?php echo $record['no_telp']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control" name="email" id="email_mahasiswa" placeholder="Enter email" maxlength="30" value="<?php echo $record['email']; ?>">
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="<?php echo base_url('mahasiswa'); ?>" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary pull-right">Edit</button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->