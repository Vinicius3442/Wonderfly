<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// Inclui a conexão
include '../db_connect.php';

// (Não precisamos buscar dados aqui, o JS fará isso)

// 2. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/comunidade.css"> 

<main>
    <section class="community-header">
        <div class="community-header-content">
            <h1>Comunidade WonderFly</h1>
            <p>Compartilhe dicas, encontre companhias e tire suas dúvidas sobre viagens.</p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <button class="btn primary lg" id="start-thread-btn">
                    <i class="ri-add-line"></i> Criar Novo Tópico
                </button>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>Login/login.php" class="btn primary lg">
                    <i class="ri-login-box-line"></i> Faça login para criar um tópico
                </a>
            <?php endif; ?>
        </div>
    </section>
    
    <section class="section community-content">
        <div class="board-filter" id="board-filter-chips">
            <button class="chip active" data-board="all">Todos</button>
            <button class="chip" data-board="avaliacoes">Avaliações</button>
            <button class="chip" data-board="dicas">Dicas</button>
            <button class="chip" data-board="roteiros">Roteiros</button>
            <button class="chip" data-board="companhia">Companhia</button>
            <button class="chip" data-board="fotografia">Fotografia</button>
            <button class="chip" data-board="perrengues">Perrengues</button>
        </div>

        <div class="thread-list" id="thread-list-container">
            <div class="thread-list-placeholder">
                <i class="ri-loader-4-line ri-spin"></i>
                <h3>Carregando tópicos...</h3>
            </div>
        </div>
    </section>

    <section class="section review-highlight alt">
        </section>
</main>

<?php if (isset($_SESSION['user_id'])): ?>
<div class="modal" id="new-thread-modal">
    <div class="modal-content">
        <button class="modal-close" id="modal-close-btn">&times;</button>
        <h2>Criar Novo Tópico</h2>
        
        <form id="new-thread-form">
            <div class="form-group">
                <label for="thread-board">Categoria</label>
                <select id="thread-board" name="board" required>
                    <option value="avaliacoes">Avaliação de Viagem</option>
                    <option value="dicas">Dicas</option>
                    <option value="roteiros">Roteiros</option>
                    <option value="companhia">Companhia</option>
                    <option value="fotografia">Fotografia</option>
                    <option value="perrengues">Perrengues</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="thread-subject">Assunto</label>
                <input type="text" id="thread-subject" name="subject" required placeholder="Ex: Melhor chip de internet na Europa?">
            </div>
            
            <div class="form-group">
                <label for="thread-message">Mensagem</label>
                <textarea id="thread-message" name="message" rows="5" placeholder="Descreva sua dúvida ou compartilhe sua dica..."></textarea>
            </div>

            <div class="form-group">
                <label for="thread-image">Foto (Opcional)</label>
                <input type="file" id="thread-image" name="imagem" accept="image/*">
            </div>
            
            <button type="submit" class="btn primary full-width">Publicar Tópico</button>
        </form>
    </div>
</div>
<?php endif; ?>

<?php
// 3. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    const baseUrl = '<?php echo BASE_URL; ?>';
    // Passa o status de login para o JS
    const isUserLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
</script>
<script src="<?php echo BASE_URL; ?>JS/comunidade.js"></script>
</body>
</html>