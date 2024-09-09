<?php
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
include 'conexao.php';

// Buscar informações do usuário logado
$user_id = $_SESSION['user_id'];
$query = "SELECT nome FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiGO - Bem-vindo(a) <?php echo htmlspecialchars($user['nome']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logonova.jpeg" alt="ServiGO">
        </div>
        <nav>
            <ul>
                <li><a href="profissional_dashboard.php" class="btn-title">Minha Conta</a></li>
                
                <!-- Adicionar o botão de logout aqui -->
                <li><a href="logout.php" class="btn-logout">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="search-section">
            <h1>Encontre os Melhores Profissionais</h1>
            <form action="search_results.php" method="GET">
                <input type="text" name="search" placeholder="Que serviço você está procurando?">
            </form>
        </section>

        <section class="categories-section">
            <h2>Principais Categorias de Serviços</h2>
            <div class="categories">
                <div class="category">
                    <a href="reformas.php">
                        <img src="img/reformas.png" alt="Reformas e Reparos">
                        <h3>Reformas e Reparos</h3>
                    </a>
                </div>
                <div class="category">
                    <a href="tecnologia.php">
                        <img src="img/tecnologia.png" alt="Tecnologia">
                        <h3>Tecnologia</h3>
                    </a>
                </div>
                <div class="category">
                    <a href="design.php">
                        <img src="img/designmoda.png" alt="Design e Moda">
                        <h3>Design e Moda</h3>
                    </a>
                </div>
            </div>
        </section>

        <section class="testimonials-section">
            <h2>O que dizem nossos clientes:</h2>
            <div class="testimonial">
                <p>"O GO me ajudou a encontrar o profissional perfeito para minha reforma. Altamente recomendado!"</p>
                <span>- João Silva</span>
            </div>
            <div class="testimonial">
                <p>"Rápido e fácil! Encontrei um designer para minha marca em poucas horas."</p>
                <span>- Maria Souza</span>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; ServiGO. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
