<?php
// Inclui o config (sobe 1 nível para achar o config.php na raiz)
include '../config.php'; 
// Inclui o header
include ROOT_PATH . './templates/header.php';
?>
<link rel="stylesheet" href="../CSS/login.css">

<div class="container">
    <div class="image-section">
        </div>
    <div class="form-section">
        <div class="logo">
            <img src="../images/logo.png" alt="WonderFly Logo" />
            <span class="azul">Wonder</span><span class="laranja">Fly</span>
        </div>
        <h1>Bem-vindo de volta!</h1>
        <p class="description">
            Acesse sua conta para ver suas viagens e momentos salvos.
        </p>

        <?php 
            // AQUI EXIBIMOS AS MENSAGENS DE ERRO/SUCESSO
            exibirMensagens(); 
        ?>

        <form id="login-form" action="../api/logar_usuario.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="seu.email@exemplo.com" required />
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Sua senha" required />
            </div>
            <button type="submit">Entrar</button>
        </form>

        <div class="top-right-nav">
            Não tem uma conta?
            <a href="./Cadastro/cadastro.php">Crie uma agora</a>
        </div>
        
        </div>
</div>

<?php include ROOT_PATH . './templates/footer.php'; ?>

</body>
</html>