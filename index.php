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

} catch (PDOException $e) {
  $reviews = []; // Se der erro, o array fica vazio
  error_log("Erro ao buscar avaliações: " . $e->getMessage());
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
        <a href="./Viagem/home_viagem.html"><button class="btn primary lg">
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
        <a href="./Viagem/home_viagem.html" class="link" style="
              color: rgb(255, 103, 1);
              font-weight: bold;
              font-size: large;
              -webkit-text-stroke-width: 0.01px;
              -webkit-text-stroke-color: #000;
            ">Ver todos &rarr;</a>
      </div>
      <div class="grid cards">
        <div class="card">
          <div class="card-img" style="
                background-image: url('https://ecommerce.cdn.genera.com.br/uploads/2022/12/cidade-antiga-marrocos-1024x575.jpg');
              "></div>
          <div class="card-body">
            <h3>Marrocos Essencial</h3>
            <p>
              7 dias por Marrakech, deserto de Agafay e montanhas históricas.
            </p>
            <div class="meta">
              <span><i class="fa-solid fa-clock"></i> 7 dias</span>
              <span>a partir de R$ 3.520</span>
            </div>
            <a href="./Viagem/home_viagem.html" class="btn secondary">Ver detalhes</a>
          </div>
        </div>
        <div class="card">
          <div class="card-img" style="
                background-image: url('https://cdn.americachip.com/wp-content/uploads/2024/05/camboja-onde-fica-1024x619.jpg?strip=all&lossy=1&quality=92&webp=92&ssl=1');
              "></div>
          <div class="card-body">
            <h3>Templos do Camboja</h3>
            <p>
              Angkor Wat ao nascer do sol e imersão gastronômica.
            </p>
            <div class="meta">
              <span><i class="fa-solid fa-clock"></i> 5 dias</span>
              <span>a partir de R$ 1.950</span>
            </div>
            <a href="./Viagem/home_viagem.html" class="btn secondary">Ver detalhes</a>
          </div>
        </div>
        <div class="card">
          <div class="card-img" style="
                background-image: url('https://www.travely.com.br/wp-content/uploads/2021/07/59b514757c03f4e14c006ca63de02928_XL.jpg');
              "></div>
          <div class="card-body">
            <h3>Safari na Tanzânia</h3>
            <p>
              Parques Tarangire e Serengeti com guias locais e lodge
              ecológico.
            </p>
            <div class="meta">
              <span><i class="fa-solid fa-clock"></i> 10 dias</span>
              <span>a partir de R$ 9.880</span>
            </div>
            <a href="./Viagem/home_viagem.html" class="btn secondary">Ver detalhes</a>
          </div>
        </div>
        <div class="card">
          <div class="card-img" style="
                background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRx8mYNSgi3ADAOBJYbukIK-uCWbUGO6gou1A&s');
              "></div>
          <div class="card-body">
            <h3>Holi na Índia</h3>
            <p>
              Participe do festival das cores mais aguardado e seguro de
              Jaipur.
            </p>
            <div class="meta">
              <span><i class="fa-solid fa-clock"></i> 3 dias</span>
              <span>a partir de R$ 1.410</span>
            </div>
            <a href="./Viagem/home_viagem.html" class="btn secondary">Ver detalhes</a>
          </div>
        </div>
      </div>
    </section>

    <section class="section alt">
      <div class="section-head">
        <h2>Experiências Culturais</h2>
      </div>
      <div class="themes">
        <button class="chip active" data-filter="all">Todos</button>
        <button class="chip" data-filter="gastronomia">Gastronomia</button>
        <button class="chip" data-filter="natureza">Natureza</button>
        <button class="chip" data-filter="festivais">Festivais</button>
        <button class="chip" data-filter="arte">História & Arte</button>
        <button class="chip" data-filter="comunidades">Comunidades</button>
      </div>
      <div class="carousel">
        <div class="carousel-track">
          <div class="slide" data-category="gastronomia" style="
                background-image: url('https://blog.swiggy.com/wp-content/uploads/2024/10/Image1_Pani-Puri-1024x538.jpg');
              ">
            <span class="badge">Gastronomia</span>
            <h3>Street food na Índia</h3>
          </div>
          <div class="slide" data-category="natureza" style="
                background-image: url('https://cdn.forevervacation.com/uploads/blog/why-java-is-the-next-up-and-coming-destination-in-indonesia-the-vacationer-by-forevervacation-3062.jpg');
              ">
            <span class="badge">Natureza</span>
            <h3>Trilha em Java</h3>
          </div>
          <div class="slide" data-category="festivais" style="
                background-image: url('https://images.squarespace-cdn.com/content/v1/52c0b141e4b0b87925bacd01/1462779501654-SZX1U1SK9WUBJW3ZC6QW/songkran3.jpg');
              ">
            <span class="badge">Festivais</span>
            <h3>Songkran na Tailândia</h3>
          </div>
          <div class="slide" data-category="arte" style="
                background-image: url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/10/c8/75/c2/zoroastrian-fire-temple.jpg?w=900&h=500&s=1');
              ">
            <span class="badge">História & Arte</span>
            <h3>Patrimônios no Irã</h3>
          </div>
          <div class="slide" data-category="comunidades" style="
                background-image: url('https://media.istockphoto.com/id/1280111094/pt/foto/ethiopian-landscape-ethiopia-africa-wilderness.jpg?s=170667a&w=0&k=20&c=dUqNe_i4sOfWjEYvGk-cTbBEHFTx1iy5BvL4lwo4rqM=');
              ">
            <span class="badge">Comunidades</span>
            <h3>Vilarejos na Etiópia</h3>
          </div>
          <div class="slide" data-category="festivais" style="
                background-image: url('https://www.chingay.gov.sg/images/UNESCO.jpg');
              ">
            <span class="badge">Comunidades</span>
            <h3>Chingay em Singapura</h3>
          </div>
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

  <script src="./JS/home.js"></script>
</body>

</html>