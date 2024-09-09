<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_tipo'] !== 'profissional') {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

$user_id = $_SESSION['user_id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$query = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssi', $nome, $email, $user_id);
$stmt->execute();

if (!empty($senha)) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $query_senha = "UPDATE usuarios SET senha = ? WHERE id = ?";
    $stmt_senha = $conn->prepare($query_senha);
    $stmt_senha->bind_param('si', $senha_hash, $user_id);
    $stmt_senha->execute();
}

$stmt->close();
if (isset($stmt_senha)) $stmt_senha->close();
$conn->close();

header("Location: perfil_profissional.php");
exit();
?>
