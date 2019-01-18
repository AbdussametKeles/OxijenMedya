
<?php include 'database.php';


if(isset($_POST['rezervasyonKaydet'])){

	
	$idArray = explode(",",$_POST['idler']);// ',' e göre stringi parçalıyor ve diziye atıyor.


	//kiralama tablosuna uygun veri girişi
	$randomFirma =rand(0,100);
	$query = "INSERT INTO rezervasyon (firmaID,personelID,baslangicTarihi,bitisTarihi,aciklama) VALUES (?,?,?,?,?)";
	$stmt = $db->prepare ($query);
	$stmt->bindParam(1,htmlspecialchars(strip_tags($_POST['firmaID'])));
	$stmt->bindParam(2,htmlspecialchars(strip_tags($_POST['personelID'])));
	$stmt->bindParam(3,htmlspecialchars(strip_tags($_POST['secilenBaslangicTarihi'])));
	$stmt->bindParam(4,htmlspecialchars(strip_tags($_POST['secilenBitisTarihi'])));
	$stmt->bindParam(5,htmlspecialchars(strip_tags($_POST['aciklama'])));

	try {
		$stmt->execute();
		$last_id = $db->lastInsertId();
		
	} catch (PDOException $e){
		echo $e->getMessage();
	}
	$query = "INSERT INTO kiralama (rezervasyonID,panoID) Values";
	foreach ($idArray as $id) {
		$query = $query."(".$last_id.",".$id."),";
	}
	//tüm value değerlerini tek query ile girecegiz (randevuid,panoid) şeklinde
	$query = rtrim($query,",");//enson eklenen virgülü siliyor.

	$stmt = $db->prepare ($query);
	try {
		$stmt->execute();
	} catch (PDOException $e){
		echo $e->getMessage();
	}


}
include "header.php";
?>

<div class="container" style="margin-top: 50px; margin-bottom: 20px;">
	<form method="POST">
		<p>Başlangıç tarihi Seçiniz</p>
		<input type="date" id="bosBaslangic" name="baslangicTarihi">
		<p>Bitiş tarihi seçiniz</p>
		<input type="date" id="bosBitis" name="bitisTarihi"><br><br><br>	
		<input type="submit" name="bosAlanlariListele" value="Boş Alanları Listele"><br><br>	
	</form>



	<?php if($_POST['bosAlanlariListele']){

		$query = "select * from kiralama inner join rezervasyon on kiralama.rezervasyonID = rezervasyon.id where (rezervasyon.baslangicTarihi between '".$_POST['baslangicTarihi']."' and '".$_POST['bitisTarihi']."') or (rezervasyon.bitisTarihi  between '".$_POST['baslangicTarihi']."' and '".$_POST['bitisTarihi']."')
		or ('".$_POST[baslangicTarihi]."' between rezervasyon.baslangicTarihi and rezervasyon.bitisTarihi) or ('".$_POST[bitisTarihi]."' between rezervasyon.baslangicTarihi and rezervasyon.bitisTarihi)";

		$stmt = $db->prepare($query);
		$stmt->execute();
		$alanIDlistesi = array(0);

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			extract($row);
			array_push($alanIDlistesi, $panoID);

		}
		$query = 'SELECT * 
		FROM alan inner join pano on alan.id = pano.alanID
		WHERE pano.id NOT IN (' . implode(',', array_map('intval', $alanIDlistesi)) . ')';
		//bu idler dışındaki kayıtları getirecek.

		$stmt = $db->prepare($query);
		$stmt->execute();
		?>



		<form method="POST" class="col-md-12 form">
			<div class="form-group">
				<label for="firma">Firma:</label>
				<select id="firma" class="form-control" name="firmaID">
					<?php 
					$personelSorgu = "select * from firma";
					$personelStmt = $db->prepare($personelSorgu);
					try{
						$personelStmt->execute();
						while($row = $personelStmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							?>
							<option value="<?php echo $id;?>"><?php echo $ad?></option>
							<?php
						}
					}catch(PDOException $e){
						echo $e->getMessage();
					}


					?>
				</select>
			</div>
			<div class="form-group">
				<label for="personel">Pazarlamacı:</label>
				<select id="personel" class="form-control" name="personelID">
					<?php 
					$personelSorgu = "select * from kullanici";
					$personelStmt = $db->prepare($personelSorgu);
					try{
						$personelStmt->execute();
						while($row = $personelStmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);
							?>
							<option value="<?php echo $id;?>"><?php echo $ad.' '.$soyad; ?></option>
							<?php
						}
					}catch(PDOException $e){
						echo $e->getMessage();
					}


					?>
				</select>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<label for="bosSelect">Boş Alanların Listesi</label>
					<select class="col-md-12 form-control" id="bosSelect"  multiple="multiple" style="height: 200px;">	

						<?php while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
							extract($row);?>

							<option value="<?php echo $id; ?>"><?php echo $ad; ?></option>

						<?php }  ?>
					</select>
				</div>

				<div class="form-group col-md-6" id="secilenDiv">
					<label for="secilenSelect">Seçilen Alanların Listesi</label>
					<select class="form-control"  id="secilenSelect" multiple="multiple" style="height: 200px;">
					</select>
				</div>

			</div>
			<div class="form-group">
				<label for="aciklama">Açıklama:</label>
				<textarea class="form-control" id="aciklama" name="aciklama"></textarea>
			</div>

			
			<input type="text" id="idler" name="idler" style="visibility: hidden;">
			<input type="date" name="secilenBaslangicTarihi" value="<?php echo $_POST['baslangicTarihi']; ?>" style="visibility: hidden;" >
			<input type="date" name="secilenBitisTarihi" value="<?php echo $_POST['bitisTarihi']; ?>" style="visibility: hidden;">
			<input class="form-control btn btn-primary col-md-12 align-right" type="submit" name="rezervasyonKaydet" value="Kaydet" onclick="idleriTopla()">
		</form>
	</div>
<?php } ?>

<script type="text/javascript">

	$(document).ready(function(){

		$('#bosSelect').keypress(function(event){
				//enter veya space tuşu ile veriyi diğer selectliste aktaracak.
				if(event.which == 13 || event.which == 32){
					var value = $('#bosSelect option:selected');
					$('#bosSelect option:selected').remove();
					$('#secilenSelect').append("<option value="+value.val()+">"+value.text()+"</option>");
				}
			});

	});
	function idleriTopla(){


		var optionValues = [];

		$('#secilenSelect option').each(function() {
			optionValues.push($(this).val());
		});

		document.getElementById('idler').value = optionValues;

	}

</script>

</body>
</html>