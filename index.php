<?php
include 'config.php';
include 'db_connect.php'; // Inclui a conexão com o banco

try {
    // Query que "junta" 3 tabelas
    $sql = "
        SELECT 
            a.mensagem, a.nota,
            u.nome_exibicao, u.avatar_url,
            v.titulo AS viagem_titulo
        FROM avaliacoes AS a
        LEFT JOIN usuarios AS u ON a.usuario_id = u.id
        LEFT JOIN viagens AS v ON a.viagem_id = v.id
        ORDER BY RAND()
        LIMIT 3
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query para "Destinos em Destaque" (4 aleatórios)
    $stmtDestaques = $conn->prepare("SELECT * FROM viagens ORDER BY RAND() LIMIT 4");
    $stmtDestaques->execute();
    $destaques = $stmtDestaques->fetchAll(PDO::FETCH_ASSOC);

    // Query para "Experiências Culturais" (6 aleatórios para o carrossel)
    $stmtExperiencias = $conn->prepare("SELECT * FROM viagens ORDER BY RAND() LIMIT 6");
    $stmtExperiencias->execute();
    $experiencias = $stmtExperiencias->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  $reviews = []; 
  $destaques = [];
  $experiencias = [];
  error_log("Erro ao buscar dados da home: " . $e->getMessage());
}

include ROOT_PATH . 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WonderFly - Explore Culturas Autênticas</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha26-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link rel="stylesheet" href="./CSS/global.css" />
</head>

<body>
  <main>
    <section class="hero">
      <div class="hero-bg"></div>
      <h1>Explore <span class="orange">culturas autênticas</span></h1>
      <p>
        Roteiros feitos por quem vive a cultura local: mercados, rituais,
        festivais e experiências reais para quem busca mais.
      </p>
      <div class="hero-ctas">
        <a href="./Viagem/home_viagem.php"><button class="btn primary lg">
            <i class="fa-solid fa-compass"></i> Explore Destinos
          </button></a>
      </div>
      <div class="trust">
        <span>• Pagamento seguro • Turismo responsável • Grupos pequenos</span>
      </div>
    </section>


    <section class="section trust-cards">
      <div class="trust-grid">
        <div class="trust-card">
          <i class="fa-solid fa-earth-americas"></i>
          <h4>Turismo responsável</h4>
          <p>
            Parcerias com guias locais, respeito às comunidades e compensação
            de carbono.
          </p>
        </div>
        <div class="trust-card">
          <i class="fa-solid fa-users"></i>
          <h4>Grupos pequenos</h4>
          <p>
            Experiências mais autênticas, tempo livre e acompanhamento
            completo.
          </p>
        </div>
        <div class="trust-card">
          <i class="fa-solid fa-headset"></i>
          <h4>Suporte 24/7</h4>
          <p>Atendimento humano antes, durante e depois da viagem.</p>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="section-head">
        <h2>Destinos em Destaque</h2>
        <a href="./Viagem/home_viagem.php" class="link" style="
              color: rgb(255, 103, 1);
              font-weight: bold;
              font-size: large;
              -webkit-text-stroke-width: 0.01px;
              -webkit-text-stroke-color: #000;
            ">Ver todos &rarr;</a>
      </div>
      <div class="grid cards">
        <?php if (empty($destaques)): ?>
            <p style="grid-column: 1/-1; text-align: center;">Nenhum destino em destaque no momento.</p>
        <?php else: ?>
            <?php foreach ($destaques as $viagem): ?>
                <div class="card">
                  <div class="card-img" style="background-image: url('<?php echo htmlspecialchars($viagem['imagem_url']); ?>');"></div>
                  <div class="card-body">
                    <h3><?php echo htmlspecialchars($viagem['titulo']); ?></h3>
                    <p>
                      <?php echo htmlspecialchars($viagem['descricao_curta']); ?>
                    </p>
                    <div class="meta">
                      <span><i class="fa-solid fa-clock"></i> <?php echo htmlspecialchars($viagem['duracao']); ?></span>
                      <span>a partir de R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></span>
                    </div>
                    <a href="./Viagem/viagem.php?id=<?php echo $viagem['id']; ?>" class="btn secondary">Ver detalhes</a>
                  </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

    <section class="section alt">
      <div class="section-head">
        <h2>Experiências Culturais</h2>
      </div>
      <div class="themes">
        <button class="chip active" data-filter="all">Todos</button>
        <?php 
            // Extrai categorias únicas das experiências carregadas
            $categorias_unicas = [];
            if (!empty($experiencias)) {
                foreach ($experiencias as $exp) {
                    // Explode por vírgula OU espaço (regex)
                    $cats = preg_split('/[\s,]+/', $exp['categorias'], -1, PREG_SPLIT_NO_EMPTY);
                    
                    foreach ($cats as $cat) {
                        $cat = trim($cat);
                        // Normaliza para chave (minúsculo, sem acentos básicos)
                        $data_cat = strtolower($cat);
                        
                        if (!isset($categorias_unicas[$data_cat])) {
                            $categorias_unicas[$data_cat] = $cat;
                        }
                    }
                }
            }
            
            // Gera os botões
            foreach ($categorias_unicas as $data_val => $label): 
        ?>
            <button class="chip" data-filter="<?php echo htmlspecialchars($data_val); ?>">
                <?php echo htmlspecialchars($label); ?>
            </button>
        <?php endforeach; ?>
      </div>
      <div class="carousel">
        <div class="carousel-track">
          <?php if (!empty($experiencias)): ?>
            <?php foreach ($experiencias as $exp): ?>
                <?php 
                    $cats = preg_split('/[\s,]+/', $exp['categorias'], -1, PREG_SPLIT_NO_EMPTY);
                    
                    // Prepara string para data-category (separado por espaço)
                    $data_cats_array = array_map('strtolower', $cats);
                    $data_category_str = implode(' ', $data_cats_array);
                    
                    // Badge mostra TODAS as categorias, formatadas
                    // Capitaliza cada palavra (ex: "aventura" -> "Aventura")
                    $cats_formatted = array_map('ucfirst', $cats);
                    $badge_label = implode(', ', $cats_formatted);
                ?>
                <div class="slide" data-category="<?php echo htmlspecialchars($data_category_str); ?>" style="background-image: url('<?php echo htmlspecialchars($exp['imagem_url']); ?>');">
                    <span class="badge"><?php echo htmlspecialchars($badge_label); ?></span>
                    <h3><?php echo htmlspecialchars($exp['titulo']); ?></h3>
                    <!-- Link opcional para a viagem -->
                    <a href="./Viagem/viagem.php?id=<?php echo $exp['id']; ?>" style="position:absolute; inset:0;"></a>
                </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="slide" style="background-color: #333; display: flex; align-items: center; justify-content: center;">
                <h3>Em breve novas experiências</h3>
            </div>
          <?php endif; ?>
        </div>
        <button class="carousel-btn prev">
          <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="carousel-btn next">
          <i class="fa-solid fa-chevron-right"></i>
        </button>
      </div>
    </section>

    <section class="section">
      <div class="section-head">
        <h2>Nossas agências:</h2>
      </div>
      <div id="mapaAgencias"></div>
    </section>

    <section class="section alt">
      <div class="section-head">
        <h2>O que nossos viajantes dizem</h2>
        <a href="./Avaliacoes/avaliacoes.php" class="link" style="color: rgb(255, 103, 1); font-weight: bold; font-size: large; -webkit-text-stroke-width: 0.01px; -webkit-text-stroke-color: #000;">
            Ver todos &rarr;
        </a>
      </div>
      <div class="testimonial-grid">

        <?php if (empty($reviews)): ?>
          <p style="text-align: center; grid-column: 1 / -1;">
            Ainda não há avaliações. Seja o primeiro a nos contar como foi!
          </p>

        <?php else: ?>

          <?php foreach ($reviews as $review): ?>
            <div class="testimonial-card">
              <div class="stars">
                <?php
                echo generateStarsHTML($review['nota']);
                ?>
              </div>
              <p class="quote">
                "<?php
                echo htmlspecialchars($review['mensagem']);
                ?>"
              </p>
              <div class="profile">
                <img src="<?php
                echo htmlspecialchars($review['avatar_url'] ?? './images/profile/default.jpg');
                ?>" alt="Foto de <?php echo htmlspecialchars($review['nome_exibicao'] ?? 'Aventureiro'); ?>" />
                <div class="profile-info">
                  <h4>
                    <?php
                    // 4. Exibe o nome ou "Anônimo" se o usuário for deletado
                    echo htmlspecialchars($review['nome_exibicao'] ?? 'Anônimo');
                    ?>
                  </h4>
                  <span>Viagem: <strong>
                      <?php
                      // 5. Exibe o título da viagem
                      echo htmlspecialchars($review['viagem_titulo'] ?? 'Não informada');
                      ?>
                    </strong></span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </section>

    <section class="cta-newsletter">
      <h3>Ganhe R$ 200 de desconto no 1º pacote</h3>
      <p>Assine a newsletter e receba nossas melhores ofertas exclusivas.</p>
      <form class="newsletter">
        <input type="email" placeholder="Seu melhor e-mail" />
        <button type="submit" class="btn white">Quero receber!</button>
      </form>
    </section>
  </main>

  <?PHP
  include ROOT_PATH . 'templates/footer.php';
  ?>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Passa a URL Base do PHP para o JavaScript
    const baseUrl = '<?php echo BASE_URL; ?>';
</script>

<script src="<?php echo BASE_URL; ?>JS/home.js"></script>
</body>

</html>