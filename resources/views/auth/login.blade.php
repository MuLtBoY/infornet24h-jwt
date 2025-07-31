@extends('layouts.app')

@section('content')
<div class="top-bar text-white text-center py-2 mb-4">
    <h2 class="m-0">Login do Sistema</h2>
</div>

<div class="container d-flex justify-content-center">
    <div class="card shadow-sm w-50">
        <div class="card-body">
            <h4 class="card-title text-center mb-4">Acesse sua conta</h4>

            {{-- Erros --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulário --}}
            <form id="login-form" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        name="email" 
                        placeholder="Digite seu e-mail" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                    >
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        name="password" 
                        placeholder="Digite sua senha" 
                        required
                    >
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-secondary">Entrar</button>
                </div>
            </form>

            {{-- Mensagens dinâmicas --}}
            <div id="error-messages" class="mt-3"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on("submit", "#login-form", function(e) {
    e.preventDefault();

    $("#error-messages").html("");

    let email = $("#email").val();
    let password = $("#password").val();

    $.ajax({
        url: "http://localhost:8000/api/login",
        method: "POST",
        data: { email, password },
        success: function(data) {

            localStorage.setItem('jwt_token', data.user.token);
            window.location.href = "/prestadores";

        },
        error: function(xhr) {

            if (xhr.status === 422) {

                let errors = xhr.responseJSON.errors;
                let html = `<div class="alert alert-danger"><ul>`;
                $.each(errors, function(key, messages) {
                    $.each(messages, function(i, msg) {
                        html += `<li>${msg}</li>`;
                    });
                });
                html += `</ul></div>`;
                $("#error-messages").html(html);
            } else {
                $("#error-messages").html(`
                    <div class="alert alert-danger">Credenciais inválidas!</div>
                `);
            }
        }
    });
});
</script>
@endpush