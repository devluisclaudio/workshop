<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Relatório Pdf</title>
</head>

<body>



    <h1>LISTA DE INSCRITOS</h1>
    <h3>Tipo de Grupo: {{$lista[0]['grupos']}}</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Nº Ordem</th>
                <th>Nome</th>
                <th>Líder</th>
                <th>Presença</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lista as $key => $user)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ mb_strtoupper($user['nome'], 'UTF-8') }}</td>
                    <td>{{ mb_strtoupper($user['nome_lider_gr'], 'UTF-8') }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
<style>
    table,
    th,
    td {
        border: 1px solid;
        text-align: center;
    }
    th {
        text-align: center;
        padding: 5px;
    }
    table{
        width: 100%;
        margin: 2rem auto;
    }
    h1,h3{
        text-align: center;
    }
</style>
