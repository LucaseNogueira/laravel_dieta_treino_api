@component('mail::message')
# Olá {{ $usuario->nome }}

Falta pouco para concretizar o seu cadastro no nosso sistema. Clique aqui para confirmar o seu cadastro!

@component('mail::button', ['url' => $urlConfirmacao])
Confirme sua conta
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
