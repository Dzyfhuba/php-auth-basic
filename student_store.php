<?php

include_once "connect.php";

$fullname = $_POST['fullname'];
$class = $_POST['class'];
$age = $_POST['age'];
// print_r($fullname);

// $password = $data->password;
$query = "INSERT INTO students (fullname, class, age) VALUES ('{$fullname}','{$class}','$age')";
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec($query);


header('Location: /');