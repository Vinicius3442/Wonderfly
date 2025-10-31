<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

$search_query = $_GET['busca'] ?? null;
$tag_query = $_GET['tag'] ?? null;

try {
    // --- CONSTRUÇÃO DINÂMICA DA QUERY ---
    
    // Base da Query
    $sql = "
        SELECT 
            a.id, a.titulo, a.resumo, a.imagem_destaque_url, a.data_publicacao,
            u.nome_exibicao AS nome_autor,
            GROUP_CONCAT(t.nome) AS tags
        FROM artigos_blog AS a
        LEFT JOIN usuarios AS u ON a.autor_id = u.id
        LEFT JOIN artigo_tags AS at ON a.id = at.artigo_id
        LEFT JOIN tags AS t ON at.tag_id = t.id
    ";
    
    $params = [];
    $where_clauses = [];

    // 1. Se estiver BUSCANDO (Full-Text Search)
    if ($search_query) {
        $where_clauses[] = "MATCH(a.titulo, a.resumo, a.conteudo_html) AGAINST(:busca IN BOOLEAN MODE)";
        $params[':busca'] = $search_query . '*'; // Adiciona wildcard
    }

    // 2. Se estiver FILTRANDO POR TAG
    if ($tag_query) {
        // Precisamos de um JOIN extra para *filtrar* (o JOIN de cima é só para *mostrar*)
        $sql .= " JOIN artigo_tags AS at_filter ON a.id = at_filter.artigo_id
                  JOIN tags AS t_filter ON at_filter.tag_id = t_filter.id ";
        $where_clauses[] = "t_filter.nome = :tag";
        $params[':tag'] = $tag_query;
    }

    // Junta as cláusulas WHERE
    if (!empty($where_clauses)) {
        $sql .= " WHERE " . implode(' AND ', $where_clauses);
    }
    
    // Agrupamento e Ordem
    $sql .= " GROUP BY a.id ORDER BY a.data_publicacao DESC";
    
    // Executa a query
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $artigos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $artigos = []; // Array vazio em caso de erro
    error_log("Erro ao buscar artigos: " . $e->getMessage());
}

// 3. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/CSS/blog-home.css" />

<section class="hero-blog">
  <div class="hero-blog-content">
    <h1>Blog WonderFly</h1>
    <p>
      Descubra o mundo com a WonderFly: dicas de viagem, guias de destinos e
      histórias inspiradoras para sua próxima aventura.
    </p>
  </div>
</section>

<section class="section blog-search">
    <form action="<?php echo BASE_URL; ?>Blog/blog_home.php" method="GET">
        <input type="text" name="busca" placeholder="Buscar no blog..." class="search-input" value="<?php echo htmlspecialchars($_GET['busca'] ?? ''); ?>">
        <button type="submit" class="btn primary">Buscar</button>
    </form>
</section>

<section class="section blog-posts">
  <div class="blog-grid">
    
    <?php if (empty($artigos)): ?>
        <p>Nenhum artigo publicado ainda. Volte em breve!</p>
    <?php else: ?>
        
        <?php foreach ($artigos as $artigo): ?>
            <article class="blog-post">
              <img
                src="<?php 
                    // Carrega a URL da imagem do banco
                    // (Verifica se é um link externo ou um upload interno)
                    $img_url = filter_var($artigo['imagem_destaque_url'], FILTER_VALIDATE_URL) 
                                ? $artigo['imagem_destaque_url'] 
                                : BASE_URL . $artigo['imagem_destaque_url'];
                    echo htmlspecialchars($img_url); 
                ?>"
                alt="<?php echo htmlspecialchars($artigo['titulo']); ?>"
              />
              <div class="post-body">
                <span class="badge"><?php echo htmlspecialchars($artigo['categoria']); ?></span>
                <h3><?php echo htmlspecialchars($artigo['titulo']); ?></h3>
                <p>
                  <?php echo htmlspecialchars($artigo['resumo']); ?>
                </p>
                <div class="post-meta">
                  <span>
                    <i class="ri-calendar-line"></i> 
                    <?php 
                        // Formata a data
                        echo date('d \d\e F \d\e Y', strtotime($artigo['data_publicacao'])); 
                    ?>
                  </span>
                  <span>
                    <i class="ri-user-line"></i> 
                    Por <?php echo htmlspecialchars($artigo['nome_autor'] ?? 'Equipe WonderFly'); ?>
                  </span>
                </div>
                <a href="<?php echo BASE_URL; ?>Blog/Artigos/artigo.php?id=<?php echo $artigo['id']; ?>" class="link">
                    Ler mais <i class="ri-arrow-right-line"></i>
                </a>
              </div>
            </article>
        <?php endforeach; ?>
        <?php endif; ?>

  </div>
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
include ROOT_PATH . 'templates/footer.php';
?>

</body>
</html>