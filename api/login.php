<?php
require "db.php";

$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";

if ($email == "" || $senha == "") {
  http_response_code(400);
  echo "Preencha email e senha.";
  exit;
}

$sql = $pdo->prepare("SELECT id, email, senha, admin FROM usuarios WHERE email = ? LIMIT 1");
$sql->execute([$email]);
$retorno = $sql->fetch(PDO::FETCH_ASSOC);

if (!$retorno) {
  http_response_code(401);
  echo "Usuário ou senha não encontrados.";
  exit;
}

if (!($senha == $retorno["senha"])) {
  http_response_code(401);
  echo "Usuário ou senha inválidos.";
  exit;
}

$_SESSION["user_id"] = $retorno["id"];
$_SESSION["user_email"] = $retorno["email"];
$_SESSION["user_admin"] = $retorno["admin"];

http_response_code(200);

echo "OK";
?>