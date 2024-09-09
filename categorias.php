<?php
session_start();

// Verificar se o usuário está logado
$logged_in = isset($_SESSION['user_id']);

// Configurar o URL da logo com base na autenticação
$logo_url = $logged_in ? 'index_logado.php' : 'index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiGO - Categorias de Serviços</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Estilo para a seção de serviços */
        .services-section {
            padding: 40px 20px;
            text-align: center;
            background-color: #f4f4f4;
        }

        .services-section h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .services {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .service {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .service button {
            width: 200px; /* Largura fixa para padronizar o tamanho dos botões */
            height: 50px; /* Altura fixa para padronizar o tamanho dos botões */
            font-size: 1rem;
            font-weight: bold;
            color: #ffffff;
            

        .service button:hover {
            background-color: #1a252f; /* Cor mais escura ao passar o mouse */
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .service button:active {
            transform: translateY(0);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        /* Estilo do rodapé */
        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
            border-top: 4px solid #2c3e50;
        }
        
        /* Estilo para o botão voltar */
        .button-back {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #ffffff;
            background-color: #e74c3c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s, transform 0.2s;
        }

        .button-back:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        .button-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="<?php echo htmlspecialchars($logo_url); ?>"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="services-section">
            <h1>Serviços disponíveis</h1>
            <ul class="services">
                <?php
                $categories = [
                    "Desenvolvimento Web" => "formulario_servico.php?categoria=Desenvolvimento%20Web",
                    "Consultoria em TI" => "formulario_servico.php?categoria=Consultoria%20em%20TI",
                    "Suporte Técnico" => "formulario_servico.php?categoria=Suporte%20Técnico",
                    "Design de Sistemas" => "formulario_servico.php?categoria=Design%20de%20Sistemas",
                    "Segurança da Informação" => "formulario_servico.php?categoria=Segurança%20da%20Informação"
                ];

                foreach ($categories as $category => $link) {
                    echo '<li class="service">
                            <a href="' . htmlspecialchars($link) . '">
                                <button type="button">' . htmlspecialchars($category) . '</button>
                            </a>
                          </li>';
                }
                ?>
            </ul>
        </section>
    </main>
    <div class="navigation-buttons">
        <button class="button-back" onclick="goBack()">Voltar</button>
    </div>
    <footer>
        <p>&copy; ServiGO.</p>
    </footer>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
