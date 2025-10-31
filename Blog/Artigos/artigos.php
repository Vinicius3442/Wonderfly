<?php
// 1. Inclui o config (sobe 2 níveis)
include '../../config.php'; 
// Inclui a conexão
include '../../db_connect.php';

// 2. GUARDIÃO: Pega o ID da URL
// (ex: artigo.php?id=1)
if (isset($_GET['id'])) {
    $artigo_id = intval($_GET['id']);
} else {
    // Se não tiver ID, redireciona para a home do blog
    header("Location: " . BASE_URL . "Blog/blog_home.php");
    exit;
}
try {
    // Query que "junta" o artigo, o autor E as tags
    $sql = "
        SELECT 
            a.*, 
            u.nome_exibicao AS nome_autor,
            -- Agrupa todas as tags do artigo em uma única string separada por vírgula
            GROUP_CONCAT(t.nome) AS tags 
        FROM artigos_blog AS a
        LEFT JOIN usuarios AS u ON a.autor_id = u.id
        LEFT JOIN artigo_tags AS at ON a.id = at.artigo_id
        LEFT JOIN tags AS t ON at.tag_id = t.id
        WHERE a.id = :id
        GROUP BY a.id -- Agrupa para o GROUP_CONCAT funcionar
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $artigo_id]);
    $artigo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se $artigo for falso (não encontrou), redireciona
    if (!$artigo) {
        $_SESSION['msg_erro'] = "Artigo não encontrado.";
        header("Location: " . BASE_URL . "Blog/blog_home.php");
        exit;
    }

} catch (PDOException $e) {
    error_log("Erro ao buscar artigo: " . $e->getMessage());
    $_SESSION['msg_erro'] = "Erro ao carregar o artigo.";
    header("Location: " . BASE_URL . "Blog/blog_home.php");
    exit;
}

// 4. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/blog-article.css" />

<section class="article-hero">
  <div class="article-hero-content">
    <p class="article-category"><?php echo htmlspecialchars($artigo['categoria']); ?></p>
    <h1><?php echo htmlspecialchars($artigo['titulo']); ?></h1>
    <p class="article-subtitle">
      <?php echo htmlspecialchars($artigo['resumo']); ?>
    </p>
    <div class="article-meta">
      <span class="author">
        <i class="ri-user-line"></i> 
        Por <?php echo htmlspecialchars($artigo['nome_autor'] ?? 'Equipe WonderFly'); ?>
      </span>
      <span class="date">
        <i class="ri-calendar-line"></i> 
        <?php echo date('d \d\e F \d\e Y', strtotime($artigo['data_publicacao'])); ?>
      </span>
      </div>
  </div>
</section>

<section class="section article-content-section">
  <div class="article-main">
    <img
      src="<?php 
            // Carrega a URL da imagem do banco
            $img_url = filter_var($artigo['imagem_destaque_url'], FILTER_VALIDATE_URL) 
                        ? $artigo['imagem_destaque_url'] 
                        : BASE_URL . $artigo['imagem_destaque_url'];
            echo htmlspecialchars($img_url); 
        ?>"
      alt="<?php echo htmlspecialchars($artigo['titulo']); ?>"
      class="article-featured-image"
    />
    <div class="article-body">
        <?php 
            // Aqui nós renderizamos o HTML salvo no banco.
            // (IMPORTANTE: Se você não confia em quem escreve os posts,
            // isso precisa ser "sanitizado" para evitar ataques XSS)
            echo $artigo['conteudo_html']; 
        ?>
    </div>
    </div>

  <section class.="section article-content-section">
  <div class="article-main">
    <div class="article-tags">
      <?php if (!empty($artigo['tags'])): ?>
        <?php 
          // Transforma a string "Ásia,Himalaia,Cultura" em um array
          $tags_array = explode(',', $artigo['tags']); 
        ?>
        <?php foreach ($tags_array as $tag_nome): ?>
            <span class="tag">
                <a href="<?php echo BASE_URL; ?>Blog/blog_home.php?tag=<?php echo urlencode($tag_nome); ?>">
                    #<?php echo htmlspecialchars($tag_nome); ?>
                </a>
            </span>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  <aside class="article-sidebar">
    <div class="sidebar-block">
      <h4>Mais da WonderFly</h4>
      <ul class="sidebar-links">
        <li><a href="#">Roteiro: Marrocos Essencial</a></li>
        <li><a href="#">Guia Completo: Templos do Camboja</a></li>
      </ul>
    </div>
  </aside>
</section>

<section class="cta-newsletter">
  <div class="cta-inner">
    <h3>Ganhe R$ 200 de desconto no 1º pacote</h3>
    <p>
      Assine a newsletter e receba roteiros, dicas e ofertas exclusivas.
    </p>
    <form class="newsletter" id="newsletter">
      <input type="email" placeholder="Seu e-mail" required />
      <button class="btn white" type="submit">Quero receber</button>
    </form>
  </div>
</section>

<?php
// 5. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

</body>
</html>