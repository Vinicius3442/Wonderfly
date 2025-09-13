document.addEventListener('DOMContentLoaded', () => {
    // Ano atual para o footer
    const yearSpan = document.getElementById('year');
    if (yearSpan) {
        yearSpan.textContent = new Date().getFullYear();
    }

    // Lógica para o menu hamburguer (se você tiver)
    const burger = document.getElementById('burger');
    const nav = document.getElementById('nav');
    if (burger && nav) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('active'); // Adicione uma classe 'active' para exibir o menu mobile
        });
    }

    // Lógica para o Quiz Modal
    const btnOpenQuiz = document.getElementById('btn-open-quiz');
    const closeQuiz = document.getElementById('close-quiz');
    const quizModal = document.getElementById('quiz');
    const quizForm = document.getElementById('quiz-form');
    const quizResult = document.getElementById('quiz-result');

    if (btnOpenQuiz && closeQuiz && quizModal && quizForm && quizResult) {
        btnOpenQuiz.addEventListener('click', () => {
            quizModal.classList.add('show');
        });

        closeQuiz.addEventListener('click', () => {
            quizModal.classList.remove('show');
            quizResult.setAttribute('hidden', ''); // Esconde o resultado ao fechar
            quizForm.reset(); // Reseta o formulário
        });

        // Fechar o modal clicando fora do conteúdo (opcional)
        quizModal.addEventListener('click', (e) => {
            if (e.target === quizModal) {
                quizModal.classList.remove('show');
                quizResult.setAttribute('hidden', '');
                quizForm.reset();
            }
        });

        // Lógica de submissão do formulário do quiz
        quizForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const formData = new FormData(quizForm);
            const tema = formData.get('tema');
            const orcamento = formData.get('orcamento');
            const estilo = formData.get('estilo');

            let suggestion = '';

            // Lógica de sugestão (simplificada para demonstração)
            if (tema === 'gastronomia' && orcamento === 'medio') {
                suggestion = 'Para você, o ideal é uma aventura gastronômica no Vietnã! Hanói te espera com sua street food incrível.';
            } else if (tema === 'natureza' && estilo === 'mochilao') {
                suggestion = 'Que tal explorar as trilhas e vulcões da Indonésia? A ilha de Java é perfeita para mochileiros aventureiros.';
            } else if (tema === 'festivais' && orcamento === 'alto') {
                suggestion = 'A Índia durante o festival Holi seria uma experiência inesquecível e cheia de cores para você!';
            } else if (tema === 'historia' && orcamento === 'baixo') {
                suggestion = 'Mergulhe na história milenar do Egito, explorando pirâmides e templos com um orçamento mais acessível.';
            } else if (tema === 'comunidades' && estilo === 'conforto') {
                suggestion = 'Conecte-se com as culturas autênticas da Etiópia, com roteiros que proporcionam conforto e imersão cultural.';
            } else {
                suggestion = 'Temos muitas opções incríveis! Entre em contato para montarmos seu roteiro ideal.';
            }

            quizResult.innerHTML = `<p>${suggestion}</p><a href="#" class="btn primary mt-3">Ver pacotes sugeridos</a>`;
            quizResult.removeAttribute('hidden');
        });
    }
});