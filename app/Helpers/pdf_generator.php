<?php

function pdf_generate($data="",$save,$lang,$name){
	require('fpdf/fpdf.php');
	require('fpdi/fpdi.php');
	if (!empty($data)) {
		$path_eng = base_path('app/helpers/eng_contract.pdf');
		$path_esp = base_path('app/helpers/esp_contract.pdf');
		header('Content-Type: text/html; charset=ISO-8859-1');
		$filename="/home/data/repornfuerza/".$name."-contract.pdf";
		$pdf = new fpdi();
		if ($lang=="ENG") {
			$pdf->setSourceFile($path_eng);
		}else{
			$pdf->setSourceFile($path_esp);
		}
		$tplIdx = $pdf->importPage(1, '/MediaBox');
		$pdf->addPage();
		$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

		$pdf->SetFont('Arial','',9);
		$pdf->SetTextColor(87, 35, 100);

		$pdf->SetXY(7, 33);
		$pdf->Write(1,$data['formReg']['last_name']." ".$data['formReg']['name']);

		$pdf->SetXY(7, 43);
		$pdf->Write(1,$data['formReg']['address']);

		$pdf->SetXY(7, 53);
		$pdf->Write(1,$data['formReg']['federal_entities']);
		
		$pdf->SetXY(85, 53);
		$pdf->Write(1,$data['formReg']['state']);

		$pdf->SetXY(110, 53);
		$pdf->Write(1,$data['formReg']['zip_code']);

		$pdf->SetXY(180, 53);
		$pdf->Write(1,$data['formReg']['birthdate']);

		$pdf->SetXY(7, 63);
		$pdf->Write(1,$data['formReg']['email']);		

		$pdf->SetXY(7, 73);
		$pdf->Write(1,$data['formReg']['phone_number']);
		$hoy = date("m-d-y");  
		$arr = explode('-', $hoy);
		$pdf->SetXY(162, 20);
		$pdf->Write(1,$arr[1]);
		$pdf->SetXY(178, 20);
		$pdf->Write(1,$arr[0]);
		$pdf->SetXY(194, 20);
		$pdf->Write(1,$arr[2]);

		$tplIdx2 = $pdf->importPage(2, '/MediaBox');
		$pdf->addPage();
		$pdf->useTemplate($tplIdx2, 0, 0, 0, 0, true); 
		
		$content = $pdf->Output('','S');
		$savePdf = savePdf($content,$data);
		
		if (empty($save)) {
			$pdf->Output();
		}
		return true;
	}else{
		return false;
	}
}

function savePdf($cont,$data){
	$pdf = base64_encode($cont);
	$size = strlen($cont);
	$mime = "application/pdf";
	if ($data['cierra_transaction']) {
		$name = $data['user_eo_number'].".pdf";
		DB::table('pdf_user')->insert(
	    	['eo_number' => $data['user_eo_number'], 'corbiz_transaction' => $data['corbiz_transaction'], 'pdf_file' => $pdf, 'size' => $size, 'mime' => $mime, 'pdf_name' => $name]
    	);	
	}else{
		$name = $data['corbiz_transaction'].".pdf";
		DB::table('pdf_user')->insert(
	    	['corbiz_transaction' => $data['corbiz_transaction'], 'pdf_file' => $pdf, 'size' => $size, 'mime' => $mime, 'pdf_name' => $name]
    	);
	}
	return true;

}