<?php
// Inclui o config (que sobe 2 níveis para achar o config.php na raiz)
include '../../config.php'; 
// Inclui o header (usando o ROOT_PATH)
include ROOT_PATH . './templates/header.php';
?>
<link rel="stylesheet" href="../../CSS/login.css">

<div class="container">
    <div class="image-section">
        </div>
    <div class="form-section">
        <div class="logo">
            <img src="../../images/logo.png" alt="WonderFly Logo">
            <span class="blue">Wonder</span><span class="orange">Fly</span>
        </div>
        <h1>Crie sua conta</h1>
        <p class="description">Junte-se a nós e comece a planejar sua próxima grande aventura!</p>
        
        <?php 
            // AQUI EXIBIMOS AS MENSAGENS DE ERRO
            exibirMensagens(); 
        ?>

        <form id="cadastro-form" action="../../api/registrar_usuario.php" method="POST">
            <div class="form-group">
                <label for="nomeCompleto">Nome Completo</label>
                <input type="text" id="nomeCompleto" name="nome" placeholder="Seu nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="seu.email@exemplo.com" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Mínimo 8 caracteres" required minlength="8">
                <div class="hint">Mínimo 8 caracteres.</div>
            </div>
            <div class="form-group">
                <label for="confirmarSenha">Confirmar Senha</label>
                <input type="password" id="confirmarSenha" name="senha_confirm" placeholder="Repita sua senha" required>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="aceitarTermos" name="aceitarTermos" required>
                <label for="aceitarTermos">
                    Eu concordo com os <a href="../../Legal/termos.html">Termos de Uso</a> e <a href="../../Legal/privacidade.html">Política de Privacidade</a>.
                </label>
            </div>

            <button type="submit">Cadastrar</button>
        </form>

        <div class="top-right-nav">
            Já tem uma conta? <a href="../login.php">Faça login aqui</a>
        </div>
    </div>
</div>
    
<?php include ROOT_PATH . './templates/footer.php'; ?>

</body>
</html>