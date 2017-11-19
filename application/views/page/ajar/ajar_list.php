<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Manajemen Mengajar
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Mengajar</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <a href="<?php echo base_url('ajar/form'); ?>" class="btn btn-flat btn-primary">Add</a>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">

              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Mengajar</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Kelp</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($record as $value): ?>                        
                        <tr>
                          <td><?php echo $value['nama_mata_kuliah']; ?></td>
                          <td><?php echo $value['nama_dosen']; ?></td>
                          <td><?php echo $value['kelp']; ?></td>
                          <td>
                            <a href="<?php echo base_url('ajar/view')."/".$value['id_ajar']; ?>" class="btn btn-xs btn-flat btn-primary">View</a>
                            <a href="<?php echo base_url('ajar/view')."/".$value['id_ajar']; ?>" class="btn btn-xs btn-flat btn-info">Peserta</a>
                            <a href="<?php echo base_url('ajar/edit')."/".$value['id_ajar']; ?>" class="btn btn-xs btn-flat btn-success">Edit</a>
                            <a href="<?php echo base_url('ajar/delete')."/".$value['id_ajar']; ?>" class="btn btn-xs btn-flat bg-orange" onclick="return konfirmasi()">Delete</a>
                            <script type="text/javascript">
                            function konfirmasi(){
                              var x = confirm('Yakin ingin menghapus data ini ?');
                              if(x){
                                return true;
                              } else {
                                return false;
                              }
                            }
                            </script>
                          </td>
                        </tr>
                      <?php endforeach ?>

                    <tfoot>
                      <tr>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Kelp</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
