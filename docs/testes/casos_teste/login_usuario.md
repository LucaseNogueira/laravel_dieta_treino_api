# Dados Manipulados

### Auth/Login

- **email** (email | obrigatório);
- **senha** (bcrypt | obrigatório | min:5);

# Casos de teste

**Método**: ``POST``

**Rota**: ``api/auth``

| ID | Caso de Teste | Pré-condição | Passos | Resultado Esperado |
| -- | ------------- | ------------ | ------ | ------------------ |
| **CT-L001** | Login do usuário | Usuário com cadastro ativo | Informar email e senha validos e enviar | Resposta status **200** com token **JWT** |
| **CT-L002** | E-mail inválido | Nenhuma | Cliente não informar ou informar e-mail inválido | Resposta status **422** com mensagem *"O e-mail não foi informado ou esta inválido"* |
| **CT-L003** | Login inválido | Nenhuma | Cliente informar um e-mail não cadastrado ou uma senha incorreta | Resposta status **401** com mensagem *"Credenciais inválidas."* |
| **CT-L004** | Senha não informada | Nenhuma | Cliente não informar ou informar senha incorreta | Resposta status **422** com mensagem *"Senha não foi informada ou incorreta (minimo de 5 caracteres)"* |
