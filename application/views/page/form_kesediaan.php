<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>STMIK Mahakarya</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('dashboard/mdosen'); ?>">Dosen</a></li>
            <li class="active">Kesediaan</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          
              <!-- Custom Tabs (Pulled to the right) -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                  <!-- <li class=""><a href="#tab_1-1" data-toggle="tab">History Kesediaan</a></li> -->
                  <li class="active"><a href="#tab_2-2" data-toggle="tab"><?php echo ($mode=='insert') ? 'Form Kesediaan' : 'View Kesediaan' ; ?></a></li>
                  <li class="pull-left header"><i class="fa fa-th"></i> <?php echo $data_dosen['nama_dosen']; ?></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane" id="tab_1-1">
                    <b>History Kesediaan</b>
                    <p>
                    </p>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane active" id="tab_2-2">
                    <b><h4><?php echo ($mode=='insert') ? 'Form Kesediaan' : 'View Kesediaan' ; ?></h4></b>
                    <div class="row">
                      <div class="col-md-12">     

                        <div class="box box-primary">
                          <!-- form start -->
                          <form role="form" method="post" action="<?php echo base_url('proses/simpan_kesediaan'); ?>">
                            <input type="hidden" name="id_dosen" value="<?php echo $data_dosen['id_dosen']; ?>">
                            <div class="box-body">
                              <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <label class=""><h5>: 2014/2015</h5></label>
                              </div>
                            </div><!-- /.box-body -->
                            <table class="table table-bordered table-striped table-condensed text-center">
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
                                      
                                        <?php # Cek Mode View Insert/Edit ?> 
                                        <?php if ($mode=='insert'): ?>
                                         
                                          <!-- checkbox -->
                                          <input type="checkbox" class="flat-red" name="data_sesi[]" value="<?php echo $value['id_sesi']."|".$v['id_hari']; ?>" checked>
                                        
                                        <?php elseif ($mode=='edit'): ?>
                                        
                                          <!-- checkbox -->
                                          <input type="checkbox" class="flat-red" name="data_sesi[]" value="<?php echo $value['id_sesi']."|".$v['id_hari']; ?>" <?php echo ($value['hari'][$k]['status']=='1') ? 'checked' : '' ; ?> disabled>
                                        
                                        <?php endif ?>
                                          
                                    </td>
                                  <?php endforeach ?>
                                    
                                </tr>
                              <?php endforeach ?>

                            </table>

                            <div class="box-footer">
                              <a href="<?php echo base_url('dashboard/mdosen'); ?>" class="btn btn-default">Cancel</a>
                            
                            <?php # Cek Mode View Insert/Edit ?> 
                            <?php if ($mode=='insert'): ?>
                              <button type="submit" class="btn btn-success pull-right">Save </button>                              
                            <?php elseif ($mode=='edit'): ?>
                              <a href="<?php echo base_url('dashboard/fkesediaan_edit')."/".$data_dosen['id_dosen']; ?>" class="btn btn-success">Edit</a>
                            <?php endif ?>
                            
                            </div>
                          </form>
                        </div><!-- /.box -->

                      </div>
                    </div>

                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

        </section><!-- /.content -->