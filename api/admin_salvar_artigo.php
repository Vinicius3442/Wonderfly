<?php
// 1. Inclui o Guardião
include 'admin_guardian.php';

// 2. Verifica se é POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Acesso negado.");
}

// 3. Pega todos os dados do formulário
$artigo_id = $_POST['artigo_id'] ?? null;
$titulo = $_POST['titulo'];
$resumo = $_POST['resumo'];
$imagem_destaque_url = $_POST['imagem_destaque_url'];
$conteudo_html = $_POST['conteudo_html'];
$tags_string = $_POST['tags']; // Ex: "Asia, Cultura, Dicas"

// 4. Inicia a Transação
$conn->beginTransaction();

try {
    if ($artigo_id) {
        // --- É UM UPDATE (Editar) ---
        $sql = "UPDATE artigos_blog SET 
                    titulo = :titulo, resumo = :resumo, 
                    imagem_destaque_url = :imagem_destaque_url, 
                    conteudo_html = :conteudo_html,
                    autor_id = :autor_id 
                WHERE id = :id";
        $params = [
            ':id' => $artigo_id,
            ':titulo' => $titulo,
            ':resumo' => $resumo,
            ':imagem_destaque_url' => $imagem_destaque_url,
            ':conteudo_html' => $conteudo_html,
            ':autor_id' => $_SESSION['user_id'] // Atualiza o autor
        ];
    } else {
        // --- É UM CREATE (Novo) ---
        $sql = "INSERT INTO artigos_blog 
                    (titulo, resumo, imagem_destaque_url, conteudo_html, autor_id) 
                VALUES 
                    (:titulo, :resumo, :imagem_destaque_url, :conteudo_html, :autor_id)";
        $params = [
            ':titulo' => $titulo,
            ':resumo' => $resumo,
            ':imagem_destaque_url' => $imagem_destaque_url,
            ':conteudo_html' => $conteudo_html,
            ':autor_id' => $_SESSION['user_id']
        ];
    }
    
    // Executa a query do artigo
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    if (!$artigo_id) {
        $artigo_id = $conn->lastInsertId();
    }

    // --- 5. ATUALIZA AS TAGS ---
    
    // 5a. Apaga todas as tags antigas deste artigo
    $stmt_del = $conn->prepare("DELETE FROM artigo_tags WHERE artigo_id = :id");
    $stmt_del->execute([':id' => $artigo_id]);

    // 5b. Prepara as novas tags
    $tags_array = explode(',', $tags_string); // ["Asia", " Cultura", " Dicas"]
    
    if (!empty($tags_array)) {
        $sql_tag = "INSERT IGNORE INTO tags (nome) VALUES (:nome)";
        $stmt_tag = $conn->prepare($sql_tag);
        
        $sql_link = "INSERT INTO artigo_tags (artigo_id, tag_id) 
                     VALUES (:artigo_id, (SELECT id FROM tags WHERE nome = :nome))";
        $stmt_link = $conn->prepare($sql_link);

        foreach ($tags_array as $tag_nome) {
            $tag_nome_limpo = trim($tag_nome);
            if (!empty($tag_nome_limpo)) {
                // Cria a tag (ignora se já existe)
                $stmt_tag->execute([':nome' => $tag_nome_limpo]);
                // Linka a tag ao artigo
                $stmt_link->execute([':artigo_id' => $artigo_id, ':nome' => $tag_nome_limpo]);
            }
        }
    }

    // 6. Confirma a Transação
    $conn->commit();
    
    // 7. Redireciona de volta para a lista
    header("Location: " . BASE_URL . "admin/gerir_blog.php");
    exit;

} catch (Exception $e) {
    // 8. Se algo deu errado, desfaz tudo
    $conn->rollBack();
    die("Erro ao salvar o artigo: " . $e->getMessage());
}
?>