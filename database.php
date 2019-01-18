<?php 

$host = "localhost";
$username =  "root";
$password = "01233210";
$db_name = "oxijendb";
$db = null;

try{

	$db = new PDO("mysql:host=".$host.";dbname=".$db_name,$username,$password);
	$db->exec("set name utf8");
}catch(PDOException $e){

	echo "Veritabanı bağlantı  hatası".$e->getMessage();


}catch(PDOException $e){
	echo $e->getMessage();
}

?>