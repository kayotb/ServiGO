<?php
// Mantemos apenas a categoria "Tecnologia"
$categories = [
    "Tecnologia" => "tecnologia.php"
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiGO - Página Inicial</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="img/logonova.jpeg" alt="ServiGO">
        </div>
        <nav>
            <ul>
                <li><a href="login.php" class="btn-title">Entrar</a></li>
                <li><a href="registro.php">Fazer Registro</a></li>
                <li class="menu-categories">
                    <a href="servicos.php">Categorias</a>
                    <!-- Submenu gerado dinamicamente -->
                    <ul class="dropdown">
                        <?php foreach ($categories as $category => $link): ?>
                            <li><a href="<?php echo $link; ?>"><?php echo $category; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Removido a seção de busca -->
        
        <section class="categories-section">
            <h2>Principais Serviços</h2>
            <div class="categories">
                <!-- Mantido apenas a categoria Tecnologia -->
                <div class="category">
                    <a href="tecnologia.php">
                        <img src="img/tecnologia.png" alt="Tecnologia">
                        <h3>Serviços</h3>
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
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
