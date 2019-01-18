<?php include "header.php";?>
<div class="container" style="margin-top: 50px";>
	<form method="POST">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="ad">Firma Adı</label>
				<input type="text" class="form-control" id="ad" name="ad" >
			</div>
			<div class="form-group col-md-6">
				<label for="vergiNo">Vergi No</label>
				<input type="text" class="form-control" id="vergiNo" name="vergiNo">
			</div>
		</div>
		<div class="form-group">
			<label for="telefon">Telefon</label>
			<input type="text" class="form-control" id="telefon" name="telefon">
		</div>
		<div class="form-group">
			<label for="adres">Adres</label>
			<input type="text" class="form-control" id="adres" name="adres">
		</div>

		<div class="form-group">
			<label for="aciklama">Açıklama</label>
			<input type="text" class="form-control" id="aciklama" name="aciklama">
		</div>

		<button type="submit" name="firmaKaydet" class="btn btn-primary">Kaydet</button>
	</form>

</div>

</body>
</html>
<?php 
include 'database.php';

if(isset($_POST['firmaKaydet'])){

	$query = "INSERT INTO firma (ad,telefon,adres,vergiNo,aciklama) values (?,?,?,?,?)";

	$stmt = $db->prepare($query);
	$stmt->bindParam(1,htmlspecialchars(strip_tags($_POST['ad'])));
	$stmt->bindParam(2,htmlspecialchars(strip_tags($_POST['telefon'])));
	$stmt->bindParam(3,htmlspecialchars(strip_tags($_POST['adres'])));	
	$stmt->bindParam(4,htmlspecialchars(strip_tags($_POST['vergiNo'])));
	$stmt->bindParam(5,htmlspecialchars(strip_tags($_POST['aciklama'])));
	try{
		$stmt->execute();
		echo "<h2>Kayıt Başarıyla Eklendi</h2>";
	}catch (PDOException $e){
		echo $e->getMessage();
	}


}



?>