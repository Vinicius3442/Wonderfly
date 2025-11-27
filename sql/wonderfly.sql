-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Nov-2025 às 17:58
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
(1, 'Butão: O Reino da Felicidade e Suas Montanhas Misteriosas', 'Explore o Butão, um reino escondido nas montanhas do Himalaia, conhecido por sua rica cultura, paisagens deslumbrantes e a busca pela felicidade genuína.', '<h2>Introdução: Um País Onde a Felicidade é Prioridade</h2><p>Escondido nas majestosas montanhas do Himalaia, o Butão se destaca como um dos destinos mais intrigantes e singulares do planeta. Diferente de muitos países que medem o sucesso pelo Produto Interno Bruto (PIB), o Butão adota a \"Felicidade Interna Bruta\" (FIB) como seu principal indicador de progresso. Essa filosofia permeia todos os aspectos da vida butanesa, desde as políticas governamentais até o dia a dia de seus habitantes.</p><p>Neste artigo, a WonderFly te convida a desvendar os mistérios e encantos desse reino isolado, explorando suas tradições milenares, paisagens deslumbrantes e a calorosa hospitalidade de seu povo.</p><h2>A Cultura e Tradições Butanesas</h2><p>A cultura do Butão é profundamente enraizada no Budismo Vajrayana...</p><img src=\"https://i0.wp.com/www.mochilaoadois.com.br/wp-content/uploads/2018/04/zhana_chham1_dzongdrakha_tshechu.jpg?w=700\" alt=\"Butaneses em trajes tradicionais\" class=\"article-image\"><figcaption class_=\"image-caption\">Dançarinos butaneses em máscaras tradicionais...</figcaption><h3>Os Tsechus: Festivais de Cor e Fé</h3><p>Os tsechus são eventos imperdíveis, repletos de danças sagradas...</p><h2>Paisagens Deslumbrantes e Aventura</h2><p>O Butão oferece paisagens de tirar o fôlego... a subida ao Ninho do Tigre (Paro Taktsang)...</p><blockquote class=\"pull-quote\">“Viajar para o Butão com a WonderFly foi mais do que uma viagem, foi uma transformação.”<span>— Ana Clara, viajante WonderFly.</span></blockquote><h3>Natureza Intocada e Sustentabilidade</h3><p>A preocupação com o meio ambiente é fundamental no Butão...</p><h2>Planeje Sua Viagem ao Butão com a WonderFly</h2><p>A WonderFly é especialista em conectar você a culturas autênticas...</p>', 'https://www.flipar.com.br/wp-content/uploads/2024/08/bhutan-2211514_640.jpg?20250518170531', '2025-10-19 13:00:00', 1);

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
(2, 5, 'A melhor agência para quem busca imersão cultural. O festival Holi na Índia foi algo que jamais esquecerei. Seguro e autêntico.', '2025-10-31 11:56:41', 2, 2);

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
(3, 2, '2025-11-03 17:41:05');

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

--
-- Extraindo dados da tabela `momentos`
--

INSERT INTO `momentos` (`id`, `descricao`, `foto_url`, `latitude`, `longitude`, `data_criacao`, `usuario_id`) VALUES
(1, 'Teste', 'uploads/momento_3_1761915522.jfif', '-17.23708764', '-49.34932478', '2025-10-31 12:58:42', 3);

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
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha_hash`, `nome_exibicao`, `bio`, `avatar_url`, `banner_url`, `is_admin`, `data_criacao`) VALUES
(1, 'ana@exemplo.com', 'senha_hash_fake_123', 'Ana Ribeiro', NULL, './images/profile/default.jpg', NULL, 0, '2025-10-31 11:56:24'),
(2, 'carlos@exemplo.com', 'senha_hash_fake_456', 'Carlos Mendes', NULL, './images/profile/default.jpg', NULL, 0, '2025-10-31 11:56:24'),
(3, 'vini@email.com', '$2y$10$n34etN8hyUHcIAyd3kAAOuQxd360KUdxInnzYciZU6D2MS6NBe9Zq', 'Vinicius', 'Olá este é o primeiro teste de db', 'uploads/avatar_3_1761915505.jfif', NULL, 1, '2025-10-31 12:37:26');

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
(6, 1, 'Machu Picchu', '-13.16310000', '-72.54500000');

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
(2, 'Patrimônios no Irã', 'Uma jornada imersiva pelas antigas civilizações e a rica cultura persa.', '<p>Prepare-se para uma viagem inesquecível ao coração da antiga Pérsia, onde a história ganha vida em cada esquina. Nosso roteiro \"Patrimônios no Irã\" foi cuidadosamente elaborado para você explorar cidades lendárias, maravilhas arquitetônicas e a hospitalidade calorosa do povo iraniano. De mercados vibrantes a mesquitas adornadas e jardins serenos, cada momento é uma imersão profunda em uma cultura rica e milenar.</p><p>Nossos guias locais experientes o levarão por Persepolis, a magnífica capital do Império Aquemênida, os coloridos bazares de Isfahan e os mausoléus poéticos de Shiraz. Viva experiências autênticas, como saborear a culinária persa em restaurantes tradicionais e interagir com artesãos locais. Uma aventura que promete transformar sua visão de mundo e criar memorias duradouras.</p>', '<h3>O que está incluso</h3><ul><li><i class=\"ri-check-line\"></i> Passagens aéreas de ida e volta (com conexão)</li><li><i class=\"ri-check-line\"></i> Hospedagem em hotéis boutique e casas tradicionais com café da manhã</li><li><i class=\"ri-check-line\"></i> Todos os transportes internos (terrestre e aéreo)</li><li><i class=\"ri-check-line\"></i> Guias locais especializados em história e cultura</li><li><i class=\"ri-check-line\"></i> Taxas de entrada para todos os sítios históricos e museus</li><li><i class=\"ri-check-line\"></i> Jantares especiais com culinária persa autêntica</li><li><i class=\"ri-check-line\"></i> Seguro viagem completo</li><li><i class=\"ri-check-line\"></i> Suporte 24/7 da WonderFly</li></ul>', '<h3>Não incluso</h3><ul><li><i class=\"ri-close-line\"></i> Visto de entrada no Irã (auxílio na documentação)</li><li><i class=\"ri-close-line\"></i> Almoços e bebidas (exceto onde especificado)</li><li><i class=\"ri-close-line\"></i> Despesas pessoais</li><li><i class=\"ri-close-line\"></i> Gorjetas</li></ul>', '<h3>Itinerário detalhado</h3><ol class=\"itinerary-list\"><li class=\"day\"><h4>Dia 1: Chegada em Teerã</h4><p>Bem-vindo ao Irã! Chegada ao Aeroporto Internacional Imam Khomeini (IKA), recepção e traslado ao hotel. Resto do dia livre para descanso e adaptação. Jantar de boas-vindas com o grupo.</p></li><li class=\"day\"><h4>Dia 2: Teerã – Capital cultural</h4><p>Explore o Palácio Golestan (Patrimônio Mundial da UNESCO), o Museu Nacional e o Grande Bazar de Teerã. À noite, jantar e experiência em uma casa de chá tradicional.</p></li><li class=\"day\"><h4>Dia 3: Voo para Isfahan – A joia persa</h4><p>Voo doméstico para Isfahan. Visita à Praça Naqsh-e Jahan (Patrimônio Mundial da UNESCO), Mesquita Shah, Mesquita Sheikh Lotfollah e Palácio Ali Qapu.</p></li><li class=\"day\"><h4>Dia 4: Isfahan – Pontes e Bazares</h4><p>Caminhe pelas pontes históricas de Khaju e Si-o-Se-Pol. Explore o bairro armênio de Jolfa e a Catedral de Vank. Tarde livre para explorar o Bazar Qeysarieh.</p></li><li class=\"day\"><h4>Dia 5: Viagem para Yazd</h4><p>Viagem terrestre para Yazd, a cidade de adobe. No caminho, parada em Na\'in para ver a antiga mesquita. Check-in no hotel em Yazd e passeio pelo centro histórico.</p></li><li class=\"day\"><h4>Dia 6: Yazd – Cidade do Fogo</h4><p>Visite as Torres do Silêncio (locais de enterro Zoroastristas), o Templo do Fogo Atash Behram e o complexo Amir Chakhmaq. Aprenda sobre os \'qanats\' (sistemas de água).</p></li><li class=\"day\"><h4>Dia 7: Rumo a Shiraz – Berço dos Poetas</h4><p>Viagem para Shiraz. No caminho, parada em Pasárgada, a tumba de Ciro, o Grande. Chegada em Shiraz ao final da tarde e jantar.</p></li><li class=\"day\"><h4>Dia 8: Persepolis e Necrópole</h4><p>Excursão de dia inteiro a Persepolis, a capital cerimonial do Império Aquemênida. Visite também Naqsh-e Rustam (Necrópole) com as tumbas dos reis persas.</p></li><li class=\"day\"><h4>Dia 9: Shiraz – Mesquitas e mercados</h4><p>Visita à Mesquita Nasir al-Mulk (Mesquita Rosa) e ao Jardim Narenjestan. Tempo para compras no Bazar Vakil e visita à Cidadela de Karim Khan. Jantar de despedida.</p></li><li class=\"day\"><h4>Dia 10: Partida de Shiraz</h4><p>Após o café da manhã, traslado ao Aeroporto Internacional de Shiraz (SYZ) para seu voo de retorno.</p></li></ol>', '<h3>Hospedagem selecionada</h3><div class=\"hotel-card\"><img src=\"https://dynamic-media-cdn.tripadvisor.com/media/photo-o/07/05/8d/3b/main-yard-atnight.jpg?w=900&h=500&s=1\" alt=\"Pátio interno do Hotel Saraye Ameriha em Kashan\"><div class=\"hotel-info\"><h4>Hotel Saraye Ameriha, Kashan</h4><p>Um hotel boutique luxuoso em uma casa histórica restaurada...</p><ul><li><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i> (5 estrelas)</li><li><i class=\"ri-restaurant-line\"></i> Restaurante no local</li><li><i class=\"ri-wifi-line\"></i> Wi-Fi gratuito</li></ul></div></div><div class=\"hotel-card\"><img src=\"https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/8c/39/cc/uninterrupted-city-view.jpg?w=900&h=500&s=1\" alt=\"Fachada do Espinas Palace Hotel em Teerã\"><div class=\"hotel-info\"><h4>Espinas Palace Hotel, Teerã</h4><p>Um dos hotéis mais prestigiados de Teerã...</p><ul><li><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-fill\"></i><i class=\"ri-star-half-fill\"></i> (4.5 estrelas)</li><li><i class=\"ri-door-line\"></i> Quartos espaçosos</li><li><i class=\"ri-fitness-line\"></i> Centro de fitness</li></ul></div></div>', '6450.00', '10 dias', 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1600&auto=format&fit=crop', 'asia', 'historia arte', 'irã persia teerã isfahan shiraz');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `topicos`
--
ALTER TABLE `topicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `viagem_locations`
--
ALTER TABLE `viagem_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `viagens`
--
ALTER TABLE `viagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
