<?php
include 'db_connect.php';
$stmt = $conn->query("SELECT id, titulo, categorias FROM viagens LIMIT 10");
$viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($viagens);
echo "</pre>";
