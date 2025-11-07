/* =============================================
   ARQUIVO: avaliacoes_acoes.js
   Funcionalidade de ações (excluir)
   ============================================= */

// 'baseUrl' é definido no <script> do avaliacoes.php
document.addEventListener('DOMContentLoaded', () => {

    const reviewsGrid = document.getElementById('all-reviews-grid');
    if (!reviewsGrid) return;

    // 1. Usa "delegação de evento" para ouvir cliques na grade inteira
    reviewsGrid.addEventListener('click', (e) => {
        // 2. Verifica se o clique foi no botão de excluir
        const deleteButton = e.target.closest('.btn-delete-review');
        
        if (deleteButton) {
            // 3. Pega o card pai e o ID da avaliação
            const card = deleteButton.closest('.testimonial-card');
            const reviewId = card.dataset.id;
            
            // 4. Mostra o pop-up de confirmação
            showDeleteConfirmation(reviewId, card);
        }
    });

    // 5. Função de confirmação (Swal)
    function showDeleteConfirmation(reviewId, cardElement) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e63946', // Vermelho
            cancelButtonColor: '#555',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // 6. Se confirmou, chama a API
                executeDelete(reviewId, cardElement);
            }
        });
    }

    // 7. Função que chama a API (fetch)
    async function executeDelete(reviewId, cardElement) {
        try {
            const response = await fetch(`${baseUrl}api/delete_avaliacao.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: reviewId })
            });

            if (!response.ok) throw new Error('Erro na resposta da rede.');

            const result = await response.json();

            if (result.success) {
                // 8. Remove o card do HTML e mostra sucesso
                cardElement.style.opacity = 0;
                setTimeout(() => {
                    cardElement.remove();
                    checkIfGridIsEmpty(); // Verifica se a grade ficou vazia
                }, 300); // Espera a animação de fade-out

                Swal.fire(
                    'Excluído!',
                    'Sua avaliação foi removida.',
                    'success'
                );
            } else {
                throw new Error(result.message || 'Erro ao excluir.');
            }

        } catch (error) {
            Swal.fire('Erro!', error.message, 'error');
        }
    }

    // 9. (Opcional) Verifica se a grade ficou vazia após a exclusão
    function checkIfGridIsEmpty() {
        const remainingCards = reviewsGrid.querySelectorAll('.testimonial-card').length;
        if (remainingCards === 0) {
            reviewsGrid.innerHTML = `
                <p style="text-align: center; grid-column: 1 / -1;">
                    Não há mais avaliações para mostrar.
                </p>
            `;
        }
    }
});