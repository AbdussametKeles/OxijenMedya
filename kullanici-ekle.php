<?php include "header.php" ?>
<div class="container" style="margin-top: 50px";>
	<form method="POST">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="ad">Ad</label>
				<input type="text" class="form-control" id="ad" name="ad" >
			</div>
			<div class="form-group col-md-6">
				<label for="soyad">Soyad</label>
				<input type="text" class="form-control" id="soyad" name="soyad">
			</div>
		</div>
		<div class="form-group">
			<label for="tc">TC Kimlik Numarası</label>
			<input type="text" class="form-control" id="tc" name="tc">
		</div>
		<div class="form-group">
			<label for="telefon">Telefon</label>
			<input type="text" class="form-control" id="telefon" name="telefon">
		</div>

		<div class="form-group">
			<label for="sgkNo">SGK Numarası</label>
			<input type="text" class="form-control" id="sgkNo" name="sgkNo">
		</div>
		<div class="form-group">
			<label for="adres">Adres</label>
			<textarea class="form-control" id="adres" name="adres"></textarea>
		</div>


		<button type="submit" name="kullaniciKaydet" class="btn btn-primary">Kaydet</button>
	</form>

</div>

</body>
</html>
<?php 
include 'database.php';

if(isset($_POST['kullaniciKaydet'])){

	$query = "INSERT INTO kullanici (ad,soyad,tc,adres,telefon,sgkNo) values (?,?,?,?,?,?)";

	$stmt = $db->prepare($query);
	$stmt->bindParam(1,htmlspecialchars(strip_tags($_POST['ad'])));
	$stmt->bindParam(2,htmlspecialchars(strip_tags($_POST['soyad'])));
	$stmt->bindParam(3,htmlspecialchars(strip_tags($_POST['tc'])));	
	$stmt->bindParam(4,htmlspecialchars(strip_tags($_POST['adres'])));
	$stmt->bindParam(5,htmlspecialchars(strip_tags($_POST['telefon'])));
	$stmt->bindParam(6,htmlspecialchars(strip_tags($_POST['sgkNo'])));
	try{
		$stmt->execute();
		echo "<h2>Kayıt Başarıyla Eklendi</h2>";
	}catch (PDOException $e){
		echo $e->getMessage();
	}


}



?>