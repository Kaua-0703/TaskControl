<?php
require "db.php";

$acao = isset($_GET["acao"]) ? trim($_GET["acao"]) : "";

if ($acao === "listar") {

    $pagina = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;
    $limite = 5;
    $offset = ($pagina - 1) * $limite;

    $sql = $pdo->prepare("
        SELECT id, id_usuario, titulo, descricao, status, data_criacao, data_limite
        FROM tarefas
        ORDER BY id DESC
        LIMIT :limite OFFSET :offset
    ");
    $sql->bindValue(":limite", $limite, PDO::PARAM_INT);
    $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
    $sql->execute();

    $bodyTarefas = "";

    while ($retorno = $sql->fetch(PDO::FETCH_ASSOC)) {

        $statusTexto = ($retorno["status"] == 1) ? "Concluída" : "Pendente";

        $bodyTarefas .= "<tr>";
        $bodyTarefas .= "<td>{$retorno['id']}</td>";
        $bodyTarefas .= "<td>{$retorno['id_usuario']}</td>";
        $bodyTarefas .= "<td>{$retorno['titulo']}</td>";
        $bodyTarefas .= "<td>{$retorno['descricao']}</td>";
        $bodyTarefas .= "<td>{$retorno['data_criacao']}</td>";
        $bodyTarefas .= "<td>{$retorno['data_limite']}</td>";
        $bodyTarefas .= "<td>{$statusTexto}</td>";

        $bodyTarefas .= "<td class='text-end'>";

        if ($retorno["status"] == 0) {
            $bodyTarefas .= "
                <button class='btn btn-success btn-sm me-1'
                    onclick='concluirTarefa({$retorno['id']})'>
                    Concluir
                </button>
            ";
        }

        $bodyTarefas .= "
            <a href='editartarefas.html?id={$retorno['id']}'
               class='btn btn-warning btn-sm me-1'>
                Editar
            </a>

            <button class='btn btn-danger btn-sm'
                onclick='excluirTarefa({$retorno['id']})'>
                Excluir
            </button>
        </td>";

        $bodyTarefas .= "</tr>";
    }

    echo $bodyTarefas;
    exit;
}

if ($acao === "cadastrar") {

    $id_usuario   = trim($_POST["id_usuario"] ?? "");
    $titulo       = trim($_POST["titulo"] ?? "");
    $descricao    = trim($_POST["descricao"] ?? "");
    $data_criacao = trim($_POST["data_criacao"] ?? "");
    $data_limite  = trim($_POST["data_limite"] ?? "");
    $status = 0;

    if ($id_usuario == "" || $titulo == "" || $descricao == "" || $data_criacao == "" || $data_limite == "") {
        http_response_code(400);
        echo "Preencha todos os campos.";
        exit;
    }

    $sql = $pdo->prepare("
        INSERT INTO tarefas
        (id_usuario, titulo, descricao, status, data_criacao, data_limite)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $sql->execute([
        $id_usuario,
        $titulo,
        $descricao,
        $status,
        $data_criacao,
        $data_limite
    ]);

    echo "OK";
    exit;
}

if ($acao === "excluir") {

    $id = (int) ($_POST["id"] ?? 0);

    if ($id <= 0) {
        http_response_code(400);
        echo "ID inválido.";
        exit;
    }

    $sql = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
    $sql->execute([$id]);

    echo "OK";
    exit;
}

if ($acao === "buscar") {

    $id = (int) ($_POST["id"] ?? 0);

    if ($id <= 0) {
        http_response_code(400);
        echo "ID inválido.";
        exit;
    }

    $sql = $pdo->prepare("
        SELECT id, titulo, descricao, data_limite
        FROM tarefas
        WHERE id = ?
    ");
    $sql->execute([$id]);

    echo json_encode($sql->fetch(PDO::FETCH_ASSOC));
    exit;
}

if ($acao === "atualizar") {

    $id          = (int) ($_POST["id"] ?? 0);
    $titulo      = trim($_POST["titulo"] ?? "");
    $descricao   = trim($_POST["descricao"] ?? "");
    $data_limite = trim($_POST["data_limite"] ?? "");

    if ($id <= 0 || $titulo == "" || $descricao == "" || $data_limite == "") {
        http_response_code(400);
        echo "Preencha todos os campos.";
        exit;
    }

    $sql = $pdo->prepare("
        UPDATE tarefas
        SET titulo = ?, descricao = ?, data_limite = ?
        WHERE id = ?
    ");
    $sql->execute([$titulo, $descricao, $data_limite, $id]);

    echo "OK";
    exit;
}

if ($acao === "concluir") {

    $id = (int) ($_POST["id"] ?? 0);

    if ($id <= 0) {
        http_response_code(400);
        echo "ID inválido.";
        exit;
    }

    $sql = $pdo->prepare("UPDATE tarefas SET status = 1 WHERE id = ?");
    $sql->execute([$id]);

    echo "OK";
    exit;
}
