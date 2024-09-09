<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_servico = $_POST['id_servico'];
    $nome_cliente = $_POST['nome_cliente'];
    $descricao = $_POST['descricao'];

    // Inserir a solicitação no banco de dados
    $sql = "INSERT INTO pedidos (id_servico, nome_cliente, descricao) VALUES ('$id_servico', '$nome_cliente', '$descricao')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Solicitação enviada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>