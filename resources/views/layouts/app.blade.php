<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Prestadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #003552;
            --bs-secondary: #F7941E;
        }

        body {
            background: #ffffff;
        }

        .top-bar {
            background-color: var(--bs-primary);
        }

        .btn-secondary {
            background-color: var(--bs-secondary);
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d97f18;
        }

        table thead th {
            background-color: var(--bs-secondary) !important;
            color: #fff !important;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>