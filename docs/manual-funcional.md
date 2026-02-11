# Manual Funcional – TaskControl

## 1. Visão Geral

O TaskControl é um sistema web de gerenciamento de tarefas desenvolvido em PHP puro, com MySQL como banco de dados e Bootstrap + jQuery no frontend. O sistema permite que usuários criem, editem, filtrem e acompanhem tarefas, com controle de sessão e permissões de administrador.

### Telas do Sistema
- **Login**: acesso ao sistema por e-mail e senha.
- **Cadastro de Usuário**: criação de novos usuários.
- **Dashboard de Tarefas**: listagem das tarefas do usuário, com filtros e paginação.
- **Nova Tarefa**: cadastro de uma nova tarefa.
- **Editar Tarefa**: edição de uma tarefa existente.
- **Dashboard de Usuários (Admin)**: gerenciamento de usuários (apenas administradores).

---

## 2. Como Utilizar o Sistema

### Login
1. Acesse a página de login.
2. Informe o e-mail e a senha cadastrados.
3. Clique em **Entrar**.

### Cadastro de Usuário
1. Na tela de login, clique em **Cadastrar usuário**.
2. Preencha nome, e-mail e senha.
3. Confirme para concluir o cadastro.

### Gerenciamento de Tarefas
- **Criar tarefa**: clique em **Nova Tarefa**, preencha os campos e salve.
- **Editar tarefa**: clique em **Editar** na tarefa desejada.
- **Concluir tarefa**: clique em **Concluir**.
- **Reabrir tarefa**: disponível apenas para administradores.
- **Excluir tarefa**: remove a tarefa permanentemente.

### Filtros
- Buscar tarefas pelo título.
- Filtrar tarefas por status (pendente ou concluída).
- Os filtros funcionam em conjunto com a paginação.

### Logout
- Clique no botão **Logout** para encerrar a sessão com segurança.

---

## 3. Instalação Local

### Requisitos
- XAMPP, WAMP ou similar (Apache, MySQL e PHP)
- Navegador web
- Editor de banco de dados (ex: HeidiSQL)

### Passos
1. Copie a pasta do projeto para o diretório `htdocs`.
2. Inicie o Apache e o MySQL.
3. Importe o arquivo `.sql` do projeto no MySQL.
4. Configure o arquivo `db.php` com as credenciais do banco.
5. Acesse `http://localhost/TaskControl` no navegador.
