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
                <li><a href="cliente.php">Cadastrar-se</a></li>
                <li class="menu-categories">
                    <a href="categorias.php">Serviços</a>
                    
                    
    </header>

    <main>
        <!-- Removido a seção de busca -->
        
        <section class="categories-section">
            <h2>Principais Serviços</h2>
            <div class="categories">
                <!-- Mantido apenas a categoria Tecnologia -->
                <div class="category">
                    <a href="categorias.php">
                        <img src="img/tecnologia.png" alt="Tecnologia">
                        <h3>Serviços</h3>
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
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
