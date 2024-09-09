<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $profissional_id = intval($_GET['id']);

    $query = "SELECT id AS servico_id, nome AS servico_nome, preco FROM servicos WHERE usuario_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $profissional_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'servico_id' => $row['servico_id'],
            'servico_nome' => $row['servico_nome'],
            'preco' => $row['preco']
        ]);
    } else {
        echo json_encode([
            'servico_id' => '',
            'servico_nome' => '',
            'preco' => ''
        ]);
    }

    $stmt->close();
}

$conn->close();
?>
