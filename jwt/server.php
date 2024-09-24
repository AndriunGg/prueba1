<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

require_once '../config.php';
echo 'hello JWT';

//solicitar un JWT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
  $payload = '' //TODO: obtener informacion de login
  $username = $payload['username'];
  $password = $payload['password'];

  //TODO: aqui va el acceso a la base de datos para comparar las credenciales del login con los usuarios de base de datos
  $user = null;
  foreach ($users as $u) {
      if ($u['username'] === $username && $u['password'] === $password) {
          $user = $u;
          break;
      }
  }

  if ($user) {
      $token = JWT::encode(['id' => $user['id'], 'exp' => time() + 3600], SECRET_JWT);
      //devolver el token  creado
      echo json_encode(['token' => $token]);
  } else {
      http_response_code(401);
      echo json_encode(['message' => 'Credenciales inválidas']);
  }
}

//valida su el JWT corresponde al SECRET_JWT
function authenticateJWT($token): void {
  try {
      return JWT::decode($token, SECRET_JWT, ['HS256']);
  } catch (ExpiredException $e) {
      http_response_code(403);
      echo json_encode(['message' => 'Token expirado']);
      exit();
  } catch (Exception $e) {
      http_response_code(403);
      echo json_encode(['message' => 'Token inválido']);
      exit();
  }
};

//restringir el acceso en caso de no tener un JWT
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] !== '/login') {
  $headers = getallheaders();
  $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

  if ($token) {
      $decripted_payload = authenticateJWT($token);
      echo 'payload: ' . $decripted_payload;
  } else {
      http_response_code(401);
      echo json_encode(['message' => 'No autorizado']);
  }
}

?>
