<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/comunidade.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/topico.css"> 

<main>
    <section class="section topic-content">
        <div class="topic-breadcrumb">
            <a href="<?php echo BASE_URL; ?>Comunidade/home_comunidade.php">
                <i class="ri-arrow-left-s-line"></i> Voltar para a Comunidade
            </a>
        </div>

        <div id="original-post-container">
            <div class="op-loading">
                <i class="ri-loader-4-line ri-spin"></i>
                <h2>Carregando tópico...</h2>
            </div>
        </div>

        <div class="replies-section">
            <h2 id="reply-count">Respostas (0)</h2>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form class="reply-form" id="reply-form">
                    <h3>Deixar uma Resposta</h3>
                    <div class="form-group">
                        <textarea id="reply-message" name="message" rows="5" placeholder="Digite sua mensagem aqui..." required></textarea>
                    </div>
                    <button type="submit" class="btn primary">Publicar Resposta</button>
                </form>
            <?php else: ?>
                <div class="reply-form-login">
                    <a href="<?php echo BASE_URL; ?>Login/login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
                        Faça login para responder
                    </a>
                </div>
            <?php endif; ?>

            <div class="replies-list" id="replies-list-container">
                </div>
        </div>
    </section>
</main>

<?php
// 3. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    const baseUrl = '<?php echo BASE_URL; ?>';
    // Passa o status de login para o JS (para saber se pode apagar)
    const isUserLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    const currentUserId = <?php echo $_SESSION['user_id'] ?? 'null'; ?>;
</script>
<script src="<?php echo BASE_URL; ?>JS/topico.js"></script>
</body>
</html>