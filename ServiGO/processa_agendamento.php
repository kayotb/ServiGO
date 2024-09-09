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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $servico_id = intval($_POST['servico_id']);
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $mensagem = $_POST['mensagem'];

    $query = "INSERT INTO agendamentos (user_id, servico_id, data, hora, mensagem) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iisss', $user_id, $servico_id, $data, $hora, $mensagem);

    if ($stmt->execute()) {
        echo "Agendamento realizado com sucesso.";
    } else {
        echo "Erro ao realizar o agendamento.";
    }

    $stmt->close();
}

$conn->close();
?>
