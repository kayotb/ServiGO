<?php
include 'conexao.php';

// Dados do administrador
$nome = 'Admin';
$email = 'admin@servigo.com';
$telefone = '123456789';
$endereco = 'Rua Admin, 123';
$senha = password_hash('100senha', PASSWORD_BCRYPT);
$tipo_usuario_id = 2; // Supondo que o ID do administrador seja 2

// Inserir o administrador no banco de dados
$query = "INSERT INTO usuarios (nome, email, telefone, endereco, senha, tipo_usuario_id, data_registro) VALUES (?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssssi', $nome, $email, $telefone, $endereco, $senha, $tipo_usuario_id);

if ($stmt->execute()) {
    echo "Administrador criado com sucesso!";
} else {
    echo "Erro ao criar administrador: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
