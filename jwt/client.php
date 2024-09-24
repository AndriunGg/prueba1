<?php
require_once '../config.php';
echo 'hello JWT';

//recibe la informacion del login page y la envia al servidor para validar la autenticidad
//de las credenciales y crear un JWT que sera almacenado en cookies
public function login(string $username, string $password): string {
  $url = SERVER_URL . '/login';

  $payload = json_encode(['username' => $username,
                          'password' => $password]);

  $http_info = [
        'http' => [
              'header' => "Content-Type: application/json\r\n",
              'method' => 'POST',
              'content' => $payload,
        ],
  ];

  $context = stream_context_create($http_info);

  try {
    $res = file_get_contents($url, false, $context);
    if (!$res) {
      throw new Exception('http POST ' . $url . ' failed with content: ' . $http_info);
    }
    $res_content = json_decode($res, true);
    if (isset($res_content['token'])) {
      setcookie$('token', json_encode($res_content['token']), time()+3600)
    } throw new Exception('response content ' . $res_content . ' failed get TOKEN field: ' . $res_content['token']);
  } catch (\Exception $e) {
    echo $e;
  }
};

//enviar JWT almacenado en cookies al servidor para validar el token y obtener la informacion encriptada
public function getSesion(string $endpoint): void {
  $url = SERVER_URL . $endpoint;
  $token = json_decode($_COOKIE['token'], true);

  $http_info = [
        'http' => [
              'header' => "Authorization: Bearer $token\r\n",
              'method' => 'GET',
        ],
  ];

  $context = stream_context_create($http_info);

  try {
    $res = file_get_contents($url, false, $context);
    if (!$res) {
      throw new Exception('http POST ' . $url . ' failed with content: ' . $http_info . $token);
    }
    echo 'USER JWT VALIDATED ' . $res;
  } catch (\Exception $e) {
    echo $e;
  }
};
?>
