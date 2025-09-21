# Introdução

Desenvolver features capazes de manter usuários e permitir a manutenção dos mesmos.

# Branches

### feat/cadastro-usuario

> Desenvolver features para cadastro de usuário.

### feat/atualizar-senha

> Desenvolver features para atualização de senha do usuário.


### feat/excluir-usuario

> Desenvolver feature de exclusão agendada do usuário.


### feat/visualizar-usuario

> Desenvolver features para visualização do usuário.

### bug/method-atualizar-usuario

> Atualizar método do path **[PUT]** ``api/user`` para **[PATCH]**.

# Objetivos

- [ ] Desenvolver modelo de Usuário;
- [ ] Atualizar modelagem do banco de dados com as tabelas desenvolvidas nesta feature;
- [ ] Desenvolver/atualizar Plano de Teste;
- [ ] Desenvolver diagrama de sequência para todas as rotas desenvolvidas;
- [X] Desenvolver método ``POST`` da rota ``api/user``;
- [X] Desenvolver método ``POST`` da rota ``api/auth``;
- [X] Desenvolver método ``GET`` da rota ``user/confirm/{hash}``;
- [X] Desenvolver método ``PATCH`` da rota ``api/user``;
- [ ] Desenvolver método ``[DELETE]`` da rota ``api/user``;
- [ ] Desenvolver método ``GET`` da rota ``api/user/{id}``;
- [ ] Desenvolver método ``PATCH`` da rota ``api/user/atualizar-senha/{id}``;
- [ ] Desenvolver método ``PATCH`` da rota ``api/user/esqueceu-senha/{hash}``;
- [ ] Desenvolver método ``POST`` da rota ``api/user/esqueceu-senha``;
- [ ] Marcar requisitos atendidos no documento de requisitos;

# Requisitos e Regras de negócio Atendidas

### Requisitos Funcionais

- [ ] **RF001 - Manter usuários:** O sistema deve manter usuários.
- [X] **RF002 - Geração de Token de Autenticação:** O sistema deve gerar um token de autenticação para cada usuário logado.
- [X] **RF003 - Login do Usuário:** O sistema deve permitir o login do usuário no sistema.
- [ ] **RF008 - Alterar a senha do usuário:** O sistema deve permitir a alteração da senha do usuário.
- [ ] **RF009 - Esqueceu sua senha:** O sistema deve permitir que o usuário atualize a sua senha caso o mesmo à esqueça.
  
### Requisitos Não Funcionais

- [X] **RNF003 - Criptografia das Senhas:** Todas as senhas devem ser armazenadas utilizando bcrypt ou algoritmo de hashing equivalente, nunca em texto plano.
- [ ] **RNF005 - Agendamento de Exclusão de Usuários:** A exclusão dos usuários com status "Exclusão Pendente" deve ser feita a partir de um scheduler executado às 01:00 da manhã.

### Regras de Negócio

- [X] **RN001 - Dados do Usuário:** Cada usuário deve possuir id único e obrigatório, nome obrigatório, senha obrigatória e protegida, e-mail obrigatório e status obrigatório.
- [X] **RN002 - Tipo de Token:** O token de autenticação do usuário deve ser do tipo JWT (JSON Web Token).
- [ ] **RN003 - Validade do Token:** O token de autenticação terá validade de 1 dia, 24 horas, a partir da data/hora de emissão.
- [ ] **RN004 - Expiração do token:** Caso o token expire, usuário autenticado por mais de 1 dia, o sistema deve exigir um novo login para gerar um novo token de autenticação.
- [X] **RN005 - Geração do token:** Um novo token é gerado quando o usuário loga no sistema.
- [X] **RN006 - Acesso do usuário:** O usuário terá acesso ao sistema caso realizado o login e caso o status de sua conta seja igual a "ativo", assim ele receberá um token de autenticação válido para as ações do usuário no sistema.
- [X] **RN007 - Cadastro do usuário:** O usuário deve se cadastrar no sistema com seus dados validados.
- [X] **RN008 - Conta pendente após o cadastro:** Após o cadastro de sua conta, o status da conta do usuário fica pendente até o mesmo confirmar o seu cadastro pelo email de confirmação.
- [X] **RN009 - Email de confirmação:** Após o cadastro no sistema o usuário irá receber um email de confirmação de acesso ao sistema, para assim ativar a sua conta.
- [ ] **RN010 - Manutenção dos dados do usuário:** Apenas após logado no sistema o usuário pode atualizar o seu nome e senha.
- [ ] **RN018 - Excluir Conta do Usuário:** Apenas o usuário logado tem permissão de alterar o status da sua conta para "Exclusão Pendente", desta forma a exclusão de sua conta será agendada.
- [ ] **RN022 - Alteração da senha do usuário:** Somente o usuário autenticado e ativo no sistema pode alterar a sua senha.
- [ ] **RN023 - Dados da alteração de senha:** O usuário autenticado e ativo no sistema deve informar a sua senha atual, a sua nova senha e informar novamente a sua nova senha, totalizando três campos obrigatórios.
- [ ] **RN024 - Esqueceu sua senha:** Caso o usuário esqueça a sua senha, o sistema deve receber o e-mail do usuário para enviar uma mensagem de e-mail para o e-mail recebido, contendo um hash que valida o pedido de atualização de senha e as instruções de como atualizar a senha.
- [ ] **RN025 - Expiração do e-mail dê esqueceu sua senha:** O email enviado pelo sistema ao usuário tem expiração de 5 minutos, contabilizados a partir do envio do e-mail para o usuário.
- [ ] **RN026 - Esqueceu sua senha - atualizar a senha:** O sistema deve receber a nova senha, a confirmação da nova senha e o hash enviado para poder atualizar a senha do usuário pelo método de esqueceu sua senha.
