<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>STMIK Mahakarya</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dashboard/mdosen'); ?>">Dosen</a></li>
            <li><a href="<?php echo base_url('dashboard/fkesediaan')."/".$data_dosen['id_dosen']; ?>">Kesediaan</a></li>
            <li class="active">Edit</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          
              <!-- Custom Tabs (Pulled to the right) -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                  <li class="active"><a href="#tab_2-2" data-toggle="tab">Edit Kesediaan</a></li>
                  <li class="pull-left header"><i class="fa fa-th"></i> <?php echo $data_dosen['nama_dosen']; ?></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_2-2">
                    <b><h4>Edit Kesediaan</h4></b>
                    <div class="row">
                      <div class="col-md-12">     

                        <div class="box box-primary">
                          <!-- form start -->
                          <form role="form" method="post" action="<?php echo base_url('proses/edit_kesediaan'); ?>">
                            <input type="hidden" name="id_dosen" value="<?php echo $data_dosen['id_dosen']; ?>">
                            <div class="box-body">
                              <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <label class=""><h5>: 2014/2015</h5></label>
                              </div>
                            </div><!-- /.box-body -->
                            <table class="table table-bordered text-center">
                              <tr>
                                <th></th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jum'at</th>
                              </tr>

                              <?php foreach ($sesi as $key => $value): ?>
                                <tr>
                                  <!-- Kolom Sesi -->
                                  <td width="10%">
                                    <?php echo substr($value['jam_awal'],0,5) . " - " . substr($value['jam_akhir'],0,5); ?>
                                  </td>

                                  <?php foreach ($hari as $k => $v): ?>
                                    <td>
                                      
                                          <!-- checkbox -->
                                          <input type="checkbox" class="flat-red" name="data_sesi[]" value="<?php echo $value['id_sesi']."|".$v['id_hari']; ?>" <?php echo ($value['hari'][$k]['status']=='1') ? 'checked' : '' ; ?> >
                                                                                 
                                    </td>
                                  <?php endforeach ?>
                                    
                                </tr>
                              <?php endforeach ?>

                            </table>

                            <div class="box-footer">
                              <a href="<?php echo base_url('dashboard/fkesediaan')."/".$data_dosen['id_dosen']; ?>" class="btn btn-default">Cancel</a>
                            
                              <button type="submit" class="btn btn-primary pull-right">Edit </button>     
                            
                            </div>
                          </form>
                        </div><!-- /.box -->

                      </div>
                    </div>

                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

        </section><!-- /.content -->