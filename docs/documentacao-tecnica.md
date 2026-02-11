# Documentação Técnica – TaskControl

## 1. Banco de Dados

### Estrutura

#### Tabela: usuario
- id (PK)
- nome
- email
- senha (hash)
- admin (0 = usuário comum, 1 = administrador)

#### Tabela: tarefas
- id (PK)
- id_usuario (FK)
- titulo
- descricao
- status
- data_criacao
- data_limite

### Relacionamentos
- tarefas.id_usuario → usuario.id

A chave estrangeira foi criada utilizando o HeidiSQL.

---

## 2. Estrutura do Projeto

/api
- db.php
- login.php
- logout.php
- tarefa.php
- usuario_logado.php
- usuario.php

/docs
- documentacao-tecnica.md
- manual-funcional.md

/telas
- cadastrousuario.html
- dashboardtarefas.html
- dashboardusuario.html
- editartarefas.html
- editarusuarios.html
- login.html
- novatarefa.html

---


---

## 3. Principais Scripts PHP

### db.php
Responsável por criar a conexão com o MySQL utilizando PDO.

### login.php
- Valida usuário e senha.
- Cria a sessão do usuário após autenticação.

### logout.php
- Finaliza a sessão utilizando `session_destroy()`.

### usuario_logado.php
- Retorna os dados do usuário logado em formato JSON.

### usuario.php
Responsável pelas ações relacionadas aos usuários, como cadastro e consulta.

### tarefa.php
Controla todas as ações relacionadas às tarefas:
- listar
- cadastrar
- atualizar
- excluir
- concluir
- reabrir

---

## 4. AJAX

A comunicação entre as telas HTML e os scripts PHP é realizada de forma assíncrona.

### Funcionalidades implementadas
- Listagem de tarefas sem recarregar a página
- Filtros por título e status
- Conclusão e reabertura de tarefas dinamicamente

### Tipos de resposta
- HTML (para listagens)
- JSON (dados do usuário)
- Texto simples (mensagens de sucesso ou erro)

---

## 5. Controle de Sessão e Permissões

- Sessões PHP são utilizadas para autenticação dos usuários.
- Usuários administradores possuem acesso a funcionalidades adicionais.
- O backend valida permissões antes de executar ações sensíveis.

---

## 6. Decisões Técnicas

- Utilização de PHP puro, conforme restrições do desafio.
- Separação entre backend (`api`) e telas (`telas`).
- Uso de AJAX para melhorar a experiência do usuário.
- HeidiSQL utilizado para gerenciamento do banco de dados.

---

## 7. Configuração Local

1. Criar o banco de dados no MySQL.
2. Importar o script SQL.
3. Configurar as credenciais no arquivo `api/db.php`.
4. Executar o projeto em ambiente local utilizando servidor Apache.
5. Acessar o sistema pelo navegador.
