<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Manajemen Tahun Ajaran
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Tahun Ajaran</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <a href="<?php echo base_url('dashboard/fta'); ?>" class="btn btn-flat btn-primary">Add</a>
            </div>
          </div>
          <?php if ($this->session->flashdata('message')): ?>

            <div class="row">
              <div class="col-xs-12">
                <div class="alert alert-info alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-info"></i> Alert!</h4>
                  <?php echo $this->session->flashdata('message'); ?>
                </div>
              </div>
            </div>
          <?php endif ?>
          <?php #if (base64_decode($info) != ""): ?>
          <!--
            <div class="row">
              <div class="col-xs-12">
                <div class="alert alert-info alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-info"></i> Alert!</h4>
                  <?php #echo $info; ?>
                </div>
              </div>
            </div> -->
          <?php #endif ?>
          <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Tahun Ajaran</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Tahun Ajar</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($record as $value): ?>
                        <tr>
                          <td><?php echo $value['tahun_ajar']; ?></td>
                          <td><?php echo $value['semester']; ?></td>
                          <td><?php echo ($this->session->userdata('id_tahun_ajaran') == $value['id_tahun_ajaran']) ? 'Active' : '' ?></td>
                          <td>
                            <?php if ($this->session->userdata('id_tahun_ajaran') != $value['id_tahun_ajaran']): ?>
                              <a href="<?php echo base_url('dashboard/fta_edit')."/".$value['id_tahun_ajaran']; ?>" class="btn btn-xs btn-flat btn-success">Edit</a>
                              <a href="<?php echo base_url('proses/hapus_ta')."/".$value['id_tahun_ajaran']; ?>" class="btn btn-xs btn-flat bg-orange" onclick="return konfirmasi()">Hapus</a>
                              <script type="text/javascript">
                                function konfirmasi(){
                                  var x = confirm('Yakin ingin menhapus data ini ?');
                                  if(x){
                                    return true;
                                  } else {
                                    return false;
                                  }
                                }
                              </script>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach ?>

                    <tfoot>
                      <tr>
                        <th>Tahun Ajar</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
