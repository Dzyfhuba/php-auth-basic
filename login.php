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
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = '{$data->email}' LIMIT 1");
  $stmt->execute();

  $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($user) < 1) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
      'status' => 'error',
      'message' => 'login failed',
    ]);
    exit();
  }
  
  $_SESSION['user'] = $user[0];

  echo json_encode([
    'status' => 'success',
    'user' => $user,
    'password' => password_verify($data->password, $user[0]['password']),
    // 'password' => $data->password == $user[0]['password'],
    // 'password_db' => $user[0]['password']
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