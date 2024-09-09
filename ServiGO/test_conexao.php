<?php
include 'conexao.php';

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conexão com o banco de dados bem-sucedida!";
}

$conn->close();
?>
