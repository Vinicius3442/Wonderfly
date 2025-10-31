<?php
// Arquivo: config.php

// 1. Inicia a sessão aqui. 
// Deve ser chamado ANTES de qualquer HTML.
session_start();

// 2. Define o caminho absoluto do servidor.
// __DIR__ é uma constante mágica do PHP que pega o caminho da pasta ATUAL (a raiz).
// Isso garante que o PHP sempre saiba onde encontrar seus templates.
define('ROOT_PATH', __DIR__ . '/');
?>