<x-mail::message>
# Olá {{ $usuario->nome }}

Falta pouco para concretizar o seu cadastro no nosso sistema. Clique no botão abaixo para confirmar o seu cadastro!

<x-mail::button :url={{ $urlConfirmacao }}>
Confirme sua conta
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
