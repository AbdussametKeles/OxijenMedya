<?php include "header.php";
session_start(); ?>
	<div class="container" style="margin-top: 50px";>
		<form class="form" method="POST">
			<div class="form-group">
				<div class="form-group">
					<label for="baslangicTarihi">Başlangıç Tarihi</label>
					<input type="date" id="baslangicTarihi" name="baslangicTarihi">
				</div>
				<div class="form-group">
					<label for="bitisTarihi">Bitiş Tarihi</label>
					<input type="date" id="bitisTarihi" name="bitisTarihi">
				</div>
			</div>
			<input class ="btn btn-primary" type="submit" name="rezervasyonListele" value="Rezervasyonları Listele">
		</form>

		<div class="table-responsive">
			<table class="table table-striped">

				<?php 
				if(isset($_POST['rezervasyonListele'])){
					$output ='<h6>'.$_POST['baslangicTarihi'].' - '.$_POST['bitisTarihi'].'</h6>
					<table border ="1">';
					$query = "select id as 'alanid',ad as 'alanadi' from alan";
					$stmt = $db->prepare($query);
					try{

						$stmt->execute();

						?>
						<thead>
							<tr>
								<th>Haftalık Pano Programı</th>
							</tr>
						</thead>
						<tbody>
							<?php 

							while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						//alan başlıklarını listeliyor.
								extract($row);

								?>
								<tr>
									<th><?php echo $alanadi ?></th>

									<?php 
									$output.= '
									<tr>
									<th>'.$alanadi.'</th>';
								//panoları alanlara göre bölüyor 
									$ikinciquery = "select id as 'panoid' from pano where alanID=?";
									$ikincistmt = $db->prepare($ikinciquery);
									$ikincistmt->bindParam(1,$alanid);
									try{

										$ikincistmt->execute();
										while($ikincirow = $ikincistmt->fetch(PDO::FETCH_ASSOC)){
											extract($ikincirow);

											?>
											<td>
												<?php 
											//bu panoda eğer rezervasyon var ise firma adını yazacak yoksa boş yazacak
												$ucuncusorgu = "select rezervasyon.id as 'rezervasyonid',rezervasyon.firmaID,firma.ad as 'firmaAdi' from pano inner join kiralama on pano.id = kiralama.panoID inner join rezervasyon on kiralama.rezervasyonID = rezervasyon.id inner join firma on firma.id = rezervasyon.firmaID where pano.id = ? and ((rezervasyon.baslangicTarihi between '".$_POST['baslangicTarihi']."' and '".$_POST['bitisTarihi']."') or (rezervasyon.bitisTarihi  between '".$_POST['baslangicTarihi']."' and '".$_POST['bitisTarihi']."')
												or ('".$_POST[baslangicTarihi]."' between rezervasyon.baslangicTarihi and rezervasyon.bitisTarihi) or ('".$_POST[bitisTarihi]."' between rezervasyon.baslangicTarihi and rezervasyon.bitisTarihi)) LIMIT 1";

												$ucuncustmt = $db->prepare($ucuncusorgu);
												$ucuncustmt ->bindParam(1,$panoid);



												try{
													$ucuncustmt->execute();

											if($ucuncustmt->rowCount() >0){//eğer içinde bulunduğumuz pano daha önceden rezerve edilmişse
												while($ucuncurow = $ucuncustmt->fetch(PDO::FETCH_ASSOC)){
													$output .='<td width="41">'.$ucuncurow['firmaAdi'].'</td>';

													echo $ucuncurow['firmaAdi'];

												}
											}else{
												$output = $output.'<td width="41">Boş</td>';
												echo "Boş";
											}
										}catch(PDOException $e){
											echo $e->getMessage();
										}
										
										

										?>
									</td>
									<?php 

								}
								$output = $output.'</tr>';
								

							}catch(PDOException $e){
								echo $e->getMessage();
							}

							?>



						</tr>
						<?php
					}

				}catch(PDOException $e){
					echo $e->getMessage();
				} 
				$output.='</table>';
				$_SESSION['veri'] = $output;

				
			}?>	

		</tbody>
	</table>

</div>
<form method="POST">
	<input type="submit" name="generate_pdf" value="PDF oluştur">
</form>
</div>	

</body>
</html>
<?php if(isset($_POST['generate_pdf'])){
	date_default_timezone_set("Turkey");
	require_once "libs/tcpdf.php";
	$obj_pdf = new TCPDF('P',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
	$obj_pdf ->SetCreator(PDF_CREATOR);
	$obj_pdf->SetTitle("Haftalık Alan Listesi");
	$obj_pdf->SetHeaderData('','',PDF_HEADER_TITLE,PDF_HEADER_STRING);
	$obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
	$obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
	$obj_pdf->SetDefaultMonospacedFont('helvetica');
	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	$obj_pdf->SetMargins(PDF_MARGIN_LEFT,'10',PDF_MARGIN_RIGHT);
	$obj_pdf->setPrintHeader(false);
	$obj_pdf->setPrintFooter(false);

	$obj_pdf->SetAutoPageBreak(TRUE,10);

	//$fontname = $pdf->addTTFfont(‘../libs/fonts/bluehighway.ttf’, ‘TrueTypeUnicode’, “, 32);


	$obj_pdf->SetFont('dejavusans','',11);
	
	$obj_pdf->AddPage('L', array('format' => 'A4', 'Rotate' => 90));

	$content = '';
	$content.= '

	<h4>Haftalık Alan Listesi</h4>

	';
	$content.= $_SESSION['veri'];

	$obj_pdf->writeHTML($content);
	ob_end_clean();
	$obj_pdf->Output('file'.date("h:i:sa").'.pdf','I');



} ?>