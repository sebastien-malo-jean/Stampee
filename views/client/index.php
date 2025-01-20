<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients</title>
    <link rel="stylesheet" href="{{asset}}/css/style.css">
</head>

<body>
    <h1>Utilisateurs</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Privilège</th>
        </tr>
        {% for client in clients %}
        <tr>
            <td><a href="{{base}}/client/show?id={{client.id}}">{{client.name}}</a></td>
            <td>{{client.username}}</td>
            <td>{{client.email}}</td>
            <td>{{client.privilege_id}}</td>
        </tr>
        {% endfor %}
    </table>
    <br><br>
    <a href="{{base}}/client/create" class="btn">New Client</a>
</body>

</html>