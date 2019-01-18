<?php include "database.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Oxijen Reklam</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle ="dropdown" data-target ="dropdown_target" href="rezervasyonlar.php">Rezervasyon
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdown_target">
					<a class="dropdown-item" href="rezervasyonlar.php">Rezervasyonlar</a>
					<a class="dropdown-item" href="rezervasyon-ekle.php">Rezervasyon Ekle</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle ="dropdown" data-target ="dropdown_target" href="index.php">Pano
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdown_target">
					<a class="dropdown-item" href="index.php">Panolar</a>
					<a class="dropdown-item" href="reklamalani-ekle.php">Pano Ekle</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle ="dropdown" data-target ="dropdown_target" href="firmalar.php">Firma
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdown_target">
					<a class="dropdown-item" href="firmalar.php">Firmalar</a>
					<a class="dropdown-item" href="firma-ekle.php">Firma Ekle</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle ="dropdown" data-target ="dropdown_target" href="kullanicilar.php">Kullanıcı
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdown_target">
					<a class="dropdown-item" href="kullanicilar.php">Kullanıcılar</a>
					<a class="dropdown-item" href="kullanici-ekle.php">Kullanıcı Ekle</a>
				</div>
			</li>
		</ul>
	</nav>