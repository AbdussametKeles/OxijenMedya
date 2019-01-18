<?php include 'header.php'; ?>
	<div class="container" style="margin-top: 50px";>
		
		<form method="POST">
			<div class="form-group">
				<label for="ad">Ad</label>
				<input type="text" class="form-control" id="ad" name="ad" >
			</div>
			<div class="form-group">
				<label for="turID">Tür</label>
				<select class="form-control" id="turID" name="turID">
					<?php 


					$query = "select * from tip";

					$stmt = $db->prepare($query);
					try{
						$stmt->execute();
					}catch(PDOException $e){
						echo $e->getMessage();
					}
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
						extract($row);
						?>
						<option value="<?php echo $id ?>"><?php echo $ad ?></option>
					<?php } ?>

				</select>
			</div>

			<div class="form-group">
				<label for="adet">Adet</label>
				<input type="number" class="form-control" id="adet" name="adet">
			</div>

			<div class="form-group">
				<label for="adres">Adres</label>
				<input type="text" class="form-control" id="adres" name="adres">
			</div>
			<div class="form-group">
				<label for="foto">Fotoğraf</label>
				<input type="file" class="form-control-file" id="foto" name="foto">
			</div>

			<button type="submit" name="alanKaydet" class="btn btn-primary">Kaydet</button>
		</form>




	</div>

</body>
</html>
<?php 


$query = "INSERT INTO alan (ad,foto,adres) values(?,?,?)";
$stmt=$db->prepare($query);
$stmt->bindParam(1,htmlspecialchars(strip_tags($_POST['ad'])));
$stmt->bindParam(2,htmlspecialchars(strip_tags($_POST['foto'])));	
$stmt->bindParam(3,htmlspecialchars(strip_tags($_POST['adres'])));

try{
	$stmt->execute();
	$last_id = $db->lastInsertId();
}catch(PDOException $e){
	echo $e->getMessage();
}

for($i=1;$i<=$_POST['adet'];$i++){

	$query = "INSERT INTO pano (alanID,turID) values (".$last_id.",".$_POST['turID'].")";

	$stmt=$db->prepare($query);

	try{
		$stmt->execute();

	}catch(PDOException $e){
		echo $e->getMessage();
	}

}
?>