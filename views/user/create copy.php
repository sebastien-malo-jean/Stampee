{{ include ('layouts/header.php', {title:'Registration'})}}
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
    <form method="post" class="general_container__form">
        <h2 class="general_container__form-header">Registration</h2>
        <label class="general_container__form-header-label">Name
            <input type="text" name="name" value="{{ user.name }}">
        </label>
        <label>Username
            <input type="email" name="username" value="{{ user.username }}">
        </label>
        <label>Password
            <input type="password" name="password">
        </label>
        <label>Email
            <input type="email" name="email" value="{{ user.email }}">
        </label>

        <label>Privilege
            <select name="privilege_id">
                <option value="">Select privilege</option>
                {% for privilege in privileges %}
                <option value="{{ privilege.id }}" {% if privilege.id== user.privilege_id %} selected {% endif %}>
                    {{ privilege.privilege }}</option>
                {% endfor %}
            </select>
        </label>
        <input type="submit" class="btn" value="save">
    </form>
</div>
{{ include ('layouts/footer.php')}}