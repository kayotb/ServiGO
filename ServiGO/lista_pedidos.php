<?php
include 'conexao.php';

$sql = "SELECT pedidos.id, pedidos.nome_cliente, pedidos.descricao, pedidos.data_solicitacao, servicos_oferecidos.nome_servico
        FROM pedidos
        JOIN servicos_oferecidos ON pedidos.id_servico = servicos_oferecidos.id";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Realizados</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Pedidos Realizados</h1>
    <table border="1">
        <tr>
            <th>Nome do Cliente</th>
            <th>Serviço</th>
            <th>Descrição</th>
            <th>Data da Solicitação</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nome_cliente'] . "</td>";
                echo "<td>" . $row['nome_servico'] . "</td>";
                echo "<td>" . $row['descricao'] . "</td>";
                echo "<td>" . $row['data_solicitacao'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum pedido encontrado.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
