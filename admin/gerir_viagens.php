<?php
// 1. Define o 'slug' e 'título' desta página
$page_slug = 'gerir_viagens';
$page_title = 'Gerir Viagens';

// 2. Inclui o Guardião
include 'admin_guardian.php';

// 3. Busca todas as viagens no banco
try {
    $stmt = $conn->prepare("SELECT id, titulo, preco, duracao FROM viagens ORDER BY titulo ASC");
    $stmt->execute();
    $viagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $db_error = "Erro ao buscar viagens: " . $e->getMessage();
}

// 4. Inclui o Header (Sidebar e Topo)
include 'templates/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Gerir Viagens (<?php echo count($viagens); ?>)</h1>
    <a href="<?php echo BASE_URL; ?>admin/editar_viagem.php" class="btn primary">
        <i class="ri-add-line"></i> Nova Viagem
    </a>
</div>

<?php if (isset($db_error)) echo "<p style='color: red;'>$db_error</p>"; ?>

<div class="content-card">
    <table class="responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Preço</th>
                <th>Duração</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($viagens)): ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Nenhuma viagem cadastrada.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($viagens as $viagem): ?>
                    <tr id="viagem-row-<?php echo $viagem['id']; ?>">
                        <td><?php echo $viagem['id']; ?></td>
                        <td><?php echo htmlspecialchars($viagem['titulo']); ?></td>
                        <td>R$ <?php echo number_format($viagem['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($viagem['duracao']); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>admin/editar_viagem.php?id=<?php echo $viagem['id']; ?>" class="btn secondary" style="padding: 5px 10px; font-size: 0.8rem;">
                                <i class="ri-pencil-line"></i> Editar
                            </a>
                            <button class="btn primary btn-delete" data-id="<?php echo $viagem['id']; ?>" style="padding: 5px 10px; font-size: 0.8rem; background-color: #c0392b;">
                                <i class="ri-delete-bin-line"></i> Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
// 5. Inclui o Footer
include 'templates/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. A 'baseUrl' é definida no config.php e templates
    const baseUrl = '<?php echo BASE_URL; ?>';
    
    // 2. Pega todos os botões de excluir
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const viagemId = button.dataset.id;
            const row = document.getElementById(`viagem-row-${viagemId}`);
            
            // 3. Mostra o pop-up de confirmação
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Esta ação é irreversível! O favorito, locais e reservas desta viagem também serão apagados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e63946',
                cancelButtonColor: '#555',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 4. Se confirmou, chama a API
                    executeDelete(viagemId, row);
                }
            });
        });
    });

    async function executeDelete(id, rowElement) {
        try {
            const response = await fetch(`${baseUrl}api/admin_delete_viagem.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });

            if (!response.ok) throw new Error('Erro na resposta da rede.');
            const result = await response.json();

            if (result.success) {
                // 5. Remove a linha da tabela (feedback visual)
                rowElement.style.opacity = 0;
                rowElement.style.transition = 'all 0.3s ease';
                setTimeout(() => rowElement.remove(), 300);
                
                Swal.fire('Excluído!', 'A viagem foi removida.', 'success');
            } else {
                throw new Error(result.message || 'Erro ao excluir.');
            }

        } catch (error) {
            Swal.fire('Erro!', error.message, 'error');
        }
    }
});
</script>