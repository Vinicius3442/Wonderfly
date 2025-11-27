document.addEventListener('DOMContentLoaded', () => {
    // A 'baseUrl' é definida no <script> do home_viagem.php

    // Delegação de evento GLOBAL: Ouve cliques em qualquer lugar do corpo
    document.body.addEventListener('click', async (e) => {
        // Verifica se o clique foi em um botão de favoritar (ou dentro dele)
        const favButton = e.target.closest('.btn-favorito');

        if (!favButton) return; // Se não for, ignora o clique

        // Previne comportamento padrão (se for link)
        e.preventDefault();

        const viagemId = favButton.dataset.id;

        try {
            const response = await fetch(`${baseUrl}api/toggle_favorito.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ viagem_id: viagemId })
            });

            if (!response.ok) {
                // Tenta ler o erro do JSON
                const errData = await response.json().catch(() => ({}));
                throw new Error(errData.message || 'Falha na resposta do servidor.');
            }

            const result = await response.json();

            if (result.success) {
                // Sucesso: Inverte a classe 'active' do botão
                if (result.action === 'added') {
                    favButton.classList.add('active');
                    showToast('Adicionado à Lista de Desejos!');
                } else {
                    favButton.classList.remove('active');
                    showToast('Removido da Lista de Desejos.');
                }
            } else {
                // Se falhar (ex: não está logado), redireciona para o login
                if (result.message && result.message.includes('autenticado')) {
                    Swal.fire({
                        title: 'Faça Login',
                        text: 'Você precisa estar logado para salvar viagens na sua lista.',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#f07913',
                        confirmButtonText: 'Fazer Login',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `${baseUrl}Login/login.php`;
                        }
                    });
                } else {
                    showToast(result.message || 'Erro desconhecido');
                }
            }
        } catch (error) {
            console.error('Erro ao favoritar:', error);
            showToast('Erro: ' + error.message);
        }
    });

    // Função helper para mostrar uma notificação (toast)
    function showToast(message) {
        // Usa SweetAlert2 (que já está no seu perfil.js, então deve estar disponível)
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            Toast.fire({ icon: 'success', title: message });
        } else {
            console.log(message); // Fallback
        }
    }
});