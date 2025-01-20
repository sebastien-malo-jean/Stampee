{{ include ('layouts/header.php', {title:'Tableau des utilisateurs'})}}

<div class="container">
    <h1>Utilisateur</h1>
    <p><strong>Nom: </strong>{{ client.name }}</p>
    <p><strong>username: </strong>{{ client.username }}</p>
    <p><strong>Email: </strong>{{ client.email }}</p>
    <p><strong>privilege: </strong>{{ client.privilege_id }}</p>
    <a href="{{ base }}/client/edit?id={{client.id}}" class="btn block">Edit</a>
    <form action="{{ base }}/client/delete" method="post">
        <input type="hidden" name="id" value="{{ client.id }}">
        <button type="submit" class="btn block red">Delete</button>
    </form>
</div>

{{ include ('layouts/footer.php')}}