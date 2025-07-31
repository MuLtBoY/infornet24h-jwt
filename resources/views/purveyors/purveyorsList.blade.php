@extends('layouts.app')

@section('content')
<div class="top-bar text-white py-2 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h2 class="m-0">Busca de Prestadores</h2>
        <button id="logout-btn" class="btn btn-danger btn-sm">Sair</button>
    </div>
</div>

<div class="container">
    {{-- Formulário --}}
    <form id="search-form" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="number" name="assistance_id" class="form-control" placeholder="ID do serviço" min="1" value="{{ request('assistance_id') }}" required>
            </div>
        </div>

        <h5 class="mt-3">Origem</h5>
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="origin_city" class="form-control" placeholder="Cidade de Origem" value="{{ request('origin_city') }}" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="origin_uf" class="form-control" placeholder="UF de Origem" maxlength="2" value="{{ request('origin_uf') }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="origin_latitude" class="form-control" placeholder="Latitude de Origem" value="{{ request('origin_latitude') }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="origin_longitude" class="form-control" placeholder="Longitude de Origem" value="{{ request('origin_longitude') }}" required>
            </div>
        </div>

        <h5 class="mt-3">Destino</h5>
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="destiny_city" class="form-control" placeholder="Cidade de Destino" value="{{ request('destiny_city') }}" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="destiny_uf" class="form-control" placeholder="UF de Destino" maxlength="2" value="{{ request('destiny_uf') }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="destiny_latitude" class="form-control" placeholder="Latitude de Destino" value="{{ request('destiny_latitude') }}" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="destiny_longitude" class="form-control" placeholder="Longitude de Destino" value="{{ request('destiny_longitude') }}" required>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-secondary">Buscar</button>
            </div>
        </div>

        {{-- Filtros --}}
        <div class="row mt-3 g-3">
            <div class="col-md-3" style="display:none">
                <select name="filters[city]" class="form-select">
                    <option value="">Filtrar por Cidade</option>
                </select>
            </div>
            <div class="col-md-2" style="display:none">
                <select name="filters[uf]" class="form-select">
                    <option value="">Filtrar por UF</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="filters[provider_status]" class="form-select">
                    <option value="">Filtrar por Status do Prestador</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="quantity" class="form-control" placeholder="Qtd. máx (1-100)" min="1" max="100" value="{{ request('quantity') }}">
            </div>
            <div class="col-md-2">
                <select name="sort[]" class="form-select">
                    <option value="">Ordenar por</option>
                    <option value="city">Cidade</option>
                    <option value="uf">UF</option>
                    <option value="provider_status">Status</option>
                    <option value="value">Valor</option>
                    <option value="distance">Distância</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Tabela --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Distância (km)</th>
                    <th>Valor (R$)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="prestadores-table-body">
                <tr>
                    <td colspan="5" class="text-center">Realize uma busca para visualizar os prestadores.</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Paginas --}}
    <div class="mt-3">
        {{ $prestadores->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        if (!localStorage.getItem('jwt_token')) {
            window.location.href = "/login";
        }

        $("#logout-btn").on("click", function () {
            let token = localStorage.getItem('jwt_token');
            $.ajax({
                url: "http://localhost/api/logout",
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + token
                },
                success: function () {
                    localStorage.removeItem('jwt_token');
                    window.location.href = "/login";
                },
                error: function () {
                    localStorage.removeItem('jwt_token');
                    window.location.href = "/login";
                }
            });
        });

        $("form#search-form").on("submit", function (e) {
            e.preventDefault();

            let formDataArray = $(this).serializeArray();
            let finalData = {};

            $.each(formDataArray, function (i, field) {
                let name = field.name;
                let value = field.value.trim();

                if (value === "") return;

                if (name === "origin_city") {
                    finalData[name] = value;
                    finalData["filters[city]"] = value;
                } else if (name === "origin_uf") {
                    finalData[name] = value;
                    finalData["filters[uf]"] = value;
                } else {
                    finalData[name] = value;
                }
            });

            let token = localStorage.getItem('jwt_token');

            $.ajax({
                url: "http://localhost/api/prestadores/filtrar",
                method: "GET",
                data: finalData,
                headers: {
                    "Authorization": "Bearer " + token
                },
                success: function (data) {
                    $("#prestadores-table-body").empty();

                    if (data.purveyors.length === 0) {
                        $("#prestadores-table-body").append(`
                            <tr><td colspan="5" class="text-center">Nenhum prestador encontrado.</td></tr>
                        `);
                        return;
                    }

                    $.each(data.purveyors, function (index, prestador) {
                        console.log(JSON.stringify(prestador));
                        $("#prestadores-table-body").append(`
                            <tr>
                                <td style="text-align:center">${prestador.id}</td>
                                <td style="text-align:center">${prestador.name}</td>
                                <td style="text-align:center">${prestador.street} ${prestador.neighborhood}</td>
                                <td style="text-align:center">${prestador.distance}</td>
                                <td style="text-align:center">${parseFloat(prestador.value).toFixed(2)}</td>
                                <td style="text-align:center">${prestador.status}</td>
                            </tr>
                        `);
                    });
                },
                error: function (error) {

                    if(error.status == 401){
                        localStorage.removeItem('jwt_token');
                        window.location.href = "/login";
                    }

                    let mensagem = "Erro ao buscar os prestadores! Verifique se está logado.";

                    if (error.responseJSON && error.responseJSON.success === false) {
                        let errors = error.responseJSON.errors;

                        if (Array.isArray(errors)) {
                            mensagem = errors.join("\n");
                        } else if (typeof errors === "string") {
                            mensagem = errors;
                        }
                    }

                    alert(mensagem);
                }
            });
        });
    });
</script>
@endpush