/* =============================================
   ARQUIVO: JS/contato.js
   Lógica do formulário de contato com EmailJS
   ============================================= */
document.addEventListener('DOMContentLoaded', () => {

    // --- CONFIGURAÇÃO DO EMAILJS ---
    // Crie sua conta em https://www.emailjs.com/
    // E preencha os dados abaixo:
    const PUBLIC_KEY = 'tSRfpA16QKlRch5It';
    const SERVICE_ID = 'service_dzli1jr'; // Ex: service_xyz
    const TEMPLATE_ID = 'template_bq1r32m'; // Ex: template_abc

    const contactForm = document.getElementById('contact-form');
    const submitButton = document.getElementById('submit-btn');

    // Inicializa o EmailJS
    if (typeof emailjs !== 'undefined') {
        emailjs.init({
            publicKey: PUBLIC_KEY,
        });
    } else {
        console.error('EmailJS SDK não carregado.');
    }

    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Impede o envio padrão

            // VERIFICAÇÃO DE CONFIGURAÇÃO
            if (PUBLIC_KEY === 'SUA_PUBLIC_KEY_AQUI') {
                Swal.fire({
                    icon: 'info',
                    title: 'Configuração Necessária',
                    html: `
                        <p>Para o formulário funcionar, você precisa configurar o EmailJS.</p>
                        <ol style="text-align: left; margin-top: 10px;">
                            <li>Crie uma conta grátis em <a href="https://www.emailjs.com/" target="_blank">emailjs.com</a></li>
                            <li>Pegue sua <b>Public Key</b>, <b>Service ID</b> e <b>Template ID</b></li>
                            <li>Atualize as variáveis no arquivo <code>JS/contato.js</code></li>
                        </ol>
                    `
                });
                return;
            }

            const btnOriginalText = submitButton.innerHTML;
            submitButton.innerHTML = 'Enviando...';
            submitButton.disabled = true;

            try {
                // Envia os dados do formulário
                const result = await emailjs.sendForm(SERVICE_ID, TEMPLATE_ID, contactForm);

                console.log('EmailJS Success:', result);
                Swal.fire(
                    'Enviado!',
                    'Sua mensagem foi enviada com sucesso. Entraremos em contato em breve!',
                    'success'
                );
                contactForm.reset(); // Limpa o formulário

            } catch (error) {
                console.error('EmailJS Error:', error);
                Swal.fire(
                    'Oops...',
                    'Houve um erro ao enviar sua mensagem. Tente novamente mais tarde.',
                    'error'
                );
            } finally {
                // Restaura o botão
                submitButton.innerHTML = btnOriginalText;
                submitButton.disabled = false;
            }
        });
    }
});