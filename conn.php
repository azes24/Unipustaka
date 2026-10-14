<?php  
define("HOST", "localhost");
define('USER', 'root');
define('PASS','');
define("DBNAME", "library");

const DSN = "mysql:host=" . HOST . ";dbname=" . DBNAME;

const OPTIONS = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
	$DBH = new PDO(DSN,USER,PASS,OPTIONS);
} catch (PDOException $err) {
	echo "Koneksi gagal: " . $err ->getMessage();
}

 ?>