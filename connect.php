<?php

// load .env
$env = parse_ini_file('.env');

session_start();

$servername = $env['MYSQL_HOST'];
$username = $env['MYSQL_USER'];
$password = $env['MYSQL_PASSWORD'];
$database = $env['MYSQL_DATABASE'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}