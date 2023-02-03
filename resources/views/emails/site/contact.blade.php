@component('mail::message')
# Novo Contato

Nome: {{ $data['name'] }}

Email: {{ $data['email'] }}

Mensagem: {{ $data['message'] }}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
