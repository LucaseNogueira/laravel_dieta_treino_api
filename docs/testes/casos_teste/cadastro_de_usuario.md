# Dados Manipulados

### Usuário
- **ID** (chave única);
- **Nome** (60 caracteres | obrigatório);
- **E-mail** (único | obrigatório);
- **Senha** (60 caracteres | Bcrypt | obrigatório);
- **Status** (enum | obrigatório);
  - Pendente **(DEFAULT)**;
  - Ativo;
  - Exclusão Pendente**;
- **E-mail Verificado** (datetime);

# Casos de Teste Cadastro de Usuário

**Método**: ``POST``

**Rota**: ``api/user``

| ID | Caso de Teste | Pré-condição | Passos | Resultado Esperado |
| -- | ------------- | ------------ | ------ | ------------------ |
| **CT-U001** | Cadastro do Usuário | Nenhuma | Preencher todos os campos corretamente e enviar | Resposta status **201** com o dados do usuário criado (com excessão da senha), status do usuário igual a **"Pendente"** |
| **CT-U002** | Cadastro com e-mail duplicado | E-mail já cadastrado | Preencher campos com e-mail existente | Resposta **422** com mensagem *"Credenciais invalidas: o e-mail informado já possui cadastro no sistema"* |
| **CT-U003** | Cadastro com nome inválido | Nenhuma | Não informar ou informar nome com mais de 60 caracteres | Resposta **422** com mensagem apropriada para cada situação |
| **CT-U004** | Cadastro com email inválido | Nenhuma | Não informar ou informar email inválido | Resposta **422** com mensagem apropriada para cada situação |
| **CT-U005** | Cadastro sem informar senha | Nenhuma | Enviar o cadastro sem informar a senha | Resposta **422** com a mensagem "Senha não informada" |
| **CT-U006** | Criptografia do campo senha no cadastro do usuário | Nenhuma | Cadastro valido de um usuário | Senha criptografada (bcrypt) |
| **CT-U007** | Envio do e-mail de confirmação | Usuário cadastrado | Nenhum | Realizar a ação de emitir o e-mail de confirmação |

# Casos de teste e-mail de confirmação

**Método:** ``GET``

**Rota:** ``user/confirm/{hash}``

| ID | Casos de Teste | Pré-Condição | Passos | Resultado Esperado |
| -- | -------------- | ------------ | ------ | ------------------ |
| **CT-U008** | Usuário confirmou o cadastro via e-mail | Usuário com cadastro Pendente e e-mail de confirmação enviado | O cliente acessar a mensagem de e-mail enviada e clicar no link de confirmação | Resposta **200**. Uma página HTML informando que foi confirmado o cadastro do usuário e que seu acesso foi liberado |
| **CT-U009** | Hash inválida na rota de confirmação do usuário | Existir um link de confirmação invalido | O cliente mal intencionado cola no link de confirmação uma hash inválida | Resposta **401**. Um HTML informando algo como "credenciais invalidas" |

# Casos de teste atualizar usuário

**Método:** ``PUT``

**Rota:** ``api/user/{?id}``

| ID | Casos de Teste | Pré-Condição | Passos | Resultado Esperado |
| -- | -------------- | ------------ | ------ | ------------------ |
| **CT-U0010** | Usuário atualizado | Usuário logado | Preencher os campos que deseja atualizar | Reposta **200** retornando o usuário atualizado |
| **CT-U0011** | Nome inválido | Usuário logado | Informar um nome com mais de 60 caracteres | Resposta **422** com a mensagem *"Campo 'Nome' possui valor invalido com mais de 60 caracteres"* |
| **CT-U0012** | Request vazia | Usuário logado | Cliente não preencher os campos | Resposta **422** com a mensagem *"Não foi informado dados válidos para a atualização do usuário."* |

# Caso de Teste agendar exclusão do usuário

**Método:** ``DELETE``

**Rota:** ``api/user``

| ID | Casos de Teste | Pré-Condição | Passos | Resultado Esperado |
| -- | -------------- | ------------ | ------ | ------------------ |
| **CT-U013** | Usuário em exclusão pendente | Usuário logado | Informar o id do usuário e enviar | Resposta **202** retornando o **id** do usuário que será excluído |


# Caso de Teste agendamento exclusão do usuário

**Periodo:** Todos os dias

**Horário:** 01:00

| ID | Casos de Teste | Pré-Condição | Passos | Resultado Esperado |
| -- | -------------- | ------------ | ------ | ------------------ |
| **CT-U014** | Executar agendamento de exclusão pendente | Usuário com status Exclusão Pendente | Forçar a execução do agendamento e verificar se o usuário foi excluido | Usuário(s) excluído(s) |
