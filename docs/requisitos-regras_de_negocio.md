# Introdução

Os requisitos e regras de negócio apresentados contemplam apenas esta API em Laravel. Todos eles terão uma checklist que quando marcado significa que o requisito ou regra de negócio foi desenvolvido.

Eu não me preocupei em ordenar os requisitos e regras de negócio, mas garanto que não está uma bagunça por completo.

# Requisitos Funcionais

- [ ] **RF001 - Manter usuários:** O sistema deve manter usuários.
- [ ] **RF002 - Geração de Token de Autenticação:** O sistema deve gerar um token de autenticação para cada usuário logado.
- [ ] **RF003 - Login do Usuário:** O sistema deve permitir o login do usuário no sistema.
- [ ] **RF004 - Manter Alimentos:** O sistema deve manter alimentos.
- [ ] **RF005 - Manter de Plano Dieta e Treino:** O sistema deve manter o plano de dieta e treino recebido pelo cliente.
- [ ] **RF006 - Cálculo da Composição Nutricional dos Alimentos Não Consumidos:** O sistema deve desenvolver a composição nutricional dos alimentos não consumidos de um plano de dieta e treino.
- [ ] **RF007 - Consulta de Composição Nutricional:** O sistema deve permitir a consulta da composição nutricional dos alimentos não consumidos de um plano de dieta e treino.

# Requisitos Não Funcionais

- [ ] **RNF001 - Framework de Desenvolvimento:** O sistema deve ser desenvolvido utilizando o framework PHP Laravel em sua versão 12.25.0.
- [ ] **RNF002 - Banco de Dados da Aplicação:** Foi definido o PostgreSQL 16 como banco de dados da aplicação.
- [ ] **RNF003 - Criptografia das Senhas:** Todas as senhas devem ser armazenadas utilizando bcrypt ou algoritmo de hashing equivalente, nunca em texto plano.
- [ ] **RNF004 - Persistência da TACO:** Os dados da TACO, fornecidos originalmente em arquivo CSV, devem ser importados e armazenados no banco de dados PostgreSQL da aplicação.
- [ ] **RNF005 - Agendamento de Exclusão de Usuários:** A exclusão dos usuários com status "Exclusão Pendente" deve ser feita a partir de um scheduler executado às 01:00 da manhã.

# Regras de Negócio

- [ ] **RN001 - Dados do Usuário:** Cada usuário deve possuir id único e obrigatório, nome obrigatório, senha obrigatória e protegida, e-mail obrigatório e status obrigatório.
- [ ] **RN002 - Tipo de Token:** O token de autenticação do usuário deve ser do tipo JWT (JSON Web Token).
- [ ] **RN003 - Validade do Token:** O token de autenticação terá validade de 1 dia, 24 horas, a partir da data/hora de emissão.
- [ ] **RN004 - Expiração do token:** Caso o token expire, usuário autenticado por mais de 1 dia, o sistema deve exigir um novo login para gerar um novo token de autenticação.
- [ ] **RN005 - Geração do token:** Um novo token é gerado quando o usuário loga no sistema.
- [ ] **RN006 - Acesso do usuário:** O usuário terá acesso ao sistema caso realizado o login e caso o status de sua conta seja igual a "ativo", assim ele receberá um token de autenticação válido para as ações do usuário no sistema.
- [ ] **RN007 - Cadastro do usuário:** O usuário deve se cadastrar no sistema com seus dados validados.
- [ ] **RN008 - Conta pendente após o cadastro:** Após o cadastro de sua conta, o status da conta do usuário fica pendente até o mesmo confirmar o seu cadastro pelo email de confirmação.
- [ ] **RN009 - Email de confirmação:** Após o cadastro no sistema o usuário irá receber um email de confirmação de acesso ao sistema, para assim ativar a sua conta.
- [ ] **RN010 - Manutenção dos dados do usuário:** Apenas após logado no sistema o usuário pode atualizar o seu nome e senha.
- [ ] **RN011 - Base de Alimentos:** Os alimentos mantidos no sistema têm como origem a tabela TACO de alimentos consumidos pela população brasileira.
- [ ] **RN012 - Dados do Plano de Dieta e Treino:** Os seguintes dados contemplam o plano de dieta e treino do usuário: identificador único do plano; Nome obrigatório do plano de dieta e treino; uma lista obrigatória de alimentos não consumidos; uma lista de treinos diários; peso atual do usuário em quilograma, dado obrigatório; altura atual do usuário em metros, dado obrigatório; período de vigência do plano, dado obrigatório; uma tabela obrigatória de metas do plano; status do plano;
- [ ] **RN013 - Lista de Alimentos não Consumidos no Plano de Dieta e Treino:** O cliente deve informar uma lista de alimentos não consumidos no plano do usuário. Cada alimento será um objeto com o id e nome do alimento presente na tabela TACO.
- [ ] **RN014 - Lista de Treinos no Plano de Dieta e Treino:** Cada treino presente na lista de treinos do plano de dieta e treino possui os seguintes dados: Seu identificador único no plano; Nome do treino; Duração fixa do treino em HR:MIN:SEG; Quantidade de dias por semana do treino.
- [ ] **RN015 - Tabela de metas do plano:** A tabela de metas do plano é composta por: dias do plano, pertencentes ao período de vigência do plano; check de dieta (true ou false); check de cada treino (true ou false); um objeto composto pelo peso do usuário naquele dia e um check para cumprir ou não a meta.
- [ ] **RN016 - Meta não cumprida:** Caso o usuário não cumpra uma meta diária, o check da meta deve retornar false.
- [ ] **RN017 - Cadastro de Plano de Dieta e Treino:** Após o cadastro do plano no sistema, o sistema deve retornar o identificador do plano cadastrado para o cliente.
- [ ] **RN018 - Excluir Conta do Usuário:** Apenas o usuário logado tem permissão de alterar o status da sua conta para "Exclusão Pendente", desta forma a exclusão de sua conta será agendada.
- [ ] **RN019 - Concluir Plano de Dieta e Treino:** O cliente pode concluir o seu plano de dieta e treino, esta ação deixará o plano exclusivo para visualização.
- [ ] **RN020 - Contas com Status "Exclusão Pendente":** Todas as contas com status "Exclusão Pendentes" não têm acesso ao sistema.
- [ ] **RN021 - Dados do Alimento:** Cada alimento contém um id único do sistema, seu id na tabela TACO, descrição, grupo alimentar, energia (kcal), proteína (g), lipídios totais (g), carboidratos (g), fibra alimentar (g), sódio (mg), açúcar total (g).
