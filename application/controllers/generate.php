<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generate extends CI_Controller {
	
	function __construct(){
		parent::__construct();

		$this->load->model('mymodel');
		#$this->load->helper('form');
	}
	
	public function index()
	{
		
		$id_tahun_ajaran 	= $this->input->post('id_tahun_ajaran');
		$arr_kesediaan 		= $this->get_data_kesediaan($id_tahun_ajaran);
		
		$jumlah_sesi 		= $this->mymodel->all('sesi');
		$jumlah_ruang 		= 7;
		$panjang_gen 		= $jumlah_sesi->num_rows() * $jumlah_ruang;

		$dosen  			= $this->mymodel->get_where('ajar',array('id_tahun_ajaran'=>$id_tahun_ajaran));

		$selisih = ($panjang_gen - $dosen->num_rows());
		
		if ($selisih > 0) 
			$this->add_ajar_kosong($selisih);

		$kosong 		= $this->mymodel->get_where('ajar',array('id_tahun_ajaran'=>$id_tahun_ajaran,'id_dosen'=>'1'))->result_array();
		$ajaran_kosong 	= array_column($kosong,'id_ajar');
		
		$ajaran 		= array_column($dosen->result_array(),'id_ajar');
		$list_dosen		= array_column($dosen->result_array(),'id_dosen');

		# Data Ajar = Keys | Data Dosen = Value
		# Array yang digunakan untuk melihat data
		$look_ajar_dosen= array_combine($ajaran, $list_dosen);

		#$ajaran_full	= array_merge($ajaran, $ajaran_kosong);

		#$this->list_gen($ajaran);
		#$this->list_gen($ajaran_full);
		#echo "<pre>";
			#print_r($dosen);
			#print_r($ajaran);
			#print_r($look_ajar_dosen);
		#echo "</pre>";

		//ini_set('max_execution_time', 0);
		$solusi 		= $this->proses_testing($ajaran, 100, $arr_kesediaan, $ajaran_kosong,$look_ajar_dosen);
		$fitness 		= $this->fitness_individu($solusi, $arr_kesediaan, $ajaran_kosong,$look_ajar_dosen);
		$solusi_fitness = array();
		foreach ($solusi as $key => $value) {
			$solusi_fitness[] = array($solusi[$key], $fitness[$key]);
		}

		$solusi_fitness = $this->get_detail_ajar($solusi_fitness);
		$solusi_fitness = array_chunk($solusi_fitness, count($solusi_fitness)/5);
		foreach ($solusi_fitness as $key => $value) {
			$solusi_fitness[$key] = array_chunk($solusi_fitness[$key], count($solusi_fitness[$key])/5);
		}

		$this->view($solusi_fitness);

	}

	function view($solusi_fitness){

		$data['sesi_waktu'] = $this->mymodel->get_field_distinct('sesi','jam_awal,jam_akhir')->result_array();

		$data['jadwal'] 	= $solusi_fitness;
		$data['content']	= 'page/view_generate';

		$this->load->view('template', $data);
	}

	function get_detail_ajar($solusi){

		$ajar  			= $this->mymodel->all('view_ajar');
		$id_ajar 		= array_column($ajar->result_array(), "id_ajar");
		$data 	 		= array_combine($id_ajar, $ajar->result_array());
		$i = 0;
		foreach ($solusi as $key => $value) {
			$data_solusi[$i] = $data[$value[0]];
			$data_solusi[$i]['status'] = $value[1];
			$i++;
		}
		
		return $data_solusi;
	}

	function add_ajar_kosong($loop){
		for ($i=0; $i < $loop; $i++) {
			$data = array(
					'id_dosen' 		 => '1',
					'id_mata_kuliah' => '1',
					'id_tahun_ajaran'=> '1',
					'kelp' 			 => '-'
				); 
			$this->mymodel->insert('ajar',$data);
		}
	}

	function get_data_kesediaan($ta){
		
		$sql = "select id_sesi from sesi order by id_sesi";
		$data = $this->mymodel->query($sql)->result_array();
		$arr_kesediaan = array();

		foreach ($data as $key => $value) {
			$arr_param_kesediaan = array(
					'id_sesi' 		  => $value['id_sesi'],
					'id_tahun_ajaran' => $ta,
				);
			$arr_kesediaan[$value['id_sesi']] = array_column($this->mymodel->get_where_field('kesediaan','id_dosen',$arr_param_kesediaan)->result_array(),'id_dosen');
		}

		return $arr_kesediaan;
	}

	function fitness_individu($array_individu, $arr_kesediaan, $arr_kesediaan_kosong,$look){
		$array_fitness = array();

		$counter = 0;		
		foreach ($array_individu as $k=>$v) {

			error_reporting(0);
			#### Cek Sesi berdasarkan 1 sesi terdiri dari (n) ruang 
			#### n = nilai modulus (jumlah ruang yang tersedia)
			$sesi = ($k % 7==0) ? ++$counter : $counter ;
			#echo $k . PHP_EOL;
			
			#### cek kesediaan dosen persesi
			#### Data Kosong = Dosen Tidak Bersedia (nilai = 1) | Data Ada = Dosen bersedia (nilai = 0)
			$array_fitness[] = in_array($look[$v], $arr_kesediaan[$sesi])?'0': (in_array($v, $arr_kesediaan_kosong) ? '0' : '1' );
		
		}

		return $array_fitness;	
	}

	function fitness_new($array_populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look){
		$array_fitness = array();
		
		#echo "<pre>";
		#print_r($array_populasi);
		#print_r($arr_kesediaan);
		#echo "</pre>";
		
		foreach ($array_populasi as $k=>$v) {

			$counter = 0;
			foreach ($v as $key => $val) {
				
				#### Cek Sesi berdasarkan 1 sesi terdiri dari (n) ruang 
				#### n = nilai modulus (jumlah ruang yang tersedia)
				$sesi = ($key % 7==0) ? ++$counter : $counter ;
				
				#### cek kesediaan dosen persesi
				#### Data Kosong = Dosen Tidak Bersedia (nilai = 1) | Data Ada = Dosen bersedia (nilai = 0)
				$array_fitness[$k][] = in_array($look[$val], $arr_kesediaan[$sesi])?'0': (in_array($val, $arr_kesediaan_kosong) ? '0' : '1' );
				 

				#$x[$k][] = $key % 7;
				#$y[$k][] = $sesi;
			}

			#echo "<table border='1' cellpadding='3' cellspacing='0'>";
			#echo "<tr>";
			#	foreach ($array_populasi[$k] as $key => $value) {
			#		echo "<td>".$value."</td>";
			#	}
			#echo "</tr>";
			#echo "<tr>";
			#	for ($i=0; $i < count($y[$k]); $i+=7) { 
			#		echo "<td colspan='7'>".$y[$k][$i]."</td>";
			#	}
			#echo "</tr>";
			#echo "<tr>";
			#	foreach ($array_fitness[$k] as $key => $value) {
			#		echo "<td>".$value."</td>";
			#	}
			#echo "</tr>";
			#echo "</table>";

			#foreach ($look as $key => $value) {
			#	echo $key. " ==== " .$value."<br>";
			#}

		}

		return $array_fitness;	
	}

	function fitness_new_old($array_populasi, $arr_kesediaan, $arr_kesediaan_kosong){
		$array_fitness = array();
		
		#echo "<pre>";
		#print_r($array_populasi);
		#print_r($arr_kesediaan);
		#echo "</pre>";
		
		foreach ($array_populasi as $k=>$v) {

			$counter = 0;
			foreach ($v as $key => $val) {
				
				#### Cek Sesi berdasarkan 1 sesi terdiri dari (n) ruang 
				#### n = nilai modulus (jumlah ruang yang tersedia)
				$sesi = ($key % 7==0) ? ++$counter : $counter ;
				
				#### cek kesediaan dosen persesi
				#### Data Kosong = Dosen Tidak Bersedia (nilai = 1) | Data Ada = Dosen bersedia (nilai = 0)
				$array_fitness[$k][] = in_array($val, $arr_kesediaan[$sesi])?'0':'1';

				#$x[$k][] = $key % 7;
				$y[$k][] = $sesi;
			}

			#$this->list_gen($x[$k]);
			#$this->list_gen($y[$k]);

			echo "<table border='1' cellpadding='3' cellspacing='0'>";
			echo "<tr>";
				foreach ($array_populasi[$k] as $key => $value) {
					echo "<td>".$value."</td>";
				}
			echo "</tr>";
			echo "<tr>";
				for ($i=0; $i < count($y[$k]); $i+=7) { 
					echo "<td colspan='7'>".$y[$k][$i]."</td>";
				}
			echo "</tr>";
			echo "<tr>";
				foreach ($array_fitness[$k] as $key => $value) {
					echo "<td>".$value."</td>";
				}
			echo "</tr>";
			echo "</table>";

			echo "<pre>";
				print_r($arr_kesediaan[1]);
			echo "</pre>";

			die();
			#echo "<br>";
		}

		return $array_fitness;	
	}

	# Pemrosesan Algoritma Genetika Testing
	function proses_testing($data, $iterasi, $arr_kesediaan, $arr_kesediaan_kosong, $look_dosen){

		#echo "<h2>Populasi Awal</h2>";
		$populasi_awal = $this->populasi($data, 50);

		$populasi = $populasi_awal;
		$fitness  = $this->fitness_new($populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

	
		for ($i=0; $i < $iterasi; $i++) { 
			#echo "<H2>Iterasi ".($i+1)."</h2>";
			
			#if ($this->cek_solusi_terbaik($fitness)) {
			#	echo "<h2>Solusi terbaik ditemukan pada iterasi ke ".($i+1)."</h2>";
			#	break;
			#}

			$parent 		= $this->seleksi_rangking($populasi, $fitness);
			$offspring 		= $this->order_crossover($parent);

			$fitness 		= $this->fitness_new($offspring, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

			#foreach ($offspring as $key => $value) {
			#	$this->list_fitness($offspring[$key], $fitness[$key]);
			#}

			$mutasi 		= $this->mutasi($offspring);
			$fitness 		= $this->fitness_new($mutasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

			#foreach ($mutasi as $key => $value) {
			#	$this->list_fitness($mutasi[$key], $fitness[$key]);
			#}

			# Hasil Crossover & Mutasi di Gabungkan ke dalam Populasi
			$populasi 		= array_merge($populasi,$mutasi);
			$fitness 		= $this->fitness_new($populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

			#echo "<h2>Seluruh Populasi sebelum Update Generasi</h2>";
			#foreach ($populasi as $key => $value) {
			#	$this->list_fitness($populasi[$key], $fitness[$key]);
			#}

			$populasi 		= $this->update_generasi($populasi,50);
			$fitness 		= $this->fitness_new($populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

			#foreach ($populasi as $key => $value) {
			#	$this->list_fitness($populasi[$key], $fitness[$key]);
			#}

		}

		#echo "<h2>Solusi</h2>";
		$fitness_sum 	= $this->fitness_sum($fitness);
		$fitness 		= $this->fitness_new($populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

		
		#foreach ($populasi as $key => $value) {
		#	$this->list_fitness($populasi[$key], $fitness[$key]);
		#}

		$solusi  = $this->tampilkan_solusi($populasi,$fitness);
		
		#echo "<pre>";
		#	print_r($solusi);
		#echo "</pre>";

		#if (in_array(1, $fitness_sum)) {
		#	echo "<h1>Solusi Optimal</h1>";
		#} else {
		#	echo "<h1>Cukup Optimal</h1>";		
		#}

		return $solusi;
		
	}

	# Pemrosesan Algoritma Genetika
	function proses($data, $iterasi){

		echo "<h2>Populasi Awal</h2>";
		$populasi_awal = $this->populasi($data, 5);

		#foreach ($populasi as $key => $value) {
		#	$this->list_gen($value);
		#}
		$populasi = $populasi_awal;

		/*
		for ($i=0; $i < $iterasi; $i++) { 
			echo "<H2>Iterasi ".($i+1)."</h2>";
			
			#if (cek_solusi_terbaik($fitness)) {
			#	echo "<h2>Solusi terbaik ditemukan pada iterasi ke ".($i+1)."</h2>";
			#	break;
			#}

			$parent 		= $this->seleksi_rangking($populasi, $fitness);
			$offspring 		= $this->order_crossover($parent);

			$fitness 		= $this->fitness($offspring, $arr_kesediaan);
			#foreach ($offspring as $key => $value) {
			#	$this->list_fitness($offspring[$key], $fitness[$key]);
			#}

			$mutasi 		= $this->mutasi($offspring);
			$fitness 		= $this->fitness($mutasi, $arr_kesediaan);
			#foreach ($mutasi as $key => $value) {
			#	$this->list_fitness($mutasi[$key], $fitness[$key]);
			#}

			# Hasil Crossover & Mutasi di Gabungkan ke dalam Populasi
			$populasi 		= array_merge($populasi,$mutasi);
			$fitness 		= $this->fitness($populasi, $arr_kesediaan);
			#echo "<h2>Seluruh Populasi sebelum Update Generasi</h2>";
			#foreach ($populasi as $key => $value) {
			#	$this->list_fitness($populasi[$key], $fitness[$key]);
			#}

			$populasi 		= $this->update_generasi($populasi,20);
			$fitness 		= $this->fitness($populasi, $arr_kesediaan);
			foreach ($populasi as $key => $value) {
				$this->list_fitness($populasi[$key], $fitness[$key]);
			}

		}

		#echo "<h2>Solusi</h2>";
		$fitness_sum 	= $this->fitness_sum($fitness);
		$fitness 		= $this->fitness($populasi, $arr_kesediaan);
		
		foreach ($populasi as $key => $value) {
			$this->list_fitness($populasi[$key], $fitness[$key]);
		}

		$solusi = $this->tampilkan_solusi($populasi,$fitness);
		echo "<pre>";
			print_r($solusi);
		echo "</pre>";

		if (in_array(1, $fitness_sum)) {
			echo "<h1>Solusi Optimal</h1>";
		} else {
			echo "<h1>Mendekati Optimal</h1>";		
		}
		*/	
	}

	#--------------------------------------------------------------------------------------------------#

			# Cetak Individu ke layar beserta nilai fitness nya
		function list_gen($ary){
			echo "<table border='1'><tr>";
			foreach ($ary as $key => $value) {
				echo "<td width='80px'>".$value."</td>";			
				#echo ($ary_fitness[$key]==0)?"<td bgcolor='red'>".$value."</td>":"<td>".$value."</td>";
			}
			echo "</tr></table>";
		}

		function list_fitness($ary,$ary_fitness){
			echo "<table border='0'><tr>";
			foreach ($ary as $key => $value) {
				echo "<td style='".(($ary_fitness[$key]==1)?'color:red;font-weight:bold':'')."' width='50px'>".$value."</td>";			
				#echo ($ary_fitness[$key]==0)?"<td bgcolor='red'>".$value."</td>":"<td>".$value."</td>";
			}
			echo "<td>==> ".array_sum($ary_fitness)."</td>";
			echo "</tr></table>";
		}

		# Membangkitkan Populasi Awal
		function populasi($array, $loop){
			$pop_array = array();
			for ($i=0; $i < $loop; $i++) { 
				shuffle($array);
				array_push($pop_array, $array);
			}
			return $pop_array;
		}

		# Menghitung nilai pinalti dari tiap individu
		function fitness($array_populasi,$array_kesediaan){
			$array_fitness = array();
			foreach ($array_populasi as $k=>$v) {
				for ($i=0; $i < count($array_kesediaan); $i++) { 
					$array_fitness[$k][] = $array_kesediaan[$i][$array_populasi[$k][$i]];
				}
			}

			return $array_fitness;		
		}

		# fitness dari tiap individu
		function fitness_sum($array_fitness){
			$array_fitness_sum = array();
			foreach ($array_fitness as $k => $v) {
				$array_fitness_sum[] = round(1/(1+array_sum($array_fitness[$k])),2);
			}
			return $array_fitness_sum;
		}

		# Update Generasi Continuous Update
		function update_generasi($populasi, $bertahan){
			# acak populasi saat ini
			shuffle($populasi);
			$populasi_baru = array_splice($populasi, 0, $bertahan);

			return $populasi_baru;
		}

		# Order Crossover Proses
		function crossover ($array){
			# inisialisasi titik potong 1 & 2
			$t1 = 2;
			$t2 = 7;
			
			# mengambil gen yang akan disilangkan dari tiap parent
			$array_gen_silang = array();
			foreach($array as $k=>$v){
				for($i=0;$i<count($array[$k]);$i++){
					# ambil data berdasarkan titik potong
					if($i>=$t1 && $i<$t2) 
						$array_gen_silang[$k][] = $array[$k][$i];
				}
			}	
			
			# deklarasi variabel sementara untuk penanganan array 2 dimensi
			$var1 = 1; $var2 = 0;
			foreach($array as $key => $val){
			
				$arr_proses 	= $array[$var1];
				$arr_gen_proses = $array_gen_silang[$var2];
				$var1--;
				$var2++;
				
				# mengambil nilai di parent1 yang tidak ada di gen silang parent2
				# berlaku juga sebaliknya
				$arr_x 			= array_diff($arr_proses,$arr_gen_proses);
				$arr_x 			= array_values($arr_x);
				
				# syntax untuk keperluan debugging
				# silahkan di unremark ketika melakukan kegiatan debugging
				#echo "<pre>";
					#print_r($arr_proses);
					#print_r($arr_gen_proses);	
					#print_r($arr_x);
				#echo "</pre>";
				
				
				$p 	= 0; # kursor untuk pengambilan data dari array parent 1 & 2
				$gs = 0; # kursor untuk pengambilan data dari array gen silang 1 & 2
				for($i=0; $i<count($arr_proses);$i++){		
					if($i>=$t1 && $i<$t2){ 
						# ambil dari array gen silang 
						$array_co[$key][$i] = $arr_gen_proses[$gs];
						$gs++;
					}else{
						# ambil dari array parent 1/2 
						$array_co[$key][$i] = $arr_x[$p];
						$p++;
					}
				}
			}

			return $array_co;
		}

		# Order Crossover
		function order_crossover($array){
			#echo "<h2>Crossover</h2>";

			$array_offspring = array();
			for ($i=0; $i < count($array); $i++) { 

				$array_parent = array();			
				if ($i!=count($array)-1) {
					$array_parent[] = $array[$i];
					$array_parent[] = $array[$i+1];
				} else {
					$array_parent[] = $array[$i];
					$array_parent[] = $array[0];
				}
				
				$array_hasil_co = $this->crossover($array_parent);

				foreach ($array_hasil_co as $key => $value) {
					$array_offspring[] = $value;
				}

			}

			return $array_offspring;
		}

		# Seleksi individu dengan metode rangking
		function seleksi_rangking($populasi, $fitness){

			$crossover_rate = (80/100)*count($populasi);
			$fitness_sum 	= $this->fitness_sum($fitness);
			arsort($fitness_sum);

			$fitness_sum_key= array_keys($fitness_sum);
			$parent_terpilih= array_slice($fitness_sum, 0, $crossover_rate);

			foreach ($parent_terpilih as $key => $value) {
				$parent[] = $populasi[$fitness_sum_key[$key]];
			}

			return $parent;
		}

		# Swap Mutation
		function mutasi($array){
			#echo "<h2>Mutasi</h2>";
			$panjang_gen    = count($array)*count($array[0]);
			$mutation_rate 	= round((1/100)*$panjang_gen);

			$titik_mutasi	= array();
			for ($i=0; $i < $mutation_rate; $i++) { 
				$titik_mutasi[] = rand(0,$panjang_gen-1);
			}

			#print_r($titik_mutasi);echo "<br>";

			foreach ($titik_mutasi as $key => $value) {
				$panjang_gen_individu 	= count($array[0]);
				$individu_terpilih 		= intval($value/count($array[0]));
				$gen_terpilih			= $value%$panjang_gen_individu;

				### Script untuk proses debugging ===> Sebelum di Swap ###
				#echo $individu_terpilih.PHP_EOL.$gen_terpilih."<br>";
				#echo ($gen_terpilih!=$panjang_gen_individu-1)? $array[$individu_terpilih][$gen_terpilih]." <==> ".$array[$individu_terpilih][$gen_terpilih+1]
				#		: $array[$individu_terpilih][$gen_terpilih]."<==>".$array[$individu_terpilih][0];

				if ($gen_terpilih!=$panjang_gen_individu-1) {
					$temp = $array[$individu_terpilih][$gen_terpilih];
					$array[$individu_terpilih][$gen_terpilih]   = $array[$individu_terpilih][$gen_terpilih+1];
					$array[$individu_terpilih][$gen_terpilih+1] = $temp;
				} else {
					$temp = $array[$individu_terpilih][$gen_terpilih];
					$array[$individu_terpilih][$gen_terpilih] 	= $array[$individu_terpilih][0];
					$array[$individu_terpilih][0] = $temp;
				}
				### Script untuk proses debugging ===> Sesudah di Swap ###
				#echo "<br>";
				#echo ($gen_terpilih!=$panjang_gen_individu-1)? $array[$individu_terpilih][$gen_terpilih]." <==> ".$array[$individu_terpilih][$gen_terpilih+1]
				#		: $array[$individu_terpilih][$gen_terpilih]."<==>".$array[$individu_terpilih][0];
				
				return $array;
			}
		}

		# Mengambil salah satu solusi terbaik dari populasi
		function tampilkan_solusi($array, $fitness){
			$fitness_sum = $this->fitness_sum($fitness);
			arsort($fitness_sum);

			return $array[key($fitness_sum)];
		}

		# Mengecek solusi terbaik dari suatu populasi
		function cek_solusi_terbaik($fitness){			
			$fitness_sum 	= $this->fitness_sum($fitness);
			
			if (in_array(1, $fitness_sum)) {
				return true;
			} else {
				return false;		
			}
		}

}

/* End of file generate.php */
/* Location: ./application/controllers/generate.php */