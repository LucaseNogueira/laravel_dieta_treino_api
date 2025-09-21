# Introdução

Desenvolver path (rotas) para o cliente/usuario atualizar a sua senha quando autenticado ou quando esquecer sua senha.

# Pré Requisitos

- Feature ``feat/cadastro-usuario``;

# Objetivos

- [ ] Desenvolver/atualizar Plano de Teste;
- [ ] Desenvolver diagrama de sequência para todas as rotas desenvolvidas;
- [ ] Desenvolver método ``PATCH`` da rota ``api/user/atualizar-senha/{id}``;
- [ ] Desenvolver método ``PATCH`` da rota ``api/user/esqueceu-senha/{hash}``;
- [ ] Desenvolver método ``POST`` da rota ``api/user/esqueceu-senha``;

# Requisitos e Regras de Negocio

### Requisito Funcional

- [ ] **RF008 - Alterar a senha do usuário:** O sistema deve permitir a alteração da senha do usuário.
- [ ] **RF009 - Esqueceu sua senha:** O sistema deve permitir que o usuário atualize a sua senha caso o mesmo à esqueça.

### Requisito Não Funcional

- [X] **RNF003 - Criptografia das Senhas:** Todas as senhas devem ser armazenadas utilizando bcrypt ou algoritmo de hashing equivalente, nunca em texto plano.

### Regra de Negócio

- [ ] **RN010 - Manutenção dos dados do usuário:** Apenas após logado no sistema o usuário pode atualizar o seu nome e senha.
- [ ] **RN022 - Alteração da senha do usuário:** Somente o usuário autenticado e ativo no sistema pode alterar a sua senha.
- [ ] **RN023 - Dados da alteração de senha:** O usuário autenticado e ativo no sistema deve informar a sua senha atual, a sua nova senha e informar novamente a sua nova senha, totalizando três campos obrigatórios.
- [ ] **RN024 - Esqueceu sua senha:** Caso o usuário esqueça a sua senha, o sistema deve receber o e-mail do usuário para enviar uma mensagem de e-mail para o e-mail recebido, contendo um hash que valida o pedido de atualização de senha e as instruções de como atualizar a senha.
- [ ] **RN025 - Expiração do e-mail dê esqueceu sua senha:** O email enviado pelo sistema ao usuário tem expiração de 5 minutos, contabilizados a partir do envio do e-mail para o usuário.
- [ ] **RN026 - Esqueceu sua senha - atualizar a senha:** O sistema deve receber a nova senha, a confirmação da nova senha e o hash enviado para poder atualizar a senha do usuário pelo método de esqueceu sua senha.
