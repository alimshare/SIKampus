<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proses extends CI_Controller {
	
	function __construct(){
		parent::__construct();

		$this->load->model('mymodel');
		$this->auth();
	}

	function auth(){
		if (!$this->session->userdata('log_admin')){
			redirect('login');
		}
	}

	
	############# =========== DOSEN ================== ############

	function simpan_dosen()
	{
		$data['nama_dosen'] 	= $this->input->post('nama_dosen');
		$data['no_telp'] 		= $this->input->post('nomor_dosen');
		$data['email ']			= $this->input->post('email_dosen');

		$stat = $this->mymodel->insert('dosen',$data);
		if ($stat){
			$this->session->set_flashdata('message','Dosen berhasil disimpan !');
			redirect('dashboard/mdosen');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function edit_dosen(){	

		$id_dosen	 			= $this->input->post('id_dosen');

		$data['nama_dosen'] 	= $this->input->post('nama_dosen');
		$data['no_telp'] 		= $this->input->post('nomor_dosen');
		$data['email ']			= $this->input->post('email_dosen');

		$stat = $this->mymodel->update('dosen',$data,array('id_dosen'=>$id_dosen));
		if ($stat){
			$this->session->set_flashdata('message','Dosen berhasil diubah !');
			redirect('dashboard/mdosen');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function hapus_dosen($id){	
		
		$nilai = array (
			'id_dosen' => $id			
		);

		$stat = $this->mymodel->delete('dosen',$nilai);
		if ($stat){
			$this->session->set_flashdata('message','Dosen berhasil dihapus !');
			redirect('dashboard/mdosen');
		} else {
			echo "Gagal ". mysql_error();
		}
	}
	
	############# =========== MATA KULIAH ================== ############

	function simpan_matkul()
	{
		$data['nama_mata_kuliah'] 	= $this->input->post('nama_mata_kuliah');
		$data['sks'] 				= $this->input->post('sks');

		$stat = $this->mymodel->insert('mata_kuliah',$data);
		if ($stat){
			$this->session->set_flashdata('message','Mata Kuliah berhasil disimpan !');
			redirect('dashboard/mmatkul');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function edit_matkul(){	

		$id_mata_kuliah	 			= $this->input->post('id_mata_kuliah');

		$data['nama_mata_kuliah'] 	= $this->input->post('nama_mata_kuliah');
		$data['sks'] 				= $this->input->post('sks');

		$this->mymodel->update('mata_kuliah',$data,array('id_mata_kuliah'=>$id_mata_kuliah));
		
		$stat = $this->mymodel->insert('mata_kuliah',$data);
		if ($stat){
			$this->session->set_flashdata('message','Mata Kuliah berhasil diubah !');
			redirect('dashboard/mmatkul');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function hapus_matkul($id){	
		
		$nilai = array (
			'id_mata_kuliah' => $id			
		);

		$stat = $this->mymodel->delete('mata_kuliah',$nilai);
		if ($stat){
			$this->session->set_flashdata('message','Mata Kuliah berhasil dihapus !');
			redirect('dashboard/mmatkul');
		} else {
			echo "Gagal ". mysql_error();
		}
	}
	
	############# =========== TAHUN AJARAN ================== ############

	function simpan_ta()
	{
		$data['tahun_ajar'] 	= $this->input->post('tahun_ajar');
		$data['semester'] 		= $this->input->post('semester');
		$data['status'] 		= $this->input->post('status');

		# Ubah status seluruh tahun ajaran yang ada menjadi "Tidak Aktif"
		if ($data['status'] == 1){
			$parameter_edit['status'] = '0';
			$stat = $this->mymodel->update('tahun_ajaran',$parameter_edit);
		}

		$stat = $this->mymodel->insert('tahun_ajaran',$data);
		if ($stat){
			if ($data['status'] == 1) {
				$this->session->set_flashdata('message','Tahun Ajaran berhasil disimpan ! Harap lakukan login ulang agar data Tahun Ajaran Sesuai');				
			} else {
				$this->session->set_flashdata('message','Tahun Ajaran berhasil disimpan !');
			}
			redirect('dashboard/mta');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function edit_ta(){	

		$id_tahun_ajaran 			= $this->input->post('id_tahun_ajaran');

		$data['tahun_ajar'] 		= $this->input->post('tahun_ajar');
		$data['semester'] 			= $this->input->post('semester');
		$data['status'] 			= $this->input->post('status');
		
		# Ubah status seluruh tahun ajaran yang ada menjadi "Tidak Aktif"
		if ($data['status'] == 1){
			$parameter_edit['status'] = '0';
			$stat = $this->mymodel->update('tahun_ajaran',$parameter_edit);
		}

		$stat = $this->mymodel->update('tahun_ajaran',$data,array('id_tahun_ajaran'=>$id_tahun_ajaran));
		if ($stat){
			if ($data['status'] == 1) {
				$this->session->set_flashdata('message','Tahun Ajaran berhasil diubah ! Harap lakukan login ulang agar data Tahun Ajaran Sesuai');
			} else {
				$this->session->set_flashdata('message','Tahun Ajaran berhasil diubah !');
			}
			redirect('dashboard/mta');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function hapus_ta($id){	
		
		$nilai = array (
			'id_tahun_ajaran' => $id			
		);

		$stat = $this->mymodel->delete('tahun_ajaran',$nilai);
		if ($stat){
			$this->session->set_flashdata('message','Tahun Ajaran berhasil dihapus !');
			redirect('dashboard/mta');
		} else {
			echo "Gagal ". mysql_error();
		}
	}
	
	############# =========== MENGAJAR ================== ############

	function simpan_ajar()
	{
		$data['id_mata_kuliah'] 	= $this->input->post('id_mata_kuliah');
		$data['id_dosen'] 			= $this->input->post('id_dosen');
		$data['id_tahun_ajaran'] 	= $this->input->post('id_tahun_ajaran');
		$data['kelp'] 				= $this->input->post('kelp');

		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$data['id_tahun_ajaran']))){	
			$this->session->set_flashdata('tipeMessage','danger');
			$this->session->set_flashdata('message','Data Ajar Tidak bisa <ins>ditambahkan</ins> dan <ins>dihapus</ins> ketika Jadwal Kuliah di Semester Aktif sudah dibuat !');
			redirect('dashboard/majar');			
		} else {
			# Delete semua data ajar yang ada dengan id_dosen = 1
			$nilai = array (
				'id_dosen' => '1'			
			);
			$stat = $this->mymodel->delete('ajar',$nilai);
			
			$stat = $this->mymodel->insert('ajar',$data);
			if ($stat){
				$this->session->set_flashdata('message','Data Ajar berhasil disimpan !');
				redirect('dashboard/majar');
			} else {
				echo "Gagal ". mysql_error();
			}
		}
	}

	function edit_ajar(){	

		$id_ajar 					= $this->input->post('id_ajar');

		$data['id_mata_kuliah'] 	= $this->input->post('id_mata_kuliah');
		$data['id_dosen'] 			= $this->input->post('id_dosen');
		$data['id_tahun_ajaran'] 	= $this->input->post('id_tahun_ajaran');
		$data['kelp'] 				= $this->input->post('kelp');

		$stat = $this->mymodel->update('ajar',$data,array('id_ajar'=>$id_ajar));
		if ($stat){
			$this->session->set_flashdata('message','Data Ajar berhasil diubah !');
			redirect('dashboard/majar');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function hapus_ajar($id){	
		
		$tahun_ajaran 			= $this->session->userdata('id_tahun_ajaran'); 
		$nilai = array (
			'id_ajar' => $id			
		);

		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$tahun_ajaran))){	
			$this->session->set_flashdata('tipeMessage','danger');
			$this->session->set_flashdata('message','Data Ajar Tidak bisa <ins>ditambahkan</ins> dan <ins>dihapus</ins> ketika Jadwal Kuliah di Semester Aktif sudah dibuat !');
			redirect('dashboard/majar');			
		} else {
			$stat = $this->mymodel->delete('ajar',$nilai);
			if ($stat){
				$this->session->set_flashdata('message','Data Ajar berhasil dihapus !');
				redirect('dashboard/majar');
			} else {
				echo "Gagal ". mysql_error();
			}
		}
	}
	
	############# =========== KESEDIAAN ================== ############

	function simpan_kesediaan()
	{
		$data_sesi 					= $this->input->post('data_sesi');
		$data['id_dosen'] 			= $this->input->post('id_dosen');
		$data['id_tahun_ajaran'] 	= '1';//$this->input->post('id_tahun_ajaran');
		

		echo "<pre>";
		print_r($data);
		echo "</pre>";

		foreach ($data_sesi as $key => $value) {
			$sesi 					= explode("|", $value);
			$data['id_sesi'] 		= $sesi[0]; 
			$data['id_hari'] 		= $sesi[1]; 
			$stat = $this->mymodel->insert('kesediaan',$data);

			#echo $this->db->last_query()."<br>";		
		}

		redirect('dashboard/fkesediaan'.'/'.$data['id_dosen']);
	}

	function edit_kesediaan()
	{	

		$data_sesi 					= $this->input->post('data_sesi');
		$data['id_dosen'] 			= $this->input->post('id_dosen');
		$data['id_tahun_ajaran'] 	= '1';//$this->input->post('id_tahun_ajaran');
		
		###### Hapus Data Kesediaan Dosen pada Semester tertentu #################
		$arr_data_hapus = array(
				'id_dosen'			=> $data['id_dosen'],
				'id_tahun_ajaran' 	=> $data['id_tahun_ajaran']
			); 
		$this->mymodel->delete('kesediaan',$arr_data_hapus);
		#echo $this->db->last_query()."<br>";

		###### Input Ulang data Kesediaan #################
		foreach ($data_sesi as $key => $value) {
			$sesi 					= explode("|", $value);
			$data['id_sesi'] 		= $sesi[0]; 
			$data['id_hari'] 		= $sesi[1]; 
			$stat = $this->mymodel->insert('kesediaan',$data);

			#echo $this->db->last_query()."<br>";		
		}

		redirect('dashboard/fkesediaan'.'/'.$data['id_dosen']);
	}

	############# =========== JADWAL ================== ############

	function simpan_jadwal()
	{
		$tahun_ajaran 			= $this->session->userdata('id_tahun_ajaran'); 

		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$tahun_ajaran))){
			
			$this->session->set_flashdata('message', 'Data Jadwal Sudah dibuat . Silahkan Hubungi Pihak Pengajaran untuk perubahan Jadwal.');
			redirect('dashboard/fjadwal');

		} else {

			/* Pake Transcation Query ketika penyimpanan Jadwal */
			$this->db->trans_begin();

			$data_jadwal 					= $this->input->post('jadwal');	
			$countHari 						= $this->input->post('countHari');
			$countSesi 						= $this->input->post('countSesi');
			$countRuang 					= $this->input->post('countRuang');		

			$cursor = 0;
			for ($hari=1; $hari <= $countHari; $hari++) { 
				for ($sesi=1; $sesi <= $countSesi ; $sesi++) { 
					for ($ruang=1; $ruang <= $countRuang ; $ruang++) { 
						$data['id_tahun_ajaran'] 	= $tahun_ajaran;
						$data['id_hari'] 	= $hari;
						$data['id_sesi'] 	= $sesi;
						$data['id_ruang'] 	= $ruang;
						$data['id_ajar'] 	= $data_jadwal[$cursor];
						$stat = $this->mymodel->insert('jadwal_kuliah',$data);
						#echo $hari."===".$sesi."===".$ruang."===".$data_jadwal[$cursor];echo "<br>";
						$cursor++;
					}
				}
			}			

			if ($this->db->trans_status() === FALSE)
			{ $this->db->trans_rollback(); }
			else
			{ $this->db->trans_commit(); }

			/* Akhir dari Transaction Query */

			redirect('dashboard/fjadwal');
		}
	}

	function simpan_jadwalManual()
	{
		$tahun_ajaran 			= $this->session->userdata('id_tahun_ajaran'); 

		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$tahun_ajaran))){
			
			$this->session->set_flashdata('message', 'Data Jadwal Sudah dibuat . Silahkan Hubungi Pihak Pengajaran untuk perubahan Jadwal.');
			redirect('dashboard/manual');

		} else {

			$data_jadwal 					= $this->input->post('jadwal');			
			$countHari 						= $this->input->post('countHari');
			$countSesi 						= $this->input->post('countSesi');
			$countRuang 					= $this->input->post('countRuang');
			
			/* Pake Transcation Query ketika penyimpanan Jadwal */
			$this->db->trans_begin();

			$cursor = 0;
			for ($hari=1; $hari <= $countHari; $hari++) { 
				for ($sesi=1; $sesi <= $countSesi ; $sesi++) { 
					for ($ruang=1; $ruang <= $countRuang ; $ruang++) { 
						$data['id_tahun_ajaran'] 	= $tahun_ajaran;
						$data['id_hari'] 	= $hari;
						$data['id_sesi'] 	= $sesi;
						$data['id_ruang'] 	= $ruang;
						$data['id_ajar'] 	= $data_jadwal[$cursor];
						$stat = $this->mymodel->insert('jadwal_kuliah',$data);
						#echo $hari."===".$sesi."===".$ruang."===".$data_jadwal[$cursor];echo "<br>";
						$cursor++;
					}
				}
			}

			if ($this->db->trans_status() === FALSE)
			{ $this->db->trans_rollback(); }
			else
			{ $this->db->trans_commit(); }

			/* Akhir dari Transaction Query */

			// echo "<br>";print_r($data_jadwal);die();
			redirect('dashboard/fjadwal');
		}
	}

	############# =========== VALIDASI DATA ================== ############



}

/* End of file proses.php */
/* Location: ./application/controllers/proses.php */