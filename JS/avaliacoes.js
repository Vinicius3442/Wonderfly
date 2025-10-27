/* =============================================
   ARQUIVO: avaliacoes.js
   Funcionalidade da página de avaliações
   ============================================= */

// Espera o HTML carregar completamente antes de rodar o script
document.addEventListener("DOMContentLoaded", () => {
  // 1. Seleciona os elementos principais
  const form = document.getElementById("form-avaliacao");
  const reviewsGrid = document.getElementById("all-reviews-grid");

  // 2. Adiciona um "ouvinte" para o evento de 'submit' do formulário
  form.addEventListener("submit", (event) => {
    // 3. Previne o comportamento padrão do formulário (que é recarregar a página)
    event.preventDefault();

    // 4. Captura os valores dos campos do formulário
    const nome = document.getElementById("autor-nome").value;
    const viagem = document.getElementById("autor-viagem").value;
    const mensagem = document.getElementById("autor-mensagem").value;

    // 5. Captura a nota (estrelas)
    // Busca pelo input de rádio (estrela) que está marcado
    const ratingInput = document.querySelector('input[name="rating"]:checked');

    // Validação: Verifica se o usuário selecionou uma nota
    if (!ratingInput) {
      alert("Por favor, selecione uma nota (de 1 a 5 estrelas).");
      return; // Para a execução se não tiver nota
    }
    const nota = ratingInput.value; // Ex: "5", "4", etc.

    // 6. Cria o HTML para as estrelas da nota
    const starsHTML = generateStarsHTML(nota);

    // 7. Cria o novo card de avaliação
    const newReviewCard = document.createElement("div");
    newReviewCard.classList.add("testimonial-card"); // Usa a mesma classe do global.css

    // Define o conteúdo HTML do novo card com os dados do formulário
    newReviewCard.innerHTML = `
      <div class="stars">
        ${starsHTML}
      </div>
      <p class="quote">
        "${mensagem}"
      </p>
      <div class="profile">
        <img src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?q=80&w=100" alt="Avatar do usuário" />
        <div>
          <h4>${nome}</h4>
          <span>Viagem: ${viagem}</span>
        </div>
      </div>
    `;

    // 8. Adiciona o novo card à grade de avaliações
    // .prepend() adiciona o novo card no INÍCIO da lista
    reviewsGrid.prepend(newReviewCard);

    // 9. Limpa o formulário após o envio
    form.reset();

    // 10. (Opcional) Rola a página para que o novo comentário fique visível
    newReviewCard.scrollIntoView({ behavior: "smooth", block: "center" });
  });

  /**
   * Função auxiliar para criar o HTML das estrelas
   * @param {string} nota - A nota de 1 a 5
   * @returns {string} - O HTML com os ícones de estrela
   */
  function generateStarsHTML(nota) {
    let stars = "";
    const notaNumerica = parseInt(nota); // Converte "5" para 5

    for (let i = 1; i <= 5; i++) {
      if (i <= notaNumerica) {
        // Estrela cheia
        stars += '<i class="fa-solid fa-star"></i> ';
      } else {
        // Estrela vazia
        stars += '<i class="fa-regular fa-star"></i> ';
      }
    }
    return stars;
  }
});