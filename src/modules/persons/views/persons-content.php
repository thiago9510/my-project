<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela com Filtros</title>
    <script src="/assets/js/person.js" defer></script>
    <link rel="stylesheet" href="/styles/base.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Tabela com Filtros</h1>
    <label for="filter">Filtrar:</label>
    <input type="text" id="filter" placeholder="Digite para filtrar...">

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Dados serão carregados aqui via AJAX -->
        </tbody>
    </table>
</body>
</html>
