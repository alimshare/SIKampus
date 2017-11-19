<?php 
	//activate worksheet number 1
	$this->excel->setActiveSheetIndex(0);

	//name the worksheet
	$this->excel->getActiveSheet()->setTitle('Data Mahasiswa');

	//set cell A1 content with some text
	$this->excel->getActiveSheet()->setCellValue('A1', 'Daftar Mahasiswa STMIK MAHAKARYA');

	//change the font size
	$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);

	//make the font become bold
	$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

	//merge cell A1 until D1
	$this->excel->getActiveSheet()->mergeCells('A1:D1');

	//set aligment to center for that merged cell (A1 to D1)
	$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$filename='daftar_mahasiswa.xls'; //save our workbook as this file name

	# Header Data
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "NIM"); 
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Nama");
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "Nomor Telephon");
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "Email");

	$header_range = 'A3:D3';
	$this->excel->getActiveSheet()->getStyle($header_range)
		->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');

	# Content Data
	$row = 4;
	$no = 1;
	foreach ($data as $key => $value) {
		$this->excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $row, $value['nim']); 
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value['nama']); 
		$this->excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2, $row, $value['no_telp']); 
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $value['email']);

		$no++;
		$row++;
	}

	# set Column Width
	for ($col = ord('a'); $col <= ord('g'); $col++)
	{
	    $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
	}


	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	            
	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	//if you want to save it as .XLSX Excel 2007 format
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
	//force user to download the Excel file without writing it to server's HD
	$objWriter->save('php://output');

?>