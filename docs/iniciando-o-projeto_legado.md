#Introdução

O projeto foi iniciado via composer com o seguinte comando:

```
composer create-project laravel/laravel laravel-dieta-treino-api
```

Em seguida foi excluído vários dos arquivos de demonstração que vem nos projetos Laravel por padrão. Muitos destes arquivos não terão utilidade nesta api, então é seguro excluí-los.

# Excluindo e alterando alguns arquivos

- ``resources/views/welcome.blade.php``: Página inicial do Laravel;
- ``resources/views/errors/``: Template de erros (404, 500 e etc). Como vamos trabalhar com uma API então podemos removê-los;
- ``tests/Feature/ExampleTest.php``: Um exemplo de teste de integração (ou uma tentativa);
- ``tests/Unit/ExampleTest.php``: Um exemplo de teste unitário;
- ``public/favicon.ico``: Pode apagar ou substituir. Eu apaguei;
- ``resources/css/*``: Apenas boilerplate desnecessários neste contexto de API Laravel/PHP;
- ``resource/js/*``: Apenas boilerplate desnecessários neste contexto de API Laravel/PHP;

Em seguida temos que remover o TailwindCSS do projeto.

Remova o Tailwind do projeto com um:
```bash
npm uninstall tailwindcss @tailwindcss/vite
```

Vá em ``vite.config.js`` ou ``vite.config.ts`` e deixe ele da seguinte forma:

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel(),
    ],
});
```

Em ``routes/web.php`` remova todas as rotas feitas pelo laravel, afinal vamos utilizar este arquivo para documentar nossas rotas via Swagger. No momento, deixe este arquivo com apenas uma rota:
```php
Route::get('/', function () {
    return 'Hello World';
});
```
Em ``/routes``, se ainda não existir, crie o arquivo ``api.php``, aqui iremos manter as nossas rotas de api. Em seguida, acesse o arquivo ``/bootstrap/app.php`` e, provavelmente, a rota api não estará definida no ``withRouting(...)``. Adicione a rota de api no arquivo da seguinte forma:
```php
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        ...
        api: __DIR__ . '/../routes/api.php',
        ...
    )
    ...
```

Não estamos utilizando sessões nesta API, o que é natural de uma aplicação **Stateless**. Consulte por ``SESSION_DRIVER`` nos arquivos ``.env`` e ``.env.example`` e defina ``SESSION_DRIVER=array``. Em ``/config/session.php`` pesquise por ``SESSION_DRIVER`` e altere o valor de *driver* por *array* da seguinte forma ``'driver' => env('SESSION_DRIVER', 'array')``. Desta forma o Laravel não irá procurar pelas tabelas de sessões que deixamos de criar em nosso banco de dados, algo que ele realiza por padrão quando o session_driver está como database.

Para testar a aplicação basta executar um ``php artisan serve`` e, em qualquer navegador ou interface de teste, insira o endereço da aplicação, provavelmente será [localhost:8000](http://localhost:8000/). O sistema deve devolver um caloroso "Hello World", definido anteriormente no arquivo ``web.php``.

# Swagger (OpenAPI)

Instale o pacote ``darkaonline/l5-swagger`` via composer.

```
composer require "darkaonline/l5-swagger"
```

Agora publique o l5-swagger no seu projeto.

```
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Acesse o arquivo de configuração do Swagger, o ``config/l5-swagger.php``, e procure, no array ``route``, algo como ``'docs' => 'documentation'`` e ``'api' => 'api/documentation'``, esta instrução indica qual será o path para acessar a documentação no seu projeto, no meu caso eu defini ``'docs' => 'docs'`` e ``'api' => 'api/docs'``, então eu consigo acessar as rotas documentadas em ``http://127.0.0.1:8000/api/docs``.

No controller abstrato padrão do Laravel, ``app/Http/Controllers/Controller.php``, adicione logo a cima da classe a seguinte anotação padrão do Swagger:

```php
namespace App\Http\Controllers;

define('APP_TITLE', env('APP_TITLE', 'Minha APP'));
define('APP_VERSION', env('APP_VERSION', '1.0.0'));
define('APP_URL', env('APP_URL', 'http://localhost/api'));
define('APP_DESCRIPTION', env('APP_DESCRIPTION', 'Doc da APP'));

/**
 * @OA\Info(
 *     version=APP_VERSION,
 *     title=APP_TITLE,
 *     description=APP_DESCRIPTION
 * )
 *
 * @OA\Server(
 *     url=APP_URL,
 *     description="Servidor principal"
 * )
 */
abstract class Controller
{
    ...
}
```

Note que eu utilizei variáveis de ambiente, presentes no arquivo ``.env``. Caso elas não estejam criadas no seu projeto você pode ignorá-las ou criá-las você mesmo.

No momento só temos a rota ``/``, que devolve um Hello World para nós, vamos criar a sua anotação apenas para testar o swagger. Crie um controlador com ``php artisan make:controller HelloWorldController --resource``. Mantenha apenas a função ``index()`` neste controller e passe as instruções + anotações a função:
```php
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Root"},
     *     summary="Endpoint raiz da API",
     *     description="Retorna uma mensagem de teste 'Hello World'. Útil para verificar se a API está no ar.",
     *     @OA\Response(
     *         response=200,
     *         description="Requisição executada com sucesso",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Hello World"
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json('Hello World', 200);
    }
```

Em ``routes/web.php`` adicione o controlador a rota ``GET``.
```php

use App\Http\Controllers\HelloWorldController;
use Illuminate\Support\Facades\Route;
...

Route::get('/', [HelloWorldController::class, 'index']);
...
```

Agora vamos gerar as anotações. No terminal informe:

```
php artisan l5-swagger:generate
```

Para testar basta executar o servidor. 

# JWT

Instale o pacote ``tymon/jwt-auth`` via composer.

```
composer require tymon/jwt-auth
```

Publique as configurações no seu projeto.

```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Gere a chave utilizando o ``php artisan``.

```
php artisan jwt:secret
```

Agora, acesse o arquivo ``config/auth.php`` e altere, ou adicione, o driver padrão da api para ``jwt``.
```php
'guards' => [
    ...
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
]
```

O teste do JWT foi realizado durante a construção das rotas de ``auth`` e ``user``.
