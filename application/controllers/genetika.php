<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Genetika extends CI_Controller {
	
	var $id_tahun_ajaran;

	var $generasi;
	# pc : Probability CrossOver | pm : Probability Mutation
	var $pc, $pm; 

	var $ruang, $sesi, $hari;
	var $dosen, $ajar, $kesediaan;

	var $look_ajar_dosen;

	function __construct(){
		parent::__construct();

		$this->load->model('mymodel');
		#$this->load->helper('form');
	}
	
	public function index()
	{
		set_time_limit(0);
		$this->proses_core_generate();
	}

	function regenerate($id){
		$this->proses_core_generate($id);
	}

	function proses_core_generate($ta = null){

		$this->pc = 0.8;
		$this->pm = 0.02;

		if ($_POST){
			$data['id_tahun_ajaran'] 	= $this->input->post('id_tahun_ajaran');			
		} else {
			$data['id_tahun_ajaran'] 	= $ta;						
		}

		$arr_kesediaan 				= $this->get_data_kesediaan($data['id_tahun_ajaran']);
		
		#$this->array_to_table($arr_kesediaan);		

		$this->sesi 		= $this->mymodel->all('sesi');
		$this->ruang		= $this->mymodel->all('ruang');
		$this->hari			= $this->mymodel->all('hari');
		# Panjang Gen : ( Jumlah Sesi x Jumlah Ruang) x Jumlah Hari
		$panjang_gen 		= ($this->sesi->num_rows() * $this->ruang->num_rows()) * $this->hari->num_rows();

		$result_ajar		= $this->mymodel->get_where('ajar',array('id_tahun_ajaran'=>$data['id_tahun_ajaran']));
		$result_ajar_kosong	= $this->mymodel->get_where('ajar',array('id_tahun_ajaran'=>$data['id_tahun_ajaran'],'id_dosen'=>'1'))->result_array();

		$selisih = ($panjang_gen - $result_ajar->num_rows());
		
		#if ($selisih > 0) $this->add_ajar_kosong($selisih);
		
		$ajar_kosong 	= array_column($result_ajar_kosong,'id_ajar');		
		$ajar 			= array_column($result_ajar->result_array(),'id_ajar');
		$dosen			= array_column($result_ajar->result_array(),'id_dosen');
		$mata_kuliah	= array_column($result_ajar->result_array(),'id_mata_kuliah');

		# Data Ajar = Keys | Data Dosen = Value
		# Array yang digunakan untuk melihat data
		$this->look_ajar_dosen= array_combine($ajar, $dosen);
		
		$solusi 		= $this->proses_testing($ajar, 20, 5, $arr_kesediaan, $ajar_kosong,$this->look_ajar_dosen);


		$fitness 		= $this->fitness_new(array($solusi), $arr_kesediaan, $ajar_kosong,$this->look_ajar_dosen);
		$solusi_fitness = array();
		foreach ($solusi as $key => $value) {
			$solusi_fitness[] = array($solusi[$key], $fitness[0][$key]);
		}

		$solusi_fitness = $this->get_detail_ajar($solusi_fitness);
		$solusi_fitness = array_chunk($solusi_fitness, count($solusi_fitness)/$this->hari->num_rows());
		foreach ($solusi_fitness as $key => $value) {
			$solusi_fitness[$key] = array_chunk($solusi_fitness[$key], count($solusi_fitness[$key])/$this->sesi->num_rows());
		}
		#$this->view($solusi_fitness, $data['id_tahun_ajaran']);
		
	}



	#-----------------------------------PROSES------------------------------------------------#

		# Pemrosesan Algoritma Genetika Testing
		function proses_testing($data, $iterasi, $individu, $arr_kesediaan, $arr_kesediaan_kosong, $look_dosen){

			#echo "<h2>Populasi Awal</h2>";
			$populasi_awal = $this->buat_populasi_awal($data, $individu);

			$populasi = $populasi_awal;
			$fitness  = $this->fitness_new($populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

			#$this->array_to_table($fitness);
			#die();

			for ($i=0; $i < $iterasi; $i++) { 
				#echo "<H2>Iterasi ".($i+1)."</h2>";
				
				if ($this->cek_solusi_terbaik($fitness)) {
				#	echo "<h2>Solusi terbaik ditemukan pada iterasi ke ".($i+1)."</h2>";
					break;
				}

				$parent 		= $this->seleksi_rangking($populasi, $fitness);
				$offspring 		= $this->order_crossover($parent);

				$fitness 		= $this->fitness_new($offspring, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

				#foreach ($offspring as $key => $value) {
				#	$this->list_fitness($offspring[$key], $fitness[$key]);
				#}

				$mutasi 		= $this->mutasi($offspring, $individu);
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

				$populasi 		= $this->update_generasi($populasi,$individu);
				$fitness 		= $this->fitness_new($populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look_dosen);

				foreach ($populasi as $key => $value) {
				#	$this->list_fitness($populasi[$key], $fitness[$key]);
					$this->list_only_fitness($fitness[$key]);
				}

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

		function fitness_new($array_populasi, $arr_kesediaan, $arr_kesediaan_kosong,$look){
			$array_fitness = array();

			# loop untuk setiap individu di dalam populasi
			foreach ($array_populasi as $k_individu=>$individu) {

				$counter 		= 0;
				$counter_hari 	= 0;
				$cek 			= 0;
				$nil_kesediaan 	= 0;
				$nil_bentrok 	= 0;
				$nil_jam_malam 	= 0;
				$nil_jam_siang 		= 0;
				$nil_bentrok_sholat_jumat 	= 0;
				
				$ar_cek_bentrok = array();
				# loop untuk setiap gen di dalam individu
				foreach ($individu as $k_gen => $gen) {
					

					#### jumlah ruang * jumlah sesi perhari 
					$hari = $counter_hari;
					# Jika pointer Key pada posisi % (Jumlah Ruang * Jumlah Sesi) == 0 | Hari berubah
					if ($k_gen % ($this->ruang->num_rows() * $this->sesi->num_rows())==0){
						$hari = ++$counter_hari;
						$counter = 0;
					}

					#### Cek Sesi berdasarkan 1 sesi terdiri dari (n) ruang 
					#### n = nilai modulus (jumlah ruang yang tersedia)
					$sesi = $counter;
					# Jika pointer Key pada posisi % (Jumlah Ruang) == 0 | Sesi berubah
					if ($k_gen % $this->ruang->num_rows()==0){
						$sesi = ++$counter;
						$ar_cek_bentrok = array();
						#echo "<br>";
					}

					# ID_AJAR diambil berdasarkan ID_DOSEN pengampu mata kuliah
					$id_dosen  = $look[$gen]; 
					#  Filter Kesediaan berdasarkan : HARI & SESI
					$kesediaan = $arr_kesediaan[$hari][$sesi];

					
					# CEK KESEDIAAN
					#### cek kesediaan dosen persesi
					#### Data Kosong = Dosen Tidak Bersedia (nilai = 10) | Data Ada = Dosen bersedia (nilai = 0)
					$nil_kesediaan = in_array($id_dosen, $kesediaan)?'0': (in_array($gen, $arr_kesediaan_kosong) ? '0' : '10' );

					# CEK BENTROK MATAKULIAH & DOSEN
					$ar_cek_bentrok[] = $id_dosen;
					$nil_bentrok = 0;
					$nil_bentrok_sholat_jumat = 0;
					$nil_jam_malam = 0;
					$nil_jam_siang = 0;

					if ($id_dosen != '1'){

						# Hitung jumlah setiap nilai di dalam Array
						$count_dosen = array_count_values($ar_cek_bentrok);
						# Ambil data jumlah dosen berdasarkan ID_DOSEN 
						$count_dosen_sesi = $count_dosen[$id_dosen];
						if ($count_dosen_sesi > 1){
							# Jika bentrok berikan nilai pinalty 5
							$nil_bentrok = 8;
						}
						
						# CEK BENTROK SHOLAT JUMAT
						##### Hari Jum'at (5) | Sesi 6 (10:300-11:00) | Sesi 7 (11:00-11:30) | Sesi 8 (11:30-12:00)
						# CEK JAM SIANG
						##### Sesi 7 (11:00-11:30) | Sesi 8 (11:30-12:00)
						if ($hari == 5) {
							if ($sesi == 6 || $sesi == 7 || $sesi == 8) {
								$nil_bentrok_sholat_jumat = 7;
							}
						} else {
							if ($sesi == 7 || $sesi == 8) {
								$nil_jam_siang = 7;
							}
						}
						
						# CEK SESI MALAM
						##### Sesi 12 (20:00 - 20:30)
						if ($sesi > 12) {
							$nil_jam_malam = 9;
						}

						# CEK BENTROK RUANG AJAR
						$posisi_jadwal = $k_gen;
						#if (){

						#}

					}

					# unremark to debug cek bentrok
					### $this->list_gen($ar_cek_bentrok);
					### echo $nil_bentrok.PHP_EOL;
					#echo $id_dosen.PHP_EOL;
					$array_fitness[$k_individu][] = $nil_kesediaan + $nil_bentrok + $nil_jam_siang + $nil_bentrok_sholat_jumat + $nil_jam_malam;
				}	 
				
				#echo "<pre>";print_r($individu);echo "</pre>";
				#echo "<pre>";print_r($array_fitness);echo "</pre>";
				#die();

			}

			return $array_fitness;	
		}

		function view($solusi_fitness, $id_tahun_ajaran){

			#$data['sesi_waktu'] = $this->mymodel->get_field_distinct('sesi','jam_awal,jam_akhir')->result_array();
			$data['data_sesi'] 		= $this->sesi->result_array();
			$data['data_ruang'] 	= $this->ruang->result_array();
			$data['data_hari'] 		= $this->hari->result_array();
			$data['id_tahun_ajaran']= $id_tahun_ajaran;

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
			
			#$sql = "select id_hari,id_sesi,id_dosen from kesediaan where id_tahun_ajaran = '".$ta."' order by id_hari ,id_sesi";
			$sql_hari = "select distinct id_hari from hari";
			
			$result_hari = $this->mymodel->query($sql_hari)->result_array();
			$hari 		 = array_column($result_hari,"id_hari");


			foreach ($hari as $k_hari => $v_hari) {

				$sql_sesi = "select distinct id_sesi from sesi";
				$result_sesi = $this->mymodel->query($sql_sesi)->result_array();
				$sesi 	  = array_column($result_sesi, "id_sesi");

				foreach ($sesi as $k_sesi => $v_sesi) {
					$array_parameter = array(
						'id_hari' => $v_hari,
						'id_sesi' => $v_sesi,
						'id_tahun_ajaran' => '1'
					);

					$result_dosen = $this->mymodel->get_where_field('kesediaan','id_dosen',$array_parameter)->result_array();
					$arr_kesediaan[$v_hari][$v_sesi] = array_column($result_dosen, "id_dosen");
				}
			
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

	#------------------------------------POPULASI---------------------------------------#
		# Membangkitkan Populasi Awal
		function populasi($array, $loop){
			$pop_array = array();
			for ($i=0; $i < $loop; $i++) { 
				shuffle($array);
				array_push($pop_array, $array);
			}
			return $pop_array;
		}

		# Pembangkitan Populasi dengan memperhatikan solusi
		function buat_populasi_awal($array, $loop){
			
			$look = $this->look_ajar_dosen;


			// print_r($kosong);
			for ($i=0; $i < $loop; $i++) { 

				# memisahkan antara kode ajar dengan kode ajar kosong
				foreach ($array as $key => $value) {
					if ($look[$value] == 1) {
						$kosong[] 	= $value;
					} else {
						$ajar[] 	= $value;
					}
				}

				$counter_sesi	= 0;
				$counter_hari 	= 0;
				# mulai menyusun gen ke dalam individu dengan memperhatikan solusi
				foreach ($array as $k_gen => $value) {
					
					#### jumlah ruang * jumlah sesi perhari 
					$hari = $counter_hari;
					# Jika pointer Key pada posisi % (Jumlah Ruang * Jumlah Sesi) == 0 | Hari berubah
					if ($k_gen % ($this->ruang->num_rows() * $this->sesi->num_rows())==0){
						$hari = ++$counter_hari;
						$counter_sesi = 0;
					}

					#### Cek Sesi berdasarkan 1 sesi terdiri dari (n) ruang 
					#### n = nilai modulus (jumlah ruang yang tersedia)
					$sesi = $counter_sesi;
					# Jika pointer Key pada posisi % (Jumlah Ruang) == 0 | Sesi berubah
					if ($k_gen % $this->ruang->num_rows()==0){
						$sesi = ++$counter_sesi;
						#echo "<br>";
					}

					# Mengisi populasi 
					# Jika berada pada hari Jumat (5) && sesi 6 || 7 || 8 : Ambil data dari array kosong
					# Jika berada pada sesi 7 || 8 	: Ambil data dari array kosong
					# Jika berada pada sesi > 12 	: Ambil data dari array kosong
					# hapus data di array kosong yang sudah ada di array Populasi (pop)
					if ($hari == 5) {
						if ($sesi == 6 || $sesi == 7 || $sesi == 8) {
							$pop[$i][] = $kosong[array_rand($kosong)];
							$kosong = array_diff($kosong, $pop[$i]);
						} elseif ($sesi > 12) {
							$pop[$i][] = $kosong[array_rand($kosong)];
							$kosong = array_diff($kosong, $pop[$i]);
						} else if ($sesi == 1 || $sesi == 4 || $sesi == 9 || $sesi == 12) {
							if (count($ajar) == 0){
								$pop[$i][] = $kosong[array_rand($kosong)];
								$kosong = array_diff($kosong, $pop[$i]);							
							} else {
								$pop[$i][] = $ajar[array_rand($ajar)];
								$ajar = array_diff($ajar, $pop[$i]);							
							}
						}  else {
							$pop[$i][] = $kosong[array_rand($kosong)];
							$kosong = array_diff($kosong, $pop[$i]);
						}
					} else {
						if ($sesi == 7 || $sesi == 8) {
							$pop[$i][] = $kosong[array_rand($kosong)];
							$kosong = array_diff($kosong, $pop[$i]);
						} elseif ($sesi > 12) {
							$pop[$i][] = $kosong[array_rand($kosong)];
							$kosong = array_diff($kosong, $pop[$i]);
						} else if ($sesi == 1 || $sesi == 4 || $sesi == 9 || $sesi == 12) {
							if (count($ajar) == 0){
								$pop[$i][] = $kosong[array_rand($kosong)];
								$kosong = array_diff($kosong, $pop[$i]);							
							} else {
								$pop[$i][] = $ajar[array_rand($ajar)];
								$ajar = array_diff($ajar, $pop[$i]);							
							}
						}  else {
							$pop[$i][] = $kosong[array_rand($kosong)];
							$kosong = array_diff($kosong, $pop[$i]);
						}
					}

				}
			}


			// echo "<pre>";
			// print_r($pop);
			// echo "</pre>";

			// die();
			return $pop;
		}


	#--------------------------------------------------------------------------------------------------#
		# cetak array 1 atau 2 Dimensi ke dalam bentuk table 
		function array_to_table($array){
			#echo "<pre>";print_r($array);echo "</pre>";
				foreach ($array as $k => $v) {
					echo "<table>";
					echo "<caption>".$k."</caption>";
						if(!is_array($v)){							
							echo "<tr>";
								echo "<td>";
									echo $v;
								echo "</td>";
							echo "</tr>";	
						} else {
							foreach ($v as $key => $value) {						
								echo "<tr>";
									echo "<td style='color:red'>".$key."</td>";
									if (!is_array($value)) {							
										echo "<td>";
											echo $value;
										echo "</td>";
									} else {		
										foreach ($value as $k2 => $v2) {						
										echo "<td>";
											echo $v2;
										echo "</td>";
										}
									}
								echo "</tr>";
							}
						}

					echo "</table>";
				}
		}


		function show_list_gen_no_table($ary){
			foreach ($ary as $key => $value) {
				echo $value.PHP_EOL;
			}
		}

		# Cetak Individu ke layar beserta nilai fitness nya
		function list_gen($ary){
			echo "<table border='1' cellspacing='1'><tr>";
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

		function list_only_fitness($ary_fitness){
			echo "<table border='0'><tr>";
			echo "<td>==> ".array_sum($ary_fitness)."</td>";
			echo "</tr></table>";
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
			$t1 = 56;
			$t2 = 112;

			#test 1
			#$t1 = rand(5, count($array[0])/2);
			#$t2 = rand(count($array[0])/2, count($array[0])-1);
			
			#test 2
			#$t1 = rand(5, 55);
			#$t2 = rand(56, 112);

			#test 3
			$t1 = rand(0,count($array[0])-8);	
			$t2 = $t1 + 7;


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
		function seleksi_rangking_new($populasi, $fitness){

			foreach ($fitness as $key => $value) {
				echo array_sum($value).PHP_EOL;
			}
	
			foreach ($fitness as $key => $value) {
				$sum[] = round(1/(1+array_sum($value)),3);
			}
			$total_sum = array_sum($sum);

			// foreach ($sum as $key => $value) {
			// 	$sum[$key] = ($value/$total_sum);
			// }

			echo "<pre>";
				print_r($total_sum);
				echo "<br>";
				print_r($sum);
			echo "</pre>";

			$nilai_kumulatif = 0;
			foreach ($sum as $key => $value) {
				$nilai_kumulatif += $value;
				$sum[$key] = $nilai_kumulatif;
			}

			echo "<pre>";
				print_r($sum);
			echo "</pre>";

			die();

			// $crossover_rate = (80/100)*count($populasi);
			// $fitness_sum 	= $this->fitness_sum($fitness);
			// arsort($fitness_sum);

			// $fitness_sum_key= array_keys($fitness_sum);
			// $parent_terpilih= array_slice($fitness_sum, 0, $crossover_rate);

			// foreach ($parent_terpilih as $key => $value) {
			// 	$parent[] = $populasi[$fitness_sum_key[$key]];
			// }

			// return $parent;



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
		function mutasi($array, $jumlah_populasi){
			#echo "<h2>Mutasi</h2>";
			#$panjang_gen    = count($array)*count($array[0]);
			$panjang_gen    = ($this->hari->num_rows() * $this->sesi->num_rows() *$this->ruang->num_rows())*$jumlah_populasi;
			$mutation_rate 	= round((2/100)*$panjang_gen);

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

/* End of file genetika.php */
/* Location: ./application/controllers/genetika.php */