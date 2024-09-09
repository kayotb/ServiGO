<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiGO - Design e Moda</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
        <li><a href="index_logado.php"><img src="img/logonova.jpeg" alt="ServiGO" style="width: 80px; height: auto;"></a></li>
        </div>
    </header>

    <main>
        <section class="services-section">
            <h1>Design e Moda</h1>
            <div class="services">
                <?php
                $services = [
                    "Design Gráfico",
                    "Design de Moda",
                    "Fotografia de Moda",
                    "Criação de Logotipos",
                    "Identidade Visual",
                    "Design de Embalagens",
                    "Design de Interiores",
                    "Consultoria de Imagem",
                    "Desenvolvimento de Marca",
                    "Edição de Imagens"
                ];

                foreach ($services as $service) {
                    // Aqui assumimos que o ID do serviço é o mesmo que o índice do array para simplificação.
                    $service_id = array_search($service, $services) + 1; // Ajuste conforme necessário
                    echo '<div class="service">
                            <form action="agendar_servico.php" method="GET">
                                <input type="hidden" name="servico_id" value="' . htmlspecialchars($service_id) . '">
                                <button type="submit">Solicitar ' . htmlspecialchars($service) . '</button>
                            </form>
                          </div>';
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; ServiGO.</p>
    </footer>
</body>
</html>
