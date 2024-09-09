<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Cliente - ServiGO</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="index_logado.php"> 
            <img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;">
        </a>
    </header>

    <div class="container">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome']); ?>!</h1>
        <p>Esta é a sua área de cliente. Aqui você pode gerenciar seus serviços, visualizar preferências e muito mais.</p>

        <div class="dashboard-buttons">
            <button><a href="perfil_cliente.php">Perfil</a></button>
            <button><a href="solicitacoes_cliente.php">Solicitações</a></button>
            <button><a href="historico_servicos_cliente.php">Histórico de Serviços</a></button>
            <button><a href="categorias.php">Solicitar Serviço</a></button>
        </div>

        <div class="navigation-buttons">
        <a href="index_logado.php" class="button">Voltar</a>
        </div>
    </div>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
