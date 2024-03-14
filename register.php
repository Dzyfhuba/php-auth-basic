<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  http_response_code(405);
  header('Content-Type: application/json');
  echo json_encode([
    'status' => 'error',
    'message' => 'Method not allowed',
  ]);
  exit();
}

include_once 'connect.php';
$json = file_get_contents('php://input');
$data = json_decode($json);
try {
  if ($data->password != $data->password_confirmation) {
    echo json_encode([
      'status' => 'error',
      'message' => 'password and password confirmation not same',
    ]);
    header('Content-Type: application/json');
    // status code 200 OK
    http_response_code(400);
    return;
  }

  $password = crypt($data->password, '12345678');
  // $password = $data->password;
  $query = "INSERT INTO users (email, name, password) VALUES ('{$data->email}','{$data->name}','$password')";
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $conn->exec($query);

  echo json_encode([
    'status' => 'success',
  ]);
  header('Content-Type: application/json');
  // status code 200 OK
  http_response_code(201);

} catch (\PDOException $th) {
  echo json_encode([
    'status' => 'error',
    'message' => json_decode($th->getMessage()),
  ]);
  header('Content-Type: application/json');
  // status code 200 OK
  http_response_code(500);

}