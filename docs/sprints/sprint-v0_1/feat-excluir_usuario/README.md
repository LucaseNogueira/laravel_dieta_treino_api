# Introdução

Desenvolver rota capaz de excluir o usuário autenticado, adicionando a ação numa tarefa agendada.

# Pré-Requisitos

- feat/cadastro-usuario

# Objetivos

- [ ] Desenvolver método ``[DELETE]`` da rota ``api/user``;
- [ ] Desenvolver/atualizar Plano de Teste;
- [ ] Desenvolver diagrama de sequência 

# Requisitos e Regras de Negócio

### Requisitos Funcionais

- [ ] **RF001 - Manter usuários:** O sistema deve manter usuários.

### Requisitos Não Funcionais

- [ ] **RNF005 - Agendamento de Exclusão de Usuários:** A exclusão dos usuários com status "Exclusão Pendente" deve ser feita a partir de um scheduler executado às 01:00 da manhã.

### Regrs de Negocio

- [ ] **RN018 - Excluir Conta do Usuário:** Apenas o usuário logado tem permissão de alterar o status da sua conta para "Exclusão Pendente", desta forma a exclusão de sua conta será agendada.
