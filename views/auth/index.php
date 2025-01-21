{{ include ('layouts/header.php', {title:'Connection'})}}
<div class="general_container">
    {% if errors is defined %}
    <div class="error">
        <ul>
            {% for error in errors %}
            <li>{{ error }}</li>
            {% endfor %}
        </ul>
    </div>
    {% endif %}
    <form method="post">
        <h2>Login</h2>
        <label>Username
            <input type="email" name="username" value="{{ user.username }}">
        </label>
        <label>Password
            <input type="password" name="password">
        </label>
        <input type="submit" class="btn" value="login">
    </form>
    <a href="{{base}}/user/create" class="btn">new user</a>
</div>
{{ include ('layouts/footer.php')}}