<?php 
include "header.php";?>
<div class="container">
	<table class="table table-light">
		<tr>
			<th>Pano Adı</th>
			<th>Pano Sayısı</th>
		</tr>
		<?php

		$alanquery = "select * from alan";
		$alanstmt = $db->prepare($alanquery);
		try{

			$alanstmt->execute();
			while($row= $alanstmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);?>
				<tr>
					<th><?php echo $ad; ?></th>

					<?php 

					$panoquery = "select count(alanID) as sayi,turID from pano where alanID = ?";

					$panostmt = $db->prepare($panoquery);
					$panostmt->bindParam(1,$id);
					try{
						$panostmt->execute();
						while ($panorow =$panostmt->fetch(PDO::FETCH_ASSOC)) {
							extract($panorow);
							?>

							<td><?php echo $sayi; ?></td>


							<?php
						}


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


		?>
	</table>
</div>
</body>