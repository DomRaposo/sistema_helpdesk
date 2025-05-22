<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Chamados</title>
    <style>
        h2{
            text-align:center;
        }
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: red; color:white; border: 1px solid white; padding: 6px }
    </style>
</head>
<body>
<h2>Relatório de Chamados</h2>


<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Status</th>
        <th>Assunto</th>
        <th>Data Criação</th>
        <th>Data Encerramento</th>
    </tr>
    </thead>
    <tbody>
    @foreach($chamados as $chamado)
        <tr>
            <td>{{ $chamado['id'] }}</td>
            <td>{{ $chamado['titulo'] }}</td>
            <td>{{ $chamado['descricao'] }}</td>
            <td>{{ $chamado['status'] }}</td>
            <td>{{ strtoupper($chamado['assunto']) }}</td>
            <td>{{ $chamado['data_criacao'] }}</td>
            <td>{{ $chamado['data_encerramento'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

