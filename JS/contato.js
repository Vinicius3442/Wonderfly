/* =============================================
   ARQUIVO: JS/contato.js
   Lógica do formulário de contato com EmailJS
   ============================================= */
document.addEventListener('DOMContentLoaded', () => {
    
    // (A 'baseUrl' não é necessária aqui, mas é bom ter o padrão)

    const contactForm = document.getElementById('contact-form');
    const submitButton = document.getElementById('submit-btn');

    // Inicializa o EmailJS com sua Public Key
    // TROQUE PELA SUA CHAVE
    emailjs.init({
      publicKey: 'SUA_PUBLIC_KEY_AQUI', 
    });

    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Impede o envio padrão

            const btnOriginalText = submitButton.innerHTML;
            submitButton.innerHTML = 'Enviando...';
            submitButton.disabled = true;

            // TROQUE PELOS SEUS IDs
            const serviceID = 'service_dzli1jr';
            const templateID = 'template_bq1r32m';

            try {
                // Envia os dados do formulário
                const result = await emailjs.sendForm(serviceID, templateID, contactForm);
                
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