<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Serviço - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index_logado.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="request-form-section">
            <h1>Solicitar Serviço: <?php echo htmlspecialchars($categoria); ?></h1>
            <form action="processar_solicitacao.php" method="POST">
                <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>">

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" required>

                <label for="data">Data:</label>
                <input type="date" id="data" name="data" required>

                <label for="forma_pagamento">Forma de Pagamento:</label>
                <select id="forma_pagamento" name="forma_pagamento" required>
                    <option value="boleto">Boleto</option>
                    <option value="cartao_credito">Cartão de Crédito</option>
                    <option value="transferencia">Transferência Bancária</option>
                </select>

                <button type="submit">Enviar Solicitação</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
