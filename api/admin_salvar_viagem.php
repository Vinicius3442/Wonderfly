<?php
// 1. Inclui o Guardião (que também inclui config e db)
include 'admin_guardian.php';

// 2. Verifica se é POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Acesso negado.");
}

// 3. Pega todos os dados do formulário
$viagem_id = $_POST['viagem_id'] ?? null;
$titulo = $_POST['titulo'];
$descricao_curta = $_POST['descricao_curta'];
$preco = $_POST['preco'];
$duracao = $_POST['duracao'];
$imagem_url = $_POST['imagem_url'];
$continente = $_POST['continente'];
$categorias = $_POST['categorias'];
$keywords = $_POST['keywords'];
$descricao_longa = $_POST['descricao_longa'];
$incluso_html = $_POST['incluso_html'];
$nao_incluso_html = $_POST['nao_incluso_html'];
$itinerario_html = $_POST['itinerario_html'];
$hospedagem_html = $_POST['hospedagem_html'];
$locations_json = $_POST['locations_json'];
$locations = json_decode($locations_json, true);

// 4. Inicia a Transação (Tudo ou Nada)
$conn->beginTransaction();

try {
    if ($viagem_id) {
        // --- É UM UPDATE (Editar) ---
        $sql = "UPDATE viagens SET 
                    titulo = :titulo, descricao_curta = :descricao_curta, preco = :preco, 
                    duracao = :duracao, imagem_url = :imagem_url, continente = :continente, 
                    categorias = :categorias, keywords = :keywords, descricao_longa = :descricao_longa, 
                    incluso_html = :incluso_html, nao_incluso_html = :nao_incluso_html, 
                    itinerario_html = :itinerario_html, hospedagem_html = :hospedagem_html 
                WHERE id = :id";
        $params = [
            ':id' => $viagem_id, ':titulo' => $titulo, ':descricao_curta' => $descricao_curta,
            ':preco' => $preco, ':duracao' => $duracao, ':imagem_url' => $imagem_url,
            ':continente' => $continente, ':categorias' => $categorias, ':keywords' => $keywords,
            ':descricao_longa' => $descricao_longa, ':incluso_html' => $incluso_html,
            ':nao_incluso_html' => $nao_incluso_html, ':itinerario_html' => $itinerario_html,
            ':hospedagem_html' => $hospedagem_html
        ];
    } else {
        // --- É UM CREATE (Novo) ---
        $sql = "INSERT INTO viagens 
                    (titulo, descricao_curta, preco, duracao, imagem_url, continente, 
                     categorias, keywords, descricao_longa, incluso_html, 
                     nao_incluso_html, itinerario_html, hospedagem_html) 
                VALUES 
                    (:titulo, :descricao_curta, :preco, :duracao, :imagem_url, :continente, 
                     :categorias, :keywords, :descricao_longa, :incluso_html, 
                     :nao_incluso_html, :itinerario_html, :hospedagem_html)";
        $params = [
            ':titulo' => $titulo, ':descricao_curta' => $descricao_curta,
            ':preco' => $preco, ':duracao' => $duracao, ':imagem_url' => $imagem_url,
            ':continente' => $continente, ':categorias' => $categorias, ':keywords' => $keywords,
            ':descricao_longa' => $descricao_longa, ':incluso_html' => $incluso_html,
            ':nao_incluso_html' => $nao_incluso_html, ':itinerario_html' => $itinerario_html,
            ':hospedagem_html' => $hospedagem_html
        ];
    }
    
    // Executa a query da viagem
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Se for uma nova viagem, pega o ID
    if (!$viagem_id) {
        $viagem_id = $conn->lastInsertId();
    }

    // --- 5. ATUALIZA OS PINS DO MAPA ---
    // (A forma mais segura é apagar os antigos e inserir os novos)
    
    // 5a. Apaga todos os locais antigos desta viagem
    $stmt_del = $conn->prepare("DELETE FROM viagem_locations WHERE viagem_id = :id");
    $stmt_del->execute([':id' => $viagem_id]);

    // 5b. Insere os novos locais
    if (!empty($locations)) {
        $sql_loc = "INSERT INTO viagem_locations (viagem_id, nome, latitude, longitude) 
                    VALUES (:viagem_id, :nome, :lat, :lng)";
        $stmt_loc = $conn->prepare($sql_loc);
        
        foreach ($locations as $loc) {
            $stmt_loc->execute([
                ':viagem_id' => $viagem_id,
                ':nome' => $loc['nome'],
                ':lat' => $loc['latitude'],
                ':lng' => $loc['longitude']
            ]);
        }
    }

    // 6. Confirma a Transação
    $conn->commit();
    
    // 7. Redireciona de volta para a lista
    // (Poderíamos adicionar uma msg de sucesso na sessão)
    header("Location: " . BASE_URL . "admin/gerir_viagens.php");
    exit;

} catch (Exception $e) {
    // 8. Se algo deu errado, desfaz tudo
    $conn->rollBack();
    die("Erro ao salvar a viagem: " . $e->getMessage());
}
?>