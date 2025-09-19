# Introdução

Desenvolver modelo do usuário e as rotas de cadastro e autenticação do usuário na API. Esta feature deve atender todos os requisitos associados ao usuário, com excessão da exclusão do mesmo em nosso sistema.

# Pré Requisitos

Nenhum pré requisito aparente.

# Objetivos

- [X] Desenvolver modelo de Usuário;
- [X] Atualizar modelagem do banco de dados com as tabelas desenvolvidas nesta feature;
- [X] Desenvolver/atualizar Plano de Teste;
- [X] Desenvolver diagrama de sequência para todas as rotas desenvolvidas;
- [X] Desenvolver método ``POST`` da rota ``api/user``;
- [X] Desenvolver método ``POST`` da rota ``api/auth``;
- [X] Desenvolver método ``GET`` da rota ``user/confirm/{hash}``;
- [X] Desenvolver método ``PUT`` da rota ``api/user``;
- [ ] Marcar requisitos atendidos no documento de requisitos;

# Requisitos e Regras de negócio Atendidas

### Requisitos Funcionais

- [X] **RF001 - Manter usuários:** O sistema deve manter usuários. **[PARCIALMENTE]**
- [X] **RF002 - Geração de Token de Autenticação:** O sistema deve gerar um token de autenticação para cada usuário logado.
- [X] **RF003 - Login do Usuário:** O sistema deve permitir o login do usuário no sistema.
  
### Requisitos Não Funcionais

- [X] **RNF003 - Criptografia das Senhas:** Todas as senhas devem ser armazenadas utilizando bcrypt ou algoritmo de hashing equivalente, nunca em texto plano.

### Regras de Negócio

- [X] **RN001 - Dados do Usuário:** Cada usuário deve possuir id único e obrigatório, nome obrigatório, senha obrigatória e protegida, e-mail obrigatório e status obrigatório.
- [X] **RN002 - Tipo de Token:** O token de autenticação do usuário deve ser do tipo JWT (JSON Web Token).
- [X] **RN003 - Validade do Token:** O token de autenticação terá validade de 1 dia, 24 horas, a partir da data/hora de emissão.**[Parcialmente]**
- [X] **RN004 - Expiração do token:** Caso o token expire, usuário autenticado por mais de 1 dia, o sistema deve exigir um novo login para gerar um novo token de autenticação.**[Parcialmente]**
- [X] **RN005 - Geração do token:** Um novo token é gerado quando o usuário loga no sistema.
- [X] **RN006 - Acesso do usuário:** O usuário terá acesso ao sistema caso realizado o login e caso o status de sua conta seja igual a "ativo", assim ele receberá um token de autenticação válido para as ações do usuário no sistema.
- [X] **RN007 - Cadastro do usuário:** O usuário deve se cadastrar no sistema com seus dados validados.
- [X] **RN008 - Conta pendente após o cadastro:** Após o cadastro de sua conta, o status da conta do usuário fica pendente até o mesmo confirmar o seu cadastro pelo email de confirmação.
- [X] **RN009 - Email de confirmação:** Após o cadastro no sistema o usuário irá receber um email de confirmação de acesso ao sistema, para assim ativar a sua conta.
- [X] **RN010 - Manutenção dos dados do usuário:** Apenas após logado no sistema o usuário pode atualizar o seu nome e senha.**[Parcialmente]**
