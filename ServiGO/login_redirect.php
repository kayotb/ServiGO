<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'servigo');

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT tipo FROM usuarios WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $tipo = $user['tipo'];

    if ($tipo == 'cliente') {
        header("Location: cliente_dashboard.php");
    } elseif ($tipo == 'profissional') {
        header("Location: profissional_dashboard.php");
    } else {
        echo "Tipo de usuário desconhecido.";
    }
} else {
    echo "Usuário não encontrado.";
}

$conn->close();
?>
