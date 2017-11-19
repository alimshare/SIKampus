<?php
	session_start();
?>
<html>
<head>
	<title>STMIK Mahakarya</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url()."assets/css/dashboard.css"; ?>">

	<?php foreach ($css_files as $file): ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $file; ?>">
	<?php endforeach ?>
	<?php foreach ($js_files as $file): ?>
		<script type="text/javascript" src="<?php echo $file; ?>"></script>
	<?php endforeach ?>

</head>

	<body>
		<div class="menu list">
			<ul>
				<li><a href="<?php echo base_url('dashboard'); ?>">Home</a></li>
				<li><a href="">Master</a>
					<ul>
						<li><a href="<?php echo base_url('dashboard/dosen'); ?>">Dosen</a></li>
						<li><a href="<?php echo base_url('dashboard/matkul'); ?>">Mata Kuliah</a></li>
						<li><a href="<?php echo base_url('dashboard/tahun_ajaran'); ?>">Tahun Ajaran</a></li>
						<li><a href="">Jadwal</a></li>
					</ul>
				</li>
				<li><a href="">Proses</a></li>
			</ul>

			<ul class="kanan">
				<li><a href="<?php echo base_url('login/logout') ?>">Logout</a></li>
			</ul>
		</div>
		
		<div class="content" id="content">
			
			<?php echo $output; ?>

		</div>

		<div id="footer">
			<a href="">Help</a> | <a href="">FAQ</a>  | <a href="<?php echo base_url('login/logout') ?>">Logout</a>
		</div>
	</body>
</html>

