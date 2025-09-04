# Introdução

Este projeto possui os arquivos ``Dockerfile`` e ``docker-compose.yml``, permitindo a criação de um container em seu servidor ou máquina pessoal para rodar toda a infraestrutura deste projeto, como o banco de dados e a aplicação em si. Neste arquivo irei explicar cada arquivo e os comandos necessários para executar o container.

# Dockerfile

É um arquivo que contém instruções para o Docker construir uma imagem da sua aplicação.Essa imagem é como uma “receita” que descreve tudo o que o contêiner precisa para rodar: sistema operacional base, dependências, bibliotecas, variáveis de ambiente e como a aplicação deve ser executada.

Estrutura básica de um Dockerfile consiste em:
- ``FROM`` Define a imagem base (ex.: ``FROM ubuntu:20.04`` ou ``FROM node:18``). É o ponto de partida do contêiner.

- ``WORKDIR`` Define o diretório de trabalho dentro do contêiner. Exemplo: ``WORKDIR /app``

- ``COPY`` Copia arquivos do sistema local para dentro da imagem. Exemplo: ``COPY . /app``

- ``RUN`` Executa comandos durante a criação da imagem. Exemplo: ``RUN apt-get update && apt-get install -y python3``

- ``CMD```Define o comando padrão a ser executado quando o contêiner iniciar. Exemplo: ``CMD ["python3", "app.py"]``

- ``EXPOSE`` Documenta a porta que o contêiner vai usar. Exemplo: ``EXPOSE 8080``

- ``ENV`` Define variáveis de ambiente dentro do contêiner. Exemplo: ``ENV NODE_ENV=production``

# Docker Compose

O docker-compose.yml é um arquivo de configuração que descreve como rodar e orquestrar múltiplos contêineres ao mesmo tempo. Assim podemos, por exemplo, orquestar a execução da aplicação e do banco de dados em um ambiente apropriado.

A estrutura básica de um ``docker-compose.yml`` consiste em:

- ``version`` Define a versão da sintaxe do Compose. Exemplo: ``version: "3.9"``.
  
- ``services`` Onde você define os contêineres que serão criados. Cada serviço é baseado em uma imagem ou em um Dockerfile.

- ``build`` Indica onde está o Dockerfile para construir a imagem.
  
- ``image`` Diz qual imagem usar (pode ser uma oficial do Docker Hub ou uma criada por você).

- ``ports`` Faz o mapeamento de portas host:container.

- ``volumes`` Cria persistência de dados ou compartilha pastas.

- ``environment`` Define variáveis de ambiente para o contêiner.

- ``networks`` Permite conectar serviços em redes personalizadas.

# Executando

Para executar os serviços e criar os containers basta executar:

```
docker-compose up -d
```

Para testar acesse o ``Dockerfile``, localizado na raiz do projeto, e identifique a porta que sua aplicação esta localizada.

```
...
ports:
    - "8001:8000"
...
```

No navegador ou outra aplicação de sua escolha acesse uma das rotas da aplicação, neste caso irei acessa a ``api/docs``.
```
http://localhost:8001/api/docs
```

É possivel adicionar o banco de dados criado numa aplicação de administração de banco de dados (ex: DBeaver ou PGAdmin). Basta verificar o ``environment`` e ``port`` definidos no serviço ``db`` do ``docker-compose.yml``. Adicione os valores presentes nos parametros na ferramenta de sua escolha e lembre-se que o ``host = localhost`` e ``port = 5433``.
