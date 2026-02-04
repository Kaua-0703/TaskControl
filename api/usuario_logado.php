<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    http_response_code(401);
    echo json_encode(["erro" => "Não autenticado"]);
    exit;
}

echo json_encode([
    "id"   => $_SESSION["usuario_id"],
    "nome" => $_SESSION["usuario_nome"],
    "admin" => $_SESSION["usuario_admin"]

]);