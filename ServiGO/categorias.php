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
            background-color: #2c3e50; /* Cor de fundo dos botões */
            border: none;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

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
    </style>
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
        <section class="services-section">
            <h1>Categorias</h1>
            <ul class="services">
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
        <a href="index_logado.php" class="button">Voltar</a>
        </div>
    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
