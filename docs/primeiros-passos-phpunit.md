# Introdução

Este projeto optou pelo PHPUnit na construção dos seus testes. Para utilizar o PHPUnit em projetos Laravel + Docker é recomendado realizar algumas configurações, que podem mudar de caso a caso. Neste documento irei relatar o passo a passo de como foi configurado o PHPUnit neste projeto.

# Configure o seu ``phpunit.xml``

O arquivo ``phpunit.xml`` define as configurações básicas do PHPUnit na sua aplicação Laravel. Nele vamos apontar o nosso [banco de dados de teste](#banco-de-dados-de-teste-no-docker)

```xml
<php>
...
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="pgsql"/>
    <env name="DB_HOST" value="db"/>
    <env name="DB_PORT" value="5432"/>
    <env name="DB_DATABASE" value="dieta_treino_db_test"/>
    <env name="DB_USERNAME" value="dieta_treino_api"/>
    <env name="DB_PASSWORD" value="dieta_treino_api"/>
...
</php>
```

Alguns atributos são mais intuitivos mas vale dar atenção aos seguintes atributos:

- ``DB_HOST``: Neste caso o nosso host será o serviço no docker, ou seja, o nosso serviço PostgreSQL **db**;
- ``DB_PORT``: Como a nossa aplicação irá rodar no docker, a porta do banco é a **5432**, porta interna no container docker;
- ``DB_DATABASE``: Vamos apontar para um banco de dados próprio para testes, onde vamos chamá-lo de **dieta_treino_db_test**;

# Arquivo ``.env.testing``

Precisamos de um ``.env`` expecífico para testes. Você pode copiar o conteúdo do seu arquivo ``.env``, também pode ser o conteúdo do arquivo ``.env.example``, e altere/adicione as seguintes variáveis:

```
...
APP_ENV=testing
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=dieta_treino_db_test
DB_USERNAME=dieta_treino_api
DB_PASSWORD=dieta_treino_api
...
```

# Banco de dados de teste no Docker

Para criar o banco de dados para os nossos testes de forma automática vamos precisar de um arquivo ``sql`` que execute a criação do nosso banco. Partindo da raiz do projeto, crie ``docker/postgres/init.sql`` e adicione a seguinte instrução no arquivo:

```sql
CREATE DATABASE dieta_treino_db_test;
```

Agora vamos ajustar o nosso ``docker-compose.yml``, adicionando um novo volume, que será criado a partir do nosso arquivo ``init.sql`` criado anteriormente.

```yml
db:
    ...
    volumes:
        ...
        - ./docker/postgres/init.sql:/docker-entrypoint-initdb.d/init.sql
```

# Linhas de comando

Agora vamos atualizar o nosso container. É importante lembrar que o **desenvolvimento a seguir possivelmente irá apagar o conteúdo presente no banco de dados do container. Se achar necessário faça um backup.**

Primeiramente vamos garantir que as configurações e cache do projeto Laravel estão limpos. Recomendo rodar os dois comandos separadamente pois pode ocorrer um erro ao executar o segundo comando, responsável por limpar o cache. Isso pode acontecer por que, no momento, não existe uma tabela de cache no banco de dados, com isso o Laravel tenta encontrar esta tabela, não acha, e gera o erro. Porém esse erro não prejudica o nosso desenvolvimento.

```
php artisan config:clear
php artisan cache:clear
```

Agora iremos subir o nosso container do zero. Aqui será a etapa que irá apagar todo o conteúdo presente na base de dados do container, então, caso necessário, **realize um backup**.

```
docker compose down -v
docker compose up -d
```

Confirme se o banco foi criado com:

```
docker exec -it laravel_dieta_treino_postgres psql -U dieta_treino_api -d postgres -c "\l"
```

A resposta pode ser algo como:

```
dieta_treino_db
dieta_treino_db_test
```

Ou uma tabela contendo alguns dados do(s) serviço(s) de banco de dados. Nesta tabela deve conter pelo menos um **dieta_treino_db** e pelo menos um **dieta_treino_db_test**.

Com um banco de dados apropriado para os nossos testes nós podemos popularizar este banco utilizando as nossas migrations. Em outro prompt de comando, ou terminal, execute ``docker exec -it laravel_dieta_treino_api bash`` para entrar no terminal do projeto no docker/container. Acessando este terminal você pode executar códigos nele, como por exemplo os ``php artisan``.

```
php artisan migrate --env=testing
```

Assim o banco de dados de teste será populado e você poderá executar os seus testes sem preocupações.

```
php artisan test
```

# Observações finais

Com o PHPunit nós podemos criar alguns testes que envolvem integrar com outras camadas do nosso sistema ou até mesmo com outros sistemas. Num teste não necessariamente nós queremos criar um novo registro ou enviar um email, o que nós queremos é testar o comportamento do sistema ao realizar essas ações. Pensando nisso, eu separei esta etapa para apresentar uma breve introdução a alguns recursos do PHPUnit + Laravel que nos permitem testar estes comportamentos sem implicar na criação de novos registros.

O primeiro é o que fizemos anteriormente, **criar um banco de dados apenas para os testes do PHPUnit**. Mesmo em ambiente de desenvolvimento é bom ter um banco de dados para seus testes na aplicação, principalmente os que envolvem o PHPUnit. Outra dica é, sempre que você observar que precisa trabalhar num cenário/ambiente diferente da aplicação, cogite criar um banco de dados para este ambiente específico.

Quando criado uma classe de teste unitário ou de integração é preciso ter atenção com o que você quer com este teste. Você quer criar um novo registro? Você quer **manter este novo registro no banco de dados?** Você quer que o teste dispare o email para o cliente toda vez que ele for executado? Ter esta questão é muito importante, afinal esta classe pode ser executada infinitas vezes ao longo do tempo. Aqui vai algumas dicas para ajudá-lo com essas questões:

- Utilize a trait **RefreshDatabase** ou **DatabaseTransactions** quando não querer afetar o banco de dados;
- Use ``Queue::fake()`` quando trabalhar com testes de filas e, em muitos casos, jobs;
- Use ``Mail::fake()`` quando trabalhar com testes de envio de e-mail;
- Use ``Event::fake()`` quando trabalhar com event-listener;
- Saiba quando trabalhar com as dicas anteriores. Sempre atente-se ao comportamento que você espera do teste.
