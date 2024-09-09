<?php
include 'conexao.php'; // Conexão ao banco de dados

// Consulta para obter os serviços disponíveis
$sql = "SELECT * FROM servicos_oferecidos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Oferecidos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Serviços Prestados</h1>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            // Exibir cada serviço com uma opção para solicitá-lo
            while($row = $result->fetch_assoc()) {
                echo "<li><strong>" . $row["nome_servico"] . "</strong><br>" . $row["descricao"] . "<br>";
                echo "<a href='solicitar_servico.php?id=" . $row['id'] . "'>Solicitar Serviço</a></li>";
            }
        } else {
            echo "<li>Nenhum serviço disponível.</li>";
        }
        ?>
    </ul>
</body>
</html>
