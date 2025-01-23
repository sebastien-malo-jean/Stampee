{{ include ('layouts/header.php', {title:'Connexion'}) }}
<div class="general-container">
    <!-- Bloc pour les erreurs -->
    {% if errors is defined %}
    <div class="form-container__error">
        <ul class="form-container__error-list">
            {% for error in errors %}
            <li class="form-container__error-item">{{ error }}</li>
            {% endfor %}
        </ul>
    </div>
    {% endif %}
    <div class="form-container">
        <!-- Formulaire de connexion -->
        <form class="form" method="post">
            <h2 class="form__title">Connexion</h2>

            <label class="form__label">
                Email
                <input type="email" class="form__input" name="username" value="{{ user.username }}" required>
            </label>

            <label class="form__label">
                Mot de passe
                <input type="password" class="form__input" name="password" required>
            </label>

            <button type="submit" class="form__button">Connexion</button>
        </form>
        <a href="{{base}}/reset_password" class="form__link">Mot de passe oublié ?</a>
    </div>
</div>
{{ include ('layouts/footer.php') }}