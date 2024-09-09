<?php
session_start();
include 'conexao.php';

// Inicializar variáveis para mensagens
$message = null;

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];
$endereco = $_POST['endereco'];
$forma_pagamento = $_POST['forma_pagamento'];

// Prepare a query para inserir uma nova solicitação
$query = "INSERT INTO solicitacoes (user_id, categoria, descricao, endereco, forma_pagamento, data_solicitacao) 
          VALUES (?, ?, ?, ?, ?, NOW())";

// Preparar e executar a consulta
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('issss', $user_id, $categoria, $descricao, $endereco, $forma_pagamento);

    if ($stmt->execute()) {
        $message = "Solicitação enviada com sucesso!";
    } else {
        $message = "Erro ao processar a solicitação: " . $stmt->error;
    }
    $stmt->close();
} else {
    $message = "Erro ao preparar a consulta: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de Serviço</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .message {
            text-align: center;
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado da Solicitação</h1>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <a href="index_logado.php">Voltar</a>
    </div>
</body>
</html>
