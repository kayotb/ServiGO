<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $servico_id = intval($_GET['id']);

    $query = "SELECT preco FROM servicos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $servico_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['preco' => $row['preco']]);
    } else {
        echo json_encode(['preco' => '']);
    }

    $stmt->close();
}

$conn->close();
?>
