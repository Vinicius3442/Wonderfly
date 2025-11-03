<?php
// 1. Inclui o config (sobe 1 nível)
include '../config.php'; 
// (db_connect.php não é necessário aqui, a menos que você queira salvar os contatos no banco)

// 2. Inclui o Header
include ROOT_PATH . 'templates/header.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>CSS/contato.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<section class="hero-contact">
    <div class="hero-contact-content">
        <h1>Fale Conosco!</h1>
    </div>
</section>

<section class="section contact-details">
    <div class="contact-grid">
        <div class="contact-card">
            <i class="ri-mail-line"></i>
            <h4>E-mail</h4>
            <p>Para dúvidas gerais e suporte.</p>
            <a href="mailto:oi@wonderfly.com" class="link">oi@wonderfly.com</a>
        </div>
        <div class="contact-card">
            <i class="ri-phone-line"></i>
            <h4>Telefone</h4>
            <p>Atendimento de segunda à sábado, das 08h às 21h.</p>
            <a href="tel:+5511999999999" class="link">(11) 99999-9999</a>
        </div>
        <div class="contact-card">
            <i class="ri-whatsapp-line"></i>
            <h4>WhatsApp</h4>
            <p>Tire dúvidas rápidas ou solicite um atendimento personalizado.</p>
            <a href="https://wa.me/5511999999999" target="_blank" class="link">Enviar mensagem</a>
        </div>
        <div class="contact-card">
            <i class="ri-map-pin-line"></i>
            <h4>Endereço</h4>
            <p>Visite-nos com hora marcada.</p>
            <p>Rua Exemplo, 123 - Centro, São Paulo - SP</p>
        </div>
    </div>
</section>

<section class="section alt contact-form-section">
    <div class="section-head">
        <h2>Envie-nos uma mensagem</h2>
    </div>
    
    <form class="contact-form" id="contact-form">
        <div class="form-group">
            <label for="name">Seu Nome Completo</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Seu E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="subject">Assunto</label>
            <input type="text" id="subject" name="subject">
        </div>
        <div class="form-group">
            <label for="message">Sua Mensagem</label>
            <textarea id="message" name="message" rows="6" required></textarea>
        </div>
        <button type="submit" class="btn primary lg" id="submit-btn">
            Enviar Mensagem <i class="ri-send-plane-line"></i>
        </button>
    </form>
</section>

<?php
// 3. Inclui o Footer
include ROOT_PATH . 'templates/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

<script>
    const baseUrl = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>JS/contato.js"></script>

</body>
</html>