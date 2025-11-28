# Wonderfly | A Magia de Viajar ao Seu Alcance

![Badge de Status](http://img.shields.io/static/v1?label=STATUS&message=EM_DESENVOLVIMENTO&color=yellow&style=for-the-badge)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00618A?style=for-the-badge&logo=mysql&logoColor=white)
![JSON](https://img.shields.io/badge/JSON-000000?style=for-the-badge&logo=json&logoColor=white)

> **Plataforma web dinâmica inspirada no mundo das viagens, com login, perfis, cadastro de destinos, avaliações e sistema de gerenciamento, tudo construído com HTML, CSS, JavaScript, PHP e MySQL.**

---

## Sobre o Projeto

**Wonderfly** é uma plataforma web que simula um sistema completo de gerenciamento e exploração de destinos turísticos.  
O foco é entregar uma experiência interativa: o usuário cria sua conta, explora destinos cadastrados, faz avaliações, salva favoritos e interage com páginas dinâmicas geradas pelo servidor.

Assim como no Deep Blue, o projeto utiliza **JSON, manipulação dinâmica de DOM, modularização, efeitos visuais em CSS e lógica distribuída em múltiplos arquivos JS/PHP**.

---

## Funcionalidades Principais

### 1. Sistema de Login & Autenticação

- Fluxo completo de registro e login usando **PHP + MySQL**.
- Armazenamento seguro em banco de dados.
- Sessões persistentes para manter o usuário logado.

### 2. Cadastro e Gerenciamento de Destinos

- Administradores podem cadastrar novos destinos.
- Destinos possuem imagem, descrição, localização e notas.
- Os dados podem ser carregados via **JSON** para exibição dinâmica no front-end.

### 3. Avaliações e Interatividade

- Usuários podem deixar comentários e notas.
- Dados enviados ao PHP, processados e armazenados no banco.
- Front-end consome os dados via JavaScript.

### 4. Manipulação de DOM Avançada

- Destinos listados dinamicamente no catálogo.
- Cartões e modais criados via JS.
- Animações CSS para tornar a interface mais viva.

### 5. Sistema de Favoritos (LocalStorage)

- Usuário pode marcar destinos como favoritos.
- Dados são salvos no navegador.
- Não precisa estar logado para salvar.

### 6. Responsividade & UI

- Layout fluido e adaptado para telas maiores.
- (Versão mobile ainda em desenvolvimento.)

---

## Tecnologias e Conceitos Aplicados

Wonderfly utiliza uma combinação forte de ferramentas modernas:

### **Front-End**

- **HTML5** estrutura das interfaces.
- **CSS3 Avançado**
  - Uso de variáveis, flex/grid, animações e efeitos.
- **JavaScript ES6+**
  - Manipulação de DOM.
  - Consumo de dados em JSON.
  - Módulos e organização da lógica.
  - Criação dinâmica de elementos.

### **Back-End**

- **PHP** para processamento de formulários, login, CRUD de destinos, avaliações.
- **MySQL** para armazenamento dos dados principais.
- **JSON** como mini “banco de dados auxiliar” para carregar destinos no front-end.

### **Outros Conceitos**

- Uso de `fetch()` para leitura de JSON.
- Estrutura modular (arquivos JS separados por função).
- Separação de camadas: front-end, back-end e dados.

---

## 📂 Estrutura do Projeto

```bash
Wonderfly/
│
├── index.php                 # Página inicial (home)
├── login.php                 # Tela de Login
├── register.php              # Cadastro de usuários
├── logout.php                # Finalização de sessão
│
├── destinos/                 # CRUD de destinos
│   ├── cadastrar.php
│   ├── editar.php
│   ├── deletar.php
│   └── listar.php
│
├── avaliacao/                # Sistema de avaliações
│   ├── enviar.php
│   └── listar.php
│
├── data/                     # JSONs usados pelo front-end
│   ├── destinos.json
│   └── categorias.json
│
├── css/                      # Estilos do projeto
│   └── style.css
│
├── js/                       # Scripts do front-end
│   ├── ui.js                 # Funções visuais
│   ├── destinos.js           # Criação dinâmica dos destinos
│   └── favoritos.js          # Sistema baseado em LocalStorage
│
├── uploads/                  # Imagens enviadas pelos usuários/admin
│
├── config.php                # Configuração de conexão com MySQL
└── db_connect.php            # Conexão com o banco de dados

<table align="center"> <tr> <td align="center"> <a href="https://github.com/Vinicius3442"> <img src="https://github.com/Vinicius3442.png" width="100px;" style="border-radius: 50%;" /> </a> <br /> <sub><b>Vinícius Montuani</b></sub> <br /> <small>Desenvolvimento & Estrutura do Sistema</small> <br /> <a href="https://www.linkedin.com/in/vinicius-montuani"> <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=flat-square&logo=linkedin&logoColor=white" /> </a> <a href="https://github.com/Vinicius3442"> <img src="https://img.shields.io/badge/GitHub-181717?style=flat-square&logo=github&logoColor=white" /> </a> </td> </tr> </table>
```
