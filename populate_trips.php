<?php
include 'config.php';
include 'db_connect.php';

// Verifica quantas viagens existem
$stmt = $conn->query("SELECT COUNT(*) FROM viagens");
$count = $stmt->fetchColumn();

echo "Viagens atuais: $count<br>";

if ($count < 3) {
    echo "Inserindo viagens de teste...<br>";

    $viagens_teste = [
        [
            'titulo' => 'Aventura nos Alpes',
            'descricao_curta' => 'Uma jornada incrível pelas montanhas.',
            'descricao_longa' => 'Explore os picos mais altos e desfrute de vistas deslumbrantes.',
            'preco' => 2500.00,
            'duracao' => '7 dias',
            'continente' => 'Europa',
            'categorias' => 'Aventura, Natureza',
            'imagem_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1770',
            'keywords' => 'Montanha, Neve, Ski',
            'lat' => 46.8182,
            'lng' => 8.2275
        ],
        [
            'titulo' => 'Relaxamento em Bali',
            'descricao_curta' => 'Praias paradisíacas e templos antigos.',
            'descricao_longa' => 'Relaxe nas areias brancas e descubra a cultura local.',
            'preco' => 3200.00,
            'duracao' => '10 dias',
            'continente' => 'Ásia',
            'categorias' => 'Relaxamento, Cultura',
            'imagem_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1738',
            'keywords' => 'Praia, Sol, Templo',
            'lat' => -8.4095,
            'lng' => 115.1889
        ],
        [
            'titulo' => 'Safari na África do Sul',
            'descricao_curta' => 'Encontre os "Big Five" em seu habitat natural.',
            'descricao_longa' => 'Uma experiência selvagem inesquecível nas savanas africanas.',
            'preco' => 4500.00,
            'duracao' => '5 dias',
            'continente' => 'África',
            'categorias' => 'Natureza, Aventura',
            'imagem_url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=1768',
            'keywords' => 'Safari, Leão, Savana',
            'lat' => -25.7479,
            'lng' => 28.2293
        ]
    ];

    $stmt_insert = $conn->prepare("INSERT INTO viagens (titulo, descricao_curta, descricao_longa, preco, duracao, continente, categorias, imagem_url, keywords) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_loc = $conn->prepare("INSERT INTO viagem_locations (viagem_id, nome, latitude, longitude) VALUES (?, ?, ?, ?)");

    foreach ($viagens_teste as $v) {
        try {
            $stmt_insert->execute([
                $v['titulo'], $v['descricao_curta'], $v['descricao_longa'], 
                $v['preco'], $v['duracao'], $v['continente'], 
                $v['categorias'], $v['imagem_url'], $v['keywords']
            ]);
            $id = $conn->lastInsertId();
            
            // Insere localização
            $stmt_loc->execute([$id, $v['titulo'], $v['lat'], $v['lng']]);
            
            echo "Inserida: {$v['titulo']} (ID: $id)<br>";
        } catch (Exception $e) {
            echo "Erro ao inserir {$v['titulo']}: " . $e->getMessage() . "<br>";
        }
    }
} else {
    echo "Já existem viagens suficientes.<br>";
}

echo "Concluído.";
?>
