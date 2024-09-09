<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexao.php';

// Verificar se o serviço foi especificado
$servico_id = isset($_GET['servico_id']) ? intval($_GET['servico_id']) : 0;
$servico = null;

if ($servico_id > 0) {
    $query = "SELECT * FROM servicos WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $servico_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $servico = $result->fetch_assoc();
    } else {
        echo "Serviço não encontrado.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiGO - Solicitação de Serviço</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logonova.jpeg" alt="ServiGO">
        </div>
    </header>

    <main>
        <section class="request-section">
            <h1>Solicitação de Serviço</h1>

            <?php if ($servico): ?>
                <p>Você está solicitando o serviço: <strong><?php echo htmlspecialchars($servico['nome']); ?></strong>.</p>
                <p>Descrição: <?php echo htmlspecialchars($servico['descricao']); ?></p>
                <p>Preço: R$ <?php echo number_format($servico['preco'], 2, ',', '.'); ?></p>

                <form action="processa_solicitacao_cliente.php" method="POST">
                    <input type="hidden" name="servico_id" value="<?php echo $servico['id']; ?>">
                    <label for="mensagem">Mensagem:</label>
                    <textarea id="mensagem" name="mensagem" rows="4" required></textarea>

                    <button type="submit">Enviar Solicitação</button>
                </form>
            <?php else: ?>
                <p>Selecione um serviço para solicitar.</p>
            <?php endif; ?>
        </section>
        
        <section class="categories-section">
            <h2>Categorias de Serviços Disponíveis</h2>
            <?php
            $categories = [
                "Consultoria e Finanças" => "consultoria_financas.php",
                "Design e Moda" => "design.php",
                "Eventos e Festas" => "eventos_festas.php",
                "Esporte e Fitness" => "esporte_fitness.php",
                "Marketing e Publicidade" => "marketing_publicidade.php",
                "Manutenção de Veículos" => "manutencao_veiculos.php",
                "Pets e Animais" => "pets_animais.php",
                "Reformas e Reparos" => "reformas.php",
                "Saúde e Bem-Estar" => "saude_bem_estar.php",
                "Serviços Domésticos" => "servicos_domesticos.php",
                "Tecnologia" => "tecnologia.php",
                "Transporte e Mudanças" => "transporte_mudancas.php",
                "Outros" => "outros_servicos.php"
            ];

            foreach ($categories as $category => $link): ?>
                <div class="category">
                    <h3><?php echo htmlspecialchars($category); ?></h3>
                    <a href="<?php echo $link; ?>">Ver Serviços</a>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
