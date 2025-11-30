<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Blog - WonderFly Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <!-- Include Blog CSS for Preview -->
    <link rel="stylesheet" href="../CSS/blog-article.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        /* Editor Specific Styles */
        .editor-container {
            display: flex;
            gap: 20px;
            height: calc(100vh - 100px);
            position: relative;
        }
        
        /* Fullscreen Styles */
        .editor-container.fullscreen .editor-form {
            display: none;
        }
        .editor-container.fullscreen .editor-preview {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            border-radius: 0;
            padding: 40px;
        }
        .fullscreen-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 100;
            background: rgba(0,0,0,0.6);
            color: #fff;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
        }
        .fullscreen-btn:hover {
            background: rgba(0,0,0,0.8);
        }

        .editor-form {
            flex: 1;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .editor-preview {
            flex: 1;
            background: #fff; /* Preview needs white bg like real site */
            border-radius: 12px;
            overflow-y: auto;
            color: #222; /* Reset text color for preview */
            position: relative;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .form-group label {
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .form-group input, .form-group textarea {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 10px;
            border-radius: 8px;
            color: var(--text-light);
            font-family: inherit;
        }
        .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }
        .preview-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0,0,0,0.5);
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            z-index: 10;
        }
        /* Overwrite some blog css for preview context if needed */
        .editor-preview .article-hero {
            border-radius: 12px 12px 0 0;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <img src="../images/logo.png" alt="WonderFly Logo" style="height: 40px; margin-right: 10px;">
            <span>WonderFly</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            <a href="blog.php" class="nav-item active">
                <i class="ri-article-line"></i> Blog
            </a>
            <a href="forum.php" class="nav-item">
                <i class="ri-discuss-line"></i> Fórum
            </a>
            <a href="users.php" class="nav-item">
                <i class="ri-user-line"></i> Usuários
            </a>
            <a href="trips.php" class="nav-item">
                <i class="ri-map-pin-line"></i> Viagens
            </a>
            <a href="reviews.php" class="nav-item">
                <i class="ri-star-line"></i> Avaliações
            </a>
            <a href="../index.php" class="nav-item">
                <i class="ri-arrow-left-line"></i> Voltar ao Site
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header-bar">
            <div class="header-title">
                <h1>Novo Artigo</h1>
            </div>
            <div class="action-buttons">
                <input type="file" id="contentUpload" accept=".txt,.pdf,.docx" style="display: none;">
                <button class="btn-export" onclick="document.getElementById('contentUpload').click()">
                    <i class="ri-upload-cloud-line"></i> Importar Arquivo
                </button>
                <button class="btn-export" onclick="history.back()">Cancelar</button>
                <button class="btn-add" onclick="savePost()">Salvar Artigo</button>
            </div>
        </div>

        <div class="editor-container">
            <!-- Form -->
            <div class="editor-form">
                <div class="form-group">
                    <label>Título</label>
                    <input type="text" id="postTitle" placeholder="Título do artigo">
                </div>
                <div class="form-group">
                    <label>Autor (Manual)</label>
                    <input type="text" id="postAuthor" placeholder="Nome do Autor (ex: Admin)">
                </div>
                <div class="form-group">
                    <label>Resumo</label>
                    <textarea id="postSummary" style="min-height: 80px;" placeholder="Breve resumo..."></textarea>
                </div>
                <div class="form-group">
                    <label>URL da Imagem de Capa</label>
                    <input type="text" id="postImage" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label>Conteúdo (HTML)</label>
                    <textarea id="postContent" placeholder="<p>Escreva seu conteúdo aqui...</p>"></textarea>
                    <small style="color: var(--text-muted)">Use tags HTML como &lt;h2&gt;, &lt;p&gt;, &lt;img&gt;</small>
                </div>
            </div>

            <!-- Live Preview -->
            <div class="editor-preview" id="previewArea">
                <span class="preview-label">Live Preview</span>
                
                <!-- Hero Section -->
                <section class="article-hero" id="previewHero">
                    <div class="article-hero-content">
                        <div class="article-category">Categoria</div>
                        <h1 id="previewTitle">Título do Artigo</h1>
                        <div class="article-meta">
                            <span><i class="ri-calendar-line"></i> Hoje</span>
                            <span><i class="ri-user-line"></i> Admin</span>
                        </div>
                    </div>
                </section>

                <!-- Content Section -->
                <section class="article-content-section">
                    <div class="article-main">
                        <div class="article-subtitle" id="previewSummary">
                            Resumo do artigo aparecerá aqui...
                        </div>
                        <div id="previewContent">
                            <p>O conteúdo do artigo aparecerá aqui...</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </main>

    <script src="js/blog_editor.js"></script>
    <script>
        document.getElementById('contentUpload').addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);

            const btn = document.querySelector('.btn-export[onclick*="contentUpload"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i> Processando...';
            btn.disabled = true;

            try {
                const response = await fetch('../api/parse_content.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    if (result.title) document.getElementById('postTitle').value = result.title;
                    if (result.content) {
                        // For Blog, we want HTML content if possible, but the API returns nl2br-ed content.
                        // The textarea placeholder suggests HTML tags are allowed.
                        // So we can use the content as is (with <br>).
                        document.getElementById('postContent').value = result.content;
                    }
                    alert('Conteúdo importado com sucesso!');
                } else {
                    alert('Erro ao importar: ' + result.message);
                }
            } catch (error) {
                console.error(error);
                alert('Erro na requisição.');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
                e.target.value = ''; // Reset input
            }
        });
    </script>
</body>
</html>
