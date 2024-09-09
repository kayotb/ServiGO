<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $servico_id = intval($_POST['servico_id']);
    $mensagem = htmlspecialchars($_POST['mensagem']);
    
    $query = "INSERT INTO solicitacoes (user_id, servico_id, mensagem, data_solicitacao) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $user_id, $servico_id, $mensagem);
    
    if ($stmt->execute()) {
        echo "Solicitação enviada com sucesso!";
        header("Location: solicitacoes_cliente.php");
    } else {
        echo "Erro ao enviar a solicitação: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
