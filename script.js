// Mobile menu
const burger = document.getElementById('burger');
const nav = document.getElementById('nav');
burger?.addEventListener('click', () => nav.classList.toggle('open'));

// Carousel
const track = document.querySelector('.carousel-track');
const prev = document.querySelector('.carousel .prev');
const next = document.querySelector('.carousel .next');
let index = 0;
function updateCarousel(){
  const slides = document.querySelectorAll('.slide');
  const width = slides[0].clientWidth;
  track.style.transform = `translateX(${-index * (width + 12)}px)`;
}
next?.addEventListener('click', ()=>{ index = Math.min(index + 1, document.querySelectorAll('.slide').length - 1); updateCarousel(); });
prev?.addEventListener('click', ()=>{ index = Math.max(index - 1, 0); updateCarousel(); });
window.addEventListener('resize', updateCarousel);
updateCarousel();

// Newsletter
document.getElementById('newsletter')?.addEventListener('submit', (e)=>{
  e.preventDefault();
  alert('Valeu! Você receberá nossas melhores ofertas e dicas 💌');
  e.target.reset();
});

// Quiz
const modal = document.getElementById('quiz');
const btnOpenQuiz = document.getElementById('btn-open-quiz');
const btnCloseQuiz = document.getElementById('close-quiz');
const result = document.getElementById('quiz-result');

btnOpenQuiz?.addEventListener('click', ()=> modal.style.display = 'flex');
btnCloseQuiz?.addEventListener('click', ()=> modal.style.display = 'none');
modal?.addEventListener('click', (e)=>{ if(e.target === modal) modal.style.display = 'none'; });

document.getElementById('quiz-form')?.addEventListener('submit', (e)=>{
  e.preventDefault();
  const data = Object.fromEntries(new FormData(e.target));
  const sugestoes = {
    gastronomia: 'Hanói (Vietnã) — tour street food + aula de culinária.',
    natureza: 'Ilha de Java (Indonésia) — trilhas nos vulcões Bromo e Ijen.',
    festivais: 'Chiang Mai (Tailândia) — Songkran com curadoria WonderFly.',
    historia: 'Isfahan & Yazd (Irã) — arquitetura persa e bazares históricos.',
    comunidades: 'Vale do Omo (Etiópia) — imersão em comunidades locais.'
  };
  const preco = { baixo: 'até R$ 4 mil', medio: 'entre R$ 4–7 mil', alto: 'acima de R$ 7 mil' };
  result.innerHTML = `
    <strong>Sua vibe:</strong> ${data.tema} • <strong>Orçamento:</strong> ${preco[data.orcamento]} • <strong>Estilo:</strong> ${data.estilo}<br><br>
    <strong>Sugestão:</strong> ${sugestoes[data.tema]}
  `;
  result.hidden = false;
});

// Copy year
document.getElementById('year').textContent = new Date().getFullYear();
