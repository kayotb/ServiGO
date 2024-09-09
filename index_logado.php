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
                <li><a href="index_logado.php" class="btn-title">Início</a></li>
                <li><a href="cliente_dashboard.php" class="btn-title">Minha Conta</a></li>
                <li class="menu-categories">
                    <a href="categorias.php">Serviços</a>
                    <ul class="dropdown">
                        <!-- Atualizar para mostrar apenas a categoria "Tecnologia" -->
                      
                    </ul>
                </li>
                <li><a href="logout.php" class="btn-logout">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Removido a seção de busca -->
        
        <section class="categories-section">
            <h2>Principais Categorias de Serviços</h2>
            <div class="categories">
                <!-- Mantido apenas a categoria Tecnologia -->
                <div class="category">
                    <a href="categorias.php">
                        <img src="img/tecnologia.png" alt="Tecnologia">
                        <h3>Tecnologia</h3>
                    </a>
                </div>
            </div>
        </section>

        <section class="testimonials-section">
            <h2>O que dizem nossos clientes:</h2>
            <div class="testimonial">
                <p>"O ServiGO facilitou a criação de um projeto de site para minha marca. O processo foi simples e eficiente, recomendo muito!"</p>
                <span>- João Silva</span>
            </div>
            <div class="testimonial">
                <p>"Graças ao ServiGO, encontrei rapidamente um suporte técnico ideal para minha loja. A plataforma foi extremamente útil e ágil!"</p>
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
