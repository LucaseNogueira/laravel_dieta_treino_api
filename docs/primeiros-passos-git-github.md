# Introdução

Este documento apresenta o passo a passo do workflow de desenvolvimento no Git e Github.

# Primeiro push remoto

O primeiro passo é criar o repositório no Github. Quando criado o repositório o próprio Github indica alguns comandos básicos para adicionar o repositório remoto no seu projeto local. Algo que eu gosto de manter são os botões de "Gitignore" e "Readme" desmarcados no Github, pois prefiro definir isso no próprio projeto local antes de submetê-lo ao Github.

Próximo passo é certificar:
- Projeto Laravel iniciado;
- Arquivo ``README.md`` foi documentado;
- Grande parte das depêndencias do projeto foram instaladas;
- ``.env`` e arquivos semelhantes possuem as variáveis utilizadas no projeto;
- Todos os arquivos de configurações necessários estão no projeto;

No terminal, no local do projeto, inicie o git, adicione os arquivos do projeto e faça o primeiro commit.

```
git init

git add .

git commit -m "chore: Iniciando o projeto"
```

Certifique-se que a branch atual será a "main" renomeando-a para "main"

```
git branch -M main
```

Adicione o repositório remoto ao seu projeto e realize o push do projeto local para o repositório remoto.

```
git remote add origin [_link_do_repositório_no_github.git]

git push -u origin main
```

# Criando Sprint e Features

Para criar uma branch feature é preciso ter uma branch sprint e caso não exista uma sprint então vamos criar uma nova sprint.

Para criar uma sprint é preciso estar na branch main, criar a sprint e enviar para o repositório remoto. É possível fazer isso no Github, porém vou fazer via comando.

```
# estando na main, atualize o projeto
git checkout main
git pull origin main

# crie a branch de desenvolvimento a partir da main
git checkout -b sprint-v0.1

# envie para o remoto
git push origin sprint-v0.1
```

Note que as instruções anteriores levam em conta que seu projeto local está limpo, sem novas atualizações e pronto para iniciar um novo desenvolvimento.

Para criar uma feature o processo é semelhante, porém você precisa estar na sprint, criar a feature a partir da sprint e enviar a feature para o repositório remoto. 

```
# vai para a branch sprint
git checkout sprint-v0.1

# cria a feature a partir da sprint
git checkout -b feat/cadastro-usuario

# envia para o remoto
git push origin feat/cadastro-usuario
```

Pronto, feature branch criada. Caso você queira permanecer na feature para começar a desenvolver basta:

```
# certificar que esta na feature
git checkout feat/cadastro-usuario

# se achar necessario de um pull da feat remota no projeto local
git pull origin feat/cadastro-usuario
```
