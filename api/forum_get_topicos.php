<?php
include '../config.php';
include '../db_connect.php';

header('Content-Type: application/json');

try {
    // Query que junta Tópicos, Usuários (para o nome do autor) e Respostas (para a contagem)
    $sql = "
        SELECT 
            t.id, t.board, t.assunto, t.mensagem, t.imagem_url, t.data_criacao,
            u.nome_exibicao AS autor_nome,
            u.avatar_url AS autor_avatar,
            COUNT(r.id) AS total_respostas
        FROM topicos AS t
        LEFT JOIN usuarios AS u ON t.usuario_id = u.id
        LEFT JOIN respostas AS r ON t.id = r.topico_id
        GROUP BY t.id
        ORDER BY t.data_criacao DESC
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $topicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'topicos' => $topicos]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro de banco de dados: ' . $e->getMessage()]);
}
?>