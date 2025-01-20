{{ include ('layouts/header.php', {title:'Tableau des utilisateurs'})}}
<h1>Tableau des utilisateurs</h1>
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
        <td>{{client.privilege_name}}</td>
    </tr>
    {% endfor %}
</table>
<br><br>
<a href="{{base}}/client/create" class="btn">New Client</a>
{{ include ('layouts/footer.php')}}