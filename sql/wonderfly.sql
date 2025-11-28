-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2025 às 20:09
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wonderfly`
--
CREATE DATABASE IF NOT EXISTS `wonderfly` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wonderfly`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `artigos_blog`
--

CREATE TABLE `artigos_blog` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumo` text DEFAULT NULL,
  `conteudo_html` text NOT NULL,
  `imagem_destaque_url` varchar(255) DEFAULT NULL,
  `data_publicacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `autor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `artigos_blog`
--

INSERT INTO `artigos_blog` (`id`, `titulo`, `resumo`, `conteudo_html`, `imagem_destaque_url`, `data_publicacao`, `autor_id`) VALUES
(1, 'Butão: O Reino da Felicidade e Suas Montanhas Misteriosas', 'Explore o Butão, um reino escondido nas montanhas do Himalaia, conhecido por sua rica cultura, paisagens deslumbrantes e a busca pela felicidade genuína.', '<h2>Introdução: Um País Onde a Felicidade é Prioridade</h2><p>Escondido nas majestosas montanhas do Himalaia, o Butão se destaca como um dos destinos mais intrigantes e singulares do planeta. Diferente de muitos países que medem o sucesso pelo Produto Interno Bruto (PIB), o Butão adota a \"Felicidade Interna Bruta\" (FIB) como seu principal indicador de progresso. Essa filosofia permeia todos os aspectos da vida butanesa, desde as políticas governamentais até o dia a dia de seus habitantes.</p><p>Neste artigo, a WonderFly te convida a desvendar os mistérios e encantos desse reino isolado, explorando suas tradições milenares, paisagens deslumbrantes e a calorosa hospitalidade de seu povo.</p><h2>A Cultura e Tradições Butanesas</h2><p>A cultura do Butão é profundamente enraizada no Budismo Vajrayana...</p><img src=\"https://i0.wp.com/www.mochilaoadois.com.br/wp-content/uploads/2018/04/zhana_chham1_dzongdrakha_tshechu.jpg?w=700\" alt=\"Butaneses em trajes tradicionais\" class=\"article-image\"><figcaption class_=\"image-caption\">Dançarinos butaneses em máscaras tradicionais...</figcaption><h3>Os Tsechus: Festivais de Cor e Fé</h3><p>Os tsechus são eventos imperdíveis, repletos de danças sagradas...</p><h2>Paisagens Deslumbrantes e Aventura</h2><p>O Butão oferece paisagens de tirar o fôlego... a subida ao Ninho do Tigre (Paro Taktsang)...</p><blockquote class=\"pull-quote\">“Viajar para o Butão com a WonderFly foi mais do que uma viagem, foi uma transformação.”<span>— Ana Clara, viajante WonderFly.</span></blockquote><h3>Natureza Intocada e Sustentabilidade</h3><p>A preocupação com o meio ambiente é fundamental no Butão...</p><h2>Planeje Sua Viagem ao Butão com a WonderFly</h2><p>A WonderFly é especialista em conectar você a culturas autênticas...</p>', 'https://www.flipar.com.br/wp-content/uploads/2024/08/bhutan-2211514_640.jpg?20250518170531', '2025-10-19 13:00:00', 1),
(2, 'Dicas para Japão #1', 'Um breve resumo sobre a incrível experiência de viajar para Japão. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', '2024-09-06 19:16:12', 3),
(3, 'Roteiro em Roma #2', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', '2024-06-29 06:25:14', 3),
(4, 'Viagem para Japão #3', 'Um breve resumo sobre a incrível experiência de viajar para Japão. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2025-03-17 04:58:40', 3),
(5, 'Segredos de Nova York #4', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', '2024-02-10 07:33:15', 3),
(6, 'Viagem para Nova York #5', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', '2025-09-13 21:44:40', 3),
(7, 'Roteiro em Patagônia #6', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', '2025-01-02 10:26:30', 3),
(8, 'Explorando Brasil #7', 'Um breve resumo sobre a incrível experiência de viajar para Brasil. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2025-10-29 22:07:26', 3),
(9, 'Viagem para Alpes #8', 'Um breve resumo sobre a incrível experiência de viajar para Alpes. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', '2025-06-08 12:49:01', 3),
(10, 'O Melhor de Patagônia #9', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', '2024-04-10 14:48:04', 3),
(11, 'Férias em Egito #10', 'Um breve resumo sobre a incrível experiência de viajar para Egito. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', '2025-02-15 01:22:42', 3),
(12, 'Descobrindo Paris #11', 'Um breve resumo sobre a incrível experiência de viajar para Paris. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', '2025-04-12 18:31:34', 3),
(13, 'Férias em Londres #12', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', '2023-12-11 19:12:42', 3),
(14, 'Roteiro em Londres #13', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', '2024-04-13 15:59:45', 3),
(15, 'Explorando Bali #14', 'Um breve resumo sobre a incrível experiência de viajar para Bali. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', '2024-12-18 17:55:03', 3),
(16, 'Viagem para Londres #15', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80', '2025-03-14 06:05:47', 3),
(17, 'Explorando Patagônia #16', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=800&q=80', '2025-05-26 00:51:19', 3),
(18, 'Aventuras em Nova York #17', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80', '2025-03-25 00:21:10', 3),
(19, 'Roteiro em Paris #18', 'Um breve resumo sobre a incrível experiência de viajar para Paris. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?auto=format&fit=crop&w=800&q=80', '2024-10-04 03:46:15', 3),
(20, 'O Melhor de Patagônia #19', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?auto=format&fit=crop&w=800&q=80', '2025-11-04 02:53:52', 3),
(21, 'Viagem para Caribe #20', 'Um breve resumo sobre a incrível experiência de viajar para Caribe. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=800&q=80', '2025-10-04 10:24:10', 3),
(22, 'Dicas para Patagônia #21', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', '2024-07-10 17:12:06', 3),
(23, 'Descobrindo Machu Picchu #22', 'Um breve resumo sobre a incrível experiência de viajar para Machu Picchu. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', '2025-11-08 16:22:04', 3),
(24, 'Aventuras em Londres #23', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2025-04-27 19:07:54', 3),
(25, 'Descobrindo Patagônia #24', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', '2023-12-27 20:07:11', 3),
(26, 'Segredos de Patagônia #25', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', '2023-12-05 07:21:53', 3),
(27, 'Dicas para Nova York #26', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', '2024-06-15 07:03:22', 3),
(28, 'Aventuras em Tailândia #27', 'Um breve resumo sobre a incrível experiência de viajar para Tailândia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2025-02-16 06:22:49', 3),
(29, 'Descobrindo Nova York #28', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', '2024-07-20 09:11:55', 3),
(30, 'Férias em Islândia #29', 'Um breve resumo sobre a incrível experiência de viajar para Islândia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', '2024-06-01 06:46:08', 3),
(31, 'Segredos de Roma #30', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', '2024-09-08 06:52:16', 3),
(32, 'Descobrindo Tóquio #31', 'Um breve resumo sobre a incrível experiência de viajar para Tóquio. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', '2024-09-30 14:09:43', 3),
(33, 'A Magia de Paris #32', 'Um breve resumo sobre a incrível experiência de viajar para Paris. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', '2024-12-08 13:41:35', 3),
(34, 'O Melhor de Roma #33', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', '2024-11-04 22:50:45', 3),
(35, 'Viagem para Tailândia #34', 'Um breve resumo sobre a incrível experiência de viajar para Tailândia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', '2024-01-15 20:21:20', 3),
(36, 'Aventuras em Machu Picchu #35', 'Um breve resumo sobre a incrível experiência de viajar para Machu Picchu. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80', '2024-10-22 23:08:20', 3),
(37, 'O Melhor de Tóquio #36', 'Um breve resumo sobre a incrível experiência de viajar para Tóquio. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=800&q=80', '2023-12-22 04:04:42', 3),
(38, 'Viagem para Londres #37', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80', '2023-12-17 14:08:30', 3),
(39, 'Explorando Nova York #38', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?auto=format&fit=crop&w=800&q=80', '2025-02-08 04:41:31', 3),
(40, 'A Magia de Tailândia #39', 'Um breve resumo sobre a incrível experiência de viajar para Tailândia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?auto=format&fit=crop&w=800&q=80', '2024-11-05 19:17:21', 3),
(41, 'Dicas para Japão #40', 'Um breve resumo sobre a incrível experiência de viajar para Japão. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=800&q=80', '2025-10-22 18:58:05', 3),
(42, 'Segredos de Brasil #41', 'Um breve resumo sobre a incrível experiência de viajar para Brasil. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', '2025-10-25 09:05:59', 3),
(43, 'O Melhor de Patagônia #42', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', '2025-10-13 08:23:22', 3),
(44, 'A Magia de Caribe #43', 'Um breve resumo sobre a incrível experiência de viajar para Caribe. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2025-04-14 21:00:23', 3),
(45, 'O Melhor de Roma #44', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', '2025-10-11 08:03:47', 3),
(46, 'Aventuras em Nova York #45', 'Um breve resumo sobre a incrível experiência de viajar para Nova York. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', '2024-07-19 03:05:50', 3),
(47, 'Aventuras em Paris #46', 'Um breve resumo sobre a incrível experiência de viajar para Paris. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', '2024-10-24 13:45:02', 3),
(48, 'A Magia de Brasil #47', 'Um breve resumo sobre a incrível experiência de viajar para Brasil. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2024-06-24 13:17:51', 3),
(49, 'O Melhor de Alpes #48', 'Um breve resumo sobre a incrível experiência de viajar para Alpes. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', '2024-08-07 13:21:22', 3),
(50, 'Segredos de Paris #49', 'Um breve resumo sobre a incrível experiência de viajar para Paris. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', '2025-06-13 01:42:43', 3),
(51, 'Dicas para Patagônia #50', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', '2025-04-18 23:58:55', 3),
(52, 'Explorando Tóquio #51', 'Um breve resumo sobre a incrível experiência de viajar para Tóquio. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', '2024-11-27 05:46:22', 3),
(53, 'O Melhor de Machu Picchu #52', 'Um breve resumo sobre a incrível experiência de viajar para Machu Picchu. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', '2024-07-07 20:13:55', 3),
(54, 'A Magia de Islândia #53', 'Um breve resumo sobre a incrível experiência de viajar para Islândia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', '2025-08-17 00:33:20', 3),
(55, 'Férias em Paris #54', 'Um breve resumo sobre a incrível experiência de viajar para Paris. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', '2024-08-06 00:04:12', 3),
(56, 'O Melhor de Londres #55', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80', '2025-05-05 02:01:36', 3),
(57, 'Aventuras em Patagônia #56', 'Um breve resumo sobre a incrível experiência de viajar para Patagônia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=800&q=80', '2025-06-28 13:53:30', 3),
(58, 'Roteiro em Brasil #57', 'Um breve resumo sobre a incrível experiência de viajar para Brasil. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80', '2025-07-22 15:08:11', 3),
(59, 'Segredos de Egito #58', 'Um breve resumo sobre a incrível experiência de viajar para Egito. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?auto=format&fit=crop&w=800&q=80', '2025-11-21 08:25:22', 3),
(60, 'Segredos de Bali #59', 'Um breve resumo sobre a incrível experiência de viajar para Bali. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?auto=format&fit=crop&w=800&q=80', '2024-04-01 11:20:36', 3),
(61, 'Aventuras em Caribe #60', 'Um breve resumo sobre a incrível experiência de viajar para Caribe. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=800&q=80', '2024-06-05 22:07:19', 3),
(62, 'Segredos de Londres #61', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', '2024-01-28 04:38:50', 3),
(63, 'Descobrindo Roma #62', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', '2025-09-09 12:16:44', 3),
(64, 'Viagem para Bali #63', 'Um breve resumo sobre a incrível experiência de viajar para Bali. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2025-08-22 00:10:30', 3),
(65, 'Férias em Roma #64', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', '2024-09-22 23:18:31', 3),
(66, 'Explorando Roma #65', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', '2023-12-25 13:24:07', 3),
(67, 'A Magia de Roma #66', 'Um breve resumo sobre a incrível experiência de viajar para Roma. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', '2023-12-16 01:58:55', 3),
(68, 'Segredos de Londres #67', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2024-04-22 20:28:33', 3),
(69, 'Roteiro em Egito #68', 'Um breve resumo sobre a incrível experiência de viajar para Egito. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', '2024-01-11 18:46:14', 3),
(70, 'Explorando Egito #69', 'Um breve resumo sobre a incrível experiência de viajar para Egito. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', '2025-03-13 10:02:16', 3),
(71, 'Férias em Alpes #70', 'Um breve resumo sobre a incrível experiência de viajar para Alpes. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', '2025-04-13 06:35:17', 3),
(72, 'A Magia de Tóquio #71', 'Um breve resumo sobre a incrível experiência de viajar para Tóquio. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', '2024-03-14 20:00:18', 3),
(73, 'O Melhor de Londres #72', 'Um breve resumo sobre a incrível experiência de viajar para Londres. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', '2024-09-24 07:21:41', 3),
(74, 'Roteiro em Caribe #73', 'Um breve resumo sobre a incrível experiência de viajar para Caribe. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', '2025-04-21 06:39:34', 3),
(75, 'Descobrindo Tailândia #74', 'Um breve resumo sobre a incrível experiência de viajar para Tailândia. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Uma experiência única que vai mudar sua forma de ver o mundo. A cultura local é fascinante e a gastronomia é de tirar o fôlego. Recomendo a todos que buscam aventura e conhecimento.</p><h3>Dicas Importantes</h3><ul><li>Leve roupas confortáveis</li><li>Experimente a comida de rua</li><li>Respeite os costumes locais</li></ul>', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', '2024-05-01 16:21:16', 3);
INSERT INTO `artigos_blog` (`id`, `titulo`, `resumo`, `conteudo_html`, `imagem_destaque_url`, `data_publicacao`, `autor_id`) VALUES
(76, 'Dicas para Alpes #75', 'Um breve resumo sobre a incrível experiência de viajar para Alpes. Descubra dicas, roteiros e muito mais neste artigo completo.', '<p>Viajar é preciso! Neste artigo, compartilho minhas memórias favoritas desta viagem incrível. As paisagens são deslumbrantes e as pessoas muito acolhedoras.</p><p>Não deixe de visitar os pontos turísticos clássicos, mas também se permita perder pelas ruas e descobrir cantinhos escondidos.</p>', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80', '2024-05-25 18:22:17', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `artigo_tags`
--

CREATE TABLE `artigo_tags` (
  `artigo_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `artigo_tags`
--

INSERT INTO `artigo_tags` (`artigo_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL,
  `viagem_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `nota`, `mensagem`, `data_criacao`, `usuario_id`, `viagem_id`) VALUES
(1, 5, 'Experiência incrível, viagem impecável! A WonderFly cuidou de tudo, os guias locais eram fantásticos e o roteiro foi diferenciado.', '2025-10-31 11:56:41', 1, 1),
(2, 5, 'A melhor agência para quem busca imersão cultural. O festival Holi na Índia foi algo que jamais esquecerei. Seguro e autêntico.', '2025-10-31 11:56:41', 2, 2),
(4, 5, 'Teste', '2025-11-28 11:19:22', 3, 2),
(5, 3, 'Lugar maravilhoso, voltaria com certeza.', '2025-10-25 06:54:16', 149, 41),
(6, 5, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-08-17 00:44:58', 62, 3),
(7, 3, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-11-12 21:41:30', 115, 32),
(8, 3, 'A organização foi impecável, parabéns à equipe.', '2025-07-12 07:02:33', 33, 10),
(9, 4, 'Experiência única, recomendo a todos.', '2025-06-13 01:44:00', 149, 19),
(10, 5, 'Lugar maravilhoso, voltaria com certeza.', '2025-06-29 23:34:04', 40, 21),
(11, 5, 'Foi bom, mas esperava mais das atividades inclusas.', '2025-09-27 11:34:07', 2, 25),
(12, 3, 'Experiência única, recomendo a todos.', '2025-07-14 21:47:51', 123, 45),
(13, 4, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-11-01 08:59:19', 114, 9),
(14, 5, 'Simplesmente inesquecível!', '2025-08-24 03:42:33', 8, 11),
(15, 3, 'Simplesmente inesquecível!', '2025-09-25 01:35:28', 98, 1),
(16, 3, 'A organização foi impecável, parabéns à equipe.', '2025-09-06 04:03:18', 89, 7),
(17, 5, 'A organização foi impecável, parabéns à equipe.', '2025-06-18 09:32:45', 141, 19),
(18, 3, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-07-26 05:44:32', 47, 43),
(19, 5, 'Gostei muito, mas achei o hotel um pouco longe do centro.', '2025-09-17 22:35:34', 17, 5),
(20, 5, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-06-21 14:00:26', 122, 1),
(21, 3, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-09-30 16:37:04', 65, 22),
(22, 5, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-06-23 12:47:50', 3, 4),
(23, 5, 'Lugar maravilhoso, voltaria com certeza.', '2025-10-31 02:25:52', 57, 33),
(24, 5, 'Melhor viagem da minha vida.', '2025-10-23 00:17:24', 76, 18),
(25, 5, 'Lugar maravilhoso, voltaria com certeza.', '2025-07-04 06:13:26', 37, 53),
(26, 4, 'A organização foi impecável, parabéns à equipe.', '2025-10-17 12:37:43', 136, 37),
(27, 3, 'A organização foi impecável, parabéns à equipe.', '2025-06-22 16:48:38', 46, 52),
(28, 5, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-08-18 16:59:32', 32, 1),
(29, 5, 'Experiência única, recomendo a todos.', '2025-10-29 08:34:59', 84, 37),
(30, 4, 'Tudo perfeito, desde o voo até os passeios.', '2025-10-07 00:16:16', 75, 3),
(31, 3, 'Lugar maravilhoso, voltaria com certeza.', '2025-09-18 17:18:48', 146, 12),
(32, 3, 'Experiência única, recomendo a todos.', '2025-08-18 02:57:03', 9, 56),
(33, 3, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-11-11 12:36:02', 89, 21),
(34, 5, 'Foi bom, mas esperava mais das atividades inclusas.', '2025-06-09 04:15:18', 22, 10),
(35, 4, 'Melhor viagem da minha vida.', '2025-06-29 14:35:02', 11, 16),
(36, 4, 'Gostei muito, mas achei o hotel um pouco longe do centro.', '2025-08-27 13:37:58', 93, 24),
(37, 4, 'Simplesmente inesquecível!', '2025-11-15 12:46:02', 124, 59),
(38, 4, 'Tudo perfeito, desde o voo até os passeios.', '2025-06-30 18:46:21', 108, 39),
(39, 3, 'Viagem incrível! Superou todas as minhas expectativas.', '2025-10-21 04:11:33', 1, 58),
(40, 5, 'Simplesmente inesquecível!', '2025-10-22 17:21:10', 145, 31),
(41, 4, 'A organização foi impecável, parabéns à equipe.', '2025-07-19 13:29:03', 63, 30),
(42, 5, 'Melhor viagem da minha vida.', '2025-10-09 03:17:50', 31, 40),
(43, 5, 'Lugar maravilhoso, voltaria com certeza.', '2025-07-01 11:57:06', 115, 30),
(44, 5, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-10-22 05:47:20', 114, 1),
(45, 5, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-06-07 12:13:17', 132, 33),
(46, 3, 'Lugar maravilhoso, voltaria com certeza.', '2025-07-18 02:50:09', 100, 18),
(47, 3, 'Foi bom, mas esperava mais das atividades inclusas.', '2025-07-31 15:53:52', 127, 54),
(48, 3, 'Foi bom, mas esperava mais das atividades inclusas.', '2025-08-25 07:52:28', 17, 20),
(49, 3, 'Tudo perfeito, desde o voo até os passeios.', '2025-08-13 23:47:41', 95, 44),
(50, 3, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-11-24 03:27:28', 33, 8),
(51, 3, 'Gostei muito, mas achei o hotel um pouco longe do centro.', '2025-09-19 17:14:13', 126, 47),
(52, 5, 'A organização foi impecável, parabéns à equipe.', '2025-06-06 23:44:37', 82, 61),
(53, 3, 'Paisagens de tirar o fôlego e guia muito atencioso.', '2025-06-23 02:54:19', 47, 35),
(54, 5, 'Melhor viagem da minha vida.', '2025-07-16 03:57:11', 46, 51);

-- --------------------------------------------------------

--
-- Estrutura da tabela `favoritos_viagens`
--

CREATE TABLE `favoritos_viagens` (
  `usuario_id` int(11) NOT NULL,
  `viagem_id` int(11) NOT NULL,
  `data_favoritado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `favoritos_viagens`
--

INSERT INTO `favoritos_viagens` (`usuario_id`, `viagem_id`, `data_favoritado`) VALUES
(3, 1, '2025-11-28 15:17:59'),
(3, 13, '2025-11-28 17:12:32'),
(3, 42, '2025-11-28 17:12:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `momentos`
--

CREATE TABLE `momentos` (
  `id` int(11) NOT NULL,
  `descricao` text DEFAULT NULL,
  `foto_url` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `viagem_id` int(11) DEFAULT NULL,
  `data_viagem` date NOT NULL,
  `data_reserva` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`id`, `usuario_id`, `viagem_id`, `data_viagem`, `data_reserva`) VALUES
(1, 3, 1, '2024-05-10', '2025-10-31 13:01:56'),
(2, 3, 2, '2024-03-15', '2025-10-31 13:05:04'),
(3, 3, 2, '2025-11-07', '2025-11-07 11:33:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `topico_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `respostas`
--

INSERT INTO `respostas` (`id`, `mensagem`, `data_criacao`, `topico_id`, `usuario_id`) VALUES
(2, 'Acho que depende do seu orçamento.', '2025-07-16 00:18:09', 5, 80),
(3, 'Isso me ajudou muito, valeu!', '2025-07-17 12:47:50', 5, 81),
(4, 'Concordo plenamente.', '2025-02-28 21:33:36', 6, 64),
(5, 'Obrigado pelas dicas!', '2025-02-22 04:35:11', 6, 7),
(6, 'Acho que depende do seu orçamento.', '2025-11-22 21:55:01', 7, 37),
(7, 'Acho que depende do seu orçamento.', '2025-11-21 22:41:34', 7, 101),
(8, 'Alguém mais tem sugestões?', '2025-11-21 07:40:05', 7, 104),
(9, 'Isso me ajudou muito, valeu!', '2025-11-21 13:29:20', 7, 5),
(10, 'Isso me ajudou muito, valeu!', '2025-09-08 03:23:25', 9, 5),
(11, 'Obrigado pelas dicas!', '2025-09-14 17:50:45', 9, 116),
(12, 'Acho que depende do seu orçamento.', '2025-01-30 01:43:31', 10, 80),
(13, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-01-31 06:49:56', 10, 55),
(14, 'Obrigado pelas dicas!', '2025-10-28 01:39:46', 11, 117),
(15, 'Acho que depende do seu orçamento.', '2025-10-31 06:04:25', 11, 117),
(16, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-10-24 11:51:38', 11, 28),
(17, 'Ótimo tópico! Também tenho essa dúvida.', '2025-06-20 13:07:06', 12, 10),
(18, 'Isso me ajudou muito, valeu!', '2025-01-18 20:20:29', 14, 26),
(19, 'Concordo plenamente.', '2025-01-26 00:02:49', 14, 92),
(20, 'Acho que depende do seu orçamento.', '2025-01-25 06:43:42', 14, 107),
(21, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-01-21 05:44:26', 14, 134),
(22, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-01-17 23:50:55', 14, 142),
(23, 'Concordo plenamente.', '2025-06-02 22:25:07', 15, 91),
(24, 'Concordo plenamente.', '2025-05-29 01:09:24', 15, 87),
(25, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-07-19 13:24:14', 16, 17),
(26, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-07-17 09:55:08', 16, 80),
(27, 'Estou planejando ir em breve também.', '2025-07-19 15:01:39', 16, 60),
(28, 'Concordo plenamente.', '2024-12-17 18:19:58', 17, 114),
(29, 'Concordo plenamente.', '2024-12-19 23:04:54', 17, 21),
(30, 'Não esqueça de levar um adaptador de tomada.', '2024-12-14 16:07:38', 17, 42),
(31, 'Obrigado pelas dicas!', '2024-12-13 05:39:03', 17, 107),
(32, 'Concordo plenamente.', '2025-01-31 07:24:45', 18, 28),
(33, 'Estou planejando ir em breve também.', '2025-05-25 15:26:27', 19, 74),
(34, 'Alguém mais tem sugestões?', '2025-05-27 07:19:14', 19, 57),
(35, 'Não esqueça de levar um adaptador de tomada.', '2025-05-31 12:30:17', 19, 122),
(36, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-05-26 19:06:57', 19, 19),
(37, 'Que foto linda!', '2025-05-29 01:49:42', 19, 19),
(38, 'Isso me ajudou muito, valeu!', '2025-06-26 09:15:49', 20, 125),
(39, 'Obrigado pelas dicas!', '2025-06-24 09:04:11', 20, 7),
(40, 'Que foto linda!', '2025-06-21 08:17:57', 20, 56),
(41, 'Isso me ajudou muito, valeu!', '2025-06-22 04:01:36', 20, 84),
(42, 'Não esqueça de levar um adaptador de tomada.', '2025-06-25 14:00:57', 20, 143),
(43, 'Alguém mais tem sugestões?', '2025-03-18 07:54:42', 21, 143),
(44, 'Acho que depende do seu orçamento.', '2025-03-16 20:02:58', 21, 129),
(45, 'Isso me ajudou muito, valeu!', '2025-03-17 12:50:56', 21, 89),
(46, 'Não esqueça de levar um adaptador de tomada.', '2025-03-23 01:25:05', 21, 100),
(47, 'Não esqueça de levar um adaptador de tomada.', '2025-03-20 06:07:19', 21, 66),
(48, 'Que foto linda!', '2025-05-20 16:44:16', 23, 81),
(49, 'Não esqueça de levar um adaptador de tomada.', '2025-10-21 22:16:35', 24, 38),
(50, 'Isso me ajudou muito, valeu!', '2025-11-03 08:25:18', 27, 23),
(51, 'Alguém mais tem sugestões?', '2025-08-25 04:43:20', 29, 83),
(52, 'Isso me ajudou muito, valeu!', '2025-08-24 04:42:40', 29, 16),
(53, 'Estou planejando ir em breve também.', '2025-08-28 01:01:46', 29, 150),
(54, 'Alguém mais tem sugestões?', '2025-08-19 13:58:26', 29, 24),
(55, 'Isso me ajudou muito, valeu!', '2025-08-26 02:10:54', 29, 120),
(56, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2025-01-11 15:05:36', 30, 110),
(57, 'Ótimo tópico! Também tenho essa dúvida.', '2025-01-10 13:16:10', 30, 85),
(58, 'Estou planejando ir em breve também.', '2025-01-07 21:49:56', 30, 75),
(59, 'Que foto linda!', '2025-01-04 19:29:47', 30, 14),
(60, 'Concordo plenamente.', '2025-01-08 01:50:53', 30, 61),
(61, 'Não esqueça de levar um adaptador de tomada.', '2024-12-07 17:40:12', 31, 18),
(62, 'Ótimo tópico! Também tenho essa dúvida.', '2024-12-03 04:28:53', 31, 20),
(63, 'Não esqueça de levar um adaptador de tomada.', '2024-11-29 15:36:11', 31, 147),
(64, 'Eu fui ano passado e foi incrível. Recomendo muito!', '2024-12-02 11:41:49', 31, 42),
(65, 'Ótimo tópico! Também tenho essa dúvida.', '2024-12-01 10:59:22', 31, 83),
(66, 'Alguém mais tem sugestões?', '2025-06-18 11:52:16', 32, 103),
(67, 'Acho que depende do seu orçamento.', '2025-06-24 16:39:24', 32, 108),
(68, 'Isso me ajudou muito, valeu!', '2025-02-03 20:20:11', 33, 144);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tags`
--

INSERT INTO `tags` (`id`, `nome`) VALUES
(2, 'Ásia'),
(1, 'Butão'),
(4, 'Cultura'),
(6, 'Destinos Exóticos'),
(5, 'Espiritualidade'),
(3, 'Himalaia'),
(7, 'Turismo Responsável');

-- --------------------------------------------------------

--
-- Estrutura da tabela `topicos`
--

CREATE TABLE `topicos` (
  `id` int(11) NOT NULL,
  `assunto` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `board` varchar(50) NOT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `topicos`
--

INSERT INTO `topicos` (`id`, `assunto`, `mensagem`, `board`, `imagem_url`, `data_criacao`, `usuario_id`) VALUES
(4, 'Melhor época para ir ao Caribe? #1', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Melhor época para ir ao Caribe? #1', 'Geral', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', '2025-04-13 08:46:51', 40),
(5, 'Seguro viagem: qual escolher? #2', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Seguro viagem: qual escolher? #2', 'Dicas', NULL, '2025-07-09 21:42:52', 101),
(6, 'Dicas de roteiro na Europa #3', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Dicas de roteiro na Europa #3', 'Geral', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2025-02-21 08:43:14', 96),
(7, 'Seguro viagem: qual escolher? #4', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Seguro viagem: qual escolher? #4', 'Geral', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', '2025-11-13 07:41:45', 47),
(8, 'Viagem solo: vale a pena? #5', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Viagem solo: vale a pena? #5', 'Dicas', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', '2025-08-14 15:11:17', 42),
(9, 'Dicas de roteiro na Europa #6', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Dicas de roteiro na Europa #6', 'Dicas', NULL, '2025-09-07 13:02:48', 122),
(10, 'Viagem solo: vale a pena? #7', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Viagem solo: vale a pena? #7', 'Dicas', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', '2025-01-28 12:04:29', 80),
(11, 'Dicas de roteiro na Europa #8', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Dicas de roteiro na Europa #8', 'Dicas', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2025-10-23 13:27:37', 76),
(12, 'Procurando companhia para mochilão #9', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Procurando companhia para mochilão #9', 'Geral', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', '2025-06-19 11:38:42', 117),
(13, 'Viagem solo: vale a pena? #10', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Viagem solo: vale a pena? #10', 'Relatos', NULL, '2025-10-29 07:06:29', 142),
(14, 'Como economizar em passagens aéreas #11', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Como economizar em passagens aéreas #11', 'Dicas', NULL, '2025-01-17 19:46:44', 121),
(15, 'Alguém já foi para o Japão? #12', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Alguém já foi para o Japão? #12', 'Relatos', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', '2025-05-25 05:45:15', 38),
(16, 'Melhor época para ir ao Caribe? #13', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Melhor época para ir ao Caribe? #13', 'Geral', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2025-07-14 09:19:45', 70),
(17, 'Alguém já foi para o Japão? #14', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Alguém já foi para o Japão? #14', 'Relatos', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2024-12-12 23:50:02', 101),
(18, 'Roteiro de 15 dias na Itália #15', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Roteiro de 15 dias na Itália #15', 'Geral', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2025-01-25 16:05:23', 146),
(19, 'Viagem solo: vale a pena? #16', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Viagem solo: vale a pena? #16', 'Companhia', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', '2025-05-22 16:44:18', 67),
(20, 'Como economizar em passagens aéreas #17', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Como economizar em passagens aéreas #17', 'Geral', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', '2025-06-16 09:55:59', 45),
(21, 'Minha experiência em Bali #18', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Minha experiência em Bali #18', 'Companhia', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', '2025-03-15 12:51:44', 107),
(22, 'Procurando companhia para mochilão #19', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Procurando companhia para mochilão #19', 'Relatos', NULL, '2025-07-30 17:21:40', 17),
(23, 'Alguém já foi para o Japão? #20', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Alguém já foi para o Japão? #20', 'Companhia', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', '2025-05-12 12:34:25', 66),
(24, 'Viagem solo: vale a pena? #21', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Viagem solo: vale a pena? #21', 'Relatos', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', '2025-10-18 16:33:37', 21),
(25, 'Procurando companhia para mochilão #22', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Procurando companhia para mochilão #22', 'Companhia', NULL, '2025-07-26 02:31:12', 119),
(26, 'Alguém já foi para o Japão? #23', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Alguém já foi para o Japão? #23', 'Dicas', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', '2024-12-02 11:37:35', 126),
(27, 'Dicas de roteiro na Europa #24', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Dicas de roteiro na Europa #24', 'Geral', NULL, '2025-10-27 04:50:40', 76),
(28, 'Dicas de roteiro na Europa #25', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Dicas de roteiro na Europa #25', 'Relatos', NULL, '2025-08-27 13:25:11', 27),
(29, 'Alguém já foi para o Japão? #26', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Alguém já foi para o Japão? #26', 'Dicas', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', '2025-08-19 03:28:03', 50),
(30, 'Seguro viagem: qual escolher? #27', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Seguro viagem: qual escolher? #27', 'Geral', NULL, '2025-01-04 14:45:45', 153),
(31, 'Viagem solo: vale a pena? #28', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Viagem solo: vale a pena? #28', 'Relatos', NULL, '2024-11-29 02:13:46', 128),
(32, 'Alguém já foi para o Japão? #29', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Alguém já foi para o Japão? #29', 'Companhia', NULL, '2025-06-16 17:34:36', 67),
(33, 'Dicas de roteiro na Europa #30', 'Olá pessoal, gostaria de compartilhar/tirar dúvidas sobre este assunto. Dicas de roteiro na Europa #30', 'Relatos', NULL, '2025-01-30 14:33:13', 49);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `nome_exibicao` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT '/images/profile/avatar-default.jpg',
  `banner_url` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `is_banned` tinyint(1) DEFAULT 0,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha_hash`, `nome_exibicao`, `bio`, `avatar_url`, `banner_url`, `is_admin`, `is_banned`, `data_criacao`) VALUES
(1, 'ana@exemplo.com', 'senha_hash_fake_123', 'Ana Ribeiro', NULL, './images/profile/default.jpg', NULL, 0, 0, '2025-10-31 11:56:24'),
(2, 'carlos@exemplo.com', 'senha_hash_fake_456', 'Carlos Mendes', NULL, './images/profile/default.jpg', NULL, 0, 0, '2025-10-31 11:56:24'),
(3, 'vini@email.com', '$2y$10$n34etN8hyUHcIAyd3kAAOuQxd360KUdxInnzYciZU6D2MS6NBe9Zq', 'Vinicius', 'Olá este é o primeiro teste de db', 'uploads/avatar_3_1761915505.jfif', 'uploads/banner_3_1764349890.png', 1, 0, '2025-10-31 12:37:26'),
(4, 'danilo.silva@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Danilo Silva', 'Olá! Eu sou Danilo e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/85.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(5, 'graciliano.nogueira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Graciliano Nogueira', 'Olá! Eu sou Graciliano e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/0.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(6, 'hercilia.vieira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Hercília Vieira', 'Olá! Eu sou Hercília e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/42.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(7, 'taliana.cavalcanti@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Taliana Cavalcanti', 'Olá! Eu sou Taliana e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/14.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(8, 'aloisio.moreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Aloísio Moreira', 'Olá! Eu sou Aloísio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/33.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(9, 'alvina.cardoso@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Alvina Cardoso', 'Olá! Eu sou Alvina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/96.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(10, 'jocilene.campos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Jocilene Campos', 'Olá! Eu sou Jocilene e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/71.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(11, 'lois.dacosta@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lois da Costa', 'Olá! Eu sou Lois e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/35.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(12, 'sulani.novaes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Sulani Novaes', 'Olá! Eu sou Sulani e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/57.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(13, 'evencio.ramos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Evêncio Ramos', 'Olá! Eu sou Evêncio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/46.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(14, 'fabiao.damota@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Fabião da Mota', 'Olá! Eu sou Fabião e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/72.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(15, 'ramon.jesus@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Ramon Jesus', 'Olá! Eu sou Ramon e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/40.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(16, 'flavio.porto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Flávio Porto', 'Olá! Eu sou Flávio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/80.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(17, 'simone.silveira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Simone Silveira', 'Olá! Eu sou Simone e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/4.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(18, 'rupio.moura@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Rúpio Moura', 'Olá! Eu sou Rúpio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/56.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(19, 'daria.dias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Dária Dias', 'Olá! Eu sou Dária e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/77.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(20, 'emanuel.dasneves@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Emanuel das Neves', 'Olá! Eu sou Emanuel e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/13.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(21, 'margot.porto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Margot Porto', 'Olá! Eu sou Margot e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/57.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(22, 'requerino.silva@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Requerino Silva', 'Olá! Eu sou Requerino e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/55.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(23, 'faustino.moraes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Faustino Moraes', 'Olá! Eu sou Faustino e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/1.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(24, 'alito.campos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Alito Campos', 'Olá! Eu sou Alito e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/18.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(25, 'pedrino.aragao@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Pedrino Aragão', 'Olá! Eu sou Pedrino e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/5.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(26, 'jaime.ramos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Jaime Ramos', 'Olá! Eu sou Jaime e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/29.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(27, 'luanda.peixoto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Luanda Peixoto', 'Olá! Eu sou Luanda e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/33.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(28, 'fabricio.costa@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Fabrício Costa', 'Olá! Eu sou Fabrício e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/6.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(29, 'junior.dapaz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Júnior da Paz', 'Olá! Eu sou Júnior e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/43.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(30, 'cleide.dias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Cleide Dias', 'Olá! Eu sou Cleide e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/42.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(31, 'laurita.fogaca@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Laurita Fogaça', 'Olá! Eu sou Laurita e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/41.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(32, 'tacio.mendes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Tácio Mendes', 'Olá! Eu sou Tácio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/8.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(33, 'amor.moura@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Amor Moura', 'Olá! Eu sou Amor e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/56.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(34, 'baldemar.freitas@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Baldemar Freitas', 'Olá! Eu sou Baldemar e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/48.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(35, 'xenon.dias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Xénon Dias', 'Olá! Eu sou Xénon e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/82.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(36, 'rosalina.freitas@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Rosalina Freitas', 'Olá! Eu sou Rosalina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/41.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(37, 'cicero.nunes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Cícero Nunes', 'Olá! Eu sou Cícero e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/39.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(38, 'dulcelina.rodrigues@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Dulcelina Rodrigues', 'Olá! Eu sou Dulcelina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/19.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(39, 'quiliano.farias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Quiliano Farias', 'Olá! Eu sou Quiliano e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/11.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(40, 'urias.porto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Urias Porto', 'Olá! Eu sou Urias e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/87.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(41, 'josilene.cardoso@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Josilene Cardoso', 'Olá! Eu sou Josilene e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/28.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(42, 'ilma.goncalves@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Ilma Gonçalves', 'Olá! Eu sou Ilma e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/70.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(43, 'reis.pires@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Reis Pires', 'Olá! Eu sou Reis e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/72.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(44, 'lisandra.nascimento@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lisandra Nascimento', 'Olá! Eu sou Lisandra e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/34.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(45, 'cecy.cavalcanti@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Cecy Cavalcanti', 'Olá! Eu sou Cecy e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/86.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(46, 'zada.martins@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Zada Martins', 'Olá! Eu sou Zada e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/84.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(47, 'apolinario.fernandes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Apolinário Fernandes', 'Olá! Eu sou Apolinário e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/66.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(48, 'leilane.souza@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Leilane Souza', 'Olá! Eu sou Leilane e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/47.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(49, 'reis.farias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Reis Farias', 'Olá! Eu sou Reis e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/38.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(50, 'luciele.dacosta@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Luciele da Costa', 'Olá! Eu sou Luciele e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/58.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(51, 'aitor.moreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Aitor Moreira', 'Olá! Eu sou Aitor e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/42.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(52, 'iridea.lopes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Irídea Lopes', 'Olá! Eu sou Irídea e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/75.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(53, 'getulia.souza@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Getúlia Souza', 'Olá! Eu sou Getúlia e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/44.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(54, 'lia.damata@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lia da Mata', 'Olá! Eu sou Lia e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/44.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(55, 'caterine.daluz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Caterine da Luz', 'Olá! Eu sou Caterine e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/96.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(56, 'ivanete.rocha@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Ivanete Rocha', 'Olá! Eu sou Ivanete e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/85.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(57, 'mariano.aragao@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Mariano Aragão', 'Olá! Eu sou Mariano e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/27.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(58, 'rita.darosa@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Rita da Rosa', 'Olá! Eu sou Rita e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/45.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(59, 'valdinelia.dapaz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Valdinélia da Paz', 'Olá! Eu sou Valdinélia e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/96.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(60, 'belinda.lima@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Belinda Lima', 'Olá! Eu sou Belinda e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/83.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(61, 'fulvio.novaes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Fúlvio Novaes', 'Olá! Eu sou Fúlvio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/71.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(62, 'candela.souza@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Candela Souza', 'Olá! Eu sou Candela e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/24.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(63, 'eulogio.gomes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Eulógio Gomes', 'Olá! Eu sou Eulógio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/1.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(64, 'benedita.dapaz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Benedita da Paz', 'Olá! Eu sou Benedita e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/19.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(65, 'mariangela.fogaca@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Mariângela Fogaça', 'Olá! Eu sou Mariângela e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/62.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(66, 'apolinario.castro@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Apolinário Castro', 'Olá! Eu sou Apolinário e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/79.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(67, 'ari.farias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Ari Farias', 'Olá! Eu sou Ari e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/2.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(68, 'levi.daluz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Levi da Luz', 'Olá! Eu sou Levi e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/14.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(69, 'amarilio.lopes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Amarílio Lopes', 'Olá! Eu sou Amarílio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/81.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(70, 'marilaine.novaes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Marilaine Novaes', 'Olá! Eu sou Marilaine e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/90.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(71, 'thais.daconceicao@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Thaís da Conceição', 'Olá! Eu sou Thaís e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/13.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(72, 'leoberto.daconceicao@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Leoberto da Conceição', 'Olá! Eu sou Leoberto e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/49.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(73, 'alano.cavalcanti@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Alano Cavalcanti', 'Olá! Eu sou Alano e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/77.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(74, 'liliane.castro@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Liliane Castro', 'Olá! Eu sou Liliane e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/80.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(75, 'simara.cardoso@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Simara Cardoso', 'Olá! Eu sou Simara e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/57.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(76, 'dilermando.fernandes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Dilermando Fernandes', 'Olá! Eu sou Dilermando e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/34.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(77, 'euclides.melo@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Euclides Melo', 'Olá! Eu sou Euclides e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/51.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(78, 'gabino.porto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Gabino Porto', 'Olá! Eu sou Gabino e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/46.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(79, 'afranio.dacruz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Afrânio da Cruz', 'Olá! Eu sou Afrânio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/3.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(80, 'dulcilene.araujo@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Dulcilene Araújo', 'Olá! Eu sou Dulcilene e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/94.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(81, 'mair.dacruz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Mair da Cruz', 'Olá! Eu sou Mair e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/69.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(82, 'frederica.cavalcanti@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Frederica Cavalcanti', 'Olá! Eu sou Frederica e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/96.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(83, 'zulmira.alves@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Zulmira Alves', 'Olá! Eu sou Zulmira e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/10.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(84, 'leonara.nunes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Leonara Nunes', 'Olá! Eu sou Leonara e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/32.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(85, 'lauriana.silva@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lauriana Silva', 'Olá! Eu sou Lauriana e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/87.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(86, 'custodia.rezende@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Custódia Rezende', 'Olá! Eu sou Custódia e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/42.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(87, 'filino.peixoto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Filino Peixoto', 'Olá! Eu sou Filino e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/45.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(88, 'zulmara.nogueira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Zulmara Nogueira', 'Olá! Eu sou Zulmara e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/17.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(89, 'santina.dapaz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Santina da Paz', 'Olá! Eu sou Santina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/4.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(90, 'marilia.rezende@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Marília Rezende', 'Olá! Eu sou Marília e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/34.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(91, 'marilena.nogueira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Marilena Nogueira', 'Olá! Eu sou Marilena e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/82.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(92, 'jairo.pires@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Jairo Pires', 'Olá! Eu sou Jairo e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/32.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(93, 'barac.damata@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Barac da Mata', 'Olá! Eu sou Barac e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/74.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(94, 'yane.moura@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Yane Moura', 'Olá! Eu sou Yane e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/19.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(95, 'lucinda.darocha@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lucinda da Rocha', 'Olá! Eu sou Lucinda e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/8.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(96, 'rina.darocha@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Rina da Rocha', 'Olá! Eu sou Rina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/30.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(97, 'firmo.rezende@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Firmo Rezende', 'Olá! Eu sou Firmo e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/50.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(98, 'licelima.moreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Licelima Moreira', 'Olá! Eu sou Licelima e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/38.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(99, 'zardilaque.santos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Zardilaque Santos', 'Olá! Eu sou Zardilaque e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/52.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(100, 'suraje.campos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Suraje Campos', 'Olá! Eu sou Suraje e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/17.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(101, 'bento.aragao@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Bento Aragão', 'Olá! Eu sou Bento e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/72.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(102, 'isaias.lopes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Isaías Lopes', 'Olá! Eu sou Isaías e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/8.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(103, 'odair.ferreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Odair Ferreira', 'Olá! Eu sou Odair e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/83.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(104, 'beatrice.nunes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Beatrice Nunes', 'Olá! Eu sou Beatrice e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/28.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(105, 'franklim.monteiro@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Franklim Monteiro', 'Olá! Eu sou Franklim e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/34.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(106, 'arani.nascimento@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Arani Nascimento', 'Olá! Eu sou Arani e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/2.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(107, 'abel.costa@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Abel Costa', 'Olá! Eu sou Abel e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/18.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(108, 'olinda.pereira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Olinda Pereira', 'Olá! Eu sou Olinda e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/13.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(109, 'luara.silva@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Luara Silva', 'Olá! Eu sou Luara e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/86.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(110, 'leia.santos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Léia Santos', 'Olá! Eu sou Léia e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/57.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(111, 'luciola.nunes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lucíola Nunes', 'Olá! Eu sou Lucíola e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/40.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(112, 'feliciana.monteiro@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Feliciana Monteiro', 'Olá! Eu sou Feliciana e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/89.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(113, 'cleci.oliveira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Cleci Oliveira', 'Olá! Eu sou Cleci e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/8.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(114, 'procopio.mendes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Procópio Mendes', 'Olá! Eu sou Procópio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/11.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(115, 'urien.fernandes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Urien Fernandes', 'Olá! Eu sou Urien e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/26.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(116, 'antonino.gomes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Antonino Gomes', 'Olá! Eu sou Antonino e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/12.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(117, 'ria.pinto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Ria Pinto', 'Olá! Eu sou Ria e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/44.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(118, 'soila.desouza@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Soila de Souza', 'Olá! Eu sou Soila e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/96.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(119, 'abraao.desouza@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Abraão de Souza', 'Olá! Eu sou Abraão e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/39.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(120, 'ary.freitas@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Ary Freitas', 'Olá! Eu sou Ary e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/68.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(121, 'virgilio.moreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Virgílio Moreira', 'Olá! Eu sou Virgílio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/58.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(122, 'idalecio.moreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Idalécio Moreira', 'Olá! Eu sou Idalécio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/31.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(123, 'idalio.sales@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Idálio Sales', 'Olá! Eu sou Idálio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/50.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(124, 'fabia.nunes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Fábia Nunes', 'Olá! Eu sou Fábia e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/90.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(125, 'luiziane.cavalcanti@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Luiziane Cavalcanti', 'Olá! Eu sou Luiziane e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/9.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(126, 'otoniel.dias@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Otoniel Dias', 'Olá! Eu sou Otoniel e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/72.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(127, 'daisy.almeida@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Daisy Almeida', 'Olá! Eu sou Daisy e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/82.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(128, 'areta.vieira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Areta Vieira', 'Olá! Eu sou Areta e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/80.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(129, 'jacome.desouza@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Jácome de Souza', 'Olá! Eu sou Jácome e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/83.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(130, 'falviana.damata@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Falviana da Mata', 'Olá! Eu sou Falviana e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/4.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(131, 'tarsicio.damota@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Tarsício da Mota', 'Olá! Eu sou Tarsício e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/71.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(132, 'magali.dasneves@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Magali das Neves', 'Olá! Eu sou Magali e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/15.jpg', NULL, 0, 0, '2025-11-28 15:25:26'),
(133, 'manuela.dacruz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Manuela da Cruz', 'Olá! Eu sou Manuela e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/48.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(134, 'adelina.martins@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Adelina Martins', 'Olá! Eu sou Adelina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/39.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(135, 'evaristo.daluz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Evaristo da Luz', 'Olá! Eu sou Evaristo e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/29.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(136, 'livian.dapaz@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Lívian da Paz', 'Olá! Eu sou Lívian e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/56.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(137, 'victor.novaes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Victor Novaes', 'Olá! Eu sou Victor e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/37.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(138, 'helen.teixeira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Helen Teixeira', 'Olá! Eu sou Helen e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/84.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(139, 'enzo.monteiro@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Enzo Monteiro', 'Olá! Eu sou Enzo e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/70.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(140, 'evaristo.silva@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Evaristo Silva', 'Olá! Eu sou Evaristo e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/26.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(141, 'hildeberto.teixeira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Hildeberto Teixeira', 'Olá! Eu sou Hildeberto e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/22.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(142, 'jovito.aragao@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Jovito Aragão', 'Olá! Eu sou Jovito e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/3.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(143, 'jovina.campos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Jovina Campos', 'Olá! Eu sou Jovina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/13.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(144, 'bernarda.peixoto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Bernarda Peixoto', 'Olá! Eu sou Bernarda e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/10.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(145, 'matilde.pinto@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Matilde Pinto', 'Olá! Eu sou Matilde e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/33.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(146, 'viviana.martins@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Viviana Martins', 'Olá! Eu sou Viviana e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/96.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(147, 'mara.pires@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Mara Pires', 'Olá! Eu sou Mara e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/64.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(148, 'erico.ramos@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Erico Ramos', 'Olá! Eu sou Erico e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/56.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(149, 'holdina.dasneves@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Holdina das Neves', 'Olá! Eu sou Holdina e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/92.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(150, 'eni.ferreira@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Eni Ferreira', 'Olá! Eu sou Eni e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/56.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(151, 'neide.moraes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Neide Moraes', 'Olá! Eu sou Neide e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/34.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(152, 'dioclecio.fernandes@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Dioclécio Fernandes', 'Olá! Eu sou Dioclécio e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/men/52.jpg', NULL, 0, 0, '2025-11-28 15:25:27'),
(153, 'viviana.costa@example.com', '$2y$10$zzfJZhDH5eyJM2J0C3alFOBIw1qNNfs62pk6WN6UK8GSCCmOSbUYa', 'Viviana Costa', 'Olá! Eu sou Viviana e adoro viajar com a WonderFly.', 'https://randomuser.me/api/portraits/women/29.jpg', NULL, 0, 0, '2025-11-28 15:25:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `viagem_locations`
--

CREATE TABLE `viagem_locations` (
  `id` int(11) NOT NULL,
  `viagem_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `viagem_locations`
--

INSERT INTO `viagem_locations` (`id`, `viagem_id`, `nome`, `latitude`, `longitude`) VALUES
(1, 2, 'Teerã', '35.68920000', '51.38900000'),
(2, 2, 'Isfahan', '32.65460000', '51.66800000'),
(3, 2, 'Shiraz', '29.61010000', '52.53110000'),
(4, 1, 'Cusco', '-13.53190000', '-71.96750000'),
(5, 1, 'Vale Sagrado', '-13.31060000', '-72.08580000'),
(6, 1, 'Machu Picchu', '-13.16310000', '-72.54500000'),
(7, 3, 'Paris', '48.85660000', '2.35220000'),
(8, 4, 'Tóquio', '35.67620000', '139.65030000'),
(9, 5, 'Nova York', '40.71280000', '-74.00600000'),
(10, 6, 'Londres', '51.50740000', '-0.12780000'),
(11, 7, 'Roma', '41.90280000', '12.49640000'),
(12, 8, 'Bali', '-8.40950000', '115.18890000'),
(13, 9, 'Barcelona', '41.38510000', '2.17340000'),
(14, 10, 'Madrid', '40.41680000', '-3.70380000'),
(15, 11, 'Lisboa', '38.72230000', '-9.13930000'),
(16, 12, 'Berlim', '52.52000000', '13.40500000'),
(17, 13, 'Amsterdã', '52.36760000', '4.90410000'),
(18, 14, 'Viena', '48.20820000', '16.37380000'),
(19, 15, 'Praga', '50.07550000', '14.43780000'),
(20, 16, 'Budapeste', '47.49790000', '19.04020000'),
(21, 17, 'Atenas', '37.98380000', '23.72750000'),
(22, 18, 'Dublin', '53.34980000', '-6.26030000'),
(23, 19, 'Estocolmo', '59.32930000', '18.06860000'),
(24, 20, 'Oslo', '59.91390000', '10.75220000'),
(25, 21, 'Helsinque', '60.16990000', '24.93840000'),
(26, 22, 'Zurique', '47.37690000', '8.54170000'),
(27, 23, 'Genebra', '46.20440000', '6.14320000'),
(28, 24, 'Kyoto', '35.01160000', '135.76810000'),
(29, 25, 'Seul', '37.56650000', '126.97800000'),
(30, 26, 'Pequim', '39.90420000', '116.40740000'),
(31, 27, 'Xangai', '31.23040000', '121.47370000'),
(32, 28, 'Hong Kong', '22.31930000', '114.16940000'),
(33, 29, 'Cingapura', '1.35210000', '103.81980000'),
(34, 30, 'Bangkok', '13.75630000', '100.50180000'),
(35, 31, 'Hanoi', '21.02850000', '105.85420000'),
(36, 32, 'Mumbai', '19.07600000', '72.87770000'),
(37, 33, 'Dubai', '25.20480000', '55.27080000'),
(38, 34, 'Los Angeles', '34.05220000', '-118.24370000'),
(39, 35, 'San Francisco', '37.77490000', '-122.41940000'),
(40, 36, 'Las Vegas', '36.16990000', '-115.13980000'),
(41, 37, 'Miami', '25.76170000', '-80.19180000'),
(42, 38, 'Chicago', '41.87810000', '-87.62980000'),
(43, 39, 'Toronto', '43.65100000', '-79.34700000'),
(44, 40, 'Vancouver', '49.28270000', '-123.12070000'),
(45, 41, 'Cidade do México', '19.43260000', '-99.13320000'),
(46, 42, 'Buenos Aires', '-34.60370000', '-58.38160000'),
(47, 43, 'Santiago', '-33.44890000', '-70.66930000'),
(48, 44, 'Bogotá', '4.71100000', '-74.07210000'),
(49, 45, 'Cidade do Cabo', '-33.92490000', '18.42410000'),
(50, 46, 'Cairo', '30.04440000', '31.23570000'),
(51, 47, 'Marrakech', '31.62950000', '-7.98110000'),
(52, 48, 'Sydney', '-33.86880000', '151.20930000'),
(53, 49, 'Melbourne', '-37.81360000', '144.96310000'),
(54, 50, 'Auckland', '-36.84850000', '174.76330000'),
(55, 51, 'Istambul', '41.00820000', '28.97840000'),
(56, 52, 'Jerusalém', '31.76830000', '35.21370000'),
(57, 53, 'Petra', '30.32850000', '35.44440000'),
(58, 54, 'Machu Picchu', '-13.16310000', '-72.54500000'),
(59, 55, 'Rio de Janeiro', '-22.90680000', '-43.17290000'),
(60, 56, 'Havana', '23.11360000', '-82.36660000'),
(61, 57, 'Cartagena', '10.39100000', '-75.47940000'),
(62, 58, 'Reykjavik', '64.14660000', '-21.94260000'),
(63, 59, 'Santorini', '36.39320000', '25.46150000'),
(64, 60, 'Veneza', '45.44080000', '12.31550000'),
(65, 61, 'Florença', '43.76960000', '11.25580000'),
(66, 62, 'Munique', '48.13510000', '11.58200000');

-- --------------------------------------------------------

--
-- Estrutura da tabela `viagens`
--

CREATE TABLE `viagens` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao_curta` text DEFAULT NULL,
  `descricao_longa` text DEFAULT NULL,
  `incluso_html` text DEFAULT NULL,
  `nao_incluso_html` text DEFAULT NULL,
  `itinerario_html` text DEFAULT NULL,
  `hospedagem_html` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `duracao` varchar(50) DEFAULT NULL,
  `imagem_url` varchar(255) DEFAULT NULL,
  `continente` varchar(50) DEFAULT NULL,
  `categorias` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `viagens`
--

INSERT INTO `viagens` (`id`, `titulo`, `descricao_curta`, `descricao_longa`, `incluso_html`, `nao_incluso_html`, `itinerario_html`, `hospedagem_html`, `preco`, `duracao`, `imagem_url`, `continente`, `categorias`, `keywords`) VALUES
(1, 'Trilhas dos Incas - Peru', 'Aventure-se pelos Andes, descubra Machu Picchu e a rica cultura Inca.', NULL, NULL, NULL, NULL, NULL, '4100.00', '8 dias', 'https://media.istockphoto.com/id/1388676876/pt/foto/lima-peru-along-the-coast-at-a-golden-hour-sunset.jpg?s=612x612&w=0&k=20&c=TpgT1pyYvdqFLNWyPJeKaDaIyCMC5Guc-vnHUbr3__Y=', 'america-sul', 'aventura historia', 'peru incas machu picchu andes'),
(2, 'Patrimônios no Irã', 'Uma jornada imersiva pelas antigas civilizações e a rica cultura persa.', '<p>Prepare-se para uma viagem inesquecível ao coração da antiga Pérsia, onde a história ganha vida em cada esquina. Nosso roteiro \"Patrimônios no Irã\" foi cuidadosamente elaborado para você explorar cidades lendárias, maravilhas arquitetônicas e a hospitalidade calorosa do povo iraniano. De mercados vibrantes a mesquitas adornadas e jardins serenos, cada momento é uma imersão profunda em uma cultura rica e milenar.</p><p>Nossos guias locais experientes o levarão por Persepolis, a magnífica capital do Império Aquemênida, os coloridos bazares de Isfahan e os mausoléus poéticos de Shiraz. Viva experiências autênticas, como saborear a culinária persa em restaurantes tradicionais e interagir com artesãos locais. Uma aventura que promete transformar sua visão de mundo e criar memorias duradouras.</p>', '<h3>O que está incluso</h3><ul><li><i class=\"ri-check-line\"></i> Passagens aéreas de ida e volta (com conexão)</li><li><i class=\"ri-check-line\"></i> Hospedagem em hotéis boutique e casas tradicionais com café da manhã</li><li><i class=\"ri-check-line\"></i> Todos os transportes internos (terrestre e aéreo)</li><li><i class=\"ri-check-line\"></i> Guias locais especializados em história e cultura</li><li><i class=\"ri-check-line\"></i> Taxas de entrada para todos os sítios históricos e museus</li><li><i class=\"ri-check-line\"></i> Jantares especiais com culinária persa autêntica</li><li><i class=\"ri-check-line\"></i> Seguro viagem completo</li><li><i class=\"ri-check-line\"></i> Suporte 24/7 da WonderFly</li></ul>', '<h3>Não incluso</h3><ul><li><i class=\"ri-close-line\"></i> Visto de entrada no Irã (auxílio na documentação)</li><li><i class=\"ri-close-line\"></i> Almoços e bebidas (exceto onde especificado)</li><li><i class=\"ri-close-line\"></i> Despesas pessoais</li><li><i class=\"ri-close-line\"></i> Gorjetas</li></ul>', '<h3>Itinerário detalhado</h3><ol class=\"itinerary-list\"><li class=\"day\"><h4>Dia 1: Chegada em Teerã</h4><p>Bem-vindo ao Irã! Chegada ao Aeroporto Internacional Imam Khomeini (IKA), recepção e traslado ao hotel. Resto do dia livre para descanso e adaptação. Jantar de boas-vindas com o grupo.</p></li><li class=\"day\"><h4>Dia 2: Teerã – Capital cultural</h4><p>Explore o Palácio Golestan (Patrimônio Mundial da UNESCO), o Museu Nacional e o Grande Bazar de Teerã. À noite, jantar e experiência em uma casa de chá tradicional.</p></li><li class=\"day\"><h4>Dia 3: Voo para Isfahan – A joia persa</h4><p>Voo doméstico para Isfahan. Visita à Praça Naqsh-e Jahan (Patrimônio Mundial da UNESCO), Mesquita Shah, Mesquita Sheikh Lotfollah e Palácio Ali Qapu.</p></li><li class=\"day\"><h4>Dia 4: Isfahan – Pontes e Bazares</h4><p>Caminhe pelas pontes históricas de Khaju e Si-o-Se-Pol. Explore o bairro armênio de Jolfa e a Catedral de Vank. Tarde livre para explorar o Bazar Qeysarieh.</p></li><li class=\"day\"><h4>Dia 5: Viagem para Yazd</h4><p>Viagem terrestre para Yazd, a cidade de adobe. No caminho, parada em Na\'in para ver a antiga mesquita. Check-in no hotel em Yazd e passeio pelo centro histórico.</p></li><li class=\"day\"><h4>Dia 6: Yazd – Cidade do Fogo</h4><p>Visite as Torres do Silêncio (locais de enterro Zoroastristas), o Templo do Fogo Atash Behram e o complexo Amir Chakhmaq. Aprenda sobre os \'qanats\' (sistemas de água).</p></li><li class=\"day\"><h4>Dia 7: Rumo a Shiraz – Berço dos Poetas</h4><p>Viagem para Shiraz. No caminho, parada em Pasárgada, a tumba de Ciro, o Grande. Chegada em Shiraz ao final da tarde e jantar.</p></li><li class=\"day\"><h4>Dia 8: Persepolis e Necrópole</h4><p>Excursão de dia inteiro a Persepolis, a capital cerimonial do Império Aquemênida. Visite também Naqsh-e Rustam (Necrópole) com as tumbas dos reis persas.</p></li><li class=\"day\"><h4>Dia 9: Shiraz – Mesquitas e mercados</h4><p>Visita à Mesquita Nasir al-Mulk (Mesquita Rosa) e ao Jardim Narenjestan. Tempo para compras no Bazar Vakil e visita à Cidadela de Karim Khan. Jantar de despedida.</p></li><li class=\"day\"><h4>Dia 10: Partida de Shiraz</h4><p>Após o café da manhã, traslado ao Aeroporto Internacional de Shiraz (SYZ) para seu voo de retorno.</p></li></ol>', '<h3>Hospedagem selecionada</h3><div class=\"hotel-card\"><img src=\"https://dynamic-media-cdn.tripadvisor.com/media/photo-o/07/05/8d/3b/main-yard-atnight.jpg?w=900&h=500&s=1\" alt=\"Pátio interno do Hotel Saraye Ameriha em Kashan\"><div class=\"hotel-info\"><h4>Hotel Saraye Ameriha, Kashan</h4><p>Um hotel boutique luxuoso em uma casa histórica restaurada...</p><ul><li><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i> (5 estrelas)</li><li><i class=\"ri-restaurant-line\"></i> Restaurante no local</li><li><i class=\"ri-wifi-line\"></i> Wi-Fi gratuito</li></ul></div></div><div class=\"hotel-card\"><img src=\"https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/8c/39/cc/uninterrupted-city-view.jpg?w=900&h=500&s=1\" alt=\"Fachada do Espinas Palace Hotel em Teerã\"><div class=\"hotel-info\"><h4>Espinas Palace Hotel, Teerã</h4><p>Um dos hotéis mais prestigiados de Teerã...</p><ul><li><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-half-fill\"></i> (4.5 estrelas)</li><li><i class=\"ri-door-line\"></i> Quartos espaçosos</li><li><i class=\"ri-fitness-line\"></i> Centro de fitness</li></ul></div></div>', '6450.00', '10 dias', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1600&auto=format&fit=crop', 'asia', 'historia arte', 'irã persia teerã isfahan shiraz'),
(3, 'Romance em Paris', 'A cidade luz espera por você com todo seu charme e romance.', '<p>Paris, a capital da França, é uma das cidades mais importantes e influentes do mundo. Conhecida como a \"Cidade Luz\", é famosa por sua história, cultura, gastronomia e moda.</p><p>Neste roteiro, você visitará a Torre Eiffel, o Museu do Louvre, a Catedral de Notre-Dame e muito mais. Desfrute de jantares românticos em bistrôs charmosos e passeios relaxantes pelo Rio Sena.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem 4 estrelas</li><li>Café da manhã</li><li>Passeios guiados</li></ul>', '<ul><li>Almoço e Jantar</li><li>Gorjetas</li></ul>', '<ol><li>Chegada e Transfer</li><li>Torre Eiffel e Campo de Marte</li><li>Museu do Louvre</li><li>Montmartre e Sacré-Cœur</li><li>Dia Livre</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis selecionados no centro de Paris.</p>', '5500.00', '6 dias', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', 'europa', 'romance cultura', 'paris frança europa romance torre eiffel'),
(4, 'Tóquio Futurista', 'Mergulhe na tecnologia e tradição da capital japonesa.', '<p>Tóquio é uma metrópole vibrante que mistura o ultramoderno com o tradicional. De arranha-céus iluminados por neon a templos históricos, a cidade oferece uma experiência única.</p>', '<ul><li>Voo direto</li><li>Hospedagem em hotel cápsula (opcional) ou tradicional</li><li>Passe de trem JR</li></ul>', '<ul><li>Refeições não mencionadas</li></ul>', '<ol><li>Chegada em Narita/Haneda</li><li>Shibuya e Harajuku</li><li>Templo Senso-ji e Asakusa</li><li>Akihabara</li><li>Retorno</li></ol>', '<p>Hotéis modernos em Shinjuku ou Shibuya.</p>', '7200.00', '7 dias', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', 'asia', 'tecnologia cultura', 'toquio japao asia tecnologia anime'),
(5, 'Nova York: A Cidade que Nunca Dorme', 'Explore a Big Apple, seus teatros, parques e arranha-céus.', '<p>Nova York é o centro do mundo. Times Square, Central Park, Estátua da Liberdade e Broadway são apenas o começo.</p>', '<ul><li>Aéreo</li><li>Hotel em Manhattan</li><li>City Pass</li></ul>', '<ul><li>Visto americano</li><li>Alimentação</li></ul>', '<ol><li>Chegada JFK</li><li>Times Square</li><li>Central Park e Museus</li><li>Estátua da Liberdade</li><li>Brooklyn Bridge</li><li>Retorno</li></ol>', '<p>Hotel 4 estrelas próximo à Times Square.</p>', '6800.00', '5 dias', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', 'america-norte', 'urbano compras', 'nova york eua manhattan times square'),
(6, 'Londres Real', 'Conheça a terra da Rainha, o Big Ben e os pubs históricos.', '<p>Londres é uma cidade global com uma história fascinante. Visite o Palácio de Buckingham, o Museu Britânico e a London Eye.</p>', '<ul><li>Passagem aérea</li><li>Hotel com café</li><li>Oyster Card</li></ul>', '<ul><li>Ingressos extras</li></ul>', '<ol><li>Chegada Heathrow</li><li>Big Ben e Parlamento</li><li>British Museum</li><li>Camden Town</li><li>Retorno</li></ol>', '<p>Hotel confortável na zona 1 ou 2.</p>', '5900.00', '6 dias', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', 'europa', 'historia urbano', 'londres inglaterra reino unido europa big ben'),
(7, 'Roma Antiga', 'Caminhe pela história no Coliseu e Vaticano.', '<p>Roma é um museu a céu aberto. O Coliseu, o Fórum Romano e o Vaticano são paradas obrigatórias para quem ama história.</p>', '<ul><li>Voo</li><li>Hotel</li><li>Tours guiados</li></ul>', '<ul><li>Taxas de turismo locais</li></ul>', '<ol><li>Chegada Fiumicino</li><li>Coliseu e Fórum</li><li>Vaticano e Capela Sistina</li><li>Fontana di Trevi</li><li>Retorno</li></ol>', '<p>Hotel charmoso próximo ao centro histórico.</p>', '5300.00', '5 dias', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', 'europa', 'historia gastronomia', 'roma italia europa coliseu vaticano'),
(8, 'Bali: Paraíso Tropical', 'Relaxe nas praias paradisíacas e templos de Bali.', '<p>Bali é conhecida por suas montanhas vulcânicas, arrozais icônicos, praias e recifes de coral. É o destino perfeito para relaxar e se conectar com a natureza.</p>', '<ul><li>Aéreo</li><li>Resort à beira-mar</li><li>Spa day</li></ul>', '<ul><li>Atividades aquáticas extras</li></ul>', '<ol><li>Chegada Denpasar</li><li>Ubud e Arrozais</li><li>Templos</li><li>Praias de Uluwatu</li><li>Retorno</li></ol>', '<p>Resort 5 estrelas em Nusa Dua ou Seminyak.</p>', '6100.00', '8 dias', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', 'asia', 'praia natureza relaxamento', 'bali indonesia asia praia'),
(9, 'Explorando Barcelona', 'Descubra as maravilhas de Barcelona, Espanha. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Barcelona! Esta viagem foi planejada para você aproveitar o melhor que Espanha tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Barcelona</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Barcelona.</p>', '4894.00', '7 dias', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'barcelona espanha europa viagem turismo'),
(10, 'Explorando Madrid', 'Descubra as maravilhas de Madrid, Espanha. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Madrid! Esta viagem foi planejada para você aproveitar o melhor que Espanha tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Madrid</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Madrid.</p>', '7185.00', '11 dias', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'madrid espanha europa viagem turismo'),
(11, 'Explorando Lisboa', 'Descubra as maravilhas de Lisboa, Portugal. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Lisboa! Esta viagem foi planejada para você aproveitar o melhor que Portugal tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Lisboa</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Lisboa.</p>', '9428.00', '8 dias', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'lisboa portugal europa viagem turismo'),
(12, 'Explorando Berlim', 'Descubra as maravilhas de Berlim, Alemanha. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Berlim! Esta viagem foi planejada para você aproveitar o melhor que Alemanha tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Berlim</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Berlim.</p>', '11450.00', '6 dias', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'berlim alemanha europa viagem turismo'),
(13, 'Explorando Amsterdã', 'Descubra as maravilhas de Amsterdã, Holanda. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Amsterdã! Esta viagem foi planejada para você aproveitar o melhor que Holanda tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Amsterdã</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Amsterdã.</p>', '7803.00', '12 dias', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'amsterdã holanda europa viagem turismo'),
(14, 'Explorando Viena', 'Descubra as maravilhas de Viena, Áustria. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Viena! Esta viagem foi planejada para você aproveitar o melhor que Áustria tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Viena</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Viena.</p>', '8076.00', '7 dias', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'viena Áustria europa viagem turismo'),
(15, 'Explorando Praga', 'Descubra as maravilhas de Praga, República Checa. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Praga! Esta viagem foi planejada para você aproveitar o melhor que República Checa tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Praga</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Praga.</p>', '10994.00', '15 dias', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'praga república checa europa viagem turismo'),
(16, 'Explorando Budapeste', 'Descubra as maravilhas de Budapeste, Hungria. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Budapeste! Esta viagem foi planejada para você aproveitar o melhor que Hungria tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Budapeste</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Budapeste.</p>', '7407.00', '9 dias', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'budapeste hungria europa viagem turismo'),
(17, 'Explorando Atenas', 'Descubra as maravilhas de Atenas, Grécia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Atenas! Esta viagem foi planejada para você aproveitar o melhor que Grécia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Atenas</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Atenas.</p>', '7297.00', '15 dias', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'atenas grécia europa viagem turismo'),
(18, 'Explorando Dublin', 'Descubra as maravilhas de Dublin, Irlanda. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Dublin! Esta viagem foi planejada para você aproveitar o melhor que Irlanda tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Dublin</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Dublin.</p>', '5616.00', '6 dias', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'dublin irlanda europa viagem turismo'),
(19, 'Explorando Estocolmo', 'Descubra as maravilhas de Estocolmo, Suécia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Estocolmo! Esta viagem foi planejada para você aproveitar o melhor que Suécia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Estocolmo</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Estocolmo.</p>', '3625.00', '13 dias', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'estocolmo suécia europa viagem turismo'),
(20, 'Explorando Oslo', 'Descubra as maravilhas de Oslo, Noruega. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Oslo! Esta viagem foi planejada para você aproveitar o melhor que Noruega tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Oslo</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Oslo.</p>', '14929.00', '8 dias', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'oslo noruega europa viagem turismo'),
(21, 'Explorando Helsinque', 'Descubra as maravilhas de Helsinque, Finlândia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Helsinque! Esta viagem foi planejada para você aproveitar o melhor que Finlândia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Helsinque</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Helsinque.</p>', '11994.00', '11 dias', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'helsinque finlândia europa viagem turismo'),
(22, 'Explorando Zurique', 'Descubra as maravilhas de Zurique, Suíça. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Zurique! Esta viagem foi planejada para você aproveitar o melhor que Suíça tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Zurique</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Zurique.</p>', '11301.00', '15 dias', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'zurique suíça europa viagem turismo'),
(23, 'Explorando Genebra', 'Descubra as maravilhas de Genebra, Suíça. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Genebra! Esta viagem foi planejada para você aproveitar o melhor que Suíça tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Genebra</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Genebra.</p>', '11414.00', '11 dias', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'genebra suíça europa viagem turismo'),
(24, 'Explorando Kyoto', 'Descubra as maravilhas de Kyoto, Japão. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Kyoto! Esta viagem foi planejada para você aproveitar o melhor que Japão tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Kyoto</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Kyoto.</p>', '8179.00', '10 dias', 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'kyoto japão asia viagem turismo'),
(25, 'Explorando Seul', 'Descubra as maravilhas de Seul, Coreia do Sul. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Seul! Esta viagem foi planejada para você aproveitar o melhor que Coreia do Sul tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Seul</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Seul.</p>', '12927.00', '13 dias', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'seul coreia do sul asia viagem turismo'),
(26, 'Explorando Pequim', 'Descubra as maravilhas de Pequim, China. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Pequim! Esta viagem foi planejada para você aproveitar o melhor que China tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Pequim</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Pequim.</p>', '7630.00', '6 dias', 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'pequim china asia viagem turismo'),
(27, 'Explorando Xangai', 'Descubra as maravilhas de Xangai, China. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Xangai! Esta viagem foi planejada para você aproveitar o melhor que China tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Xangai</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Xangai.</p>', '7536.00', '8 dias', 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'xangai china asia viagem turismo'),
(28, 'Explorando Hong Kong', 'Descubra as maravilhas de Hong Kong, China. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Hong Kong! Esta viagem foi planejada para você aproveitar o melhor que China tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Hong Kong</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Hong Kong.</p>', '5914.00', '12 dias', 'https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'hong kong china asia viagem turismo'),
(29, 'Explorando Cingapura', 'Descubra as maravilhas de Cingapura, Cingapura. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Cingapura! Esta viagem foi planejada para você aproveitar o melhor que Cingapura tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Cingapura</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Cingapura.</p>', '10310.00', '15 dias', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'cingapura cingapura asia viagem turismo'),
(30, 'Explorando Bangkok', 'Descubra as maravilhas de Bangkok, Tailândia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Bangkok! Esta viagem foi planejada para você aproveitar o melhor que Tailândia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Bangkok</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Bangkok.</p>', '12080.00', '6 dias', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'bangkok tailândia asia viagem turismo'),
(31, 'Explorando Hanoi', 'Descubra as maravilhas de Hanoi, Vietnã. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Hanoi! Esta viagem foi planejada para você aproveitar o melhor que Vietnã tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Hanoi</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Hanoi.</p>', '11692.00', '10 dias', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'hanoi vietnã asia viagem turismo'),
(32, 'Explorando Mumbai', 'Descubra as maravilhas de Mumbai, Índia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Mumbai! Esta viagem foi planejada para você aproveitar o melhor que Índia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Mumbai</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Mumbai.</p>', '3654.00', '7 dias', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'mumbai Índia asia viagem turismo'),
(33, 'Explorando Dubai', 'Descubra as maravilhas de Dubai, Emirados Árabes. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Dubai! Esta viagem foi planejada para você aproveitar o melhor que Emirados Árabes tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Dubai</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Dubai.</p>', '12625.00', '14 dias', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'dubai emirados Árabes asia viagem turismo'),
(34, 'Explorando Los Angeles', 'Descubra as maravilhas de Los Angeles, EUA. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Los Angeles! Esta viagem foi planejada para você aproveitar o melhor que EUA tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Los Angeles</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Los Angeles.</p>', '12426.00', '12 dias', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'los angeles eua america-norte viagem turismo'),
(35, 'Explorando San Francisco', 'Descubra as maravilhas de San Francisco, EUA. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a San Francisco! Esta viagem foi planejada para você aproveitar o melhor que EUA tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em San Francisco</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em San Francisco.</p>', '14881.00', '8 dias', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'san francisco eua america-norte viagem turismo'),
(36, 'Explorando Las Vegas', 'Descubra as maravilhas de Las Vegas, EUA. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Las Vegas! Esta viagem foi planejada para você aproveitar o melhor que EUA tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Las Vegas</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Las Vegas.</p>', '4857.00', '11 dias', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'las vegas eua america-norte viagem turismo'),
(37, 'Explorando Miami', 'Descubra as maravilhas de Miami, EUA. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Miami! Esta viagem foi planejada para você aproveitar o melhor que EUA tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Miami</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Miami.</p>', '12380.00', '14 dias', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'miami eua america-norte viagem turismo'),
(38, 'Explorando Chicago', 'Descubra as maravilhas de Chicago, EUA. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Chicago! Esta viagem foi planejada para você aproveitar o melhor que EUA tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Chicago</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Chicago.</p>', '10661.00', '14 dias', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'chicago eua america-norte viagem turismo'),
(39, 'Explorando Toronto', 'Descubra as maravilhas de Toronto, Canadá. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Toronto! Esta viagem foi planejada para você aproveitar o melhor que Canadá tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Toronto</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Toronto.</p>', '12941.00', '8 dias', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'toronto canadá america-norte viagem turismo'),
(40, 'Explorando Vancouver', 'Descubra as maravilhas de Vancouver, Canadá. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Vancouver! Esta viagem foi planejada para você aproveitar o melhor que Canadá tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Vancouver</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Vancouver.</p>', '11033.00', '14 dias', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'vancouver canadá america-norte viagem turismo'),
(41, 'Explorando Cidade do México', 'Descubra as maravilhas de Cidade do México, México. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Cidade do México! Esta viagem foi planejada para você aproveitar o melhor que México tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Cidade do México</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Cidade do México.</p>', '9054.00', '5 dias', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', 'america-norte', 'cultura lazer', 'cidade do méxico méxico america-norte viagem turismo'),
(42, 'Explorando Buenos Aires', 'Descubra as maravilhas de Buenos Aires, Argentina. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Buenos Aires! Esta viagem foi planejada para você aproveitar o melhor que Argentina tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Buenos Aires</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Buenos Aires.</p>', '10183.00', '9 dias', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', 'america-sul', 'cultura lazer', 'buenos aires argentina america-sul viagem turismo'),
(43, 'Explorando Santiago', 'Descubra as maravilhas de Santiago, Chile. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Santiago! Esta viagem foi planejada para você aproveitar o melhor que Chile tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Santiago</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Santiago.</p>', '13214.00', '7 dias', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?auto=format&fit=crop&w=800&q=80', 'america-sul', 'cultura lazer', 'santiago chile america-sul viagem turismo'),
(44, 'Explorando Bogotá', 'Descubra as maravilhas de Bogotá, Colômbia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Bogotá! Esta viagem foi planejada para você aproveitar o melhor que Colômbia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Bogotá</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Bogotá.</p>', '5914.00', '11 dias', 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=800&q=80', 'america-sul', 'cultura lazer', 'bogotá colômbia america-sul viagem turismo'),
(45, 'Explorando Cidade do Cabo', 'Descubra as maravilhas de Cidade do Cabo, África do Sul. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Cidade do Cabo! Esta viagem foi planejada para você aproveitar o melhor que África do Sul tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Cidade do Cabo</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Cidade do Cabo.</p>', '5492.00', '11 dias', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80', 'africa', 'cultura lazer', 'cidade do cabo África do sul africa viagem turismo'),
(46, 'Explorando Cairo', 'Descubra as maravilhas de Cairo, Egito. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Cairo! Esta viagem foi planejada para você aproveitar o melhor que Egito tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Cairo</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Cairo.</p>', '13276.00', '13 dias', 'https://images.unsplash.com/photo-1503220317375-aaad61436b1b?auto=format&fit=crop&w=800&q=80', 'africa', 'cultura lazer', 'cairo egito africa viagem turismo'),
(47, 'Explorando Marrakech', 'Descubra as maravilhas de Marrakech, Marrocos. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Marrakech! Esta viagem foi planejada para você aproveitar o melhor que Marrocos tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Marrakech</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Marrakech.</p>', '8621.00', '12 dias', 'https://images.unsplash.com/photo-1500835556837-99ac94a94552?auto=format&fit=crop&w=800&q=80', 'africa', 'cultura lazer', 'marrakech marrocos africa viagem turismo'),
(48, 'Explorando Sydney', 'Descubra as maravilhas de Sydney, Austrália. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Sydney! Esta viagem foi planejada para você aproveitar o melhor que Austrália tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Sydney</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Sydney.</p>', '10071.00', '11 dias', 'https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=800&q=80', 'oceania', 'cultura lazer', 'sydney austrália oceania viagem turismo'),
(49, 'Explorando Melbourne', 'Descubra as maravilhas de Melbourne, Austrália. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Melbourne! Esta viagem foi planejada para você aproveitar o melhor que Austrália tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Melbourne</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Melbourne.</p>', '4712.00', '15 dias', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80', 'oceania', 'cultura lazer', 'melbourne austrália oceania viagem turismo'),
(50, 'Explorando Auckland', 'Descubra as maravilhas de Auckland, Nova Zelândia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Auckland! Esta viagem foi planejada para você aproveitar o melhor que Nova Zelândia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Auckland</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Auckland.</p>', '7272.00', '12 dias', 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=800&q=80', 'oceania', 'cultura lazer', 'auckland nova zelândia oceania viagem turismo');
INSERT INTO `viagens` (`id`, `titulo`, `descricao_curta`, `descricao_longa`, `incluso_html`, `nao_incluso_html`, `itinerario_html`, `hospedagem_html`, `preco`, `duracao`, `imagem_url`, `continente`, `categorias`, `keywords`) VALUES
(51, 'Explorando Istambul', 'Descubra as maravilhas de Istambul, Turquia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Istambul! Esta viagem foi planejada para você aproveitar o melhor que Turquia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Istambul</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Istambul.</p>', '14200.00', '14 dias', 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'istambul turquia europa viagem turismo'),
(52, 'Explorando Jerusalém', 'Descubra as maravilhas de Jerusalém, Israel. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Jerusalém! Esta viagem foi planejada para você aproveitar o melhor que Israel tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Jerusalém</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Jerusalém.</p>', '6734.00', '11 dias', 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'jerusalém israel asia viagem turismo'),
(53, 'Explorando Petra', 'Descubra as maravilhas de Petra, Jordânia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Petra! Esta viagem foi planejada para você aproveitar o melhor que Jordânia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Petra</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Petra.</p>', '11917.00', '15 dias', 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?auto=format&fit=crop&w=800&q=80', 'asia', 'cultura lazer', 'petra jordânia asia viagem turismo'),
(54, 'Explorando Machu Picchu', 'Descubra as maravilhas de Machu Picchu, Peru. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Machu Picchu! Esta viagem foi planejada para você aproveitar o melhor que Peru tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Machu Picchu</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Machu Picchu.</p>', '5935.00', '6 dias', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', 'america-sul', 'cultura lazer', 'machu picchu peru america-sul viagem turismo'),
(55, 'Explorando Rio de Janeiro', 'Descubra as maravilhas de Rio de Janeiro, Brasil. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Rio de Janeiro! Esta viagem foi planejada para você aproveitar o melhor que Brasil tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Rio de Janeiro</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Rio de Janeiro.</p>', '8803.00', '15 dias', 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80', 'america-sul', 'cultura lazer', 'rio de janeiro brasil america-sul viagem turismo'),
(56, 'Explorando Havana', 'Descubra as maravilhas de Havana, Cuba. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Havana! Esta viagem foi planejada para você aproveitar o melhor que Cuba tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Havana</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Havana.</p>', '8531.00', '9 dias', 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80', 'america-central', 'cultura lazer', 'havana cuba america-central viagem turismo'),
(57, 'Explorando Cartagena', 'Descubra as maravilhas de Cartagena, Colômbia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Cartagena! Esta viagem foi planejada para você aproveitar o melhor que Colômbia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Cartagena</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Cartagena.</p>', '6139.00', '9 dias', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80', 'america-sul', 'cultura lazer', 'cartagena colômbia america-sul viagem turismo'),
(58, 'Explorando Reykjavik', 'Descubra as maravilhas de Reykjavik, Islândia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Reykjavik! Esta viagem foi planejada para você aproveitar o melhor que Islândia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Reykjavik</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Reykjavik.</p>', '12957.00', '11 dias', 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'reykjavik islândia europa viagem turismo'),
(59, 'Explorando Santorini', 'Descubra as maravilhas de Santorini, Grécia. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Santorini! Esta viagem foi planejada para você aproveitar o melhor que Grécia tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Santorini</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Santorini.</p>', '11833.00', '9 dias', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'santorini grécia europa viagem turismo'),
(60, 'Explorando Veneza', 'Descubra as maravilhas de Veneza, Itália. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Veneza! Esta viagem foi planejada para você aproveitar o melhor que Itália tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Veneza</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Veneza.</p>', '8556.00', '6 dias', 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'veneza itália europa viagem turismo'),
(61, 'Explorando Florença', 'Descubra as maravilhas de Florença, Itália. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Florença! Esta viagem foi planejada para você aproveitar o melhor que Itália tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Florença</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Florença.</p>', '7248.00', '11 dias', 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'florença itália europa viagem turismo'),
(62, 'Explorando Munique', 'Descubra as maravilhas de Munique, Alemanha. Uma viagem inesquecível espera por você.', '<p>Bem-vindo a Munique! Esta viagem foi planejada para você aproveitar o melhor que Alemanha tem a oferecer. Cultura, gastronomia e paisagens deslumbrantes.</p><p>Prepare-se para dias de muita aventura e descobertas em um dos destinos mais procurados do mundo.</p>', '<ul><li>Passagem aérea</li><li>Hospedagem</li><li>Café da manhã</li><li>Guia local</li></ul>', '<ul><li>Almoço e Jantar</li><li>Despesas pessoais</li></ul>', '<ol><li>Chegada em Munique</li><li>City Tour</li><li>Dia Livre</li><li>Passeio Cultural</li><li>Retorno</li></ol>', '<p>Hospedagem em hotéis 4 estrelas bem localizados em Munique.</p>', '4550.00', '14 dias', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', 'europa', 'cultura lazer', 'munique alemanha europa viagem turismo');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `artigos_blog`
--
ALTER TABLE `artigos_blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);
ALTER TABLE `artigos_blog` ADD FULLTEXT KEY `titulo` (`titulo`,`resumo`,`conteudo_html`);

--
-- Índices para tabela `artigo_tags`
--
ALTER TABLE `artigo_tags`
  ADD PRIMARY KEY (`artigo_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `viagem_id` (`viagem_id`);

--
-- Índices para tabela `favoritos_viagens`
--
ALTER TABLE `favoritos_viagens`
  ADD PRIMARY KEY (`usuario_id`,`viagem_id`),
  ADD KEY `viagem_id` (`viagem_id`);

--
-- Índices para tabela `momentos`
--
ALTER TABLE `momentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `viagem_id` (`viagem_id`);

--
-- Índices para tabela `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topico_id` (`topico_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `topicos`
--
ALTER TABLE `topicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `viagem_locations`
--
ALTER TABLE `viagem_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `viagem_id` (`viagem_id`);

--
-- Índices para tabela `viagens`
--
ALTER TABLE `viagens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `artigos_blog`
--
ALTER TABLE `artigos_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `momentos`
--
ALTER TABLE `momentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `topicos`
--
ALTER TABLE `topicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de tabela `viagem_locations`
--
ALTER TABLE `viagem_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `viagens`
--
ALTER TABLE `viagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `artigos_blog`
--
ALTER TABLE `artigos_blog`
  ADD CONSTRAINT `artigos_blog_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `artigo_tags`
--
ALTER TABLE `artigo_tags`
  ADD CONSTRAINT `artigo_tags_ibfk_1` FOREIGN KEY (`artigo_id`) REFERENCES `artigos_blog` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `artigo_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`viagem_id`) REFERENCES `viagens` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `favoritos_viagens`
--
ALTER TABLE `favoritos_viagens`
  ADD CONSTRAINT `favoritos_viagens_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_viagens_ibfk_2` FOREIGN KEY (`viagem_id`) REFERENCES `viagens` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `momentos`
--
ALTER TABLE `momentos`
  ADD CONSTRAINT `momentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`viagem_id`) REFERENCES `viagens` (`id`) ON DELETE SET NULL;

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `respostas_ibfk_1` FOREIGN KEY (`topico_id`) REFERENCES `topicos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `respostas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `topicos`
--
ALTER TABLE `topicos`
  ADD CONSTRAINT `topicos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `viagem_locations`
--
ALTER TABLE `viagem_locations`
  ADD CONSTRAINT `viagem_locations_ibfk_1` FOREIGN KEY (`viagem_id`) REFERENCES `viagens` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
