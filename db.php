<?php
// db.php — Sambungan ke pangkalan data MySQL
$host   = "localhost";
$user   = "root";      // lalai XAMPP
$pass   = "";          // lalai XAMPP (kosong)
$dbname = "fashion_alumni";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Sambungan pangkalan data gagal: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
