
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="glyphicon glyphicon-th-large"></i> <span>Master</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('dosen'); ?>"><i class="fa fa-circle-o"></i> Dosen</a></li>
                <li><a href="<?php echo base_url('matkul'); ?>"><i class="fa fa-circle-o"></i> Mata Kuliah</a></li>
                <li><a href="<?php echo base_url('dashboard/mta'); ?>"><i class="fa fa-circle-o"></i> Tahun Ajaran</a></li>
                <li><a href="<?php echo base_url('ajar'); ?>"><i class="fa fa-circle-o"></i> Mengajar</a></li>
                <!--<li><a href="#"><i class="fa fa-circle-o"></i> User</a></li>-->
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-graduation-cap"></i> <span>Academic</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('mahasiswa'); ?>"><i class="fa fa-circle-o"></i> Mahasiswa</a></li>
              </ul>
            </li>
            <li>
              <a href="<?php echo base_url('dashboard/fjadwal'); ?>">
                <i class="fa fa-calendar"></i> <span>Jadwal</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-gear"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo base_url('role'); ?>"><i class="fa fa-circle-o"></i> Role</a></li>
                <li><a href="<?php echo base_url('role'); ?>"><i class="fa fa-circle-o"></i> User</a></li>
                <li><a href="<?php echo base_url('role'); ?>"><i class="fa fa-circle-o"></i> Email</a></li>
                <li><a href="<?php echo base_url('role'); ?>"><i class="fa fa-circle-o"></i> SMS</a></li>
              </ul>
            </li>

            <li>
              <a href data-toggle="modal" data-target="#mdlLogout" class="">
                <i class="fa fa-power-off"></i> <span>Log Out</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <div class="modal fade" id="mdlLogout">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Konfirmasi</h4>
            </div>
            <div class="modal-body">
              <h5>Yakin ingin keluar dari aplikasi ?</h5>
            </div>
             <div class="modal-footer">
              <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-primary btn-flat">Yes</a>
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal" autofocus="yes">No</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>