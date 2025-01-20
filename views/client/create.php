{{ include ('layouts/header.php', {title:'Tableau des utilisateurs'})}}

<div class="container">
    <form method="post">
        <h2>Nouvel Utilisateur</h2>
        <label>Nom
            <input type="text" name="name" value="{{ inputs.name }}">
        </label>
        {% if errors.name is defined %}
        <span class="error">{{ errors.name }}</span>
        {% endif %}
        <label>Pseudo
            <input type="text" name="username" value="{{ inputs.username }}">
        </label>
        {% if errors.username is defined %}
        <span class="error">{{ errors.username }}</span>
        {% endif %}
        <label>Mot de passe
            <input type="text" name="password" value="{{ inputs.password }}">
        </label>
        {% if errors.password is defined %}
        <span class="error">{{ errors.password }}</span>
        {% endif %}
        <label>Email
            <input type="email" name="email" value="{{ inputs.email }}">
        </label>
        {% if errors.email is defined %}
        <span class="error">{{ errors.email }}</span>
        {% endif %}
        <label>Privilege
            <input type="number" name="privilege_id" value="{{ inputs.privilege_id }}">
        </label>
        {% if errors.privilege_id is defined %}
        <span class="error">{{ errors.privilege_id }}</span>
        {% endif %}
        <input type="submit" class="btn" value="save">
    </form>
</div>

{{ include ('layouts/footer.php')}}