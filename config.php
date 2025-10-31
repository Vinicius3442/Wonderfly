<?php
session_start();
define('ROOT_PATH', __DIR__ . '/');

/**
 * Cria o HTML das estrelas com base em uma nota.
 * @param int $nota - A nota de 1 a 5
 * @return string - O HTML com os ícones de estrela
 */
function generateStarsHTML($nota) {
    $stars = "";
    $notaNumerica = intval($nota); // Garante que é um número

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $notaNumerica) {
            // Estrela cheia
            $stars .= '<i class="fa-solid fa-star"></i> ';
        } else {
            // Estrela vazia (FontAwesome 6 usa 'regular')
            $stars .= '<i class="fa-regular fa-star"></i> ';
        }
    }
    return $stars;
}
?>
?>