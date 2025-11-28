# Wonderfly | A Magia de Viajar ao Seu Alcance

![Banner do Projeto](images/banner.png)

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00618A?style=for-the-badge&logo=mysql&logoColor=white)
![JSON](https://img.shields.io/badge/JSON-000000?style=for-the-badge&logo=json&logoColor=white)

<br>

> **Plataforma web dinâmica inspirada no mundo das viagens, integrando sistema de login, gerenciamento de destinos (CRUD), avaliações e experiências visuais imersivas.**

## Sobre o Projeto

**Wonderfly** é uma plataforma full-stack que simula um ecossistema completo de turismo. O objetivo foi criar uma experiência interativa onde o usuário não apenas consome conteúdo, mas participa dele através de avaliações e favoritos.

O projeto combina a robustez do **PHP/MySQL** no back-end com a interatividade do **JavaScript Moderno** no front-end, utilizando JSON para alimentação de dados e manipulação dinâmica do DOM.

![Screenshot Principal](./images/home_print.jpg)
*Interface principal com listagem dinâmica de destinos.*

---

## Funcionalidades Principais

### 1. Sistema de Autenticação (Back-end)
Fluxo completo de segurança e gerenciamento de usuários.

* **Conceitos:** Sessões PHP, Criptografia de senhas, Validação de formulários.
* **Destaques:**
    * Registro e Login persistentes conectados ao MySQL.
    * Restrição de acesso a áreas administrativas.
    * Feedback visual de erros e sucessos.

### 2. Gestão de Destinos (CRUD)
Painel administrativo para controle total do conteúdo da plataforma.

* **Conceitos:** Upload de arquivos, Manipulação de Banco de Dados, Integração JSON.
* **Destaques:**
    * Cadastro completo com imagens, descrições e geolocalização.
    * Atualização em tempo real do catálogo.
    * Consumo híbrido de dados (Banco de Dados + Arquivos JSON).

### 3. Interatividade e Social
Sistema que permite aos usuários compartilharem suas experiências.

* **Conceitos:** Requisições assíncronas, Renderização condicional.
* **Funcionalidades:**
    * Sistema de comentários e notas (estrelas).
    * **Lista de Favoritos:** Uso de `LocalStorage` para salvar destinos preferidos sem necessidade de login imediato.

---

## Tecnologias e Conceitos Aplicados

### Front-end Criativo
* **CSS3 Moderno:** Uso de variáveis, Flexbox/Grid para layouts responsivos e animações de transição para suavizar a navegação.
* **JavaScript ES6+:**
    * `fetch()` API para leitura de dados JSON.
    * Manipulação do DOM para criar modais e cards dinamicamente.
    * Modularização de scripts (UI, Destinos, Favoritos).

### Engenharia de Software
* **Back-end PHP:** Arquitetura estruturada separando a lógica de conexão (`db_connect.php`), as rotas de processamento e a camada de visualização.
* **Banco de Dados:** Modelagem relacional em MySQL para usuários, destinos e avaliações.

---

# Autores

<table align="center">
  <tr>
    <td align="center">
      <a href="https://github.com/Vinicius3442">
        <img src="https://github.com/Vinicius3442.png" width="100px;" alt="Foto de Vinícius Montuani" style="border-radius: 50%;"/>
      </a>
      <br />
      <sub><b>Vinícius Montuani</b></sub>
      <br />
      <a href="https://www.linkedin.com/in/vinicius-montuani" target="_blank">
        <img src="https://img.shields.io/badge/-LinkedIn-0077B5?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn Vinícius">
      </a>
      <a href="https://github.com/Vinicius3442" target="_blank">
        <img src="https://img.shields.io/badge/-GitHub-181717?style=flat-square&logo=github&logoColor=white" alt="GitHub Vinícius">
      </a>
    </td>

  <td align="center">
      <a href="https://github.com/biancapaivaa">
        <img src="https://github.com/biancapaivaa.png" width="100px;" alt="Foto de Bianca Paiva" style="border-radius: 50%;"/>
      </a>
      <br />
      <sub><b>Bianca Paiva</b></sub>
      <br />
      <a href="URL_LINKEDIN_BIANCA" target="_blank">
        <img src="https://img.shields.io/badge/-LinkedIn-0077B5?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn Bianca">
      </a>
      <a href="https://github.com/biancapaivaa" target="_blank">
        <img src="https://img.shields.io/badge/-GitHub-181717?style=flat-square&logo=github&logoColor=white" alt="GitHub Bianca">
      </a>
    </td>

  <td align="center">
      <a href="https://github.com/pietro-renno">
        <img src="https://github.com/pietro-renno.png" width="100px;" alt="Foto de Pietro Rennó" style="border-radius: 50%;"/>
      </a>
      <br />
      <sub><b>Pietro Rennó</b></sub>
      <br />
      <a href="URL_LINKEDIN_PIETRO" target="_blank">
        <img src="https://img.shields.io/badge/-LinkedIn-0077B5?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn Pietro">
      </a>
      <a href="https://github.com/pietro-renno" target="_blank">
        <img src="https://img.shields.io/badge/-GitHub-181717?style=flat-square&logo=github&logoColor=white" alt="GitHub Pietro">
      </a>
    </td>
  </tr>
</table>
